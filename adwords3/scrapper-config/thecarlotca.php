<?php
global $scrapper_configs;
$scrapper_configs["thecarlotca"] = array( 
	'entry_points' => array(
        'new' => 'https://www.thecarlot.ca/new/',
        'used' => 'https://www.thecarlot.ca/used/ma/Audi%7CBuick%7CChevrolet%7CDodge%7CFord%7CGMC%7CHonda%7CInfiniti%7CHyundai%7CJeep%7CKia%7CLincoln%7CMazda%7CMercedes-Benz%7CNissan%7CRAM%7CSubaru%7CToyota%7CVolkswagen/priceF/0/priceT/100000/'
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<div class="ajax-loading"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
        'make'   => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model'  => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'trim' => '/"trim":"(?<trim>[^"]+)"/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain' => '/"driveTrain":"(?<drivetrain>[^"]+)/',
        'vin' => '/itemprop="sku">(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',    
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/onerror="imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
);

 add_filter("filter_thecarlotca_field_images", "filter_thecarlotca_field_images");
    
    function filter_thecarlotca_field_images($im_urls)
     {
        if(count($im_urls)<2)
             {
             return [];
            
             }
       
         return $im_urls;
    }