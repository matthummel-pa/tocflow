<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * Deactivation must not delete data. Uninstall only deletes the option
 * when the site owner opted in via Settings → TOCguide.
 *
 * @package TOCguide
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$tocguide_settings = get_option( 'tocguide_settings', array() );

if ( is_array( $tocguide_settings ) && ! empty( $tocguide_settings['delete_data'] ) ) {
	delete_option( 'tocguide_settings' );

	$tocguide_users = get_users(
		array(
			'fields'       => 'ID',
			'meta_key'     => 'tocguide_welcome_dismissed', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- one-time uninstall cleanup.
			'meta_compare' => 'EXISTS',
		)
	);
	foreach ( $tocguide_users as $tocguide_user_id ) {
		delete_user_meta( (int) $tocguide_user_id, 'tocguide_welcome_dismissed' );
	}
}

delete_transient( 'tocguide_activation_redirect' );
