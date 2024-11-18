<?php
global $scrapper_configs;
$scrapper_configs["kingscrosshyundaica"] = array( 
	"entry_points" => array(
        'used' => 'https://www.kingscrosshyundai.ca/used/',
         'new' => 'https://www.kingscrosshyundai.ca/new/',
        
       
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'srp_page_regex'      => '/ca\/(?:new|used|certified)\//i',
    'refine' => false,
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12">',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\s*]+)/',
        'model' => '/itemprop=\'model\' notranslate>(?<model>[^<]+)/',
        'price' => '/<span itemprop="price"[^\>]+>(?<price>[^\<]+)<\/span><\/span>/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'drivetrain'    => '/itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/transmission:\s*\'(?<transmission>[^\']+)/',
        'stock_number' => '/Stock #:\s*(?<stock_number>[^<]+)/',
        'custom' => '/itemprop="description"[^>]+>(?<custom>[^<]+)/',
        'vin'   => '/\&vin=(?<vin>[^\&]+)/',
        'description'   => '/<meta name="description" content="(?<description>[^"]+)/',
        'interior_color'      => '/exterior_color:\s*\'(?<interior_color>[A-zA-z0-9^\s*]+)/',
        'exterior_color'    => '/exterior_color:\s*\'(?<exterior_color>[A-zA-z0-9^\s*]+)/',
        'fuel_type'           => '/Fuel type:[^>]+>[^>]+>\s*(?<fuel_type>[^<]+)/',
        'msrp' => '/itemprop="priceRange"\s*content="[^-]+-(?<msrp>[^"]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',
        'price' => '/itemprop="priceRange"\s*content="[^-]+-(?<price>[^"]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)"/'
);

add_filter("filter_kingscrosshyundaica_field_images", "filter_kingscrosshyundaica_field_images");

function filter_kingscrosshyundaica_field_images($im_urls) {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'new_vehicles_images_coming.png');
                                
    });
}
