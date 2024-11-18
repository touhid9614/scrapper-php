<?php
global $scrapper_configs;
$scrapper_configs["dinsdaleautonet"] = array( 
    'entry_points' => array(
            'new' => array(
                'https://www.dinsdaleauto.net/VehicleSearchResults?configCtx=%7B%22webId%22%3A%22gmps-tom-dinsdale%22%2C%22locale%22%3A%22en_US%22%2C%22version%22%3A%22LIVE%22%2C%22page%22%3A%22VehicleSearchResults%22%2C%22secureSiteId%22%3Anull%7D&fragmentId=view%2Fcard%2F5e80a9e1-0305-4c1d-bdbd-df95aaef5892&search=new&forceOrigin=true&limit=100&page=1&offset=0',
                'https://www.dinsdaleauto.net/VehicleSearchResults?configCtx=%7B%22webId%22%3A%22gmps-tom-dinsdale%22%2C%22locale%22%3A%22en_US%22%2C%22version%22%3A%22LIVE%22%2C%22page%22%3A%22VehicleSearchResults%22%2C%22secureSiteId%22%3Anull%7D&fragmentId=view%2Fcard%2F5e80a9e1-0305-4c1d-bdbd-df95aaef5892&search=new&forceOrigin=true&limit=100&page=2&offset=100',
            ),
            'used' => array(
                'https://www.dinsdaleauto.net/VehicleSearchResults?configCtx=%7B%22webId%22%3A%22gmps-tom-dinsdale%22%2C%22locale%22%3A%22en_US%22%2C%22version%22%3A%22LIVE%22%2C%22page%22%3A%22VehicleSearchResults%22%2C%22secureSiteId%22%3Anull%7D&fragmentId=view%2Fcard%2F5e80a9e1-0305-4c1d-bdbd-df95aaef5892&search=used&forceOrigin=true&limit=100&page=1&offset=0',
                'https://www.dinsdaleauto.net/VehicleSearchResults?configCtx=%7B%22webId%22%3A%22gmps-tom-dinsdale%22%2C%22locale%22%3A%22en_US%22%2C%22version%22%3A%22LIVE%22%2C%22page%22%3A%22VehicleSearchResults%22%2C%22secureSiteId%22%3Anull%7D&fragmentId=view%2Fcard%2F5e80a9e1-0305-4c1d-bdbd-df95aaef5892&search=used&forceOrigin=true&limit=100&page=2&offset=100',
                'https://www.dinsdaleauto.net/VehicleSearchResults?configCtx=%7B%22webId%22%3A%22gmps-tom-dinsdale%22%2C%22locale%22%3A%22en_US%22%2C%22version%22%3A%22LIVE%22%2C%22page%22%3A%22VehicleSearchResults%22%2C%22secureSiteId%22%3Anull%7D&fragmentId=view%2Fcard%2F5e80a9e1-0305-4c1d-bdbd-df95aaef5892&search=used&forceOrigin=true&limit=100&offset=200&page=3',
                'https://www.dinsdaleauto.net/VehicleSearchResults?configCtx=%7B%22webId%22%3A%22gmps-tom-dinsdale%22%2C%22locale%22%3A%22en_US%22%2C%22version%22%3A%22LIVE%22%2C%22page%22%3A%22VehicleSearchResults%22%2C%22secureSiteId%22%3Anull%7D&fragmentId=view%2Fcard%2F5e80a9e1-0305-4c1d-bdbd-df95aaef5892&search=used&forceOrigin=true&limit=100&offset=300&page=4',
            ),
            
            
    ),
        'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
        'srp_page_regex'      => '/\/VehicleSearchResults\?search=(?:new|used|certified|preowned)/',
        'use-proxy' => true,
        'refine'=>false,

        'details_start_tag' => 'context="search-filter"',
        'details_end_tag'   => 'id="pageDisclaimer">',
        'details_spliter'   => 'wc-vehicle-card id',
        'data_capture_regx' => array(
           'url'               => '/<a href="(?<url>[^"]+)"\s*data-insight="/',
           'custom_3'             => '/TD Price[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<custom_3>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
            //'title'          => '/og:title" content="(?<title>[^"]+)/',
            'stock_type'     => '/VehicleDetails\/(?<stock_type>[^\-]+)/i',
            'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)<\/span/',
            'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'vin'            => '/"vin":"(?<vin>[^"]+)/',
            'stock_number'   => '/stockNumber":"(?<stock_number>[^"]+)/',
            'custom_2'       => '/stockNumber":"(?<custom_2>[^"]+)/',
            'year'           => '/year":"(?<year>[^"]+)/',
            'make'           => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'model'          => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'price'          => '/"(?:price|msrp)":"(?<price>[0-9,.]+)/',
            'kilometres'     =>'/Miles[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'transmission'   => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
       ),
        // 'next_page_regx'        => '/data-action=\\\"next\\\" href=\\\"(?<next>[^\\\"]+)/',
        'images_regx'        => '/photoUrl":"(?<img_url>[^"]+)/',
   );
