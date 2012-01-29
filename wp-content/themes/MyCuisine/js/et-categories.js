jQuery(document).ready(function() {
	var $custom_portfolio_box = jQuery('#et_custom_settings'),
		$et_featured_options = $custom_portfolio_box.find('#et_settings_featured_options > div'),
		$et_settings_portfolio_options = $custom_portfolio_box.find('#et_settings_portfolio_options > div');
	
	if ($custom_portfolio_box.find('input#et_is_featured:checked').length) {
		$custom_portfolio_box.find('#et_settings_featured_options > div').css('display','block');
	}
	
	if ($custom_portfolio_box.find('input#et_is_page_portfolio:checked').length) {
		$custom_portfolio_box.find('#et_settings_portfolio_options > div').css('display','block');
	}
	
	$custom_portfolio_box.find('input#et_is_featured').click(function(){
		if (jQuery(this).attr('checked')) {
			$et_featured_options.css({'display':'block','opacity':'0'}).animate({opacity:1},500);
		} else {
			$et_featured_options.css({'display':'block'}).animate({opacity:0},500,function(){
				jQuery(this).css('display','none');
			});
		}
	});
	
	$custom_portfolio_box.find('input#et_is_page_portfolio').click(function(){
		if (jQuery(this).attr('checked')) {
			$et_settings_portfolio_options.css({'display':'block','opacity':'0'}).animate({opacity:1},500);
		} else {
			$et_settings_portfolio_options.css({'display':'block'}).animate({opacity:0},500,function(){
				jQuery(this).css('display','none');
			});
		}
	});
});