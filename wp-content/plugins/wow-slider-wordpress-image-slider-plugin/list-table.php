<?php
/**
 * WOW Slider List Table class.
 *
 * @package WordPress
 * @subpackage List_Table
 */
class WOWSlider_List_Table extends WP_List_Table {

	function __construct(){
		global $status, $page, $s;
		$default_status = get_user_option('wowslider_last_view');
		if (empty($default_status)) $default_status = 'published';
		$status = isset($_REQUEST['slider_status']) ? $_REQUEST['slider_status'] : $default_status;
        if (!in_array($status, array('published', 'trash'))) $status = 'published';
        if ($status != $default_status) update_user_meta(get_current_user_id(), 'wowslider_last_view', $status);
        if (isset($_REQUEST['s'])) $_SERVER['REQUEST_URI'] = add_query_arg('s', stripslashes($_REQUEST['s']));
        $page = $this -> get_pagenum();
		parent::__construct(array('plural' => 'wowslider'));
	}

    function get_table_classes(){
		return array('widefat', 'fixed', 'wowslider-list-table'); 
	}

	function prepare_items(){
		global $status, $totals, $page, $orderby, $order, $s, $m, $mode;
        wp_reset_vars(array('orderby', 'order', 's', 'm'));
        $q = $where = array();
        $mode   = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : 'list';
        $order  = $order == 'asc' ? 'ASC' : 'DESC';
        $screen = get_current_screen();
        $totals = wowslider_get('totals');
        $this -> items = array();
        $sliders_per_page = $this -> get_items_per_page(str_replace('-', '_', $screen -> id . '_per_page'), 10);
        if ($orderby && !in_array($orderby, array('name', 'code', 'author', 'date'))) $orderby = '';
        $q['sort']  = $orderby ? ($orderby == 'code' ? 'ID' : 'slider_' . $orderby) . ' ' . $order : 'ID DESC';
		$q['page']  = (int)$page;
        $q['count'] = $sliders_per_page;
        if (isset($_GET['author'])) $where[] = 'slider_author = ' . (int)$_GET['author'];
        if (trim($s)) $q['search'] = trim($s);
        if (strlen($m) == 6){
            $q['year'] = (int)substr($m, 0, 4);
            $q['month'] = (int)substr($m, 4, 2);
        }
        $where[] = 'slider_public = ' . ($status == 'published' ? 1 : 0);
        if ($where) $q['where'] = implode(' AND ', $where);
        $this -> items = wowslider_get($q);
        $this -> set_pagination_args(array(
			'total_items' => wowslider_get('count'),
			'per_page' => $sliders_per_page,
		));
	}

    function pagination($which){
		global $mode;
		parent::pagination($which);
		if ('top' == $which) $this -> view_switcher($mode);
	} 

	function no_items(){
		_e('No sliders found.', 'wowslider');
	}

	function get_columns(){
		return array(
			'cb'     => '<input type="checkbox" />',
			'name'   => __('Title'),
			'code'   => __('Shortcode', 'wowslider'),
            'author' => __('Author'),
            'images' => __('Images', 'wowslider'),
            'date'   => __('Date')
		);
	}

	function get_sortable_columns() {
		return array(
			'name'   => 'name',
            'code'   => 'code',
			'author' => 'author',
			'date'   => array('date', true)
		);
	} 

	function get_views(){
		global $totals, $status;
		$status_links = array();
        foreach ($totals as $type=>$count){
			if (!$count) continue;
			switch ($type){
                case 'published':
					$text = __('Published');
					break;
				case 'trash':
					$text = __('Trash');
					break;
			}
            $text .= ' <span class="count">(' . $count . ')</span>';
			$status_links[$type] = sprintf('<a href="%s" %s>%s</a>',
                add_query_arg('slider_status', $type, 'admin.php?page=wow-slider-wordpress-image-slider-plugin/admin.php'),
                ($type == $status) ? ' class="current"' : '',
                sprintf($text, number_format_i18n($count))
            );
		}
		return $status_links;
	}

	function get_bulk_actions(){
		global $status;
		$actions = array();
		if ('published' == $status) $actions['trash'] = __('Move to Trash');
		if ('trash' == $status){
			$actions['untrash'] = __('Restore'); 
            $actions['delete'] = __('Delete Permanently');
        }
        return $actions;
	}

	function bulk_actions($which){
		global $status;
		parent::bulk_actions($which);
	}

	function extra_tablenav($which){
		global $status;
?>
		<div class="alignleft actions">
<?php
		if ('top' == $which){
			$this -> months_dropdown($status);
            submit_button(__('Filter'), 'secondary', false, false);
		}
		if ('trash' == $status){
			submit_button(__('Empty Trash'), 'button-secondary apply', 'delete_all', false);
		}
?>
		</div>
<?php
	}

    function months_dropdown($status = 'all'){
		global $wp_locale;
		$months = wowslider_get('months ' . $status);
		$month_count = count($months);
		if (!$month_count) return;
		$m = isset($_GET['m']) ? (int)$_GET['m'] : 0;
?>
		<select name="m">
			<option<?php selected($m, 0); ?> value="0"><?php _e('Show all dates'); ?></option>
<?php
		foreach ($months as $v){
			$month = zeroise($v['month'], 2);
			$year = $v['year'];
			printf("<option %s value='%s'>%s</option>\n",
				selected($m, $year . $month, false),
				esc_attr($v['year'] . $month),
				$wp_locale -> get_month($month) . " $year"
			);
		}
?>
		</select>
<?php
	} 

