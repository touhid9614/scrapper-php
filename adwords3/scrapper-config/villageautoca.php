<?php
global $scrapper_configs;
$scrapper_configs["villageautoca"] = array( 
	"entry_points" => array(

	    'used' => 'https://www.villageauto.ca/used/',
        
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'refine' => false,
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer wp"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12">',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
       'make' => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\s*]+)/',
        'model' => '/itemprop=\'model\' notranslate>(?<model>[^<]+)/',
        'price' => '/Approval Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'vin' => '/VIN:<\/td><td class="table-col-1">(?<vin>[^<]+)/',
        'drivetrain'    => '/itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)/',
       
    ),
    'data_capture_regx_full' => array(
       
      'interior_color'=> '/itemprop="vehicleInteriorColor" >\s*(?<interior_color>[^\s*]+)/',
      'fuel_type'     => '/itemprop="fuelType">\s*(?<fuel_type>[^\s*]+)/',
      'description'   => '/itemprop="description" notranslate>(?<description>[^<]+)<\/span><a id="readLess"/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)"/',
);
