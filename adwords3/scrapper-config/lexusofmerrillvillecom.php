<?php
global $scrapper_configs;
$scrapper_configs["lexusofmerrillvillecom"] = array( 
	"entry_points" => array(
        'used' => 'https://www.lexusofmerrillville.com/search/pre-owned-merrillville-in/?cy=46410&tp=pre_owned&v=2',
        'new' => 'https://www.lexusofmerrillville.com/search/new-lexus-merrillville-in/?cy=46410&mk=33&tp=new',
    ),
    'vdp_url_regex' => '/\/auto\/(?:new|preowned)/i',
    'use-proxy'              => false,
    'refine'                 => false,
    'details_start_tag'      => 'id="header"',
    'details_end_tag'        => 'footer-bottom-col',
    'details_spliter'        => '<div class="vehicle_item"',
    'data_capture_regx'      => array(
        'url'            => '/<a href="(?<url>[^"]+)\s*"\s*alt="/',
		'year'			 => '/alt="(?:New|Pre-Owned|)\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)"\s*title/',
		'make'			 => '/alt="(?:New|Pre-Owned|)\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)"\s*title/',
		'model'			 => '/alt="(?:New|Pre-Owned|)\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)"\s*title/',
    ),
    'data_capture_regx_full' => array(
		'trim'			 => '/"make":"(?<make>[^"]+)/',
        'price'          => '/"vehicle_price":\[(?<price>[^\]]+)/',
        'stock_number'   => '/Stock #(?<stock_number>[^"]+)"\s/',
        'body_style'     => '/"vehicle_body_style":\["(?<body_style>[^"]+)/',
        'vin'            => '/VIN[^>]+>[^>]+>(?<vin>[^<]+)<\/td/',
        'description'    => '/description"\s*content="(?<description>[^"]+)/',
    ),
    'next_page_regx'         => '/thm-light_text_color" href="(?<next>[^"]+)"\s*rel="no[^\.]+\.[^\.]+\.[^\.]+\.png"[^>]+>Nex/',
    'images_regx'            => '/image"\s*content="(?<img_url>[^"]+)/'
);

add_filter('filter_lexusofmerrillvillecom_car_data', 'filter_lexusofmerrillvillecom_car_data');

function filter_lexusofmerrillvillecom_car_data($car_data)
{

    if ($car_data['stock_number'] == "" || strlen($car_data['stock_number']) > 8) {
        $car_data['stock_number'] = $car_data['vin'];
    }

    return $car_data;
}


add_filter('filter_for_fb_lexusofmerrillvillecom', 'filter_for_fb_lexusofmerrillvillecom', 10, 2);
function filter_for_fb_lexusofmerrillvillecom($car_data, $feed_type)
{
   
    if ($car_data['stock_number'] == "") {
        return null;
    }

    return $car_data;
}
