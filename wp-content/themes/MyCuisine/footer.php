	</div> <!-- end #content-area -->	
		
	<div id="footer">
		<div class="container">
			<?php if ( !is_home() ) { ?>
				<div id="footer-widgets" class="clearfix">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
					<?php endif; ?>
				</div> <!-- end #footer-widgets -->
			<?php } ?>
			
			<div id="footer-bottom" class="clearfix<?php if ( !is_home() ) echo ' nobg'; ?>">
				<?php 
					$menuID = 'bottom-menu';
					$footerNav = '';
				
					if (function_exists('wp_nav_menu')) $footerNav = wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'fallback_cb' => '', 'menu_id' => $menuID, 'echo' => false, 'depth' => '1' ) );
					if ($footerNav == '') show_page_menu($menuID);
					else echo($footerNav); 
				?>
				<p id="copyright"><?php esc_html_e('Designed by ','MyCuisine'); ?> <a href="http://www.elegantthemes.com" title="Premium WordPress Themes">Elegant WordPress Themes</a> | <?php esc_html_e('Powered by ','MyCuisine'); ?> <a href="http://www.wordpress.org">WordPress</a></p>
			</div> 	<!-- end #footer-bottom -->	
		</div> 	<!-- end .container -->	
	</div> <!-- end #footer -->
	
	<?php get_template_part('includes/scripts'); ?>
	<?php wp_footer(); ?>
</body>
</html>