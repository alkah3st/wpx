<?php
/**
 * Search
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
get_header(); ?>

<h1>Search Results</h1>

<p class="default alert">Found <strong><?php echo $wp_query->found_posts; ?></strong> posts for "<strong><?php the_search_query(); ?></strong>."</p>

<?php get_footer(); ?>