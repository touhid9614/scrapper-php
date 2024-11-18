<?php
global $scrapper_configs;
 $scrapper_configs["cutterauto"] = array( 
	'entry_points' => array(
            'new'   => 'https://www.cutterauto.com/new-cars-for-sale-oahu',
            'used'  => 'https://www.cutterauto.com/used-cars-for-sale-oahu'
        ),
        'vdp_url_regex'       => '/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.magic-thumbs'],
        'picture_nexts'     => ['.mz-button.mz-button-next'],
        'picture_prevs'     => ['.mz-button.mz-button-prev'],
     
         'details_start_tag' => '<div class="srp-vehicle-container" >',
         'details_end_tag' => '<div class="footer">',
         'details_spliter' => '<div class="row srp-vehicle"',
        'data_capture_regx' => array(
        'stock_number' => '/Stock:<\/span>\s*(?<stock_number>[^<]+)/',
        'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'price' => '/(?:MSRP|Sale Price):[^\$]+\$.*itemprop=\'price\' content=\'(?<price>[^\']+)/',
        'engine' => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/',
        'exterior_color' => '/Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
        'url' => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
        'interior_color' => '/Int. Color:<\/span>\s*(?<interior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '/make":\s*"(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
        'trim' => '/trim":\s*"(?<trim>[^"]+)/',
    ),
    'next_page_regx' => '/current\'><a[^>]+>[0-9]<\/a><\/li><li><a href=\'\/inventory(?<next>[^\']+)/',
    'images_regx' => '/vehicleGallery" href="(?<img_url>[^"]+)/',
);
