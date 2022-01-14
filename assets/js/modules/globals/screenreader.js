jQuery(document).ready(function($) {

	'use strict';

	WPX.Screenreader = {

		$skipSection: WPX.Utils.ctrl('skipSection'),
		$body: $('body'),

		init: function() {

			// events
			this.bindEvents();

		},

		/** 
		 * bind all events
		*/
		bindEvents: function() {

			WPX.Screenreader.$skipSection.click(function() {
				event.preventDefault();
				console.log('// WPX: Changing Focus to Next Element');
				$(this).closest('.wpx-custom-block').next().attr('tabIndex', -1).focus();
			});

		},

	};

	WPX.Screenreader.init();

});