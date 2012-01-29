<?php


/********* ePanel v.2.5 ************/


/* Adds jquery script */
add_action('wp_print_scripts', 'et_jquery_script',8);
function et_jquery_script(){
	if ( function_exists('esc_attr') ) wp_enqueue_script('jquery'); 
	else {
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js', false, '1.4.2'); 
	}
}


/* Admin scripts + ajax jquery code */
if ( ! function_exists( 'et_epanel_admin_js' ) ){
	function et_epanel_admin_js(){
		$epanel_jsfolder = get_template_directory_uri() . '/epanel/js';
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-form');
		wp_enqueue_script('epanel_checkbox',$epanel_jsfolder . '/checkbox.js');
		wp_enqueue_script('epanel_functions_init',$epanel_jsfolder . '/functions-init.js');
		wp_localize_script( 'epanel_functions_init', 'ePanelSettings', array(
				'clearpath' => get_template_directory_uri() . '/epanel/images/empty.png',
				'epanel_nonce' => wp_create_nonce('epanel_nonce')
		));
		wp_enqueue_script('epanel_colorpicker',$epanel_jsfolder . '/colorpicker.js');
		wp_enqueue_script('epanel_eye',$epanel_jsfolder . '/eye.js');
	}
}
/* --------------------------------------------- */

/* Adds additional ePanel css */
if ( ! function_exists( 'et_epanel_css_admin' ) ){
	function et_epanel_css_admin() { ?> 
		<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/epanel/css/panel.css" type="text/css" />
		<style type="text/css">
		.lightboxclose { background: url("<?php echo get_template_directory_uri() ?>/epanel/images/description-close.png") no-repeat; width: 19px; height: 20px; }
		</style>
		<!--[if IE 7]>
		<style type="text/css">
			#epanel-save, #epanel-reset { font-size: 0px; display:block; line-height: 0px; bottom: 18px;}
			.box-desc { width: 414px; }
			.box-desc-content { width: 340px; }
			.box-desc-bottom { height: 26px; }
			#epanel-content .epanel-box input, #epanel-content .epanel-box select, .epanel-box textarea {  width: 395px; }
			#epanel-content .epanel-box select { width:434px !important;}
			#epanel-content .epanel-box .box-content { padding: 8px 17px 15px 16px; }
		</style>
		<![endif]-->  
		<!--[if IE 8]>
		<style type="text/css">
				#epanel-save, #epanel-reset { font-size: 0px; display:block; line-height: 0px; bottom: 18px;}
	</style>
		<![endif]-->  
	<?php }
}
/* --------------------------------------------- */

/* Save/Reset actions | Adds theme options to WP-Admin menu */
add_action('admin_menu', 'et_add_epanel');
function et_add_epanel() {
    global $themename, $shortname, $options;
	$epanel = basename(__FILE__);
	
	if ( isset($_GET['page']) && $_GET['page'] == $epanel && isset($_REQUEST['action']) ) {
		epanel_save_data( 'js_disabled' ); //saves data when javascript is disabled
	}
	
    $core_page = add_theme_page($themename." Options", $themename." Theme Options", 'switch_themes', basename(__FILE__), 'et_build_epanel');
	
	add_action( "admin_print_scripts-{$core_page}", 'et_epanel_admin_js' );
	
	add_action("admin_head-{$core_page}", 'et_epanel_css_admin');
}
/* --------------------------------------------- */

