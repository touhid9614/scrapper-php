<?php
global $scrapper_configs;
 $scrapper_configs["buddygreggcom"] = array( 
	'entry_points' => array(
           'used'  => 'https://www.buddygregg.com/used-rvs-for-sale?pagesize=24',
            'new'   => 'https://www.buddygregg.com/new-rvs-for-sale?pagesize=72',
           
        ),
        'vdp_url_regex'     => '/\/product\/(?:new|used)-/i',
        'ty_url_regex'      => '/\/contact-confirmation/i',
        'use-proxy'         => true,
        'refine'            => false,
     
        'picture_selectors' => ['#main > div > div.row > div.col-md-7 > div.detailMedia > div.detail-thumbnail-wrapper.hidden-xs > div > div > img'],
        'picture_nexts'     => ['.sliderNext'],
        'picture_prevs'     => ['.sliderPrev'],
     
        'details_start_tag' => '<div class="listingPagination listingToolbar">',
        'details_end_tag'   => '<div class="listingPagination bottomPaging',
        'details_spliter'   => "<li class='unit",
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
            'vin'               => '/data-dv-vin="(?<vin>[^"]+)/',
            'exterior_color'    => '/Exterior Color:\s(?<exterior_color>[^<]+)/',
        ),
        'next_query_regx'   => '/<a href="#" class="next" title="Next Page" data-(?<param>page)="(?<value>[0-9]*)"/',
        'images_regx'       => '/<img llsrc="(?<img_url>[^"]+)"/'
    );

