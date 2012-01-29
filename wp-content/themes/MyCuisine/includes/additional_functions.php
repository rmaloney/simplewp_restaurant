<?php 

/* Meta boxes */

function et_mycuisine_settings(){
	add_meta_box("et_post_meta", "ET Settings", "mycuisine_post_meta", "page", "normal", "high");
	add_meta_box("et_post_meta", "ET Settings", "mycuisine_post_meta", "post", "normal", "high");
}
add_action("admin_init", "et_mycuisine_settings");

function mycuisine_post_meta($callback_args) {
	global $post;
	
	$post_type = $callback_args->post_type;
	$temp_array = array();

	$temp_array = maybe_unserialize(get_post_meta($post->ID,'_et_mycuisine_settings',true));
			
	$et_is_featured = isset( $temp_array['et_is_featured'] ) ? (bool) $temp_array['et_is_featured'] : false;
	$et_fs_variation = isset( $temp_array['et_fs_variation'] ) ? (int) $temp_array['et_fs_variation'] : 1;
	$et_fs_bgcolor = isset( $temp_array['et_fs_bgcolor'] ) ? $temp_array['et_fs_bgcolor'] : '';
	$et_fs_custom_excerpt = isset( $temp_array['et_fs_custom_excerpt'] ) ? $temp_array['et_fs_custom_excerpt'] : '';
	$et_fs_button = isset( $temp_array['et_fs_button'] ) ? $temp_array['et_fs_button'] : '';
	$et_fs_link = isset( $temp_array['et_fs_link'] ) ? $temp_array['et_fs_link'] : ''; ?>
	
	<div id="et_custom_settings" style="margin: 13px 0 17px 4px;">
		<label class="selectit" for="et_is_featured" style="font-weight: bold;">
			<input type="checkbox" name="et_is_featured" id="et_is_featured" value=""<?php checked( $et_is_featured ); ?> /> This <?php echo esc_html($post_type); ?> is Featured</label><br/>
		
		<div id="et_settings_featured_options" style="margin-top: 12px;">
			
			<div class="et_fs_setting" style="display: none; margin: 13px 0 26px 4px;">
				<label for="et_fs_variation" style="color: #000; font-weight: bold;"> Description: </label>				
				<select id="et_fs_variation" name="et_fs_variation">
					<option value="1" <?php selected( $et_fs_variation, 1 ); ?>>on the left side</option>
					<option value="2" <?php selected( $et_fs_variation, 2 ); ?>>on the right side</option>
				</select>
				<br />
			</div>
			
			<div class="et_fs_setting" style="display: none; margin: 13px 0 26px 4px;">
				<label for="et_fs_bgcolor" style="color: #000; font-weight: bold;"> Background Color: </label>
				<br />
				#<input type="text" style="width: 30em;" value="<?php echo esc_attr($et_fs_bgcolor); ?>" id="et_fs_bgcolor" name="et_fs_bgcolor" size="67" />
				<br />
				<small style="position: relative; top: 8px;">ex: <code>000000</code></small>
			</div>
						
			<div class="et_fs_setting" style="display: none; margin: 13px 0 26px 4px;">
				<label for="et_fs_custom_excerpt" style="color: #000; font-weight: bold;"> Custom Excerpt Text: </label>
				<br />
				<textarea id="et_fs_custom_excerpt" name="et_fs_custom_excerpt" cols="40" rows="1" style="display: inline; position: relative; top: 5px; width: 490px; height: 125px;"><?php echo esc_textarea($et_fs_custom_excerpt); ?></textarea>
				<br />
			</div>
			
			<div class="et_fs_setting" style="display: none; margin: 13px 0 26px 4px;">
				<label for="et_fs_button" style="color: #000; font-weight: bold;"> Custom Button Text: </label>
				<input type="text" style="width: 30em;" value="<?php echo esc_attr($et_fs_button); ?>" id="et_fs_button" name="et_fs_button" size="67" />
				<br />
				<small style="position: relative; top: 8px;">ex: <code><?php echo htmlspecialchars("Read More");?></code></small>
			</div>
			
			<div class="et_fs_setting" style="display: none; margin: 13px 0 26px 4px;">
				<label for="et_fs_link" style="color: #000; font-weight: bold;"> Custom Read More Link: </label>
				<input type="text" style="width: 30em;" value="<?php echo esc_url($et_fs_link); ?>" id="et_fs_link" name="et_fs_link" size="67" />
				<br />
			</div>
			
		</div> <!-- #et_settings_featured_options -->
		
	</div> <!-- #et_custom_settings -->
		
	<?php
}

add_action('save_post', 'mycuisine_custom_panel_save');
function mycuisine_custom_panel_save($post_id){
	global $pagenow;
	
	if ( 'post.php' != $pagenow ) return $post_id;
		
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
		
	$temp_array = array();
		
	if ( !isset($_POST['et_is_featured']) ) {
		if ( get_post_meta( $post_id, "_et_mycuisine_settings", true ) ) $temp_array = maybe_unserialize( get_post_meta( $post_id, "_et_mycuisine_settings", true ) ); 
		$temp_array['et_is_featured'] = 0;
		update_post_meta( $post_id, "_et_mycuisine_settings", $temp_array );
		
		return $post_id;
	}
	
	$temp_array['et_is_featured'] = isset( $_POST["et_is_featured"] ) ? 1 : 0;
	$temp_array['et_fs_variation'] = isset($_POST["et_fs_variation"]) ? (int) $_POST["et_fs_variation"] : '';
	$temp_array['et_fs_bgcolor'] = isset($_POST["et_fs_bgcolor"]) ? esc_attr($_POST["et_fs_bgcolor"]) : '';
	$temp_array['et_fs_custom_excerpt'] = isset($_POST["et_fs_custom_excerpt"]) ? $_POST["et_fs_custom_excerpt"] : '';
	$temp_array['et_fs_button'] = isset($_POST["et_fs_button"]) ? esc_attr($_POST["et_fs_button"]) : '';
	$temp_array['et_fs_link'] = isset($_POST["et_fs_link"]) ? esc_url($_POST["et_fs_link"]) : '';
			
	update_post_meta( $post_id, "_et_mycuisine_settings", $temp_array );
}

add_action( 'admin_enqueue_scripts', 'upload_etsettings_metabox_scripts' );
function upload_etsettings_metabox_scripts( $hook_suffix ) {
	if ( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {
		wp_register_script('et-categories', get_bloginfo('template_directory').'/js/et-categories.js', array('jquery'));
		wp_enqueue_script('et-categories');
	}
}

add_action('init', 'et_mycuisine_testimonial_register');
function et_mycuisine_testimonial_register() {
	$labels = array(
		'name' => _x('Testimonials', 'post type general name'),
		'singular_name' => _x('Testimonials', 'post type singular name'),
		'add_new' => _x('Add Testimonial', 'testimonial item'),
		'add_new_item' => __('Add Testimonial'),
		'edit_item' => __('Edit Testimonial'),
		'new_item' => __('New Testimonial'),
		'view_item' => __('View Testimonial'),
		'search_items' => __('Search Testimonial'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','excerpt','comments','revisions','custom-fields'),
		'taxonomies' => array('category', 'post_tag')
	); 
 
	register_post_type( 'testimonial' , $args );
	register_taxonomy_for_object_type('category', 'testimonial');
    register_taxonomy_for_object_type('post_tag', 'testimonial');
}
?>