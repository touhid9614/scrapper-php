<?php
global $scrapper_configs;
$scrapper_configs["excellence_peterbiltcom"] = array( 
	"entry_points" => array(
	    'all' => 'https://excellence-peterbilt.com/en/new-trucks/models-in-stock/',
    ),
    'vdp_url_regex' => '/\/en\/camions/i',  
    'use-proxy' => true,
    'picture_selectors' => ['.slide.cycle-slide'],
    'picture_nexts' => ['.sliderControl div.right'],
    'picture_prevs' => ['.sliderControl div.left'],
     'refine' => false,
    
    'details_start_tag' => '<div class="containerModeles">',
    'details_end_tag' => '<footer id="footer">',
    'details_spliter' => '<div class="row-fluid modele">',
    'data_capture_regx' => array(
        'url' => '/<div class="span3">\s*<a href="(?<url>[^"]+)"/',
        'stock_type'  => '/condition">\s*<strong>[^\s]+\s(?<stock_type>[^\s]+)/',
        'title' => '/<div class="span9">\s*<[^>]+>\s*<[^>]+>\s*<h4>\s*(?<title>(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'stock_number' => '/inventaire:\s*<\/strong>(?<stock_number>[^<]+)/',
        'vin' => '/inventaire:\s*<\/strong>(?<vin>[^<]+)/',
        'year' => '/Année:\s*<\/strong>(?<year>[0-9]{4})/',
        'make' => '/<div class="span9">\s*<[^>]+>\s*<[^>]+>\s*<h4>\s*(?<title>(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'model' => '/<div class="span9">\s*<[^>]+>\s*<[^>]+>\s*<h4>\s*(?<title>(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
       
        'engine' => '/Moteur:\s*<\/strong>(?<engine>[^<]+)/',
       
        'transmission' => '/Transmission:\s*<\/strong>(?<transmission>[^<]+)/',
        'exterior_color' => '/Couleur\s*:\s*<\/strong>(?<exterior_color>[^\s*<]+)/',
      
    ),
    'data_capture_regx_full' => array(
       'price' => '/Prix<\/td>\s*<td>(?<price>[^\s*]+)\s*\$\s*USD/',
    ),
    'next_page_regx' => '/<a href=\'(?<next>[^\']+)\'>&rs/',
    'images_regx' => '/<div class="slide">\s*<a href="(?<img_url>[^"]+)"/',
   
);
add_filter('filter_excellence_peterbiltcom_car_data', 'filter_excellence_peterbiltcom_car_data');
function filter_excellence_peterbiltcom_car_data($car_data) {
    
  $car_data['stock_type'] =strtolower($car_data['stock_type']);
    return $car_data;
}