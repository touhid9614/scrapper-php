<?php
global $scrapper_configs;
$scrapper_configs["hallmangmcom"] = array( 
	"entry_points" => array(
        'new' => 'https://www.hallmangm.com/new/',
        'used' => 'https://www.hallmangm.com/used/',
      
    ),
    'vdp_url_regex'          => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next'],
    'picture_prevs'          => ['.prev'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer class="',
    'details_spliter'        => '<!-- vehicle-list-cell -->',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span\s*style=\'/',
        'year'           => '/itemprop=\'releaseDate\'[^>]+>(?<year>[0-9]+)/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain'     => '/"driveTrain":"(?<drivetrain>[^"]+)/'
    ),
    'data_capture_regx_full' => array(
        'make'           => '/itemprop=\'manufacturer\' notranslate>[^>]+>(?<make>[^\s*]+)/',
        'model' => '/model[^=]+=[^\']\'(?<model>[^\']+)/',
        'kilometres'     => '/Mileage[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin'            => '/\&vin=(?<vin>[^\&]+)/',
        'fuel_type'      => '/itemprop="fuelType">(?<fuel_type>[^<]+)/',
        'description'    => '/name="description" content="(?<description>[^"]+)/',
        'custom'         => '/Location Alert:\s*<\/strong>(?<custom>[^o]+)/',
    ),
    'next_page_regx'         => '/rel="next"\shref="(?<next>[^"]+)"/',
    'images_regx'            => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)/'
);


     add_filter('filter_hallmangmcom_field_price', 'filter_hallmangmcom_field_price',10,3);

    
    function filter_hallmangmcom_field_price($price,$car_data,$spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
   
        $sale_regex     =  '/Our Price:[^>]+>[^>]+>[^>]+>[^>]+>\s*[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
              
        $matches = [];
       
        if(preg_match($sale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex sale: {$matches['price']}");
        }
       
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }

