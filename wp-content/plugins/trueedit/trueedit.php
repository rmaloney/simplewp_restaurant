<?php
/*
Plugin Name: TRUEedit
Package: TRUEedit
Plugin URI: http://wordpress.org/extend/plugins/trueedit/
Description: TRUEedit turns the Post HTML Tab into a raw HTML editor that does not texturize or modify your code.
Version: 1.4
Author: Zachary Segal
Author URI: http://www.illproductions.com/

Copyright 2011  Zachary Segal  (email : zac@illproductions.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/



trueedit_hook_into_wordpress();



/**
 * Hook plugin specific functions into WordPress actions and filters
 *
 * @return void
 **/
function trueedit_hook_into_wordpress() {
	register_activation_hook( __FILE__, 'trueedit_activate' );
	add_action('init', 'trueedit_plugin_init');
	
	add_action('admin_menu', 'trueedit_admin_menu');
	add_filter('contextual_help', 'trueedit_contextual_help', 10, 3);
	
	add_action('wp_head', 'trueedit_give_credit');
}



/**
 * This function installs or updates the default options for the plugin.
 *
 * @return void
 **/
function trueedit_activate() {
	
	// define the default options array
	$default_options = array();
	$default_options['filters']           = array('wpautop', 'wptexturize');
	$default_options['font-family']       = '';
	$default_options['font-size']         = '';
	$default_options['font-color']        = '#000000';
	$default_options['background-color']  = '#ffffff';
	$default_options['editor-height']     = '';
	$default_options['editor-fullscreen'] = true;
	
	// add any new default options to the saved array
	$saved_options = get_option('trueedit_options');
	if (is_array($saved_options)) {
		foreach ($default_options as $option => $default_value) {
			if (!in_array($option, array_keys($saved_options))) {
				$saved_options[$option] = $default_value;
			}
		}		
	} else {
		$saved_options = $default_options;
	}
	
	// migrate old filter settings into new array
	$old_settings = array('wpautop', 'wptexturize');
	foreach ($old_settings as $setting) {
		if (isset($saved_options[$setting])) {
			if ($saved_options[$setting] == true) {
				$saved_options['filters'][] = $setting;
			}
			unset($saved_options[$setting]);
		}		
	}
	
	// save changes
	update_option('trueedit_options', $saved_options);
}



/**
 * Multipurpose function
 * if in admin post editor panel enqueue plugin scripts and styles
 * if not in the plugins option panel disable any selected functions
 * registered with 'the_content' filter
 * 
 * @return void
 **/
function trueedit_plugin_init() {
	
	// enqueue scripts and styles if in admin post editor panel
	if (is_admin()) {
		$new_post = strpos($_SERVER['PHP_SELF'], '-new.php');
		$edit_post = isset($_REQUEST['post']);
		if ($new_post || $edit_post) {
			wp_enqueue_script('trueedit-javascript', plugins_url().'/trueedit/trueedit.js', array('jquery'), '1.4');
			wp_enqueue_style('trueedit-stylesheet', plugins_url().'/trueedit/trueedit.css', false, '1.4');
			add_action('admin_head', 'trueedit_editor_styles');
		}
	}
	
	// check that we are not in the plugin's options panel
	if (isset($_REQUEST['page']) == false || $_REQUEST['page'] != 'trueedit_options') {

		// retrieve the $wp_filter global and the plugins settings
		global $wp_filter;
		$options = get_option('trueedit_options');
		
		// loop through all active filters removing any that have been disabled
		if ( isset($wp_filter['the_content']) && isset($options['filters']) ) {
			foreach ($wp_filter['the_content'] as $filter_priority => $filters) {
				foreach ($filters as $function_name => $filter) {
					if (function_exists($function_name) && is_array($options['filters'])) {
						if (in_array($function_name, $options['filters'])) {
							if (has_filter('the_content', $function_name)) {
								remove_filter ('the_content', $function_name, $filter_priority);
							}
						}
					}
				}
			}		
		}
		
		
	}
}



/**
 * Register the plugin's options page in the Settings panel and the plugin panel
 *
 * @return void
 **/
function trueedit_admin_menu() {
	add_options_page('TRUEedit', 'TRUEedit', 'manage_options', 'trueedit_options', 'trueedit_admin_panel');
	add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'trueedit_plugin_action_links' );
}



