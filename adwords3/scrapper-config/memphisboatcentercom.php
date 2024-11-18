<?php
global $scrapper_configs;
 $scrapper_configs["memphisboatcentercom"] = array( 
	 "entry_points" => array(
        'new' =>  'https://memphisboatcenter.com/Showroom/New-Boats',
        'used' => 'https://memphisboatcenter.com/Showroom/Used-Boat-Inventory'
    ),

    'vdp_url_regex' => '/\/Power-Boats-/i',
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['div.galleria-image.lazy > img'],
    'picture_nexts' => ['div.galleria-image-nav-right'],
    'picture_prevs' => ['div.galleria-image-nav-left'],

    'details_start_tag' => '<ul class="dx1-products default-list">',
    'details_end_tag' => '<!-- FORM LIST-->',
    'details_spliter' => 'See More Details',

    'data_capture_regx' => array(
        'url' => '/<header class="model-info col-sm-8">\s*<a href="(?<url>[^"]+)">/'
    ),
    'data_capture_regx_full' => array(
        'stock_number'  => '/Stock Number<\/span><\/div>\s*[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'price'         => '/<h3 class="price">(?<price>[^<]+)/',
        'year'          => '/Model Year<\/span><\/div>\s*[^>]+>[^>]+>(?<year>[^<]+)/',
        'make'          => '/Manufacturer<\/span><\/div>\s*[^>]+>[^>]+>(?<make>[^<]+)/',
        'model'         => '/Model<\/span><\/div>\s*[^>]+>[^>]+>(?<model>[^<]+)/',
        'kilometres'    => '/Range:<[^\s]+\s(?<kilometres>[^<]+)<\/div>/',
        'vin'           => '/HIN<\/span><\/div>\s*[^>]+>[^>]+>(?<vin>[^<]+)/',
        'body_style'    => '/Model Type<\/span><\/div>\s*[^>]+>[^>]+>(?<body_style>[^<]+)/',
        'exterior_color'=> '/Hull Material<\/span><\/div>\s*[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
    ),
    'images_regx'    => '/<div class="item"><a><img src="(?<img_url>[^"]+)"/',
    'next_page_regx' => '/page-link next[^"]+"[^"]+"(?<next>[^"]+)"/',
);

add_filter("filter_memphisboatcentercom_field_images", "filter_memphisboatcentercom_field_images",10,2);
function filter_memphisboatcentercom_field_images($im_urls,$car_data) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    

  foreach ($im_urls as $im_url) {
             $retval[] = str_replace(['\\'], [''], rawurldecode($im_url));
        }
     


       
    return $retval;
}