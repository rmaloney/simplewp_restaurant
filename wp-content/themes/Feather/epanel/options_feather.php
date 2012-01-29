<?php
global $epanelMainTabs, $themename, $shortname, $default_colorscheme, $options, $et_bg_texture_urls, $et_google_fonts, $epanel_texture_urls;

$themename = "Feather";
$shortname = "feather";
$default_colorscheme = "Default";

$epanelMainTabs = array('general','navigation','layout','ad','colorization','seo','integration','support');

$cats_array = get_categories('hide_empty=0');
$pages_array = get_pages('hide_empty=0');
$pages_number = count($pages_array);

$site_pages = array();
$site_cats = array();
$pages_ids = array();
$cats_ids = array();

foreach ($pages_array as $pagg) {
	$site_pages[$pagg->ID] = htmlspecialchars($pagg->post_title);
	$pages_ids[] = $pagg->ID;
}

foreach ($cats_array as $categs) {
	$site_cats[$categs->cat_ID] = $categs->cat_name;
	$cats_ids[] = $categs->cat_ID;
}

$et_bg_texture_urls = array('Thin Vertical Lines', 'Small Squares', 'Thick Diagonal Lines', 'Thin Diagonal Lines', 'Diamonds', 'Small Circles', 'Thick Vertical Lines', 'Thin Flourish', 'Thick Flourish', 'Pocodot', 'Checkerboard', 'Squares', 'Noise', 'Wooden', 'Stone', 'Canvas');

$et_google_fonts = apply_filters( 'et_google_fonts', array('Kreon','Droid Sans','Droid Serif','Lobster','Yanone Kaffeesatz','Nobile','Crimson Text','Arvo','Tangerine','Cuprum','Cantarell','Philosopher','Josefin Sans','Dancing Script','Raleway','Bentham','Goudy Bookletter 1911','Quattrocento','Ubuntu', 'PT Sans') );
sort($et_google_fonts);

$epanel_texture_urls = $et_bg_texture_urls;
array_unshift( $epanel_texture_urls, 'Default' );

