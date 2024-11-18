<?php

global $scrapper_configs;

$scrapper_configs['hondaofmelbournecom'] = array(
    'entry_points' => array(
        'new' => 'https://www.hondaofmelbourne.com/imglib/Inventory/cache/3165/NVehInv.js?v=3821531',
        'used' => 'https://www.hondaofmelbourne.com/imglib/Inventory/cache/3165/UVehInv.js?v=7559355',
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
        $end_tag = ';';

        if (stripos($resp, $start_tag)) {
            $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
        }

        if (stripos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }

        $inventory = json_decode($resp);
        //slecho($resp);

        $to_return = array();

        foreach ($inventory as $obj) {
            if ($obj->type == 'U') {
                $url = "https://www.hondaofmelbourne.com/default.asp?page=xPreOwnedInventoryDetail";
            } else {
                $url = "https://www.hondaofmelbourne.com/default.asp?page=xNewInventoryDetail";
            }
            $car_data = array(
                'transmission' => $obj->transmission,
                'stock_number' => !empty($obj->stockno) ? $obj->stockno : $obj->id,
                'year' => $obj->bike_year,
                'make' => unicodifyM($obj->manuf),
                'model' => unicodifyM($obj->model),
                /*'make' => $obj->manuf,
                'model' => $obj->model,*/
                'body_style' => $obj->vehtypename,
                'stock_type' => $obj->type == 'U' ? 'used' : 'new',
                'price' => !empty($obj->price) ? $obj->price : (!empty($obj->retail_price) ? $obj->retail_price : 'Call for Price'),
                'kilometres' => isset($obj->miles) ? $obj->miles : '',
                'url' => $url . '&id=' . $obj->id,
                'exterior_color' => $obj->color,
                'engine' => $obj->engine
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/(?:unitSliderImg">[^\(]+\(|<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src=")(?<img_url>[^(?\)|")]+)/',
        // 'images_fallback_regx' => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);


function unicodifyM($txt)
{
    $temp = str_replace('\u00ae', '®', $txt);
    $temp2 = str_replace('\u2122', '™', $temp);
    $temp3 = str_replace('\u00AE', '®', $temp2);
    return $temp3;
}