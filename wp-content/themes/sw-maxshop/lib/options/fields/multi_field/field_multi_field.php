<?php
class YA_Options_multi_field extends YA_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since YA_Options 1.0.5
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		if (is_array($value)) {
			foreach ($value as $k => $val) {
				if (isset($val['style-name']) ) {
					$v = trim($val['style-name']);
					if ( !empty($v)) $this->value[$k] = $val;
				}
			}
		}
		
		//$this->render();
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since YA_Options 1.0.5
	*/
	function render(){
		
		$parent->args['opt_name'] = $this->args['opt_name'].'['.$this->field['id'].'][0]' ;
		$class = (isset($this->field['class']))?esc_attr( $this->field['class'] ):'regular-text';
		
		echo '<table id="'.esc_attr( $this->field['id'] ).'-table">';
		
		if(isset($this->value) && is_array($this->value)){
			foreach($this->value as $k => $value){
				foreach ($this->field['sub_fields'] as $field ) { 
					echo '<tr>';
					echo '<td>'.esc_html( $field['title'] ).'</td><td>';
					$class_field = 'YA_Options_'.$field['type'];
					$render = new $class_field($field, $value[$field['id']], $parent);
					$render->render();
					echo '</td></tr>';
				}
			}//foreach
		}else{
			if ( isset($this->field['sub_fields']) && is_array($this->field['sub_fields']) ){
				foreach ($this->field['sub_fields'] as $field ) { 
					echo '<tr>';
					echo '<td>'.esc_html( $field['title'] ).'</td><td>';
					$class_field = 'YA_Options_'.$field['type'];
					$render = new $class_field($field, '', $parent);
					$render->render();
					echo '</td></tr>';
				}
			}
			//echo '<li><input type="text" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].'][]" value="" class="'.$class.'" /> <a href="javascript:void(0);" class="ya-opts-multi-text-remove">'.__('Remove', 'maxshop').'</a></li>';
		
		}//if
		
		//echo '<li style="display:none;"><input type="text" id="'.$this->field['id'].'" name="" value="" class="'.$class.'" /> <a href="javascript:void(0);" class="ya-opts-multi-text-remove">'.__('Remove', 'maxshop').'</a></li>';
		
		echo '</table>';
		
		echo '<a href="javascript:void(0);" class="ya-opts-multi-field-add" rel-id="'.esc_attr( $this->field['id'] ).'-table" rel-name="'.$this->args['opt_name'].'['.$this->field['id'].'][]">'.__('Add More', 'maxshop').'</a><br/>';
		
		//echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';
		
	}//function
	
	
	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since YA_Options 1.0.5
	*/
	function enqueue(){
		
		wp_enqueue_script(
			'ya-opts-field-multi-field-js', 
			YA_OPTIONS_URL.'fields/multi_field/field_multi_field.js', 
			array('jquery'),
			time(),
			true
		);
		
	}//function
	
}//class
?>