<?php

global $scrapper_configs;
///https://app.guidecx.com/app/projects/XVWDUAHT4L2ELNMH2AXB54QUQQPUED2N73RVNNOSM72OH62DWGRQ/notes/// 
$scrapper_configs['morrieschippewavalleymazda'] = array(
      'entry_points' => array(
           'used' => 'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
 
         'new' => 'https://v3zovi2qfz-3.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
          ),
     'vdp_url_regex'         => '/\/inventory\/(?:new|used|certified)-[0-9]{4}-/',
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
            //$obj = $obj->_source;
         

            $car_data = array(
                'stock_number' => $obj->stock ? $obj->stock : $obj->vin,
                //'stock_type'        => $obj->type,
                'year' => $obj->year,
                'make' => $obj->make,
                'model' => $obj->model,
                'trim' => $obj->trim,
                'body_style' => $obj->body,
                'price' => $obj->our_price,
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
                //'all_images'        => $obj->thumbnail,
                    //'title'             => $obj->title_vrp,
            );
            $response_data = HttpGet($car_data['url']);
            $images_regex = '/data-src=\'(?<img_url>[^\']+)\'/';
            $matches = [];
           if(preg_match_all($images_regex, $response_data, $matches))
                {
                    if (count($matches['img_url']) <= 60) {
                        
                    } else {
               
               
                    $car_data['images']     = $matches['img_url'];
                   
                    $car_data['all_images'] = implode('|', $car_data['images']);

                }

                }
               
            $to_return[] = $car_data;
        }

        return $to_return;
    },
 //   'images_regx' => '/<div class="vehicle-image-bg swiper-lazy" data-background="(?<img_url>[^"]+)/'
);
add_filter('filter_morrieschippewavalleymazda_post_data', 'filter_morrieschippewavalleymazda_post_data', 10, 2);

function filter_morrieschippewavalleymazda_post_data($post_data, $stock_type) {
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"chippewavalleymazda-legacymigration0122_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22drivetrain%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"chippewavalleymazda-legacymigration0122_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"chippewavalleymazda-legacymigration0122_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22drivetrain%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"chippewavalleymazda-legacymigration0122_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}


     //https://app.asana.com/0/687248649257779/1179981231236928
//     'entry_points' => array(
//         'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/MP226.csv'
//     ),
//     'use-proxy' => true,
//     'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
//     'picture_selectors' => ['.owl-item'],
//     'picture_nexts' => ['.owl-next'],
//     'picture_prevs' => ['.owl-prev'],
//     'refine' => false,
//     'custom_data_capture' => function($url, $resp) {
//         $vehicles = convert_CSV_to_JSON($resp);

//         $result = [];

//         foreach ($vehicles as $vehicle) {
//             $car_data = [
//                 'stock_number' => $vehicle['Stock #'],
//                 'vin' => $vehicle['VIN'],
//                 'year' => $vehicle['Year'],
//                 'make' => $vehicle['Make'],
//                 'model' => $vehicle['Model'],
//                 'trim' => $vehicle['Series'],
//                 'drivetrain' => $vehicle['Drivetrain Desc'],
//                 'fuel_type' => $vehicle['Fuel'],
//                 'transmission' => $vehicle['Transmission'],
//                 'body_style' => $vehicle['Body'],
//                 'images' => explode('|', $vehicle['Photo Url List']),
//                 'all_images' => $vehicle['Photo Url List'],
//                 'price' => $vehicle['Price'] > 0 ? $vehicle['Price'] : $vehicle['MSRP'],
//                 'url' => $vehicle['Vehicle Detail Link'],
//                 'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
//                 'exterior_color' => $vehicle['Colour'],
//                 'interior_color' => $vehicle['Interior Color'],
//                 'engine' => $vehicle['Engine'],
//                 'description' => strip_tags($vehicle['Description']),
//                 'kilometres' => $vehicle['Odometer'],
//             ];


//             $result[] = $car_data;
//         }

//         return $result;
//     }
// );




