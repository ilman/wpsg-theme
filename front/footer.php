
	</div>
	<!-- container -->
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

<?php wp_footer(); ?>
</body>
</html>