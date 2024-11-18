<?php
global $scrapper_configs;
$scrapper_configs["integrity1motorscom"] = array( 
	   'entry_points' => array(
        'used' => 'https://www.integrity1motors.com/newandusedcars?pagesize=500&page=1',
    ),
    'vdp_url_regex' => '/(?:New|Used)-[0-9]{4}\-[^\-]+\-[^\/]+/i',
    'use-proxy' => true,
    'refine'=>false,
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.carousel-inner > .item'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'details_start_tag' => '<div class="inv-repeater',
    'details_end_tag' => '<footer class="footerWrapper">',
    'details_spliter' => '<div class="row no-gutters invMainCell">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:<\/label>\s*(?<stock_number>[^\s*]+)/',
        'url' => '/vehicleTitle[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'year' => '/vehicleTitle[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'make' => '/vehicleTitle[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'model' => '/vehicleTitle[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'price' => '/Internet Price[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/',
        'engine' => '/Engine:<\/label>\s*(?<engine>[^\s*]+)/',
        'vin' => '/VIN:<\/label>\s*(?<vin>[^\s*]+)/',
      //  'transmission' => '/Transmission">(?<transmission>[^\s*]+)/',
        'exterior_color' => '/Color:<\/label>\s*(?<exterior_color>[^\s*]+)/',
        'interior_color' => '/Interior:<\/label>\s*(?<interior_color>[^<]+)/',
        ),
    'data_capture_regx_full' => array(
        
    ),
    //'next_query_regx' => '/dxp-num dxp-current">[^<]+<\/b><a class="dxp-num" onclick="__doPostBack\(&#39;ctl02\$ctl01\$ctl00\$ASPxPager(?:1|2)&#39;,+&#39;(?<param>PN)(?<value>[0-9]+)+/',
    'images_regx' => '/<img loading="auto" data-src=\'(?<img_url>[^\']+)\'/',
      'images_fallback_regx' => '/<img loading="auto".*(?:src|data-src)="(?<img_url>[^\"]+)"/'
);
add_filter('filter_integrity1motorscom_field_url', 'filter_integrity1motorscom_field_url');
function filter_integrity1motorscom_field_url($url) {
    return trim($url);
}

