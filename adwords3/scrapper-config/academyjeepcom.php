<?php
global $scrapper_configs;
$scrapper_configs["academyjeepcom"] = array( 
	 'entry_points' => array(
            'new'   => 'https://www.academyjeep.com/search/new-chrysler-dodge-jeep-ram-tipton-in/?cy=46072&tp=new',
            'used'  => 'https://www.academyjeep.com/search/used-tipton-in/?cy=46072&tp=used'
        ),
        'vdp_url_regex'     => '/\/auto/i',
        //with proxy it was not working so I make it false.
        'use-proxy' => false,
        'picture_selectors' => ['.thumb'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        
        //'details_start_tag' => '<div class="srp_orderby_select_container">',
       // 'details_end_tag'   => '<div id="details-disclaimer"',
        'details_spliter'   => 'class="srp_vehicle_wrapper srp_vehicle_item_container srp_results_design_v3"',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #<\/td>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/multi_widget[^>]+><h2\s*><a href="[^"]+" alt="[^"]+" title="(?<title>[^"]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'price'         => '/data-sales-price="(?<price>[^"]+)/',
            'transmission'  => '/<meta itemprop="vehicleTransmission" content="(?<transmission>[^"]+)" \/>/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'interior_color'=> '/<meta itemprop="vehicleInteriorColor" content="(?<interior_color>[^"]+)/',
            'url'           => '/multi_widget[^>]+><h2\s*><a href="(?<url>[^"]+)/',
            'vin'           => '/data-vin="(?<vin>[^"]+)/',
        ),
        'data_capture_regx_full' => array(
            'engine'        => '/Engine<\/td>\s*[^>]+>(?<engine>[^<]+)/',
            'kilometres'    => '/>Mileage<\/td>\s*[^>]+>(?<kilometres>[^<]+)/',
            
            
        ),
        'next_page_regx'       => '/class="next">\s*<a class="[^"]+" href="(?<next>[^"]+)/',
        'images_regx'          => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );