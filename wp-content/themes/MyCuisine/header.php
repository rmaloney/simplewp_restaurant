<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php elegant_titles(); ?></title>
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911' rel='stylesheet' type='text/css' />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie6style.css" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, span.overlay, a.zoom-icon, a.more-icon, #menu, #menu-right, #menu-content, ul#top-menu ul, #menu-bar, .footer-widget ul li, span.post-overlay, #content-area, .avatar-overlay, .comment-arrow, .testimonials-item-bottom, #quote, #bottom-shadow, #quote .container');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie7style.css" />
<![endif]-->
<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie8style.css" />
<![endif]-->

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
	<div id="page-bg">
		<div id="page-bottom">
			<div id="page-top"<?php if ( is_home() && get_option('mycuisine_featured') == 'false' ) echo ' class="nofeatured"'; ?>>
				<?php if ( is_home() && get_option('mycuisine_featured') == 'on' ) get_template_part('includes/featured'); ?>
				<div id="main-area">
					<div class="container">
						<div id="menu-right"></div>
						<div id="menu-bar">
							<div id="menu-content" class="clearfix">
								<a href="<?php bloginfo('url'); ?>">
									<?php $logo = (get_option('mycuisine_logo') <> '') ? get_option('mycuisine_logo') : get_bloginfo('template_directory').'/images/logo.png'; ?>
									<img src="<?php echo esc_url($logo); ?>" alt="MyCuisine Logo" id="logo"/>
								</a>
								<?php do_action('et_header'); ?>
								<?php $menuClass = 'nav';
								$menuID = 'top-menu';
								$primaryNav = '';
								if (function_exists('wp_nav_menu')) {
									$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) ); 
								};
								if ($primaryNav == '') { ?>
									<ul id="<?php echo $menuID; ?>" class="<?php echo $menuClass; ?>">
										<?php if (get_option('mycuisine_home_link') == 'on') { ?>
											<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php bloginfo('url'); ?>"><?php esc_html_e('Home','MyCuisine') ?></a></li>
										<?php }; ?>
										
										<?php show_page_menu($menuClass,false,false); ?>
										<?php show_categories_menu($menuClass,false); ?>
									</ul> <!-- end ul#nav -->
								<?php }
								else echo($primaryNav); ?>
							</div> <!-- end #menu-content-->
						</div> <!-- end #menu-bar-->
											
						<?php if ( !is_home() ) get_template_part('includes/top_info'); ?>
					</div> 	<!-- end .container -->
				</div> <!-- end #main-area -->
			</div> <!-- end #page-top -->
			<?php if ( is_home() && get_option('mycuisine_featured') == 'on' ) { ?>
				<div id="controllers">
					<div class="container clearfix">
						<div id="switcher">
							<div id="switcher-right">
								<div id="switcher-content">
									<?php global $featured_num;
									for ($i = 1; $i <= $featured_num; $i++) { ?>
										<a href="#" class="item<?php if ( $i == 1 ) echo ' active'; ?>"><?php echo $i; ?></a>
									<?php } ?>
								</div> <!-- #switcher-content -->
							</div> <!-- #switcher-right -->
						</div> <!-- #switcher -->
					</div> <!-- .container -->
				</div> <!-- #controllers -->
			<?php } ?>
		</div> <!-- end #page-bottom -->
	</div> <!-- end #page-bg -->
	
	<div id="content-area">