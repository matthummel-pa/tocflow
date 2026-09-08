/**
 * Front-end behavior for the Table of Contents block.
 *
 * Loaded via block.json `viewScript`. wp-scripts extracts `@wordpress/*`
 * imports as script dependencies (no jQuery, no IIFE wrapper).
 *
 * Reading Guide features (progress tracking, reactions, author notes,
 * per-section citations) activate only when the nav carries `has-guide-mode`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */
import domReady from '@wordpress/dom-ready';

const prefersReduced = () =>
	window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

const offsetOf = ( nav ) =>
	parseInt( nav.getAttribute( 'data-tocflow-offset' ) || '0', 10 ) || 0;

const smoothEnabled = ( nav ) =>
	nav.getAttribute( 'data-tocflow-smooth' ) !== '0';

// ── Collapse toggle ───────────────────────────────────────────────────────────

const initToggle = ( nav ) => {
	const button = nav.querySelector( '.tocflow__toggle' );
	if ( ! button ) {
		return;
	}
	button.addEventListener( 'click', () => {
		const expanded = button.getAttribute( 'aria-expanded' ) === 'true';
		button.setAttribute( 'aria-expanded', expanded ? 'false' : 'true' );
		nav.classList.toggle( 'is-collapsed', expanded );
	} );
};

// ── Smooth scroll ─────────────────────────────────────────────────────────────

const initSmoothScroll = ( nav ) => {
	nav.addEventListener( 'click', ( event ) => {
		const link = event.target.closest( 'a[href^="#"]' );
		if ( ! link || ! nav.contains( link ) ) {
			return;
		}
		const id = decodeURIComponent(
			( link.getAttribute( 'href' ) || '' ).slice( 1 )
		);
		if ( ! id ) {
			return;
		}
		const target = document.getElementById( id );
		if ( ! target ) {
			return;
		}
		event.preventDefault();
		const top =
			target.getBoundingClientRect().top +
			window.scrollY -
			offsetOf( nav );
		const behavior =
			smoothEnabled( nav ) && ! prefersReduced() ? 'smooth' : 'auto';
		window.scrollTo( { top: Math.max( 0, top ), behavior } );
		if ( window.history.pushState ) {
			window.history.pushState( null, '', `#${ id }` );
		}
		target.setAttribute( 'tabindex', '-1' );
		target.focus( { preventScroll: true } );
	} );
};

// ── Scroll spy (highlight active section) ────────────────────────────────────

const initScrollSpy = ( nav ) => {
	if ( ! nav.classList.contains( 'has-scroll-spy' ) ) {
		return;
	}
	const links = Array.from(
		nav.querySelectorAll( '.tocflow__link[href^="#"]' )
	);
	if ( ! links.length ) {
		return;
	}

	const map = links
		.map( ( link ) => {
			const id = decodeURIComponent(
				( link.getAttribute( 'href' ) || '' ).slice( 1 )
			);
			const heading = id ? document.getElementById( id ) : null;
			return heading ? { link, heading } : null;
		} )
		.filter( Boolean );

	if ( ! map.length ) {
		return;
	}

	const setCurrent = ( active ) => {
		links.forEach( ( link ) => {
			link.classList.toggle( 'is-active', link === active );
			if ( link === active ) {
				link.setAttribute( 'aria-current', 'location' );
			} else {
				link.removeAttribute( 'aria-current' );
			}
		} );
	};

	const pick = () => {
		const line = offsetOf( nav ) + 8;
		let current = map[ 0 ];
		map.forEach( ( entry ) => {
			if ( entry.heading.getBoundingClientRect().top - line <= 0 ) {
				current = entry;
			}
		} );
		setCurrent( current.link );
	};

	pick();
	window.addEventListener( 'scroll', pick, { passive: true } );
	window.addEventListener( 'resize', pick );
};

// ── Reading progress: mark sections as read when scrolled past ────────────────

const initProgressTracking = ( nav ) => {
	if ( nav.getAttribute( 'data-tocflow-progress' ) !== '1' ) {
		return;
	}
	if ( typeof window.IntersectionObserver === 'undefined' ) {
		return;
	}

	const entries = Array.from(
		nav.querySelectorAll( '.tocflow__link[href^="#"]' )
	)
		.map( ( link ) => {
			const id = decodeURIComponent(
				( link.getAttribute( 'href' ) || '' ).slice( 1 )
			);
			const heading = id ? document.getElementById( id ) : null;
			const item = link.closest( '.tocflow__item' );
			return heading && item ? { heading, item } : null;
		} )
		.filter( Boolean );

	if ( ! entries.length ) {
		return;
	}

	// eslint-disable-next-line no-undef
	const observer = new IntersectionObserver(
		( changes ) => {
			changes.forEach( ( change ) => {
				const entry = entries.find(
					( e ) => e.heading === change.target
				);
				if ( ! entry ) {
					return;
				}
				if (
					! change.isIntersecting &&
					change.boundingClientRect.top < 0
				) {
					entry.item.classList.add( 'is-read' );
				} else if ( change.isIntersecting ) {
					entry.item.classList.remove( 'is-read' );
				}
			} );
		},
		{ threshold: 0 }
	);

	entries.forEach( ( { heading } ) => observer.observe( heading ) );
};

