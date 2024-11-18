<?php
global $scrapper_configs;
 $scrapper_configs["melvillechevrolet"] = array( 
	 'entry_points' => array(
        'used' => 'https://www.melvillechevrolet.com/inventory/used/',
        'new' => 'https://www.melvillechevrolet.com/inventory/new//',
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:New|certified|Used)/i',
    'refine'              => false,
    'picture_selectors' => ['.slick-slide img'],
    'picture_nexts' => ['button.slick-next'],
    'picture_prevs' => ['button.slick-prev'],
    'details_start_tag' => 'class="srpVehicles__wrap">',
    'details_end_tag' => 'class="disclaimer__wrap">',
    'details_spliter' => 'id="carbox',
    'data_capture_regx' => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
        'year' => '/year">\s*(?<year>[0-9]{4})/',
        'make' => '/vehicle-title--make\s*">\s*(?<make>[^\s]+)/',
        'model' => '/vehicle-title--model\s*">\s*(?<model>[^<]+)/',
        'trim' => '/title-trim[^>]+>\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>(?<stock_number>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'price' => '/name="description" content="[^\$]+\$(?<price>[^.]+)/',
        'kilometres' => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
        'engine' => '/Engine:[^>]+>\s*[^>]+>(?<engine>[^\<]+)/',
        'exterior_color' => '/Exterior Color:[^>]+>\s*[^>]+>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:[^>]+>\s*[^>]+>(?<interior_color>[^\<]+)/',
        'transmission' => '/Transmission:[^>]+>\s*[^>]+>(?<transmission>[^\<]+)/',
    ),
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx' => '/data-lightbox="(?<img_url>[^"]+)"/',
);

    add_filter("filter_melvillechevrolet_field_images", "filter_melvillechevrolet_field_images",10,2);
     function filter_melvillechevrolet_field_images($im_urls,$car_data)
    {
    if(isset($car_data['url']) && $car_data['url'])
    {
       $api_url="https://www.melvillechevrolet.com/api/ajax_requests/?currentQuery=".$car_data['url'];
       $response_data = HttpGet($api_url);
       $regex       =  '/url":"(?<img_url>[^"]+)","is_stock/';
        $matches = [];
         $retval = array();
        if (preg_match_all($regex, $response_data, $matches)) {
            foreach ($matches['img_url'] as $key => $value) {
                $retval= str_replace(['\\'], [''], rawurldecode($value));
                $im_urls[] = $retval;
            }
        }
    }
    
    return  $im_urls;
    }