/* Displays ePanel */
if ( ! function_exists( 'et_build_epanel' ) ){
	function et_build_epanel() {

		global $themename, $shortname, $options, $et_disabled_jquery;
		
		if (isset($_REQUEST['saved'])) {
			if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
		};
		if (isset($_REQUEST['reset'])) {
			if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
		};
		
	?>

		<div id="wrapper">
		  <div id="panel-wrap">
			<form method="post" id="main_options_form" enctype="multipart/form-data">
				<div id="epanel-wrapper">
					<div id="epanel">
						<div id="epanel-content-wrap">
							<div id="epanel-content">
								<img src="<?php echo get_template_directory_uri() ?>/epanel/images/logo.png" alt="ePanel" class="pngfix" id="epanel-logo" />
								<?php 
									global $epanelMainTabs;
									$epanelMainTabs = apply_filters( 'epanel_page_maintabs', $epanelMainTabs );
								?>
								<ul id="epanel-mainmenu">
									<?php if(in_array('general',$epanelMainTabs)) { ?>
										<li><a href="#wrap-general"><img src="<?php echo get_template_directory_uri() ?>/epanel/images/general-icon.png" class="pngfix" alt="" />General Settings</a></li>
									<?php }; ?>
									<?php if(in_array('navigation',$epanelMainTabs)) { ?>
										<li><a href="#wrap-navigation"><img src="<?php echo get_template_directory_uri() ?>/epanel/images/navigation-icon.png" class="pngfix" alt="" />Navigation</a></li>
									<?php }; ?>
									<?php if(in_array('layout',$epanelMainTabs)) { ?>
										<li><a href="#wrap-layout"><img src="<?php echo get_template_directory_uri() ?>/epanel/images/layout-icon.png" class="pngfix" alt="" />Layout Settings</a></li>
									<?php }; ?>
									<?php if(in_array('ad',$epanelMainTabs)) { ?>
										<li><a href="#wrap-advertisements"><img src="<?php echo get_template_directory_uri() ?>/epanel/images/ad-icon.png" class="pngfix" alt="" />Ad Management</a></li>
									<?php }; ?>
									<?php if(in_array('colorization',$epanelMainTabs)) { ?>
										<li><a href="#wrap-colorization"><img src="<?php echo get_template_directory_uri() ?>/epanel/images/colorization-icon.png" class="pngfix" alt="" />Colorization</a></li>
									<?php }; ?>
									<?php if(in_array('seo',$epanelMainTabs)) { ?>
										<li><a href="#wrap-seo"><img src="<?php echo get_template_directory_uri() ?>/epanel/images/seo-icon.png" class="pngfix" alt="" />SEO</a></li>
									<?php }; ?>
									<?php if(in_array('integration',$epanelMainTabs)) { ?>
										<li><a href="#wrap-integration"><img src="<?php echo get_template_directory_uri() ?>/epanel/images/integration-icon.png" class="pngfix" alt="" />Integration</a></li>
									<?php }; ?>
									<?php if(in_array('support',$epanelMainTabs)) { ?>
										<li><a href="#wrap-support"><img src="<?php echo get_template_directory_uri() ?>/epanel/images/support-icon.png" class="pngfix" alt="" />Support Docs</a></li>
									<?php }; ?>
									<?php do_action( 'epanel_render_maintabs',$epanelMainTabs ); ?>
								</ul><!-- end epanel mainmenu -->

		<?php 
			foreach ($options as $value) {
				if (($value['type'] == "text") || ($value['type'] == "textlimit") || ($value['type'] == "textarea") || ($value['type'] == "select") || ($value['type'] == "checkboxes") || ($value['type'] == "different_checkboxes") || ($value['type'] == "colorpicker") || ($value['type'] == "textcolorpopup") || ($value['type'] == "upload")) { ?>
					<div class="epanel-box">
						<div class="box-title">
							<h3><?php echo esc_html($value['name']); ?></h3>
							<img src="<?php echo get_template_directory_uri() ?>/epanel/images/help-image.png" alt="description" class="box-description" />
							<div class="box-descr">
								<p><?php echo esc_html($value['desc']); ?></p>
							</div> <!-- end box-desc-content div -->
						</div> <!-- end div box-title -->
						
						<div class="box-content">
				
							<?php if ($value['type'] == "text") { ?>
							
								<input name="<?php echo esc_attr($value['id']); ?>" id="<?php echo esc_attr($value['id']); ?>" type="<?php echo esc_attr($value['type']); ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo esc_attr( stripslashes(get_option( $value['id']) ) ) ; } else { echo esc_attr(stripslashes($value['std'])); } ?>" />
								
							<?php } elseif ($value['type'] == "textlimit") { ?>
							
								<input name="<?php echo esc_attr($value['id']); ?>" id="<?php echo esc_attr($value['id']); ?>" type="text" maxlength="<?php echo esc_attr($value['max']); ?>" size="<?php echo esc_attr($value['max']); ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo esc_attr( stripslashes(get_option( $value['id'] ) ) ); } else { echo esc_attr(stripslashes($value['std'])); } ?>" />
								
							<?php } elseif ($value['type'] == "colorpicker") { ?>
							
								<div id="colorpickerHolder"></div>
								
							<?php } elseif ($value['type'] == "textcolorpopup") { ?>
							
								<input name="<?php echo esc_attr($value['id']); ?>" id="<?php echo esc_attr($value['id']); ?>" class="colorpopup" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo esc_attr(get_option( $value['id'] )); } else { echo esc_attr($value['std']); } ?>" />
								
							<?php } elseif ($value['type'] == "textarea") { ?>
							
								<textarea name="<?php echo esc_attr($value['id']); ?>" id="<?php echo esc_attr($value['id']); ?>"><?php if ( get_option( $value['id'] ) != "") { echo esc_textarea( stripslashes( get_option( $value['id'] ) ) ); } else { echo esc_textarea( stripslashes( $value['std'] ) ); } ?></textarea>
								
							<?php } elseif ($value['type'] == "upload") { ?>
									
									<input id="<?php echo esc_attr($value['id']); ?>" class="uploadfield" type="text" size="90" name="<?php echo esc_attr($value['id']); ?>" value="<?php echo esc_url(get_option($value['id'])); ?>" />
									<div class="upload_buttons">
										<span class="upload_image_reset">Reset</span>
										<input class="upload_image_button" type="button" value="Upload Image" />
									</div>
									
									<div class="clear"></div>
											
							<?php } elseif ($value['type'] == "select") { ?>
							
								<select name="<?php echo esc_attr($value['id']); ?>" id="<?php echo esc_attr($value['id']); ?>">
									<?php foreach ($value['options'] as $option) { ?>
										<option<?php if ( esc_attr( stripslashes( get_option( $value['id'] ) ) ) == trim( esc_attr( stripslashes(($option)) ) ) ) { echo ' selected="selected"'; } elseif ( !get_option( $value['id'] ) && isset($value['std']) && esc_attr( stripslashes($option) ) == esc_attr( stripslashes($value['std']) ) ) { echo ' selected="selected"'; } ?>><?php echo esc_html(trim($option)); ?></option>
									<?php } ?>
								</select>
								
							<?php } elseif ($value['type'] == "checkboxes") {
							
								if (empty($value['options'])) {
									echo("You don't have pages");
								} else {
									$i = 1;
									$className = 'inputs';
									if ( isset($value['excludeDefault']) && $value['excludeDefault'] == 'true' ) $className = $className . ' different';
									
									foreach ($value['options'] as $option) {
										$checked = "";
										
										if (get_option( $value['id'])) {
											if (in_array($option, get_option( $value['id'] ))) $checked = "checked=\"checked\"";
										} ?>
										
										<p class="<?php echo $className; ?><?php if ($i%3 == 0) echo(' last'); ?>"><input type="checkbox" class="usual-checkbox" name="<?php echo esc_attr($value['id']); ?>[]" id="<?php echo esc_attr($value['id']),"-",esc_attr($option); ?>" value="<?php echo esc_attr($option); ?>" <?php echo $checked; ?> />
										<label for="<?php echo esc_attr($value['id']),"-",esc_attr($option); ?>"><?php if ($value['usefor']=='pages') echo get_pagename($option); else echo get_categname($option); ?></label>
										</p>
										<?php if ($i%3 == 0) echo('<br class="clearfix"/>');?>
								  <?php $i++; }
								}; ?>
								<br class="clearfix"/>
								
							<?php } elseif ($value['type'] == "different_checkboxes") {
							
								foreach ($value['options'] as $option) {
									$checked = "";
									if ( get_option( $value['id']) !== false ) {
										if (in_array($option, get_option( $value['id'] ))) $checked = "checked=\"checked\"";
									} elseif ( isset($value['std']) ) {
										if ( in_array($option, $value['std']) ) $checked = "checked=\"checked\"";
									} ?>
									<p class="<?php echo ("postinfo-".esc_attr($option)) ?>"><input type="checkbox" class="usual-checkbox" name="<?php echo esc_attr($value['id']); ?>[]" id="<?php echo (esc_attr($value['id'])."-".esc_attr($option)); ?>" value="<?php echo esc_attr($option); ?>" <?php echo $checked; ?> />
									</p>
								<?php } ?>
								<br class="clearfix"/>
								
							<?php } ?>
				
						</div> <!-- end box-content div -->
					</div> <!-- end epanel-box div -->
					
				<?php } elseif (($value['type'] == "checkbox") || ($value['type'] == "checkbox2")) { ?>

					<div class="epanel-box <?php if ($value['type'] == "checkbox") { echo('epanel-box-small-1'); } else { echo('epanel-box-small-2'); } ?>">
						<div class="box-title"><h3><?php echo esc_html($value['name']); ?></h3>
							<img src="<?php echo get_template_directory_uri() ?>/epanel/images/help-image.png" alt="description" class="box-description" />
							<div class="box-descr">
								<p><?php echo esc_html($value['desc']); ?></p>
							</div> <!-- end box-desc-content div -->
						</div> <!-- end div box-title -->
						<div class="box-content">
							<?php 
								$checked = '';
								if((get_option($value['id'])) <> '') {
									if((get_option($value['id'])) == 'on') { $checked = 'checked="checked"'; }
									else { $checked = ''; }
								}
								elseif ($value['std'] == 'on') { $checked = 'checked="checked"'; }
							?>
							<input type="checkbox" class="checkbox" name="<?php echo esc_attr($value['id']);?>" id="<?php echo esc_attr($value['id']);?>" <?php echo($checked); ?> />
						</div> <!-- end box-content div -->
					</div> <!-- end epanel-box-small div -->
					
				<?php } elseif ($value['type'] == "support") { ?>
						
					<div class="inner-content">
						<?php include(TEMPLATEPATH . "/includes/functions/".$value['name'].".php"); ?>
					</div>
						
				<?php } elseif (($value['type'] == "contenttab-wrapstart") || ($value['type'] == "subcontent-start")) { ?>

					<div id="<?php echo esc_attr($value['name']); ?>" class="<?php if ($value['type'] == "contenttab-wrapstart") {echo('content-div');} else {echo('tab-content');} ?>">
						
				<?php } elseif (($value['type'] == "contenttab-wrapend") || ($value['type'] == "subcontent-end")) { ?>

					</div> <!-- end <?php echo esc_attr($value['name']); ?> div -->
						
				<?php } elseif ($value['type'] == "subnavtab-start") { ?>

					<ul class="idTabs">
						
				<?php } elseif ($value['type'] == "subnavtab-end") { ?>

					</ul>
						
				<?php } elseif ($value['type'] == "subnav-tab") { ?>

					<li><a href="#<?php echo esc_attr($value['name']); ?>"><span class="pngfix"><?php echo esc_html($value['desc']); ?></span></a></li>
						
				<?php } elseif ($value['type'] == "clearfix") { ?>
						
					<div class="clearfix"></div>

				<?php } ?>

			<?php } //end foreach ($options as $value) ?>
				
							</div> <!-- end epanel-content div -->
						</div> <!-- end epanel-content-wrap div -->
					</div> <!-- end epanel div -->
				</div> <!-- end epanel-wrapper div -->
				
				<div id="epanel-bottom">
					<input name="save" type="submit" value="Save changes" id="epanel-save" />
					<input type="hidden" name="action" value="save_epanel" />
				
					<img src="<?php echo get_template_directory_uri() ?>/epanel/images/defaults.png" class="defaults-button" alt="no" />   
				</div><!-- end epanel-bottom div -->
				
			</form>
			 
			<div style="clear: both;"></div>
			<div style="position: relative;">
				<div class="defaults-hover">
					This will return all of the settings throughout the options page to their default values. <strong>Are you sure you want to do this?</strong>
					<div class="clearfix"></div>
					<form method="post">
						<?php wp_nonce_field('et-nojs-reset_epanel'); ?>
						<input name="reset" type="submit" value="Reset" id="epanel-reset" />
						<input type="hidden" name="action" value="reset" />
					</form>
					<img src="<?php echo get_template_directory_uri() ?>/epanel/images/no.gif" class="no" alt="no" />
				</div> 
			</div>

			</div> <!-- end panel-wrap div -->
		</div> <!-- end wrapper div -->
			
		<div id="epanel-ajax-saving">
			<img src="<?php echo get_template_directory_uri() ?>/epanel/images/saver.gif" alt="loading" id="loading" />
			<span>Saving...</span>
		</div>
			
	<?php
	}
}
/* --------------------------------------------- */

