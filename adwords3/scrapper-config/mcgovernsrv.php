<?php
	global $scrapper_configs;
    $scrapper_configs['mcgovernsrv'] = array(
         'entry_points' => array(
            'new'  => array(
                'https://www.mcgovernsrv.com/default.asp?page=inventory&condition=new&category=trailer&sz=50',
                'https://www.mcgovernsrv.com/default.asp?page=inventory&condition=new&category=trailer&sz=50&pg=2',
            ),
            'used' => 'https://www.mcgovernsrv.com/default.asp?page=inventory&condition=pre-owned&category=motorhome&category=trailer&sz=50'
        ),
        'vdp_url_regex'     => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}/i',
        'refine'            => false,
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.prev'],
        
        'details_start_tag' => '<h2 class="v7list-subheader__heading">',
        'details_end_tag'   => '<div class="v7list-footer">',
        'details_spliter'   => '<li class="v7list-results__item"',
        'data_capture_regx' => array(
            'url'           => '/vehicle-heading__link" href="(?<url>[^"]+)/',
            'year'          => '/<span class="vehicle-heading__year">(?<year>[^<]+)/',
            'make'          => '/vehicle-heading__name">(?<make>[^<]+)/',
            'model'         => '/vehicle-heading__model">(?<model>[^<]+)/',
            'price'         => '/Our Price[^>]+>[^>]+>(?<price>[^<]+)/',
            'stock_number'  => '/Stock Number:\s[^>]+>(?<stock_number>[^<]+)/',
        ),
        'data_capture_regx_full' => array(        
            'stock_number' => '/Stock Number<\/label>\s*[^>]+>(?<stock_number>[^\<]+)/',
            'vin' => '/Stock Number<\/label>\s*[^>]+>(?<vin>[^<]+)/',
            'fuel_type' => '/Fuel Type<\/label>\s*[^>]+>(?<fuel_type>[^<]+)/',
            'exterior_color' => '/Color<\/label>\s*[^>]+>(?<exterior_color>[^\<]+)/',
            'description' => '/<meta name="description" content="(?<description>[^"]+)/',
            'engine' => '/Engine<\/label>\s*[^>]+>(?<engine>[^\<]+)/',
            'kilometres' => '/Odometer<\/label>\s*[^>]+>(?<kilometres>[^\s*]+)/',
            'body_style' => '/Body Style<\/label>\s*[^>]+>(?<body_style>[^\<]+)/',
        ) ,
        'images_regx'       => '/<div class="lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
        'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
);
 
    add_filter('filter_mcgovernsrv_car_data', 'filter_mcgovernsrv_car_data');


function filter_mcgovernsrv_car_data($car_data) {
    
     $makes=[
                    'oachmen',
                    'utchmen',
                    'orest River',
                    'orest River RV',
                    'ayco',
                    'eystone RV',
                    'ance',
                    'orthwood',
                    'tarcraft',
                    'hor Motor Coach',
                    'innebago',
                    
                ];
                foreach($makes as $make) {
                    
                    if (strripos($car_data['make'],$make)) 
                    {   
                        $car_data['custom']=$car_data['make'][0] . $make;
                        slecho("make modified  ,{$car_data['custom']}");
                        

                    }
                }
    
            
    
   // $car_data['custom']=$car_data['make'];
    preg_match("/\s+(?<temp>.+)/i", $car_data['make'], $matches);
    $car_data['make']=preg_replace('/\s+.+/', '', $car_data['make']);
    $car_data['model']= $matches['temp']  . ' ' . $car_data['model'];


    return $car_data;
}

    
    

    function mcgovernsrv_images_proc($image_url)
    {
        $tmp = str_replace('&#x2F;', '/', $image_url);
        return $tmp;
    }

 add_filter("filter_mcgovernsrv_field_images", "filter_mcgovernsrv_field_images");
 function filter_mcgovernsrv_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            
             
              $url=str_replace('https://www.mcgovernsrv.com/', '', $url);
            $retval_im[] = str_replace('&#x2F;', '/', $url);
           
           
        }
        
        return $retval_im;

    }
    
