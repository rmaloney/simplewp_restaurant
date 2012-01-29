<?php

/*
Plugin Name: Auto Post Thumbnail
Plugin URI: http://www.sanisoft.com/blog/2010/04/19/wordpress-plugin-automatic-post-thumbnail/
Description: Automatically generate the Post Thumbnail (Featured Thumbnail) from the first image in post (or any custom post type) only if Post Thumbnail is not set manually.
Version: 3.2.3
Author: Aditya Mooley <adityamooley@sanisoft.com>
Author URI: http://www.sanisoft.com/blog/author/adityamooley/
*/

/*  Copyright 2009  Aditya Mooley  (email : adityamooley@sanisoft.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


add_action('publish_post', 'apt_publish_post');

// This hook will now handle all sort publishing including posts, custom types, scheduled posts, etc.
add_action('transition_post_status', 'apt_check_required_transition');

add_action('admin_notices', 'apt_check_perms');
add_action('admin_menu', 'apt_add_admin_menu'); // Add batch process capability
add_action('admin_enqueue_scripts', 'apt_admin_enqueues'); // Plugin hook for adding CSS and JS files required for this plugin
add_action('wp_ajax_generatepostthumbnail', 'apt_ajax_process_post'); // Hook to implement AJAX request

// Register the management page
function apt_add_admin_menu() {
    add_options_page('Auto Post Thumbnail', 'Auto Post Thumbnail', 'manage_options', 'generate-post-thumbnails', 'apt_interface');
}

/**
 * Admin user interface plus post thumbnail generator
 * 
 * Most of the code in this function is copied from - 
 * Regenerate Thumbnails plugin (http://www.viper007bond.com/wordpress-plugins/regenerate-thumbnails/)
 * 
 * @return void
 */
function apt_interface() {
    global $wpdb;
?>
<div id="message" class="updated fade" style="display:none"></div>

<div class="wrap genpostthumbs">
    <h2>Generate Post Thumbnails</h2>
    
<?php 
    // If the button was clicked
        if ( !empty($_POST['generate-post-thumbnails']) ) {
            // Capability check
            if ( !current_user_can('manage_options') )
                wp_die('Cheatin&#8217; uh?');

            // Form nonce check
            check_admin_referer( 'generate-post-thumbnails' );
            
            // Get id's of all the published posts for which post thumbnails does not exist.
            $query = "SELECT * FROM {$wpdb->posts} p where p.post_status = 'publish' AND p.ID NOT IN (
                        SELECT DISTINCT post_id FROM {$wpdb->postmeta} WHERE meta_key IN ('_thumbnail_id', 'skip_post_thumb')
                      )";
            $posts = $wpdb->get_results($query);
            
            if (empty($posts)) {
                echo '<p>Currently there are no published posts available to generate thumbnails.</p>';
            } else {
                echo '<p>We are generating post thumbnails. Please be patient!</p>';
                
                // Generate the list of IDs
                $ids = array();
                foreach ( $posts as $post )
                    $ids[] = $post->ID;
                $ids = implode( ',', $ids );

                $count = count( $posts );
?>
    <noscript><p><em>You must enable Javascript in order to proceed!</em></p></noscript>

    <div id="genpostthumbsbar" style="position:relative;height:25px;">
        <div id="genpostthumbsbar-percent" style="position:absolute;left:50%;top:50%;width:50px;margin-left:-25px;height:25px;margin-top:-9px;font-weight:bold;text-align:center;"></div>
    </div>

    <script type="text/javascript">
    // <![CDATA[
        jQuery(document).ready(function($){
            var i;
            var rt_images = [<?php echo $ids; ?>];
            var rt_total = rt_images.length;
            var rt_count = 1;
            var rt_percent = 0;

            $("#genpostthumbsbar").progressbar();
            $("#genpostthumbsbar-percent").html( "0%" );

            function genPostThumb( id ) {
                $.post( "admin-ajax.php", { action: "generatepostthumbnail", id: id }, function() {
                    rt_percent = ( rt_count / rt_total ) * 100;
                    $("#genpostthumbsbar").progressbar( "value", rt_percent );
                    $("#genpostthumbsbar-percent").html( Math.round(rt_percent) + "%" );
                    rt_count = rt_count + 1;

                    if ( rt_images.length ) {
                        genPostThumb( rt_images.shift() );
                    } else {
                        $("#message").html("<p><strong><?php echo js_escape( sprintf('All done! Processed %d posts.', $count ) ); ?></strong></p>");
                        $("#message").show();
                    }

                });
            }

            genPostThumb( rt_images.shift() );
        });
    // ]]>
    </script>
<?php
            }
        } else {
?>
    
    <p>Use this tool to generate Post Thumbnail (Featured Thumbnail) for your Published posts.</p>
    <p>If the script stops executing for any reason, just <strong>Reload</strong> the page and it will continue from where it stopped.</p>

    <form method="post" action="">
<?php wp_nonce_field('generate-post-thumbnails') ?>


    <p><input type="submit" class="button hide-if-no-js" name="generate-post-thumbnails" id="generate-post-thumbnails" value="Generate Thumbnails" /></p>

    <noscript><p><em>You must enable Javascript in order to proceed!</em></p></noscript>

    </form>
    <p>Note: Thumbnails won't be generated for posts that already have post thumbnail or <strong><em>skip_post_thumb</em></strong> custom field set.</p>
<?php } ?>
</div>
<?php
} //End apt_interface()

