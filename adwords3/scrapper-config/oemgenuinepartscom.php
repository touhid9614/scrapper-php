<?php
global $scrapper_configs;
$scrapper_configs["oemgenuinepartscom"] = array( 
	'entry_points' => array(
       'used' => 'https://www.oemgenuineparts.com/sitemap.xml',
    ),
    'vdp_url_regex' => '/\/oem-parts\//i',
    'picture_selectors'    => ['.scroll-content-item'],
    'picture_nexts'        => ['.bx-next'],
    'picture_prevs'        => ['.bx-prev'],

    "use-proxy"            => true,
    "custom_data_capture"  => function ($url, $data) {
        $site                 = "www.oemgenuineparts.com";
        $vdp_url_regex        = '/\/oem-parts\//i';
        $images_regx          = '/class="product-main-image centered"\s*src="(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<meta name="og:image"\s*content="(?<img_url>[^"]+)/i';
        $required_params      = [];
        $use_proxy            = true;

        $data_capture_regx_full = [
            'title'          => '/"title":"(?<title>[^"]+)","fitmen/i',

            'year'           => '/"fitment"[^"]+"year":"(?<year>[0-9]{4})/i',

            'stock_number'   => '/SKU:[^>]+>\s*[^>]+>\s*(?<stock_number>[^<]+)/i',

            'make'           => '/"fitment"[^"]+"[^"]+"[^"]+"[^"]+"[^"]+"make":"(?<make>[^"]+)/i',

      'model'      => '/"fitment"[^"]+"[^"]+"[^"]+"[^"]+"[^"]"[^"]+"[^"]+"[^"]+"[^"]+"model":"(?<model>[^"]+)/i',

            'price'          => '/Sale Price:[^>]+>\s*[^>]+>\s*(?<price>[^<]+)/i',

            
        ];

         $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
        return $cars;


    },

    'images_regx'          => '/class="product-main-image centered"\s*src="(?<img_url>[^"]+)/i',
    'images_fallback_regx' => '/<meta name="og:image"\s*content="(?<img_url>[^"]+)/i'
);
