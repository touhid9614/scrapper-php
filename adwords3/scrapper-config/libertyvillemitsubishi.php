<?php
global $scrapper_configs;
$scrapper_configs["libertyvillemitsubishi"] = array(
    'entry_points' => array(
        'new' => 'https://www.libertyvillemitsubishi.com/new-inventory/index.htm',
        'used' => 'https://www.libertyvillemitsubishi.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
    'ty_url_regex' => '/\/contact-form-confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.jcarousel-item'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.previous'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',

    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/<dt>Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
        'transmission' => '/<dt>Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Color:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres' => '/<dt>Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'data_capture_regx_full' => array(
        'vin' => '/vin:\s\'(?<vin>[^\']+)/',
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_libertyvillemitsubishi_field_images", "filter_libertyvillemitsubishi_field_images");

function filter_libertyvillemitsubishi_field_images($im_urls)
{

    return array_filter($im_urls, function ($im_urls) {
        $im_url = str_replace(['|', "%20"], ['%7C', " "], $im_urls);
        return !endsWith($im_url, 'en_US.jpg');
    });


}

