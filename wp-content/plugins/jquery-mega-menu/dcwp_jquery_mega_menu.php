<?php
/*
		Plugin Name: jQuery Mega Menu
		Plugin URI: http://www.designchemical.com/blog/index.php/wordpress-plugins/wordpress-plugin-jquery-mega-menu-widget/
		Tags: jquery, dropdown, menu, vertical accordion, animated, css, navigation
		Description: Creates a widget, which allows you to turn any Wordpress custom menu into a drop down mega menu. Includes sample skins.
		Author: Lee Chestnutt
		Version: 1.3.7
		Author URI: http://www.designchemical.com
*/

global $registered_skins;

class dc_jqmegamenu {

	function dc_jqmegamenu(){
		global $registered_skins;
	
		if(!is_admin()){
			// Header styles
			add_action( 'wp_head', array('dc_jqmegamenu', 'header') );
			// Scripts
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jqueryhoverintent', dc_jqmegamenu::get_plugin_directory() . '/js/jquery.hoverIntent.minified.js', array('jquery') );
			wp_enqueue_script( 'dcjqmegamenu', dc_jqmegamenu::get_plugin_directory() . '/js/jquery.dcmegamenu.1.3.3.js', array('jquery') );
		}
		add_action( 'wp_footer', array('dc_jqmegamenu', 'footer') );
		
		$registered_skins = array();
	}

	function header(){
		echo "\n\t<link rel=\"stylesheet\" type=\"text/css\" href=\"".dc_jqmegamenu::get_plugin_directory()."/css/dcjq-mega-menu.css\" media=\"screen\" />";
	}
	
	function footer(){
		//echo "\n\t";
	}
	
	function options(){}

	function get_plugin_directory(){
		return WP_PLUGIN_URL . '/jquery-mega-menu';	
	}

};

// Include the widget
include_once('dcwp_jquery_mega_menu_widget.php');

// Initialize the plugin.
$dcjqmegamenu = new dc_jqmegamenu();

// Register the widget
add_action('widgets_init', create_function('', 'return register_widget("dc_jqmegamenu_widget");'));

?>