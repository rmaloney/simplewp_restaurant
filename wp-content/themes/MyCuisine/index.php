<?php get_header(); ?>

<?php get_template_part('includes/breadcrumbs'); ?>
<div class="container">
	<div id="content" class="clearfix">	
		<div id="left-area">
			<?php get_template_part('includes/entry'); ?>
		</div> 	<!-- end #left-area -->

		<?php get_sidebar(); ?>
	</div> <!-- end #content -->
	<div id="bottom-shadow"></div>
</div> <!-- end .container -->
				
<?php get_footer(); ?>