<?php

global $scrapper_configs;

$scrapper_configs['sherwoodbuick'] = array(
    'entry_points' => array(
      
       'used'   => 'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.8.5)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
       'new'  =>   'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.8.5)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ'
        ),
        'vdp_url_regex'         => '/inventory\/(?:new|used|certified|certified-used)-[0-9]{4}-/',
         'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.mss-centering-img'],
        'picture_nexts'     => ['.mss-buttons-wrapper button.mss-arrow-next'],
        'picture_prevs'     => ['.mss-buttons-wrapper button.mss-arrow-prev'],
        'content_type'      => 'application/json',
        'custom_data_capture'   => function($url, $data){
                
        $objects = json_decode($data);

                
        if(!$objects) { slecho($data); return array(); }

                
        $to_return = array();

                
        
 foreach($objects->results[0]->hits as $obj)
        {
            
            if ($obj->stock == '9GY2703' || $obj->stock == '20T22616'  || $obj->stock == '21T15784') {
                slecho("Excluding cars that have a stock number {$obj->stock}");
                continue;
            }

            $car_data = array(
                'stock_number'      => $obj->stock?$obj->stock:$obj->vin,
                'stock_type'        => $obj->type=='Certified Used'? 'certified': ($obj->type=='Used' ? 'used' : 'new'),
                'year'              => $obj->year,
                'make'              => $obj->make,
                'model'             => $obj->model,
                'trim'              => $obj->trim,
                'body_style'        => $obj->body,
                'price'             => $obj->our_price,
                'engine'            => $obj->engine_description,
                'transmission'      => $obj->transmission_description,
                'kilometres'        => $obj->miles,
                'vin'               => $obj->vin,
                'fuel_type'         => $obj->fueltype,
                'drivetrain'        => $obj->drivetrain,
                'msrp'              => $obj->msrp,
                'url'               => $obj->link,
                'exterior_color'    => $obj->ext_color,
                'interior_color'    => $obj->int_color,
               // 'all_images'        => $obj->thumbnail,
                'title'             => $obj->title_vrp,
            );  

            $to_return[] = $car_data;
        }

        return $to_return;
    },

    'images_regx'     =>'/class="vehicle-image-bg swiper-lazy" data-background="(?<img_url>[^"]+)/',
              
);
add_filter('filter_sherwoodbuick_post_data', 'filter_sherwoodbuick_post_data', 10, 2);

function filter_sherwoodbuick_post_data($post_data, $stock_type)
{
    if($stock_type == 'new')
    {
    $post_data = '{"requests":[{"indexName":"sherwoodbuickgmc_production_inventory_vehicle_api_id_make_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22lightning.locations.Location%22%2C%22fleet_page%22%2C%22price_to_go%22%2C%22demo_page%22%2C%22truck_page%22%2C%22Fleet%22%2C%22demo%22%2C%22fleet_vehicles%22%2C%22custom%22%2C%22smc_page%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"sherwoodbuickgmc_production_inventory_vehicle_api_id_make_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
            
    }
    elseif($stock_type == 'used')
    {
        $post_data = '{"requests":[{"indexName":"sherwoodbuickgmc_production_inventory_vehicle_api_id_make_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22lightning.locations.Location%22%2C%22fleet_page%22%2C%22price_to_go%22%2C%22demo_page%22%2C%22truck_page%22%2C%22Fleet%22%2C%22demo%22%2C%22fleet_vehicles%22%2C%22custom%22%2C%22smc_page%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"sherwoodbuickgmc_production_inventory_vehicle_api_id_make_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}

//add_filter('filter_sherwoodbuick_car_data', 'filter_sherwoodbuick_car_data');
//
//function filter_sherwoodbuick_car_data($car_data) {
//    if($car_data['stock_number']=='21T19417') 
//        {
//           
//            return null;
//        }
//    return $car_data;
//}