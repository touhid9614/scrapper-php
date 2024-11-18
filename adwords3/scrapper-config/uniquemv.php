<?php
global $scrapper_configs;
 $scrapper_configs["uniquemv"] = array( 
	 'entry_points' => array(
        'used' => 'https://uniquemv.com/inventory/',
    ),
    'vdp_url_regex' => '/\/listings\/[0-9]{4}-/i',
    'inpage_cont_match' => 'Your message has been sent',
    'use-proxy' => true,
    'picture_selectors' => ['.fancybox.fancybox_listing_link'],
    'picture_nexts' => ['.fancybox-nav.fancybox-next'],
    'picture_prevs' => ['.fancybox-nav.fancybox-prev'],
    'details_start_tag' => '<div class="content-wrap car_listings row">',
    'details_end_tag' => '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagination_container">',
    'details_spliter' => 'class="inventory clearfix margin-bottom-20',
    'data_capture_regx' => array(
        'url'    => '/<a class="inventory"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)/',
        'year'   => '/<a class="inventory"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)/',
        'make'   => '/<a class="inventory"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)/',
        'model'  => '/<a class="inventory"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)/',
        'price'  => '/Price\s*:<\/b><br>\s*[^>]+>(?<price>\$[0-9,]+)/',
        'body_style' => '/Body Style: <\/td>\s*<td class=\'spec\'>(?<body_style>[^<]+)/',
        'transmission' => '/Transmission: <\/td>\s*<td class=\'spec\'>(?<transmission>[^<]+)/',
        'vin'         => '/VIN Number: <\/td>[^>]+>(?<vin>[^<]+)/',
        'drivetrain' =>  '/Drivetrain: <\/td>[^>]+>(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Stock Number: <\/td><td>(?<stock_number>[^<]+)/',
        'kilometres' => '/Mileage: <\/td><td>(?<kilometres>[^<]+)/',
        'trim' => '/Trim: <\/td><td>(?<trim>[^<]+)/',
        'engine' => '/Engine: <\/td><td>(?<engine>[^<]+)/',
        'transmission' => '/Transmission: <\/td><td>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color: <\/td><td>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color: <\/td><td>(?<interior_color>[^<]+)/',
        'vin'            => '/Stock Number: <\/td><td>(?<vin>[^<]+)/',
    ),
    'next_page_regx' => '/class="current_page">(?<next>[^<]+)/',
    'images_regx' => '/data-full-image="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
);

add_filter("filter_uniquemv_next_page", "filter_uniquemv_next_page", 10, 2);

function filter_uniquemv_next_page($next, $current_page) {
    slecho("Filtering curr url:" . $current_page);
    slecho("Filtering next url:" . $next);

    $newstr = substr_replace($next, "page/", 46, 0);
    $newstr++;
    slecho("Filtering newstr url:" . $newstr);
    return $newstr;
}
