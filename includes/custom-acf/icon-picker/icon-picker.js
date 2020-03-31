jQuery(document).ready(function($) {

	'use strict';

	// setup namespace
	var acfFontelloPicker = {};

	// setup objects
	window.acfFontelloPicker = acfFontelloPicker;

	acfFontelloPicker = {

		init: function() {

			this.bindEvents();

		},

		/** 
		 * bind all events
		*/
		bindEvents: function() {

			$(document).on("click", '.acf-fontello-picker-choice', function(event) {
				var whatIcon = $(this).attr('data-choice');
				$(this).closest('.acf-fontello-picker').find('.acf-fontello-picker-choice').removeClass('selected');
				$(this).addClass('selected');
				$(this).closest('.acf-input').find('input').val(whatIcon);
				console.log($(this).closest('.acf-fontello-picker').find('input').val());
			});

		}

	};

	acfFontelloPicker.init();

});