jQuery(document).ready(function($) {

	'use strict';

	WPX.Layout = {

		init: function() {

			// events
			this.bindEvents();

			// layout
			this.bindBreakpoints();

		},

		/** 
		 * bind all events
		*/
		bindEvents: function() {

			// responsive video
			$(".flex-video").fitVids();

			// inline retina images
			$('img.retina[data-2x]').dense();

			// on scroll throttle
			$(window).scroll( $.throttle( 10, function() { 

			} ) );

			// on resize throttle
			$(window).resize( $.throttle( 10, function() { 
				
			} ) );

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