<?php 
/* 
Template Name: Menu Page
*/
?>

<?php get_header(); ?>

<?php get_template_part('includes/breadcrumbs'); ?>

<div class="container fullwidth">
	<div id="content" class="clearfix">	
		<div id="left-area">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php $menu_categories = is_array(get_option('mycuisine_exlcats_menupage')) ? get_option('mycuisine_exlcats_menupage') : array();
			$currency_sign = get_option('mycuisine_currency_sign') <> '' ? esc_html(get_option('mycuisine_currency_sign')) : '$';
			$i=1; ?>
				
			<?php 
				foreach ( $menu_categories as $category_id ) { ?>
					<?php if ( $i == 1 || ( ($i-1) % 3 == 0 ) ) { 
						$div_open = true;
					?>
						<div class="et_menu_row clearfix">
					<?php } ?>
							<div class="home-block<?php if ( $i%3 == 0 ) echo ' last'; ?>">
								<h2 class="category_name"><?php echo get_cat_name( $category_id ); ?></h2>
								<?php $et_menu_args=array(
									'showposts'=>get_option('mycuisine_menu_numposts'),
									'cat' => $category_id,
								);
								$et_menu_query = new WP_Query($et_menu_args);
								while ( $et_menu_query->have_posts() ) : $et_menu_query->the_post();
						?>
									<?php 
										$thumb = '';
										$width = 56;
										$height = 56;
										$classtext = 'item-image';
										$titletext = get_the_title();
										$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Recommendation');
										$thumb = $thumbnail["thumb"];
										$et_price = get_post_meta($post->ID,'et_price',true) ? esc_html(get_post_meta($post->ID,'et_price',true)) : '';
									?>
									<div class="et_menu_item">
										<div class="thumb">
											<a href="<?php the_permalink(); ?>">
												<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
												<span class="overlay"></span>
												<?php if ( $et_price <> '' ) { ?>
													<span class="price-tag"><span><?php echo $currency_sign . $et_price; ?></span></span>
												<?php } ?>
											</a>
										</div> <!-- end .thumb -->
										<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										<p><?php truncate_post(50); ?></p>
									</div> <!-- end .et_menu_item -->
								<?php endwhile; wp_reset_postdata(); ?>
							</div> <!-- .home-block -->
					<?php if ( $i % 3 == 0 ) {
						$div_open = false;
					?>
						</div> <!-- .et_menu_row -->
					<?php } ?>
				<?php $i++; ?>
			<?php } ?>
			
			<?php if ( isset( $div_open ) && $div_open ) { ?>
				</div> <!-- .et_menu_row -->
			<?php } ?>
		<?php endwhile; endif; ?>
		</div> 	<!-- end #left-area -->

	</div> <!-- end #content -->
	<div id="bottom-shadow"></div>
</div> <!-- end .container -->
		
<?php get_footer(); ?>