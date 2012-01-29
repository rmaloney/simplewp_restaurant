
function print_r(x, max, sep, l) {

	l = l || 0;
	max = max || 10;
	sep = sep || ' ';

	if (l > max) {
		return "[WARNING: Too much recursion]\n";
	}

	var
		i,
		r = '',
		t = typeof x,
		tab = '';

	if (x === null) {
		r += "(null)\n";
	} else if (t == 'object') {

		l++;

		for (i = 0; i < l; i++) {
			tab += sep;
		}

		if (x && x.length) {
			t = 'array';
		}

		r += '(' + t + ") :\n";

		for (i in x) {
			try {
				r += tab + '<br />[' + i + '] : ' + print_r(x[i], max, sep, (l + 1));
			} catch(e) {
				return "[ERROR: " + e + "]\n";
			}
		}

	} else {

		if (t == 'string') {
			if (x == '') {
				x = '(empty)';
			}
		}

		r += '(' + t + ') ' + x + "\n";

	}

	return r;

};

function getFormFieldValue(field_name, formData) {
	for(var i = 0; i < formData.length; i++) {
		if (formData[i].name == field_name) {
			return formData[i].value;
		}
	}
	return false;
};

/*function pageselectCallback(page_index, jq){
	rows = $j('#form-submissions-hidden > tr')
	items_per_page = 5;
	max_elem = Math.min((page_index+1) * items_per_page, rows.length);
	var new_content = '';
	for(var i=page_index*items_per_page;i<max_elem;i++) {
		if (rows.eq(i) != null) {
			new_content += '<tr class="' + rows.eq(i).attr('class') + '">' + rows.eq(i).html() + '</tr>';
			i += 1;
			new_content += '<tr class="' + rows.eq(i).attr('class') + '">' + rows.eq(i).html() + '</tr>';
		} else i += 1;
	}
	if (new_content != '' && new_content != null)
		$j('#form-submissions-table tbody').empty().append(new_content);
	$j('.submission-content').hide();
	$j('.submission-content-expand-button').click(function() {
		$j(this)
		.parent()
		.parent()
		.parent()
		.next()
		.toggle();
	});
	return false;
}
           
function initPagination() {
	// Create content inside pagination element
	var num_entries = $j('#form-submissions-hidden > tr').length;
	$j("#form-submissions-pagination").pagination(num_entries, {
		callback: pageselectCallback,
		items_per_page: 5 // Show only one item per page
	});
}*/

