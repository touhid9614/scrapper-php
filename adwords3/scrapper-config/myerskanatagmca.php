<?php
global $scrapper_configs;
$scrapper_configs["myerskanatagmca"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.myerskanatagm.ca/VehicleSearchResults?search=new',
        'used' => 'https://www.myerskanatagm.ca/VehicleSearchResults?search=preowned',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="content" template="content"><div class="title"',
    'data_capture_regx' => array(
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine".*\s*[^>]+>\s*[^>]+>(?<engine>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
         'stock_number' => '/Stock Number<\/span>\s*[^"]+"\s*[^"]+"\s*itemprop="sku">(?<stock_number>[^<]+)/',
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
);

add_filter("filter_myerskanatagmca_next_page", "filter_myerskanatagmca_next_page", 10, 2);
add_filter("filter_myerskanatagmca_field_images", "filter_myerskanatagmca_field_images");

function filter_myerskanatagmca_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

function filter_myerskanatagmca_field_images($im_urls)
    {
        $retval = [];
        
        foreach($im_urls as $img)
        {
            {
            
             $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
        }
        
        }
        
        return $retval;
    }

  add_filter("filter_myerskanatagmca_field_price", "filter_myerskanatagmca_field_price", 10, 3);
     function filter_myerskanatagmca_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/itemprop="name">MSRP[^>]+>\s*[^>]+>(?<price>[^<]+)/';
       

                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
       
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }

    
   

    add_filter("filter_myerskanatagmca_field_stock_number", "filter_myerskanatagmca_field_stock_number");
    
    function filter_myerskanatagmca_field_stock_number($stock_number)
    {
        if ( $stock_number == 'N/A') { $stock_number = ''; } 
        return $stock_number;
    }