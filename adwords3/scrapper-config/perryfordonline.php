<?php

global $scrapper_configs;

$scrapper_configs['perryfordonline'] = array(
    'entry_points' => array(
        'new' => 'https://www.perryfordonline.com/new-inventory/index.htm',
        'used' => 'https://www.perryfordonline.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/class="msrp">[^\$]+(?<price>[^<]+)/', //msrp price for new page
        'kilometres' => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
        'vin' => '/<li>VIN:\s*<[^>]+>(?<vin>[^<]+)/',
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter("filter_perryfordonline_field_price", "filter_perryfordonline_field_price", 10, 3);

function filter_perryfordonline_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/class="msrp final-price">.*class=\'value[^>]+>(?<price>[^<]+)/'; //msrp1 price for new page
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/class="internetPrice final-price">.*class=\'value[^>]+>(?<price>[^<]+)/'; //perry's best price for used page
    $cond_final_regex = '/class="stackedConditionalFinal final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/'; //final price for new page
    $retail_regex = '/retailValue[^=]*="(?<price>[^"]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

/* add_filter("filter_perryfordonline_field_images", "filter_perryfordonline_field_images");

  function filter_perryfordonline_field_images($im_urls)
  {
  $retval = [];

  foreach ($im_urls as $im_url)
  {
  if (stripos($im_url, 'https://pictures.dealer.com/p/perrynationalcityfordfd/1330/a5d34688d0a139ac90fd694660349f7ax.jpg') == false)
  {
  $retval[] = $im_url;
  }
  }

  return $retval;
  } */

add_filter('filter_for_fb_perryfordonline', 'filter_for_fb_perryfordonline', 10, 1);

function filter_for_fb_perryfordonline($car) {
    $images = $car['images'];

    foreach ($images as $key => $value) {
        if (stripos($value, 'https://pictures.dealer.com/p/perrynationalcityfordfd/1330/a5d34688d0a139ac90fd694660349f7ax.jpg') !== false) {
            unset($images[$key]);
        }

        if (stripos($value, 'https://static.dealer.com/images/blank.gif') !== false) {
            unset($images[$key]);
        }
    }

    $car['images'] = $images;

    return $car;
}