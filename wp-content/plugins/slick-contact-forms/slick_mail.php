<?php

require_once("../../../wp-config.php");
require_once('dcwp_slick_contact.php');

$action = $_POST['action'];

if ($action == "submit") {

	// Get redirect URLs
	$redirect = dc_jqslickcontact_widget::get_dcscf_default('redirect');
	$refSuccess = dc_jqslickcontact_widget::get_dcscf_default('redirect_success') != '' ? dc_jqslickcontact_widget::get_dcscf_default('redirect_success') : $_SERVER['HTTP_REFERER'] ;
	$refError = dc_jqslickcontact_widget::get_dcscf_default('redirect_error') != '' ? dc_jqslickcontact_widget::get_dcscf_default('redirect_error') : $_SERVER['HTTP_REFERER'] ;

	// retrieve from parameters
	$label1 = isset($_POST["label1"]) ? $_POST["label1"] : "";
	$label2 = isset($_POST["label2"]) ? $_POST["label2"] : "";
	$label3 = isset($_POST["label3"]) ? $_POST["label3"] : "";
	$valid1 = isset($_POST["valid1"]) ? $_POST["valid1"] : "";
	$valid2 = isset($_POST["valid2"]) ? $_POST["valid2"] : "";
	$valid3 = isset($_POST["valid3"]) ? $_POST["valid3"] : "";
	$input1 = isset($_POST["input1"]) ? stripslashes($_POST["input1"]) : "";
	$input2 = isset($_POST["input2"]) ? stripslashes($_POST["input2"]) : "";
	$input3 = isset($_POST["input3"]) ? stripslashes($_POST["input3"]) : "";
	$comments = isset($_POST["comments"]) ? stripslashes($_POST["comments"]) : "";
	$labelText = isset($_POST["labelText"]) ? $_POST["labelText"] : "";
	$tabText = isset($_POST["tabText"]) ? $_POST["tabText"] : "";
	$emailTo = isset($_POST["emailTo"]) ? $_POST["emailTo"] : "";
	$nocomment = isset($_POST["nocomment"]) ? $_POST["nocomment"] : "";

	$key = isset($_POST["key"]) ? $_POST["key"] : "";
	
	$subject = (dc_jqslickcontact_widget::get_dcscf_default('subject') == '') ? get_option('blogname'): dc_jqslickcontact_widget::get_dcscf_default('subject');
	$subject .= ' '.$tabText;
	
	// make sure the key matches
	if ($key == dc_jqslickcontact_widget::token()) {
			
		// Honeypot captcha
		
		if($nocomment == '') {
		
			$replyTo = '';
			$text1 = '';
			if($input1 != ''){
				$text1 = $label1.': '.$input1;
				if($valid1 == '2'){
					$replyTo = $input1;
				}
			}
			$text2 = '';
			if($input2 != ''){
				$text2 = $label2.': '.$input2;
				if($valid2 == '2'){
					$replyTo = $input2;
				}
			}
			$text3 = '';
			if($input3 != ''){
				$text3 = $label3.': '.$input3;
				if($valid3 == '2'){
					$replyTo = $input3;
				}
			}
			$text4 = '';
			if($comments != ''){
				$text4 = $labelText.': '.$comments;
			}
			
			// Check if required fields are empty
			$error = '';
			if($valid1 == '1'){
				$error .= $input1 == '' ? 'error' : '';
			}
			if($valid2 == '1'){
				$error .= $input2 == '' ? 'error' : '';
			}
			if($valid3 == '1'){
				$error .= $input3 == '' ? 'error' : '';
			}
			
			// If required fields empty return error message otherwise send email
			if($error == ''){
				$response = sendEmail($tabText, $subject, $message, $emailTo, $text1, $text2, $text3, $text4, $replyTo);
			} else {
				if($redirect == 'redirect') {
					$response = $refError;
				} else {
					$response = (dc_jqslickcontact_widget::get_dcscf_default('response_invalid') == '') ? "There was an error verifying your details.": dc_jqslickcontact_widget::get_dcscf_default('response_invalid');
				}
			}
			
		} else {
			if($redirect == 'redirect') {
					$response = $refError;
				} else {
					$response = (dc_jqslickcontact_widget::get_dcscf_default('response_invalid') == '') ? "There was an error verifying your details.": dc_jqslickcontact_widget::get_dcscf_default('response_invalid');
				}
		
		}
	}
	else {
		if($redirect == 'redirect') {
			$response = $refError;
		} else {
			$response = (dc_jqslickcontact_widget::get_dcscf_default('response_invalid') == '') ? "There was an error verifying your details.": dc_jqslickcontact_widget::get_dcscf_default('response_invalid');
		}
	}
	if($redirect == 'redirect') {
		header("Location: ".$response);
	} else {
		echo $response;
	}
}

