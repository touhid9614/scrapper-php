<?php

global $scrapper_configs;

$scrapper_configs['barneshdlangley'] = array(
    'entry_points'           => array(
        'used' => 'https://www.barneshd.com/used-harley-motorcycles-langley-vancouver-british-columbia-dealer--inventory?condition=pre-owned&sz=50&pg=1',
        'new'  => 'https://www.barneshd.com/new-harley-davidson-motorcycles-for-sale-harley-dealer-langley-british-columbia--inventory?condition=new&sz=50&pg=1',
    ),
    'url_resolve'            => array(
        'barneshdlangley'  => '/www\.barneshd\.com\/.*-Langley-/i',
        'barneshdkamloops' => '/www\.barneshd\.com\/.*-Kamloops-/i',
        'barneshdvictoria' => '/www\.barneshd\.com\/.*-Victoria-/i',
    ),
    'vdp_url_regex'          => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.lS-image-wrapper'],
    'picture_nexts'          => ['.lSNext'],
    'picture_prevs'          => ['.lSPrev'],
    'details_start_tag'      => '<ul class="v7list-results__list">',
    'details_end_tag'        => '<div class="v7list-footer">',
    'details_spliter'        => '<li class="v7list-results__item"',
    'data_capture_regx'      => array(
        'stock_number'   => '/Stock Number:\s*(?<stock_number>[a-zA-Z0-9]+-[a-zA-Z0-9]+)"/',
        'vin'            => '/Vin:[^>]+>(?<vin>[^<]+)/',
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
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx'         => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results" >/',
    'images_regx'            => '/lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
);

add_filter("filter_barneshdlangley_next_page", "filter_barneshdlangley_next_page", 10, 2);
add_filter("filter_barneshdlangley_field_images", "filter_barneshdlangley_field_images");

function filter_barneshdlangley_next_page($next, $current_page)
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

function filter_barneshdlangley_field_images($im_urls)
{
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
    $check_exist = ["B8A958CC-6ED9-45D0-A90D-CAB5FFF2F166.jpg", "1D1064C2-D324-4D9F-87D9-1DD027826ACB.jpg", "4E389358-932B-4B98-B275-D1248E9B6A97.jpg", "6D0E2D60-3BD9-4594-A4A0-7D2CACC11AB8.jpg"];

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
    if (count($final_image) < 2) {
        return null;
    } else {
        return $final_image;

    }
}

add_filter('filter_barneshdlangley_car_data', 'filter_barneshdlangley_car_data');

function filter_barneshdlangley_car_data($car_data)
{
    if ($car_data['stock_number'] === 'U19-607401') {
        slecho("Excluding car that has stock number U19-607401 ,{$car_data['url']}");
        return null;
    }
    return $car_data;
}
