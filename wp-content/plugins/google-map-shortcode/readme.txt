=== Google Map Shortcode ===
Contributors: alaingg
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=support%40web%2dargument%2ecom&lc=US&item_name=Web%2dArgument%2ecom&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Tags: google maps, shortcode, map, maps, categories, widget, post map, point, marker, list, location, address, images, geocoder, google maps, animation
Requires at least: 2.5
Tested up to: 3.2.1
Stable tag: 3.0.1

Real Friendly integration of Google Map instances into your blogs. The plugin allows to display multiple maps on your pages. 
== Description ==
This plugin allows you to include instances of Google Map in your blogs with a simple editor button. You can insert maps everywhere: in your theme files, posts and pages. The points can include custom title, description, marker and thumbnail.

[Plugin Page](http://web-argument.com/google-map-shortcode-wordpress-plugin/) | [Shortcode References](http://web-argument.com/google-map-shortcode-reference/) | [How To Use](http://web-argument.com/google-map-shortcode-how-to-use/) | [Examples](http://web-argument.com/google-map-shortcode-wordpress-plugin/#examples)

Special Features:

*   The plugin can handle large number of map points.
*   Points can be added using address or coordinates.
*   Addresses in different languages allowed.
*	The Editor button allows to include points and maps.
* 	Custom markers allowed.
*   Based on Google Maps Javascript API Version 3.
*  	Faster and more applicable to mobile devices.
* 	Maps in multiple languages.
* 	Points under post categories can be included.
* 	Allows to insert maps into the content and theme files.
*   The window box opened display part of the content of your posts like: post title, thumbnails, excerpt or a custom title description and thumbnail.
*   You can customize the html of the info window box on the settings.
*   The plugin is based on Wordpress shortcode and allows many options like: initial zoom, width, height, categories, post ID, specific address, marker and thumbnail.

Plugin Languages:

*	English - default
*   French - Thanks to [Nicolas Mollet](http://mapicons.nicolasmollet.com)
*   Spanish - Thanks to [Alain Gonzalez](http://web-argument.com)

Please contact me [alaingoga at gmail] in order to include your language within the plugin package.

== Installation ==

1. Upload 'Google Map Shortcode' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the Google Map Shortcode Options page under settings and save your preferred options.
4. Using the Google Map editor button insert the address and add the map into your posts/pages.

== Frequently Asked Questions ==

= Can I use a custom marker? =

Yes, the plugin includes some markers images powered by [Maps Icons Collection](http://mapicons.nicolasmollet.com) but you can upload your own icon.

= The plugin allows using address in other languages? =

Yes, you can use addresses in different languages.

= The custom fields are needed? =

No, the custom fields are not needed, and it is recommended to delete them after importing the address to the database.

= The custom fields are needed? =

No, the custom fields are not needed, and it is recommended to delete them after importing the address to the database.

= How to use my old custom fields addresses and coordinates? =

When the map is deployed or when the Google Map Shortcode Editor panel is open in the post. The addresses/coordinates attached to the post using custom fields are imported to the database.


== Screenshots ==

1. Custom Marker
2. Google Map Shortcode Button
3. Google Map Shortcode editor panel
4. Google Map Shortcode Media Tab
5. Insert/Show map.

== Changelog ==  

= 3.0.1 =
 * Animation bug fixed.

= 3.0 =
 * Custom field deprecated.
 * The point's information is saved in the database.
 * Points based on coordinates included.

= 2.2.3 =
 * French language added.
 * Special characters bugs fixed.

= 2.2.2 =
 * Internationalization added.
 * Special characters bugs fixed.

= 2.2.1 =
 * allow_url_fopen exception added.
 * get excerpt bug fixed.

= 2.2 =
 * Map type added.	
 * Marker animation option added. 
 * Focus option added.
 * Maps marging and aligment added.
 * Performance improved. 
 * More map languages included

= 2.1.2 =
 * Preview map added on the map editor panel.  

= 2.1.1 =
 * Google Map Shortcode tab added to the media editor window.  
 * Upload Image button added. 
 * Cleaning string before saving points fixed.
 * Other bugs fixed.
 
= 2.1 =  
 * Allows selecting single point icon, title and description.
 * Html filters added.
 * Just one custom field by post to include all the points.
 * Icon selection improved.

= 2.0.1 =  
 * Geocoding API request changed.
 * Html width parameter included.

= 2.0 =  
 * Custom marker added.
 * Google Map Javascript v3 integrated.
 * Editor button added.
 * Ready for translation.
 * Maps in different languages allowed.
   
= 1.1 =  
 * Loops related bugs fixed.
 * More than 10 points allows per page fixed.
 * New custom field included in order to cache the Latitude and Longitude and avoid extra Google Geocoder requests.
 * More than one point per post fixed. 
 
= 1.0.0 =  
* Initial release.

 
== Upgrade Notice ==

= 3.0 =
Upgrade is recommended to handle large number of points and use addresses in other languages. From this version the custom fields are not needed to be used, all the data will be saved on the database.