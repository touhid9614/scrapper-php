<?php
global $scrapper_configs;
$scrapper_configs["kiacoldlakecom"] = array(  
	'entry_points' => array(
            'used' => 'https://www.kiacoldlake.com/used/search.html',
        'new'  => 'https://www.kiacoldlake.com/en/sitemap_newinventory.xml',
        
    ),     
    'vdp_url_regex'     => '/\/(?:new|used|demos)\/(?:inventory|[0-9]{4})(?:\/|-)/i',
    'srp_page_regex'    => '/\/(?:new|used|demos)\/search/i',
    'refine'            => false,
    'use-proxy'           => false,
    'details_start_tag' => 'header.mobile-header{',
    'details_end_tag'   => 'class="conditionsFooter -w50p">',
    'details_spliter'   => 'class="carBoxWrapper"',

    'new'   => array(
        'use-proxy'           => false,
        'refine'              => false, 
        "custom_data_capture" => function ($url, $data) {
            $site                 = "https://www.kiacoldlake.com/en/sitemap_newinventory.xml";
            $vdp_url_regex        = '/\/new\/inventory\/[0-9]{4}\-[A-z]+\-[A-z]+\-id/i';
            $images_regx          = '/property="og:image" content="(?<img_url>[^"]+)/i';
            $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)/i';
            $required_params      = [];     // Mandatory url parameters
            $use_proxy            = false;   // Uses proxy to reach site
            $keymap               = null;   // Return the output data mapped against any car key
            $invalid_images       = [];     // List of image urls to be filtered out
            $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

            $annoy_func = function ($car) {
                $car['stock_type'] = trim(strtolower($car['stock_type']));
                
                if($car['custom']=="certified"){
                    $car['stock_type']="cpo";
                }
                return $car;
            };

            $data_capture_regx_full = [
                'body_style'   => '/"body":"(?<body_style>[^"]+)/',
                'model'        => '/oldlake.com\/(?<stock_type>[^\/]+)\/inventory\/(?<year>[^\-]+)\-(?<make>[^\-]+)\-(?<model>[^\-]+)/',
                'stock_type'   => '/oldlake.com\/(?<stock_type>[^\/]+)\/inventory/',
                'year'         => '/oldlake.com\/(?<stock_type>[^\/]+)\/inventory\/(?<year>[^\-]+)\-(?<make>[^\-]+)\-(?<model>[^\-]+)/i',
                'make'         => '/oldlake.com\/(?<stock_type>[^\/]+)\/inventory\/(?<year>[^\-]+)\-(?<make>[^\-]+)\-(?<model>[^\-]+)/i',
                'stock_number' => '/Stock:(?<stock_number>[^\-]+)/i',
                'vin'          => '/VIN:(?<vin>[^\<]+)<\/span/i',
                'price'        => '/Price:(?<price>[^<]+)/',
                'trim'         => '/data-trim="(?<trim>[^"]+)"\s*data\-condition="/',
                'custom'        => '/img3.d2cmedia.ca\/(?<custom>[^\/]+)\/cb65a90759b0fa5/',
                'fuel_type'     => '/Fuel Type<\/div>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<fuel_type>[^<]+)/'
            ];

            $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
            return $cars;
        }
    ),
    'used'  => array(
        'vdp_url_regex'     => '/\/(?:new|used|demos)\/(?:inventory|[0-9]{4})(?:\/|-)/i',
        'refine'            => false,
        'use-proxy'           => false,
        'details_start_tag' => 'header.mobile-header{',
        'details_end_tag'   => 'class="conditionsFooter -w50p">',
        'details_spliter'   => 'class="carBoxWrapper"',
        'data_capture_regx' => array(
            'url'       => '/<a\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*/',
            //'title'   => '/<div class="divSpan divSpan12 carBasics">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
            'year'      => '/<a\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*/',
            'make'      => '/<a\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*/',
            'model'     => '/model="(?<model>[^"]+)"\s*data-year/',
            'kilometres'=> '/class=\'divSpan divSpan12 carDescription elIsLoadable\'><span [^>]+><span [^>]+>(?<kilometres>[0-9 ,]+)\s*KM/',
            'price'     => '/carPrice elIsLoadable[^>]+>[^>]+>(?<price>[^<]+)/',
            
        ),
        'data_capture_regx_full' => array(
            'model'         => '/Model:(?<model>[^<]+)/',
            'kilometres'    => '/class=\'divSpan divSpan12 carDescription elIsLoadable\'><span [^>]+><span [^>]+>(?<kilometres>[0-9 ,]+)\s*KM/',
            'price'         => '/Price:(?<price>[^<]+)/',
            'stock_number'  => '/popupstocknumber\' value=\'(?<stock_number>[^\']+)/',
            'kilometres'    => '/Kilometers:(?<kilometres>[^<]+)',
            'engine'        => '/specsEngine\'>Engine:\s(?<engine>[^<]+)/',
            'transmission'  => '/specsTransmission\'>Transmission:\s(?<transmission>[^<]+)/',
            'exterior_color'=> '/specsTransmission\'>Transmission:\s(?<exterior_color>[^<]+)/',
            'body_style'    => '/specsBodyType\'>Category:\s(?<body_style>[^<]+)/',
            'vin'           => '/VIN:(?<vin>[^<]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)"\s*data\-condition="/',
            'custom'        => '/img3.d2cmedia.ca\/(?<custom>[^\/]+)\/[a-zA-Z0-9]+\/kia.png/',
            'fuel_type'     => '/specsFuel\'>Fuel:\s(?<fuel_type>[^<]+)/'
        ),
        'images_regx' => '/image":\["(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/og:image"\s*content="(?<img_url>[^"]+)/'
    ),               
);

add_filter("filter_kiacoldlakecom_field_images", "filter_kiacoldlakecom_field_images");

function filter_kiacoldlakecom_field_images($im_urls) {
    $retval = [];
    //$img_urls= explode('|', $im_urls);

    foreach ($im_urls as $im_url) {
        $retval[] = str_replace(['\\'], [''], rawurldecode($im_url));
    }

    $retval = preg_replace('/http(s)?:.*(?=http)/', '', $retval, -1);
    //$car_data['all_images']= implode('|', $retval);
            
    return $retval;
}

add_filter('filter_kiacoldlakecom_car_data', 'filter_kiacoldlakecom_car_data');

function filter_kiacoldlakecom_car_data($car_data)
{    
    if($car_data['custom']=="certified"){
        $car_data['stock_type']="cpo";
    }
    $trim_filter = explode(' ', trim($car_data['trim'] ))[0];
    $car_data['trim'] = $trim_filter;
    return $car_data;
}

