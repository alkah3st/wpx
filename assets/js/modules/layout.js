jQuery(document).ready(function($) {

	'use strict';

	WPX.Layout = {

		init: function() {

			// match all heights
			this.matchHeights();

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
			$('img[data-2x]').dense();

		},

		/*
		matches heights on element pairs
		 */
		matchHeights: function() {

			// match heights
			$('body').imagesLoaded( function() {

				// resize columns
				$('.eq-parent').each( function(i, equalizer) {
					$(this).find(".eq").matchHeight({
						byRow: true,
						property: 'height'
					});
				});

			});

		},

		/*
		bind layouts
		 */
		bindBreakpoints: function() {

			enquire
			.register("screen and (min-width: 801px)", {

				// desktop
				match: function() {
					console.log('801px+');
				},

				// tablet
				unmatch: function() {}

			})
			.register("screen and (max-width: 800px)", {

				// tablet
				match: function() {
					console.log('<= 800px');
				},

				// desktop
				unmatch: function() {}

			})
			.register("screen and (max-width: 600px)", {

				// mobile
				match: function() {
					console.log('<= 600px');
				},

				// tablet
				unmatch: function() {}
			});

		}

	};

	WPX.Layout.init();

});