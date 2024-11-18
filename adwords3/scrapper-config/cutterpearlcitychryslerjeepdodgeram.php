<?php
global $scrapper_configs;
 $scrapper_configs["cutterpearlcitychryslerjeepdodgeram"] = array( 
	'entry_points' => array(
            'new'  => 'https://www.cutterpearlcitychryslerjeepdodgeram.com/new-cars-for-sale',
            'used' => 'https://www.cutterpearlcitychryslerjeepdodgeram.com/used-cars-for-sale',
           
        ),
        'vdp_url_regex'     => '/vehicle-details\/(?:new|used|certified)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.magic-thumbs ul li','.slick-slide',],
        'picture_nexts'     => ['.mz-button.mz-button-next'],
        'picture_prevs'     => ['.mz-button.mz-button-prev'],
    
        'details_start_tag' => '<div class="srp-vehicle-container" >',
        'details_end_tag'   => '<div class="footer">',
        'details_spliter'   => '<div class="row srp-vehicle" itemprop="offers"',
        'data_capture_regx' => array(
              'url'           => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
            'title'         => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'year'          => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'make'          => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'model'         => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'stock_number'  => '/Stock:<\/span>\s*(?<stock_number>[^<]+)/',
            'price'         => '/(?:Sale Price:|MSRP)[^\$]+\$<\/span><span itemprop=\'price\' content=\'(?<price>[0-9]+)/',
            'exterior_color'=> '/Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
            'engine'        => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
            'kilometres'    => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/'
        ),
        'data_capture_regx_full' => array(        
          /*  'make'          => '@make\: \'(?<make>[^\']+)\'@',
            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
            'trim' => '@"trim": "(?<trim>[^"]+)@'*/
        ) ,
        'next_page_regx'    => '/current\'><a[^>]+>[0-9]<\/a><\/li><li><a href=\'(?<next>[^\']+)/',
        'images_regx'       => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
    );

add_filter("filter_cutterpearlcitychryslerjeepdodgeram_next_page", "filter_cutterpearlcitychryslerjeepdodgeram_next_page", 10, 2);

function filter_cutterpearlcitychryslerjeepdodgeram_next_page($next_page_regex)
{
	slecho("Filtering Next url");
	 return str_replace('inventory', '',  $next_page_regex);
	 
}
