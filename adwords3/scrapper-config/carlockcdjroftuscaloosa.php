<?php

global $scrapper_configs;

/*$scrapper_configs["carlockcdjroftuscaloosa"] = array(
'entry_points'        => array(
'used' => 'https://www.carlockcdjroftuscaloosa.net/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
'new'  => 'https://www.carlockcdjroftuscaloosa.net/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1'
),
'vdp_url_regex'       => '/\/inventory\/(?:new|used|certified)-[0-9]{4}-/i',
'use-proxy'           => true,
'picture_selectors'   => ['.pswp-thumbnail'],
'picture_nexts'       => ['.pswp__button--arrow--right'],
'picture_prevs'       => ['.pswp__button--arrow--left'],
'custom_data_capture' => function ($url, $data) {
$objects = json_decode($data);

if (!$objects) {
slecho($data);
}

$to_return = [];

foreach ($objects->pageInfo->trackingData as $obj) {
$car_data = array(
'stock_number'   => !empty($obj->stockNumber) ? $obj->stockNumber : $obj->vin,
'stock_type'     => $obj->newOrUsed,
'vin'            => $obj->vin,
'year'           => $obj->modelYear,
'make'           => $obj->make,
'model'          => $obj->model,
'body_style'     => $obj->bodyStyle,
'price'          => $obj->pricing->finalPrice,
'trim'           => $obj->trim,
'transmission'   => $obj->transmission,
'kilometres'     => $obj->odometer,
'exterior_color' => $obj->exteriorColor,
'interior_color' => $obj->interiorColor,
'fuel_type'      => $obj->fuelType,
'drive_train'    => $obj->driveLine,
'options'        => isset($obj->installed_options) ? $obj->installed_options : [],
'url'            => "https://www.carlockcdjroftuscaloosa.net/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}" . ".htm"
);

$to_return[] = $car_data;
}

return $to_return;
},
'next_page_regx'      => '/enableMyCars":(?<next>[^"]+)/',
'images_regx'         => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/'
);

add_filter("filter_carlockcdjroftuscaloosa_next_page", "filter_carlockcdjroftuscaloosa_next_page", 10, 2);
function filter_carlockcdjroftuscaloosa_next_page($next, $current_page)
{
$start_tag = 'start=';
$end_tag   = '&';

if (stripos($current_page, $start_tag)) {
$resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
}

if (strpos($resp, $end_tag)) {
$resp = substr($resp, 0, stripos($resp, $end_tag));
}

$rep_value = $resp + 35;

$find = "start=" . $resp;
$rep  = "start=" . $rep_value;
$next = str_replace($find, $rep, $current_page);
slecho($next);

return $next;
}*/

$scrapper_configs["carlockcdjroftuscaloosa"] = array(
    'entry_points'        => array(
        'new' => 'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.6.0)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.2.2)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
        // we will get new, used, certified in single request
    ),
    'vdp_url_regex'       => '/\/inventory\/(?:new|used|certified)-[0-9]{4}-/i',
    'use-proxy'           => true,
    'init_method'         => 'POST',
    'next_method'         => 'POST',
    'picture_selectors'   => ['.pswp-thumbnail'],
    'picture_nexts'       => ['.pswp__button--arrow--right'],
    'picture_prevs'       => ['.pswp__button--arrow--left'],
    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
        }

        $to_return = [];

        foreach ($objects->results[0]->hits as $obj) {
            $car_data = [
                'url'            => $obj->link,
                'msrp'           => $obj->msrp,
                'price'          => $obj->our_price,
                'doors'          => $obj->doors,
                'cylinder'       => $obj->cylinders,
                'drivetrain'     => $obj->drivetrain,
                'certified'      => $obj->certified,
                'stock_number'   => !empty($obj->stock) ? $obj->stock : $obj->model_number,
                'vin'            => $obj->vin,
                'stock_type'     => (strtolower($obj->type) == 'new') ? 'new' : 'used',
                'year'           => $obj->year,
                'make'           => $obj->make,
                'model'          => $obj->model,
                'trim'           => $obj->trim,
                'title'          => $obj->title_vrp,
                'kilometres'     => $obj->miles,
                'transmission'   => $obj->transmission_description,
                'engine'         => $obj->engine_description,
                'exterior_color' => !empty($obj->ext_color) ? $obj->ext_color : $obj->ext_color_generic,
                'interior_color' => !empty($obj->int_color) ? $obj->int_color : $obj->ext_color_generic,
                'fuel_type'      => $obj->fueltype,
                'body_style'     => $obj->body
            ];

            $to_return[] = $car_data;
        }

        return $to_return;
    },

    'images_regx' => '/<div class="vehicle-image-bg swiper-lazy" data-background="(?<img_url>[^"]+)">/'
);

add_filter('filter_carlockcdjroftuscaloosa_post_data', 'filter_carlockcdjroftuscaloosa_post_data', 10);

function filter_carlockcdjroftuscaloosa_post_data($post_data)
{
    $post_data = '{"requests":[{"indexName":"carlockchryslerdodgejeepramoftuscaloosa_production_inventory","params":"maxValuesPerFacet=1000&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%2C%22type%3ANew%22%5D%5D"},{"indexName":"carlockchryslerdodgejeepramoftuscaloosa_production_inventory","params":"maxValuesPerFacet=1000&hitsPerPage=1000&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';

    return $post_data;
}
