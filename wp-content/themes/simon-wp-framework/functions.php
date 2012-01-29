<?php
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '',
		'after_title' => '',
	));
?>

<?php
function new_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'new_excerpt_more');
?>

<?php add_theme_support( 'post-thumbnails' ); 
	  set_post_thumbnail_size( 150, 120, true );
?>

<?php
	if ( function_exists('register_sidebar') ){
	    register_sidebar(array(
	        'name' => 'my_mega_menu',
	        'before_widget' => '<div id="my-mega-menu-widget">',
	        'after_widget' => '</div>',
	        'before_title' => '',
	        'after_title' => '',
	));
	}

?>