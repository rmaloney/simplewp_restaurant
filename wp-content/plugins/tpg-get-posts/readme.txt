===  TPG Get Posts ===
Contributors: Criss Swaim, based on plugin nurelm-get-posts
Donate link: http://www.tpginc.net/wordpress-plugins/donate/
Tags: get_posts, post, posts, formatting, list, shortcode
Requires at least: 2.?    
Tested up to: 3.2.1
Stable tag: 1.2.3

Adds a shortcode tag [tpg_get_posts] to display posts within any static page or post.  Posts can be selected by tags, category, category_name or any other option supported by the WP get_posts function.

== Description ==

Updated: 2011-09-27      (since the wp last updated field is broken)

This plugin adds the ability to put a shortcode tag in a page or post and have it display a list of posts formatted similarly to the standard blog.  The posts can be selected by one or more tag values to show only items relevant to the page.

By default it will show the 5 most recent posts ordered in reverse date order,
but it will accept any of the options provided by the [get_posts template tag]( href="http://codex.wordpress.org/Template_Tags/get_posts" ).

To use it, just put the following into the HTML of any page or post, use as many times as you like on the same page:

	[tpg_get_posts]

	
This default usage will return the last 5 posts in reverse chronological order.  It will display the post similarly to a standard post, honoring the <!more> tag to produce a teaser.  Meta data showing post date, author, modified date, comments, categories and tags is also displayed.
	
See the usage section in 'Other Notes' for a list of parms and more examples of use.
	
== Usage ==

**WARNING**  If you copy/paste the commands, the function may not work. If this happens, type the entire command in to avoid introducing hidden characters.

To use it, just put the following into the HTML of any page or post, use as many times as you like on the same page:

	[tpg_get_posts]
	
	this is equivalent to:
	
	[tpg_get_posts show_meta="true" post_entire="false" fields="post_title, post_content" 
	fields_classes ="p_title_class, p_content_class" numberposts=5 ]
	
This default usage will return the last 5 posts in reverse chronological order.  It will display the post similarly to a standard post, honoring the <!more> tag to produce a teaser.  Meta data showing post date, 
author, modified date, comments, categories and tags is also displayed.

A common usage is to show post on a page that have a common tag:
	
	[tpg_get_posts tag="tag1, tag2,tag3"]

Along with all the options provided by the get_posts template tag, 
it will also accept a few additional options:

* tag. This allows for the selection of posts by tag.

* category_name. This allows for the selection of posts by category_name.

* category. This allows for the selection of posts by category number.

* show_entire. This option show_entire="true" will show the entire post, not just the teaser. Default is "false"

* show_meta. This option show_meta="false" will suppress the display of metadata.  Default is "true".

* show_byline. This option show_byline="false" will suppress the display of the by-line.  Default is "true".

* shorten_title.  This option shorten_title="c15" or shorten_title="w15" specifies that the title will be shortened to 15 characters.  The 'c' indicates to cut at the character while the 'w' indicates that only whole words in the first 15 characters are included.

* shorten_content. Using the more tag is generally a better option, but is is provided for consistency.  This option shorten_content="c150" or shorten_content="w150" specifies that the content will be shortened to 150 characters, excluding the "read more..." text.  The 'c' indicates to cut at the character while the 'w' indicates that only whole words in the first 150 characters are included.  The 'read more' tag is processed first, then this process is applied, so a read more tag can cause the text to be shorter than the specified length if placed in the post before the first x characters.

* text_ellipsis.  This parameter allows you to set the ellipsis displayed after shortened text.  it defaults to text_ellipsis=' ...' but can be set to anything or nothing text_ellipsis=''.

* title_tag.  This parameter controls the formatting of the title line.  The default is to make post titles h2, which is consistent with the regular post markup.  title_tag="p" will apply the paragraph markup.  Note: do not include the <>.

* ul_class. This is the class assigned to the bullet list.  When this class is provided, the output is returned as an unordered list.

* fields. This is a comma separated list of fields to show, taken right from the [wp_posts database table fields](http://codex.wordpress.org/Database_Description/2.7#Table:_wp_posts). The default is "post_title, post_content".

* fields_classes.  Another comma separated list that lets you assign a class to each of the fields specified above, which will be provided via a <span> tag wrapped around the field.  The default value for this list is "post_title_class".  The default classes are p_title_class, p_content_class.  The metadata has a class
of p_metadata_class.


A couple of examples:

	[tpg_get_posts tag="tag1,tag2" numberposts=5 orderby="title]

Shows 5 posts with the tag "tag1" or "tag2" ordered by title. Display the post title and content teaser.

	[tpg_get_posts category_name="Events,News" numberposts=2 orderby="title show_entire="true"]

Shows 2 posts with the category name of "Events" or "News" ordered by title. Display the post title and the entire content.

	[tpg_get_posts tag="tag5" fields="post_title" ul_class="p_ul_class"]

Shows a bullet list of post titles. The title will be wrapped in a <span> tag with a class of "class1", the date with a <span> of class "p_ul_class".  The title will provide a link to the post. The title can be formatted with a css style .p_ul_class h2 {}.

Check the [get_posts template tag](http://codex.wordpress.org/Template_Tags/get_posts) documentation for all of the possible options associated with the tag, and the [wp_posts database table fields](http://codex.wordpress.org/Database_Description/2.7#Table:_wp_posts) for all possible field names.

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory and unzip it.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Place `[tpg_get_posts]` in your pages. 

== Frequently Asked Questions ==

= How to I format the output? =

Set the format in your css
 
* heading - .p_title_class
* byline - .p_byline
* content - .p_content_class
* metadata - .p_metadata_class

= Can this plugin select by category? =

Yes, multiple category_name(s) can be submitted.  The base WordPress function get_posts accepts only a single category, but multiple category ids.  So in the plugin, the category name is converted to the category id and the category_name parameter is blanked out and the post is requested by multiple ids.

= Can I combine categories and tags? =

Yes, but listing both category and tag as selection criteria forms 'and' logic not 'or' logic.  So if a post meets both selection criteria, then it is selected.  If it meets only a single selection, then it is ignored.  

== Screenshots ==

1. This screen shot of a page using the plugin shows how the output is formatted by default. 

== Changelog ==
= 1.2.3 =
* Corrected error introduced in version 1.2.2 when no parameters were passed - the argument parameter defaulted as a space and not an array which threw an invalid type error. 

= 1.2.2 =
* Corrected option behavior to allow additional get_posts options to be accepted.  The earlier releases of this plugin only allowed the options defined in the default table to be passed to WP get_posts.  This fix appends any undefined option to the table and passes it to WP get_posts.  thanks cdaley1981 for pointing this out.

= 1.2.1 =
* Added option to suppress byline with show_byline tag.

= 1.2 =
* Corrected typos in documentation
* Add function to restrict length of title and content.
  New options are available to specify the max length of title and max length of content in characters.  The option also includes a code ('c' or 'w') to specify if the filtered text should only contain whole words.

= 1.1 =
* Add code to honor the page comment settings.  (Thanks to unidentified person for providing the code fix.)
  Problem:  comments were not being allowed on page where the short-code was used.
  Solution:  save the page settings before fetching the posts and then restore settings before returning the page.

= 1.0 =
* Update to allow multiple categories to be entered

= 0.1 =
* Initial release. 

== Upgrade Notice ==

= 1.2.1 =
Added option to supress byline

