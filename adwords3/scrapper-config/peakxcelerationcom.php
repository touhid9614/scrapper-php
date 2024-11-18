<?php
global $scrapper_configs;
$scrapper_configs["peakxcelerationcom"] = array( 
	'entry_points' => array(
        'used' => 'https://www.peakxceleration.com/--inventory?condition=pre-owned&pg=1',
        'new' => 'https://www.peakxceleration.com/--inventory?condition=new&pg=1',
        
    ),
    'vdp_url_regex' => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine'   => false,
    'picture_selectors' => ['.lS-image-wrapper'],
    'picture_nexts' => ['.lSNext'],
    'picture_prevs' => ['.lSPrev'],
    'details_start_tag' => '<div class="v7list-results listview',
    'details_end_tag' => '<footer',
    'details_spliter' => '<li class="v7list-results__item"',
    'data_capture_regx' => array(
      
        'year' => '/vehicle-heading__year">(?<year>[0-9]{4})/',
        'make' => '/vehicle-heading__name">(?<make>[^<]+)/',
        'model' => '/vehicle-heading__model">(?<model>[^<]+)/',
        'url' => '/<a class="vehicle-heading__link" href="(?<url>[^"]+)"/',
        'price' => '/class="vehicle-price__price ">\s*(?<price>[^\s]+)/',
     
    ),
    'data_capture_regx_full' => array(
         'stock_number' => '/Stock Number<\/label>\s*[^>]+>(?<stock_number>[^\<]+)/',
         'vin' => '/Stock Number<\/label>\s*[^>]+>(?<vin>[^<]+)/',
        'fuel_type' => '/Fuel Type<\/label>\s*[^>]+>(?<fuel_type>[^<]+)/',
        'exterior_color' => '/Color<\/label>\s*[^>]+>(?<exterior_color>[^\<]+)/',
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
         'engine' => '/Engine<\/label>\s*[^>]+>(?<engine>[^\<]+)/',
         'kilometres' => '/Odometer<\/label>\s*[^>]+>(?<kilometres>[^\s*]+)/',
        'body_style' => '/Body Style<\/label>\s*[^>]+>(?<body_style>[^\<]+)/',
    ),
    'next_page_regx' => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results" >/',
    'images_regx' => '/<div class="lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
);

add_filter("filter_peakxcelerationcom_next_page", "filter_peakxcelerationcom_next_page", 10, 2);
add_filter("filter_peakxcelerationcom_field_images", "filter_peakxcelerationcom_field_images");

function filter_peakxcelerationcom_next_page($next, $current_page) {

    slecho($current_page);
    $next = explode('/', $next);
    $index = count($next) - 1;
    $next = ($next[$index]);
    $next++;
    $peg = "pg=" . $next;
    $prev = "pg=" . ($next - 1);
    $url = str_replace($prev, $peg, $current_page);

    return $url;
}

add_filter("filter_peakxcelerationcom_field_images", "filter_peakxcelerationcom_field_images");
function filter_peakxcelerationcom_field_images($im_urls)
{
    $retval = [];

    foreach($im_urls as $img)
    {
        $retval[] = str_replace(["&#x2F;","https://www.peakxceleration.com/"], ["/",""], $img);
    }

    return $retval;
}