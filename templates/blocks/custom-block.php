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

?>

<div class="wpx-custom-block block-custom-block <?php echo $class; ?>" <?php if ($id) : ?>id="<?php echo $id; ?>"<?php endif; ?>>


</div>