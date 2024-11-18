<?php
global $scrapper_configs;

$scrapper_configs['summitauto']=array(
        'entry_points' => array(
            'new'   => 'http://www.summitauto.com/new-inventory/index.htm',
            'used'  => 'http://inventory.summitauto.com/fond-du-lac-wi/cars.asp?param_new-used=used&reset=InventoryListing'
        ),
        'vdp_url_regex'     => '/(?:\/fond-du-[^\/]+\/vehicle.asp\?.*|\/new\/.*\/[0-9]{4}-.*)/i',
        'ty_url_regex'      => '/\/contact-form-confirm.htm/i',
        
        'new'     =>array(
                'use-proxy' => true,
                'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
                'details_end_tag'   => '<div class="ft">',
                'details_spliter'   => '<div class="item-compare">',
          
                'data_capture_regx' => array(
                   
                    'url'           => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
                    //'title'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
                    'year'          => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
                    'make'          => '/data-make="(?<make>[^"]+)/',
                    'model'         => '/data-model="(?<model>[^"]+)/',
                    'trim'          => '/data-trim="(?<trim>[^"]+)/',
                    'price'         => '/final-price">[^v]+value\'\s*>\$(?<price>[^<]+)/',
//                    'exterior_color'=> '/Exterior\s*Color:<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
//                    'interior_color'=> '/Interior\s*Color:<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
                    'engine'        => '/Engine:(?<engine>[^<]+)/',
                    'transmission'  => '/Transmission:(?<transmission>[^<]+)/',          
                    'stock_number'  => '/Stock #(?<stock_number>[^\n]+)/',
                    
                ),
                'data_capture_regx_full' => array(
                    'make'          => '/make: \'(?<make>[^\']+)/',
                    'model'         => '/model: \'(?<model>[^\']+)/',
                    'body_style'    => '/bodyStyle: \'(?<body_style>[^\']+)/',
                    'stock_number'  => '/Stock\s*#\s*<\/span>\s*<span[^\n]+\s*<span class="value">\s*(?<stock_number>[^\s]+)/',
                ),
                'next_page_regx'    => '/<a class="ddc-btn\s*ddc-btn-link[^"]+"\s*href="(?<next>[^"]+)"\srel="next"/',
                'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/',
                'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
            ),
            'used'     =>array(
                'required_params'   => ['vehicle_id'],
                'use-proxy' => true,
                'details_start_tag' => '<div class="browse_row" name="1" id="1" >',
                'details_end_tag'   => '<div class="footer_container">',
                'details_spliter'   => '<div class="vehicle_image" id="thumb_holder_',
                //'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
                'data_capture_regx' => array(
                    'stock_number'  => '/Stock\s*#<\/span>\s*[^>]+>(?<stock_number>[^<]+)/',
                    'url'           => '/class="vehicle_link">\s*<a\shref="(?<url>[^"]+)"\s*alt="[^"]+"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^"]+)/',
                    'title'         => '/class="vehicle_link">\s*<a\shref="(?<url>[^"]+)"\s*alt="[^"]+"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^"]+)/',
                    'year'          => '/class="vehicle_link">\s*<a\shref="(?<url>[^"]+)"\s*alt="[^"]+"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^"]+)/',
                    'make'          => '/class="vehicle_link">\s*<a\shref="(?<url>[^"]+)"\s*alt="[^"]+"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^"]+)/',
                    'model'         => '/class="vehicle_link">\s*<a\shref="(?<url>[^"]+)"\s*alt="[^"]+"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^"]+)/',
                    'price'         => '/Price:<\/div><[^>]+>\$(?<price>[^<]+)/',
                    'exterior_color'=> '/Exterior\s*Color:<\/span>\s*[^>]+>(?<exterior_color>[^<]+)/',
                   
                    'transmission'  => '/Transmission:<\/span>\s*[^>]+>(?<transmission>[^<]+)/',
                    'kilometres'    => '/Miles:<\/div><[^>]+>(?<kilometres>[^<]+)/'
                ),
                'data_capture_regx_full' => array(
                    
                ),
                'next_query_regx'   => '/[0-9]+-<a\s*href="javascript:go_url\(\'(?<param>[^\']+)\',\s*\'(?<value>[^\']+)\'\)/',
                'images_regx'       => '/<a\s*href="javascript:Thumbnail_Click\(\'(?<img_url>[^\']+)\'/'
            )
    );

    add_filter('filter_summitauto_post_data', 'filter_summitauto_post_data', 10, 2);

    function filter_summitauto_post_data($post_data, $stock_type)
    {
        if($stock_type == 'used') {
            return "param_new-used=used&reset=InventoryListing&$post_data";
        }
    }
