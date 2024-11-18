<?php

global $scrapper_configs;

$scrapper_configs['oregansvolkswagenhalifaxcom'] = array(
    'entry_points' => array(
        'used' => 'https://www.oregansvolkswagenhalifax.com/wp-json/strathcom/vehicles/search?language=en&stock_type=Used&page=1&page_length=1000&sort_by=price&sort_order=ASC',
        'new' => 'https://www.oregansvolkswagenhalifax.com/wp-json/strathcom/vehicles/search?language=en&stock_type=New&make=Volkswagen&page=1&page_length=1000&sort_by=price&sort_order=ASC',
    ),
    'vdp_url_regex' => '/\/inventory\/(?:new|used)\/[0-9]{4}-/i',
  
    'use-proxy' => true,
    'picture_selectors' => ['.carousel .slides>li'],
    'picture_nexts' => ['.carousel-nav-next'],
    'picture_prevs' => ['.carousel-nav-prev'],
    
    
    'custom_data_capture' => function($url, $data) {

       $object = json_decode($data);
        $inventory = $object->data->vehicles;

        $to_return = array();

        foreach ($inventory as $obj) {
            $car_data = array(
                'stock_number' => $obj->stock_number,
                'vin' => $obj->identifiers->vin,
                'year' => $obj->year,
                'make' => $obj->make,
                'model' => $obj->model,
                'body_style' => $obj->body_type,
                'trim' => $obj->trim->description,
                'price' => $obj->pricingData->current,
                'engine' => $obj->engine->litres . 'L' . ' ' . $obj->engine->config_name,
                'transmission' => $obj->transmission,
                'kilometres' => $obj->odometer_value . ' ' . $obj->odometer_unit,
                'url' => "https://www.oregansvolkswagenhalifax.com/en/inventory/" . strtolower($obj->stock_type) .
                '/' . strtolower($obj->year) . '-' . strtolower($obj->make) . '-' . strtolower(explode(" ", $obj->model)[0]) . '-' . strtolower(explode(" ", $obj->model)[1]) .
                '-' . strtolower($obj->dealer->city) . '-' . strtolower(" ", $obj->dealer->province->name) .
                '/' . strtolower($obj->id),
                'exterior_color' => $obj->color->exterior->name,
                'interior_color' => $obj->color->interior->name,
            
                  
            );

            $to_return[] = $car_data;
        }
        slecho("End Scrap");
        return $to_return;
    },
    'images_regx' => '/<a href="(?<img_url>[^"]+)">\s*<img class="img-defer" itemprop="image"/'
);
add_filter("filter_oregansvolkswagenhalifaxcom_field_images", "filter_oregansvolkswagenhalifaxcom_field_images");

function filter_oregansvolkswagenhalifaxcom_field_images($im_urls) {
    $retval = [];

    foreach ($im_urls as $img) {

        $retval[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }

    return array_filter($retval, function($im_url) {
        return !endsWith($im_url, 'coming-soonv2.jpg');
    });
}
