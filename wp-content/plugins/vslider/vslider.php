<?php
/*
    Plugin Name: vSlider
    Plugin URI: http://www.Vibethemes.com/vslider-wordpress-image-slider-plugin/
    Description: Implementing a featured image gallery into your WordPress theme has never been easier! Showcase your portfolio, animate your header or manage your banners with vSlider.Create unlimited image sliders, the best wordpress image slider plugin vSlider by  <a href="http://www.vibethemes.com/" title="premium wordpress themes">VibeThemes</a>.
    Author: Mr.Vibe
    Version: 4.1.1
    Author URI: http://www.Vibethemes.com/

	vSlider is released under GPL:
	http://www.opensource.org/licenses/gpl-license.php
*/
//=====:: This is Awesomenewss from MR.Vibe at VibeThemes.com ::=====//
//  If not defined, define the path to wp-conder dir
if (!defined('WP_CONTENT_URL')) {
	define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
}

function get_vsliders()
{
    global $wpdb;$num=1;
	$table_name = $wpdb->prefix . "vslider"; 
    $vslider_data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id");
    foreach ($vslider_data as $data) { 
        
        if($data->active == 1)
        { $active='<a href="?page=vslider&deactivate='.$data->id.'" class="button">Deactivate</a>';
          
        }
        else {
            $active='<a href="?page=vslider&activate='.$data->id.'" class="button">Activate</a>';
            $disabled='disabled="disabled"';
            }
        
       echo '<tr style="height:40px;"><td style="width: 100px;text-align:center;padding: 10px;" >'.$data->id.'</td><td style="width: 100px;text-align:center;padding: 10px;" valign="middle"> '.$data->option_name.' </td><td style="width: 100px;text-align:center;padding: 10px;" >
       <a href="?page=add-vSlider&edit='.$data->option_name.'" class="button" '.$disabled.'>Edit</a>        
       </td><td style="width: 100px;text-align:center;padding: 10px;"> '.$active.' </td>
       <td style="width: 100px;text-align:center;padding: 10px;" > <a href="?page=vslider&delete='.$data->option_name.'" class="button">Delete</a> </td></tr>';
         $num++;}
         ?>
       <form method="post" action="?page=vslider&add=1">
       <tr style="height:60px;"> <td style="width: 100px;text-align:center;padding: 20px;"><?php echo ($data->id+1); ?> </td>
       <td style="padding: 20px;" colspan="2"><input type="text" id="option_name" name="option_name" size="70" />
       <font style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;* Do not use spaces, numbers or special characters in the name.</font>
       </td>
       <td style="width: 100px;text-align:center;padding: 20px;" colspan="2"><input type="submit" class="button-primary" style="padding: 10px 30px 10px 30px;" value="Add new vSlider" />  </td>
       </tr>
       </form>
       <?php
}

// Add thickbox to upload images
if ( $_GET['page'] == 'vslider' ) {
    add_action('admin_init', 'vslider_a_scripts');
}
if ( $_GET['page'] == 'add-vSlider' ) {
    add_action('admin_init', 'vslider_admin_scripts');
    add_action('admin_print_styles', 'vslider_admin_styles');
}

if ( $_GET['page'] == 'vslider-tutorials' ) {
    add_action('admin_init', 'vslider_tutorial_scripts');
    add_action('admin_print_styles', 'vslider_tutorial_styles');
}

if ( $_GET['page'] == 'vslider-themes' ) {
    add_action('admin_init', 'vslider_theme_scripts');
    add_action('admin_print_styles', 'vslider_theme_styles');
}

if($_POST['uninstallvslider']){
    vslider_plugin_uninstall();
    }

//Scripts to be loaded in the vSlider admin Panel
function vslider_admin_scripts() {
    wp_enqueue_script  ('media-upload');
    wp_enqueue_script  ('thickbox');
    wp_register_script ('vslider-upload', WP_CONTENT_URL.'/plugins/vslider/js/upload.js', array('jquery','media-upload', 'thickbox'));
    wp_enqueue_script  ('vslider-upload');
    wp_register_script ( 'colorpicker-js', WP_CONTENT_URL.'/plugins/vslider/picker/colorpicker.js', array('jquery'));
    wp_enqueue_script  ('colorpicker-js' );
    wp_register_script ( 'custom-js', WP_CONTENT_URL.'/plugins/vslider/js/custom.js', array('jquery'));
    wp_enqueue_script  ('custom-js' );
   }
function vslider_a_scripts() {
    wp_register_script ( 'a-js', WP_CONTENT_URL.'/plugins/vslider/js/main.js', array('jquery'));
    wp_enqueue_script  ('a-js' );
}
function vslider_tutorial_scripts() {
    wp_register_script ( 'tutorials-js', WP_CONTENT_URL.'/plugins/vslider/js/tutorials.js', array('jquery'));
    wp_enqueue_script  ('tutorials-js' );
}    
function vslider_theme_scripts() {
    wp_register_script ( 'themes-js', WP_CONTENT_URL.'/plugins/vslider/js/themes.js', array('jquery'));
    wp_enqueue_script  ('themes-js' );
} 
//Styles to be loaded in the vSlider admin Panel
function vslider_admin_styles() {
    wp_enqueue_style('thickbox');
    wp_register_style('colorpicker-css', WP_CONTENT_URL.'/plugins/vslider/picker/colorpicker.css');
    wp_enqueue_style( 'colorpicker-css');
    wp_register_style('tooltip-css', WP_CONTENT_URL.'/plugins/vslider/css/tooltip.css');
    wp_enqueue_style( 'tooltip-css');
}
function vslider_tutorial_styles() {
    wp_register_style('tutorials-css', WP_CONTENT_URL.'/plugins/vslider/css/tutorials.css');
    wp_enqueue_style( 'tutorials-css');
    }
function vslider_theme_styles() {
    wp_register_style('themes-css', WP_CONTENT_URL.'/plugins/vslider/css/themes.css');
    wp_enqueue_style( 'themes-css');
    }

add_action('wp_print_scripts', 'vslider_head_scripts');

// ADD VSLIDER JS TO THEME HEAD SECTION
function vslider_head_scripts() {
    wp_enqueue_script ('jquery'); 
	wp_enqueue_script('vslider', WP_CONTENT_URL.'/plugins/vslider/js/vslider.js', $deps = array('jquery'));
}

// ADD VSLIDER HEAD STYLES
function vslider_head($option) { 
    $options = get_option($option); ?>
<!-- Start vSlider options -->
<script type="text/javascript">
var $jq = jQuery.noConflict(); $jq(document).ready(function() { 
    $jq('#<?php echo $option; ?>').coinslider({ width: <?php echo $options['width']; ?>,     height: <?php echo $options['height']; ?>, spw: <?php echo $options['spw']; ?>, sph: <?php echo $options['sph']; ?>, delay: <?php echo $options['delay']; ?>, sDelay: <?php echo $options['sDelay']; ?>, opacity: <?php echo $options['opacity']; ?>, titleSpeed: <?php echo $options['titleSpeed']; ?>, effect: '<?php echo $options["effect"]; ?>', navigation: <?php echo $options['navigation']; ?>, links : <?php echo $options['links']; ?>, stickynav: <?php echo $options['stickynav']; ?>, hoverPause: <?php echo $options['hoverPause']; ?> }); }); 
    </script>
<style type="text/css" media="screen">
#<?php echo $option; ?>container {
    margin: <?php echo $options['holdermar']; ?>;
    float:<?php echo $options['holderfloat']; ?>;
    }
#<?php echo $option; ?> { 
    width: <?php echo $options['width']; ?>px; 
    height: <?php echo $options['height']; ?>px;
    overflow: hidden; 
    position: relative; 
    }
    

    #<?php echo $option; ?> a, #<?php echo $option; ?> a img {
        border: none !important; 
        text-decoration: none !important; 
        outline: none !important;
        } 
        
    #<?php echo $option; ?> h4 {
        color: #<?php echo $options['textColor']; ?> !important;
        margin: 0px !important;padding: 0px !important;
        font-family: <?php echo $options['fontFamily']; ?> !important;
        font-size: <?php echo $options['titleFont']; ?>px !important;}
        
    #<?php echo $option; ?> .cs-title {
        background: #<?php echo $options['bgColor']; ?>;
        color: #<?php echo $options['textColor']; ?>  !important;
        font-family: <?php echo $options['fontFamily']; ?> !important;
        font-size: <?php echo $options['fontSize']; ?>px !important;
        letter-spacing: normal !important;line-height: normal !important;}
        
    #<?php echo $option; ?> .cs-title{ position:absolute;
    <?php switch($options['layout']){
            case 'stripe-top':{
                echo 'top:0px; height: '.($options['height']/2 -50).'px;width: '.($options['width']-$options['borderWidth']+10).'px; padding: 10px 10px 10px 10px;overflow:hidden;';
                break;
            }
            case 'stripe-right':{ $width=$options['width']/3+$options['borderWidth']-10;
                echo 'margin-left: '.($options['width']-$width).'px;top: 0px;width: '.($width).'px; padding: 10px 10px 0px 10px;';
                break;
            }
            case 'stripe-bottom':{
                          echo 'width: '.($options['width']-$options['borderWidth']-10).'px; padding: 10px;'; 
                break;
            }
            case 'stripe-left':{
                echo 'left:0px;top: 0px;width: '.($options['width']/3+$options['borderWidth']-10).'px; padding: 10px 10px 0px 10px;';
                break;
            }
        }
        ?>
        }
    <?php 
    if($options['buttons'] == 'false')
    {
        echo '#cs-buttons-'.$option.' { display: none; }';
    } 
     ?>
    #<?php echo $option; ?>container .cs-buttons {clear:both; font-size: 0px; margin: <?php echo $options['navplace']; ?>; float: left; }
       #cs-button-<?php echo $option; ?>{ z-index:999;outline:none;}
     <?php
     switch ($options['navstyle']){
        case 'nav_small':  { ?>
       #<?php echo $option; ?>container .cs-buttons { font-size: 0px; margin: 8px 0 0 8px;padding: 8px 8px 8px 5px; float: left; 
                                             background: #dfdfdf;
                                              -webkit-border-radius: 5px;
                                              -moz-border-radius: 5px;
                                              border-radius: 5px;
                                              outline: none !important;
                                            }
                              #<?php echo $option; ?>container .cs-buttons a { margin-left: 5px; height: 5px; width: 5px; float: left; 
                                               background: #<?php echo $options['bgColor']; ?>;
                                               text-indent: -1000px;
                                               -webkit-border-radius: 5px;
                                                -moz-border-radius: 5px;
                                                border-radius: 5px;
                                                outline: none !important;
                                                <?php if($options['vnavenable'])
                                                {
                                                    echo "clear: both;margin-bottom:5px;";
                                                }  ?>
                                                }              
                             #<?php echo $option; ?>container   a.cs-active { background-color: #<?php echo $options['textColor']; ?>; outline: none !important;}          
            <?php break;
        }
        case 'nav_style1':  { ?>
                            #<?php echo $option; ?>container   .cs-buttons a { margin-left: 5px; height: 16px; width: 15px; float: left; 
                                               text-indent: -999px;
                                               background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style1.png') no-repeat;
                                               background-position: left;
                                               outline: none !important;
                                               <?php if($options['vnavenable'])
                                                {
                                                    echo "clear: both;margin-bottom:5px;";
                                                }  ?>
                                               }             
                              #<?php echo $option; ?>container   .cs-buttons a:hover,
 #<?php echo $option; ?>container a.cs-active { background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style1.png') no-repeat;background-position: right; outline: none !important;}          
            <?php break;
        }
        
        case 'nav_style2':  { ?>
                             #<?php echo $option; ?>container  .cs-buttons a { margin-left: 5px; height: 15px; width: 15px; float: left; 
                                               text-indent: -999px; background: #dfdfdf;
                                               border: 5px solid #c6c6c6; 
                                               text-indent: -1000px; 
                                               outline: none !important;
                                               opacity:0.7;filter:alpha(opacity=70);
                                                -webkit-border-radius: 15px;
                                                -moz-border-radius: 15px;
                                                border-radius: 15px;
                                               <?php if($options['vnavenable'])
                                                {
                                                    echo "clear: both;margin-bottom:5px;";
                                                }  ?>
                                               }             
                                 
                              #<?php echo $option; ?>container   .cs-buttons a:hover  { background: #efefef; border-color: #444;outline: none !important;}
                              #<?php echo $option; ?>container   a.cs-active { background: #efefef; border-color: #444; outline: none !important;}          
            <?php break;
        }
        
        case 'nav_style3':  { ?>
                              #<?php echo $option; ?>container .cs-buttons a { margin-left: 5px; height: 33px; width: 33px; float: left; 
                                               text-indent: -999px;
                                               background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_2.png') no-repeat;
                                               outline: none !important;
                                              <?php if($options['vnavenable'])
                                                {
                                                    echo "clear: both;margin-bottom:5px;";
                                                }  ?> 
                                               }             
                               #<?php echo $option; ?>container  .cs-buttons a:hover,
 #<?php echo $option; ?>container a.cs-active { background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_2_active.png') no-repeat; outline: none !important;}          
            <?php break;
        }
        
        case 'nav_style4':  { ?>
                             #<?php echo $option; ?>container  .cs-buttons a { margin-left: 5px; height: 12px; width: 12px; float: left; 
                                               background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style4.png') no-repeat;
                                               background-position: left;
                                               outline: none !important;
                                              <?php if($options['vnavenable'])
                                                {
                                                    echo "clear: both;margin-bottom:5px;";
                                                }  ?>
                                               }             
                              #<?php echo $option; ?>container   .cs-buttons a:hover,
 #<?php echo $option; ?>container a.cs-active { background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style4.png') no-repeat;background-position: right; outline: none !important;}          
            <?php break;
        }
        case 'nav_style5':  { ?>
                              #<?php echo $option; ?>container .cs-buttons a { margin-left: 5px; height: 14px; width: 14px; float: left; 
                                               background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style5.png') no-repeat;
                                               background-position: top;
                                               outline: none !important;
                                              <?php if($options['vnavenable'])
                                                {
                                                    echo "clear: both;margin-bottom:5px;";
                                                }  ?>
                                               }             
                               #<?php echo $option; ?>container .cs-buttons a:hover,
 #<?php echo $option; ?>container a.cs-active { background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style5.png') no-repeat;background-position: bottom; outline: none !important;}          
            <?php break;
        }
        
        default: { ?>
           #<?php echo $option; ?>container .cs-buttons { font-size: 0px; padding: 10px; float: left; outline: none !important;}
           #<?php echo $option; ?>container .cs-buttons a { margin-left: 5px; height: 15px; width: 15px; float: left; 
                            background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/default_style.png') no-repeat;background-position:top;
                                                text-indent: -1000px;
                                                outline: none !important;
                            <?php if($options['vnavenable'])
                                                {
                                                    echo "clear: both;margin-bottom:5px;";
                                                }  ?> }
             #<?php echo $option; ?>container .cs-buttons a:hover  { background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/default_style.png') no-repeat;background-position: bottom;top:15px;outline: none !important;}
            #<?php echo $option; ?>container  a.cs-active { background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/default_style.png') no-repeat;background-position:bottom;outline: none !important;}          
                                
        
            <?php
        }
     }
     ?>
     #<?php echo $option; ?>  .cs-prev,#<?php echo $option; ?>  .cs-next { outline:none; }
     <?php
switch($options['arrstyle']){
    case 'arr_style1':{ ?>
      #<?php echo $option; ?>  .cs-prev {margin-left:8px; line-height: 50px;width: 50px;height:50px; background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style1_arrows-prev.png')no-repeat; text-indent: -999px;}
      #<?php echo $option; ?>  .cs-next {margin-right: 5px; line-height: 50px;width: 50px;height:50px; background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style1_arrows-next.png')no-repeat; text-indent: -999px;}
        <?php break;
    }
    case 'arr_style2':{?>
      #<?php echo $option; ?>  .cs-prev {margin-left:8px; line-height: 30px;width: 30px;height:30px; background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style2_arrows-prev.png')no-repeat; text-indent: -999px;}
      #<?php echo $option; ?>  .cs-next {margin-right: 5px; line-height: 30px;width: 30px;height:30px; background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style2_arrows-next.png')no-repeat; text-indent: -999px;}
    <?php       
        break;
    }
    case 'arr_style3':{ ?>
          #<?php echo $option; ?>  .cs-prev {margin-left:8px; line-height: 50px;width: 50px;height:50px; background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style3_arrows-prev.png')no-repeat; text-indent: -999px;}
          #<?php echo $option; ?>  .cs-next {margin-right: 5px; line-height: 50px;width: 50px;height:50px; background: url('<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/nav_style3_arrows-next.png')no-repeat; text-indent: -999px;}
    <?php
        break;
    }
    default:{?>
           #<?php echo $option; ?>  .cs-prev,#<?php echo $option; ?> .cs-next {font-weight: bold;background: #<?php echo $options['bgColor']; ?> !important;font-size: 28px !important;font-family: "Courier New", Courier, monospace;color: #<?php echo $options['textColor']; ?> 
!important;padding: 0px 10px !important;-moz-border-radius: 5px;-khtml-border-radius: 5px;-webkit-border-radius: 5px;}
    <?php }
}
     ?>
     
       #<?php echo $option; ?>,#<?php echo $option; ?> img {
        border:<?php echo $options['borderWidth']; ?>px solid #<?php echo $options['borderColor']; ?>; 
        border-radius:<?php echo $options['borderRadius']; ?>px;
        -moz-border-radius:<?php echo $options['borderRadius']; ?>px;
        -webkit-border-radius:<?php echo $options['borderRadius']; ?>px;
        }
</style>
<!-- End vSlider options -->
<?php }

// ENABLE SUPPORT FOR POST THUMBNAILS
if ( function_exists('add_theme_support') ) {
	add_theme_support('post-thumbnails');
}


// Let's set the default values
function vslider_defaults() {
    $default = array(
        'slideNr' => 3,
    	'width' => 630,
    	'height' => 280,
    	'spw' => 7,
    	'sph' => 5,
    	'delay' => 3000,
    	'sDelay' => 30,
    	'opacity' => '0.7',
    	'titleSpeed' => 1500,
    	'effect' => '',
    	'navigation' => 'true',
        'stickynav' => 'false',
    	'links' => 'true',
        'buttons' => 'true',
    	'hoverPause' => 'false',
    	'fontFamily' => 'Arial, Helvetica, sans-serif',
    	'titleFont' => 16,
    	'fontSize' => 12,
    	'textColor' => 'FFFFFF',
    	'bgColor' => '222222',
    	'customImg' => 'true',
        'catchimage' => 'true',
    	'chars' => 200,
    	'excerpt' => 'true',
    	'slide1' => WP_CONTENT_URL.'/plugins/vslider/images/slide1.jpg',
    	'slide2' => WP_CONTENT_URL.'/plugins/vslider/images/slide2.jpg',
    	'slide3' => WP_CONTENT_URL.'/plugins/vslider/images/slide3.jpg',
        'target' => 'none',
        'navstyle' => 'none',
        'arrstyle' => 'none',
        'navplace' => '10px 0 10px 100px',
        'layout' => 'stripe-bottom',
        'borderWidth' => '5',
        'borderRadius' => '0',
        'borderColor' => 'FFFFFF',
        'holdermar' => '10px 10px 10px 10px',
        'holderfloat' => 'none',
        'timthumb' => 1,
        'quality' => '80',
        'vnavenable' => 0,
        'randimg' => 0
    );
return $default;
}

// Runs when plugin is activated and creates new database field
register_activation_hook(__FILE__,'vslider_plugin_install');
function vslider_plugin_install() {
    add_option('vslider_options', vslider_defaults());
    add_option('vslider_support', 0);
    vslider_install();
    global $wpdb;
	$table_name = $wpdb->prefix . "vslider"; 
    $sql = "INSERT IGNORE INTO " . $table_name . " values ('','vslider_options','1');";
    $wpdb->query( $sql );
}

//vSlider Table
function vslider_install(){
    global $wpdb;
	$table_name = $wpdb->prefix . "vslider"; 
    
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  option_name VARCHAR(255) NOT NULL DEFAULT  'vslider_options',
		  active tinyint(1) NOT NULL DEFAULT  '0',
		  PRIMARY KEY (`id`),
          UNIQUE (
                    `option_name`
            )
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

}

// Runs on plugin deactivation and deletes the database field
//register_deactivation_hook( __FILE__, 'vslider_plugin_remove' );

function vslider_uninstall(){
  if($_POST['uninstallvslider']){
echo '<div class="wrap"><div id="message" class="updated fade">';
    echo '<p><h2> vSlider Successfully Uninstalled </h2></p></div>';
	echo '<h2>'.__('vSlider Uninstall', 'vslider').'</h2>';
	echo '<p><p><h3> vSlider Successfully Uninstalled </h3></p><strong>'.sprintf(__('Deactivate the vSlider from Plugins panel to Finish the Uninstallation.', 'vslider'), $deactivate_url).'</strong></p>';
	echo '</div>';    }else { ?>
<form method="post" action="">
<div class="wrap">
	<h2><?php _e('Uninstall vSlider', 'vslider'); ?></h2>
	<p>
		<?php _e('Deactivating vSlider plugin does not remove any data that may have been created, such as the slider data and the image links. To completely remove this plugin, you can uninstall it here.', 'vslider'); ?>
	</p>
	<p style="color: red">
		<strong><?php _e('WARNING:', 'vslider'); ?></strong><br />
		<?php _e('Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first.', 'vslider'); ?>
	</p>
	<p style="color: red">
		<strong><?php _e('The following WordPress Options/Tables will be DELETED:', 'vslider'); ?></strong><br />
	</p>
	<table class="widefat" style="width: 200px;">
		<thead>
			<tr>
            <?php
					global $wpdb;
	                $table_name = $wpdb->prefix . "vslider"; ?>
				<th><?php _e('Table: '.$table_name, 'vslider'); ?></th>
			</tr>
		</thead>
		<tr>
			<td valign="top" class="alternate">
				<ol>
				<?php
                     $vslider_data = $wpdb->get_results("SELECT option_name FROM $table_name ORDER BY id");
                      foreach ($vslider_data as $data) {
                      echo '<li>'.$data->option_name.'</li>';
                      }
				?>
				</ol>
			</td>
		</tr>
	</table>
	<p style="text-align: center;">
		<?php _e('Do you really want to uninstall vSlider?', 'vslider'); ?><br /><br />
		<input type="checkbox" name="uninstall_vslider" value="yes" />&nbsp;<?php _e('Yes', 'vslider'); ?><br /><br />
		<input type="submit" name="uninstallvslider" value="<?php _e('UNINSTALL vSlider', 'vslider'); ?>" class="button-primary" onclick="return confirm('<?php _e('You Are About To Uninstall vSlider From WordPress.\nThis Action Is Not Reversible.\n\n Choose [Cancel] To Stop, [OK] To Uninstall.', 'vslider'); ?>')" />
	</p>
</div>
</form>
  <?php    
  }
}

function vslider_plugin_uninstall() {
    global $wpdb;
	$table_name = $wpdb->prefix . "vslider"; 
    $vslider_data = $wpdb->get_results("SELECT option_name FROM $table_name ORDER BY id");
    foreach ($vslider_data as $data) {
        delete_option($data->option_name);
        }
    $sql = "DROP TABLE " . $table_name;
		$wpdb->query( $sql );
}

// Reset to defaults
if ($_POST['vslider-reset'] == 1) { 
    $option=$_GET['edit'];
    update_option($option, vslider_defaults());
    $message = '<div class="updated" id="message"><p><strong>Settings Reset to Default</strong></p></div>';
}

// Updated message
if ($_GET['updated'] == 'true') {
    $message = '<div class="updated" id="message"><p><strong>Settings Saved</strong></p></div>';
    $variable = $_POST['option01'];
    update_option('my-plugin-options', $variable);
}

// Hook for adding admin menus
add_action('admin_menu', 'vslider_plugin_admin_menu');

function vslider_plugin_admin_menu() {
    add_menu_page('Add vSlider ', 'vSlider', 'publish_posts', 'vslider', 'vslider_main', WP_CONTENT_URL.'/plugins/vslider/images/icon.png');
      add_submenu_page('vslider','Edit vslider','Edit vSlider', 'publish_posts', 'add-vSlider', 'vslider_admin_page');
     add_submenu_page('vslider','Uninstall vslider','Uninstall vSlider', 'publish_posts', 'uninstall-vSlider', 'vslider_uninstall');
    add_submenu_page('vslider','vSlider Tutorials ','Tutorials & Faq', 'publish_posts', 'vslider-tutorials', 'vslider_tutorials_page');
    add_submenu_page('vslider','VibeThemes Themes and Plugins','Themes & Plugins', 'publish_posts', 'vslider-themes', 'vslider_theme_page');
    }
//vSlider main page
function vslider_main()
{
    ?>
    <div class="wrap" style="width:820px;"><div id="icon-options-general" class="icon32"><br /></div>
    <h2>vSlider 4.1.1 Settings</h2>
    <div class="metabox-holder" style="width: 820px; float:left;">
    <small>Welcome to vSlider 4.1.1</small>
     <div class="inside">
     <br />
     </div>
     </div>
<?php
//vSlider Functions
    
if($_GET['add'])
{
    $option=$_POST['option_name'];
    if(!get_option($_POST['option_name']))
    {
     if($option){
            $option = preg_replace('/[^a-z0-9\s]/i', '', $option);  
            $option = str_replace(" ", "_", $option);
            global $wpdb;
            $table_name = $wpdb->prefix . "vslider"; 
             $options = get_option($option);
            if($options)
            {
                $v_message= 'Unable to Add vSlider,  different name';
            }else{
                $sql = "INSERT INTO " . $table_name . " values ('','".$option."','1');";
                if ($wpdb->query( $sql )){
                        add_option($option, vslider_defaults());
                        $v_message= ' vSlider successfully added';
                        }
                else{
                        $v_message= 'Unable to Add vSlider, can not insert vSlider';
                        }
                };
            }else{
                    $v_message= ' Unable to Add vSlider';
                }
    }else{
        $v_message= ' Unable to Add vSlider, try a different name';
    }
    ?>
<div class="updated" id="message"><p><strong>
    <?php echo $v_message; ?>
</strong></p></div>
<?php
        }
if($_POST['link'])
{ 
    update_option( 'vslider_support', 1 );
}
elseif($_POST['removelink'])
    {
        update_option( 'vslider_support', 0 );
    }
if($_GET['delete'])
{
    $option=$_GET['delete'];
    delete_option($option);
    global $wpdb;
	$table_name = $wpdb->prefix . "vslider"; 
    $sql = "DELETE FROM " . $table_name . " WHERE option_name='".$option."';";
		$wpdb->query( $sql );
?>
<div class="updated" id="message"><p><strong>
    vSlider Deleted
</strong></p></div>
<?php
}

if($_GET['deactivate'])
{
    $id=$_GET['deactivate'];
    global $wpdb;
	$table_name = $wpdb->prefix . "vslider"; 
    $sql = "UPDATE " . $table_name . " SET active='0' WHERE id='".$id."';";
		$wpdb->query( $sql );
        ?>
<div class="updated" id="message"><p><strong>
    vSlider Deactivated
</strong></p></div>
<?php
}
if($_GET['activate'])
{
    $id=$_GET['activate'];
    global $wpdb;
	$table_name = $wpdb->prefix . "vslider"; 
    $sql = "UPDATE " . $table_name . " SET active='1' WHERE id='".$id."';";
		$wpdb->query( $sql );
        ?>
<div class="updated" id="message"><p><strong>
   vSlider Activated
</strong></p></div>
<?php
}
?>
    <table class="widefat" cellspacing="0">
	
		<thead>
			<tr>
				<th scope="col" id="name" class="manage-column column-name" colspan="5">Table Of vSliders</th>
			</tr>
            <tr style="background: #efefef;">
            <td style="width: 100px;text-align:center;"> ID </td>
            <td style="width: 100px;text-align:center;"> vSlider Name </td>
            <td style="width: 100px;text-align:center;"> Edit </td>
            <td style="width: 100px;text-align:center;"> Active </td>
            <td style="width: 100px;text-align:center;"> Delete </td>
            </tr>
			</thead>
			<tbody>
            <?php
              get_vsliders();
             ?>
            </tbody>
			<tfoot>
			<tr>
                <th scope="col"  class="manage-column column-name" colspan="3">
                <?php 
                    if(get_option('vslider_support') == 1 ){
                        _e('Thank You for Supporting Us! ');
                        echo '<form method="post" style="float: right;margin-right: 250px;" action="?page=vslider"><input type="submit" style="padding: 3px 10px 3px 10px;" name="removelink" class="button" value="Remove Link" /></form>';
                        }
                        else{
                 _e('Support development'); ?>: 
        <select id="vsliderdonate" onchange="support(this);">
        <option value="link" selected="<?php echo $link; ?>"><?php _e('OK, this will place a link to author in footer.'); ?></option>
        <option value="donate" selected="<?php echo $donate; ?>"><?php _e('OK, I would prefer to donate some money.'); ?></option>
        <option value="nohelp" selected="selected"><?php _e('I do not think it\'s worth supporting it.'); ?></option>
        </select>
        <div id="vsliderdonatebox" style="display:none;">
        <?php _e('Donate Amount'); ?>:
        <small>
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=99fusion%40gmail.com&item_name=vSlider Donation&no_note=1&tax=0&amount=19&currency_code=USD" target="_blank">$19 USD</a> |
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=99fusion%40gmail.com&item_name=vSlider Donation&no_note=1&tax=0&amount=9&currency_code=USD" target="_blank">$9 USD</a> |
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=99fusion%40gmail.com&item_name=vSlider Donation&no_note=1&tax=0&amount=6&currency_code=USD" target="_blank">$6 USD</a> |
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=99fusion%40gmail.com&item_name=vSlider Donation&no_note=1&tax=0&amount=3&currency_code=USD" target="_blank">$3 USD</a>
        </small></div>
        <div id="vsliderlink" style="display:none;margin:5px 2px 2px 2px">
        <?php _e('Confirm text link in the Footer'); ?> : <form method="post" style="float: right;margin-right: 250px;" action="?page=vslider"><input type="submit" style="padding: 3px 10px 3px 10px;" class="button-primary" name="link" value="Add Link" /></form>
        </div>
        <?php
        }
        ?>
                </th>

                <th scope="col"  class="manage-column column-name" colspan="2"><small><?php _e('Stay Connected '); ?>:</small>&nbsp;
                <a href="http://twitter.com/#!/vibethemes/" target="_blank"><img src="<?php echo WP_CONTENT_URL."/plugins/vslider/images/twitter.gif"; ?>" /></a>
                &nbsp;<a href="http://www.facebook.com/vibethemes/" target="_blank"><img src="<?php echo WP_CONTENT_URL."/plugins/vslider/images/facebook.png"; ?>" /></a>
                &nbsp;<a href="http://www.vibethemes.com/forum/" target="_blank" title="VibeThemes Forums"><img src="<?php echo WP_CONTENT_URL."/plugins/vslider/images/vibeforums.png"; ?>" /></a>
                </th>
			</tr>
		</tfoot>
        </table>
    </div>
    <?php
}
// GENERATE THEME SHOWCASE PAGE
function vslider_theme_page() { ?>
	    <div class="wrap"><div id="icon-themes" class="icon32"><br /></div><h2>vSlider Themes Page</h2>
        <div id="themes"></div>
	</div>
<?php }

// GENERATE THE TUTORIAL PAGE
function vslider_tutorials_page() { ?>
	<div class="wrap"><div id="icon-users" class="icon32"><br /></div><h2>vSlider Tutorials &amp; FAQ's&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="button" href="#">Expand All</a></h2>
    <div id="tutorials"></div>
	</div>
<?php }

function vslider_admin_page() { 
    global $message; 
    $option=$_GET['edit'];
    ?>
<div class="wrap" style="width:820px;"><div id="icon-options-general" class="icon32"><br /></div>
<?php echo $message; ?>
<?php 
if($_GET["edit"]){
$option=$_GET['edit'];
}else{
    $option='vslider_options';
    }
?>
<h2><?php _e("vSlider 4.1.1 Edit Options Page [ ".$option." ]"); ?></h2>


<form method="post" action="options.php">
<?php 
wp_nonce_field('update-options'); 
$options = get_option($option); 
?>

	<div class="metabox-holder" style="width: 350px; float:left;">
		<div class="postbox">
		<h3><?php _e("General Setings", 'vslider'); ?></h3>
			<div id="general" class="inside" style="padding: 10px;">

                <p><?php _e("Image width", 'vslider'); ?>:<input type="text" name="<?php echo $option; ?>[width]" value="<?php echo $options['width'] ?>" size="3" />px&nbsp;&nbsp;<?php _e("height", 'vslider'); ?>:<input type="text" name="<?php echo $option; ?>[height]" value="<?php echo $options['height'] ?>" size="3" />px</p>
                <p><?php _e("Squares per width", 'vslider'); ?>:<input type="text" name="<?php echo $option; ?>[spw]" value="<?php echo $options['spw'] ?>" size="3" />&nbsp;&nbsp;<?php _e("per height", 'vslider'); ?>:<input type="text" name="<?php echo $option; ?>[sph]" value="<?php echo $options['sph'] ?>" size="3" /></p>
                <p><?php _e("Delay between images", 'vslider'); ?>:<input type="text" name="<?php echo $option; ?>[delay]" value="<?php echo $options['delay'] ?>" size="3" />&nbsp;in ms</p>
                <p><?php _e("Delay beetwen squares", 'vslider'); ?>:<input type="text" name="<?php echo $option; ?>[sDelay]" value="<?php echo $options['sDelay'] ?>" size="3" />&nbsp;in ms</p>
                <p><?php _e("Opacity of title and navigation", 'vslider'); ?>:<input type="text" name="<?php echo $option; ?>[opacity]" value="<?php echo $options['opacity'] ?>" size="3" /></p>
                <p><?php _e("Speed of title appereance", 'vslider'); ?>:<input type="text" name="<?php echo $option; ?>[titleSpeed]" value="<?php echo $options['titleSpeed'] ?>" size="3" />&nbsp;in ms</p>
                <p><?php _e("Effect", 'vslider'); ?>:<select name="<?php echo $option; ?>[effect]" ><option value="" <?php selected('', $options['effect']); ?>>all combined</option><option value="random" <?php selected('random', $options['effect']); ?>>Random</option><option value="swirl" <?php selected('swirl', $options['effect']); ?>>Swirl</option><option value="rain" <?php selected('rain', $options['effect']); ?>>rain</option><option value="fade" <?php selected('fade', $options['effect']); ?>>Fade</option><option value="vertical" <?php selected('vertical', $options['effect']); ?>>Curtain</option><option value="altvertical" <?php selected('altvertical', $options['effect']); ?>>Alternate Curtain</option><option value="horizontal" <?php selected('horizontal', $options['effect']); ?>>Winding</option><option value="althorizontal" <?php selected('althorizontal', $options['effect']); ?>>Alternate Winding</option><option value="diagonal" <?php selected('diagonal', $options['effect']); ?>>Diagonal</option></select>
                &nbsp;&nbsp;<a href="#" class="tooltip"><span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/vslider-effects.png' /> </span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/tooltip.png' /> </a> 
                </p>
                <p><?php _e("Show navigation buttons", 'vslider'); ?>:<select name="<?php echo $option; ?>[navigation]"><option value="true" <?php selected('true', $options['navigation']); ?>>Yes</option><option value="false" <?php selected('false', $options['navigation']); ?>>No</option></select>
                &nbsp;&nbsp;<a href="#" class="tooltip"><span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/navigationbuttons.png' /> </span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/tooltip.png' /> </a>
                </p>
                <p><?php _e("Sticky navigation buttons", 'vslider'); ?>:<select name="<?php echo $option; ?>[stickynav]"><option value="true" <?php selected('true', $options['stickynav']); ?>>Yes</option><option value="false" <?php selected('false', $options['stickynav']); ?>>No</option></select>
                <p><?php _e("Show images as links ", 'vslider'); ?>:<select name="<?php echo $option; ?>[links]"><option value="true" <?php selected('true', $options['links']); ?>>Yes</option><option value="false" <?php selected('false', $options['links']); ?>>No</option></select></p>
                <p><?php _e("Show image buttons ", 'vslider'); ?>:<select name="<?php echo $option; ?>[buttons]"><option value="true" <?php selected('true', $options['buttons']); ?>>Yes</option><option value="false" <?php selected('false', $options['buttons']); ?>>No</option></select>
                &nbsp;&nbsp;<a href="#" class="tooltip"><span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/imagebuttons.png' /> </span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/tooltip.png' /> </a></p>
                <p><?php _e("Pause on mouse hover", 'vslider'); ?>:<select name="<?php echo $option; ?>[hoverPause]"><option value="true" <?php selected('true', $options['hoverPause']); ?>>Yes</option><option value="0" <?php selected('0', $options['hoverPause']); ?>>No</option></select></p>
                <p><?php _e("Border Width", 'vslider'); ?>: <input type="text" name="<?php echo $option; ?>[borderWidth]" value="<?php echo $options['borderWidth'] ?>" size="3" />px &nbsp;&nbsp;<?php _e("Border Radius", 'vslider'); ?>: <input type="text" name="<?php echo $option; ?>[borderRadius]" value="<?php echo $options['borderRadius'] ?>" size="3" />px</p>
                <p><?php _e("Border Color", 'vslider'); ?>:<input id="borderColor" type="text" name="<?php echo $option; ?>[borderColor]" value="<?php echo $options['borderColor'] ?>" size="8" />&nbsp;HEX
                &nbsp;&nbsp;<a href="#" class="tooltip"><span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/border.png' /> </span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/tooltip.png' /> </a></p>
                <p><?php _e("Font family", 'vslider'); ?>:<select name="<?php echo $option; ?>[fontFamily]"><option value="'Trebuchet MS', Helvetica, sans-serif" <?php selected("'Trebuchet MS', Helvetica, sans-serif", $options['fontFamily']); ?>>'Trebuchet MS', Helvetica, sans-serif</option><option value="Arial, Helvetica, sans-serif" <?php selected('Arial, Helvetica, sans-serif', $options['fontFamily']); ?>>Arial, Helvetica, sans-serif</option><option value="Tahoma, Geneva, sans-serif" <?php selected('Tahoma, Geneva, sans-serif', $options['fontFamily']); ?>>Tahoma, Geneva, sans-serif</option><option value="Verdana, Geneva, sans-serif" <?php selected('Verdana, Geneva, sans-serif', $options['fontFamily']); ?>>Verdana, Geneva, sans-serif</option><option value="Georgia, serif" <?php selected('Georgia, serif', $options['fontFamily']); ?>>Georgia, serif</option><option value="'Arial Black', Gadget, sans-serif" <?php selected("'Arial Black', Gadget, sans-serif", $options['fontFamily']); ?>>'Arial Black', Gadget, sans-serif</option><option value="'Bookman Old Style', serif" <?php selected("'Bookman Old Style', serif", $options['fontFamily']); ?>>'Bookman Old Style', serif</option><option value="'Comic Sans MS', cursive" <?php selected("'Comic Sans MS', cursive", $options['fontFamily']); ?>>'Comic Sans MS', cursive</option><option value="'Courier New', Courier, monospace" <?php selected("'Courier New', Courier, monospace", $options['fontFamily']); ?>>'Courier New', Courier, monospace</option><option value="Garamond, serif" <?php selected("Garamond, serif", $options['fontFamily']); ?>>Garamond, serif</option><option value="'Times New Roman', Times, serif" <?php selected("'Times New Roman', Times, serif", $options['fontFamily']); ?>>'Times New Roman', Times, serif</option><option value="Impact, Charcoal, sans-serif" <?php selected("Impact, Charcoal, sans-serif", $options['fontFamily']); ?>>Impact, Charcoal, sans-serif</option><option value="'Lucida Console', Monaco, monospace" <?php selected("'Lucida Console', Monaco, monospace", $options['fontFamily']); ?>>'Lucida Console', Monaco, monospace</option><option value="'MS Sans Serif', Geneva, sans-serif" <?php selected("'MS Sans Serif', Geneva, sans-serif", $options['fontFamily']); ?>>'MS Sans Serif', Geneva, sans-serif</option></select></p>
                <p><?php _e("Title font size", 'vslider'); ?>:<input type="text" name="<?php echo $option; ?>[titleFont]" value="<?php echo $options['titleFont'] ?>" size="3" />px</p>
                <p><?php _e("Text font size", 'vslider'); ?>:<input type="text" name="<?php echo $option; ?>[fontSize]" value="<?php echo $options['fontSize'] ?>" size="3" />px
                &nbsp;&nbsp;<a href="#" class="tooltip"><span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/titletext.png' /> </span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/tooltip.png' /> </a></p>
                <p><?php _e("Text color", 'vslider'); ?>:<input id="textColor" type="text" name="<?php echo $option; ?>[textColor]" value="<?php echo $options['textColor'] ?>" size="8" />&nbsp;HEX</p>
                <small><?php _e("Click on the text box to pick a color", 'vslider'); ?></small>
                <p><?php _e("Background color", 'vslider'); ?>:<input id="bgColor" type="text" name="<?php echo $option; ?>[bgColor]" value="<?php echo $options['bgColor'] ?>" size="8" />&nbsp;HEX</p>
                <small><?php _e("To select color click on Tick at the right bottom of the color panel", 'vslider'); ?></small>
                <p><input type="submit" class="button" value="<?php _e('Save Settings') ?>" /></p>

			</div>
		</div>
	</div>

	<div class="metabox-holder" style="width: 450px;float:right;margin-bottom:-10px;">
       <div class="postbox">        
		<h3><?php _e("More vSlider Settings", 'vslider'); ?> <div class="click" id="moreeffects" style="float:right;cursor:pointer;"><?php _e("(+/-)", 'vslider'); ?></div></h3>
			<div class="inside" style="padding: 10px;display:none;" id="boxmoreeffects">         
             <p><?php _e("Image Button Style", 'vslider'); ?>:<select name="<?php echo $option; ?>[navstyle]" id="navstyle">
                <option value="none" <?php selected('none', $options['navstyle']); ?>>None</option>
                <option value="nav_small" <?php selected('nav_small', $options['navstyle']); ?>>Small Buttons</option>
                <option value="nav_style1" <?php selected('nav_style1', $options['navstyle']); ?>>Style 1</option>
                <option value="nav_style2" <?php selected('nav_style2', $options['navstyle']); ?>>Style 2</option>
                <option value="nav_style3" <?php selected('nav_style3', $options['navstyle']); ?>>Style 3</option>
                <option value="nav_style4" <?php selected('nav_style4', $options['navstyle']); ?>>Style 4</option>
                <option value="nav_style5" <?php selected('nav_style5', $options['navstyle']); ?>>Style 5</option>
                </select>
                &nbsp;&nbsp;<?php _e("Vertical Buttons", 'vslider'); ?>: <input type="checkbox" name="<?php echo $option; ?>[vnavenable]" value="1" <?php if($options['vnavenable']){ echo "checked=CHECKED"; } ?> />
                </p>
             <p><?php _e("Navigation Button Style", 'vslider'); ?>:<select name="<?php echo $option; ?>[arrstyle]" id="navstyle">
                <option value="none" <?php selected('none', $options['navstyle']); ?>>None</option>
                <option value="arr_style1" <?php selected('arr_style1', $options['arrstyle']); ?>>Style 1</option>
                <option value="arr_style2" <?php selected('arr_style2', $options['arrstyle']); ?>>Style 2</option>
                <option value="arr_style3" <?php selected('arr_style3', $options['arrstyle']); ?>>Style 3</option>
                </select>
                </p>
             <p>
                <?php _e("Image buttons placement", 'vslider'); ?>: <input type="text" name="<?php echo $option; ?>[navplace]" size="30" id="navplace"  value="<?php echo $options['navplace']; ?>"/>
                &nbsp;&nbsp;<a href="#" class="tooltip"><span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/btnplacement.png' /> </span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/tooltip.png' /></a>
                <br /><small>Order of Spacing(margin): TOPpx RIGHTpx BOTTOMpx LEFTpx</small>
                </p>  
              <p>
              <?php _e("Enable Auto-Resizing", 'vslider'); ?>: <input type="checkbox" name="<?php echo $option; ?>[timthumb]" value="1" <?php if($options['timthumb']){ echo "checked=CHECKED"; } ?> />
              &nbsp;&nbsp;<?php _e("Image Quality", 'vslider'); ?>:<select name="<?php echo $option; ?>[quality]">
                <option value="40" <?php selected('40', $options['quality']); ?>>40%</option>
                <option value="50" <?php selected('50', $options['quality']); ?>>50%</option>
                <option value="60" <?php selected('60', $options['quality']); ?>>60%</option>
                <option value="70" <?php selected('70', $options['quality']); ?>>70%</option>
                <option value="80" <?php selected('80', $options['quality']); ?>>80%</option>
                <option value="90" <?php selected('90', $options['quality']); ?>>90%</option>
                <option value="100" <?php selected('100', $options['quality']); ?>>100%</option>
                </select>
                </p>   
              <p><?php _e("Slide Layout", 'vslider'); ?>:<select name="<?php echo $option; ?>[layout]" id="layout">
                <option value="stripe-left" <?php selected('stripe-left', $options['layout']); ?>>Stripe Left</option>
                <option value="stripe-right" <?php selected('stripe-right', $options['layout']); ?>>Stripe Right</option>
                <option value="stripe-bottom" <?php selected('stripe-bottom', $options['layout']); ?>>Stripe Bottom</option>
                <option value="stripe-top" <?php selected('stripe-top', $options['layout']); ?>>Stripe Top</option>
                </select>
                &nbsp;&nbsp;<a href="#" class="tooltip"><span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/layout.png' /> </span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/tooltip.png' /> </a>
                </p> 
              <p>
                <?php _e("Container Margin", 'vslider'); ?>: <input type="text" name="<?php echo $option; ?>[holdermar]" size="30" id="holdermar"  value="<?php echo $options['holdermar']; ?>"/>
                &nbsp;&nbsp;<a href="#" class="tooltip"><span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/cntnerspcing.png' /> </span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/tooltip.png' /></a>
                <br /><small>Order of Spacing(margin): TOPpx RIGHTpx BOTTOMpx LEFTpx</small>
                </p> 
               <p>
                <?php _e("Container Float", 'vslider'); ?>: <select name="<?php echo $option; ?>[holderfloat]" id="holderfloat">
                <option value="none" <?php selected('none', $options['holderfloat']); ?>>None</option>
                <option value="left" <?php selected('left', $options['holderfloat']); ?>>Left</option>
                <option value="right" <?php selected('right', $options['holderfloat']); ?>>Right</option>
                </select>
                &nbsp;&nbsp;<a href="#" class="tooltip"><span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/float.png' /> </span><img src='<?php echo WP_CONTENT_URL;?>/plugins/vslider/images/tooltip.png' /> </a>
                </p> 
                <p><input type="submit" class="button" value="<?php _e('Save Settings') ?>" /></p>
              </div>
              
        </div>  
   </div>
      <div class="metabox-holder" style="width: 450px;float:right;margin-bottom:-10px;">          
		<div class="postbox">
		<h3><?php _e("Images Source", 'vslider'); ?> </h3>
			<div class="inside" style="padding: 10px;" id="boximgsrc">

                <p><?php _e(" Image Source", 'vslider'); ?>?&nbsp;
                <select name="<?php echo $option; ?>[customImg]">
                    <option value="true" <?php selected('true', $options['customImg']); ?>>Custom</option>
                    <option value="false" <?php selected('false', $options['customImg']); ?>>Category</option>
                </select>&nbsp;				
                <small><?php _e("Open image links in new window:", 'vslider'); ?></small>&nbsp;<input type="checkbox" name="<?php echo $option; ?>[target]" value="_blank" <?php if($options['target'] === '_blank'){ echo 'CHECKED';}; ?> />
               </p>
               <p> <?php _e("Category:", 'vslider'); ?>
                <?php wp_dropdown_categories(array('selected' => $options['imgCat'], 'name' => $option.'[imgCat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'vslider'), 'hide_empty' => '0' )); ?>
                &nbsp;&nbsp;<?php _e("Grab Post Image:", 'vslider'); ?>
                <select name="<?php echo $option; ?>[catchimage]">
                    <option value="featured" <?php selected('featured', $options['catchimage']); ?>>Featured</option>
                    <option value="first" <?php selected('first', $options['catchimage']); ?>>First</option>
                </select>
                </p>
                <p><?php _e("Slides", 'vslider'); ?>:
                <select name="<?php echo $option; ?>[slideNr]">
                <?php for($s=1; $s<21; $s++){ ?>
                    <option value="<?php echo $s; ?>" <?php selected($s, $options['slideNr']); ?>><?php echo $s; ?></option>
                <?php } ?>
                </select>
                <?php _e("Display post excerpt", 'vslider'); ?>?&nbsp;
                <select name="<?php echo $option; ?>[excerpt]">
                    <option value="true" <?php selected('true', $options['excerpt']); ?>>Yes</option>
                    <option value="false" <?php selected('false', $options['excerpt']); ?>>No</option>
                </select>&nbsp;
                <?php _e("chars", 'vslider'); ?>:
                <input type="text" name="<?php echo $option; ?>[chars]" value="<?php echo $options['chars'] ?>" size="3" />
                </p>
                <p><small><?php _e("Random Image Sequence:", 'vslider'); ?></small>&nbsp;<input type="checkbox" name="<?php echo $option; ?>[randimg]" value="_blank" <?php if($options['randimg'] === '_blank'){ echo 'CHECKED';}; ?> /></p>
                <p><input type="submit" class="button" value="<?php _e('Save Settings') ?>" /></p>

			</div>
		</div>
	</div>

    <?php $slides = $options['slideNr'] + 1; ?>
    <?php for($x=1; $x<$slides; $x++){ ?>
	<div class="metabox-holder" style="width: 450px;float:right;margin-bottom:-10px;">
		<div class="postbox">
		<h3><?php _e("Custom Image", 'vslider'); ?> <?php echo $x; ?><div class="click" id="<?php echo $x; ?>" style="float:right;cursor:pointer;"><?php _e("(+/-)", 'vslider'); ?></div></h3>
			<div class="inside" id="box<?php echo $x; ?>" style="padding: 10px;display:none;">

                <p><?php _e("Image URL", 'vslider'); ?>: <small style="float:right;"><?php _e("upload", 'vslider'); ?></small><br />
                <input id="slide<?php echo $x; ?>" type="text" name="<?php echo $option; ?>[slide<?php echo $x; ?>]" value="<?php echo $options['slide'.$x.''] ?>" size="62" />
                <a href="media-upload.php?type=image&amp;TB_iframe=true" class="thickbox" onclick="current_image='slide<?php echo $x; ?>';"><img src='images/media-button-image.gif' alt='Add an Image' /></a><br />
                <?php _e("Image links to", 'vslider'); ?>:<br />
                <input type="text" name="<?php echo $option; ?>[link<?php echo $x; ?>]" value="<?php echo $options['link'.$x.''] ?>" size="62" /><br />
				<?php _e("Heading text", 'vslider'); ?>:<br />
                <input type="text" name="<?php echo $option; ?>[heading<?php echo $x; ?>]" value="<?php echo $options['heading'.$x.''] ?>" size="62" /><br />
				<?php _e("Description text", 'vslider'); ?>:<br />
                <textarea name="<?php echo $option; ?>[desc<?php echo $x; ?>]" cols=51 rows=3><?php echo $options['desc'.$x.''] ?></textarea>
                </p>
                <p><input type="submit" class="button" value="<?php _e('Save Settings') ?>" /></p>

			</div>
		</div>
	</div>
    <?php } ?>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="<?php echo $option; ?>" />
</form>


<form method="post" style="clear:both;">
<input type="hidden" name="vslider-reset" value="1" />
<p><input type="submit" class="button-primary" onclick="return confirm('Are you sure you want to reset to default settings?')" value="<?php _e('Reset') ?>" /></p>
</form>

</div>
<?php }

// LIMIT CONTENT FUNCTION
function vslider_limitpost ($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      echo $content;
      echo "&nbsp;<a rel='nofollow' href='";
      the_permalink();
      echo "'>".__('Read More', 'vibe')." &rarr;</a>";
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo $content;
        echo "...";
        echo "&nbsp;<a rel='nofollow' href='";
        the_permalink();
        echo "'>".$more_link_text."</a>";
   }
   else {
      echo $content;
      echo "&nbsp;<a rel='nofollow' href='";
      the_permalink();
      echo "'>".__('Read More', 'vibe')." &rarr;</a>";
   }
}

// VSLIDER
function vslider($option='vslider_options'){ 
    $options = get_option($option);
    if(!$option){ $option='vslider_options';$options = get_option($option); }
    global $wpdb;$num=1;
	$table_name = $wpdb->prefix . "vslider"; 
    $vslider_data = $wpdb->get_results("SELECT active FROM $table_name WHERE option_name='".$option."'");
    foreach ($vslider_data as $data) { 
        if($data->active == 1)
        {  vslider_head($option);
    ?>
    <div id="<?php echo $option.'container'; ?>">
    <?php
  echo '<div id="'.$option.'">';
  if($options['customImg'] == 'false') {
      if($options['randimg']){$randimg="orderby=rand&";}//Randomise Images
      $recent = new WP_Query($randimg."cat=".$options['imgCat']."&showposts=".$options['slideNr']); 
      while($recent->have_posts()) : $recent->the_post(); ?>
          <a href="<?php the_permalink(); ?>" target="<?php echo $options['target']; ?>">
          <?php 
          if($options['catchimage'] == 'featured'){ // CATCH THE FEATURED IMAGE OF THE POST
             if($options['timthumb'])    // get the src of the post thumbnail
            {    
                $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 300,300 ), false, '' ); 
                $thumbnailSrc = $src[0]; 
                $img_url = WP_CONTENT_URL.'/plugins/vslider/timthumb.php?src='.$thumbnailSrc.'&amp;w='.$options['width'].'&amp;h='.$options['height'].'&amp;zc=1&amp;q='.$options['quality'];
      
                ?>
                <img src="<?php echo $img_url; ?>" alt="" />
                <?php } else {
                              the_post_thumbnail ( array($options['width'], $options['height']) );
                              }
            }else if($options['catchimage'] == 'first'){
                  // CATCH THE FIRST IMAGE OF THE POST 
                    $iPostID = get_the_ID();
                    $content_post = get_post($iPostID);
                    $content = $content_post->post_content;
                    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',$content, $matches);
                    $firstsrc = $matches [1] [0];
                    if($options['timthumb'])    // get the src of the post thumbnail
                    {  $image = str_replace(get_bloginfo('siteurl'), '', $firstsrc); 
                       $img_url = WP_CONTENT_URL.'/plugins/vslider/timthumb.php?src='.urlencode($image).'&amp;w='.$options['width'].'&amp;h='.$options['height'].'&amp;zc=1&amp;q='.$options['quality'];
                       }else {$img_url= $firstsrc;}
                        ?>
                        <div style="background: url(<?php echo $img_url; ?>) no-repeat;<?php echo "width:".$options['width'].";height:".$options['height'].";"; ?>" alt="">
                        </div>
                        <?php                          
            }    
             if($options['excerpt'] == 'true') { ?>
              <span><h4><?php the_title(); ?></h4><?php vslider_limitpost($options['chars'], "" ); ?></span>
          <?php } ?>
          </a>
      <?php endwhile; //endwhile
  } else {
    //$slides = $options['slideNr'] + 1;
    $randx = range(1, $options['slideNr']);
    if($options['randimg']){        //RANDOMISING IMAGES
           shuffle($randx);
    }//Randomise Images
    
    foreach( $randx as $x){ ?>
       <a href="<?php echo $options['link'.$x.'']; ?>" style="background:#fff;" target="<?php echo $options['target']; ?>">
       <?php 
       if($options['timthumb']){
       $image = str_replace(get_bloginfo('siteurl'), '', $options['slide'.$x.'']); 
       $img_url =WP_CONTENT_URL.'/plugins/vslider/timthumb.php?src='.urlencode($image).'&amp;w='.$options['width'].'&amp;h='.$options['height'].'&amp;zc=1&amp;q='.$options['quality'];
       }else{
        $img_url=$options['slide'.$x.''];
       }
       ?>
       <img src="<?php echo $img_url; ?>" style="width:<?php echo $options['width']; ?>px;height:<?php echo $options['height']; ?>px;" alt="<?php echo $options['heading'.$x.'']; ?>" />
         <?php if($options['heading'.$x.''] || $options['desc'.$x.'']) { ?>
           <span><h4><?php echo $options['heading'.$x.'']; ?></h4><?php echo $options['desc'.$x.'']; ?></span>
         <?php } ?>
       </a>
    <?php }
  }
  echo '</div></div>';
   }//ENDIF
  }//END-FOR
}//END FUNCTION VSLIDER

function vSlider_link() { ?>
<noscript><a href="http://www.vibethemes.com/" target="_blank" title="wordpress themes">Vibe Themes</a></noscript>
<?php }
if(get_option('vslider_support')==1) //Asking USER EXPLICITLY TO SUPPORT VSLIDER not the DEFAULT OPTION
{add_action('wp_footer', 'vSlider_link');}

// Add vSlider short code  use vslider as  [vslider name='vslider_options']
function vslider_short_code($atts) {
	ob_start();
    extract(shortcode_atts(array(
		"name" => ''
	), $atts));
	vslider($name);
	$output = ob_get_clean();
	return $output;
}
add_shortcode('vslider', 'vslider_short_code');



// REGISTER VSLIDER AS WIDGET
add_action('widgets_init', create_function('', "register_widget('vslider_widget');"));

class vslider_widget extends WP_Widget {

	function vslider_widget() { 
	   $options = get_option('vslider_options');
		$widget_ops = array( 'classname' => 'vslider-widget', 'description' => 'jQuery Image Slider' );
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'vslider-widget' );
		$this->WP_Widget( 'vslider-widget', 'vSlider Widget', $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);

		echo $before_widget;

			if (!empty($instance['title']))
				echo $before_title . $instance['title'] . $after_title;
                
    if (empty($instance['vslider']))
    {
        $instance['vslider']='vslider_options';
    }
    vslider ($instance['vslider']); //check

	echo $after_widget;
	}

	function update($new_instance, $old_instance) {
         $instance=$old_instance;
        /* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['vslider'] = $new_instance['vslider'];
        return $instance;
	}

	function form($instance) { ?>
    
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title"); ?>:</label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" /></p>
        <p><label><?php _e("vSlider Name"); ?>:</label>  <br />  
            <select id="<?php echo $this->get_field_name('vslider'); ?>" name="<?php echo $this->get_field_name('vslider'); ?>">
            <?php
             global $wpdb;$num=1;
	$table_name = $wpdb->prefix . "vslider"; 
    $vslider_data = $wpdb->get_results("SELECT * FROM $table_name where active=1 ORDER BY id");
    foreach ($vslider_data as $data) { 
        ?>
            <option value="<?php echo $data->option_name; ?>" <?php if ( $data->option_name == $instance['vslider'] ) echo 'selected="selected"'; ?>><?php echo $data->option_name; ?></option>
            <?php 
            }
            ?>
            </select>
            </p>

	<?php
	}
}

?>