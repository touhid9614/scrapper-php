<?php
global $scrapper_configs;
$scrapper_configs["temeculasubarucom"] = array(
    'entry_points'        => array(
        'used' => 'https://10aprxotjr-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=003c8cddb5b15f2cfa774c02b7a3b59e&x-algolia-application-id=10APRXOTJR',
        'new'  => 'https://10aprxotjr-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=003c8cddb5b15f2cfa774c02b7a3b59e&x-algolia-application-id=10APRXOTJR',
    ),
    'vdp_url_regex'       => '/inventory\/(?:new|used|certified-used)-[0-9]{4}-/',
    'use-proxy'           => false, // why?
    'refine'              => false,
    'init_method'         => 'POST',
    'next_method'         => 'POST',
    'picture_selectors'   => ['.swiper-slide'],
    'picture_nexts'       => ['.swiper-button-next'],
    'picture_prevs'       => ['.swiper-button-prev'],
    'content_type'        => 'application/json',
    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            return [];
        }

        $to_return = [];

        foreach ($objects->results[0]->hits as $obj) {
            $car_data = array(
                'stock_number'   => $obj->stock ? $obj->stock : $obj->vin,
                'year'           => $obj->year,
                'make'           => $obj->make,
                'model'          => $obj->model,
                'trim'           => $obj->trim,
                'body_style'     => $obj->body,
                'stock_type'     => $obj->type == 'Certified Used' ? 'cpo' : ($obj->type == 'Used' ? 'used' : 'new'),
                'price'          => (!empty($obj->our_price) ? $obj->our_price : 'Call for Price'),
                'engine'         => $obj->engine_description,
                'transmission'   => $obj->transmission_description,
                'kilometres'     => $obj->miles,
                'vin'            => $obj->vin,
                'fuel_type'      => $obj->fueltype,
                'drivetrain'     => $obj->drivetrain,
                'msrp'           => $obj->msrp,
                'url'            => $obj->link,
                'exterior_color' => $obj->ext_color,
                'interior_color' => $obj->int_color,
               // 'all_images'     => $obj->thumbnail,
            );

            $to_return[] = temeculasubarucom_process_data($car_data);
        }

        return $to_return;
    },
);

add_filter('filter_temeculasubarucom_post_data', 'filter_temeculasubarucom_post_data', 10, 2);

function filter_temeculasubarucom_post_data($post_data, $stock_type)
{
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"hellosubaruoftemecula_production_inventory_status_sort","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22custom_status%22%2C%22status_sort%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%2C%22date_modified%22%2C%22hash%22%2C%22monroneyLabel%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%2C%5B%22make%3ASubaru%22%5D%5D"},{"indexName":"hellosubaruoftemecula_production_inventory_status_sort","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type&facetFilters=%5B%5B%22make%3ASubaru%22%5D%5D"},{"indexName":"hellosubaruoftemecula_production_inventory_status_sort","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=make&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"hellosubaruoftemecula_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22custom_status%22%2C%22status_sort%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%2C%22date_modified%22%2C%22hash%22%2C%22monroneyLabel%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"hellosubaruoftemecula_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }
    return $post_data;
}

function temeculasubarucom_process_data($car_data)
{
    $response_data = HttpGet($car_data['url'], true, true);
    $regex         = '/"description":\s*"(?<description>[^"]+)/';
    $matches       = [];

    if (preg_match($regex, $response_data, $matches)) {
        $car_data['description'] = $matches['description'];
    }

    $images_regex = '/<img class=\'swiper-lazy\' data-src=\'(?<img_url>[^\']+)/';
    $matches      = [];

    if (preg_match_all($images_regex, $response_data, $matches)) {
        $car_data['images'] = $matches['img_url'];

        if (count($car_data['images']) >3) {
            $car_data['all_images'] = implode('|', $car_data['images']);
        }
    }


//    if (strtolower($car_data['make']) == 'mazda') {
//        return null;
//    }

    
      if (startsWith($car_data['description'], 'Hello Subaru of Temecula')) {

        $response_data = HttpGet($car_data['url'], true, true);
        $regex = '/<meta name="description" content="(?<description>[^"]+)/';
        $matches = [];

        if (preg_match($regex, $response_data, $matches)) {
            $car_data['description'] = $matches['description'];
        }

        return $car_data;
    } else {
        slecho("This car is not Hello Subaru of Temecula ");
        return null;
    }
    //  return $car_data;
}