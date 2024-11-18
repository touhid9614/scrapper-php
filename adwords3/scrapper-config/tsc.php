<?php

    global $scrapper_configs;

    $scrapper_configs['tsc'] = array(
        'entry_points' => array(
            'new'   => 'http://www.777regina.com/new',
            'used'  => 'http://www.777regina.com/pre-owned'
        ),
        'use-proxy' => true,
        'details_start_tag' => '<ul class=\'listAll bigger\'>',
        'details_end_tag'   => '</ul>',
        'details_spliter'   => '</li>',
        'data_capture_regx' => array(
            'url'           => '/href=\'(?<url>\/car-details[^\']+)\'/',
            'stock_number'  => '/Stock&#32;#:&#32;(?<stock_number>[^<]+)/',
            'make'          => '/<li><h1><a href=\'\/car-details\?[^\']+\'>(?<make>[^<]+)/',
            'price'         => '/SALE Price:&#32;&#36;(?<price>[^*<]+)/'
        ),
        'data_capture_regx_full' => array(
            'title'         => '/<h1>(?<title>(?<year>[0-9]{4}) &middot;\s*[^&]+&middot; (?<model>[^ ]+)[^<]+)/',
            'year'          => '/<h1>(?<title>(?<year>[0-9]{4}) &middot;\s*[^&]+&middot; (?<model>[^ ]+)[^<]+)/',
            'model'         => '/<h1>(?<title>(?<year>[0-9]{4}) &middot;\s*[^&]+&middot; (?<model>[^ ]+)[^<]+)/',
            'body_style'    => '/Bodystyle<\/span>(?<body_style>[^<]+)/',
            'engine'        => '/Engine<\/span>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission<\/span>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Colour<\/span>(?<exterior_color>[^<]+)/',
            'kilometres'    => '/Kilometres<\/span>(?<kilometres>[^<]+)/'
        ) ,
        'options_start_tag' => '<ul class=\'oftContent\'>',
        'options_end_tag'   => '<div class=\'shade\'>',
        'options_regx'      => '/<li>(?<option>[^<]+)<\/li>/',
        'images_regx'       => '/<li><img src=\'(?<img_url>[^\']+)\'\/>/'
    );
    
    function tsc_field_title($title)
    {
        return str_replace('&middot; ', '', $title);
    }
    add_filter('filter_tsc_field_title', 'tsc_field_title');


// $scrapper_configs['tsc'] = array(
//         'entry_points' => array(
//             'new'   => 'http://www.triplesevenchryslerdealer.com/new-inventory/index.htm',
//             'used'  => 'http://www.triplesevenchryslerdealer.com/used-inventory/index.htm'
//         ),
//         'use-proxy' => true,
//         'details_start_tag' => '<form id="compareForm"',
//         'details_end_tag'   => '<div class="ft">',
//         'details_spliter'   => '<div class="item-compare">',
//         'data_capture_regx' => array(
//             'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
//             'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
//             'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
//             'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
//             'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
//             'price'         => '/Price<span class=\'separator\'>:<\/span><\/span><span class="value">(?<price>[^<]+)/',
//             'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
//             'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
//             'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
//             'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
//             'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
//         ),
//         'options_start_tag' => '<dt><h4>Additional Options</h4></dt>',        
//         'options_end_tag'   => '</dd>',        
//         'options_regx'      => '/<li><span>(?<option>[^<]+)/',        
//         'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
//         'images_regx'       => '/<li>\s*<a href="(?<img_url>\/\/pictures.dealer.com\/c\/[^"]+)" class="">/',
//         'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
//     );
