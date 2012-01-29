/**
 * Google Map Shortcode 
 * Version: 3.0
 * Author: Alain Gonzalez
 * Plugin URI: http://web-argument.com/google-map-shortcode-wordpress-plugin/
*/

(function ($) {

	 $(window).load(function(){     
	 
		var iconSelect = "";
		
		$(".gmshc_icon,.gmshc_thumb").click(function(){
			gmshc_switchImg($(this)); 
		}).mouseover(function(){
			$(this).css({"border":"solid #BBBBBB 1px"})
		}).mouseout(function(){
			$(this).css({"border":"solid #F9F9F9 1px"})
		});         
		
		$(".insert_map").click(function(){		
			gmshc_add_map();
			parent.tb_remove();			
		});
		
		$(".gmshc_show").click(function(){
			var mapDiv = $("#gmshc_map");
			var refreshMap = $(".gmshc_refresh");
			var mapBtn = $(".gmshc_show");
			if (mapDiv.height() >1) {
				mapDiv.height("0");				
				mapBtn.text(mapBtn.attr("show"));
				refreshMap.hide();
				$("#iframe_sc").hide();
			} else {
				mapDiv.height("440");				
				mapBtn.text(mapBtn.attr("hide"));
				refreshMap.show();
				deploy_map();												
			}
			return false;
		});	
		
		$(".gmshc_refresh").click(deploy_map);		
			
		$("#windowhtml").change(function(){
			$("#gmshc_html_previews").html($(this).val());			
		});
		
		var winHtml = $("#windowhtml").val();
		
		$("#windowhtml").val($.trim(winHtml));
	
	 });
	 
	 function deploy_map(){		 
		urlP = gmshc_generate_sc();
		var iframeUrl = $("#iframe_url").val()+"map=true&"+urlP[1];
		$("#iframe_sc").show().attr("src",iframeUrl);
		$("#gmshc_map").focus();
	 }

	function gmshc_switchImg(obj) {		
		var iconSrc = obj.children("img").attr("src");
		obj.siblings().removeClass('gmshc_selected');			
		obj.addClass('gmshc_selected');		
		obj.siblings("input").val(iconSrc);
		//$("#default_icon").val(iconSrc);
	}
	
     function gmshc_add_map(){
		 
		var str = gmshc_generate_sc();        
		var win = window.dialogArguments || opener || parent || top;
		win.send_to_editor(str[0]);		
   
    }
	
	function gmshc_generate_sc(){
		
        var width = $("#width").val();
		var defaultWidth = $("#default_width").val();
        
		var height = $("#height").val();
		var defaultHeight = $("#default_height").val();
		
		var margin = $("#margin").val();
		var defaultMargin = $("#default_margin").val();
		
		var align = "";
		if($("#aleft").is(':checked')) align = "left"; 
		else if($("#acenter").is(':checked')) align = "center"; 
		else if ($("#aright").is(':checked')) align = "right"; 
		
		var defaultAlign = $("#default_align").val();				
        
		var zoom = $("#zoom").val();
		var defaultZoom = $("#default_zoom").val();
		
		var type = $("#type").val();
		var defaultType = $("#default_type").val();
		
		var focusPoint = $("#focus").val();
		var defaultFocusPoint = $("#default_focus").val();

		var focusType = $("#focus_type").val();
		var defaultFocusType= $("#default_focus_type").val();			
        
        str = "[google-map-sc";
		urlP = "";
		if (width != defaultWidth)
			str += " width=\""+width+"\"";
			urlP += "width="+width+"&";
		if (height != defaultHeight)
			str += " height=\""+height+"\"";
			urlP += "height="+height+"&";
		if (margin != defaultMargin)
			str += " margin=\""+margin+"\"";			
		if (align != defaultAlign)
			str += " align=\""+align+"\"";						
		if (zoom != defaultZoom)
			str += " zoom=\""+zoom+"\"";
			urlP += "zoom="+zoom+"&";
		if(type != defaultType)
			str += " type=\""+type+"\"";
			urlP += "type="+type+"&";	
		if(focusPoint != defaultFocusPoint)
			str += " focus=\""+focusPoint+"\"";
			urlP += "focus="+focusPoint+"&";
		if(focusType != defaultFocusType)
			str += " focus_type=\""+focusType+"\"";
			urlP += "focus_type="+focusType;								
		str +="]";
		
		return [str,urlP]; 		
	}
    
    function gmshc_delete_point(id,msg){
        var answer = confirm(msg);
		alert(answer);
        if (answer) {
        var width = $("#width").val();
        var height = $("#height").val();
        var zoom = $("#zoom").val();        
        var url = "?post_id=<?php echo $post_id ?>&tab=gmshc&delp="+id+"&width="+width+"&height="+height+"&zoom="+zoom;
        window.location = url;
        } else {
        return false;
        }	
    }
 
	 
})(jQuery);
	
	
	