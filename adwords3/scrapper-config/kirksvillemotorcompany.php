<?php
global $scrapper_configs;
$scrapper_configs["kirksvillemotorcompany"] = array(
    'entry_points'        => array(
        'new' => 'https://www.kirksvillemotorcompany.com/VehicleSearchResults?search=new'
    ),
    'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.kirksvillemotorcompany.com/sitemap-inventory-sincro.xml";
        $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
        $images_regx          = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = true;
        $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png','https://media.assets.sincrod.com/websites/5.0-8416/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png'];

        $data_capture_regx_full = [
            //'title'          => '/og:title" content="(?<title>[^"]+)/',
            //need a unique value for Transit vehicle
            //https://smedia-hq.slack.com/archives/C018KT2BQEB/p1672442686914739
            'disclaimer'        => '/showVehicleStatusDisclaimer"[^"]+"[^"]+"[^"]+"[^"]+"[^"]+"vehicle-status-disclaimer"><span>(?<disclaimer>[^<]+)/',
            'stock_type'     => '/VehicleDetails\/(?<stock_type>[^\-]+)/i',
            'stock_number'   => '/Stock Number[^>]+>[^>]+>(?<stock_number>[^<]+)<\/span/',
            'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)<\/span/',
            'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'vin'           => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
            'year'           => '/year":"(?<year>[^"]+)/',
            'make'           => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'model'          => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'price'          => '/"price":"(?<price>[0-9,]+)/',
            'msrp'          => '/itemprop="name">MSRP[^>]+>[^>]+>(?<msrp>[^<]+)/',
            'kilometres'        =>'/Mileage[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'transmission'   => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);

add_filter('filter_kirksvillemotorcompany_car_data', 'filter_kirksvillemotorcompany_car_data');

function filter_kirksvillemotorcompany_car_data($car_data)
{

    // if ($car_data['msrp'] == NULL) {
    //     $car_data['custom'] = 0;
    // }
    // else{
    //     $car_data['custom'] = 1;
    // }
    if (strcmp($car_data['disclaimer'],"In Transit") == 0) {
        slecho("Filter is working");
        $car_data['custom'] = 1;
    }
    else{
        $car_data['custom'] = 0;
    }

    return $car_data;
}

