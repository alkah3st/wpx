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
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo assets_url(); ?>/images/favicons/apple-touch-icon.png?v=47BrWnbJxN">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo assets_url(); ?>/images/favicons/favicon-32x32.png?v=47BrWnbJxN">
	<link rel="icon" type="image/png" sizes="194x194" href="<?php echo assets_url(); ?>/images/favicons/favicon-194x194.png?v=47BrWnbJxN">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo assets_url(); ?>/images/favicons/android-chrome-192x192.png?v=47BrWnbJxN">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo assets_url(); ?>/images/favicons/favicon-16x16.png?v=47BrWnbJxN">
	<link rel="manifest" href="<?php echo assets_url(); ?>/images/favicons/site.webmanifest?v=47BrWnbJxN">
	<link rel="mask-icon" href="<?php echo assets_url(); ?>/images/favicons/safari-pinned-tab.svg?v=47BrWnbJxN" color="#567b87">
	<link rel="shortcut icon" href="/favicon.ico">
	<meta name="apple-mobile-web-app-title" content="DQuinn.net">
	<meta name="application-name" content="DQuinn.net">
	<meta name="msapplication-TileColor" content="#567b87">
	<meta name="msapplication-TileImage" content="<?php echo assets_url(); ?>/images/favicons/mstile-144x144.png?v=47BrWnbJxN">
	<meta name="msapplication-config" content="<?php echo assets_url(); ?>/images/favicons/browserconfig.xml?v=47BrWnbJxN">
	<meta name="theme-color" content="#567b87">
	<?php // see https://realfavicongenerator.net/; don't forget to put favicon.png/ico in the root of the site ?>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>