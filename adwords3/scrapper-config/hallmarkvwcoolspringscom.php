<?php

global $scrapper_configs;

$scrapper_configs['hallmarkvwcoolspringscom'] = array(
    'entry_points'        => array(
        'used' => 'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.1.0)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.1.1)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
        'new'  => 'https://v3zovi2qfz-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.1.0)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.1.1)&x-algolia-api-key=ec7553dd56e6d4c8bb447a0240e7aab3&x-algolia-application-id=V3ZOVI2QFZ',
    ),
    'vdp_url_regex'       => '/\/inventory\/(?:new|used)-[0-9]{4}-/',
    'ty_url_regex'        => '/\/thank-you-for-/i',
    'srp_page_regex'      => '/\/(?:new|used|certified)-vehicles/i',
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

        if (!$objects) {slecho($data);return array();}

        $to_return = array();

        foreach ($objects->results[0]->hits as $obj) {
            //$obj = $obj->_source;

            $car_data = array(
                'stock_number'   => $obj->stock ? $obj->stock : $obj->vin,
                'year'           => $obj->year,
                'make'           => $obj->make,
                'model'          => $obj->model,
                // 'trim'              => $obj->trim,
                'body_style'     => $obj->body,
                'price'          => $obj->our_price == '<span class="callforprice">Please call for price</span>' ? 'Please Call' : $obj->our_price,
                'engine'         => $obj->engine_description,
                'transmission'   => $obj->transmission_description,
                'kilometres'     => $obj->miles,
                'vin'            => $obj->vin,
                'fuel_type'      => $obj->fueltype,
                // 'drivetrain'        => $obj->drivetrain,
                'msrp'           => $obj->msrp,
                'url'            => $obj->link,
                'exterior_color' => $obj->ext_color,
                'interior_color' => $obj->int_color,
                'all_images'     => $obj->thumbnail,
                //'title'             => $obj->title_vrp,
            );
            
             $response_data = HttpGet($car_data['url']);
            $regex       =  '/<meta name="description" content="(?<description>[^"]+)/';
            $matches = [];
            if(preg_match($regex, $response_data, $matches)) {
           
            $car_data['description']=$matches['description'];
             
            } 
            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx'         => '/data-background="(?<img_url>[^"]+)/'
);
add_filter("filter_hallmarkvwcoolspringscom_field_images", "filter_hallmarkvwcoolspringscom_field_images");

function filter_hallmarkvwcoolspringscom_field_images($im_urls)
{
    if (count($im_urls) < 3) {
        slecho("Filter Worked");
        return array();
    }
    return $im_urls;
}

add_filter('filter_hallmarkvwcoolspringscom_post_data', 'filter_hallmarkvwcoolspringscom_post_data', 10, 2);

function filter_hallmarkvwcoolspringscom_post_data($post_data, $stock_type)
{
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"carlockvwofcoolsprings1_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22mileage_page%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"carlockvwofcoolsprings1_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"carlockvwofcoolsprings1_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22mileage_page%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"carlockvwofcoolsprings1_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}

// <?php
// global $scrapper_configs;
// $scrapper_configs["hallmarkvwcoolspringscom"] = array(
//     'entry_points' => array(
//             'new'   => 'https://www.volkswagenofcoolsprings.com/new-volkswagen-franklin-tn',
//             'used'  => 'https://www.volkswagenofcoolsprings.com/used-cars-franklin-tn',

//         ),
//         'vdp_url_regex'     => '/\/vehicle-details\//i',

//         'use-proxy' => true,
//         'refine'=>false,
//          'picture_selectors' => ['.thumb-item .thumb-preview'],
//         'picture_nexts'     => ['.navigation-arrow.navigation-right'],
//         'picture_prevs'     => ['.navigation-arrow.navigation-left'],

//         'details_start_tag' => '<div class="vehicles">',
//        'details_end_tag' => '<div class="inventory-pagination">',
//         'details_spliter' => '<div class="vehicle-container">',
//         'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',

//         'data_capture_regx' => array(
//             'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
//             'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/',
//             'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
//             'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
//             'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
//             'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
//             'price'         => '/(?:Our|Retail) Price:\s*<\/div>\s*[^>]+>\s*[^>]+>(?<price>[^<]+)/',
//             'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
//              'vin'          => '/data-vin="(?<vin>[^"]+)/',
//              'trim'          => '/"Trim":"(?<trim>[^"]+)/',

//         ),
//         'data_capture_regx_full' => array(
//             'interior_color'=> '/Interior:.*\s*<span class="value">(?<interior_color>[^<]+)/',
//             'trim'          => '/Trim:.*\s*<span class="value">(?<trim>[^ <]+)/',
//             'engine'        => '/Engine:<\/span>\s*[^>]+>(?<engine>[^<]+)/',
//             'transmission'  => '/Transmission:<\/span>\s*[^>]+>(?<transmission>[^<]+)/',
//             'kilometres'    => '/Mileage:<\/span>\s*[^>]+>(?<kilometres>[^<]+)/',
//              'vin'          => '/VIN #:<\/span>\s*[^>]+>(?<vin>[^<]+)/',

//         ),
//           'next_page_regx'    => '/<a class="pagination-next js-pagination-btn" href="(?<next>[^"]+)/',
//           'images_regx'       => '/itemprop="image" data-preview="(?<img_url>[^"]+)"/',
//           'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
//         );
//           add_filter("filter_hallmarkvwcoolspringscom_field_images", "filter_hallmarkvwcoolspringscom_field_images");
//           function filter_hallmarkvwcoolspringscom_field_images($im_urls) {

//   $retvals = [];

//     foreach ($im_urls as $img) {
//         $retvals[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
//     }
//     return array_filter($retvals, function ($retval) {
//         return !(endsWith($retval,'noimage_folsom.jpg'));
//     });
// }
