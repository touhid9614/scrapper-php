<?php

global $scrapper_configs;

$scrapper_configs['centralplainscoop'] = array(
    'entry_points' => array(
        'used' => 'https://www.centralplainsco-op.crs/sites/centralplains/local',
    ),
    'no_scrap' => true,
//    'vdp_url_regex' => '/\/local/detail\//i',
//    'picture_selectors' => ['.hero-image img'],
//    'details_start_tag' => '<div class="grid-outer">',
//    'details_end_tag' => '<div class="footer-container">',
//    'details_spliter' => '<div class="grid-item col-12 col-sm-6 col-md-4">',
//    'data_capture_regx' => array(
//        'url' => '/<a href="(?<url>[^"]+)">\s*<div class="grid-thumbnail">/',
//        'title' => '/class="grid-title fsize12 fsize-md-20 fw-600 black text-uppercase">\s*(?<title>[^<\n]+)/',
//    ),
//    'data_capture_regx_full' => array(
//    ),
//    'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*title="Link to next page"/',
//    'images_regx' => '/<div class="hero-image"><img src="(?<img_url>[^"]+)"/',
);