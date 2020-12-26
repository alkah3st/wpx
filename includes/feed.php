<?php
/**
 * Filters
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
namespace WPX\Feed;

/**
 * Append Post Thumbnail to RSS Feed Posts
 * @return [type] [description]
 */
function rss_add_mediacontent() {
	global $post; 
	$thumbnail = \WPX\Utility\get_image(get_post_thumbnail_id($post->ID), 'post-thumbnail');
	$img_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' );
	?>
	<media:content url="<?php echo $thumbnail; ?>" medium="image" width="<?php echo $img_attributes[1]; ?>" height="<?php echo $img_attributes[2]; ?>" />
	<?php
}
add_filter( 'rss2_item', '\WPX\Feed\rss_add_mediacontent' );

/**
 * Add Logomark to Feed & GA ID
 */
function rss_add_channelmeta() {
	$thumbnail = \WPX\Utility\get_image(get_field('default_share_image','options'), 'post-thumbnail');
	echo '<webfeeds:cover image="'.$thumbnail.'" />';
	echo '<webfeeds:icon>'.assets_url().'/images/logomark.svg'.'</webfeeds:icon>';
	echo '<webfeeds:logo>'.assets_url().'/images/logo-dark.svg'.'</webfeeds:logo>';
	echo '<webfeeds:accentColor>f8a01e</webfeeds:accentColor>';
	echo '<webfeeds:related layout="card" target="browser" />';
	echo '<webfeeds:analytics id="'.WPX_GA_ID.'" engine="GoogleAnalytics" />';
}
// add_filter( 'rss2_head', '\WPX\Feed\rss_add_channelmeta' );

/**
 * Add Feedly Namespace
 */
function rss_enhance_nms() {
	echo 'xmlns:webfeeds="http://webfeeds.org/rss/1.0"'; 
	echo "\n".'xmlns:media="http://search.yahoo.com/mrss/"';
}
add_filter( 'rss2_ns', '\WPX\Feed\rss_enhance_nms' );

/**
 * Remove WP Version # from Feed
 */
function wp_complete_version_removal() {
	return '';
}
add_filter('the_generator', '\WPX\Feed\wp_complete_version_removal');

/**
 * Wait 30m Before Publishing Feed
 */
function publish_later_on_feed($where) {
	global $wpdb;
	if (is_feed()) {
		// timestamp in WP-format
		$now = gmdate('Y-m-d H:i:s');

		// value for wait; + device
		$wait = '30'; // integer

		// http://dev.mysql.com/doc/refman/5.0/en/date-and-time-functions.html#function_timestampdiff
		$device = 'MINUTE'; // MINUTE, HOUR, DAY, WEEK, MONTH, YEAR

		// add SQL-sytax to default $where
		$where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
	}
	return $where;
}
add_filter('posts_where', '\WPX\Feed\publish_later_on_feed');

// @todo remove
// add_filter('wp_feed_cache_transient_lifetime', function () { return 0; });