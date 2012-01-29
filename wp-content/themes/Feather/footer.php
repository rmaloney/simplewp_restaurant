		</div> <!-- end .container -->
	</div> <!-- end #content -->

	<div id="footer">
		<div class="container">
			<div id="footer-widgets" class="clearfix">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
				<?php endif; ?>
			</div> <!-- end #footer-widgets -->

			<div id="footer-bottom" class="clearfix">
				<?php
					$menuID = 'bottom-nav';
					$footerNav = '';

					if (function_exists('wp_nav_menu')) $footerNav = wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'fallback_cb' => '', 'menu_id' => $menuID, 'menu_class' => 'bottom-nav', 'echo' => false, 'depth' => '1' ) );
					if ($footerNav == '') show_page_menu($menuID);
					else echo($footerNav);
				?>
				<p id="copyright"><?php esc_html_e('Designed by ','Feather'); ?> <a href="http://www.elegantthemes.com" title="Premium WordPress Themes">Elegant WordPress Themes</a> | <?php esc_html_e('Powered by ','Feather'); ?> <a href="http://www.wordpress.org">WordPress</a></p>
			</div> <!-- end #footer-bottom -->
		</div> <!-- end .container -->
	</div> <!-- end #footer -->

	<?php get_template_part('includes/scripts'); ?>
	<?php wp_footer(); ?>

</body>
</html>