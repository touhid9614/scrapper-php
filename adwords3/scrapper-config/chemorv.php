<?php

    global $scrapper_configs;

    $chemorv_makes = array(
        'Adventurer',
        'Arctic Fox',
        'Arctic Fox Classic',
        'Arctic Fox Silver Fox Edition',
        'Avenger ATI',
        'Avenger Touring Edition',
        'Coachmen Catalina SBX',
        'Coachmen Catalina',
        'Crusader',
        'Fury',
        'Lacrosse Touring Edition',
        'Nash',
        'Sanibel',
        'Spartan',
        'Tracer',
        'Tracer Air',
        'Wolf Creek'
    );
    
    $chemorv_makes_inline = implode('|', $chemorv_makes);
    
    $scrapper_configs['chemorv'] = array(
        'entry_points' => array(
            'new'   => 'http://chemorv.ca/new',
            'used'  => 'http://chemorv.ca/pre-owned'
        ),
        'refine'    => false,
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/(?:new|pre-owned)\/item\?/i',
        'inpage_cont_match' => 'Thank You!',
        'ajax_url_match'    => '/item?',
        'ajax_resp_match'   => '"status":"ok"',
        'vdp_page_regex'    => '/\/(?:new|pre-owned)\/item\?/i',
        'required_params'   => array('rv'),
        'details_start_tag' => 'id="rv_content"',
        'details_end_tag'   => '<div class="pagination">',
        'details_spliter'   => '<div class="rv-prod">',
        'data_capture_regx' => array(
            'stock_number'  => '/<div class="stock-num">Stock #:\s*(?<stock_number>[^,<]+)/',
            'url'           => '/<div class="rv-name"><a href="(?<url>[^"]+)">/',
            'year'          => '/<div class="rv-yr">Year:\s*(?<year>[0-9]{4})/',
            'make'          => '/<div class="rv-name"><a href="(?<url>[^"]+)">(?<make>(?:' . $chemorv_makes_inline . ')) (?<model>[^<]+)/',
            'model'         => '/<div class="rv-name"><a href="(?<url>[^"]+)">(?<make>(?:' . $chemorv_makes_inline . ')) (?<model>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'price'         => '/<div class="rv-price">(?<price>[0-9,\$]+)/'
        ),
        'next_page_regx'    => '/<a class="paging" href="(?<next>[^"]+)">Next/',
        'images_regx'       => '/<a rel="rv_photo" href="(?<img_url>[^"]+)"/'
    );
    