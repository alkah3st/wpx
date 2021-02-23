jQuery(document).ready(function($) {

	$('body').on('click', '.acf-image-selector-option', function (){
		console.log('hey');
		// deselect all
		$(this).closest('.acf-image-selector-wrap').find('.acf-image-selector-option').removeClass('selected');
		// if already selected
		if ($(this).hasClass('selected')) {
			console.log('no val');
			$(this).closest('.acf-image-selector-wrap').find('.acf-image-selector-field').val('');
			console.log($(this).closest('.acf-image-selector-wrap').find('.acf-image-selector-field').val());
		} else {
			console.log('has val');
			var value = $(this).find('img').attr('data-value');
			console.log(value);
			$(this).closest('.acf-image-selector-wrap').find('.acf-image-selector-field').val(value);
			console.log($(this).closest('.acf-image-selector-wrap').find('.acf-image-selector-field').val());
		}
		$(this).toggleClass('selected');
	});

});