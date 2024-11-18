<?php

global $scrapper_configs;
$scrapper_configs["centennialkia"] = array(
   'entry_points' => array(
        'new' => 'https://www.centennialkia.ca/en/new-catalog',
        'used' => 'https://www.centennialkia.ca/en/used-inventory?limit=200',
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/en\/(?:new|used)-(?:inventory|catalog)\//i',
    'picture_selectors' => ['.image-select li a', '#bxslider-pager a'],
    'picture_nexts' => ['', '#cboxNext'],
    'picture_prevs' => ['', '#cboxPrevious'],
    'new' => array(
        'details_start_tag' => '<meta property="og:type" content="website"',
        'details_end_tag' => '<div class="footer-sm custom"',
        'details_spliter' => 'class="catalog-card-vertical__wrapper"',
        'data_capture_regx' => array(
            'url' => '/<a href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)"\s*class/',
            // 'title' => '/<a class="catalog-block-alpha__name-anchor title__tertiary" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'year' => '/<a href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)"\s*class/',
            'make' => '/<a href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)"\s*class/',
            'model' => '/<a href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)"\s*class/',
            'price' => '/class=" vehicle-selling-price__value" data-theme-style=""role="">\s*(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            // 'price' => '/salePrice:\'(?<price>[^\']+)\'\s*/',
        ),
        'images_regx' => '/data-src="[^"]+"\s*itemprop="image"/',
    ),
    'used' => array(
        'details_start_tag' => '<meta property="og:type" content="website"',
        'details_end_tag' => '<div class="footer-sm custom"',
        'details_spliter' => 'class="catalog-card-vertical__wrapper"',
    'data_capture_regx' => array(
        'url'        => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'title'      => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'year'       => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'make'       => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'model'      => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'price'      => '/Available at<\/span>\s*<[^>]+>(?<price>[^<]+)/',
        'kilometres' => '/class="inventory-list-layout__preview-km">\s*<[^>]+><\/span>\s*<[^>]+>(?<kilometres>[0-9 ,]+)\s*KM/'
        ),
        'data_capture_regx_full' => array(
        'stock_number'   => '/Inventory\s*#:<\/div>\s*<[^>]+>(?<stock_number>[^<]+)/',         
        'kilometres'     => '/Mileage:<\/div>\s*<[^>]+>(?<kilometres>[^<]+)/',
        'transmission'   => '/Transmission:<\/div>\s*<[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext. Color:<\/div>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. color:<\/div>\s*[^>]+>(?<interior_color>[^<]+)/',
        'body_style'     => '/Bodystyle:<\/div>\s*<[^>]+>(?<body_style>[^<]+)/',
        'vin'            => '/Inventory\s*#:<\/div>\s*<[^>]+>(?<vin>[^<]+)/',
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
        'drivetrain' => '/Drivetrain:<\/div>\s*[^>]+>(?<drivetrain>[^<]+)/',
        'fuel_type'      => '/Fuel:<\/div>\s*[^>]+>(?<fuel_type>[^<]+)/',
        ),
       //'next_page_regx' => '/class="pagination__page-arrows-text\s*"\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/<div class="inventory-list-layout__preview-image">\s*<img src="(?<img_url>[^"]+)"\s*alt="/',
    ),
);
add_filter("filter_centennialkia_field_images", "filter_centennialkia_field_images",10,2);



    function filter_centennialkia_field_images($im_urls,$car_data)
    {
    if(isset($car_data['url']) && $car_data['url'])
    {
       $id=explode("id",$car_data['url']);
       $api_url="https://www.centennialkia.ca/en/inventory/" . $car_data['stock_type'] . "/fragments/vehiclesByIds?view=ninjabox-gallery&vehicleId={$id[1]}";
       $response_data = HttpGet($api_url);
       $regex       =  '/<img src="(?<img_url>[^"]+)" alt=/';
        $matches = [];
        if(preg_match_all($regex, $response_data, $matches)) {
            foreach ($matches['img_url'] as $key => $value)
            {
               $im_urls[]=$value;
            }
        }
    }
return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no-photo1594838900745.jpg');
        });
        return  $im_urls;
    }


