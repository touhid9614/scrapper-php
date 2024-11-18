<?php

global $scrapper_configs;
$scrapper_configs["centennialnissanofsummerside"] = array(
      'entry_points' => array(
        'used' => 'https://www.centennialnissanofsummerside.com/en/used-inventory?limit=200',
        'new' => 'https://www.centennialnissanofsummerside.com/en/new-inventory?limit=200',
    ),
    'vdp_url_regex' => '/\/en\/(?:new|pre-owned|used|certified)-inventory\//i',
    'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['.slick-slide'],
    'picture_nexts'     => ['.widget-ninjabox__bxslider-controls--next'],
    'picture_prevs'     => ['.widget-ninjabox__bxslider-controls--prev'],
    
    'details_start_tag' => '<div class="inventory-listing__vehicles',
    'details_end_tag' => '<footer class="',
    'details_spliter' => '<article class="inventory-list-layout-wrapper',
    
    'data_capture_regx' => array(
        'url' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'title' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/', 
        'year' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'make' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'model' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'price' => '/itemprop="price" content=[^>]+>(?<price>\$[0-9,]+)/',
        
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Inventory #:<\/div>\s*[^>]+>(?<stock_number>[^<]+)/',
        'vin' => '/Inventory #:<\/div>\s*[^>]+>(?<vin>[^<]+)/',
         'trim' => '/Trim:<\/div>\s*[^>]+>(?<trim>[^<]+)/',
        'kilometres' => '/Mileage:<\/div>\s*[^>]+>(?<kilometres>[^<]+)/',
        'drivetrain' => '/Drivetrain:<\/div>\s*[^>]+>(?<drivetrain>[^<]+)/',
        'transmission' => '/Transmission:<\/div>\s*[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext.\s*Color:<\/div>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int.\s*color:<\/div>\s*[^>]+>(?<interior_color>[^<]+)/',
        'body_style' => '/Bodystyle:<\/div>\s*[^>]+>(?<body_style>[^<]+)/',
    ),
    'next_page_regx' => '/<a class="pager-item pagination__page-arrows-text .*"\s*href="(?<next>[^"]+)"/',



    'images_regx'       => '/(?:class="inventory-list-layout__preview-image">|class="overlay">)\s*<img.*src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'



   // 'images_regx' => '/<img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+"/',
   // 'images_fallback_regx' => '/<img src="(?<img_url>[^"]+)"\s*onerror="this/'
);
// add_filter("filter_centennialnissanofsummerside_field_images", "filter_centennialnissanofsummerside_field_images");
    
    // function filter_centennialnissanofsummerside_field_images($im_urls)
    // {
    //     return array_filter($im_urls, function($im_url){
    //         return !endsWith($im_url, 'no-photo1594838900745.jpg');
    //     });
    // }



 add_filter("filter_centennialnissanofsummerside_field_images", "filter_centennialnissanofsummerside_field_images",10,2);



     function filter_centennialnissanofsummerside_field_images($im_urls,$car_data)
    {

    if(isset($car_data['url']) && $car_data['url'])
    {
       $id=explode("id",$car_data['url']);
       $api_url="https://www.centennialnissanofsummerside.com/en/inventory/" . $car_data['stock_type'] . "/fragments/vehiclesByIds?view=ninjabox-gallery&vehicleId={$id[1]}";
       $response_data = HttpGet($api_url);
       $regex       =  '/<img src="(?<img_url>[^"]+)" alt=/';

        $matches = [];


        if(preg_match_all($regex, $response_data, $matches)) {

            foreach ($matches['img_url'] as $key => $value)
            {
               $im_urls[]=$value;
            }
             //return  $im_urls;

        }


    }

        return  $im_urls;
    }