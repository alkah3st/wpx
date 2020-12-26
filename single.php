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

<div class="context">

	<div class="tinymce">
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
</div>

<?php comments_template(); ?>

<?php get_footer(); ?>