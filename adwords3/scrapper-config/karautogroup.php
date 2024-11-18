<?php
    global $scrapper_configs;

    $scrapper_configs['karautogroup'] = array(
        'entry_points' => array(
            'used'  => 'https://www.karautogroup.com/used-cars',
            'new'   => 'https://www.karautogroup.com/new-cars',
            
        ),
        'vdp_url_regex'     => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
     //   'ty_url_regex'      => '/\/eprice-[^\?]+\?.*form-action=success/i',
         'use-proxy' => true,
        'refine'     => false,
        
        'picture_selectors' => ['.thumb-item .thumb-preview'],
        'picture_nexts'     => ['.navigation-arrow.navigation-right'],
        'picture_prevs'     => ['.navigation-arrow.navigation-left'],
        
        'details_start_tag' => '<div class="c-vehicles list">',
        'details_end_tag'   => '<div class="com-inventory-listing-pagination row',
        'details_spliter'   => '<div class="vehicle"',
         'must_contain_regx' 	=> '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        
        'data_capture_regx' 	=> array(
            'stock_number'  	=> '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'url'           	=> '/<meta itemprop="url" content="(?<url>[^"]+)/',
            'title'         	=> '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          	=> '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          	=> '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         	=> '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         	=> '/<meta itemprop="price" content="(?<price>[^"]+)/',
            'exterior_color'	=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'engine'        	=> '/<span class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
            'transmission'  	=> '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
            'kilometres'    	=> '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
          //'certified'     	=>'/<img\s*src="[^"]+"\s*alt="Certified"\s*class="[^"]+"\s*title="(?<certified>[^"]+)"/'

        ),
        'data_capture_regx_full'=> array(
            'trim'          	=> '/Trim:<\/span>\s*<span[^>]+>(?<trim>[^<]+)/',
            //'model'         	=> '/Model:<\/strong><\/span>\s*<span[^>]+>(?<model>[^<]+)/',
            'body_style'    	=> '/Body style:<\/span>\s*<span[^>]+>(?<body_style>[^<]+)/',
          //'interior_color'	=> '/Interior:<\/strong><\/span>\s*<span[^>]+>(?<interior_color>[^<]+)/',
          //  'kilometres'    	=> '/Mileage:<\/strong><\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',
        ),
        'next_page_regx'    	=> '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       	=> '/data-preview="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_karautogroup_field_images", "filter_karautogroup_field_images");
    add_filter("filter_karautogroup_field_price", "filter_karautogroup_field_price", 10, 3);

    
    function filter_karautogroup_field_images($im_urls)
    {   
        if(count($im_urls) < 2) { return array(); }
        
        return array_filter($im_urls, function($im_url){
            
            return !endsWith($im_url, '581_cc0640_001_PY.jpg');
        });
    }
    
    function filter_karautogroup_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Price: $price");
        }
        slecho("Info:Price not found.");
        if (empty($price)){
            $msrp_regex     =  '/<span>(?<price>\$[0-9,]+)<\/span>\s*msrp/';
            $sale_regex     =  '/>Sale Price:\s*(?<price>\$[0-9,]+)/';
            $price_regex    =  '/"price js-price-info">(?<price>\$[0-9,]+)/';


            $matches = [];

            if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex MSRP: {$matches['price']}");
            }
            if(preg_match($sale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex sale: {$matches['price']}");
            }
            if(preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex price: {$matches['price']}");
            }



            if(count($prices) > 0) {
                $price = butifyPrice(min($prices));
            }
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }