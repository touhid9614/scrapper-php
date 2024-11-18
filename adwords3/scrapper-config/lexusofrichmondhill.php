<?php
    global $scrapper_configs;

    $scrapper_configs['lexusofrichmondhill'] = array(
        'entry_points' => array(
            'used'  => 'http://www.lexusofrichmondhill.com/!/usedvehiclesv2/filter?uv_make=any&uv_model=any&uv_body_type=any&uv_price=any&uv_mileage=any&uv_year=any&uv_listings_per_page=1000&uv_page=1&uv_sort_by=Year&uv_colour=any&certified=any&stock_numbers=any&uv_sorting=Year-DESC'
        ),
        'vdp_url_regex'     => '/\/preowned_vehicles\/[0-9]{4}\//i',
        'ty_url_regex'      => '/\/thankYou.do/i',
        'ajax_url_match'    => 'callback=secureLeadSubmission',
        'use-proxy'         => true,
        'details_spliter'   => '<div class="wrapper">',
        'data_capture_regx' => array(
            'stock_number'      => '/<div class="large-6 small-6 columns vehicle-stock">\s*<p><span class="strong">Stock <\/span>\s*<br>#(?<stock_number>[^<]+)/',
            'url'               => '/<td valign="middle">\s*<a href="URL(?<url>[^"]+)" class="[^"]+">\s*<h3>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'title'             => '/<td valign="middle">\s*<a href="(?<url>[^"]+)" class="[^"]+">\s*<h3>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'year'              => '/<td valign="middle">\s*<a href="(?<url>[^"]+)" class="[^"]+">\s*<h3>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'make'              => '/<td valign="middle">\s*<a href="(?<url>[^"]+)" class="[^"]+">\s*<h3>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'model'             => '/<td valign="middle">\s*<a href="(?<url>[^"]+)" class="[^"]+">\s*<h3>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'price'             => '/<div class="vehicle-price">\s*<h2 class="green">\s*(?<price>[\$,0-9]+)/',
            'kilometres'        => '/<div class="large-6 small-6 columns vehicle-mileage">\s*<p><span class="strong">\s*Mileage<\/span>\s*<br>(?<kilometres>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'exterior_color'    => '/<li><strong>Ext. Colour</strong>: (?<exterior_color>[^<]+)/',
            'interior_color'    => '/<li><strong>Int. Colour</strong>: (?<interior_color>[^<]+)/',
            //'body_style'        => '/itemprop="bodyType">(?<body_style>[^<]+)/',
            'engine'            => '/<li><strong>Engine</strong>: (?<engine>[^<]+)/',
            'transmission'      => '/<li><strong>Transmission</strong>: (?<transmission>[^<]+)/'
        ),
        'images_regx'       => '/<a href="(?<img_url>http:\/\/azr.cdnmedia.autotrader.ca\/[^"]+)">\s*<img src=/',
    );
    
    add_filter('filter_lexusofrichmondhill_field_url', 'filter_lexusofrichmondhill_field_url');
    
    function filter_lexusofrichmondhill_field_url($url) {
        return "http://www.lexusofrichmondhill.com/preowned_vehicles{$url}";
    }