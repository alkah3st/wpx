<?php
/**
 * Header
 *
 * @package WordPress
 * @subpackage WPX_Theme
 * @since 0.1.0
 * @version 1.0
 */
?><!DOCTYPE HTML>
<!--[if lt IE 9]><html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]><html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php // @todo, needs updating ?>
	<link rel="icon" href="<?php echo WPX_THEME_URL; ?>/favicon.png">
	<!--[if IE]><link rel="shortcut icon" href="<?php echo WPX_THEME_URL; ?>/favicon.ico"><![endif]-->
	<meta name="msapplication-TileColor" content="#000000">
	<meta name="msapplication-TileImage" content="<?php echo WPX_THEME_URL; ?>/tileicon.png">
	<link rel="apple-touch-icon" href="<?php echo WPX_THEME_URL; ?>/apple-touch-icon.png">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>