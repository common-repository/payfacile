<?php
/*
Plugin Name: Payfacile
Plugin URI: http://www.payfacile.com
Description: Insert customizable Payfacile buttons and widgets into your pages and posts easily.
Version: 1.0.1
Author: Payfacile
Author URI: http://payfacile.com
Text Domain: payfacile
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'PAYFACILE' ) ) {
	class PAYFACILE
	{

		const DB_VER = 1;
		const VER = '0.1';
		public $plugin_name   = 'Payfacile';
		public $plugin_slug   = 'payfacile';
		public $plugin_url;


		/**
		 * Construct class
		 */
		function __construct() {

			$this->plugin_url = plugin_dir_url( __FILE__ );
			
			if ( is_admin() ) {
				add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins' ), 998 );
				add_filter( 'mce_buttons', array( $this, 'mce_buttons' ), 999 );
			    load_plugin_textdomain( 'payfacile', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
				add_action( 'init', array( $this, 'admin_init' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

			} else { 
				// frontend scripts
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
				add_action( 'wp_footer', array( $this, 'footer_scripts' ) );
			}
			add_shortcode( 'payfacile', array( $this, 'shortcode' ) );

		} // END function __construct()

		
		/**
		 * Create Settings page
		 */
		function admin_init() {

			require_once( 'inc/settings.php' );
			global $PAYFACILE_SETTINGS;
			if ( empty( $PAYFACILE_SETTINGS ) ) {
				$PAYFACILE_SETTINGS = new PAYFACILE_SETTINGS();
			}

		} // END function admin_init_settings()

		/**
		 * Enqueue admin scripts and styles for widget customization
		 */
		function admin_scripts() {

			global $pagenow;

			// Enqueue only on post pages
			if ( ! in_array( $pagenow, array(  'post.php', 'post-new.php' ) ) ) {
				return;
			}

			wp_enqueue_style(
				$this->plugin_slug . '-admin',
				plugins_url( 'assets/css/admin.css', __FILE__ ),
				array(),
				self::VER
			);


			wp_enqueue_script( 'wp-color-picker');
			wp_enqueue_style( 'wp-color-picker' );


			$js = "<script type=\"text/javascript\">
				var payfacile_langs = []
				payfacile_langs['button'] = '".__( 'button', 'payfacile' )."';
				payfacile_langs['product_url'] = '".__( 'product url', 'payfacile' )."';
				payfacile_langs['product_url_label'] = '".__( 'product url label', 'payfacile' )."';
				payfacile_langs['button_text'] = '".__( 'button text', 'payfacile' )."';
				payfacile_langs['button_label'] = '".__( 'button label', 'payfacile' )."';
				payfacile_langs['button_buy_default'] = '".__( 'button buy default', 'payfacile' )."';
				payfacile_langs['text_color'] = '".__( 'text color', 'payfacile' )."';
				payfacile_langs['background_color'] = '".__( 'background color', 'payfacile' )."';
				payfacile_langs['type_of_target_window'] = '".__( 'type of target window', 'payfacile' )."';
				payfacile_langs['type_of_target_window_popup'] = '".__( 'type of target window popup', 'payfacile' )."';
				payfacile_langs['type_of_target_window_new'] = '".__( 'type of target window new', 'payfacile' )."';
				payfacile_langs['type_of_target_window_label'] = '".__( 'type of target window label', 'payfacile' )."';
				payfacile_langs['iframe_width'] = '".__( 'iframe width', 'payfacile' )."';
				payfacile_langs['iframe_height'] = '".__( 'iframe height', 'payfacile' )."';
				payfacile_langs['iframe_height_label'] = '".__( 'iframe height label', 'payfacile' )."';
				payfacile_langs['iframe_width_label'] = '".__( 'iframe width label', 'payfacile' )."';
				payfacile_langs['outline_color'] = '".__( 'outline color', 'payfacile' )."';
				payfacile_langs['outline_width'] = '".__( 'outline width', 'payfacile' )."';
				payfacile_langs['outline_color_label'] = '".__( 'outline color label', 'payfacile' )."';
				payfacile_langs['outline_width_label'] = '".__( 'outline width label', 'payfacile' )."';
				payfacile_langs['choose_color'] = '".__( 'choose color', 'payfacile' )."';
				payfacile_langs['insert_shortcode'] = '".__( 'insert shortcode', 'payfacile' )."';
				payfacile_langs['cancel'] = '".__( 'cancel', 'payfacile' )."';
				payfacile_langs['limit_20_chars'] = '".__( 'limit 20 chars', 'payfacile' )."';
				</script>\n
				";
			echo $js;
		} // END function admin_scripts()

		/**
		 * Enqueue frontend scripts and styles
		 */
		function enqueue_scripts() {


				wp_enqueue_style(
					'magnific-popup-au',
					plugins_url( 'assets/lib/magnific-popup/magnific-popup.css', __FILE__ ),
					array(),
					self::VER
				);
				wp_enqueue_script(
					'magnific-popup',
					plugins_url( 'assets/lib/magnific-popup/jquery.magnific-popup.js', __FILE__ ),
					array( 'jquery' ),
					'',
					true
				);
				wp_enqueue_style(
					'payfacile',
					plugins_url( 'assets/css/payfacile.css', __FILE__ ),
					array(),
					self::VER
				);
			
		} // end function enqueue_scripts

		/**
		 * Generate inline JavaScript code 
		 * @return string
		 */
		function footer_scripts() {
			$js = "<script type=\"text/javascript\">

			jQuery(document).ready(function() {
				jQuery('.payfacile_btn_lightbox').magnificPopupAU({
					type:'iframe',
					mainClass:'pf-lightbox',
					preloader:true,
					fixedContentPos:false
				});
   
    			/*
	  			jQuery(document).on('click hover', '.payfacile_btn', function (e) {
	              
	                var circle, size, x, y;
	                
	                circle = jQuery('<div class=\'circle\'></div>');
	                jQuery(this).append(circle);
	                x = e.pageX - jQuery(this).offset().left - circle.width() / 2;
	                y = e.pageY - jQuery(this).offset().top - circle.height() / 2;
	                size = jQuery(this).width();
	                circle.css({
	                    top: y + 'px',
	                    left: x + 'px',
	                    width: size + 'px',
	                    height: size + 'px'
	                }).addClass('animate');
	                return setTimeout(function () {
	                    return circle.remove();
	                }, 500);
	            });
				*/
			});</script>";
			echo $js;
		} 

	
		public function shortcode($atts) {
			return implode( array_values( $this->output( $atts ) ) );
		} // END public function shortcode()

		// Print out 
		public function output($instance) {
			$output = array();
			$instance['textbutton'] = sanitize_text_field($instance['textbutton']);
			//print_r($instance);
			$po = str_replace("_"," ", $instance['textbutton'] );
			//$url = 'https://www.payfacile.com/test-wp/s/ml';
			$url = $instance['url'];
			//$url = 'url';
			if($instance['type_of'] =='button'){
				
				if($instance['win_target'] =='new'){
					$lt_class = "";
					$target="_blank";
				}
				else{
					$target="";
					$url = str_replace("/s/","/si/", $url);
					//https://www.payfacile.com/test-wp/s/ml
					$lt_class="payfacile_btn_lightbox";
				}
				$output[] = '<div class="payfacile_button_container"><a target="'.$target.'" style="color:'.$instance['color_text'].'; background:'.$instance['color_bg'].';"  href="'.$url.'" class="payfacile_btn '.$lt_class.'"><span>'.$po.'</span></a></div>';

			}
			if($instance['type_of'] =='iframe'){
					$url = str_replace("/s/","/si/", $url);
					$output[] = '<div class="payfacile"><div class="iframe_wrapper"><iframe height="'.$instance['iframe_height'].'px" width="'.$instance['iframe_width'].'%" style="border:'.$instance['outline_width'].'px solid '.$instance['outline_color'].';" src="'.$url.'"></iframe></div></div>';

			}
			return $output;

		} // END public function output($instance)

		/**
		 * Register TinyMCE button 
		 * @param  array $plugins Unmodified set of plugins
		 * @return array          Set of TinyMCE plugins
		 */
		function mce_external_plugins($plugins) {
			$plugins['payfacile'] = plugin_dir_url( __FILE__ ) . 'inc/tinymce/plugin.js';
			return $plugins;

		} // END function mce_external_plugins($plugins)

		/**
		 * Append TinyMCE button 
		 * @param  array $buttons Unmodified set of buttons
		 * @return array Set of TinyMCE buttons
		 */
		function mce_buttons($buttons) {
			$buttons[] = 'payfacile_shortcode';
			return $buttons;

		} // END function mce_buttons($buttons)
	
	} // end class
} // end class check


global $PAYFACILE;
if ( empty( $PAYFACILE ) ) {
	$PAYFACILE = new PAYFACILE();
}
