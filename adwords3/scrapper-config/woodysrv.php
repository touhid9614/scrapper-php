<?php

global $scrapper_configs;
$scrapper_configs["woodysrv"] = array(
    
        'entry_points' => array(
            'used'  => 'https://www.woodysrv.com/rv-inventory/used/?page=1',
            'new'   => 'https://www.woodysrv.com/rv-inventory/new/?page=1',
        ),
        'vdp_url_regex'     => '/\/rv-inventory\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
        'use-proxy' => true,
        'refine'            => false,
        'picture_selectors' => ['a.cboxElement > img'],
        'picture_nexts'     => ['#cboxNext','#cboxLoadedContent'],
        'picture_prevs'     => ['#cboxPrevious'],
        //'required_params'   => array('page','id'),
        'details_start_tag' => '<div class="col-xxs-12 rv-repeater">',
        'details_end_tag'   => '<!-- End RV Repeater -->',
        'details_spliter'   => '<!-- RV Listing -->',
        'must_not_contain_regex' => '/<img src="[^"]+" alt="This unit is sold">/',
        'data_capture_regx' => array(
          
            'price'         => '/Woody\'s Price[^>]+>\s*<span class="price-amount">(?<price>\$[0-9,]+)/',
            'body_style'    => '/RV Type<\/td>\s*<td>(?<body_style>[^<]+)/',
        
            'url'           => '/class="main-image">\s*<a href="(?<url>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            'year'          => '/data-year="(?<year>[^"]+)"/',
            'make'          => '/data-manufacturer="(?<make>[^"]+)/',
            'model'         => '/data-brand="(?<model>[^"]+)/',
            'trim'          => '/data-model="(?<trim>[^"]+)/',
            'exterior_color'=> '/Exterior<\/td>\s*<td>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior<\/td>\s*<td>(?<interior_color>[^<]+)/',
            'stock_number'  => '/Stock No<\/td>\s*<td>(?<stock_number>[^<]+)/',
            'city'          => '/Location<\/td>\s*<td>(?<city>[^<]+)/',
            'price'         => '/class="price selling">\s*<span>[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
            
            
        ),
        'next_query_regx'    => '/<a href="\?(?<param>page)=(?<value>[0-9]+)" class="fc-next-page"/',
        'images_regx'       => '/data-lazy="(?<img_url>[^"]+)" alt=/',
        
        
      //  'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );


add_filter("filter_woodysrv_field_images", "filter_woodysrv_field_images");
    
    function filter_woodysrv_field_images($im_urls)
    {
       if(count($im_urls)<3)
            {
            return [];
            
            }
       
        return $im_urls;
    }
add_filter('filter_woodysrv_car_data', 'filter_woodysrv_car_data');

function filter_woodysrv_car_data($car_data) {
    //taking all cars except Corvette

    if ($car_data['stock_number'] == '&nbsp;') {
        $car_data['stock_number'] = "";
        $car_data['vin'] = "";
    }
    $car_data['msrp'] = substr($car_data['msrp'], 0, strpos($car_data['msrp'], "."));

    $car_data['city'] = str_replace(" ", "_", strtolower($car_data['city']));
    $car_data['exterior_color'] = 'other';
    
    
    if ($car_data['price'] == '$0') {
        $car_data['price'] = "Please Call";   
    }
    if ($car_data['msrp'] == '$0') {
        $car_data['msrp'] = "Please Call";   
    }

    return $car_data;
}
