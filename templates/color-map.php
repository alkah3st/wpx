<?php
/**
 * Color Map
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 *
*/
if (wp_get_environment_type() === 'development' || wp_get_environment_type() === 'local') {

	wpx_update_color_map();

	exit;

}