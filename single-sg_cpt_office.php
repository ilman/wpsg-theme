<?php 
	global $sg_qid;

	$sg_page_hide_title = get_post_meta($sg_qid, '_sg_mb_page_hide_title', true);
?>
<div class="post-single row">
<?php while ( have_posts() ) : the_post(); ?>


	<?php 

		function replace_once($needle, $replace, $haystack){
			$pos = strpos($haystack, $needle);
			if ($pos !== false) {
			    $newstring = substr_replace($haystack, $replace, $pos, strlen($needle));
			}
		}

		$content = get_the_content();

		if(!$content){
			$content = '<strong>We want to make letting or selling your property as stress-free and enjoyable as possible and help you achieve the best price for your property. Opening our office in 1998 our reputation is built on an ethos of honesty and integrity and always putting the customer first.</strong>

Our busy Town Centre office is staffed by an expert team with a wealth of local knowledge and experience. If you re looking to buy or sell your home we are confident Choices Properties  are the perfect choice to assist you with your property needs. Our lettings history makes us ideal to advise landlords on the purchase of buy to let property and to offer effective locally based property management of their rental portfolio.';
		}

		ob_start();
		sg_get_post_thumbnail('office_thumb');
		$post_thumb = ob_get_clean();

		$pos = strpos($content, '<p>');
		if ($pos !== false) {
			$content = substr_replace($content, '<p>'.$post_thumb, $pos, strlen('<p>'));
		}
		else{
			$content = $post_thumb.$content;
		}
	?>


	<div id="post-<?php the_ID(); ?>" <?php post_class('post-item col-sm-12'); ?>>
		<?php if(!$sg_page_hide_title): ?>
			<h2 class="page-title-accent"><?php the_title(); ?></h2>
		<?php endif ?>
		<?php 			
			echo apply_filters( 'the_content', $content );
		?>
	</div>

	<?php 
		$content = sg_opt('office_form_shortcode');
		echo do_shortcode($content);
	?>







<?php endwhile; ?>
</div>
<?php 
	if(is_single()){
		include(sg_view_path('templates/content-bottom.php'));
	}
?>