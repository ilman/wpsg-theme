<?php
	if(!isset($col_width)){ $col_width = 4; }

	$page_detail_url = sg_opt('resales_property_details_page');
	$pagination = '<div class="text-center">'.resales_pagination_links($query_info).'</div>';
?>

<?php if(isset($text)): ?>
<p><i><?php echo $text ?></i></p>
<?php endif; ?>

<?php echo $pagination ?>

<!-- <?php echo $url ?> -->

<style>
	.block-property .block-thumb img, .block-property .block-thumb a{ height:100% !important; }
	.hover-show{ opacity:0; }
	.hover-show:hover{ opacity:1; }
</style>

<ul class="post-list list-column ea-list-column row">
	<?php foreach($result as $row): ?>
		<?php 
			$search_type   = ucwords(str_replace('-', ' ', $search_type));
			$prop_image    = SG_Util::val($row,'image');
			$prop_title    = SG_Util::val($row,'type').' '.$search_type.' '.SG_Util::val($row,'location');
			$prop_price    = SG_Util::val($row,'price');
			$prop_desc     = SG_Util::val($row,'desc');
			$prop_ref      = SG_Util::val($row,'ref');

			//prepare property detail query
			$prop_query = 'query_id='.SG_Util::val($query_info,'query_id').'&ref_id='.SG_Util::val($row,'ref');

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
						<?php if(isset($prop_priority) && $prop_priority): ?>
							<span class="property-priority bg-primary"><?php echo $prop_priority ?></span>
						<?php endif; ?>
					</a>
				</div>
				<div class="block-body">
					<h5 class="property-title">
						<a href="<?php echo $prop_link ?>"><?php echo $prop_title ?></a>
					</h5>
					<div class="property-price pull-right"><?php echo sg_price_format($prop_price, SG_Util::val($row,'cur')) ?></div>
					<div class="property-meta pull-left">
						Beds: <?php echo SG_Util::val($row, 'beds') ?>
						Baths: <?php echo SG_Util::val($row, 'baths') ?>
					</div>
				</div>
			</div>
			<!-- block -->
		</li>
	<?php endforeach; ?>
</ul>
<!-- post-list -->

<?php echo $pagination ?>