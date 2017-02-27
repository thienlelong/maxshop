<?php 
/**
 * Skillbar
**/
class Ya_Skillbar_Shortcode{
    private $addScript = false;
	private $TypeScriptBar = false;
	private $TypeScriptCircle =false;
	function __construct(){
	
		add_action( 'wp_footer', array( $this, 'Skillbar_Script' ) );
		add_shortcode('skillbar', array($this, 'skillbar'));
	}
	function skillbar( $atts ){
		$this -> addScript = true;
	extract( shortcode_atts( array(
			'title'			=> '',
			'percentage'	=> '100',
			'color'			=> '#6adcfa',
			'class'			=> '',
			'style'         =>'',
			'show_percent'	=> 'true',
			'visibility'	=> 'all',
		), $atts ) );
		wp_enqueue_script('ya_waypoints_api', 'http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js', array('jquery'), null, true);
		$sk_id = 'ya_skillbar_shorcode_'.rand().time();
	if($style == 'large'||$stype='small'){
			$this->TypeScriptBar = true;
		}
		if($style == 'circle'){
		   $this->TypeScriptCircle = true;
		 
		}
		// Display the large	';
		if($style == 'large'){
		$output = '<div class="yt-skillbar yt-skillbar-'.$style.' yt-clearfix '. $class .' yt-'. $visibility .'" data-percent="'. intval( $percentage ) .'%">';
			if ( $title !== '' ) $output .= '<div class="yt-skillbar-title"><span>'. $title .'</span></div>';
			$output .= '<div class="yt-skillbar-bar"></div>';
			if ( $show_percent == 'true' ) {
				$output .= '<div class="yt-skill-bar-percent">'.esc_html( $percentage ).'%</div>';
			}
		$output .= '</div>';
		
		return $output;
		}
		// Display the small	';
		if($style == 'small'){
		if ( $title !== '' ) {$output = '<div class="yt-skillbar-title '.esc_attr( $style ).'"><span>'. esc_html( $title ) .' : </span></div>';}
			$output .= '<div class="yt-skillbar '.esc_attr( $style ).' yt-clearfix '. esc_attr( $class ) .' yt-'. $visibility .'" data-percent="'. intval( $percentage ) .'%">';
			
			$output .= '<div class="yt-skillbar-bar"></div>';
			if ( $show_percent == 'true' ) {
				$output .= '<div class="yt-skill-bar-percent">'.esc_html( $percentage ).'%</div>';
			}
		$output .= '</div>';
		return $output;
		}
		// Display the circle	';
		if($style == 'circle'){
			wp_register_script( 'ya_circle_skillbar', get_template_directory_uri() .'/js/ya_circle_skillbar.js',array(), null, true );
		    wp_localize_script( 'ya_circle_skillbar', 'ya_circle_skillbar', array( 'sk_id' => $sk_id , 'class' => $class ) );
			return '<div id="'.esc_attr( $sk_id ).'" class="ya-skill-circle" data-dimension="170" data-text="'.esc_attr( $percentage ).'%" data-width="17" data-fontsize="36" data-percent="'.esc_attr( $percentage ).'" data-fgcolor="'.esc_attr( $color ).'" data-bgcolor="#a1a1a1"><span class="circle-info-half" style="line-height: 221.5px;">'.esc_html( $title ).'</span></div>';
		}
	}
	function Skillbar_Script(){

		if( !$this -> addScript ){
			return false;
		}
		
		if($this->TypeScriptBar == true){
			$script = '';
	$script .= '<script type="text/javascript">
	 jQuery(function($){
		 "use strict";
	$(document).ready(function(){
		jQuery( ".yt-skillbar" ).waypoint( function() {
			
	        $(this).find(".yt-skillbar-bar").animate({ width: $(this).attr("data-percent") }, 1500 );

			}, {
				triggerOnce: true,
				offset: "bottom-in-view"
			});
         
	});
});
	</script>';
	echo $script;
		}
		if($this->TypeScriptCircle == true){
			wp_enqueue_script('ya_circle_skillbar');
		}
	}
}
new Ya_Skillbar_Shortcode();