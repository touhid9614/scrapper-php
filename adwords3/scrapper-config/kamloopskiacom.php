<?php
global $scrapper_configs;
$scrapper_configs["kamloopskiacom"] = array(
   "entry_points" => array(
	  // 'new' => 'https://www.kamloopskia.com/new/inventory/search.html?filterid=q0-500',
        'used' => 'https://www.kamloopskia.com/used/search.html?filterid=q0-500',
    ),     
    'vdp_url_regex' => '/\/(?:new|used|demos)\/.*[0-9]{4}-/i',
    'refine'=>false,
    'picture_selectors' => ['.slide a img'],
    'picture_nexts' => ['div a.next'],
    'picture_prevs' => ['div a.previous'],
        'details_start_tag' => '<div class="divSpan divSpan12 lstListingWrapper">',
        'details_end_tag' => '<footer id="footerWrapper"',
        'details_spliter' => '<li class="carBoxWrapper"',
        'data_capture_regx' => array(
            'url' => '/<div class="divSpan divSpan12 carBasics">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
            'title' => '/<div class="divSpan divSpan12 carBasics">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
            'year' => '/<div class="divSpan divSpan12 carBasics">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
            'make' => '/<div class="divSpan divSpan12 carBasics">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
            'model' => '/<div class="divSpan divSpan12 carBasics">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
            
            'kilometres' => '/class=\'divSpan divSpan12 carDescription elIsLoadable\'><span [^>]+><span [^>]+>(?<kilometres>[0-9 ,]+)\s*KM/',
        ),
        'data_capture_regx_full' => array(
            'stock_type' => '/specsNoStock[^\:]*\:\s*[A-Za-z0-9]+-(?<stock_type>new)/',
        	'price' => '/Your price:[^>]+>\s*[^>]+>(?<price>[^<]+)/',
            'stock_number' => '/specsNoStock\'>Stock #:\s(?<stock_number>[^<]+)/',
            //'vin' => '/specsNoStock\'>Stock #:\s(?<vin>[^<]+)/',
            'kilometres' => '/specsKM\'>Kilometers:\s(?<kilometres>[0-9 ,]+)/',
            'engine' => '/specsEngine\'>Engine:\s(?<engine>[^<]+)/',
            'transmission' => '/specsTransmission\'>Transmission:\s(?<transmission>[^<]+)/',
            'exterior_color' => '/specsTransmission\'>Transmission:\s(?<exterior_color>[^<]+)/',
            'body_style' => '/specsBodyType\'>Category:\s(?<body_style>[^<]+)/',
           // 'vin'           => '/specsNoStock\'>Stock #:\s(?<vin>[^<]+)/',
        ),
         
   
    'images_regx' => '/<a rel="slider-lightbox[^"]+"\shref="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta  property="og:image" content="(?<img_url>[^"]+)/'
);
add_filter("filter_kamloopskiacom_field_images", "filter_kamloopskiacom_field_images");
    
    function filter_kamloopskiacom_field_images($im_urls)
    {
       if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }