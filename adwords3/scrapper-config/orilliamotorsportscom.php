<?php
global $scrapper_configs;
$scrapper_configs["orilliamotorsportscom"] = array(
	'entry_points' => array(
		
                'used'  =>'https://orilliamotorsports.com/Pre-Owned/',
                'new'   => 'https://orilliamotorsports.com/New-inventory/',
	),
	'vdp_url_regex'     => '/\/[A-Z][a-z]+-/i',
	'use-proxy' => true,
    'refine' => false,
	'details_start_tag' => '<div id="products" class="view-group">',
	'details_end_tag'   => '<!-- End Model Row -->',
	'details_spliter'   => '<div class="item col-xs-4 col-lg-4',

	'picture_selectors' => ['.lSSlideWrapper.usingCss'],
	'picture_nexts' => ['.lSnext'],
	'picture_prevs' => ['.lSPrev'],

	'data_capture_regx' => array(
		'stock_number'  => '/Id: <\/strong><span>\s*(?<stock_number>[^<]+)/',
		'year'          => '/model-title-link[^"]+" href="(?<url>[^"]+)">(?<year>[0-9^\s*]+)(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
		'make'          => '/model-title-link[^"]+" href="(?<url>[^"]+)">(?<year>[0-9^\s*]+)(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
		'model'         => '/model-title-link[^"]+" href="(?<url>[^"]+)">(?<year>[0-9^\s*]+)(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
		'price'         => '/class="price">[^>]+>[^>]+>\$\s*(?<price>[^\s*]+)/',
		'kilometres'    => '/Km: <\/strong><span>\s*(?<kilometres>[0-9,^<]+)/',
		'url'           => '/model-title-link[^"]+" href="(?<url>[^"]+)">(?<year>[0-9^\s*]+)(?<make>[^\s*]+)\s*(?<model>[^<]+)/'
	),
	'data_capture_regx_full' => array(
		'vin'           => '/Vin\s*<\/div>[^>]+>\s*(?<vin>[^\s<]+)/',
		'exterior_color' => '/Color\s*<\/div>[^>]+>\s*(?<exterior_color>[^\s<]+)/'
	),
	'next_query_regx'   => '/(?<param>page)\/(?<value>[0-9]*)\/" onclick="[^>]+>Next/',
	'images_regx'       => '/<li data-src="(?<img_url>[^"]+)"/'
);

add_filter("filter_orilliamotorsportscom_field_images", "filter_orilliamotorsportscom_field_images",10,2);
function filter_orilliamotorsportscom_field_images($im_urls,$car_data) {
    $retval = array();

    $ignore="https://orilliamotorsports.com";

  slecho($ignore);
    
    foreach ($im_urls as $im_url) {
           $retval[] = str_replace([$ignore,], ['https://www.equipmentsearch.com',], rawurldecode($im_url));
        }
     
    return $retval;
}

