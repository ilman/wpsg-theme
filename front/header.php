<!DOCTYPE HTML>
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9 ]><html class="ie ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>

<!-- ****basic page needs**** -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php wp_title('|', true, 'right'); ?></title>

<!-- ****responsive viewport**** -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- ****wordpress enqueue**** -->
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header id="header">
	<?php if(sg_opt('header_top')): ?>
	<div id="header-top" class="<?php echo sg_val_class(array('theme-header-top page-section',sg_opt('header_top_color_set'),sg_opt('header_top_separator'),sg_opt('header_extra_class'))) ?>">
		<div class="container">		
			<div class="pull-left">
				<?php echo sg_opt('header_top_text') ?>
			</div>
			<div class="pull-right">
				<div class="menu menu-inline">
					<?php 
						wp_nav_menu(
							array(
								'theme_location'	=> 'header_top', 
								'menu_class'		=> 'menu menu-inline',
								'walker'			=> new sg_walker_menu(),
								'fallback_cb'		=> 'sg_no_menu_cb'
							)
						); 
					?>
				</div>
				<div class="menu menu-inline menu-social">
					<ul>
						<?php $vars = array('facebook','twitter','linkedin','email'); ?>
						<?php foreach($vars as $var): ?>
							<li><a href=""><?php echo $var ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<!-- pull right -->
		</div>
		<!-- container -->
	</div>
	<!-- header top -->
	<?php endif; ?>

	<div id="header-main" class="<?php echo sg_val_class(array('theme-header-main page-section bg-trans',sg_opt('header_color_set'),sg_opt('header_separator'),sg_opt('header_align'),sg_opt('header_extra_class'))) ?>">
		
		
		<nav class="navbar navbar-blank navbar-static-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle btn btn-primary" type="button" data-toggle="collapse" data-target="#nav-main"> <i class="fa fa-fw fa-bars"></i> </button>
					<a class="navbar-brand hide show-sm" href="<?php echo home_url(); ?>">
						<img class="brand-default" src="<?php echo sg_asset_url('front/assets/images/logo-2016-mobile.png') ?>" alt="Choices">
					</a>
				</div>
				
				<div class="collapse navbar-collapse" id="nav-main">
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
			 </div>
			 <!-- container -->
		</nav>
		<!-- nav -->
		


	</div>
	<!-- header-main -->
</header>
<!-- header -->

<div id="subheader" style="background-image:url(<?php echo sg_asset_url('front/assets/images/bg-1.jpg') ?>)">
	<div class="container">
		<div class="subcontainer">
			<p>
				<a href="<?php echo site_url() ?>">
					<img src="<?php echo get_template_directory_uri().'/front/assets/images/logo-2016.png' ?>" alt="choices">
				</a>
			</p>
		</div>
	</div>
	<!-- container -->
</div>
<!-- subheader -->

<div id="searchbar">
	<div class="container">
		<?php echo do_shortcode('[ea_search_bar]') ?>
	</div>
	<!-- container -->
</div>
<!--  -->


<?php do_action('sg_content_before'); ?>
	

<div id="content">