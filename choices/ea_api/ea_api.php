<?php 

use Scienceguard\SG_Util;

function render_ea_property_html_new($data, $layout='list-column'){

	if(!is_array($data)){
		return false;
	}

	extract($data);

	if(strrpos(strtolower($url), 'accessdenied') !== false){
		return '<p><i>Temporary session from EA is expired, please repeat your search</i></p>';
	}

	$path = sg_view_path('templates/ea_api/ea-'.$layout.'.php');

	ob_start();	
	include($path);
	return ob_get_clean();
}


function render_ea_pagination_html_new($params = array(), $key = 'page'){

	extract($params);
	$current_page = (isset($_GET[$key])) ? $_GET[$key] : 1;
	$last_page = ceil( $total_rows / $per_page );

	$inputs = ($inputs) ? $inputs : $_GET;
	unset($inputs[$key]);
	$inputs = http_build_query($inputs);

	$base_url = explode('?', $base_url);
	$base_url = $base_url[0];

	$output = '<ul class="pagination">';

	// goto prev link
	if($current_page>1){
		$param_page = $key.'='.($current_page-1);
		$query = trim($param_page.'&'.$inputs, '&');
		$link = ($query) ? $base_url.'?'.$query : $base_url;
	}
	else{
		$link = false;
	}
	if($link){
		$output .= '<li><a href="'.$link.'">&laquo;</a></li>';
	}
	else{
		$output .= '<li class="disabled"><span>&laquo;</span></li>';
	}

	// goto page link
	$first_page = 1;
	$segment = 7;
	$segment_avg = floor($segment/2);

	if($last_page<=$segment){
		$segment_1 = $last_page;
		$segment_2 = 0;
		$segment_3 = 0;
	}
	else{

		$segment_1_0 = $first_page-1+$current_page-1;
		$segment_3_0 = $last_page+1-$current_page-1;

		if($segment_1_0<$segment_avg){
			$segment_1 = $segment_avg + $segment_1_0;
			$segment_2 = 0;
			$segment_3 = $segment_avg - $segment_1_0;
		}
		elseif($segment_3_0<$segment_avg){
			$segment_1 = $segment_avg - $segment_3_0;
			$segment_2 = 0;
			$segment_3 = $segment_avg + $segment_3_0;
		}
		else{
			$segment_1 = 1;
			$segment_2 = $segment_avg;
			$segment_3 = 1;
		}

	}

	if($segment_1){
		for($i=$first_page; $i<$first_page+$segment_1; $i++){
			$param_page = ($i>1) ? $key.'='.$i : '';
			$query = trim($param_page.'&'.$inputs, '&');
			$link = ($query) ? $base_url.'?'.$query : $base_url;
			$li_class = ($i==$current_page) ? ' class="active"' : '';
			$output .= '<li'.$li_class.'><a href="'.$link.'">'.$i.'</a></li>';
			$segment -= 1;
		}
		if($segment_3){
			$output .= '<li><span>&hellip;</span></li>';
		}
	}

	if($segment_2){
		for($i=$current_page-1; $i<$current_page+$segment_2-1; $i++){
			$param_page = $key.'='.$i;
			$query = trim($param_page.'&'.$inputs, '&');
			$link = ($query) ? $base_url.'?'.$query : $base_url;
			$li_class = ($i==$current_page) ? ' class="active"' : '';
			$output .= '<li'.$li_class.'><a href="'.$link.'">'.$i.'</a></li>';
			$segment -= 1;
		}
		if($segment_3){
			$output .= '<li><span>&hellip;</span></li>';
		}
	}

	if($segment_3){
		for($i=$last_page-$segment_3+1; $i<=$last_page; $i++){
			$param_page = $key.'='.$i;
			$query = trim($param_page.'&'.$inputs, '&');
			$link = ($query) ? $base_url.'?'.$query : $base_url;
			$li_class = ($i==$current_page) ? ' class="active"' : '';
			$output .= '<li'.$li_class.'><a href="'.$link.'">'.$i.'</a></li>';
			$segment -= 1;
		}
	}


	// goto next link
	if($current_page<$last_page){
		$param_page = $key.'='.($current_page+1);
		$query = trim($param_page.'&'.$inputs, '&');
		$link = ($query) ? $base_url.'?'.$query : $base_url;
	}
	else{
		$link = false;
	}

	if($link){
		$output .= '<li><a href="'.$link.'">&raquo;</a></li>';
	}
	else{
		$output .= '<li class="disabled"><span>&raquo;</span></li>';
	}	

	$output .= '</ul>';

	return $output;
}