/**
 * Add our JS and CSS files
 * 
 * @param $hook_suffix
 * @return void
 */
function apt_admin_enqueues($hook_suffix) {
    if ( 'settings_page_generate-post-thumbnails' != $hook_suffix ) {
        return;
    }

    // WordPress 3.1 vs older version compatibility
	if ( wp_script_is( 'jquery-ui-widget', 'registered' ) ) {
		wp_enqueue_script( 'jquery-ui-progressbar', plugins_url( 'jquery-ui/jquery.ui.progressbar.min.js', __FILE__ ), array( 'jquery-ui-core', 'jquery-ui-widget' ), '1.7.2' );
	}
	else {
		wp_enqueue_script( 'jquery-ui-progressbar', plugins_url( 'jquery-ui/ui.progressbar.js', __FILE__ ), array( 'jquery-ui-core' ), '1.7.2' );
	}
			
    wp_enqueue_style( 'jquery-ui-genpostthumbs', plugins_url( 'jquery-ui/redmond/jquery-ui-1.7.2.custom.css', __FILE__ ), array(), '1.7.2' );
} //End apt_admin_enqueues

/**
 * Process single post to generate the post thumbnail
 * 
 * @return void
 */
function apt_ajax_process_post() {
    if ( !current_user_can( 'manage_options' ) ) {
        die('-1');
    }    

    $id = (int) $_POST['id'];

    if ( empty($id) ) {
        die('-1');
    }

    set_time_limit( 60 );
    
    // Pass on the id to our 'publish' callback function.
    apt_publish_post($id);
    
    die(-1);
} //End apt_ajax_process_post()


/**
 * Check whether the required directory structure is available so that the plugin can create thumbnails if needed.
 * If not, don't allow plugin activation.
 */
function apt_check_perms() {
    $uploads = wp_upload_dir(current_time('mysql'));

    if ($uploads['error']) {
        echo '<div class="updated"><p>';
        echo $uploads['error'];

        if ( function_exists('deactivate_plugins') ) {
            deactivate_plugins('auto-post-thumbnail/auto-post-thumbnail.php', 'auto-post-thumbnail.php' );
            echo '<br /> This plugin has been automatically deactivated.';
        }

        echo '</p></div>';
    }
}

/**
 * Function to check whether scheduled post is being published. If so, apt_publish_post should be called.
 * 
 * @param $new_status
 * @param $old_status
 * @param $post
 * @return void
 */
function apt_check_required_transition($new_status='', $old_status='', $post='') {
    global $post_ID; // Using the post id from global reference since it is not available in $post object. Strange!

    if ('publish' == $new_status) {
        apt_publish_post($post_ID);
    }
}

/**
 * Function to save first image in post as post thumbmail.
 */
