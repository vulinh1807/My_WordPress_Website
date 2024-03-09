<!DOCTYPE html>
<html>
<!–[if IE 8]> <html <?php language_attributes(); ?> class="ie8"> <![endif]–>
<!–[if !IE]> <html <?php language_attributes(); ?>> <![endif]–>
<head id="header">
	<meta charset="<?php bloginfo('charset');?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<?php linhvu_logo(); ?>
	<link rel="profile" href="http://gmgp.org/xfn/11"/>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
	<title>My theme</title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
	
	<div id="container">
		<header id="header">
		<?php linhvu_logo(); ?>
		<?php linhvu_menu('primary-menu'); ?>
		</header>