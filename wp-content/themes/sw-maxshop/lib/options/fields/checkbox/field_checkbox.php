<?php
class YA_Options_checkbox extends YA_Options{
	
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
		
		$class = (isset($this->field['class']))?$this->field['class']:'';
		
		echo ($this->field['desc'] != '')?' <label>':'';
		
		echo '<input type="checkbox" id="'.esc_attr( $this->field['id'] ).'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="1" class="'.$class.'" '.checked($this->value, '1', false).'/>';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' '.esc_html( $this->field['desc'] ).'</label>':'';
		
	}//function
	
	
//	public function getCpanelHtml(){
//		$this->cpanel_tpl = '<label class="checkbox"> %1$s %2$s </label>';
//		
//		$class = (isset($this->field['class']))?$this->field['class']:'';
//		$input = '<input type="checkbox" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="1" class="'.$class.'" '.checked($this->value, '1', false).'/>';
//		
//		return sprintf($this->cpanel_tpl, $input, $this->field['title']);
//	}
	
	public function getCpanelHtml(){
		echo ' <div class="control-group">';
		echo '<label class="control-label">'.esc_html( $this->field['title'] ).'</label>';
		echo '<div class="controls">';
		$this->render();
		echo '</div></div>';
	}
}//class
?>