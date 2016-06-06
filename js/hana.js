jQuery(document).ready(function($){

	$(document).foundation();	
        		
    var backtotop = $('.back-to-top');   
	// Back-to-top Script
	backtotop.hide();
	$('.back-to-top a').click(function () {
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
    // Shrinking Topbar
	var stickyContainer = $('.sticky');
	stickyContainer.on('sticky.zf.stuckto:top', function(){
  		stickyContainer.find('.top-bar').addClass('shrunk');
	}).on('sticky.zf.unstuckfrom:top', function(){
  		stickyContainer.find('.top-bar').removeClass('shrunk');
	});
    //Resize
    var slider;
	$(window).on("orientationchange resize", function () {
		$("#offCanvasLeft").foundation("close");
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
			adaptiveHeight: true,
			onSliderLoad: function(){
        		$(".featured-content").css("visibility", "visible");
        		$(".featured-content").css("height", "auto");
      		},
		});
	}
//Adjust header
	hanaAdjustHeader();
	function hanaAdjustHeader() {
		if  ( $('.featured-content-full').length !== 0 ) {
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
		var button = $('.portfolio .load-more');
		var page = 2;
		var loading = false;

		$('body').on('click', '.load-more', function(){
			if( ! loading ) {
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
						if (res.data !== '' ) {
							$('.portfolio').append( res.data );
							$('.portfolio').append( button );
							var newEqualizer = new Foundation.Equalizer($(".portfolio"), {
 								equalizeOnStack: false,equalizeByRow: true, equalizeOn: 'medium'
							});
							page = page + 1;				
						}
						else {
							button.addClass('hide');
						}
						loading = false;
					} else {
					// console.log(res);
					}
				}).fail(function(xhr, textStatus, e) {
					// console.log(xhr.responseText);
				});
			}
		});
	} //Portfolio

});
