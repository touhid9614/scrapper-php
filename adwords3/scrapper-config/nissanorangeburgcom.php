<?php
global $scrapper_configs;
$scrapper_configs["nissanorangeburgcom"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.nissanorangeburg.com/inventory/New/',
        'used' => 'https://www.nissanorangeburg.com/inventory/Used/'
    ),
    'use-proxy' => true,
    'refine'=>false,
    'vdp_url_regex' => '/\/inventory\/(?:New|Certified|Used)/i',
    'ty_url_regex' => '/\/inventory\/thank_you/i',
    'picture_selectors' => ['.slick-lightbox-slick-img'],
    'picture_nexts' => ['.slick-next'],
    'picture_prevs' => ['.slick-prev'],
    'details_start_tag' => 'class="srpVehicles__wrap">',
    'details_end_tag' => 'class="disclaimer__wrap">',
    'details_spliter' => 'id="carbox__',
    'data_capture_regx' => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
        //'title' => '/wrap-carbox-title"> <h2>[^\s]+\s(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'year' => '/vehicle-title--year">\s*(?<year>[^<]+)/',
        'make' => '/vehicle-title--make ">\s*(?<make>[^<]+)/',
        'model' => '/vehicle-title--model ">\s*(?<model>[^<]+)/',
        'trim' => '/title-trim[^>]+>\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/Retail Price<\/div>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx' => '/data-lightbox="(?<img_url>[^"]+)"/',
);

 add_filter("filter_nissanorangeburgcom_field_price", "filter_nissanorangeburgcom_field_price", 10, 3);
        function filter_nissanorangeburgcom_field_price($price,$car_data, $spltd_data)
        {
            $prices = [];

            slecho('');

            if($price && numarifyPrice($price) > 0) {
                $prices[] = numarifyPrice($price);
                slecho("nissanorangeburgcom Price: $price");
            }

            $msrp_regex =  '/MSRP<\/div>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[0-9,]+)/';
            $net_regex  =  '/Net Price<\/div>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[0-9,]+)/';
           

            $matches = [];

            if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex MSRP: {$matches['price']}");
            }
            
            if(preg_match($net_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex Net: {$matches['price']}");
            }

           

            if(count($prices) > 0) {
                $price = butifyPrice(min($prices));
            }

            slecho("Sale Price: {$price}".'<br>');
            return $price;
        }


add_filter("filter_nissanorangeburgcom_field_images", "filter_nissanorangeburgcom_field_images",10,2);

     function filter_nissanorangeburgcom_field_images($im_urls,$car_data)
    {
       
    if(isset($car_data['url']) && $car_data['url'])
    {   
      
       $api_url="https://www.nissanorangeburg.com/api/ajax_requests/?currentQuery=".$car_data['url'];
       $response_data = HttpGet($api_url);
       $regex       =  '/url":"(?<img_url>[^"]+)","is_stock/';
       
        $matches = [];
         $retval = array();
        
        if (preg_match_all($regex, $response_data, $matches)) {

            foreach ($matches['img_url'] as $key => $value) {
                $retval= str_replace(['\\'], [''], rawurldecode($value));
                $im_urls[] = $retval;
            }
           
        }
    }
    
    return  $im_urls;
}

