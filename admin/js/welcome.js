/**
 * Dismiss the welcome notice via admin-ajax.php.
 */
( function () {
	'use strict';

	document.addEventListener( 'click', function ( event ) {
		const notice =
			event.target.closest && event.target.closest( '.tocflow-welcome' );
		if (
			! notice ||
			! event.target.classList.contains( 'notice-dismiss' )
		) {
			return;
		}
		const nonce = notice.getAttribute( 'data-nonce' );
		const fd = new FormData();
		fd.append( 'action', 'tocflow_dismiss_welcome' );
		fd.append( 'nonce', nonce );
		if ( typeof window.ajaxurl === 'undefined' ) {
			return;
		}
		fetch( window.ajaxurl, {
			method: 'POST',
			credentials: 'same-origin',
			body: fd,
		} );
	} );
} )();
