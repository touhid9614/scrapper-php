<?php
global $scrapper_configs;
$scrapper_configs["mccombssuperiorhyundai"] = array(
    "entry_points" => array(
        'new' => 'http://www.mccombssuperiorhyundai.com/new-inventory/index.htm',
        'used' => 'http://www.mccombssuperiorhyundai.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    //'required_params'   => ['searchDepth'],
    'use-proxy' => true,
    'picture_selectors' => ['.jcarousel-item'],
    'picture_nexts' => ['.next'],
    'picture_prevs' => ['.prev'],

    'details_start_tag' => '<div class="type-2 ddc-content',
    'details_end_tag' => '<div class=" ddc-content content-default',
    'details_spliter' => '<li class="item notshared',
    'data_capture_regx' => array(
        'url' => '/class="url"[^"]*"(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"[^"]*"(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:<\/dt> <dd>(?<kilometres>[^miles]+)/',
        'stock_number' => '/data-vin="(?<stock_number>[^"]+)/',
        'engine' => '/Engine:<\/dt> <dd>(?<engine>[^<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt> <dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/data-exteriorColor="(?<exterior_color>[^"]+)/',
        'interior_color' => '/Interior Color:</dt> <dd>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
        'vin' => '/VIN:\s(?<vin>[^"]+)"\s/'
    ),
    'next_page_regx' => '/rel="next"[^?]*(?<next>[^;]+)/',
    'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/'
);

add_filter("filter_mccombssuperiorhyundai_field_images", "filter_mccombssuperiorhyundai_field_images");

function filter_mccombssuperiorhyundai_field_images($im_urls)
{
    if (count($im_urls) <= 2) {
        return array();
    }
    return $im_urls;
}