// ── Emoji reactions (localStorage, no server required) ────────────────────────

const reactionKey = ( postId, slug, emoji ) =>
	`tocflow-r-${ postId }-${ slug }-${ emoji }`;

const initReactions = ( nav ) => {
	const postId = nav.getAttribute( 'data-tocflow-post' );
	if ( ! postId ) {
		return;
	}

	nav.querySelectorAll( '.tocflow__reaction' ).forEach( ( btn ) => {
		const item = btn.closest( '.tocflow__item' );
		const slug = item ? item.getAttribute( 'data-tocflow-slug' ) : null;
		const emoji = btn.getAttribute( 'data-reaction' );
		if ( ! slug || ! emoji ) {
			return;
		}

		// Restore persisted state.
		try {
			const saved = localStorage.getItem(
				reactionKey( postId, slug, emoji )
			);
			if ( saved === '1' ) {
				btn.setAttribute( 'aria-pressed', 'true' );
			}
		} catch {
			// localStorage may be blocked (private mode, security policy).
		}

		btn.addEventListener( 'click', () => {
			const pressed = btn.getAttribute( 'aria-pressed' ) === 'true';
			const next = ! pressed;
			btn.setAttribute( 'aria-pressed', next ? 'true' : 'false' );

			try {
				const key = reactionKey( postId, slug, emoji );
				if ( next ) {
					localStorage.setItem( key, '1' );
				} else {
					localStorage.removeItem( key );
				}
			} catch {
				// localStorage may be blocked.
			}

			if ( ! prefersReduced() ) {
				btn.classList.add( 'is-popped' );
				setTimeout( () => btn.classList.remove( 'is-popped' ), 300 );
			}
		} );
	} );
};

// ── Author section notes (toggle reveal) ─────────────────────────────────────

const initNotes = ( nav ) => {
	nav.querySelectorAll( '.tocflow__note-toggle' ).forEach( ( btn ) => {
		btn.addEventListener( 'click', () => {
			const expanded = btn.getAttribute( 'aria-expanded' ) === 'true';
			btn.setAttribute( 'aria-expanded', expanded ? 'false' : 'true' );
			const targetId = btn.getAttribute( 'aria-controls' );
			const note = targetId ? document.getElementById( targetId ) : null;
			if ( note ) {
				if ( expanded ) {
					note.setAttribute( 'hidden', '' );
				} else {
					note.removeAttribute( 'hidden' );
				}
			}
		} );
	} );
};

// ── Per-section academic citations ────────────────────────────────────────────

const MONTHS = [
	'January',
	'February',
	'March',
	'April',
	'May',
	'June',
	'July',
	'August',
	'September',
	'October',
	'November',
	'December',
];

const formatCitation = ( meta, headingText, slug, style ) => {
	const { author, title, site, date, url } = meta;
	const sectionUrl = url + '#' + slug;
	const dateObj = date ? new Date( date ) : new Date();
	const year = dateObj.getUTCFullYear();
	const monthLong = MONTHS[ dateObj.getUTCMonth() ];
	const day = dateObj.getUTCDate();

	switch ( style ) {
		case 'mla':
			return `${ author }. "${ headingText }." ${ title }, ${ site }, ${ day } ${ monthLong } ${ year }, ${ sectionUrl }.`;
		case 'chicago':
			return `${ author }. "${ headingText }." ${ title }. ${ site }. ${ monthLong } ${ day }, ${ year }. ${ sectionUrl }.`;
		case 'harvard':
			return `${ author } (${ year }) '${ headingText }' in ${ title }. ${ site }. Available at: ${ sectionUrl }.`;
		case 'plain':
			return `"${ headingText }" — ${ title } (${ sectionUrl })`;
		case 'apa':
		default:
			return `${ author }. (${ year }, ${ monthLong } ${ day }). ${ headingText }. In ${ title }. ${ site }. ${ sectionUrl }`;
	}
};

const showCopied = ( btn ) => {
	btn.classList.add( 'is-copied' );
	setTimeout( () => btn.classList.remove( 'is-copied' ), 2200 );
};

const copyText = ( text, btn ) => {
	if ( navigator.clipboard && navigator.clipboard.writeText ) {
		navigator.clipboard.writeText( text ).then( () => showCopied( btn ) );
		return;
	}
	// execCommand fallback for older browsers.
	const ta = document.createElement( 'textarea' );
	ta.value = text;
	ta.style.cssText = 'position:fixed;opacity:0;top:0;left:0';
	document.body.appendChild( ta );
	ta.focus();
	ta.select();
	try {
		document.execCommand( 'copy' );
		showCopied( btn );
	} finally {
		document.body.removeChild( ta );
	}
};

