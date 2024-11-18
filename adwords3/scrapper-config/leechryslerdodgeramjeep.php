<?php
$scrapper_configs["leechryslerdodgeramjeep"] = array( 
"entry_points" => array(
        'used'  => 'https://www.leechryslerdodgeramjeep.com/search/used-wilson-nc/?cy=27896&tp=used',
        'new'  => 'https://www.leechryslerdodgeramjeep.com/search/new-chrysler-dodge-jeep-ram-wagoneer-wilson-nc/?&cy=27896&tp=new',
),
    'use-proxy' => false,
    'refine'    => false,  
    'proxy-area'   => 'CA',
    'vdp_url_regex'     => '/\/auto\/(?:nuevo|usado|new|used)-[0-9]{4}-/i',

    'details_start_tag' => 'class="srp_results carbon">',
    'details_end_tag'   => '<div id="details-disclaimer"',
    'details_spliter'   => 'class="vehicle_item"',
    
    'data_capture_regx' => array(
        'url'           => '/<a href="(?<url>[^"]+)"\s*alt/',
        'year'          => '/<a href="(?<url>[^"]+)"\s*alt\="(?<cus>[^\s*]+)\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)/',
        'make'          => '/<a href="(?<url>[^"]+)"\s*alt\="(?<cus>[^\s*]+)\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)/',
        'model'         => '/<a href="(?<url>[^"]+)"\s*alt\="(?<cus>[^\s*]+)\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)/',
        'price'         => '/Internet Price[^>]+>\s*[^"]+"vehicle_pri[^>]+>(?<price>[^<]+)/',
        'stock_number'  => '/data-stock="(?<stock_number>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
        'vin'           => '/VIN[^>]+>[^>]+>(?<vin>[^<]+)\<\/div/',
        'transmission'  => '/<meta\s*itemprop="vehicleTransmission"\s*content="(?<transmission>[^"]+)/',
        'exterior_color'=> '/Exterior Color[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color'=> '/Interior Color[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres'    => '/Mileage[^>]+>[^>]+>(?<kilometres>[^<]+)/',
    ),
    'next_page_regx'        => '/<li class="active[^>]+.*<\/li>\s*<li[^>]+>\s*<a\s*class="[^"]+"\s*href="(?<next>[^"]+)/',
    'images_regx'           => '/loopslider__image" data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_leechryslerdodgeramjeep_field_price", "filter_leechryslerdodgeramjeep_field_price", 10, 3);
function filter_leechryslerdodgeramjeep_field_price($price,$car_data, $spltd_data)
{
    $prices = [];

    slecho('');

    if($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("leechryslerdodgeramjeep Price: $price");
    }

    $msrp_regex =  '/MSRP[^>]+>[^>]+>(?<price>[^<]+)<span/';
    $now_regex  =  '/Lee Price[^>]+>[^>]+>(?<price>[^<]+)/';
    $list_regex =  '/List Price:\s*(?<price>\$[0-9,]+)/';

    $matches = [];

    if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    
    if(preg_match($now_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Now: {$matches['price']}");
    }

    if(preg_match($list_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex List Price: {$matches['price']}");
    }

    if(count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}".'<br>');
    return $price;
}

add_filter("filter_leechryslerdodgeramjeep_field_images", "filter_leechryslerdodgeramjeep_field_images");
   
    function filter_leechryslerdodgeramjeep_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
         if (endsWith($im_url, 'aW1nL21ha2VzLzE3X28uanBn')) {
           return false;
        }
        else if(endsWith($im_url, 'aW1nL21ha2VzLzI5X28uanBn')) {   
            return false;
        }
        return true;
        });
    }