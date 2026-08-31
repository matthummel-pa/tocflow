/**
 * Editor UI for the Table of Contents block.
 *
 * Canvas uses useBlockProps + RichText. Settings live in InspectorControls.
 * List type is a BlockControls toolbar control. Visual presets are Gutenberg
 * Block Styles from block.json (Styles panel → is-style-* classes).
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 */
import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
	BlockControls,
	RichText,
	store as blockEditorStore,
} from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import {
	Disabled,
	PanelBody,
	ToggleControl,
	RangeControl,
	ToolbarGroup,
	ToolbarButton,
} from '@wordpress/components';
import { formatListBullets, formatListNumbered } from '@wordpress/icons';
import { collectHeadings, filterAndNormalize } from './headings';

/**
 * Nested outline preview (read-only; front end is server-rendered).
 *
 * @param {Object}  props
 * @param {Array}   props.items
 * @param {boolean} props.ordered
 */
function PreviewList( { items, ordered } ) {
	const Tag = ordered ? 'ol' : 'ul';
	const tree = [];
	const stack = [ tree ];

	items.forEach( ( item ) => {
		while ( stack.length > item.level ) {
			stack.pop();
		}
		while ( stack.length < item.level ) {
			const nested = [];
			const parent = stack[ stack.length - 1 ];
			const last = parent[ parent.length - 1 ];
			if ( last ) {
				last.children = nested;
			} else {
				parent.push( { text: '', slug: '', children: nested } );
			}
			stack.push( nested );
		}
		stack[ stack.length - 1 ].push( { ...item, children: [] } );
	} );

	const renderItems = ( nodes, depth ) => (
		<Tag className={ depth === 0 ? 'tocflow__list' : 'tocflow__sub' }>
			{ nodes.map( ( node, index ) => (
				<li
					key={ `${ node.slug }-${ index }` }
					className="tocflow__item"
				>
					{ node.text ? (
						<a className="tocflow__link" href={ `#${ node.slug }` }>
							{ node.text }
						</a>
					) : null }
					{ node.children?.length
						? renderItems( node.children, depth + 1 )
						: null }
				</li>
			) ) }
		</Tag>
	);

	return renderItems( tree, 0 );
}

export default function Edit( { attributes, setAttributes } ) {
	const {
		title,
		showH2,
		showH3,
		showH4,
		showH5,
		showH6,
		ordered,
		collapsible,
		collapsedDefault,
		sticky,
		highlightActive,
		scrollOffset,
	} = attributes;

	const blocks = useSelect(
		( select ) => select( blockEditorStore ).getBlocks(),
		[]
	);

	const levels = [
		showH2 && 2,
		showH3 && 3,
		showH4 && 4,
		showH5 && 5,
		showH6 && 6,
	].filter( Boolean );

	const items = filterAndNormalize(
		collectHeadings( blocks ),
		levels.length ? levels : [ 2 ]
	);

	const blockProps = useBlockProps( {
		className: [
			'tocflow',
			sticky ? 'is-sticky' : '',
			collapsible ? 'is-collapsible' : '',
		]
			.filter( Boolean )
			.join( ' ' ),
		style:
			scrollOffset >= 0
				? { '--tocflow-offset': `${ scrollOffset }px` }
				: undefined,
		'aria-label': title || __( 'Table of Contents', 'tocflow' ),
	} );

	return (
		<>
			<BlockControls group="block">
				<ToolbarGroup>
					<ToolbarButton
						icon={ formatListBullets }
						label={ __( 'Bulleted list', 'tocflow' ) }
						isPressed={ ! ordered }
						onClick={ () => setAttributes( { ordered: false } ) }
					/>
					<ToolbarButton
						icon={ formatListNumbered }
						label={ __( 'Numbered list', 'tocflow' ) }
						isPressed={ ordered }
						onClick={ () => setAttributes( { ordered: true } ) }
					/>
				</ToolbarGroup>
			</BlockControls>

			<InspectorControls>
				<PanelBody title={ __( 'Heading levels', 'tocflow' ) }>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Include H2 headings', 'tocflow' ) }
						checked={ showH2 }
						onChange={ ( value ) =>
							setAttributes( { showH2: value } )
						}
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Include H3 headings', 'tocflow' ) }
						checked={ showH3 }
						onChange={ ( value ) =>
							setAttributes( { showH3: value } )
						}
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Include H4 headings', 'tocflow' ) }
						checked={ showH4 }
						onChange={ ( value ) =>
							setAttributes( { showH4: value } )
						}
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Include H5 headings', 'tocflow' ) }
						checked={ showH5 }
						onChange={ ( value ) =>
							setAttributes( { showH5: value } )
						}
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Include H6 headings', 'tocflow' ) }
						checked={ showH6 }
						onChange={ ( value ) =>
							setAttributes( { showH6: value } )
						}
					/>
				</PanelBody>
				<PanelBody
					title={ __( 'Display', 'tocflow' ) }
					initialOpen={ false }
				>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Sticky while scrolling', 'tocflow' ) }
						checked={ sticky }
						onChange={ ( value ) =>
							setAttributes( { sticky: value } )
						}
						help={ __(
							'Keeps the outline in view in a sidebar or wide column.',
							'tocflow'
						) }
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Collapsible', 'tocflow' ) }
						checked={ collapsible }
						onChange={ ( value ) =>
							setAttributes( { collapsible: value } )
						}
					/>
					{ collapsible && (
						<ToggleControl
							__nextHasNoMarginBottom
							label={ __( 'Start collapsed', 'tocflow' ) }
							checked={ collapsedDefault }
							onChange={ ( value ) =>
								setAttributes( { collapsedDefault: value } )
							}
						/>
					) }
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Highlight the section in view',
							'tocflow'
						) }
						checked={ highlightActive }
						onChange={ ( value ) =>
							setAttributes( { highlightActive: value } )
						}
					/>
					<RangeControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Scroll offset override (px)', 'tocflow' ) }
						value={ scrollOffset }
						min={ -1 }
						max={ 400 }
						onChange={ ( value ) =>
							setAttributes( { scrollOffset: value } )
						}
						help={ __(
							'Use −1 to inherit the site-wide offset from Settings → TOCflow.',
							'tocflow'
						) }
					/>
				</PanelBody>
			</InspectorControls>

			<nav { ...blockProps }>
				<RichText
					tagName="p"
					className="tocflow__title"
					identifier="title"
					value={ title }
					onChange={ ( value ) => setAttributes( { title: value } ) }
					placeholder={ __( 'Table of Contents', 'tocflow' ) }
					allowedFormats={ [] }
					withoutInteractiveFormatting
				/>
				<Disabled>
					<div className="tocflow__body">
						{ items.length ? (
							<PreviewList items={ items } ordered={ ordered } />
						) : (
							<p className="tocflow__placeholder">
								{ __(
									'Add Heading blocks to this post and they will appear here. Headings with the class no-toc are skipped.',
									'tocflow'
								) }
							</p>
						) }
					</div>
				</Disabled>
			</nav>
		</>
	);
}