function ea_district_code_new($area=null, $dep='for-sale'){
	$district_code = array(
		'brighton-hove' => '4061',
		'south-coast' => '4061',
		'caterham' => '56',
		'coulsdon' => '57',
		'crawley'  => '8',
		'croydon' => '60',
		'dorking' => '8593',
		// 'east-grinstead' => '4084',
		// 'epsom' => '9303',
		// 'haywards-heath' => '4086',
		'horley' => '9',
		// 'horsham' => '6454',
		// 'kingston' => '9796',
		'redhill' => '58',
		'sutton' => '59',
		// 'tunbridge-wells' => '5892',
		'worthing' => '4897',
		'dockland' => '30582',
		'central-london' => '30582',
		'nationwide' => '44562',
	);

	$district_investment_code = array(
		'london-north' => 50,
		'london-south' => 51,
		'surrey-sussex' => 54,
		'essex-kent' => 49,
		'east-midlands' => 48,
		'west-midlands' => 55,
		'central-southern-england' => 47,
		'south-west-counties' => 53,
		'north-england' => 52,
	);

	if($dep=='for-investment'){
		$district_code = $district_investment_code;
	}

	if($area){
		return SG_Util::val($district_code, $area);
	}
	elseif($area===''){
		return array();
	}

	return $district_code;
}




function ea_price_array_new($key=null){
	$price = array(
		'for-sale' => array(
		   '25000','50000','75000','100000','125000','150000','175000','225000','250000','275000',
		   '300000','350000','400000','450000','500000','550000','600000','700000','800000','900000',
		   '1000000'
		),
		'to-rent' => array(
		   '400','500','600','700','800','900','1000','1200','1400','1600',
		   '1800','2000','3000',
		)
	);

	if($key){
		return SG_Util::val($price, $key);
	}
	else{
		return $price;
	}
}


function ea_price_init_new(){
	$choices_price = array(
		'for-sale' => array(
		   '25000','50000','75000','100000','125000','150000','175000','225000','250000','275000',
		   '300000','350000','400000','450000','500000','550000','600000','700000','800000','900000',
		   '1000000'
		),
		'to-rent' => array(
		   '400','500','600','700','800','900','1000','1200','1400','1600',
		   '1800','2000','3000',
		)
	);

	// Register the script first.
	wp_register_script('ea-form-price', 
		get_template_directory_uri() . '/front/assets/js/ea-form-price.js',
		array('theme-js'),
		'',
		true
	);

	// Now we can localize the script with our data.
	wp_localize_script('ea-form-price', 'choices_price', ea_price_array());

	// The script can be enqueued now or later.
	wp_enqueue_script('ea-form-price');
}
add_action('init','ea_price_init');


function ea_property_block($data)
{
	extract($data);

	ob_start();
?>
	
	<div class="block block-box block-property bg-gray">
		<div class="block-thumb no-overflow">
			<a class="anim-hover hover-parent" href="<?php echo $prop_link ?>">
				<img class="hover-child hover-grow" src="<?php echo $prop_image ?>" alt="<?php echo $prop_title ?>" />
				<?php if($prop_type): ?>
					<span class="property-priority bg-primary"><?php echo $prop_type ?></span>
				<?php endif; ?>
			</a>
		</div>
		<div class="block-body">
			<h5 class="property-title">
				<a href="<?php echo $prop_link ?>"><?php echo $prop_title ?></a>
			</h5>
			<div class="property-rooms-count">
				<span title="Bedrooms"><i class="fa fa-bed"></i> <?php echo $bedrooms ?> beds</span>						
				<span title="Bathrooms"><i class="fa fa-tint"></i> <?php echo $bathrooms ?> baths</span>						
				<span title="Receptions"><i class="fa fa-coffee"></i> <?php echo $receptions ?> receptions</span>						
			</div>
			<div class="property-price"><?php echo str_replace('Â','',$prop_price) ?></div>
		</div>
	</div>
	<!-- block -->

<?php
	
	return ob_get_clean();

}