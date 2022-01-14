jQuery(document).ready(function($) {

	'use strict';

	WPX.Utils = {

		init: function() {},

		ctrl: function(controller, target) {
			var element = $('[data-controller="'+controller+'"]');
			return element;
		},

		el: function(controller, selector) {
			var element = $('[data-controller="'+controller+'"]').find(selector);
			return element;
		},

		val: function(controller, selector, value) {
			var $controllerElement = $('[data-controller="'+controller+'"]');
			if (controller === selector) {
				var value = $controllerElement.attr('data-'+value);
			} else {
				var value = $controllerElement.find(selector).attr('data-'+value);
			}
			return value;
		},

		target: function(controller, target) {
			var element = $('[data-controller="'+controller+'"]').find('[data-target="'+target+'"]');
			return element;
		}

	};

	WPX.Utils.init();

});