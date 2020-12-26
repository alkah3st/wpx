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
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/wpx/assets/images/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/wpx/assets/images/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="194x194" href="/wp-content/themes/wpx/assets/images/favicons/favicon-194x194.png">
	<link rel="icon" type="image/png" sizes="192x192" href="/wp-content/themes/wpx/assets/images/favicons/android-chrome-192x192.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/wpx/assets/images/favicons/favicon-16x16.png">
	<link rel="manifest" href="/wp-content/themes/wpx/assets/images/favicons/site.webmanifest">
	<link rel="mask-icon" href="/wp-content/themes/wpx/assets/images/favicons/safari-pinned-tab.svg" color="#f8a01e">
	<link rel="shortcut icon" href="/wp-content/themes/wpx/assets/images/favicons/favicon.ico">
	<meta name="apple-mobile-web-app-title" content="DQuinn.net">
	<meta name="application-name" content="DQuinn.net">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/wp-content/themes/wpx/assets/images/favicons/mstile-144x144.png">
	<meta name="msapplication-config" content="/wp-content/themes/wpx/assets/images/favicons/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<?php // see https://realfavicongenerator.net/; don't forget to put favicon.png/ico in the root of the site ?>

	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;0,700;0,800;0,900;1,400;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&family=Lora:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>