	function display_rows(){
        $index = 1;
		foreach ($this -> items as $data){
			$this -> single_row($data['id'], $data, $index);
            $index++;
        }
	}

	function single_row($id, $data, $index){
		global $status, $page, $s, $mode;
        if ($data['trash'])
            $actions = array(
                'untrash' => '<a href="' . wp_nonce_url('admin.php?page=wow-slider-wordpress-image-slider-plugin/admin.php&amp;slider=' . $id .'&amp;action=untrash&amp;slider_status=' . $status . '&amp;paged=' . $page, 'untrash') . '" title="' . esc_attr__('Restore this item from the Trash') . '">' . __('Restore') . '</a>',
                'delete' => '<a href="' . wp_nonce_url('admin.php?page=wow-slider-wordpress-image-slider-plugin/admin.php&amp;slider=' . $id .'&amp;action=delete&amp;slider_status=' . $status . '&amp;paged=' . $page, 'delete') . '" title="' . esc_attr__('Delete this item permanently') . '" class="submitdelete">' . __('Delete Permanently') . '</a>'
            );
        else {
            $actions = array(
                'trash' => '<a href="' . wp_nonce_url('admin.php?page=wow-slider-wordpress-image-slider-plugin/admin.php&amp;slider=' . $id .'&amp;action=trash&amp;slider_status=' . $status . '&amp;paged=' . $page, 'trash') . '" title="' . esc_attr__('Move this item to the Trash') . '" class="submitdelete">' . __('Trash') . '</a>',
                'view' => '<a href="' . admin_url('admin.php?page=wow-slider-wordpress-image-slider-plugin/admin.php&amp;slider=' . $id .'&amp;action=view') . '" title="' . esc_attr__('View this item', 'wowslider') . '" class="view">' . __('View') . '</a>'
            );
        }
        echo "<tr id=\"slider-$id\" class=\"" . ($index % 2 ? 'alternate' : '') . "\" valign=\"top\">";
		list($columns, $hidden) = $this -> get_column_info();
        foreach ($columns as $column_name=>$column_display_name){
			$style = '';
			if (in_array($column_name, $hidden)) $style = ' style="display:none;"';
			switch ($column_name){
				case 'cb':
					echo '<th scope="row" class="check-column"><input type="checkbox" name="checked[]" value="' . esc_attr($id) . '" id="checkbox_' . $id . '" /><label class="screen-reader-text" for="checkbox_' . $id . '" >' . __('Select') . ' ' . htmlspecialchars($data['Name']) . '</label></th>';
					break;
				case 'name':
					echo '<td class="column-title"' . $style . '><strong>';
                    if ($status == 'trash') echo htmlspecialchars($data['name']);
                    else echo '<a href="' . admin_url('admin.php?page=wow-slider-wordpress-image-slider-plugin/admin.php&amp;slider=' . $id .'&amp;action=view') . '" title="' . __('View') . ' ' . esc_attr('"' . $data['name'] . '"') . '">' . htmlspecialchars($data['name']) . '</a>';
					echo '</strong>' . $this -> row_actions($actions);
					echo '</td>';
					break;
                case 'code':
					echo '<td class="column-code"' . $style . '><code>[wowslider id="' . $id . '"]</code>' . ('list' == $mode ? '' : '<br/><small>( ' . __('for templates', 'wowslider') . ': <code>&lt;?php wowslider(' . $id . '); ?&gt;</code>)</small>') . '</td>';
					break;
                case 'author':
					echo '<td class="column-author"' . $style . '>';
                    if ($data['author']) echo '<a href="' . admin_url('admin.php?page=wow-slider-wordpress-image-slider-plugin/admin.php&author=' . $data['author']['id']) . '">' . htmlspecialchars($data['author']['name']) . '</a>';
                    else echo '&nbsp;';
                    echo '</td>';
					break;
				case 'images':
					echo '<td class="column-images"' . $style . ' ' . ('list' == $mode ? '' : 'style="padding-bottom:7px;"') . '>';
                    $data['images'] = array_slice($data['images'], 0, ('list' == $mode ? 3 : 6));
                    $thumb_dir = is_dir(WOWSLIDER_PLUGIN_PATH . 'sliders/' . $id . '/tooltips/') ? '/tooltips/' : '/images/';
                    foreach ($data['images'] as $image)
                        echo '<a href="' . WOWSLIDER_PLUGIN_URL . 'sliders/' . $id . '/images/' . $image . '"><img src="' . WOWSLIDER_PLUGIN_URL . 'sliders/' . $id . $thumb_dir . $image . '" /></a> ';
					echo '</td>';
					break;
                case 'date':
                    $t_time = mysql2date(__('Y/m/d g:i:s A'), $data['date'], true);
                    $m_time = $data['date'];
                    $time   = mysql2date('G', $data['date_gmt'], false);
                    $time_diff = time() - $time;
                    if ($time_diff > 0 && $time_diff < 24*60*60) $h_time = sprintf(__('%s ago'), human_time_diff($time));
                    else $h_time = mysql2date(__( 'Y/m/d'), $m_time);
                    echo '<td class="column-date"' . $style . '>';
                    if ('excerpt' == $mode) echo apply_filters('post_date_column_time', $t_time, $post, $column_name, $mode);
                    else echo '<abbr title="' . $t_time . '">' . apply_filters('post_date_column_time', $h_time, $post, $column_name, $mode) . '</abbr>';
                    echo '</td>';
                break; 
				default:
					echo "<td class=\"$column_name column-$column_name\"$style>";
					echo '</td>';
			}
		}
		echo '</tr>';
	}
}

?>
