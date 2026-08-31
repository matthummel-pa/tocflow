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
			'smooth_scroll'     => 1,
			'scroll_offset'     => 96,
			'highlight_active'  => 1,
			'auto_insert'       => 'none',
			'auto_insert_types' => array( 'post' ),
			'auto_title'        => 'Table of Contents',
			'auto_show_title'   => 1,
			'auto_title_tag'    => 'p',
			'auto_show_h1'      => 0,
			'auto_show_h2'      => 1,
			'auto_show_h3'      => 1,
			'auto_show_h4'      => 0,
			'auto_show_h5'      => 0,
			'auto_show_h6'      => 0,
			'auto_ordered'      => 0,
			'auto_numbering'    => 'default',
			'auto_hide_markers' => 0,
			'auto_collapsible'  => 0,
			'auto_collapsed'    => 0,
			'auto_sticky'       => 0,
			'auto_compact'      => 0,
			'auto_two_columns'  => 0,
			'auto_underline'    => 0,
			'auto_style'        => 'default',
			'auto_max_height'   => 0,
			'min_headings'      => 2,
			'schema_markup'     => 0,
			'delete_data'       => 0,
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
	 * @param string $key      Setting key.
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
	 * Block attributes for the auto-generated Table of Contents block.
	 *
	 * Used by auto-insert so the front end is the Gutenberg block, not a shortcode.
	 *
	 * @return array
	 */
	public static function block_attributes() {
		$settings  = self::get();
		$style     = isset( $settings['auto_style'] ) ? sanitize_key( $settings['auto_style'] ) : 'default';
		$allowed   = class_exists( 'TOCflow_Headings' ) ? TOCflow_Headings::allowed_style_slugs() : array( 'default' );
		if ( ! in_array( $style, $allowed, true ) ) {
			$style = 'default';
		}

		$numbering = isset( $settings['auto_numbering'] ) ? sanitize_key( $settings['auto_numbering'] ) : 'default';
		if ( ! in_array( $numbering, array( 'default', 'nested' ), true ) ) {
			$numbering = 'default';
		}

		$title_tag = isset( $settings['auto_title_tag'] ) ? strtolower( (string) $settings['auto_title_tag'] ) : 'p';
		if ( ! in_array( $title_tag, array( 'p', 'h2', 'h3', 'h4' ), true ) ) {
			$title_tag = 'p';
		}

		$title = isset( $settings['auto_title'] ) ? $settings['auto_title'] : '';
		if ( '' === $title ) {
			$title = __( 'Table of Contents', 'tocflow' );
		}

		$ordered = ! empty( $settings['auto_ordered'] ) || 'nested' === $numbering;

		return array(
			'title'            => $title,
			'showTitle'        => ! empty( $settings['auto_show_title'] ),
			'titleTag'         => $title_tag,
			'showH1'           => ! empty( $settings['auto_show_h1'] ),
			'showH2'           => ! empty( $settings['auto_show_h2'] ),
			'showH3'           => ! empty( $settings['auto_show_h3'] ),
			'showH4'           => ! empty( $settings['auto_show_h4'] ),
			'showH5'           => ! empty( $settings['auto_show_h5'] ),
			'showH6'           => ! empty( $settings['auto_show_h6'] ),
			'ordered'          => $ordered,
			'numbering'        => $numbering,
			'hideMarkers'      => ! empty( $settings['auto_hide_markers'] ),
			'collapsible'      => ! empty( $settings['auto_collapsible'] ),
			'collapsedDefault' => ! empty( $settings['auto_collapsed'] ),
			'sticky'           => ! empty( $settings['auto_sticky'] ),
			'compact'          => ! empty( $settings['auto_compact'] ),
			'twoColumns'       => ! empty( $settings['auto_two_columns'] ),
			'underlineLinks'   => ! empty( $settings['auto_underline'] ),
			'highlightActive'  => ! empty( $settings['highlight_active'] ),
			'stylePreset'      => $style,
			'className'        => 'is-style-' . $style,
			'scrollOffset'     => -1,
			'maxHeight'        => isset( $settings['auto_max_height'] ) ? max( 0, (int) $settings['auto_max_height'] ) : 0,
			'minHeadings'      => -1,
			'smoothScroll'     => 'inherit',
		);
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

		$checkboxes = array(
			'smooth_scroll',
			'highlight_active',
			'schema_markup',
			'delete_data',
			'auto_show_title',
			'auto_show_h1',
			'auto_show_h2',
			'auto_show_h3',
			'auto_show_h4',
			'auto_show_h5',
			'auto_show_h6',
			'auto_ordered',
			'auto_hide_markers',
			'auto_collapsible',
			'auto_collapsed',
			'auto_sticky',
			'auto_compact',
			'auto_two_columns',
			'auto_underline',
		);
		foreach ( $checkboxes as $key ) {
			$clean[ $key ] = empty( $input[ $key ] ) ? 0 : 1;
		}

		$offset = isset( $input['scroll_offset'] ) ? (int) $input['scroll_offset'] : $defaults['scroll_offset'];
		$clean['scroll_offset'] = min( 400, max( 0, $offset ) );

		$min = isset( $input['min_headings'] ) ? (int) $input['min_headings'] : $defaults['min_headings'];
		$clean['min_headings'] = min( 10, max( 1, $min ) );

		$max_height = isset( $input['auto_max_height'] ) ? (int) $input['auto_max_height'] : 0;
		$clean['auto_max_height'] = min( 800, max( 0, $max_height ) );

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

		$title = isset( $input['auto_title'] ) ? sanitize_text_field( $input['auto_title'] ) : $defaults['auto_title'];
		$clean['auto_title'] = '' !== $title ? $title : $defaults['auto_title'];

		$title_tag = isset( $input['auto_title_tag'] ) ? strtolower( sanitize_html_class( $input['auto_title_tag'] ) ) : 'p';
		$clean['auto_title_tag'] = in_array( $title_tag, array( 'p', 'h2', 'h3', 'h4' ), true ) ? $title_tag : 'p';

		$numbering = isset( $input['auto_numbering'] ) ? sanitize_key( $input['auto_numbering'] ) : 'default';
		$clean['auto_numbering'] = in_array( $numbering, array( 'default', 'nested' ), true ) ? $numbering : 'default';

		$style = isset( $input['auto_style'] ) ? sanitize_key( $input['auto_style'] ) : 'default';
		$allowed_styles = array( 'default', 'minimal', 'boxed', 'underline', 'card' );
		$clean['auto_style'] = in_array( $style, $allowed_styles, true ) ? $style : 'default';

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