/*
global $options, $value, $shortname;
foreach ($options as $value) {
	if (isset($value['id'])) {
		if ( get_option( $value['id'] ) === FALSE) {
			if (array_key_exists('std', $value)) { 
				update_option( $value['id'], $value['std'] );
				$$value['id'] = $value['std'];
			}
		} else {
			$$value['id'] = get_option( $value['id'] ); }
	}
}
*/

add_action('wp_ajax_save_epanel', 'et_epanel_save_callback');
function et_epanel_save_callback() {
    check_ajax_referer("epanel_nonce");
	epanel_save_data( 'ajax' );

	die();
}

if ( ! function_exists( 'epanel_save_data' ) ){
	function epanel_save_data( $source ){
		global $options;
		
		if ( !current_user_can('switch_themes') )
			die('-1');
		
		$epanel = basename(__FILE__);
		
		if ( isset($_REQUEST['action']) ) {
			
			#$valuesArray = array();
			
			if ( 'save_epanel' == $_REQUEST['action'] ) {
				foreach ($options as $value) {
					if( isset( $value['id'] ) ) { 
						if( isset( $_REQUEST[ $value['id'] ] ) ) {
							if ( in_array( $value['type'], array('text','textlimit','select','textcolorpopup','checkbox','checkbox2') ) ) 
								update_option( $value['id'], stripslashes( esc_html($_REQUEST[$value['id']]) ) );
							elseif ( $value['type'] == 'upload' )
								update_option( $value['id'], stripslashes( esc_url( $_REQUEST[$value['id']] ) ) );
							elseif ( $value['type'] == 'textarea' )
								update_option( $value['id'], stripslashes( $_REQUEST[$value['id']] ) );
							elseif ( in_array( $value['type'], array('checkboxes','different_checkboxes') ) )
								update_option( $value['id'], stripslashes_deep( array_map('esc_html', $_REQUEST[$value['id']]) ) );
						}
						else {
							if ( in_array( $value['type'], array('checkbox','checkbox2') ) ) update_option( $value['id'] , 'false' );
							elseif ($value['type'] == 'different_checkboxes') {
								update_option( $value['id'] , array() );
							}
							else delete_option( $value['id'] );
						}
					}
					
					/*if ( isset( $value['id'] ) && isset( $_POST[$value['id']] ) ) {
						$valuesArray[$value['id']] = $_POST[$value['id']];
					}*/
				}
				#print_r(base64_encode(serialize($valuesArray))); exit;
				if ( $source == 'js_disabled' ) header("Location: themes.php?page=$epanel&saved=true");
				die('1');
				
			} else if( 'reset' == $_REQUEST['action'] ) {
				check_admin_referer('et-nojs-reset_epanel');
				
				foreach ($options as $value) {
					if ( isset($value['id']) ) {
						delete_option( $value['id'] );
						if ( isset($value['std']) ) update_option( $value['id'], $value['std'] );
					}
				}
				
				header("Location: themes.php?page=$epanel&reset=true");
				die('1');
			}
		}
	}
}

function et_epanel_media_upload_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', get_template_directory_uri().'/epanel/js/custom_uploader.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
}
	 
function et_epanel_media_upload_styles() {
	wp_enqueue_style('thickbox');
}

global $pagenow; 
if ( 'themes.php' == $pagenow && isset($_GET['page']) && ($_GET['page'] == basename(__FILE__)) ) {
	add_action('admin_print_scripts', 'et_epanel_media_upload_scripts');
	add_action('admin_print_styles', 'et_epanel_media_upload_styles');
} ?>