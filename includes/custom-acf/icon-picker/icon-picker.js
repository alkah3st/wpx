jQuery(document).ready(function($) {

	'use strict';

	// setup namespace
	var WPX_ACF_IconPicker = {};

	// setup objects
	window.WPX_ACF_IconPicker = WPX_ACF_IconPicker;

	WPX_ACF_IconPicker = {

		init: function() {

			this.bindEvents();

		},

		/** 
		 * bind all events
		*/
		bindEvents: function() {

			$(".wpx-acf-icon-picker select").select2({
				templateResult: WPX_ACF_IconPicker.formatState,
				width: '100%'
			});

			$(document).on("click", '.acf-fontello-picker-choice', function(event) {
				var whatIcon = $(this).attr('data-choice');
				$(this).closest('.acf-fontello-picker').find('.acf-fontello-picker-choice').removeClass('selected');
				$(this).addClass('selected');
				$(this).closest('.acf-input').find('input').val(whatIcon);
				console.log($(this).closest('.acf-fontello-picker').find('input').val());
			});
		},

		formatState: function(state) {
			console.log(state);
			if (!state.id) { return state.text; }
			var $state = $('<span><i class="icon-' +  state.id + '"></i> '+state.text+'</span>');
			return $state;
		}

	};

	WPX_ACF_IconPicker.init();

});