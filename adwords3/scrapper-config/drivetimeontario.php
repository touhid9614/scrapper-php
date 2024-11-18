<?php
global $scrapper_configs;
 $scrapper_configs["drivetimeontario"] = array( 
	'entry_points' => array(
            'used'  => 'https://drivetimeontario.ca/vehicles/',
        ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.fit'],
        'picture_nexts'     => ['.carousel__button--next'],
        'picture_prevs'     => ['.carousel__button--previous'],
         'srp_page_regex'      => '/\/(?:new|used|certified)-cars/i',
        'details_start_tag' => '<article class="rule--top">',
        'details_end_tag'   => '<footer id="footer"',
        'details_spliter'   => '<div id="item-',
        
        //'must_not_contain_regx' => '/<img class="sold-banner" alt="Sold" [^>]+>/',
        
        'data_capture_regx' => array(
            'url'           => '/<a title=".*" href="(?<url>[^"]+)"/',
            'year'          => '/<a title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
            'make'          => '/<a title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
            'model'         => '/<a title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
            'title'          => '/<a title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
            'price'         => '/itemprop="price">\s*[^>]+>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/align--medium-left">[^>]+>(?<kilometres>[^<]+)/',
            'vin'           => '/VIN:[^>]+>[^>]+>(?<vin>[^<]+)/',
         ),
        'data_capture_regx_full' => array(
 
            'stock_number'  => '/Stock No:\s*(?<stock_number>[^<]+)/',
            'exterior_color'=> '/Exterior Colour[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<exterior_color>[^\&]+)/',
            'engine'        => '/Engine Type[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<engine>[^\&]+)/',
            'transmission'  => '/Transmission[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<transmission>[^\&]+)/',
           'interior_color'=> '/Interior Colour[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<interior_color>[^\&]+)/',
           'body_style'    => '/Body Style[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<body_style>[^\&]+)/',
            'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
            
        ),
        'next_page_regx'    => '/class="pagination__next"><a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<img class="js-lazy"\s*src="(?<img_url>[^"]+)"/'
    );
 
 
    add_filter('filter_drivetimeontario_field_url', 'filter_drivetimeontario_field_url');
    function filter_drivetimeontario_field_url($url)
    {
        slecho("URL:".$url);
        return $url;
    };