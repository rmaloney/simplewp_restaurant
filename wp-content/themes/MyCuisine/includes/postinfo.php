<?php if (!is_single() && get_option('mycuisine_postinfo1') <> '') { ?>
	<p class="meta-info"><?php esc_html_e('Posted','MyCuisine'); ?> <?php if (in_array('author', get_option('mycuisine_postinfo1'))) { ?> <?php esc_html_e('by','MyCuisine'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('mycuisine_postinfo1'))) { ?> <?php esc_html_e('on','MyCuisine'); ?> <?php the_time(get_option('mycuisine_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('mycuisine_postinfo1'))) { ?> <?php esc_html_e('in','MyCuisine'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('mycuisine_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','MyCuisine'), esc_html__('1 comment','MyCuisine'), '% '.esc_html__('comments','MyCuisine')); ?><?php }; ?></p>
<?php } elseif (is_single() && get_option('mycuisine_postinfo2') <> '') { ?>
	<p class="meta-info">
		<?php global $query_string;
		$new_query = new WP_Query($query_string);
		while ($new_query->have_posts()) $new_query->the_post(); ?>
			<?php esc_html_e('Posted','MyCuisine'); ?> <?php if (in_array('author', get_option('mycuisine_postinfo2'))) { ?> <?php esc_html_e('by','MyCuisine'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('mycuisine_postinfo2'))) { ?> <?php esc_html_e('on','MyCuisine'); ?> <?php the_time(get_option('mycuisine_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('mycuisine_postinfo2'))) { ?> <?php esc_html_e('in','MyCuisine'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('mycuisine_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','MyCuisine'), esc_html__('1 comment','MyCuisine'), '% '.esc_html__('comments','MyCuisine')); ?><?php }; ?>
		<?php wp_reset_postdata() ?>
	</p>
<?php }; ?>