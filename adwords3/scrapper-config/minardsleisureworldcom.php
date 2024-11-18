<?php
global $scrapper_configs;
$scrapper_configs["minardsleisureworldcom"] = array( 
	 'entry_points' => array(
         'new' => 'https://minardsleisureworld.com/',
    ),
    'vdp_url_regex'        => '/\/product\/[0-9]{4}-/i',
    'refine'               => false,
    'picture_selectors'    => ['.scroll-content-item'],
    'picture_nexts'        => ['.bx-next'],
    'picture_prevs'        => ['.bx-prev'],

    "use-proxy"            => false,

    "custom_data_capture"  => function ($url, $data) {
        $site                 = "https://minardsleisureworld.com/product-sitemap.xml";
        $vdp_url_regex        = '/\/product\/[0-9]{4}-/i';
        $images_regx          = '/<div class="single-rv-modal-slideshow minards-carousel">\s*<div class="slide-inner">\s*<div class="slide-img">\s*<img src="(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = false;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

    
        // $annoy_func = function ($car_data) {
           
        //     $car_data['title'] = trim(str_replace(['&#039;s'], [''], $car_data['title']));

        //     return $car_data;
        // };

        $data_capture_regx_full = [
            //The title was showing incorrectly in the feed so it has now been taken//
            'title'          => '/<meta property="og:title" content="(?<title>(?<year>[^ ]+)\s*(?:Used|New|)\s*(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',

          //  'stock_type'     => '/<link\s*rel="canonical"\s*href="https:\/\/minardsleisureworld.com\/product[^\-]+-(?<stock_type>[^\-]+)/',
            'year'           => '/<meta property="og:title" content="(?<title>(?<year>[^ ]+)\s*(?:Used|New|)\s*(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'make'           => '/<meta property="og:title" content="(?<title>(?<year>[^ ]+)\s*(?:Used|New|)\s*(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'model'          => '/<meta property="og:title" content="(?<title>(?<year>[^ ]+)\s*(?:Used|New|)\s*(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
			'price'          => '/Add to Favourites<\/div>\s*[^>]+>\s*\s*[^>]+>\s*[^>]+>\s*<[^>]+>\s*.*\s*.*\s*(?<price>\$[0-9,]+)/i',
            'exterior_color' => '/<span class="single-rv-spec-label">COLOUR<\/span>[^;]+;(?<exterior_color>[^<]+)/i',
            'stock_number'   => '/<span class="single-rv-spec-label">SKU<\/span>[^;]+;(?<stock_number>[^<]+)/i',  
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
        return $cars;

    },

    'images_regx'          => '/data-lightbox="(?<img_url>[^"]+)"/i',
    'images_fallback_regx' => '/property="og:image" content="(?<img_url>[^"]+)"/i'
);