add_filter("filter_dinsdaleautonet_field_images", "filter_dinsdaleautonet_field_images",10,2);
function filter_dinsdaleautonet_field_images($im_urls,$car_data) {
   
    foreach ($im_urls as $im_url) {
       if($im_url == "https://inv.assets.sincrod.com/0/2/6/31212104620.jpg" || "https://images.dealer.com/unavailable_stockphoto.png" || "https://media.assets.sincrod.com/websites/5.0-8416/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png" || "https://media.assets.sincrod.com/websites/5.0-8620/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png" || "https://media.assets.ansira.net/websites/5.0-9560/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png")
       {
            $im_url = null;
       }
    
    }

    return $im_urls;
}

add_filter('filter_dinsdaleautonet_car_data', 'filter_dinsdaleautonet_car_data');

function filter_dinsdaleautonet_car_data($car_data)
{    
    slecho("contact us price:  " . $car_data['custom_3']);
    $car_data['custom_3']=numarifyPrice($car_data['custom_3']);
    slecho("contact us price after:  " . $car_data['custom_3']);
    if($car_data['custom_2'] == ""){
        $car_data['stock_number'] = $car_data['vin'];
    }

    if($car_data['custom_3'] > 0){
        $car_data['price'] = $car_data['custom_3'];
        
    } else{
        $car_data['price'] = $car_data['price'];
    }
    
    return $car_data;
}



//  'entry_points'        => array(
//     'new' => 'https://www.dinsdaleauto.net/VehicleSearchResults?search=new'
// ),
// 'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
//  'srp_page_regex'      => '/\/VehicleSearchResults\?search=(?:new|used|certified|preowned)/',
// 'use-proxy'           => false,

// "custom_data_capture" => function ($url, $data) {
//     $site                 = "https://www.dinsdaleauto.net/sitemap-inventory-sincro.xml";
//     $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
//     $images_regx          = '/photoUrl":"(?<img_url>[^"]+)/i';
//     $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
//     $required_params      = [];
//     $use_proxy            = false;
//     $invalid_images       = ['https://inv.assets.sincrod.com/0/2/6/31212104620.jpg','https://images.dealer.com/unavailable_stockphoto.png','https://media.assets.sincrod.com/websites/5.0-8416/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png','https://media.assets.sincrod.com/websites/5.0-8620/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png','https://media.assets.ansira.net/websites/5.0-9560/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png'];

//     $annoy_func = function ($car) {
//         if($car['custom_2'] == ""){
//             $car['stock_number'] = $car['vin'];
//         }
//         if($car['stock_type'] == 'certified'){
//             $car['stock_type'] = 'used';
//         }
//         return $car;
//     };

//     $data_capture_regx_full = [
//         //'title'          => '/og:title" content="(?<title>[^"]+)/',
//         'stock_type'     => '/VehicleDetails\/(?<stock_type>[^\-]+)/i',
//         'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)<\/span/',
//         'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
//         'vin'            => '/"vin":"(?<vin>[^"]+)/',
//         'stock_number'   => '/stockNumber":"(?<stock_number>[^"]+)/',
//         'custom_2'       => '/stockNumber":"(?<custom_2>[^"]+)/',
//         'year'           => '/year":"(?<year>[^"]+)/',
//         'make'           => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
//         'model'          => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
//         'price'          => '/"price":"(?<price>[0-9,]+)/',
//         'kilometres'     =>'/Miles[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
//         'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
//         'transmission'   => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
//     ];

//     $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

//     return $cars;
// }
// );