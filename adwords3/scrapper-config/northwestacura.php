<?php
global $scrapper_configs;
$scrapper_configs["northwestacura"] = array(
    "entry_points" => array(
        'new'   => 'https://www.northwestacura.com/inventory/new-inventory?stock_type=New&page_length=1000',
        'used'  => 'https://www.northwestacura.com/inventory/used-inventory?stock_type=Used&page_length=1000'
    ),
    'use-proxy' => true,
    'vdp_url_regex'     => '/\/inventory\/(?:new|used|certified)\/[0-9]{4}-/i',
    'picture_selectors' => ['div.image-carousel.carousel div ul li'],
    'picture_nexts'     => ['div.image-slider.carousel > ul > li.carousel-nav-next > a'],
    'picture_prevs'     => ['div.image-slider.carousel > ul > li.carousel-nav-prev > a'],
    'custom_data_capture' => function($url, $resp){
        slecho("Statring Scrap...");
        $start_tag  = 'window.strathcomSearchData =';
        $end_tag    = ',"took"';

        if(stripos($resp, $start_tag)) {
            $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
        }

        if(stripos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }
        $resp      .='}}';
        $object     = json_decode($resp);
        $inventory  = $object->data->vehicles;

        $to_return = array();

        foreach($inventory as $obj)
        {
            $car_data = array(
                'stock_number'      => $obj->stock_number?$obj->stock_number:$obj->dealer->id,
                'year'              => $obj->year,
                'make'              => $obj->make,
                'model'             => $obj->model,
                'trim'              => $obj->trim->description,
                'body_style'        => $obj->body_type,
                'price'             => $obj->pricingData->current,
                'engine'            => $obj->engine->litres.'L'.' '.$obj->engine->config_name,
                'transmission'      => $obj->transmission,
                'kilometres'        => $obj->odometer_value.' '.$obj->odometer_unit,
                'url'               => "https://www.northwestacura.com/inventory/" . strtolower($obj->stock_type) .
                    '/' .strtolower($obj->year).'-'. strtolower($obj->make) . '-' . strtolower($obj->model) .
                    '-' . strtolower($obj->dealer->city) . '-' . strtolower($obj->dealer->province->name) .
                    '/' .strtolower($obj->id),
                'exterior_color'    => $obj->color->exterior->name,
                'interior_color'    => $obj->color->interior->name,
                'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                'images'            => array_merge($obj->photos->user, $obj->photos->stock)
                //'interior_color'    => $obj->interior_color
            );

            $to_return[] = $car_data;
        }
        slecho("End Scrap");
        return $to_return;
    },
    'images_regx' => '/<img\s*itemprop="image"\s*src="(?<img_url>[^"]+)"\s* width="526" height="394"/'
);