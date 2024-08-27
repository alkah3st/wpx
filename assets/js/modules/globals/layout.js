jQuery(document).ready(function($) {

	'use strict';

	WPX.Layout = {

		$body: $('body'),

		init: function() {

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

			// on scroll throttle
			$(window).scroll( $.throttle( 10, function() { 
				console.log('// WPX: Scrolling...');
			} ) );

			// on resize throttle
			$(window).resize( $.throttle( 10, function() { 
				console.log('// WPX: Resizing...');
			} ) );

		},

		modalOpen: function(modal) {
			console.log('Modal Open');
		},

		modalClose: function(modal) {
			console.log('Modal Closed');
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