const initCitations = ( nav ) => {
	const rawMeta = nav.getAttribute( 'data-tocflow-meta' );
	if ( ! rawMeta ) {
		return;
	}
	let meta;
	try {
		meta = JSON.parse( rawMeta );
	} catch {
		return;
	}
	const style = meta.citationStyle || 'apa';

	nav.querySelectorAll( '.tocflow__cite-btn' ).forEach( ( btn ) => {
		const item = btn.closest( '.tocflow__item' );
		const slug = item ? item.getAttribute( 'data-tocflow-slug' ) : null;
		const headingText = item
			? item.getAttribute( 'data-tocflow-heading' )
			: null;
		if ( ! slug || ! headingText ) {
			return;
		}

		btn.addEventListener( 'click', () => {
			copyText( formatCitation( meta, headingText, slug, style ), btn );
		} );
	} );
};

// ── Section hover-preview tooltip ────────────────────────────────────────────

/**
 * Show a floating tooltip with the section's opening text when the reader
 * hovers over (or focuses) a TOC link. Works independently of guide mode.
 *
 * Uses one shared `position: fixed` bubble per nav so the tooltip escapes
 * any overflow:hidden or max-height constraints on the nav container.
 *
 * @param {HTMLElement} nav The TOC nav element.
 */
const initHoverPreviews = ( nav ) => {
	const items = Array.from(
		nav.querySelectorAll( '.tocflow__item.has-hover-preview' )
	);
	if ( ! items.length ) {
		return;
	}

	const bubble = document.createElement( 'div' );
	bubble.className = 'tocflow__tip-bubble';
	bubble.setAttribute( 'aria-hidden', 'true' );
	document.body.appendChild( bubble );

	let hideTimer = null;

	const positionBubble = ( anchor ) => {
		const rect = anchor.getBoundingClientRect();
		const gap = 12;
		const vw = window.innerWidth;
		const vh = window.innerHeight;
		const bw = Math.min( 280, vw - 24 );

		bubble.style.maxWidth = bw + 'px';
		// Measure height off-screen first.
		bubble.style.visibility = 'hidden';
		bubble.style.top = '-9999px';
		bubble.style.left = '0px';

		const bh = bubble.offsetHeight;

		// Prefer placing to the right; fall back to the left.
		let left = rect.right + gap;
		let side = 'is-right';
		if ( left + bw > vw - 8 ) {
			left = rect.left - gap - bw;
			side = 'is-left';
		}
		left = Math.max( 8, left );

		// Center vertically on the anchor; clamp to viewport.
		let top = rect.top + rect.height / 2 - bh / 2;
		top = Math.max( 8, Math.min( top, vh - bh - 8 ) );

		bubble.classList.remove( 'is-right', 'is-left' );
		bubble.classList.add( side );
		bubble.style.visibility = '';
		bubble.style.top = Math.round( top ) + 'px';
		bubble.style.left = Math.round( left ) + 'px';
	};

	const showBubble = ( item ) => {
		clearTimeout( hideTimer );
		const label = item.querySelector( '.tocflow__tip-label' );
		const text = label ? label.textContent.trim() : '';
		if ( ! text ) {
			return;
		}
		const anchor = item.querySelector( '.tocflow__link' ) || item;
		bubble.textContent = text;
		bubble.classList.add( 'is-visible' );
		positionBubble( anchor );
	};

	const hideBubble = () => {
		clearTimeout( hideTimer );
		// Brief delay so moving between tight items feels smooth.
		hideTimer = setTimeout(
			() => bubble.classList.remove( 'is-visible' ),
			60
		);
	};

	items.forEach( ( item ) => {
		const link = item.querySelector( '.tocflow__link' );
		item.addEventListener( 'mouseenter', () => showBubble( item ) );
		item.addEventListener( 'mouseleave', hideBubble );
		if ( link ) {
			link.addEventListener( 'focus', () => showBubble( item ) );
			link.addEventListener( 'blur', hideBubble );
		}
	} );
};

// ── Bootstrap ─────────────────────────────────────────────────────────────────

const initNav = ( nav ) => {
	if ( nav.dataset.tocflowReady ) {
		return;
	}
	nav.dataset.tocflowReady = '1';
	initToggle( nav );
	initSmoothScroll( nav );
	initScrollSpy( nav );

	if ( nav.classList.contains( 'has-hover-preview' ) ) {
		initHoverPreviews( nav );
	}

	if ( nav.classList.contains( 'has-guide-mode' ) ) {
		initProgressTracking( nav );
		initReactions( nav );
		initNotes( nav );
		initCitations( nav );
	}
};

domReady( () => {
	document
		.querySelectorAll( '.wp-block-tocflow-table-of-contents, .tocflow' )
		.forEach( initNav );
} );
