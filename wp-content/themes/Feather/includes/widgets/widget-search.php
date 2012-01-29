<?php class ETSearchWidget extends WP_Widget
{
    function ETSearchWidget(){
		$widget_ops = array('description' => 'Display custom search field.');
		parent::WP_Widget(false,$name='ET Search',$widget_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		echo $before_widget;
?>
			<div id="search-form">
				<form method="get" id="searchform1" action="<?php bloginfo('url'); ?>"> 
					<input type="text" value="<?php esc_attr_e('Search this site...', 'Feather'); ?>" name="s" id="searchinput" /> 
					<input type="image" src="<?php bloginfo('template_directory'); ?>/images/search_btn.png" id="searchsubmit" />
				</form>
			</div> <!-- end #search-form -->
<?php
		echo $after_widget;
	}

}// end ETSearchWidget class

function ETSearchWidgetInit() {
  register_widget('ETSearchWidget');
}

add_action('widgets_init', 'ETSearchWidgetInit');

?>