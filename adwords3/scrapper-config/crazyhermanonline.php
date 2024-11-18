<?php

global $scrapper_configs;

$scrapper_configs['crazyhermanonline'] = array(
    'entry_points' => array(
        'used' => 'https://www.crazyhermanonline.com/autos?te_class=autos&te_mode=table&te_pgNumber=1%20&te_pgSize=200',
    ),
    'vdp_url_regex' => '/\/autos\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumbnail '],
    'picture_nexts' => ['.carousel-control-next'],
    'picture_prevs' => ['.carousel-control-prev'],
    'details_start_tag' => '<div class="te_main_table te_table autos_table px-3 container">',
    'details_end_tag' => '<div class="autos_footer">',
    'details_spliter' => '<span class="d-md-inline-block d-none">View More Information',
    'data_capture_regx' => array(
        'url' => '/class="autos-inventory mb-3">\s*<a href="(?<url>[^"]+)">/',
        'year' => '/class="autos-inventory mb-3">\s*<a href="(?<url>[^"]+)">\s*<[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'make' => '/class="autos-inventory mb-3">\s*<a href="(?<url>[^"]+)">\s*<[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'model' => '/class="autos-inventory mb-3">\s*<a href="(?<url>[^"]+)">\s*<[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'title' => '/class="autos-inventory mb-3">\s*<a href="(?<url>[^"]+)">\s*<[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'engine' => '/Engine:<\/strong>\s*<span>(?<engine>[^<]+)/',
        'transmission' => '/Trans.:<\/strong>\s*<span>(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/strong>\s*<span>(?<kilometres>[^<]+)/',
        'exterior_color' => '/Exterior:<\/strong>\s*<span>(?<exterior_color>[^<]+)/',
        'stock_number' => '/Stock No.:<\/strong>\s*<span>(?<stock_number>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'price' => '/Price<\/strong>\s*<span>(?<price>\$[0-9,]+)/',
    ),
    //  'next_page_regx' => '/<a href="(?<next>[^"]+)" alt="Next Page">Next Page<\/a>/',
    'images_regx' => '/<source type="image/webp" srcset="(?<img_url>[^"]+)"/',
);
