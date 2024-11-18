<?php
global $scrapper_configs;
$scrapper_configs["starautomall512com"] = array( 
	'entry_points' => array(
        'used' => 'https://starautomall512.com/newandusedcars?pagesize=1000&page=1',
    ),
    'vdp_url_regex' => '/(?:New|Used)-[0-9]{4}\-[^\-]+\-[^\/]+/i',
    'use-proxy' => true,
    'refine'=>false,
    'init_method' => 'GET',
    'next_method' => 'POST',
   
    'picture_selectors' => ['.carousel-item img'],
    'picture_nexts' => ['.carousel-control-next-icon'],
    'picture_prevs' => ['.carousel-control-prev-icon'],
    
     'details_start_tag' => '<div class="inv-repeater update-vehicles',
    'details_end_tag' => '<footer id="Footer_wrap',
    'details_spliter' => '<div class="invMainCell row no-gutters',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:<\/label>\s*(?<stock_number>[^\s*]+)/',
        'url' => '/class="vehicleTitleWrap[^>]+>\s*<a.*href="(?<url>[^"]+)"/',
        'year' => '/class="vehicleTitleWrap[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'make' => '/class="vehicleTitleWrap[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'model' => '/class="vehicleTitleWrap[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'price' => '/class="lblPrice">(?<price>\$[0-9,]+)/',
        'engine' => '/Engine:<\/label>\s*(?<engine>[^\s*]+)/',
        'vin' => '/VIN:<\/label>\s*(?<vin>[^\s*]+)/',
        'transmission' => '/Trans:<\/label>\s*(?<transmission>[^\s*]+)/',
        'exterior_color' => '/Color:<\/label>\s*(?<exterior_color>[^\s*]+)/',
        'interior_color' => '/Interior:<\/label>\s*(?<interior_color>[^<]+)/',
        ),
    'data_capture_regx_full' => array(
        
    ),
    //'next_query_regx' => '/dxp-num dxp-current">[^<]+<\/b><a class="dxp-num" onclick="__doPostBack\(&#39;ctl02\$ctl01\$ctl00\$ASPxPager(?:1|2)&#39;,+&#39;(?<param>PN)(?<value>[0-9]+)+/',
    'images_regx' => '/<img loading="auto" data-src=\'(?<img_url>[^\']+)\'/'
);
add_filter('filter_starautomall512com_field_url', 'filter_starautomall512com_field_url');
function filter_starautomall512com_field_url($url) {
    return trim($url);
}

