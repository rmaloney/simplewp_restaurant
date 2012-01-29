<?php

function wowslider_admin_bar_menu(){
    global $wp_admin_bar;
    if (is_super_admin() && is_admin_bar_showing()){
        $wp_admin_bar -> add_menu(array(
            'parent' => 'new-content',
            'title'  => __('Slider', 'wowslider'),
            'href'   => admin_url('admin.php?page=wowslider-add-new')
        ));
    }
}

add_action('wp_before_admin_bar_render', 'wowslider_admin_bar_menu');


?>
