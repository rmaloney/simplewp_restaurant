<?php
require_once('dcwp_plugin_admin.php');

if(!class_exists('dc_jqslickcontact_admin')) {
	
	class dc_jqslickcontact_admin extends dcwp_plugin_admin_dcscf {
	
		var $hook = 'slick-contact-forms';
		var $longname = 'Slick Contact Forms Configuration';
		var $shortname = 'Slick Contact Forms';
		var $filename = 'slick-contact-forms/dcwp_slick_contact.php';
		var $homepage = 'http://www.designchemical.com/blog/index.php/wordpress-plugin-slick-contact-forms/';
		var $homeshort = 'http://bit.ly/jUtiFX';
		var $twitter = 'designchemical';
		var $title = 'Wordpress plugin Slick Contact Forms';
		var $description = 'Quick and easy customisable contact forms in a slide out or floating tab';
		
		function __construct() {
		
			parent::__construct();
			add_action('admin_init', array(&$this,'settings_init'));
			
		}
		 
		function settings_init() {
		
			register_setting('dcscf_options_group', 'dcscf_options');
		
		}
		
		// Plugin specific side info box
		function info_box() {}
		
		function option_page() {
			
			$this->setup_admin_page('Slick Contact Forms Settings','Slick Contact Forms Configuration Settings');
			
			// Set defaults
			$email =  get_option('admin_email');
			$subject = get_option('blogname');
			$response_sent = "Thank you. Your comments have been received.";
			$response_error = "Error. Please try again.";
			$response_invalid = "There was an error verifying your details.";
			$valid_error = "Required";
			$valid_email = "Enter a valid email";
			
		?>
		<?php if (!empty($message)) : ?>
			<div id="message" class="updated fade"><p><strong><?php echo $message ?></strong></p></div>
		<?php endif; ?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#dcscf_redirect').change(function(){
				var redirect = $('#dcscf_redirect option:selected').val();
				$('.redirect-hide').hide();
				$('.redirect-'+redirect).show();
			});
			$('.hide-init').hide();
		});
		</script>
		<p class="dcwp-intro">For instructions on how to configure this plugin check out the <a target="_blank" href="http://www.designchemical.com/blog/index.php/wordpress-plugin-slick-contact-forms/"><?php echo $this->shortname; ?> project page</a>.</p>
		
		<form method="post" id="dcscf_settings_page" class="dcwp-form" action="options.php">
			
			<?php 
				settings_fields('dcscf_options_group'); $options = get_option('dcscf_options'); 
				$redirect = isset($options['redirect']) ?  $options['redirect'] : 'ajax';
				$hideAjax = $redirect == 'redirect' ? ' hide-init' : '' ;
				$hideRedirect = $redirect == 'ajax' ? ' hide-init' : '' ;
			?>
				<ul>
				
					<li>
						<label for="dcscf_default_email">Default Email Address:</label>
						<input type="text" id="dcscf_default_email" class="dcwp-input-m" name="dcscf_options[default_email]" value="<?php echo isset($options['default_email']) ? $options['default_email'] : $email; ?>" />
					
						<span class="description dcwp-note">Default email address for receiving submitted forms. <br />Each individual form can also be set via the widget control panel.</span>
					</li>
					
					<li>
						<label for="dcscf_subject">Email Subject:</label>
						<input type="text" name="dcscf_options[subject]" id="dcscf_subject" class="dcwp-input-m" value="<?php echo isset($options['subject']) ?  $options['subject'] : $subject; ?>" />
						<span class="description dcwp-note">The subject line for the email sent to the admin email</span>
					</li>
					
					<?php $email_user = isset($options['email_user']) ?  $options['email_user'] : 'false'; ?>
					
					<li>
						<label for="dcscf_email_user">Send From User Email:</label>
					    <input name="dcscf_options[email_user]" type="checkbox" id="dcscf_email_user" class="dcwp-checkbox" value="true" <?php checked($email_user,'true'); ?> /> <span class="description">Check this option to use the visitors email address in the email "from" field - in order for this to work at least one of the form input fields "status" must be set to "email"</span>
					</li>
					
					<?php $include_ip = isset($options['include_ip']) ?  $options['include_ip'] : 'false'; ?>
					
					<li>
						<label for="dcscf_include_ip">Include IP Address?</label>
					    <input name="dcscf_options[include_ip]" type="checkbox" id="dcscf_include_ip" class="dcwp-checkbox" value="true" <?php checked($include_ip,'true'); ?> /> <span class="description">Check this option to include the users IP address in all sent emails</span>
					</li>
					
					<?php $include_url = isset($options['include_url']) ?  $options['include_url'] : 'false'; ?>
					
					<li>
						<label for="dcscf_include_url">Include Page URL?</label>
					    <input name="dcscf_options[include_url]" type="checkbox" id="dcscf_include_url" class="dcwp-checkbox" value="true" <?php checked($include_url,'true'); ?> /> <span class="description">Check this option to include the URL of the page that was used to send the form</span>
					</li>
					
					<?php $wpmail = isset($options['wpmail']) ?  $options['wpmail'] : 'false'; ?>
					
					<li>
						<label for="dcscf_wpmail">Use wp_mail()</label>
					    <input name="dcscf_options[wpmail]" type="checkbox" id="dcscf_wpmail" class="dcwp-checkbox" value="true" <?php checked($wpmail,'true'); ?> /> <span class="description">Check this option to use the Wordpress mail function for sending the emails</span>
					</li>
					
					<li>
						<label for="dcscf_redirect">After Form Submit</label>
						<select name="dcscf_options[redirect]" id="dcscf_redirect" >
							<option value='ajax' <?php selected( $redirect, 'ajax'); ?> >AJAX Message</option>
							<option value='redirect' <?php selected( $redirect, 'redirect'); ?> >Redirect</option>
						</select>
						<span class="description">Select the type of response when a form is submitted</span>
					</li>
					<li class="redirect-hide redirect-redirect<?php echo $hideRedirect; ?>"><h4>Redirect URL</h4></li>
					<li class="redirect-hide redirect-redirect<?php echo $hideRedirect; ?>">
						<label for="dcscf_redirect_success">Email Sent:</label>
						<input type="text" id="dcscf_redirect_success" class="dcwp-input-m" name="dcscf_options[redirect_success]" value="<?php echo isset($options['redirect_success']) ?  $options['redirect_success'] : $redirect_success; ?>" />
						<span class="description dcwp-note">Enter the URL to redirect the page to when the form is successfully submitted</span>
					</li>
					
					<li class="redirect-hide redirect-redirect<?php echo $hideRedirect; ?>">
						<label for="dcscf_redirect_error">Error:</label>
						<input type="text" id="dcscf_redirect_error" class="dcwp-input-m" name="dcscf_options[redirect_error]" value="<?php echo isset($options['redirect_error']) ?  $options['redirect_error'] : $redirect_error; ?>" />
						<span class="description dcwp-note">Enter the URL to redirect the page to when the form fails</span>
						
					</li>
					
					<li class="redirect-hide redirect-ajax<?php echo $hideAjax; ?>"><h4>AJAX Message</h4></li>
					
					<li class="redirect-hide redirect-ajax<?php echo $hideAjax; ?>">
						<label for="dcscf_response_sent">Email Sent:</label>
						<textarea id="dcscf_response_sent" class="dcwp-textarea" name="dcscf_options[response_sent]" rows="3"><?php echo isset($options['response_sent']) ?  $options['response_sent'] : $response_sent; ?></textarea>
						<span class="description dcwp-note">The message that will be shown when a form has been submitted successfully</span>
						
					</li>
					
					<li class="redirect-hide redirect-ajax<?php echo $hideAjax; ?>">
						<label for="dcscf_response_error">Error:</label>
						<textarea id="dcscf_response_error" class="dcwp-textarea" name="dcscf_options[response_error]" rows="3"><?php echo isset($options['response_error']) ?  $options['response_error'] : $response_error; ?></textarea>
						<span class="description dcwp-note">The message that will be shown when an error occurs with the form submission</span>
						
					</li>
					
					<li class="redirect-hide redirect-ajax<?php echo $hideAjax; ?>">
						<label for="dcscf_response_invalid">Invalid:</label>
						<textarea id="dcscf_response_invalid" class="dcwp-textarea" name="dcscf_options[response_invalid]" rows="3"><?php echo isset($options['response_invalid']) ?  $options['response_invalid'] : $response_invalid; ?></textarea>
						<span class="description dcwp-note">The message that will be shown if the form is invalid</span>
					</li>
					
					<li><h4>Validation Messages</h4></li>
					<li>
						<label for="dcscf_valid_error">Input Required:</label>
						<input type="text" id="dcscf_valid_error" class="dcwp-input-m" name="dcscf_options[valid_error]" value="<?php echo isset($options['valid_error']) ?  $options['valid_error'] : $valid_error; ?>" />
						<span class="description dcwp-note">Error message for required field.</span>
					</li>
					
					<li>
						<label for="dcscf_valid_error">Email Address:</label>
						<input type="text" id="dcscf_valid_email" class="dcwp-input-m" name="dcscf_options[valid_email]" value="<?php echo isset($options['valid_email']) ?  $options['valid_email'] : $valid_email; ?>" />
						<span class="description dcwp-note">Error message for invalid email.</span>
					</li>
					
				</ul>

				<p class="submit">
				
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

				</p>
		</form>			

			<?php

			$this->close_admin_page();

		}
	}
}

