<?php get_header(); ?>

<div id="content-area" class="clearfix">
	<div id="left-area">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="entry post clearfix">
			<?php if (get_option('feather_integration_single_top') <> '' && get_option('feather_integrate_singletop_enable') == 'on') echo(get_option('feather_integration_single_top')); ?>
			
			<?php if (get_option('feather_thumbnails') == 'on') { ?>
				<?php 
					$thumb = '';
					$width = 178;
					$height = 178;
					$classtext = 'post-thumb';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
					$thumb = $thumbnail["thumb"];
				?>
				
				<?php if($thumb <> '') { ?>
					<div class="post-thumbnail">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
						<span class="post-overlay"></span>
					</div> 	<!-- end .post-thumbnail -->
				<?php } ?>
			<?php } ?>
			
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Feather').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_html__('Edit this page','Feather')); ?>			
		</div> <!-- end .entry -->
		
		<?php if (get_option('feather_integration_single_bottom') <> '' && get_option('feather_integrate_singlebottom_enable') == 'on') echo(get_option('feather_integration_single_bottom')); ?>		
					
		<?php if (get_option('feather_468_enable') == 'on') { ?>
				  <?php if(get_option('feather_468_adsense') <> '') echo(get_option('feather_468_adsense'));
				else { ?>
				   <a href="<?php echo esc_url(get_option('feather_468_url')); ?>"><img src="<?php echo esc_url(get_option('feather_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
		   <?php } ?>   
		<?php } ?>
		
		<?php if (get_option('feather_show_postcomments') == 'on') comments_template('', true); ?>
	<?php endwhile; endif; ?>
	</div> 	<!-- end #left-area -->

	<?php get_sidebar(); ?>
</div> <!-- end #content-area -->	
		
<?php get_footer(); ?>