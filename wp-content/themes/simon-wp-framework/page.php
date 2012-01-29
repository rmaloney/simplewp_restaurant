<?php get_header(); ?>
<div id="content" class="grid_12">
  
  <?php if (have_posts()) : while (have_posts()) : the_post();?>
  <div id="post-entries">
    <?php if(is_page(array(26,20))) {?>
    <h2> <?php the_title(); }?></h2>
  <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <?php the_content() ?>
  <div class="clear"></div>
  </div>

  </div>
  <?php endwhile; else: ?>
  <p>
    <?php _e('Sorry, no posts matched your criteria.'); ?>
  </p>
  <?php endif; ?>

</div>



<!--- make your call to get_sidebar() here to display sidebar. This is disabled for full pages -->
<?php get_footer(); ?>