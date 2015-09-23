(function( $ ) {
	'use strict';
	// we create a copy of the WP inline edit and save post function
	var $wp_inline_edit = inlineEditPost.edit;
	// and then we overwrite the function with our own code
	inlineEditPost.edit = function( id ) {

		// "call" the original WP edit function
		// we don't want to leave WordPress hanging
		$wp_inline_edit.apply( this, arguments );

		// now we take care of our business

		// get the post ID
		var $post_id = 0;
		if ( typeof( id ) == 'object' )
			$post_id = parseInt( this.getId( id ) );

		if ( $post_id > 0 ) {

			// define the edit row
			var $edit_row = $( '#edit-' + $post_id );

			// get the values
			var $focusk = $( '#post-' + $post_id + ' .wpseo-focuskw');
			var $title = $( '#post-' + $post_id + ' .wpseo-title');
			var $description = $( '#post-' + $post_id + ' .wpseo-metadesc');

			// populate the release date
			$edit_row.find( 'input[name="yoast_qef[keyword]"]' ).val( $focusk.text() );
			$edit_row.find( 'input[name="yoast_qef[title]"]' ).val( $title.text() );
			$edit_row.find( 'textarea[name="yoast_qef[description]"]' ).val( $description.text() );

		}

	};


})( jQuery );
