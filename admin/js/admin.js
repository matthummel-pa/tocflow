/**
 * TOCguide settings-page admin JS.
 *
 * Handles:
 *  – Colour text ↔ swatch sync for design settings.
 *  – Show/hide Reading Guide sub-options when guide mode is toggled.
 *  – Show/hide citation format when citations are toggled.
 *
 * Vanilla JS, no jQuery, no build step required.
 */
( function () {
	'use strict';

	/**
	 * Sync a hex text input with a companion colour swatch (input[type=color]).
	 * Adds a clear link to reset to empty (= "not set").
	 */
	function initColorFields() {
		document
			.querySelectorAll( '.tocguide-color-field' )
			.forEach( function ( wrap ) {
				const text = wrap.querySelector( 'input[type="text"]' );
				const swatch = wrap.querySelector( 'input[type="color"]' );
				if ( ! text || ! swatch ) {
					return;
				}
				const clear = wrap.querySelector( '.tocguide-color-clear' );

				// Text → swatch (only when value is a valid 6-digit hex).
				text.addEventListener( 'input', function () {
					const v = text.value.trim();
					if ( /^#[0-9a-fA-F]{6}$/.test( v ) ) {
						swatch.value = v;
					}
					// 3-digit shorthand → expand for swatch.
					if ( /^#[0-9a-fA-F]{3}$/.test( v ) ) {
						swatch.value =
							'#' +
							v[ 1 ].repeat( 2 ) +
							v[ 2 ].repeat( 2 ) +
							v[ 3 ].repeat( 2 );
					}
				} );

				// Swatch → text.
				swatch.addEventListener( 'input', function () {
					text.value = swatch.value;
					text.dispatchEvent(
						new Event( 'input', { bubbles: true } )
					);
				} );

				// Clear → empty (= use built-in styles).
				if ( clear ) {
					clear.addEventListener( 'click', function ( e ) {
						e.preventDefault();
						text.value = '';
						swatch.value = '#ffffff';
						text.dispatchEvent(
							new Event( 'input', { bubbles: true } )
						);
					} );
				}
			} );
	}

	/**
	 * Show/hide a dependent container based on a checkbox state.
	 *
	 * @param {string} triggerId ID of the controlling checkbox.
	 * @param {string} targetId  ID of the container to show/hide.
	 */
	function syncConditional( triggerId, targetId ) {
		const trigger = document.getElementById( triggerId );
		const target = document.getElementById( targetId );
		if ( ! trigger || ! target ) {
			return;
		}
		function update() {
			target.style.display = trigger.checked ? '' : 'none';
		}
		trigger.addEventListener( 'change', update );
		update();
	}

	/**
	 * Paint the settings preview from the current form values.
	 * Hidden sections stay in the form, so every tab can update it.
	 */
	function refreshPreview() {
		const nav = document.getElementById( 'tocguide-preview-nav' );
		const form = document.querySelector( '.tocguide-admin__form' );
		if ( ! nav || ! form ) {
			return;
		}

		const field = function ( key ) {
			return form.querySelector(
				'[name="tocguide_settings[' + key + ']"]'
			);
		};
		const value = function ( key ) {
			const el = field( key );
			return el ? el.value.trim() : '';
		};
		const checked = function ( key ) {
			const el = field( key );
			return !! ( el && el.checked );
		};

		const stacks =
			window.tocguideAdmin && window.tocguideAdmin.fontStacks
				? window.tocguideAdmin.fontStacks
				: {
						system: 'system-ui, "Segoe UI", sans-serif',
						geometric:
							'"Avenir Next", "Segoe UI", system-ui, sans-serif',
						neutral: 'Arial, Helvetica, sans-serif',
						mono: 'ui-monospace, Menlo, Consolas, monospace',
				  };

		const vars = {
			design_bg_color: '--tocguide-bg',
			design_text_color: '--tocguide-color',
			design_link_color: '--tocguide-link-color',
			design_link_hover: '--tocguide-link-hover',
			design_accent_color: '--tocguide-accent',
			design_marker_color: '--tocguide-marker-bg',
			design_marker_text: '--tocguide-marker-color',
			design_font_size: '--tocguide-font-size',
			design_font_weight: '--tocguide-font-weight',
			design_title_size: '--tocguide-title-size',
			design_title_weight: '--tocguide-title-weight',
			design_line_height: '--tocguide-line-height',
			design_letter_spacing: '--tocguide-letter-spacing',
			design_item_gap: '--tocguide-item-gap',
			design_border_width: '--tocguide-border-width',
			design_border_color: '--tocguide-border-color',
			design_border_style: '--tocguide-border-style',
			design_border_radius: '--tocguide-radius',
			design_padding: '--tocguide-padding',
			design_title_color: '--tocguide-title-color',
			design_icon_color: '--tocguide-icon-color',
			design_text_transform: '--tocguide-text-transform',
		};

		Object.keys( vars ).forEach( function ( key ) {
			const raw = value( key );
			if ( '' === raw ) {
				nav.style.removeProperty( vars[ key ] );
			} else {
				nav.style.setProperty( vars[ key ], raw );
			}
		} );

		const family = value( 'design_font_family' );
		let stack = stacks[ family ] || '';
		if ( ! stack && checked( 'exclude_theme_styles' ) && stacks.system ) {
			stack = stacks.system;
		}
		if ( stack ) {
			nav.style.setProperty( '--tocguide-font-family', stack );
		} else {
			nav.style.removeProperty( '--tocguide-font-family' );
		}

		const styles = [ 'default', 'minimal', 'boxed', 'underline', 'card' ];
		const style =
			styles.indexOf( value( 'auto_style' ) ) >= 0
				? value( 'auto_style' )
				: 'default';
		styles.forEach( function ( name ) {
			nav.classList.remove( 'is-style-' + name, 'tocguide--' + name );
		} );
		nav.classList.add( 'is-style-' + style, 'tocguide--' + style );

		nav.classList.toggle(
			'is-theme-isolated',
			checked( 'exclude_theme_styles' )
		);
		nav.classList.toggle( 'is-compact', checked( 'auto_compact' ) );
		nav.classList.toggle( 'is-no-markers', checked( 'auto_hide_markers' ) );

		const marker = value( 'design_marker_style' );
		nav.classList.toggle( 'is-marker-square', 'square' === marker );
		nav.classList.toggle( 'is-marker-plain', 'plain' === marker );

		const shadow = value( 'design_shadow' );
		nav.classList.toggle( 'has-shadow-soft', 'soft' === shadow );
		nav.classList.toggle( 'has-shadow-medium', 'medium' === shadow );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		initColorFields();
		refreshPreview();

		const form = document.querySelector( '.tocguide-admin__form' );
		if ( form ) {
			form.addEventListener( 'input', refreshPreview );
			form.addEventListener( 'change', refreshPreview );
		}

		// Reading Guide sub-options depend on guide mode being on.
		syncConditional( 'tocguide-auto-guide-mode', 'tocguide-guide-subopts' );

		// Citation format selector depends on citations being on.
		syncConditional(
			'tocguide-auto-show-citations',
			'tocguide-citation-style-row'
		);
	} );
} )();
