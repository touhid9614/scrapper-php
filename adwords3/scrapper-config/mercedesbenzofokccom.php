<?php
global $scrapper_configs;
$scrapper_configs["mercedesbenzofokccom"] = array( 
	'entry_points' => array(
        'new' => 'https://www.mercedesbenzofokc.com/new-vehicles/',
        'used' => 'https://www.mercedesbenzofokc.com/used-vehicles/'
    ),
    'use-proxy' => true,
     'refine'=>false,
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.swiper-lazy'],
    'picture_nexts' => ['.swiper-button-next'],
    'picture_prevs' => ['.swiper-button-prev'],
    'details_start_tag' => '<table class="results_table">',
    'details_end_tag' => '</table>',
    'details_spliter' => '<tr class="spacer">',
    'data_capture_regx' => array(
        'stock_number' => '/<span class="stock-label">Stock\s*#:\s*(?<stock_number>[^<]+)/',
         'vin' => '/VIN:\s*(?<vin>[^<]+)/', 
        'title' => '/<div class="vehicle-title.*">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>(?:New|Pre-Owned|Certified Pre-Owned|)\s*(?<year>[0-9]{4}) *(?<make>[^ ]+) (?<model>[^ <]+)[^<])/',
        'year' => '/data-year=\'(?<year>[^\']+)/',
        'make' => '/data-make=\'(?<make>[^\']+)/',
        'model' => '/data-model=\'(?<model>[^\']+)/',
        'price' => '/Market Price\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
        'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
       // 'engine' => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
        'interior_color' => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
        'kilometres' => '/Kilometers:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
        'url' => '/<div class="vehicle-title.*">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) (?<model>[^ <]+)[^<])/'
    ),
    'data_capture_regx_full' => array(
         'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<img class="swiper-lazy" data-src="(?<img_url>[^"]+)"\s*alt/'
);
add_filter('filter_mercedesbenzofokccom_post_data', 'filter_mercedesbenzofokccom_post_data', 10, 3);
add_filter('filter_mercedesbenzofokccom_data', 'filter_mercedesbenzofokccom_data');
add_filter("filter_mercedesbenzofokccom_field_images", "filter_mercedesbenzofokccom_field_images");

$mercedesbenzofokccom_nonce = '';

function filter_mercedesbenzofokccom_post_data($post_data, $stock_type, $data) {
    global $mercedesbenzofokccom_nonce;
    if ($post_data == '') {
        $post_data = "page=1";
    }

    $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
    $nonce = '';
    $matches = [];

    if ($data && preg_match($nonce_regex, $data, $matches)) {
        $nonce = $matches['nonce'];
    }
    slecho("ajax_nonce : " . $nonce);
    if ($nonce && isset($nonce)) {
        $mercedesbenzofokccom_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $mercedesbenzofokccom_nonce);
    $post_id = 6;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 7;
        $referer = '/used-vehicles/';
    }

    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$mercedesbenzofokccom_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_mercedesbenzofokccom_data($data) {
    if ($data) {
        if (isJSON($data)) {
            slecho("data is in jSon format");
            $obj = json_decode($data);

            $data = "{$obj->results}\n{$obj->pagination}";
        } else {
            slecho("data is not in jSon format");
        }
    }

    return $data;
}

function filter_mercedesbenzofokccom_field_images($im_urls) {
  $final_image=[];
   $check_exist=["notfound.jpg","PhotosComingSoon-Sprinter.jpg","cc_2020MBS680003_01_640_149.png"];

   foreach ($im_urls as $images){

       $contents = explode('/', $images);
       if (!in_array(end($contents), $check_exist))
       {
           array_push($final_image,$images);
       }
   }
   return $final_image;
}
 add_filter("filter_mercedesbenzofokccom_field_price", "filter_mercedesbenzofokccom_field_price", 10, 3);

    function filter_mercedesbenzofokccom_field_price($price, $car_data, $spltd_data) 
    {
        $prices = [];

        slecho('');

        if ($price && numarifyPrice($price) > 0) 
        {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }

        $was_regex = '/MSRP\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';
        $matches = [];

       
        if (preg_match($was_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) 
        {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Was Price: {$matches['price']}");
        }

        if (count($prices) > 0) 
        {
            $price = butifyPrice(min($prices));
        }

        slecho("Sale Price: {$price}" . '<br>');

        return $price;
    }
    
