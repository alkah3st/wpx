<?php
/**
 * Block Name: Custom Block
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
?>

<?php $id = $block['id']; ?>
<?php $class = $block['className']; ?>
<?php $title = get_field('title'); ?>

<div class="wp-block-custom <?php echo $class; ?>" <?php if ($id) : ?>id="<?php echo $id; ?>"<?php endif; ?>>

	<?php if ($title) : ?><h1><?php echo $title; ?></h1><?php endif; ?>

</div>