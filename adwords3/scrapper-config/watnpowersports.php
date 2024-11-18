<?php
    global $scrapper_configs;

    $scrapper_configs['watnpowersports'] = array(
        'entry_points' => array(
            'all'   => 'https://www.watnpowersports.com/s/Services/Search.aspx'
        ),
        'vdp_url_regex'         => '/https:\/\/www.watnpowersports.com\/(?:showcaseproductdetail.htm|[0-9]{4}-[^\.]+\.htm)\?/',
        'ajax_url_match'        => 'Services/WidgetServices.aspx',
        'ajax_resp_match'       => 'Thank you',
        'vdp_page_regex'        => '/https:\/\/www.watnpowersports.com\/(?:showcaseproductdetail.htm|[0-9]{4}-[^\.]+\.htm)\?/',
        'required_params'       => array('id', 'in-stock'),
        'use-proxy'             => true,
        'picture_selectors' => ['.galleria-thumbnails .galleria-image'],
        'picture_nexts'     => ['.galleria-image-nav-right'],
        'picture_prevs'     => ['.galleria-image-nav-left'],
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
                    'price'             => $obj->priceLabel == 'DMS Price'?$obj->minPrice:'Call for Price',
                    'kilometres'        => isset($obj->metricValue)?$obj->metricValue:'',
                    'url'               => "https://www.watnpowersports.com/showcaseproductdetail.htm?id={$obj->productId}&in-stock=1",
                    'exterior_color'    => $obj->primaryColor,
                    'images'            => array()
                );
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx'       => '/"standardSize":"(?<img_url>[^\"]+)"/'
    );
    
    add_filter('filter_watnpowersports_post_data', 'filter_watnpowersports_post_data');

    function filter_watnpowersports_post_data($post_data)
    {
        return '{"publicUrl":"https://www.watnpowersports.com/s/search/inventory/availability/In Stock/sort/best-match","availability":"Brochure","existingProductIds":[],"showBrochureUnits":true,"filters":{"Availability":[{"value":"In Stock","currentFilter":true}]},"hasUnitInventory":true,"industries":["Power Sports","Ag and Lawn"],"locations":[{"id":"14293","city":"Watertown","name":"Watertown Power Sports","postalCode":"13601","region":"NY"}],"page":1,"pageSize":18,"productIds":[],"queryString":null,"searchType":"inventory","sortType":[{"sortBy":"BestMatch","label":"Best Match","url":"best-match","ascending":true}],"subSearchType":null,"isOptionLevel":true,"isAutocompleteSearch":false,"getFacetsRule":"none"}';
       
    }