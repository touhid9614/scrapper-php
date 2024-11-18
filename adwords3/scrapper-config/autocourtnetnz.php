<?php
global $scrapper_configs;
$scrapper_configs["autocourtnetnz"] = array( 
     'entry_points'      => array(

        'used' => 'https://www.autocourt.net.nz/vehicles.aspx',
    ),
    'vdp_url_regex' => '/\/vehicle/i',
    'required_params'   => ['stockno'],
    'use-proxy' => true,
    'picture_selectors' => ['#vehicle-photos div ul li'],
    'picture_nexts' => ['.gallery-counter .icon-arrow-right'],
    'picture_prevs' => ['.gallery-counter .icon-arrow-left'],
    
    'details_start_tag' => '<table class="vehicle-results list',
    'details_end_tag' => '<div id="footer"',
    'details_spliter' => 'class="vehicle-results-cell last-cell">',
    'data_capture_regx' => array(
        'url' => '/<h3>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<year>[^\s*]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'year' => '/<h3>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<year>[^\s*]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'make' => '/<h3>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<year>[^\s*]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'model' => '/<h3>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<year>[^\s*]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'price' => '/<p class="price">\s*<[^>]+>(?<price>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
         'stock_number' => '/Vehicle ID:\s*#(?<stock_number>[^<]+)/',
         'vin' => '/Vehicle ID:\s*#(?<vin>[^<]+)/',
    	 'exterior_color' => '/Ext Colour\s*<\/td>\s*<[^>]+>\s*(?<exterior_color>[^<]+)/',
    	 'transmission' => '/Transmission\s*<\/td>\s*<[^>]+>\s*(?<transmission>[^\s*]+)/',
    	 'engine' => '/Engine\s*[^>]+>\s*<[^>]+>\s*(?<engine>[^<]+)/',
    	 'kilometres' => '/Odometer\s*<\/td>\s*<[^>]+>\s*(?<kilometres>[^&]+)/',
    	 'title' => '/<div id="vehicle-title">\s*<[^>]+>\s*<h1>\s*(?<title>[^\n]+)/',
    ),
    'next_page_regx' => '/<td>\s*<a href="(?<next>[^"]+)"\s*class=[^>]+>Next<\/a>/',
     'images_regx' => '/<li><a href="(?<img_url>[^"]+)" rel="lightbox-photos">/'
   // 'images_regx' => '/<div id="carousel">\s*<ul>\s*<li><a href="(?<img_url>[^"]+)/'
);

add_filter("filter_autocourtnetnz_field_images", "filter_autocourtnetnz_field_images");
function filter_autocourtnetnz_field_images($im_urls)
{
    $new_im_urls = [];
    $url_base = "https://www.autocourt.net.nz";
    foreach ($im_urls as $im_url)
    {
        $new_im_url = preg_replace("/https:\/\/www.autocourt.net.nz\/vehicle\/[^\/]+/", $url_base, $im_url);
        array_push($new_im_urls, $new_im_url);
    }
    return $new_im_urls;
}