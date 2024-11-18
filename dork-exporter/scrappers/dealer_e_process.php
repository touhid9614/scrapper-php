<?php

global $site_scrappers;

$site_scrappers['dealer_e_process'] = array(
    'use-proxy' => true,
    'details_start_tag' => 'var compare_ids=new Array();',
    'details_end_tag'   => '<input type="submit" value="Compare Vehicles" class="compare_selected thm-general_border thm-box_gradient thm-light_text_color rounded_corners fl_l" />',
    'details_spliter'   => '<div class="search-veh_details fl_l">',
    'data_capture_regx' => array(
        'url'           => '/<a class="thm-hglight-text_color" href="(?<url>[^"]+)">*(New|Used)*(?<title>\s*(?<condition>[^ ]+) *(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ ]+)[^<]*)/',
        'title'         => '/<a class="thm-hglight-text_color" href="(?<url>[^"]+)">*(New|Used)*(?<title>\s*(?<condition>[^ ]+) *(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ ]+)[^<]*)/',
        'year'          =>  '/<a class="thm-hglight-text_color" href="(?<url>[^"]+)">*(New|Used)*(?<title>\s*(?<condition>[^ ]+) *(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ ]+)[^<]*)/',
        'make'          =>  '/<a class="thm-hglight-text_color" href="(?<url>[^"]+)">*(New|Used)*(?<title>\s*(?<condition>[^ ]+) *(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ ]+)[^<]*)/',
        'model'         =>  '/<a class="thm-hglight-text_color" href="(?<url>[^"]+)">*(New|Used)*(?<title>\s*(?<condition>[^ ]+) *(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ ]+)[^<]*)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number'  => '/<td class=\'details-overview_title\'>Stock #:<\/td>\s*<td class=\'details-overview_data\'>(?<stock_number>[^<]+)/',
        'price'         => '/<dd data-price="(?<price>[^"]+)/',
        'engine'        => '/<td class=\'details-overview_title\'>Engine:<\/td>\s*<td class=\'details-overview_data\'>(?<engine>[^<]+)/',
        'kilometres'    => '/<td class=\'details-overview_title\'>Odometer:<\/td>\s*<td class=\'details-overview_data\'>(?<kilometres>[^<]+)/',
        'exterior_color'=> '/<td class=\'details-overview_title\'>Exterior Color:<\/td>\s*<td class=\'details-overview_data\'>(?<exterior_color>[^<]+)/',
        'interior_color'=> '/<td class=\'details-overview_title\'>Interior Color:<\/td>\s*<td class=\'details-overview_data\'>(?<interior_color>[^<]+)/',
        'transmission'  => '/<td class=\'details-overview_title\'>Transmission:<\/td>\s*<td class=\'details-overview_data\'>(?<transmission>[^<]+)/',
        'body_style'    => '/Body Style:<\/span><\/div> <span class="field-text">(?<body_style>[^<]+)/'
    ) ,
    'options_start_tag' => 'Options</h3>',        
    'options_end_tag'   => '</ul>',        
    'options_regx'      => '/<li>(?<option>[^<]+)/',        
    'next_page_regx'   => '/<li class="next"><a class="thm-lighter_text_color" href="(?<next>[^"]+)"/',
    'images_regx'       => '/<meta itemprop="image" content="(?<img_url>http:\/\/[^"]+\.jpg)"/'
);

function dealer_e_process_images_proc($image_url)
{
    return str_replace('_th.jpg', '.jpg', $image_url);
}
?>