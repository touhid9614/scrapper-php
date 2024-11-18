<?php
global $scrapper_configs;
$scrapper_configs["allstarrvca"] = array( 
	"entry_points" => array(
	       
        'new' => 'https://www.allstarrv.ca/new-rvs-for-sale',
         
       ),
    'vdp_url_regex'       => '/\/product\/(?:new|used)-/i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.current'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "http://www.allstarrv.ca/sitemap.xml";
        $vdp_url_regex        = '/\/product\/(?:new|used)-/i';
        $images_regx          = '/<a title="Click to enlarge" href="(?<img_url>[^"]+)" data/i';
        $images_fallback_regx = '/<meta property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = true;

        $data_capture_regx_full = [
         
          //  'stock_type'     => '/Type:<\/div>[^>]+>(?<stock_type>[^<]+)/i',
            'year'           => '/data-year="(?<year>[^"]+)/i',
            'make'           => '/data-mfg=\'(?<make>[^\']+)/i',
            'model'          => '/data-brand="(?<model>[^"]+)/i',
            'price'          => '/<span class="PriceLabel">Price:<\/span>\s*<[^>]+>(?<price>[^<]+)/i',
           // 'engine'         => '/infoinfoengine">(?<engine>[^<]+)/i',
           // 'transmission'   => '/infoinfotransmission">(?<transmission>[^<]+)/i',
          //  'kilometres'     => '/infoinfomileage">(?<kilometres>[^<]+)/i',
            'interior_color' => '/<td class="SpecLabelContainer">Interior Color[^>]+>\s*[^>]+>\s*(?<interior_color>[^<]+)/i', 
            'stock_number'   => '/Stock#(?<stock_number>[^<]+)/i',
            'vin'            => '/VIN[^>]+>\s*[^>]+>\s*(?<vin>[^<]+)/i',
           // 'body_style'     => '/infoinfostyle">(?<body_style>[^<]+)/i',
          //  'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
           
      ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        return $cars;

    },
     'images_regx'          => '/<a title="Click to enlarge" href="(?<img_url>[^"]+)" data/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/',
);