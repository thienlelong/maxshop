<?php


if ( !class_exists('YA_Config')):
class YA_Config {
	public static $instance = null;
	protected $vars = array();
	public function __construct(){

	}
	
	public function __get($field){
		if ( array_key_exists($field, $_COOKIE) ){
			return $_COOKIE[$field];
		} else if ( array_key_exists($field, $this->vars) ){
			return $this->vars[$field];
		}
		return null;
	}
	
	public function gets(){
		$cookie_vars = array();
		foreach($this->vars as $field => $val){
			if (array_key_exists($field, $_COOKIE)){
				$cookie_vars[$field] = $_COOKIE[$field];
			}
		}
		return array_merge($this->vars, $cookie_vars);
	}
	
	public function __set($field, $val){
		$this->vars[$field] = $val;
	}
	
	public static function setVariables($vars){
		if ( is_null(self::$instance) ){
			self::$instance = new YA_Config();
			//self::$instance->vars = (array)$vars;
			foreach ( (array)$vars as $field => $val ){
				self::$instance->$field = $val;
			}
		}
		return self::$instance;
	}
}

endif;

if ( !class_exists('YA_Widget') ):

abstract class YA_Widget extends WP_Widget{
	protected $base_path = null;
	protected $base_tpl_path = null;
	protected $override_tpl_path = null;
	protected $tpls = null;
	
	public function __construct($id_base = false, $name, $widget_options = array(), $control_options = array()){
		parent::__construct($id_base, $name, $widget_options, $control_options);
		$this->init();
	}
	
	protected function init(){
		$this->base_path = dirname(__FILE__);
		$this->base_tpl_path = apply_filters('ya_widget_template_base', $this->base_path.'/widgets/'.$this->id_base.'/tmpl');
		$this->override_tpl_path = apply_filters('ya_widget_override_base', get_template_directory().'/widgets/'.$this->id_base);
	}
	
	/**
	 * Scans a directory for files of a certain extension.
	 *
	 * @since 3.4.0
	 * @access private
	 *
	 * @param string $path Absolute path to search.
	 * @param mixed  Array of extensions to find, string of a single extension, or null for all extensions.
	 * @param int $depth How deep to search for files. Optional, defaults to a flat scan (0 depth). -1 depth is infinite.
	 * @param string $relative_path The basename of the absolute path. Used to control the returned path
	 * 	for the found files, particularly when this function recurses to lower depths.
	 */
	protected function scandir( $path, $extensions = null, $depth = 0, $relative_path = '' ) {
		if ( ! is_dir( $path ) )
			return false;
	
		if ( $extensions ) {
			$extensions = (array) $extensions;
			$_extensions = implode( '|', $extensions );
		}
	
		$relative_path = trailingslashit( $relative_path );
		if ( '/' == $relative_path )
			$relative_path = '';
	
		$results = scandir( $path );
		$files = array();
	
		foreach ( $results as $result ) {
			if ( '.' == $result[0] )
				continue;
			if ( is_dir( $path . '/' . $result ) ) {
				if ( ! $depth || 'CVS' == $result )
					continue;
				$found = self::scandir( $path . '/' . $result, $extensions, $depth - 1 , $relative_path . $result );
				$files = array_merge_recursive( $files, $found );
			} elseif ( ! $extensions || preg_match( '~\.(' . $_extensions . ')$~', $result ) ) {
				$files[ $relative_path . $result ] = $path . '/' . $result;
			}
		}
	
		return $files;
	}
	
