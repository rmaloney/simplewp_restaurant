=== Easing Slider  ===
Homepage: http://easingslider.matthewruddy.com
Contributors: MatthewRuddy
Tags: slider, slideshows, easing, plugin, jquery, content, featured, images, wordpress
Requires at least: 2.9.2
Tested up to: 3.2.1
Stable tag: 1.1.9

The Easing Slider is an image slider plugin for WordPress which uses the jQuery Easing plugin.

== Description ==

<a href="http://premiumslider.matthewruddy.com">Need unlimited sliders? Want more options? Go Premium!</a>

The Easing Slider comes with various options that allow you to choose different sources to get the images from and also multiple styling options so that you"ll never have to edit any files directly & with ease. Create your own unique elegant slider.

<a href="http://easingslider.matthewruddy.com">Live Demo</a>

<h4>Choose between images sourced from:</h4>
- Custom fields from a particular category
- Custom fields from all categories
- Selected images from the plugins "Custom Images" section.

<h4>The Easing Slider has the following optional features:</h4>
- *New* Link images to URLs.
- Pagination (with custom icons if you wish)
- Next/previous buttons
- Choose between three different shadow types
- 7 different types of preloading icons (or use none)
- Padding & border settings
- And much more.


== Installation ==

<h4>Installation</h4>
<b>Via FTP:</b>
Once you download the plugin, extract the folder from the .rar file. Next, via FTP place the file in the "plugins" directory with all other plugins. This directory can be found in wp-content under the directory in which you store WordPress's files.

<b>Via Admin panel:</b>
Go to Add new under Plugins. Then search "easing slider" then click install.


<h4>Usage</h4>
To use the Easing Slider you can use the following methods:

Shortcode in posts:
`[easingslider]`

Function in template files (via php):
`<?php if (function_exists("easing_slider")){ easing_slider(); }; ?>`


<h4>Image Source:</h4>
You can change many of the sliders settings from the "Easing Slider" control panel in the WordPress administration panel.
Once the plugin is activated a new tab called "Easing Slider" emerges in the WordPress admin control panel. Under the tab "Usage Settings" there is a section called "Get images from?". Here there is a dropdown menu with which you can select three different sources to get images from. These are:

Custom Fields (Selected Category):
Allows you to use custom fields to specify an image from each post to be displayed on the slider from a particular category only. To display an image use the custom field name "easing" followed by the URL of the image in the value field. You can only upload <i>ONE</i> custom field per post.

Custom Fields (All Categories):
This option displays images from custom fields with the name "easing" from all categories, then enter the URL of the image in the value field.

Custom Images:
This allows you to use a maximum of ten custom images specified in the "Custom Images" tab. Here you can enter your own URL to specific images of insert images from your media library. This panel also gives you a preview of all the custom images that will be displayed on the slider.

<h4>Adding an image</h4>

Note: You can only use one custom field per post.

Custom Fields:
If you are NOT using custom images you can insert images into the slider via Custom Fields. To do this, insert "easing" into the Custom field <i>name</i> field followed by the URL of the image in the <i>value</i> field. You can only insert one image per post.

Custom Images tab:
If you have selected "Custom Images" as your source you can now use the custom images tab. To insert images from this tab onto the slider simply paste the link into the text box and then clicking "save changes". Alternatively you can use the "upload image" button which uses Wordpress's built in media library. Once you uploaded the image click "insert into post" to insert the image URL into the next available text box. Then click "save changes" after each one.


== Screenshots ==

1. The Easing Slider used on MatthewRuddy.com showing how the slider can be tailored to your site.

2. Preview of the slider's "Custom Images" panel.

3. Use Wordpress's media library to upload new images to the slider.

4. Modify the sliders styling to your liking. Customize nearly everything.

5. Usage settings tab. Change the image source and amount of images shown, etc.

== Frequently Asked Questions ==

<h4>The content slider is not working. It is just displaying the loading icon. What's wrong?</h4>

This (most likely) is due to one of two potential problems:

1. You have loaded jQuery already in your theme. If you manually inserted jQuery into your theme previously then it will break the Easing Slider (along with other plugins potentially) because jQuery is being loaded twice (the Easing Slider also loads jQuery).

2. No custom fields with the name "easing" followed by the URL of an image in the "value" field have been specified in any of your posts. See the "installation" section for more details on how to display images on the slider via custom fields. Alternatively you can use "custom images" by enabling this in the usage settings tab of the Easing Slider's settings.

<h4>For more information please email me at info@matthewruddy.com</h4>

== Changelog ==

= 1.1.9 =
* Fixed: Plugin inconsistancies and Javascript mistakes.
* Changed: Plugin now only deletes slideshow when uninstalled (rather than de-activated).

= 1.1.8 =
* Fixed: IE9 issues. Slider is now fully functional in IE9.

= 1.1.7 =
* Added: Option to enable or disable jQuery.
* Fixed: Issue with slider appearing above post content when using shortcode.

= 1.1.6 =
* Added: Premium Slider notice.
* Added: Icon to heading on Admin options.

= 1.1.5 =
* Fixed: Mix up between autoPlay & transitionSpeed values in previous versions.

= 1.1.4 =
* Fixed: Added !important to padding & margin values of 0 to make sure slider doesn't inherit theme's css values.

= 1.1.3 =
* Fixed: CSS glitch in admin area.

= 1.1.2 =
* Fixed: Bug with previous version.

= 1.1.1 =
* Added: Option to disable permalinks in 'slider settings'.

= 1.1.0 =
* Added: Ability to add links to images. Images sourced from custom fields link to their respective post.
* Fixed: Edited script.js issue with fade animation.

= 1.0.3 =
* Added: paddingTop & paddingRight settings.
* Fixed: Bottom padding issue when shadow is enabled.
* Changed: Tab name 'Plugin Settings' to 'Usage Settings'.

= 1.0.2 =
* Added: Fade transition. Compatibility problems fixed.
* Fixed: Preloader margin-top with IE only. Used IE hack to add 1 pixel to the top margin to make preloader appear aligned.

= 1.0.1 =

* Fixed: Issues with 'Thematic' theme.
* Fixed: jQuery into noConflict mode to avoid conflictions with various other jQuery plugins.
* Fixed: Parse errors in CSS file.
* Fixed: jQuery version number.
* Removed: Fade transition effect due to compatibility problems & issue with certain themes.