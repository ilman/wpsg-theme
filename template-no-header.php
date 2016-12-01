<?php
/*
Template Name: No Header Template
*/
?>

<?php include(sg_view_path('front/header.php')) ?>

<style> 
	#header-main{ display:none; }
</style>

<div class="page-section">
	<div class="container">
		<?php 
			echo ($sg_page_add_section) ? '<div class="'.trim('page-section '.$sg_page_section_class).'">' : '';
			echo ($sg_page_add_container) ? '<div class="container">' : '';

			sg_get_template_part($sg_wrapper['content_base'], $sg_wrapper['content_layout']);

			echo ($sg_page_add_container) ? '</div><!-- container -->' : '';
			echo ($sg_page_add_section) ? '</div><!-- section -->' : '';
		?>
	</div>
	<!-- container -->
</div>
<!-- section -->

<?php include(sg_view_path('front/footer.php')) ?>