<?php

global $scrapper_configs;

$scrapper_configs['toyotasbynelson'] = array(
    'entry_points'        => array(
        'used' => 'https://sewjn80htn-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.1.0)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.1.1)&x-algolia-api-key=179608f32563367799314290254e3e44&x-algolia-application-id=SEWJN80HTN',
        'new'  => 'https://sewjn80htn-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.1.0)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.1.1)&x-algolia-api-key=179608f32563367799314290254e3e44&x-algolia-application-id=SEWJN80HTN',
    ),
    'vdp_url_regex'       => '/inventory\/(?:new|used|certified-used)-[0-9]{4}-/',
    'use-proxy'           => true,
    'refine'              => false,
    'init_method'         => 'POST',
    'next_method'         => 'POST',
    'picture_selectors'   => ['.swiper-slide'],
    'picture_nexts'       => ['.swiper-button-next'],
    'picture_prevs'       => ['.swiper-button-prev'],
    'content_type'        => 'application/json',
    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return [];
        }

        $to_return = [];

        foreach ($objects->results[0]->hits as $obj) {
            $car_data = array(
                'stock_number'   => $obj->stock ? $obj->stock : $obj->vin,
                'stock_type'     => $obj->type == 'Certified Used' ? 'used' : strtolower($obj->type),
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
                'interior_color' => $obj->int_color,
                //'all_images'     => $obj->thumbnail
            );

              
$response_data = HttpGet($car_data['url']);
            $regex       =  '/<meta name="description" content="(?<description>[^"]+)/';
            $matches = [];
            if(preg_match($regex, $response_data, $matches)) {
           
            $car_data['description']=$matches['description'];
             
            } 

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
    //'images_regx'         => '/data-background="(?<img_url>[^"]+)/'
);
add_filter('filter_toyotasbynelson_post_data', 'filter_toyotasbynelson_post_data', 10, 2);

function filter_toyotasbynelson_post_data($post_data, $stock_type)
{
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"nelsontoyota_production_inventory_high_to_low","params":"maxValuesPerFacet=250&hitsPerPage=60&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22model_code%22%2C%22bodytype%22%2C%22special_field_1%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algoliaPrice%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%2C%5B%22make%3AToyota%22%5D%5D"},{"indexName":"nelsontoyota_production_inventory_high_to_low","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type&facetFilters=%5B%5B%22make%3AToyota%22%5D%5D"},{"indexName":"nelsontoyota_production_inventory_high_to_low","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=make&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"nelsontoyota_production_inventory_high_to_low","params":"maxValuesPerFacet=250&hitsPerPage=600&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22model_code%22%2C%22bodytype%22%2C%22special_field_1%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algoliaPrice%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"nelsontoyota_production_inventory_high_to_low","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}
add_filter("filter_toyotasbynelson_field_images", "filter_toyotasbynelson_field_images");

function filter_toyotasbynelson_field_images($im_urls)
{
    return array_filter($im_urls, function ($im_url) {
        return !endsWith($im_url, 'Nelson-Toyota-Photos-Coming-Soon.png');
    });
}
