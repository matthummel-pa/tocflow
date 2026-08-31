<?php
/**
 * Heading collection, list rendering, and heading-id injection.
 *
 * @package TOCflow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single source of truth for TOC headings and matching anchors.
 */
class TOCflow_Headings {

	/**
	 * Create a URL-safe, unique anchor slug from heading text.
	 *
	 * @param string $text Heading text.
	 * @param array  $used Slugs already used on this page (passed by reference).
	 * @return string
	 */
	public static function make_slug( $text, &$used ) {
		$slug = sanitize_title( $text );
		if ( '' === $slug ) {
			$slug = 'section';
		}
		$base  = $slug;
		$index = 2;
		while ( isset( $used[ $slug ] ) ) {
			$slug = $base . '-' . $index;
			$index++;
		}
		$used[ $slug ] = true;
		return $slug;
	}

	/**
	 * Whether a heading should be skipped (class no-toc / tocflow-skip).
	 *
	 * @param array  $block Parsed block.
	 * @param string $html  Inner HTML.
	 * @return bool
	 */
	public static function should_skip( $block, $html ) {
		$classes = '';
		if ( ! empty( $block['attrs']['className'] ) ) {
			$classes .= ' ' . $block['attrs']['className'];
		}
		if ( preg_match( '/class=["\']([^"\']+)["\']/', $html, $match ) ) {
			$classes .= ' ' . $match[1];
		}
		$classes = strtolower( $classes );
		return ( false !== strpos( $classes, 'no-toc' ) || false !== strpos( $classes, 'tocflow-skip' ) );
	}

	/**
	 * Recursively walk parsed blocks and collect heading data in document order.
	 *
	 * @param array $blocks    Parsed blocks from parse_blocks().
	 * @param array $used      Used slugs (by reference) for dedup.
	 * @param array $collected Growing list of headings (by reference).
	 */
	public static function collect( $blocks, &$used, &$collected ) {
		foreach ( $blocks as $block ) {
			if ( 'core/heading' === $block['blockName'] ) {
				$html = isset( $block['innerHTML'] ) ? $block['innerHTML'] : '';
				$text = trim( wp_strip_all_tags( $html ) );

				$level = 2;
				if ( isset( $block['attrs']['level'] ) ) {
					$level = (int) $block['attrs']['level'];
				} elseif ( preg_match( '/<h([1-6])/i', $html, $match ) ) {
					$level = (int) $match[1];
				}

				if ( '' !== $text && ! self::should_skip( $block, $html ) ) {
					$slug = '';
					if ( ! empty( $block['attrs']['anchor'] ) ) {
						$slug = sanitize_title( $block['attrs']['anchor'] );
					} elseif ( preg_match( '/\sid=["\']([^"\']+)["\']/i', $html, $id_match ) ) {
						$slug = $id_match[1];
					}

					if ( '' === $slug ) {
						$slug = self::make_slug( $text, $used );
					} else {
						$used[ $slug ] = true;
					}

					$collected[] = array(
						'level' => $level,
						'text'  => $text,
						'slug'  => $slug,
					);
				}
			}

			if ( ! empty( $block['innerBlocks'] ) ) {
				self::collect( $block['innerBlocks'], $used, $collected );
			}
		}
	}

	/**
	 * Get the full, slug-stamped heading map for a post.
	 *
	 * @param int $post_id Post ID.
	 * @return array
	 */
	public static function get_all( $post_id ) {
		static $cache = array();
		$post_id      = (int) $post_id;

		if ( isset( $cache[ $post_id ] ) ) {
			return $cache[ $post_id ];
		}

		$post      = get_post( $post_id );
		$used      = array();
		$collected = array();

		if ( $post ) {
			self::collect( parse_blocks( $post->post_content ), $used, $collected );
		}

		$cache[ $post_id ] = $collected;
		return $collected;
	}

