<?php
global $scrapper_configs;
 $scrapper_configs["rosecityford"] = array(
	"entry_points" => array(
        'used' => 'https://www.rosecityford.com/used/search.html?filterid=q0-500',
        'new' => 'https://www.rosecityford.com/new/inventory/search.html',
    ),
    'vdp_url_regex' => '/\/(?:new|used|demos)\//i',
    'refine'=>false,
    'picture_selectors' => ['.pp_hoverContainer'],
    'picture_nexts' => ['.pp_next'],
    'picture_prevs' => ['.pp_previous'],
        'details_start_tag' => 'header.mobile-header',
        'details_end_tag' => 'class="conditionsFooter -w50p">',
        'details_spliter' => 'class="carBoxWrapper"',
        'data_capture_regx' => array(
            'url' => '/<a\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*/',
            //'title' => '/<div class="divSpan divSpan12 carBasics">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
            'year' => '/<a\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*/',
            'make' => '/<a\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*/',
            'model' => '/model="(?<model>[^"]+)"\s*data-year/',
            'kilometres' => '/class=\'divSpan divSpan12 carDescription elIsLoadable\'><span [^>]+><span [^>]+>(?<kilometres>[0-9 ,]+)\s*KM/',
            'price' => '/carPrice elIsLoadable[^>]+>[^>]+>(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'model' => '/Model:(?<model>[^<]+)/',
            'kilometres' => '/class=\'divSpan divSpan12 carDescription elIsLoadable\'><span [^>]+><span [^>]+>(?<kilometres>[0-9 ,]+)\s*KM/',
            'price' => '/name="vehiclePrice"\s*value="(?<price>[^"]+)/',
            'stock_number' => '/Kilometers:(?<kilometres>[^<]+)/',
            'kilometres' => '/Kilometers:(?<kilometres>[^<]+)',
            'engine' => '/specsEngine\'>Engine:\s(?<engine>[^<]+)/',
            'transmission' => '/specsTransmission\'>Transmission:\s(?<transmission>[^<]+)/',
            'exterior_color' => '/specsTransmission\'>Transmission:\s(?<exterior_color>[^<]+)/',
            'body_style' => '/specsBodyType\'>Category:\s(?<body_style>[^<]+)/',
            'vin'           => '/VIN:(?<vin>[^<]+)/',
        ),
         
   
    'images_regx' => '/image":\["(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/og:image"\s*content="(?<img_url>[^"]+)/'
);

   add_filter("filter_rosecityford_field_images", "filter_rosecityford_field_images");

    function filter_rosecityford_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'White/front45.png');
        });
    }