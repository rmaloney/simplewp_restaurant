var $jq=jQuery.noConflict();$jq(document).ready(function(){$jq(".updated").fadeIn(1000).fadeTo(1000,1).fadeOut(1000);
$jq('.click').click(function(){var id=$jq(this).attr('id');$jq('#box'+id).slideToggle('slow',function(){})})
});

$jq(document).ready(function(){$jq('#textColor, #bgColor, #boundaryColor, #borderColor').ColorPicker({onShow:function(colpkr){$jq(colpkr).fadeIn(500);return false},onHide:function(colpkr){$jq(colpkr).fadeOut(500);return false},onSubmit:function(hsb,hex,rgb,el){$jq(el).val(hex);$jq(el).ColorPickerHide()},onBeforeShow:function(){$jq(this).ColorPickerSetColor(this.value)}}).bind('keyup',function(){$jq(this).ColorPickerSetColor(this.value)})});