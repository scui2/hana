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
	// Mouse Scroll Check
	var sectionMenu = $('.sectionmenu');
	var leftMenuToggle = $('.top-bar .leftmenu-toggle');
	$(window).scroll(function () {
		hanaScroll();
	});
    hanaScroll();
	function hanaScroll() {
		var scrollPos = $(window).scrollTop();
		if (scrollPos > 500) {
			backtotop.fadeIn();
		} else {
			backtotop.fadeOut();
		}
		if ( sectionMenu.length !== 0 && leftMenuToggle.length !== 0) {
			if ( ( sectionMenu.position().top + 40 ) < scrollPos )
				leftMenuToggle.removeClass("hide");
			else
				leftMenuToggle.addClass("hide");
		}
		if ( sectionMenu.length !== 0 && sectionMenu.is(':hidden') ) {
			leftMenuToggle.removeClass("hide");
		}       
	}
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
	});   
	// Show Comments
    var hanaHash = window.location.hash;
	var postCommnet = $('#comments');
	var commentToggle = $('.comment-toggle');
	if ( postCommnet !== undefined ) {
		if ( '#respond' == hanaHash || hanaHash.match('#comment') ) {
			postCommnet.css("display", "block");
			commentToggle.addClass('is-open');
		} else {
			postCommnet.css("display", "none");	
			commentToggle.removeClass('is-open');	
		}		
	}
	$('.comment-link').click(function (e) {
		postCommnet.css("display", "block");
		commentToggle.addClass('is-open');
	});

    // Shrinking Topbar
	var stickyContainer = $('.sticky');
	stickyContainer.on('sticky.zf.stuckto:top', function(){
		var shrinkTopBar = stickyContainer.attr('data-shrink');
		if (shrinkTopBar !== undefined) {
	  		stickyContainer.find('.top-bar').addClass('shrunk');
			if($('.top-bar').is(':visible')) {
                 $('body').addClass('shrunk-header');
			}
        }

	}).on('sticky.zf.unstuckfrom:top', function(){
		var shrinkTopBar = stickyContainer.attr('data-shrink');
		if (shrinkTopBar !== undefined) {
	  		stickyContainer.find('.top-bar').removeClass('shrunk');
            $('body').removeClass('shrunk-header');
  			setTimeout(hanaAdjustHeader, 510);
		}
	});
		
    //Resize
    var slider;
	$(window).on("orientationchange resize", function () {
		if ( $("#offCanvasLeft").length !== 0 ) {
			$("#offCanvasLeft").foundation("close");
		}
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
        		hanaScroll();
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
        		hanaScroll();
      		}
		});
	}
//Adjust header
	hanaAdjustHeader();
	function hanaAdjustHeader() {
		if  ( $('.adjust-header').length !== 0 && $(window).scrollTop() === 0 ) {
			var  hwHeight = 0;
			if($('.top-bar').is(':visible')) {
				hwHeight = $(".top-bar").outerHeight( false );
			}
			var cssStr = '-' + hwHeight + 'px';	
			$(".adjust-header .featured-content").css("margin-top",cssStr);					
		}
	}	
//Portfolio Ajax Loading
	if  ( $('.portfolio').length !== 0 ) {
		var page = 2;
		var loading = false;

		$('body').on('click', '.portfolio .load-more', function(){
			if( ! loading ) {
				$('.portfolio .loadmore-container').remove();
				loading = true;
				var data = {
					action: 'hana_portfolio_load_more',
					nonce: hanaloadmore.nonce,
					page: page,
					column: hanaloadmore.column,
					entry_meta: hanaloadmore.entry_meta,
					thumbnail: hanaloadmore.thumbnail,
					query: hanaloadmore.query,
				};
				$.post(hanaloadmore.url, data, function(res) {
					if( res.success) {
						if ( 1 == hanaloadmore.column ) {
				            $('.portfolio').append( res.data );				
						} else {
                            $('.portfolio-items').append( res.data );	
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
		}).on('click', '.portfolio-toggle', function(){
            var $tags = $(this).data("tag").split(',');
            $(this).toggleClass('disabled');
            console.log( $tags );
        });;	
	} //Portfolio

});
