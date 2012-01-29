<?php 
	if ( is_home() ){
		$args=array(
			'showposts'=> (int) get_option('feather_homepage_posts'),
			'paged'=>$paged,
			'category__not_in' => (array) get_option('feather_exlcats_recent'),
		);
		if (get_option('feather_duplicate') == 'false'){
			global $ids;
			$args['post__not_in'] = $ids;
		}
		query_posts($args);
	}
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="post entry clearfix">
		<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php get_template_part('includes/postinfo'); ?>
		<?php
			$thumb = '';
			$width = 178;
			$height = 178;
			$classtext = 'post-thumb';
			$titletext = get_the_title();
			$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
			$thumb = $thumbnail["thumb"];
		?>
		<?php if($thumb <> '' && get_option('feather_thumbnails_index') == 'on') { ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					<span class="post-overlay"></span>
				</a>
			</div> 	<!-- end .post-thumbnail -->
		<?php } ?>
		<?php if (get_option('feather_blog_style') == 'on') the_content(''); else { ?>
			<p><?php truncate_post(500); ?></p>
		<?php }; ?>
		<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More','Feather'); ?></a>
	</div> 	<!-- end .post-->
<?php endwhile; ?>
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
	else { ?>
		 <?php get_template_part('includes/navigation'); ?>
	<?php } ?>
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; if ( is_home() ) wp_reset_query(); ?>