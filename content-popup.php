<?php
/*
Plugin Name: Content Popup
Plugin URI: http://patrick.forringer.com/plugins/content-popup
Description: Allows you to section off content in a post for a popup
Version: 0.1
Author: Patrick Forringer
Author URI: http://patrick.forringer.com
*/

define( PF_CP_VER, '0.1.0' );

/* Set constant path to the volunteers plugin directory. */
define( PF_CP_DIR, plugin_dir_path( __FILE__ ) );

/* Set constant path to the volunteers plugin URL. */
define( PF_CP_URL, plugin_dir_url( __FILE__ ) );

class PF_Content_Popup{

	private static $regd_popups;
	
	private $popups;
	
	function __construct(){

		$short_code = 'popup'; // TODO: over writeable shortcode - in options
		
		add_action( 'wp_enqueue_scripts', array( &$this , 'enqueue_scripts' ) );
		
		add_shortcode( $short_code , array( &$this, 'do_shortcode' ) );

		add_action( 'wp_footer', array( &$this, 'insert_popup_js' ) );
		
		// register scripts
		wp_register_script('PF_Content_Popup_JS',
			PF_CP_URL . 'js/popup.js',
			array( 'jquery' ), '0.1');		
	}
	
	function enqueue_scripts(){
		if(!is_admin()){
				wp_enqueue_script( 'PF_Content_Popup_JS' );;	 
				//wp_enqueue_style( '' );
		}
	}
	
	function do_shortcode( $attrs, $content ){

		$op = (object) shortcode_atts(array(
				'link' => 'View Popup.',
				'kind' => 'fancybox'
			), $attrs );
			
		$this->popups++;

		// store content of popups
		$this->regd_popups['popup-'.$this->popups] = $content;
		
		return "<a data-popup=\"popup-{$this->popups}\" data-kind=\"{$op->kind}\" href=\"#\">{$op->link}</a><div class=\"visuallyHidden\">{$content}</div>";

	}
	
	function insert_popup_js(){

		// check if we have any popups to insert
		if( count($this->regd_popups) > 0 ){
			
			echo '<script type="text/javascript"> PF_Content_Popup.popup_content = '.json_encode( $this->regd_popups ).'</script>';
			
		}
	}

}

new PF_Content_Popup;