<?php
/*
Plugin Name: Social Media Pack - Twitter Module
Plugin URI: http://www.socialmediapack.co.uk
Description: The social media pack automatically sends your wordpress posts onto twitter
Version: 1.2
Author: Matt Porter / Nick Rogers
Author URI: http://www.mattporter.com
License: GPL2
*/

/*  Copyright 2010  Matt Porter Web Design Limited

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

register_activation_hook(__FILE__, 'smp_twitter_install');
add_action('admin_menu', 'smp_twitter_add_options');
add_action('publish_post', 'sendToTwitter');

function smp_twitter_add_options() {
	add_options_page('SMP - Twitter', 'SMP - Twitter', 'manage_options', 'smp-twitter', 'smp_twitter_page');
}

// Installation function
function smp_twitter_install() {
	global $wpdb;

	// Create the table if it doesn't exist
	$table_name = $wpdb->prefix . 'smp_twitter';
	if ($wpdb->get_var('show tables like \'' . $table_name . '\'') != $table_name) {
		$sql = 'CREATE TABLE ' . $table_name . ' (
			auth_id int(11) NOT NULL AUTO_INCREMENT,
			oauth_token VARCHAR(255) NOT NULL,
			oauth_token_secret VARCHAR(255) NOT NULL,
			access_token mediumtext NOT NULL,
			status VARCHAR(255) NOT NULL,
			UNIQUE KEY id (auth_id)
		);';

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		add_option('smp_twitter_db_version', 1.0);
   }
}

function smp_twitter_page() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	global $wpdb;

	$action = (isset($_GET['action']) ? $_GET['action'] : '');

	if ($action == '') {
		echo '<div class="wrap" style="padding-top: 30px; font-weight: bold;">Click on the twitter logo if you wish to authorize and link your twitter account with this website. <a href="options-general.php?page=smp-twitter&action=auth"><img src="http://twitter-badges.s3.amazonaws.com/twitter-b.png" style="display: inline; border: 0;" alt="" /></a><br /><br />';

		try {
			// Get the twitter access keys
			$access_token = $wpdb->get_row('SELECT access_token FROM ' . $wpdb->prefix . 'smp_twitter WHERE status = "verified" ORDER BY auth_id DESC LIMIT 1');

			// Check they were found in the db
			if (!is_null($access_token)) {
				// Unserialize them back into an array
				$access_token = unserialize($access_token->access_token);

				// Include the config and the library
				require_once('twitterFramework/twitteroauth.php');
				require('config.php');

				// Create a new connection to twitter
				$connection = new TwitterOAuth($_TWITTER['CONSUMER_KEY'], $_TWITTER['CONSUMER_SECRET'], $access_token['oauth_token'], $access_token['oauth_token_secret']);
				$content = $connection->get('account/verify_credentials');

				if (!isset($content->screen_name)) throw new Exception;

				echo 'The account "' . $content->screen_name . '" is currently linked and authorized, if you wish to link this website with a different account, click on the button above.';
			} else
				throw new Exception;
		} catch (Exception $e) {
			echo 'There are currently no accounts linked with this website.';
		}

		echo '</div>';
	} elseif ($action == 'done') {
		echo '<div class="wrap" style="padding-top: 30px; font-weight: bold;">Done! Your site is now logged into <img src="http://twitter-badges.s3.amazonaws.com/twitter-b.png" style="display: inline;" alt="" />, feel free to start posting.</div>';
	} elseif ($action == 'auth') {
		// Include the framework and config
		require_once('twitterFramework/twitteroauth.php');
		require_once('config.php');

		// Connect to twitter
		$connection = new TwitterOAuth($_TWITTER['CONSUMER_KEY'], $_TWITTER['CONSUMER_SECRET']);

		// Get the temporary credentials
		$request_token = $connection->getRequestToken($_TWITTER['OAUTH_CALLBACK']);

		// Check if the connection succeeded
		try {
			switch ($connection->http_code) {
				case 200:
					// Save the temporary credentials
					$wpdb->insert($wpdb->prefix . 'smp_twitter', array('oauth_token' => $request_token['oauth_token'], 'oauth_token_secret' => $request_token['oauth_token_secret'], 'access_token' => '', 'status' => 'incomplete'), array('%s', '%s', '%s', '%s'));

					// Check they were saved
					if ($wpdb->insert_id < 1) throw new Exception('The information could not be stored in the database.');

					// Build authorization URL and redirect user to Twitter
					echo '<div class="wrap" style="padding-top: 30px; font-weight: bold;">You will now be redirected to the <img src="http://twitter-badges.s3.amazonaws.com/twitter-b.png" style="display: inline;" alt="" /> website.</div>
					<script type="text/javascript">
					<!--
						window.location = "' . $connection->getAuthorizeURL($request_token['oauth_token']) . '"
					//-->
					</script>';
					break;
				default:
					throw new Exception('Could not connect to Twitter.');
			}
		} catch (Exception $e) {
			echo $e->getMessage() . ' Please make sure the details are correct and try again later. If the problem persists, contact an administrator.';
		}
	}
}

// Main twitter update function
function sendToTwitter($postID) {
	global $wpdb;

	// Get the twitter access keys
	$access_token = $wpdb->get_row('SELECT access_token FROM ' . $wpdb->prefix . 'smp_twitter WHERE status = "verified" ORDER BY auth_id DESC LIMIT 1');

	// Check they were found in the db
	if (!is_null($access_token)) {
		// Unserialize them back into an array
		$access_token = unserialize($access_token->access_token);

		// Include the config and the library
		require_once('twitterFramework/twitteroauth.php');
		require('config.php');

		// Create a new connection to twitter
		$connection = new TwitterOAuth($_TWITTER['CONSUMER_KEY'], $_TWITTER['CONSUMER_SECRET'], $access_token['oauth_token'], $access_token['oauth_token_secret']);

		// Get the content of the post
		$post = get_post($postID);

		// Generate a short URL from is.gd
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://is.gd/api.php?longurl='.$post->guid);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$shorturl = curl_exec($ch);
		curl_close($ch);

		// Concatenate the Title, Contents and URL together, truncating the contents and title where necessary
		$length = 140 - strlen($shorturl);
		if (strlen($post->post_title) + 3 > $length)
			$title = substr($post->post_title, 0, $length - 3) . '.. ';
		else
			$title = $post->post_title . ' - ';

		$length = $length - strlen($title);

		if ($length > 10 && $length <= strlen($post->post_content))
			$content = substr($post->post_content, 0, $length - 3) . '.. ';
		else if ($length > strlen($post->post_content))
			$content = $post->post_content . ' ';
		else
			$content = '';
		$status = strip_tags($title) . strip_tags($content) . $shorturl;

		// Send the new status to twitter
		$status = $connection->post('statuses/update', array('status' => $status));
	}
}

?>