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

$tocflow_settings = get_option( 'tocflow_settings', array() );

if ( is_array( $tocflow_settings ) && ! empty( $tocflow_settings['delete_data'] ) ) {
	delete_option( 'tocflow_settings' );

	$tocflow_users = get_users(
		array(
			'fields'       => 'ID',
			'meta_key'     => 'tocflow_welcome_dismissed', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- one-time uninstall cleanup.
			'meta_compare' => 'EXISTS',
		)
	);
	foreach ( $tocflow_users as $tocflow_user_id ) {
		delete_user_meta( (int) $tocflow_user_id, 'tocflow_welcome_dismissed' );
	}
}

delete_transient( 'tocflow_activation_redirect' );
