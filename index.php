<?php if ( have_posts() ): ?>	
	<?php include(locate_template('templates/'.$sg_page_layout.'.php')); ?>
<?php else: ?>
	<?php get_template_part( 'no-result', 'index' ); ?>
<?php endif; ?>