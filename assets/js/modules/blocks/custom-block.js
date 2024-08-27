jQuery(document).ready(function($) {

	'use strict';

	WPX.CustomBlock = {

		init: function() {

			// events
			this.bindEvents();

		},

		/** 
		 * bind all events
		*/
		bindEvents: function() {},

		initializeBlock: function() {

			console.log('// WPX : Hello, I am a custom block!');

			/*

			var slideshow = $('[data-controller="blockCarousel"]');

			if (slideshow.length) {

				$(slideshow).each(function( idx, item ) {

					$(this).not('.slick-initialized').on('init', function(event, slick){
						$(this).removeClass('is-loading');
					}).slick({
						dots: false,
						slide: '.carousel-slide',
						arrows: true,
						initialSlide: 0,
						slidesToScroll: 1,
						centerMode: true,
						infinite: false,
						variableWidth: true,
						appendArrows: $(this).find('[data-target="BlockCarouselNav"]'),
						nextArrow: '<button class="carousel-next"><i class="icon-left-small"></i></button>',
						prevArrow: '<button class="carousel-back"><i class="icon-right-small"></i></button>',
						adaptiveHeight: false,
						autoplay: false,
						cssEase: 'ease',
						responsive: [
							{
								breakpoint: 680,
								settings: {
									variableWidth: false,
									adaptiveHeight: true,
									centerMode: false,
									slidesToShow: 1
								}
							}
						]
					});

				});

			}

			*/

		}
	};

	WPX.CustomBlock.init();

});