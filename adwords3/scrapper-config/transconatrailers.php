<?php
    global $scrapper_configs;

    $scrapper_configs['transconatrailers'] = array(
        'entry_points' => array(
            'all'   => 'http://www.transconatrailers.com/s/Services/Search.aspx'
        ),
        'vdp_url_regex'         => '/https:\/\/www.transconatrailers.com\/(?:showcaseproductdetail.htm|[0-9]{4}-[^\.]+\.htm)\?/',
        'ajax_url_match'        => 'Services/WidgetServices.aspx',
        'ajax_resp_match'       => 'Thank you',
        'vdp_page_regex'        => '/https:\/\/www.transconatrailers.com\/(?:showcaseproductdetail.htm|[0-9]{4}-[^\.]+\.htm)\?/',
        'required_params'       => array('id', 'in-stock'),
        'use-proxy'             => true,
        'refine'                => false,
        'next_method'           => 'POST',
        'content_type'          => 'application/json',
        'custom_data_capture'   => function($url, $data){
        
            $objects = json_decode($data);
            
            if(!$objects) { slecho($data); return array(); }
            
            $to_return = array();
            
            foreach($objects->items as $obj)
            {
                if($obj->priceLabel == 'Sold') { continue; }

                $car_data = array(
                    'stock_number'      => $obj->productId,
                    'year'              => $obj->year,
                    'make'              => $obj->brand,
                    'model'             => $obj->name,
                    'body_style'        => $obj->typeStyleName,
                    'stock_type'        => $obj->used == 1?'used':'new',
                    'price'             => $obj->priceLabel == 'Web Price'?$obj->minPrice:'Call for Price',
                    'kilometres'        => isset($obj->metricValue)?$obj->metricValue:'',
                    'url'               => "https://www.transconatrailers.com/showcaseproductdetail.htm?id={$obj->productId}&in-stock=1",
                    'exterior_color'    => $obj->primaryColor,
                    'images'            => array()
                );
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx'       => '/"standardSize":"(?<img_url>[^\"]+)"/'
    );
    
    add_filter('filter_transconatrailers_post_data', 'filter_transconatrailers_post_data');
    add_filter('filter_transconatrailers_field_images', 'filter_transconatrailers_field_images');

    function filter_transconatrailers_post_data($post_data)
    {
        return '{"publicUrl":"https://www.transconatrailers.com/s/search/inventory/sort/best-match","availability":"Brochure","existingProductIds":[],"showBrochureUnits":true,"filters":{},"hasUnitInventory":true,"industries":["Power Sports","Trailers","RVs"],"locations":[{"id":"21908","city":"Winnipeg","name":"Transcona Trailer Sales Ltd.","postalCode":"R2J 0H2","region":"MB"}],"page":0,"pageSize":1000,"productIds":[],"queryString":null,"searchType":"inventory","sortType":[{"sortBy":"BestMatch","label":"Best Match","url":"best-match","ascending":true}],"subSearchType":null,"isOptionLevel":true,"isAutocompleteSearch":false,"getFacetsRule":"none"}';
       
    }
    function filter_transconatrailers_field_images($im_urls)
    {
        slecho("Inside Image filter");
        return array_filter($im_urls, function ($url){
            return !contains('Stock%20Image', $url);
        });
    }