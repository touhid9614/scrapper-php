<?php
global $scrapper_configs;
$scrapper_configs["bmwdurhamca"] = array( 
	 'entry_points'        => array(
          'new' => 'https://www.bmwdurham.ca/en/new-inventory'
    ),

    'vdp_url_regex'       => '/\/en\/(?:new|used)-inventory\//i',
    "use-proxy"           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.bmwdurham.ca/en/sitemap-xml";
        $vdp_url_regex        = '/\/en\/(?:new|used)-inventory\//i';
        $images_regx          = '/<div class="gallery-delta-slider__slide">\s*<img src="(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/"image" : "(?<img_url>[^"]+)",/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = true;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        $annoy_func = function ($car) {
            $imgs   = [];
            $images = explode('|', $car['all_images']);

            $retval            = preg_replace('/http(s)?:.*(?=http)/', '', $images, -1);
            $car['all_images'] = implode("|", $retval);

            return $car;
        };

        $data_capture_regx_full = [
            'stock_type'   => '/vehicleType:\'(?<stock_type>[^\']+)/',
            'year'         => '/year:\'(?<year>[^\']+)/i',
            'make'         => '/make:\'(?<make>[^\']+)/i',
            'model'        => '/model:\'(?<model>[^\']+)/i',
            'price'        => '/salePrice:\'(?<price>[^\']+)/i',
            'transmission' => '/transmission:\'(?<transmission>[^\']+)/i',
            'engine'       => '/"engine":[^,]+,"[^"]+":"(?<engine>[^"]+)/',
            'stock_number' => '/stockNo:\'(?<stock_number>[^\']+)/i',
            'vin'          => '/data-vehicle="vin" >\s*(?<vin>[^<]+)/i',
            'kilometres'   => '/mileage:\'(?<kilometres>[^\']+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);