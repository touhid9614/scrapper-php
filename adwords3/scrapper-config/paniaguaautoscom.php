<?php
global $scrapper_configs;
$scrapper_configs["paniaguaautoscom"] = array( 
	'entry_points'           => array(
       'new' => 'https://paniaguaautos.com/vehicles',
    ),
    'vdp_url_regex'        => '/com\/[0-9]{4}-/i',

    'picture_selectors'    => ['.scroll-content-item'],
    'picture_nexts'        => ['.bx-next'],
    'picture_prevs'        => ['.bx-prev'],

    "use-proxy"            => true,

    "custom_data_capture"  => function ($url, $data) {
        $site                 = "https://www.paniaguaautos.com/sitemap.xml";
        $vdp_url_regex        = '/com\/[0-9]{4}-/i';
        $images_regx          = '/mileageFromOdometer":"[^,]+,"image":"(?<img_url>[^?]+)/i';
        $images_fallback_regx = '/<meta property="og:image" content="(?<img_url>[^?]+)/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = false;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url
   
        $data_capture_regx_full = [
          
            'stock_type'        => '/"itemCondition":"(?<stock_type>[^"]+)/',
            'vin'            => '/"vehicleIdentificationNumber":"(?<vin>[^"]+)/i',
            'transmission'   => '/Transmission[^>]+>\s*[^>]+>\s*(?<transmission>[^<]+)/i',
           
            'exterior_color' => '/"color":"(?<exterior_color>[^"]+)/i',
          //  'interior_color' => '/Interior[^>]+>\s*[^>]+>\s*(?<interior_color>[^<]+)/',
            'engine'         => '/"engineType":"(?<iengine>[^"]+)/',

          // 'drivetrain'     => '/<li class="specs">\s*[^>]+>\s*Drive Type[^>]+>\s*[^>]+>(?<drivetrain>[^<]+)/',
             'body_style'     => '/"bodyType":"(?<body_style>[^"]+)/',
          // 'fuel_type'      => '/<li class="specs">\s*[^>]+>\s*Fuel Type[^>]+>\s*[^>]+>(?<fuel_type>[^<]+)/',


            'year'           => '/"releaseDate":"(?<year>[^"]+)/i',
            'make'           => '/"manufacturer":"(?<make>[^"]+)/i',
            'model'          => '/"model":"(?<model>[^"]+)/i',

            'price'          => '/Our Price\s*<span>(?<price>[^<]+)/i',
     
            'stock_number'   => '/"sku":"(?<stock_number>[^"]+)/i',

            'kilometres'     => '/Mileage[^>]+>\s*[^>]+>\s*(?<kilometres>[^<]+)/',

           // 'description'    => '/<meta property="og:description" content="(?<description>[^"]+)/',
 
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
        return $cars;

    },

   
);