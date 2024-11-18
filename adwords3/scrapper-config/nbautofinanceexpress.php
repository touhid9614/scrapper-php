<?php
    global $scrapper_configs;

    $scrapper_configs['nbautofinanceexpress'] = array(
        'entry_points' => array(
            'used'  => 'https://nbautofinanceexpress.com/inventory/'
        ),
        'vdp_url_regex'     => '/\/vehicle-details\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/eprice-[^\?]+\?.*form-action=success/i',
        'use-proxy' => true,
        'details_start_tag' => '<div class="cwp_list">',
        'details_end_tag'   => '<div class="cwp_paging">',
        'details_spliter'   => '<a class="cwp_list_item"',
        'must_contain_regx' => '/<div class="cwp_image"[^>]+>\s*<\/div>/i',
        'data_capture_regx' => array(
            'stock_number'  => '/<span>Stock No:<\/span>(?<stock_number>[^<]+)/',
            'url'           => '/href="(?<url>[^"]+)"\s*>\s*<div class="cwp_image"/',
            'title'         => '/<h3>\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^\s]+)[^\n]*)/',
            'year'          => '/<h3>\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^\s]+)[^\n]*)/',
            'make'          => '/<h3>\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^\s]+)[^\n]*)/',
            'model'         => '/<h3>\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^\s]+)[^\n]*)/',
            'kilometres'    => '/<span>Mileage:<\/span>(?<kilometres>[^<]+)/',
            'exterior_color'=> '/<span>Ext. Color:<\/span>(?<exterior_color>[^<]+)/',
            'transmission'  => '/<span>Transmission:<\/span>(?<transmission>[^<]+)/',
            'engine'        => '/<span>Displacement:<\/span>(?<engine>[^<]+)/',
            'price'         => '/<div class="cwp_price_container">\s*<div class=\'cwp_price\'>(?<price>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            //'body_style'    => '/Body:.*\s*<span class="value">(?<body_style>[^<]+)/',
            'interior_color'=> '/<label>Interior Color: <\/label>(?<interior_color>[^<]+)/'
        ),
        'next_page_regx'    => '/<a href=\'(?<next>[^\']+)\' class=\'cwp-next\'>Next<\/a>/',
        'images_regx'       => '/<li><img src=\'(?<img_url>[^\']+)\'/'
    );