/**
 * TOCflow settings-page admin JS.
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
			.querySelectorAll( '.tocflow-color-field' )
			.forEach( function ( wrap ) {
				const text = wrap.querySelector( 'input[type="text"]' );
				const swatch = wrap.querySelector( 'input[type="color"]' );
				if ( ! text || ! swatch ) {
					return;
				}
				const clear = wrap.querySelector( '.tocflow-color-clear' );

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
				} );

				// Clear → empty (= use built-in styles).
				if ( clear ) {
					clear.addEventListener( 'click', function ( e ) {
						e.preventDefault();
						text.value = '';
						swatch.value = '#ffffff';
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

	document.addEventListener( 'DOMContentLoaded', function () {
		initColorFields();

		// Reading Guide sub-options depend on guide mode being on.
		syncConditional( 'tocflow-auto-guide-mode', 'tocflow-guide-subopts' );

		// Citation format selector depends on citations being on.
		syncConditional(
			'tocflow-auto-show-citations',
			'tocflow-citation-style-row'
		);
	} );
} )();