	/**
	 * Filter headings to selected levels and normalize nesting depths.
	 *
	 * @param array $all    Full heading map.
	 * @param array $levels Heading levels to keep (e.g. array( 2, 3 )).
	 * @return array
	 */
	public static function filter_and_normalize( $all, $levels ) {
		$filtered = array_values(
			array_filter(
				$all,
				function ( $heading ) use ( $levels ) {
					return in_array( (int) $heading['level'], $levels, true );
				}
			)
		);

		if ( empty( $filtered ) ) {
			return array();
		}

		$present = array_values( array_unique( wp_list_pluck( $filtered, 'level' ) ) );
		sort( $present, SORT_NUMERIC );
		$depth_map = array_flip( $present );

		foreach ( $filtered as &$heading ) {
			$heading['level'] = $depth_map[ $heading['level'] ] + 1;
		}
		unset( $heading );

		return $filtered;
	}

	/**
	 * Heading levels requested by block attributes.
	 *
	 * @param array $attributes Block attributes.
	 * @return array
	 */
	public static function levels_from_attributes( $attributes ) {
		$levels = array();
		$map    = array(
			'showH2' => 2,
			'showH3' => 3,
			'showH4' => 4,
			'showH5' => 5,
			'showH6' => 6,
		);
		foreach ( $map as $key => $level ) {
			if ( ! empty( $attributes[ $key ] ) ) {
				$levels[] = $level;
			}
		}
		if ( empty( $levels ) ) {
			$levels = array( 2 );
		}
		return $levels;
	}

	/**
	 * Render nested list markup from heading data.
	 *
	 * @param array  $headings Heading data with normalized 'level'.
	 * @param string $list_tag 'ol' or 'ul'.
	 * @return string
	 */
	public static function render_list( $headings, $list_tag ) {
		if ( empty( $headings ) ) {
			return '';
		}

		$list_tag = ( 'ol' === $list_tag ) ? 'ol' : 'ul';
		$html     = '';
		$prev     = 0;
		$open     = 0;

		foreach ( $headings as $heading ) {
			$level = (int) $heading['level'];

			if ( $level > $prev ) {
				for ( $i = 0; $i < ( $level - $prev ); $i++ ) {
					$class = 0 === $open ? ' class="tocflow__list"' : ' class="tocflow__sub"';
					$html .= '<' . $list_tag . $class . '>';
					$open++;
				}
			} else {
				$html .= '</li>';
				if ( $level < $prev ) {
					for ( $i = 0; $i < ( $prev - $level ); $i++ ) {
						$html .= '</' . $list_tag . '></li>';
						$open--;
					}
				}
			}

			$html .= '<li class="tocflow__item"><a class="tocflow__link" href="#' . esc_attr( $heading['slug'] ) . '">' . esc_html( $heading['text'] ) . '</a>';
			$prev  = $level;
		}

		$html .= '</li>';
		for ( $i = 0; $i < $open; $i++ ) {
			$html .= '</' . $list_tag . '>';
			if ( $i < $open - 1 ) {
				$html .= '</li>';
			}
		}

		return $html;
	}

