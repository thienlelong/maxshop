<?php 
/**
 * Portfolio
**/
class Ya_Portfolio_Shortcode{
	private $addScript = false;
	function __construct(){
		add_action( 'wp_footer', array( $this, 'Ya_Portfolio_Script' ) );
		add_shortcode('portfolio', array($this, 'portfolio'));
		add_action("wp_ajax_sw_portfolio_ajax", array($this, "sw_portfolio_ajax"));
		add_action("wp_ajax_nopriv_sw_portfolio_ajax",array($this, "sw_portfolio_ajax"));
	}
	function portfolio( $atts ){
		$this -> addScript = true;
		wp_register_script( 'ya_portfolio', get_template_directory_uri() .'/js/portfolio.js',array(), null, true );
		extract( shortcode_atts( array(
		'categories' => '',
		'style'	=> 'fitRows',
		'layout' => '',
		'm_col'	=> 4,
		'col_large' => '',
		'col_medium' => '',
		'col_small' => '',
		'col_xsmall' => '',
		'orderby' => 'id',
		'order'	=> 'DESC',
		'offset' => 0,
		'loadmore' => 'yes',
		'number' => 12		
		), $atts ) );		
		$pf_id = 'portfolio-'.rand().time();
		$categories_id = array();
		$p_class = '';
		if( $style == 'masonry' ){
			$p_class = 'ya-portfolio-masonry';
		}else{
			$p_class = 'row';
		}
		$attributes = '';
		$attributes .= 'portfolio-item';
		if( $categories != '' ){
			$categories_id = preg_split( '/[\s,]/', $categories );
		}
		if( $style == 'masonry' ){
			if( $m_col != '' ){
				$attributes .= ' masonry-columns-'.$m_col; 
			}
		}else{
			if( $col_large != '' ){
				$attributes .= ' col-lg-'.$col_large; 
			}
			if( $col_medium != '' ){
				$attributes .= ' col-md-'.$col_medium; 
			}
			if( $col_small != '' ){
				$attributes .= ' col-sm-'.$col_small; 
			}
			if( $col_xsmall != '' ){
				$attributes .= ' col-xs-'.$col_xsmall; 
			}
		}
		$output = '';
		if( count($categories_id) != 0 ){
			$query = new wp_query( 'cat='.esc_attr( $categories ).'&posts_per_page='.esc_attr( $number ).'&orderby='.esc_attr( $orderby ).'&order='.esc_attr( $order ) );
			$max_page = $query -> max_num_pages;
			wp_localize_script( 'ya_portfolio', 'ya_portfolio', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ,'style' => $style , 'pf_id' => $pf_id , 'categories' => $categories, 'number' => $number, 'orderby' => $orderby, 'offset' => $offset, 'attributes' => $attributes, 'max_page' => $max_page, 'order' => $order ) );
			$output .= '<div id="'. esc_attr( $pf_id ) .'" class="porfolio">';
			$output .= '<div class="portfolio-tab"><ul id="tab-'. esc_attr( $pf_id ) .'">';
			$output .= '<li class="selected" data-portfolio-filter="*">'. __( 'All', 'maxshop' ).' </li>';
			foreach( $categories_id as $category_id ){
				$cat = get_category( $category_id );
				//var_dump( $cat );
				$output .= '<li data-portfolio-filter=".'. $cat -> slug.'">/&nbsp&nbsp' .esc_html( $cat -> name ). '</li>';
			}
			$output .= '</ul></div>';
			$output .='<div class="portfolio-container"><ul id="container-' .esc_attr( $pf_id ). '" class=" '.esc_attr( $p_class ).'">';
			while( $query -> have_posts() ) : $query -> the_post();
			global $post;
			$terms = get_the_terms( $post->ID, 'category' );
			$term_str = '';
			foreach( $terms as $key => $term ){
				$term_str .= $term -> slug . ' ';
			}		
			if( $style = 'masonry' ){
				$output .= '<li class="'.$attributes.' '.esc_attr( $term_str ).'"><div class="portfolio-masonry-inner">';
				$output .= '<a class="portfolio-img" href="'.get_permalink( $post->ID ).'" title="'.esc_attr( $post->post_title ).'">'.get_the_post_thumbnail( $post->ID, 'thumbnail' ).'</a>';	
				$output .= '<h3><a href="'.get_permalink( $post->ID ).'" title="'.esc_attr( $post->post_title ).'">'.esc_html( $post->post_title ).'</a></h3>';
				$output .= '</div></li>';				
			}else{
				$output .= '<li class="'.$attributes.' '.esc_attr( $term_str ).'">';
				$output .= '<a class="portfolio-img" href="'.get_permalink( $post->ID ).'" title="'.esc_attr( $post->post_title ).'">'.get_the_post_thumbnail( $post->ID, 'thumbnail' ).'</a>';	
				$output .= '<h3><a href="'.get_permalink( $post->ID ).'" title="'.esc_attr( $post->post_title ).'">'.esc_html( $post->post_title ).'</a></h3>';
				$output .= '</li>';
			}
			endwhile;
			wp_reset_postdata();
			$output .= '</ul></div>';
			if( $loadmore == 'yes' ){
				$output .= '<div class="btn-loadmore">';
				$output .= '<span class="respl-image-loading"></span>';
				$output .= '<span class="des-load" data-label="'.__("Show More Portfolio", 'maxshop' ).'" data-label-loaded="'.__("All Items Loaded", 'maxshop' ) .'"></span>';		
				$output .= '</div>';
			}
			$output .= '</div>';
		}else{
			$output .= __( 'Please select categories id', 'maxshop' );
		}
		return $output;
	}
	function sw_portfolio_ajax(){
		$catid 		= (isset($_POST["catid"])   && $_POST["catid"] != '' ) ? $_POST["catid"] : '';
		$page 		= (isset($_POST["page"])    && $_POST["page"]> 0 ) ? $_POST["page"] : 0;
		$attributes = (isset($_POST["attributes"])    && $_POST["attributes"] != '' ) ? $_POST["attributes"] : '';
		$number 	= (isset($_POST["numb"])    && $_POST["numb"]>0) ? $_POST["numb"] : 0;
		$offset 	= (isset($_POST["offset"])  && $_POST["offset"]>0) ? $_POST["offset"] : 0;
		$orderby 	= (isset($_POST["orderby"]) && $_POST["orderby"] != '') ? $_POST["orderby"] : '';
		$order 		= (isset($_POST["order"]) && $_POST["order"] != '') ? $_POST["order"] : '';
		$style 		= (isset($_POST["style"]) && $_POST["style"] != '') ? $_POST["style"] : '';
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'cat' => $catid,
			'posts_per_page' => $number,
			'orderby'	=> $orderby,
			'order'	=> $order,
			'offset'	=> $offset + ($number*$page)
		);
		$output = '';
		$query = new wp_query( $args ); 
		while( $query -> have_posts() ) : $query -> the_post();
		global $post;
		$terms = get_the_terms( $post->ID, 'category' );
		$term_str = '';
		foreach( $terms as $key => $term ){
			$term_str .= $term -> slug. ' ';
		}
		if( $style = 'masonry' ){
			$output .= '<li class="'.$attributes.' '.esc_attr( $term_str ).'"><div class="portfolio-masonry-inner">';
			$output .= '<a class="portfolio-img" href="'.get_permalink( $post->ID ).'" title="'.esc_attr( $post->post_title ).'">'.get_the_post_thumbnail( $post->ID, 'thumbnail' ).'</a>';	
			$output .= '<h3><a href="'.get_permalink( $post->ID ).'" title="'.esc_attr( $post->post_title ).'">'.esc_html( $post->post_title ).'</a></h3>';
			$output .= '</div></li>';				
		}else{
			$output .= '<li class="'.$attributes.' '.esc_attr( $term_str ).'">';
			$output .= '<a class="portfolio-img" href="'.get_permalink( $post->ID ).'" title="'.esc_attr( $post->post_title ).'">'.get_the_post_thumbnail( $post->ID, 'thumbnail' ).'</a>';	
			$output .= '<h3><a href="'.get_permalink( $post->ID ).'" title="'.esc_attr( $post->post_title ).'">'.esc_html( $post->post_title ).'</a></h3>';
			$output .= '</li>';
		}
		endwhile;
		wp_reset_postdata();
		echo $output;
		exit();
	}
	function Ya_Portfolio_Script(){
		if( !$this -> addScript ){
			return false;
		}
		wp_register_script( 'layout_js', get_template_directory_uri() .'/js/isotope.js',array(), null, true );		
		if (!wp_script_is('layout_js')) {
			wp_enqueue_script('layout_js');
		} 
		wp_enqueue_script( 'ya_portfolio' );
	}
}
new Ya_Portfolio_Shortcode();