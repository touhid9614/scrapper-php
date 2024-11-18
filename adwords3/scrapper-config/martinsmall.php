<?php
global $scrapper_configs;
 $scrapper_configs["martinsmall"] = array( 
	     'entry_points' => array(
	         'used'   => 'https://www.martinsmall.ca/search/inventory/usage/Used',
             'new'  => 'https://www.martinsmall.ca/search/inventory/usage/New',
           
        ),
        'use-proxy' => true,
        'refine'            => false,
        'vdp_url_regex' => '/\/inventory\/[0-9]{4}-/i',
         'picture_selectors' => ['.unit-image-container'],
         'picture_nexts' => ['.inventory-gallery-thumbs button.slick-next'],
         'picture_prevs' => ['.inventory-gallery-thumbs button.slick-prev'],
     
        'details_start_tag' => '<div class="search-results-list">',
        'details_end_tag'   => '<footer class="footer-b',
        'details_spliter'   => '<div class="panel panel-default search-result">',
        'data_capture_regx' => array(
        'stock_number'  => '/Stock #<\/strong>\s*.*\s*<td[^>]+>\s*(?<stock_number>[^<]+)/',
        'year' => '/data-model-year>(?<year>[0-9]{4})/',
        'make' => '/data-model-brand>(?<make>[^<]+)/',
        'model' => '/data-model-name>(?<model>[^<]+)/',
        'price' => '/itemprop="price">\s*(?<price>\$[0-9,]+)/',
        'body_style' => '/Style<\/strong>\s*.*\s*<td[^>]+>\s*(?<body_style>[^<]+)/',
        'exterior_color' => '/Color<\/strong>\s*.*\s*<td[^>]+>\s*(?<exterior_color>[^<]+)/',     
        'url' => '/<a href="(?<url>[^"]+)" .*>View Details/'
    ),
    'data_capture_regx_full' => array(
        'vin'           => '/VIN[^\=]*[^\>]*\>(?<vin>[^\<]+)/',
        'fuel_type'     => '/Fuel System[^>]*>[^>]*>(?<fuel_type>[^<]+)/',
        'engine'        => '/Engine Type[^>]*>[^>]*>(?<engine>[^<]+)/',
        'drivetrain'    => '/Engine Type[^>]*>[^>]*>(?<drivetrain>[^<]+)/',
        'description'   => '/name=\"description\"[^"]+\"(?<description>[^\"]+)/',
        'kilometres'    => '/strong\>Usage[^=]*[^>]*\>(?<kilometres>[^\<]+)/',

    ),
    'next_page_regx' => '/<li class="active">\s*<a href="[^"]+">[^\n]+\s*<\/li>\s*<li [^>]+>\s*<a href="(?<next>[^"]+)/',
    'images_regx' => '/<img data-highres="[^\?]+\?img=(?<img_url>[^\&]+)/',
   
);
 
 
 
add_filter("filter_martinsmall_field_images", "filter_martinsmall_field_images");

function filter_martinsmall_field_images($im_urls) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    foreach ($im_urls as $im_url) {
        $retval[] = str_replace(['http://www.martinsmall.ca/inventory/','%3a','%2f','+','http://www.martinsmall.ca/new-models/'],['',':','/',' ',''],$im_url);
    }
    //   slecho(implode('|', $retval));
    return $retval;
}

