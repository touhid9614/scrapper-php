<?php
global $scrapper_configs;
 $scrapper_configs["curbie"] = array( 
	 'entry_points' => array(
            'used'  => 'https://www.curbie.ca/vehicles/',
        ),
        'vdp_url_regex'     => '/\/vehicles\/[0-9]*-[0-9]{4}-/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.swiper-wrapper .swiper-slide'],
        'picture_nexts'     => ['.container #vehicle-next'],
        'picture_prevs'     => ['.container #vehicle-prev'],
        
        'details_start_tag' => '<div class="container admin-controls">',
        'details_end_tag'   => '<p class="fine-print fine-print-standalone">',
        'details_spliter'   => '<div class="col-xs-12 col-md-6',
        
        //'must_not_contain_regx' => '/<img class="sold-banner" alt="Sold" [^>]+>/',
        
        'data_capture_regx' => array(
            'url'           => '/carousel-item active">\s*[^\/]+href="(?<url>[^"]+)">/',
            'year'          => '/column float-left">\s*<h4>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))</',
            'make'          => '/column float-left">\s*<h4>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))</',
            'model'         => '/column float-left">\s*<h4>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))</',
            'title'          => '/column float-left">\s*<h4>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))</',
            'price'         => '/column float-right">\s*<h3>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/column float-left">\s*<h4>[^>]+>\s*<p>(?<kilometres>[^<]+)/',
         ),
        'data_capture_regx_full' => array(
          //  'make'          => '/Make<\/dt>\s*<dd[^>]*>(?<make>[^<]+)/',
           // 'model'         => '/Model<\/dt>\s*<dd[^>]*>(?<model>[^<]+)/',
            'stock_number'  => '/Stock #:[^"]+[^>]+>(?<stock_number>[^<]+)/',
          //  'exterior_color'=> '/Body (Or Basic )?Color<\/dt>\s*<dd[^>]+>(?<exterior_color>[^<]+)/',
            'engine'        => '/ENGINE<\/h5>\s*<span>(?<engine>[^<]+)/',
            'transmission'  => '/TRANSMISSION<\/h5>\s*<span>(?<transmission>[^<]+)/',
         //   'interior_color'=> '/Interior (Or Basic )?Color<\/dt>\s*<dd[^>]+>(?<interior_color>[^<]+)/',
            'body_style'    => '/TYPE<\/h5>\s*<span>(?<body_style>[^<]+)/'
            
        ),
        //'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<img class="img-fluid" data-secondary-src="(?<img_url>[^"]+)/'
    );
 
 
    add_filter('filter_curbie_field_url', 'filter_curbie_field_url');
    function filter_curbie_field_url($url)
    {
        slecho("URL:".$url);
        return $url;
    }