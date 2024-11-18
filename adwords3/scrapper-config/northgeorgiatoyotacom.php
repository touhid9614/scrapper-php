<?php
global $scrapper_configs;
$scrapper_configs["northgeorgiatoyotacom"] = array( 
'entry_points' => array(
        'used' => 'https://www.northgeorgiatoyota.com/searchused.aspx',
        'new' => 'https://www.northgeorgiatoyota.com/searchnew.aspx',   
    ),
       'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
       'refine'=>false,
       'picture_selectors' => ['.carousel__item'],
       'picture_nexts' => ['.carousel__control.carousel__control--next'],
       'picture_prevs' => ['.carousel__control.carousel__control--prev'],
    
       'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
       'details_end_tag' => '<div class="row srpDisclaimer">',
       'details_spliter' => '<div id="srpRow-',
    
        'data_capture_regx' => array(
            'url'              => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*<]*))/',
            'title'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*<]*))/',
            'year'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*<]*))/',
            'make'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*<]*))/',
            'model'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*<]*))/',
            'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
            'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
            'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
            'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
            'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
            'stock_number'     => '/<strong>VIN\s*#:\s*[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'kilometres'       => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
            'price'            => '/Internet Price[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[0-9,]+)/',
        ),
        'data_capture_regx_full' => array(
         
        ),
        
      'next_page_regx' => '/href="(?<next>[^"]+)"\s*class="stat-arrow-next"[^>]+>\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
    );
    add_filter("filter_northgeorgiatoyotacom_field_price", "filter_northgeorgiatoyotacom_field_price", 10, 3);
    add_filter("filter_northgeorgiatoyotacom_field_model", "filter_northgeorgiatoyotacom_field_model");
    add_filter("filter_northgeorgiatoyotacom_field_trim", "filter_northgeorgiatoyotacom_field_trim");
    function filter_northgeorgiatoyotacom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Internet Price: $price");
        }
        
        $msrp_regex =  '/MSRP[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[0-9,]+)/';
        $internetPrice    ='/Internet Price[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($internetPrice, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
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
    function filter_northgeorgiatoyotacom_field_model($model)
    {
        return str_replace('+', ' ', $model);
    }
    function filter_northgeorgiatoyotacom_field_trim($trim)
    {
        return str_replace('+', ' ', $trim);
    }
 