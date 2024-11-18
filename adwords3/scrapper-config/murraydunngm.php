<?php
global $scrapper_configs;
$scrapper_configs["murraydunngm"] = array(
    'entry_points'        => array(
        'new' => 'https://www.murraydunngm.com/inventory/new/',
    ),

    'vdp_url_regex'       => '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-/i',
    "use-proxy"           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.murraydunngm.com/inventory_pages-sitemap.xml";
        $vdp_url_regex        = '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-/i';
        $images_regx          = '/data-lightbox="(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = true;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        // Modify car data if needed
        $annoy_func = function ($car_data) {
            $api_base = "https://www.murraydunngm.com/api/ajax_requests/?currentQuery=";
            $api_url  = $api_base . $car_data['url'];

            $response_data = HttpGet($api_url, true, true);
            $regex         = '/url":"(?<img_url>[^"]+)","width":"1600","height":"900"/';
            $im_urls       = [];
            $matches       = [];

            if (preg_match_all($regex, $response_data, $matches)) {
                foreach ($matches['img_url'] as $key => $value) {
                    $retval    = str_replace(['\\'], [''], rawurldecode($value));
                    $im_urls[] = $retval;
                  //  unset($im_urls[0]);
                }
            }
             if (count($im_urls) > 4) {
                $car_data['all_images'] = implode('|', $im_urls);
            } else {
                $car_data['all_images'] = "";
            }

            if ($car_data['exterior_color'] == '/') {
                $car_data['exterior_color'] = '';
            }
            $car_data['model'] = trim(str_replace(['&amp;', '&'], ['', ''], $car_data['model']));

            return $car_data;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/itemCondition":"(?<stock_type>[^"]+)/', // Must scrap
            'year'           => '/vehicle-title--year">\s*(?<year>[^<]+)/i',
            'make'           => '/class="notranslate vehicle-title--make\s*">\s*(?<make>[^<]+)/i',
            'model'          => '/class="notranslate vehicle-title--model\s*">\s*(?<model>[^<]+)/i',
            'trim'           => '/class="notranslate vehicle-title--trim\s*">\s*(?<trim>[^<]+)/i',
            'price'          => '/name="description" content="[^\$]+\$(?<price>[^.]+)/i',
            'msrp'           => '/",msrp:"(?<msrp>[^"]+)",/i',
            'engine'         => '/data-vehicle="engdescription" >\s*(?<engine>[^<]+)/i',
            'transmission'   => '/data-vehicle="transdescription" >\s*(?<transmission>[^<]+)/i',
            'exterior_color' => '/data-vehicle="extcolor" >\s*(?<exterior_color>[^<]+)/i',
            'interior_color' => '/data-vehicle="intcolor" >(?<interior_color>[^<]+)/i',
            'stock_number'   => '/"sku":"(?<stock_number>[^"]+)/i',
            'vin'            => '/data-vehicle="vin" >\s*(?<vin>[^<]+)/i',
            'kilometres'     => '/data-vehicle="miles"\s*[^>]+>(?<kilometres>[^<]+)/',
            'body_style'     => '/data-vehicle="standardbody" >\s*(?<body_style>[^<]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);




// 'entry_points' => array(
//     'new' => 'https://www.murraydunngm.com/inventory/new/',
//     'used' => 'https://www.murraydunngm.com/inventory/used/',
// ),
// 'use-proxy' => true,
// 'refine'    => false,
// 'vdp_url_regex' => '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-/i',
// 'picture_selectors' => ['.owl-item.cloned'],
// 'picture_nexts' => ['#newnext'],
// 'picture_prevs' => ['#newprev'],
// 'details_start_tag' => 'class="srpVehicles__wrap">',
// 'details_end_tag' => 'class="disclaimer__wrap">',
// 'details_spliter' => 'class="carbox-wrap',
// 'data_capture_regx' => array(
//     'url' => '/data-permalink="(?<url>[^"]+)/',
//     'year' => '/class="vehicle-title--year">\s*(?<year>[0-9]{4})/',
//     'make' => '/class="notranslate vehicle-title--make ">\s*(?<make>[^<]+)/',
//     'model' => '/class="notranslate vehicle-title--model ">\s*(?<model>[^<]+)/',
//     'trim' => '/title-trim[^>]+>\s*(?<trim>[^<]+)/',
//     'stock_number' => '/Stock#:<\/span>[^>]+>\s*(?<stock_number>[^<]+)/',
//     'price' => '/class="currency">\$[^>]+>(?<price>[0-9,]+)/',
// ),
// 'data_capture_regx_full' => array(
// ),
// 'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
// 'images_regx' => '/data-lightbox="(?<img_url>[^"]+)"/',
// 'images_fallback_regx' => '/property="og:image" content="(?<img_url>[^"]+)"/'
// );

// add_filter("filter_murraydunngm_field_images", "filter_murraydunngm_field_images",10,2);
// function filter_murraydunngm_field_images($im_urls,$car_data)
// {
// if(isset($car_data['url']) && $car_data['url'])
// {
//    $api_url="https://www.murraydunngm.com/api/ajax_requests/?currentQuery=".$car_data['url'];
//    $response_data = HttpGet($api_url);
//    $regex       =  '/url":"(?<img_url>[^"]+)","is_stock/';
//     $matches = [];
//     $retval = array();
// if (preg_match_all($regex, $response_data, $matches)) {
//         foreach ($matches['img_url'] as $key => $value) {
//             $retval= str_replace(['\\'], [''], rawurldecode($value));
//             $im_urls[] = $retval;
//         }
//     }
// }
// unset($im_urls[0]);
// return  $im_urls;
// }

