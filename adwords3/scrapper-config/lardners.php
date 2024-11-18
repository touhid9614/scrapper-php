<?php

    global $scrapper_configs;

    $scrapper_configs['lardners'] = array(
        'entry_points' => array(
            'new'   => 'http://www.lardners.com/new-rvs/all-inventory/',
            'used'  => 'http://www.lardners.com/used/all-inventory/'
        ),
        'vdp_url_regex'     => '/\/inventory\/(?:new|preowned)\/[0-9]{4}-/i',
        'ajax_url_match'    => 'tools/packages/dealerxchange/collector',
        'refine'    => false,
        'use-proxy' => true,
        'picture_selectors' => ['.bx-wrapper img'],
        'picture_nexts'     => ['.bx-next'],
        'picture_prevs'     => ['.bx-prev'],
        'details_start_tag' => 'id="car_list">',
        'details_end_tag'   => '<div id="request-info" class="popup-form mfp-hide">',
        'details_spliter'   => '<div class="vehicle">',
        'must_contain_regx' => '/<div class="current-price">((?!SOLD).)*<\/div>/',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:<\/div>\s*<div class="value">(?<stock_number>[^<]+)/',
            'url'           => '/<h3 class="vehicle-name">\s*<a href="(?<url>[^"]+)"[^>]*>(?<year>[0-9]{4}) (?<make>[^<]+)(?:<br\s*\/>(?<model>[^<]+))/',
            'year'          => '/<h3 class="vehicle-name">\s*<a href="(?<url>[^"]+)"[^>]*>(?<year>[0-9]{4}) (?<make>[^<]+)(?:<br\s*\/>(?<model>[^<]+))/',
            'make'          => '/<h3 class="vehicle-name">\s*<a href="(?<url>[^"]+)"[^>]*>(?<year>[0-9]{4}) (?<make>[^<]+)(?:<br\s*\/>(?<model>[^<]+))/',
            'model'         => '/<h3 class="vehicle-name">\s*<a href="(?<url>[^"]+)"[^>]*>(?<year>[0-9]{4}) (?<make>[^<]+)(?:<br\s*\/>(?<model>[^<]+))/',
            'body_style'    => '/Type:<\/div>\s*<div class="value">(?<body_style>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'price'         => '/<div itemprop="price" class="price ?">(?<price>[^<]+)/',
            'biweekly'      => '/<div class="installment ">[\s\S]*<strong>(?<biweekly>[^<]+)<\/strong> \/\s*Bi-weekly/'
        ),
        'images_regx'       => '/<a data-slide-index=\'[0-9]*\'><img src=\'(?<img_url>[^\']+)\' alt=\'\'>/'
    );
    