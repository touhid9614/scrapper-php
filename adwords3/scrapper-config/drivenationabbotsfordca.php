<?php
global $scrapper_configs;
$scrapper_configs["drivenationabbotsfordca"] = array( 
	'entry_points' => array(
            'used'  => 'https://www.drivenationabbotsford.ca/vehicles/?fwp_paged=1',
        ),
        'vdp_url_regex'     => '/\/vehicles\/[0-9]{4}-/i',
         'ty_url_regex' => '/\/thank-you-for-/i',
        'use-proxy' => false,
         'refine'=>false,
        'picture_selectors' => ['.slick-slide'],
        'picture_nexts'     => ['.btn-next'],
        'picture_prevs'     => ['.btn-prev'],
        
        'details_start_tag' => '<div class="fwpl-layout',
        'details_end_tag'   => '<footer class="',
        'details_spliter'   => '<div class="fwpl-result',
  
        'data_capture_regx' => array(
            'url'           => '/class="fwpl-item[^>]+><a href="(?<url>[^"]+)"[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
            'year'          => '/class="fwpl-item[^>]+><a href="(?<url>[^"]+)"[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
            'make'          => '/class="fwpl-item[^>]+><a href="(?<url>[^"]+)"[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
            'model'         => '/class="fwpl-item[^>]+><a href="(?<url>[^"]+)"[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
            'price'         => '/class="fwpl-item[^>]+>\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/class="fwpl-item el-h9o3i8">(?<kilometres>[^\s*]+)/',
            'vin'           => '/VIN:\s*(?<vin>[^<]+)/',
            'transmission'  => '/class="fwpl-item el-pu79g4">[^\s*]+\s*(?<transmission>[^<]+)/',
            'stock_number'  => '/Stock:\s*(?<stock_number>[^<]+)/',
             'drive_train'=> '/class="fwpl-item el-2dvyhf9">[^\s*]+\s*(?<drive_train>[^<]+)/',
             'fuel_type'        => '/fwpl-item el-tjasb">[^\s*]+\s*(?<fuel_type>[^<]+)/', 
         ),
        'data_capture_regx_full' => array(
           'description' => '/tab-title-description">[^\;]+\;(?<description>[\s\S]*?(?=<\/div>))/',
        ),
         'next_page_regx'   => '/data-page=[^"]+"(?<next>[0-9]*)[^"]+">Next/',
        'images_regx'       => '/data-thumb="(?<img_url>[^\?]+)/',
    //  'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
    );
 
    add_filter("filter_drivenationabbotsfordca_field_description", "filter_drivenationabbotsfordca_field_description");

    function filter_drivenationabbotsfordca_field_description($description) {
         $description=preg_replace("/<a href=[^>]+>/", "", $description);
         $description=str_replace(['&#8211;','&#8217;'], ["",''], $description);
         return strip_tags($description);
     }

add_filter("filter_drivenationabbotsfordca_next_page", "filter_drivenationabbotsfordca_next_page", 10, 2);

function filter_drivenationabbotsfordca_next_page($next, $current_page) {
    slecho($next);
    $next = str_replace("https://www.drivenationabbotsford.ca/vehicles/", '', $next);
    $prev_val = "fwp_paged=" . ($next - 1);
    $next_val = "fwp_paged=" . $next;

    $next_url = str_replace($prev_val, $next_val, $current_page);
    slecho($next_url);
    return $next_url;
}
