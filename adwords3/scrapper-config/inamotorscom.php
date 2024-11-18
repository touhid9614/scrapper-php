<?php
global $scrapper_configs;
$scrapper_configs["inamotorscom"] = array( 
	'entry_points'           => array(
        'used' => 'https://www.inamotors.com/used/',
        'new'  => 'https://www.inamotors.com/new/',
    ),
    'srp_page_regex'         => '/\/(?:new|used)/i',
    'vdp_url_regex'          => '/\/vehicle\//i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next.next-small'],
    'picture_prevs'          => ['.left.left-small'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<div class="ajax-loading"',
    'details_spliter'        => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span style/',
        'year'           => '/itemprop=\'releaseDate\'[^>]+>(?<year>[0-9]{4})/',
        'make'           => '/itemprop=\'manufacturer\'[^>]+>[^>]+>(?<make>[^\s*<]+)/',
        'model'          => '/itemprop=\'model\'[^>]+>[^>]+>(?<model>[^<]+)/',
        'price'          => '/itemprop="price" content="[^>]+>(?<price>[^<]+)/',
        'kilometres'     => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'model'          => '/\&model=(?<model>[^\&]+)/',
        'trim'           => '/\&trim=(?<trim>[^\&]+)/',
        'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
        'price'          => '/span id="final-price">(?<price>[^<]+)/',
        'vin'            => '/vin: \'(?<vin>[^\']+)\',/',
    ),
    'next_page_regx'         => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx'            => '/onerror="imgError\(this\);" (?:data-src|src)="(?<img_url>[^"]+)"/',
);
add_filter('filter_inamotorscom_car_data', 'filter_inamotorscom_car_data');

function filter_inamotorscom_car_data($car_data)
{               
            
                $ignore_data=[
                    'A22128A',
                    'P5217A',
                    'P5189',
                    'A23034A',
                ];
    
            if (in_array($car_data['stock_number'], $ignore_data)) 
            {
                slecho("Excluding car that has  ,{$car_data['stock_number']}");
                 return null;

            }
    
    return $car_data;
}