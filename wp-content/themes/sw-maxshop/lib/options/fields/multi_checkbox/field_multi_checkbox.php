<?php
class YA_Options_multi_checkbox extends YA_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since YA_Options 1.0
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		//$this->render();
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since YA_Options 1.0
	*/
	function render(){
		
		$class = (isset($this->field['class']))?esc_attr( $this->field['class'] ):'regular-text';
		
		echo '<fieldset>';
			
			foreach($this->field['options'] as $k => $v){
				
				$this->value[$k] = (isset($this->value[$k]))?$this->value[$k]:'';
				
				echo '<label for="'.esc_attr( $this->field['id'] ).'_'.array_search($k,array_keys($this->field['options'])).'">';
				echo '<input type="checkbox" id="'.esc_attr( $this->field['id'] ).'_'.array_search($k,array_keys($this->field['options'])).'" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$k.']" '.$class.' value="1" '.checked($this->value[$k], '1', false).'/>';
				echo ' '.esc_html( $v ).'</label><br/>';
				
			}//foreach

		echo (isset($this->field['desc']) && !empty($this->field['desc']))?'<span class="description">'.$this->field['desc'].'</span>':'';
		
		echo '</fieldset>';
		
	}//function
	
}//class
?>