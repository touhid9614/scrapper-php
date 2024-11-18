<?php
global $scrapper_configs;
 $scrapper_configs["arbogastrvs"] = array( 
	  'entry_points' => array(
               'used'  => 'https://www.arbogastrvs.com/used-rvs-for-sale?pagesize=100&page=1',
            'new'   => 'https://www.arbogastrvs.com/new-rvs-for-sale?pagesize=100&page=1',
           
        ),
        'vdp_url_regex'     => '/\/product\/(?:new|used)-/i',
        'ty_url_regex'      => '/\/contact-confirmation/i',
        'use-proxy'         => true,
        'refine'            => false,
     
        'picture_selectors' => ['#main > div > div.row > div.col-md-7 > div.detailMedia > div.detail-thumbnail-wrapper.hidden-xs > div > div > img'],
        'picture_nexts'     => ['.sliderNext'],
        'picture_prevs'     => ['.sliderPrev'],
     
        'details_start_tag' => '<div class="listingPagination listingToolbar">',
        'details_end_tag'   => '<div class="listingPagination bottomPaging',
        'details_spliter'   => "<li class='unit",
        'data_capture_regx' => array(
            'stock_number'      => '/data-stocknumber="(?<stock_number>[^"]+)/',
            'url'               => '/data-unitlink="(?<url>[^"]+)/',
            'year'              => '/data-year="(?<year>[^"]+)/',
            'make'              => '/data-brand="(?<make>[^"]+)/',
            'model'             => '/data-unitname="(?<model>[^"]+)/',
            'price'             => '/data-saleOrRegularPrice="(?<price>[^"]+)/',
            'body_style'        => '/data-type="(?<body_style>[^"]+)/',
        ),
        'data_capture_regx_full' => array(
            'vin'               => '/data-dv-vin="(?<vin>[^"]+)/',
            'exterior_color'    => '/Exterior Color:\s(?<exterior_color>[^<]+)/',
        ),
        'next_query_regx'   => '/<a href="#" class="next" title="Next Page" data-(?<param>page)="(?<value>[0-9]*)"/',
        'images_regx'       => '/<a title="Click to enlarge" href="(?<img_url>[^"]+)"/'
    );

add_filter('filter_arbogastrvs_car_data', 'filter_arbogastrvs_car_data');
function filter_arbogastrvs_car_data($car_data) {

    if(empty($car_data['exterior_color']))
    {
        $car_data['exterior_color'] = "Not Defined";
    }
    return $car_data;
}

add_filter("filter_arbogastrvs_field_images", "filter_arbogastrvs_field_images");

function filter_arbogastrvs_field_images($im_urls) {
    if (count($im_urls) < 4) {
        return array();
    }

    return $im_urls;
}

    