
</div>
<!-- content -->

<footer id="footer">
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
	<div id="footer-bottom" class="<?php echo sg_val_class(array('page-section',sg_opt('footer_bottom_color_set'),sg_opt('footer_bottom_separator'),sg_opt('footer_bottom_extra_class'))) ?>">
		<div class="container">
			<div class="pull-left">
				<?php echo sg_opt('footer_bottom_text') ?>
			</div>
			<div class="pull-right">
				<div class="menu menu-inline">
					<ul>
						<?php $vars = array('VafPress','WordPress','ThemeForest'); ?>
						<?php foreach($vars as $var): ?>
							<li><a href=""><?php echo $var ?></a></li>
						<?php endforeach; ?>
					</ul>
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
	</div>
</footer>
<!-- footer -->
<?php wp_footer(); ?>
</body>
</html>