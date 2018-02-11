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

		<!-- inject:yarn:js -->
		<script src="<?php echo assets_url(); ?>/js/libraries.js"></script>
		<!-- endinject -->
		<!-- inject:vendor:js -->
		<script src="<?php echo assets_url(); ?>/js/vendor/jquery.imagesloaded.js"></script>
		<script src="<?php echo assets_url(); ?>/js/vendor/jquery.matchheight.js"></script>
		<!-- endinject -->
		<!-- inject:init:js -->
		<script src="<?php echo assets_url(); ?>/js/app.init.js"></script>
		<!-- endinject -->
		<!-- inject:modules:js -->
		<script src="<?php echo assets_url(); ?>/js/modules/layout.js"></script>
		<script src="<?php echo assets_url(); ?>/js/modules/utility.js"></script>
		<!-- endinject -->
	
	<?php endif; ?>

</body>