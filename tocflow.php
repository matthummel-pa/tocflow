<?php
/**
 * Plugin Name:       TOCflow
 * Plugin URI:        https://github.com/matthummel-pa/tocflow
 * Description:       A lightweight Table of Contents block that auto-generates a linked outline from your post headings.
 * Version:           1.0.1
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Author:            Matt Hummel
 * Author URI:        https://matthummel.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tocflow
 * Domain Path:       /languages
 *
 * @package   TOCflow
 * @copyright 2026 Matt Hummel
 * @license   GPL-2.0-or-later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TOCFLOW_VERSION', '1.0.1' );
define( 'TOCFLOW_FILE', __FILE__ );
define( 'TOCFLOW_DIR', plugin_dir_path( __FILE__ ) );
define( 'TOCFLOW_URL', plugin_dir_url( __FILE__ ) );
define( 'TOCFLOW_BASENAME', plugin_basename( __FILE__ ) );

require_once TOCFLOW_DIR . 'includes/class-tocflow-settings.php';
require_once TOCFLOW_DIR . 'includes/class-tocflow-headings.php';
require_once TOCFLOW_DIR . 'includes/class-tocflow-plugin.php';

/**
 * Returns the main plugin instance.
 *
 * @return TOCflow_Plugin
 */
function tocflow() {
	return TOCflow_Plugin::instance();
}

tocflow()->boot();

register_activation_hook( TOCFLOW_FILE, array( 'TOCflow_Plugin', 'activate' ) );
register_deactivation_hook( TOCFLOW_FILE, array( 'TOCflow_Plugin', 'deactivate' ) );

/**
 * Heading map for a post. Kept as a prefixed wrapper so render.php stays thin.
 *
 * @param int $post_id Post ID.
 * @return array
 */
function tocflow_get_all_headings( $post_id ) {
	return TOCflow_Headings::get_all( $post_id );
}

/**
 * Render nested list markup from heading data.
 *
 * @param array  $headings Heading data with normalized 'level'.
 * @param string $list_tag 'ol' or 'ul'.
 * @return string
 */
function tocflow_render_list( $headings, $list_tag ) {
	return TOCflow_Headings::render_list( $headings, $list_tag );
}
