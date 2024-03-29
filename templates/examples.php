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
$example_module = new \WPX\Classes\UI\Example();
the_post();
get_header(); ?>

<h1>Your Markup Here</h1>

<p>Make as many of these templates as needed to render your front end markup.</p>

<h2>Example Icon Font</h2>

<p><i class="icon-menu"></i> Cheers.</p>

<h2>Example Inline Retina Image</h2>

<p><img src="<?php echo assets_url(); ?>/images/example@1x.png" data-2x="<?php echo assets_url(); ?>/images/example@2x.png" class="retina" alt=""></p>

<h2>Example Retina Sprite</h2>

<div class="calendar-icon"></div>

<h2>Example Retina Background</h2>

<div class="background-example"></div>

<h2>Example Stimulus Element</h2>

<div data-controller="exampleController">

	<h1>Click Below to Trigger Controller Function</h1>

	<a href="#" data-target="exampleTarget">Check Console Log</a>

</div>

<div class="example-wrap">

<p>Most UI should be constructed as classes:</p>

<?php $example_module->exampleHeader(); ?>

</div>

<?php get_footer(); ?>