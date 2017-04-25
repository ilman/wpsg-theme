<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<title><?php wp_title('|', true, 'right'); ?></title>


	<?php wp_head(); ?>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body <?php body_class(); ?>>

	<nav id="header" class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Project name</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<?php 
					wp_nav_menu( 
						array( 
							'theme_location' => 'primary', 
							'container' => false,
							'menu_class' => 'nav navbar-nav navbar-center',
							'walker' => new sg_walker_menu(),
							'fallback_cb'  => 'sg_no_menu_cb'
						) 
					);
				?>
			</div>
			<!-- navbar-collapse -->
		</div>
		<!-- container -->
	</nav>

	<?php do_action('sg_content_before'); ?>

	<div id="content">
		<div class="container">


