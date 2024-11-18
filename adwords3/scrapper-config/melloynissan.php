<?php

global $scrapper_configs;

$scrapper_configs['melloynissan']   =  array(
    'entry_points' => array(
            'used'  => 'https://v3zovi2qfz-2.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
            'new'   => 'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
        ),
        'vdp_url_regex'         => '/\/inventory\/(?:new|used|certified)-[0-9]{4}-/',
        'srp_page_regex'      => '/\/(?:new|used|certified)-vehicles\//',
        'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'content_type'      => 'application/json',
        'custom_data_capture'   => function($url, $data){
                
        $objects = json_decode($data);
                
        if(!$objects) { slecho($data); return array(); }
      
        $to_return = array();
   
        foreach($objects->results[0]->hits as $obj)
        {
            $car_data = array(
                'stock_number'      => $obj->stock?$obj->stock:$obj->vin,
                'stock_type'        => strtolower($obj->type),
                'year'              => $obj->year,
                'make'              => $obj->make,
                // 'model'             => $obj->model,
                'model'             => preg_replace('/[^A-Za-z0-9 -]/', '', $obj->model),
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
                //  'all_images'        => $obj->thumbnail,
                //  'title'             => $obj->title_vrp,
            );  
            

            $temp_data = HttpGet($car_data['url']);
            $images_regex = '/<img data-src="(?<img_url>[^"]+)"/';
            $matches = [];
            if(preg_match_all($images_regex, $temp_data, $matches))
            {
                $car_data['images']     = $matches['img_url'];
            if(count($car_data['images'])<5){
                $car_data['all_images'] = implode('|', $car_data['images']);
            }
                else{
                    unset($car_data['images'][0]);
                    $car_data['all_images'] = implode('|', $car_data['images']);
                }

            }
            $response_data = HttpGet($car_data['url']);
            $regex = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
            }

            //We need to filter out the Car which is more than 180 days old. 
            //https://app.guidecx.com/app/projects/bcfc56f9-9d36-471d-b693-9502a3b3873c/notes
            // $current_day = time();
            // $car_arrival_date = $car_data['arrival_date'];
            // $car_age = ($current_day - $car_arrival_date)/60/60/24;
            // slecho("This car age in website is ", $car_age);

            // if($car_age>180.0){
            //     slecho("This car Age is greater than 180 days and its ffiltering out.");
            //     $car_data = [];
            // }

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    //'images_regx' => '/image_lg":"(?<img_url>[^"]+)/',
);


add_filter('filter_melloynissan_post_data', 'filter_melloynissan_post_data', 10, 2);

function filter_melloynissan_post_data($post_data, $stock_type)
{
    if($stock_type == 'new')
    {
        $post_data = '{"requests":[{"indexName":"melloynissan_production_inventory_low_to_high","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%2C%22monroneyLabel%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"melloynissan_production_inventory_low_to_high","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }
    elseif($stock_type == 'used')
    {
        $post_data = '{"requests":[{"indexName":"melloynissan_production_inventory_low_to_high","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%2C%22monroneyLabel%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"melloynissan_production_inventory_low_to_high","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}
add_filter("filter_melloynissan_field_images", "filter_melloynissan_field_images");
function filter_melloynissan_field_images($im_urls)
{
    return  array_filter($im_urls,function($img_url){
            return !endsWith($img_url,"notfound.jpg");
        }
    );
}

add_filter('filter_for_fb_melloynissan', 'filter_for_fb_melloynissan', 10, 2);

function filter_for_fb_melloynissan($car_data, $feed_type)
{
    echo "arrival date: " . $car_data['arrival_date'];

    return $car_data;
}


// 'entry_points' => array(
//     'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/melloynissan.csv'
// ),
// 'vdp_url_regex'         => '/\/inventory\//',
// 'use-proxy'         => true,
// 'refine' => false,

// 'custom_data_capture' => function($url, $resp) {
//     $vehicles = convert_CSV_to_JSON($resp);

//     $result = [];

//     foreach ($vehicles as $vehicle) {
//         $car_data = [
//             'stock_type' => strtolower($vehicle['Type']),
//             'stock_number' => $vehicle['Stock'],
//             'vin' => $vehicle['VIN'],
//             'year' => $vehicle['Year'],
//             'make' => $vehicle['Make'],
//             'model' => $vehicle['Model'],
//             'body_style' => $vehicle['Body'],
//             'exterior_color' => $vehicle['ExteriorColor'],
//             'interior_color' => $vehicle['InteriorColor'],
//             'price' => $vehicle['SellingPrice'],
//             'url' => $vehicle['WebsiteVDPURL'],
//             'all_images' => implode('|', explode(',', $vehicle['ImageList'])),,

//             'trim' => $vehicle['Trim'],
//             'description' => strip_tags($vehicle['Description']),
//             'kilometres' => $vehicle['Odometer'],
//         ];


//         $result[] = $car_data;
//     }

//     return $result;
// }
// );