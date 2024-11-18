<?php
global $scrapper_configs;
$scrapper_configs["keeseemotorcompanycom"] = array( 
	"entry_points" => array(
     'new' => 'https://search-a5-jazel-tango.jazel-qa.com/api/passthroughsrp?q=(account_id%3A796%20AND%20(vehicle_filter_ids%3A2))&q.parser=lucene&size=1000&sort=has_price%20desc%2Chas_image%20desc%2Cdisplay_price%20asc&start=0',
      'used' => 'https://search-a5-jazel-tango.jazel-qa.com/api/passthroughsrp?q=(account_id%3A796%20AND%20(vehicle_filter_ids%3A3))&q.parser=lucene&size=1000&sort=has_price%20desc%2Chas_image%20desc%2Cdisplay_price%20asc&start=0',
    ),
   'vdp_url_regex' => '/\/inventory\/(?:new|used|certified)-/',
    'use-proxy' => false,
    'content_type' => 'application/json',
    'picture_selectors' => ['.carousel-indicators li'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'custom_data_capture' => function($url, $data) {

        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return array();
        }

        $to_return = array();

        foreach ($objects->hits->hit as $obj) {
            $obj = $obj->fields;

            $sata = json_decode($obj->image);
            $car_data = array(
                'stock_type' => $obj->condition,
                'stock_number' => $obj->stock_number ? $obj->stock_number : $obj->id,
                'year' => $obj->year,
                'make' => $obj->make,
                'model' => $obj->model,
                'trim' => $obj->trim,
                'body_style' => $obj->style_name,
                'price' => $obj->display_price,
                'engine' => $obj->engine_cylinders,
                'transmission' => $obj->transmission,
                'kilometres' => $obj->mileage,
                'url' => $obj->condition == "New" ? "https://www.keeseemotorcompany.com/inventory/" . 'new-vehicles/vehicle/'
                . ($obj->vin) : "https://www.keeseemotorcompany.com/inventory/" . "used-vehicles/vehicle/" . ($obj->vin),
                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color_sidebar,
                'images' => array($sata->Source)
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/class="image-gallery-image"><img src="(?<img_url>[^"]+)"/',
    
);