<?php

global $scrapper_configs;

$scrapper_configs['jonesautocenters'] = array(
    'entry_points' => array(
        'new' => 'https://www.jonesautocenters.com/new-inventory/index.htm',
        'used' => 'https://www.jonesautocenters.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.jcarousel li'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.prev'],
    'details_start_tag' => '<ul class="gv-inventory-list simple-grid list-unstyled">',
    'details_end_tag' => '<div class="clearfix ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="inventory-titl[^>]+>\s*<a href="(?<url>[^"]+)[^>]+>(?<title>[^<]+)/',
        'title'         => '/class="url">\s*(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/(?:MSRP|Price)[^>]+>[^>]+>[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
            'stock_number'  => '/Stock Number<\/label>[^>]+>(?<stock_number>[^<]+)/',
            'engine'        => '/Engine<\/label>[^>]+>(?<engine>[^<]+)/',      
            'transmission'  => '/Transmission<\/label>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Color<\/label>[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color<\/label>[^>]+>(?<interior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '/make: \'(?<make>[^\']+)\',/',
        'model' => '/model: \'(?<model>[^\']+)\',/',
         'price'         => '/(?:MSRP|Price)[^>]+>[^>]+>[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
    ),
    //'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'next_page_regx' => '/rel="next"\s*href="(?<next>[^"]+)"/',
    'images_regx' => '/{."id.":[^,]+,."src.":."(?<img_url>[^\\\\]+)."/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_jonesautocenters_field_price", "filter_jonesautocenters_field_price", 10, 3);

function filter_jonesautocenters_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $final_regex = '/.final-price .price-value">(?<price>[^<]+)/';
    $msrp_regex = '/MSRP\s*.*\s*[^>]+>\s*[^>]+>\s*(?<price>[^\s*]+)/';
    $cond_final_regex = '/Jones Conditional Price.*data-style-editor-text="[^>]+>(?<price>[^<]+)/';
    
    $asking_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
   


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
  
    if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
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
       add_filter("filter_jonesautocenters_field_images", "filter_jonesautocenters_field_images");
    
   function filter_jonesautocenters_field_images($im_urls)
    {
        $retval = [];
        
        foreach($im_urls as $img)
        {
            
             $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
        }
        
        return $retval;
    }
