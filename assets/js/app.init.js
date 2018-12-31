jQuery(document).ready(function($) {

	'use strict';

	/**
	 * throttle
	 */
	$.fn.throttledBind = function(){
		var args = [].slice.call(arguments),
			an = (typeof args[1] === "function") ? 1 : 2;
		if (typeof args[0] === "object") {
			$.each(args[0], function(event, fn){
				args[0][event] = $.throttle.apply(null, [fn].concat([].splice.call(args, 1, 5)));
			});
		} else {
			args[an] = $.throttle.apply(null, [].splice.call(args, an, 6));
		}
		args.slice(0, an);
		return this.bind.apply(this, args);
	};

	// setup WPX
	var WPX = {};

	// setup objects
	window.WPX = WPX;
	
});