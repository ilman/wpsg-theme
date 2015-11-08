
</div>
<!-- content -->

<footer id="footer">
	<?php /* if(sg_opt('footer_main')): ?>
	<div id="footer-main" class="<?php echo sg_val_class(array('page-section',sg_opt('footer_color_set'),sg_opt('footer_separator'),sg_opt('footer_extra_class'))) ?>">
		<div class="container">
			<div class="row">
				<?php 
					$footer_cols = explode('-',sg_opt('footer_grid_layout'));
					$i=1;
					foreach($footer_cols as $col){
						echo '<div class="col-sm-'.$col.'">';
						dynamic_sidebar('footer_column_'.$i);
						echo '</div>';
						$i++;
					}
				?>
			</div>
		</div>
	</div>
	<!-- footer-main -->
	<?php endif; */ ?>
	
	<div id="footer-bottom" class="<?php echo sg_val_class(array('page-section bg-trans',sg_opt('footer_bottom_color_set'),sg_opt('footer_bottom_separator'),sg_opt('footer_bottom_extra_class'))) ?>">
		<?php include('footer-choices.php') ?>
	</div>
	<!-- footer-bottom -->
</footer>
<!-- footer -->
<?php wp_footer(); ?>
</body>
</html>