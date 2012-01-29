=== JQuery Mega Menu Widget ===
Contributors: remix4
Donate link: http://www.designchemical.com/blog/index.php/wordpress-plugins/wordpress-plugin-jquery-drop-down-mega-menu-widget/#form-donate
Tags: jquery, dropdown, mega, menu, vertical, animated, css, navigation, widget
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 1.3.7

Creates a widget, which allows you to add drop down mega menus from any Wordpress custom menu using jQuery.

== Description ==

Creates a widget, which allows you to add drop down mega menus from any standard Wordpress custom menu using jQuery. Can handle multiple mega menus on each page, offers either "fade In" or "slide down" effects and the option to use hover or click to show the sub-menu. For best results use 3 levels for the custom menu.

= Menu Options =

The widget has several parameters that can be configured to help cutomise the mega menu:

* Hover/Click - Select the event that activates the sub-menu. Note that if using "Click" the parent menu links will be disabled
* Number Items Per Row - Select the number of sub-menu items to be shown on each row of the mega menu.
* Skin - Several sample skins are available to give examples of css that can be used to style your own mega menu
* Animation Effect - The effect used to display the drop down menu. Options are slide down or fade in
* Animation Speed - The speed at which the dropdown menu will open/close - selecting "No Animation" will immediately show/hide the menu
* Set Sub Menu To Full Width - If checked, the drop down mega sub menu width will be 100%

[__See demo__](http://www.designchemical.com/lab/demo-wordpress-jquery-mega-menu-plugin/)

== Installation ==

1. Upload the plugin through `Plugins > Add New > Upload` interface or upload `jquery-mega-menu` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In the widgets section, select the jQuery mega menu widget and add to one of your widget areas
4. Select one of the WP menus, set the required settings and save your widget

== Frequently Asked Questions ==

[__Also check out our jquery mega menu faq page__](http://www.designchemical.com/blog/index.php/frequently-asked-questions/jquery-mega-menu/)

= The menu appears on the page but does not work. Why? =

One main reason for this is that the plugin adds the required jQuery code to your template footer. Make sure that your template files contain the wp_footer() function.

Another likely cause is due to other non-functioning plugins, which may have errors and cause the plugin javascript to not load. Remove any unwanted plugins and try again. Checking with Firebug will show where these error are occuring.

= How should I structure my custom menu to get the best results? =

The widget works by taking the standard menu structure and creating the sub-menus from the nested links. To get the full effect you need to have 3 levels within the custom menu:

1. First level is used for the main menu items
2. The second level is used to create the sub-menu headings
3. The 3rd level links are then grouped together under the headings to create the menu options

Example: Products --> Category --> Product Ranges

= The menu appears but the drop down sub-menu doesn't show? =

Check your theme style sheet to see if the tags wrapping the menu have "overflow: hidden;". This will prevent the sub-menus from appearing underneath the main menu bar.

[__Also check out our jquery mega menu faq page__](http://www.designchemical.com/blog/index.php/frequently-asked-questions/jquery-mega-menu/)

== Screenshots ==

1. Widget in edit mode
2. Sample custom menu structure
3. Sample mega menu skins

== Changelog ==

= 1.3.7 =
* Fixed: Error with default values

= 1.3.6 =
* Added: Full width option for mega menu
* Updated: jquery.dcmegamenu.1.3.3.js

= 1.3.5 =
* Added: Option to select no animation

= 1.3.4 =
* Fix: Fixed bug with "no theme" option

= 1.3.3 =
* Fix: IE7 Bug in initialisation code

= 1.3.2 =
* Add: Ability to select either click or hover event

= 1.3.1 =
* Add: Menu automatically adjusts to stay within right-hand limit

= 1.3 =
* Add: Ability to select animation effect

= 1.2 =
* Fixed: Bug fixes for IE7

= 1.1 =
* Edit: Security for dynamic skins

= 1.0 = 
* First release

== Upgrade Notice ==
