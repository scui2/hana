jQuery(document).ready(function($){

	$(document).foundation();	
        		
    var backtotop = $('.back-to-top');   
	// Back-to-top Script
	backtotop.hide();
	$('.back-to-top a').click(function (e) {
		e.preventDefault();
		$('body,html,header').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
	$(window).scroll(function () {
		var scrollPos = $(window).scrollTop();
		if (scrollPos > 500) {
			backtotop.fadeIn();
		} else {
			backtotop.fadeOut();
		}	
	});
	// Search Focus
    $(window).on(
        'open.zf.reveal', function () {
			$('#modelSearch' ).find( '.search-query' ).each(function(){
       			$(this).focus();
       			var searchStr = $(this).val();
				$(this).val('');
				$(this).val(searchStr);
   			});
        }  
    );
    // Toggle Class
	$('.hana-toggle').click(function (e) {
		$(this).toggleClass('is-open');
		return false;
	});    
    // Shrinking Topbar
	var stickyContainer = $('.sticky');
	stickyContainer.on('sticky.zf.stuckto:top', function(){
		var shrinkTopBar = stickyContainer.attr('data-shrink');
		if (shrinkTopBar !== undefined) {
	  		stickyContainer.find('.top-bar').addClass('shrunk');

		}
	}).on('sticky.zf.unstuckfrom:top', function(){
		var shrinkTopBar = stickyContainer.attr('data-shrink');
		if (shrinkTopBar !== undefined) {
	  		stickyContainer.find('.top-bar').removeClass('shrunk');
  			setTimeout(hanaAdjustHeader, 510);	
		}
	});
		
    //Resize
    var slider;
	$(window).on("orientationchange resize", function () {
		if ( $("#offCanvasLeft").length !== 0 ) {
			$("#offCanvasLeft").foundation("close");
		}
		$(".sticky").foundation('_calc', true);
		if ( slider ) {
			slider.reloadSlider();			
		}
		hanaAdjustHeader();
	});
// Ticker
	if ( $('.hanaTicker').length !== 0 ) {
		$('.hanaTicker').bxSlider({
  			minSlides: hanaTicker.minSlides,
  			maxSlides: hanaTicker.maxSlides,
  			slideWidth: hanaTicker.slideWidth,
  			slideMargin: 20,
  			ticker: true,
  			speed: hanaTicker.speed * 1000,
  			tickerHover: true,
  			useCSS: false,
			onSliderLoad: function(){
        		$(".featured-content").css("visibility", "visible");
        		$(".featured-content").css("height", "auto");
      		}
		});
	}
//Slider
	if ( $('.hanaSlider').length !== 0 ) {
		slider = $('.hanaSlider').bxSlider({
			auto: true,
			mode: hanaSlider.mode,
			pause: hanaSlider.speed * 1000,
			speed: 1000,
  			useCSS: true,
			adaptiveHeight: true,
			onSliderLoad: function(){
        		$(".featured-content").css("visibility", "visible");
        		$(".featured-content").css("height", "auto");
      		}
		});
	}
//Adjust header
	hanaAdjustHeader();
	function hanaAdjustHeader() {
		if  ( $('.fullwidth-slider .featured-content-full').length !== 0 && $(window).scrollTop() === 0 ) {
			var  hwHeight = 0;
			if($('.top-bar').is(':visible')) {
				hwHeight = $(".top-bar").outerHeight( false );
			}
			var cssStr = '-' + hwHeight + 'px';	
			$(".fullwidth-slider .featured-content-full").css("margin-top",cssStr);					
		}
	}	
//Portfolio Ajax Loading
	if  ( $('.portfolio').length !== 0 ) {
		var page = 2;
		var loading = false;

		$('body').on('click', '.portfolio .load-more', function(){
			if( ! loading ) {
				$('.portfolio .load-more').remove();
				loading = true;
				var data = {
					action: 'hana_portfolio_load_more',
					nonce: hanaloadmore.nonce,
					page: page,
					column: hanaloadmore.column,
					thumbnail: hanaloadmore.thumbnail,
					query: hanaloadmore.query,
				};
				$.post(hanaloadmore.url, data, function(res) {
					if( res.success) {
						$('.portfolio').append( res.data );
						if ( hanaloadmore.column > 1 ) {
							var newHanaEqualizer = new Foundation.Equalizer($(".portfolio"), {
 								equalizeOnStack: false,equalizeByRow: true, equalizeOn: 'medium'
							});					
						}
						page = page + 1;				
						loading = false;
					} else {
					 	//console.log(res);
					}
				}).fail(function(xhr, textStatus, e) {
					 //console.log(xhr.responseText);
				});
			}
		});	
	} //Portfolio

});
