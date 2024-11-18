<?php
global $scrapper_configs;
$scrapper_configs["estevanmotors"] = array(
    'entry_points' => array(
        'used' => 'https://www.estevanmotors.ca/used-inventory/index.htm',
        'new' => 'https://www.estevanmotors.ca/new-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
    //'ty_url_regex' => '/\/contact-form-confirm.htm/i',
    'use-proxy' => false,
    //'proxy-area'        => 'CA',
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.slider-decorator-0'],
    'picture_prevs' => ['.slider-decorator-1'],

    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div  class="ddc-footer"',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:<\/dt>\s*[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/final-price.*class=\'value[^>]+>\$(?<price>[^<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'kilometres' => '/Kilometres:<\/dt> <dd>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'msrp' => '/MSRP<span class=\'separator\'>:<\/span><\/span>\s*<span class=\'[^>]+>\s*(?<msrp>\$[0-9,]+)/',
        'description' => '/Comments[^>]+>\s*[^>]+>\s*(?<description>[^<]+)/',
        'vin' => '/VIN:\s*[^>]+>[^>]+>(?<vin>[^<]+)/',
    ),

    'data_capture_regx_full' => array(
        'exterior_color' => '/Exterior Colour<[^>]+><[^>]+><[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Colour<[^>]+><[^>]+><[^>]+>(?<interior_color>[^<]+)/',
        //'drivetrain' => '/Drive type<\/span>[^>]+>[^>]+>[^>]+>(?<drivetrain>[^<]+)/',
        'fuel_type' => '/Fuel Economy[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<fuel_type>[^<]+)<\/span>/',
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    //'images_regx'       => '/<li>\s*<a href="(?<img_url>(?:https?:)?\/\/pictures.dealer.com\/c\/[^"]+)" class="">/',
    # Server has an older version of LibJPEG
    # When they resize image on their server they create image with a newer encoding
    # Which we fail to read, therefore we shall pick the base URL not the the URL with parameter
    # https://pictures.dealer.com/b/estevanmotorssaleslloydminstertc/0746/672e861c2af954e573f355a9bf37f7e1x.jpg?impolicy=resize&w=650
    # The above URL fails but the one below will work
    # https://pictures.dealer.com/b/estevanmotorssaleslloydminstertc/0746/672e861c2af954e573f355a9bf37f7e1x.jpg
    'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_estevanmotors_field_description", "filter_estevanmotors_field_description");

function filter_estevanmotors_field_description($description)
{
    return strip_tags($description);
}

add_filter("filter_estevanmotors_field_images", "filter_estevanmotors_field_images");
function filter_estevanmotors_field_images($im_urls)
{
    $retvals = [];

    foreach ($im_urls as $img) {
        $retvals[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }
    return array_filter($retvals, function ($retval) {
        return !startsWith($retval, 'https://images.dealer');
    });
}