// Run server-side validation
function sendEmail($name, $subject, $content, $emailTo, $text1, $text2, $text3, $text4, $replyTo) {

	global $redirect, $refSuccess, $refError; 
	// filter
	$name = filter($name);
	$subject =  filter($subject);
	$url = dc_jqslickcontact_widget::get_dcscf_default('include_url') ? "Origin Page: ".$_SERVER['HTTP_REFERER'] : "";
	$ip = dc_jqslickcontact_widget::get_dcscf_default('include_ip') ? "IP Address: ".$_SERVER["REMOTE_ADDR"] : "";
	$defaultEmail = (dc_jqslickcontact_widget::get_dcscf_default('default_email') == '') ? get_option('admin_email'): dc_jqslickcontact_widget::get_dcscf_default('default_email');
	
	$message = "$text1\r\n$text2\r\n$text3\r\n$text4\r\n\n$ip\r\n$url";
	
	$emails = explode(',', $emailTo);
	
	$emailTo = '';
	$i = 0;
	foreach($emails as $email){
	
		$emailTo .= $i > 0 ? ',' : '' ;
		$emailTo .= filter($email);
		
		// Validate return email & inform admin
		
		if (!validateSlickEmail(trim($email))) {
			$subject .= " - Invalid Return Email";
			$message = "Return Email: '".$email."'\n\nForm Submitted:\n\n".$message;
			$to = $defaultEmail;
		}
		$i++;
	} 
	
	$to = $emailTo;

	// Validate reply to email
	if($replyTo != ''){
		$replyTo = filter($replyTo);
		if (!validateSlickEmail($replyTo)) {
			$replyTo = '';
		}
	}
	
	// Setup final message
	$body = wordwrap($message);
	
	$emailFrom = $to;
	if(dc_jqslickcontact_widget::get_dcscf_default('email_user') == 'true' && $replyTo != ''){
		$emailFrom = $replyTo;
	}
	
	// Create headers
	$headers = "From: $emailFrom\n";
	$headers .= $replyTo != '' ? "Reply-To: $replyTo\n" : "" ;
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/plain; charset=utf-8\r\n";
	$headers .= "Content-Transfer-Encoding: quoted-printable\r\n";
	
	// Send email
	if(dc_jqslickcontact_widget::get_dcscf_default('wpmail') == 'true'){
	
		$mail_sent = wp_mail( $to, $subject, $body, $headers);
		
	} else {
		
		$mail_sent = @mail($to, $subject, $body, $headers);
		
	}
	
	if($redirect == 'redirect') {
		return $mail_sent ? $refSuccess : $refError;
	} else {
		$sent = (dc_jqslickcontact_widget::get_dcscf_default('response_sent') == '') ?"Thank you. Your comments have been received." :dc_jqslickcontact_widget::get_dcscf_default('response_sent');
		$error = (dc_jqslickcontact_widget::get_dcscf_default('response_error') == '') ?"Error. Please try again." :dc_jqslickcontact_widget::get_dcscf_default('response_error');
		return $mail_sent ? $sent : dc_jqslickcontact_widget::get_dcscf_default('response_error');
	}
}

// Remove any un-safe values to prevent email injection
function filter($value) {
	$pattern = array("/\n/", "/\r/", "/content-type:/i", "/to:/i", "/from:/i", "/cc:/i");
	$value = preg_replace($pattern, "", $value);
	return $value;
}

// Validate email address format in case client-side validation "fails"
function validateSlickEmail($email) {
	$at = strrpos($email, "@");

	// Check (@) sybmol and location
	if ($at && ($at < 1 || ($at + 1) == strlen($email)))
		return false;

	// Check double periods
	if (preg_match("/(\.{2,})/", $email))
		return false;

	// split email and domain & check length
	$local = substr($email, 0, $at);
	$domain = substr($email, $at + 1);
	$locLen = strlen($local);
	$domLen = strlen($domain);
	if ($locLen < 1 || $locLen > 64 || $domLen < 4 || $domLen > 255)
		return false;

	// Check use of period at end
	if (preg_match("/(^\.|\.$)/", $local) || preg_match("/(^\.|\.$)/", $domain))
		return false;

	if (!preg_match('/^"(.+)"$/', $local)) {
		// check for valid characters
		if (!preg_match('/^[-a-zA-Z0-9!#$%*\/?|^{}`~&\'+=_\.]*$/', $local))
			return false;
	}

	// Domain - valid characters & min one period
	if (!preg_match('/^[-a-zA-Z0-9\.]*$/', $domain) || !strpos($domain, "."))
		return false;	

	return true;
}

exit;

?>