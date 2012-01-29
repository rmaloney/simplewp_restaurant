<div id="breadcrumbs">
	<div class="container clearfix">
		<div id="breadcrumbs-shadow"></div>
		<span id="breadcrumbs-text">
			<?php if(function_exists('bcn_display')) { bcn_display(); } 
				  else { ?>
						<a href="<?php echo home_url(); ?>"><?php esc_html_e('Home','MyCuisine') ?></a> <span class="raquo">&raquo;</span>
						
						<?php if( is_tag() ) { ?>
							<?php esc_html_e('Posts Tagged ','MyCuisine') ?><span class="raquo">&quot;</span><?php single_tag_title(); echo('&quot;'); ?>
						<?php } elseif (is_day()) { ?>
							<?php esc_html_e('Posts made in','MyCuisine') ?> <?php the_time('F jS, Y'); ?>
						<?php } elseif (is_month()) { ?>
							<?php esc_html_e('Posts made in','MyCuisine') ?> <?php the_time('F, Y'); ?>
						<?php } elseif (is_year()) { ?>
							<?php esc_html_e('Posts made in','MyCuisine') ?> <?php the_time('Y'); ?>
						<?php } elseif (is_search()) { ?>
							<?php esc_html_e('Search results for','MyCuisine') ?> <?php the_search_query() ?>
						<?php } elseif (is_single()) { ?>
							<?php $category = get_the_category();
								  $catlink = get_category_link( $category[0]->cat_ID );
								  echo ('<a href="'.esc_url($catlink).'">'.esc_html($category[0]->cat_name).'</a> '.'<span class="raquo">&raquo;</span> '.get_the_title()); ?>
						<?php } elseif (is_category()) { ?>
							<?php single_cat_title(); ?>
						<?php } elseif (is_author()) { ?>
							<?php esc_html_e('Posts by ','MyCuisine'); echo ' ',$curauth->nickname; ?>
						<?php } elseif (is_page()) { ?>
							<?php wp_title(''); ?>
						<?php }; ?>
			<?php } ?>
		</span>
		<div id="search-form">
			<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
				<input type="text" value="<?php esc_attr_e('Search this website...', 'MyCuisine'); ?>" name="s" id="searchinput" />
				<input type="submit" id="searchbutton" value="<?php esc_attr_e('Search', 'MyCuisine'); ?>" />
			</form>
		</div> <!-- end #search-form -->
	</div> 	<!-- end .container -->
</div> <!-- end #breadcrumbs -->