function apt_publish_post($post_id)
{
    global $wpdb;

    // First check whether Post Thumbnail is already set for this post.
    if (get_post_meta($post_id, '_thumbnail_id', true) || get_post_meta($post_id, 'skip_post_thumb', true)) {
        return;
    }

    $post = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE id = $post_id");

    // Initialize variable used to store list of matched images as per provided regular expression
    $matches = array();

    // Get all images from post's body
    preg_match_all('/<\s*img [^\>]*src\s*=\s*[\""\']?([^\""\'>]*)/i', $post[0]->post_content, $matches);

    if (count($matches)) {
        foreach ($matches[0] as $key => $image) {
            /**
             * If the image is from wordpress's own media gallery, then it appends the thumbmail id to a css class.
             * Look for this id in the IMG tag.
             */
            preg_match('/wp-image-([\d]*)/i', $image, $thumb_id);
            $thumb_id = $thumb_id[1];
            
            // If thumb id is not found, try to look for the image in DB. Thanks to "Erwin Vrolijk" for providing this code.
            if (!$thumb_id) {
                $image = substr($image, strpos($image, '"')+1);
                $result = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE guid = '".$image."'");
                $thumb_id = $result[0]->ID;
            }

            // Ok. Still no id found. Some other way used to insert the image in post. Now we must fetch the image from URL and do the needful.
            if (!$thumb_id) {
                $thumb_id = apt_generate_post_thumb($matches, $key, $post[0]->post_content, $post_id);
            }

            // If we succeed in generating thumg, let's update post meta
            if ($thumb_id) {
                update_post_meta( $post_id, '_thumbnail_id', $thumb_id );
                break;
            }
        }
    }
}// end apt_publish_post()

/**
 * Function to fetch the image from URL and generate the required thumbnails
 */
function apt_generate_post_thumb($matches, $key, $post_content, $post_id)
{
    // Make sure to assign correct title to the image. Extract it from img tag
    $imageTitle = '';
    preg_match_all('/<\s*img [^\>]*title\s*=\s*[\""\']?([^\""\'>]*)/i', $post_content, $matchesTitle);

    if (count($matchesTitle) && isset($matchesTitle[1])) {
        $imageTitle = $matchesTitle[1][$key];
    }

    // Get the URL now for further processing
    $imageUrl = $matches[1][$key];

    // Get the file name
    $filename = substr($imageUrl, (strrpos($imageUrl, '/'))+1);

    if (!(($uploads = wp_upload_dir(current_time('mysql')) ) && false === $uploads['error'])) {
        return null;
    }

    // Generate unique file name
    $filename = wp_unique_filename( $uploads['path'], $filename );

    // Move the file to the uploads dir
    $new_file = $uploads['path'] . "/$filename";
    
    if (!ini_get('allow_url_fopen')) {
        $file_data = curl_get_file_contents($imageUrl);
    } else {
        $file_data = @file_get_contents($imageUrl);
    }
    
    if (!$file_data) {
        return null;
    }
    
    file_put_contents($new_file, $file_data);

    // Set correct file permissions
    $stat = stat( dirname( $new_file ));
    $perms = $stat['mode'] & 0000666;
    @ chmod( $new_file, $perms );

    // Get the file type. Must to use it as a post thumbnail.
    $wp_filetype = wp_check_filetype( $filename, $mimes );

    extract( $wp_filetype );

    // No file type! No point to proceed further
    if ( ( !$type || !$ext ) && !current_user_can( 'unfiltered_upload' ) ) {
        return null;
    }

    // Compute the URL
    $url = $uploads['url'] . "/$filename";

    // Construct the attachment array
    $attachment = array(
        'post_mime_type' => $type,
        'guid' => $url,
        'post_parent' => null,
        'post_title' => $imageTitle,
        'post_content' => '',
    );

    $thumb_id = wp_insert_attachment($attachment, $file, $post_id);
    if ( !is_wp_error($thumb_id) ) {
        require_once(ABSPATH . '/wp-admin/includes/image.php');
        
        wp_update_attachment_metadata( $thumb_id, wp_generate_attachment_metadata( $thumb_id, $new_file ) );

        return $thumb_id;
    }

    return null;
}

/**
 * Function to fetch the contents of URL using curl in absense of allow_url_fopen.
 * 
 * Copied from user comment on php.net (http://in.php.net/manual/en/function.file-get-contents.php#82255)
 */
function curl_get_file_contents($URL) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) {
        return $contents;
    }
    
    return FALSE;
}