<?php

    global $scrapper_configs;

    $scrapper_configs['northwestpreownedcenter'] = array(
        'entry_points' => array(
            'used' => 'https://www.northwestpreownedcenter.com/used-cars.aspx?limit=100'
        ),
        'vdp_url_regex'     => '/\/details-[0-9]{4}-/i',
        
        'refine' => false,
        'use-proxy' => true,
        'picture_selectors' => ['.swiper-slide'],
        'picture_nexts'     => ['#viewer-next-button'],
        'picture_prevs'     => ['#viewer-prev-button'],
        
        'details_start_tag' => '<div id="srp-vehicle-list">',
        'details_end_tag'   => '<div id="disclaimer"',
        'details_spliter'   => 'class="ml-0 ml-lg-5 pt-4 pb-2 border-bottom">',
        // 'must_not_contain_regx' => '/<h4 class="body-font inline-block nomargin">Sold</h4>/',
        'data_capture_regx' => array(
            'url'           => '/<h2 class="ebiz-vdp-title[^>]+><a href="(?<url>[^"]+)"\s*aria-label="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^-]+))/',
            'title'         => '/<h2 class="ebiz-vdp-title[^>]+><a href="(?<url>[^"]+)"\s*aria-label="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^-]+))/',
            'year'          => '/<h2 class="ebiz-vdp-title[^>]+><a href="(?<url>[^"]+)"\s*aria-label="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^-]+))/',
            'make'          => '/<h2 class="ebiz-vdp-title[^>]+><a href="(?<url>[^"]+)"\s*aria-label="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^-]+))/',
            'model'         => '/<h2 class="ebiz-vdp-title[^>]+><a href="(?<url>[^"]+)"\s*aria-label="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^-]+))/',
            'price'         => '/INTERNET SALE PRICE[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>[^<]+)/',
            'kilometres'    => '/Miles:<\/strong>\s*(?<kilometres>[^<]+)/',
            'stock_number'  => '/Stock #:<\/strong>\s*(?<stock_number>[^<]+)/',
            'engine'        => '/Engine:<\/strong>\s*(?<engine>[^\s<]+)/',
            'transmission'  => '/Transmission:<\/strong>\s*(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/strong>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/strong>\s*(?<interior_color>[^<]+)/',
            'body_style'=> '/ebiz-vdp-subtitle">(?<body_style>[^<]+)/'
        ),
        'data_capture_regx_full' => array(        
        ) ,
        'next_page_regx' => '/<li class="active[^<]+<[^<]+<[^<]+<a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/<img src="(?<img_url>[^"]+)"\s*class/',
        'images_fallback_regx' => '/og:image" content="(?<img_url>[^"]+)"/'
    );
add_filter("filter_northwestpreownedcenter_next_page", "filter_northwestpreownedcenter_next_page", 10, 2);

function filter_northwestpreownedcenter_next_page($next_page) {
    slecho("Filtering Next url");
    return str_replace('&amp;', '&', $next_page);
}

    add_filter("filter_northwestpreownedcenter_field_images", "filter_northwestpreownedcenter_field_images");
    
     function filter_northwestpreownedcenter_field_images($im_urls)
     {
           if(count($im_urls)<4)
            {
            return [];
            
            }
       else{
         return $im_urls;
  
        }
     }

