/**
 * Collect core/heading blocks in document order for the editor preview.
 *
 * @param {Array}  blocks Parsed editor blocks.
 * @param {Object} used   Slug collision map (mutated).
 * @return {Array} Heading objects in document order.
 */
export function collectHeadings( blocks, used = {} ) {
	const headings = [];

	const slugify = ( text ) => {
		let slug = String( text )
			.toLowerCase()
			.normalize( 'NFKD' )
			.replace( /[\u0300-\u036f]/g, '' )
			.replace( /[^a-z0-9\s-]/g, '' )
			.trim()
			.replace( /\s+/g, '-' )
			.replace( /-+/g, '-' );
		if ( ! slug ) {
			slug = 'section';
		}
		const base = slug;
		let i = 2;
		while ( used[ slug ] ) {
			slug = `${ base }-${ i }`;
			i += 1;
		}
		used[ slug ] = true;
		return slug;
	};

	const skip = ( block ) => {
		const extra = ( block?.attributes?.className || '' ).toLowerCase();
		return extra.includes( 'no-toc' ) || extra.includes( 'tocguide-skip' );
	};

	const walk = ( inner ) => {
		( inner || [] ).forEach( ( block ) => {
			if ( block.name === 'core/heading' && ! skip( block ) ) {
				const raw = block.attributes?.content || '';
				const text = String( raw )
					.replace( /<[^>]+>/g, '' )
					.replace( /&nbsp;/g, ' ' )
					.trim();
				if ( text ) {
					const level = block.attributes?.level || 2;
					const slug = block.attributes?.anchor
						? String( block.attributes.anchor )
						: slugify( text );
					headings.push( { level, text, slug } );
				}
			}
			if ( block.innerBlocks?.length ) {
				walk( block.innerBlocks );
			}
		} );
	};

	walk( blocks );
	return headings;
}

/**
 * Keep selected levels and collapse them to sequential depths.
 *
 * @param {Array} headings Collected heading objects.
 * @param {Array} levels   Heading levels to keep (e.g. [ 2, 3 ]).
 * @return {Array} Filtered headings with normalized sequential depths.
 */
export function filterAndNormalize( headings, levels ) {
	const filtered = headings.filter( ( heading ) =>
		levels.includes( heading.level )
	);
	const present = [
		...new Set( filtered.map( ( heading ) => heading.level ) ),
	].sort( ( a, b ) => a - b );
	const map = {};
	present.forEach( ( level, index ) => {
		map[ level ] = index + 1;
	} );
	return filtered.map( ( heading ) => ( {
		...heading,
		level: map[ heading.level ],
	} ) );
}

/**
 * Marker label for one row in a nested preview list.
 *
 * @param {number}  index               Zero-based index among siblings.
 * @param {string}  parentMarker        Parent nested label, or ''.
 * @param {Object}  options
 * @param {boolean} options.ordered
 * @param {string}  options.numbering
 * @param {boolean} options.hideMarkers
 * @return {string} Empty, "bullet", or a number such as "1.2".
 */
export function itemMarker( index, parentMarker, options ) {
	const ordered = !! options.ordered;
	const numbering = options.numbering || 'default';
	const hideMarkers = !! options.hideMarkers;
	const nested = ordered && numbering === 'nested';
	if ( hideMarkers && ! nested ) {
		return '';
	}
	if ( ! ordered ) {
		return 'bullet';
	}
	const n = String( index + 1 );
	if ( nested && parentMarker ) {
		return `${ parentMarker }.${ n }`;
	}
	return n;
}
