<?php
global $scrapper_configs;
$scrapper_configs["getawayrv"] = array(
    'entry_points' => array(
        'new' => 'https://www.getawayrv.com/inventory/new-rv-inventory',
        'used'=> 'https://www.getawayrv.com/inventory/used-rv-inventory'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:[Nn]ew|[Uu]sed)-[0-9]{4}-/i',
    'ty_url_regex' => '/#contactus/',
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],

    'details_start_tag' => 'var vehicles =',
    'details_end_tag'   => ';</script>',

    'custom_data_capture' => function ($url, $data) {
        $tdata = substr($data, strlen('var vehicles = '));
        $objects = json_decode($tdata);

        $to_return = array();

        foreach($objects as $obj)
        {
            $car_data = array(
                'stock_number'      => $obj->stock,
                'title'             => $obj->header,
                'year'              => $obj->year,
                'make'              => $obj->make,
                'model'             => $obj->model,
                'trim'              => $obj->trim,
                'body_style'        => $obj->type,
                'price'             => $obj->promotion? $obj->promotion : $obj->price,
                'engine'            => $obj->engine,
                'transmission'      => $obj->transmission,
                'kilometres'        => $obj->mileage,
                'url'               => urlCombine($url, $obj->url),
                'exterior_color'    => $obj->color,
                'interior_color'    => $obj->interior
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/(?:alt="[^"]+" [^"]+"[^"]+" src="|title=\'[^\']+\' src=\')(?<img_url>[^\']+?\.(?:jpeg|jpg))/',
    'images_fallback_regx' => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
    