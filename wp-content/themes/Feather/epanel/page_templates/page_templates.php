<?php 

/********* Page Templates v.1.8 ************/

define( 'ET_PT_PATH', get_template_directory_uri() . '/epanel/page_templates' );

add_action('wp_print_styles','et_ptemplates_css');
function et_ptemplates_css(){
	if ( !is_admin() && !(strstr( $_SERVER['PHP_SELF'], 'wp-login.php')) ) {
		echo('<link media="screen" type="text/css" href="'.ET_PT_PATH.'/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" />');
		echo("\n".'<link media="screen" type="text/css" href="'.ET_PT_PATH.'/page_templates.css" rel="stylesheet" />');
	}
}

add_action('wp_print_scripts','et_ptemplates_footer_js');
function et_ptemplates_footer_js(){
	if ( !is_admin() ) {
		wp_enqueue_script('easing', ET_PT_PATH . '/js/fancybox/jquery.easing-1.3.pack.js', array('jquery'), '1.3.4', true);
		wp_enqueue_script('fancybox', ET_PT_PATH . '/js/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery'), '1.3.4', true);
		wp_enqueue_script('et-ptemplates-frontend', ET_PT_PATH . '/js/et-ptemplates-frontend.js', array('jquery','fancybox'), '1.1', true);
	}
}

add_action( 'admin_enqueue_scripts', 'et_ptemplate_upload_categories_scripts' );
function et_ptemplate_upload_categories_scripts( $hook_suffix ) {
	if ( in_array($hook_suffix, array('post.php','post-new.php')) ) {
		wp_register_script('et-ptemplates', get_template_directory_uri().'/epanel/page_templates/js/et-ptemplates.js', array('jquery'));
		wp_enqueue_script('et-ptemplates');
	}
}

add_action("admin_init", "et_ptemplates_metabox");
function et_ptemplates_metabox(){
	add_meta_box("et_ptemplate_meta", "ET Page Template Settings", "et_ptemplate_meta", "page", "side");
}

if ( ! function_exists( 'et_ptemplate_meta' ) ){
	function et_ptemplate_meta($callback_args) {
		global $post;
		$temp_array = array();

		$temp_array = maybe_unserialize(get_post_meta($post->ID,'et_ptemplate_settings',true));
		
		$et_fullwidthpage = isset( $temp_array['et_fullwidthpage'] ) ? (bool) $temp_array['et_fullwidthpage'] : false;
		$et_regenerate_numbers = isset( $temp_array['et_regenerate_numbers'] ) ? (bool) $temp_array['et_regenerate_numbers'] : false;
		$et_ptemplate_blogstyle = isset( $temp_array['et_ptemplate_blogstyle'] ) ? (bool) $temp_array['et_ptemplate_blogstyle'] : false;
		$et_ptemplate_showthumb = isset( $temp_array['et_ptemplate_showthumb'] ) ? (bool) $temp_array['et_ptemplate_showthumb'] : false;
		$et_ptemplate_blogcats = isset( $temp_array['et_ptemplate_blogcats'] ) ? (array) $temp_array['et_ptemplate_blogcats'] : array();
		$et_ptemplate_gallerycats = isset( $temp_array['et_ptemplate_gallerycats'] ) ? (array) $temp_array['et_ptemplate_gallerycats'] : array();
		$et_ptemplate_blog_perpage = isset( $temp_array['et_ptemplate_blog_perpage'] ) ? (int) $temp_array['et_ptemplate_blog_perpage'] : 10;
		$et_ptemplate_gallery_perpage = isset( $temp_array['et_ptemplate_gallery_perpage'] ) ? (int) $temp_array['et_ptemplate_gallery_perpage'] : 10;
		$et_email_to = isset( $temp_array['et_email_to'] ) ? esc_attr( $temp_array['et_email_to'] ) : '';
		$et_ptemplate_showtitle = isset( $temp_array['et_ptemplate_showtitle'] ) ? (bool) $temp_array['et_ptemplate_showtitle'] : 1;
		$et_ptemplate_showdesc = isset( $temp_array['et_ptemplate_showdesc'] ) ? (bool) $temp_array['et_ptemplate_showdesc'] : 1;
		$et_ptemplate_detect_portrait = isset( $temp_array['et_ptemplate_detect_portrait'] ) ? (bool) $temp_array['et_ptemplate_detect_portrait'] : 1;
		$et_ptemplate_imagesize = isset( $temp_array['et_ptemplate_imagesize'] ) ? (int) $temp_array['et_ptemplate_imagesize'] : 2;	?>
		
		<div style="margin: 13px 0 11px 4px;" class="et_pt_info">
			<p>Additional settings appear here, when one of ET page templates is selected ( Page Attributes -> Template )</p>
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_sitemap et_pt_blog et_pt_gallery et_pt_search et_pt_login et_pt_contact et_pt_portfolio">
			<label class="selectit" for="et_fullwidthpage">
				<input type="checkbox" name="et_fullwidthpage" id="et_fullwidthpage" value=""<?php checked( $et_fullwidthpage ); ?> /> Full Width Page</label><br/>
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_contact">
			<label class="selectit" for="et_regenerate_numbers">
				<input type="checkbox" name="et_regenerate_numbers" id="et_regenerate_numbers" value=""<?php checked( $et_regenerate_numbers ); ?> /> Regenerate captcha numbers</label><br/>
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_contact">
			<label for="et_email_to" style="color: #000; font-weight: bold;"> Email To: </label>
			<input type="text" value="<?php echo $et_email_to; ?>" id="et_email_to" name="et_email_to" size="20" />
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_blog">
			<label class="selectit" for="et_ptemplate_blogstyle">
				<input type="checkbox" name="et_ptemplate_blogstyle" id="et_ptemplate_blogstyle" value=""<?php checked( $et_ptemplate_blogstyle ); ?> /> Blog Style mode</label><br/>
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_blog">
			<label class="selectit" for="et_ptemplate_showthumb">
				<input type="checkbox" name="et_ptemplate_showthumb" id="et_ptemplate_showthumb" value=""<?php checked( $et_ptemplate_showthumb ); ?> /> Hide Auto Thumbnail</label><br/>
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_portfolio">
			<label class="selectit" for="et_ptemplate_showtitle">
				<input type="checkbox" name="et_ptemplate_showtitle" id="et_ptemplate_showtitle" value=""<?php checked( $et_ptemplate_showtitle ); ?> /> Show Titles</label><br/>
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_portfolio">
			<label class="selectit" for="et_ptemplate_showdesc">
				<input type="checkbox" name="et_ptemplate_showdesc" id="et_ptemplate_showdesc" value=""<?php checked( $et_ptemplate_showdesc ); ?> /> Show Descriptions</label><br/>
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_portfolio">
			<label class="selectit" for="et_ptemplate_detect_portrait">
				<input type="checkbox" name="et_ptemplate_detect_portrait" id="et_ptemplate_detect_portrait" value=""<?php checked( $et_ptemplate_detect_portrait ); ?> /> Detect Portrait Images</label><br/>
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_portfolio">
			<p style="font-weight: bold; padding-bottom: 7px;">Thumbnail Size:</p>
			<label title="Small"><input type="radio" name="et_ptemplate_imagesize" value="1"<?php checked( $et_ptemplate_imagesize, 1 ); ?>> <span>Small</span></label><br><br>
			<label title="Medium"><input type="radio" name="et_ptemplate_imagesize" value="2"<?php checked( $et_ptemplate_imagesize, 2 ); ?>> <span>Medium</span></label><br><br>
			<label title="Large"><input type="radio" name="et_ptemplate_imagesize" value="3"<?php checked( $et_ptemplate_imagesize, 3 ); ?>> <span>Large</span></label>
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_blog">
			<label for="et_ptemplate_blog_perpage" style="color: #000; font-weight: bold;"> Number of posts per page: </label>
			<input type="text" class="small-text" value="<?php echo $et_ptemplate_blog_perpage; ?>" id="et_ptemplate_blog_perpage" name="et_ptemplate_blog_perpage" size="2" />
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_gallery et_pt_portfolio">
			<label for="et_ptemplate_gallery_perpage" style="color: #000; font-weight: bold;"> Number of posts per page: </label>
			<input type="text" class="small-text" value="<?php echo $et_ptemplate_gallery_perpage; ?>" id="et_ptemplate_gallery_perpage" name="et_ptemplate_gallery_perpage" size="2" />
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_blog">
			<h4>Select blog categories:</h4>
					
			<?php $cats_array = get_categories('hide_empty=0');
			$site_cats = array();
			foreach ($cats_array as $categs) {
				$checked = '';
				
				if (!empty($et_ptemplate_blogcats)) {
					if (in_array($categs->cat_ID, $et_ptemplate_blogcats)) $checked = "checked=\"checked\"";
				} ?>
				
				<label style="padding-bottom: 5px; display: block;" for="<?php echo 'et_ptemplate_blogcats-',$categs->cat_ID; ?>">
					<input type="checkbox" name="et_ptemplate_blogcats[]" id="<?php echo 'et_ptemplate_blogcats-',$categs->cat_ID; ?>" value="<?php echo ($categs->cat_ID); ?>" <?php echo $checked; ?> />
					<?php echo $categs->cat_name; ?>
				</label>							
			<?php } ?>
		</div>
		
		<div style="margin: 13px 0 11px 4px; display: none;" class="et_pt_gallery et_pt_portfolio">
			<h4>Select gallery categories:</h4>
					
			<?php $cats_array = get_categories('hide_empty=0');
			$site_cats = array();
			foreach ($cats_array as $categs) {
				$checked = '';
				
				if (!empty($et_ptemplate_gallerycats)) {
					if (in_array($categs->cat_ID, $et_ptemplate_gallerycats)) $checked = "checked=\"checked\"";
				} ?>
				
				<label style="padding-bottom: 5px; display: block;" for="<?php echo 'et_ptemplate_gallerycats-',$categs->cat_ID; ?>">
					<input type="checkbox" name="et_ptemplate_gallerycats[]" id="<?php echo 'et_ptemplate_gallerycats-',$categs->cat_ID; ?>" value="<?php echo ($categs->cat_ID); ?>" <?php echo $checked; ?> />
					<?php echo $categs->cat_name; ?>
				</label>							
			<?php } ?>
		</div>
		
		<?php
	}
}

