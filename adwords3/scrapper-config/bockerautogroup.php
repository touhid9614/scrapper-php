<?php
    global $scrapper_configs;
    $scrapper_configs['bockerautogroup'] = array(
        'entry_points'        => array(
            'new' => 'https://www.bockerautogroup.com/VehicleSearchResults?search=new'
        ),
        'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
        'use-proxy'           => true,
    
        'picture_selectors'   => ['.scroll-content-item'],
        'picture_nexts'       => ['.bx-next'],
        'picture_prevs'       => ['.bx-prev'],
    
        "custom_data_capture" => function ($url, $data) {
            $site                 = "https://www.bockerautogroup.com/sitemap-inventory-sincro.xml";
            $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
            $images_regx          = '/"photoUrl":"(?<img_url>[^"]+)/i';
            $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
            $required_params      = [];
            $use_proxy            = true;
            $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png','https://media.assets.sincrod.com/websites/5.0-8416/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png','https://media.assets.sincrod.com/websites/5.0-8538/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png','https://media.assets.sincrod.com/websites/5.0-8578/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png','https://media.assets.sincrod.com/websites/5.0-8620/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png','https://media.assets.sincrod.com/websites/5.0-8749/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png'];
    
            $data_capture_regx_full = [
                //'title'          => '/og:title" content="(?<title>[^"]+)/',
                'stock_type'     => '/VehicleDetails\/(?<stock_type>[^\-]+)/i',
                'stock_number'   => '/"stockNumber":"(?<stock_number>[^"]+)/',
                'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)<\/span/',
                'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
                'vin'           => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
                'year'           => '/year":"(?<year>[^"]+)/',
                'make'           => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
                'model'          => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
                'price'          => '/(?:"price"|"msrp"):"(?<price>[^"]+)/',
                'kilometres'        =>'/Miles[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
                'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
                'transmission'   => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
            ];
    
            $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
            $return_cars = [];
                       
            foreach ($cars as $car) {
                
                if(strpos($car['all_images'],"noImage_large") ){
                    $car['all_images']="";
                }
                $return_cars[] = $car;
            }
            return $return_cars;
        }
    );
    
add_filter("filter_bockerautogroup_field_images", "filter_bockerautogroup_field_images");
function filter_bockerautogroup_field_images($im_urls)
{
    if(count($im_urls)<2)
        {
            return [];
        }
    return $im_urls;
}

//useing MSRP where Sale Price is Contact Us
//https://smedia-hq.slack.com/archives/C01QFVB637V/p1660849068364819

add_filter('filter_bockerautogroup_car_data', 'filter_bockerautogroup_car_data');
function filter_bockerautogroup_car_data($car_data) {

    if($car_data['price']==''){
        $car_data['price'] = $car_data['msrp'];
    }

    if($car_data['stock_type']=='certified'){
        $car_data['stock_type']="cpo";
    }

    return $car_data;
}


