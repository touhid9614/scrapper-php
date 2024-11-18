<?php
 
    global $scrapper_configs;

    $scrapper_configs['kiaofeasthartfordcom'] = array(
        'entry_points' => array(
            'new'   => 'https://www.kiaofeasthartford.com/new-kia-for-sale?1=1&pg=1&limit=500',
            'used'  => 'https://www.kiaofeasthartford.com/used-kia-for-sale?1=1&pg=1&limit=500'
        ),
        'vdp_url_regex'     => '/(?:new|certified|used)-[0-9]{4}-/i',
		'refine'			=> false,

        'picture_selectors' => ['.mz-thumb'],
        'picture_nexts'     => ['.mz-button.mz-button-next'],
		'picture_prevs'     => ['.mz-button.mz-button-prev'],
		
        'details_start_tag' => '<div class="accordion-content"',
        'details_end_tag'   => '<div class="footer">',
        'details_spliter'   => '<div class="row srp-vehicle"',
        
        'data_capture_regx' => array(
            'stock_number'  => '/<span>Stock:[^>]+>\s*(?<stock_number>[^<]+)/',
            //'title'       => '/<a href=\'(?<url>[^"]+)\'>\s*<span class="CarTitle">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'year'          => '/<span\s*itemprop=\'name\'>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'make'          => '/<span\s*itemprop=\'name\'>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'model'         => '/<span\s*itemprop=\'name\'>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'price'         => '/Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',//price for used cars
            //'body_style'  => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:[^>]+>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>\s*(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color:[^>]+>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. Color:[^>]+>\s*(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:[^>]+>\s*(?<kilometres>[^<]+)/',
			'url'           => '/srp-vehicle-title">\s*<a\s*href="(?<url>[^"]+)/',
			'vin'			=> '/VIN[^>]+>\s*(?<vin>[^<]+)<\/div>/',
        ),
        //'next_page_regx'    => '/<a class="page-link" href="(?<next>[^"]+)" aria-label="Next">/',
        'images_regx' => '/><img src="(?<img_url>[^"]+)"\s*alt/',
    );

    add_filter("filter_kiaofeasthartfordcom_field_price", "filter_kiaofeasthartfordcom_field_price", 10, 3);
    
    function filter_kiaofeasthartfordcom_field_price($price,$car_data, $spltd_data)
       {
           $prices = [];

           slecho('');

           if($price && numarifyPrice($price) > 0) {
               $prices[] = numarifyPrice($price);
               slecho("kiaofeasthartfordcom Price: $price");
           }

        $msrp_regex       =  '/MSRP:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
        $retail_regex     =  '/Sale Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    

                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
      
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Retail Price: {$matches['price']}");
        }
     
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }

           slecho("Sale Price: {$price}".'<br>');
           return $price;
       }
