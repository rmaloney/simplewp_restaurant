<?php

// Callback.php

// Include the framework and config
require_once('./../../../wp-blog-header.php');
require_once('twitterFramework/twitteroauth.php');
require_once('config.php');

try {
	if (!isset($_GET['oauth_token'])) throw new Exception('The authorization token was not given.');
	
	$tokens = $wpdb->get_row($wpdb->prepare('SELECT auth_id, oauth_token, oauth_token_secret, status FROM ' . $wpdb->prefix . 'smp_twitter WHERE oauth_token = %s', $_GET['oauth_token']));
	
	if (is_null($tokens)) throw new Exception('The required data could not be loaded from the DB.');
	
	if (!isset($tokens->auth_id) || $tokens->auth_id < 1) throw new Exception('The authorization token could not be found in the database.');
	if ($tokens->status == 'verified') throw new Exception('The session has already been authorized.');
	
	// Create TwitteroAuth object with app key/secret and token key/secret from default phase
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $tokens->oauth_token, $tokens->oauth_token_secret);
	
	// Request access tokens from twitter
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	
	// Save the access tokens
	$wpdb->update($wpdb->prefix . 'smp_twitter', array('access_token' =>  serialize($access_token)), array('auth_id' => $tokens->auth_id), array('%s'), array('%d'));
	
	// Check the HTTP response was good
	if (200 == $connection->http_code) {
		// Save the access tokens. Normally these would be saved in a database for future use.
	$wpdb->update($wpdb->prefix . 'smp_twitter', array('status' =>  'verified'), array('auth_id' => $tokens->auth_id), array('%s'), array('%d'));
		
		header('Location: ' . get_bloginfo('url') . '/wp-admin/options-general.php?page=smp-twitter&action=done');
	} else {
		throw new Exception('Could not connect to Twitter.');
	}
} catch (Exception $e) {
	echo $e->getMessage() . ' Please make sure the details are correct and try again later. If the problem persists, contact an administrator.';
	exit;
}

?>