class dc_jqslickcontact_widget extends WP_Widget {
	
	/** constructor */
    function dc_jqslickcontact_widget() {
	
		$name =			'Slick Contact Forms';
		$desc = 		'Sticky sliding & floating contact forms';
		$id_base = 		'dc_jqslickcontact_widget';
		$css_class = 	'dcscf_widget';
		$alt_option = 	'widget_dcjq_slick_contact_forms'; 

		$widget_ops = array(
			'classname' => $css_class,
			'description' => __( $desc, 'dcjq-slick-contact' ),
		);
		
		$this->WP_Widget($id_base, __($name, 'dcjqslickcontact'), $widget_ops);
		$this->alt_option_name = $alt_option;
		
		add_action( 'wp_head', array(&$this, 'styles'), 10, 1 );	
		add_action( 'wp_footer', array(&$this, 'footer'), 10, 1 );
		add_action('init', array(&$this, 'my_init_method'));
		
		$options = get_option('dcscf_options');
		$default_widget_email = ($options['default_email'] == '') ? get_option('admin_email'):$options['default_email'];
		$this->defaults = array(
			'method' => 'stick',
			'event' => 'click',
			'width' => 260,
			'speedMenu' => 600,
			'speedFloat' => 1500,
			'position' => 'left',
			'offsetL' => 50,
			'offsetA' => 50,
			'tabText' => 'Contact Us',
			'autoClose' => '1',
			'formText' => 'We welcome any feedback, questions or comments',
			'textPosition' => 'top',
			'label1' => 'Name',
			'label2' => 'Email',
			'label3' => '',
			'labelText' => 'Questions/Comments',
			'valid1' => '1',
			'valid2' => '2',
			'valid3' => '-1',
			'validText' => '1',
			'btnText' => 'Submit',
			'emailTo' => $default_widget_email,
			'skin' => 'Black'
		);
    }

