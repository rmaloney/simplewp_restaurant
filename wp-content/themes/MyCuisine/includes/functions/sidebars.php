<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar',
		'before_widget' => '',
		'after_widget' => '</div> <!-- end .widget-content--></div> <!-- end .widget-bottom--></div> <!-- end .widget-->',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4><div class="widget"><div class="widget-bottom"><div class="widget-content">',
    ));
	
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Footer',
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget' => '</div> <!-- end .footer-widget -->',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
    ));
?>