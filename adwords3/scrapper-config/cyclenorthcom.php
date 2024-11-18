<?php
global $scrapper_configs;
$scrapper_configs["cyclenorthcom"] = array( 
	'entry_points'         => array(
        'other' => 'https://www.cyclenorth.com/imglib/Inventory/cache/722/VehInv.js?v=6554654/',
        'new'   => 'https://www.cyclenorth.com/imglib/Inventory/cache/722/VehInv.js?v=8810971',
        'used'  => 'https://www.cyclenorth.com/imglib/Inventory/cache/722/UVehInv.js?v=8418073',
    ),
    // 'vdp_url_regex'        => '/\/default\.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
    'vdp_url_regex'        => '/\/default\.asp\?page=x(?:New|PreOwnedInventory|Inventory)/i',
    'srp_page_regex'       => '/\/default\.asp\?page=x(?:All|New|PreOwned)Inventory\&/i',
    'required_params'      => ['page', 'id'],
    'use-proxy'            => true,
    'refine'               => false,

    'custom_data_capture'  => function ($url, $resp) {
        $start_tag = 'var Vehicles=';
        $end_tag   = '];';

        if (stripos($resp, $start_tag)) {
            $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
        }

        if (stripos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }

        $resp      = $resp . ']';
        $inventory = json_decode($resp);
        $to_return = [];
        $typeMap   = [
            'Motorcycle / Scooter' => 'motorcycle',
            'Trailer'              => 'trailer',
            'Cargo Trailer'        => 'cargo-trailer',
            'Golf Cart'            => 'golf-cart',
            'ATV'                  => 'atv',
            'Power Equipment'      => 'power-equipment',
            'Lawn Mower'           => 'lawn-mower',
            'Blower'               => 'blower',
            'Rotary Cutters'       => 'rotary-cutters',
            'Cutter'               => 'cutter',
            'Chainsaw'             => 'chainsaw',
            'Trimmer'              => 'trimmer',
            'Snow Removal'         => 'snow-removal',
            'Snow Blower'          => 'snow-blower',
            'Aerator'              => 'aerator',
            'Boat'                 => 'boat',
            'Outboard'             => 'outboard',
            'Utility Vehicle'      => 'utility',
        ];

        foreach ($inventory as $obj) {
            $base_url = ($obj->type == 'U') ? "https://www.cyclenorth.com/default.asp?page=xPreOwnedInventoryDetail" : "https://www.cyclenorth.com/default.asp?page=xNewInventoryDetail";

            $type = isset($typeMap[$obj->vehtypename]) ? $typeMap[$obj->vehtypename] : 'other';

            $car_data = [
                'transmission'   => $obj->transmission,
                'stock_number'   => !empty($obj->stockno) ? $obj->stockno : $obj->id,
                'year'           => $obj->bike_year,
                'make'           => $obj->manuf,
                'model'          => $obj->model,
                // 'body_style'     => $type,
                'body_style'     => $obj->vehtypename,
                'custom'         => $obj->vehtypename,
                'stock_type'     => $obj->type == 'U' ? 'used' : 'new',
                'price'          => !empty($obj->price) ? $obj->price : (!empty($obj->retail_price) ? $obj->retail_price : 'Call For Price'),
                'kilometres'     => isset($obj->miles) ? $obj->miles : '',
                'url'            => $base_url . '&id=' . $obj->id,
                'exterior_color' => $obj->color,
                'engine'         => $obj->engine,
                'city'           => str_replace(' ', '_', strtolower($obj->location)),
                'all_images'     => "https://cdn.dealerspike.com/imglib/v1/1024x1024" . $obj->stock_image,
            ];

            //https://app.guidecx.com/app/projects/7e8654bf-9772-4f3c-8a81-16dd2f0fbfb1/notes
            // They have url variations in website and two different url will lead to same vehicle
            //handeling based on entry point.
            // if($car_data['stock_type'] == 'other' || $car_data['stock_type'] == "new" || $car_data['stock_type'] == "used"){
            //     $url = "https://www.cyclenorth.com/default.asp?page=xInventoryDetail";
            //     $car_data['url'] = $url . '&id=' . $obj->id;
            //     $car_data['stock_type'] = $obj->type == 'U' ? 'used' : 'new';
            // }
            // else{
            //     $base_url = ($obj->type == 'U') ? "https://www.cyclenorth.com/default.asp?page=xPreOwnedInventoryDetail" : "https://www.cyclenorth.com/default.asp?page=xNewInventoryDetail";
            //     $car_data['url'] = $base_url . '&id=' . $obj->id;
            //     $car_data['stock_type'] = $obj->type == 'U' ? 'used' : 'new';
            // }
            /*
            if (strpos($obj->manuf, "usqvarna")) {
                $car_data['price'] = 'Call For Price';
            }

            $response_data = HttpGet($car_data['url'], true, true);
            $regex         = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches       = [];

            if (preg_match($regex, $response_data, $matches)) {
                $car_data['description'] = $matches['description'];
            }

            $autos = [
                'Dodge',
                'Ford',
                'GMC',
                'Jeep',
                'Nissan',
                'Chevrolet',
            ];
            if (in_array($car_data['make'], $autos)) 
            {   
                $car_data['body_style'] = "autos";
            }

            $powersports = [
                'Apollo',
                'Argo',
                'Beta',
                'Can-Am',
                'CFMoto',
                'GoTrax',
                'Indian Motorcycle',
                'Harley Davidson',
                'SURRON',
                'Tao Motor',
                'Thumpstar',
                'YCF',
            ];
            if (in_array($car_data['make'], $powersports)) 
            {   
                $car_data['body_style'] = "powersports";
            }

            $marine = [
                'Angler Qwest',
                'Marlon',
                'Polar Kraft',
            ];
            if (in_array($car_data['make'], $marine)) 
            {   
                $car_data['body_style'] = "marine";
            }

            $rvs = [
                'Forest River',
                'Prime Time',
                'Coachmen',
                'Gulf Stream',
                'Sunset Park RV',
            ];
            if (in_array($car_data['make'], $rvs)) 
            {   
                $car_data['body_style'] = "rvs";
            }
            */
            //https://app.guidecx.com/app/projects/c66df764-d404-4097-92ea-ed2e77b3c4d7/notes
            //writing this condition because if website set their body style as Other then the result may effect. 
            if(strtolower($car_data['body_style']) == "other"){
                $car_data['body_style'] = "";
                $car_data['custom'] = "";
            }
            $feed_filtering_array = [
                'Boat',
                'Surfing',
                'Outboard',
                'Personal Watercraft',
            ];
            $car_data['custom'] = $car_data['body_style'];
            if(in_array($car_data['body_style'], $feed_filtering_array)){
                $car_data['body_style'] = "OTHER";
                // $car_data['custom'] = "OTHER";
            }

            //https://app.guidecx.com/app/projects/7e8654bf-9772-4f3c-8a81-16dd2f0fbfb1/notes
            // They have url variations in website and two different url will lead to same vehicle
            // $url = "https://www.cyclenorth.com/default.asp?page=xInventoryDetail";
            // $main_url = $car_data['url'];
            // $car_data['url'] = $url . '&id=' . $obj->id;

            // if($obj->vehtypename == "")
            //     $to_return[] = $car_data;
            //     $car_data['url'] = str_replace(['xPreOwnedInventoryDetail', 'xNewInventoryDetail'], 'xInventoryDetail', $car_data['url']);
            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx'          => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
    
add_filter("filter_cyclenorthcom_field_images", "filter_cyclenorthcom_field_images");
function filter_cyclenorthcom_field_images($im_urls)
{
    $retval = [];

    foreach($im_urls as $img)
    {
        $retval[] = str_replace(["&#x2F;","https://www.cyclenorth.com/"], ["/",""], $img);
    }

    return $retval;
}