	public function ya_trim_words( $text, $num_words = 30, $more = null ) {
		$text = strip_shortcodes( $text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		return wp_trim_words($text, $num_words, $more);
	}
	
	
	protected function getTemplatePath($tpl='default', $type=''){
		$file = '/'.$tpl.$type.'.php';
		if ( file_exists( $this->override_tpl_path.$file ) ){
			return $this->override_tpl_path.$file;
		}
		if ( file_exists( $this->base_tpl_path.$file ) ){
			return $this->base_tpl_path.$file;
		}
		return $tpl=='default' ? false : $this->getTemplatePath('default', $type);
	}
		
	protected function getTemplates(){
		if ( is_null($this->tpls) ){
			$has_default = false;
			if ( $files = $this->scandir($this->override_tpl_path, 'php') ){
				$this->tpls['ov'] = array();
				foreach ( $files as $n => $p ){
					if ( preg_match('/_/', $n) ) continue;
					$bn = basename($n, '.php');
					$tpl = strtr($bn, '-', ' ');
					$tpl = ucwords($tpl);
					
					$this->tpls['ov'][$bn] = $tpl;
				}
				$has_default = isset($this->tpls['ov']['default']);
			}
			
			if ( $files = $this->scandir($this->base_tpl_path, 'php') ){
				$this->tpls['df'] = array();
				foreach ( $files as $n => $p ){
					if ( preg_match('/_/', $n) ) continue;
					$bn = basename($n, '.php');
					$tpl = strtr($bn, '-', ' ');
					$tpl = ucwords($tpl);
						
					$this->tpls['df'][$bn] = $tpl;
				}
				$has_default = $has_default || isset($this->tpls['df']['default']);
			}
			
			if ( !$has_default ){
				$this->tpls['df']['default'] = 'Default';
				try{
					$default_tpl = $this->base_tpl_path.'/default.php';
					mkdir( dirname( $default_tpl ), 0755, true );
					global $wp_filesystem;
					$wp_filesystem->put_contents($default_tpl, '<?php  ?>', 644);
				} catch(Exception $e){}
			}
		}
		
		return $this->tpls;
	}
	
	public function widget_template_select( $field_name, $opts = array(), $field_value = null ){
		$default_options = array(
				'multiple' => false,
				'disabled' => false,
				'size' => 5,
				'class' => 'widefat',
				'required' => false,
				'autofocus' => false,
				'form' => false,
		);
		$opts = wp_parse_args($opts, $default_options);
	
		if ( (is_string($opts['multiple']) && strtolower($opts['multiple'])=='multiple') || (is_bool($opts['multiple']) && $opts['multiple']) ){
			$opts['multiple'] = 'multiple';
			if ( !is_numeric($opts['size']) ){
				if ( intval($opts['size']) ){
					$opts['size'] = intval($opts['size']);
				} else {
					$opts['size'] = 5;
				}
			}
		} else {
			// is not multiple
			unset($opts['multiple']);
			unset($opts['size']);
			if (is_array($field_value)){
				$field_value = array_shift($field_value);
			}
		}
	
		if ( (is_string($opts['disabled']) && strtolower($opts['disabled'])=='disabled') || is_bool($opts['disabled']) && $opts['disabled'] ){
			$opts['disabled'] = 'disabled';
		} else {
			unset($opts['disabled']);
		}
	
		if ( (is_string($opts['required']) && strtolower($opts['required'])=='required') || (is_bool($opts['required']) && $opts['required']) ){
			$opts['required'] = 'required';
		} else {
			unset($opts['required']);
		}
	
		if ( !is_string($opts['form']) ) unset($opts['form']);
	
		if ( !isset($opts['autofocus']) || !$opts['autofocus'] ) unset($opts['autofocus']);
	
		$opts['id'] = $this->get_field_id($field_name);
	
		$opts['name'] = $this->get_field_name($field_name);
	
		$select_attributes = '';
		foreach ( $opts as $an => $av){
			$select_attributes .= "{$an}=\"{$av}\" ";
		}
	
		$templates = $this->getTemplates();
		if (!$templates) return '';
		$all_templates = array_key_exists('ov', $templates) ? array_keys($templates['ov']) : array();
		if ( array_key_exists('df', $templates) ){
			foreach ($templates['df'] as $tpl => $lb) $all_templates[] = $tpl;
		}
		$is_valid_field_value = is_string($field_value) && in_array($field_value, $all_templates);
		if (!$is_valid_field_value && is_array($field_value)){
			$intersect_values = array_intersect($field_value, $all_templates);
			$is_valid_field_value = count($intersect_values) > 0;
		}
		if (!$is_valid_field_value){
			$field_value = 'default';
		}
	
		$select_html = '<select ' . $select_attributes . '>';
		if ( array_key_exists('ov', $templates) && count($templates['ov']) ){
			$select_html .= '<optgroup label="'. __('Override by Theme', 'maxshop') .'">';
			foreach ($templates['ov'] as $name => $label) {
				$select_html .= '<option value="' . $name . '"';
				if ($name == $field_value || (is_array($field_value)&&in_array($name, $field_value))){ $select_html .= ' selected="selected"';}
				$select_html .=  '>'.$label.'</option>';
			};
			$select_html .= '</optgroup>';
		}
		if ( array_key_exists('df', $templates) && count($templates['df']) ){
			$select_html .= '<optgroup label="'. __('Default Template', 'maxshop') .'">';
			foreach ($templates['df'] as $name => $label) {
				$select_html .= '<option value="' . $name . '"';
				if ($name == $field_value || (is_array($field_value)&&in_array($name, $field_value))){ $select_html .= ' selected="selected"'; }
				if (array_key_exists('ov', $templates) && array_key_exists($name, $templates['ov'])){ $select_html .= ' disabled="disabled"'; }
				$select_html .=  '>'.$label.'</option>';
			};
			$select_html .= '</optgroup>';
		}
		$select_html .= '</select>';
		return $select_html;
	}
	
	public function category_select( $field_name, $opts = array(), $field_value = null ){
		$default_options = array(
				'multiple' => false,
				'disabled' => false,
				'size' => 5,
				'class' => 'widefat',
				'required' => false,
				'autofocus' => false,
				'form' => false,
		);
		$opts = wp_parse_args($opts, $default_options);
	
		if ( (is_string($opts['multiple']) && strtolower($opts['multiple'])=='multiple') || (is_bool($opts['multiple']) && $opts['multiple']) ){
			$opts['multiple'] = 'multiple';
			if ( !is_numeric($opts['size']) ){
				if ( intval($opts['size']) ){
					$opts['size'] = intval($opts['size']);
				} else {
					$opts['size'] = 5;
				}
			}
		} else {
			// is not multiple
			unset($opts['multiple']);
			unset($opts['size']);
			if (is_array($field_value)){
				$field_value = array_shift($field_value);
			}
			if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
				unset($opts['allow_select_all']);
				$allow_select_all = '<option value="0">All Categories</option>';
			}
		}
	
		if ( (is_string($opts['disabled']) && strtolower($opts['disabled'])=='disabled') || is_bool($opts['disabled']) && $opts['disabled'] ){
			$opts['disabled'] = 'disabled';
		} else {
			unset($opts['disabled']);
		}
	
		if ( (is_string($opts['required']) && strtolower($opts['required'])=='required') || (is_bool($opts['required']) && $opts['required']) ){
			$opts['required'] = 'required';
		} else {
			unset($opts['required']);
		}
	
		if ( !is_string($opts['form']) ) unset($opts['form']);
	
		if ( !isset($opts['autofocus']) || !$opts['autofocus'] ) unset($opts['autofocus']);
	
		$opts['id'] = $this->get_field_id($field_name);
	
		$opts['name'] = $this->get_field_name($field_name);
		if ( isset($opts['multiple']) ){
			$opts['name'] .= '[]';
		}
		$select_attributes = '';
		foreach ( $opts as $an => $av){
			$select_attributes .= "{$an}=\"{$av}\" ";
		}
		
		$categories = get_categories();
		// if (!$templates) return '';
		$all_category_ids = array();
		foreach ($categories as $cat) $all_category_ids[] = (int)$cat->cat_ID;
		
		$is_valid_field_value = is_numeric($field_value) && in_array($field_value, $all_category_ids);
		if (!$is_valid_field_value && is_array($field_value)){
			$intersect_values = array_intersect($field_value, $all_category_ids);
			$is_valid_field_value = count($intersect_values) > 0;
		}
		if (!$is_valid_field_value){
			$field_value = '0';
		}
	
		$select_html = '<select ' . $select_attributes . '>';
		if (isset($allow_select_all)) $select_html .= $allow_select_all;
		foreach ($categories as $cat){
			$select_html .= '<option value="' . $cat->cat_ID . '"';
			if ($cat->cat_ID == $field_value || (is_array($field_value)&&in_array($cat->cat_ID, $field_value))){ $select_html .= ' selected="selected"';}
			$select_html .=  '>'.$cat->name.'</option>';
		}
		$select_html .= '</select>';
		return $select_html;
	}
	public function product_select( $field_name, $opts = array(), $field_value = null ){
		$default_options = array(
				'multiple' => false,
				'disabled' => false,
				'size' => 5,
				'class' => 'widefat',
				'required' => false,
				'autofocus' => false,
				'form' => false,
		);
		$opts = wp_parse_args($opts, $default_options);
	
		if ( (is_string($opts['multiple']) && strtolower($opts['multiple'])=='multiple') || (is_bool($opts['multiple']) && $opts['multiple']) ){
			$opts['multiple'] = 'multiple';
			if ( !is_numeric($opts['size']) ){
				if ( intval($opts['size']) ){
					$opts['size'] = intval($opts['size']);
				} else {
					$opts['size'] = 5;
				}
			}
		} else {
			// is not multiple
			unset($opts['multiple']);
			unset($opts['size']);
			if (is_array($field_value)){
				$field_value = array_shift($field_value);
			}
			if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
				unset($opts['allow_select_all']);
				$allow_select_all = '<option value="0">All Categories</option>';
			}
		}
	
