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

get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php the_content(); ?>

<?php 
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
?>

<?php get_footer(); ?>