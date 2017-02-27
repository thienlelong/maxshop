jQuery(document).ready(function($){
	/*
	 *
	 * YA_Options_upload function
	 * Adds media upload functionality to the page
	 *
	 */
	 
	 var header_clicked = false;
	jQuery("img[src='']").attr("src", ya_upload.url);
	
	jQuery('.ya-opts-upload').click(function() {
		header_clicked = true;
		formfield = jQuery(this).attr('rel-id');
		preview = jQuery(this).prev('img');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	
	jQuery('.ya-menu-upload').click(function() {
		header_clicked = true;
		formfield = jQuery(this).attr('rel-id');
		preview = jQuery(this).prev('img');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	
	
	// Store original function
	window.original_send_to_editor = window.send_to_editor;
	
	
	window.send_to_editor = function(html) {
		if (header_clicked) {
			if (jQuery('img', html).attr('src')) {
				imgurl = jQuery('img', html).attr('src');
			} else imgurl = jQuery(html).attr('src');
			
			jQuery('#' + formfield).val(imgurl);
			jQuery('#' + formfield).next().fadeIn('slow');
			jQuery('#' + formfield).next().next().fadeOut('slow');
			jQuery('#' + formfield).next().next().next().fadeIn('slow');
			jQuery(preview).attr('src' , imgurl);
			tb_remove();
			header_clicked = false;
		} else {
			window.original_send_to_editor(html);
		}
	}
	
	jQuery('.ya-opts-upload-remove').click(function(){
		$relid = jQuery(this).attr('rel-id');
		jQuery('#'+$relid).val('');
		jQuery(this).prev().fadeIn('fast');
		jQuery(this).prev().prev().fadeOut('fast', function(){jQuery(this).attr("src", ya_upload.url);});
		jQuery(this).fadeOut('slow');
	});
	
	jQuery('.ya-menu-upload-remove').click(function(){
		$relid = jQuery(this).attr('rel-id');
		jQuery('#'+$relid).val('');
		jQuery(this).prev().fadeIn('fast');
		jQuery(this).prev().prev().fadeOut('fast', function(){jQuery(this).attr("src", ya_menu_upload.url);});
		jQuery(this).fadeOut('slow');
	});
});
	jQuery('.menu-advance-href').each(function(){
		var $advance_id = jQuery(this).data('id');
		jQuery(this).click(function(){
			jQuery('#' + $advance_id).slideToggle();
		});
	});