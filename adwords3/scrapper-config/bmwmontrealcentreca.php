<?php
global $scrapper_configs;
$scrapper_configs["bmwmontrealcentreca"] = array( 
	"entry_points" => array(

        'new' => 'https://www.bmwmontrealcentre.ca/new/inventory/search.html?utm_source=smedia&utm_campaign=organic&filterid=q0-500',
      'used' => 'https://www.bmwmontrealcentre.ca/used/search.html?utm_source=smedia&utm_campaign=organic&filterid=q0-500',  
    ),
        
    'vdp_url_regex' => '/\/(?:new|used|occasion|neufs)\/.*[0-9]{4}-/i',
    'refine'=>false,
    'picture_selectors' => ['.slide a img'],
    'picture_nexts' => ['div a.next'],
    'picture_prevs' => ['div a.previous'],
        'details_start_tag' => '<div class="divSpan divSpan12 lstListingWrapper">',
        'details_end_tag' => '<div id="footer"',
        'details_spliter' => '<li class="carBoxWrapper"',
        'data_capture_regx' => array(
            'url' => '/<div class="carBasics flex-between">\s*<a\s*[^"]+"(?<url>[^"]+)/',     
            'year' => '/<span class=\'divModelYear\'>(?<year>[0-9]{4})\s*(?<model>[^<]+)/',
            'make' => '/<span class=\'divMake\'>(?<make>[^\s]+)/',
            'model' => '/<span class=\'divModelYear\'>(?<year>[0-9]{4})\s*(?<model>[^<]+)/',         
            'kilometres' => '/s-km\'>(?<kilometres>[0-9 ,]+)/',
        ),
        'data_capture_regx_full' => array(
        	'price' => '/Your price:[^>]+>\s*[^>]+>\s*(?<price>[^<]+)/',
            'stock_number' => '/specsNoStock\'>Stock #:\s(?<stock_number>[^<]+)/',
            'vin' => '/id=\'specsVin\'>VIN:(?<vin>[^<]+)/',
            'kilometres' => '/specsKM\'>Kilometers:\s(?<kilometres>[0-9 ,]+)/',
            'engine' => '/specsEngine\'>Engine:\s(?<engine>[^<]+)/',
            'transmission' => '/specsTransmission\'>Transmission:\s(?<transmission>[^<]+)/',
            'exterior_color' => '/specsTransmission\'>Transmission:\s(?<exterior_color>[^<]+)/',
            'body_style' => '/specsBodyType\'>Category:\s(?<body_style>[^<]+)/',
           
        ),
         
   
    'images_regx' => '/<a rel="slider-lightbox[^"]+"\shref="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image"content="(?<img_url>[^"]+)/'
);

