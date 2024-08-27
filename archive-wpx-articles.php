<?php
/**
 * The template for a custom CPT archive (Articles)
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
$description = term_description();

get_header(); ?>

<header>
	<?php if ( is_day() ) : ?>
		<h1><?php echo get_the_date() ?></h1>
	<?php elseif ( is_month() ) : ?>
		<h1><?php echo get_the_date( 'F Y' ); ?></h1>
	<?php elseif ( is_year() ) : ?>
		<h1><?php echo get_the_date( 'Y' ); ?></h1>
	<?php elseif ( is_category() ) : ?>
		<h1><?php single_cat_title(); ?></h1>
	<?php elseif ( is_tag() ) : ?>
		<h1><?php single_tag_title(); ?></h1>
	<?php else : ?>
		<h1>Archives</h1>
	<?php endif; ?>

	<?php if ($description) { ?><p><?php echo $description; ?></p><?php } ?>

	<p class="default alert">Found <strong><?php echo $wp_query->found_posts; ?></strong> posts in the archive for <strong>Articles</strong>.</p>

</header>

<?php get_footer(); ?>