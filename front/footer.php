</div>
<!-- content -->

<footer id="footer">

	<?php 
		$footer_block_id = sg_opt('footer_template');

		if($footer_block_id){
			echo SG_CptBlock::render($footer_block_id);
		}
		else{
			include(sg_view_path('front/part-footer.php'));
		}	

	?>

</footer>
<!-- footer -->

<div id="theme-modal" class="modal fade" tabindex="-1" style="display: none;"></div>

<?php wp_footer(); ?>
</body>
</html>