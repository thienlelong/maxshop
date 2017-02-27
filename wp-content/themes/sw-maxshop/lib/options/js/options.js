jQuery(document).ready(function(){
	
	
	if(jQuery('#last_tab').val() == ''){

		jQuery('.ya-opts-group-tab:first').slideDown('fast');
		jQuery('#ya-opts-group-menu li:first').addClass('active');
	
	}else{
		
		tabid = jQuery('#last_tab').val();
		jQuery('#'+tabid+'_section_group').slideDown('fast');
		jQuery('#'+tabid+'_section_group_li').addClass('active');
		
	}
	
	
	jQuery('input[name="'+ya_opts.opt_name+'[defaults]"]').click(function(){
		if(!confirm(ya_opts.reset_confirm)){
			return false;
		}
	});
	
	jQuery('.ya-opts-group-tab-link-a').click(function(){
		relid = jQuery(this).attr('data-rel');
		
		jQuery('#last_tab').val(relid);
		
		jQuery('.ya-opts-group-tab').each(function(){
			if(jQuery(this).attr('id') == relid+'_section_group'){
				jQuery(this).show();
			}else{
				jQuery(this).hide();
			}
			
		});
		
		jQuery('.ya-opts-group-tab-link-li').each(function(){
				if(jQuery(this).attr('id') != relid+'_section_group_li' && jQuery(this).hasClass('active')){
					jQuery(this).removeClass('active');
				}
				if(jQuery(this).attr('id') == relid+'_section_group_li'){
					jQuery(this).addClass('active');
				}
		});
	});
	
	
	
	
	if(jQuery('#ya-opts-save').is(':visible')){
		jQuery('#ya-opts-save').delay(4000).slideUp('slow');
	}
	
	if(jQuery('#ya-opts-imported').is(':visible')){
		jQuery('#ya-opts-imported').delay(4000).slideUp('slow');
	}	
	
	jQuery('input, textarea, select').change(function(){
		jQuery('#ya-opts-save-warn').slideDown('slow');
	});
	
	
	jQuery('#ya-opts-import-code-button').click(function(){
		if(jQuery('#ya-opts-import-link-wrapper').is(':visible')){
			jQuery('#ya-opts-import-link-wrapper').fadeOut('fast');
			jQuery('#import-link-value').val('');
		}
		jQuery('#ya-opts-import-code-wrapper').fadeIn('slow');
	});
	
	jQuery('#ya-opts-import-link-button').click(function(){
		if(jQuery('#ya-opts-import-code-wrapper').is(':visible')){
			jQuery('#ya-opts-import-code-wrapper').fadeOut('fast');
			jQuery('#import-code-value').val('');
		}
		jQuery('#ya-opts-import-link-wrapper').fadeIn('slow');
	});
	
	
	
	
	jQuery('#ya-opts-export-code-copy').click(function(){
		if(jQuery('#ya-opts-export-link-value').is(':visible')){jQuery('#ya-opts-export-link-value').fadeOut('slow');}
		jQuery('#ya-opts-export-code').toggle('fade');
	});
	
	jQuery('#ya-opts-export-link').click(function(){
		if(jQuery('#ya-opts-export-code').is(':visible')){jQuery('#ya-opts-export-code').fadeOut('slow');}
		jQuery('#ya-opts-export-link-value').toggle('fade');
	});
	
	

	
	
	
});