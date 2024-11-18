<?php

    global $scrapper_configs;

    $scrapper_configs['westcoast_autogroup'] = array (
        'entry_points'  => array(
            'used' => 'https://westcoast-autogroup.com/inventory',
        ),
        'vdp_url_regex'     => '/\/[^\/]+\/[0-9]{4}-/i',
        'use-proxy'         => true,
        'picture_selectors' => ['#gallery-1 .gallery-item'],
        'picture_nexts'     => ['#TB_next'],
        'picture_prevs'     => ['#TB_prev'],
        
        'details_start_tag' => '<div id="middle-contents"',
        'details_end_tag'   => '<div id="footer">',
        'details_spliter'   => '<div class="post-meta">',
        
        'data_capture_regx' => [
            'url'           => '/property="dc:title" resource="(?<url>[^"]+)/',
            'title'         => '/property="dc:title" resource="(?<url>[^"]+)">(?<title>[^\|]+)/',
            'year'          => '/Year<\/strong>:\s*(?<year>[0-9]{4})/',
            'make'          => '/property="dc:title" resource="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s\|]*)(?<trim>\s*[^\|,]*)?/',
            'model'         => '/property="dc:title" resource="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s\|]*)(?<trim>\s*[^\|,]*)?/',
            'trim'          => '/property="dc:title" resource="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s\|]*)(?<trim>\s*[^\|,]*)?/',
            'price'         => '/Price<\/strong>:\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage<\/strong>:\s*(?<kilometres>[^<]+)/',
            'stock_number'  => '/Stock<\/strong>:\s*(?<stock_number>[^<]+)/',
            'engine'        => '/Engine<\/strong>:\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission<\/strong>:\s*(?<transmission>[^<]+)/',
            'exterior_color'=> '/Color<\/strong>:\s*(?<exterior_color>[^<]+)/',
        ],    
        'data_capture_regx_full' => [
            
        ],
        'next_page_regx'    => '/<li><span .* class=\'page-numbers current\'>[^\n]+\s*<li><a class=\'[^\']+\' href=\'(?<next>[^\']+)\'/',
        'images_regx'       => '/<img data-image-id=\'[^\']+\'\s*[^\n]+\s*[^\n]+\s*src="(?<img_url>[^"]+)/',
      //  'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );