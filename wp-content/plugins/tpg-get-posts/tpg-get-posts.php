<?php
/*
Plugin Name: TPG Get Posts
Plugin URI: http://www.tpginc.net/wordpress-plugins/
Description: Adds a shortcode tag [tpg_get_posts] to display posts on page.
Version: 1.2.3
Author: Criss Swaim
Author URI: http://www.tpginc.net/
*/

/*  The code is based on nurelm-get-posts

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * @todo ... Description
 *
 *  1) when post contains an image with caption, the caption is not formatted correctly
 */

// functions for formating post

/**
 * format routine to identify category selection
 *
 * @package WordPress
 * @subpackage tpg_get_posts
 * @since 2.8
 *
 * if request by category name is made, this is a preprocess routine to 
 * convert the name to a category id, allowing for multiple category names
 * 
 * @param    type    $id    post id
 * @return   string         category ids for selection
 *

 */
function get_my_cats($id) { 
	// init $tpg_cats fld
	$tpg_cats =''; 
	//if categories exist, process them
	if(get_the_category($id)){ 
		//loop through each cat for the post id
		foreach(get_the_category($id) as $cat) {
			//get the category
			$cat_name = $cat->name;
			//string cats serparated by ','  
			$tpg_cats .= $cat_name.',';         
		}
	}
//	substr_replace($tpg_cats,"",-1);             // remove last ','
	return substr_replace($tpg_cats,"",-1);
}

/**
 * format routine for tag selection
 *
 * @package WordPress
 * @subpackage tpg_get_posts
 * @since 2.8
 *
 * if request by tag is made, this is a preprocess routine to 
 * convert creates a list of tags in comma delimited format
 * 
 * @param    type    $id    	post id
 * @return   string             string of the tags for selecting posts
 *
 */

function get_my_tags($id) {
	// init $tpg_tags fld
	$tpg_tags =''; 
	// if tags exist, process them
	if(get_the_tags($id)){ 
		// loop through each tag for the post id
		foreach(get_the_tags($id) as $tag) {
			//get the tag
			$tag_name = $tag->name;
			//string tags serparated by ',' 
			$tpg_tags .= $tag_name.',';
		}
	}
	if ($tpg_tags == "") $tpg_tags = "No Tags ";
//	substr_replace($tpg_tags,"",-1);   // remove last ','
	return  substr_replace($tpg_tags,"",-1);
}

/**
 * shorten text to fixed length or complete word less than length
 *
 * @package WordPress
 * @subpackage tpg_get_posts
 * @since 2.8
 *
 * to control formatting, sometimes it is necessary to restrict a text field to 
 * a specific length or the last word less than the length 
 * 
 * @param    string  $style			the code value of c or w
 * @param    string  $len			length of the output text
 * @param    string  $text			the string to be shortened
 * @return   string  $text			the shortened text string
 *
 */

function shorten_text($style='w', $len='20', $text, $ellipsis) {
	//if style is w and the next char is space change style to c
	if ($style == 'w') {
		if (substr($text,$len,1) == " ") {$style = 'c';}
	}
	
	// if style is c shorten to char and truncate
	// if style is w shorten to last complete word
	switch ($style) {
		case 'c' :
			$text = substr($text,0,$len);
			break;
		case 'w' :
			if (strlen($text) <= $len) {
    			$text = $text; //do nothing
			} else {
				$text = preg_replace('/\s+?(\S+)?$/', '', substr($text, 0, $len+1));				
			}
			break;
	}
	$text .= $ellipsis;                     // add elipse
	return $text;
}

/**
 * get the posts
 *
 * @package WordPress
 * @subpackage tpg_get_posts
 * @since 2.8
 *
 * to control formatting, sometimes it is necessary to restrict a text field to 
 * a specific length or the last word less than the length 
 * 
 * @param    array    $args   		values from the shortcode passed to this routine
 * @return   string   $content      the selected formated posts
 *
 */

function tpg_get_posts_gen($args = '') {
	global $id, $post, $more;
//	global $id, $post, $more, $page, $pages, $multipage, $preview, $pagenow;

	//default values passed to get_posts
  	$default_attr =   
    array(
      'numberposts'      => '5',
      'offset'           => '',
      'category'         => '',
      'category_name'    => '',
      'tag'              => '',
      'orderby'          => 'date',
	  'end-of-parms'     => '---------',
	  'post_entire'      => 'false',
	  'show_meta'        => 'false',
	  'show_byline'		 => 'true',
	  'shorten_title'    => '',
	  'shorten_content'  => '',
	  'text_ellipsis'    => ' ...',
      'ul_class'         => '',
	  'title_tag'        => 'h2',
      'fields'           => 'post_title, post_content',
      'fields_classes'   => 'p_title_class, p_content_class');
	
	//loop through attributes and add if array if key does not exist
	if ($args != '') {
		foreach ($args as $key => $value) {
			if (array_key_exists ($key,$default_attr)) {
				continue;
			} else {
				$default_attr=array($key=>$value)+$default_attr;
			}
		}
		reset($args);
	}
	
	reset($default_attr);
	
	//now apply any options passed to the default array
    $r = shortcode_atts($default_attr,$args );
	
	//if multiple category_names passed, convert to cat_id
	$cat_nam_list = explode(",", $r['category_name']);
	if (sizeof($cat_nam_list) <= 1 ) {
		//single or no cat name submitted - continue  
	} else {
		//loop to get cat id and replace cat_names with cat ids
		foreach ($cat_nam_list as $value) {
			$r['category'] .= get_cat_ID($value).",";
		}
		$r['category'] = substr_replace($r['category'],"",-1);
		$r['category_name'] = "";
	}
	
	//setup parms for query
	$q_args = array();
	reset ($r);
	while (list($key, $value) =  each($r)){
		if ($key == 'end-of-parms') {
			end ($r);
			break;
		} 
		if ($value != ''){
			$q_args[$key] = $value; 
		}
	}
	
	//set up output fields
	$fields_list = explode(",", $r['fields']);
	$fields_classes_list = explode(",", $r['fields_classes']);

	if ( null === $more_link_text )
		$more_link_text = __( '(read more...)' );
		
	if ($r['post_entire'] == "true") {
		$post_entire = true;
	} else {
		$post_entire = false;
	}
	
	if ($r['show_meta'] == "true") {
		$show_meta = true;
	} else {
		$show_meta = false;
	}
	
	if ($r['show_byline'] == "true") {
		$show_byline = true;
	} else {
		$show_byline = false;
	}
	
	if ($r['ul_class'] == "") {
		$show_as_list = false;
	} else {
		$show_as_list = true;
	}
	
	// set flag to shorten text in title
	$ellip = $r['text_ellipsis'];
	if ($r['shorten_title'] == "") {
		$short_title = false;
	} else {
		$short_title = true;
		$st_style = substr($r['shorten_title'],0,1);
		$st_len= substr($r['shorten_title'],1);
	}
	
	if ($r['shorten_content'] == "") {
		$short_content = false;
	} else {
		$short_content = true;
		$sc_style = substr($r['shorten_content'],0,1);
		$sc_len= substr($r['shorten_content'],1);
	}
	
	//set up title tag
	if ($r['title_tag'] == '') {
		$t_tag_beg = '';
		$t_tag_end = '';
	} else {
		$t_tag_beg = "<".$r['title_tag'].">";
		$t_tag_end = "</".$r['title_tag'].">";
	}
	
	//open div and begin post process
	$content = '<div id="tpg-get-posts" />';
	if ($show_as_list) {
		$content .="<ul class=\"".$r['ul_class']."\">\n";
	}

	// get posts
	$tmp_post = $post;                    // save current post/page settings
	$posts = get_posts($q_args);
	foreach( $posts as $post ) {
		if ($show_as_list) 
			$content .= "  <li>";
			
		setup_postdata($post);
		$i = 0;
    	foreach ( $fields_list as $field ) {

			if (isset($fields_classes_list[$i])) {
				$content .= "<span class=\"" . trim($fields_classes_list[$i]) . "\">";
			}

			$field = trim($field);
			
			$wkcontent = $post->$field;                                         //get the content
			switch ($field) {
				case "post_title":
					$wkcontent = ($short_title)? shorten_text($st_style,$st_len,$wkcontent,$ellip): $wkcontent;
					$wkcontent = $t_tag_beg.'<a href="'.get_permalink($post->ID).'" id="">'.$wkcontent.'</a>'.$t_tag_end;
					if ($show_byline) {
						$wkcontent .= '<p class="p_byline" >By '.get_the_author().' on '.mysql2date('F j, Y', $post->post_date).'</p>';
					}
					break;
				case "post_content":					
					if (!$post_entire) {           //show only teaser 
						$wkarr = preg_split('/<!--more(.*?)?-->/', $wkcontent);
						$wkcontent = ($short_content)? shorten_text($sc_style,$sc_len,$wkarr[0],$ellip): $wkarr[0];
						$wkcontent = '<div id="tpg_post_content">'.$wkcontent;
//						$wkcontent .= '<a href="'.get_permalink($post->ID).'" class=\"more-link\">'.$more_link_text.'</a></div>';
						$wkcontent .= apply_filters( 'the_content_more_link', ' <a href="' . get_permalink() . "#more-$id\" class=\"more-link\">$more_link_text</a></div>", $more_link_text );
						$wkcontent = force_balance_tags($wkcontent);
					}else {
						$wkcontent = '<div id="tpg_post_content">'.$wkcontent.'</div>';
					}
					break;
			}
			
	  		$content .= $wkcontent;

			if (isset($fields_classes_list[$i])) {
				$content .=  "</span>";
			}
			
			$i++;
		}
// print post metadata
		if ($show_meta) {
			$content .= '<small><p class="p_metadata_class">&nbsp;&nbsp;&nbsp;';
//			$content .= "<b>Posted:</b> ".$post->post_date." | <b>Author:</b> ".get_the_author_login();
			ob_start();
//			echo " | <b>Last Modified:</b> ";
//			the_modified_date( ' Y-m-d ');                                    //date
//			the_modified_date('H:i');                                         //time
			comments_popup_link(' No Comments &#187;', ' 1 Comment &#187;', ' % Comments &#187;');
			$content .= ob_get_clean();
			$content .= " | <b>Filed under:</b> ".get_my_cats($post->ID)."&nbsp;&nbsp;|&nbsp;&nbsp;<b>Tags:</b> ".get_my_tags($post->ID);
			$content .= '</p></small>';
		}
// end of metadata

    	if ($show_as_list) 
			$content .= "</li> <hr class=\"tpg_get_post_hr\" />";
	}	
	
	if ($show_as_list)
		$content .= '</ul>';
	$content .= '</div><!-- #tpg-get-posts -->';
	$post = $tmp_post;            //restore current page/post settings
	return $content;	
}

add_shortcode('tpg_get_posts', 'tpg_get_posts_gen');
?>
