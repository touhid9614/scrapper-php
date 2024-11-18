<?php
    global $scrapper_configs;
    $scrapper_configs['gauthierchryslercom'] = array(
        'entry_points' => array(
            'new' => 'https://www.gauthierchrysler.com/new-inventory/',
            'used' => 'https://www.gauthierchrysler.com/used-inventory/',
        ),
            'vdp_url_regex' => '/inventory\/sku\//i',
            'use-proxy' => false,
            'refine'=>false,
            'picture_selectors' => ['.photo-card'],
            'picture_nexts' => ['.viewer-next-button'],
            'picture_prevs' => ['.viewer-prev-button'],
            'details_start_tag' => '<div class="products-list-container',
            'details_end_tag' => '<footer class="',
            'details_spliter' => '<div class="product-item ',
        'new'       => array(
            'vdp_url_regex' => '/inventory\/sku\//i',
            'details_start_tag' => '<div class="products-list-container',
            'details_end_tag' => '<footer class="',
            'details_spliter' => '<div class="product-item ',
        'data_capture_regx' => array(
            'url' => '/class="block-body">\s*<a href="(?<url>[^"]+)" class="link[^>]+>/',
            'year' => '/class="block-body">\s*<a href="(?<url>[^"]+)" class="link[^>]+>(?<year>[^<]+)[^>]+>(?<make>[^<]+)\s*[^>]+>\s*(?<model>[^\s*<]+)/',
            'make' => '/class="block-body">\s*<a href="(?<url>[^"]+)" class="link[^>]+>(?<year>[^<]+)[^>]+>(?<make>[^<]+)\s*[^>]+>\s*(?<model>[^\s*<]+)/',
            'model' => '/class="block-body">\s*<a href="(?<url>[^"]+)" class="link[^>]+>(?<year>[^<]+)[^>]+>(?<make>[^<]+)\s*[^>]+>\s*(?<model>[^\s*<]+)/',
            'msrp' => '/MSRP[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<msrp>[^<]+)/',
            'stock_number' => '/Stock ID[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<stock_number>[^\s*]+)/',
        ),
        'data_capture_regx_full' => array(
            'price' => '/Sale Price[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',
            'kilometres' => '/Mileage[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<kilometres>[^<]+)/',
            'body_style' => '/class="title">Body[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<body_style>[^<]+)/',
            'transmission' => '/Transmission<\/span>\s*<\/div>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*<span class="option-title">\s*(?<transmission>[^\<]+)/',
            'engine' => '/Engine<\/span>\s*<\/div>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*<span class="option-title">\s*(?<engine>[^\<]+)/',
            'year' => '/Year<\/span>\s*<\/div>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*<span class="option-title">\s*(?<year>[0-9]{4})/',
            'make' => '/Make<\/span>\s*<\/div>\s*[^>]+>\s*(?<make>[^\s*]+)/',
            'model' => '/Model<\/span>\s*<\/div>\s*[^>]+>\s*(?<model>[^\<]+)/',
        ),
            'next_page_regx' => '/class="next">\s*<a href="(?<next>[^"]+)/',
            'images_regx' => '/data-gal-src="(?<img_url>[^"]+)/',
            'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
        ),
        
        'used'      => array(
            'vdp_url_regex' => '/inventory\/sku\//i',
            'details_start_tag' => '<div class="products-list-container',
            'details_end_tag' => '<footer class="',
            'details_spliter' => '<div class="product-item ',
        'data_capture_regx' => array(
            'url' => '/class="block-body">\s*<a href="(?<url>[^"]+)" class="link[^>]+>/',
            'year' => '/class="block-body">\s*<a href="(?<url>[^"]+)" class="link[^>]+>(?<year>[^<]+)[^>]+>(?<make>[^<]+)\s*[^>]+>\s*(?<model>[^\s*<]+)/',
            'make' => '/class="block-body">\s*<a href="(?<url>[^"]+)" class="link[^>]+>(?<year>[^<]+)[^>]+>(?<make>[^<]+)\s*[^>]+>\s*(?<model>[^\s*<]+)/',
            'model' => '/class="block-body">\s*<a href="(?<url>[^"]+)" class="link[^>]+>(?<year>[^<]+)[^>]+>(?<make>[^<]+)\s*[^>]+>\s*(?<model>[^\s*<]+)/',
            'price' => '/Our Price[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/', ///dealer price///
            'stock_number' => '/Stock ID[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<stock_number>[^\s*]+)/',
        ),
        'data_capture_regx_full' => array(
            // 'price' => '/Sale Price[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',
            'kilometres' => '/Mileage[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<kilometres>[^<]+)/',
            'body_style' => '/class="title">Body[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<body_style>[^<]+)/',
            'transmission' => '/Transmission<\/span>\s*<\/div>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*<span class="option-title">\s*(?<transmission>[^\<]+)/',
            'engine' => '/Engine<\/span>\s*<\/div>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*<span class="option-title">\s*(?<engine>[^\<]+)/',
            'year' => '/Year<\/span>\s*<\/div>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*<span class="option-title">\s*(?<year>[0-9]{4})/',
            'make' => '/Make<\/span>\s*<\/div>\s*[^>]+>\s*(?<make>[^\s*]+)/',
            'model' => '/Model<\/span>\s*<\/div>\s*[^>]+>\s*(?<model>[^\<]+)/',
        ),
            'next_page_regx' => '/class="next">\s*<a href="(?<next>[^"]+)/',
            'images_regx' => '/data-gal-src="(?<img_url>[^"]+)/',
            'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
        )
    );

add_filter('filter_gauthierchryslercom_car_data', 'filter_gauthierchryslercom_car_data');

function filter_gauthierchryslercom_car_data($car_data) {

    if(!isset($car_data['price'])){
        $car_data['price']=$car_data['msrp'];
    }

    return $car_data;
}

add_filter("filter_gauthierchryslercom_field_images", "filter_gauthierchryslercom_field_images");
function filter_gauthierchryslercom_field_images($im_urls) {
   $retval = [];
         foreach($im_urls as $img)
        {
             $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
        }
        return $retval;
}
