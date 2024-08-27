<?php
/**
 * Post
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
the_post();

get_header(); 

echo '<h1>'.get_the_title($post).'</h1>';

the_content();

get_footer(); 

?>