		if ( (is_string($opts['disabled']) && strtolower($opts['disabled'])=='disabled') || is_bool($opts['disabled']) && $opts['disabled'] ){
			$opts['disabled'] = 'disabled';
		} else {
			unset($opts['disabled']);
		}
	
		if ( (is_string($opts['required']) && strtolower($opts['required'])=='required') || (is_bool($opts['required']) && $opts['required']) ){
			$opts['required'] = 'required';
		} else {
			unset($opts['required']);
		}
	
		if ( !is_string($opts['form']) ) unset($opts['form']);
	
		if ( !isset($opts['autofocus']) || !$opts['autofocus'] ) unset($opts['autofocus']);
	
		$opts['id'] = $this->get_field_id($field_name);
	
		$opts['name'] = $this->get_field_name($field_name);
		if ( isset($opts['multiple']) ){
			$opts['name'] .= '[]';
		}
		$select_attributes = '';
		foreach ( $opts as $an => $av){
			$select_attributes .= "{$an}=\"{$av}\" ";
		}
		
		$categories = get_terms('product_cat');
		//print '<pre>'; var_dump($categories);
		// if (!$templates) return '';
		$all_category_ids = array();
		foreach ($categories as $cat) $all_category_ids[] = (int)$cat->term_id;
		
		$is_valid_field_value = is_numeric($field_value) && in_array($field_value, $all_category_ids);
		if (!$is_valid_field_value && is_array($field_value)){
			$intersect_values = array_intersect($field_value, $all_category_ids);
			$is_valid_field_value = count($intersect_values) > 0;
		}
		if (!$is_valid_field_value){
			$field_value = '0';
		}
	
