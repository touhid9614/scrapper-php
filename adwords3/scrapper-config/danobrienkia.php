<?php
    global $scrapper_configs;

    $scrapper_configs['danobrienkia'] = array(
        'entry_points' => array(
            'new'   => 'https://www.danobrienkiaconcord.com/inventory?type=new',
            'used'  => 'https://www.danobrienkiaconcord.com/inventory?type=used'
        ),
       'vdp_url_regex'     => '/vehicle-details\/(?:new|used|certified)-[0-9]{4}-/i',
          'ty_url_regex'      => '/\/form\/confirm.htm/i',
         'use-proxy' => true,
        
        'picture_selectors' => ['.slick-slide'],
        'picture_nexts' => ['button.slick-next'],
       'picture_prevs' => ['button.slick-prev'],
        
        'details_start_tag' => '<div class="srp-vehicle-container" >',
        'details_end_tag'   => '<div class="footer">',
        'details_spliter'   => '<div class="row srp-vehicle" itemprop="offers"',
    
        'data_capture_regx' => array(
         'url' => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
        'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'stock_number' => '/<div class="column"><span>Stock:<\/span>\s*(?<stock_number>[^<]+)/',
        'vin' => '/">VIN[^>]+>\s*(?<vin>[^<]+)/',
        'price' => '/itemprop=\'price\' content=\'(?<price>[0-9]+)\'>/',
        'exterior_color' => '/<div class="column"><span>Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/<div class="column"><span>Ext. Color:<\/span>\s*(?<interior_color>[^<]+)/',
        'engine' => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/'
    ),
        'data_capture_regx_full' => array(          
            'make'          => '/make":\s*"(?<make>[^"]+)/',
            'model'         => '/model":\s*"(?<model>[^"]+)/',
            'trim'          => '/trim":\s*"(?<trim>[^"]+)/',
            'body_style'    => '/Body Style:<\/span>\s*(?<body_style>[^<]+)/',
            
        ),
        'next_page_regx'    => '/current\'><a[^>]+>[0-9]*<\/a><\/li><li><a href=\'(?<next>[^\']+)/',
        'images_regx'       => '/vehicleGallery" href="(?<img_url>[^"]+)/',
        
    );
 
    add_filter("filter_danobrienkia_field_images", "filter_danobrienkia_field_images");
    function filter_danobrienkia_field_images($im_urls) {
    
         return array_filter($im_urls, function($img_url) {
                 return !endsWith($img_url, "5a3a77a9b91f4.png");
                 }
            );
        }
