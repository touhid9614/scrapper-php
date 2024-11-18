<?php
global $scrapper_configs;

$scrapper_configs["fourseasonssales"] = array( 
	'entry_points' => array(
       'new'  => array(
            'https://www.fourseasonssales.com/imglib/Inventory/cache/2768/NVehInv.js?v=1811582',
            'https://www.fourseasonssales.com/imglib/Inventory/cache/2768/NVehInv.js?v=5468931',
        ),

        'used' => array(
            'https://www.fourseasonssales.com/imglib/Inventory/cache/2768/UVehInv.js?v=1367735',
            'https://www.fourseasonssales.com/imglib/Inventory/cache/2768/UVehInv.js?v=8583280',
        )
    ),

    'vdp_url_regex'     => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
    'required_params'   => array('page', 'id'),
    'use-proxy'         => true,
    'refine'            => false,
    'picture_selectors' => ['.photo'],
    'picture_nexts'     => ['.right.next'],
    'picture_prevs'     => ['.left.prev'],
    'details_start_tag'     => 'var Vehicles=',

    'custom_data_capture' => function($url, $resp)
    {
        $resp       = trim(substr($resp, strlen('var Vehicles=')), ';');
        $inventory  = json_decode($resp);
        $to_return  = array();

        foreach ($inventory as $obj)
        {    
            if ($obj->imageOverlayText === 'Sold')
            { 
                continue; 
            }

            if ($obj->type == 'U')   
            {
               $url = "https://www.fourseasonssales.com/default.asp?page=xPreOwnedInventoryDetail";
            }
            else 
            {
               $url = "https://www.fourseasonssales.com/default.asp?page=xNewInventoryDetail";
            }

            $car_data = array(
               'transmission'      => $obj->transmission,
               'stock_number'      => !empty($obj->stockno) ? $obj->stockno : $obj->id,
               'year'              => $obj->bike_year,
               'make'              => $obj->manuf,
               'model'             => $obj->model,
               'body_style'        => $obj->brand,
               'stock_type'        => $obj->type == 'U' ? 'used' : 'new',
               'price'             => !empty($obj->price) ? $obj->price : (!empty($obj->retail_price) ? $obj->retail_price : 'Call For Price'),
               'kilometres'        => isset($obj->miles) ? $obj->miles : '',
               'url'               => $url . '&id=' . $obj->id,
               'exterior_color'    => $obj->color,
               'engine'            => $obj->engine,
               'biweekly'          => $obj->SpecificationsJSON->PaymentsPrice,
               'vin'               => $obj->vin,
               'city'              => $obj->location,
           );

           $to_return[] = $car_data;
        }

        return $to_return;
    },

    'images_regx'       => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);

    add_filter('filter_fourseasonssales_field_make', 'unicodify');
    add_filter('filter_fourseasonssales_field_model', 'unicodify');
    add_filter("filter_fourseasonssales_car_data", "filter_fourseasonssales_car_data", 10, 1);

    function fourseasonssales_images_proc($image_url)
    {
        $tmp = str_replace('120x90', '800x600', $image_url);
        return str_replace('_th.jpg', '.jpg', $tmp);
    }

  
    function filter_fourseasonssales_car_data($car_data) {

    if ($car_data['stock_number'] === 'V63A') {
        slecho("Excluding car that has stock number V63A ,{$car_data['url']}");
        return null;
    }
        $car_data['city'] = isset($car_data['city']) ? trim($car_data['city']) : 'Virden';
        if (!$car_data['city'] || empty($car_data['city']) || $car_data['city'] == 'AUCTION' || $car_data['city'] == 'FSSR - AUCTION')
        {
            $car_data['city'] = 'Virden';
        }
        return $car_data;
}