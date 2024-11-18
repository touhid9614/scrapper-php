<?php

global $scrapper_configs;

$scrapper_configs['precisionacura'] = array(
    'entry_points' => array(
        'new' => 'https://www.precisionacura.com/new-inventory/index.htm',
        'used' => 'https://www.precisionacura.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/contact-form-confirm.htm/i',
    'use-proxy' => true,
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['#photos div a img'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/final-price.*class=\'value[^>]+>\$(?<price>[^<]+)/',
        'engine' => '/Engine:<\/dt> <dd>(?<engine>[^<]+)/',
        'transmission' => '/<dt>Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres' => '/<dt>Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter('filter_precisionacura_post_data', 'filter_precisionacura_post_data', 10, 3);
add_filter('filter_precisionacura_data', 'filter_precisionacura_data');


$precisionacura_nonce = '';

function filter_precisionacura_post_data($post_data, $stock_type, $data) {
    global $precisionacura_nonce;
    if ($post_data == '') {
        $post_data = "page=1";
    }

    $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
    $nonce = '';
    $matches = [];

    if ($data && preg_match($nonce_regex, $data, $matches)) {
        $nonce = $matches['nonce'];
    }
    slecho("ajax_nonce : " . $nonce);
    if ($nonce && isset($nonce)) {
        $precisionacura_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $precisionacura_nonce);
    $post_id = 5;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 6;
        $referer = '/used-vehicles/';
    }

    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$precisionacura_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_precisionacura_data($data) {
    if ($data) {
        if (isJSON($data)) {
            slecho("data is in jSon format");
            $obj = json_decode($data);

            $data = "{$obj->results}\n{$obj->pagination}";
        } else {
            slecho("data is not in jSon format");
        }
    }

    return $data;
}
