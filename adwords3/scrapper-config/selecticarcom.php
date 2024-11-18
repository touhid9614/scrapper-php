<?php
global $scrapper_configs;
$scrapper_configs["selecticarcom"] = array( 
	"entry_points" => array(
	    'used' => 'https://www.selecticar.com/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'refine' => false,
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer class="footer wp"',
        'details_spliter'   => '<div itemprop="ItemOffered"',
        'data_capture_regx' => array(
        'url'            => '/role="button"\s*href="(?<url>[^"]+)"\s*onclick/',
        'year'           => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make'           => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model'          => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'stock_number'   => '/STK#\s*(?<stock_number>[^\/]+)/',
        'exterior_color' => '/"exteriorColour":"(?<exterior_color>[^"]+)/', 
        'interior_color' => '/"exteriorColour":"(?<interior_color>[^"]+)/',
        'engine'         => '/"engine":"(?<engine>[^"]+)/',
        'transmission'   => '/"transmission":"(?<transmission>[^"]+)/',
        'kilometres'     => '/"mileage":"(?<kilometres>[^"]+)/',
        'vin'            => '/"vin":"(?<vin>[^"]+)/',
        ),
        'data_capture_regx_full' => array(        
        // 'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        // 'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        // 'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        // 'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        // 'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        // 'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        // 'vin' => '/data-vin="(?<vin>[^"]+)/',
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[^<]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
    );
 add_filter("filter_selecticarcom_field_images", "filter_selecticarcom_field_images");
 function filter_selecticarcom_field_images($im_urls)
    {
               if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }