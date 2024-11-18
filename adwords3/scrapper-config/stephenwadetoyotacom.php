<?php
global $scrapper_configs;

$scrapper_configs["stephenwadetoyotacom"] = array(
    'entry_points'           => array(
        // 'new'  => 'https://www.stephenwadetoyota.com/inventory?type=new',
        'used' => 'https://www.stephenwadetoyota.com/inventory?type=used',
    ),
    'vdp_url_regex'          => '/\/vehicle-details\/used-[0-9]{4}-/i',
    'url_resolve'            => array(
        'stephenwadetoyota'    => '/www\.stephenwadetoyota\.com\/.*new/',
        'stephenwadetoyotacom' => '/www\.stephenwadetoyota\.com\/.*used/',
    ),
    'use-proxy'              => true,
    'picture_selectors'      => ['.mz-thumb'],
    'picture_nexts'          => ['.mz-button-next'],
    'picture_prevs'          => ['.mz-button-prev'],
    'details_start_tag'      => '<div class="srp-vehicle-container" >',
    'details_end_tag'        => '<div class="footer">',
    'details_spliter'        => '<div class="row srp-vehicle" itemprop="offers"',
    'data_capture_regx'      => array(
        'url'            => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
        'title'          => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year'           => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make'           => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model'          => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'stock_number'   => '/Stock:<\/span>\s*<span>(?<stock_number>[^<]+)/',
        'price'          => '/itemprop=\'price\' content=\'(?<price>[0-9]+)/',
        'exterior_color' => '/Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
        'engine'         => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
        'transmission'   => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
        'kilometres'     => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'year'         => '/"year":\s*"(?<year>[^"]+)/',
        'make'         => '/make":\s*"(?<make>[^"]+)/',
        'model'        => '/model":\s*"(?<model>[^"]+)/',
        'stock_number' => '/"stock":\s*"(?<stock_number>[^"]+))/',
        'price'        => '/Red Tag Price:.*itemprop=\'price\' content=[^>]+><\/span>(?<price>[^<]+)/',
        'trim'         => '/trim":\s*"(?<trim>[^"]+)/',
        'body_style'   => '/Body Style:<\/span>\s*(?<body_style>[^<]+)/',
    ),
    'next_page_regx'         => '/current\'><a[^>]+>[^<]+<\/a><\/li><li><a href=\'(?<next>[^\']+)/',
    'images_regx'            => '/vehicleGallery" href="(?<img_url>[^"]+)/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);

add_filter("filter_stephenwadetoyotacom_field_images", "filter_stephenwadetoyotacom_field_images");

function filter_stephenwadetoyotacom_field_images($im_urls)
{
    return array_filter($im_urls, function ($img_url) {
        if (startsWith($img_url, "https://stock.")) {
            return false;
        } elseif (startsWith($img_url, "https://s3.amazonaws.com/")) {
            return false;
        }
        return true;
    });
}