	/**
	 * Build the full <nav> markup for a TOC.
	 *
	 * @param array $attributes Block attributes.
	 * @param int   $post_id    Post ID.
	 * @param bool  $wrap       Whether to include block wrapper attributes.
	 * @return string
	 */
	public static function render_nav( $attributes, $post_id, $wrap = true ) {
		$levels = self::levels_from_attributes( $attributes );
		$all    = self::get_all( $post_id );
		$items  = self::filter_and_normalize( $all, $levels );

		$min = (int) TOCflow_Settings::get_value( 'min_headings', 2 );
		if ( count( $items ) < $min ) {
			return '';
		}

		$settings   = TOCflow_Settings::get();
		$list_tag   = ! empty( $attributes['ordered'] ) ? 'ol' : 'ul';
		$title_raw  = isset( $attributes['title'] ) ? (string) $attributes['title'] : '';
		$title_text = trim( wp_strip_all_tags( $title_raw ) );
		$label      = '' !== $title_text ? $title_text : __( 'Table of Contents', 'tocflow' );
		$preset     = self::style_slug_from_attributes( $attributes );
		$class_name = isset( $attributes['className'] ) ? (string) $attributes['className'] : '';
		$classes    = array(
			'tocflow',
			'tocflow--' . $preset,
		);

		/*
		 * Gutenberg Block Styles add is-style-{name} via className, which
		 * get_block_wrapper_attributes() already prints. Shortcode/auto-insert
		 * ($wrap = false) must add the class themselves.
		 */
		if ( ! $wrap || false === strpos( $class_name, 'is-style-' ) ) {
			$classes[] = 'is-style-' . $preset;
		}

		if ( ! empty( $attributes['collapsible'] ) ) {
			$classes[] = 'is-collapsible';
		}
		if ( ! empty( $attributes['collapsedDefault'] ) ) {
			$classes[] = 'is-collapsed';
		}
		if ( ! empty( $attributes['sticky'] ) ) {
			$classes[] = 'is-sticky';
		}
		if ( ! empty( $attributes['highlightActive'] ) || ! empty( $settings['highlight_active'] ) ) {
			$classes[] = 'has-scroll-spy';
		}

		$offset = (int) $settings['scroll_offset'];
		if ( isset( $attributes['scrollOffset'] ) && (int) $attributes['scrollOffset'] >= 0 ) {
			$offset = (int) $attributes['scrollOffset'];
		}

		$class_attr = implode( ' ', array_map( 'sanitize_html_class', $classes ) );
		$style_attr = '--tocflow-offset:' . (int) $offset . 'px';

		if ( $wrap ) {
			$wrapper = get_block_wrapper_attributes(
				array(
					'class'               => $class_attr,
					'aria-label'          => $label,
					'data-tocflow-offset' => (string) $offset,
					'data-tocflow-smooth' => ! empty( $settings['smooth_scroll'] ) ? '1' : '0',
					'style'               => $style_attr,
				)
			);
			$html = '<nav ' . $wrapper . '>';
		} else {
			$html = sprintf(
				'<nav class="%1$s" aria-label="%2$s" data-tocflow-offset="%3$s" data-tocflow-smooth="%4$s" style="%5$s">',
				esc_attr( $class_attr . ' wp-block-tocflow-table-of-contents' ),
				esc_attr( $label ),
				esc_attr( (string) $offset ),
				! empty( $settings['smooth_scroll'] ) ? '1' : '0',
				esc_attr( $style_attr )
			);
		}

		if ( '' !== $title_text ) {
			$html .= '<div class="tocflow__header">';
			$html .= '<p class="tocflow__title">' . esc_html( $title_text ) . '</p>';
			if ( ! empty( $attributes['collapsible'] ) ) {
				$expanded = empty( $attributes['collapsedDefault'] ) ? 'true' : 'false';
				$html    .= '<button type="button" class="tocflow__toggle" aria-expanded="' . esc_attr( $expanded ) . '">';
				$html    .= '<span class="tocflow__visually-hidden">' . esc_html__( 'Toggle table of contents', 'tocflow' ) . '</span>';
				$html    .= '<span class="tocflow__toggle-icon" aria-hidden="true"></span>';
				$html    .= '</button>';
			}
			$html .= '</div>';
		}

		$html .= '<div class="tocflow__body">';
		$html .= self::render_list( $items, $list_tag );
		$html .= '</div>';
		$html .= '</nav>';

		if ( ! empty( $settings['schema_markup'] ) ) {
			$html .= self::schema_json( $items, $post_id );
		}

		return $html;
	}

	/**
	 * JSON-LD ItemList for the outline.
	 *
	 * @param array $items   Normalized headings.
	 * @param int   $post_id Post ID.
	 * @return string
	 */
	public static function schema_json( $items, $post_id ) {
		$permalink = get_permalink( $post_id );
		$list      = array();
		$position  = 1;
		foreach ( $items as $item ) {
			$list[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => $item['text'],
				'url'      => $permalink . '#' . $item['slug'],
			);
			$position++;
		}

		$payload = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'ItemList',
			'name'            => __( 'Table of Contents', 'tocflow' ),
			'itemListElement' => $list,
		);

