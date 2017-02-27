/**
 * Widget Options
 */

(function($){
	$(document).on('change', '.advanced-opt .toggle > input', function(e){
		e.preventDefault();
		if ( $(this).is(':checked') ){
			$(this).parents('.advanced-opt').addClass('on');
		} else {
			$(this).parents('.advanced-opt').removeClass('on');
		}
	});
	
	$(document).on('change', '.advanced-opt .adoptions-display-select', function(e){
		e.preventDefault();
		var parent = $(this).parents('.advanced-opt');
		if ($(this).val() == 'all') {
			$('.adoptions-display-content', parent).css('display','none');
		} else {
			$('.adoptions-display-content', parent).css('display','block');
		}
	});
	
})(jQuery);