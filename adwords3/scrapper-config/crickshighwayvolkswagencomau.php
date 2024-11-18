<?php
global $scrapper_configs;
$scrapper_configs["crickshighwayvolkswagencomau"] = array( 
	"entry_points" => array(
             'used'  => 'https://crickshighwayvolkswagen.com.au/stock/used',
	        'new'   => 'https://crickshighwayvolkswagen.com.au/stock/new',
           'demo'  => 'https://crickshighwayvolkswagen.com.au/stock/demo',
        ),
        'vdp_url_regex'     => '/\/stock\/details\//i',
        'use-proxy' => true,
      'refine'=>false,
        'picture_selectors' => ['.lSPager.lSGallery'],
        'picture_nexts'     => ['.lSNext'],
        'picture_prevs'     => ['.lSPrev'],
        'details_start_tag' => '<div class="cs-layout-grid">',
        'details_end_tag'   => '<footer class="footer">',
        'details_spliter'   => '<section class="car-list',
        'data_capture_regx' => array(
            'url'                 => '/class="clm-image t-col-6 d-col-4">\s*<a href="(?<url>[^"]+)/',
            'year'                => '/<h1 title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'make'                => '/<h1 title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'model'               => '/<h1 title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'price'               => '/class="overall-price"><[^>]+>(?<price>\$[0-9,]+)/',
            'trim'                => '/<h1 title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)\s*(?<trim>[^"]+))/',
            'stock_number'        => '/class="stock_nos" value="(?<stock_number>[^"]+)/',
           
           
            
        ),
        'data_capture_regx_full' => array( 
        	'transmission'        => '/Transmission:<\/b>\s*<span>(?<transmission>[^\<]+)/',
        	'kilometres'          => '/Kilometres:<\/b>\s*<span>(?<kilometres>[^<]+)/',
            'exterior_color'     => '/Colour:<\/b>\s*<span>(?<exterior_color>[^\<]+)/',    
            'engine'              => '/Engine:<\/b>\s*<span>(?<engine>[^\<]+)/',  
               'vin'              => '/VIN:<\/b>\s*<span>(?<vin>[^\<]+)/',    
            'description'         => '/<h2>Comments<\/h2>\s*<p>(?<description>[\s\S]*?(?=<h2>))/',
        ) ,
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" rel="next"\s*class="btn btn-primary"/',
        'images_regx'       => '/<li data-thumb="(?<img_url>[^"]+)">/',
    
    );

add_filter("filter_crickshighwayvolkswagencomau_field_price", "filter_crickshighwayvolkswagencomau_field_price", 10, 3);
add_filter("filter_crickshighwayvolkswagencomau_field_description", "filter_crickshighwayvolkswagencomau_field_description");

function filter_crickshighwayvolkswagencomau_field_description($description) {
    return strip_tags($description);
}

function filter_crickshighwayvolkswagencomau_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/<span class="t-large">Now\s*(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
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
add_filter("filter_crickshighwayvolkswagencomau_field_images", "filter_crickshighwayvolkswagencomau_field_images");
function filter_crickshighwayvolkswagencomau_field_images($im_urls) {
    if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
}
add_filter('filter_crickshighwayvolkswagencomau_car_data', 'filter_crickshighwayvolkswagencomau_car_data');

function filter_crickshighwayvolkswagencomau_car_data($car_data) {

     
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
