<?php
/**
 * Page
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
the_post(); 
get_header(); ?>

<h1><?php the_title(); ?></h1>

<div class="tinymce"><?php the_content(); ?></div>

<?php get_footer(); ?>