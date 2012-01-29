/*********************************************************
* TRUEedit JavaScript Support Library
* Package: TRUEedit
* Author: Zachary Segal
* Author URI: http://www.illproductions.com/
**********************************************************/
jQuery(document).ready(function() {
	
	// allow a user to enter a tab into a textarea with their keyboard
	jQuery('#content').bind('keydown', function(event) {
		var item = this;
		if(navigator.userAgent.match("Gecko")){
			c = event.which;
		}else{
			c = event.keyCode;
		}
		
		if(c == 9){
			var textarea_top = jQuery(item).scrollTop();
			replaceSelection(item,String.fromCharCode(9));
			jQuery("#"+item.id).focus();
			jQuery(item).scrollTop(textarea_top);
			return false;
		}
		
	});
	
	// stop execution if the add_fullscreen_button variable is not set
	if (typeof add_fullscreen_button == 'undefined') {
		return false;
	}
	
	// stop execution if the add_fullscreen_button variable is false
	if (add_fullscreen_button == false) {
		return false;
	}
	
	// append a full screen button to the admin post editor and bind a click function to it
	jQuery('#ed_toolbar').append('<input type="button" id="ed-trueedit-fullscreen" class="ed_button" value="'+btn_label_one+'" />');
	jQuery('#ed-trueedit-fullscreen').click(function() {
		
		// get the rich or none rich postdiv depending on user's editor settings
		var postdiv = jQuery('#postdivrich');
		if (postdiv.size() > 1) {
			postdiv = jQuery('#postdiv');
		}
		
		// toggle fullscreen class on postdiv element
		var class_name = "trueedit-fullscreen";
		if (postdiv.hasClass(class_name)) {
			postdiv.removeClass(class_name);
			jQuery(this).attr('value', btn_label_one);
		} else {
			postdiv.addClass(class_name);
			jQuery(this).attr('value', btn_label_two);
		}
		
	});
	
})


/*********************************************************
* support functions for inserting tabs into a textarea
**********************************************************/
function replaceSelection (input, replaceString) {
	if (input.setSelectionRange) {
		// Firefox, Safari, Chrome
		
		var selectionStart = input.selectionStart;
		var selectionEnd = input.selectionEnd;
		input.value = input.value.substring(0, selectionStart) + replaceString + input.value.substring(selectionEnd);
		setSelectionRange(input, selectionStart + replaceString.length, selectionStart + replaceString.length);

	} else if (document.selection) {
		// Internet Explorer
		
		var range = document.selection.createRange();
		if (range.parentElement() == input) {
			var isCollapsed = range.text == '';
			range.text = replaceString;
			
			if (!isCollapsed)  {
				range.moveStart('character', -replaceString.length);
				range.select();
			}
		}
	}
}
function setSelectionRange(input, selectionStart, selectionEnd) {
	if (input.setSelectionRange) {
		input.focus();
		input.setSelectionRange(selectionStart, selectionEnd);
	}
	else if (input.createTextRange) {
		var range = input.createTextRange();
		range.collapse(true);
		range.moveEnd('character', selectionEnd);
		range.moveStart('character', selectionStart);
		range.select();
	}
}