<?php
    global $scrapper_configs;

    $scrapper_configs['garbershonda'] = array(
        'entry_points' => array(
            'all'   => 'http://garbershonda.com/search-results/?lang=#headeranchor',
            
        ),
        'vdp_url_regex'     => '/\/listing\/[0-9]{4}-/i',
       // 'ty_url_regex'      => '/\/eprice-[^\?]+\?.*form-action=success/i',
        'use-proxy' => true,
        'refine'    => false,
        'picture_selectors' => ['#carousel li'],
        'picture_nexts'     => ['.flex-next'],
        'picture_prevs'     => ['.flex-prev'],
        'details_start_tag' => '<div class="twelve columns omega">',
        'details_end_tag'   => '<div class="sixteen columns outercontainer" id="footer">',
        'details_spliter'   => '<div class="four columns listingblockgrid listingblock">',
        'must_not_contain_regx' => '/<div class="banner"[^>]+>\s*Sold, Sold\s*<\/div>/',
        'data_capture_regx' => array(
           
            'url'           => '/href="(?<url>[^"]+)">\s*Details/',
            'title'         => '/<h4 class="address">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'year'          => '/<h4 class="address">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'make'          => '/<h4 class="address">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'model'         => '/<h4 class="address">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'price'         => '/<p class="price">\s*(?<price>[^<]+)/',
            'kilometres'    => '/(?<kilometres>[^\s]+) Miles/',
            
        ),
        'data_capture_regx_full' => array(
            'stock_type'    =>'/New / Pre-Owned:(?<stock_type>[^<]+)/',
            'transmission'  => '/Trans:\s*(?<transmission>[^<]+)/',
            'body_style'    => '/Body Type:\s*(?<body_style>[^<]+)/',
            'exterior_color'=> '/Ext color:\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int color:\s*(?<interior_color>[^<]+)/'
        ),
        'next_page_regx'    => '/<a class="[^"]+" rel="next" href="(?<next>[^"]+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"[^>]*><img/'
    );
    