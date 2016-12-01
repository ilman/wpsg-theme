<?php
/*
Template Name: Prime Template
*/
?>
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
<script src="http://www.primelocation.com/widgets/scripts/partner_widgets/zoopla_head.js?search_type=choices" type="text/javascript"></script>
<!-- <link rel="stylesheet" href="http://choices.co.uk/templates/zoopla-themes/zoopla-theme.css" /> -->
<base href="http://www.primelocation.com/" />	

</head>

<body <?php body_class(); ?>>


	<div class="primelocation">
		<script src="http://www.primelocation.com/widgets/scripts/partner_widgets/zoopla_header.js?search_type=choices" type="text/javascript"></script>
	
		<!-- BEGIN CHOICES CONTENT -->
			
		<?php if ( have_posts() ): ?>	
			<?php sg_get_template_part($sg_wrapper['content_base'], $sg_wrapper['content_layout']); ?>
		<?php endif; ?>
			
		<!-- END CHOICES CONTENT -->	
		
		<script src="http://www.primelocation.com/widgets/scripts/partner_widgets/zoopla_footer.js?search_type=choices" type="text/javascript"></script>
	</div>

	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
		try {
			var pageTracker = _gat._getTracker("UA-229433-1");
			pageTracker._trackPageview();
		} catch(err) {}
	</script>
	<script type="text/javascript">
		// document.getElementById('humanver').style.display = 'none';
	</script>

	<?php wp_footer(); ?>
</body>
</html>