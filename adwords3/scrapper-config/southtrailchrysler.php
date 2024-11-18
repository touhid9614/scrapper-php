<?php
global $scrapper_configs;
 $scrapper_configs["southtrailchrysler"] = array( 
	'entry_points' => array(
            'new'   => 'https://www.southtrailchrysler.com/content/templates/southtcrysler/themes/southtcrysler/inventory-ax-loader.php',
            'used'  => 'https://www.southtrailchrysler.com/content/templates/southtcrysler/themes/southtcrysler/inventory-ax-loader.php'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/view-detail[^\/]+\/[0-9]*\/[0-9]{4}-/i',
//        'vdp_url_regex'     => '/\/inventory\/(?:new|used|certified)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-your-/i',
        'picture_selectors' => ['.vdp_thumb'],
        'picture_nexts'     => ['.thumb-right'],
        'picture_prevs'     => ['.thumb-left'],
        'init_method'       => 'POST',
        'next_method'       => 'POST',
      //  'details_start_tag' => '<div class="vehicle-wrap">',
        //'details_end_tag'   => '<ul class=\'pagination\'>',
        'details_spliter'   => "<div class='inventory-box'>",
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #\s*(?<stock_number>[^<]+)/',
            'title'         => '/class=\'vtitle\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'year'          => '/class=\'vtitle\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'make'          => '/class=\'vtitle\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'model'         => '/class=\'vtitle\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',       
            'price'         => '/class=\'itop redprice\'>\s*[^$]+(?<price>\$[0-9,]+)/',
            'url'           => '/class=\'inv-image-holder\'>\s*<a href=\'(?<url>[^\']+)\'>/'
        ),
        'data_capture_regx_full' => array(
           'trim'          => '/Trim<\/td>\s*[^>]+>(?<trim>[^<]+)/',  
            'body_style'    => '/Vehicle Type<\/td>\s*[^>]+>(?<body_style>[^<]+)/',
            'transmission'  => '/Transmission<\/td>\s*[^>]+>(?<transmission>[^<]+)/',
            'engine'        => '/Engine<\/td>\s*[^>]+>(?<engine>[^<]+)/',
            'exterior_color'=> '/Exterior Color<\/td>\s*[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color<\/td>\s*[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage<\/td>\s*[^>]+>(?<kilometres>[^<]+)/',
        ),
        'next_query_regx'   => '/data-grid-button-active">[0-9]*<\/div><a data-nav=\"[0-9]*\" href=\"\?(?<param>offset)=(?<value>[0-9]*)\"/',
        'images_regx'       => '/<div class=\'vdp_thumb\'[^>]+>[^\/]+(?<img_url>[^\']+)/'
    );
    
    add_filter('filter_southtrailchrysler_post_data', 'filter_southtrailchrysler_post_data',10, 3);
    add_filter('filter_southtrailchrysler_data', 'filter_southtrailchrysler_data');
    
    function filter_southtrailchrysler_post_data($post_data, $stock_type, $data)
    {
        if($post_data == '') {
            $post_data = 'offset=0';
        }
        
        $arr = explode('=', $post_data);
        
        $offset = $arr[1];
        
        return "filters%5B%5D=&filters%5B%5D=$stock_type&filters%5B%5D=&filters%5B%5D=&filters%5B%5D=&filters%5B%5D=0&filters%5B%5D=0&filters%5B%5D=$offset&filters%5B%5D=0&filters%5B%5D=&certified=false&sub=&trim=&sort=";
    }

    function filter_southtrailchrysler_data($data)
    {
        if($data)
        {
            if(isJSON($data)){
                slecho("data is in jSon format");
                $obj = json_decode($data);

                $data = $obj->{0};
            }
            else { slecho("data is not in jSon format"); }
        }

        return $data;
    }
    
   
   