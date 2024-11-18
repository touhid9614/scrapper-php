<?php
global $scrapper_configs;

$scrapper_configs['barneshdkamloops'] = array(
    'entry_points'           => array(
        'used' => 'https://www.barneshd.com/used-harley-motorcycles-langley-vancouver-british-columbia-dealer--inventory?condition=pre-owned&location=langley&sz=50&pg=1',
        'new'  => 'https://www.barneshd.com/new-harley-davidson-motorcycles-for-sale-harley-dealer-langley-british-columbia--inventory?condition=new&location=langley&sz=50&pg=1',
    ),
    'url_resolve'            => array(
        'barneshdlangley'  => '/www\.barneshd\.com\/.*-Langley-/i',
        'barneshdkamloops' => '/www\.barneshd\.com\/.*-Kamloops-/i',
        'barneshdvictoria' => '/www\.barneshd\.com\/.*-Victoria-/i',
    ),
    'vdp_url_regex'          => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
    'use-proxy'              => true,
    'picture_selectors'      => ['#invUnitSliderTray .item > ul > li'],
    'picture_nexts'          => ['.right'],
    'picture_prevs'          => ['.left'],
    'details_start_tag'      => '<ul class="v7list-results__list">',
    'details_end_tag'        => '<div class="v7list-footer">',
    'details_spliter'        => '<li class="v7list-results__item"',
    'data_capture_regx'      => array(
        'stock_number'   => '/Stock Number:\s*(?<stock_number>[a-zA-Z0-9]+-[a-zA-Z0-9]+)"/',
        //'stock_type'        => '/Condition:\s*(?<stock_type>[^"]+)/',
        'year'           => '/vehicle-heading__year">(?<year>[0-9]{4})/',
        'make'           => '/vehicle-heading__name">(?<make>[^<]+)/',
        'model'          => '/vehicle-heading__model">(?<model>[^<]+)/',
        'url'            => '/<a class="vehicle-heading__link" href="(?<url>[^"]+)"/',
        'price'          => '/class="vehicle-price__price ">\s*(?<price>[^\s]+)/',
        'kilometres'     => '/Miles:[^>]+>(?<kilometres>[^<]+)/',
        'exterior_color' => '/Color:[^>]+>(?<exterior_color>[^<]+)/',
        'fuel_type'      => '/Fuel Type:[^>]+>(?<fuel_type>[^<]+)/',
        'drivetrain'     => '/Vehicle Type:[^>]+>(?<drivetrain>[^<]+)/',
        'engine'         => '/Category:[^>]+>(?<engine>[^<]+)/',
        'body_style'     => '/Category:[^>]+>(?<body_style>[^<]+)/',
        'vin'            => '/Vin:\s*(?<vin>[^"]+)/',
    ),
    'data_capture_regx_full' => array(),
    'next_page_regx'         => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results" >/',
    'images_regx'            => '/lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
);

add_filter("filter_barneshdkamloops_next_page", "filter_barneshdkamloops_next_page", 10, 2);
add_filter("filter_barneshdkamloops_field_images", "filter_barneshdkamloops_field_images");

function filter_barneshdkamloops_next_page($next, $current_page)
{
    slecho($current_page);
    $next  = explode('/', $next);
    $index = count($next) - 1;
    $next  = ($next[$index]);
    $next++;
    $peg  = "pg=" . $next;
    $prev = "pg=" . ($next - 1);
    $url  = str_replace($prev, $peg, $current_page);

    return $url;
}

function filter_barneshdkamloops_field_images($im_urls)
{
    $retval = array();

    foreach ($im_urls as $url) {
        $url         = str_replace('https://www.barneshdlangley.com/', '', $url);
        $url         = str_replace('https://www.barneshdkamloops.com/', '', $url);
        $url         = str_replace('https://www.barneshdvictoria.com/', '', $url);
        $url         = str_replace('http://www.barneshdlangley.com/', '', $url);
        $url         = str_replace('http://www.barneshdkamloops.com/', '', $url);
        $url         = str_replace('http://www.barneshdvictoria.com/', '', $url);
        $url         = str_replace('https://www.barneshd.com/', '', $url);
        $url         = str_replace('http://www.barneshd.com/', '', $url);
        $retval_im[] = str_replace('&#x2F;', '/', $url);
    }
    $final_image = [];
    $check_exist = ["71D7FB3C-A19D-4CFA-968C-0675D631A0B7.jpg", "3DD1C00B-E793-4093-ABF8-C556156DED04.jpg"];

    foreach ($retval_im as $images) {
        $i = 0;
        foreach ($check_exist as $check) {
            if (endsWith($images, $check)) {
                $i = 1;
                break;
            }
        }
        if ($i == 0) {
            array_push($final_image, $images);
        }
    }

    if (count($final_image) < 6) {
        return array();
    }

    return $final_image;
}
