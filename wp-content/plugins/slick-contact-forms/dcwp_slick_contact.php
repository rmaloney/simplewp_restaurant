<?php
/*
		Plugin Name: Slick Contact Forms
		Plugin URI: http://www.designchemical.com/blog/index.php/wordpress-plugin-slick-contact-forms/
		Tags: jquery, flyout, drop down, floating, sliding, contact, vertical, animated, forms, widget, validation
		Description: Create quick and easy floating or slide out contact forms with animated validation error messages.
		Author: Lee Chestnutt
		Version: 1.3.3
		Author URI: http://www.designchemical.com/blog/
		Copyright 2011 Lee Chestnutt
*/

global $registered_skins;

class dc_jqslickcontact {

	function dc_jqslickcontact(){
		global $registered_skins;
	
		if(!is_admin()){
			// Header styles
			add_action( 'wp_head', array('dc_jqslickcontact', 'header') );
			// Scripts
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jqueryeasing', dc_jqslickcontact::get_plugin_directory() . '/js/jquery.easing.js', array('jquery') );
			wp_enqueue_script( 'jqueryhoverintent', dc_jqslickcontact::get_plugin_directory() . '/js/jquery.hoverIntent.minified.js', array('jquery') );
			wp_enqueue_script( 'dcjqslickcontact', dc_jqslickcontact::get_plugin_directory() . '/js/jquery.slick.contact.1.3.2.js', array('jquery') );
			// Shortcodes
			add_shortcode( 'dcscf-link', 'dcscf_contact_link_shortcode' );
		}
		add_action( 'wp_footer', array('dc_jqslickcontact', 'footer') );
		
		$registered_skins = array();
	}

	function header(){
		//echo "\n\t";
	}
	
	function footer(){
		//echo "\n\t";
	}
	
	function get_plugin_directory(){
		return WP_PLUGIN_URL . '/slick-contact-forms';	
	}
};

require_once('inc/dcwp_admin.php');

if(is_admin()) {


	$dc_jqslickcontact_admin = new dc_jqslickcontact_admin();

}

// Initialize the plugin.
$dcjqslickcontact = new dc_jqslickcontact();


// Register the widget
add_action('widgets_init', create_function('', 'return register_widget("dc_jqslickcontact_widget");'));

/**
* Create a link shortcode for opening/closing the form
*/
function dcscf_contact_link_shortcode($atts){
	
	extract(shortcode_atts( array(
		'text' => 'Contact Us',
		'action' => 'link'
	), $atts));

	return "<a href='#' class='dcscf-$action'>$text</a>";

}
?>