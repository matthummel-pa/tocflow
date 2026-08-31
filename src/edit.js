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
	SelectControl,
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
		showTitle,
		titleTag,
		showH1,
		showH2,
		showH3,
		showH4,
		showH5,
		showH6,
		ordered,
		numbering,
		hideMarkers,
		collapsible,
		collapsedDefault,
		sticky,
		compact,
		twoColumns,
		underlineLinks,
		highlightActive,
		maxHeight,
		minHeadings,
		smoothScroll,
		scrollOffset,
	} = attributes;

	const blocks = useSelect(
		( select ) => select( blockEditorStore ).getBlocks(),
		[]
	);

	const levels = [
		showH1 && 1,
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

	const style = {};
	if ( scrollOffset >= 0 ) {
		style[ '--tocflow-offset' ] = `${ scrollOffset }px`;
	}
	if ( maxHeight > 0 ) {
		style[ '--tocflow-max-height' ] = `${ maxHeight }px`;
	}

	const blockProps = useBlockProps( {
		className: [
			'tocflow',
			sticky ? 'is-sticky' : '',
			collapsible ? 'is-collapsible' : '',
			compact ? 'is-compact' : '',
			hideMarkers ? 'is-no-markers' : '',
			twoColumns ? 'has-columns-2' : '',
			underlineLinks ? 'has-underlined-links' : '',
			ordered && numbering === 'nested' ? 'is-nested-counters' : '',
			maxHeight > 0 ? 'has-max-height' : '',
		]
			.filter( Boolean )
			.join( ' ' ),
		style: Object.keys( style ).length ? style : undefined,
		'aria-label': title || __( 'Table of Contents', 'tocflow' ),
	} );

	const TitleTag = [ 'h2', 'h3', 'h4' ].includes( titleTag ) ? titleTag : 'p';

	return (
		<>
			<BlockControls group="block">
				<ToolbarGroup>
					<ToolbarButton
						icon={ formatListBullets }
						label={ __( 'Bulleted list', 'tocflow' ) }
						isPressed={ ! ordered }
						onClick={ () =>
							setAttributes( {
								ordered: false,
								numbering: 'default',
							} )
						}
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
						label={ __( 'Include H1 headings', 'tocflow' ) }
						checked={ showH1 }
						onChange={ ( value ) =>
							setAttributes( { showH1: value } )
						}
						help={ __(
							'Most themes already print the post title as H1. Only enable this if headings inside the content use H1.',
							'tocflow'
						) }
					/>
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
					title={ __( 'Title', 'tocflow' ) }
					initialOpen={ false }
				>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Show title', 'tocflow' ) }
						checked={ showTitle }
						onChange={ ( value ) =>
							setAttributes( { showTitle: value } )
						}
						help={ __(
							'The title still appears in the editor so you can edit the accessible name.',
							'tocflow'
						) }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Title element', 'tocflow' ) }
						value={ titleTag }
						options={ [
							{
								label: __( 'Paragraph', 'tocflow' ),
								value: 'p',
							},
							{ label: 'H2', value: 'h2' },
							{ label: 'H3', value: 'h3' },
							{ label: 'H4', value: 'h4' },
						] }
						onChange={ ( value ) =>
							setAttributes( { titleTag: value } )
						}
						help={ __(
							'Use a heading if this outline should appear in the document outline. Prefer a paragraph when the post already has a nearby heading.',
							'tocflow'
						) }
					/>
				</PanelBody>
				<PanelBody
					title={ __( 'List & layout', 'tocflow' ) }
					initialOpen={ false }
				>
					{ ordered && (
						<SelectControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ __( 'Numbering', 'tocflow' ) }
							value={ numbering }
							options={ [
								{
									label: __(
										'Sequential (1, 2, 3)',
										'tocflow'
									),
									value: 'default',
								},
								{
									label: __(
										'Nested (1, 1.1, 1.1.1)',
										'tocflow'
									),
									value: 'nested',
								},
							] }
							onChange={ ( value ) =>
								setAttributes( { numbering: value } )
							}
						/>
					) }
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Hide bullets and numbers', 'tocflow' ) }
						checked={ hideMarkers }
						onChange={ ( value ) =>
							setAttributes( { hideMarkers: value } )
						}
						help={
							ordered && numbering === 'nested'
								? __(
										'Nested numbering still prints 1.1-style counters.',
										'tocflow'
								  )
								: undefined
						}
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Two columns', 'tocflow' ) }
						checked={ twoColumns }
						onChange={ ( value ) =>
							setAttributes( { twoColumns: value } )
						}
						help={ __(
							'Top-level items sit side by side. Stacks on small screens.',
							'tocflow'
						) }
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Compact spacing', 'tocflow' ) }
						checked={ compact }
						onChange={ ( value ) =>
							setAttributes( { compact: value } )
						}
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Always underline links', 'tocflow' ) }
						checked={ underlineLinks }
						onChange={ ( value ) =>
							setAttributes( { underlineLinks: value } )
						}
					/>
					<RangeControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Max height (px)', 'tocflow' ) }
						value={ maxHeight }
						min={ 0 }
						max={ 800 }
						step={ 40 }
						onChange={ ( value ) =>
							setAttributes( { maxHeight: value } )
						}
						help={ __(
							'0 is unlimited. A max height makes long outlines scroll — useful with sticky.',
							'tocflow'
						) }
					/>
				</PanelBody>
				<PanelBody
					title={ __( 'Behavior', 'tocflow' ) }
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
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Smooth scroll', 'tocflow' ) }
						value={ smoothScroll }
						options={ [
							{
								label: __( 'Use site setting', 'tocflow' ),
								value: 'inherit',
							},
							{
								label: __( 'On', 'tocflow' ),
								value: 'on',
							},
							{
								label: __( 'Off', 'tocflow' ),
								value: 'off',
							},
						] }
						onChange={ ( value ) =>
							setAttributes( { smoothScroll: value } )
						}
					/>
					<RangeControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Minimum headings override', 'tocflow' ) }
						value={ minHeadings }
						min={ -1 }
						max={ 10 }
						onChange={ ( value ) =>
							setAttributes( { minHeadings: value } )
						}
						help={ __(
							'Use −1 to inherit Settings → TOCflow. Hide this block when the post has fewer matching headings.',
							'tocflow'
						) }
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
					tagName={ TitleTag }
					className="tocflow__title"
					identifier="title"
					value={ title }
					onChange={ ( value ) => setAttributes( { title: value } ) }
					placeholder={ __( 'Table of Contents', 'tocflow' ) }
					allowedFormats={ [] }
					withoutInteractiveFormatting
					style={ showTitle ? undefined : { opacity: 0.45 } }
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
