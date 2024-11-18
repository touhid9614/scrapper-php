<?php
global $scrapper_configs;
$scrapper_configs["tomahlhyundaicom"] = array( 
	'entry_points' => array(
            'used' => 'https://www.tomahlhyundai.com/used-inventory/index.htm',
        'new' => 'https://www.tomahlhyundai.com/new-inventory/index.htm',
     
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
      'details_start_tag' => '<ul class="gv-inventory-list',
    'details_end_tag' => '<div class="clearfix ft">',
     'details_spliter'   => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)" class="url">(?<title>[^<]+)/',
        'title' => '/<a href="(?<url>[^"]+)" class="url">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/>Tom\'s Price[^>]+>\s*[^>]+>(?<price>[^<]+)/',
        
      
    ),
    'data_capture_regx_full' => array(
          'stock_number' => '/Stock:[^>]+>(?<stock_number>[^\<]+)/',
        'engine' => '/>Engine[^>]+>[^>]+>[^>]+>(?<engine>[^\<]+)/',
        
        'transmission' => '/>Transmission[^>]+>[^>]+>(?<transmission>[^\<]+)/',
        'exterior_color' => '/>Exterior Color[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/>Interior Color[^>]+>[^>]+>[^>]+>(?<interior_color>[^\<]+)/',
       'vin' => '/>VIN:[^>]+>(?<vin>[^<]+)/',
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)" class="btn btn-xsmall btn-xs next-btn"/',
    'images_regx' => '/id"[^"]+"src"[^"]+"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_tomahlhyundaicom_field_images", "filter_tomahlhyundaicom_field_images");
function filter_tomahlhyundaicom_field_images($im_urls) {
    
     $retval = [];    
        foreach($im_urls as $img)
        {
           
           $retval[] = str_replace(['|','%20','?impolicy=resize&w=650','?impolicy=resize&w=414','?impolicy=resize&w=768'], ['%7C','', '','',''], $img);
        }
        return $retval;

}

add_filter("filter_tomahlhyundaicom_field_price", "filter_tomahlhyundaicom_field_price", 10, 3);

function filter_tomahlhyundaicom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
       $sale_regex       =  '/Sale Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    
  $finel_regex       =  '/label">Price\s*[^>]+>\s*[^>]+>(?<price>[^<]+)/';
                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
        if(preg_match($sale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex sale: {$matches['price']}");
        }
           if(preg_match($finel_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex final: {$matches['price']}");
        }
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
