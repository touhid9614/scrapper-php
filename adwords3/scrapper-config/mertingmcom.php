<?php
global $scrapper_configs;
$scrapper_configs["mertingmcom"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.mertingm.com/new/',
        'used' => 'https://www.mertingm.com/used/dealer/Mertin+GM',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'refine'=>false,
    //'proxy-area'        => 'FL',
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.glyphicon-chevron-right'],
    'picture_prevs' => ['.glyphicon-chevron-left'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => 'class="modal-footer">',
    'details_spliter' => '<input type="hidden" style="display:none;" id="vehicle_owner_dealer_id',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)" title="/',  
        'year' => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]+)/',
        'make' => '/itemprop=\'manufacturer[^>]+>[^>]+>(?<make>[0-9a-zA-Z\s]+)/',
        'model' => '/itemprop=\'model[^>]+>[^>]+>(?<model>[0-9a-zA-Z\s]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer".+>(?<kilometres>[0-9,]+\skm)<\/span>/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>\s*(?<stock_number>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>.+cyl)<\/td>/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[0-9a-zA-Z\s]+)<\/td><\/tr>/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[0-9a-zA-Z\s]+)<\/td><\/tr>/',
        'exterior_color' => '/itemprop="color"\s+>(?<exterior_color>[a-zA-Z]+)<\/td><\/tr>/',
    ),
    
  'data_capture_regx_full' => array(
        // 'model' => '/\&model=(?<model>[^\&]+)/',
        // 'trim' => '/\&trim=(?<trim>[^\&]+)/',
        'stock_number'        => '/itemprop="sku">\s*(?<stock_number>[^\<]+)/',
        'engine'              => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style'          => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission'        => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color'     =>  '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
      ),  
    
    'next_page_regx' => '/rel="next"\shref="(?<next>[^"]+)"/',
    'images_regx' => '/data-src="(?<img_url>[^"]*)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

  add_filter("filter_mertingmcom_field_price", "filter_mertingmcom_field_price", 10, 3);

function filter_mertingmcom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Price:<\/span>\s*<[^>]+><[^>]+><[^>]+><[^>]+>(?<price>[^\<]+)/';
    $wholesale_regex = '/Suggested Price:[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/<span style="[^"]+"\s*itemprop="price" content="[^"]+">(?<price>[^\<]+)/';
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


add_filter("filter_mertingmcom_field_images", "filter_mertingmcom_field_images");
   function filter_mertingmcom_field_images($im_urls)
   {
      if(count($im_urls)<2)
           {
           return [];
           }
       return $im_urls;
   }