<?php 
/*
Template Name: Gallery Page
*/
?>
<?php 
$et_ptemplate_settings = array();
$et_ptemplate_settings = maybe_unserialize( get_post_meta($post->ID,'et_ptemplate_settings',true) );

$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : (bool) $et_ptemplate_settings['et_fullwidthpage'];

$gallery_cats = isset( $et_ptemplate_settings['et_ptemplate_gallerycats'] ) ? $et_ptemplate_settings['et_ptemplate_gallerycats'] : array();
$et_ptemplate_gallery_perpage = isset( $et_ptemplate_settings['et_ptemplate_gallery_perpage'] ) ? (int) $et_ptemplate_settings['et_ptemplate_gallery_perpage'] : 12;
?>

<?php get_header(); ?>

<?php get_template_part('includes/breadcrumbs'); ?>

<div class="container<?php if($fullwidth) echo (' fullwidth');?>">
	<div id="content" class="clearfix">	
		<div id="left-area">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="entry post clearfix">								
				<?php if (get_option('mycuisine_page_thumbnails') == 'on') { ?>
					<?php 
						$thumb = '';
						$width = 212;
						$height = 213;
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
				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','MyCuisine').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				
				<div id="et_pt_gallery" class="clearfix">
					<?php $gallery_query = ''; 
					if ( !empty($gallery_cats) ) $gallery_query = '&cat=' . implode(",", $gallery_cats);
					else echo '<!-- gallery category is not selected -->'; ?>
					<?php 
						$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
					?>
					<?php query_posts("showposts=$et_ptemplate_gallery_perpage&paged=" . $et_paged . $gallery_query); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
						<?php $width = 207;
						$height = 136;
						$titletext = get_the_title();

						$thumbnail = get_thumbnail($width,$height,'portfolio',$titletext,$titletext,true,'Portfolio');
						$thumb = $thumbnail["thumb"]; ?>
						
						<div class="et_pt_gallery_entry">
							<div class="et_pt_item_image">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, 'portfolio'); ?>
								<span class="overlay"></span>
								
								<a class="zoom-icon fancybox" title="<?php the_title(); ?>" rel="gallery" href="<?php echo($thumbnail['fullpath']); ?>"><?php esc_html_e('Zoom in','MyCuisine'); ?></a>
								<a class="more-icon" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','MyCuisine'); ?></a>
							</div> <!-- end .et_pt_item_image -->
						</div> <!-- end .et_pt_gallery_entry -->
						
					<?php endwhile; ?>
						<div class="page-nav clearfix">
							<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
							else { ?>
								 <?php get_template_part('includes/navigation'); ?>
							<?php } ?>
						</div> <!-- end .entry -->
					<?php else : ?>
						<?php get_template_part('includes/no-results'); ?>
					<?php endif; wp_reset_query(); ?>
				
				</div> <!-- end #et_pt_gallery -->
				
				<?php edit_post_link(esc_html__('Edit this page','MyCuisine')); ?>			
			</div> <!-- end .entry -->
		<?php endwhile; endif; ?>
		</div> 	<!-- end #left-area -->

		<?php if (!$fullwidth) get_sidebar(); ?>
	</div> <!-- end #content -->
	<div id="bottom-shadow"></div>
</div> <!-- end .container -->
		
<?php get_footer(); ?>