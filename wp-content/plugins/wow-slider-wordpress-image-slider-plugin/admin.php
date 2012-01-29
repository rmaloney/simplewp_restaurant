<?php

function wowslider_admin_menu(){
    global $submenu;
    $file = __FILE__;
    $path = plugin_basename($file);
    add_menu_page('WOW Slider', 'WOW Slider', 7, $file, 'wowslider_sliders', WOWSLIDER_PLUGIN_URL . 'data/icon0.gif');
    add_submenu_page($file, __('Add New Slider', 'wowslider'), __('Add New', 'wowslider'), 7, 'wowslider-add-new', 'wowslider_add_new');
    if (isset($submenu[$path][0][0])) $submenu[$path][0][0] = $submenu[$path][0][3] = __('All Sliders', 'wowslider');
}

function wowslider_help($contextual_help, $screen_id, $screen){
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    if ($screen -> parent_file == 'wow-slider-wordpress-image-slider-plugin/admin.php'){
        return sprintf(__('For more information, read help on %s', 'wowslider'), '<a href="http://wowslider.com/wordpress-jquery-slider.html" target="_blank">wowslider.com</a>');
    }
    return $contextual_help;
}

function wowslider_tinymce_button($q = false){
    static $sliders = null;
    if ($sliders === null) $sliders = wowslider_get(array('last' => 30));
    if ($sliders){
        if (is_array($q) && isset($q[0])){
            array_push($q, '|', 'wowslider');
            return $q;
        } else if (is_array($q)){
            $q['wowslider'] = WOWSLIDER_PLUGIN_URL . 'data/tinymce_plugin.js';
            return $q;
        } else if ($q === 'admin_head'){
            $wowslider = array(
                'title'   => __('Insert Slider', 'wowslider'),
                'sliders' => $sliders
            );
            echo '<script type="text/javascript">
//<![CDATA[
var tinymce_wowslider = ' . json_encode($wowslider) . ';
//]]>
</script>
';
        } else {
            if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) return;
            if (get_user_option('rich_editing') == 'true'){
                add_filter('mce_external_plugins', 'wowslider_tinymce_button');
                add_filter('mce_buttons', 'wowslider_tinymce_button');
                add_filter('admin_head', create_function('', 'wowslider_tinymce_button("admin_head");'));
            }
        }
    }
}

function wowslider_set_screen_id(){
    $screen = get_current_screen();
    if ('toplevel_page_wow-slider-wordpress-image-slider-plugin/admin' == $screen -> id)
        set_current_screen('wowslider_sliders');
}

function wowslider_table_include(){
    global $_wp_column_headers;
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'view') return false;
    require_once WOWSLIDER_PLUGIN_PATH . 'list-table.php';
    $screen = get_current_screen();
    if ('wowslider_sliders' == $screen -> id){
        if (isset($_POST['wp_screen_options']['value'], $_POST['screenoptionnonce']) &&
            wp_verify_nonce($_REQUEST['screenoptionnonce'], 'screen-options-nonce')){
            update_user_option(get_current_user_id(), 'wowslider_sliders_per_page', max(1, min(100, (int)$_POST['wp_screen_options']['value'])));
        }
        $sliders_per_page = (int)get_user_option('wowslider_sliders_per_page');
        $_wp_column_headers['wowslider_sliders'] = WOWSlider_List_Table::get_columns();
        add_screen_option('per_page', array('label' => _x('Sliders', 'sliders per page (screen options)'), 'default' => ($sliders_per_page ? $sliders_per_page : 10), 'option' => 'edit_sliders_per_page'));
    }
}

function wowslider_sliders(){
    global $page, $status, $s;
    if (isset($_REQUEST['action'], $_REQUEST['slider']) && $_REQUEST['action'] == 'view') return wowslider_view();
    if (isset($_REQUEST['delete_all'], $_REQUEST['_wpnonce']) &&
        wp_verify_nonce($_REQUEST['_wpnonce'], 'bulk-wowslider') &&
        ($ids = wowslider_delete('*'))){
        echo '<div id="message" class="updated"><p>';
        $deleted = count($ids);
        printf(_n('Item permanently deleted.', '%s items permanently deleted.', $deleted), number_format_i18n($deleted));
        echo '</p></div>';
    } else if (isset($_REQUEST['action'], $_REQUEST['_wpnonce']) &&
        ((isset($_REQUEST['slider']) && wp_verify_nonce($_REQUEST['_wpnonce'], $_REQUEST['action'])) ||
            (isset($_REQUEST['checked']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'bulk-wowslider')))){
        $ids = isset($_REQUEST['checked']) ? $_REQUEST['checked'] : $_REQUEST['slider'];
        if ($_REQUEST['action'] == 'trash' && ($ids = wowslider_delete($ids, 'trash'))){
            echo '<div id="message" class="updated"><p>';
            $trashed = count($ids);
            printf(_n('Item moved to the Trash.', '%s items moved to the Trash.', $trashed), number_format_i18n($trashed));
            echo ' <a href="' . wp_nonce_url('admin.php?page=wow-slider-wordpress-image-slider-plugin/admin.php&amp;slider=' . implode(',', $ids) .'&amp;action=untrash&amp;slider_status=' . $status . '&amp;paged=' . $page, 'untrash') . '" title="' . esc_attr__('Restore this item from the Trash') . '">' . __('Undo') . '</a><br />';
            echo '</p></div>';
        } else if ($_REQUEST['action'] == 'untrash' && ($ids = wowslider_delete($ids, 'restore'))){
            echo '<div id="message" class="updated"><p>';
            $untrashed = count($ids);
            printf(_n('Item restored from the Trash.', '%s items restored from the Trash.', $untrashed), number_format_i18n($untrashed));
            echo '</p></div>';
        } else if ($_REQUEST['action'] == 'delete' && ($ids = wowslider_delete($ids))){
            echo '<div id="message" class="updated"><p>';
            $deleted = count($ids);
            printf(_n('Item permanently deleted.', '%s items permanently deleted.', $deleted), number_format_i18n($deleted));
            echo '</p></div>';
        }
    }
    $wp_list_table =  new WOWSlider_List_Table;
    $wp_list_table -> prepare_items();
    ?><div class="wrap">
<div id="icon-wowslider" class="icon32"><br /></div><h2><?php _e('All Sliders', 'wowslider'); ?><a href="<?php echo admin_url('admin.php?page=wowslider-add-new'); ?>" class="add-new-h2">Add New</a> <?php
    if ($s) printf('<span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>', htmlspecialchars($s)); ?></h2>
    <?php $wp_list_table -> views(); ?>
    <form method="get" action="">
    <?php $wp_list_table -> search_box(__('Search Sliders', 'wowslider'), 'slider'); ?>
    <input type="hidden" name="page" value="wow-slider-wordpress-image-slider-plugin/admin.php" />
    <input type="hidden" name="paged" value="<?php echo esc_attr($page) ?>" />
    <input type="hidden" name="slider_status" value="<?php echo esc_attr($status) ?>" />
    <?php $wp_list_table -> display(); ?>
    </form>
    </div><?php
}

function wowslider_view(){
    $id = (int)$_REQUEST['slider'];
    if ($html = wowslider_get($id, false)){
        $slider = wowslider_get(array('where' => 'ID = ' . $id, 'limit' => 1));
        ?><div class="wrap">
    <div id="icon-wowslider" class="icon32"><br /></div><h2><?php echo htmlspecialchars($slider[0]['name']); ?><a href="javascript://" onclick="history.back();" class="add-new-h2">&larr; back</a></h2>
        </div>
        <div id="wowslider-view"><?php echo $html; ?></div>
        <strong class="shortcode"><?php _e('shortcode:', 'wowslider'); ?><br/><code>[wowslider id="<?php echo $id; ?>"]</code></strong>
        <strong class="shortcode"><?php _e('php code:', 'wowslider'); ?><br/><code>&lt;?php wowslider(<?php echo $id; ?>); ?&gt;</code></strong>
        <?php
    } else echo '<div id="message" class="error"><p>' . __('Slider not found!', 'wowslider') . '</p></div>';
}

function wowslider_add_new(){
    $tab = (isset($_GET['tab']) && $_GET['tab'] == 'import') ? 'import' : 'upload';
    $verif = (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'wowslider-add-new'));
    if (isset($_GET['message'])){
        if (isset($_GET['error'])) echo '<div id="message" class="error"><p>' . htmlspecialchars(urldecode($_GET['message'])) . '</p></div>';
        else if (isset($_GET['slider'])){
            if ($_GET['message']) echo '<div id="message" class="updated"><p>' . str_replace('%s', '<strong>./import/' . htmlspecialchars(urldecode($_GET['message'])) . '</strong>', __('Slider imported from file %s! To add it on the page use the shortcode:', 'wowslider')) . ' <strong><code>[wowslider id="' . (int)$_GET['slider'] . '"]</code></strong></p></div>';
            else echo '<div id="message" class="updated"><p>' . __('Slider added! To add it on the page use the shortcode:', 'wowslider') . ' <strong><code>[wowslider id="' . (int)$_GET['slider'] . '"]</code></strong></p></div>';
        }
    }
    if ($tab == 'upload' && isset($_FILES['sliderzip']) && $verif){
        $file = wp_handle_upload($_FILES['sliderzip'], array(
            'test_form' => false,
            'mimes' => array('zip' => 'application/zip')
        ));
        if (isset($file['error'])) exit(wp_redirect(admin_url('admin.php?page=wowslider-add-new&error=1&message=' . urlencode($file['error']))));
        else if (($status = wowslider_add($file['file'])) !== true) exit(wp_redirect(admin_url('admin.php?page=wowslider-add-new&error=1&message=' . urlencode($status))));
        else exit(wp_redirect(admin_url('admin.php?page=wowslider-add-new&message=&slider=' . wowslider_add())));
    } else if ($tab == 'import' && $verif){
        if (($status = wowslider_import()) !== true) exit(wp_redirect(admin_url('admin.php?page=wowslider-add-new&tab=import&error=1&message=' . urlencode($status))));
        else exit(wp_redirect(admin_url('admin.php?page=wowslider-add-new&tab=import&message=' . urlencode(wowslider_import('file')) . '&slider=' . wowslider_add())));
    }
    ?>
    <div class="wrap">
    <div id="icon-wowslider" class="icon32"><br /></div>
    <h2><?php _e('Add New Slider', 'wowslider'); ?></h2>
    <ul class="subsubsub">
        <li><a href="<?php echo admin_url('admin.php?page=wowslider-add-new'); ?>"<?php if ($tab == 'upload') echo ' class="current"'; ?>><?php _e('Upload', 'wowslider'); ?></a> |</li>
        <li><a href="<?php echo admin_url('admin.php?page=wowslider-add-new&tab=import'); ?>"<?php if ($tab == 'import') echo ' class="current"'; ?>><?php _e('Import from Folder', 'wowslider'); ?></a></li>
    </ul><br class="clear" />
    <? if ($tab == 'upload'): ?>
    <h4><?php _e('Add a slider in .zip format', 'wowslider') ?></h4>
	<p class="install-help"><?php echo str_replace('WOW Slider', '<a href="http://wowslider.com/" target="_blank">WOW Slider</a>', __('Create a slider with WOW Slider and upload it here.', 'wowslider')) ?></p>
	<form method="post" enctype="multipart/form-data" action="<?php echo self_admin_url('admin.php?page=wowslider-add-new&noheader=1') ?>">
		<?php wp_nonce_field('wowslider-add-new') ?>
		<label class="screen-reader-text" for="sliderzip"><?php _e('Slider zip file', 'wowslider'); ?></label>
		<input type="file" id="sliderzip" name="sliderzip" />
		<input type="submit" class="button" value="<?php esc_attr_e('Add Now', 'wowslider') ?>" />
	</form>
    <? else: ?>
    <h4><?php _e('Add a slider in .zip format from folder', 'wowslider') ?></h4>
    <p class="install-help"><?php echo str_replace('WOW Slider', '<a href="http://wowslider.com/" target="_blank">WOW Slider</a>', __('Create a slider with WOW Slider and copy to folder:', 'wowslider')) ?> "./wp-content/plugins/wow-slider-wordpress-image-slider-plugin/import/".</p>
    <br />
    <form method="post" action="<?php echo self_admin_url('admin.php?page=wowslider-add-new&tab=import&noheader=1') ?>">
		<?php wp_nonce_field('wowslider-add-new') ?>
		<input type="submit" class="button" value="<?php esc_attr_e('Import from Folder', 'wowslider') ?>" />
	</form>
    <? endif; ?>
    </div>
<?php
}

register_activation_hook(WOWSLIDER_PLUGIN_PATH . 'wowslider.php', 'wowslider_install');
add_action('init', 'wowslider_tinymce_button');
add_action('admin_menu', 'wowslider_admin_menu');
add_filter('contextual_help', 'wowslider_help', 10, 3);
add_filter('in_admin_header', 'wowslider_table_include');
add_filter('load-toplevel_page_wow-slider-wordpress-image-slider-plugin/admin', 'wowslider_set_screen_id');
wp_register_style('wowslider-admin', WOWSLIDER_PLUGIN_URL . 'data/admin.css');
wp_enqueue_style('wowslider-admin');

?>
