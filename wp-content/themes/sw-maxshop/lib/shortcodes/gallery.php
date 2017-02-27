<?php 
/**
 * Gallery
**/
class Ya_Gallery_Shortcode{
    private $addScript = false;
	private $TypeScriptColumn = false;
	private $TypeScriptSlide =false;
	private $TypeScriptFlex =false;
		
	function __construct(){
	
		add_action( 'wp_footer', array( $this, 'Gallery_Script' ) );
		add_shortcode('gallerys', array($this, 'gallery'));
	}
	function gallery( $attr ){
		$this -> addScript = true;
		static $priority = 0;
		$post = get_post();
		static $instance = 0;
		$instance++;
		if (!empty($attr['ids'])) {
			if (empty($attr['orderby'])) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}

		$output = apply_filters('post_gallery', '', $attr);

		if ($output != '') {
			return $output;
		}

		if (isset($attr['orderby'])) {
			$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
			if (!$attr['orderby']) {
				unset($attr['orderby']);
			}
		}

		if (is_array($attr) ) {
				
			foreach ($attr as $key => $att){
				$att = trim($att);
				if (empty($att)) unset( $attr[$key] );
			}
		}

		extract(shortcode_atts(array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post->ID,
				'itemtag'    => '',
				'icontag'    => '',
				'type'       =>'column',
				'columns'    => 6,
				'caption'    => 'true',
				'size'       => 'medium',
				'interval'	 => '5000',
				'event'		 => 'slide',
				'class'		 => '',
				'include'    => '',
				'exclude'    => ''
			), $attr)
		);
      
		$id = intval($id);
		if ($order === 'RAND') {
			$orderby = 'none';
		}

		if (!empty($include)) {
			$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
             
			$attachments = array();
			foreach ($_attachments as $key => $val) {
				$attachments[$val->ID] = $_attachments[$key];
			}
			
		} elseif (!empty($exclude)) {
			$attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
		} else {
			$attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
		}

