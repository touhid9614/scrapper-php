<?php

global $scrapper_configs;

$scrapper_configs['mainlinechrysler'] = array(
    'entry_points' => array(
        'used' => 'https://sewjn80htn-1.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=179608f32563367799314290254e3e44&x-algolia-application-id=SEWJN80HTN',
        'new' => 'https://sewjn80htn-1.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=179608f32563367799314290254e3e44&x-algolia-application-id=SEWJN80HTN',
        
    ),
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/',
    'use-proxy' => true,
    'srp_page_regex'      => '/\/(?:new|used|certified)-vehicles\//i',
    'refine' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',
    'picture_selectors' => ['.swiper-slide'],
    'picture_nexts' => ['.swiper-button-next'],
    'picture_prevs' => ['.swiper-button-prev'],
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
                'year' => $obj->year,
                'make' => $obj->make,
                'model' => $obj->model,
                'trim' => $obj->trim,
                'body_style' => $obj->body,
                'stock_type' => strtolower($obj->type),
                'price' => (!empty($obj->our_price) ? $obj->our_price : 'Call for Price'),
                'engine' => $obj->engine_description,
                'transmission' => $obj->transmission_description,
                'kilometres' => $obj->miles,
                'vin' => $obj->vin,
                'fuel_type' => $obj->fueltype,
                'drivetrain' => $obj->drivetrain,
                // 'msrp' => $obj->msrp,
                'url' => $obj->link,
                'exterior_color' => $obj->ext_color,
                'interior_color' => $obj->int_color,
                //'all_images' => $obj->thumbnail,
                    //'title'             => $obj->title_vrp,
            );

           $response_data = HttpGet($car_data['url']);
            $regex = '/<meta property="og:description" content="(?<description>[^"]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
            }
            

               // $temp_data = HttpGet($car_data['url']);
            $images_regex = '/data-src=\'(?<img_url>[^\']+)\'/';
            $matches = [];
            if(preg_match_all($images_regex, $response_data, $matches))
                {
               
                if (count($matches['img_url']) <= 8) {
                        
                    } else {
               
               
                    $car_data['images']     = $matches['img_url'];
                    
                    $car_data['images']=array_filter($car_data['images'], function ($img_url) {
                        if (endsWith($img_url, "default_image_29074_630f6d54550e9.jpg")) {
                            return false;
                        } else if (endsWith($img_url, "7e019b35f4cc359092b3d00f666b25e7.jpg")) {
                            return false;
                        }
                        else if (endsWith($img_url, "3825cbe331b95a02d6c342d41ffa2cf2.jpg")) {
                            return false;
                        }
                        else if (endsWith($img_url, "default_image_27984_625869ed171f6.jpg")) {
                            return false;
                        }
                        else if (endsWith($img_url, "08248f67dec1fd5a64a352fa0f5e82aa.jpg")) {
                            return false;
                        }
                        else if (endsWith($img_url, "default_image_29075_630f6c504330c.jpg")) {
                            return false;
                        }
                         else if (endsWith($img_url, "abf47d4cf850e1f38a447eae092a32e5.jpg")) {
                            return false;
                        }
                         else if (endsWith($img_url, "175aec2555409975da6a35ef368999ed.jpg")) {
                            return false;
                        }
                        return true;
                    });
                   
                    $car_data['all_images'] = implode('|', $car_data['images']);

                }
                }
                
                if(strpos($car_data['all_images'],"default_image") ){
                    $car_data['all_images']="";
                }
            $to_return[] = $car_data;
        }

        return $to_return;
    },

);
add_filter('filter_mainlinechrysler_post_data', 'filter_mainlinechrysler_post_data', 10, 2);
add_filter('filter_mainlinechrysler_car_data', 'filter_mainlinechrysler_car_data');


function filter_mainlinechrysler_post_data($post_data, $stock_type) {
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"mainlinechrysler_production_inventory_trucks_first","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22doorcrashers_stock%22%2C%22black_friday%22%2C%22bodytype%22%2C%22spring_meltdown%22%2C%22location%22%2C%22pre_ordered%22%2C%22vin%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"mainlinechrysler_production_inventory_trucks_first","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"mainlinechrysler_production_inventory_vehicle_api_id_make_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22doorcrashers_stock%22%2C%22black_friday%22%2C%22bodytype%22%2C%22spring_meltdown%22%2C%22location%22%2C%22pre_ordered%22%2C%22vin%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"mainlinechrysler_production_inventory_vehicle_api_id_make_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }
    return $post_data;
}
 

function filter_mainlinechrysler_car_data($car_data)
{

    if ($car_data['stock_number'] === 'J18180' || $car_data['stock_number'] === 'R21102A' || $car_data['stock_number'] === 'R2136A' || $car_data['stock_number'] === 'R21141'|| $car_data['stock_number'] === 'R21156'|| $car_data['stock_number'] === 'R21158') 
    {
        slecho("Excluding car that has stock number J18180 ,{$car_data['url']}");
        return null;
    }

    if ($car_data['trim'] == "SOLD AS TRADED"){
        $car_data['trim'] = "Sold As Traded";
    }
    return $car_data;
}

