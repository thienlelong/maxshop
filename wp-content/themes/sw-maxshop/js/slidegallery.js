(function($) {
			jQuery(document).ready(function($) {
				//console.log(yaSlideshow);
				$.each(yaSlideshow, function(key, value) {
					$('#yaSlideshow-'+key).carousel({
						interval: value['interval']
					});
				});
			});
})(jQuery);
			//-->
	