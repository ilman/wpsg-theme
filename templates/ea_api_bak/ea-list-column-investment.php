<?php
	if(!isset($col_width)){ $col_width = 4; }

	$page_detail_url = sg_opt('ea_investment_property_details_page');

	//get session_id from last curl url
	$parsed_url = parse_url($url);
	$url_path = SG_Util::val($parsed_url,'path');
	$exploded_path = explode('/', $url_path);
	$easid = SG_Util::val($exploded_path,1);
?>

<?php if(isset($text)): ?>
<p><i><?php echo $text ?></i></p>
<?php endif; ?>

<?php ob_start(); ?>
<?php if($pagination): ?>
<ul class="pagination">
	<?php foreach($pagination as $page): ?>
		<?php 
			$text = SG_Util::val($page,'text');
			$link = SG_Util::val($page,'link');

			if($link){
				//get page query from link pagination
				$parsed_link =parse_url($link);
				$link_query = SG_Util::val($parsed_link,'query');
				parse_str($link_query, $parsed_query);

				//build new param query containing session_id and page
				$param = array(
					'eapage' => SG_Util::val($parsed_query,'page',1), 
					'easid' => $easid
				);

				$param_get = $_GET;
				unset($param_get['eapage']);
				unset($param_get['easid']);

				$param = array_merge($param, $param_get);
				$link = '?'.urldecode(http_build_query($param));

				echo '<li><a href="'.$link.'">'.$text.'</a></li>';
			}
			else{
				echo '<li class="active"><span>'.$text.'</span></li>';
			}
		?>
	<?php endforeach; ?>
</ul>
<!-- pagination -->
<?php endif;  ?>
<?php $pagination = ob_get_clean() ?>



<?php echo $pagination ?>



<ul class="post-list list-column ea-list-column row">
	<?php foreach($result as $row): ?>
		<?php 
			$prop_image    = SG_Util::val($row,'image');
			$prop_title    = SG_Util::val($row,'title');
			$prop_price    = SG_Util::val($row,'price');
			$prop_desc     = SG_Util::val($row,'desc');
			$prop_priority = SG_Util::val($row,'priority');
			$prop_ref      = SG_Util::val($row,'ref');
			$prop_link     = SG_Util::val($row,'link');

			//get query from ea
			$parsed_link = parse_url($prop_link);
			parse_str(SG_Util::val($parsed_link, 'query'), $parsed_query);
			$eapid = SG_Util::val($parsed_query, 'pid');
			$eaaid = SG_Util::val($parsed_query, 'aid');

			//prepare property detail query
			$prop_query = 'eaaid='.$eaaid.'&eapid='.$eapid.'&curl=1';

			//get property detail url page
			$prop_link = get_permalink($page_detail_url);
			if(strpos($prop_link, '?')!==false){
				$prop_link .= '&'.$prop_query;
			}
			else{
				$prop_link .= '?'.$prop_query;
			}
		?>
		<li <?php post_class('post-item col-sm-'.$col_width); ?>>
			<div class="block block-box block-property bg-gray">
				<div class="block-thumb no-overflow">
					<a class="anim-hover hover-parent" href="<?php echo $prop_link ?>">
						<img class="hover-child hover-grow" src="<?php echo $prop_image ?>" alt="<?php echo $prop_title ?>" />
						<?php if($prop_priority): ?>
							<span class="property-priority bg-primary"><?php echo $prop_priority ?></span>
						<?php endif; ?>
					</a>
				</div>
				<div class="block-body">
					<h5 class="property-title">
						<a href="<?php echo $prop_link ?>"><?php echo $prop_title ?></a>
					</h5>
					<div class="property-price"><?php echo str_replace('Â','',$prop_price) ?></div>
				</div>
			</div>
			<!-- block -->
		</li>
	<?php endforeach; ?>
</ul>
<!-- post-list -->

<?php echo $pagination ?>

<!-- <?php echo htmlspecialchars($url) ?> -->

<?php  if($url): ?>
<!-- <p class="hover-show">ExpertAgent URL: <a href="<?php echo htmlspecialchars($url) ?>"><?php echo htmlspecialchars($url) ?></a></p> -->
<?php endif;  ?>

<style>
	.hover-show( opacity:0; );
	.hover-show:hover( opacity:1; );
</style>