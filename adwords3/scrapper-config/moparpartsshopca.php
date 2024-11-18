<?php
global $scrapper_configs;
$scrapper_configs["moparpartsshopca"] = array(
    'entry_points'           => array(
        'new' => array(
            'https://www.moparpartsshop.ca/cargo',
            'https://www.moparpartsshop.ca/floor-mats',
            'https://www.moparpartsshop.ca/wheels',
            'https://www.moparpartsshop.ca/mud-guards',
            'https://www.moparpartsshop.ca/roof-racks',
            'https://www.moparpartsshop.ca/cargo-organizers',
            'https://www.moparpartsshop.ca/interior-accessories',
        ),
    ),

    'vdp_url_regex'          => '/\/oem-parts\//i',
    'ty_url_regex'           => '/\/form\/confirm.htm/i',
    'use-proxy'              => true,

    'picture_selectors'      => ['.fancybox-image'],
    'picture_nexts'          => ['.owl-next'],
    'picture_prevs'          => ['.owl-prev'],

    'details_start_tag'      => '<div class="catalog-products',
    'details_end_tag'        => '<footer class="container-footer',
    'details_spliter'        => 'class="catalog-product row',

    'data_capture_regx'      => array(
        'url'          => '/class="product-title">\s*<a\s*href="(?<url>[^\?]+)[^>]+>(?<make>[^<]+)/',
        'make'         => '/class="product-title">\s*<a\s*href="(?<url>[^\?]+)[^>]+>(?<make>[^<]+)/',
        'year'         => '/2021/',
        'model'        => '/data-sku="(?<model>[^"]+)/',
        'price'        => '/data-sale-price="(?<price>[^"]+)/',
        'stock_number' => '/data-sku="(?<stock_number>[^"]+)/',
        'currency'     => '/CAD/',
    ),

    'data_capture_regx_full' => array(

    ),

    'images_regx'            => '/data-image-main-url="(?<img_url>[^"]+)"/',
);