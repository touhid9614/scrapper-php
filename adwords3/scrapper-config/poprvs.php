<?php
global $scrapper_configs;
$scrapper_configs["poprvs"] = array(
    'entry_points'        => array(
        'used' => 'https://2o969519xf-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.27.0%3Binstantsearch.js%202.8.0%3BJS%20Helper%202.26.0&x-algolia-application-id=2O969519XF&x-algolia-api-key=3f551dd1cf788162299dcbe02ef2879a',
    ),

    'vdp_url_regex'       => '/\/[A-Za-z-0-9]+\//',
    'use-proxy'           => true,
    'refine'              => false,

    'init_method'         => 'POST',
    'next_method'         => 'POST',

    'picture_selectors'   => ['.pswp__img'],
    'picture_nexts'       => ['.pswp__button pswp__button--arrow--right'],
    'picture_prevs'       => ['.pswp__button pswp__button--arrow--left'],
    'content_type'        => 'application/json',

    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return [];
        }

        $to_return = [];

        foreach ($objects->results[0]->hits as $obj) {
            $car_data = [
                'stock_number'   => (isset($obj->stock_number) && !empty($obj->stock_number)) ? $obj->stock_number : md5("https://www.poprvs.com/" . $obj->folders),
                'stock_type'   => 'used',
                'year'         => $obj->year,
                'make'         => $obj->manufactured_by ? $obj->manufactured_by : "Other",
                'model'        => $obj->model,
                'trim'         => $obj->trim,
                'body_style'   => 'RV',
                'price'        => $obj->price,
                'msrp'         => $obj->price_previous_max,
                'currency'     => $obj->currency_code,
                'kilometres'   => $obj->mileage,
                'fuel_type'    => $obj->fuel_type,
                'url'          => "https://www.poprvs.com/" . $obj->folders,
                'description'  => $obj->description,
            ];

            $to_return[] = $car_data;
        }

        return $to_return;
    },

    'images_regx'         => '/data-load-src="(?<img_url>[^"]+)"/'

);

add_filter('filter_poprvs_post_data', 'filter_poprvs_post_data', 10, 2);
add_filter("filter_poprvs_field_images", "filter_poprvs_field_images");
add_filter('filter_poprvs_car_data', 'filter_poprvs_car_data');

function filter_poprvs_post_data($post_data, $stock_type)
{
    $post_data = '{"requests":[{"indexName":"RV_Listings","params":"query=&hitsPerPage=1000&maxValuesPerFacet=10&page=0&aroundLatLng=&aroundRadius=all&facets=%5B%22stock_number%22%2C%22price%22%2C%22category_combined%22%2C%22brand_manufacturer%22%2C%22price%22%2C%22mileage%22%2C%22year%22%2C%22length_search%22%2C%22fuel_type%22%2C%22state_province_title%22%2C%22region%22%2C%22non_smoking%22%2C%22pet_free%22%2C%22has_video%22%2C%22has_bunks%22%2C%22has_tag_axle%22%2C%22has_king_bed%22%5D&tagFilters="}]}';

    return $post_data;
}

function filter_poprvs_field_images($im_urls)
{
    if (count($im_urls) < 3) {
        return array();
    }

    return $im_urls;
}

function handle_poprvs_pagination($url, $objects)
{
    if ($objects->results->nbHits <= 1000) {
        return $objects;
    }

    $pages = (int) ($objects->results->nbHits / 1000);

    if (!($pagination->length % 1000)) {
        $pages--;
    }

    $post_data          = '{"requests":[{"indexName":"RV_Listings","params":"query=&hitsPerPage=1000&maxValuesPerFacet=10&page=0&aroundLatLng=&aroundRadius=all&facets=%5B%22stock_number%22%2C%22price%22%2C%22category_combined%22%2C%22brand_manufacturer%22%2C%22price%22%2C%22mileage%22%2C%22year%22%2C%22length_search%22%2C%22fuel_type%22%2C%22state_province_title%22%2C%22region%22%2C%22non_smoking%22%2C%22pet_free%22%2C%22has_video%22%2C%22has_bunks%22%2C%22has_tag_axle%22%2C%22has_king_bed%22%5D&tagFilters="}]}';

    $additional_headers = [];
    $content_type       = 'application/json';
    $out_cookies        = '';
    $$in_cookies        = '';

    if ($pages) {
        for ($i = 1; $i <= $pages; $i++) {
            $mData        = HttpPost($url, $post_data, $in_cookies, $out_cookies, true, true, $content_type, $additional_headers);
            $more_objects = json_decode($mData);
            $objects      = array_merge($objects, $more_objects);
        }
    }

    return $objects;
}

function filter_poprvs_car_data($car_data)
{
    $car_data['vin'] = substr($car_data['stock_number'], 0, 16);

    return $car_data;
}