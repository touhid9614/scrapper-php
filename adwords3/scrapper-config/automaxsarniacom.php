<?php
global $scrapper_configs;
$scrapper_configs["automaxsarniacom"] = array( 
	"entry_points" => array(

        'used' => 'https://www.automaxsarnia.com/all/',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'refine' => false,
    'srp_page_regex'      => '/com\/all\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer wp"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12">',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year'                => '/itemprop=\'releaseDate\'[^>]+>(?<year>[0-9]{4})/',
        'make'                => '/itemprop=\'manufacturer\'[^>]+>[^>]+>(?<make>[^\s*<]+)/',
        'model'               => '/itemprop=\'model\'[^>]+>[^>]+>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price"[^\>]+>(?<price>[^\<]+)/',
       // 'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
         'stock_number'   => '/Stock #:\s*(?<stock_number>[^<]+)/',
         'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
       
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)"/'
);
add_filter("filter_automaxsarniacom_field_images", "filter_automaxsarniacom_field_images");

function filter_automaxsarniacom_field_images($im_urls)
{
    if (count($im_urls) < 2) {
        return [];

    }

    return $im_urls;
}