$j.preloadImages(ccfAjax.plugin_dir + "/images/wpspin_light.gif"); // preload loading image
$j(document).ready(function() {
	
	//initPagination();
	$j('.ccf-edit-ajax').attr("action", ccfAjax.url);
	
	var loading_img = null;
	var form_dom = null;
	$j('.ccf-edit-ajax').ajaxForm({
		data: { action: 'ccf-ajax', nonce: ccfLang.nonce },
		beforeSubmit: function(formData, jqForm, options)  {
			var action_type = getFormFieldValue('object_bulk_action', formData);
			//var bulk_apply_button = getFormFieldValue('object_bulk_action', formData);
			var attach_button = getFormFieldValue('buttons', formData);
			var detach_button = getFormFieldValue('object_bulk_action', formData);
			if (action_type == 0) return false;
			bulk_button = jqForm.find("input[name=object_bulk_apply]");
			form_dom = jqForm;
			loading_img = jqForm.find(".loading-img").fadeIn();
			return true;
		},
		success : function(responseText) {
			if (responseText.objects) {
				for (var i = 0; i < responseText.objects.length; i++) {
					var this_object = responseText.objects[i];
					if (responseText.object_bulk_action == 'delete') {
						
						form_dom.find(".row-" + this_object.object_type + "-" + this_object.object_id).hide().remove();
						if (this_object.object_type == "style") {
							/* delete occurences of this option within style dropdowns. */
							var style_inputs = $j(".form_style_input");
							style_inputs.each(function() {
								this_option = $j(this).find("option[value=" + this_object.object_id + "]");
								if (this_option.attr("selected") == "selected")
									$j(this).find("option[value=0]").attr("selected", "selected");
								this_option.remove();
							});
						} else if (this_object.object_type == "field" || this_object.object_type == "field_option") {
							if (this_object.object_type == "field")
								var fields_options_input = $j("select.detach-field");
							else
								var fields_options_input = $j("select.detach-field-option");
							fields_options_input.each(function () {
								var this_obj = $j(this);
								var this_option = this_obj.find("option[value=" + this_object.object_id + "]");
								if (this_option.length >=1 && this_obj.find("option").length <= 1) {
									$j("<option>")
										.attr("value", "-1")
										.text(ccfLang.nothing_attached)
										.prependTo(this_obj);
								}
								this_option.remove();
							});
							if (this_object.object_type == "field")
								fields_options_input = $j("select.attach-field option[value=" + this_object.object_id + "]");
							else
								fields_options_input = $j("select.attach-field-option option[value=" + this_object.object_id + "]");
							
							fields_options_input.each(function () {
								$j(this).remove();
							});
						}
					} else if (responseText.object_bulk_action == 'edit') {
						/* TODO: update field and field option slug dropdowns */
						if (responseText.objects[i].object_type == "field" || responseText.objects[i].object_type == "field_option") {
							
						}
					}
				}
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
		debug = fx.initDebugWindow();
					$j("<div></div>").html(textStatus + " " + errorThrown).appendTo(debug);
			//alert(textStatus + " " + errorThrown);
		},
		complete: function() {
			//j("test").html(data).appendTo(debug);
			loading_img.fadeOut();
		}
	});

	//form_submissions = $j("#form-submissions-table tbody").clone();
	//$j("#form-submissions-hidden").html(form_submissions.html());
	
	$j("span.attach-lang").remove();
	$j(".attach-check").each(function(){
		var name = $j(this).attr('name');
		var html = '<input class="attach-button" type="button" name="' + name + '" value="' + ccfLang.attach_button + '" />';
		$j(this).after(html).remove(); // add new, then remove original input
	});
	$j(".attach-button").live("click", function() {
		var object_type = $j(this).parents().find(".object-type").attr("value");
		var attach_object_field = $j(this).parents().find(".attach-object:first");
		var object_id = attach_object_field.attr("class").split(' ')[0].replace(/[^0-9]*([0-9]*)/, "$1");
		var detach_object_field = $j(this).parents().find(".detach-object:first");
		var attach_object_id = attach_object_field.attr("value");
		var attach_object_slug = attach_object_field.find("option[value=" + attach_object_id + "]:eq(0)").first().text();
		pattern = new RegExp('<option value="' + attach_object_id + '">', "i");
		str = detach_object_field.html();
		if (!str.match(pattern)) {
			var save_box = fx.initSaveBox(ccfLang.attaching);
			$j.ajax({
				type: "POST",
				url: ccfAjax.url,
				data: "nonce=" + ccfLang.nonce + "&action=ccf-ajax&object_attach=1&attach_object_id=" + attach_object_id + "&object_id=" + object_id + "&object_type=" + object_type,
				success: function(data) {
					new_option = $j("<option></option>").attr("value", attach_object_id).text(attach_object_slug); 
					detach_object_field.append(new_option);
					detach_object_field.find('option[value=-1]').remove();
					
				},
				error: function() { alert(ccfLang.error); },
				complete: function() { $j(".save-box").fadeOut().remove(); }
			});
		}
	});
	
	$j("span.detach-lang").remove();
	$j(".detach-check").each(function(){
		var name = $j(this).attr('name');
		var html = '<input class="detach-button" type="button" name="' + name + '" value="' + ccfLang.detach_button + '" />';
		$j(this).after(html).remove(); // add new, then remove original input
	});
	$j(".detach-button").live("click", function() {
		var object_type = $j(this).parents().find(".object-type").attr("value");
		var detach_object_field = $j(this).parents().find(".detach-object:first");
		var object_id = detach_object_field.attr("class").split(' ')[0].replace(/[^0-9]*([0-9]*)/, "$1");
		var detach_object_id = detach_object_field.attr("value");
		if (detach_object_id != "-1") {
			var detach_object_slug = detach_object_field.find("option[value=" + detach_object_id + "]:eq(0)").first().text();
			var save_box = fx.initSaveBox(ccfLang.detaching);
			$j.ajax({
				type: "POST",
				url: ccfAjax.url,
				data: "nonce=" + ccfLang.nonce + "&action=ccf-ajax&object_detach=1&detach_object_id=" + detach_object_id + "&object_id=" + object_id + "&object_type=" + object_type,
				success: function(data) {
					pattern = new RegExp('<option[^>]*?value="?' + detach_object_id + '"?[^>]*?>.*?<\/option>', "i");
					//alert('<option value="' + detach_object_id + '">.*?<\/option>');
					//alert(detach_object_field.html().match(pattern));
					new_options = detach_object_field.html().replace(pattern, '');
					//alert(new_options);
					var patt = /<\/option>/i;
					if (!new_options.match(patt)) new_options = '<option value="-1">Nothing Attached!</option>';
					detach_object_field.html(new_options);
				},
				error: function() { alert(ccfLang.error); },
				/*beforeSubmit: function() {
					debug = fx.initDebugWindow();
					$j("<div></div>").html(textStatus + " " + errorThrown).appendTo(debug);
				},*/
				complete: function() { $j(".save-box").fadeOut().remove(); }
			});
		}
	});
		
});