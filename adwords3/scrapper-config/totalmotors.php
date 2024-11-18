<?php
    global $scrapper_configs;

    $scrapper_configs['totalmotors'] = array(
        'entry_points' => array(
            'new'   => 'http://www.totalmotors.com/all-new-inventory',
            'used'  => 'http://www.totalmotors.com/all-used-inventory'
        ),
        'vdp_url_regex'     => '/\/details\/(?:new|used)\/[^\/]+\/[^\/]+\/[0-9]{4}\//i',
        //'ty_url_regex'      => '/\/eprice-[^\?]+\?.*form-action=success/i',
        'use-proxy' => true,
        'picture_selectors' => ['.fotorama__nav__frame'],
        'picture_nexts'     => ['.fotorama__arr--next'],
        'picture_prevs'     => ['.fotorama__arr--prev'],
        
        'details_start_tag' => '<div class="block-grid-lg-1 block-grid-md-1 block-grid-sm-2 block-grid-xs-1"',
        'details_end_tag'   => '<div class="cb-footer">',
        'details_spliter'   => '<div class="block-grid-item">',
      //  'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        'data_capture_regx' => array(
            'stock_number'  => '/<td><strong>Stock No.<\/strong><\/td>\s*<td>(?<stock_number>[^<]+)/',
            'url'           => '/class="panel-title">\s*<a\s*href="(?<url>[^"]+)/',
            'title'         => '/<div class="panel-title">\s*<a\s*href="[^>]+>(?<title>[^<]+)/',
            'year'          => '/<div class="panel-title">\s*<a\s*href="[^>]+>(?<year>[0-9]{4})/',
            //'make'          => '/<div class="panel-title">\s*<a\s*href="[^>]+>[0-9]{4}\s*(?<make>[^/\s]+)/',
            //'model'         => '/<div class="panel-title">\s*<a\s*href="[^>]+>[0-9]{4}\s*[^/\s]+\s*(?<model>[^/\s]+)/',
            'price'         => '/<span class="price final">(?<price>[^<]+)/',
            'exterior_color'=> '/<strong>Color<\/strong><\/td>\s*<td>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/<strong>Interior<\/strong><\/td>\s*<td>(?<interior_color>[^<]+)/',
            'engine'        => '/<strong>Engine<\/strong><\/td>\s*<td>(?<engine>[^<]+)/',
            'transmission'  => '/<strong>Transmission<\/strong><\/td>\s*<td>(?<transmission>[^<]+)/',
            'kilometres'    => '/<strong>Mileage<\/strong><\/td>\s*<td>(?<kilometres>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'          => '/<td>Make<\/td>\s*<td>(?<make>[^<]+)/',
            'model'         => '/<td>Model<\/td>\s*<td>(?<make>[^<]+)/',
            //'price'         => '/<label>Price[^\s]+\s*[^\s]\s*[^\s]+\s*<td[^>]+>\s*(?<price>[^\s]+)/',
            'body_style'    => '/<td>Body\s*Style<\/td>\s*<td>(?<body_style>[^<]+)/',
           
        ),
        'next_page_regx'    => '/<li\s*class="active">\s*.*\s*</li>\s*<li>\s*<a\s*href="(?<next>[^"]+)"/',
        'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*data-thumb="[^"]+"/'
    );