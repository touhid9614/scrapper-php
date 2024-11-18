<?php
global $scrapper_configs;
 $scrapper_configs["rsmhondaonline"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.rsmhondaonline.com/new-vehicles/?pg=1',
        'used' => 'https://www.rsmhondaonline.com/used-vehicles/?pg=1'
    ),
    'vdp_url_regex' => '/\/vehicle\/(?:new|used)-[0-9]{4}-/i',
    'init_method' => 'GET',
    //'next_method' => 'POST',
    'picture_selectors' => ['.fancybox-thumbs ul li img'],
    'picture_nexts' => ['.fancybox-arrow--right'],
    'picture_prevs' => ['.fancybox-arrow--left'],
    'details_start_tag' => '<div class="result-wrapper srp-no-result-wrapper">',
    'details_end_tag' => '<div class="footer_bottom-light">',
    'details_spliter' => '<div class="listing col-xs-12',
    'data_capture_regx' => array(
        'stock_number' => '/Stock:[^>]+>\s*(?<stock_number>[^<]+)/',
        'title' => '/<div class="vehicle-info">\s*<a href="(?<url>[^"]+)">\s*<h2[^>]+>[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="vehicle-info">\s*<a href="(?<url>[^"]+)">\s*<h2[^>]+>[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/<div class="vehicle-info">\s*<a href="(?<url>[^"]+)">\s*<h2[^>]+>[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'model' => '/<div class="vehicle-info">\s*<a href="(?<url>[^"]+)">\s*<h2[^>]+>[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'price' => '/(?:Value Priced at|BUY TODAY FOR:)<\/p>\s*<p class="(?:buy-price|prices)[^>]+>(?<price>[^<]+)/',
        'engine' => '/Engine:[^>]+>\s*(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior:[^>]+>\s*(?<exterior_color>[^<]+)/',
          'url' => '/<div class="vehicle-info">\s*<a href="(?<url>[^"]+)">\s*<h2[^>]+>[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',  
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/<p class="transmission">\s*Transmission [^>]+>\s*(?<transmission>[^<]+)/',   
        'interior_color' => '/<p class="interior">\s*Interior[^>]+>\s*(?<interior_color>[^<]+)/',
    ),
     'next_query_regx'   => '/<a href="javascript: addURLVarAndReload\(\'(?<param>pg)\', \'(?<value>[0-9]*)\'[^"]">&raquo;/',
     'images_regx'       => '/<div class="slick-item">\s*<img src="(?<img_url>[^"]+)"\s*alt="/'
);

add_filter("filter_rsmhondaonline_field_images", "filter_rsmhondaonline_field_images");
function filter_rsmhondaonline_field_images($im_urls) {
    return array_filter($im_urls, function($img_url) {
        return !endsWith($img_url, "notfound.jpg");
    }
    );
}
