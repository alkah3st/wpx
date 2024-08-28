<?php
/**
 * Block Name: Custom Block
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */

$attrs = $is_preview ? ' ' : get_block_wrapper_attributes();
$testimonial = (get_field('testimonial') ? get_field('testimonial') : 'Testimonial text goes here...');
$author = (get_field('author') ? get_field('author') : 'Jane Smith');
$role = (get_field('role') ? get_field('role') : 'CEO');

if( isset( $block['data']['wpx_preview_image'] )  ) : 
	echo '<img src="'. $block['data']['wpx_preview_image'] .'" style="width:100%; height:auto;">';
else : ?>

<div <?php echo $attrs; ?>>

	<div class="<?php \WPX\Blocks\custom_block_classes(); ?>">

		<blockquote>
			<p><?php echo $testimonial; ?></p>
			<cite><?php echo $author; ?>, <?php echo $role; ?></cite>
		</blockquote>

	</div>

</div>

<?php endif;