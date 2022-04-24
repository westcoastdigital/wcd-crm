(function( $ )
{
	'use strict';

	jQuery( function( $ )
	{
		$( '[name*="select_post"]' ).change( function()
		{
			var $this	 = $(this),
				$scope	 = $this.parents( '.rwmb-clone' ),
				$post_id = $this.val();

			$.get()

		} );
	} );

} )( jQuery );