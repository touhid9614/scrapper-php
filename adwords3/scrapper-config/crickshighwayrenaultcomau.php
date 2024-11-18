<?php
global $scrapper_configs;
$scrapper_configs["crickshighwayrenaultcomau"] = array( 
	"entry_points" => array(
	        'new'   => 'https://crickshighwayrenault.com.au/stock/new',
            'used'  => 'https://crickshighwayrenault.com.au/stock/used',
            'demo'  => 'https://crickshighwayrenault.com.au/stock/demo',
        ),
        'vdp_url_regex'     => '/\/stock\/details\//i',
        'use-proxy' => true,
         'refine'=>false,
        'picture_selectors' => ['.lSPager.lSGallery'],
        'picture_nexts'     => ['.lSNext'],
        'picture_prevs'     => ['.lSPrev'],
        'details_start_tag' => '<div class="cs-layout-grid">',
        'details_end_tag'   => '<footer class="footer">',
        'details_spliter'   => '<div class="stock-item',
        'data_capture_regx' => array(
            'url'                 => '/<a class="si-title" href="(?<url>[^"]+)/',
            'year'                => '/<span class="year">(?<year>[^<]+)/',
            'make'                => '/<span class="make">(?<make>[^<]+)/',
            'model'               => '/<span class="model">(?<model>[^<]+)/',
            'price'               => '/<span class="price-value sl-highlight">(?<price>\$[0-9,]+)/',
           // 'trim'                => '/<h1 title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)\s*(?<trim>[^"]+))/',
            
        ),
        'data_capture_regx_full'  => array( 
            'stock_number'        => '/Stock #:[^>]+>\s*[^>]+>\s*(?<stock_number>[^<]+)/',
        	'transmission'        => '/Transmission:[^>]+>\s*[^>]+>\s*(?<transmission>[^\<]+)<\/span>[^>]+>\s*<div><span>Colour/',
        	'kilometres'          => '/Kilometres:[^>]+>\s*[^>]+>\s*(?<kilometres>[^\<]+)/',
            'exterior_color'      => '/<div><span>Colour:[^>]+>\s*[^>]+>\s*(?<exterior_color>[^\<]+)/',    
            'engine'              => '/Engine:[^>]+>\s*[^>]+>\s*(?<engine>[^\<]+)/',  
            'vin'                 => '/VIN:[^>]+>\s*[^>]+>\s*(?<vin>[^\<]+)/',         
            'description'         => '/<meta property="og:description" content="(?<description>[^"]+)/',
        ) ,
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" rel="next"\s*class="btn btn-primary"/',
        'images_regx'       => '/<div class="embla__slide__inner">\s*<a href="(?<img_url>[^"]+)"/'
    );

add_filter("filter_crickshighwayrenaultcomau_field_price", "filter_crickshighwayrenaultcomau_field_price", 10, 3);
add_filter("filter_crickshighwayrenaultcomau_field_description", "filter_crickshighwayrenaultcomau_field_description");

function filter_crickshighwayrenaultcomau_field_description($description) {
    return strip_tags($description);
}

function filter_crickshighwayrenaultcomau_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/<span class="t-large">Now\s*(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/price-value sl-highlight price-special">(?<price>[^<]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
add_filter("filter_crickshighwayrenaultcomau_field_images", "filter_crickshighwayrenaultcomau_field_images");
function filter_crickshighwayrenaultcomau_field_images($im_urls) {
    if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
}
add_filter('filter_crickshighwayrenaultcomau_car_data', 'filter_crickshighwayrenaultcomau_car_data');

function filter_crickshighwayrenaultcomau_car_data($car_data) {

     
    if($car_data['stock_type']=='demo'){
        $car_data['custom']="demo";
        $car_data['stock_type']="new";
    }
    else{
        $car_data['custom']=$car_data['stock_type'];
    }
    $car_data['description'] = strip_tags(preg_replace("/[^a-zA-Z0-9`_.,;@#%~'\"\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\-\s\\\\]+/", "", $car_data['description']));
    $car_data['description'] =str_replace("<","",$car_data['description']);
    
    return $car_data;
}
