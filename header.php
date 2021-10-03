<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php wp_head(); ?>

		<style>
		#bg:after {background-image: url("<?php header_image(); ?>");}
		</style>

	</head>
	<body ?php body_class( 'is-preload' ); ?>

		<!-- Wrapper -->
			<div id="wrapper">
