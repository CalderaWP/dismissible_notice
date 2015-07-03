jQuery(document).ready(function($) {
	// Save dismiss state
	$( '.notice.is-dismissible' ).on('click', '.notice-dismiss', function ( event ) {
		event.preventDefault();
		var $this = $(this);
		if( ! $this.parent().data( 'key' ) ){
			return;
		}
		$.post( ajaxurl, {
			action: "caldera_warnings_dismissible_notice",
			url: ajaxurl,
			nag: $this.parent().data( 'key' ),
			nonce: caldera_commonL10n.nonce || ''
		});

	});

	// Make notices dismissible - backward compatabity -4.2 - copied from WordPress 4.2
	$( '.notice.is-dismissible' ).each( function() {
		if( caldera_commonL10n.wp_version ){
			return;
		}

		var $this = $( this ),
			$button = $( '<button type="button" class="notice-dismiss"><span class="screen-reader-text"></span></button>' ),
			btnText = caldera_commonL10n.dismiss || '';

		// Ensure plain text
		$button.find( '.screen-reader-text' ).text( btnText );

		$this.append( $button );

		$button.on( 'click.wp-dismiss-notice', function( event ) {
			event.preventDefault();
			$this.fadeTo( 100 , 0, function() {
				$(this).slideUp( 100, function() {
					$(this).remove();
				});
			});
		});
	});
});
