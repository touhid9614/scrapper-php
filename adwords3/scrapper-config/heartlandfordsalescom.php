<?php
global $scrapper_configs;
$scrapper_configs["heartlandfordsalescom"] = array( 
	   'entry_points' => array(
            'new'   => 'https://www.heartlandfordsales.com/new/',
            'used'  => 'https://www.heartlandfordsales.com/used/'
        ),
        'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'refine'=>false,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['.next.stat-arrow-next'],
        'picture_prevs'     => ['.next.stat-arrow-prev'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer class="footer wp"',
        'details_spliter'   => '<div itemprop="ItemOffered"',
        'data_capture_regx' => array(
            'url'            => '/role="button" href="(?<url>[^"]+)"/',
            'year'           => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
            'make'           => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
            'model'          => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
            'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
            'stock_number'   => '/STK#\s*(?<stock_number>[^\/]+)/',
            'engine'         => '/engine":"(?<engine>[^"]+)/',
            'transmission'   => '/transmission":"(?<transmission>[^"]+)/',
            'exterior_color' => '/exteriorColour":"(?<exterior_color>[^"]+)/',
        ),
        'data_capture_regx_full' => array(
        ) ,
        'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx' => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    );
   add_filter("filter_heartlandfordsalescom_field_price", "filter_heartlandfordsalescom_field_price", 10, 3);

function filter_heartlandfordsalescom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Heartland Ford:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
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
add_filter("filter_heartlandfordsalescom_field_images", "filter_heartlandfordsalescom_field_images");
    
    function filter_heartlandfordsalescom_field_images($im_urls)
    {
       if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }