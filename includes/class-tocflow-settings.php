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
			// Reading experience.
			'smooth_scroll'         => 1,
			'scroll_offset'         => 96,
			'highlight_active'      => 1,
			'min_headings'          => 2,

			// Auto-generate.
			'auto_insert'           => 'none',
			'auto_insert_types'     => array( 'post' ),
			'auto_title'            => 'Table of Contents',
			'auto_show_title'       => 1,
			'auto_title_tag'        => 'p',
			'auto_show_h1'          => 0,
			'auto_show_h2'          => 1,
			'auto_show_h3'          => 1,
			'auto_show_h4'          => 0,
			'auto_show_h5'          => 0,
			'auto_show_h6'          => 0,
			'auto_ordered'          => 0,
			'auto_numbering'        => 'default',
			'auto_hide_markers'     => 0,
			'auto_collapsible'      => 0,
			'auto_collapsed'        => 0,
			'auto_sticky'           => 0,
			'auto_compact'          => 0,
			'auto_two_columns'      => 0,
			'auto_underline'        => 0,
			'auto_style'            => 'default',
			'auto_max_height'       => 0,

			// Reading Guide & Study Tools global defaults.
			'auto_preview_hover'    => 0,
			'auto_guide_mode'       => 0,
			'auto_show_previews'    => 1,
			'auto_show_density'     => 1,
			'auto_show_read_time'   => 1,
			'auto_track_progress'   => 1,
			'auto_show_reactions'   => 0,
			'auto_show_citations'   => 0,
			'auto_citation_style'   => 'apa',
			'auto_reading_progress' => 0,
			'auto_bookmark'         => 0,
			'auto_reader_notes'     => 0,
			'auto_export'           => 0,

			// Design & Appearance (empty = use built-in styles).
			'design_bg_color'       => '',
			'design_text_color'     => '',
			'design_link_color'     => '',
			'design_font_size'      => '',
			'design_font_weight'    => '',
			'design_line_height'    => '',
			'design_border_width'   => '',
			'design_border_color'   => '',
			'design_border_style'   => '',
			'design_border_radius'  => '',
			'design_padding'        => '',

			// Accessibility.
			'focus_style'           => 'default',

			// SEO & data.
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
		$settings = self::get();
		$style    = isset( $settings['auto_style'] ) ? sanitize_key( $settings['auto_style'] ) : 'default';
		$allowed  = class_exists( 'TOCflow_Headings' ) ? TOCflow_Headings::allowed_style_slugs() : array( 'default' );
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

		$ordered        = ! empty( $settings['auto_ordered'] ) || 'nested' === $numbering;
		$guide_mode     = ! empty( $settings['auto_guide_mode'] );
		$allowed_cite   = array( 'apa', 'mla', 'chicago', 'harvard', 'plain' );
		$citation_style = isset( $settings['auto_citation_style'] ) && in_array( $settings['auto_citation_style'], $allowed_cite, true )
			? $settings['auto_citation_style'] : 'apa';

		return array(
			'title'               => $title,
			'showTitle'           => ! empty( $settings['auto_show_title'] ),
			'titleTag'            => $title_tag,
			'showH1'              => ! empty( $settings['auto_show_h1'] ),
			'showH2'              => ! empty( $settings['auto_show_h2'] ),
			'showH3'              => ! empty( $settings['auto_show_h3'] ),
			'showH4'              => ! empty( $settings['auto_show_h4'] ),
			'showH5'              => ! empty( $settings['auto_show_h5'] ),
			'showH6'              => ! empty( $settings['auto_show_h6'] ),
			'ordered'             => $ordered,
			'numbering'           => $numbering,
			'hideMarkers'         => ! empty( $settings['auto_hide_markers'] ),
			'collapsible'         => ! empty( $settings['auto_collapsible'] ),
			'collapsedDefault'    => ! empty( $settings['auto_collapsed'] ),
			'sticky'              => ! empty( $settings['auto_sticky'] ),
			'compact'             => ! empty( $settings['auto_compact'] ),
			'twoColumns'          => ! empty( $settings['auto_two_columns'] ),
			'underlineLinks'      => ! empty( $settings['auto_underline'] ),
			'highlightActive'     => ! empty( $settings['highlight_active'] ),
			'stylePreset'         => $style,
			'className'           => 'is-style-' . $style,
			'scrollOffset'        => -1,
			'maxHeight'           => isset( $settings['auto_max_height'] ) ? max( 0, (int) $settings['auto_max_height'] ) : 0,
			'minHeadings'         => -1,
			'smoothScroll'        => 'inherit',
			// Reading Guide global defaults.
			'previewOnHover'      => ! empty( $settings['auto_preview_hover'] ),
			'guideMode'           => $guide_mode,
			'showPreviews'        => $guide_mode && ! empty( $settings['auto_show_previews'] ),
			'showDensity'         => $guide_mode && ! empty( $settings['auto_show_density'] ),
			'showReadTime'        => $guide_mode && ! empty( $settings['auto_show_read_time'] ),
			'trackProgress'       => $guide_mode && ! empty( $settings['auto_track_progress'] ),
			'showReactions'       => $guide_mode && ! empty( $settings['auto_show_reactions'] ),
			'showCitations'       => $guide_mode && ! empty( $settings['auto_show_citations'] ),
			'citationStyle'       => $citation_style,
			'sectionNotes'        => array(),
			'sectionStatus'       => array(),
			// Study Tools & Export global defaults.
			'showReadingProgress' => ! empty( $settings['auto_reading_progress'] ),
			'showBookmark'        => ! empty( $settings['auto_bookmark'] ),
			'showReaderNotes'     => ! empty( $settings['auto_reader_notes'] ),
			'showExport'          => ! empty( $settings['auto_export'] ),
		);
	}

	/**
	 * Sanitize the settings array from the Settings API.
	 *
	 * @param mixed $input Raw submitted values.
	 * @return array
	 */
	/**
	 * Sanitize a hex colour string. Returns empty string if invalid.
	 *
	 * @param mixed $value Raw value.
	 * @return string
	 */
	private static function sanitize_hex_color( $value ) {
		$v = trim( (string) $value );
		if ( '' === $v ) {
			return '';
		}
		if ( preg_match( '/^#[0-9a-fA-F]{3}([0-9a-fA-F]{3})?$/', $v ) ) {
			return strtolower( $v );
		}
		return '';
	}

	/**
	 * Sanitize a CSS length (px / rem / em / %). Returns empty string if invalid.
	 *
	 * @param mixed $value Raw value.
	 * @return string
	 */
	private static function sanitize_css_length( $value ) {
		$v = trim( (string) $value );
		if ( '' === $v ) {
			return '';
		}
		if ( preg_match( '/^[\d.]+(%|px|rem|em)$/', $v ) ) {
			return $v;
		}
		return '';
	}

	/**
	 * Sanitize a unitless CSS number (e.g. line-height). Returns empty if invalid.
	 *
	 * @param mixed $value Raw value.
	 * @return string
	 */
	private static function sanitize_css_number( $value ) {
		$v = trim( (string) $value );
		if ( '' === $v ) {
			return '';
		}
		if ( preg_match( '/^\d+(\.\d+)?$/', $v ) ) {
			return $v;
		}
		return '';
	}

	/**
	 * Sanitize settings before saving to the database.
	 *
	 * @param mixed $input Raw form data.
	 * @return array Sanitized settings merged with defaults.
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
			// Reading Guide & Study Tools checkboxes.
			'auto_preview_hover',
			'auto_guide_mode',
			'auto_show_previews',
			'auto_show_density',
			'auto_show_read_time',
			'auto_track_progress',
			'auto_show_reactions',
			'auto_show_citations',
			'auto_reading_progress',
			'auto_bookmark',
			'auto_reader_notes',
			'auto_export',
		);
		foreach ( $checkboxes as $key ) {
			$clean[ $key ] = empty( $input[ $key ] ) ? 0 : 1;
		}

		$offset                 = isset( $input['scroll_offset'] ) ? (int) $input['scroll_offset'] : $defaults['scroll_offset'];
		$clean['scroll_offset'] = min( 400, max( 0, $offset ) );

		$min                   = isset( $input['min_headings'] ) ? (int) $input['min_headings'] : $defaults['min_headings'];
		$clean['min_headings'] = min( 10, max( 1, $min ) );

		$max_height               = isset( $input['auto_max_height'] ) ? (int) $input['auto_max_height'] : 0;
		$clean['auto_max_height'] = min( 800, max( 0, $max_height ) );

		$allowed_insert       = array( 'none', 'before', 'after_first_heading' );
		$insert               = isset( $input['auto_insert'] ) ? sanitize_key( $input['auto_insert'] ) : 'none';
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

		$title               = isset( $input['auto_title'] ) ? sanitize_text_field( $input['auto_title'] ) : $defaults['auto_title'];
		$clean['auto_title'] = '' !== $title ? $title : $defaults['auto_title'];

		$title_tag               = isset( $input['auto_title_tag'] ) ? strtolower( sanitize_html_class( $input['auto_title_tag'] ) ) : 'p';
		$clean['auto_title_tag'] = in_array( $title_tag, array( 'p', 'h2', 'h3', 'h4' ), true ) ? $title_tag : 'p';

		$numbering               = isset( $input['auto_numbering'] ) ? sanitize_key( $input['auto_numbering'] ) : 'default';
		$clean['auto_numbering'] = in_array( $numbering, array( 'default', 'nested' ), true ) ? $numbering : 'default';

		$style               = isset( $input['auto_style'] ) ? sanitize_key( $input['auto_style'] ) : 'default';
		$allowed_styles      = array( 'default', 'minimal', 'boxed', 'underline', 'card' );
		$clean['auto_style'] = in_array( $style, $allowed_styles, true ) ? $style : 'default';

		// Citation style.
		$allowed_citation             = array( 'apa', 'mla', 'chicago', 'harvard', 'plain' );
		$cite                         = isset( $input['auto_citation_style'] ) ? sanitize_key( $input['auto_citation_style'] ) : 'apa';
		$clean['auto_citation_style'] = in_array( $cite, $allowed_citation, true ) ? $cite : 'apa';

		// Design & Appearance.
		$clean['design_bg_color']    = self::sanitize_hex_color( isset( $input['design_bg_color'] ) ? $input['design_bg_color'] : '' );
		$clean['design_text_color']  = self::sanitize_hex_color( isset( $input['design_text_color'] ) ? $input['design_text_color'] : '' );
		$clean['design_link_color']  = self::sanitize_hex_color( isset( $input['design_link_color'] ) ? $input['design_link_color'] : '' );
		$clean['design_font_size']   = self::sanitize_css_length( isset( $input['design_font_size'] ) ? $input['design_font_size'] : '' );
		$clean['design_line_height'] = self::sanitize_css_number( isset( $input['design_line_height'] ) ? $input['design_line_height'] : '' );

		$allowed_fw                  = array( '100', '200', '300', '400', '500', '600', '700', '800', '900', 'normal', 'bold' );
		$fw                          = isset( $input['design_font_weight'] ) ? trim( (string) $input['design_font_weight'] ) : '';
		$clean['design_font_weight'] = in_array( $fw, $allowed_fw, true ) ? $fw : '';

		$clean['design_border_width']  = self::sanitize_css_length( isset( $input['design_border_width'] ) ? $input['design_border_width'] : '' );
		$clean['design_border_color']  = self::sanitize_hex_color( isset( $input['design_border_color'] ) ? $input['design_border_color'] : '' );
		$clean['design_border_radius'] = self::sanitize_css_length( isset( $input['design_border_radius'] ) ? $input['design_border_radius'] : '' );
		$clean['design_padding']       = self::sanitize_css_length( isset( $input['design_padding'] ) ? $input['design_padding'] : '' );

		$allowed_bs                   = array( '', 'solid', 'dashed', 'dotted', 'double', 'none' );
		$bs                           = isset( $input['design_border_style'] ) ? sanitize_key( $input['design_border_style'] ) : '';
		$clean['design_border_style'] = in_array( $bs, $allowed_bs, true ) ? $bs : '';

		// Accessibility.
		$allowed_focus        = array( 'default', 'bold', 'high-contrast' );
		$focus                = isset( $input['focus_style'] ) ? sanitize_key( $input['focus_style'] ) : 'default';
		$clean['focus_style'] = in_array( $focus, $allowed_focus, true ) ? $focus : 'default';

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
