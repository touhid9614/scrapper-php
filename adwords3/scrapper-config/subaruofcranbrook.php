<?php
    global $scrapper_configs;

    $scrapper_configs['subaruofcranbrook'] = array(
        'entry_points' => array(
            'new'   => [
                'http://www.subaruofcranbrook.com/new-subaru-for-sale-in-cranbrook'
            ],
            'used'  => [
                'http://www.subaruofcranbrook.com/shop-for-a-used-car-cranbrook'
            ]
        ),
        'vdp_url_regex'     => '/\/detail\//i',
        'use-proxy' => true,
        'picture_selectors' => ['.i-thumbs-mini img'],
        'picture_nexts'     => ['.i-gallery-right'],
        'picture_prevs'     => ['.i-gallery-left'],
        
        'details_start_tag' => '<div class="page-div"',
        'details_end_tag'   => '<div class="inv-record inv-record-footer">',
        'details_spliter'   => '<div class=\'ibox\'',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock\s<span>(?<stock_number>[^<]+)/',
            'title'         => '/<div class=\'ibox-title\'>(?<title>[^<]+)/',
            'year'          => '/<div class=\'ibox-title\'>(?<year>[0-9]{4})/',
            'make'          => '/<div class=\'ibox-title\'>[0-9]{4}\s(?<make>[^\s]+)/',
            'model'         => '/<div class=\'ibox-title\'>[0-9]{4}\s[^\s]+\s(?<model>[^\s]+)/',
            'trim'          => '/<div class=\'ibox-title\'>[0-9]{4}\s[^\s]+\s[^\s]+\s(?<trim>[^<]+)/',
            'price'         => '/<div class=\'ibox-pricing\'>(?<price>[^<]+)/',
            'url'           => '/<a\sclass=\'ibox-aref\'\shref=\'(?<url>[^\']+)/'
        ),
        'data_capture_regx_full' => array(  
        	'body_style'    => '/Body Type<\/td>\s*[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine<\/td>\s*[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission<\/td>\s*[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior\sColor<\/td>\s*[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior\sColor<\/td>\s*[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage<\/td>\s*[^>]+>(?<kilometers>[^<]+)/',      
            'make'          => '/Make<\/td>\s*[^>]+>(?<make>[^<]+)/',
            'model'         => '/Model<\/td>\s*[^>]+>(?<model>[^<]+)/',
            'trim'		    => '/Trim<\/td>\s*[^>]+>(?<trim>[^<]+)/'
        ) ,
        'next_page_regx'    => '/<a\shref="(?<next>[^"]+)"\sclass="inv-record-button">/',
        'images_regx'       => '/<div class=\'i-thumbs-mini\'><[^\']+\'[^\=]+=\'(?<img_url>[^\']+)/',
        //'images_fallback_regx'  => '/<div class=\'i-title-bars\'>\s*<a\shref="[^-]+-\s(?<img_url>[^\"]+)/'
    );
    add_filter("filter_subaruofcranbrook_field_images", "filter_subaruofcranbrook_field_images");
    
    function filter_subaruofcranbrook_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'unavailable_stockphoto.png');
        });
    }
