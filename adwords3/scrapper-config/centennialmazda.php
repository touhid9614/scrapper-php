<?php
global $scrapper_configs;
 $scrapper_configs["centennialmazda"] = array(
	 'entry_points' => array(
             'used'      => 'https://www.centennialmazda.ca/en/used-inventory',
             'new'       => 'https://www.centennialmazda.ca/en/new-inventory',
        ),
        'vdp_url_regex'     => '/\/en\/(?:new|used)-inventory\//i',
        'ty_url_regex'      => '/\/en\/thank-you/i',
        'use-proxy' => true,

        'picture_selectors' => ['div.slick-slide img'],
        'picture_nexts'     => ['.widget-ninjabox__bxslider-controls--next'],
        'picture_prevs'     => ['.widget-ninjabox__bxslider-controls--prev'],


        'details_start_tag' => '<div class="inventory-listing__vehicles',
        'details_end_tag'   => '<footer class="footer-delta',
        'details_spliter'   => '<article class="inventory-list-layout',
        'data_capture_regx' => array(

            'title'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'year'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'make'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'model'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))/',
            'price'         => '/<span itemprop="price" content="[^>]+>(?<price>\$[0-9,]+)/',
            'url'           => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/Inventory #[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
            'body_style'    => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Cylinders[^>]+>\s*[^>]+>(?<engine>[^(?:\&|<)]+)/',
            'transmission'  => '/Transmission:<\/div>[^>]+\s*inventory-details__content-value">(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
            'vin'           => '/vin:\'(?<vin>[^\']+)/',
            'kilometres'    => '/Mileage<\/span>\s*<span class="inventory-details__vehicle-info-value">(?<kilometres>[^<]+)/',
        ),
        'next_page_regx'    => '/<a class="pagination__page-arrows-text " href="(?<next>[^"]+)"[^>]+>[^>]+>Next/',
        'images_regx'       => '/catalog-photo-(?:interior|exterior)">\s*[^"]+"\s*(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );

    add_filter("filter_centennialmazda_field_images", "filter_centennialmazda_field_images",10,2);



     function filter_centennialmazda_field_images($im_urls,$car_data)
    {

    if(isset($car_data['url']) && $car_data['url'])
    {
       $id=explode("id",$car_data['url']);
       $api_url="https://www.centennialmazda.ca/en/inventory/" . $car_data['stock_type'] . "/fragments/vehiclesByIds?view=ninjabox-gallery&vehicleId={$id[1]}";
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

    if(count($im_urls) == 3) { return array(); }
        return  $im_urls;
    }
add_filter('filter_centennialmazda_car_data', 'filter_centennialmazda_car_data');

function filter_centennialmazda_car_data($car_data) {

    if(!isset($car_data['exterior_color'])){
        $car_data['exterior_color']="other";
    }

    return $car_data;
}