<?php
	use Scienceguard\SG_Util;

	if(!isset($col_width)){ $col_width = 4; }

	$page_detail_url = sg_opt('ea_property_details_page');
?>

<div class="flexslider ea-list-slider">
    <ul class="slides">
    	<?php foreach($result as $row): ?>
			<?php 
				$row_result = SG_Util::val($row,'result');
			?>
			<?php if(count((array)$row_result)): ?>
				<?php 
					$prop_image    = SG_Util::val($row_result,'image');
					$prop_title    = SG_Util::val($row_result,'title');
					$prop_price    = SG_Util::val($row_result,'price');
					$prop_desc     = SG_Util::val($row_result,'desc');
					$prop_link     = SG_Util::val($row_result,'link');
					$prop_dep 	   = ucwords(str_replace('-', ' ', $dep));

					//get query from ea
					$parsed_link = parse_url($prop_link);
					parse_str(SG_Util::val($parsed_link, 'query'), $parsed_query);
					$eapid = SG_Util::val($parsed_query, 'pid');

					//prepare property detail query
					$prop_query = 'eapid='.$eapid;

					//get property detail url page
					$prop_link = get_permalink($page_detail_url);
					if(strpos($prop_link, '?')!==false){
						$prop_link .= '&'.$prop_query;
					}
					else{
						$prop_link .= '?'.$prop_query;
					}
				?>
				<li>
		            <div class="block block-box block-property bg-gray">
						<div class="block-thumb no-overflow">
							<a class="anim-hover hover-parent" href="<?php echo $prop_link ?>">
								<img class="hover-child hover-grow" src="<?php echo $prop_image ?>" alt="<?php echo $prop_title ?>" />
								<span class="property-priority bg-primary"><?php echo $prop_dep ?></span>
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
			<?php endif; ?>
		<?php endforeach; ?>
    </ul>
</div>
<!-- flexslider -->