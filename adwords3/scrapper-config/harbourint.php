<?php
global $scrapper_configs;
 $scrapper_configs["harbourint"] = array( 
	  'entry_points' => array(
        'new' => 'https://www.harbourint.ca/imglib/Inventory/cache/5959/NVehInv.js?v=1891096',
        'used' => 'https://www.harbourint.ca/imglib/Inventory/cache/5959/UVehInv.js?v=4594694',
    ),
    'vdp_url_regex' => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
    'required_params' => array('page', 'id'),
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.photo'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'custom_data_capture' => function($url, $resp) {
        $start_tag = 'var Vehicles=';
        $end_tag = '];';

        if (stripos($resp, $start_tag)) {
            $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
        }

        if (stripos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }
        $resp = $resp . ']';
        $inventory = json_decode($resp);

        $to_return = array();

        foreach ($inventory as $obj) {
            if ($obj->type == 'U') {
                $url = "https://www.harbourint.ca/default.asp?page=xPreOwnedInventoryDetail";
            } else {
                $url = "https://www.harbourint.ca/default.asp?page=xNewInventoryDetail";
            }
            $car_data = array(
                'transmission' => $obj->transmission,
                'stock_number' => !empty($obj->stockno) ? $obj->stockno : $obj->id,
                'year' => $obj->bike_year,
                'make' => $obj->manuf,
                'model' => $obj->model,
                'body_style' => $obj->vehtypename,
                'stock_type' => $obj->type == 'U' ? 'used' : 'new',
                'price' => !empty($obj->price) ? $obj->price : (!empty($obj->retail_price) ? $obj->retail_price : 'Call for Price'),
                'kilometres' => isset($obj->miles) ? $obj->miles : '',
                'url' => $url . '&id=' . $obj->id,
                'exterior_color' => $obj->color,
                'engine' => $obj->engine,
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/(?:unitSliderImg">[^\(]+\(|<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src=")(?<img_url>[^(?\)|")]+)/',
    'images_fallback_regx' => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
 add_filter("filter_harbourint_field_images", "filter_harbourint_field_images");

function filter_harbourint_field_images($im_urls) {

    $final_image = [];
    $check_exist = ["https://www.harbourint.ca/your%20ZIP"];

    foreach ($im_urls as $images) {

    
        if (!in_array($images, $check_exist)) {
            array_push($final_image, $images);
        }
    }

    return $final_image;
}