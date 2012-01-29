<?php 

class dc_jqmegamenu_widget extends WP_Widget {
    /** constructor */
    function dc_jqmegamenu_widget() {
	
		$name =			'jQuery Mega Menu';
		$desc = 		'Create Mega Menus From Any Wordpress Custom Menu';
		$id_base = 		'dc_jqmegamenu_widget';
		$css_class = 	'';
		$alt_option = 	'widget_dcjq_mega_menu_navigation'; 

		$widget_ops = array(
			'classname' => $css_class,
			'description' => __( $desc, 'dcjq-mega-menu' ),
		);
		parent::WP_Widget( 'nav_menu', __('Custom Menu'), $widget_ops );
		
		$this->WP_Widget($id_base, __($name, 'dcjqmegamenu'), $widget_ops);
		$this->alt_option_name = $alt_option;
		
		add_action( 'wp_head', array(&$this, 'styles'), 10, 1 );	
		add_action( 'wp_footer', array(&$this, 'footer'), 10, 1 );	

		$this->defaults = array(
			'title' => '',
			'rowItems' => 3,
			'subMenuWidth' => '150px',
			'speed' => 'slow',
			'effect' => 'fade',
			'event' => 'hover',
			'skin' => 'white.css'
		);
    }
	
	function widget($args, $instance) {
		extract( $args );
		// Get menu
		
		$widget_options = wp_parse_args( $instance, $this->defaults );
		extract( $widget_options, EXTR_SKIP );
		
		$nav_menu = wp_get_nav_menu_object( $instance['nav_menu'] );

		if ( !$nav_menu )
			return;

		$instance['title'] = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		
		echo $args['before_widget'];

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
			
		?>
		<div class="dcjq-mega-menu" id="<?php echo $this->id.'-item'; ?>">
		
		<?php

			wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false ) );
		
		?>
		
		</div>
		<?php
		
		echo $args['after_widget'];
	}

    /** @see WP_Widget::update */
    function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		$instance['rowItems'] = $new_instance['rowItems'];
		$instance['subMenuWidth'] = $new_instance['subMenuWidth'];
		$instance['skin'] = $new_instance['skin'];
		$instance['speed'] = $new_instance['speed'];
		$instance['effect'] = $new_instance['effect'];
		$instance['event'] = $new_instance['event'];
		$instance['fullWidth'] = $new_instance['fullWidth'];
		
		return $instance;
	}

    /** @see WP_Widget::form */
    function form($instance) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		$rowItems = isset( $instance['rowItems'] ) ? $instance['rowItems'] : '';
		$subMenuWidth = isset( $instance['subMenuWidth'] ) ? $instance['subMenuWidth'] : '';
		$skin = isset( $instance['skin'] ) ? $instance['skin'] : '';
		$speed = isset( $instance['speed'] ) ? $instance['speed'] : '';
		$effect = isset( $instance['effect'] ) ? $instance['effect'] : '';
		$event = isset( $instance['event'] ) ? $instance['event'] : '';
		$fullWidth = isset( $instance['fullWidth'] ) ? $instance['fullWidth'] : '';
		
		$widget_options = wp_parse_args( $instance, $this->defaults );
		extract( $widget_options, EXTR_SKIP );

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
		<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
		</select>
	</p>
	<p>
		<input type="radio" id="<?php echo $this->get_field_id('event1'); ?>" name="<?php echo $this->get_field_name('event'); ?>" value="click"<?php checked( $event, 'click' ); ?> /> 
		<label for="<?php echo $this->get_field_id('event1'); ?>"><?php _e( 'Click' , 'dcjq-mega-menu' ); ?></label>
		<input type="radio" id="<?php echo $this->get_field_id('event2'); ?>" name="<?php echo $this->get_field_name('event'); ?>" value="hover"<?php checked( $event, 'hover' ); ?> /> 
		<label for="<?php echo $this->get_field_id('event2'); ?>"><?php _e( 'Hover' , 'dcjq-mega-menu' ); ?></label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('rowItems'); ?>"><?php _e( 'Number Items Per Row' , 'dcjq-mega-menu' ); ?></label>
		<select name="<?php echo $this->get_field_name('rowItems'); ?>" id="<?php echo $this->get_field_id('rowItems'); ?>" >
			<option value='1' <?php selected( $rowItems, '1'); ?> >1</option>
			<option value='2' <?php selected( $rowItems, '2'); ?> >2</option>
			<option value='3' <?php selected( $rowItems, '3'); ?> >3</option>
			<option value='4' <?php selected( $rowItems, '4'); ?> >4</option>
			<option value='5' <?php selected( $rowItems, '5'); ?> >5</option>
			<option value='6' <?php selected( $rowItems, '6'); ?> >6</option>
			<option value='7' <?php selected( $rowItems, '7'); ?> >7</option>
			<option value='8' <?php selected( $rowItems, '8'); ?> >8</option>
			<option value='9' <?php selected( $rowItems, '9'); ?> >9</option>
			<option value='10' <?php selected( $rowItems, '10'); ?> >10</option>
		</select>
		</p>
		<p><label for="<?php echo $this->get_field_id('skin'); ?>"><?php _e('Skin:', 'dcjq-mega-menu'); ?>  <?php 
		
		// http://www.codewalkers.com/c/a/File-Manipulation-Code/List-files-in-a-directory-no-subdirectories/

		echo "<select name='".$this->get_field_name('skin')."' id='".$this->get_field_id('skin')."'>";
		echo "<option value='no-theme' ".selected( $skin, 'no-theme', false).">No theme</option>";
			
		//The path to the style directory
		$dirpath = plugin_dir_path(__FILE__) . 'skins/';	
			
		$dh = opendir($dirpath);
		while (false !== ($file = readdir($dh))) {
			//Don't list subdirectories
			if (!is_dir("$dirpath/$file") && pathinfo($file, PATHINFO_EXTENSION) == 'css') {
				//Remove file extension
				$newSkin = htmlspecialchars(ucfirst(preg_replace('/\..*$/', '', $file)));
				echo "<option value='$newSkin' ".selected($skin, $newSkin, false).">" . $newSkin . '</option>';
			}
		}
		closedir($dh); 
		echo "</select>"; ?> </label><br />
	</p>
	<input type="hidden" value="<?php echo $subMenuWidth; ?>" class="widefat" id="<?php echo $this->get_field_id('subMenuWidth'); ?>" name="<?php echo $this->get_field_name('subMenuWidth'); ?>" />
	<p><label for="<?php echo $this->get_field_id('effect'); ?>"><?php _e('Animation Effect:', 'dcjq-mega-menu'); ?>
		<select name="<?php echo $this->get_field_name('effect'); ?>" id="<?php echo $this->get_field_id('effect'); ?>" >
			<option value='fade' <?php selected( $effect, 'fade'); ?> >Fade In</option>
			<option value='slide' <?php selected( $effect, 'slide'); ?> >Slide Down</option>
		</select>
		</label>
	</p>
	<p><label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Animation Speed:', 'dcjq-mega-menu'); ?>
		<select name="<?php echo $this->get_field_name('speed'); ?>" id="<?php echo $this->get_field_id('speed'); ?>" >
		    <option value='0' <?php selected( $speed, '0'); ?> >No Animation</option>
			<option value='fast' <?php selected( $speed, 'fast'); ?> >Fast</option>
			<option value='normal' <?php selected( $speed, 'normal'); ?> >Normal</option>
			<option value='slow' <?php selected( $speed, 'slow'); ?> >Slow</option>
		</select>
		</label>
	</p>
	<p>
		<input type="checkbox" value="true" class="checkbox" id="<?php echo $this->get_field_id('fullWidth'); ?>" name="<?php echo $this->get_field_name('fullWidth'); ?>"<?php checked( $fullWidth, 'true' ); ?> />
		<label for="<?php echo $this->get_field_id('fullWidth'); ?>"><?php _e( 'Set Sub Menu To Full Width' , 'dcjq-accordion' ); ?></label>
	</p>
	<div class="widget-control-actions alignright">
		<p><small><a href="http://www.designchemical.com/blog/index.php/wordpress-plugins/wordpress-plugin-jquery-drop-down-mega-menu-widget/"><?php esc_attr_e('Visit plugin site', 'dcjq-mega-menu'); ?></a></small></p>
	</div>
	
	<?php 
	}
	
	/** Adds ID based dropdown menu skin to the header. */
	function styles(){
		
		if(!is_admin()){

			$all_widgets = $this->get_settings();
		
			foreach ($all_widgets as $key => $wpdcjqmegamenu){
				$widget_id = $this->id_base . '-' . $key;		
				if(is_active_widget(false, $widget_id, $this->id_base)){
					$skin = $wpdcjqmegamenu['skin'];
					$skin = htmlspecialchars(ucfirst(preg_replace('/\..*$/', '', $skin)));
					if($skin != 'No-theme'){
						echo "\n\t<link rel=\"stylesheet\" href=\"".dc_jqmegamenu::get_plugin_directory()."/skin.php?widget_id=".$key."&amp;skin=".strtolower($skin)."\" type=\"text/css\" media=\"screen\"  />";
					}
				}
			}
		}
	}

	/** Adds ID based activation script to the footer */
	function footer(){
		
		if(!is_admin()){
		
		$all_widgets = $this->get_settings();
		
		foreach ($all_widgets as $key => $wpdcjqmegamenu){
		
			$widget_id = $this->id_base . '-' . $key;

			if(is_active_widget(false, $widget_id, $this->id_base)){
				
				$effect = $wpdcjqmegamenu['effect'];
				if($effect == ''){$effect = 'fade';}
				
				$event = $wpdcjqmegamenu['event'];
				if($event == ''){$event = 'hover';}
				
				$fullWidth = $wpdcjqmegamenu['fullWidth'];
				if($fullWidth != ''){$fullWidth = ',fullWidth: true';}

			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					jQuery('#<?php echo $widget_id.'-item'; ?> .menu').dcMegaMenu({
						rowItems: <?php echo $wpdcjqmegamenu['rowItems']; ?>,
						subMenuWidth: '<?php echo $wpdcjqmegamenu['subMenuWidth']; ?>',
						speed: <?php echo $wpdcjqmegamenu['speed'] == '0' ? 0 : "'".$wpdcjqmegamenu['speed']."'"; ?>,
						effect: '<?php echo $effect; ?>',
						event: '<?php echo $event; ?>'
						<?php echo $fullWidth; ?>
					});
				});
			</script>
		
			<?php
			
			}		
		}
		}
	}
} // class dc_jqmegamenu_widget