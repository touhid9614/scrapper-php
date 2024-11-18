<?php
global $scrapper_configs;
 $scrapper_configs["eliteautocentre"] = array( 
	 "entry_points" => array(
	 'used' => 'https://www.eliteautocentre.ca/used-cars-kelowna',
    ),
     
     'use-proxy' => true,
     'refine' => false,
       'vdp_url_regex'      => '/\/[0-9]{4}-[^\~]+\~/i',
       'srp_page_regex'      => '/\/(?:new|used)-cars-kelowna/i',
        'picture_selectors' => ['#wowslider-container1 .ws_thumbs a img'],
        'picture_nexts'     => ['#wowslider-container1 a.ws_next'],
        'picture_prevs'     => ['#wowslider-container1 a.ws_prev'], 
        'details_start_tag' => '<div class="row eziSBRPP">',
        'details_end_tag'   => '<div class="dsFooter">',
        'details_spliter'   => '<div class="eziGetMoreInfo" style="text-align:left">',
        'data_capture_regx' => array(
            'stock_number'  => '/<div class="eziQuickDetail.*">\s*<span>#(?<stock_number>[^<]+)/',
            'title'         => '/<h2 class="eziVehicleName[^>]+>+\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^<]*))/',
            'year'          => '/<h2 class="eziVehicleName[^>]+>+\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^<]*))/',
            'make'          => '/<h2 class="eziVehicleName[^>]+>+\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^<]*))/',
            'model'         => '/<h2 class="eziVehicleName[^>]+>+\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^<]*))/',    
            'price'         => '/<span class=\'eziPriceValue\'>(?<price>[^<]+)/',
            'kilometres'    => '/Odometer:<\/span><span>(?<kilometres>[0-9,]+)/',
            'url'           => '/<div class="eziVehicle eziVehicleList" .*AssetId="[^"]+" onclick="window.location.href=\'(?<url>[^\']+)\'">/',
            'exterior_color'=> '/Exterior:<\/span><span>(?<exterior_color>[^<]+)/',
            'body_style'    => '/<span title=\'(?<body_style>[^\']+)/',
        ),
        
        'data_capture_regx_full' => array(
            'engine'        => '/<span>Engine:<\/span><span>(?<engine>[^<]+)/',
            'transmission'  => '/<span>Transmission:<\/span><span>(?<transmission>[^<]+)/',
            'exterior_color'=> '/<span>Exterior:<\/span><span>(?<exterior_color>[^<]+)/',
            'price'         => '/<span class="eziPriceValue">\$(?<price>[^<]+)/',
            'vin'           => '/VIN:<\/span><span>(?<vin>[^<]+)/',
            'description'    => '/<meta property="og:description" content="(?<description>[^"]+)/',
        ),
       
        'images_regx'       => '/<img src="(?<img_url>[^"]+)" id="wows[^"]+"/',
        'next_page_regx'    => '/<a title="Next" href="(?<next>[^"]+)/'
    );
