<?php get_header(); ?>

<?php if ( get_option('mycuisine_blog_style') == 'false' ) { ?>
	<?php if ( get_option('mycuisine_quote') == 'on' ) { ?>
		<div id="quote">
			<div class="container">
				<div id="quote-shadow"></div>
				<p id="quote-line-1"><?php echo get_option('mycuisine_quote_line1'); ?></p>
				<p id="quote-line-2"><?php echo get_option('mycuisine_quote_line2'); ?></p>
			</div> 	<!-- end .container -->
		</div> <!-- end #quote -->
	<?php } ?>

	<div class="container clearfix">
		<?php if ( get_option('mycuisine_display_blurbs') == 'on' ){ ?>
			<?php for ($i=1; $i <= 3; $i++) { ?>
				<div class="home-block<?php if ( $i == 3 ) echo ' last'; ?>">
					<?php if ( $i ==1 ) { ?>
						<?php if ( get_option('mycuisine_use_area1') != 'on' ) { ?>
							<h3 class="title"><?php esc_html_e("Chef's Recommendations",'MyCuisine'); ?></h3>
							<?php
								$recommendations_args=array(
									'showposts'=> (int) get_option('mycuisine_numposts_recommendations'),
									'category__not_in' => (array) get_option('mycuisine_exlcats_recommendations'),
								);
								$recommendations_query = new WP_Query($recommendations_args);
								while ( $recommendations_query->have_posts() ) : $recommendations_query->the_post();
							?>
									<?php 
										$thumb = '';
										$width = 56;
										$height = 56;
										$classtext = 'item-image';
										$titletext = get_the_title();
										$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Recommendation');
										$thumb = $thumbnail["thumb"];
									?>
									<?php if ( $thumb <> '' ) { ?>
										<div class="thumb">
											<a href="<?php the_permalink(); ?>">
												<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
												<span class="overlay"></span>
											</a>
										</div> <!-- end .thumb -->
										<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										<p><?php truncate_post(50); ?></p>
									<?php } ?>
							<?php endwhile; wp_reset_postdata(); ?>
						<?php } else { ?>
							<?php 
								$service_query = new WP_Query('page_id=' . get_pageId(html_entity_decode(get_option('mycuisine_home_page_1'))));
								while ( $service_query->have_posts() ) : $service_query->the_post(); ?>
							<?php 
								global $more; $more = 0;
							?>
									<h3 class="title"><?php the_title(); ?></h3>
									<?php the_content(''); ?>
							<?php endwhile; wp_reset_postdata(); ?>
						<?php } ?>
					<?php } ?>
					
					<?php if ( $i ==2 ) { ?>
						<?php if ( get_option('mycuisine_use_area2') != 'on' ) { ?>
							<h3 class="title"><?php esc_html_e("Location and hours of operation",'MyCuisine'); ?></h3>
							
							<div id="gmaps-border">
								<div id="gmaps-container"></div>
							</div> <!-- end #gmaps-border -->

							<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.1&sensor=false"></script>
							<script type="text/javascript">
							  //<![CDATA[
							  var map;
							  var geocoder;

							  initialize();

							  function initialize() {
								 geocoder = new google.maps.Geocoder();
								 geocoder.geocode({
									'address': '<?php echo esc_js(get_option('mycuisine_address')); ?>',
									'partialmatch': true}, geocodeResult);   
							  }

							  function geocodeResult(results, status) {
								 
								 if (status == 'OK' && results.length > 0) {         
									var latlng = new google.maps.LatLng(results[0].geometry.location.b,results[0].geometry.location.c);
									var myOptions = {
									   zoom: 17,
									   center: results[0].geometry.location,
									   mapTypeId: google.maps.MapTypeId.ROADMAP
									};
									
									map = new google.maps.Map(document.getElementById("gmaps-container"), myOptions);
									   var marker = new google.maps.Marker({
									   position: results[0].geometry.location,
									   map: map
									});

									var contentString = '<div id="et-gmaps-content">'+
									'<div id="bodyContent">'+
									'<p><a target="_blank" href="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='+escape(results[0].formatted_address)+'&amp;ie=UTF8&amp;view=map">'+results[0].formatted_address+'</a>'+
									'</p>'+
									'</div>'+
									'</div>';
									
									var infowindow = new google.maps.InfoWindow({
									   content: contentString,
									   maxWidth: 100
									});

									google.maps.event.addListener(marker, 'click', function() {
									   infowindow.open(map,marker);
									});

									google.maps.event.trigger(marker, "click");

								 } else {
									//alert("Geocode was not successful for the following reason: " + status);
								 }
							  }
							  //]]>
							</script>
							
							<span class="hours_of_work"><?php esc_html_e('Mon-Fri','MyCuisine'); ?></span> <span class="work_hours_text"><?php echo esc_html(get_option('mycuisine_mon_fri')); ?></span> <span class="hours_of_work"><?php esc_html_e('Sat-Sun','MyCuisine'); ?></span> <span class="work_hours_text"><?php echo esc_html(get_option('mycuisine_sat_sun')); ?></span>
						<?php } else { ?>
							<?php 
								$service_query = new WP_Query('page_id=' . get_pageId(html_entity_decode(get_option('mycuisine_home_page_2'))));
								while ( $service_query->have_posts() ) : $service_query->the_post(); ?>
							<?php 
								global $more; $more = 0;
							?>
									<h3 class="title"><?php the_title(); ?></h3>
									<?php the_content(''); ?>
							<?php endwhile; wp_reset_postdata(); ?>
						<?php } ?>
					<?php } ?>
					
					<?php if ( $i == 3 ) { ?>
						<?php if ( get_option('mycuisine_use_area3') != 'on' ) { ?>
							<h3 class="title"><?php esc_html_e("Customer Testimonials",'MyCuisine'); ?></h3>
							<?php 
								$testimonials_args = array(
									'post_type' => array('testimonial'),
									'showposts' => '1',
									'orderby' => 'rand'
								);
								$testimonials_query = new WP_Query( $testimonials_args );
								while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post(); ?>
									<div class="testimonials-item">
										<div class="testimonials-item-bottom">
											<div class="testimonials-item-content">
												<?php 
													$thumb = '';
													$width = 56;
													$height = 56;
													$classtext = 'item-image';
													$titletext = get_the_title();
													$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Testimonial');
													$thumb = $thumbnail["thumb"];
												?>
												<?php if ( $thumb <> '' ) { ?>
													<div class="thumb">
														<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
														<span class="overlay"></span>
													</div> <!-- end .thumb -->
												<?php } ?>
												<p class="author"><?php the_title(); ?></p>
												<?php the_content(''); ?>
											</div> 	<!-- end .testimonials-item-content -->
										</div> <!-- end .testimonials-item-bottom -->
									</div> <!-- end .testimonials-item -->
							<?php endwhile; wp_reset_postdata(); ?>
						<?php } else { ?>
							<?php 
								$service_query = new WP_Query('page_id=' . get_pageId(html_entity_decode(get_option('mycuisine_home_page_3'))));
								while ( $service_query->have_posts() ) : $service_query->the_post(); ?>
							<?php 
								global $more; $more = 0;
							?>
									<h3 class="title"><?php the_title(); ?></h3>
									<?php the_content(''); ?>
							<?php endwhile; wp_reset_postdata(); ?>
						<?php } ?>
					<?php } ?>
				</div> <!-- end .home-block -->
			<?php } ?>
		<?php } ?>
			
		<a href="<?php echo get_option('mycuisine_menu_page_url'); ?>" class="browse-menu"><span><?php esc_html_e('Click Here To Browse The Menu','MyCuisine'); ?></span></a>
		<div id="bottom-shadow"></div>
	</div> 	<!-- end .container -->
<?php } else { ?>
	<div class="container">
		<div id="content" class="clearfix">	
			<div id="left-area">
				<?php get_template_part('includes/entry','home'); ?>
			</div> 	<!-- end #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- end #content -->
		<div id="bottom-shadow"></div>
	</div> <!-- end .container -->
<?php } ?>

<?php get_footer(); ?>