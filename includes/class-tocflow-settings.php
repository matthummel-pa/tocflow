<?php
/**
 * Settings defaults, sanitization, and accessors.
 *
 * @package TOCflow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin settings stored in a single option.
 */
class TOCflow_Settings {

	const OPTION = 'tocflow_settings';

	/**
	 * Default settings.
	 *
	 * @return array
	 */
	public static function defaults() {
		return array(
			'smooth_scroll'         => 1,
			'scroll_offset'         => 96,
			'highlight_active'      => 1,
			'auto_insert'           => 'none',
			'auto_insert_types'     => array( 'post' ),
			'min_headings'          => 2,
			'schema_markup'         => 0,
			'delete_data'           => 0,
		);
	}

	/**
	 * Get merged settings.
	 *
	 * @return array
	 */
	public static function get() {
		$stored = get_option( self::OPTION, array() );
		if ( ! is_array( $stored ) ) {
			$stored = array();
		}
		return wp_parse_args( $stored, self::defaults() );
	}

	/**
	 * Get one setting.
	 *
	 * @param string $key     Setting key.
	 * @param mixed  $fallback Fallback if missing.
	 * @return mixed
	 */
	public static function get_value( $key, $fallback = null ) {
		$settings = self::get();
		if ( isset( $settings[ $key ] ) ) {
			return $settings[ $key ];
		}
		return $fallback;
	}

	/**
	 * Sanitize the settings array from the Settings API.
	 *
	 * @param mixed $input Raw submitted values.
	 * @return array
	 */
	public static function sanitize( $input ) {
		$defaults = self::defaults();
		if ( ! is_array( $input ) ) {
			return $defaults;
		}

		$clean = array();

		$clean['smooth_scroll']    = empty( $input['smooth_scroll'] ) ? 0 : 1;
		$clean['highlight_active'] = empty( $input['highlight_active'] ) ? 0 : 1;
		$clean['schema_markup']    = empty( $input['schema_markup'] ) ? 0 : 1;
		$clean['delete_data']      = empty( $input['delete_data'] ) ? 0 : 1;

		$offset = isset( $input['scroll_offset'] ) ? (int) $input['scroll_offset'] : $defaults['scroll_offset'];
		$clean['scroll_offset'] = min( 400, max( 0, $offset ) );

		$min = isset( $input['min_headings'] ) ? (int) $input['min_headings'] : $defaults['min_headings'];
		$clean['min_headings'] = min( 10, max( 1, $min ) );

		$allowed_insert = array( 'none', 'before', 'after_first_heading' );
		$insert         = isset( $input['auto_insert'] ) ? sanitize_key( $input['auto_insert'] ) : 'none';
		$clean['auto_insert'] = in_array( $insert, $allowed_insert, true ) ? $insert : 'none';

		$types = array();
		if ( ! empty( $input['auto_insert_types'] ) && is_array( $input['auto_insert_types'] ) ) {
			$public = get_post_types( array( 'public' => true ), 'names' );
			foreach ( $input['auto_insert_types'] as $type ) {
				$type = sanitize_key( $type );
				if ( isset( $public[ $type ] ) || in_array( $type, $public, true ) ) {
					$types[] = $type;
				}
			}
		}
		$clean['auto_insert_types'] = array_values( array_unique( $types ) );

		return $clean;
	}

	/**
	 * Register the setting with WordPress.
	 */
	public static function register() {
		register_setting(
			'tocflow_settings_group',
			self::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( __CLASS__, 'sanitize' ),
				'default'           => self::defaults(),
				'show_in_rest'      => false,
			)
		);
	}
}
