<?php

    global $scrapper_configs;

    $scrapper_configs['sunridgervs'] = array(
        'entry_points' => array(
            'new'   => 'http://www.sunridgervs.ca/new-rvs-for-sale?pagesize=8&page=1',
            'used'  => 'http://www.sunridgervs.ca/used-rvs-for-sale?pagesize=8&page=1'
        ),
        'vdp_url_regex'     => '/\/product\/(?:new|used)-/i',
        'ty_url_regex'      => '/\/contact-confirmation/i',
        'use-proxy'         => true,
        'refine'            => false,
        'details_start_tag' => '<div class="listingPagination listingToolbar">',
        'details_end_tag'   => 'class="listingPagination bottomPaging"',
        'details_spliter'   => "<li class='unit ",
        'data_capture_regx' => array(
            'stock_number'      => '/data-stocknumber="(?<stock_number>[^"]+)/',
            'url'               => '/data-unitlink="(?<url>[^"]+)/',
            'year'              => '/data-year="(?<year>[^"]+)/',
            'make'              => '/data-brand="(?<make>[^"]+)/',
            'model'             => '/data-unitname="(?<model>[^"]+)/',
            'price'             => '/data-saleOrRegularPrice="(?<price>[^"]+)/',
            'body_style'        => '/data-type="(?<body_style>[^"]+)/',
        ),
        'data_capture_regx_full' => array(
        ),
        'next_query_regx'   => '/<a href="#" class="next" title="Next Page" data-(?<param>page)="(?<value>[0-9]*)"/',
        'images_regx'       => '/<a title="Click to enlarge" href="(?<img_url>[^"]+)"/'
    );
    