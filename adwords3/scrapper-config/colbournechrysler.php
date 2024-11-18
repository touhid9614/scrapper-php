<?php

global $scrapper_configs;

$scrapper_configs['colbournechrysler'] = array(
    'entry_points' => array(
        'new' => 'https://www.colbournechrysler.com/new-inventory/index.htm',
        'used' => 'https://www.colbournechrysler.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/+[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="gv-inventory-list simple-grid list-unstyled">',
    'details_end_tag' => '<div class="clearfix ft">',
     'details_spliter'   => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)" class="url"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'title' => '/<a href="(?<url>[^"]+)" class="url"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/<a href="(?<url>[^"]+)" class="url"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/<a href="(?<url>[^"]+)" class="url"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model' => '/<a href="(?<url>[^"]+)" class="url"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'price' => '/(?:Discounted Price|Sale Price|Price)\s*<span class="[^>]+>:<\/span>\s*<\/span>\s*<span [^>]+>\s*(?<price>[^<]+)/',
        'engine' => '/Engine<\/label>\s*<span>(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior Colour<\/label>\s*<span>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Colour<\/label>\s*<span>(?<interior_color>[^/<]+)/',
        'kilometres' => '/Kilometres<\/label>\s*<span>(?<kilometres>[^<]+)/',
        'stock_number' => '/Stock Number<\/label>\s*<span>(?<stock_number>[^<]+)/',
        'transmission' => '/Transmission<\/label>\s*<span>(?<transmission>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
         'body_style' => '/bodyStyle: \'(?<body_style>[^\']+)/',
    ),
      'next_page_regx' => '/next-btn" data-href="(?<next>[^"]+)"/',
   // 'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
    //'images_regx' => '/\\\\"src\\\\":\\\\"(?<image_url>[^\\\\]*)/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
   add_filter("filter_colbournechrysler_field_images", "filter_colbournechrysler_field_images");
   function filter_colbournechrysler_field_images($im_urls) {
   /* if (count($im_urls) < 2) {
        return array();
    }
    * 
    */
    $retval = [];

    foreach ($im_urls as $img) {
        $retval[] = str_replace(['|', "%20", "?impolicy=resize&w=414", "?impolicy=resize&w=768"], ['%7C', " ", " ", " "], $img);
    }

    return $retval;
}
