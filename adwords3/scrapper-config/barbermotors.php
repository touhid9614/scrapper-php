<?php

global $scrapper_configs;


// [
//     'entry_points'  => 
//     [
//         'new'       => "https://crawler-api.smedia.ca/api/vehicles/www.barbermotors.com/",
//         //Trailing slash is recommended
//     ],

//     'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/',
//     'use-proxy'           => true,
//     'content_type'        => 'application/json',

//     'picture_selectors'   => ['.deck-gallery[smartgallery] > .deck > section'],
//     'picture_nexts'       => ['.arrow.single.next'],
//     'picture_prevs'       => ['.arrow.single.prev'],

//     'custom_data_capture' => function ($url, $data)
//     {
//         return nlp_crawler($url, $data, true);
//     }
// ];


//the site is changed that's why scraped this way..if its necessary to scrap this in crawler please use above code//

$scrapper_configs['barbermotors'] = array(
    'entry_points' => array(
        'used' => 'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
        'new' => 'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
    ),
    'vdp_url_regex' => '/\/inventory\/(?:used|new|certified-used|certified)-[0-9]{4}-/',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['owl-prev'],
    'content_type' => 'application/json',
    'custom_data_capture' => function($url, $data) {

        $objects = json_decode($data);


        if (!$objects) {
            slecho($data);
            return array();
        }


        $to_return = array();



        foreach ($objects->results[0]->hits as $obj) {
            //$obj = $obj->_source;

            $car_data = array(
                'stock_number' => $obj->stock ? $obj->stock : $obj->vin,
                'stock_type'        => $obj->type == 'Certified Used'?'used':strtolower($obj->type),
                'year' => $obj->year,
                'make' => $obj->make,
                'model' => $obj->model,
                'trim' => $obj->trim,
                'body_style' => $obj->body,
                'price' =>  $obj->our_price=='<span class="callforprice">Please call for price</span>'?'Please Call': $obj->our_price,
                'engine' => $obj->engine_description,
                'transmission' => $obj->transmission_description,
                'kilometres' => $obj->miles,
                'vin' => $obj->vin,
                'fuel_type' => $obj->fueltype,
                'drivetrain' => $obj->drivetrain,
                'msrp' => $obj->msrp,
                'url' => $obj->link,
                'exterior_color' => $obj->ext_color,
                'interior_color' => $obj->int_color,
           //   'all_images' => $obj->thumbnail,
                   
            );

            $response_data = HttpGet($car_data['url']);
            $images_regex = '/<img class=\'swiper-lazy\' data-src=\'(?<img_url>[^\']+)/';
            $matches = [];
           if(preg_match_all($images_regex, $response_data, $matches))
                {
                    $car_data['images']     = $matches['img_url'];
                   
                    $car_data['all_images'] = implode('|', $car_data['images']);

                }
               
            $to_return[] = $car_data;
        }

        return $to_return;
    },
  //  'images_regx' => '/<div class="vehicle-image-bg swiper-lazy" data-background="(?<img_url>[^"]+)/'
);

add_filter('filter_barbermotors_post_data', 'filter_barbermotors_post_data', 10, 2);

function filter_barbermotors_post_data($post_data, $stock_type) {
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"barbermotors_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22special_field_1%22%2C%22specials%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"barbermotors_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    } 
    elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"barbermotors_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=200&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22special_field_1%22%2C%22specials%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"barbermotors_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}