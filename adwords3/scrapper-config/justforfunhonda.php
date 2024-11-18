<?php

    global $scrapper_configs;

    $scrapper_configs['justforfunhonda'] = array(
        'entry_points' => array(
             'used'   => 'https://www.justforfunhonda.com/New_Powersports_Units_For_Sale_Middlefield_OH/Major_Unit_List?fltr=pre-owned&search_keywords=&filterChange=1',
             'new'     => 'https://www.justforfunhonda.com/New_Powersports_Units_For_Sale_Middlefield_OH/Major_Unit_List?fltr=New_Inventory&search_keywords=&filterChange=1',
            //'used'   => 'https://www.justforfunhonda.com/motorcycle_ci/filterMotorcycle',
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/[^\/]+\/_?[0-9]{4}/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
        // 'init_method'       => 'GET',
        //'next_method'       => 'POST',
        'picture_selectors' => ['ul.lSPager.lSGallery li'],
        'picture_nexts'     => ['.lSAction a.lSNext'],
        'picture_prevs'     => ['.lSAction a.lSPrev'],
        'details_start_tag' => '<div class="mid-r md-flex">',
        'details_end_tag'   => '<div class="mypagination">',
        'details_spliter'   => '<div class="modal fade pop" id="trade-in-value-modal_',
        'data_capture_regx' => array(
            'stock_number'  => '/stock :<span>(?<stock_number>[^<]+)/',
            'title'         => '/mid-text-left">\s*<h3>\s*(?<title>[^<]+)/',
            'price'         => '/Retail Price:\s*[^\$]+(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/color :<span>(?<exterior_color>[^<]+)/',
            'kilometres'    => '/mileage :<span>(?<kilometres>[^<]+)/',
            'url'           => '/<a href="(?<url>[^"]+).*VIEW DETAILS/',
            'body_style'    => '/mid-r">\s*<a href="https?:\/\/[^\/]+\/(?<body_style>[^\/]+)/',
            'stock_type'    => '/condition :<span>(?<stock_type>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/Stock #:\s*(?<stock_number>[^<]+)/',
            'engine'        => '/Engine Type :[^\n]+\s*<span>(?<engine>[^<]+)/',
            'transmission'  => '/transmission :[^\n]+\s*<span>(?<transmission>[^<]+)/',
            'year'          => '/year :[^\n]+\s*<span>(?<year>[0-9]{4})/',
            'make'          => '/make :[^\n]+\s*<span>(?<make>[^<]+)/',
            'model'         => '/model :[^\n]+\s*<span>(?<model>[^<]+)/',
          
        ),
        'next_page_regx'   => '/<li class="active pgn">[^\n]*\s*<li class="(?<param>pgn)"><a href="[^"]+" data-page-number="(?<next>[^"]+)/',
        'images_regx'       => '/<li data-thumb="(?<img_url>[^"]+)/',
        'images_fallback_regx'=> '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    
    add_filter('filter_justforfunhonda_post_data', 'filter_justforfunhonda_post_data', 10, 2);
    add_filter("filter_justforfunhonda_field_images", "filter_justforfunhonda_field_images");
     add_filter('filter_justforfunhonda_field_stock_type','filter_justforfunhonda_field_stock_type');
      add_filter("filter_justforfunhonda_field_model", "filter_justforfunhonda_field_model");
      add_filter('filter_justforfunhonda_cookies', 'filter_justforfunhonda_cookies');
      
      add_filter("filter_justforfunhonda_next_page", "filter_justforfunhonda_next_page", 10, 2);


function filter_justforfunhonda_next_page($next, $current_page)
{
        if(strpos($current_page,"pre-owned")){
            slecho("Filtering Next url:" . "https://www.justforfunhonda.com/Motorcycle_Show/50/1");
            return "https://www.justforfunhonda.com/Motorcycle_Show/50/1";
        }
        else{
            slecho("Filtering Next url:" . "https://www.justforfunhonda.com/Motorcycle_Show/50/0");
            return "https://www.justforfunhonda.com/Motorcycle_Show/50/0";
        }
            
        
	
}
    
    

function filter_justforfunhonda_cookies($cookies) {
   /* if(!$cookies) {
        $cookies = "PHPSESSID=a1bjcu9iu55nb765dt6n0fkec2; path=/; domain=.www.justforfunhonda.com; HttpOnly;";
    }
    */
    slecho("Filtering cookie:". $cookies);
    return $cookies;
}

      
      function filter_justforfunhonda_field_model($model)
    {
        
        $temp2 = str_replace('™', '', $model);
        $temp3 = str_replace('®', '', $temp2);
        $temp4 = str_replace('Â', '', $temp3);
        $temp5 = str_replace('â„¢', '', $temp4);
        return $temp5;
    }
     
     function filter_justforfunhonda_field_stock_type($stock_type)
    {
        $used_stock_type = ['Pre-Owned'];
        if (in_array($stock_type,$used_stock_type)) 
        { $stock_type = 'used'; } 
        else{
            $stock_type = 'new';
        }
        
        return $stock_type;
    }

    function filter_justforfunhonda_post_data($post_data, $stock_type)
    {
        $exp = explode('=', $post_data);
        if(count($exp) == 2) {
            $exp[1]-=1;
            $exp[0]=str_replace('pgn','page',$exp[0]);
        }
        $post_data = implode('=', $exp);
       
        if($post_data == '')
        {
            $post_data = "page=0";
        }
        
        $condition = 'New_Inventory';
        
        if($stock_type == 'used') {
            $condition = 'pre-owned';
        }

        return "condition=$condition&$post_data";
    }
  
    add_filter("filter_justforfunhonda_field_price", "filter_justforfunhonda_field_price", 10, 3);
    function filter_justforfunhonda_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("justforfunhonda Price: $price");
        }
        
        $sale_regex =  '/Sale Price:\s*[^\$]+(?<price>\$[0-9,.]+)/';
       
        $matches = [];
        
        if(preg_match($sale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex sale Price: {$matches['price']}");
        }
       
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
   
    
     function filter_justforfunhonda_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            
            if(endsWith($im_url, 'Aero_Base_BRN.jpg'))
            {
                return !endsWith($im_url, 'Aero_Base_BRN.jpg');
            }
             if(endsWith($im_url, 'Metropolitan_Base_BLU.jpg'))
            {
                return !endsWith($im_url, 'Metropolitan_Base_BLU.jpg');
            }
            
            return $im_url;
            
        });
    }
