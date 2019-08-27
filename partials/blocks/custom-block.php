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
$title = get_field('title');

?>

<div class="block-custom-block <?php echo $class; ?>" <?php if ($id) : ?>id="<?php echo $id; ?>"<?php endif; ?>>

	<?php if ($title) : ?><h1><?php echo $title; ?></h1><?php endif; ?>

</div>