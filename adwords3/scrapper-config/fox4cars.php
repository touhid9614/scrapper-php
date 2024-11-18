<?php
global $scrapper_configs;

$scrapper_configs['fox4cars'] = array(
    'entry_points' => array(
        'used' => 'http://www.fox4cars.com/view-inventory'
      
    ),
    'vdp_url_regex' => '/\/vehicle-details\//i',

    'use-proxy' => true,
    'init_method'    => 'GET',
    'next_method'       => 'POST',
    'picture_selectors' => ['.flexslider .slides > li'],
    'picture_nexts'     => [],
    'picture_prevs'     => [],
     'details_start_tag' => '<div class="inventory-list-container">',
     'details_end_tag'   => '<div class="footer-container "',
     'details_spliter'   => '<div class="clearfix inventory-panel palette-bg2  lot-00">',
     'data_capture_regx' => array(
        'stock_number'   => '/class="stocknumber">(?<stock_number>[^<]+)/',
        'url'            => '/accent-color1" href="(?<url>[^"]+)"\s* title="(?<title>[^"]+)/',
        'title'          => '/accent-color1" href="(?<url>[^"]+)"\s* title="(?<title>[^"]+)/',
        'year'           => '/accent-color1" href="[^"]+"\s* title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s*]+)\s*(?<body_type>[^"]+)/',
        'make'           => '/accent-color1" href="[^"]+"\s* title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s*]+)\s*(?<body_type>[^"]+)/',
        'model'          => '/accent-color1" href="[^"]+"\s* title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s*]+)\s*(?<body_type>[^"]+)/',
        'trim'           => '/accent-color1" href="[^"]+"\s* title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s*]+)\s*(?<body_type>[^"]+)/',
        'price'          => '/accent-color1 pricevalue1[^\$]+\$<\/span>(?<price>[0-9,]+)/',
        'exterior_color' => '/class="Extcolor">(?<exterior_color>[^<]+)/',
        'interior_color' => '/class="Intcolor">(?<interior_color>[^<]+)/',
        'engine'         => '/class="engine">(?<engine>[^<]+)/',
        'kilometres'     => '/class="mileage">(?<kilometres>[^<]+)/',
        'transmission'   => '/class="transmission">(?<transmission>[^<]+)/',
        'body_style'     => '/accent-color1" href="[^"]+"\s* title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s*]+)\s*(?<body_type>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
        
        
    ),
        'next_page_regx'        => '/onclick="Inventory_SetPage\(\'(?<param>0258b099ba094f0999cf0ca03aa3a0b6)\',\'(?<value>2)\'\);" title="Next Page"/',
        'images_regx'           => '/<li><a href="(?<img_url>[^"]+)/',
        
    );

    add_filter('filter_fox4cars_post_data', 'filter_fox4cars_post_data');
    function filter_fox4cars_post_data($post_data)
    {
        
        slecho ("Post Data: ".$post_data);
        $exp = explode('=', $post_data);
        
        return "xControlId=$exp[0]&xAction=SetPage&xPageId=$exp[1]";
    }

    