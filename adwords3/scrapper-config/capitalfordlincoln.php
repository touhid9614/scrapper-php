<?php

global $scrapper_configs;
$scrapper_configs["capitalfordlincoln"] = array(
    'entry_points'        => array(
        'new'  => 'https://sewjn80htn-1.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.31.0%3BJS%20Helper%202.26.1&x-algolia-application-id=SEWJN80HTN&x-algolia-api-key=179608f32563367799314290254e3e44',
        'used' => 'https://sewjn80htn-1.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.31.0%3BJS%20Helper%202.26.1&x-algolia-application-id=SEWJN80HTN&x-algolia-api-key=179608f32563367799314290254e3e44'
    ),
    'vdp_url_regex'       => '/\/inventory\/(?:new|used|certified)-[0-9]{4}-/',
    'use-proxy'           => true,
    'refine'              => false,
    'init_method'         => 'POST',
    'next_method'         => 'POST',
    'picture_selectors'   => ['.owl-item'],
    'picture_nexts'       => ['.owl-next'],
    'picture_prevs'       => ['owl-prev'],
    'content_type'        => 'application/json',
    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
			slecho($data);
			return array();
		}

        $to_return = array();

        foreach ($objects->results[0]->hits as $obj) {
            $car_data = array(
                'stock_number'   => $obj->stock ? $obj->stock : $obj->vin,
                'stock_type'     => $obj->type == 'Used' ? 'used' : 'new',
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
                'all_images'     => $obj->thumbnail
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx'         => '/<img class="lazyOwl"[^"]+"(?<img_url>[^"]+)/'
);

add_filter('filter_capitalfordlincoln_post_data', 'filter_capitalfordlincoln_post_data', 10, 2);
add_filter("filter_capitalfordlincoln_field_images", "filter_capitalfordlincoln_field_images");

function filter_capitalfordlincoln_field_images($im_urls)
{
    return array_filter($im_urls, function ($img_url) {
        if (endsWith($img_url, "additional-photo-new-1.jpg")) {
            return false;
        } else if (endsWith($img_url, "notfound.jpg")) {
            return false;
        }
        return true;
    });
}

function filter_capitalfordlincoln_post_data($post_data, $stock_type)
{
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"capitalfordlincoln_production_inventory_specials_price","params":"query=&hitsPerPage=424&maxValuesPerFacet=250&page=0&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22lightning.locations.meta_location%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"capitalfordlincoln_production_inventory_specials_price","params":"query=&hitsPerPage=1&maxValuesPerFacet=250&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"capitalfordlincoln_production_inventory_specials_price","params":"query=&hitsPerPage=251&maxValuesPerFacet=250&page=0&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22lightning.locations.meta_location%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"capitalfordlincoln_production_inventory_specials_price","params":"query=&hitsPerPage=1&maxValuesPerFacet=250&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}
