<?php
global $scrapper_configs;
$scrapper_configs["weeksinbentoncom"] = array( 
	"entry_points"        => array(
        'new' => 'https://www.weeksinbenton.com/inventory/new/',
    ),

    'vdp_url_regex'       => '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-[^-]+-/i',
    "use-proxy"           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.weeksinbenton.com/sitemap_index.xml";
        $vdp_url_regex        = '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-[^-]+-/i';
        $images_regx          = '/data-lightbox="(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = true;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        // Modify car data if needed
        $annoy_func = function ($car_data) {
            $api_base = "https://www.weeksinbenton.com/api/ajax_requests/?currentQuery=";
            $api_url  = $api_base . $car_data['url'];

            $response_data = HttpGet($api_url, true, true);
            $regex         = '/url":"(?<img_url>[^"]+)","width":"1600","height":"900"/';
            $im_urls       = [];
            $matches       = [];

            if (preg_match_all($regex, $response_data, $matches)) {
                foreach ($matches['img_url'] as $key => $value) {
                    $retval    = str_replace(['\\'], [''], rawurldecode($value));
                    $im_urls[] = $retval;
                }
            }

            $car_data['all_images'] = implode('|', $im_urls);

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