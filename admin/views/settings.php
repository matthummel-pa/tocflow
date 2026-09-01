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
		<a href="<?php echo esc_url( admin_url( 'options-general.php?page=tocflow&tab=support' ) ); ?>" class="nav-tab <?php echo 'support' === $tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Docs & Support', 'tocflow' ); ?></a>
	</nav>

	<?php if ( 'support' === $tab ) : ?>
		<div class="tocflow-admin__grid">
			<section class="tocflow-card">
				<h2><?php esc_html_e( 'Get started', 'tocflow' ); ?></h2>
				<ol>
					<li><?php esc_html_e( 'Edit a post that has Heading blocks (H1–H6; H1 is off by default).', 'tocflow' ); ?></li>
					<li><?php esc_html_e( 'Click + and search for “Table of Contents”.', 'tocflow' ); ?></li>
					<li><?php esc_html_e( 'Optional: pick a style, numbered list, collapse, or sticky in the block sidebar.', 'tocflow' ); ?></li>
					<li><?php esc_html_e( 'Preview the post and click a link — it should jump to that heading.', 'tocflow' ); ?></li>
				</ol>
				<p>
					<a class="button button-primary" href="<?php echo esc_url( $tocflow_docs_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Open full documentation', 'tocflow' ); ?></a>
					<a class="button" href="<?php echo esc_url( $tocflow_github_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'GitHub repository', 'tocflow' ); ?></a>
				</p>
			</section>

			<section class="tocflow-card">
				<h2><?php esc_html_e( 'Need help?', 'tocflow' ); ?></h2>
				<p><?php esc_html_e( 'Support is provided through GitHub issues. Include your WordPress version, PHP version, theme, and steps to reproduce.', 'tocflow' ); ?></p>
				<p><a class="button" href="<?php echo esc_url( $tocflow_support_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Report a bug or request a feature', 'tocflow' ); ?></a></p>
				<ul class="tocflow-admin__links">
					<li><a href="<?php echo esc_url( $tocflow_docs_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'User guide & FAQ', 'tocflow' ); ?></a></li>
					<li><a href="<?php echo esc_url( $tocflow_github_url . '/blob/main/CHANGELOG.md' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Changelog', 'tocflow' ); ?></a></li>
					<li><a href="<?php echo esc_url( $tocflow_github_url . '/blob/main/SECURITY.md' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Security policy', 'tocflow' ); ?></a></li>
				</ul>
			</section>

			<section class="tocflow-card tocflow-card--wide">
				<h2><?php esc_html_e( 'Shortcode', 'tocflow' ); ?></h2>
				<p><?php esc_html_e( 'Use this in classic content, widgets, or a theme template (via do_shortcode):', 'tocflow' ); ?></p>
				<p><code>[tocflow]</code></p>
				<p><?php esc_html_e( 'Optional attributes:', 'tocflow' ); ?> <code>title</code>, <code>showtitle</code>, <code>titletag</code>, <code>h1</code>–<code>h6</code>, <code>ordered</code>, <code>numbering</code>, <code>markers</code>, <code>collapsible</code>, <code>collapsed</code>, <code>sticky</code>, <code>compact</code>, <code>columns</code>, <code>underline</code>, <code>highlight</code>, <code>maxheight</code>, <code>min</code>, <code>smooth</code>, <code>style</code></p>
				<p><code>[tocflow title="On this page" ordered="1" numbering="nested" style="boxed"]</code></p>
			</section>

			<section class="tocflow-card tocflow-card--wide">
				<h2><?php esc_html_e( 'Skip a heading', 'tocflow' ); ?></h2>
				<p><?php esc_html_e( 'Add the CSS class no-toc or tocflow-skip to a Heading block (Advanced → Additional CSS class(es)) to keep it out of the outline.', 'tocflow' ); ?></p>
			</section>
		</div>
	<?php else : ?>
		<?php $tocflow_opt = TOCflow_Settings::OPTION; ?>
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
								<label><input type="radio" name="<?php echo esc_attr( $tocflow_opt ); ?>[auto_insert]" value="none" <?php checked( $settings['auto_insert'], 'none' ); ?>> <?php esc_html_e( 'Off — only show when the block or shortcode is added', 'tocflow' ); ?></label><br>
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
				<h2><?php esc_html_e( 'SEO & data', 'tocflow' ); ?></h2>
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

			<?php submit_button( __( 'Save settings', 'tocflow' ) ); ?>
		</form>
	<?php endif; ?>
</div>
