<?php
/**
 * Admin settings and support screens.
 *
 * @package TOCflow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * wp-admin UI. Loaded only when is_admin().
 */
class TOCflow_Admin {

	/**
	 * Singleton.
	 *
	 * @var TOCflow_Admin|null
	 */
	private static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return TOCflow_Admin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Hook admin actions.
	 */
	public function boot() {
		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		add_action( 'wp_ajax_tocflow_dismiss_welcome', array( $this, 'dismiss_welcome' ) );
		add_action( 'admin_head-settings_page_tocflow', array( $this, 'help_tabs' ) );
	}

	/**
	 * Settings → TOCflow.
	 */
	public function menu() {
		add_options_page(
			__( 'TOCflow', 'tocflow' ),
			__( 'TOCflow', 'tocflow' ),
			'manage_options',
			'tocflow',
			array( $this, 'render' )
		);
	}

	/**
	 * Enqueue admin CSS on our screen only.
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function assets( $hook ) {
		if ( get_transient( 'tocflow_activation_redirect' ) && ! get_user_meta( get_current_user_id(), 'tocflow_welcome_dismissed', true ) ) {
			wp_enqueue_script(
				'tocflow-welcome',
				TOCFLOW_URL . 'admin/js/welcome.js',
				array(),
				TOCFLOW_VERSION,
				true
			);
		}

		if ( 'settings_page_tocflow' !== $hook ) {
			return;
		}
		wp_enqueue_style(
			'tocflow-admin',
			TOCFLOW_URL . 'admin/css/admin.css',
			array(),
			TOCFLOW_VERSION
		);
	}

	/**
	 * Help tabs on the settings screen.
	 */
	public function help_tabs() {
		$screen = get_current_screen();
		if ( ! $screen ) {
			return;
		}
		$screen->add_help_tab(
			array(
				'id'      => 'tocflow-block',
				'title'   => __( 'Using the block', 'tocflow' ),
				'content' => '<p>' . esc_html__( 'Edit a post, click the inserter, and search for “Table of Contents”. The outline is built from Heading blocks in that post.', 'tocflow' ) . '</p>',
			)
		);
		$screen->add_help_tab(
			array(
				'id'      => 'tocflow-auto',
				'title'   => __( 'Auto-generate', 'tocflow' ),
				'content' => '<p>' . esc_html__( 'Settings → TOCflow can print the Table of Contents block at the top of content or after the first heading. Customize title, heading levels, style, and layout there. Manual blocks and the [tocflow] shortcode still skip auto-generate so you never get two outlines.', 'tocflow' ) . '</p>',
			)
		);
		$screen->add_help_tab(
			array(
				'id'      => 'tocflow-shortcode',
				'title'   => __( 'Shortcode', 'tocflow' ),
				'content' => '<p><code>[tocflow]</code> ' . esc_html__( 'prints the same outline in classic content, widgets, or a theme template. The Gutenberg block is the primary placement method.', 'tocflow' ) . '</p>',
			)
		);
		$screen->set_help_sidebar(
			'<p><strong>' . esc_html__( 'Support', 'tocflow' ) . '</strong></p>' .
			'<p><a href="https://github.com/matthummel-pa/tocflow/issues" target="_blank" rel="noopener noreferrer">' . esc_html__( 'GitHub issues', 'tocflow' ) . '</a></p>' .
			'<p><a href="https://matthummel-pa.github.io/tocflow/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Online docs', 'tocflow' ) . '</a></p>'
		);
	}

	/**
	 * Render the settings / support page.
	 */
	public function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'settings'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! in_array( $tab, array( 'settings', 'support' ), true ) ) {
			$tab = 'settings';
		}

		$settings = TOCflow_Settings::get();
		$types    = get_post_types( array( 'public' => true ), 'objects' );

		include TOCFLOW_DIR . 'admin/views/settings.php';
	}

	/**
	 * One-time welcome notice after activation.
	 */
	public function welcome_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( ! get_transient( 'tocflow_activation_redirect' ) ) {
			return;
		}
		if ( get_user_meta( get_current_user_id(), 'tocflow_welcome_dismissed', true ) ) {
			delete_transient( 'tocflow_activation_redirect' );
			return;
		}
		$screen = get_current_screen();
		if ( $screen && 'settings_page_tocflow' === $screen->id ) {
			return;
		}
		?>
		<div class="notice notice-success is-dismissible tocflow-welcome" data-nonce="<?php echo esc_attr( wp_create_nonce( 'tocflow_dismiss_welcome' ) ); ?>">
			<p>
				<strong><?php esc_html_e( 'TOCflow is ready.', 'tocflow' ); ?></strong>
				<?php esc_html_e( 'Add the Table of Contents block to a post, or auto-generate it under Settings → TOCflow. The [tocflow] shortcode still works in classic content.', 'tocflow' ); ?>
				<a href="<?php echo esc_url( admin_url( 'options-general.php?page=tocflow' ) ); ?>"><?php esc_html_e( 'Open settings', 'tocflow' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Persist welcome dismissal.
	 */
	public function dismiss_welcome() {
		check_ajax_referer( 'tocflow_dismiss_welcome', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( null, 403 );
		}
		update_user_meta( get_current_user_id(), 'tocflow_welcome_dismissed', 1 );
		delete_transient( 'tocflow_activation_redirect' );
		wp_send_json_success();
	}
}
