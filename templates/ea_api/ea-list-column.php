<?php
	if(!isset($col_width)){ $col_width = 4; }

	$page_detail_url = sg_opt('ea_property_details_page');

	//get session_id from last curl url
	$parsed_url = parse_url($url);
	$url_path = SG_Util::val($parsed_url,'path');
	$exploded_path = explode('/', $url_path);
	$easid = SG_Util::val($exploded_path,1);
?>

<?php if(isset($text)): ?>
<p><i><?php echo $text ?></i></p>
<?php endif; ?>


<?php echo $pagination ?>



<ul class="post-list list-column ea-list-column row">
	<?php foreach($result as $row): ?>
		<?php 
			$prop_image    = SG_Util::val($row,'advert_image');
			$prop_title    = SG_Util::val($row,'advert_heading');
			$prop_price    = SG_Util::val($row,'price_text');
			$prop_priority = SG_Util::val($row,'priority');
			$prop_id      = SG_Util::val($row,'id');
			$prop_type     = SG_Util::val($row,'property_type');

			//prepare property detail query
			$prop_query = 'pid='.$prop_id;

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
					<div class="property-type"><?php echo ($prop_type) ? $prop_type :'-' ?></div>
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