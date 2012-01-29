<div id="featured">
<?php global $ids, $featured_num;;
	$ids = array();
	$arr = array();
	$i=1;
	
	$width = 1400;
	$height = 465;
					
	$featured_cat = get_option('mycuisine_feat_cat'); 
	$featured_num = get_option('mycuisine_featured_num'); 
		
	if (get_option('mycuisine_use_pages') == 'false') query_posts("showposts=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;
		
		if (get_option('mycuisine_feat_pages') <> '') $featured_num = count(get_option('mycuisine_feat_pages'));
		else $featured_num = $pages_number;
				
		query_posts(array('post_type' => 'page',
						'orderby' => 'menu_order',
						'order' => 'DESC',
						'post__in' => (array) get_option('mycuisine_feat_pages'),
						'showposts' => (int) $featured_num));
	};
			
	while (have_posts()) : the_post();
		global $post;
		
		$et_mycuisine_settings = maybe_unserialize( get_post_meta($post->ID,'_et_mycuisine_settings',true) );
					
		$arr[$i]['variation'] = isset( $et_mycuisine_settings['et_fs_variation'] ) ? (int) $et_mycuisine_settings['et_fs_variation'] : 1;		
		$arr[$i]["title"] = truncate_title(25,false);
		$arr[$i]["fulltitle"] = truncate_title(250,false);
		
		$arr[$i]["excerpt"] = isset( $et_mycuisine_settings['et_fs_custom_excerpt'] ) ? $et_mycuisine_settings['et_fs_custom_excerpt'] : truncate_post(180,false);
				
		$arr[$i]["permalink"] = isset( $et_mycuisine_settings['et_fs_link'] ) && !empty($et_mycuisine_settings['et_fs_link']) ? $et_mycuisine_settings['et_fs_link'] : get_permalink();
				
		$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'',$arr[$i]["fulltitle"],$arr[$i]["fulltitle"],true,'Featured');
		$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];		
		$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];
		
		$arr[$i]["color"] = isset( $et_mycuisine_settings['et_fs_bgcolor'] ) ? $et_mycuisine_settings['et_fs_bgcolor'] : '452917';
		$arr[$i]["color"] = str_replace('#','',$arr[$i]["color"]);
		
		$arr[$i]["moretext"] = isset( $et_mycuisine_settings['et_fs_button'] ) && !empty($et_mycuisine_settings['et_fs_button']) ? $et_mycuisine_settings['et_fs_button'] : 'Read More';

		$i++;
		$ids[] = $post->ID;
	endwhile; wp_reset_query();	?>
	
	<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
		<div class="slide<?php if ($i==1) echo(' active'); ?>" style="background: <?php if($arr[$i]["color"] != '') echo '#' . esc_attr($arr[$i]["color"]); ?> url('<?php print_thumbnail($arr[$i]["thumb"], $arr[$i]["use_timthumb"], $arr[$i]["fulltitle"], $width, $height, '', true, true); ?>') no-repeat top center;">
			<div class="container<?php if ( $arr[$i]['variation'] == 2 ) echo ' descright'; ?>">
				<div class="description">
					<h2 class="title"><a href="<?php echo esc_url($arr[$i]["permalink"]); ?>"><?php echo esc_html($arr[$i]["fulltitle"]); ?></a></h2>
					<p><?php echo($arr[$i]["excerpt"]); ?></p>
					<a class="readmore" href="<?php echo esc_url($arr[$i]["permalink"]); ?>"><span><?php echo esc_html($arr[$i]["moretext"]); ?></span></a>
				</div> <!-- .description -->
			</div> <!-- .container -->
			<div class="slide-top-shadow"></div>
			<div class="slide-bottom-shadow"></div>
		</div> <!-- .slide -->
	<?php } ?>
</div> <!-- #featured -->