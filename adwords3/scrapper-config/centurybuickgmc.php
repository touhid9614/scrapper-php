<?php
global $scrapper_configs;
$scrapper_configs["centurybuickgmc"] = array(
    'entry_points'           => array(
        'new'  => 'https://www.centurybuickgmc.com/VehicleSearchResults?search=new',
        'used' => 'https://www.centurybuickgmc.com/VehicleSearchResults?search=preowned',
    ),
    'vdp_url_regex'          => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/',
    'use-proxy'              => false,
    'picture_selectors'      => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'          => ['.arrow.single.next'],
    'picture_prevs'          => ['.arrow.single.prev'],
    'details_start_tag'      => '<ul each="cards">',
    'details_end_tag'        => '<div class="content" id="pageDisclaimer">',
    'details_spliter'        => '<div class="deck" each="cards">',
    'data_capture_regx'      => array(
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^<]+)/',
        // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year'           => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make'           => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model'          => '/itemprop="model">(?<model>[^<]+)/',
        'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim'           => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url'            => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'transmission'   => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price'          => '/itemprop="price".*data-action="priceSpecification"[^>]+>(?<price>[^<]+)/',
        'msrp'           => '/MSRP\s*<\/span>\s*[^>]+>(?<msrp>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres'     => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style'     => '/"bodyType":"(?<body_style>[^"]+)/',
        'vin'            => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)</',
        //'price' => '/MSRP\s*<\/span>\s*[^>]+>(?<msrp>[^<]+)/',
    ),
    'next_page_regx'         => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx'            => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx'   => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/',
);

add_filter("filter_centurybuickgmc_next_page", "filter_centurybuickgmc_next_page", 10, 2);
add_filter("filter_centurybuickgmc_field_price", "filter_centurybuickgmc_field_price", 10, 3);
add_filter("filter_centurybuickgmc_field_images", "filter_centurybuickgmc_field_images");

function filter_centurybuickgmc_field_images($im_urls)
{
    //  if(count($im_urls) < 3) { return array(); }
    return array_filter($im_urls, function ($im_url) {
        return !endsWith($im_url, 'photo_unavailable_320.gif');
    });
}

function filter_centurybuickgmc_next_page($next, $current_page)
{
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

function filter_centurybuickgmc_field_price($price, $car_data, $spltd_data)
{
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }
    $msrp_regex = '/MSRP\s*<\/span>\s*[^>]+>(?<price>[^<]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}