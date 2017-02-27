(function($) {
  "use strict";
  var $ya_event = ya_flexgallery.event;
  var $ya_event_thumbnail = ya_flexgallery.evthumbnail;
	jQuery(document).ready(function(){
	  jQuery("#flex-thumbnail").flexslider({
		animation: 'slide',
		controlNav: false,
		itemMargin: 10,
		animationLoop: false,
		slideshow: false,
		itemWidth: 113,				
		asNavFor: "#flexslider-gallery"
	  });

	  jQuery("#flexslider-gallery").flexslider({
		animation:$ya_event,
		controlNav: false,
		animationLoop: true,
		slideshow: true,
		sync: "#flex-thumbnail",
		start: function(slider){
		  jQuery("body").removeClass("loading");
		}
	  });
	  jQuery('.gallery-images').removeClass('slider-loading');
	});
})(jQuery);