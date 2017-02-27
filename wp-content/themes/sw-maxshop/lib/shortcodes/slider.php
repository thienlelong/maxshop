<?php
	/**
		** Shortcode slideshow
		** Author: Smartaddons
	**/
class Ya_Slider_Shortcode{
	function __construct(){
		add_shortcode('ya_slider', array($this, 'ya_slider'));
		add_shortcode('slider_item', array($this, 'ya_slider_item'));
	}
	function ya_slider( $atts, $content = NULL ){
		extract( shortcode_atts( array(
		'interval'	=> 5000,
		'show_navigator' => 'true',
		'show_indicator'	=> 'false' ,
		'type'             =>'',
		'title'            =>'',
		'nav_position' => 'center'
		), $atts ) );
		preg_match_all("/\[slider_item[^>]*\]/iU", $content, $matches);
		$output = '';
		$sl_id = 'ya_slider_shorcode_'.rand().time();
		$output .= '<div class="carousel carousel-'.$type.' slide ya-slider" id="'.esc_attr( $sl_id ).'">';
		if($title !='' && $show_navigator == 'true'){
			$output .='<div class="box-recommend-title">
			            <a href="#'.esc_attr( $sl_id ).'" class="left carousel-control" data-slide="prev"><i class="fa fa-angle-left"></i></a>
						<h3>'.esc_html( $title ).'</h3>
						<a href="#'.esc_attr( $sl_id ).'" class="right carousel-control" data-slide="next"><i class="fa fa-angle-right"></i></a>
						</div>';
		}elseif($title != '' ){
			$output .='<div class="box-recommend-title">
						<h3>'.esc_html( $title ).'</h3>
						</div>';
			
		}elseif( $show_navigator == 'true' ){
			$output .= '<a href="#'.esc_attr( $sl_id ).'" class="left carousel-control" data-slide="prev"><i class="fa fa-angle-left"></i></a>';
			$output .= '<a href="#'.esc_attr( $sl_id ).'" class="right carousel-control" data-slide="next"><i class="fa fa-angle-right"></i></a>';
		}
		if( $show_indicator != 'false' ){
		$output .= '<ol class="carousel-indicators">';
			for( $i = 0; $i < count($matches[0]); $i ++ ){
				$active = ( $i == 0 ) ? 'active' : '';
				$output .= '<li data-target="#'.$sl_id.'" data-slide-to="'.$i.'" class="'.$active.'"></li>';
			}
		$output .= '</ol>';
		}
		$output .= '<div class="carousel-inner">';
		$output .= do_shortcode( $content );
		$output .= '</div>';
		
		$output .= '</div>';
		return $output;
	}
	function ya_slider_item( $atts, $content = NULL ){
		extract( shortcode_atts( array(
		'class'	=> '',
		), $atts ) );	
		$output = '<div class="item '.esc_attr( $class ).'">'.do_shortcode($content).'</div>';
		return $output;
		
	}
}
new Ya_Slider_Shortcode();