		$select_html = '<select ' . $select_attributes . '>';
		if (isset($allow_select_all)) $select_html .= $allow_select_all;
		foreach ($categories as $cat){
			$select_html .= '<option value="' . $cat->term_id . '"';
			if ($cat->term_id == $field_value || (is_array($field_value)&&in_array($cat->term_id, $field_value))){ $select_html .= ' selected="selected"';}
			$select_html .=  '>'.$cat->name.'</option>';
		}
		$select_html .= '</select>';
		return $select_html;
	}
	
	
	public function update( $new_instance, $old_instance ){
		if ( !array_key_exists('widget_template', $new_instance) ){
			$new_instance['widget_template'] = 'default';
		}
		$update_template = $this->getTemplatePath($new_instance['widget_template'], '_update');
		if ( $update_template ){
			require $update_template;
		}
		return isset($instance) ? $instance : $new_instance;
	}
	
	public function form( $instance ){
		if ( is_null($instance) ) $instance = array();
		if ( !array_key_exists('widget_template', $instance) ){
			$instance['widget_template'] = 'default';
		}
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'maxshop')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>" type="text"
				value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'maxshop')?></label>
			<br/>
			<?php echo $this->widget_template_select('widget_template', array(), $instance['widget_template']); ?>
		</p>
		<?php
		$form_template = $this->getTemplatePath($instance['widget_template'], '_form');
		if ( $form_template ){
			require $form_template;
		}
	}
	
	public function widget( $args, $instance ){
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo isset($instance['widget_before']) ? $instance['widget_before'] : $before_widget;
		if ( isset($instance['widget_title_before']) && !empty($instance['widget_title_before'])){
			$before_title = $instance['widget_title_before'];
		}
		if ( isset($instance['widget_title_after']) && !empty($instance['widget_title_after'])){
			$before_title = $instance['widget_title_after'];
		}
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		
		is_null($instance) or extract($instance);
		
		if ( file_exists( $template = $this->getTemplatePath($widget_template) ) ){
			require $template;
		}
		
		echo isset($instance['widget_after']) ? $instance['widget_after'] : $after_widget;
	}
}

endif;

function getPostViews($postID){    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}  