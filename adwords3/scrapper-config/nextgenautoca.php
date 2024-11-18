<?php
global $scrapper_configs;
$scrapper_configs["nextgenautoca"] = array( 
	"entry_points" => array(
	    'used' => 'https://www.nextgenauto.ca/inventory',
        ),
        'vdp_url_regex'     => '/\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.flexslider .slides > li'],
        'picture_nexts'     => ['.flex-next'],
        'picture_prevs'     => ['.flex-prev'],
       'srp_page_regex'     => '/\/inventory/i',

        'details_start_tag' => '<div class="col-md-9 col-sm-12 mb20 new-cont">',
        'details_end_tag'   => '<div class="footer">',
        'details_spliter'   => '<div class="vehicle-listing"',
        'data_capture_regx' => array(
            'url'           => '/class="eziVehicleName"> \s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^\s*]*)/',
            'title'         => '/class="eziVehicleName"> \s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^\s*]*)/',
            'year'          => '/class="eziVehicleName"> \s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^\s*]*)/',
            'make'          => '/class="eziVehicleName"> \s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^\s*]*)/',
            'model'         => '/class="eziVehicleName"> \s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^\s*]*)/',
            'price'         => '/<span class="eziPriceValue">\s*(?<price>[^\s*]+)/',
            'kilometres'    => '/Miles\s*<\/strong>\s*<span>\s*(?<kilometres>[^\s]+)/',
            'stock_number'  => '/Stock#\s*<\/strong>\s*<span>\s*(?<stock_number>[^<]+)/',
             'exterior_color'=> '/Exterior\s*<\/strong>\s*<span>\s*(?<exterior_color>[^<]+)/',
            'engine'        => '/Engine\s*<\/strong>\s*<span>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission\s*<\/strong>\s*<span>\s*(?<transmission>[^<]+)/',
           
        ),
        'data_capture_regx_full' => array(        

        ) ,
        'next_page_regx'    => '/<li class="next"><a href="(?<next>[^&]+)/',
        'images_regx'       => '/<div class="head-text">\s*<img src="(?<img_url>[^"]+)/'
    );
//for coming soon images//
add_filter("filter_nextgenautoca_field_images", "filter_nextgenautoca_field_images");
    
    function filter_nextgenautoca_field_images($im_urls)
    {
       if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }