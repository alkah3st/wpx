<?php
/**
 * Example Module
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Classes\UI;

class ExampleModule {

	public $args;

	function __construct($params=false) {

		$defaults = array (
			'default_setting' => false,
		);

		$this->args = wp_parse_args( $params, $defaults );

		/**
		 * Example Calling a Method Dynamically
		 */
		
		// $variableMethod = 'string'.$variable;
		// $this->$variableMethod($post);

	}


	function exampleHeader() {
		echo "hey!";
	}

}