<?php
global $scrapper_configs;
$scrapper_configs["oldsgm"] = array(
    "entry_points" => array(
        'new' => 'https://www.oldsgm.com/VehicleSearchResults?search=new',
        'used' => 'https://www.oldsgm.com/VehicleSearchResults?search=preowned'
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used)-[0-9]{4}-\S+/i',
    'use-proxy' => true,

    'picture_selectors'         => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'             => ['#rg-gallery > div.rg-thumbs > div.es-carousel-wrapper > div:nth-child(1) > span.es-nav-next'],
    'picture_prevs'             => ['#rg-gallery > div.rg-thumbs > div.es-carousel-wrapper > div:nth-child(1) > span.es-nav-prev'],

    'details_start_tag' => '<ul each="cards">',
     'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
     'details_spliter'   => '<div class="deck" each="cards">',

    'data_capture_regx' => array(
        'stock_type' => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'url' => '/<div class="content" template="content">.*href="(?<url>[^"]+)/',
        'year' => '/<span class="year" itemprop="vehicleModelDate">(?<year>[^<]+)/',
        'make' => '/<span class="make" not="suppressMake" itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/<span class="model" itemprop="model">(?<model>[^<]+)/',
        'price' => '/itemprop="price".*data-action="priceSpecification"[^>]+>(?<price>[^<]+)/',
       
    ),

    'data_capture_regx_full' => array(
        'stock_number' => '/Stock Number<\/span>\s*<span [^>]+>(?<stock_number>[^<]+)/',
        'exterior_color' => '/Exterior<\/span>\s*<[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'kilometres' => '/"miles":"(?<kilometres>[^"]+)/',
        'transmission' => '/Transmission<\/span>\s*.*>\s*<span itemprop="name">(?<transmission>[^<]+)/',
        'engine' => '/<span class="value" itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'vin' => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
    ),

    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
   
);

add_filter("filter_oldsgm_next_page", "filter_oldsgm_next_page", 10, 2);
add_filter("filter_oldsgm_field_images", "filter_oldsgm_field_images");

function filter_oldsgm_next_page($next,$current_page)
{
    slecho("Filtering Next url");
    $car_type= explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
}

function filter_oldsgm_field_images($im_urls)
{
    $final_image=[];
    $i=0;
    foreach ($im_urls as $image){
        if ($i == 0) {
            $i++;
            continue;
        }
        array_push($final_image,$image);
    }
    return $final_image;
}