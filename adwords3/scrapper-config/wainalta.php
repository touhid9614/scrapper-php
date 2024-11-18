<?php

global $scrapper_configs;

$scrapper_configs['wainalta'] = array(
    'entry_points' => array(
        'new'   => 'http://www.wainalta.com/inventory/new/',
        'used'  => 'http://www.wainalta.com/inventory/pre-owned/'
    ),
    'vdp_url_regex'      => '/\/inventory\/[0-9]{4}-/i',
    'ty_url_regex'       => '/\/form\/confirm.htm/i',
    'use-proxy'          => true,
    'picture_selectors' => ['.item'],
    'picture_nexts'     => [],
    'picture_prevs'     => [],
    'details_start_tag'  => 'class="block CarContainer">',
    'details_end_tag'    => '<div id="CompareModal" class="modal fade" role="dialog">',
    'details_spliter'    => 'class="block CarContainer">',
    'data_capture_regx'  => array(
        'stock_number'      => '/<span class="gray-txt">Stock Number:<\/span>\s*(?<stock_number>[^<]+)<\/div>/',
        'url'               => '/<a class="decoration-none black-txt" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+) (?<trim>[^<]+))/',
        'title'             => '/<a class="decoration-none black-txt" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+) (?<trim>[^<]+))/',
        'year'              => '/<a class="decoration-none black-txt" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+) (?<trim>[^<]+))/',
        'make'              => '/<a class="decoration-none black-txt" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+) (?<trim>[^<]+))/',
        'model'             => '/<a class="decoration-none black-txt" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+) (?<trim>[^<]+))/',
        'trim'              => '/<a class="decoration-none black-txt" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+) (?<trim>[^<]+))/',
        'price'             => '/WebPrice[^\n]+\s*<div class="col-xs-12 pad-0 text-left">(?<price>[^<]+)/',
        'exterior_color'    => '/Exterior:<\/span> (?<exterior_color>[A-Z a-z]+)<\/div>/',
        'engine'            => '/Engine:<\/span>\s*(?<engine>[^<]+)<\/div>/',
        'transmission'      => '/Transmission:<\/span>\s*(?<transmission>[^<]+)<\/div>/',
        'kilometres'        => '/Odometer:<\/span>\s*(?<kilometres>[^<]+)<\/div>/',
    ),
    'next_query_regx'   => '/.bootpag\(\{\s*total:\s*(?<value>[0-9]*),\s*(?<param>page):\s*/',
    'images_regx'       => '/<a class="group3" href="(?<img_url>[^"]+)/'
);

// function wainalta_next_processor($param, $value)
//{
//    slecho ("Inside processor : ");
//    $cur_page=1;
//    $ttl_page=$value;
//    if($param == 'page'){      
//       if($cur_page <= $ttl_page) {
//            return $cur_page + 1;
//        } 
//    }
//    else return $value;
//}
add_filter('filter_wainalta_post_data', 'filter_wainalta_post_data');
$cur_page =1 ;
function filter_wainalta_post_data($post_data)
{
    global $cur_page;
    slecho ("Post Data: ".$post_data);
    $exp = explode('=', $post_data);
    $ttl_page=$exp[1];
    if(count($exp) == 2) {
        $exp[0] = "Page";
        if($cur_page<$ttl_page)
        {
           $exp[1]= ++$cur_page;
        }
    } else {
        return null;
    }
     slecho (implode('|', $exp));
    return implode('=', $exp);
}