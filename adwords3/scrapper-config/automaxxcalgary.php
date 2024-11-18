<?php

    global $scrapper_configs;

    $scrapper_configs['automaxxcalgary'] = array(
        'entry_points' => array(
            'used' => 'https://www.automaxxcalgary.com/used-inventory/index.htm'
        ),
        'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex' => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.slider-slide img'],
        'picture_nexts' => ['.pswp__button--arrow--right'],
        'picture_prevs' => ['.pswp__button--arrow--left'],
        'details_start_tag' => '<div class="type-2 ddc-content"',
        'details_end_tag' => '<div class=" ddc-content content-default"',
        'details_spliter' => '<div class="item-compare">',

        'data_capture_regx' => array(
            'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'model' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'price' => '/final-price"><span[^>]+>[^<]+<span[^>]+>[^<]+<\/span><\/span><span\s*class=\'value\'[^>]+>(?<price>[^<]+)/',
            //'body_style' => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres' => '/Mileage:<\/dt> <dd>(?<kilometres>[^<]+)/',
            'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'trim' => '/data-trim="(?<trim>[^"]+)/',
            'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        ),

        'data_capture_regx_full' => array(
            'vin'           => '/<li>VIN:\s*[^>]+>(?<vin>[^<]+)/',
            'drivetrain'    => '/Drive type: <\/span><span>(?<drivetrain>[^"]+)<\/span>/',
            'fuel_type'     => '/fuelType": "(?<fuel_type>[^"]+)/',
            'body_style'    => '/Body\/Seating<\/dt><dd class="col-xs-7 p-0"><span>(?<body_style>[^<]+)/',
            'transmission' => '/transmission": "(?<transmission>[^"]+)/',
            'description'   => '/Dealer Notes<\/h3>[^>]+>(?:<div>|[^>]+>)(?<description>[\s\S]*?(?=<\/div>))/'
        ),
        
        'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)","thumbnail/',
        'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );

    /*
    add_filter("filter_automaxxcalgary_next_page", "filter_automaxxcalgary_next_page", 10, 2);
    
    function filter_automaxxcalgary_next_page($next,$current_page) 
    {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
    */

    add_filter("filter_automaxxcalgary_field_description", "filter_automaxxcalgary_field_description");
    add_filter('filter_automaxxcalgary_field_images','filter_automaxxcalgary_field_images');
    
    function filter_automaxxcalgary_field_description($description)
    {
       return strip_tags($description);
    }

    function filter_automaxxcalgary_field_images($im_urls)
    {
        foreach($im_urls as $img)
        {
            
             $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
        }
        
        return $retval;
    }
   
   