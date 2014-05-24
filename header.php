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
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header id="header">
	<?php if(sg_opt('header_top')): ?>
	<div id="header-top" class="<?php echo sg_val_class(array('page-section',sg_opt('header_top_color_set'),sg_opt('header_top_separator'),sg_opt('header_extra_class'))) ?>">
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
	<div id="header-main" class="<?php echo sg_val_class(array('page-section',sg_opt('header_color_set'),sg_opt('header_separator'),sg_opt('header_align'),sg_opt('header_extra_class'))) ?>">
		<?php include('header-choices.php') ?>
	</div>
	<!-- header-main -->
</header>
<!-- header -->

<?php if(sg_opt('subheader')): ?>
<?php get_template_part('templates/subheader') ?>
<?php endif; ?>

<div id="content">
