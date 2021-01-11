jQuery(document).ready(function($) {

	'use strict';
	
	(() => {
		const application = Stimulus.Application.start();

		application.register("example-controller", class extends Stimulus.Controller {
			static get targets() {
				return [ "exampleElement" ];
			}

			// gets called when target is clicked
			// place data-action="click->example-controller#exampleFunction" in markup
			// and data-example-controller-target="exampleElement" on same element
			exampleFunction() {
				event.preventDefault();
				const thisTarget = this.exampleElementTarget;
				// do stuff
				console.log('hello');
			}

		});
	})();

});