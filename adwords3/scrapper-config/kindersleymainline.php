<?php

global $scrapper_configs;

$scrapper_configs['kindersleymainline'] = array(
    "entry_points" => array(
        'new' => 'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
        'used' => 'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
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

            $car_data = array(
                'stock_number' => $obj->stock ? $obj->stock : $obj->vin,
                'year' => $obj->year,
                'make' => $obj->make,
                'model' => $obj->model,
                'trim' => $obj->trim,
                'body_style' => $obj->body,
                'price'             => $obj->our_price=='<span class="callforprice">Please call for price</span>'?'Please Call': $obj->our_price,
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
                'location'  => $obj->location,
                'all_images'        => $obj->thumbnail,
                'options' => 'Demo',
                'description' => $obj->engine_description,
            );
            $temp_data = HttpGet($car_data['url']);
            $images_regex = '/<div class="swiper-slide">\s*<img data-src="(?<img_url>[^"]+)/';
            $matches = [];
            if(preg_match_all($images_regex, $temp_data, $matches))
            {
                $car_data['images']     = $matches['img_url'];
                
                 $car_data['images']=array_filter($car_data['images'], function ($img_url) {
                        if (endsWith($img_url, "7e019b35f4cc359092b3d00f666b25e7.jpg")) {
                            return false;
                        } else if (endsWith($img_url, "3825cbe331b95a02d6c342d41ffa2cf2.jpg")) {
                            return false;
                        }
                        else if (endsWith($img_url, "08248f67dec1fd5a64a352fa0f5e82aa.jpg")) {
                            return false;
                        }
                        else if (endsWith($img_url, "default_image_29075_630f6c504330c.jpg")) {
                            return false;
                        }
                        else if (endsWith($img_url, "default_image_28142_6179a7805044e.jpg")) {
                            return false;
                        }
                        else if (endsWith($img_url, "51808ae1664117c3b931d0e15b5d6df5.jpg")) {
                            return false;
                        }
                         else if (endsWith($img_url, "aca6d5a9636036e0d4dabf42fbf3f006.jpg")) {
                            return false;
                        }
                          else if (endsWith($img_url, "ba70be5c9f19c9ad225ef884acb7625a.jpg")) {
                            return false;
                        }
                          else if (endsWith($img_url, "02f3964e931cb13066a79fa72098b6c5.jpg")) {
                            return false;
                        }
                         else if (endsWith($img_url, "a9dce7f4a716596f739379c9e387bdd3.jpg")) {
                            return false;
                        }
                         else if (endsWith($img_url, "7b02cab19a0484ed6cf39b13684fa5d4.jpg")) {
                            return false;
                        }
                         
                        return true;
                    });
                    unset($car_data['images'][0]);
                $car_data['all_images'] = implode('|', $car_data['images']);

            }
            if(strpos($car_data['all_images'],"default_image") || strpos($car_data['all_images'],"stock-images")){
                    $car_data['all_images']="";
                }
            $to_return[] = $car_data;
        }
        return $to_return;
    },
    // 'images_regx' => '/<div class="swiper-slide">\s*<img data-src="(?<img_url>[^"]+)/'
);
add_filter('filter_kindersleymainline_post_data', 'filter_kindersleymainline_post_data', 10, 2);

function filter_kindersleymainline_post_data($post_data, $stock_type) {
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"kindersleymainlinemotorproducts_production_inventory_vehicle_api_id_make_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22stock%22%2C%22deal_specials%22%2C%22location%22%2C%22vin%22%2C%22pre_ordered%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"kindersleymainlinemotorproducts_production_inventory_vehicle_api_id_make_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"kindersleymainlinemotorproducts_production_inventory_vehicle_api_id_make_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22stock%22%2C%22deal_specials%22%2C%22location%22%2C%22vin%22%2C%22pre_ordered%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"kindersleymainlinemotorproducts_production_inventory_vehicle_api_id_make_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}

