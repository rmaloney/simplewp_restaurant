<?php

function wpcf7_plugin_path( $path = '' ) {
	return path_join( WPCF7_PLUGIN_DIR, trim( $path, '/' ) );
}

function wpcf7_plugin_url( $path = '' ) {
	return plugins_url( $path, WPCF7_PLUGIN_BASENAME );
}

function wpcf7_admin_url( $query = array() ) {
	global $plugin_page;

	if ( ! isset( $query['page'] ) )
		$query['page'] = $plugin_page;

	$path = 'admin.php';

	if ( $query = build_query( $query ) )
		$path .= '?' . $query;

	$url = admin_url( $path );

	return esc_url_raw( $url );
}

function wpcf7() {
	global $wpdb, $wpcf7;

	if ( is_object( $wpcf7 ) )
		return;

	$wpcf7 = (object) array(
		'processing_within' => '',
		'widget_count' => 0,
		'unit_count' => 0,
		'global_unit_count' => 0 );
}

wpcf7();

require_once WPCF7_PLUGIN_DIR . '/includes/functions.php';
require_once WPCF7_PLUGIN_DIR . '/includes/formatting.php';
require_once WPCF7_PLUGIN_DIR . '/includes/pipe.php';
require_once WPCF7_PLUGIN_DIR . '/includes/shortcodes.php';
require_once WPCF7_PLUGIN_DIR . '/includes/classes.php';
require_once WPCF7_PLUGIN_DIR . '/includes/taggenerator.php';

if ( is_admin() )
	require_once WPCF7_PLUGIN_DIR . '/admin/admin.php';
else
	require_once WPCF7_PLUGIN_DIR . '/includes/controller.php';

add_action( 'plugins_loaded', 'wpcf7_set_request_uri', 9 );

function wpcf7_set_request_uri() {
	global $wpcf7_request_uri;

	$wpcf7_request_uri = add_query_arg( array() );
}

function wpcf7_get_request_uri() {
	global $wpcf7_request_uri;

	return (string) $wpcf7_request_uri;
}

/* Loading modules */

add_action( 'plugins_loaded', 'wpcf7_load_modules', 1 );

function wpcf7_load_modules() {
	$dir = WPCF7_PLUGIN_MODULES_DIR;

	if ( ! ( is_dir( $dir ) && $dh = opendir( $dir ) ) )
		return false;

	while ( ( $module = readdir( $dh ) ) !== false ) {
		if ( substr( $module, -4 ) == '.php' )
			include_once $dir . '/' . $module;
	}
}

/* L10N */

add_action( 'init', 'wpcf7_load_plugin_textdomain' );

function wpcf7_load_plugin_textdomain() {
	load_plugin_textdomain( 'wpcf7', false, 'contact-form-7/languages' );
}

/* Custom Post Type: Contact Form */

add_action( 'init', 'wpcf7_register_post_types' );

function wpcf7_register_post_types() {
	$args = array(
		'labels' => array(
			'name' => __( 'Contact Forms', 'wpcf7' ),
			'singular_name' => __( 'Contact Form', 'wpcf7' ) )
	);

	register_post_type( 'wpcf7_contact_form', $args );
}

/* Upgrading */

add_action( 'init', 'wpcf7_upgrade' );

function wpcf7_upgrade() {
	$opt = get_option( 'wpcf7' );

	if ( ! is_array( $opt ) )
		$opt = array();

	$old_ver = isset( $opt['version'] ) ? (string) $opt['version'] : '0';
	$new_ver = WPCF7_VERSION;

	if ( $old_ver == $new_ver )
		return;

	do_action( 'wpcf7_upgrade', $new_ver, $old_ver );

	$opt['version'] = $new_ver;

	update_option( 'wpcf7', $opt );

	if ( is_admin() && isset( $_GET['page'] ) && 'wpcf7' == $_GET['page'] ) {
		wp_redirect( wpcf7_admin_url( array( 'page' => 'wpcf7' ) ) );
		exit();
	}
}

add_action( 'wpcf7_upgrade', 'wpcf7_convert_to_cpt', 10, 2 );

function wpcf7_convert_to_cpt( $new_ver, $old_ver ) {
	global $wpdb;

	if ( ! version_compare( $old_ver, '3.0-dev', '<' ) )
		return;

	$table_name = $wpdb->prefix . "contact_form_7";

	if ( ! $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) )
		return;

	$old_rows = $wpdb->get_results( "SELECT * FROM $table_name" );

	foreach ( $old_rows as $row ) {
		$q = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_old_cf7_unit_id'"
			. $wpdb->prepare( " AND meta_value = %d", $row->cf7_unit_id );

		if ( $wpdb->get_var( $q ) )
			continue;

		$postarr = array(
			'post_type' => 'wpcf7_contact_form',
			'post_status' => 'publish',
			'post_title' => maybe_unserialize( $row->title ) );

		$post_id = wp_insert_post( $postarr );

		if ( $post_id ) {
			update_post_meta( $post_id, '_old_cf7_unit_id', $row->cf7_unit_id );
			update_post_meta( $post_id, 'form', maybe_unserialize( $row->form ) );
			update_post_meta( $post_id, 'mail', maybe_unserialize( $row->mail ) );
			update_post_meta( $post_id, 'mail_2', maybe_unserialize( $row->mail_2 ) );
			update_post_meta( $post_id, 'messages', maybe_unserialize( $row->messages ) );
			update_post_meta( $post_id, 'additional_settings',
				maybe_unserialize( $row->additional_settings ) );
		}
	}
}

/* Install and default settings */

add_action( 'activate_' . WPCF7_PLUGIN_BASENAME, 'wpcf7_install' );

function wpcf7_install() {
	if ( $opt = get_option( 'wpcf7' ) )
		return;

	wpcf7_load_plugin_textdomain();
	wpcf7_register_post_types();
	wpcf7_upgrade();

	if ( get_posts( array( 'post_type' => 'wpcf7_contact_form' ) ) )
		return;

	$contact_form = wpcf7_get_contact_form_default_pack(
		array( 'title' => sprintf( __( 'Contact form %d', 'wpcf7' ), 1 ) ) );

	$contact_form->save();
}

?>