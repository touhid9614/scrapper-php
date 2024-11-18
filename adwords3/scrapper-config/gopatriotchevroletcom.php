<?php
global $scrapper_configs;
$scrapper_configs["gopatriotchevroletcom"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.gopatriotchevrolet.com/searchnew.aspx',
        'used' => 'https://www.gopatriotchevrolet.com/searchused.aspx',
    ),
        'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
        'refine' => false,
        
        'details_start_tag'   => '<header>',
        'details_end_tag'     => '<div class="row srpDisclaimer">',
        'details_spliter'     => 'vehicle-card vehicle-card--mo',
         'data_capture_regx' => array(
        'url'   => '/<a class="vehicle-title"\s*[^"]+"[^"]+"\s*href="(?<url>[^"]+)"/',
        //'title' => '/title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))">\s*<h3 class="vehicle-title__text h2">/',
        'year'  => '/<span class="vehicle-title__year">(?<year>[0-9]{4})/',
        'make'  => '/<span class="vehicle-title__make-model">\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model' => '/<span class="vehicle-title__make-model">\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'price' => '/<span class="vehiclePricingHighlightAmount\s*">(?<price>[^<]+)<\/span>\s*<[^>]+>BEST PRICE/',
        'vin'   => '/VIN:\s*[^>]+>\s*<span class="vehicle-identifiers__value">(?<vin>[^<]+)/',
        'stock_number'   => '/Stock:\s*[^>]+>\s*<span class="vehicle-identifiers__value">(?<stock_number>[^<\/]+)/',
    ),
    'data_capture_regx_full' => array(
    	'body_style'     => '/Body Style[^>]+>\s*[^>]+>(?<body_style>[^<\/]+)/',
    	//'transmission'   => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)<\/li>\s*<li class="ext/',
        'engine'         => '/Engine[^>]+>\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/Exterior Color[^>]+>\s*[^>]+>\s*(?<exterior_color>[^<\/]+)/',
       // 'interior_color' => '/class="intColor"><strong>Int. Color: <\/strong>(?<interior_color>[^<\/]+)/',  
        'kilometres'     => '/Mileage[^>]+>\s*[^>]+>\s*(?<kilometres>[^<\/]+)/',

    ),
    'next_page_regx' => '/<a href=\'(?<next>[^\']+)\'\s*class="stat-arrow-next"/',
    'images_regx' => '/hyperlink\'>\s*<img src="(?<img_url>[^\?]+)/',
  
);

   add_filter("filter_gopatriotchevroletcom_field_price", "filter_gopatriotchevroletcom_field_price", 10, 3);

add_filter("filter_gopatriotchevroletcom_field_images", "filter_gopatriotchevroletcom_field_images");


    function filter_gopatriotchevroletcom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }



    $internet_regex = '/Internet Price[^>]+>[^>]+>(?<price>[^<]+)/';
    $retail_regex = '/MSRP:[^>]+>[^>]+>(?<price>[^<]+)/';
    $msrp_regex = '/Patriot Price[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    // $cond_final_regex = '/Price":(?<price>[^.]+)/';
    // $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
    }
