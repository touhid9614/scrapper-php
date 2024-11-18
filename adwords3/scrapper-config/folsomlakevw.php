<?php
global $scrapper_configs;
 $scrapper_configs["folsomlakevw"] = array( 
	'entry_points' => array(
            'new'   => 'https://www.folsomlakevw.com/new-volkswagen-folsom-ca',
            'used'  => 'https://www.folsomlakevw.com/used-cars-folsom-ca',
         
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
            'price'         => '/Our Price:\s*<\/div>\s*[^>]+>\s*[^>]+>(?<price>[^<]+)/',
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
          'next_page_regx'    => '/active\s+"\s*[^\n]+\s*<a[^\n]+\s*href="(?<next>[^"]+)/',
          'images_regx'       => '/<div class="gallery-.*\s*<img\s*src="(?<img_url>[^"]+)"/',
          'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
        );
          add_filter("filter_folsomlakevw_field_images", "filter_folsomlakevw_field_images");
    function filter_folsomlakevw_field_images($im_urls) {

  $retvals = [];

    foreach ($im_urls as $img) {
        $retvals[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }
    return array_filter($retvals, function ($retval) {
        return !(endsWith($retval,'noimage_folsom.jpg'));
    });
}