=== TRUEedit ===
Contributors: macguru2000
Donate link: http://catablog.illproductions.com/donate/
Tags: admin, edit, Post, posts, texturize, wpautop, tabs, html, html editor, visual editor, customize admin, raw
Requires at least: 2.7
Tested up to: 3.1
Stable tag: 1.4

TRUEedit turns the Post HTML Tab into a raw HTML editor that does not texturize or modify your code.

== Description ==

TRUEedit is designed specifically for people who understand HTML and want to format their HTML code for readability. By default WordPress modifies your post content with two filter, this plugin lets you disable those filters along with any other content filters. TRUEedit also enables the inserting of tab characters into the post's content editor. You can even change the font, size and color of the editor, giving you more control over your blog editor.

Keep in mind that by default WordPress texturizes and automatically adds break and paragraph tags into your post content. Which means if you want to put HTML tags on different lines and format your code you could inadvertently be adding break and paragraph tags. Oh No? Use TRUEedit to fix this problem.

Highlighted Features:

* Removes the wpautop filter which adds paragraph tags to your post content.
* Removes the wptexturize filter which replaces characters and patterns.
* Review and remove any other filter applied to the content of your blog.
* Lets users insert tabs in the post HTML editor
* Lets user change font, size, color and height of the post editor
* Lets user go into a fullscreen editor mode.

== Installation ==

1. Upload the `trueedit` directory to your `/wp-content/plugins/` directory
1. Activate the plugin through the `Plugins` menu in WordPress
1. If you want you may also network activate for your WordPress MultiSite installations.

== Frequently Asked Questions ==

= How do I completely remove the Visual Editor =

You should use WordPress's built in "Visual Editor" option for each user whom you would like to stop from using the Visual Editor. Simply go to your Admin Panel's User section, edit a user and check the checkbox near the top that is labeled "Disable the visual editor when writing".

= Can I Keep One Of The Filters =

Yes, if you go to the TRUEedit Settings Panel you will see two check boxes which let you turn on and off the wpautop and wptexturize filters.

== Screenshots ==

1. The default list of built in content filters for WordPress.
2. Feel free to write your HTML how ever you like and get wicked with the tabs.
3. Customize the post editor to your liking with fonts, size, color and height controls.

== Changelog ==

= 1.4 =

* fixed the jump bug when inserting tab characters in Firefox.
* fixed the PHP warnings on the settings page when a filters array doesn't exist.
* html is no longer set as the default editor while the plugin is active, disable the visual editor in your user settings instead.

= 1.3 =

* only show documentation links for specific built in filters.
* fixed javascript bug when full screen button was disabled.

= 1.2.2 =

* fixed syntax error that stopped activation.

= 1.2.1 =

* display bug fix on plugin activation.

= 1.2 =

* Disable any of the functions attached to 'the_content' filter.
* Fix FullScreen Editor bugs.

= 1.1 =

* Added Fullscreen Editor.

= 1.0 =

* Initial Release

== Upgrade Notice ==

= 1.0 =

* No Upgrade Notices