<?php

global $scrapper_configs;
$scrapper_configs["lussiersales"] = array(
    'entry_points' => array(
        'used' => 'https://lussiersales.com/wp-admin/admin-ajax.php?id=&post_id=53&slug=vehicles&canonical_url=https%3A%2F%2Flussiersales.com%2Fvehicles%2F&posts_per_page=-1&page=0&offset=0&post_type=ls_vehicles&repeater=default&seo_start_page=1&preloaded=false&preloaded_amount=0&order=DESC&orderby=date&action=alm_get_posts&query_type=standard'
    ),
    'vdp_url_regex' => '/com\/vehicle\/[0-9]{4}-[^-]+-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slick-slide.slick-active div div img'],
    'picture_nexts' => ['.slick-next'],
    'picture_prevs' => ['.slick-prev'],
    'details_start_tag' => '{"html":"',
    'details_end_tag' => '}}',
    'details_spliter' => '"flex w-100 w-50-s w-third-l pa3',
    'data_capture_regx' => array(
        'url' => '/<a class=[^"]+"flex flex-wrap[^"]+" href=[^"]+"(?<url>[^"]+)/',
        'title' => '/<h3 class=[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^<]+))/',
        'year' => '/<h3 class=[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^<]+))/',
        'make' => '/<h3 class=[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^<]+))/',
        'model' => '/<h3 class=[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^<]+))/',
        'price' => '/slab-serif[^>]+>(?<price>[^<]+)/',
        'kilometres' => '/Odometer[^>]+>[^>]+>(?<kilometres>[^\s*]+)/',
        'engine' => '/Engine[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Trans[^>]+>[^>]+>(?<transmission>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'trim' => '/Trim<\/span>\s*[^>]+>(?<trim>[^<]+)/',
        'year' => '/Year<\/span>\s*[^>]+>(?<year>[0-9]{4})/',
        'make' => '/Make<\/span>\s*[^>]+>(?<make>[^<]+)/',
        'model' => '/Model<\/span>\s*[^>]+>(?<model>[^<]+)/',
        'stock_number' => '/Stock #<\/span>[^>]+>(?<stock_number>[^<]+)/',
        
        'exterior_color' => '/Exterior<\/span>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior<\/span>\s*[^>]+>(?<interior_color>[^<]+)/'
    ),
    // 'next_page_regx'    => '/<li class="pagination__current">[0-9]*<\/li><li class="pagination__page"><a href="(?<next>[^"]+)"/',
    'images_regx' => '/<img src="(?<img_url>[^"]+)" alt="" itemprop="image"/',
);

add_filter('filter_lussiersales_field_url', 'filter_lussiersales_field_url');

function filter_lussiersales_field_url($url) {
    $url = str_replace("\\", "", $url);
    slecho("URLxxxxxxxx:" . $url);
    return trim($url);
}
