jQuery(document).ready(function($){
	
	"use strict";

	// Top Widget
	var $dropDownWrapper = $( '#top-widget .widget-content' );
		
		$dropDownWrapper.css('height',0);

		if ( $dropDownWrapper.length ) { 
				
			$('.actions-top-widget a').click(function() {
				
				var pageHeight = $('.top-widget-container').height() + 0; 
				var wrapperHeight = $dropDownWrapper.height();				
				if( wrapperHeight == 0 ) {
					$dropDownWrapper.animate( { height: pageHeight }, 500, 'easeOutQuad', function() {
						$(this).css('height', 'auto');
						$('.top-widget').addClass( "active" );
					});
				}
				else {
					$dropDownWrapper.animate( { height: 0 }, 500, 'easeInQuad' );
					$('.top-widget').removeClass( "active" );
				}
				
				$( 'body, html' ).animate({ scrollTop: 0 }, 200, 'easeInQuad' );
				
			});
			
		}

	// Images Popup Effect
	jQuery('.image-link').magnificPopup({
		type: 'image',
	    closeOnContentClick: true,
	    closeBtnInside: false,
	    fixedContentPos: true,
	    mainClass: 'mfp-no-margins mfp-with-zoom', 
	    image: {
	        verticalFit: true
	    }
	});

	// Main Menu
	jQuery('ul.sf-menu').superfish({
		  animation:     {height:'show'},   
		  animationOut:  {height:'hide'}, 
		  speed:         'fast',           
		  speedOut:      'fast', 
		  delay:         800,           
	});

	// Portfolio Images Hover Effect
	jQuery('.portfolio-item').hover(function() {
		jQuery(this).find('.portfolio-content').stop().animate({'opacity' : 1}, 200, 'easeOutQuad');
		jQuery(this).find('.portfolio-link').stop().animate({'top' : jQuery(this).height()/2-54, 'opacity' : 1}, 160, 'easeOutQuad');
		jQuery(this).find('.portfolio-title').stop().animate({'bottom' : 0, 'opacity' : 1}, 160, 'easeOutQuad');
	}, function(){
		jQuery(this).find('.portfolio-content').stop().animate({'opacity' : 0}, 300, 'easeInQuad');
		jQuery(this).find('.portfolio-link').stop().animate({'top' : -25, 'opacity' : 0}, 260, 'easeInQuad');
		jQuery(this).find('.portfolio-title').stop().animate({'bottom' : -50, 'opacity' : 0}, 260, 'easeInQuad');
	});

	// Blog Post Images Hover Effect
	jQuery('.blog-item-image').hover(function() {
		jQuery(this).find('.blog-item-image-cover').stop().animate({'opacity' : 1}, 200, 'easeOutQuad');
		jQuery(this).find('.blog-item-image-cover-link').stop().animate({'top' : jQuery('.blog-item-image-cover').height()/2-20, 'opacity' : 1}, 160, 'easeOutQuad');
	}, function(){
		jQuery(this).find('.blog-item-image-cover').stop().animate({'opacity' : 0}, 300, 'easeInQuad');
		jQuery(this).find('.blog-item-image-cover-link').stop().animate({'top' : -25, 'opacity' : 0}, 260, 'easeInQuad');
	});

	// Accordion
	var allPanels = $('.accordion > .inner').hide();
    
  	$('.accordion > .title > a').click(function() {
		var $this = $(this);
		var $target =  $this.parent().next();

		if(!$target.hasClass('active')){
			allPanels.slideUp(400, 'easeOutCirc');
			$target.slideDown(400, 'easeOutCirc');
			$this.parent().parent().find('.title').removeClass('active');
			$this.parent().addClass('active');
		}
      
    	return false;
  	});

  	// Toggle
  	$('.toggle').click(function () {

		var toggle = $(this).children('div.panel');
		var title = $(this).children('.title');

		if (toggle.is(':hidden')) {
			toggle.slideDown('200');	
			title.addClass( "active" );	
		} else {
			toggle.slideUp('200');
			title.removeClass( "active" );		
		}
		
	});

  	// Skill Bar
    setTimeout(function(){
		$('.skill-bar .skill-bar-content').each(function() {
			var me = $(this);
			var perc = me.attr("data-percentage");
			var current_perc = 0;
			var progress = setInterval(function() {
				if (current_perc>=perc) {
					clearInterval(progress);
				} else {
					current_perc +=1;
					me.css('width', (current_perc)+'%');
				}
				me.text((current_perc)+'%');
			}, 10);
		});
	},10);

    // Chart
    jQuery('.chart').each(function(){
		jQuery(this).easyPieChart({
			easing: 'easeOutBounce',
			onStep: function(from, to, percent) {
				$(this.el).find('.percent').text(Math.round(percent));
			},
			size: 160,
			lineWidth: 10,
			barColor: jQuery(this).data('barcolor'),
			trackColor: '#f1f1f1',
		});
	});

    // Notification
    $(".notification a.close").click(function(){
		$(this).parent().slideUp();
		return false;
	});


    jQuery(window).load(function(){
		var jQuerycontainer = jQuery('#portfolio-filter');
			jQuerycontainer.isotope({
				itemSelector: '.element',
				layoutMode: 'fitRows',
				animationEngine : 'best-available',
			  	animationOptions: {
			     	duration: 200,
			     	easing: 'easeInOutQuad',
			     	queue: false
			   	}
	    });

		jQuery(window).resize(function() {
			jQuerycontainer.isotope('reLayout');
		});

		// Portfolio Filter
	    var jQueryoptionSets = jQuery('#options'),
	        jQueryoptionLinks = jQueryoptionSets.find('a');
	    jQueryoptionLinks.click(function () {
	        var jQuerythis = jQuery(this);
	        if (jQuerythis.hasClass('selected')) {
				return false;
	        }
	        var jQueryoptionSet = jQuerythis.parents('.option-set');
	        jQueryoptionSet.find('.selected').removeClass('selected');
	        jQuerythis.addClass('selected');
	        var options = {},
	        key = jQueryoptionSet.attr('data-option-key'),
	            value = jQuerythis.attr('data-option-value');
	        value = value === 'false' ? false : value;
	        options[key] = value;
	        if (key === 'layoutMode' && typeof changeLayoutMode === 'function') {
	            changeLayoutMode(jQuerythis, options)
	        } else {
	            jQuerycontainer.isotope(options);
	        }
	        return false;
	    });
	});

    // Media Element
    $('audio,video').mediaelementplayer({
		// automatically create these translations on load
		translations:['es','ar','yi','zh-cn'],
		// all the user to add additional translations
		translationSelector: true,
		// start with English automatically turned on
		startLanguage: 'en',
	});

    // Mansory Blog Archive
	$('.mansory').masonry();

	// Tab Functions
	(function ($) {
	$.fn.tabset = function () {
	    var $tabsets = $(this);
	    $tabsets.each(function (i) {
	        var $tabs = $('li.tab a', this);
	        $tabs.click(function (e) {
	            var $this = $(this);
	            var panels = $.map($tabs, function (val, i) {
	                    return $(val).attr('href');
	                });
	            $(panels.join(',')).hide();
	            $tabs.removeClass('selected');
	            $this.addClass('selected').blur();
	            $($this.attr('href')).show();
	            e.preventDefault();
	            return false;
	        }).first().triggerHandler('click');
	    });
	};
	})(jQuery);

	$('div.tabset').tabset();

	// FitVids
	$(".blog-item-media, .embed_content").fitVids();

	// Content Slider
	$('.content-slider').flexslider({
	    animation: "slide",
	    controlNav: false,
	    directionNav: true,
	    prevText: "&#xf104;",
    	nextText: "&#xf105;",
    	slideshowSpeed: 10000,
    	animationSpeed: 1600,
	});

	// Blog Post Slider
	$('.slider').flexslider({
	    animation: "slide",
	    controlNav: false,
	    directionNav: true,
	    prevText: "&#xf104;",
    	nextText: "&#xf105;",
    	start: function(slider) {
           $('.slider').removeClass('loading');
       }
	});

	// Top Header News Slides
	$('.news-slides').flexslider({
	    direction: "vertical",
	    controlNav: false,
	    directionNav: false,
	    prevText: "&#xf104;",
    	nextText: "&#xf105;",
	});

	// scroll back to top
	(function($){$.fn.backToTop=function(options){var $this=$(this);$this.hide().click(function(){$("body, html").animate({scrollTop:"0px"});});var $window=$(window);$window.scroll(function(){if($window.scrollTop()>0){$this.fadeIn();}else{$this.fadeOut();}});return this;};})(jQuery);

	// adding back to top button
	jQuery('body').append('<a class="back-to-top"><i class="icon-angle-up"></i></a>');
	jQuery('.back-to-top').backToTop();

	// Responsive Mobile Menu
	var navList = jQuery('header .menu > ul').clone();
    var etOpener = '<span class="open-child"><i class="icon-angle-down"></i></span>';
    navList.removeClass().addClass('mobile-menu');
    
    
	navList.find('li:has(ul)',this).each(function() {
		jQuery(this).prepend(etOpener);
	})
    
    navList.find('.open-child').toggle(function(){
        jQuery(this).parent().addClass('over').find('>ul').slideDown(200);
    },function(){
        jQuery(this).parent().removeClass('over').find('>ul').slideUp(200);
    });
    
    jQuery('#mobile-menu .mobile-menu-container').after(navList[0]);
    jQuery('.logo').after('<span class="menu-title"><i class="icon-reorder"></i></span>');
    
    jQuery('.menu-title').toggle(function(){
        jQuery('.mobile-menu').slideDown(200);
        jQuery('.menu-title').addClass('active');
    },function(){
        jQuery('.mobile-menu').slideUp(200);
        jQuery('.menu-title').removeClass('active');
    });

    // Eqal Height
    function equalHeight(group) {
		var tallest = 0;
		group.each(function() {
			var thisHeight = $(this).height();
			if(thisHeight > tallest) {
				tallest = thisHeight;
			}
		});
		group.height(tallest);
	}

	equalHeight($('.related-post-item'));

});