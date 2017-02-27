<?php

/**
 * Adds WP_Customize_Textarea_Control
 */

if ( class_exists( 'WP_Customize_Control' ) ) {
	class WP_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

    	public function render_content() { ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
  	}
}

/**
 * Adds sections to the customizer
 * @param WP_Customize_Control $wp_customize
 */
function ya_customize_register( $wp_customize ){

	$priority = 200;
	$sections = array();
	$ya_options = ya_options();	
	$i = 0;
	foreach ( $ya_options->sections as $section) {
		
		if ( isset($section['fields']) && is_array($section['fields']) ) {
			
			foreach ($section['fields'] as $field ){
				
				$customize = $field['id'].'_customize_allow';
				if ($ya_options->get($customize)) {
					
					if ( isset($field['options']) ) $field['choices'] = $field['options'];
					
					if ($field['type'] == 'upload') $field['type'] = 'image';
					
					if ($field['type'] == 'radio_img') {
						$field['type'] = 'select';
						$field['choices'] = array();
		
						foreach ( $field['options'] as $key => $choices ) {
							$field['choices'][$key] = $choices['title']; 
						}
					}
					
					$field['label'] = $field['title'];
					$field['section'] = sanitize_title($section['title']);
					$field['settings'] = $ya_options->args['opt_name'].'['.$field['id'].']';
					$field['priority'] = $priority++;
					$sections[$i]['fields'][] = $field;
				}
			} 
			
			if ( isset($sections[$i]['fields']) ) {
				$sections[$i]['title'] = $section['title'];
				$sections[$i]['priority'] = $priority++;
				$sections[$i]['capability'] = 'edit_theme_options';
				$i++;
			}
		}
	}
	
	foreach ( $sections as $section ) {
			
		// Add Section
		$wp_customize->add_section( sanitize_title($section['title']), $section );
		
		foreach ($section['fields'] as $field ){ 

			//Add Setting
			$wp_customize->add_setting( 
					$ya_options->args['opt_name'].'['.$field['id'].']', 
					array(
						'default'  	=> $ya_options->get($field['id']),
    					'type' 		=> 'option',
						'transport' => 'postMessage',
						'capability' => 'edit_theme_options',
						'sanitize_callback' => 'customize_option'
					)
				);
				
			// Add Control
			switch( $field['type'] ){
				case 'color':
					$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $field['id'], $field ) );
					break;
				case 'image':
					$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $field['id'], $field ) );
					break;
				case 'textarea':
					$wp_customize->add_control( new WP_Customize_Textarea_Control( $wp_customize, $field['id'], $field ) );
					break;
				default:
					$wp_customize->add_control( $field['id'], $field );
			}
			//$wp_customize->get_setting($ya_options->args['opt_name'].'['.$field['id'].']')->transport = 'postMessage';
		}		
	}
	$wp_customize -> get_setting( 'blogname' )-> transport = 'postMessage';
	$wp_customize -> get_setting( 'blogdescription' )-> transport = 'postMessage';
}
add_action( 'customize_register', 'ya_customize_register' );
