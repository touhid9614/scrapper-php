<?php
global $scrapper_configs;
$scrapper_configs["suncoastcjdcom"] = array( 
	  'entry_points' => array(
            'used'  => 'https://www.suncoastcjd.com/used-cars-seminole-fl.html',
            'new'   => 'https://www.suncoastcjd.com/car-dealership-seminole-fl.html',
         
        ),
       'vdp_url_regex' => '/\/(?:new|used)-[^-]*-[0-9]{4}-/i',
    'picture_selectors' => ['.img-responsive'],
    'picture_nexts' => ['.stat-arrow-next'],
    'picture_prevs' => ['.stat-arrow-prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/class="vehicleTitle\s*margin-[^>]+>\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'year' => '/class="vehicleTitle\s*margin-[^>]+>\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'make' => '/class="vehicleTitle\s*margin-[^>]+>\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'model' => '/class="vehicleTitle\s*margin-[^>]+>\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'trim' => '/class="vehicleTitle\s*margin-[^>]+>\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
         'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'price' => '/(?:Internet Price|Sale Price:)\s*<\/span><span [^>]+>(?<price>[$0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'trim' => '/var vehicleTrim="(?<trim>[^"]+)/',
        'make' => '/var vehicleMake="(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
    'images_regx' => '/<img class=\'img-responsive\' src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);add_filter("filter_suncoastcjdcom_field_price", "filter_suncoastcjdcom_field_price", 10, 3);

    function filter_suncoastcjdcom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];

        slecho('');

        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("suncoastcjdcom Price: $price");
        }

        $msrp_regex      = '/MSRP:\s*[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
      

        $matches = [];

        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }

      
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }

        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }