( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetWPSierraPosts = function() {

    if ($('.masonry-container')[0]) {
        var container = document.querySelector('.masonry-container');
				//container.imagesLoaded( function(){
	        var msnry = new Masonry( container, {
	          itemSelector: '.item',
	          columnWidth: $('.masonry-container').find('.item')[1],
	          horizontalOrder: true,
	        });
      //});
    }
	};

	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/sierra-posts.default', WidgetWPSierraPosts );
	} );
} )( jQuery );
