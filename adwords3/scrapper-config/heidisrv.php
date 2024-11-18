<?php
    global $scrapper_configs;

    $scrapper_configs['heidisrv'] = array(
        'entry_points' => array(
         //   'new'   => 'https://www.heidisrv.com/rv-inventory/new/',
            'used'  => 'https://www.heidisrv.com/rv-inventory/used/',
            'new'   => 'https://www.heidisrv.com/rv-inventory/new/',
        ),
        'vdp_url_regex'     => '/\/Heidis-RV-Details.php/i',
        'use-proxy' => true,
        'refine'            => false,
        'picture_selectors' => ['a.cboxElement > img'],
        'picture_nexts'     => ['#cboxNext','#cboxLoadedContent'],
        'picture_prevs'     => ['#cboxPrevious'],
       // 'required_params'   => ['VEHICLE_NO','DEALER_NO'],
        'details_start_tag' => '<div class="col-xxs-12 rv-repeater">',
        'details_end_tag'   => '<!-- End RV Repeater -->',
        'details_spliter'   => '<!-- RV Listing -->',
        'must_not_contain_regex' => '/<img src="[^"]+" alt="This unit is sold">/',
        'data_capture_regx' => array(
          
            'price'         => '/class="price-amount">(?<price>\$[0-9,]+)/',
            'body_style'    => '/RV Type<\/td>\s*<td>(?<body_style>[^<]+)/',
        
            'url'           => '/class="main-image">\s*<a href="(?<url>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            'year'          => '/class="col-xs-12">\s*<h2>(?<year>[0-9]{4}) (?<make>[^[0-9]+)(?<model>[^<]*)/',
            'make'          => '/class="col-xs-12">\s*<h2>(?<year>[0-9]{4}) (?<make>[^[0-9]+)(?<model>[^<]*)/',
            'model'         => '/class="col-xs-12">\s*<h2>(?<year>[0-9]{4}) (?<make>[^[0-9]+)(?<model>[^<]*)/',
            'exterior_color'=> '/Exterior<\/td>\s*<td>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int\. Colour<\/td>\s*<td>(?<interior_color>[^<]+)/',
            'stock_number'  => '/Stock NO.<\/td>\s*<td>(?<stock_number>[^<]+)/',
            'price'         => '/class="price selling\s*">\s*[^>]+>(?<price>\$[0-9,]+)/',
            
            
        ),
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" id="next-page" title/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" rel="thumbs">/',
        
        
      //  'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    
    //add_filter("filter_heidisrv_field_images", "filter_heidisrv_field_images");
    //add_filter("filter_heidisrv_field_url", "filter_heidisrv_field_url");
    
    /*function filter_heidisrv_field_images($im_urls)
    {
        if(count($im_urls) < 2) { return array(); }
        return $im_urls;
    }*/
   /* function filter_heidisrv_field_url($url)
    {
        return str_replace("&amp;","&",$url);
    }*/
    
