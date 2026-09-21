<?php
/**
 * Server-side render for the Table of Contents block.
 *
 * Do not declare functions here — this file is included on every render.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#render
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Block default content.
 * @var WP_Block $block      Block instance.
 *
 * @package TOCguide
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tocguide_post_id = 0;
if ( isset( $block ) && $block instanceof WP_Block && ! empty( $block->context['postId'] ) ) {
	$tocguide_post_id = (int) $block->context['postId'];
}
if ( ! $tocguide_post_id ) {
	$tocguide_post_id = (int) get_the_ID();
}
if ( ! $tocguide_post_id ) {
	return;
}

echo TOCguide_Headings::render_nav( $attributes, $tocguide_post_id, true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- markup is escaped inside render_nav().
