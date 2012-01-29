<!-- Start Featured -->	
	<div id="featured">
		<div id="slides">
		<?php
			global $wp_embed, $ids;
			
			$ids = array();
			$arr = array();
			$i=1;
						
			$featured_cat = get_option('feather_feat_cat');
			$featured_num = get_option('feather_featured_num');
			
			if (get_option('feather_use_pages') == 'false') query_posts("showposts=$featured_num&cat=".get_catId($featured_cat));
			else { 
				global $pages_number;
				
				if (get_option('feather_feat_pages') <> '') $featured_num = count(get_option('feather_feat_pages'));
				else $featured_num = $pages_number;
				
				query_posts(array
								('post_type' => 'page',
								'orderby' => 'menu_order',
								'order' => 'ASC',
								'post__in' => (array) get_option('feather_feat_pages'),
								'showposts' => (int) $featured_num)
							);
			}
			
			while (have_posts()) : the_post();
				$et_feather_settings = maybe_unserialize( get_post_meta($post->ID,'et_feather_settings',true) );
				
				$variation = isset( $et_feather_settings['et_fs_variation'] ) ? (int) $et_feather_settings['et_fs_variation'] : 1;
				$link = isset( $et_feather_settings['et_fs_link'] ) && !empty($et_feather_settings['et_fs_link']) ? $et_feather_settings['et_fs_link'] : get_permalink();
				$title = isset( $et_feather_settings['et_fs_title'] ) && !empty($et_feather_settings['et_fs_title']) ? $et_feather_settings['et_fs_title'] : get_the_title();
				$description = isset( $et_feather_settings['et_fs_description'] ) && !empty($et_feather_settings['et_fs_description']) ? $et_feather_settings['et_fs_description'] : truncate_post(450,false);
				$video = isset( $et_feather_settings['et_fs_video'] ) && !empty($et_feather_settings['et_fs_video']) ? $et_feather_settings['et_fs_video'] : '';
				$video_manual_embed = isset( $et_feather_settings['et_fs_video_embed'] ) && !empty($et_feather_settings['et_fs_video_embed']) ? $et_feather_settings['et_fs_video_embed'] : '';
				
				$additional_class = ' ';
				$width = 396;
				$height = 233;
				
				switch ($variation) {
					case 2:
						$additional_class .= 'pngimage';
						$width = 396;
						$height = 233;
						break;
					case 3:
						$additional_class .= 'description-left';
						break;
					case 4:
						$additional_class .= 'description-center';
						break;
					case 5:
						$additional_class .= 'full-image';
						$width = 812;
						break;
				}
		?>
				<div class="slide clearfix<?php echo esc_attr($additional_class); ?>">
					
					<?php if ($variation != 4) { ?>
						<div class="featured-img">
							<?php if ( $video == '' && $video_manual_embed == '' ) { ?>
								<a href="<?php echo esc_url($link); ?>">							
									<?php $thumbnail = get_thumbnail($width,$height,'',$title,$title,false,'Featured');
									$thumb = $thumbnail["thumb"];
									print_thumbnail($thumb, $thumbnail["use_timthumb"], $title, $width, $height, ''); ?>
				
									<?php if ( in_array($variation, array(1,3,5)) ) { ?>
										<span class="overlay"></span>
									<?php } ?>
								</a>
							<?php } else { ?>
								<?php if ( $variation != 2 ) { ?>
									<div class="video-slide">
								<?php } ?>
								<?php
									if ( $video <> '' ) { 
										$video_embed = $wp_embed->shortcode( '', $video );
										if ( $video_embed == '<a href="'.esc_url($video).'">'.esc_html($video).'</a>' ) $video_embed = $video_manual_embed;
									} else {
										$video_embed = $video_manual_embed;
									}
																		
									$video_embed = preg_replace('/<embed /','<embed wmode="transparent" ',$video_embed);
									$video_embed = preg_replace('/<\/object>/','<param name="wmode" value="transparent" /></object>',$video_embed); 
									$video_embed = preg_replace("/height=\"[0-9]*\"/", "height={$height}", $video_embed);
									$video_embed = preg_replace("/width=\"[0-9]*\"/", "width={$width}", $video_embed);
									
									echo $video_embed;
								?>
								<?php if ( $variation != 2 ) { ?>
									</div> <!-- end .video-slide -->
								<?php } ?>
							<?php } ?>
						</div> 	<!-- end .featured-img -->
					<?php } ?>
					
					<?php if ($variation != 5) { ?>
						<div class="description">
							<h2 class="title"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a></h2>
							
							<p><?php if ( $variation == 4 ) echo '"'; ?><?php echo $description; ?><?php if ( $variation == 4 ) echo '"'; ?></p>
						</div> <!-- end .description -->
					<?php } ?>
				</div> <!-- end .slide -->
		<?php
				$ids[]= $post->ID;
			endwhile; wp_reset_query();	
		?>
		</div> <!-- end #featured_content -->
		
		<div id="controllers" class="clearfix"></div>
		
		<a id="featured-left" href="#"><?php esc_html_e('Previous','Feather'); ?></a>
		<a id="featured-right" href="#"><?php esc_html_e('Next','Feather'); ?></a>
	</div>	<!-- end #featured -->