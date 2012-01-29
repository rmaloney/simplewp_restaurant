jQuery.noConflict();

jQuery(document).ready(function(){
	var $featured_content = jQuery('#featured'),
		et_disable_toptier = jQuery("meta[name=et_disable_toptier]").attr('content'),
		et_cufon = jQuery("meta[name=et_cufon]").attr('content'),
		et_featured_slider_auto = jQuery("meta[name=et_featured_slider_auto]").attr('content'),
		et_featured_auto_speed = jQuery("meta[name=et_featured_auto_speed]").attr('content');

	if ( et_cufon == 1 ) {
		Cufon.replace('.home-block h3.title, .home-block h4.title, p.author, #sidebar h4.widgettitle, .post h1, .post h2, .post h3, .post h4, .post h5, .post h6, h4.widgettitle, h3#comments, .comment-meta, span.hours_of_work, h2.category_name, h3#reply-title span',{textShadow:'1px 1px 1px #fff'})('#page-top h1.category-title, #page-top h2.title, span.price-tag',{textShadow:'1px 1px 1px rgba(0,0,0,0.6)'});
	}

	jQuery('ul.nav').superfish({ 
		delay:       200,                            // one second delay on mouseout 
		animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
		speed:       'fast',                          // faster animation speed 
		autoArrows:  true,                           // disable generation of arrow mark-up 
		dropShadows: false                            // disable drop shadows 
	});

	jQuery('ul.nav > li > a.sf-with-ul').parent('li').addClass('sf-ul');

	if ( $featured_content.length ) {
		(function($){
			$.fn.et_switcher = function(options)
			{
				var defaults =
				{
				   slides: '>div',
				   activeClass: 'active',
				   linksNav: '',
				   findParent: true, //use parent elements in defining lengths
				   lengthElement: 'li', //parent element, used only if findParent is set to true
				   useArrows: false,
				   arrowLeft: 'prevlink',
				   arrowRight: 'nextlink',
				   auto: false,
				   autoSpeed: 5000
				};

				var options = $.extend(defaults, options);

				return this.each(function()
				{
					var slidesContainer = jQuery(this);
					slidesContainer.find(options.slides).hide().end().find(options.slides).filter(':first').css('display','block');
			 
					if (options.linksNav != '') {
						var linkSwitcher = jQuery(options.linksNav);
										
						linkSwitcher.click(function(){
							var targetElement;

							if (options.findParent) targetElement = jQuery(this).parent();
							else targetElement = jQuery(this);
													
							if (targetElement.hasClass('active')) return false;
							
							targetElement.siblings('.active').removeClass('active');
							targetElement.addClass('active');
								
							var ordernum = targetElement.prevAll(options.lengthElement).length;
						
							slidesContainer.find(options.slides).filter(':visible').hide().end().end().find(options.slides).filter(':eq('+ordernum+')').stop(true,true).fadeIn(700);
													
							if (typeof interval != 'undefined') {
								clearInterval(interval);
								auto_rotate();
							};
							
							return false;
						});
					};
					
					jQuery('#'+options.arrowRight+', #'+options.arrowLeft).click(function(){
					  
						var slideActive = slidesContainer.find(options.slides).filter(":visible"),
							nextSlide = slideActive.next(),
							prevSlide = slideActive.prev();

						if (jQuery(this).attr("id") == options.arrowRight) {
							if (nextSlide.length) {
								var ordernum = nextSlide.prevAll().length;                        
							} else { var ordernum = 0; }
						};

						if (jQuery(this).attr("id") == options.arrowLeft) {
							if (prevSlide.length) {
								var ordernum = prevSlide.prevAll().length;                  
							} else { var ordernum = slidesContainer.find(options.slides).length-1; }
						};

						slidesContainer.find(options.slides).filter(':visible').hide().end().end().find(options.slides).filter(':eq('+ordernum+')').stop(true,true).fadeIn(700);

						if (typeof interval != 'undefined') {
							clearInterval(interval);
							auto_rotate();
						};

						return false;
					});   

					if (options.auto) {
						auto_rotate();
					};
					
					function auto_rotate(){
						interval = setInterval(function(){
							var slideActive = slidesContainer.find(options.slides).filter(":visible"),
								nextSlide = slideActive.next();
						 
							if (nextSlide.length) {
								var ordernum = nextSlide.prevAll().length;                        
							} else { var ordernum = 0; }
						 
							if (options.linksNav === '') 
								jQuery('#'+options.arrowRight).trigger("click");
							else 		 		
								linkSwitcher.filter(':eq('+ordernum+')').trigger("click");
						},options.autoSpeed);
					};
				});
			}
		})(jQuery);
		
		var et_featured_options = {
			linksNav: '#switcher a',
			auto: false,
			autoSpeed: et_featured_auto_speed,
			findParent: false,
			lengthElement: 'a'
		}
		
		if ( et_featured_slider_auto == 1 ) et_featured_options.auto = true;
			
		$featured_content.et_switcher(et_featured_options);
		
		var $controllers_box = jQuery('#controllers #switcher'),
			controllers_offset = Math.round( ( 960 - ( $controllers_box.width() ) ) / 2 );
		
		$controllers_box.css('marginLeft',controllers_offset);
	}
		
	var $footer_widget = jQuery("#footer-widgets .footer-widget");
	if ( $footer_widget.length ) {
		$footer_widget.each(function (index, domEle) {
			if ((index+1)%3 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
		});
	}

	et_search_bar();

	function et_search_bar(){
		var $searchform = jQuery('#breadcrumbs div#search-form'),
			$searchinput = $searchform.find("input#searchinput"),
			searchvalue = $searchinput.val();
			
		$searchinput.focus(function(){
			if (jQuery(this).val() === searchvalue) jQuery(this).val("");
		}).blur(function(){
			if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
		});
	}

	if ( et_disable_toptier == 1 ) jQuery("ul.nav > li > ul").prev("a").attr("href","#");
			 
	if ( et_cufon == 1 ) Cufon.now();
});