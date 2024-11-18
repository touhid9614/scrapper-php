<?php

global $scrapper_configs;
$scrapper_configs["ronhodgson"] = array(
   'entry_points' => array(
        'used' => 'https://sewjn80htn-2.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.31.0%3BJS%20Helper%202.26.1&x-algolia-application-id=SEWJN80HTN&x-algolia-api-key=179608f32563367799314290254e3e44',


        'new' => 'https://sewjn80htn-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.31.0%3BJS%20Helper%202.26.1&x-algolia-application-id=SEWJN80HTN&x-algolia-api-key=179608f32563367799314290254e3e44'
    ),
    'vdp_url_regex' => '/inventory\/(?:new|used|certified-used)-[0-9]{4}-/',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',
    'picture_selectors' => ['.swiper-lazy'],
    'picture_nexts' => ['.swiper-button-next'],
    'picture_prevs' => ['.swiper-button-prev'],
    'content_type' => 'application/json',
    'custom_data_capture' => function ($url, $data) {

        $objects = json_decode($data);


        if (!$objects) {
            //slecho($data);
            return array();
        }


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
              //  'all_images' => $image_urls,
                //'title'             => $obj->title_vrp,
            );
            $to_return[] = $car_data;
        }
        return $to_return;
    },
     'images_regx' => '/<img class="swiper-lazy" data-src="(?<img_url>[^"]+)"/'
);
add_filter('filter_ronhodgson_post_data', 'filter_ronhodgson_post_data', 10, 2);

function filter_ronhodgson_post_data($post_data, $stock_type)
{
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"ronhodgsonchevybuickgmc_production_inventory_low_to_high","params":"query=&hitsPerPage=1000&maxValuesPerFacet=250&page=0&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"ronhodgsonchevybuickgmc_production_inventory_low_to_high","params":"query=&hitsPerPage=1&maxValuesPerFacet=250&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"ronhodgsonchevybuickgmc_production_inventory_low_to_high","params":"query=&hitsPerPage=1000&maxValuesPerFacet=250&page=0&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"ronhodgsonchevybuickgmc_production_inventory_low_to_high","params":"query=&hitsPerPage=1&maxValuesPerFacet=250&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}

