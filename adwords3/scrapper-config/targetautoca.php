<?php
global $scrapper_configs;
$scrapper_configs["targetautoca"] = array( 
	 'entry_points' => array(
            'used' => 'https://www.targetauto.ca/inventory'
        ),
        'vdp_url_regex'     => '/\/[0-9]{4}-/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.mySlides img'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.prev'],
        
        'details_start_tag' => '<div id="target_top',
        'details_end_tag'   => '<footer',
        'details_spliter'   => '<div class="item',
        'data_capture_regx' => array(
            'url'           => '/thumbnail">\s*<a href="(?<url>[^"]+)/',
            'year' => '/text-left">\s*<p>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\<]+)/',
            'make' => '/text-left">\s*<p>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\<]+)/',
            'model' => '/text-left">\s*<p>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\<]+)/',
            'price'         => '/class="price">\$\s*(?<price>[0-9,]+)/',      
        ),
        'data_capture_regx_full' => array(        
            'year'          => '/Year:[^>]+>(?<year>[^<]+)/',
            'make'          => '/Make:[^>]+>(?<make>[^<]+)/',
            'model'         => '/Model:[^>]+>(?<model>[^<]+)/',
            'stock_number'  => '/Stock Number[^>]+>(?<stock_number>[^<]+)/',
            'vin'           => '/VIN[^>]+>(?<vin>[^<]+)/',
            'engine'        => '/Engine:\s*<span>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Colour[^>]+>(?<exterior_color>[^<]+)/',
            'kilometres'    => '/Odometers[^>]+>(?<kilometres>[^<]+)KM/', 
        ) ,
       // 'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/"mySlides">\s*[^>]+>\s*[^>]+>\s*<img src="(?<img_url>[^"]+)/'
    );



