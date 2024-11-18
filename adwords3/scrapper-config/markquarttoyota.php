<?php
global $scrapper_configs;
 $scrapper_configs["markquarttoyota"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.markquarttoyota.com/searchnew.aspx',
        'used' => 'https://www.markquarttoyota.com/searchused.aspx'
    ),
//    'init_method' => 'GET',
//    'next_method' => 'POST',
    'vdp_url_regex' => '/\/(?:new|used)-[^-]*-[0-9]{4}-/i',
    'picture_selectors' => ['.img-responsive'],
    'picture_nexts' => ['.mfp-arrow-right.mfp-prevent-close'],
    'picture_prevs' => ['.mfp-arrow-left.mfp-prevent-close'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'year' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'make' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'model' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'trim' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'body_style' => '/class="[^"]+ ">\s*<li class="[^"]+"><strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)<\/li>\s*<li class="ext/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)<\/li>\s*<li class="drive/',
        'exterior_color' => '/Transmission:.*\s*<li class="extColor"><strong>Ext. Color: <\/strong>(?<exterior_color>[^<\/]+)/',
        'interior_color' => '/class="intColor"><strong>Int. Color: <\/strong>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'price' => '/class="pull-right primaryPrice">(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'trim' => '/var vehicleTrim="(?<trim>[^"]+)/',
        'make' => '/var vehicleMake="(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
        'vin' => '/VIN:\s(?<vin>[^<]+)/'
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
    'images_regx' => '/zoom feature element[^>]+>\s*<img src="(?<img_url>[^\?]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_markquarttoyota_field_images", "filter_markquarttoyota_field_images");
    
    function filter_markquarttoyota_field_images($im_urls)
    {
        if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }
    
    