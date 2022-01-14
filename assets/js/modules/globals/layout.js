jQuery(document).ready(function($) {

	'use strict';

	WPX.Layout = {

		$loader: WPX.Utils.ctrl('loader'),
		$loaderBar: WPX.Utils.target('loader', 'bar'),
		totalImageCount: $('body img').size(),
		$body: $('body'),

		init: function() {

			// page transition fx
			pageTransition();

			// fade in
			this.fadeInPage();

			// events
			this.bindEvents();

		},

		/** 
		 * bind all events
		*/
		bindEvents: function() {

			// inline retina images
			$('img.retina').dense();
			$('.retina img').dense();

			// micromodal
			MicroModal.init({
				onShow: function(modal){
					WPX.Layout.modalOpen(modal);
				},
				onClose: function(modal){
					WPX.Layout.modalClose(modal);
				},
				openClass: 'is-open',
				disableScroll: true,
			});

			// fitvids
			$('.flex-video').fitVids();

			// on scroll throttle
			$(window).scroll( $.throttle( 10, function() { 

			} ) );

			// on resize throttle
			$(window).resize( $.throttle( 10, function() { 
				
			} ) );

		},

		modalOpen: function(modal) {
			console.log('Modal Open');
		},

		modalClose: function(modal) {
			console.log('Modal Closed');
		},

		/**
		 * gentle fade in
		 */
		fadeInPage: function() {

			WPX.Layout.$body.imagesLoaded().always( function( instance ) {
				WPX.Layout.$loader.fadeOut(500, function() {
					WPX.Layout.$loader.addClass('hide');
				});
			}).progress( function( instance, image ) {

				if(image.isLoaded) {
					$(image.img).addClass('loaded');
					var countLoadedImages = $('body img.loaded').size();
					var width = 100 * (countLoadedImages / WPX.Layout.totalImageCount) + '%';
					WPX.Layout.$loaderBar.css({
						'width' : width
					});
				}

			});

		},

		/**
		 * trigger js on breakpoints
		 */
		bindBreakpoints: function() {

			enquire
			.register("screen and (min-width: 801px)", {

				// desktop
				match: function() {},

				// tablet
				unmatch: function() {}

			})
			.register("screen and (max-width: 800px)", {

				// tablet
				match: function() {},

				// desktop
				unmatch: function() {}

			})
			.register("screen and (max-width: 500px)", {

				// mobile
				match: function() {},

				// tablet
				unmatch: function() {}
			});

		}

	};

	WPX.Layout.init();

});