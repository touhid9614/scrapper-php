<?php
global $scrapper_configs;
$scrapper_configs["brockvillenissancom"] = array( 
	"entry_points" => array(
	    'new' => 'https://www.brockvillenissan.com/new/inventory/search.html?filterid=q0-500',
        'used' => 'https://www.brockvillenissan.com/used/search.html?filterid=q0-500',
    ),     
    'vdp_url_regex' => '/\/(?:new|used|demos)\/.*[0-9]{4}-/i',
    'refine'=>false,
    'picture_selectors' => ['.slide a img'],
    'picture_nexts' => ['div a.next'],
    'picture_prevs' => ['div a.previous'],
        'details_start_tag' => '<div class="divSpan divSpan12 lstListingWrapper">',
        'details_end_tag' => '<div id="footer',
        'details_spliter' => '<div class="divSpan divSpan12 carBoxInner',
        'data_capture_regx' => array(
            'url' => '/<div class="carBasics flex-between">\s*<a\s*[^"]+"(?<url>[^"]+)/',
            //'title' => '/<div class="divSpan divSpan12 carBasics">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
            'year' => '/class=\'divModelYear[^>]+>(?<year>[^\s*]+)\s*(?<model>[^<]+)/',
            'make' => '/class=\'divMake[^>]+>(?<make>[^<]+)/',
            'model' => '/class=\'divModelYear[^>]+>(?<year>[^\s*]+)\s*(?<model>[^<]+)/',
            'kilometres' => '/class=\'divSpan divSpan12 carDescription elIsLoadable\'><span [^>]+><span [^>]+>(?<kilometres>[0-9 ,]+)\s*KM/',
            'price' => '/carPrice elIsLoadable[^>]+>[^>]+>(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
        	//'price' => '/Your price:[^>]+>\s*[^>]+>(?<price>[^<]+)/',
            'stock_number' => '/specsNoStock\'>Stock #:\s(?<stock_number>[^\-]+)/',
             //'stock_type' => '/name="status" value="(?<stock_type>[^"]+)/',
            'kilometres' => '/specsKM\'>Kilometers:\s(?<kilometres>[0-9 ,]+)/',
            'engine' => '/specsEngine\'>Engine:\s(?<engine>[^<]+)/',
            'transmission' => '/specsTransmission\'>Transmission:\s(?<transmission>[^<]+)/',
            'exterior_color' => '/specsTransmission\'>Transmission:\s(?<exterior_color>[^<]+)/',
            'body_style' => '/specsBodyType\'>Category:\s(?<body_style>[^<]+)/',
           // 'vin'           => '/specsNoStock\'>Stock #:\s(?<vin>[^<]+)/',
        ),
         
   
    'images_regx' => '/<a rel="slider-lightbox[^"]+"\shref="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta  property="og:image" content="(?<img_url>[^"]+)/'
);
