<?php
/**
 * Widget: Categories
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
*/

/**
 * Register the Widget
 */
class WPX_Categories extends WP_Widget {

	/**
	 * Register widget
	 */
	function __construct() {

		$widget_ops = array( 'classname'=>'widget-categories', 'description' => __( 'Displays the categories in the blog.', 'wpx' ) );
		parent::__construct( 'WPX_Categories', __( 'Categories', 'wpx' ), $widget_ops );
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

		echo $before_widget; ?>

		<header>
			<h1 class="heading">Categories</h1>
			<p class="subheading">From the Blog</p>
		</header>

		<ul>
			<?php $categories = get_categories(); ?>
			<?php foreach($categories as $category) : ?>
				<li><a href="<?php echo get_category_link( $category->term_id ); ?>"><span class="f"><?php echo $category->name; ?></span><span class="r"></span></a></li>
			<?php endforeach ?>
		</ul>

		<?php echo $after_widget;
	}

}

add_action( 'widgets_init', function () { register_widget( 'WPX_Categories' ); } );