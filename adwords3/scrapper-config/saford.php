<?php
global $scrapper_configs;
 $scrapper_configs["saford"] = array( 
	 "entry_points" => array(
		'new'  => 'https://www.saford.com/searchnew.aspx',
		'used' => 'https://www.saford.com/searchused.aspx'
	 ),
	 'vdp_url_regex'     => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
         'use-proxy' => true,
        'picture_selectors' => ['.carousel__item.js-carousel__item '],
        'picture_nexts'     => ['.js-carousel__control--next'],
        'picture_prevs'     => ['.js-carousel__control--prev'],
        
        'details_start_tag' => '<div class="row srpSort',
        'details_end_tag'   => '<div class="row srpDisclaimer',
        'details_spliter'   => 'class="row srpVehicle hasVehicleInfo"',
        'data_capture_regx' => array(
            'url'           => '/href="(?<url>[^"]+)">\s*<span/',
            'title'         => '/data-name="(?<title>[^"]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/data-price="(?<price>[^"]+)/',
            'kilometres'    => '/Mileage: </strong>(?<kilometres>[^<]+)/',
            'stock_number'  => '/data-vin="(?<stock_number>[^"]+)/',
            'engine'        => '/data-engine="(?<engine>[^"]+)/',
            'body_style'    => '/data-bodystyle ="(?<body_style>[^"]+)/',
            'transmission'  => '/data-trans="(?<transmission>[^"]+)/',
            'exterior_color'=> '/data-extcolor="(?<exterior_color>[^"]+)/',
            'interior_color'=> '/data-intcolor="(?<interior_color>[^"]+)/'
        ),
        
        'next_page_regx'    => '/href="(?<next>[^"]+)" aria-label="Next">/',
        'images_regx'       => '/<img[^"]*"(?<img_url>[^"]+)" alt="/'
	);
 
 add_filter("filter_saford_field_price", "filter_saford_field_price", 10, 3);
        function filter_saford_field_price($price,$car_data, $spltd_data)
        {
            
            if($price > 0) {
               return $price;
            }
            else {
                $price="please call";
                return $price;
            }

            
        }
