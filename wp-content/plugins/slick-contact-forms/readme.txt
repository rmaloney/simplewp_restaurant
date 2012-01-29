=== Slick Contact Forms ===
Contributors: remix4
Donate link: http://www.designchemical.com/blog/index.php/wordpress-plugin-slick-contact-forms/#form-donate
Tags: jquery, flyout, drop down, floating, sliding, contact forms, validation, animated, widget
Requires at least: 3.0
Tested up to: 3.21
Stable tag: 1.3.3

Slick contact forms allows you quickly and easily create contact forms for any area on your Wordpress site using widgets

== Description ==

Creates a widget, which adds a contact form using either a floating, drop down button or a sticky, sliding tab. Can handle multiple forms on each page and the location of the floating button or sliding tab can be easily set from the widget control panel.

Each form includes up to 3 text input fields and one text area. The input labels and type of validation can be set via the widget control panel. The plugin includes validation for the form fields using animated error messages.

The plugin also includes shortcodes, which allow you to add a text link to your content, which will open/close the contact form.

= Configuration Options =

General configuration can be set via the Wordpress admin menu option Settings --> Slick Contact Forms

* Default Email Address - Email address where submitted forms are sent if not set in the widget control panel - default is the Wordpress admin email
* Email Subject - The text that appears in the email subject line - default is the Blog Name
* Send From User Email - Check this option to use the visitors email address in the email "from" field - at least one of the contact form input fields "status" must be set to "email" for this to work
* Include IP Address - If checked the email will include the IP address of the user
* Include Page URL - If checked the email will include the URL of the page on which the user submitted the contact form
* Use wp_mail() - Check this option if you wish to use the Wordpress mail function to send the email as opposed to the php mail() function

After Form Submit - The form can be set to either submit using AJAX (default) and return a message to the form slide out panel or to redirect to a different page

If using AJAX Message:

Set the text that is shown when the form has been submitted
* Email Sent - When a form is successfully submitted
* Error - If an error occurred during submission
* Invalid - If invalid data is received by the server

If using Redirect:

Enter the URLs to redirect the page to when the form submit is complete
* Email Sent - Enter the URL to redirect the page to when the form is successfully submitted
* Error - Enter the URL to redirect the page to when the form fails

Validation Messages - The text that will appear in the animated validation error messages
* Input Required - If a required form field is empty
* Email Address - If an invalid email format is entered

= Contact Form Widget Options =

Each individual form can be customised via the widget control panel:

* Method - Select either a "floating" button or a "Sliding" tab
* Tab Text - Enter the text that you would like to use for the form tab.
* Width - Set the width of the contact form
* Location - Select the position of the contact form.
* Offset - Position the form by offsetting the location from the edge of the browser in pixels (For Sticky Tabs only option A is used)
* Floating Speed - The speed for the floating animation (only applicable for the floating type)
* Animation Speed - The speed at which the form section will open/close
* Auto-Close - If checked, the form will automatically slide closed when the user clicks anywhere in the browser window
* Skin - 4 different sample skins are currently available for styling the contact form. These can be used to create your own custom form theme.

To set up the form, several options are available for you to customise the number of text input fields, the label for the form field and the type of validation.
* Email To - The address where the form details will be sent
* Form Text - Add introduction text for the form. Select the position of the text - either before or after the form fields.
* Text input fields - up to 3 form fields can be added to the contact form. Enter the text for the label in the left hand box. The right-hand drop down "Status" menu allows you to select whether the form field is required:

	* N/A - If selected the form field will not appear on the contact form
	* None - Form field will appear but is not required
	* Required - User must enter text in order to submit
	* Email - User must enter a valid email address
	
* The form also includes the option of one text area
* Submit Button - Set the text for the form submit button

= Shortcodes =

The plugin includes the feature to add text links within your site content that will open/close the sticky or floating tab.

