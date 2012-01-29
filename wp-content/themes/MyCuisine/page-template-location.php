<?php 
/* 
Template Name: Location Page
*/
?>

<?php get_header(); ?>

<?php get_template_part('includes/breadcrumbs'); ?>

<div class="container fullwidth">
	<div id="content" class="clearfix">	
		<div id="left-area">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="location-left-area">
				<div class="info-block">
					<h2 class="category_name"><?php esc_html_e('Address','MyCuisine'); ?></h2>
					<?php echo esc_html(get_option('mycuisine_address')); ?>
				</div> <!-- end .info-block -->
				
				<div class="info-block">
					<h2 class="category_name"><?php esc_html_e('Hours Of Operation','MyCuisine'); ?></h2>
					<p><?php esc_html_e('Monday-Friday:','MyCuisine'); ?> <span><?php echo esc_html(get_option('mycuisine_mon_fri')); ?></span></p>
					<p><?php esc_html_e('Saturday-Sunday:','MyCuisine'); ?> <span><?php echo esc_html(get_option('mycuisine_sat_sun')); ?></span></p>
				</div> <!-- end .info-block -->
				
				<div class="info-block">
					<h2 class="category_name"><?php esc_html_e('Contact Info','MyCuisine'); ?></h2>
					<p><?php esc_html_e('Email Address:','MyCuisine'); ?> <span><?php echo antispambot(get_option('mycuisine_email')); ?></span></p>
					<p><?php esc_html_e('Telephone:','MyCuisine'); ?> <span><?php echo esc_html(get_option('mycuisine_telephone')); ?></span></p>
					<p><?php esc_html_e('Fax:','MyCuisine'); ?> <span><?php echo esc_html(get_option('mycuisine_fax')); ?></span></p>
				</div> <!-- end .info-block -->
				
				<?php do_action('et_location_additional_info'); ?>
			</div> <!-- end #location-left-area -->
		
			<div id="gmaps-border" class="location-page">
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
					   maxWidth: 100,
					   maxHeight: 200
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
			
			<?php do_action('et_location_content'); ?>
		<?php endwhile; endif; ?>
		</div> 	<!-- end #left-area -->

	</div> <!-- end #content -->
	<div id="bottom-shadow"></div>
</div> <!-- end .container -->
		
<?php get_footer(); ?>