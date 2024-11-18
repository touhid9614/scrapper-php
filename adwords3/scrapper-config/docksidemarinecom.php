<?php
global $scrapper_configs;
$scrapper_configs["docksidemarinecom"] = array( 
 'entry_points' => array(
         'used' => 'https://v2mzlxx99f-1.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=f7b5e3f281e3dbaf7bb03d10029e9291&x-algolia-application-id=V2MZLXX99F',
         'new' => 'https://v2mzlxx99f-2.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=f7b5e3f281e3dbaf7bb03d10029e9291&x-algolia-application-id=V2MZLXX99F',
     ),

     'vdp_url_regex'       => '/\/inventory\/(?:new|used)-[0-9]{4}/',
     'srp_page_regex'      => '/\/(?:new|used|certified)-vehicles\//i',
     'use-proxy'           => true,
     'refine'              => false,
     'init_method'         => 'POST',
     'next_method'         => 'POST',
     'picture_selectors'   => ['.carousel-indicators li'],
     'picture_nexts'       => [],
     'picture_prevs'       => [],
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
                 'price'          => $obj->our_price,
                 'engine'         => $obj->engine_description,
                 'transmission'   => $obj->transmission_description,
                 'kilometres'     => $obj->miles,
                 'vin'            => $obj->vin,
                 'fuel_type'      => $obj->fueltype,
                 'drivetrain'     => $obj->drivetrain,
                 'msrp'           => $obj->msrp,
                 'url'            => $obj->link,
                 'exterior_color' => $obj->ext_color,
                 'interior_color' => $obj->int_color
             );
             $response_data = HttpGet($car_data['url']);
             $regex = '/<meta property="og:description" content="(?<description>[^"]+)/';
             $matches = [];
             if (preg_match($regex, $response_data, $matches)) {

                 $car_data['description'] = $matches['description'];
             }


            $temp_data = HttpGet($car_data['url']);
            $images_regex = '/<div class="swiper-slide">\s*<img data-src="(?<img_url>[^"]+)/';
            $matches = [];
           if(preg_match_all($images_regex, $temp_data, $matches))
                {
                    $car_data['images']     = $matches['img_url'];
                   
                    $car_data['all_images'] = implode('|', $car_data['images']);

                }



             $to_return[] = $car_data;
         }
         return $to_return;
     },
   
 );

add_filter('filter_docksidemarinecom_post_data', 'filter_docksidemarinecom_post_data', 10, 2);

function filter_docksidemarinecom_post_data($post_data, $stock_type)
{
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"docksidemarinecentreltdandtowstowdrymarina_production_inventory_low_to_high","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"docksidemarinecentreltdandtowstowdrymarina_production_inventory_low_to_high","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}'; }
    elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"docksidemarinecentreltdandtowstowdrymarina_production_inventory_low_to_high","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"docksidemarinecentreltdandtowstowdrymarina_production_inventory_low_to_high","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';}

    return $post_data;
}

