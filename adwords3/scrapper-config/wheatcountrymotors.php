<?php

global $scrapper_configs;

$scrapper_configs['wheatcountrymotors'] = array(
    'entry_points' => array(
        'used' => 'https://v6eba1srpfohj89dp-1.a1.typesense.net/multi_search?x-typesense-api-key=TE53WFg3S3dNSDQyT05wc0NEc3ZmTWVUZVA2a1pIVW5FM2FxbVRqZlZnaz1oZmUweyJmaWx0ZXJfYnkiOiJzdGF0dXM6W0luc3RvY2ssIFNvbGRdICYmIGJvZHlfdHlwZTpbVHJ1Y2ssIFNVVi1Dcm9zc292ZXIsIFBpY2t1cC1UcnVjaywgU2VkYW4sIENvdXBlLCBDb252ZXJ0aWJsZV0gJiYgdmlzaWJpbGl0eTo%2BMCAmJiBkZWxldGVkX2F0Oj0wIn0%3D',
    ),
         'vdp_url_regex'         => '/\/inventory\/[0-9]{4}-/',
         'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.swiper-slide img'],
        'picture_nexts'     => ['.swiper-slide-next'],
        'picture_prevs'     => ['.swiper-slide-prev'],
        'content_type'      => 'application/json',
        'custom_data_capture'   => function($url, $data){
                
        $objects = json_decode($data);

                
        if(!$objects) { slecho($data); return array(); }

                
        $to_return = array();


        foreach ($objects->results[0]->hits as $obj) {
         

            $car_data = array(
                'stock_number' => $obj->document->stock_no,
                'stock_type' => strtolower($obj->document->vehicle_type),
                'year' => $obj->document->year,
                'make' => $obj->document->make,
                'model' => $obj->document->model,
                'trim' => $obj->document->trim,
                'body_style' => $obj->document->body_type,
                'price' => $obj->document->price,
                'engine' => $obj->document->engine,
                'transmission' => $obj->document->transmission,
                'kilometres' => $obj->document->odometer,
                'vin' => $obj->document->vin,
                'fuel_type' => $obj->document->fuel_type,
                'drivetrain' => $obj->document->drivetrain,
                'url'           => "https://www.wheatcountrymotors.ca/{$obj->document->page_url}",
                'exterior_color' => $obj->document->exterior_color,
                'interior_color' => $obj->document->interior_color,
                  
            );
            $to_return[] = $car_data;
        }
        return $to_return;
    },
    'images_regx' => '/<li class="swiper-slide" data-src="(?<img_url>[^"]+)"/'
);
add_filter('filter_wheatcountrymotors_post_data', 'filter_wheatcountrymotors_post_data', 10, 2);

function filter_wheatcountrymotors_post_data($post_data, $stock_type) {
    if ($stock_type == 'used') {
        $post_data = '{"searches":[{"query_by":"make,model,year_search,trim,vin,stock_no,exterior_color","num_typos":0,"sort_by":"status_rank:asc,created_at:desc","highlight_full_fields":"make,model,year_search,trim,vin,stock_no,exterior_color","collection":"f5cafcfe35ca5bd1d7c0eede59b58f69","q":"*","facet_by":"vehicle_type,year,make,model,exterior_color,body_type,transmission,fuel_type,selling_price,odometer","filter_by":"","max_facet_values":50,"page":1,"per_page":500}]}';
    }

    return $post_data;
}
