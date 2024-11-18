<?php

global $scrapper_configs;

$scrapper_configs['ronniesmotorsports'] = array(
    'entry_points'        => array(
        'used' => 'https://rbg3h22y5v-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.30.0%3Binstantsearch.js%202.10.4%3BJS%20Helper%202.26.1&x-algolia-application-id=RBG3H22Y5V&x-algolia-api-key=YjZjZmE5MTg0NzYwZmJmZjY0ODg0NjAyMDA0MDdhYTliOTM2MGFhMDljNTZiMzI5NzkyMGI3MmJiMDEzZGNlOGZhY2V0RmlsdGVycz0lNUIlNUIlMjJPcmdhbml6YXRpb25JZCUzQTRiZGY5NjhiLTkwOWYtNGYwMy04MTA1LTk4OGQyMjk4OGMzZSUyMiU1RCUyQyU1QiUyMlNpdGVHdWlkTGlzdHMlM0E5MTY2NzQ5Yi05Y2RjLTQwZTQtYTMzZS1hNmZjMGJhZjdhY2ElMjIlNUQlMkMlNUIlMjJDb25kaXRpb24lM0FVc2VkJTIyJTVEJTVEJnJlc3RyaWN0SW5kaWNlcz1wcm9kX1dlYlNlbGxhYmxlLHByb2RfV2ViU2VsbGFibGVfUHJpY2VfQXNjLHByb2RfV2ViU2VsbGFibGVfUHJpY2VfRGVzYyZ2YWxpZFVudGlsPTE2MTU0OTAwNjE%3D',
        'new'  => 'https://rbg3h22y5v-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.30.0%3Binstantsearch.js%202.10.4%3BJS%20Helper%202.26.1&x-algolia-application-id=RBG3H22Y5V&x-algolia-api-key=NWIwZjg4YjYzOWRhYzRmMjgwZjRlY2VkZGUwOTM3NzYyNWYzM2NhMjRjOWQzOGM0NTBkZTYwNDVmNTk1NDFhM2ZhY2V0RmlsdGVycz0lNUIlNUIlMjJPcmdhbml6YXRpb25JZCUzQTRiZGY5NjhiLTkwOWYtNGYwMy04MTA1LTk4OGQyMjk4OGMzZSUyMiU1RCUyQyU1QiUyMlNpdGVHdWlkTGlzdHMlM0E5MTY2NzQ5Yi05Y2RjLTQwZTQtYTMzZS1hNmZjMGJhZjdhY2ElMjIlNUQlMkMlNUIlMjJDb25kaXRpb24lM0FOZXclMjIlNUQlNUQmcmVzdHJpY3RJbmRpY2VzPXByb2RfV2ViU2VsbGFibGUscHJvZF9XZWJTZWxsYWJsZV9QcmljZV9Bc2MscHJvZF9XZWJTZWxsYWJsZV9QcmljZV9EZXNjJnZhbGlkVW50aWw9MTYxNTQ4OTkzOA%3D%3D',
    ),
    'vdp_url_regex'       => '/-[0-9]{4}-Guilderland-NY-/',
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
                'stock_number'   => $obj->StockNumber,
                'vin'            => $obj->Vin,
                'stock_type'     => $obj->Condition == 'Used' ? 'used' : 'new',
                'price'          => $obj->Price,
                'msrp'           => $obj->Msrp,
                'kilometres'     => $obj->Odometer,
                'engine'         => $obj->EngineSize,
                'year'           => $obj->Year,
                'make'           => $obj->Manufacturer,
                'model'          => $obj->ProductName,
                'exterior_color' => $obj->Color,
                'url'            => $obj->ShowroomUrl,
                'city'           => $obj->City,
                'body_style'     => $obj->ProductCategory,
            );

            $response_data = HttpGet($car_data['url']);
            $regex         = '/<meta property="og:description" content="(?<description>[^"]+)/';
            $matches       = [];

            if (preg_match($regex, $response_data, $matches)) {
                $car_data['description'] = $matches['description'];
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },

    'images_regx'         => '/<div class="item"><img.*src="(?<img_url>[^"]+)"/'
);

add_filter('filter_ronniesmotorsports_post_data', 'filter_ronniesmotorsports_post_data', 10, 2);

function filter_ronniesmotorsports_post_data($post_data, $stock_type)
{
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"prod_WebSellable","params":"query=&hitsPerPage=1000&maxValuesPerFacet=99&page=0&facets=%5B%22Year%22%2C%22Price%22%2C%22Condition%22%2C%22Manufacturer%22%2C%22ProductCategory%22%2C%22ProductType%22%5D&tagFilters=&facetFilters=%5B%5B%22Condition%3ANew%22%5D%5D"},{"indexName":"prod_WebSellable","params":"query=&hitsPerPage=1000&maxValuesPerFacet=99&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=%5B%22Condition%22%5D"}]}';} elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"prod_WebSellable","params":"query=&hitsPerPage=1000&maxValuesPerFacet=99&page=0&facets=%5B%22Year%22%2C%22Price%22%2C%22Condition%22%2C%22Manufacturer%22%2C%22ProductCategory%22%2C%22ProductType%22%5D&tagFilters=&facetFilters=%5B%5B%22Condition%3AUsed%22%5D%5D"},{"indexName":"prod_WebSellable","params":"query=&hitsPerPage=1000&maxValuesPerFacet=99&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=%5B%22Condition%22%5D"}]}';}

    return $post_data;
}