		return '<script type="application/ld+json">' . wp_json_encode( $payload, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS ) . '</script>';
	}

	/**
	 * Inject matching anchor IDs into core/heading blocks on the front end.
	 *
	 * @param string $block_content Rendered block HTML.
	 * @param array  $block         Parsed block.
	 * @return string
	 */
	public static function add_heading_ids( $block_content, $block ) {
		if ( is_admin() || ! is_singular() || empty( $block['blockName'] ) || 'core/heading' !== $block['blockName'] ) {
			return $block_content;
		}

		if ( ! self::should_inject_ids() ) {
			return $block_content;
		}

		$post_id = get_the_ID();
		if ( ! $post_id ) {
			return $block_content;
		}

		$text = trim( wp_strip_all_tags( $block_content ) );
		if ( '' === $text ) {
			return $block_content;
		}

		if ( self::should_skip( $block, $block_content ) ) {
			return $block_content;
		}

		$headings = self::get_all( $post_id );

		static $pointers = array();
		$pointer         = isset( $pointers[ $post_id ] ) ? $pointers[ $post_id ] : 0;

		if ( ! isset( $headings[ $pointer ] ) ) {
			return $block_content;
		}
		$pointers[ $post_id ] = $pointer + 1;

		$slug = $headings[ $pointer ]['slug'];

		if ( class_exists( 'WP_HTML_Tag_Processor' ) ) {
			$processor = new WP_HTML_Tag_Processor( $block_content );
			while ( $processor->next_tag() ) {
				$tag = $processor->get_tag();
				if ( $tag && preg_match( '/^H[1-6]$/', $tag ) ) {
					if ( null === $processor->get_attribute( 'id' ) ) {
						$processor->set_attribute( 'id', $slug );
					}
					return $processor->get_updated_html();
				}
			}
			return $block_content;
		}

		if ( preg_match( '/<h[1-6][^>]*\sid=/i', $block_content ) ) {
			return $block_content;
		}

		return preg_replace( '/(<h[1-6])(\s|>)/i', '$1 id="' . esc_attr( $slug ) . '"$2', $block_content, 1 );
	}

	/**
	 * Inject IDs only when a TOC will actually be shown.
	 *
	 * @return bool
	 */
	public static function should_inject_ids() {
		$settings = TOCflow_Settings::get();
		if ( 'none' !== $settings['auto_insert'] ) {
			return true;
		}
		$post = get_post();
		if ( $post && has_block( 'tocflow/table-of-contents', $post ) ) {
			return true;
		}
		if ( $post && has_shortcode( $post->post_content, 'tocflow' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Allowed Gutenberg Block Style slugs (block.json "styles").
	 *
	 * @return string[]
	 */
	public static function allowed_style_slugs() {
		return array( 'default', 'minimal', 'boxed', 'underline', 'card' );
	}

	/**
	 * Resolve the active style from className (is-style-*) with a stylePreset fallback.
	 *
	 * @param array $attributes Block or shortcode attributes.
	 * @return string
	 */
	public static function style_slug_from_attributes( $attributes ) {
		$allowed    = self::allowed_style_slugs();
		$class_name = isset( $attributes['className'] ) ? (string) $attributes['className'] : '';
		$preset     = 'default';

		if ( preg_match( '/(?:^|\s)is-style-([a-z0-9-]+)/', $class_name, $matches ) ) {
			$preset = sanitize_key( $matches[1] );
		} elseif ( ! empty( $attributes['stylePreset'] ) ) {
			$preset = sanitize_key( $attributes['stylePreset'] );
		}

		if ( ! in_array( $preset, $allowed, true ) ) {
			return 'default';
		}

		return $preset;
	}
}
