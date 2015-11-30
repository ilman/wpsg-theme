<?php 

define('RESALESAID','1014809');

function resales_price_array($key=null){
	$price = array(
		'for-sale' => array(
		   '100000','125000','150000','175000','225000','250000','275000',
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


function curl_resales($url, $params=array())
{
	//http://www.sitepoint.com/using-curl-for-remote-requests/

	$ch = curl_init();
	$wp_upload_dir = wp_upload_dir();
	$wp_upload_dir = $wp_upload_dir['basedir'];

	curl_setopt_array(
    $ch, array( 
	    CURLOPT_URL => $url,
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_FOLLOWLOCATION => true,
	    CURLOPT_CONNECTTIMEOUT => 0,
	    CURLOPT_TIMEOUT => 400,
	    // CURLOPT_NOBODY => true,
	    // CURLOPT_COOKIESESSION => true,
    	// CURLOPT_COOKIEJAR => $wp_upload_dir.'/choices-ea-cookie.txt'
	));
 
	$body = curl_exec($ch);
	$header = curl_getinfo($ch);

	curl_close($ch);

	if($body){
		return array('body'=>$body,'header'=>$header);
	}

	return false;
}


function render_resales_property_html($data, $layout='list-column'){

	if(!is_array($data)){
		return false;
	}

	extract($data);

	if(strrpos(strtolower($url), 'accessdenied') !== false){
		return '<p><i>Temporary session from Resales Online is expired, please repeat your search</i></p>';
	}

	$path = '/templates/resales-'.$layout.'.php';

	ob_start();	
	include(SG_THEME_PATH.$path);
	return ob_get_clean();
}


function resales_pagination_links($query_info, $params=false, $base_url=false){
	extract((array) $query_info);
	$total_pages = round($property_count/$per_page);
	$last_page = $total_pages;

	// $base_url = ($base_url) ? $base_url : Request::url();
	$params = ($params) ? $params : $_GET;
	unset($params['s_page']);
	$params = http_build_query($params);

	$output = '<ul class="pagination">';

	// goto prev link
	if($current_page>1){
		$param_page = 's_page='.($current_page-1);
		$query = trim($param_page.'&'.$params, '&');
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
			$param_page = ($i>1) ? 's_page='.$i : '';
			$query = trim($param_page.'&'.$params, '&');
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
			$param_page = 's_page='.$i;
			$query = trim($param_page.'&'.$params, '&');
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
			$param_page = 's_page='.$i;
			$query = trim($param_page.'&'.$params, '&');
			$link = ($query) ? $base_url.'?'.$query : $base_url;
			$li_class = ($i==$current_page) ? ' class="active"' : '';
			$output .= '<li'.$li_class.'><a href="'.$link.'">'.$i.'</a></li>';
			$segment -= 1;
		}
	}


	// goto next link
	if($current_page<$last_page){
		$param_page = 's_page='.($current_page+1);
		$query = trim($param_page.'&'.$params, '&');
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