	function my_init_method() {
			
			if ( version_compare( get_bloginfo( 'version' ) , '3.0' , '<' ) && is_ssl() ) {
				$wp_content_url = str_replace( 'http://' , 'https://' , get_option( 'siteurl' ) );
			} else {
				$wp_content_url = get_option( 'siteurl' );
			}
			$wp_content_url .= '/wp-content';
			$wp_plugin_url = $wp_content_url . '/plugins';

			wp_register_style('dcwp_plugin_admin_dcscf_css', $wp_plugin_url .'/slick-contact-forms/css/admin.css');
			wp_enqueue_style('dcwp_plugin_admin_dcscf_css');
	}    

	function widget($args, $instance) {
		extract( $args );
		$widget_options = wp_parse_args( $instance, $this->defaults );
		extract( $widget_options, EXTR_SKIP );
		
		$label1 = $widget_options['label1'];
		$label2 = $widget_options['label2'];
		$label3 = $widget_options['label3'];
		$labelText = $widget_options['labelText'];
		$valid1 = $widget_options['valid1'];
		$valid2 = $widget_options['valid2'];
		$valid3 = $widget_options['valid3'];
		$validText = $widget_options['validText'];
		$btnText = $widget_options['btnText'];
		$tabText = $widget_options['tabText'];
		
		$options = get_option('dcscf_options');
		$valid_error = $options['valid_error'];
		$valid_email = $options['valid_email'];
		
		?>
		<div class="dcjq-contact" id="<?php echo $this->id.'-item'; ?>">
		
		<?php 

			$corner = '<div class="dc-corner"><span></span></div>';
			if(($widget_options['position'] == 'bottom-left')||($widget_options['position'] == 'bottom-right')){
				echo $corner;
			}
			$commentRow = '<li class="comment-row">'.$widget_options['formText'].'</li>';
		?>

			<form class="slick-form" method="post" action="<?php echo dc_jqslickcontact::get_plugin_directory()."/slick_mail.php"; ?>">
			  <fieldset>
			    <ol>
				  <?php 
						if($widget_options['textPosition'] == 'top') {
							echo $commentRow;
						} 
					?>
					<?php if($valid1 > '-1'){ ?>
				  <li class="input-row">
				    <label for="input1"><?php echo $label1; ?></label>
					<input class="<?php echo $this->dcscf_validation($widget_options['valid1'], 'defaultText text-input'); ?>" name="input1" value="" title="<?php echo $label1; ?>" />
					<input type="hidden" name="valid1" value="<?php echo $valid1; ?>" />
				  </li>
				    <?php } ?>
					<?php if($valid2 > '-1'){ ?>
				  <li class="input-row">	
				    <label for="input2"><?php echo $label2; ?></label>
					<input class="<?php echo $this->dcscf_validation($widget_options['valid2'], 'defaultText text-input'); ?>" name="input2" value="" title="<?php echo $label2; ?>" />
					<input type="hidden" name="valid2" value="<?php echo $valid2; ?>" />
				  </li>
				  <?php } ?>
				  <?php if($valid3 > '-1'){ ?>
				  <li class="input-row">	
				    <label for="input3"><?php echo $label3; ?></label>
					<input class="<?php echo $this->dcscf_validation($widget_options['valid3'], 'defaultText text-input'); ?>" name="input3" value="" title="<?php echo $label3; ?>" />
					<input type="hidden" name="valid3" value="<?php echo $valid3; ?>" />
				  </li>
				  <?php } ?>
				  <?php if($validText > '-1'){ ?>
				  <li class="text-row">	
				    <label for="comments"><?php echo $labelText; ?></label>
					<textarea name="comments" class="<?php echo $this->dcscf_validation($widget_options['validText'], 'defaultText text-area'); ?>" rows="6" title="<?php echo $labelText; ?>"></textarea>
				  </li>
				  <?php } ?>
				  <li class="nocomment">
					<label for="nocomment">Leave This Field Empty</label>
					<input id="nocomment" value="" name="nocomment" />
				  </li>
				  <?php 
						if($widget_options['textPosition'] == 'bottom') {
							echo $commentRow;
						} 
					?>
				  <li class="button-row">
					<input type="submit" name="submit" value="<?php echo $btnText; ?>" class="'btn-submit" />
					<?php
						echo '<input type="hidden" name="key" value="' . $this->token() . '" />';
						echo $label1 != '' ? '<input type="hidden" name="label1" value="'.$label1.'" />' : '';
						echo $label2 != '' ? '<input type="hidden" name="label2" value="'.$label2.'" />' : '';
						echo $label3 != '' ? '<input type="hidden" name="label3" value="'.$label3.'" />' : '';
						echo $labelText != '' ? '<input type="hidden" name="labelText" value="'.$labelText.'" />' : '';
						echo $tabText != '' ? '<input type="hidden" name="tabText" value="'.$tabText.'" />' : '';
				
						$obfuscatedLink = "";
						for ($i=0; $i<strlen($emailTo); $i++){
							$obfuscatedLink .= "&#" . ord($emailTo[$i]) . ";";
						}

						echo '<input type="hidden" name="emailTo" value="'.$obfuscatedLink.'" />';
						echo '<input type="hidden" name="action" value="submit" />';
						echo '<input type="hidden" name="v_error" id="v-error" value="'.$valid_error.'" />';
						echo '<input type="hidden" name="v_email" id="v-email" value="'.$valid_email.'" />';
					?>
				  </li>
				</ol>
			  </fieldset>
			  <div class="slick-response"></div>
			</form>
		<?php
			if(($widget_options['position'] == 'top-left')||($widget_options['position'] == 'top-right')||($widget_options['position'] == 'left')||($widget_options['position'] == 'right')){
				echo $corner;
			}
		?>
		</div>
		<?php
	}

