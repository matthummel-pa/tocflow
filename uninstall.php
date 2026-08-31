<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * Deactivation must not delete data. Uninstall only deletes the option
 * when the site owner opted in via Settings → TOCflow.
 *
 * @package TOCflow
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$settings = get_option( 'tocflow_settings', array() );

if ( is_array( $settings ) && ! empty( $settings['delete_data'] ) ) {
	delete_option( 'tocflow_settings' );

	$users = get_users(
		array(
			'fields'       => 'ID',
			'meta_key'     => 'tocflow_welcome_dismissed', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- one-time uninstall cleanup.
			'meta_compare' => 'EXISTS',
		)
	);
	foreach ( $users as $user_id ) {
		delete_user_meta( (int) $user_id, 'tocflow_welcome_dismissed' );
	}
}

delete_transient( 'tocflow_activation_redirect' );
