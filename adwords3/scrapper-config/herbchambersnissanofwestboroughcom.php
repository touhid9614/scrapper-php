<?php
global $scrapper_configs;
 $scrapper_configs["herbchambersnissanofwestboroughcom"] = array( 
	'entry_points' => array(
        'used' => 'https://www.herbchambersnissanofwestborough.com/used-inventory/herb-chambers.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/contact-form-confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.mss-slide'],
    'picture_nexts' => ['.mss-arrow-next'],
    'picture_prevs' => ['.mss-arrow-prev'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
       
        'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/final-price.*class=\'value[^>]+>\$(?<price>[^<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres' => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'msrp'          => '/MSRP<span class=\'separator\'>:<\/span><\/span>\s*<span class=\'[^>]+>\s*(?<msrp>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
         'stock_number' => '/Stock:[^>]+>(?<stock_number>[^<]+)/',
         'price' => '/ <li class="final-price">\s*<i .*\s*<span class="price">(?<price>[^<]+)/',
         'vin'           => '/VIN:\s*[^>]+>(?<vin>[^<]+)<\!/',
    ),
    'next_page_regx'        => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx'           => '/"id":[^"]+"src":"(?<img_url>[^"]+)","thumbnail"/',
    'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_herbchambersnissanofwestboroughcom_field_images", "filter_herbchambersnissanofwestboroughcom_field_images");

function filter_herbchambersnissanofwestboroughcom_field_images($im_urls) {
   $retval = [];
    $final_image = [];
    $check_exist = ["640-en_US.jpg"];

    foreach ($im_urls as $images) {

        $contents = explode('/', $images);
        if (!in_array(end($contents), $check_exist)) {
            array_push($final_image, $images);
        }
    }

    foreach ($final_image as $img) {

        $retval[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }

    return $retval;
}

add_filter("filter_herbchambersnissanofwestboroughcom_field_price", "filter_herbchambersnissanofwestboroughcom_field_price", 10, 3);

function filter_herbchambersnissanofwestboroughcom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("herbchambersnissanofwestboroughcom Price: $price");
    }

    $retail_regex = '/retailValue"><span[^>]+>[^<]+<span[^>]+>[^<]+<\/span><\/span><span\s*class=\'value\'[^>]+>(?<price>[^<]+)/';

    $matches = [];

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex lot price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
