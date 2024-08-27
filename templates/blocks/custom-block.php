<?php
/**
 * Block Name: Custom Block
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */

$testimonial = (get_field('testimonial') ? get_field('testimonial') : 'Testimonial text goes here...');
$author = (get_field('author') ? get_field('author') : 'Jane Smith');
$role = (get_field('role') ? get_field('role') : 'CEO');

?>

<div <?php echo get_block_wrapper_attributes() ?>>

	<blockquote>
		<p><?php echo $testimonial; ?></p>
		<cite><?php echo $author; ?>, <?php echo $role; ?></cite>
	</blockquote>

</div>