/**
 * Front-end behavior for the Table of Contents block.
 *
 * Loaded via block.json `viewScript`. wp-scripts extracts `@wordpress/*`
 * imports as script dependencies (no jQuery, no IIFE wrapper).
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

const initNav = ( nav ) => {
	if ( nav.dataset.tocflowReady ) {
		return;
	}
	nav.dataset.tocflowReady = '1';
	initToggle( nav );
	initSmoothScroll( nav );
	initScrollSpy( nav );
};

domReady( () => {
	document
		.querySelectorAll( '.wp-block-tocflow-table-of-contents, .tocflow' )
		.forEach( initNav );
} );
