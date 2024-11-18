<?php
    global $scrapper_configs;

    $scrapper_configs['carcorneredmonton'] = array(
        'entry_points' => array(
            'used'  => 'https://www.carcorneredmonton.com/inventory-used-vehicle-car-truck-suv.php'
        ),
        'vdp_url_regex'     => '/\?id=/i',
       // 'ty_url_regex'      => '/\/form\/confirm.htm/',
        'required_params'   => ['id'],
        'use-proxy' => true,
        'picture_selectors' => [],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        
        'details_start_tag' => '<div class="inventory_bar"',
        'details_end_tag'   => '<div style="width:1074px; margin-left:auto; margin-right:auto; background-repeat:repeat-y; margin-top:0px;"',
        'details_spliter'   => '<div class="inventory_list2"',
        
        'data_capture_regx' => array(
            
            'title'         => '/title">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'year'          => '/title">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'make'          => '/title">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'model'         => '/title">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]+)/',
            'price'         => '/price">(?<price>\$[0-9,]+)/',
            'url'           => '/id="inventory[^"]+" onclick="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'          => '/"manufacturer"\s*:\s*"(?<make>[^"]+)/',
            'model'         => '/"model"\s*:\s*"(?<model>[^"]+)/',
            'trim'          => '/Trim:<\/th><td>(?<trim>[^<]+)/',
            'engine'        => '/Engine Type:<\/th><td>(?<engine>[^<]+)/',
            'kilometres'    => '/Kilometers:<\/th><td>(?<kilometres>[^<]+)/',
            'stock_number'  => '/Stock Number:<\/th><td>(?<stock_number>[^<]+)/',
            'transmission'  => '/Transmission:<\/th><td>(?<transmission>[^<]+)/'
        ),
        'next_page_regx'    => '/<div onclick="location\.href=\'(?<next>[^\']+)\'\;" class="pagenumber">/',
        'images_regx'       => '/<img id="thumb[0-9]*" src="(?<img_url>[^"]+)/',
        
    );
    
    add_filter("filter_carcorneredmonton_field_images", "filter_carcorneredmonton_field_images");
    add_filter('filter_carcorneredmonton_field_url', 'filter_carcorneredmonton_field_url');
    function filter_carcorneredmonton_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_replace('thumb_', '', $url);
        }

        return $retval;
    }
    function filter_carcorneredmonton_field_url($url)
    {
        $vehicle_id=strstr(str_replace(['\'','.',';'],"",$url),"id");
        return "https://www.carcorneredmonton.com/inventory-used-vehicle-car-truck-suv.php?".$vehicle_id;
    }
