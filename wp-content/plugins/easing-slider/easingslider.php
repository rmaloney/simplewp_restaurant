<?php
/*
Plugin Name: Easing Slider
Plugin URI: http://easingslider.matthewruddy.com
Description: Easing Slider is an image slider which uses the jQuery Easing Plugin. It comes with many different transition and styling settings so you'll never have to edit any of the CSS files directly. Images are got from custom fields or Easing Slider's own 'custom images' panel where you can specify particular images via their URL.
Version: 1.1.9
Author: Matthew Ruddy
Author URI: http://matthewruddy.com
License: This plugin is licensed under the GNU General Public License.
*/

function my_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('uploadimagebutton', WP_PLUGIN_URL.'/easing-slider/js/uploadimagebutton.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('uploadimagebutton');
}

function my_admin_styles() {
wp_enqueue_style('thickbox');
}

if (isset($_GET['page']) && $_GET['page'] == 'easing-slider/easingslider.php') {
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');
}

function easing_head() {
  $width = get_option('width');
	$interval = get_option('interval');
	$transition = get_option('transition');
	$transpeed = get_option('transpeed');
	$start = get_option('start');
	$pageposition = get_option('pageposition');
	$pageside = get_option('pageside');
	$paginationon = get_option('paginationon');
	$paginationoff = get_option('paginationoff');
?>

<!-- Start of Easing Slider -->
<style type="text/css">ul.lof-navigator li{background: url(<?php if($paginationoff=='') echo WP_PLUGIN_URL.'/easing-slider/images/pagination.png'; if($paginationoff!='') echo $paginationoff; ?>) 0 0 no-repeat;} ul.lof-navigator li.active{background: url(<?php if($paginationon=='') echo WP_PLUGIN_URL.'/easing-slider/images/pagination_current.png'; if($paginationon!='') echo $paginationon; ?>) 0 0 no-repeat;}
.lof-opacity{width:<?php echo $width;?>px;height:<?php echo $height;?>px;}
.lof-opacity li{width:<?php echo $width;?>px;height:<?php echo $height;?>px;}
</style>

<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready( function($){	
	var buttons = { previous:$('#lofslidecontent45 .lof-previous') , next:$('#lofslidecontent45 .lof-next') };
	$obj = $('#lofslidecontent45')
	.lofJSidernews( { interval : <?php echo $interval; ?>,
	<?php if($transition=='slide') echo "easing : 'easeInOutExpo'";
		if($transition=='smooth') echo "easing : 'easeInOutQuad'";
    if($transition=='fade') echo "direction : 'opacity'";
		if($transition=='swipe') echo "easing : 'easeOutBack'";
		if($transition=='bounce') echo "easing : 'easeOutBounce'"; ?>,
	duration : <?php echo $transpeed; ?>,
	auto : true,
	maxItemDisplay : 10,
	startItem:<?php if($start=='1') echo '0';
	if($start=='2') echo '1'; 
	if($start=='3') echo '2'; 
	if($start=='4') echo '3'; 
	if($start=='5') echo '4'; 
	if($start=='6') echo '5'; 
	if($start=='7') echo '6'; 
	if($start=='8') echo '7'; 
	if($start=='9') echo '8'; 
	if($start=='10') echo '9'; ?>,
	navPosition     : 'horizontal', // horizontal
	navigatorHeight : 15,
	navigatorWidth  : 25,
	buttons : buttons,
	mainWidth:<?php echo $width; ?>} );	
});</script>
<!-- End of Easing Slider -->
<?php }

function add_scripts() {
$scripturl = WP_PLUGIN_URL .'/easing-slider/js/';

if(get_option('jquery') == 'true') {
if ( !is_admin() ) {
wp_deregister_script('jquery');
wp_register_script('jquery', $scripturl.'jquery.js', '', '1.4.2');
wp_enqueue_script('jquery');
}
}

wp_register_script('easing', $scripturl.'jquery.easing.js', '', '1.3');
wp_enqueue_script('easing');
wp_register_script('script', $scripturl.'script.js', '', '1.1.9');
wp_enqueue_script('script');

}

function add_styles() {
$sliderstyle = WP_PLUGIN_URL .'/easing-slider/css/slider.css';

wp_register_style('slider', $sliderstyle, '', '1.1.9');
wp_enqueue_style('slider');

}

add_action('wp_print_styles','add_styles');
add_action('wp_print_scripts','add_scripts');

function admin_files() {
	?><link rel="stylesheet" href="<?php echo WP_PLUGIN_URL .'/easing-slider/css/tabs.css'; ?>" />
	<script type="text/javascript" src="http://yui.yahooapis.com/2.5.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>
	<script type="text/javascript" src="http://yui.yahooapis.com/2.5.0/build/element/element-beta-min.js"></script>
	<script type="text/javascript" src="http://yui.yahooapis.com/2.5.0/build/connection/connection-min.js"></script>
	<script type="text/javascript" src="http://yui.yahooapis.com/2.5.0/build/tabview/tabview-min.js"></script>
<?php }

add_action('admin_head', 'admin_files');
add_action('wp_head', 'easing_head');

function easing_slider() {
	$sImg1 = get_option('sImg1');
	$sImg2 = get_option('sImg2');
	$sImg3 = get_option('sImg3');
	$sImg4 = get_option('sImg4');
	$sImg5 = get_option('sImg5');
	$sImg6 = get_option('sImg6');
	$sImg7 = get_option('sImg7');
	$sImg8 = get_option('sImg8');
	$sImg9 = get_option('sImg9');
	$sImg10 = get_option('sImg10');
	$sImglink1 = get_option('sImglink1');
	$sImglink2 = get_option('sImglink2');
	$sImglink3 = get_option('sImglink3');
	$sImglink4 = get_option('sImglink4');
	$sImglink5 = get_option('sImglink5');
	$sImglink6 = get_option('sImglink6');
	$sImglink7 = get_option('sImglink7');
	$sImglink8 = get_option('sImglink8');
	$sImglink9 = get_option('sImglink9');
	$sImglink10 = get_option('sImglink10');
	$sPagination = get_option('sPagination');
	$activation = get_option('activation');
	$width = get_option('width');
	$height = get_option('height');
	$shadow = get_option('shadow');
	$interval = get_option('interval');
	$transition = get_option('transition');
	$bgcolour = get_option('bgcolour');
	$transpeed = get_option('transpeed');
	$bwidth = get_option('bwidth');
	$bcolour = get_option('bcolour');
	$preload = get_option('preload');
	$start = get_option('start');
	$buttons = get_option('buttons');
	$source = get_option('source');
	$featcat = get_option('featcat');
	$featpost = get_option('featpost');
	$padbottom = get_option('padbottom');
	$padleft = get_option('padleft');
	$padright = get_option('padright');
	$paddingtop = get_option('paddingtop');
	$shadowstyle = get_option('shadowstyle');
	$paginationon = get_option('paginationon');
	$paginationoff = get_option('paginationoff');
	$next = get_option('next');
	$prev = get_option('prev');
	$pageposition = get_option('pageposition');
	$pageside = get_option('pageside');
	$permalink = get_option('permalink');
	$jquery = get_option('jquery');

	$padtop = $bwidth*2;

	if ($activation == 'enable') {

	$padding = '';

	if ($shadow == '') {
	$padding = $padbottom;
	$imgpadding = '0'; }
	else {
	$imgpadding = $padbottom; } ?>
  <!-- Easing Slider -->
    <div class="lof-container" style="height:<?php echo $height; ?>px;padding-right:<?php echo $padright; ?>px;padding-top:<?php echo $paddingtop; ?>px;padding-left:<?php echo $padleft;?>px;padding-bottom:<?php echo $imgpadding;?>px;">
      <div class="lof-slidecontent" id="lofslidecontent45" style="border:<?php echo $bwidth;?>px solid #<?php echo $bcolour; ?>;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;">
        <div class="preload" style="<?php if($transition=='fade') echo 'padding-top:1px\9;'; ?>background:url(<?php echo WP_PLUGIN_URL; ?>/easing-slider/images/<?php if($preload=='indicator') echo 'indicator'; if($preload=='none') echo ''; if($preload=='arrows') echo 'arrows';  if($preload=='bar') echo 'bar'; if($preload=='bigflower') echo 'bigflower'; if($preload=='bounceball') echo 'bounceball'; if($preload=='indicatorlight') echo 'indicatorlight'; if($preload=='pik') echo 'pik'; if($preload=='snake') echo 'snake'; ?>.gif) no-repeat center center #<?php if($bgcolour=='') echo 'fff'; else echo $bgcolour; ?>;">

        </div>
            <div class="lof-main-outer" style="background: #<?php echo $bgcolour; ?>;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;">
                <ul class="lof-main-wapper">
              <?php
  	
  	if(get_option('source') == 'featured') { ?>
      <?php $recent = new WP_Query('cat='.$featcat.'&showposts='.$featpost.'');
        while($recent->have_posts()) : $recent->the_post(); global $post;
          $image = get_post_meta($post->ID, 'easing', true); if (!empty($image)) { ?>
                  <li><?php if($permalink == '') { ?><a href="<?php the_permalink(); ?>"><?php } ?><img src="<?php echo $image; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($permalink == '') { ?></a><?php } ?></li>
                  
        <?php }endwhile; ?>
        
    <?php } else if(get_option('source') == 'all') { ?>
      <?php $recent = new WP_Query('showposts='.$featpost.'');
        while($recent->have_posts()) : $recent->the_post(); global $post;
          $image = get_post_meta($post->ID, 'easing', true); if (!empty($image)) { ?>
                   <li><?php if($permalink == '') { ?><a href="<?php the_permalink(); ?>"><?php } ?><img src="<?php echo $image; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>"/><?php if ($permalink == '') { ?></a><?php } ?></li>
                   
        <?php }endwhile; ?>
        
  <?php } else if(get_option('source') == 'custom') {
  
	if ($sImg1) { ?>
		<li><?php if($sImglink1!='') echo '<a href="'. $sImglink1 .'">'; ?><img src="<?php echo $sImg1; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($sImglink1!='') echo '</a>'; ?></li><?php }

	if ($sImg2) { ?>
		<li><?php if($sImglink2!='') echo '<a href="'. $sImglink2 .'">'; ?><img src="<?php echo $sImg2; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($sImglink2!='') echo '</a>'; ?></li><?php }
		
	if ($sImg3) { ?>
		<li><?php if($sImglink3!='') echo '<a href="'. $sImglink3 .'">'; ?><img src="<?php echo $sImg3; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($sImglink3!='') echo '</a>'; ?></li><?php }
		
	if ($sImg4) { ?>
		<li><?php if($sImglink4!='') echo '<a href="'. $sImglink4 .'">'; ?><img src="<?php echo $sImg4; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($sImglink4!='') echo '</a>'; ?></li><?php }
		
	if ($sImg5) { ?>
		<li><?php if($sImglink5!='') echo '<a href="'. $sImglink5 .'">'; ?><img src="<?php echo $sImg5; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($sImglink5!='') echo '</a>'; ?></li><?php }
		
	if ($sImg6) { ?>
		<li><?php if($sImglink6!='') echo '<a href="'. $sImglink6 .'">'; ?><img src="<?php echo $sImg6; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($sImglink6!='') echo '</a>'; ?></li><?php }
		
	if ($sImg7) { ?>
		<li><?php if($sImglink7!='') echo '<a href="'. $sImglink7 .'">'; ?><img src="<?php echo $sImg7; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($sImglink7!='') echo '</a>'; ?></li><?php }
		
	if ($sImg8) { ?>
		<li><?php if($sImglink8!='') echo '<a href="'. $sImglink8 .'">'; ?><img src="<?php echo $sImg8; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($sImglink8!='') echo '</a>'; ?></li><?php }
		
	if ($sImg9) { ?>
		<li><?php if($sImglink9!='') echo '<a href="'. $sImglink9 .'">'; ?><img src="<?php echo $sImg9; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($sImglink9!='') echo '</a>'; ?></li><?php }
		
	if ($sImg10) { ?>
		<li><?php if($sImglink10!='') echo '<a href="'. $sImglink10 .'">'; ?><img src="<?php echo $sImg10; ?>" style="width:<?php echo $width; ?>px;" alt="<?php echo $images; ?>" /><?php if($sImglink10!='') echo '</a>'; ?></li><?php }
		
		}
		
	?></ul><?php


	if ($buttons=='');
	else { ?>
              <div onclick="return false" class="lof-previous" style="
	background:url(<?php if($prev=='') echo WP_PLUGIN_URL.'/easing-slider/images/b_prev.png'; if($prev!='') echo $prev; ?>) no-repeat left center;"></div>
              <div onclick="return false" class="lof-next" style="
	background:url(<?php if($next=='') echo WP_PLUGIN_URL.'/easing-slider/images/b_next.png'; if($next!='') echo $next; ?>) no-repeat right center;"></div> <?php }

	?></div><?php


	$sPagination = get_option('sPagination');

	if ($sPagination=='yes') { ?>
                <div class="lof-navigator-wapper" style="bottom:<?php if($pageposition=='outside') echo '-35'; if($pageposition=='inside') echo '5'; ?>px;<?php if($pageside=='left') echo 'left: 0'; if($pageside=='right') echo 'right:-10px'; ?>;padding:5px <?php if($pageposition=='outside') echo '5'; if($pageposition=='inside') echo '15'; ?>px;">
                  <div class="lof-navigator-outer">
                    <ul class="lof-navigator">
                      <?php
  	
  	if(get_option('source') == 'featured') { ?>
      <?php $recent = new WP_Query('cat='.$featcat.'&showposts='.$featpost.'');
        while($recent->have_posts()) : $recent->the_post(); global $post;
          $image = get_post_meta($post->ID, 'easing', true); if (!empty($image)) { ?>
            <li><span>.</span></li>
        <?php }endwhile; ?>
        
      <?php } else if(get_option('source') == 'all') { ?>
      <?php $recent = new WP_Query('showposts='.$featpost.'');
        while($recent->have_posts()) : $recent->the_post(); global $post;
          $image = get_post_meta($post->ID, 'easing', true); if (!empty($image)) { ?>
            <li><span>.</span></li>
        <?php }endwhile; ?>
        
<?php } else if(get_option('source') == 'custom') {
  
	if ($sImg1) {
		echo '<li><span>.</span></li>'; }
	if ($sImg2) {
		echo '<li><span>.</span></li>'; }
	if ($sImg3) {
		echo '<li><span>.</span></li>'; }
	if ($sImg4) {
		echo '<li><span>.</span></li>'; }
	if ($sImg5) {
		echo '<li><span>.</span></li>'; }
	if ($sImg6) {
		echo '<li><span>.</span></li>'; }
	if ($sImg7) {
		echo '<li><span>.</span></li>'; }
	if ($sImg8) {
		echo '<li><span>.</span></li>'; }
	if ($sImg9) {
		echo '<li><span>.</span></li>'; }
	if ($sImg10) {
		echo '<li><span>.</span></li>'; }
}

	?>             </ul>
                </div>
              </div>
              
<?php  }
	
	elseif ($sPagination=='no') {
    echo ''; } ?>
            </div>
          </div><?php

	if ($shadow=='')   
	echo '<img src="'.WP_PLUGIN_URL.'/easing-slider/images/shadow_'.$shadowstyle.'.png" style="width:'.$width.'px; padding-left:'.$padleft.'px;padding-bottom:'.$padding.'px;padding-top:'.$padtop.'px;margin-left:'.$bwidth.'px;" alt="" />'; ?><!-- End of Easing Slider --><?php

}
}


function easing_slider_short() {
    ob_start();
    easing_slider();
    $output_string=ob_get_contents();;
    ob_end_clean();

return $output_string;
}


add_shortcode('easingslider', 'easing_slider_short');

function set_easing_options() {
  add_option('sImg1','','');
	add_option('sImg2','','');
	add_option('sImg3','','');
	add_option('sImg4','','');
	add_option('sImg5','','');
	add_option('sImg6','','');
	add_option('sImg7','','');
	add_option('sImg8','','');
	add_option('sImg9','','');
	add_option('sImg10','','');
  add_option('sImglink1','','');
	add_option('sImglink2','','');
	add_option('sImglink3','','');
	add_option('sImglink4','','');
	add_option('sImglink5','','');
	add_option('sImglink6','','');
	add_option('sImglink7','','');
	add_option('sImglink8','','');
	add_option('sImglink9','','');
	add_option('sImglink10','','');
	add_option('sPagination','yes','');
	add_option('activation','enable','');
	add_option('width','480','');
	add_option('height','185','');
	add_option('shadow','','');
	add_option('interval','4000','');
	add_option('transition','slide','');
	add_option('bgcolour','fff','');
	add_option('transpeed','1200','');
	add_option('bwidth','3','');
	add_option('bcolour','ccc','');
	add_option('preload','indicator','');
	add_option('start','1','');
	add_option('buttons','','');
	add_option('source','featured','');
	add_option('featcat','','');
	add_option('featpost','5','');
	add_option('padbottom','0','');
	add_option('padleft','0','');
	add_option('padright','0','');
	add_option('paddingtop','0','');
	add_option('shadowstyle','arc','');
	add_option('paginationon','','');
	add_option('paginationoff','','');
	add_option('next','','');
	add_option('prev','','');
	add_option('pageposition','outside','');
	add_option('pageside','left','');
	add_option('permalink','','');
	add_option('jquery','true','');
}

function unset_easing_options() {
	delete_option('sImg1');
	delete_option('sImg2');
	delete_option('sImg3');
	delete_option('sImg4');
	delete_option('sImg5');
	delete_option('sImg6');
	delete_option('sImg7');
	delete_option('sImg8');
	delete_option('sImg9');
	delete_option('sImg10');
	delete_option('sImglink1');
	delete_option('sImglink2');
	delete_option('sImglink3');
	delete_option('sImglink4');
	delete_option('sImglink5');
	delete_option('sImglink6');
	delete_option('sImglink7');
	delete_option('sImglink8');
	delete_option('sImglink9');
	delete_option('sImglink10');
	delete_option('sPagination');
	delete_option('activation');
	delete_option('width');
	delete_option('height');
	delete_option('shadow');
	delete_option('interval');
	delete_option('transition');
	delete_option('bgcolour');
	delete_option('transpeed');
	delete_option('bwidth');
	delete_option('bcolour');
	delete_option('preload');
	delete_option('start');
	delete_option('buttons');
	delete_option('source');
	delete_option('featcat');
	delete_option('featpost');
	delete_option('padbottom');
	delete_option('padleft');
	delete_option('padright');
	delete_option('paddingtop');
	delete_option('shadowstyle');
	delete_option('paginationon');
	delete_option('paginationoff');
	delete_option('next');
	delete_option('prev');
	delete_option('pageposition');
	delete_option('pageside');
	delete_option('permalink');
	delete_option('jquery');
}

register_activation_hook(__FILE__,'set_easing_options');
register_uninstall_hook(__FILE__,'unset_easing_options');

function admin_easing() {

	$sImg1 = get_option('sImg1');
	$sImg2 = get_option('sImg2');
	$sImg3 = get_option('sImg3');
	$sImg4 = get_option('sImg4');
	$sImg5 = get_option('sImg5');
	$sImg6 = get_option('sImg6');
	$sImg7 = get_option('sImg7');
	$sImg8 = get_option('sImg8');
	$sImg9 = get_option('sImg9');
	$sImg10 = get_option('sImg10');
	$sImglink1 = get_option('sImglink1');
	$sImglink2 = get_option('sImglink2');
	$sImglink3 = get_option('sImglink3');
	$sImglink4 = get_option('sImglink4');
	$sImglink5 = get_option('sImglink5');
	$sImglink6 = get_option('sImglink6');
	$sImglink7 = get_option('sImglink7');
	$sImglink8 = get_option('sImglink8');
	$sImglink9 = get_option('sImglink9');
	$sImglink10 = get_option('sImglink10');
	$sPagination = get_option('sPagination');
	$activation = get_option('activation');
	$width = get_option('width');
	$height = get_option('height');
	$shadow = get_option('shadow');
	$interval = get_option('interval');
	$transition = get_option('transition');
	$bgcolour = get_option('bgcolour');
	$transpeed = get_option('transpeed');
	$bwidth = get_option('bwidth');
	$bcolour = get_option('bcolour');
	$preload = get_option('preload');
	$start = get_option('start');
	$buttons = get_option('buttons');
	$source = get_option('source');
	$featcat = get_option('featcat');
	$featpost = get_option('featpost');
	$padbottom = get_option('padbottom');
	$padleft = get_option('padleft');
	$padright = get_option('padright');
	$paddingtop = get_option('paddingtop');
	$shadowstyle = get_option('shadowstyle');
	$paginationon = get_option('paginationon');
	$paginationoff = get_option('paginationoff');
	$next = get_option('next');
	$prev = get_option('prev');
	$pageposition = get_option('pageposition');
	$pageside = get_option('pageside');
	$permalink = get_option('permalink');
	$jquery = get_option('jquery');

if ('process' == $_POST['options']) {
	update_option('sImg1',$_REQUEST['sImg1']);
	update_option('sImg2',$_REQUEST['sImg2']);
	update_option('sImg3',$_REQUEST['sImg3']);
	update_option('sImg4',$_REQUEST['sImg4']);
	update_option('sImg5',$_REQUEST['sImg5']);
	update_option('sImg6',$_REQUEST['sImg6']);
	update_option('sImg7',$_REQUEST['sImg7']);
	update_option('sImg8',$_REQUEST['sImg8']);
	update_option('sImg9',$_REQUEST['sImg9']);
	update_option('sImg10',$_REQUEST['sImg10']);
	update_option('sImglink1',$_REQUEST['sImglink1']);
	update_option('sImglink2',$_REQUEST['sImglink2']);
	update_option('sImglink3',$_REQUEST['sImglink3']);
	update_option('sImglink4',$_REQUEST['sImglink4']);
	update_option('sImglink5',$_REQUEST['sImglink5']);
	update_option('sImglink6',$_REQUEST['sImglink6']);
	update_option('sImglink7',$_REQUEST['sImglink7']);
	update_option('sImglink8',$_REQUEST['sImglink8']);
	update_option('sImglink9',$_REQUEST['sImglink9']);
	update_option('sImglink10',$_REQUEST['sImglink10']);
	update_option('sPagination',$_REQUEST['sPagination']);
	update_option('activation',$_REQUEST['activation']);
	update_option('width',$_REQUEST['width']);
	update_option('height',$_REQUEST['height']);
	update_option('shadow',$_REQUEST['shadow']);
	update_option('interval',$_REQUEST['interval']);
	update_option('transition',$_REQUEST['transition']);
	update_option('bgcolour',$_REQUEST['bgcolour']);
	update_option('transpeed',$_REQUEST['transpeed']);
	update_option('bwidth',$_REQUEST['bwidth']);
	update_option('bcolour',$_REQUEST['bcolour']);
	update_option('preload',$_REQUEST['preload']);
	update_option('start',$_REQUEST['start']);
	update_option('buttons',$_REQUEST['buttons']);
	update_option('source',$_REQUEST['source']);
	update_option('featcat',$_REQUEST['featcat']);
	update_option('featpost',$_REQUEST['featpost']);
	update_option('padbottom',$_REQUEST['padbottom']);
	update_option('padleft',$_REQUEST['padleft']);
	update_option('padright',$_REQUEST['padright']);
	update_option('paddingtop',$_REQUEST['paddingtop']);
	update_option('shadowstyle',$_REQUEST['shadowstyle']);
	update_option('paginationon',$_REQUEST['paginationon']);
	update_option('paginationoff',$_REQUEST['paginationoff']);
	update_option('next',$_REQUEST['next']);
	update_option('prev',$_REQUEST['prev']);
	update_option('pageposition',$_REQUEST['pageposition']);
	update_option('pageside',$_REQUEST['pageside']);
	update_option('permalink',$_REQUEST['permalink']);
	update_option('jquery',$_REQUEST['jquery']);
	$sImg1 = get_option('sImg1');
	$sImg2 = get_option('sImg2');
	$sImg3 = get_option('sImg3');
	$sImg4 = get_option('sImg4');
	$sImg5 = get_option('sImg5');
	$sImg6 = get_option('sImg6');
	$sImg7 = get_option('sImg7');
	$sImg8 = get_option('sImg8');
	$sImg9 = get_option('sImg9');
	$sImg10 = get_option('sImg10');
	$sImglink1 = get_option('sImglink1');
	$sImglink2 = get_option('sImglink2');
	$sImglink3 = get_option('sImglink3');
	$sImglink4 = get_option('sImglink4');
	$sImglink5 = get_option('sImglink5');
	$sImglink6 = get_option('sImglink6');
	$sImglink7 = get_option('sImglink7');
	$sImglink8 = get_option('sImglink8');
	$sImglink9 = get_option('sImglink9');
	$sImglink10 = get_option('sImglink10');
	$sPagination = get_option('sPagination');
	$activation = get_option('activation');
	$width = get_option('width');
	$height = get_option('height');
	$shadow = get_option('shadow');
	$interval = get_option('interval');
	$transition = get_option('transition');
	$bgcolour = get_option('bgcolour');
	$transpeed = get_option('transpeed');
	$bwidth = get_option('bwidth');
	$bcolour = get_option('bcolour');
	$preload = get_option('preload');
	$start = get_option('start');
	$buttons = get_option('buttons');
	$source = get_option('source');
	$featcat = get_option('featcat');
	$featpost = get_option('featpost');
	$padbottom = get_option('padbottom');
	$padleft = get_option('padleft');
	$padright = get_option('padright');
	$paddingtop = get_option('paddingtop');
	$shadowstyle = get_option('shadowstyle');
	$paginationon = get_option('paginationon');
	$paginationoff = get_option('paginationoff');
	$next = get_option('next');
	$prev = get_option('prev');
	$pageposition = get_option('pageposition');
	$pageside = get_option('pageside');
	$permalink = get_option('permalink');
	$jquery = get_option('jquery');
}


	?><div class="wrap"><div id="icon-plugins" class="icon32"></div><h2>Easing Slider</h2>
	
	<a href="http://premiumslider.matthewruddy.com"><img src="<?php echo WP_PLUGIN_URL.'/easing-slider/images/advert.jpg'; ?>" style="margin-top: 15px;"/></a>

	<?php if ( $_REQUEST['submit'] ) echo '<div id="message" class="updated" style="width:750px;"><p><strong>Slider Options Updated.</strong></p></div>'; ?>


	<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&updated=true">
		<input type="hidden" name="options" value="process" />

<?php

	print_easing_form();

	?></div><?php
}


function modify_menu() {
	add_menu_page(
	'Easing Slider',
	'Easing Slider',
	'administrator',
	'easing-slider/easingslider.php',
	'admin_easing'
	);
	
}

add_action('admin_menu','modify_menu');

function print_easing_form() {
	$sImg1 = get_option('sImg1');
	$sImg2 = get_option('sImg2');
	$sImg3 = get_option('sImg3');
	$sImg4 = get_option('sImg4');
	$sImg5 = get_option('sImg5');
	$sImg6 = get_option('sImg6');
	$sImg7 = get_option('sImg7');
	$sImg8 = get_option('sImg8');
	$sImg9 = get_option('sImg9');
	$sImg10 = get_option('sImg10');
	$sImglink1 = get_option('sImglink1');
	$sImglink2 = get_option('sImglink2');
	$sImglink3 = get_option('sImglink3');
	$sImglink4 = get_option('sImglink4');
	$sImglink5 = get_option('sImglink5');
	$sImglink6 = get_option('sImglink6');
	$sImglink7 = get_option('sImglink7');
	$sImglink8 = get_option('sImglink8');
	$sImglink9 = get_option('sImglink9');
	$sImglink10 = get_option('sImglink10');
	$sPagination = get_option('sPagination');
	$activation = get_option('activation');
	$width = get_option('width');
	$height = get_option('height');
	$shadow = get_option('shadow');
	$interval = get_option('interval');
	$transition = get_option('transition');
	$bgcolour = get_option('bgcolour');
	$transpeed = get_option('transpeed');
	$bwidth = get_option('bwidth');
	$bcolour = get_option('bcolour');
	$preload = get_option('preload');
	$start = get_option('start');
	$buttons = get_option('buttons');
	$source = get_option('source');
	$featcat = get_option('featcat');
	$featpost = get_option('featpost');
	$padbottom = get_option('padbottom');
	$padleft = get_option('padleft');
	$padright = get_option('padright');
	$paddingtop = get_option('paddingtop');
	$shadowstyle = get_option('shadowstyle');
	$paginationon = get_option('paginationon');
	$paginationoff = get_option('paginationoff');
	$next = get_option('next');
	$prev = get_option('prev');
	$pageposition = get_option('pageposition');
	$pageside = get_option('pageside');
	$permalink = get_option('permalink');
	$jquery = get_option('jquery');
	
	
	?>
	<div id="content-explorer">
	<ul class="yui-nav">
 		<li class="selected"><a href="#">Custom Images</a></li>
		<li><a href="#">Slider Settings</a></li>
		<li><a href="#">Usage Settings</a></li>
	</ul>
	
	<div class="metabox-holder" style="width:810px;">
  <input class="button-secondary" id="upload_image_button" type="button" value="Upload Image" />
	<input type="submit" class="button-primary" name="submit" value="Save Changes" style="" />
	<div style="display:inline;font-style:italic;font-size:11px;padding-left:10px;"><b>Important:</b> Click 'save changes' after every image you 'insert into post'. </div>
	</div>
		
<div class="yui-content">

  <div style="overflow: auto;"><!-- first div for content tabs -->
  <?php if($source!='custom') echo '<div id="message" style="padding:10px;margin:10px 0;border:1px solid #e6db55;background:#ffffe0;width:790px;"><strong>Custom Images are currently not enabled. To use them, change "Get Images From?" to "Custom Images" under the "Usage Settings" tab.</strong></div>'; ?>
	<div class="metabox-holder" style="width:402px;float:left;"><div class="postbox"><h3><span>Image #1 link:</span></h3>
	<?php if($sImg1) echo '<h4 style="margin:10px;">Preview:</h4><img src="'.$sImg1.'" style="margin:0 10px;width:380px;" />'; ?><h4 style="margin:10px;">Image Path:</h4><input type="text" <?php if(empty($sImg1)) echo 'id="upload_image"'; ?> name="sImg1" value="<?php echo stripslashes($sImg1); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
	<h4 style="margin:10px;">Image Link:</h4><input type="text" name="sImglink1" value="<?php echo stripslashes($sImglink1); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
	</div>
	
		<div class="postbox"><h3><span>Image #2 link:</span></h3>
		<?php if($sImg2) echo '<h4 style="margin:10px;">Preview:</h4><img src="'.$sImg2.'" style="width:380px;margin:0 10px;"  />'; ?><h4 style="margin:10px;">Image Path:</h4><input type="text" <?php if(isset($sImg1)&empty($sImg2)) echo 'id="upload_image"'; ?> name="sImg2" value="<?php echo stripslashes($sImg2); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?>style="width: 380px;margin:10px;margin-top:0px;" />
		<h4 style="margin:10px;">Image Link:</h4><input type="text" name="sImglink2" value="<?php echo stripslashes($sImglink2); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
    </div>
	
		<div class="postbox"><h3><span>Image #3 link:</span></h3>
		<?php if($sImg3) echo '<h4 style="margin:10px;">Preview:</h4><img src="'.$sImg3.'" style="width:380px;margin:0 10px;" />'; ?><h4 style="margin:10px;">Image Path:</h4><input type="text" <?php if(isset($sImg1)&isset($sImg2)&empty($sImg3)) echo 'id="upload_image"'; ?> id="sImg3" name="sImg3" value="<?php echo stripslashes($sImg3); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?>style="width: 380px;margin:10px;margin-top:0px;" />
		<h4 style="margin:10px;">Image Link:</h4><input type="text" name="sImglink3" value="<?php echo stripslashes($sImglink3); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
    </div>
	
		<div class="postbox"><h3><span>Image #4 link:</span></h3>
		<?php if($sImg4) echo '<h4 style="margin:10px;">Preview:</h4><img src="'.$sImg4.'" style="width:380px;margin:0 10px;" />'; ?><h4 style="margin:10px;">Image Path:</h4><input type="text" <?php if(isset($sImg1)&isset($sImg2)&isset($sImg3)&empty($sImg4)) echo 'id="upload_image"'; ?> name="sImg4" value="<?php echo stripslashes($sImg4); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?>style="width: 380px;margin:10px;margin-top:0px;" />
		<h4 style="margin:10px;">Image Link:</h4><input type="text" name="sImglink4" value="<?php echo stripslashes($sImglink4); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
    </div>

		<div class="postbox"><h3><span>Image #5 link:</span></h3>
		<?php if($sImg5) echo '<h4 style="margin:10px;">Preview:</h4><img src="'.$sImg5.'" style="width:380px;margin:0 10px;" />'; ?><h4 style="margin:10px;">Image Path:</h4><input type="text" <?php if(isset($sImg1)&isset($sImg2)&isset($sImg3)&isset($sImg4)&empty($sImg5)) echo 'id="upload_image"'; ?> name="sImg5" value="<?php echo stripslashes($sImg5); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?>style="width: 380px;margin:10px;margin-top:0px;" />
		<h4 style="margin:10px;">Image Link:</h4><input type="text" name="sImglink5" value="<?php echo stripslashes($sImglink5); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
    </div></div>

		<div class="metabox-holder" style="width:402px;float:left;margin-left:10px;"><div class="postbox"><h3><span>Image #6 link:</span></h3>
		<?php if($sImg6) echo '<h4 style="margin:10px;">Preview:</h4><img src="'.$sImg6.'" style="width:380px;margin:0 10px;" />'; ?><h4 style="margin:10px;">Image Path:</h4><input type="text" <?php if(isset($sImg1)&isset($sImg2)&isset($sImg3)&isset($sImg4)&isset($sImg5)&empty($sImg6)) echo 'id="upload_image"'; ?> name="sImg6" value="<?php echo stripslashes($sImg6); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?>style="width: 380px;margin:10px;margin-top:0px;" />
		<h4 style="margin:10px;">Image Link:</h4><input type="text" name="sImglink6" value="<?php echo stripslashes($sImglink6); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
    </div>

		<div class="postbox"><h3><span>Image #7 link:</span></h3>
		<?php if($sImg7) echo '<h4 style="margin:10px;">Preview:</h4><img src="'.$sImg7.'" style="width:380px;margin:0 10px;" />'; ?><h4 style="margin:10px;">Image Path:</h4><input type="text" <?php if(isset($sImg1)&isset($sImg2)&isset($sImg3)&isset($sImg4)&isset($sImg5)&isset($sImg6)&empty($sImg7)) echo 'id="upload_image"'; ?> name="sImg7" value="<?php echo stripslashes($sImg7); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?>style="width: 380px;margin:10px;margin-top:0px;" />
		<h4 style="margin:10px;">Image Link:</h4><input type="text" name="sImglink7" value="<?php echo stripslashes($sImglink7); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
    </div>

		<div class="postbox"><h3><span>Image #8 link:</span></h3>
		<?php if($sImg8) echo '<h4 style="margin:10px;">Preview:</h4><img src="'.$sImg8.'" style="width:380px;margin:0 10px;" />'; ?><h4 style="margin:10px;">Image Path:</h4><input type="text" <?php if(isset($sImg1)&isset($sImg2)&isset($sImg3)&isset($sImg4)&isset($sImg5)&isset($sImg6)&isset($sImg7)&empty($sImg8)) echo 'id="upload_image"'; ?> name="sImg8" value="<?php echo stripslashes($sImg8); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?>style="width: 380px;margin:10px;margin-top:0px;" />
		<h4 style="margin:10px;">Image Link:</h4><input type="text" name="sImglink8" value="<?php echo stripslashes($sImglink8); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
    </div>

		<div class="postbox"><h3><span>Image #9 link:</span></h3>
		<?php if($sImg9) echo '<h4 style="margin:10px;">Preview:</h4><img src="'.$sImg9.'" style="width:380px;margin:0 10px;" />'; ?><h4 style="margin:10px;">Image Path:</h4><input type="text" <?php if(isset($sImg1)&isset($sImg2)&isset($sImg3)&isset($sImg4)&isset($sImg5)&isset($sImg6)&isset($sImg7)&isset($sImg8)&empty($sImg9)) echo 'id="upload_image"'; ?> name="sImg9" value="<?php echo stripslashes($sImg9); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?>style="width: 380px;margin:10px;margin-top:0px;" />
		<h4 style="margin:10px;">Image Link:</h4><input type="text" name="sImglink9" value="<?php echo stripslashes($sImglink9); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
    </div>
	
		<div class="postbox"><h3><span>Image #10 link:</span></h3>
		<?php if($sImg10) echo '<h4 style="margin:10px;">Preview:</h4><img src="'.$sImg10.'" style="width:380px;margin:0 10px;" />'; ?><h4 style="margin:10px;">Image Path:</h4><input type="text" <?php if(isset($sImg1)&isset($sImg2)&isset($sImg3)&isset($sImg4)&isset($sImg5)&isset($sImg6)&isset($sImg7)&isset($sImg8)&isset($sImg9)&empty($sImg10)) echo 'id="upload_image"'; ?> name="sImg10" value="<?php echo stripslashes($sImg10); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?>style="width: 380px;margin:10px;margin-top:0px;" />
		<h4 style="margin:10px;">Image Link:</h4><input type="text" name="sImglink10" value="<?php echo stripslashes($sImglink10); ?>" <?php if($source!='custom') echo 'readonly="readonly"';?> style="width: 380px;margin:10px;margin-top:0px;"/>
    </div></div>
		
	</div>
	<div><!-- second div for content tabs -->
		
	<div class="metabox-holder" style="width: 815px;">
	<div class="postbox">

		<table class="form-table" style="margin:0;">
		<tr valign="top"><td style="padding:0;width:180px;"><h3>Name</h3></td><td style="padding:0;width:130px;"><h3>Value</h3></td><td style="padding:0;"><h3>Description</h3></td></tr>

		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="shadow" style="padding:10px;font-weight:bold;">disableShadow</label></td>
		<td style="padding:5px 0;margin-left:5px;"><input type="checkbox" name="shadow" <?php if (get_option('shadow')) echo "checked='checked'"; ?>/>Disable</td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Disable the shadow beneath the slider.</p></td></tr>
		
		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="shadowtype" style="padding:10px;font-weight:bold;">shadowStyle:
		<td style="padding:5px 0;margin-left:5px;"><select name="shadowstyle" style="width:110px;">
			<option style="padding-right:10px;" value="arc" <?php selected('arc', get_option('shadowstyle')); ?>>Arc</option>
			<option style="padding-right:10px;" value="large" <?php selected('large', get_option('shadowstyle')); ?>>Large</option>
			<option style="padding-right:10px;" value="small" <?php selected('small', get_option('shadowstyle')); ?>>Small</option>
		</select></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Choose between three different types of shadow beneath the slider.</p></td></tr>

		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="buttons" style="padding:10px;font-weight:bold;">next/prevButtons</td></label>
		<td style="padding:5px 0;margin-left:5px;"><input type="checkbox" name="buttons" <?php if (get_option('buttons')) echo "checked='checked'"; ?>/>Enable</td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Enable the "next" and "previous" buttons. By default these are disabled.</p></td></tr>

    <tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="next" style="padding:10px;font-weight:bold;">nextbuttonIcon</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="next" <?php if(empty($_REQUEST['buttons'])) {echo 'readonly="readonly"';}?> value="<?php echo ($next); ?>" style="width: 100px;" /><?php if($next!='') echo '<img src="'.$next.'" width="20px" style="position:relative;top:5px;padding-left:5px;" />';?></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">change the icon used for the 'next' button. If left blank, it will use the default image.</p></td></tr>
    
    <tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="prev" style="padding:10px;font-weight:bold;">prevbuttonIcon</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="prev" <?php if(empty($_REQUEST['buttons'])) {echo 'readonly="readonly"';}?> value="<?php echo ($prev); ?>" style="width: 100px;" /><?php if($prev!='') echo '<img src="'.$prev.'" width="20px" style="position:relative;top:5px;padding-left:5px;" />';?></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Change the icon used for the 'prev' button. If left blank, it will use the default image.</p></td></tr>
		
		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="width" style="padding:10px;font-weight:bold;">Slider "width"</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="width" value="<?php echo ($width); ?>" style="width: 50px;" />px</td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Set the sliders width.</p></td></tr>

		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="height" style="padding:10px;font-weight:bold;">Slider "height"</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="height" value="<?php echo ($height); ?>" style="width: 50px;" />px</td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Set the sliders height.</p></td></tr>
		
		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="padbottom" style="padding:10px;font-weight:bold;">paddingBottom</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="padbottom" value="<?php echo ($padbottom); ?>" style="width: 50px;" />px</td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Amount of padding to add to the bottom of the slider.</p></td></tr>
		
		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="paddingtop" style="padding:10px;font-weight:bold;">paddingTop</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="paddingtop" value="<?php echo ($paddingtop); ?>" style="width: 50px;" />px</td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Amount of padding to add to the top of the slider.</p></td></tr>
		
		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="padright" style="padding:10px;font-weight:bold;">paddingRight</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="padright" value="<?php echo ($padright); ?>" style="width: 50px;" />px</td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Amount of padding to add to the right of the slider.</p></td></tr>
		
    <tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="padleft" style="padding:10px;font-weight:bold;">paddingLeft</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="padleft" value="<?php echo ($padleft); ?>" style="width: 50px;" />px</td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Amount of padding to add to the left of the slider.</p></td></tr>
		
		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="bgcolour" style="padding:10px;font-weight:bold;">backgroundColour:</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="bgcolour" value="<?php echo $bgcolour; ?>" style="width: 50px;" /></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Change the sliders background colour. When left blank it is set to white in order for the preloader to function correctly.</p></td></tr>

		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="start" style="padding:10px;font-weight:bold;">startPosition:</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="start" value="<?php echo ($start); ?>" style="width: 50px;" /></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Number of the image that the slider will start with. Choose a number between one and ten.</p></td></tr>

<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="transpeed" style="padding:10px;font-weight:bold;">transitionSpeed:</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="transpeed" value="<?php echo $transpeed; ?>" style="width: 50px;" /></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Amount of time it takes to transition one image to another.</p></td></tr>


		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="interval" style="padding:10px;font-weight:bold;">autoPlay:</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="interval" value="<?php echo $interval; ?>" style="width: 50px;" /></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">The amount of time in milliseconds each image is displayed for.</p></td></tr>

    <tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="transition" style="padding:10px;font-weight:bold;">animationStyle:
		<td style="padding:5px 0;margin-left:5px;"><select name="transition" style="width:110px;">
			<option style="padding-right:10px;" value="slide" <?php selected('slide', get_option('transition')); ?>>slide</option>
			<option style="padding-right:10px;" value="smooth" <?php selected('smooth', get_option('transition')); ?>>smooth</option>
			<option style="padding-right:10px;" value="fade" <?php selected('fade', get_option('transition')); ?>>fade</option>
			<option style="padding-right:10px;" value="swipe" <?php selected('swipe', get_option('transition')); ?>>swipe</option>
			<option style="padding-right:10px;" value="bounce" <?php selected('bounce', get_option('transition')); ?>>bounce</option>
		</select></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Easing effect used to transition from each image. Choose from five different effect: slide, smooth, fade, swipe & bounce.</p></td></tr>

		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="bwidth" style="padding:10px;font-weight:bold;">borderWidth:</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="bwidth" value="<?php echo $bwidth; ?>" style="width: 50px;" />px</td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Width of the sliders surrounding border. Set to "0" for no border.</p></td></tr>

<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="bcolour" style="padding:10px;font-weight:bold;">borderColour:</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="bcolour" value="<?php echo $bcolour; ?>" style="width: 50px;" /></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Colour of the surrounding border.</p></td></tr>

	<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="preload" style="padding:10px;font-weight:bold;">preloadIcon:</label></td>
		<td style="padding:5px 0;margin-left:5px;"><select name="preload" style="width:110px;">
			<option style="padding-right:10px;" value="none" <?php selected('none', get_option('preload')); ?>>none</option>
			<option style="padding-right:10px;" value="indicator" <?php selected('indicator', get_option('preload')); ?>>indicator</option>
	<option style="padding-right:10px;" value="arrows" <?php selected('arrows', get_option('preload')); ?>>arrows</option>
	<option style="padding-right:10px;" value="bar" <?php selected('bar', get_option('preload')); ?>>bar</option>
	<option style="padding-right:10px;" value="bigflower" <?php selected('bigflower', get_option('preload')); ?>>bigflower</option>
	<option style="padding-right:10px;" value="bounceball" <?php selected('bounceball', get_option('preload')); ?>>bounceball</option>
	<option style="padding-right:10px;" value="indicatorlight" <?php selected('indicatorlight', get_option('preload')); ?>>indicatorlight</option>
	<option style="padding-right:10px;" value="pik" <?php selected('pik', get_option('preload')); ?>>pik</option>
	<option style="padding-right:10px;" value="snake" <?php selected('snake', get_option('preload')); ?>>snake</option>
		</select></td>

		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Animation displayed while slider is loading. Choose between eight different options or set to "none" for no image.</p></td></tr>

		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="sPagination" style="padding:10px;font-weight:bold;">pagination:</label></td>
		<td style="padding:5px 0;margin-left:5px;"><select name="sPagination" style="width:110px;">
			<option style="padding-right:10px;" value="yes" <?php selected('yes', get_option('sPagination')); ?>>Yes</option>
			<option style="padding-right:10px;" value="no" <?php selected('no', get_option('sPagination')); ?>>No</option>
		</select></td>

		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Icons acting as links for each individual image.</p></td></tr>
		
		<tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="pageposition" style="padding:10px;font-weight:bold;">paginationPosition:</label></td>
			<td style="padding:5px 0;margin-left:5px;"><select name="pageposition" style="width:110px;">
			<option style="padding-right:10px;" value="outside" <?php selected('outside', get_option('pageposition')); ?>>Outside</option>
			<option style="padding-right:10px;" value="inside" <?php selected('inside', get_option('pageposition')); ?>>Inside</option>
		</select><br /><select name="pageside" style="width:110px;">
			<option style="padding-right:10px;" value="left" <?php selected('left', get_option('pageside')); ?>>Left</option>
			<option style="padding-right:10px;" value="right" <?php selected('right', get_option('pageside')); ?>>Right</option>
		</select></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Choose whether the pagination will be displayed inside the slider or outside of it. Also select whether it will appear on the left or right.</p></td></tr>
		
		
	
    <tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="paginationon" style="padding:10px;font-weight:bold;">paginationIcon (on):</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="paginationon" <?php if($sPagination=='no') echo 'readonly="readonly"';?> value="<?php echo $paginationon; ?>" style="width: 100px;" /><?php if($paginationon!='') echo '<img src="'.$paginationon.'" style="position:relative;top:5px;padding-left:5px;" />';?></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Insert the selected version here of your custom pagination icon here.</p></td></tr>
		
    <tr valign="top" style="border-bottom:1px solid #ccc;"><td style="padding:5px 0;"><label for="paginationoff" style="padding:10px;font-weight:bold;">paginationIcon (off):</label></td>
			<td style="padding:5px 0;margin-left:5px;"><input type="text" name="paginationoff" <?php if($sPagination=='no') echo 'readonly="readonly"';?> value="<?php echo $paginationoff; ?>" style="width: 100px;" /><?php if($paginationoff!='') echo '<img src="'.$paginationoff.'" style="position:relative;top:5px;padding-left:5px;" />';?></td>
		<td style="margin:5px 0;"><p style="margin:0;margin-left:10px;font-style:italic;font-size:11px;">Use your own custom pagination icons. Insert the unselected version here.</p></td></tr>
	
		</table></div></div>
  </div>
	<div><!--third div for content tabs -->
	<div class="metabox-holder" style="width:815px;">
	<div class="postbox">
	<table class="form-table" style="margin:0;">
	<tr valign="top"><td style="padding:0;width:180px;"><h3>Name</h3></td><td style="padding:0;width:235px;"><h3>Value</h3></td><td style="padding:0;"><h3>Description</td></h3></tr>
	<tr valign="top" style="border-bottom:1px solid #ccc;">
	<td  style="padding:5px 0;">
     <label for="activation" style="padding:10px;font-weight:bold;">Activate Plugin</label>
  </td>
  <td style="padding:5px 0;">
			<?php if($activation == 'enable') { ?>
			<input type="radio" checked="checked" value="enable" name="activation">Enable
			<br />
			<input type="radio" value="disable" name="activation">Disable
			<?php } else { ?>
			<input type="radio" value="enable" name="activation">Enable
			<br />
			<input type="radio" checked="checked" value="disable" name="activation">Disable
			<?php } ?>
	</td>
	<td  style="margin:5px 0;">
	<p style="margin:0;font-style:italic;font-size:11px;">
	Enable or disable the slider.
	</p>
	</td>
	</tr>
	
	<tr valign="top" style="border-bottom:1px solid #ccc;">
			<td  style="padding:5px 0;">
        <label for="source" style="padding:10px;font-weight:bold;">Load jQuery?</label>
      </td>
      <td  style="padding:5px 0;">
        <select name="jquery" style="width:235px;">
          <option value="true" <?php selected('true', get_option('jquery')); ?>>True</option>
          <option value="false" <?php selected('false', get_option('jquery')); ?>>False</option>
        </select>
      </td>	
      <td  style="padding:5px 0;">
      <p style="margin:0 10px;font-style:italic;font-size:11px;">
      Choose if the slider should load jQuery. Setting this to 'false' may fix jQuery conflict errors that are breaking the slider.
      </p>
      </td>
      </tr>
			
	<tr valign="top" style="border-bottom:1px solid #ccc;">
	<td  style="padding:5px 0;">
  <label for="permalink" style="padding:10px;font-weight:bold;">Permalinks</label>
  </td>
  <td style="padding:5px 0;">
			<input type="checkbox" name="permalink" <?php if (get_option('permalink')) echo "checked='checked'"; ?>/>Disable
	</td>
	<td  style="margin:5px 0;">
	<p style="margin:0;font-style:italic;font-size:11px;">
	Check this box to disable the permalinks on images sourced from posts (custom fields).
	</p>
	</td>
	</tr>
			
			<tr valign="top" style="border-bottom:1px solid #ccc;">
			<td  style="padding:5px 0;">
        <label for="source" style="padding:10px;font-weight:bold;">Get Images From?</label>
      </td>
      <td  style="padding:5px 0;">
        <select name="source" style="width:235px;">
          <option value="featured" <?php selected('featured', get_option('source')); ?>>Custom Fields (Selected Category)</option>
          <option value="all" <?php selected('all', get_option('source')); ?>>Custom Fields (All Categories)</option>
          <option value="custom" <?php selected('custom', get_option('source')); ?>>Custom Images</option>
        </select>
      </td>	
      <td  style="padding:5px 0;">
      <p style="margin:0 10px;font-style:italic;font-size:11px;">
      Here you can select the source from which the images are displayed. </p><p style="margin:10px;font-style:italic;font-size:11px;">Select 'Custom Fields' if you wish to get the images from custom fields. To do so, enter 'easing' under name field & and the URL of the chosen image under the value field. </p><p style="margin:10px;font-style:italic;font-size:11px;"> Otherwise, you can choose to display 'custom' images. These images can be uploaded in the 'Custom Images' section where you can specify links to images from the Media Library or elsewhere. </p><p style="margin:10px;font-style:italic;font-size:11px;">By default, this option is set to 'Custom Fields (Selected Category)'.
      </p>
      </td>
      </tr>
      
      <tr valign="top" style="border-bottom:1px solid #ccc;">
      <td  style="padding:5px 0;">
        <label for="featcat" style="padding:10px;font-weight:bold;">Selected Category:</label>
      <td  style="padding:5px 0;"><style type="text/css">.cat_select{width:235px;};</style>
        <?php wp_dropdown_categories(array('hide_empty' => 0, 'class' => 'cat_select', 'name' => 'featcat', 'orderby' => 'name', 'selected' => get_option('featcat'), 'hierarchical' => true,));?>
      </td>
      <td style="padding:5px 0;">
      <p style="margin:10px;margin-top:0;font-style:italic;font-size:11px;">
      Here you can select which categorie's post thumbnails you wish to display if you have selected the 'Post thumbnails (Selected Category)' option above.
      </p>
      </tr>
      
      <tr valign="top">
      <td  style="padding:5px 0;">
        <label for="featpost" style="padding:10px;font-weight:bold;">Number of Posts:</label>
      </td>
      <td  style="padding:5px 0;"">
          <input type="text" id="test" style="width:50px;" name="featpost" value="<?php echo $featpost; ?>" <?php if($source=='custom') echo 'readonly="readonly"'; ?> />
      </td>
      <td style="padding:5px 0;">
      <p style="margin:0 10px;font-style:italic;font-size:11px;">
      Number of post thumbnails to be displayed in the slider. No matter how high you set it, the slider will display a maximum of 10 images. </p></tr>
      </table>
      </div></div></div>
      </div><!-- #yui-content -->
      </div><!-- #content-explorer -->
	
		</form>

<script type="text/javascript">
	var myTabs = new YAHOO.widget.TabView("content-explorer");
	</script>
<?php }
