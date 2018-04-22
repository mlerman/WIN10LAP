

/*jQuery anonymous function calls*/
(function($) {

/* ========================================================================== */

/* Documetn Ready */

$(function() {

/* Magnific Popup Lightbox */

if( $('.qt-photo-gallery').length ){

	$('.qt-photo-gallery-item').magnificPopup({
	  delegate: 'a', // child items selector, by clicking on it popup will open
	  type: 'image',
	  gallery: {
	  	enabled:true
	  }
	  // other options
	});

}


/* End: Document Ready */

});


/* ========================================================================== */

})(jQuery);



