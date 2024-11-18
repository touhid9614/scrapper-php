<?php

global $scrapper_configs;

$scrapper_configs['familymotorsco'] = array(
    'entry_points' => array(
        'used'=> 'http://www.familymotorsco.com/inventory/'
    ),
    'vdp_url_regex' => '/\/inventory\//i',
    'use-proxy' => true,
    'picture_selectors' => ['ul.lSPager li'],
    'picture_nexts'     => ['div.lSAction a.lSNext'],
    'picture_prevs'     => ['div.lSAction a.lSPrev'],
    
    'custom_data_capture' => function($url, $resp){
           
        $inventory= get_familymotorsco_inventory($url);
        $to_return = array();

        foreach($inventory as $obj)
        {
            $car_data = array(
                'stock_number'      => $obj->StockNumber?$obj->StockNumber:$obj->VehicleInfoId,
                'year'              => $obj->Year,
                'make'              => $obj->Make,
                'model'             => $obj->Model,
                'trim'              => $obj->Trim,
                'body_style'        => $obj->BodyType,
                'price'             => $obj->VehiclePrice,
                'engine'            => $obj->Engine,
                'transmission'      => $obj->Transmission,
                'kilometres'        => $obj->Odometer,
                'url'               => "http://www.familymotorsco.com/inventory/".strtolower($obj->Make) . '/' . strtolower($obj->Model) .
                                        '/' .strtolower($obj->StockNumber),
                'exterior_color'    => $obj->ExteriorColor,
                'interior_color'    => $obj->InteriorColor,
                
            );
            $temp_data = HttpGet($car_data['url']);

            $images_regex   = '/<li\s*data-thumb="(?<img_url>[^"]+)/';

            $matches = array();

           
            if(preg_match_all($images_regex, $temp_data, $matches))
            {
                $car_data['images']     = $matches['img_url'];
                
                $car_data['all_images'] = implode('|', $car_data['images']);
                
            }

            $to_return[] = $car_data;
        }


        return $to_return;
    },
    
   // 'images_regx' => '/<img\s*itemprop="image"\s*src="(?<img_url>[^"]+)"\s*width="526" height="394"/'
);

function get_familymotorsco_inventory($url)
{
    $matches = [];
    $inventory = [];
    $data= HttpGet($url);

    $grid_regex ='/"gridColumnCount":"(?<column_count>[^"]+)/';
    if(preg_match($grid_regex, $data, $matches))
    {
        $page_count= $matches['column_count'];
    }

    for($count=1;$count<=$page_count;$count++)
    {
        $data = HttpGet("http://www.familymotorsco.com/inventory/?pager=25&page_no=$count");
        $page_regex ='/"serviceUrl":"(?<url>[^"]+)/';
        

        if(preg_match($page_regex, $data, $matches))
        {
            $page_url[] = str_replace('\/','/','http://www.familymotorsco.com'.$matches['url']);
        }
    }
    
    foreach($page_url as $url)
    {
        $resp       = HttpGet($url);

        $start_tag  = 'dws_inventory_listing_1(';
        $end_tag    = ");";

        $resp       = trim(substr($resp, strlen($start_tag)), $end_tag);
        $object     =json_decode($resp);
        $inventory  = array_merge($inventory,$object->Vehicles);
    }
    return $inventory;
}

