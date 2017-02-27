/*
 *
 * YA_Options_radio_img function
 * Changes the radio select option, and changes class on images
 *
 */
function ya_radio_img_select(relid, labelclass){
	jQuery(this).prev('input[type="radio"]').prop('checked');

	jQuery('.ya-radio-img-'+labelclass).removeClass('ya-radio-img-selected');	
	
	jQuery('label[for="'+relid+'"]').addClass('ya-radio-img-selected');
}//function