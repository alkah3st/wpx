<?php
/**
 * Post
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
get_header(); ?>

<?php the_post(); ?>

<h1><?php the_title(); ?></h1>

<?php the_content(); ?>

<?php comments_template( '', true ); ?>

<?php get_footer(); ?>