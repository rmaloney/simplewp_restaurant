<?php get_header(); ?>

<?php if ( get_option('feather_blog_style') == 'false' ) { ?>
	<?php if ( get_option('feather_display_blurbs') == 'on' ){ ?>
		<div id="blurbs" class="clearfix">
			<?php for ($i=1; $i <= 4; $i++) { ?>
				<?php query_posts('page_id=' . get_pageId(html_entity_decode(get_option('feather_home_page_'.$i)))); while (have_posts()) : the_post(); ?>
					<?php 
						global $more; $more = 0;
					?>
					<div class="blurb<?php if ( $i == 4 ) echo ' last'; ?>">
						<?php
							$thumb = '';
							$width = 178;
							$height = 108;
							$classtext = 'item-image';
							$titletext = get_the_title();
							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'etservice');
							$thumb = $thumbnail["thumb"];
							$et_service_link = get_post_meta($post->ID,'etlink',true) ? get_post_meta($post->ID,'etlink',true) : get_permalink();
						?>
						<?php if ( $thumb <> '' ) { ?>
							<div class="thumb">
								<a href="<?php echo esc_url($et_service_link); ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
									<span class="overlay"></span>
									<span class="et-plus"></span>
								</a>
							</div> <!-- end .thumb -->
						<?php } ?>
						<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<?php the_content(''); ?>
					</div> <!-- end .blurb -->
				<?php endwhile; wp_reset_query(); ?>
			<?php } ?>
		</div> <!-- end #blurbs -->
	<?php } ?>

	<?php if ( get_option('feather_quote') == 'on' ) { ?>
		<p id="tagline">"<?php echo get_option('feather_quote_one'); ?>"</p>
	<?php } ?>
	
	<?php if ( get_option('feather_display_recentblog_section') == 'on' ) { ?>
		<div class="home-recent">
			<div class="recent-inner clearfix">
				<div class="description">
					<h4 class="title"><?php esc_html_e('Recent Blog Posts','Feather'); ?></h4>
					<p><?php echo get_option('feather_homeblog_desc'); ?></p>
				</div> <!-- end .description -->
				<?php 
					$args=array(
						'showposts' => '3',
						'cat' => get_cat_ID(get_option('feather_home_recentblog_section'))
					);
					query_posts($args);
					$blog_current_post = 1;
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="blurb<?php if ( $blog_current_post == 3 ) echo ' last'; ?>">
						<p class="meta-info"><?php the_time(get_option('feather_date_format')) ?></p>
						<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php truncate_post(90); ?></p>
					</div> <!-- end .blurb -->
				<?php $blog_current_post++; endwhile; ?>
				<?php endif; wp_reset_query(); ?>
				
				<a href="<?php echo esc_url(get_category_link(get_cat_ID(get_option('feather_home_recentblog_section')))); ?>" class="blog-more"><?php esc_html_e('More','Feather'); ?></a>
			</div> <!-- end .recent-inner -->
		</div> <!-- end .home-recent -->
	<?php } ?>

	<?php if ( get_option('feather_display_recentwork_section') == 'on' ) { ?>
		<div class="home-recent">
			<div class="recent-inner clearfix">
				<div class="description">
					<h4 class="title"><?php esc_html_e('Recent Work','Feather'); ?></h4>
					<p><?php echo get_option('feather_homework_desc'); ?></p>
				</div> <!-- end .description -->
				<div id="media-slider">
					<?php 
						$args=array(
							'showposts' => (int) get_option('feather_posts_media'),
							'category__not_in' => (array) get_option('feather_exlcats_media')
						);
						query_posts($args);
						$blog_current_post = 1;
						$blog_current_post_open = false;
					?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php 
							if ( $blog_current_post == 1 || ( $blog_current_post - 1 ) % 4 == 0  ) { 
								echo '<div class="project-group">';
								$blog_current_post_open = true;
							}
						?>
							<div class="project<?php if ( $blog_current_post % 4 == 0 ) echo ' last'; ?>">
								<?php 
									$width = 132;
									$height = 79;
									$titletext = get_the_title();
									$thumbnail = get_thumbnail($width,$height,'media-image',$titletext,$titletext,true,'Media');
									$thumb = $thumbnail["thumb"];
									$et_medialink = get_post_meta($post->ID,'et_medialink',true) ? get_post_meta($post->ID,'et_medialink',true) : '';
									$et_videolink = get_post_meta($post->ID,'et_videolink',true) ? get_post_meta($post->ID,'et_videolink',true) : '';
								?>
								<p class="meta-info"><?php the_time(get_option('feather_date_format')) ?></p>
								<div class="media-thumb">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, 'media-image'); ?>
									<span class="overlay"></span>
									<?php if ( $et_medialink <> '' ) { ?>
										<a href="<?php echo esc_url($et_medialink); ?>" class="zoom">
									<?php } elseif ( $et_videolink <> '' ) { ?>
										<a href="<?php echo esc_url($et_videolink); ?>" class="zoom et-video et_video_lightbox" title="<?php echo esc_attr($titletext); ?>">
									<?php } else { ?>
										<a href="<?php echo esc_url($thumbnail["fullpath"]); ?>" rel="media" class="zoom fancybox" title="<?php echo esc_attr($titletext); ?>">
									<?php } ?>
									<?php esc_html_e('Zoom in','Feather'); ?></a>
									<a href="<?php the_permalink(); ?>" class="more"><?php esc_html_e('More','Feather'); ?></a>
								</div> 	<!-- end .media-thumb -->
							</div> <!-- end .project -->
						<?php 
							if ( $blog_current_post % 4 == 0  ) { 
								echo '</div> <!-- end .project-group -->';
								$blog_current_post_open = false;
							} 
						?>
					<?php $blog_current_post++; endwhile; ?>
					<?php endif; wp_reset_query(); ?>
					
					<?php if ( $blog_current_post_open ) echo '</div> <!-- end .project-group -->'; ?>
				</div> <!-- end #media-slider -->
				<a id="media-left" href="#"><?php esc_html_e('Previous','Feather'); ?></a>
				<a id="media-right" href="#"><?php esc_html_e('Next','Feather'); ?></a>
			</div> <!-- end .recent-inner -->	
		</div> <!-- end .home-recent -->
	<?php } ?>
<?php } else { ?>
	<div id="content-area" class="clearfix">
		<div id="left-area">
			<?php get_template_part('includes/entry','home'); ?>
		</div> 	<!-- end #left-area -->

		<?php get_sidebar(); ?>	
	</div> <!-- end #content-area -->
<?php } ?>
<?php get_footer(); ?>