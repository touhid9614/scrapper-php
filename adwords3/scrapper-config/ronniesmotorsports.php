<?php

global $scrapper_configs;

$scrapper_configs['ronniesmotorsports'] = array(
    'entry_points'        => array(
        'all' => 'https://ronniesmotorsports.com/Showroom/All-Inventory',
    ),
    'vdp_url_regex'       => '/-[0-9]{4}-Guilderland-NY-/',
    'use-proxy'           => true,
    'refine'              => false,
    'init_method'         => 'GET',
    'picture_selectors'   => ['.swiper-slide'],
    'picture_nexts'       => ['.swiper-button-next'],
    'picture_prevs'       => ['.swiper-button-prev'],

    'custom_data_capture' => function ($url, $srp_data) {
        $api_key_regex = '/","apiKey":"(?<api_key>[^"]+)/';
        $matches       = [];

        preg_match($api_key_regex, $srp_data, $matches);
        $api_key = $matches['api_key'];

        $api_url   = 'https://rbg3h22y5v-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.30.0%3Binstantsearch.js%202.10.4%3BJS%20Helper%202.26.1&x-algolia-application-id=RBG3H22Y5V&x-algolia-api-key=' . $api_key;
        $post_data = '{"requests":[{"indexName":"prod_WebSellable","params":"query=&hitsPerPage=1000&maxValuesPerFacet=1000&page=0&facets=%5B%22Year%22%2C%22Price%22%2C%22Condition%22%2C%22Manufacturer%22%2C%22ProductCategory%22%2C%22ProductType%22%5D&tagFilters="}]}';

        $in_cookies         = '';
        $out_cookies        = '';
        $use_proxy          = true;
        $random_proxy       = true;
        $content_type       = 'application/json';
        $additional_headers = [];

        $data = HttpPost($api_url, $post_data, $in_cookies, $out_cookies, $use_proxy, $random_proxy, $content_type, $additional_headers);

        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return [];
        }

        $to_return = [];

        // Take image from PhotoLists
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
