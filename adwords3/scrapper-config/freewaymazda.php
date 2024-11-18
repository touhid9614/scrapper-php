<?php

global $scrapper_configs;

$scrapper_configs['freewaymazda'] = array(
    'entry_points' => array(
        'new' => 'https://sewjn80htn-3.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=179608f32563367799314290254e3e44&x-algolia-application-id=SEWJN80HTN',
        'used' => 'https://sewjn80htn-3.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=179608f32563367799314290254e3e44&x-algolia-application-id=SEWJN80HTN'
    ),
    'vdp_url_regex' => '/\/inventory\/(?:used|new|certified-used|certified)-[0-9]{4}-/',
    'srp_page_regex' => '/\/(?:new|used|certified)-vehicles\//i',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',
    'picture_selectors' => ['.swiper-slide img'],
    'picture_nexts' => ['.swiper-slide-next'],
    'picture_prevs' => ['.swiper-slide-prev'],
    'content_type' => 'application/json',
    'custom_data_capture' => function ($url, $data) {

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
                'stock_type' => $obj->type == 'Used' ? 'used' : 'new',
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
                    // 'all_images'        => $obj->thumbnail,
                    //  'title'             => $obj->title_vrp,
            );

            if (strlen($car_data['trim']) > 6) {
                $car_data['trim'] = "";
            }

            $response_data = HttpGet($car_data['url']);
            $regex = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
            }


          //  $temp_data = HttpGet($car_data['url']);
            $images_regex = '/<div class="swiper-slide">\s*<img data-src="(?<img_url>[^"]+)"/';
            $matches = [];
            if (preg_match_all($images_regex, $response_data, $matches)) {
                $car_data['images'] = $matches['img_url'];

                $car_data['all_images'] = implode('|', $car_data['images']);
            }
            $ignore_data = [
                '16P8165E',
            ];

            if (in_array($car_data['stock_number'], $ignore_data)) {
                slecho("Excluding car that has  ,{$car_data['stock_number']}");
                continue;
            }


            $to_return[] = $car_data;
        }

        return $to_return;
    },
        // 'images_regx' => '/<div class=\'vehicle-image-bg swiper-lazy\'\s*data-background=\'(?<img_url>[^\']+)/'
);

add_filter('filter_freewaymazda_post_data', 'filter_freewaymazda_post_data', 10, 2);

function filter_freewaymazda_post_data($post_data, $stock_type) {
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"freewaymazda_production_inventory_specials_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22demo_vehicles%22%2C%22custom_year%22%2C%22fuelefficiency%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%2C%22date_modified%22%2C%22hash%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%2C%5B%22make%3AMazda%22%5D%5D"},{"indexName":"freewaymazda_production_inventory_specials_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type&facetFilters=%5B%5B%22make%3AMazda%22%5D%5D"},{"indexName":"freewaymazda_production_inventory_specials_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=make&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"freewaymazda_production_inventory_specials_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22demo_vehicles%22%2C%22custom_year%22%2C%22fuelefficiency%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%2C%22date_modified%22%2C%22hash%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"freewaymazda_production_inventory_specials_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}


add_filter('filter_for_fb_freewaymazda', 'filter_for_fb_freewaymazda', 10, 2);

function filter_for_fb_freewaymazda($car_data, $feed_type)
{
    $images = explode('|', $car_data['all_images']);

    
    
    
    if (!in_array($feed_type, ['google-merchant', 'google-marchant', 'google_merchant', 'google_marchant'])) {
        
        $myimg = array_values($images);
        $car_data['images'] = $myimg;
        $car_data['all_images'] = implode('|', $myimg);

        return $car_data;
    }
    unset($images[0]);
    $myimg = array_values($images);
    $car_data['images'] = $myimg;
    $car_data['all_images'] = implode('|', $myimg);

    return $car_data;
}
