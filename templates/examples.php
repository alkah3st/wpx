<?php
/**
 * Template Name: Examples
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 *
*/
the_post();
get_header(); ?>

<h1>Your Markup Here</h1>

<p>Make as many of these templates as needed to render your front end markup.</p>

<h2>Example Icon Font</h2>

<p><i class="icon-emo-happy"></i> Cheers.</p>

<h2>Example Inline Retina Image</h2>

<p><img src="<?php echo assets_url(); ?>/images/logo-gray.png" data-2x="<?php echo assets_url(); ?>/images/logo-gray@2x.png" class="retina" alt=""></p>

<h2>Example Retina Sprite</h2>

<div class="calendar-icon"></div>

<h2>Example Retina Background</h2>

<div class="background-example"></div>

<div class="tinymce"><?php the_content(); ?></div>

<?php get_footer(); ?>