    /** @see WP_Widget::update */
    function update( $new_instance, $old_instance ) {
	
		$instance['method'] = $new_instance['method'];
		$instance['width'] = (int) strip_tags( stripslashes($new_instance['width']) );
		$instance['speedMenu'] = (int) strip_tags( stripslashes($new_instance['speedMenu']) );
		$instance['speedFloat'] = (int) strip_tags( stripslashes($new_instance['speedFloat']) );
		$instance['position'] = $new_instance['position'];
		$instance['offsetL'] = (int) strip_tags( stripslashes($new_instance['offsetL']) );
		$instance['offsetA'] = (int) strip_tags( stripslashes($new_instance['offsetA']) );
		$instance['skin'] = $new_instance['skin'];
		$instance['autoClose'] = $new_instance['autoClose'];
		$instance['loadOpen'] = $new_instance['loadOpen'];
		$instance['tabText'] = strip_tags( stripslashes($new_instance['tabText']) );
		$instance['emailTo'] = strip_tags( stripslashes($new_instance['emailTo']) );
		$instance['formText'] = strip_tags( stripslashes($new_instance['formText']) );
		$instance['textPosition'] = strip_tags( stripslashes($new_instance['textPosition']) );
		$instance['label1'] = strip_tags( stripslashes($new_instance['label1']) );
		$instance['label2'] = strip_tags( stripslashes($new_instance['label2']) );
		$instance['label3'] = strip_tags( stripslashes($new_instance['label3']) );
		$instance['labelText'] = strip_tags( stripslashes($new_instance['labelText']) );
		$instance['valid1'] = strip_tags( stripslashes($new_instance['valid1']) );
		$instance['valid2'] = strip_tags( stripslashes($new_instance['valid2']) );
		$instance['valid3'] = strip_tags( stripslashes($new_instance['valid3']) );
		$instance['validText'] = strip_tags( stripslashes($new_instance['validText']) );
		$instance['btnText'] = strip_tags( stripslashes($new_instance['btnText']) );

		return $instance;
	}

    /** @see WP_Widget::form */
    function form($instance) {
	
		$widget_options = wp_parse_args( $instance, $this->defaults );
		extract( $widget_options, EXTR_SKIP );
		
		// Get default admin email
		settings_fields('dcscf_options_group'); $options = get_option('dcscf_options');
		$default_email = $options['default_email'];
		$emailTo = ( $widget_options['emailTo'] != '' ) ? $widget_options['emailTo'] : $default_email;
		
		?>

	<p>
		<input type="radio" id="<?php echo $this->get_field_id('method1'); ?>" name="<?php echo $this->get_field_name('method'); ?>" value="float"<?php checked( $widget_options['method'], 'float' ); ?> class="method-float" /> 
		<label for="<?php echo $this->get_field_id('method1'); ?>"><?php _e( 'Floating' , 'dcjq-slick-contact' ); ?></label>
		<input type="radio" id="<?php echo $this->get_field_id('method2'); ?>" name="<?php echo $this->get_field_name('method'); ?>" value="stick"<?php checked( $widget_options['method'], 'stick' ); ?> class="method-slick" /> 
		<label for="<?php echo $this->get_field_id('method2'); ?>"><?php _e( 'Slide Out' , 'dcjq-slick-contact' ); ?></label>
	</p>
	<p class="dcwp-row">
		<label for="<?php echo $this->get_field_id('tabText'); ?>"><?php _e('Tab Text:') ?></label>
		<input type="text" id="<?php echo $this->get_field_id('tabText'); ?>" name="<?php echo $this->get_field_name('tabText'); ?>" value="<?php echo $widget_options['tabText']; ?>" />
	</p>
	
	<p class="dcwp-row">
		<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:') ?></label>
		<input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $widget_options['width']; ?>" />
	</p>
	
	<p class="dcwp-row">
	  <label for="<?php echo $this->get_field_id('position'); ?>"><?php _e( 'Location' , 'dcjq-slick-contact' ); ?></label>
		<select name="<?php echo $this->get_field_name('position'); ?>" id="<?php echo $this->get_field_id('position'); ?>" >
			<option value='top-left' <?php selected( $widget_options['position'], 'top-left'); ?> >Top Left</option>
			<option value='top-right' <?php selected( $widget_options['position'], 'top-right'); ?> >Top Right</option>
			<option value='bottom-left' <?php selected( $widget_options['position'], 'bottom-left'); ?> >Bottom Left</option>
			<option value='bottom-right' <?php selected( $widget_options['position'], 'bottom-right'); ?> >Bottom Right</option>
			<option value='left' <?php selected( $widget_options['position'], 'left'); ?> >Left</option>
			<option value='right' <?php selected( $widget_options['position'], 'right'); ?> >Right</option>
		</select>
		</p>
	
	<p class="dcwp-row">

	<label for="<?php echo $this->get_field_id('offsetL'); ?>"><?php _e( 'Offset:' , 'dcjq-slick-contact' ); ?></label>
		A: <input type="text" id="<?php echo $this->get_field_id('offsetL'); ?>" name="<?php echo $this->get_field_name('offsetL'); ?>" value="<?php echo $widget_options['offsetL']; ?>" size="4" /> 
		B: <input type="text" id="<?php echo $this->get_field_id('offsetA'); ?>" name="<?php echo $this->get_field_name('offsetA'); ?>" value="<?php echo $widget_options['offsetA']; ?>" size="4" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('speedFloat'); ?>"><?php _e('Float Speed:') ?></label>
		<input type="text" id="<?php echo $this->get_field_id('speedFloat'); ?>" name="<?php echo $this->get_field_name('speedFloat'); ?>" value="<?php echo $widget_options['speedFloat']; ?>" size="5" /> (ms)
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('speedMenu'); ?>"><?php _e('Slide Speed:') ?></label>
		<input type="text" id="<?php echo $this->get_field_id('speedMenu'); ?>" name="<?php echo $this->get_field_name('speedMenu'); ?>" value="<?php echo $widget_options['speedMenu']; ?>" size="5" /> (ms)
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id('autoClose'); ?>"><?php _e( 'Auto-Close' , 'dcjq-slick-contact' ); ?></label> 
		<input type="checkbox" value="true" class="checkbox" id="<?php echo $this->get_field_id('autoClose'); ?>" name="<?php echo $this->get_field_name('autoClose'); ?>"<?php checked( $widget_options['autoClose'], 'true'); ?> style="margin-right: 5px;" /> 
	
		<label for="<?php echo $this->get_field_id('loadOpen'); ?>"><?php _e( 'Load Open' , 'dcjq-slick-contact' ); ?></label> 
		<input type="checkbox" value="true" class="checkbox" id="<?php echo $this->get_field_id('loadOpen'); ?>" name="<?php echo $this->get_field_name('loadOpen'); ?>"<?php checked( $widget_options['loadOpen'], 'true'); ?> />
	</p>
	<p class="dcwp-row">
	  <label for="<?php echo $this->get_field_id('skin'); ?>"><?php _e('Skin:', 'dcjq-slick-contact'); ?></label>
	
	  <?php 
		echo "<select name='".$this->get_field_name('skin')."' id='".$this->get_field_id('skin')."'>";
		echo "<option value='no-theme' ".selected( $skin, 'no-theme', false).">No theme</option>";
			
		//The path to the style directory
		$dirpath = plugin_dir_path(__FILE__) . '../skins/';	
			
		$dh = opendir($dirpath);
		while (false !== ($file = readdir($dh))) {
			//Don't list subdirectories
			if (!is_dir("$dirpath/$file")) {
				//Remove file extension
				$newSkin = htmlspecialchars(ucfirst(preg_replace('/\..*$/', '', $file)));
				echo "<option value='$newSkin' ".selected($widget_options['skin'], $newSkin, false).">" . $newSkin . '</option>';
			}
		}
		closedir($dh); 
		echo "</select>"; ?>
	</p>

	<p class="dcwp-row">
		<label for="<?php echo $this->get_field_id('emailTo'); ?>"><?php _e('Email To:') ?></label>
		<input type="text" id="<?php echo $this->get_field_id('emailTo'); ?>" name="<?php echo $this->get_field_name('emailTo'); ?>" value="<?php echo $emailTo; ?>" />
	</p>
	<p class="dcwp-row">
	  <label><?php _e('Form Text') ?></label>
		<input type="radio" id="<?php echo $this->get_field_id('textPosition1'); ?>" name="<?php echo $this->get_field_name('textPosition'); ?>" value="top"<?php checked( $widget_options['textPosition'], 'top' ); ?> /> Top 
		<input type="radio" id="<?php echo $this->get_field_id('textPosition2'); ?>" name="<?php echo $this->get_field_name('textPosition'); ?>" value="bottom"<?php checked( $widget_options['textPosition'], 'bottom' ); ?> /> Bottom
	</p>
	<p>
		<textarea id="<?php echo $this->get_field_id('formText'); ?>" name="<?php echo $this->get_field_name('formText'); ?>" class="dcwp-widget-text"><?php echo $widget_options['formText']; ?></textarea>
	</p>

	<ul class="dcscf-ul">
	  <li>
	    <h4 class="left">Text Box</h4>
		<h4 class="right">Status</h4>
	  </li>
	  <li>
	    <?php echo $this->dcscf_widget_text_input('1',$this->get_field_id('label1'), $this->get_field_name('label1'), $widget_options['label1'], $this->get_field_name('valid1'), $this->get_field_id('valid1'), $widget_options['valid1'],'1'); ?>
	  </li>
	  <li>
	    <?php echo $this->dcscf_widget_text_input('2',$this->get_field_id('label2'), $this->get_field_name('label2'), $widget_options['label2'], $this->get_field_name('valid2'), $this->get_field_id('valid2'), $widget_options['valid2'],'1'); ?>
	  </li>
	  <li>
	    <?php echo $this->dcscf_widget_text_input('3',$this->get_field_id('label3'), $this->get_field_name('label3'), $widget_options['label3'], $this->get_field_name('valid3'), $this->get_field_id('valid3'), $widget_options['valid3'],'1'); ?>
	  </li>
	  <li>
	    <h4 class="left">Text Area</h4>
		<h4 class="right">Status</h4>
	  </li>
	  <li>
	    <?php echo $this->dcscf_widget_text_input('4',$this->get_field_id('labelText'), $this->get_field_name('labelText'), $widget_options['labelText'], $this->get_field_name('validText'), $this->get_field_id('validText'), $widget_options['validText'],'0'); ?>
	  </li>
	</ul>
	<p class="dcwp-row">
		<label for="<?php echo $this->get_field_id('btnText'); ?>"><?php _e('Submit Button:') ?></label>
		<input type="text" id="<?php echo $this->get_field_id('btnText'); ?>" name="<?php echo $this->get_field_name('btnText'); ?>" value="<?php echo $btnText; ?>" />
	</p>
	<div class="widget-control-actions alignright">
		<p><small><a href="http://www.designchemical.com/blog/index.php/wordpress-plugin-slick-contact-forms/"><?php esc_attr_e('Visit plugin site', 'dcjq-slick-contact'); ?></a></small></p>
	</div>
	
	<?php 
	}
	
	/** Create widget form text row **/
	function dcscf_widget_text_input($id, $label, $name, $value, $select, $selectId, $selectValue, $email){
	
		$input = $selectValue == '-1' ? '' : $value;
		$row = '';
		$row .= '<label for="'.$label.'">'. $id .'</label>';
		$row .= '<input type="text" id="'. $label .'" name="' .$name.'" value="'.$input.'" class="dcwp-widget-input" />';
		$row .= '<select name="'.$select.'" id="'.$selectId.'" >';
		$row .= '<option value="-1" '.(selected( $selectValue, "-1", false)).'>N/A</option>';
		$row .= '<option value="0" '.(selected( $selectValue, "0", false)).'>None</option>';
		$row .= '<option value="1" '.(selected( $selectValue, "1", false)).'>Required</option>';
		if($email == '1'){
			$row .= '<option value="2" '.(selected( $selectValue, "2", false)).'>Email</option>';
		}
		$row .= '</select>';
		
		return $row;
	}
	
	/** Get validation classes for form inputs **/
	function dcscf_validation($value, $class){
	
		if($value == '0'){ $classValid = $class; }
		if($value == '1'){ $classValid = 'required '.$class; }
		if($value == '2'){ $classValid = 'required email '.$class; }
		return $classValid;
	}
	
	/** Adds ID based slick skin to the header. */
	function styles(){
		
		if(!is_admin()){

			$all_widgets = $this->get_settings();
		
			$i = 0;
			foreach ($all_widgets as $key => $wpdcjqslickcontact){
				$widget_id = $this->id_base . '-' . $key;		
				if(is_active_widget(false, $widget_id, $this->id_base)){
		
					$skin = $wpdcjqslickcontact['skin'];
					$skin = htmlspecialchars(ucfirst(preg_replace('/\..*$/', '', $skin)));
					if($skin != 'No-theme'){
						echo "\n\t<link rel=\"stylesheet\" href=\"".dc_jqslickcontact::get_plugin_directory()."/skin.php?widget_id=".$key."&amp;skin=".strtolower($skin)."\" type=\"text/css\" media=\"screen\"  />";
						if($i == 0){
							echo "\n\t<link rel=\"stylesheet\" href=\"".dc_jqslickcontact::get_plugin_directory()."/css/form.css\" type=\"text/css\" media=\"screen\"  />";
						}
						$i++;
					}
				}
			}
		}
	}

	/** Adds ID based activation script to the footer */
	function footer(){
		
		if(!is_admin()){
		
		$all_widgets = $this->get_settings();
		
		foreach ($all_widgets as $key => $wpdcjqslickcontact){
		
			$widget_id = $this->id_base . '-' . $key;
			
			$contact_id = 'dc-contact-' . $key;

			if(is_active_widget(false, $widget_id, $this->id_base)){
			
				$method = $wpdcjqslickcontact['method'];
				if($method == ''){$method = 'stick';}
				
				$position = $wpdcjqslickcontact['position'];
				if($position == 'top-left'){
					$location = 'top';
					$align = 'left';
				}
				if($position == 'top-right'){
					$location = 'top';
					$align = 'right';
				}
				if($position == 'bottom-left'){
					$location = 'bottom';
					$align = 'left';
				}
				if($position == 'bottom-right'){
					$location = 'bottom';
					$align = 'right';
				}
				
				if($position == 'left'){
					if($method == 'float'){
						$location = 'top';
						$align = 'left';
					} else {
						$location = 'left';
						$align = 'top';
					}
				}
				
				if($position == 'right'){
					if($method == 'float'){
						$location = 'top';
						$align = 'right';
					} else {
						$location = 'right';
						$align = 'top';
					}
				}
				
				$width = $wpdcjqslickcontact['width'];
				if($width == ''){$width = '200';}
				
				$speedMenu = $wpdcjqslickcontact['speedMenu'];
				if($speedMenu == ''){$speedMenu = '600';}
				
				$speedFloat = $wpdcjqslickcontact['speedFloat'];
				if($speedFloat == ''){$speedFloat = '1500';}
			
				$offsetL = $wpdcjqslickcontact['offsetL'];
				if($offsetL == ''){$offsetL = '0';}
				$offsetA = $wpdcjqslickcontact['offsetA'];
				if($offsetA == ''){$offset = '0';}
				
				$autoClose = $wpdcjqslickcontact['autoClose'];
				if($autoClose == ''){$autoClose = 'false';}
				
				$loadOpen = $wpdcjqslickcontact['loadOpen'];
				if($loadOpen == ''){$loadOpen = 'false';}

				$tabText = $wpdcjqslickcontact['tabText'];
				
				$classWrapper = 'dc-contact-'.$method;
				
				$options = get_option('dcscf_options');
				$ajaxSubmit = $options['redirect'] == 'ajax' ? 'true' : 'false' ;
				$animate = 'true';
				
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					jQuery('#<?php echo $widget_id.'-item'; ?>').dcSlickContact({
						method: '<?php echo $method; ?>',
						event: 'click',
						classWrapper: '<?php echo $classWrapper; ?>',
						classContent: 'dc-contact-content',
						width: <?php echo $width; ?>,
						location: '<?php echo $location; ?>',
						align: '<?php echo $align; ?>',
						speedContent: <?php echo $speedMenu; ?>,
						speedFloat: <?php echo $speedFloat; ?>,
						offsetLocation: <?php echo $offsetL; ?>,
						offsetAlign: <?php echo $offsetA; ?>,
						autoClose: <?php echo $autoClose; ?>,
						tabText: '<?php echo $tabText; ?>',
						idWrapper: '<?php echo $contact_id; ?>',
						animateError: <?php echo $animate; ?>,
						loadOpen: <?php echo $loadOpen; ?>,
						ajaxSubmit: <?php echo $ajaxSubmit; ?>
						
					});
				});
			</script>
		
			<?php
			
			}		
		}
		}
	}
	
	function token() {
		$admin_email = get_option("admin_email");
		return md5("slick-" . $admin_email . date("WY"));
	}
	
	function get_dcscf_default($option){

		$options = get_option('dcscf_options');
		$default = $options[$option];
		return $default;
	}
} // class dc_jqslickcontact_widget