<?php
    global $scrapper_configs;

    $scrapper_configs['whitecapmotors'] = array(
        'entry_points' => array(
             'used'  => 'https://www.whitecapgm.com/VehicleSearchResults?search=preowned',
            'new'   => 'https://www.whitecapgm.com/VehicleSearchResults?search=new',
           
        ),
        'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
       
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'kilometres' => '/<span not="isNumeric" class="value">(?<kilometres>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'msrp'           => '/MSRP <\/span>[^>]+>(?<msrp>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/'
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
    add_filter("filter_whitecapmotors_field_images", "filter_whitecapmotors_field_images");

    function filter_whitecapmotors_field_images($im_urls)
    {
        $retval=[];
       foreach($im_urls as $im_url) {
            $retval[] = str_replace('Width=80&Height=60','Width=800&Height=600', $im_url);
        }
        
        return $retval;
    }