		if (empty($attachments)) {
			return '';
		}
		/** column **/
        if($type == 'column'){
			$this->TypeScriptColumn = true;
		}elseif($type == 'slide'){
		   $this->TypeScriptSlide = true;
		}elseif($type == 'flex'){
			$this -> TypeScriptFlex = true;
		}
		$pf_id = 'gallery-'.rand().time();
		if($type == 'column'){
		wp_register_script( 'ya_gallery', get_template_directory_uri() .'/js/ya_gallery.js',array(), null, true );
		if (is_feed()) {
		$output = "\n";
		//var_dump($attachments);
		foreach ($attachments as $att_id => $attachment) {
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		}
		return $output;
	}
	
	if (!wp_style_is('ya_photobox_css')){
		wp_enqueue_style('ya_photobox_css');
	}
	
	if (!wp_enqueue_script('photobox_js')){
		wp_enqueue_script('photobox_js');
	}
	
	$output = '<ul id="photobox-gallery-' . esc_attr( $instance ). '" class="thumbnails photobox-gallery gallery gallery-columns-'.esc_attr( $columns ).'">';

	$i = 0;
	$width = 100/$columns - 1;
	foreach ($attachments as $id => $attachment) {
		//$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
		$link = '<a class="thumbnail" href="' . wp_get_attachment_url($id) . '">';
		$link .= wp_get_attachment_image($id);
		$link .= '</a>';
		if ($caption == 'true') {
				$link .= '<div class="caption">';
				$link .= '<h4>'.esc_html( $attachment->post_title ).'</h4>';
				$link .= '</div>';
			}
		$output .= '<li style="width: '.esc_attr( $width ).'%;">' . $link;
		$output .= '</li>';
	}

	$output .= '</ul>';
	return $output;
		}
			/** slide **/
		if($type == 'slide'){
		wp_register_script( 'ya_slidegallery', get_template_directory_uri() .'/js/slidegallery.js',array(), null, true );
		wp_localize_script( 'ya_slidegallery', 'ya_slidegallery', array( 'event' => $event , 'pf_id' => $pf_id ) );
		   $classes =array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		$classes[] = trim($event);
		array_unshift($classes, 'shortcode-slideshow');
		$classes = array_unique($classes);
		$classes = implode(' ', $classes);
		
		$slideshow_id = 'yaSlideshow-'.$priority;
		
		$script = '';
		$script .= '<script type="text/javascript">';
		
		if ($priority == 0) $script .= 'yaSlideshow = {};';
		
		$script .= 'yaSlideshow['.$priority.'] = {';
		$script .= 		'interval: ' .$interval;
		$script .= '};';
		$script .= '</script>';
		$html = '';
		$html .= $script;
		$html .= '<div class="carousel '.$classes.'" id="'.esc_attr( $slideshow_id ).'" >';
		$html .= '<div class="carousel-inner">';
		$i = 0;
		$j =0;
		$k =(count($attachments));
		foreach ($attachments as $attachment){
			$active = '';
			if ($i==0) $active = 'active';
			 
			$html .= '<div class="item '.$active.'">';
			$html .= wp_get_attachment_image($attachment->ID, $size);

			if ($caption == 'true') {
				$html .= '<div class="carousel-caption">';
				$html .= '<h4>'.esc_html( $attachment->post_title ).'</h4>';
				$content = trim($attachment->post_content);
				if (!empty($content)) {
					$html .= ' <p>'.esc_html( $content ).'</p>';
				}
				$html .= '</div>';
			}

			$html .= '</div>';
			$i++;
		}
		$html .= '</div>';
		 $html .='<ol class="carousel-indicators">';
		 for($j=0;$j < $k;$j++){
			 $active = '';
			 if ($j==0) $active = 'active';
		    $html .='<li data-target="#'.esc_attr( $slideshow_id ).'" data-slide-to="'.$j.'" class="'.$active.'"></li>';
		 }
		 $html .='</ol>';

		$html .= '<a data-slide="prev" href="#'.esc_attr( $slideshow_id ).'" class="left carousel-control"></a>
				<a data-slide="next" href="#'.esc_attr( $slideshow_id ).'" class="right carousel-control"></a>';
		$html .= '</div>';
		$priority++;
		return $html;
		}
		/** flex **/
		if($type == 'flex'){
		wp_register_script( 'ya_flexgallery', get_template_directory_uri() .'/js/flexgallery.js',array(), null, true );
		wp_localize_script( 'ya_flexgallery', 'ya_flexgallery', array( 'event' => $event , 'pf_id' => $pf_id ) );
		
		$html ='<div class ="gallery-images '.$class.'"><div id="flexslider-gallery" class="flexslider ">';
			$html .='<div style="overflow: hidden; position: relative;" class="flex-viewport"> <ul class="slides">';
			foreach ($attachments as $attachment){
			$html .='<li>' .wp_get_attachment_image($attachment->ID,'large').	'</li>';
			}
			$html .='</ul></div>';
			$html .='<ul class="flex-direction-nav"><li><a class="flex-prev" href="#">Previous</a></li>';
			$html .='<li><a tabindex="-1" class="flex-next" href="#">Next</a></li></ul></div>';
			$html .='<div id="flex-thumbnail" class="flexslider flex-thumbnail">';	
	        $html .='<div style="overflow: hidden; position: relative;" class="flex-viewport"><ul class="slides">';
			foreach ($attachments as $attachment){
		    $html .='<li><a href="'.wp_get_attachment_url( $attachment->ID).'" class="product_image" title="19">'.wp_get_attachment_image($attachment->ID,'thumbnail').	'</a></li>';
			}
			$html .='</ul></div>';
			$html .= '<ul class="flex-direction-nav"><li><a class="flex-prev" href="#">Previous</a></li><li><a tabindex="-1" class="flex-next" href="#">Next</a></li>';
			$html .= '</ul></div></div>';
			return $html;	
		}
	}
	function Gallery_Script(){

		if( !$this -> addScript ){
			return false;
		}
		
		if($this->TypeScriptColumn == true){
			wp_enqueue_script('ya_gallery');
		}
		if($this->TypeScriptSlide == true){
			wp_enqueue_script( 'ya_slidegallery' );
		}
		if($this->TypeScriptFlex == true){
			wp_enqueue_script( 'ya_flexgallery' );
		}	
		
	}
}
new Ya_Gallery_Shortcode();