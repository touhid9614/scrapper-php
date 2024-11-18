<?php
global $scrapper_configs;
	$scrapper_configs["adamsautosales"] = array(
        'entry_points' => array(
        'used' => 'https://adamsautosales.co/newandusedcars?pagesize=500&page=1',
    ),
    'vdp_url_regex' => '/\/vdp\//i',
    'srp_page_regex'      => '/\/newandusedcars/', 
    'refine'  => false,     
    // 'use-proxy' => true,
    'init_method' => 'GET',
    'next_method' => 'POST',

    'details_start_tag' => '<div id="vehicles"',
    'details_end_tag' => '<footer class',
    'details_spliter' => '<div class="row no-gutters invMainCell',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:<\/label>\s*(?<stock_number>[^\s*]+)/',
        'url' => '/class="vehicleTitleWrap[^>]+>\s*<a.*href="(?<url>[^"]+)"/',
        'year' => '/class="vehicleTitleWrap[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'make' => '/class="vehicleTitleWrap[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'model' => '/class="vehicleTitleWrap[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'price' => '/Internet[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/',
        'engine' => '/Engine:<\/label>\s*(?<engine>[^\s*]+)/',
        'vin' => '/VIN:<\/label>\s*(?<vin>[^\s*]+)/',
        'kilometres' => '/Mileage:<\/label>\s*(?<kilometres>[^\s*]+)/',
        'transmission' => '/Trans:<\/label>\s*(?<transmission>[^\s*]+)/',
        'exterior_color' => '/Color:<\/label>\s*(?<exterior_color>[^\s*]+)/',
        'interior_color' => '/Interior:<\/label>\s*(?<interior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'price' => "/Retail[^>]+>[^>]+>(?<price>[^<]+)<\/span/",
    ),
    //'next_query_regx' => '/dxp-num dxp-current">[^<]+<\/b><a class="dxp-num" onclick="__doPostBack\(&#39;ctl02\$ctl01\$ctl00\$ASPxPager(?:1|2)&#39;,+&#39;(?<param>PN)(?<value>[0-9]+)+/',
    'images_regx' => '/<img loading="auto" data-src=\'(?<img_url>[^\']+)\'/'
);

add_filter('filter_adamsautosales_field_url', 'filter_adamsautosales_field_url');
function filter_adamsautosales_field_url($url) {
    return trim($url);
}
