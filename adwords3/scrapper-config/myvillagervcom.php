<?php
global $scrapper_configs;
$scrapper_configs["myvillagervcom"] = array( 
	 'entry_points' => array(
            'new'   => 'https://www.myvillagerv.com/inventory/?condition=New',
            'used'  => 'https://www.myvillagerv.com/inventory/?condition=Used',
        ),
        'vdp_url_regex' => '/\/inv\//',
         'refine' => false,
        'use-proxy' => true,
        'details_start_tag' => '<div class="inventory-header">',
        'details_end_tag'   => '<footer class=\'container_wrap socket_color',
        'details_spliter'   => '<div class="car_item" id="',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #<\/span>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="cd-title-container-link" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'year'          => '/class="cd-title-container-link" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'make'          => '/class="cd-title-container-link" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'model'         => '/class="cd-title-container-link" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'price'         => '/sale-price sale-price">(?<price>[^<]+)/',
            'url'           => '/class="cd-title-container-link" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        ),
        'data_capture_regx_full' => array(
            'vin'           => '/VIN<\/span>[^>]+>(?<vin>[^<]+)/',
            'body_style'    => '/Class<\/span>[^>]+>(?<body_style>[^<]+)/',
            //'engine'        => '/Engine:&nbsp;\s*(?<engine>[^\s<]+)/',
            //'transmission'  => '/Transmission: (?<transmission>[^<]+)/',
            // 'exterior_color'=> '/Exterior Color<\/span>[^>]+>(?<exterior_color>[^<]+)/',
            // 'interior_color'=> '/Exterior Color<\/span>[^>]+>(?<interior_color>[^<]+)/',
            //'kilometres'    => '/<li>Odometer: (?<kilometres>[^<]+)/',
        ),
        'images_regx'       => '/src="(?<img_url>[^"]+)" \/><\/a><a/',
        'next_page_regx'    => '/<a class="nextpostslink" rel="prev" href="(?<next>[^"]+)"/',
    );
 

// add_filter("filter_myvillagervcom_field_images", "filter_myvillagervcom_field_images");
// function filter_myvillagervcom_field_images($im_urls)
//     {
//         $retval = [];
        
//         foreach($im_urls as $img)
//         {
//             $retval[] = str_replace('https://cdn.shortpixel.ai/client/q_lossless,ret_img/', '', $img);
//         }
        
//         return $retval;
//     }
