<?php
class RGBA{
	public static $instance = null;
	protected $color_names = array(
			'aqua' => array(0, 255, 255),
			'black' => array(0, 0, 0),
			'blue' => array(0, 0, 255),
			'fuchsia' => array(255, 0, 255),
			'gray' => array(128, 128, 128),
			'green' => array(0, 128, 0),
			'lime' => array(0, 255, 0),
			'maroon' => array(128, 0, 0),
			'navy' => array(0, 0, 128),
			'olive' => array(128, 128, 0),
			'purple' => array(128, 0, 128),
			'red' => array(255, 0, 0),
			'silver' => array(192, 192, 192),
			'teal' => array(0, 128, 128),
			'white' => array(255, 255, 255),
			'yellow' => array(255, 255, 0)
	);
	
	public function __construct(){
		
	}
	/**
	 * @return RGBA
	 */
	public static function getInstance(){
		if ( is_null(self::$instance) ){
			self::$instance = new RGBA();
		}
		return self::$instance;
	}
	
	public static function get($r = 0, $g = 0, $b = 0, $a = 1){
		$data = self::getInstance()->getData($r, $g, $b, $a);
		$data_encoded = call_user_func('base64'.'_encode', $data);
		return 'data:image/png;base64,'.$data_encoded;
	}
	
	public function getData($r = 0, $g = 0, $b = 0, $a = 1){
		if ( is_string($r) && stripos($r, '#')===0 ){
			$a = $g;
			list( $r, $g, $b ) = $this->parseColor( $r );
		}
		$r = intval($r);
		$g = intval($g);
		$b = intval($b);
		if ( $r > 255 ) $r = 255; else if ( $r < 0 ) $r = 0;
		if ( $g > 255 ) $g = 255; else if ( $g < 0 ) $g = 0;
		if ( $b > 255 ) $b = 255; else if ( $b < 0 ) $b = 0;
		if ( $a > 100 ) $a = 100; else if ( $a < 0 ) $a = 0;
		if ( $a > 1 ){
			$a = $a / 100;
		}
		$a = intval(127 - 127 * $a);
		ob_start();
		if ( function_exists('imagecreatetruecolor')
				&& function_exists('imagealphablending')
				&& function_exists('imagesavealpha')
				&& function_exists('imagecolorallocatealpha')
				&& function_exists('imagefill')
				&& function_exists('imagepng')
				&& function_exists('imagedestroy')
				){
			$img = imagecreatetruecolor(1, 1);
			imagealphablending($img, false);
			imagesavealpha($img, true);
			$color = imagecolorallocatealpha($img, $r, $g, $b, $a);
			imagefill($img, 0, 0, $color);
			imagepng($img);
			imagedestroy($img);
		}
		$data = ob_get_contents();
		ob_end_clean();
		return $data;
	}
	
	public function parseColor($hex){
		$hex = str_replace('#', '', $hex);
		
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}

}