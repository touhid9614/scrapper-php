<?php

global $scrapper_configs;

$scrapper_configs['prioritytoyotaspringfield'] = array(
//     "entry_points" => array(
//         'new' => 'https://7ypjisko92-3.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.5.1)%3B%20Browser%20(lite)%3B%20instantsearch.js%20(4.8.3)%3B%20JS%20Helper%20(3.2.2)&x-algolia-api-key=NzNjMTkxYzMyZmI3MjNiM2FkMzI0MzFkYzM3ODNkYWEyNTU0OTcwYTk4M2MwODkwNWZhMTkwNGQzZTQwMzg0N3ZhbGlkVW50aWw9MTY3ODQ2NTUyOSZhbmFseXRpY3M9dHJ1ZQ%3D%3D&x-algolia-application-id=7YPJISKO92',
//         'used' => 'https://7ypjisko92-2.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.5.1)%3B%20Browser%20(lite)%3B%20instantsearch.js%20(4.8.3)%3B%20JS%20Helper%20(3.2.2)&x-algolia-api-key=MDkxYmU0MmJiMmQyZGNmYzEyOTA4NWNmM2FlMWI0YTEzZmRmYWY2MGU3NjE5Mjk3MzFmYmE4YTQ5NzU3M2E4N3ZhbGlkVW50aWw9MTY3ODQ2NTQ0MiZhbmFseXRpY3M9dHJ1ZQ%3D%3D&x-algolia-application-id=7YPJISKO92',
//     ),
//         'vdp_url_regex'         => '/\/inventory\/(?:new|used|certified)-[0-9]{4}-/',
//         'use-proxy'         => true,
//         'refine'            => false,
//         'init_method'       => 'POST',
//         'next_method'       => 'POST',
//         'picture_selectors' => ['.slick-item'],
//         'picture_nexts'     => ['.vdp-slider-arrow-next'],
//         'picture_prevs'     => ['.vdp-slider-arrow-prev'],
//         'content_type'      => 'application/json',
//         'custom_data_capture'   => function($url, $data){

//         $objects = json_decode($data);

//         if(!$objects) { slecho($data); return array(); }

//         $to_return = array();

//         foreach ($objects->results[0]->hits as $obj) {

//             $car_data = array(
//                 'stock_number' => $obj->stock_number,
//                 'year' => $obj->yr,
//                 'make' => $obj->make,
//                 'model' => $obj->model,
//                 'trim' => $obj->trim,
//                 'body_style' => $obj->body,
//                 'price'             => $obj->msrp=='$0'?'Please Call': $obj->msrp,
//                 'engine' => $obj->engine_description,
//                 'transmission' => $obj->transmission_description,
//                 'kilometres' => $obj->miles,
//                 'vin' => $obj->vin,
//                 'fuel_type' => $obj->fueltype,
//                 'drivetrain' => $obj->drivetrain,
//                 'msrp' => $obj->msrp,
//                 'url' => "https://www.prioritytoyotaspringfield.com".$obj->vdp_url,
//                 'exterior_color' => $obj->ext_color,
//                 'interior_color' => $obj->int_color,
//                 'description'   => $obj->description,
//             );
//             $response_data = HttpGet($car_data['url']);
//             $images_regex = '/slick\-item">\s*<img\s*src="(?<img_url>[^"]+)';
//             $images_matches = [];
//             if(preg_match_all($images_regex, $response_data, $images_matches))
//             {
//                 $car_data['images']     = $images_matches['img_url'];
                
//                 $car_data['all_images'] = implode('|', $car_data['images']);

//             }

//             // $price_regex = '/"internet_price":"(?<price>[^"][0-9,]+)/';
//             // $price_matches = [];
//             // if(preg_match($price_regex, $response_data, $price_matches))
//             // {
//             //     $car_data['price'] = $price_matches['price'];
//             // }
               
//             $to_return[] = $car_data;
//         }

//         return $to_return;
//     },
//     'images_regx'         => '/slick\-item">\s*<img\s*src="(?<img_url>[^"]+)/'
// );
// add_filter('filter_prioritytoyotaspringfield_post_data', 'filter_prioritytoyotaspringfield_post_data', 10, 2);

// function filter_prioritytoyotaspringfield_post_data($post_data, $stock_type) {
//     if ($stock_type == 'new') {
//         $post_data = '{"requests":[{"indexName":"prioritytoyotaspringfield_price_lowhigh","params":"filters=category%3ANew&hitsPerPage=1000&highlightPreTag=__ais-highlight__&highlightPostTag=__%2Fais-highlight__&query=&maxValuesPerFacet=100000&page=0&facets=%5B%22features%22%2C%22make%22%2C%22model%22%2C%22trim%22%2C%22yr%22%2C%22final_price_range%22%2C%22body%22%2C%22cab%22%2C%22bed%22%2C%22fuel%22%2C%22transmission_type%22%2C%22generic_color%22%2C%22drivetrain%22%2C%22dealer.name%22%2C%22mpg_hway%22%2C%22status%22%2C%22flags.type%22%5D&tagFilters=&facetFilters=%5B%5B%22dealer.name%3APriority%20Toyota%20Springfield%22%5D%5D"},{"indexName":"prioritytoyotaspringfield_price_lowhigh","params":"filters=category%3ANew&hitsPerPage=1&highlightPreTag=__ais-highlight__&highlightPostTag=__%2Fais-highlight__&query=&maxValuesPerFacet=100000&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=dealer.name"}]}';
//     } elseif ($stock_type == 'used') {
//         $post_data = '{"requests":[{"indexName":"prioritytoyotaspringfield_price_lowhigh","params":"filters=category%3AUsed&hitsPerPage=1000&highlightPreTag=__ais-highlight__&highlightPostTag=__%2Fais-highlight__&query=&maxValuesPerFacet=100000&page=0&facets=%5B%22vehicleHistory%22%2C%22features%22%2C%22yr%22%2C%22make%22%2C%22model%22%2C%22trim%22%2C%22final_price_range%22%2C%22mileage_range%22%2C%22body%22%2C%22cab%22%2C%22bed%22%2C%22fuel%22%2C%22transmission_type%22%2C%22generic_color%22%2C%22drivetrain%22%2C%22dealer.name%22%2C%22mpg_hway%22%2C%22flags.type%22%5D&tagFilters=&facetFilters=%5B%5B%22dealer.name%3APriority%20Toyota%20Springfield%22%5D%5D"},{"indexName":"prioritytoyotaspringfield_price_lowhigh","params":"filters=category%3AUsed&hitsPerPage=1&highlightPreTag=__ais-highlight__&highlightPostTag=__%2Fais-highlight__&query=&maxValuesPerFacet=100000&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=dealer.name"}]}';
//     }

//     return $post_data;
// }

    //client wants to advertise on their springfield located vehicles
    //https://app.asana.com/0/687248649257779/1184582700972930
    'entry_points' => array(
       'all' => 'https://tm.smedia.ca/adwords3/client-data/prioritytoyota/prioritytoyotaspringfield.csv' 
     ),
    
    'use-proxy' => false,
    'vdp_url_regex' => '/\/(?:new|used)-[0-9]{4}-/i',
    'srp_page_regex'      => '/\/(?:new|used|certified)-vehicles\//i',
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
    'refine' => false,
    'custom_data_capture' => function($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['stock_number'],
                'vin' => $vehicle['vin'],
                'year' => $vehicle['year'],
                'make' => $vehicle['make'],
                'model' => $vehicle['model'],
                'trim' => $vehicle['trim'],
                //'drivetrain' => $vehicle['Drivetrain Desc'],
                //'fuel_type' => $vehicle['Fuel'],
                'transmission' => $vehicle['transmission'],
                'body_style' => $vehicle['body_style'],
                'images'        => explode(',', $vehicle['images']),
                'all_images'    => implode('|http', explode(',http', $vehicle['images'])),
                // 'price' => $vehicle['price'] > 0 ? $vehicle['price'] : $vehicle['msrp'],
                'url' => $vehicle['url'],
                'stock_type' => $vehicle['condition'],
                'exterior_color' => $vehicle['exterior_color'],
                'interior_color' => $vehicle['interior_color'],
                'engine' => $vehicle['engine'],
                //'description' => strip_tags($vehicle['Description']),
                'kilometres' => $vehicle['mileage'],
            ];
            
            if(strpos($car_data['all_images'],"632674bda278") ){
                $car_data['all_images']="";
            }
            
            $response_data = HttpGet($car_data['url'],true,true);
            $regex = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                 $car_data['description'] = $matches['description'];
             }

            $price_regex = '/"internet_price":"(?<price>[^"][0-9,]+)/';
            $price_matches = [];
            if(preg_match($price_regex, $response_data, $price_matches))
            {
                $car_data['price'] = $price_matches['price'];
            }

            $result[] = $car_data;
        }

        return $result;
    }
);

add_filter('filter_prioritytoyotaspringfield_car_data', 'filter_prioritytoyotaspringfield_car_data');

function filter_prioritytoyotaspringfield_car_data($car_data)
{               
            
    if($car_data['price'] == "$0" || $car_data['price'] == "0"){
        $car_data['price'] = "Call for price";
    }
    
    return $car_data;
}

