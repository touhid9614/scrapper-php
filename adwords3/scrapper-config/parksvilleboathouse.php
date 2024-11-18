<?php
global $scrapper_configs;
$scrapper_configs["parksvilleboathouse"] = array(
    'entry_points'           => array(
        'used' => 'https://parksvilleboathouse.com/used-boats-for-sale-vancouver-island/',
        'new'  => 'https://parksvilleboathouse.com/new-boats-for-sale-parksville-vancouver-island-bc/',
    ),

    'use-proxy'              => true,
    'refine'                 => false,

    'vdp_url_regex'          => '/\/(?:new|used)-boats-for-sale\/[0-9]{4}-/i',
    'ty_url_regex'           => '/\/inventory\/thank_you/i',
    'srp_page_regex'         => '/\/(?:new|used|certified)-boats/i',
    'must_not_contain_regx'  => '/DEAL PENDING/',

    'picture_selectors'      => ['.item-holder a'],
    'picture_nexts'          => ['.fancybox-next'],
    'picture_prevs'          => ['.fancybox-prev'],

    'details_start_tag'      => '<div data-mk-stretch-content="',
    'details_end_tag'        => '<div class="pagination">',
    'details_spliter'        => '<div class="vc_col-sm-6 wpb_column column_container',

    'data_capture_regx'      => array(
        'url'   => '/boat_title"><a href="(?<url>[^"]+)">/',
        'year'  => '/boat_title"><a href="(?<url>[^"]+)">(?<year>[0-9]{4})/',
        'make'  => '/boat_title"><a href="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[A-Za-zA-z^\s*]+)(?<model>[A-Za-z0-9^\s*]+)[^$]+(?<price>[^\s*<]+)/',
        'model' => '/boat_title"><a href="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[A-Za-zA-z^\s*]+)(?<model>[A-Za-z0-9^\s*]+)[^$]+(?<price>[^\s*<]+)/',
        'price' => '/boat_title"><[^>]+>[^$]+\$\s*(?<price>[^\s*<]+)/',
    ),

    'data_capture_regx_full' => array(
        'make'        => '/MANUFACTURER:\s*(?<make>[^<]+)/',
        'model'       => '/MODEL:\s*(?<model>[^<]+)/',
        'engine'      => '/MOTOR :\s*(?<engine>[^<]+)/',
        'year'        => '/YEAR\s*(?:<\/strong>|):(?:<strong>|)\s*(?<year>[0-9]{4})/',
        'description' => '/<meta property="og:title" content="(?<description>[^"]+)/',
    ),

    'next_page_regx'         => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx'            => '/(?:<div class="image-hover-overlay">\s*<\/div>\s*<a href="|<img class="vc_single_image-img " src=")(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);

add_filter('filter_parksvilleboathouse_car_data', 'filter_parksvilleboathouse_car_data');

function filter_parksvilleboathouse_car_data($car)
{
    $car['exterior_color'] = "White/Black";
    $car['body_style']     = "Boat";

    $delete        = ['â€™', '’', ' ', 'Â ', 'Â'];
    $replace       = ["'", "'", '', '', ''];

    $badStrRegex   = '/[^(\x20-\x7F)\x0A\x0D]*/';
    $goodStrRegex  = '/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s';
    $carAttributes = ['make', 'model', 'title', 'description', 'engine'];

    // $str = replaceAccents($str);  // function in utils
   // $regex="";
   // $matches = [];
    if ( !(preg_match('/[0-9]{4}/', $car['year'])) || empty($car['year']) ) {
        return null;
    }

    foreach ($carAttributes as $property) {
        $car[$property] = trim(str_replace($badStrRegex, '', $car[$property]));
        $car[$property] = trim(str_replace($delete, $replace, $car[$property]));
    }

    return $car;
}
