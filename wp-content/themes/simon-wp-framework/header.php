<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<title>
<?php if (is_home()) { echo bloginfo('name');
			} elseif (is_404()) {
			echo '404 Not Found';
			} elseif (is_category()) {
			echo 'Category:'; wp_title('');
			} elseif (is_search()) {
			echo 'Search Results';
			} elseif ( is_day() || is_month() || is_year() ) {
			echo 'Archives:'; wp_title('');
			} else {
			echo wp_title('');
			}
			?>
</title>
<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
<meta name="description" content="<?php bloginfo('description') ?>" />
<?php if(is_search()) { ?>
<meta name="robots" content="noindex, nofollow" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<?php }?>


<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />

<link rel="stylesheet" type="text/css" href="css/gh-buttons.css">
<!-- font stack css. Thanks Google! -->

<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Tinos|PT+Serif|Open+Sans+Condensed:300|Vollkorn|Unna' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=News+Cycle' rel='stylesheet' type='text/css'>

<!-- mobile stylesheet -->
<link rel="stylesheet" media="only screen and (max-device-width: 480px)" href="css/mobile.css" />


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"/></script>
<script type="text/javascript" src="js/silverspoon.js"></script>


<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body>
<!-- header START -->
<div class="container_12" id="wrapper">
<div id="header-wrap">
  <div id="nav-bar">
    <div id="navbar-left">
      <p class="alignleft" style="font-family: 'PT Serif', serif;"></p>
     <ul id="nav">
       <?php wp_list_pages('include=137,4,6,8&title_li='); ?>
     </ul>
    </div>
    
  </div>
  <div class="header">
    <div id="search-bar">
      <!-- Search Bar Commented Out for Now -->
    </div>
    <h1><a href="<?php echo get_option('home'); ?>/">
     <img src="images/silverspoon_logo.png">
      </a></h1>
    <div class="description">
      
    </div>
    <div style="clear: both"></div>
  </div>
</div>
<!-- header END -->
<div style="clear: both"></div>