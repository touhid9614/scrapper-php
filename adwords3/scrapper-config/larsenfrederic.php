<?php

global $scrapper_configs;

$scrapper_configs['larsenfrederic'] = array(
    'entry_points'        => array(
        'used' => 'https://www.larsenauto.com/searchused.aspx',
    ),

    'vdp_url_regex'       => '/\/(?:new|used)/',
    "use-proxy"           => false,
    'refine'              => false,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.larsenauto.com/sitemap.xml";
        $vdp_url_regex        = '/\/(?:new|used)/';
        $images_regx          = '/hyperlink\'>\s*<img src="(?<img_url>[^, "]+)/i';
        $images_fallback_regx = '/rel="image_src"\s*href="(?<img_url>[^"]+)/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = false;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png'];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        // Modify car data if needed
        $annoy_func = function ($car_data) {
            $car_data['stock_type'] = strtolower($car_data['stock_type']);

            if($car_data['stock_type'] != "new" || $car_data['stock_type'] != "used"){
                if($car_data['stock_type'] == "usedcondition"){
                    $car_data['stock_type'] = "used";
                }
                else if($car_data['stock_type'] == "newcondition"){
                    $car_data["stock_type"] = "new";
                }
            }

            if($car_data['make'] == '' && $car_data['model'] == '') {
                $car_data = []; 
            }

            return $car_data;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/<span class="info__label">Condition[^>]+>\s*[^>]+>\s*(?<stock_type>[^\<]+)/i',
            'stock_number'   => '/sku"\:\s*"(?<stock_number>[^"]+)/i',
            'vin'            => '/vin"\:\s*"(?<vin>[^"]+)/i',
            'year'           => '/og:title" content="(?<year>[^\s*]+)/i',
            'make'           => '/make"\:\s*"(?<make>[^"]+)/i',
            'model'          => '/model"\:\s*"(?<model>[^"]+)/i',
            'trim'           => '/trim"\:\s*"(?<trim>[^"]+)/i',
            'price'          => '/"price": "(?<price>[^"]+)/i',
            //'msrp'           => '/<span class="price-value[^>]+>(?<msrp>[^<]+)/i',
            'kilometres'     => '/odometer:\s*\'(?<kilometres>[^\']+)/i',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        return $cars;
    }
);
add_filter("filter_larsenfrederic_field_images", "filter_larsenfrederic_field_images");
    
function filter_larsenfrederic_field_images($im_urls)
{
    if(count($im_urls)<2)
    {
        return [];
    }
    
    return $im_urls;
}