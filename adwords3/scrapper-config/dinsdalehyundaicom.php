<?php
global $scrapper_configs;
$scrapper_configs["dinsdalehyundaicom"] = array( 
	'entry_points'        => array(
        'new' => 'https://www.dinsdalehyundai.com/VehicleSearchResults?search=new'
    ),
    'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'srp_page_regex'      => '/\/VehicleSearchResults\?search=(?:new|used|certified|preowned)/',
    'use-proxy'           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.dinsdalehyundai.com/sitemap.xml";
        $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
        $images_regx          = '/photoUrl":"(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = false;
        $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png'];

        
        $annoy_func = function ($car) {


            if (strtolower($car['stock_type']) == 'certified') {
                $car['stock_type'] = 'cpo';
            }
            $car['model'] = strtolower($car['model']);
            
            slecho("all-images: " . $car['all_images']);
            $car['all_images']=str_replace('.jpg', 'x1200.jpg', $car['all_images']);
            slecho("after all-images: " . $car['all_images']);
            
            if (isset($car['vin']) && $car['vin'] && $car['stock_type']=='used') {
                $vin=strtolower($car['vin']);
                $api_url = "https://api.impel.io/spin/tomtinsdalehyundai/{$vin}";
                slecho("api url: " . $api_url);
                $response_data = HttpGet($api_url);
                slecho("response data: " . $response_data);
                if ($response_data) {
                    $obj = json_decode($response_data);
                    slecho("numImgCloseup: " . $obj->info->options->numImgCloseup);

                    for ($i = 0; $i < $obj->info->options->numImgCloseup; $i++) {
                        $img = "{$obj->cdn_image_prefix}closeups/cu-{$i}.jpg";
                        $im_urls[] = str_replace('//', 'https://', $img);
                    }
                }
                $car['all_images']=implode('|', $im_urls);
            }
            
            
            return $car;
        };

        $data_capture_regx_full = [
           // 'title'          => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'stock_type'     => '/"category":"(?<stock_type>[^"]+)/i',
            'year'           => '/"year":"(?<year>[^"]+)/i',
            'make'           => '/"make":"(?<make>[^"]+)/i',
            'model'          => '/"model":"(?<model>[^"]+)/i',
            'trim'           => '/trim":"(?<trim>[^"]+)","year/i',
            'price'          => '/"price":"(?<price>[^"]+)/i',    
            'engine'         => '/Engine<\/span>\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<engine>[^<]+)/i',
            'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
            'kilometres'     => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/i',
            // 'exterior_color' => '/Exterior Colour<\/dt><[^>]+><span>(?<exterior_color>[^<]+)<\/span>/i',
            'stock_number' => '/"stockNumber":"(?<stock_number>[^"]+)/',
            'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
            'vin' => '/"vin":"(?<vin>[^"]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        
        
        return $cars;
    }
);
/*
add_filter('filter_dinsdalehyundaicom_car_data', 'filter_dinsdalehyundaicom_car_data');

function filter_dinsdalehyundaicom_car_data($car_data)
{
    $car_data['make']  = ucwords(strtolower($car_data['make']));
    $car_data['model'] = ucwords(strtolower($car_data['model']));
    if($car_data['make'] == "gmc"||$car_data['make'] == "Gmc"||$car_data['make'] == "ram"||$car_data['make'] == "Ram"){
        $car_data['make'] = strtoupper($car_data['make']);
    }

    return $car_data;
}*/
/*add_filter("filter_dinsdalehyundaicom_field_images", "filter_dinsdalehyundaicom_field_images",10,2);

function filter_dinsdalehyundaicom_field_images($im_urls,$car_data) 
{
    if (isset($car_data['stock_number']) && $car_data['stock_number'])
    {   
        $api_url="https://api.spincar.com/spin/nottautocorp/{$car_data['stock_number']}";
        
        $response_data = HttpGet($api_url);
              
        if ($response_data) 
        {
            $obj = json_decode($response_data);
            slecho("api url:" . $obj->info->options->numImgCloseup);  

            for ($i=0;$i<$obj->info->options->numImgCloseup;$i++)
            {  
                $img="{$obj->cdn_image_prefix}closeups/cu-{$i}.jpg";
                $im_urls[]=str_replace('//', 'https://', $img);
            }
            
        }
    }

    return  $im_urls;
}*/