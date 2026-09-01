<?php
/**
 * Plugin bootstrap, hooks, shortcode, and auto-insert.
 *
 * @package TOCflow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin controller.
 */
class TOCflow_Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var TOCflow_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Get the singleton.
	 *
	 * @return TOCflow_Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Hook everything. Safe to call once.
	 */
	public function boot() {
		add_action( 'init', array( $this, 'register_block' ) );
		add_action( 'init', array( $this, 'register_shortcode' ) );
		add_action( 'admin_init', array( 'TOCflow_Settings', 'register' ) );
		add_filter( 'render_block', array( 'TOCflow_Headings', 'add_heading_ids' ), 10, 2 );
		add_filter( 'the_content', array( $this, 'auto_insert' ), 12 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_front_assets' ), 20 );
		add_filter( 'plugin_action_links_' . TOCFLOW_BASENAME, array( $this, 'action_links' ) );
		add_filter( 'plugin_row_meta', array( $this, 'row_meta' ), 10, 2 );

		if ( is_admin() ) {
			require_once TOCFLOW_DIR . 'includes/class-tocflow-admin.php';
			TOCflow_Admin::instance()->boot();
		}
	}

	/**
	 * Register the dynamic block from compiled metadata.
	 */
	public function register_block() {
		$build = TOCFLOW_DIR . 'build';
		if ( ! file_exists( $build . '/block.json' ) ) {
			return;
		}
		register_block_type( $build );
	}

	/**
	 * [tocflow] shortcode — same output as the block, for classic content and theme templates.
	 *
	 * @param array|string $atts Shortcode attributes.
	 * @return string
	 */
	public function shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'       => __( 'Table of Contents', 'tocflow' ),
				'showtitle'   => '1',
				'titletag'    => 'p',
				'h1'          => '0',
				'h2'          => '1',
				'h3'          => '1',
				'h4'          => '0',
				'h5'          => '0',
				'h6'          => '0',
				'ordered'     => '0',
				'numbering'   => 'default',
				'markers'     => '1',
				'collapsible' => '0',
				'collapsed'   => '0',
				'sticky'      => '0',
				'compact'     => '0',
				'columns'     => '1',
				'underline'   => '0',
				'highlight'   => '',
				'maxheight'   => '0',
				'min'         => '-1',
				'smooth'      => 'inherit',
				'style'       => 'default',
			),
			$atts,
			'tocflow'
		);

		$post_id = get_the_ID();
		if ( ! $post_id ) {
			return '';
		}

		$style = sanitize_key( $atts['style'] );
		if ( ! in_array( $style, TOCflow_Headings::allowed_style_slugs(), true ) ) {
			$style = 'default';
		}

		$numbering = sanitize_key( $atts['numbering'] );
		if ( ! in_array( $numbering, array( 'default', 'nested' ), true ) ) {
			$numbering = 'default';
		}

		$smooth = sanitize_key( $atts['smooth'] );
		if ( ! in_array( $smooth, array( 'inherit', 'on', 'off' ), true ) ) {
			$smooth = 'inherit';
		}

		$title_tag = strtolower( sanitize_html_class( $atts['titletag'] ) );
		if ( ! in_array( $title_tag, array( 'p', 'h2', 'h3', 'h4' ), true ) ) {
			$title_tag = 'p';
		}

		$highlight = '' === $atts['highlight']
			? (bool) TOCflow_Settings::get_value( 'highlight_active' )
			: $this->is_truthy( $atts['highlight'] );

		$attributes = array(
			'title'            => sanitize_text_field( $atts['title'] ),
			'showTitle'        => $this->is_truthy( $atts['showtitle'] ),
			'titleTag'         => $title_tag,
			'showH1'           => $this->is_truthy( $atts['h1'] ),
			'showH2'           => $this->is_truthy( $atts['h2'] ),
			'showH3'           => $this->is_truthy( $atts['h3'] ),
			'showH4'           => $this->is_truthy( $atts['h4'] ),
			'showH5'           => $this->is_truthy( $atts['h5'] ),
			'showH6'           => $this->is_truthy( $atts['h6'] ),
			'ordered'          => $this->is_truthy( $atts['ordered'] ) || 'nested' === $numbering,
			'numbering'        => $numbering,
			'hideMarkers'      => ! $this->is_truthy( $atts['markers'] ),
			'collapsible'      => $this->is_truthy( $atts['collapsible'] ),
			'collapsedDefault' => $this->is_truthy( $atts['collapsed'] ),
			'sticky'           => $this->is_truthy( $atts['sticky'] ),
			'compact'          => $this->is_truthy( $atts['compact'] ),
			'twoColumns'       => (int) $atts['columns'] >= 2,
			'underlineLinks'   => $this->is_truthy( $atts['underline'] ),
			'stylePreset'      => $style,
			'className'        => 'is-style-' . $style,
			'highlightActive'  => $highlight,
			'scrollOffset'     => -1,
			'maxHeight'        => max( 0, (int) $atts['maxheight'] ),
			'minHeadings'      => (int) $atts['min'],
			'smoothScroll'     => $smooth,
		);

		return TOCflow_Headings::render_nav( $attributes, $post_id, false );
	}

	/**
	 * Register the shortcode.
	 */
	public function register_shortcode() {
		add_shortcode( 'tocflow', array( $this, 'shortcode' ) );
	}

	/**
	 * Ensure view script + block CSS load for shortcode and auto-insert
	 * (block.json assets only auto-enqueue when the block is in content).
	 */
	public function enqueue_front_assets() {
		if ( ! is_singular() ) {
			return;
		}
		$post = get_post();
		if ( ! $post ) {
			return;
		}
		$settings = TOCflow_Settings::get();
		$needed   = has_block( 'tocflow/table-of-contents', $post )
			|| has_shortcode( $post->post_content, 'tocflow' )
			|| ( 'none' !== $settings['auto_insert'] && in_array( $post->post_type, $settings['auto_insert_types'], true ) );
		if ( ! $needed ) {
			return;
		}

		$script = 'tocflow-table-of-contents-view-script';
		$style  = 'tocflow-table-of-contents-style';
		if ( wp_script_is( $script, 'registered' ) ) {
			wp_enqueue_script( $script );
		}
		if ( wp_style_is( $style, 'registered' ) ) {
			wp_enqueue_style( $style );
		}
	}

	/**
	 * Auto-insert a TOC when no block/shortcode is present.
	 *
	 * @param string $content Post content.
	 * @return string
	 */
	public function auto_insert( $content ) {
		if ( is_admin() || ! is_singular() || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		$settings = TOCflow_Settings::get();
		if ( 'none' === $settings['auto_insert'] ) {
			return $content;
		}

		$post = get_post();
		if ( ! $post ) {
			return $content;
		}

		$types = $settings['auto_insert_types'];
		if ( empty( $types ) || ! in_array( $post->post_type, $types, true ) ) {
			return $content;
		}

		if ( has_block( 'tocflow/table-of-contents', $post ) ) {
			return $content;
		}
		if ( has_shortcode( $post->post_content, 'tocflow' ) ) {
			return $content;
		}

		$toc = self::render_auto_block( (int) $post->ID );
		if ( '' === $toc ) {
			return $content;
		}

		if ( 'after_first_heading' === $settings['auto_insert'] ) {
			$updated = preg_replace( '/(<\/h[1-6]>)/i', '$1' . $toc, $content, 1 );
			return is_string( $updated ) ? $updated : $content . $toc;
		}

		return $toc . $content;
	}

	/**
	 * Render the Gutenberg Table of Contents block using auto-generate settings.
	 *
	 * @param int $post_id Post ID (passed through block context).
	 * @return string
	 */
	public static function render_auto_block( $post_id ) {
		$attributes = TOCflow_Settings::block_attributes();
		$registry   = WP_Block_Type_Registry::get_instance();

		if ( class_exists( 'WP_Block' ) && $registry->is_registered( 'tocflow/table-of-contents' ) ) {
			$block = new WP_Block(
				array(
					'blockName'    => 'tocflow/table-of-contents',
					'attrs'        => $attributes,
					'innerBlocks'  => array(),
					'innerHTML'    => '',
					'innerContent' => array(),
				),
				array(
					'postId'   => (int) $post_id,
					'postType' => get_post_type( $post_id ),
				)
			);
			$html = $block->render( array( 'dynamic' => true ) );
			if ( is_string( $html ) && '' !== $html ) {
				return $html;
			}
		}

		return TOCflow_Headings::render_nav( $attributes, $post_id, false );
	}

	/**
	 * Settings + Docs links on the Plugins screen.
	 *
	 * @param array $links Existing action links.
	 * @return array
	 */
	public function action_links( $links ) {
		$settings = '<a href="' . esc_url( admin_url( 'options-general.php?page=tocflow' ) ) . '">' . esc_html__( 'Settings', 'tocflow' ) . '</a>';
		$docs     = '<a href="' . esc_url( admin_url( 'options-general.php?page=tocflow&tab=support' ) ) . '">' . esc_html__( 'Docs & Support', 'tocflow' ) . '</a>';
		array_unshift( $links, $settings, $docs );
		return $links;
	}

	/**
	 * Extra meta links.
	 *
	 * @param array  $links Already-formed links.
	 * @param string $file  Plugin basename.
	 * @return array
	 */
	public function row_meta( $links, $file ) {
		if ( TOCFLOW_BASENAME !== $file ) {
			return $links;
		}
		$links[] = '<a href="https://matthummel-pa.github.io/tocflow/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Documentation', 'tocflow' ) . '</a>';
		$links[] = '<a href="https://github.com/matthummel-pa/tocflow/issues" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Support', 'tocflow' ) . '</a>';
		return $links;
	}

	/**
	 * Truthy shortcode values.
	 *
	 * @param mixed $value Raw attribute.
	 * @return bool
	 */
	private function is_truthy( $value ) {
		return in_array( strtolower( (string) $value ), array( '1', 'true', 'yes', 'on' ), true );
	}

	/**
	 * Activation: store a one-time welcome flag. Do not delete data on deactivate.
	 */
	public static function activate() {
		if ( false === get_option( TOCflow_Settings::OPTION ) ) {
			add_option( TOCflow_Settings::OPTION, TOCflow_Settings::defaults(), '', false );
		}
		set_transient( 'tocflow_activation_redirect', 1, 30 );
	}

	/**
	 * Deactivation must not delete settings (Envato + WP.org).
	 */
	public static function deactivate() {
		delete_transient( 'tocflow_activation_redirect' );
	}
}