/**
 * Create and return a html link to the plugin's options page
 *
 * @param array $links A global array of html settings links for plugins
 * @return array $links A global array of html settings links for plugins
 **/
function trueedit_plugin_action_links($links) {
	$settings_link = '<a href="options-general.php?page=trueedit_options">' . __('Settings') . '</a>';
	array_unshift($links, $settings_link);
	return $links;
}



/**
 * Display the plugin options and possibly save if the form was submitted.
 *
 * @return void
 **/
function trueedit_admin_panel() {
	$message = false;
	$error   = false;
	
	$built_in_filter_functions = array('capital_P_dangit', 'convert_chars', 'convert_smilies', 'do_shortcode', 'wpautop', 'wptexturize');
	
	global $wp_filter;
	
	$content_filters = array();
	if (isset($wp_filter['the_content'])) {
		foreach ($wp_filter['the_content'] as $filter_priority => $filters) {
			foreach ($filters as $function_name => $filter) {
				if (function_exists($function_name)) {
					$content_filters[] = $function_name;
				}
			}
		}		
	}
	sort($content_filters);
	
	if (isset($_POST['save'])) {
		$nonce_verified = wp_verify_nonce( $_REQUEST['_trueedit_save_nonce'], 'trueedit_save' );
		if ($nonce_verified) {
			$options['filters']           = isset($_POST['disable-filters'])? $_POST['disable-filters'] : array();
			$options['font-family']       = $_POST['font-family'];
			$options['font-size']         = $_POST['font-size'];
			$options['editor-height']     = $_POST['editor-height'];
			$options['font-color']        = $_POST['font-color'];
			$options['background-color']  = $_POST['background-color'];
			$options['editor-fullscreen'] = isset($_POST['show-fullscreen']);
			
			update_option('trueedit_options', $options);
			$message = __("Your settings have been updated.");
		}
		else {
			$error = __("The WordPress Nonce could not be verified, please reload this page and try again.");
		}
	}
	
	$options = get_option('trueedit_options');
	include_once('trueedit-admin-options.php');
}



/**
 * Register the contextual help for the plugin's options panel
 *
 * @param string $contextual_help The current contextual help string
 * @param string $screen_id The unique identifier for a screen
 * @param string $screen Another identifier for the screen
 * @return string $contextual_help The plugin's contextual help
 **/
function trueedit_contextual_help($contextual_help, $screen_id, $screen) {
	if ($screen_id == 'settings_page_trueedit_options') {
		include_once('trueedit-contextual-help.php');
	}
	return $contextual_help;
}



/**
 * Generate and echo the admin post editor modification styles and scripts, goes in admin header
 *
 * @return void
 **/
function trueedit_editor_styles() {
	$options = get_option('trueedit_options');
	$add_fullscreen = (isset($options['editor-fullscreen']) && $options['editor-fullscreen'] == true)? 'true' : 'false';
	
	$styles = '<style type="text/css">form #content { ';
	$styles .= (strlen($options['font-family']) > 1)? 'font-family:"'.$options['font-family'].'";' : '';
	$styles .= (strlen($options['font-size']) > 1)? 'font-size:'.$options['font-size'].';' : '';
	$styles .= (strlen($options['editor-height']) > 1)? 'height:'.$options['editor-height'].';' : '';
	$styles .= (strlen($options['font-color']) > 1)? 'color:'.$options['font-color'].';' : '';
	$styles .= (strlen($options['background-color']) > 1)? 'background-color:'.$options['background-color'].';' : '';
	$styles .= '</style>';
	
	$javascript = "<script type='text/javascript'>";
	$javascript .= "var add_fullscreen_button=$add_fullscreen; ";
	$javascript .= "var btn_label_one='".__('full screen editor')."'; ";
	$javascript .= "var btn_label_two='".__('back to normal view')."'; ";
	$javascript .= "</script>";
	
	echo $styles . "\n" . $javascript . "\n";
}



/**
 * Render the plugin credits
 *
 * @return void
 **/
function trueedit_give_credit() {
	echo __("<!-- TRUEedit 1.0 by Zachary Segal: http://www.illproductions.com -->");
}
