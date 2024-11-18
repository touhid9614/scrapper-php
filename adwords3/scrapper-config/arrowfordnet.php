<?php
global $scrapper_configs;
$scrapper_configs["arrowfordnet"] = array( 
	'entry_points' => array(
            'used' => 'https://www.arrowford.net/used-inventory/index.htm',
            'new'  => 'https://www.arrowford.net/new-inventory/index.htm',
            
         ),
      'vdp_url_regex'       => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.arrowford.net/sitemap.xml";
        $vdp_url_regex        = '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i';
        $images_regx          = '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/i';
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = true;

        $data_capture_regx_full = [
            'title'          => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'stock_type'     => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'year'           => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'make'           => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'model'          => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'trim'           => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'price'          => '/<span class="price-value[^>]+>(?<price>[^<]+)/i',
            'engine'         => '/Engine<\/dt><[^>]+><span>(?<engine>[^<]+)<\/span>/i',
            'transmission'   => '/"transmission":\s*"(?<transmission>[^"]+)/i',
            'kilometres'     => '/odometer:\s*\'(?<kilometres>[^\']+)/i',
            'exterior_color' => '/Exterior Color<\/dt><[^>]+><[^>]+><[^>]+><[^>]+>(?<exterior_color>[^<]+)/i',
            'interior_color' => '/Interior Color<\/dt><[^>]+><[^>]+><[^>]+><[^>]+>(?<interior_color>[^<]+)/i',
            'stock_number'   => '/"stockNumber":\s*"(?<stock_number>[^"]+)/i',
            'vin'            => '/vin:\s*\'(?<vin>[^\']+)/i',
            'body_style'     => '/bodyStyle:\s*\'(?<body_style>[^\']+)/i',
            'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
            //'custom'         => '/"id":[^"]+"uri":"(?<custom>[^"]+)"[^"]+"thumbnail/'
            
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
        $return_cars = [];
          $im_urls=[];
        foreach ($cars as $car) {
            $car['transmission'] = str_replace('\x2D', '', $car['transmission']);

            if (!$car['transmission']) {
                $car['transmission'] = '';
            }

            if (strtolower($car['trim']) == 'for') {
                $car['trim'] = '';
            }
            
            
       //     unset($car['custom']);
            $return_cars[] = $car;
        }

        return $return_cars;
    }
);