add_action('save_post', 'et_ptemplate_save_details');
function et_ptemplate_save_details( $post_id ){
	global $pagenow;
	
	if ( 'post.php' != $pagenow ) return $post_id;

	$post_info = get_post( $post_id );
	if ( 'page' != $post_info->post_type )
		return $post_id;
			
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;

	if ( !isset( $_POST["page_template"] ) )
		return $post_id;
		
	if ( !in_array( $_POST["page_template"], array('page-blog.php', 'page-sitemap.php', 'page-gallery.php', 'page-search.php', 'page-login.php', 'page-contact.php', 'page-template-portfolio.php') ) )
		return $post_id;
		
	$temp_array = array();
	
	$temp_array['et_fullwidthpage'] = isset( $_POST["et_fullwidthpage"] ) ? 1 : 0;
	
	if ( 'page-blog.php' == $_POST["page_template"] ) {
		$temp_array['et_ptemplate_blogstyle'] = isset( $_POST["et_ptemplate_blogstyle"] ) ? 1 : 0;
		$temp_array['et_ptemplate_showthumb'] = isset( $_POST["et_ptemplate_showthumb"] ) ? 1 : 0;
		if (isset($_POST["et_ptemplate_blogcats"])) $temp_array['et_ptemplate_blogcats'] = $_POST["et_ptemplate_blogcats"];
		if (isset($_POST["et_ptemplate_blog_perpage"])) $temp_array['et_ptemplate_blog_perpage'] = $_POST["et_ptemplate_blog_perpage"];
	}
	
	if ( 'page-gallery.php' == $_POST["page_template"] ) {
		if (isset($_POST["et_ptemplate_gallerycats"])) $temp_array['et_ptemplate_gallerycats'] = $_POST["et_ptemplate_gallerycats"];
		if (isset($_POST["et_ptemplate_gallery_perpage"])) $temp_array['et_ptemplate_gallery_perpage'] = $_POST["et_ptemplate_gallery_perpage"];
	}
	
	if ( 'page-template-portfolio.php' == $_POST["page_template"] ) {
		if (isset($_POST["et_ptemplate_gallerycats"])) $temp_array['et_ptemplate_gallerycats'] = $_POST["et_ptemplate_gallerycats"];
		if (isset($_POST["et_ptemplate_gallery_perpage"])) $temp_array['et_ptemplate_gallery_perpage'] = $_POST["et_ptemplate_gallery_perpage"];
		$temp_array['et_ptemplate_showtitle'] = isset( $_POST["et_ptemplate_showtitle"] ) ? 1 : 0;
		$temp_array['et_ptemplate_showdesc'] = isset( $_POST["et_ptemplate_showdesc"] ) ? 1 : 0;
		$temp_array['et_ptemplate_detect_portrait'] = isset( $_POST["et_ptemplate_detect_portrait"] ) ? 1 : 0;
		$temp_array['et_ptemplate_imagesize'] = isset( $_POST["et_ptemplate_imagesize"] ) ? $_POST["et_ptemplate_imagesize"] : 2;
	}
	
	if ( 'page-contact.php' == $_POST["page_template"] ) {
		$temp_array['et_regenerate_numbers'] = isset( $_POST["et_regenerate_numbers"] ) ? 1 : 0;
		if (isset($_POST["et_email_to"])) $temp_array['et_email_to'] = $_POST["et_email_to"];
	}
	
	update_post_meta( $post_id, "et_ptemplate_settings", $temp_array );
} ?>