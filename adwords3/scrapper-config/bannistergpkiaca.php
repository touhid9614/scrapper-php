<?php
global $scrapper_configs;
$scrapper_configs["bannistergpkiaca"] = array( 
	'entry_points'           => array(
        'used' => 'https://www.bannistergpkia.ca/used/',
        'new'  => 'https://www.bannistergpkia.ca/new/',
    ),
    'vdp_url_regex'          => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.glyphicon-chevron-right'],
    'picture_prevs'          => ['.glyphicon-chevron-left'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer',
    'details_spliter'        => '<!-- vehicle-list-cell -->',
    'must_not_contain_regex' => '/This vehicle is located offsite at one of our Bannis/',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span\s*style=\'/',
        'year'           => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make'           => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model'          => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres'     => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain'     => '/"driveTrain":"(?<drivetrain>[^"]+)/'
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin'            => '/\&vin=(?<vin>[^\&]+)/',
        'fuel_type'      => '/itemprop="fuelType">(?<fuel_type>[^<]+)/',
        'description'    => '/name="description" content="(?<description>[^"]+)/',
        'custom'         => '/Location Alert:\s*<\/strong>(?<custom>[^o]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',
         'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx'         => '/rel="next"\shref="(?<next>[^"]+)"/',
    'images_regx'            => '/imgError\(this\)\;"\s*(?:data-|)src="(?<img_url>[^"]+)/'
);

add_filter("filter_bannistergpkiaca_field_images", "filter_bannistergpkiaca_field_images");
function filter_bannistergpkiaca_field_images($im_urls)
{
    return array_filter($im_urls, function ($im_url) {
        if (endsWith($im_url, 'no_image-640x480.jpg')) {
            return false;
        } else if (endsWith($im_url, 'new_vehicles_images_coming.png')) {
            return false;
        }
        return true;
    });
}

