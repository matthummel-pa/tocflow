<?php
/**
 * Settings and support page markup.
 *
 * @package TOCflow
 *
 * @var string $tab      Active tab.
 * @var array  $settings Current settings.
 * @var array  $types    Public post type objects.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tocflow_docs_url    = 'https://matthummel-pa.github.io/tocflow/';
$tocflow_github_url  = 'https://github.com/matthummel-pa/tocflow';
$tocflow_support_url = 'https://github.com/matthummel-pa/tocflow/issues';
?>
<div class="wrap tocflow-admin">
	<div class="tocflow-admin__hero">
		<div class="tocflow-admin__brand">
			<img src="<?php echo esc_url( TOCFLOW_URL . 'assets/brand/tocflow-mark.svg' ); ?>" alt="" width="48" height="48">
			<div>
				<h1><?php esc_html_e( 'TOCflow', 'tocflow' ); ?></h1>
				<p><?php esc_html_e( 'Server-rendered table of contents for the WordPress block editor.', 'tocflow' ); ?></p>
			</div>
		</div>
		<p class="tocflow-admin__version"><?php echo esc_html( sprintf( /* translators: %s: plugin version */ __( 'Version %s', 'tocflow' ), TOCFLOW_VERSION ) ); ?></p>
	</div>

	<nav class="nav-tab-wrapper tocflow-admin__tabs" aria-label="<?php esc_attr_e( 'TOCflow sections', 'tocflow' ); ?>">
		<a href="<?php echo esc_url( admin_url( 'options-general.php?page=tocflow' ) ); ?>" class="nav-tab <?php echo 'settings' === $tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Settings', 'tocflow' ); ?></a>
		<a href="<?php echo esc_url( admin_url( 'options-general.php?page=tocflow&tab=support' ) ); ?>" class="nav-tab <?php echo 'support' === $tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Docs &amp; Support', 'tocflow' ); ?></a>
	</nav>

	<?php if ( 'support' === $tab ) : ?>
		<div class="tocflow-admin__grid">
			<section class="tocflow-card">
				<h2><?php esc_html_e( 'Get started', 'tocflow' ); ?></h2>
				<ol>
					<li><?php esc_html_e( 'Edit a post that has Heading blocks (H1-H6; H1 is off by default).', 'tocflow' ); ?></li>
					<li><?php esc_html_e( 'Click + and search for "Table of Contents".', 'tocflow' ); ?></li>
					<li><?php esc_html_e( 'Optional: pick a style, numbered list, collapse, or sticky in the block sidebar.', 'tocflow' ); ?></li>
					<li><?php esc_html_e( 'Preview the post and click a link - it should jump to that heading.', 'tocflow' ); ?></li>
				</ol>
				<p>
					<a class="button button-primary" href="<?php echo esc_url( $tocflow_docs_url . 'documentation.html' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Full documentation', 'tocflow' ); ?></a>
					<a class="button" href="<?php echo esc_url( $tocflow_github_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'GitHub repository', 'tocflow' ); ?></a>
				</p>
			</section>

			<section class="tocflow-card">
				<h2><?php esc_html_e( 'Need help?', 'tocflow' ); ?></h2>
				<p><?php esc_html_e( 'Support is provided through GitHub issues. Include your WordPress version, PHP version, theme, and steps to reproduce.', 'tocflow' ); ?></p>
				<p><a class="button" href="<?php echo esc_url( $tocflow_support_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Report a bug or request a feature', 'tocflow' ); ?></a></p>
				<ul class="tocflow-admin__links">
					<li><a href="<?php echo esc_url( $tocflow_docs_url . 'documentation.html' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Full documentation', 'tocflow' ); ?></a></li>
					<li><a href="<?php echo esc_url( $tocflow_docs_url . 'documentation.html#reading-guide' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Reading Guide docs', 'tocflow' ); ?></a></li>
					<li><a href="<?php echo esc_url( $tocflow_docs_url . 'documentation.html#compatibility' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Compatibility notes', 'tocflow' ); ?></a></li>
					<li><a href="<?php echo esc_url( $tocflow_github_url . '/blob/main/CHANGELOG.md' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Changelog', 'tocflow' ); ?></a></li>
					<li><a href="<?php echo esc_url( $tocflow_github_url . '/blob/main/SECURITY.md' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Security policy', 'tocflow' ); ?></a></li>
				</ul>
			</section>

			<section class="tocflow-card tocflow-card--wide tocflow-compat-card">
				<h2><?php esc_html_e( 'Compatibility', 'tocflow' ); ?></h2>
				<p class="description"><?php esc_html_e( 'TOCflow works with every major theme, SEO plugin, and multilingual plugin. It inherits your theme\'s fonts and colors, makes zero remote calls, and loads no third-party assets.', 'tocflow' ); ?></p>
				<div class="tocflow-compat-grid">
					<div class="tocflow-compat-group">
						<strong><?php esc_html_e( 'WordPress &amp; PHP', 'tocflow' ); ?></strong>
						<ul>
							<li><?php esc_html_e( 'WordPress 6.4 through 7.1', 'tocflow' ); ?></li>
							<li><?php esc_html_e( 'PHP 7.4, 8.0, 8.1, 8.2, 8.3', 'tocflow' ); ?></li>
							<li><?php esc_html_e( 'Block editor + Classic Editor (shortcode)', 'tocflow' ); ?></li>
						</ul>
					</div>
					<div class="tocflow-compat-group">
						<strong><?php esc_html_e( 'SEO plugins', 'tocflow' ); ?></strong>
						<ul>
							<li><?php esc_html_e( 'Yoast SEO - no schema conflicts', 'tocflow' ); ?></li>
							<li><?php esc_html_e( 'Rank Math - schema opt-in only', 'tocflow' ); ?></li>
							<li><?php esc_html_e( 'All in One SEO, SEOPress', 'tocflow' ); ?></li>
						</ul>
					</div>
					<div class="tocflow-compat-group">
						<strong><?php esc_html_e( 'Themes', 'tocflow' ); ?></strong>
						<ul>
							<li><?php esc_html_e( 'Twenty Twenty-Four / Twenty Twenty-Five', 'tocflow' ); ?></li>
							<li><?php esc_html_e( 'Astra, Kadence, GeneratePress, Blocksy', 'tocflow' ); ?></li>
							<li><?php esc_html_e( 'Any theme - inherits your colors &amp; fonts', 'tocflow' ); ?></li>
						</ul>
					</div>
					<div class="tocflow-compat-group">
						<strong><?php esc_html_e( 'Page builders', 'tocflow' ); ?></strong>
						<ul>
							<li><?php esc_html_e( 'Elementor - heading JSON parsed automatically', 'tocflow' ); ?></li>
							<li><?php esc_html_e( 'Bricks, Divi, Beaver, WPBakery, Oxygen', 'tocflow' ); ?></li>
							<li><?php esc_html_e( 'Any builder - HTML scan fallback', 'tocflow' ); ?></li>
						</ul>
					</div>
				</div>
				<p><a href="<?php echo esc_url( $tocflow_docs_url . 'documentation.html#compatibility' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Full compatibility notes', 'tocflow' ); ?> &rarr;</a></p>
			</section>

			<section class="tocflow-card tocflow-card--wide">
				<h2><?php esc_html_e( 'Reading Guide', 'tocflow' ); ?> <span class="tocflow-badge-new">v1.1</span></h2>
				<p class="description"><?php esc_html_e( 'Enable in the block sidebar. Adds hover section previews, read-time estimates, content density bars, reading progress, emoji reactions, author notes, and one-click academic citations. Everything is extracted server-side - zero external APIs.', 'tocflow' ); ?></p>
				<p><a href="<?php echo esc_url( $tocflow_docs_url . 'documentation.html#reading-guide' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Reading Guide documentation', 'tocflow' ); ?> &rarr;</a></p>
			</section>

			<section class="tocflow-card tocflow-card--wide">
				<h2><?php esc_html_e( 'Shortcode', 'tocflow' ); ?></h2>
				<p><?php esc_html_e( 'Use this in classic content, page-builder text widgets, or a theme template (via do_shortcode):', 'tocflow' ); ?></p>
				<p><code>[tocflow]</code></p>
				<p><?php esc_html_e( 'Layout &amp; behavior:', 'tocflow' ); ?> <code>title</code>, <code>showtitle</code>, <code>titletag</code>, <code>h1</code>&ndash;<code>h6</code>, <code>ordered</code>, <code>numbering</code>, <code>markers</code>, <code>collapsible</code>, <code>collapsed</code>, <code>sticky</code>, <code>compact</code>, <code>columns</code>, <code>underline</code>, <code>highlight</code>, <code>maxheight</code>, <code>min</code>, <code>smooth</code>, <code>style</code></p>
			<p><?php esc_html_e( 'Reading Guide:', 'tocflow' ); ?> <code>preview="1"</code> <?php esc_html_e( '(hover tooltip)', 'tocflow' ); ?>, <code>guide="1"</code> <?php esc_html_e( '(full guide mode)', 'tocflow' ); ?>, <code>previews="1"</code>, <code>density="1"</code>, <code>readtime="1"</code>, <code>progress="1"</code>, <code>reactions="1"</code>, <code>citations="1"</code>, <code>citation="apa|mla|chicago|harvard|plain"</code></p>
			<p><?php esc_html_e( 'Study tools:', 'tocflow' ); ?> <code>rprogress="1"</code> <?php esc_html_e( '(reading progress bar)', 'tocflow' ); ?>, <code>bookmark="1"</code> <?php esc_html_e( '(resume reading)', 'tocflow' ); ?>, <code>rnotes="1"</code> <?php esc_html_e( '(reader note pads per section)', 'tocflow' ); ?></p>
			<p><?php esc_html_e( 'Export &amp; print:', 'tocflow' ); ?> <code>export="1"</code> <?php esc_html_e( '(adds Copy / .md / .doc / Print buttons)', 'tocflow' ); ?></p>
			<p><code>[tocflow title="On this page" style="boxed" preview="1" export="1"]</code></p>
			<p><code>[tocflow guide="1" previews="1" readtime="1" reactions="1" citations="1" export="1"]</code></p>
			<p><code>[tocflow rprogress="1" bookmark="1" rnotes="1"]</code></p>
		</section>

			<section class="tocflow-card tocflow-card--wide">
				<h2><?php esc_html_e( 'Skip a heading', 'tocflow' ); ?></h2>
				<p><?php esc_html_e( 'Add the CSS class no-toc or tocflow-skip to a Heading block (Advanced > Additional CSS class(es)) to keep it out of the outline.', 'tocflow' ); ?></p>
			</section>
		</div>
	<?php else : ?>
		<?php
		$tocflow_opt = TOCflow_Settings::OPTION;
		/**
		 * Helper: render a colour-picker field (text + swatch + clear link).
		 *
		 * @param string $name    Form field name (without option prefix).
		 * @param string $value   Current saved value.
		 * @param string $label   Accessible label for the text input.
		 */
		$tocflow_color_field = function ( $name, $value, $label ) use ( $tocflow_opt ) {
			$swatch_val = '' !== $value ? $value : '#ffffff';
			printf(
				'<span class="tocflow-color-field">'
				. '<input type="text" name="%1$s[%2$s]" value="%3$s" placeholder="#rrggbb" maxlength="7" aria-label="%4$s">'
				. '<input type="color" value="%5$s" aria-hidden="true" tabindex="-1">'
				. '<a href="#" class="tocflow-color-clear" aria-label="%6$s">%7$s</a>'
				. '</span>',
				esc_attr( $tocflow_opt ),
				esc_attr( $name ),
				esc_attr( $value ),
				esc_attr( $label ),
				esc_attr( $swatch_val ),
				esc_attr__( 'Clear colour', 'tocflow' ),
				esc_html__( 'Clear', 'tocflow' )
			);
		};
	?>
		<form action="options.php" method="post" class="tocflow-admin__form">
			<?php settings_fields( 'tocflow_settings_group' ); ?>

			<section class="tocflow-card">
				<h2><?php esc_html_e( 'Reading experience', 'tocflow' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Smooth scroll', 'tocflow' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[smooth_scroll]" value="1" <?php checked( $settings['smooth_scroll'], 1 ); ?>>
								<?php esc_html_e( 'Animate jumps to headings (respects reduced-motion preferences).', 'tocflow' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="tocflow-scroll-offset"><?php esc_html_e( 'Scroll offset (px)', 'tocflow' ); ?></label></th>
						<td>
							<input name="<?php echo esc_attr( $tocflow_opt ); ?>[scroll_offset]" id="tocflow-scroll-offset" type="number" min="0" max="400" class="small-text" value="<?php echo esc_attr( (string) $settings['scroll_offset'] ); ?>">
							<p class="description"><?php esc_html_e( 'Space to leave under a sticky admin bar or site header so headings are not covered.', 'tocflow' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Highlight active heading', 'tocflow' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[highlight_active]" value="1" <?php checked( $settings['highlight_active'], 1 ); ?>>
								<?php esc_html_e( 'Mark the section currently in view in the table of contents.', 'tocflow' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="tocflow-min-headings"><?php esc_html_e( 'Minimum headings', 'tocflow' ); ?></label></th>
						<td>
							<input name="<?php echo esc_attr( $tocflow_opt ); ?>[min_headings]" id="tocflow-min-headings" type="number" min="1" max="10" class="small-text" value="<?php echo esc_attr( (string) $settings['min_headings'] ); ?>">
							<p class="description"><?php esc_html_e( 'Hide the TOC when a post has fewer matching headings than this.', 'tocflow' ); ?></p>
						</td>
					</tr>
				</table>
			</section>

			<section class="tocflow-card">
				<h2><?php esc_html_e( 'Auto-generate the block', 'tocflow' ); ?></h2>
				<p class="description"><?php esc_html_e( 'Prints the Table of Contents Gutenberg block on the front end. Posts that already have the block (or the [tocflow] shortcode) are left alone. You can still insert the block by hand in the editor.', 'tocflow' ); ?></p>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Position', 'tocflow' ); ?></th>
						<td>
							<fieldset>
								<label><input type="radio" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_insert]" value="none" <?php checked( $settings['auto_insert'], 'none' ); ?>> <?php esc_html_e( 'Off - only show when the block or shortcode is added', 'tocflow' ); ?></label><br>
								<label><input type="radio" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_insert]" value="before" <?php checked( $settings['auto_insert'], 'before' ); ?>> <?php esc_html_e( 'Top of content', 'tocflow' ); ?></label><br>
								<label><input type="radio" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_insert]" value="after_first_heading" <?php checked( $settings['auto_insert'], 'after_first_heading' ); ?>> <?php esc_html_e( 'After the first heading', 'tocflow' ); ?></label>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Post types', 'tocflow' ); ?></th>
						<td>
							<fieldset class="tocflow-admin__checks">
								<?php foreach ( $types as $tocflow_post_type_obj ) : ?>
									<label>
										<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_insert_types][]" value="<?php echo esc_attr( $tocflow_post_type_obj->name ); ?>" <?php checked( in_array( $tocflow_post_type_obj->name, $settings['auto_insert_types'], true ) ); ?>>
										<?php echo esc_html( $tocflow_post_type_obj->labels->singular_name ); ?>
									</label>
								<?php endforeach; ?>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="tocflow-auto-title"><?php esc_html_e( 'Title', 'tocflow' ); ?></label></th>
						<td>
							<input name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_title]" id="tocflow-auto-title" type="text" class="regular-text" value="<?php echo esc_attr( $settings['auto_title'] ); ?>">
							<p>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_show_title]" value="1" <?php checked( $settings['auto_show_title'], 1 ); ?>>
									<?php esc_html_e( 'Show the title above the list', 'tocflow' ); ?>
								</label>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="tocflow-auto-title-tag"><?php esc_html_e( 'Title element', 'tocflow' ); ?></label></th>
						<td>
							<select name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_title_tag]" id="tocflow-auto-title-tag">
								<option value="p" <?php selected( $settings['auto_title_tag'], 'p' ); ?>><?php esc_html_e( 'Paragraph', 'tocflow' ); ?></option>
								<option value="h2" <?php selected( $settings['auto_title_tag'], 'h2' ); ?>>H2</option>
								<option value="h3" <?php selected( $settings['auto_title_tag'], 'h3' ); ?>>H3</option>
								<option value="h4" <?php selected( $settings['auto_title_tag'], 'h4' ); ?>>H4</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Heading levels', 'tocflow' ); ?></th>
						<td>
							<fieldset class="tocflow-admin__checks">
								<?php
								$tocflow_level_keys = array(
									'auto_show_h1' => 'H1',
									'auto_show_h2' => 'H2',
									'auto_show_h3' => 'H3',
									'auto_show_h4' => 'H4',
									'auto_show_h5' => 'H5',
									'auto_show_h6' => 'H6',
								);
								foreach ( $tocflow_level_keys as $tocflow_key => $tocflow_label ) :
									?>
									<label>
										<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[<?php echo esc_attr( $tocflow_key ); ?>]" value="1" <?php checked( $settings[ $tocflow_key ], 1 ); ?>>
										<?php echo esc_html( $tocflow_label ); ?>
									</label>
								<?php endforeach; ?>
							</fieldset>
							<p class="description"><?php esc_html_e( 'H1 is usually the post title. Leave it off unless headings inside the content use H1.', 'tocflow' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'List', 'tocflow' ); ?></th>
						<td>
							<fieldset>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_ordered]" value="1" <?php checked( $settings['auto_ordered'], 1 ); ?>>
									<?php esc_html_e( 'Numbered list', 'tocflow' ); ?>
								</label><br>
								<label for="tocflow-auto-numbering"><?php esc_html_e( 'Numbering', 'tocflow' ); ?></label>
								<select name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_numbering]" id="tocflow-auto-numbering">
									<option value="default" <?php selected( $settings['auto_numbering'], 'default' ); ?>><?php esc_html_e( 'Sequential (1, 2, 3)', 'tocflow' ); ?></option>
									<option value="nested" <?php selected( $settings['auto_numbering'], 'nested' ); ?>><?php esc_html_e( 'Nested (1, 1.1, 1.1.1)', 'tocflow' ); ?></option>
								</select>
								<p class="description"><?php esc_html_e( 'Nested numbering applies when the list is numbered.', 'tocflow' ); ?></p>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_hide_markers]" value="1" <?php checked( $settings['auto_hide_markers'], 1 ); ?>>
									<?php esc_html_e( 'Hide bullets and browser numbers', 'tocflow' ); ?>
								</label>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="tocflow-auto-style"><?php esc_html_e( 'Style', 'tocflow' ); ?></label></th>
						<td>
							<select name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_style]" id="tocflow-auto-style">
								<?php
								$tocflow_styles = array(
									'default'   => __( 'Default', 'tocflow' ),
									'minimal'   => __( 'Minimal', 'tocflow' ),
									'boxed'     => __( 'Boxed', 'tocflow' ),
									'underline' => __( 'Underline', 'tocflow' ),
									'card'      => __( 'Card', 'tocflow' ),
								);
								foreach ( $tocflow_styles as $tocflow_slug => $tocflow_label ) :
									?>
									<option value="<?php echo esc_attr( $tocflow_slug ); ?>" <?php selected( $settings['auto_style'], $tocflow_slug ); ?>><?php echo esc_html( $tocflow_label ); ?></option>
								<?php endforeach; ?>
							</select>
							<p class="description"><?php esc_html_e( 'Same Block Styles as in the editor Styles panel.', 'tocflow' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Layout', 'tocflow' ); ?></th>
						<td>
							<fieldset>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_compact]" value="1" <?php checked( $settings['auto_compact'], 1 ); ?>>
									<?php esc_html_e( 'Compact spacing', 'tocflow' ); ?>
								</label><br>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_two_columns]" value="1" <?php checked( $settings['auto_two_columns'], 1 ); ?>>
									<?php esc_html_e( 'Two columns (stacks on small screens)', 'tocflow' ); ?>
								</label><br>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_underline]" value="1" <?php checked( $settings['auto_underline'], 1 ); ?>>
									<?php esc_html_e( 'Always underline links', 'tocflow' ); ?>
								</label><br>
								<label for="tocflow-auto-max-height"><?php esc_html_e( 'Max height (px)', 'tocflow' ); ?></label>
								<input name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_max_height]" id="tocflow-auto-max-height" type="number" min="0" max="800" step="40" class="small-text" value="<?php echo esc_attr( (string) $settings['auto_max_height'] ); ?>">
								<p class="description"><?php esc_html_e( '0 is unlimited. A max height makes long outlines scroll.', 'tocflow' ); ?></p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Behavior', 'tocflow' ); ?></th>
						<td>
							<fieldset>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_sticky]" value="1" <?php checked( $settings['auto_sticky'], 1 ); ?>>
									<?php esc_html_e( 'Sticky while scrolling', 'tocflow' ); ?>
								</label><br>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_collapsible]" value="1" <?php checked( $settings['auto_collapsible'], 1 ); ?>>
									<?php esc_html_e( 'Collapsible', 'tocflow' ); ?>
								</label><br>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_collapsed]" value="1" <?php checked( $settings['auto_collapsed'], 1 ); ?>>
									<?php esc_html_e( 'Start collapsed', 'tocflow' ); ?>
								</label>
							</fieldset>
						</td>
					</tr>
				</table>
			</section>

			<section class="tocflow-card">
				<h2><?php esc_html_e( 'SEO &amp; data', 'tocflow' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Schema markup', 'tocflow' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( TOCflow_Settings::OPTION ); ?>[schema_markup]" value="1" <?php checked( $settings['schema_markup'], 1 ); ?>>
								<?php esc_html_e( 'Output ItemList JSON-LD for the outline. Leave off if your SEO plugin already outputs a TOC schema.', 'tocflow' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Uninstall', 'tocflow' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( TOCflow_Settings::OPTION ); ?>[delete_data]" value="1" <?php checked( $settings['delete_data'], 1 ); ?>>
								<?php esc_html_e( 'Delete TOCflow settings when the plugin is deleted. Deactivating never deletes data.', 'tocflow' ); ?>
							</label>
						</td>
					</tr>
				</table>
			</section>

			<!-- ── Design & Appearance ───────────────────────────────────────── -->
			<section class="tocflow-card">
				<h2><?php esc_html_e( 'Design &amp; Appearance', 'tocflow' ); ?></h2>
				<p class="description">
					<?php esc_html_e( 'Global visual defaults. Leave any field empty to use the built-in preset style. Per-block overrides in the editor always win.', 'tocflow' ); ?>
				</p>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Background colour', 'tocflow' ); ?></th>
						<td>
							<?php $tocflow_color_field( 'design_bg_color', $settings['design_bg_color'], __( 'Background colour (hex)', 'tocflow' ) ); ?>
							<p class="description"><?php esc_html_e( 'e.g. #f8fafc — overrides the preset background.', 'tocflow' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Text colour', 'tocflow' ); ?></th>
						<td>
							<?php $tocflow_color_field( 'design_text_color', $settings['design_text_color'], __( 'Text colour (hex)', 'tocflow' ) ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Link colour', 'tocflow' ); ?></th>
						<td>
							<?php $tocflow_color_field( 'design_link_color', $settings['design_link_color'], __( 'Link colour (hex)', 'tocflow' ) ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Font size', 'tocflow' ); ?></th>
						<td>
							<input type="text" name="<?php echo esc_attr( $tocflow_opt ); ?>[design_font_size]" value="<?php echo esc_attr( $settings['design_font_size'] ); ?>" placeholder="<?php esc_attr_e( 'e.g. 15px or 0.9rem', 'tocflow' ); ?>" class="regular-text">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Link font weight', 'tocflow' ); ?></th>
						<td>
							<select name="<?php echo esc_attr( $tocflow_opt ); ?>[design_font_weight]">
								<option value="" <?php selected( $settings['design_font_weight'], '' ); ?>><?php esc_html_e( '— inherit from theme —', 'tocflow' ); ?></option>
								<?php
								foreach ( array( '300', '400', '500', '600', '700', '800' ) as $tocflow_fw ) :
									?>
									<option value="<?php echo esc_attr( $tocflow_fw ); ?>" <?php selected( $settings['design_font_weight'], $tocflow_fw ); ?>><?php echo esc_html( $tocflow_fw ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Line height', 'tocflow' ); ?></th>
						<td>
							<input type="text" name="<?php echo esc_attr( $tocflow_opt ); ?>[design_line_height]" value="<?php echo esc_attr( $settings['design_line_height'] ); ?>" placeholder="<?php esc_attr_e( 'e.g. 1.6', 'tocflow' ); ?>" class="small-text">
							<p class="description"><?php esc_html_e( 'Unitless number, e.g. 1.6.', 'tocflow' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Border', 'tocflow' ); ?></th>
						<td>
							<fieldset>
								<div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:6px;">
									<input type="text" name="<?php echo esc_attr( $tocflow_opt ); ?>[design_border_width]" value="<?php echo esc_attr( $settings['design_border_width'] ); ?>" placeholder="<?php esc_attr_e( 'width e.g. 1px', 'tocflow' ); ?>" class="small-text" style="width:90px;" aria-label="<?php esc_attr_e( 'Border width', 'tocflow' ); ?>">
									<select name="<?php echo esc_attr( $tocflow_opt ); ?>[design_border_style]" aria-label="<?php esc_attr_e( 'Border style', 'tocflow' ); ?>">
										<option value="" <?php selected( $settings['design_border_style'], '' ); ?>><?php esc_html_e( '— style —', 'tocflow' ); ?></option>
										<?php foreach ( array( 'solid', 'dashed', 'dotted', 'double', 'none' ) as $tocflow_bs ) : ?>
											<option value="<?php echo esc_attr( $tocflow_bs ); ?>" <?php selected( $settings['design_border_style'], $tocflow_bs ); ?>><?php echo esc_html( $tocflow_bs ); ?></option>
										<?php endforeach; ?>
									</select>
									<?php $tocflow_color_field( 'design_border_color', $settings['design_border_color'], __( 'Border colour (hex)', 'tocflow' ) ); ?>
								</div>
								<div style="display:flex;gap:8px;align-items:center;">
									<label for="tocflow-design-radius"><?php esc_html_e( 'Border radius:', 'tocflow' ); ?></label>
									<input id="tocflow-design-radius" type="text" name="<?php echo esc_attr( $tocflow_opt ); ?>[design_border_radius]" value="<?php echo esc_attr( $settings['design_border_radius'] ); ?>" placeholder="<?php esc_attr_e( 'e.g. 8px', 'tocflow' ); ?>" class="small-text" style="width:80px;">
								</div>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="tocflow-design-padding"><?php esc_html_e( 'Padding', 'tocflow' ); ?></label></th>
						<td>
							<input id="tocflow-design-padding" type="text" name="<?php echo esc_attr( $tocflow_opt ); ?>[design_padding]" value="<?php echo esc_attr( $settings['design_padding'] ); ?>" placeholder="<?php esc_attr_e( 'e.g. 1.25rem', 'tocflow' ); ?>" class="small-text">
							<p class="description"><?php esc_html_e( 'All sides. Use px or rem. Leave blank for the preset default.', 'tocflow' ); ?></p>
						</td>
					</tr>
				</table>
			</section>

			<!-- ── Reading Guide & Study Tools global defaults ────────────────── -->
			<section class="tocflow-card">
				<h2>
					<?php esc_html_e( 'Reading Guide &amp; Study Tools', 'tocflow' ); ?>
					<span class="tocflow-section-badge tocflow-section-badge--guide">v1.1</span>
				</h2>
				<p class="description">
					<?php esc_html_e( 'Global defaults for auto-inserted blocks and shortcodes. Manual blocks keep their own per-block settings from the editor sidebar.', 'tocflow' ); ?>
				</p>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Hover section preview', 'tocflow' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_preview_hover]" value="1" <?php checked( $settings['auto_preview_hover'], 1 ); ?>>
								<?php esc_html_e( 'Show the opening sentence of each section in a tooltip when hovering a TOC link.', 'tocflow' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Reading Guide mode', 'tocflow' ); ?></th>
						<td>
							<label>
								<input id="tocflow-auto-guide-mode" type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_guide_mode]" value="1" <?php checked( $settings['auto_guide_mode'], 1 ); ?>>
								<?php esc_html_e( 'Enable the full Reading Guide (inline previews, density bars, read time, progress fade).', 'tocflow' ); ?>
							</label>
							<div id="tocflow-guide-subopts">
								<table class="form-table" role="presentation">
									<tr>
										<th scope="row"><?php esc_html_e( 'Section content previews', 'tocflow' ); ?></th>
										<td>
											<label>
												<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_show_previews]" value="1" <?php checked( $settings['auto_show_previews'], 1 ); ?>>
												<?php esc_html_e( 'Show the first ~20 words of each section under its TOC link.', 'tocflow' ); ?>
											</label>
										</td>
									</tr>
									<tr>
										<th scope="row"><?php esc_html_e( 'Content density bars', 'tocflow' ); ?></th>
										<td>
											<label>
												<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_show_density]" value="1" <?php checked( $settings['auto_show_density'], 1 ); ?>>
												<?php esc_html_e( 'Show a proportional bar indicating each section\'s word count.', 'tocflow' ); ?>
											</label>
										</td>
									</tr>
									<tr>
										<th scope="row"><?php esc_html_e( 'Per-section read time', 'tocflow' ); ?></th>
										<td>
											<label>
												<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_show_read_time]" value="1" <?php checked( $settings['auto_show_read_time'], 1 ); ?>>
												<?php esc_html_e( 'Show an estimated read time next to each TOC link.', 'tocflow' ); ?>
											</label>
										</td>
									</tr>
									<tr>
										<th scope="row"><?php esc_html_e( 'Reading progress fade', 'tocflow' ); ?></th>
										<td>
											<label>
												<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_track_progress]" value="1" <?php checked( $settings['auto_track_progress'], 1 ); ?>>
												<?php esc_html_e( 'Fade out TOC items as the reader scrolls past each section.', 'tocflow' ); ?>
											</label>
										</td>
									</tr>
									<tr>
										<th scope="row"><?php esc_html_e( 'Emoji reactions', 'tocflow' ); ?></th>
										<td>
											<label>
												<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_show_reactions]" value="1" <?php checked( $settings['auto_show_reactions'], 1 ); ?>>
												<?php esc_html_e( 'Let readers react per section (💡 ⭐ 🤔 ✅) — stored in browser localStorage, never on your server.', 'tocflow' ); ?>
											</label>
										</td>
									</tr>
									<tr>
										<th scope="row"><?php esc_html_e( 'Academic citations', 'tocflow' ); ?></th>
										<td>
											<label>
												<input id="tocflow-auto-show-citations" type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_show_citations]" value="1" <?php checked( $settings['auto_show_citations'], 1 ); ?>>
												<?php esc_html_e( 'Show a § button that copies a formatted citation for each section — built from post meta, no external API.', 'tocflow' ); ?>
											</label>
											<div id="tocflow-citation-style-row" style="margin-top:6px;">
												<label for="tocflow-auto-citation-style"><?php esc_html_e( 'Citation format:', 'tocflow' ); ?></label>
												<select id="tocflow-auto-citation-style" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_citation_style]">
													<?php
													$tocflow_cite_formats = array(
														'apa'     => 'APA',
														'mla'     => 'MLA',
														'chicago' => 'Chicago',
														'harvard' => 'Harvard',
														'plain'   => __( 'Plain link', 'tocflow' ),
													);
													foreach ( $tocflow_cite_formats as $tocflow_cf_key => $tocflow_cf_label ) :
														?>
														<option value="<?php echo esc_attr( $tocflow_cf_key ); ?>" <?php selected( $settings['auto_citation_style'], $tocflow_cf_key ); ?>><?php echo esc_html( $tocflow_cf_label ); ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</section>

			<!-- ── Study Tools & Export global defaults ───────────────────────── -->
			<section class="tocflow-card">
				<h2>
					<?php esc_html_e( 'Study Tools &amp; Export', 'tocflow' ); ?>
					<span class="tocflow-section-badge tocflow-section-badge--study">v1.2</span>
				</h2>
				<p class="description">
					<?php esc_html_e( 'All features are off by default and store data only in the reader\'s browser — nothing is sent to your server.', 'tocflow' ); ?>
				</p>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Reading progress bar', 'tocflow' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_reading_progress]" value="1" <?php checked( $settings['auto_reading_progress'], 1 ); ?>>
								<?php esc_html_e( 'Show a thin progress bar (0–100 % of headings read) above the TOC list.', 'tocflow' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Resume reading bookmark', 'tocflow' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_bookmark]" value="1" <?php checked( $settings['auto_bookmark'], 1 ); ?>>
								<?php esc_html_e( 'Bookmark the reader\'s last-read heading in localStorage and show a ↩ Resume button on return visits.', 'tocflow' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Reader note pads', 'tocflow' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_reader_notes]" value="1" <?php checked( $settings['auto_reader_notes'], 1 ); ?>>
								<?php esc_html_e( 'Add a 📝 button per section so readers can jot private notes (localStorage only — no account needed).', 'tocflow' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Export &amp; print toolbar', 'tocflow' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_export]" value="1" <?php checked( $settings['auto_export'], 1 ); ?>>
								<?php esc_html_e( 'Add Copy / Download .md / Download .doc / Print buttons under the TOC.', 'tocflow' ); ?>
							</label>
						</td>
					</tr>
				</table>
			</section>

			<!-- ── Accessibility ─────────────────────────────────────────────── -->
			<section class="tocflow-card">
				<h2><?php esc_html_e( 'Accessibility', 'tocflow' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="tocflow-focus-style"><?php esc_html_e( 'Focus ring style', 'tocflow' ); ?></label></th>
						<td>
							<select id="tocflow-focus-style" name="<?php echo esc_attr( $tocflow_opt ); ?>[focus_style]">
								<option value="default" <?php selected( $settings['focus_style'], 'default' ); ?>><?php esc_html_e( 'Default — underline only (follows theme)', 'tocflow' ); ?></option>
								<option value="bold" <?php selected( $settings['focus_style'], 'bold' ); ?>><?php esc_html_e( 'Bold — 3 px outline, offset 2 px (WCAG 2.1 AA)', 'tocflow' ); ?></option>
								<option value="high-contrast" <?php selected( $settings['focus_style'], 'high-contrast' ); ?>><?php esc_html_e( 'High contrast — black outline on yellow background (WCAG 2.1 AAA)', 'tocflow' ); ?></option>
							</select>
							<p class="description"><?php esc_html_e( 'Applies to keyboard focus on TOC links. Does not affect the block editor.', 'tocflow' ); ?></p>
						</td>
					</tr>
				</table>
			</section>

			<?php submit_button( __( 'Save settings', 'tocflow' ) ); ?>
		</form>
	<?php endif; ?>
</div>
