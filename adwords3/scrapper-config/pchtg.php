<?php
global $scrapper_configs;
$scrapper_configs["pchtg"] = array(
    "entry_points" => array(
        'used' => 'http://www.pchtg.ca/inventory.aspx?new=0',
        'new' => 'http://www.pchtg.ca/inventory.aspx?new=1',
    ),
    'vdp_url_regex' => '/\/specsheet.aspx\?ID=[0-9]*/i',
    'use-proxy' => true,

    'picture_selectors' => ['#photos #thumbs li a img'],

    'details_start_tag'    => '<table width="100%" border="0" class="invcont">',
    'details_end_tag'   => '<div id="marker-location">',
    'details_spliter'   => '<table id="truckTable" cellSpacing="0" cellpadding="0" width="100%" border="0" class="unittable">',

    'data_capture_regx' => array(
        'url'            => '/class="stdThumbsImageLink" href="(?<url>[^"]+)/',
    ),

    'data_capture_regx_full' => array(
        'year' => '/id="unitQuickSpecs_year">(?<year>[^<]+)/',
        'make' => '/id="unitQuickSpecs_make">(?<make>[^<]+)/',
        'model' => '/id="unitQuickSpecs_model">(?<model>[^<]+)/',
        'price' => '/id="unitQuickSpecs_price">(?<price>[^<]+)/',
        'engine' => '/<dt>Engine<\/dt>[^<]+<dd>(?<engine>[^<]+)/',
        'transmission' => '/<dt>Transmission<\/dt>[^<]+<dd>(?<transmission>[^<]+)/',
        'body_style'        => '/class="specname">Truck Type<\/td>[^<]+<td class="specval">(?<body_style>[^<]+)/',
        'exterior_color' => '/class="specname">Color<\/td>[^<]+<td class="specval">(?<exterior_color>[^<]+)/',
        'stock_number'   => '/class="specname">Serial No.<\/td>[^<]+<td class="specval">(?<stock_number>[^<]+)/',
    ),

    'next_page_regx'        => '/class="pagingNavLink" href="(?<next>[^">]+)">Next/',
    'images_regx'           => '/thisbigurl=\'(?<img_url>[^\']+)/',
    'images_fallback_regx'  => '/img id="photo" src="(?<img_url>[^"]+)/'
);

add_filter('filter_pchtg_field_url', 'filter_pchtg_field_url');
function filter_pchtg_field_url($url)
{
    $url = str_replace("specsheet.aspx","inventory/specsheet_res/",$url );
    slecho("URL:".$url);
    return $url;
}