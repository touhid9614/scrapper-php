<?php

    global $scrapper_configs;

    $scrapper_configs['silversagechev'] = array(
        'entry_points' => array(
            'new'    => 'http://silversagechev.ca/request/vehicle_search.php',
            'used'   => 'http://silversagechev.ca/request/vehicle_search.php'
        ),
        
        'vdp_url_regex'     => '/\/vehicle\/[0-9]{4}\//i',

        'next_method'       => 'POST',
        'picture_selectors' => ['.small-img'],
        
        'details_spliter'   => '<div class="vehicle-summary-item clearfix">',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock#\s*(?<stock_number>[^\s]+)/',
            'title'         => '/<a href="(?<url>[^"]+)"\s*title="view details about (?<title>[0-9]{4}[^"]+)/',
            'year'          => '/title="[^"]+">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
            'make'          => '/title="[^"]+">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
            'model'         => '/title="[^"]+">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
            'price'         => '/class="price">\s*<span[^>]+>[^>]+>\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/class="odometer">(?<kilometres>[^<]+)/',
            'url'           => '/<a href="(?<url>[^"]+)"\s*title="view details about (?<title>[0-9]{4}[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'trim'          => '/Trim package<\/div>\s*<div[^>]+>(?<trim>[^<]+)/',
            'transmission'  => '/Transmission<\/div>\s*<div[^>]+>(?<transmission>[^<]+)/',
            'engine'        => '/Engine<\/div>\s*<div[^>]+>(?<engine>[^<]+)/',
            'exterior_color'=> '/Exterior<\/div>\s*<div[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior<\/div>\s*<div[^>]+>(?<interior_color>[^<]+)/',
        ),
        
        'images_regx'       => '/<a class="small-img"[^>]+>\s*<img src="(?<img_url>[^"]+)/'
    );
    
    add_filter('filter_silversagechev_post_data', 'filter_silversagechev_post_data', 10, 2);
    add_filter('filter_silversagechev_data', 'filter_silversagechev_data');

    function filter_silversagechev_post_data($post_data, $stock_type)
    {
        return "search%5Bsort%5D=0&search%5Byear_start%5D=0&search%5Byear_end%5D=0&search%5Bmake%5D=0&search%5Bbody_style%5D=0&search%5Bsubcategory%5D={$stock_type}";
    }

    function filter_silversagechev_data($data)
    {
        if($data)
        {
            $obj = json_decode($data);

            $data = "{$obj->html}\n{$obj->error}\n{$obj->error_message}";
        }

        return $data;
    }
