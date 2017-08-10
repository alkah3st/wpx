<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
?>

	<script>var SITE_ROOT = '<?php echo WPX_DOMAIN; ?>';</script>
	<script>var SITE_ASSETS = '<?php echo assets_url(); ?>';</script>
	<script>var SITE_THEME = '<?php echo WPX_THEME_URL; ?>';</script>

	<?php if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_footer(); ?>

	<?php if (WP_DEBUG == true) : ?>
		
		<!-- bower:js -->
		<script src="<?php bloginfo("url") ?>/wp-content/themes/wpx/assets/js/libraries/jquery/dist/jquery.js"></script>
		<script src="<?php bloginfo("url") ?>/wp-content/themes/wpx/assets/js/libraries/jquery-placeholder/jquery.placeholder.js"></script>
		<script src="<?php bloginfo("url") ?>/wp-content/themes/wpx/assets/js/libraries/jquery-validation/dist/jquery.validate.js"></script>
		<script src="<?php bloginfo("url") ?>/wp-content/themes/wpx/assets/js/libraries/jquery.fitvids/jquery.fitvids.js"></script>
		<script src="<?php bloginfo("url") ?>/wp-content/themes/wpx/assets/js/libraries/enquire/dist/enquire.js"></script>
		<script src="<?php bloginfo("url") ?>/wp-content/themes/wpx/assets/js/libraries/slick-carousel/slick/slick.js"></script>
		<script src="<?php bloginfo("url") ?>/wp-content/themes/wpx/assets/js/libraries/dense/src/dense.js"></script>
		<!-- endbower -->
		<!-- inject:init:js -->
		<script src="<?php echo assets_url(); ?>/js/app.init.js"></script>
		<!-- endinject -->
		<!-- inject:modules:js -->
		<script src="<?php echo assets_url(); ?>/js/modules/layout.js"></script>
		<script src="<?php echo assets_url(); ?>/js/modules/utility.js"></script>
		<!-- endinject -->
	
	<?php endif; ?>

</body>