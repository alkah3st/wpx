<?php
/**
 * Widget: Visual Editor
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
*/

/**
 * Register the Widget
 */
class WPX_Visual_Editor extends WP_Widget {

	/**
	 * Register widget
	 */
	function __construct() {

		$widget_ops = array( 'classname'=>'widget-ve', 'description' => __( 'Allows you to enter freeform content.', 'wpx' ) );
		parent::__construct( 'WPX_Visual_Editor', __( 'Visual Editor', 'wpx' ), $widget_ops );
	}

	/**
	 * Display widget
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		
		extract( $args );

		global $post;
		global $wp_query;

		$title = (get_field('title', 'widget_' . $args['widget_id'])) ? get_field('title', 'widget_' . $args['widget_id']) : '';
		$call_to_action = get_field('call_to_action', 'widget_' . $args['widget_id']);
		$ve = get_field('ve_content', 'widget_' . $args['widget_id']);

		echo $before_widget;

		?>
		<div class="widget-inner">

			<div class="widget-concealer"></div>

			<?php if ($title) : ?><h1 class="widget-title"><?php echo $title; ?></h1><?php endif; ?>

			<div class="tinymce">
				<?php echo $ve; ?>
			</div>

			<?php if ($call_to_action) : ?><p class="widget-archive"><a <?php if ($call_to_action['target']) : ?>target="<?php echo $call_to_action['target']; ?>"<?php endif; ?> href="<?php echo $call_to_action['url']; ?>"><?php echo $call_to_action['title']; ?></a></p><?php endif; ?>

		</div>
		<?php

		echo $after_widget;
	}

	public function form($instance){ return $instance; }

}

add_action( 'widgets_init', function () { register_widget( 'WPX_Visual_Editor' ); } );