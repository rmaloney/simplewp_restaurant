<?php 
add_action( 'admin_enqueue_scripts', 'import_epanel_javascript' );
function import_epanel_javascript( $hook_suffix ) {
	if ( 'admin.php' == $hook_suffix && isset( $_GET['import'] ) && isset( $_GET['step'] ) && 'wordpress' == $_GET['import'] && '1' == $_GET['step'] )
		add_action( 'admin_head', 'admin_headhook' );
}

function admin_headhook(){ ?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$("p.submit").before("<p><input type='checkbox' id='importepanel' name='importepanel' value='1' style='margin-right: 5px;'><label for='importepanel'>Import epanel settings</label></p>");
		});
	</script>
<?php }

add_action('import_end','importend');
function importend(){
	global $wpdb, $shortname;
	
	#make custom fields image paths point to sampledata/sample_images folder
	$sample_images_postmeta = $wpdb->get_results("SELECT meta_id, meta_value FROM $wpdb->postmeta WHERE meta_value REGEXP 'http://et_sample_images.com'");
	if ( $sample_images_postmeta ) {
		foreach ( $sample_images_postmeta as $postmeta ){
			$template_dir = get_template_directory_uri();
			if ( is_multisite() ){
				switch_to_blog(1);
				$main_siteurl = site_url();
				restore_current_blog();
				
				$template_dir = $main_siteurl . '/wp-content/themes/' . get_template();
			}
			preg_match( '/http:\/\/et_sample_images.com\/([^.]+).jpg/', $postmeta->meta_value, $matches );
			$image_path = $matches[1];
			
			$local_image = preg_replace( '/http:\/\/et_sample_images.com\/([^.]+).jpg/', $template_dir . '/sampledata/sample_images/$1.jpg', $postmeta->meta_value );
			
			$local_image = preg_replace( '/s:55:/', 's:' . strlen( $template_dir . '/sampledata/sample_images/' . $image_path . '.jpg' ) . ':', $local_image );
			
			$wpdb->update( $wpdb->postmeta, array( 'meta_value' => $local_image ), array( 'meta_id' => $postmeta->meta_id ), array( '%s' ) );
		}
	}

	if ( !isset($_POST['importepanel']) )
		return;
	
	$importOptions = 'YTo4ODp7czoxNDoiY2hhbWVsZW9uX2xvZ28iO3M6MDoiIjtzOjE3OiJjaGFtZWxlb25fZmF2aWNvbiI7czowOiIiO3M6MTc6ImNoYW1lbGVvbl9iZ2NvbG9yIjtzOjA6IiI7czoyMzoiY2hhbWVsZW9uX2JndGV4dHVyZV91cmwiO3M6NzoiRGVmYXVsdCI7czoxNzoiY2hhbWVsZW9uX2JnaW1hZ2UiO3M6MDoiIjtzOjIxOiJjaGFtZWxlb25faGVhZGVyX2ZvbnQiO3M6NToiS3Jlb24iO3M6Mjc6ImNoYW1lbGVvbl9oZWFkZXJfZm9udF9jb2xvciI7czowOiIiO3M6MTk6ImNoYW1lbGVvbl9ib2R5X2ZvbnQiO3M6MTA6IkRyb2lkIFNhbnMiO3M6MjU6ImNoYW1lbGVvbl9ib2R5X2ZvbnRfY29sb3IiO3M6MDoiIjtzOjI3OiJjaGFtZWxlb25fc2hvd190d2l0dGVyX2ljb24iO3M6Mjoib24iO3M6MjM6ImNoYW1lbGVvbl9zaG93X3Jzc19pY29uIjtzOjI6Im9uIjtzOjI4OiJjaGFtZWxlb25fc2hvd19mYWNlYm9va19pY29uIjtzOjI6Im9uIjtzOjIxOiJjaGFtZWxlb25fdHdpdHRlcl91cmwiO3M6MToiIyI7czoxNzoiY2hhbWVsZW9uX3Jzc191cmwiO3M6MDoiIjtzOjIyOiJjaGFtZWxlb25fZmFjZWJvb2tfdXJsIjtzOjE6IiMiO3M6MjI6ImNoYW1lbGVvbl9jYXRudW1fcG9zdHMiO3M6MToiNiI7czoyNjoiY2hhbWVsZW9uX2FyY2hpdmVudW1fcG9zdHMiO3M6MToiNSI7czoyNToiY2hhbWVsZW9uX3NlYXJjaG51bV9wb3N0cyI7czoxOiI1IjtzOjIyOiJjaGFtZWxlb25fdGFnbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjE6ImNoYW1lbGVvbl9kYXRlX2Zvcm1hdCI7czo2OiJNIGosIFkiO3M6MjY6ImNoYW1lbGVvbl9uZXdfdGh1bWJfbWV0aG9kIjtzOjI6Im9uIjtzOjI4OiJjaGFtZWxlb25fc2hvd19jb250cm9sX3BhbmVsIjtzOjI6Im9uIjtzOjI0OiJjaGFtZWxlb25fZGlzcGxheV9ibHVyYnMiO3M6Mjoib24iO3M6MjM6ImNoYW1lbGVvbl9kaXNwbGF5X21lZGlhIjtzOjI6Im9uIjtzOjE1OiJjaGFtZWxlb25fcXVvdGUiO3M6Mjoib24iO3M6MTk6ImNoYW1lbGVvbl9xdW90ZV9vbmUiO3M6Nzc6IkNoYW1lbGVvbiBpcyBhbiBleHRyZW1lbHkgdmVyc2F0aWxlIHRoZW1lIHdpdGggYSBteXJpYWQgb2Ygb3B0aW9ucyBhbmQgc3R5bGVzIjtzOjE5OiJjaGFtZWxlb25fcXVvdGVfdHdvIjtzOjkxOiJBbGlxdWFtIHZlbmVuYXRpcyBlbmltIGluIG1pIGlhY3VsaXMgaW4gdGVtcG9yIGxlY3R1cyB0ZW1wb3IgZXQgY29udmFsbGlzIGVyYXQgcGVsbGVudGVzcXVlIjtzOjIxOiJjaGFtZWxlb25faG9tZV9wYWdlXzEiO3M6NToiQWJvdXQiO3M6MjE6ImNoYW1lbGVvbl9ob21lX3BhZ2VfMiI7czo5OiJXaGF0IEkgRG8iO3M6MjE6ImNoYW1lbGVvbl9ob21lX3BhZ2VfMyI7czo4OiJXaG8gSSBBbSI7czoyMToiY2hhbWVsZW9uX3Bvc3RzX21lZGlhIjtzOjI6IjEwIjtzOjIzOiJjaGFtZWxlb25fZXhsY2F0c19tZWRpYSI7YToxOntpOjA7czoyOiIxMyI7fXM6MjQ6ImNoYW1lbGVvbl9ob21lcGFnZV9wb3N0cyI7czoxOiI3IjtzOjE4OiJjaGFtZWxlb25fZmVhdHVyZWQiO3M6Mjoib24iO3M6MTk6ImNoYW1lbGVvbl9kdXBsaWNhdGUiO3M6Mjoib24iO3M6MjE6ImNoYW1lbGVvbl9zbGlkZXJfdHlwZSI7czo1OiJjeWNsZSI7czoxODoiY2hhbWVsZW9uX2ZlYXRfY2F0IjtzOjg6IkZlYXR1cmVkIjtzOjIyOiJjaGFtZWxlb25fZmVhdHVyZWRfbnVtIjtzOjE6IjMiO3M6MjY6ImNoYW1lbGVvbl9zbGlkZXJfYXV0b3NwZWVkIjtzOjQ6IjcwMDAiO3M6MTk6ImNoYW1lbGVvbl9tZW51cGFnZXMiO2E6MTp7aTowO3M6MzoiNzI0Ijt9czoyNjoiY2hhbWVsZW9uX2VuYWJsZV9kcm9wZG93bnMiO3M6Mjoib24iO3M6MTk6ImNoYW1lbGVvbl9ob21lX2xpbmsiO3M6Mjoib24iO3M6MjA6ImNoYW1lbGVvbl9zb3J0X3BhZ2VzIjtzOjEwOiJwb3N0X3RpdGxlIjtzOjIwOiJjaGFtZWxlb25fb3JkZXJfcGFnZSI7czozOiJhc2MiO3M6Mjc6ImNoYW1lbGVvbl90aWVyc19zaG93bl9wYWdlcyI7czoxOiIzIjtzOjE4OiJjaGFtZWxlb25fbWVudWNhdHMiO2E6Mzp7aTowO3M6MjoiMTQiO2k6MTtzOjI6IjE1IjtpOjI7czoxOiIxIjt9czozNzoiY2hhbWVsZW9uX2VuYWJsZV9kcm9wZG93bnNfY2F0ZWdvcmllcyI7czoyOiJvbiI7czoyNjoiY2hhbWVsZW9uX2NhdGVnb3JpZXNfZW1wdHkiO3M6Mjoib24iO3M6MzI6ImNoYW1lbGVvbl90aWVyc19zaG93bl9jYXRlZ29yaWVzIjtzOjE6IjMiO3M6MTg6ImNoYW1lbGVvbl9zb3J0X2NhdCI7czo0OiJuYW1lIjtzOjE5OiJjaGFtZWxlb25fb3JkZXJfY2F0IjtzOjM6ImFzYyI7czoxOToiY2hhbWVsZW9uX3Bvc3RpbmZvMiI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MjA6ImNoYW1lbGVvbl90aHVtYm5haWxzIjtzOjI6Im9uIjtzOjI3OiJjaGFtZWxlb25fc2hvd19wb3N0Y29tbWVudHMiO3M6Mjoib24iO3M6MTk6ImNoYW1lbGVvbl9wb3N0aW5mbzEiO2E6NDp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjtpOjI7czoxMDoiY2F0ZWdvcmllcyI7aTozO3M6ODoiY29tbWVudHMiO31zOjI2OiJjaGFtZWxlb25fdGh1bWJuYWlsc19pbmRleCI7czoyOiJvbiI7czoyMjoiY2hhbWVsZW9uX2NoaWxkX2Nzc3VybCI7czowOiIiO3M6MjQ6ImNoYW1lbGVvbl9jb2xvcl9tYWluZm9udCI7czowOiIiO3M6MjQ6ImNoYW1lbGVvbl9jb2xvcl9tYWlubGluayI7czowOiIiO3M6MjQ6ImNoYW1lbGVvbl9jb2xvcl9wYWdlbGluayI7czowOiIiO3M6MzE6ImNoYW1lbGVvbl9jb2xvcl9wYWdlbGlua19hY3RpdmUiO3M6MDoiIjtzOjI0OiJjaGFtZWxlb25fY29sb3JfaGVhZGluZ3MiO3M6MDoiIjtzOjI5OiJjaGFtZWxlb25fY29sb3Jfc2lkZWJhcl9saW5rcyI7czowOiIiO3M6MjE6ImNoYW1lbGVvbl9mb290ZXJfdGV4dCI7czowOiIiO3M6Mjc6ImNoYW1lbGVvbl9jb2xvcl9mb290ZXJsaW5rcyI7czowOiIiO3M6Mjg6ImNoYW1lbGVvbl9zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjM0OiJjaGFtZWxlb25fc2VvX2hvbWVfZGVzY3JpcHRpb250ZXh0IjtzOjA6IiI7czozMToiY2hhbWVsZW9uX3Nlb19ob21lX2tleXdvcmRzdGV4dCI7czowOiIiO3M6MjM6ImNoYW1lbGVvbl9zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6Mjc6ImNoYW1lbGVvbl9zZW9faG9tZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MzI6ImNoYW1lbGVvbl9zZW9fc2luZ2xlX2ZpZWxkX3RpdGxlIjtzOjk6InNlb190aXRsZSI7czozODoiY2hhbWVsZW9uX3Nlb19zaW5nbGVfZmllbGRfZGVzY3JpcHRpb24iO3M6MTU6InNlb19kZXNjcmlwdGlvbiI7czozNToiY2hhbWVsZW9uX3Nlb19zaW5nbGVfZmllbGRfa2V5d29yZHMiO3M6MTI6InNlb19rZXl3b3JkcyI7czoyNToiY2hhbWVsZW9uX3Nlb19zaW5nbGVfdHlwZSI7czoyMToiUG9zdCB0aXRsZSB8IEJsb2dOYW1lIjtzOjI5OiJjaGFtZWxlb25fc2VvX3NpbmdsZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MjQ6ImNoYW1lbGVvbl9zZW9faW5kZXhfdHlwZSI7czoyNDoiQ2F0ZWdvcnkgbmFtZSB8IEJsb2dOYW1lIjtzOjI4OiJjaGFtZWxlb25fc2VvX2luZGV4X3NlcGFyYXRlIjtzOjM6IiB8ICI7czozMzoiY2hhbWVsZW9uX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjMxOiJjaGFtZWxlb25faW50ZWdyYXRlX2JvZHlfZW5hYmxlIjtzOjI6Im9uIjtzOjM2OiJjaGFtZWxlb25faW50ZWdyYXRlX3NpbmdsZXRvcF9lbmFibGUiO3M6Mjoib24iO3M6Mzk6ImNoYW1lbGVvbl9pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyNjoiY2hhbWVsZW9uX2ludGVncmF0aW9uX2hlYWQiO3M6MDoiIjtzOjI2OiJjaGFtZWxlb25faW50ZWdyYXRpb25fYm9keSI7czowOiIiO3M6MzI6ImNoYW1lbGVvbl9pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozNToiY2hhbWVsZW9uX2ludGVncmF0aW9uX3NpbmdsZV9ib3R0b20iO3M6MDoiIjtzOjE5OiJjaGFtZWxlb25fNDY4X2ltYWdlIjtzOjA6IiI7czoxNzoiY2hhbWVsZW9uXzQ2OF91cmwiO3M6MDoiIjtzOjIxOiJjaGFtZWxlb25fNDY4X2Fkc2Vuc2UiO3M6MDoiIjt9';
	
	/*global $options;
	
	foreach ($options as $value) {
		if( isset( $value['id'] ) ) { 
			update_option( $value['id'], $value['std'] );
		}
	}*/
	
	$importedOptions = unserialize(base64_decode($importOptions));
	
	foreach ($importedOptions as $key=>$value) {
		if ($value != '') update_option( $key, $value );
	}
	
	update_option( $shortname . '_use_pages', 'false' );
} ?>