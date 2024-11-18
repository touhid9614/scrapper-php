<?php
global $scrapper_configs;
$scrapper_configs["atlantichondacom"] = array( 
	'entry_points' => array(
           'new'   => 'https://www.atlantichonda.com/new-cars-bay-shore-ny',
            'used'  => 'https://www.atlantichonda.com/used-cars-bay-shore-ny',
        
        ),
    'vdp_url_regex'     => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
        'use-proxy' => true,
         'picture_selectors' => ['.thumb-item .thumb-preview'],
        'picture_nexts'     => ['.navigation-arrow.navigation-right'],
        'picture_prevs'     => ['.navigation-arrow.navigation-left'],
        
        'details_start_tag' => '<div class="vehicles">',
       'details_end_tag' => '<div class="inventory-pagination">',
        'details_spliter' => '<div class="vehicle-container">',
        'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/',
            'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/MSRP:\s*<\/div>\s*[^>]+>\s*[^>]+>(?<price>[^<]+)/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            

        ),
        'data_capture_regx_full' => array(
            'interior_color'=> '/Interior:.*\s*<span class="value">(?<interior_color>[^<]+)/',
            'trim'          => '/Trim:.*\s*<span class="value">(?<trim>[^ <]+)/',
            'engine'        => '/Engine:<\/span>\s*[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/span>\s*[^>]+>(?<transmission>[^<]+)/',
            'kilometres'    => '/Mileage:<\/span>\s*[^>]+>(?<kilometres>[^<]+)/',  
             'vin'          => '/VIN #:<\/span>\s*[^>]+>(?<vin>[^<]+)/',
            
        ),
          'next_page_regx'    => '/class="pagination-next js-pagination-btn" href="(?<next>[^"]+)/',
          'images_regx'       => '/data-preview="(?<img_url>[^"]+)"/',
          'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
        );
          add_filter("filter_atlantichondacom_field_images", "filter_atlantichondacom_field_images");
    function filter_atlantichondacom_field_images($im_urls) {

  $retvals = [];

    foreach ($im_urls as $img) {
        $retvals[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }
    return array_filter($retvals, function ($retval) {
        return !(endsWith($retval,'noimage_folsom.jpg'));
    });
}
add_filter("filter_atlantichondacom_field_price", "filter_atlantichondacom_field_price", 10, 3);


function filter_atlantichondacom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("Adjusted Price: $price");
    }

    $finance_regex = '/Finance For:[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<price>[^<]+)/';
    $retail_regex = '/Retail Price:\s*<\/div>\s*[^>]+>\s*[^>]+>(?<price>[^<]+)/';
    $matches = [];

    if (preg_match($finance_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex finance: {$matches['price']}");
    }
   if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail: {$matches['price']}");
    }
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}