1. [dcscf-link] - default link, which will toggle the contact form open/closed with the link text "Contact Us".
2. [dcscf-link text="Contact Us Now"] - toggle the contact form open/closed with the link text "Contact Us Now".
3. [dcscf-link action=open] - open the contact form with the default link text.
4. [dcscf-link action=close] - close the contact form with the default link text.

[__See demo__](http://www.designchemical.com/blog/index.php/wordpress-plugin-slick-contact-forms/)

[__More information See Plugin Project Page__](http://www.designchemical.com/blog/index.php/wordpress-plugin-slick-contact-forms/)

== Installation ==

1. Upload the plugin through `Plugins > Add New > Upload` interface or upload `slick-contact-forms` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In the widgets section, select the Slick Contact Forms widget and add to one of your widget areas
4. Set the required settings and save your widget

== Frequently Asked Questions ==

[__Also check out our slick contact forms faq page__](http://www.designchemical.com/blog/index.php/frequently-asked-questions/slick-contact-forms/)

= The menu appears on the page but the floating/slide out tab does not appear. Why? =

One main reason for this is that the plugin adds the required jQuery code to your template footer. Make sure that your template files contain the wp_footer() function.

Another likely cause is due to other non-functioning plugins, which may have errors and cause the plugin javascript to not load. Remove any unwanted plugins and try again. Checking with Firebug will show where these error are occuring.

= I dont receive any emails when a form is submitted. Why? =

The plugin uses the PHP mail function to send the email from the contact form. Sometimes web hosting companies may disable this function or require that the email be authenticated.

The following instructions may help fix the problem if your server requires authentication and you receive the following error message:

"Error. Please try again."

Either create a new email account or use an existing email account on the same domain as the slick contact form plugin - this email address should be used in the "Email To" field in the widget control panel.

Add the following lines to your php.ini file:

[mail function]
SMTP = YOUR_PROVIDER
smtp_port = 25
username = USERNAME
password = YOUR_PASSWORD

Change YOUR_PROVIDER, USERNAME & YOUR_PASSWORD with your email details - e.g. if your domain is designchemical.com usually your provider would be mail.designchemical.com - this information can usually be found in your hosting control panel or contact your hosting company.

[__Also check out our slick contact forms faq page__](http://www.designchemical.com/blog/index.php/frequently-asked-questions/slick-contact-forms/)

== Screenshots ==

1. Slick Contact Forms widget in edit mode
2. Example of form

== Changelog ==

= 1.3.3 =
* Updated: Modify email headers to remove '/r' characters

= 1.3.2 =
* Added: Option to use user email in "from" header

= 1.3.1 =
* Updated: Modifications to form.css

= 1.3 =
* Added: Ability to send to multiple receipients

= 1.2.9 =
* Added: Option to use wp_mail() function for sending email
* Fixed: Bug with saving include URL option

= 1.2.8 =
* Added: Option to redirect on form submit

= 1.2.7 =
* Added: Server-side validation for required fields

= 1.2.6 =
* Updated: jQuery Slick Contact plugin

= 1.2.5 =
* Fixed: Speed option for slide out tab

= 1.2.4 =
* Fixed: Renamed validation function for email to avoid conflict with wp-responder-email-autoresponder-and-newsletter-plugin

= 1.2.3 =
* Added: Option to have contact form open on page load

= 1.2.2 =
* Added: Option to include origin page URL in contact email

= 1.2.1 =
* Added: Reply-to in mail header

= 1.2.0 =
* Added: Ability to open menu using external link
* Fixed: Bug when using floating menu plugin

= 1.1.3 =
* Fixed: Bug with changing validation messages

= 1.1.2 =
* Added: Ability to show only text

= 1.1.1 =
* Added: Ability to set submit button text from widget control panel

= 1.1 =
* Added: Can now leave tab text box blank to allow for background images for vertical text
* Added: Honeypot style captcha

= 1.0 = 
* First release

== Upgrade Notice ==
