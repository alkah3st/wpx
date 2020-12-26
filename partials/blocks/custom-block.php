<?php
/**
 * Block Name: Custom Block
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */

$id = (isset($block['id']) ? $block['id'] : false);
$class = (isset($block['className']) ? $block['className'] : false);
$color = get_field('my_colors');
$icon = get_field('my_icons');

?>

<div class="wpx-custom-block my-custom-block <?php echo $class; ?>" <?php if ($id) : ?>id="<?php echo $id; ?>"<?php endif; ?>>

	<p class="has-<?php echo $color; ?>-color">My Custom Color</p>

	<p><i class="icon-<?php echo $icon; ?>"></i></p>

</div>