$options = array (

	array( "name" => "wrap-general",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "general-1",
				   "type" => "subnav-tab",
				   "desc" => "General"),

			array( "name" => "general-2",
				   "type" => "subnav-tab",
				   "desc" => "Homepage"),

			array( "name" => "general-3",
				   "type" => "subnav-tab",
				   "desc" => "Featured Slider"),

		array( "type" => "subnavtab-end",),

		array( "name" => "general-1",
			   "type" => "subcontent-start",),
			   
			array( "name" => "Logo",
				   "id" => $shortname."_logo",
				   "type" => "upload",
				   "std" => "",
				   "desc" => "desc."
			),

			array( "name" => "Favicon",
				   "id" => $shortname."_favicon",
				   "type" => "upload",
				   "std" => "",
				   "desc" => "desc."
			),
		
			array( "name" => "Background Color",
				   "id" => $shortname."_bgcolor",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "desc.",),
				   
			array( "name" => "Background Texture",
				   "id" => $shortname."_bgtexture_url",
				   "type" => "select",
				   "std" => "Default",
				   "options" => $epanel_texture_urls,
				   "desc" => "desc.",),
				   
			array( "name" => "Background Image",
				   "id" => $shortname."_bgimage",
				   "type" => "upload",
				   "std" => "",
				   "desc" => "desc."
			),
							   
			array( "name" => "Header Font",
				   "id" => $shortname."_header_font",
				   "type" => "select",
				   "std" => "Lobster",
				   "options" => $et_google_fonts,
				   "desc" => "desc.",),
				   
			array( "name" => "Header Font Color",
				   "id" => $shortname."_header_font_color",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "desc.",),
				   
			array( "name" => "Body Font",
				   "id" => $shortname."_body_font",
				   "type" => "select",
				   "std" => "Droid Sans",
				   "options" => $et_google_fonts,
				   "desc" => "desc.",),
				   
			array( "name" => "Body Font Color",
				   "id" => $shortname."_body_font_color",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "desc.",),

			array( "name" => "Blog Style post format",
                   "id" => $shortname."_blog_style",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => "By default the theme truncates your posts on index/homepages automatically to create post previews. If you would rather show your posts in full on index pages like a traditional blog then you can activate this feature."),

			array( "name" => "Grab the first post image",
				   "id" => $shortname."_grab_image",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => "By default thumbnail images are created using custom fields. However, if you would rather use the images that are already in your post for your thumbnail (and bypass using custom fields) you can activate this option. Once activcated thumbnail images will be generated automatically using the first image in your post. The image must be hosted on your own server."),

			array( "type" => "clearfix",),
			
			array( "name" => "Show Twitter Icon",
                   "id" => $shortname."_show_twitter_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "desc."),
			
			array( "name" => "Show RSS Icon",
                   "id" => $shortname."_show_rss_icon",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "desc."),

			array( "type" => "clearfix",),
			
			array( "name" => "Show Facebook Icon",
                   "id" => $shortname."_show_facebook_icon",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "desc."),
			
			array( "type" => "clearfix",),
			
			array( "name" => "Twitter Profile Url",
                   "id" => $shortname."_twitter_url",
                   "std" => "#",
                   "type" => "text",
				   "desc" => "desc."),
			
			array( "name" => "RSS Icon Url",
                   "id" => $shortname."_rss_url",
                   "std" => "",
                   "type" => "text",
				   "desc" => "desc."),
				   
			array( "name" => "Facebook Profile Url",
                   "id" => $shortname."_facebook_url",
                   "std" => "#",
                   "type" => "text",
				   "desc" => "desc."),
							   				   
			array( "name" => "Number of Posts displayed on Category page",
                   "id" => $shortname."_catnum_posts",
                   "std" => "6",
                   "type" => "text",
				   "desc" => "Here you can designate how many recent articles are displayed on the Category page. This option works independently from the Settings > Reading options in wp-admin."),

			array( "name" => "Number of Posts displayed on Archive pages",
                   "id" => $shortname."_archivenum_posts",
                   "std" => "5",
                   "type" => "text",
				   "desc" => "Here you can designate how many recent articles are displayed on the Archive pages. This option works independently from the Settings > Reading options in wp-admin."),

			array( "name" => "Number of Posts displayed on Search pages",
                   "id" => $shortname."_searchnum_posts",
                   "std" => "5",
                   "type" => "text",
				   "desc" => "Here you can designate how many recent articles are displayed on the Search results pages. This option works independently from the Settings > Reading options in wp-admin."),

			array( "name" => "Number of Posts displayed on Tag pages",
                   "id" => $shortname."_tagnum_posts",
                   "std" => "5",
                   "type" => "text",
				   "desc" => "Here you can designate how many recent articles are displayed on the Tag pages. This option works independently from the Settings > Reading options in wp-admin."),

			array( "name" => "Date format",
				   "id" => $shortname."_date_format",
				   "std" => "M j, Y",
                   "type" => "text",
				   "desc" => "This option allows you to change how your dates are displayed. For more information please refer to the WordPress codex here:<a href='http://codex.wordpress.org/Formatting_Date_and_Time' target='_blank'>Formatting Date and Time</a>"),
				   				   
			array( "type" => "clearfix",),
			
			array( "name" => "Use excerpts when defined",
				   "id" => $shortname."_use_excerpt",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "desc."),
				   
			array( "name" => "Show Control Panel",
				   "id" => $shortname."_show_control_panel",
				   "type" => "checkbox2",
				   "std" => "on",
				   "desc" => "desc."),

			array( "type" => "clearfix",),
			
			array( "type" => "clearfix",),

		array( "name" => "general-1",
			   "type" => "subcontent-end",),

		array( "name" => "general-2",
			   "type" => "subcontent-start",),
			   
			array( "name" => "Display Content Areas",
                   "id" => $shortname."_display_blurbs",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "desc."),
			
			array( "name" => "Display Recent Blog Posts Section",
                   "id" => $shortname."_display_recentblog_section",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "desc."),
			
			array( "type" => "clearfix",),
			   
			array( "name" => "Display Homepage Quote",
                   "id" => $shortname."_quote",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "This controls the quote that appears on the homepage 3 blurbs."),
			
			array( "name" => "Display Recent Work Section",
                   "id" => $shortname."_display_recentwork_section",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "desc."),
				   				   
			array( "type" => "clearfix",),
			   
			array( "name" => "Quote Text",
                   "id" => $shortname."_quote_one",
                   "std" => 'Nunc luctus porta mi a estib ulum Etiam sem nisl auctor sit amet molestie sed pharetra a purus. Fusce massa dolor, facilisis eu sagittis elementum, porttitor id nisi. Dus vel ipsum neque.',
                   "type" => "text",
				   "desc" => "Here you can define the text that appears in the homepage quote."),
				   
			array( "name" => "Content Area 1 Page",
				   "id" => $shortname."_home_page_1",
				   "std" => "",
				   "type" => "select",
				   "desc" => "desc.",
				   "options" => $site_pages),
				   
			array( "name" => "Content Area 2 Page",
				   "id" => $shortname."_home_page_2",
				   "std" => "",
				   "type" => "select",
				   "desc" => "desc.",
				   "options" => $site_pages),
						
			array( "name" => "Content Area 3 Page",
				   "id" => $shortname."_home_page_3",
				   "std" => "",
				   "type" => "select",
				   "desc" => "desc.",
				   "options" => $site_pages),
				   
			array( "name" => "Content Area 4 Page",
				   "id" => $shortname."_home_page_4",
				   "std" => "",
				   "type" => "select",
				   "desc" => "desc.",
				   "options" => $site_pages),
				   
			array( "name" => "Recent Blog Posts Section Category",
				   "id" => $shortname."_home_recentblog_section",
				   "std" => "",
				   "type" => "select",
				   "desc" => "desc.",
				   "options" => $site_cats),
				   
			array( "name" => "Recent Blog Posts Section description",
                   "id" => $shortname."_homeblog_desc",
                   "std" => "Duis ligula massa consectetur a tincidunt pulvinar",
                   "type" => "text",
				   "desc" => "Recent Blog Posts Section description"),
				   
			array( "name" => "Recent Work Section description",
                   "id" => $shortname."_homework_desc",
                   "std" => "Sendun ligula massa consectetur a tincidunt pulvinar",
                   "type" => "text",
				   "desc" => "Recent Work Section description"),
			
			array( "name" => "Number of Posts in Recent Work Section",
                   "id" => $shortname."_posts_media",
                   "std" => "10",
                   "type" => "text",
				   "desc" => "Here you can designate how many recent articles are displayed in Media bar on the homepage. "),
				   
			array( "name" => "Exclude categories from Recent Work Section",
				   "id" => $shortname."_exlcats_media",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => "If you would like to exlcude certain category from the list you can do so here. ",
				   "usefor" => "categories",
				   "options" => $cats_ids),
				   							   
			array( "name" => "Number of Recent Posts displayed on homepage ( in Blog style mode )",
                   "id" => $shortname."_homepage_posts",
                   "std" => "7",
                   "type" => "text",
				   "desc" => "Here you can designate how many recent articles are displayed on the homepage. This option works independently from the Settings > Reading options in wp-admin."),
				   
			array( "name" => "Exclude categories from homepage recent posts ( in Blog style mode )",
				   "id" => $shortname."_exlcats_recent",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => "By default the homepage displays a list of all of your most recent posts. However, if you would like to exlcude certain category from the list you can do so here. ",
				   "usefor" => "categories",
				   "options" => $cats_ids),

		array( "name" => "general-2",
			   "type" => "subcontent-end",),

		array( "name" => "general-3",
				   "type" => "subcontent-start",),

			array( "name" => "Display Featured Slider",
                   "id" => $shortname."_featured",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "You can choose whether or not to display the Featured Articles section on the homepge. If you don't want to utilize this feature simply disable this option."),

			array( "name" => "Duplicate Featured Articles",
                   "id" => $shortname."_duplicate",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "In some cases your Featured Articles will also be one of your most recent articles, in which case the article will be displayed twice on the homepage. If you would like to remove duplicate posts enable this option."),

			array( "type" => "clearfix",),

			array( "name" => "Featured Category",
                   "id" => $shortname."_feat_cat",
                   "type" => "select",
			       "options" => $site_cats,
				   "desc" => "Here you can choose which category to be used to populate the Featured Slider on the homepage. This only applies if you have disabled the Use Pages options below."),

			array( "name" => "Number of Featured Slides",
                   "id" => $shortname."_featured_num",
                   "std" => "3",
                   "type" => "text",
				   "desc" => "This setting controls how menu tabs are added to the Featured Articles slider on the homepage."),
				   
			array( "name" => "Use pages",
                   "id" => $shortname."_use_pages",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => "The homepage Featured Slider can be set up using two methods. You can populate the slider using Posts, or you can populate it using Pages. If you would like to use Pages in the Featured Slider then enable this option."),

			array( "type" => "clearfix",),
	   
			array( "name" => "Include pages in the Featured Slider (if Use Pages enabled)",
				   "id" => $shortname."_feat_pages",
				   "type" => "checkboxes",
				   "std" => '',
				   "desc" => "If you selected Use Pages above, then use the checkboxes below to choose which pages are displayed in the Featured Slider.",
				   "usefor" => "pages",
				   "excludeDefault" => "true",
				   "options" => $pages_ids),
				   				   
			array( "name" => "Automatic Slider Animation",
                   "id" => $shortname."_slider_auto",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => "If you would like the Featured Articles slider to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired."),
				   				   
			array( "type" => "clearfix",),

			array( "name" => "Automatic Animation Speed (in ms)",
                   "id" => $shortname."_slider_autospeed",
                   "type" => "text",
			       "std" => "7000",
				   "desc" => "Here you can designate how fast the slider fades between each article. The higher the number the longer the pause between each rotation."),

		array( "name" => "general-3",
			   "type" => "subcontent-end",),   

	array(  "name" => "wrap-general",
			"type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-navigation",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "navigation-1",
				   "type" => "subnav-tab",
				   "desc" => "Pages"),

			array( "name" => "navigation-2",
				   "type" => "subnav-tab",
				   "desc" => "Categories"),

			array( "name" => "navigation-3",
				   "type" => "subnav-tab",
				   "desc" => "General Settings"),

		array( "type" => "subnavtab-end",),

		array( "name" => "navigation-1",
			   "type" => "subcontent-start",),

			array( "name" => "Exclude pages from the navigation bar",
				   "id" => $shortname."_menupages",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => "Here you can choose to remove certain pages from the navigation menu. All pages marked with an X will not appear in your navigation bar. ",
				   "usefor" => "pages",
				   "options" => $pages_ids),

			array( "name" => "Show dropdown menus",
            "id" => $shortname."_enable_dropdowns",
            "type" => "checkbox",
            "std" => "on",
			"desc" => "If you would like to remove the dropdown menus from the pages navigation bar disable this feature."),

			array( "name" => "Display Home link",
            "id" => $shortname."_home_link",
            "type" => "checkbox2",
            "std" => "on",
			"desc" => "By default the theme creates a Home link that, when clicked, leads back to your blog's homepage. If, however, you are using a static homepage and have already created a page called Home to use, this will result in a duplicate link. In this case you should disable this feature to remove the link."),

			array( "type" => "clearfix",),

			array( "name" => "Sort Pages Links",
                   "id" => $shortname."_sort_pages",
                   "type" => "select",
                   "std" => "post_title",
				   "desc" => "Here you can choose to sort your pages links.",
                   "options" => array("post_title", "menu_order","post_date","post_modified","ID","post_author","post_name")),

			array( "name" => "Order Pages Links by Ascending/Descending",
                   "id" => $shortname."_order_page",
                   "type" => "select",
                   "std" => "asc",
				   "desc" => "Here you can choose to reverse the order that your pages links are displayed. You can choose between ascending and descending.",
                   "options" => array("asc", "desc")),

			array( "name" => "Number of dropdown tiers shown",
            "id" => $shortname."_tiers_shown_pages",
            "type" => "text",
            "std" => "3",
			"desc" => "This options allows you to control how many teirs your pages dropdown menu has. Increasing the number allows for additional menu items to be shown."),

			array( "type" => "clearfix",),


		array( "name" => "navigation-1",
			   "type" => "subcontent-end",),

		array( "name" => "navigation-2",
			   "type" => "subcontent-start",),

			array( "name" => "Exclude categories from the navigation bar",
				   "id" => $shortname."_menucats",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => "Here you can choose to remove certain categories from the navigation menu. All categories marked with an X will not appear in your navigation bar. ",
				   "usefor" => "categories",
				   "options" => $cats_ids),

			array( "name" => "Show dropdown menus",
            "id" => $shortname."_enable_dropdowns_categories",
            "type" => "checkbox",
            "std" => "on",
			"desc" => "If you would like to remove the dropdown menus from the categories navigation bar disable this feature."),

			array( "name" => "Hide empty categories",
            "id" => $shortname."_categories_empty",
            "type" => "checkbox",
            "std" => "on",
			"desc" => "If you would like categories to be displayed in your navigationbar that don't have any posts in them then disable this option. By default empty categories are hidden"),

			array( "type" => "clearfix",),

			array( "name" => "Number of dropdown tiers shown",
            "id" => $shortname."_tiers_shown_categories",
            "type" => "text",
            "std" => "3",
			"desc" => "This options allows you to control how many teirs your pages dropdown menu has. Increasing the number allows for additional menu items to be shown."),

			array( "type" => "clearfix",),

		    array( "name" => "Sort Categories Links by Name/ID/Slug/Count/Term Group",
                   "id" => $shortname."_sort_cat",
                   "type" => "select",
                   "std" => "name",
				   "desc" => "By default pages are sorted by name. However if you would rather have them sorted by ID you can adjust this setting.",
                   "options" => array("name", "ID", "slug", "count", "term_group")),

			array( "name" => "Order Category Links by Ascending/Descending",
                   "id" => $shortname."_order_cat",
                   "type" => "select",
                   "std" => "asc",
				   "desc" => "Here you can choose to reverse the order that your categories links are displayed. You can choose between ascending and descending.",
                   "options" => array("asc", "desc")),

		array( "name" => "navigation-2",
			   "type" => "subcontent-end",),

		array( "name" => "navigation-3",
			   "type" => "subcontent-start",),

			array( "name" => "Disable top tier dropdown menu links",
            "id" => $shortname."_disable_toptier",
            "type" => "checkbox2",
            "std" => "false",
			"desc" => "In some cases users will want to create parent categories or links as placeholders to hold a list of child links or categories. In this case it is not desirable to have the parent links lead anywhere, but instead merely serve an organizational function. Enabling this options will remove the links from all parent pages/categories so that they don't lead anywhere when clicked."),

			array( "type" => "clearfix",),

		array( "name" => "navigation-3",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-navigation",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-layout",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "layout-1",
				   "type" => "subnav-tab",
				   "desc" => "Single Post Layout"),

			array( "name" => "layout-2",
				   "type" => "subnav-tab",
				   "desc" => "Single Page Layout"),

			array( "name" => "layout-3",
				   "type" => "subnav-tab",
				   "desc" => "General Settings"),

		array( "type" => "subnavtab-end",),

		array( "name" => "layout-1",
			   "type" => "subcontent-start",),

			array( "name" => "Choose which items to display in the postinfo section",
				   "id" => $shortname."_postinfo2",
				   "type" => "different_checkboxes",
				   "std" => array("author","date","categories","comments"),
				   "desc" => "Here you can choose which items appear in the postinfo section on single post pages. This is the area, usually below the post title, which displays basic information about your post. The highlighted itmes shown below will appear. ",
				   "options" => array("author","date","categories","comments")),

			array( "name" => "Place Thumbs on Posts",
                   "id" => $shortname."_thumbnails",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "By default thumbnails are placed at the beginning of your post on single post pages. If you would like to remove this initial thumbnail image to avoid repetition simply disable this option. "),
				   
			array( "name" => "Show comments on posts",
            "id" => $shortname."_show_postcomments",
            "type" => "checkbox2",
            "std" => "on",
			"desc" => "You can disable this option if you want to remove the comments and comment form from single post pages. "),

			array( "type" => "clearfix",),

		array( "name" => "layout-1",
			   "type" => "subcontent-end",),

		array( "name" => "layout-2",
			   "type" => "subcontent-start",),

			array( "name" => "Place Thumbs on Pages",
                   "id" => $shortname."_page_thumbnails",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => "By default thumbnails are not placed on pages (they are only used on posts). However, if you want to use thumbnails on posts you can! Just enable this option. "),

			array( "name" => "Show comments on pages",
            "id" => $shortname."_show_pagescomments",
            "type" => "checkbox",
            "std" => "false",
			"desc" => "By default comments are not placed on pages, however, if you would like to allow people to comment on your pages simply enable this option. "),

			array( "type" => "clearfix",),

		array( "name" => "layout-2",
			   "type" => "subcontent-end",),

		array( "name" => "layout-3",
			   "type" => "subcontent-start",),

			array( "name" => "Post info section",
				   "id" => $shortname."_postinfo1",
				   "type" => "different_checkboxes",
				   "std" => array("author","date","categories","comments"),
				   "desc" => "Here you can choose which items appear in the postinfo section on pages. This is the area, usually below the post title, which displays basic information about your post. The highlighted itmes shown below will appear. ",
				   "options" => array("author","date","categories","comments")),
				   
			array( "type" => "clearfix",),
				   
			array( "name" => "Show Thumbs on Index pages",
                   "id" => $shortname."_thumbnails_index",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "desc. "),	   

			array( "type" => "clearfix",),

		array( "name" => "layout-3",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-layout",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-colorization",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "colorization-1",
				   "type" => "subnav-tab",
				   "desc" => "Colorization"),

		array( "type" => "subnavtab-end",),

		array( "name" => "colorization-1",
			   "type" => "subcontent-start",),

			array( "name" => "Color visualizer (this is not setting, just a tool to find hexdecimal values)",
				   "type" => "colorpicker",
				   "desc" => "This is a tool that can be used to find hexdecimal color values. These values can be used to customize the colors of the various elements below. This color picker will also appear which you click in any of the fields below. ",),

			array( "name" => "Enable custom colors",
                   "id" => $shortname."_custom_colors",
                   "type" => "checkbox",
                   "std" => "false",
                   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click in the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value."),

			array( "name" => "Enable child stylesheet",
                   "id" => $shortname."_child_css",
                   "type" => "checkbox2",
                   "std" => "false",
                   "desc" => "If you would like to add a second stylsheet to your blog enable this option and input the link to your stylesheet below."),

			array( "type" => "clearfix",),

			array( "name" => "Child stylesheet URL",
				   "id" => $shortname."_child_cssurl",
				   "type" => "text",
				   "std" => "",
				   "desc" => "Input the URL to your child stylsheet here.",),

			array( "name" => "Main font color",
				   "id" => $shortname."_color_mainfont",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Link color",
				   "id" => $shortname."_color_mainlink",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Menu link color",
				   "id" => $shortname."_color_pagelink",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),
				   
			array( "name" => "Menu active link color",
				   "id" => $shortname."_color_pagelink_active",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),	   
				   
			array( "name" => "Headings color",
				   "id" => $shortname."_color_headings",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Sidebar links color",
				   "id" => $shortname."_color_sidebar_links",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

			array( "name" => "Footer text color",
				   "id" => $shortname."_footer_text",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

		    array( "name" => "Footer links color",
				   "id" => $shortname."_color_footerlinks",
				   "type" => "textcolorpopup",
				   "std" => "",
				   "desc" => "This option allows you to customize the color of a certain element of the theme. When you click inside the field a color picker will appear. Scroll to find your desired color and then click the circular submit button on the lower right to accept the value",),

		array( "name" => "colorization-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-colorization",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//
	array( "name" => "wrap-seo",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "seo-1",
				   "type" => "subnav-tab",
				   "desc" => "Homepage SEO",),

			array( "name" => "seo-2",
				   "type" => "subnav-tab",
				   "desc" => "Single Post Page SEO",),

			array( "name" => "seo-3",
				   "type" => "subnav-tab",
				   "desc" => "Index Page SEO",),

		array( "type" => "subnavtab-end",),

		array( "name" => "seo-1",
			   "type" => "subcontent-start",),

			array( "name" => " Enable custom title ",
				   "id" => $shortname."_seo_home_title",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "By default the theme uses a combination of your blog name and your blog description, as defined when you created your blog, to create your homepage titles. However if you want to create a custom title then simply enable this option and fill in the custom title field below. ",),

			array( "name" => " Enable meta description",
				   "id" => $shortname."_seo_home_description",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "By default the theme uses your blog description, as defined when you created your blog, to fill in the meta description field. If you would like to use a different description then enable this option and fill in the custom description field below. ",),

			array( "name" => " Enable meta keywords",
				   "id" => $shortname."_seo_home_keywords",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "By default the theme does not add keywords to your header. Most search engines don't use keywords to rank your site anymore, but some people define them anyway just in case. If you want to add meta keywords to your header then enable this option and fill in the custom keywords field below. ",),

			array( "name" => " Enable canonical URL's",
				   "id" => $shortname."_seo_home_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URLs all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",),

			array( "type" => "clearfix",),

			array( "name" => "Homepage custom title (if enabled)",
				   "id" => $shortname."_seo_home_titletext",
				   "type" => "text",
				   "std" => "",
				   "desc" => "If you have enabled custom titles you can add your custom title here. Whatever you type here will be placed between the < title >< /title > tags in header.php",),

			array( "name" => "Homepage meta description (if enabled)",
				   "id" => $shortname."_seo_home_descriptiontext",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "If you have enabled meta descriptions you can add your custom description here.",),

			array( "name" => "Homepage meta keywords (if enabled)",
				   "id" => $shortname."_seo_home_keywordstext",
				   "type" => "text",
				   "std" => "",
				   "desc" => "If you have enabled meta keywords you can add your custom keywords here. Keywords should be separated by comas. For example: wordpress,themes,templates,elegant",),

			array( "name" => "If custom titles are disabled, choose autogeneration method",
				   "id" => $shortname."_seo_home_type",
				   "type" => "select",
				   "std" => "BlogName | Blog description",
				   "options" => array("BlogName | Blog description", "Blog description | BlogName", "BlogName only"),
				   "desc" => "If you are not using cutsom post titles you can still have control over how your titles are generated. Here you can choose which order you would like your post title and blog name to be displayed, or you can remove the blog name from the title completely.",),

			array( "name" => "Define a character to separate BlogName and Post title",
				   "id" => $shortname."_seo_home_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => "Here you can change which character separates your blog title and post name when using autogenerated post titles. Common values are | or -",),

		array( "name" => "seo-1",
			   "type" => "subcontent-end",),

		array( "name" => "seo-2",
			   "type" => "subcontent-start",),

			array( "name" => "Enable custom titles",
				   "id" => $shortname."_seo_single_title",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "By default the theme creates post titles based on the title of your post and your blog name. If you would like to make your meta title different than your actual post title you can define a custom title for each post using custom fields. This option must be enabled for custom titles to work, and you must choose a custom field name for your title below.",),

			array( "name" => "Enable custom description",
				   "id" => $shortname."_seo_single_description",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => "If you would like to add a meta description to your post you can do so using custom fields. This option must be enabled for descriptions to be displayed on post pages. You can add your meta description using custom fields based off the custom field name you define below.",),

			array( "type" => "clearfix",),

			array( "name" => "Enable custom keywords",
				   "id" => $shortname."_seo_single_keywords",
				   	"type" => "checkbox",
				   "std" => "false",
				   "desc" => "If you would like to add meta keywords to your post you can do so using custom fields. This option must be enabled for keywords to be displayed on post pages. You can add your meta keywords using custom fields based off the custom field name you define below.",),

			array( "name" => "Enable canonical URL's",
				   "id" => $shortname."_seo_single_canonical",
				   "type" => "checkbox2",
				   "std" => "false",
				   "desc" => "Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",),

			array( "type" => "clearfix",),

			array( "name" => "Custom field Name to be used for title",
				   "id" => $shortname."_seo_single_field_title",
				   "type" => "text",
				   "std" => "seo_title",
				   "desc" => "When you define your title using custom fields you should use this value for the custom field Name. The Value of your custom field should be the custom title you would like to use.",),

			array( "name" => "Custom field Name to be used for description",
				   "id" => $shortname."_seo_single_field_description",
				   "type" => "text",
				   "std" => "seo_description",
				   "desc" => "When you define your meta description using custom fields you should use this value for the custom field Name. The Value of your custom field should be the custom description you would like to use.",),

			array( "name" => "Custom field Name to be used for keywords",
				   "id" => $shortname."_seo_single_field_keywords",
				   "type" => "text",
				   "std" => "seo_keywords",
				   "desc" => "When you define your keywords using custom fields you should use this value for the custom field Name. The Value of your custom field should be the meta keywords you would like to use, separated by comas.",),

			array( "name" => "If custom titles are disabled, choose autogeneration method",
				   "id" => $shortname."_seo_single_type",
				   "type" => "select",
				   "std" => "Post title | BlogName",
				   "options" => array("Post title | BlogName", "BlogName | Post title", "Post title only"),
				   "desc" => "If you are not using cutsom post titles you can still have control over hw your titles are generated. Here you can choose which order you would like your post title and blog name to be displayed, or you can remove the blog name from the title completely.",),

			array( "name" => "Define a character to separate BlogName and Post title",
				   "id" => $shortname."_seo_single_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => "Here you can change which character separates your blog title and post name when using autogenerated post titles. Common values are | or -",),

		array( "name" => "seo-2",
			   "type" => "subcontent-end",),

		array( "name" => "seo-3",
				   "type" => "subcontent-start",),

			array( "name" => " Enable canonical URL's",
				   "id" => $shortname."_seo_index_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "desc" => "Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",),

			array( "name" => "Enable meta descriptions",
				   "id" => $shortname."_seo_index_description",
				   	"type" => "checkbox2",
				   "std" => "false",
				   "desc" => "Check this box if you want to display meta descriptions on category/archive pages. The description is based off the category description you choose when creating/edit your category in wp-admin.",),

			array( "type" => "clearfix",),

			array( "name" => "Choose title autogeneration method",
				   "id" => $shortname."_seo_index_type",
				   "type" => "select",
				   "std" => "Category name | BlogName",
				   "options" => array("Category name | BlogName", "BlogName | Category name", "Category name only"),
				   "desc" => "Here you can choose how your titles on index pages are generated. You can change which order your blog name and index title are displayed, or you can remove the blog name from the title completely.",),

			array( "name" => "Define a character to separate BlogName and Post title",
				   "id" => $shortname."_seo_index_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => "Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -",),

			array( "type" => "clearfix",),

		array( "name" => "seo-3",
				   "type" => "subcontent-end",),

	array(  "name" => "wrap-seo",
			"type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-integration",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "integration-1",
				   "type" => "subnav-tab",
				   "desc" => "Code Integration"),

		array( "type" => "subnavtab-end",),

		array( "name" => "integration-1",
			   "type" => "subcontent-start",),

			array( "name" => "Enable header code",
                   "id" => $shortname."_integrate_header_enable",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the header code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "name" => "Enable body code",
                   "id" => $shortname."_integrate_body_enable",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the body code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "type" => "clearfix",),

			array( "name" => "Enable single top code",
                   "id" => $shortname."_integrate_singletop_enable",
                   "type" => "checkbox",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the single top code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "name" => "Enable single bottom code",
                   "id" => $shortname."_integrate_singlebottom_enable",
                   "type" => "checkbox2",
                   "std" => "on",
                   "desc" => "Disabling this option will remove the single bottom code below from your blog. This allows you to remove the code while saving it for later use."),

			array( "type" => "clearfix",),

			array( "name" => "Add code to the < head > of your blog",
				   "id" => $shortname."_integration_head",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Any code you place here will appear in the head section of every page of your blog. This is useful when you need to add javascript or css to all pages.",),

			array( "name" => "Add code to the < body > (good for tracking codes such as google analytics)",
				   "id" => $shortname."_integration_body",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Any code you place here will appear in body section of all pages of your blog. This is usefull if you need to input a tracking pixel for a state counter such as Google Analytics.",),

			array( "name" => "Add code to the top of your posts",
				   "id" => $shortname."_integration_single_top",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Any code you place here will be placed at the top of all single posts. This is useful if you are looking to integrating things such as social bookmarking links.",),

			array( "name" => "Add code to the bottom of your posts, before the comments",
				   "id" => $shortname."_integration_single_bottom",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Any code you place here will be placed at the top of all single posts. This is useful if you are looking to integrating things such as social bookmarking links.",),

		array( "name" => "integration-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-integration",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-support",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "support-1",
				   "type" => "subnav-tab",
				   "desc" => "Installation"),

			array( "name" => "support-2",
				   "type" => "subnav-tab",
				   "desc" => "Troubleshooting"),

			array( "name" => "support-3",
				   "type" => "subnav-tab",
				   "desc" => "Tutorials"),

		array( "type" => "subnavtab-end",),

		array( "name" => "support-1",
			   "type" => "subcontent-start",),

			array( "name" => "installation",
				   "type" => "support",),

		array( "name" => "support-1",
			   "type" => "subcontent-end",),

		array( "name" => "support-2",
			   "type" => "subcontent-start",),

			array( "name" => "troubleshooting",
				   "type" => "support",),

		array( "name" => "support-2",
			   "type" => "subcontent-end",),

		array( "name" => "support-3",
			   "type" => "subcontent-start",),

			array( "name" => "tutorials",
				   "type" => "support",),

		array( "name" => "support-3",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-support",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "wrap-advertisements",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "advertisements-1",
				   "type" => "subnav-tab",
				   "desc" => "Manage Un-widgetized Advertisements"),

		array( "type" => "subnavtab-end",),

		array( "name" => "advertisements-1",
			   "type" => "subcontent-start",),

			array( "name" => "Enable 468x60 banner",
				   "id" => $shortname."_468_enable",
				   	"type" => "checkbox",
				   "std" => "false",
				   "desc" => "Enabling this option will display a 468x60 banner ad on the bottom of your post pages below the single post content. If enabled you must fill in the banner image and destination url below.",),

			array( "type" => "clearfix",),

			array( "name" => "Input 468x60 advertisement banner image",
				   "id" => $shortname."_468_image",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -",),

			array( "name" => "Input 468x60 advertisement destination url",
				   "id" => $shortname."_468_url",
				   "type" => "text",
				   "std" => "",
				   "desc" => "Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -",),
				   
			array( "name" => "Input 468x60 adsense code",
				   "id" => $shortname."_468_adsense",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "desc",),

		array( "name" => "advertisements-1",
			   "type" => "subcontent-end",),

	array( "name" => "wrap-support",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

); 


function custom_colors_css(){
	global $shortname; ?>
	
	<style type="text/css">
		body { color: #<?php echo(get_option($shortname.'_color_mainfont')); ?>; }
		#content-area a { color: #<?php echo(get_option($shortname.'_color_mainlink')); ?>; }
		ul.nav li a { color: #<?php echo(get_option($shortname.'_color_pagelink')); ?> !important; }
		ul.nav > li.current_page_item > a, ul#top-menu > li:hover > a, ul.nav > li.current-cat > a { color: #<?php echo(get_option($shortname.'_color_pagelink_active')); ?>; }
		h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: #<?php echo(get_option($shortname.'_color_headings')); ?>; }
		
		#sidebar a { color:#<?php echo(get_option($shortname.'_color_sidebar_links')); ?>; }		
		.footer-widget { color:#<?php echo(get_option($shortname.'_footer_text')); ?> }
		#footer a, ul#bottom-menu li a { color:#<?php echo(get_option($shortname.'_color_footerlinks')); ?> }
	</style>

<?php };

?>