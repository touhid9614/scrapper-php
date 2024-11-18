<?php

global $scrapper_configs;

$scrapper_configs['drivenation'] = array(
    'entry_points'           => array(
        'used'      => 'https://www.drivenation.ca/vehicles/',
        //'special'   => 'https://tm.smedia.ca/adwords3/client-data/drivenation/DriveNation-Inventory.csv',
        
        
    ),

    'vdp_url_regex'     => '/\/(?:new|used|all)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'         => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts'     => ['.next .glyphicon'],
    'picture_prevs'     => ['.prev .glyphicon'],
    
    'used' => array(
        
    'details_start_tag' => '<div class="fwpl-layout',
        'details_end_tag'   => '<div data-elementor-type="footer"',
        'details_spliter'   => '<div class="fwpl-result',
  
        'data_capture_regx' => array(
            'url'           => '/class="fwpl-item[^>]+><a href="(?<url>[^"]+)"[^>]+>[^\:]+[^"]+"[^"]+"[^"]+" alt="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
            'year'          => '/class="fwpl-item[^>]+><a href="(?<url>[^"]+)"[^>]+>[^\:]+[^"]+"[^"]+"[^"]+" alt="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
            'make'          => '/class="fwpl-item[^>]+><a href="(?<url>[^"]+)"[^>]+>[^\:]+[^"]+"[^"]+"[^"]+" alt="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
            'model'         => '/class="fwpl-item[^>]+><a href="(?<url>[^"]+)"[^>]+>[^\:]+[^"]+"[^"]+"[^"]+" alt="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
            'price'         => '/class="fwpl-item[^>]+>\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/class="fwpl-item el-4nf6p3">(?<kilometres>[^\s*]+)/',
            
         ),
        'data_capture_regx_full' => array(
           'description'    => '/id="description"[^>]+>[^>]+>[^>]+>(?<description>[\s\S]*?(?=<\/div>))/',
            'vin'           => '/VIN<\/div>[^\.]+[^>]+>[^>]+>[^>]+>(?<vin>[^<]+)/',
            'transmission'  => '/Transmission<\/div>[^\.]+[^>]+>[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'stock_number'  => '/Stock Number<\/div>[^\.]+[^>]+>[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'drive_train'  => '/Drivetrain<\/div>[^\.]+[^>]+>[^>]+>[^>]+>(?<drive_train>[^<]+)/',
            'fuel_type'    => '/Fuel Type<\/div>[^\.]+[^>]+>[^>]+>[^>]+>(?<fuel_type>[^<]+)/', 
        ),
        'next_page_regx'    => '/data-page=[^"]+"(?<next>[0-9]*)[^"]+">Next/',
        'images_regx'       => '/data-large_image="(?<img_url>[^"]+)" data/',
    ),    
    
    'special' => array(
    'custom_data_capture' => function($url, $resp) {
        $resp_decode = convert_CSV_to_JSON($resp);
        $to_return = array();
        foreach ($resp_decode as $key => $obj) {
            $car_data = array(
                'stock_number' => $obj['vehicle_id'],
                'stock_type' => ($obj['state_of_vehicle'] == 'USED') ? 'used' : 'new',
                'year'  => $obj['year'],
                'make'  => $obj['make'],
                'model' => $obj['model'],
                'title' => $obj['title'],
                'trim'  =>explode($obj['model'],$obj['title'])[1],
                'body_style' => $obj['body_style'],
                'price' => $obj['price'],
                'transmission' => $obj['transmission'],
                'kilometres'   => $obj['mileage.value'],
                'url' => $obj['url'],
                'exterior_color' => $obj['exterior_color'],
                'custom'     => "special",
                'vin'        => $obj['vin'],
                'city'       => $obj['address.city'],

            );
            
            $response_data = HttpGet($car_data['url']);
            $regex = '/tab-title-description">[^\;]+\;(?<description>[\s\S]*?(?=<\/div>))/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
                $car_data['description']=preg_replace("/<a href=[^>]+>/", "", $car_data['description']);
                $car_data['description']=str_replace(['&#8211;','&#8217;'], ["",''], $car_data['description']);
                $car_data['description']= strip_tags($car_data['description']);

            }
            $im_urls=explode(",",$obj['image[0].url']);
            $all_images=[];
            foreach ($im_urls as $key => $val) {
            /*if(strpos($val,"www.drivenation.ca")){
               continue;
             }*/
             $all_images[]=$val;
            }
            $car_data['all_images']=implode("|",$all_images);
            $to_return[] = $car_data;
        }
        return $to_return;
    }
    ),    
);

add_filter("filter_drivenation_field_images", "filter_drivenation_field_images");
add_filter('filter_drivenation_car_data', 'filter_drivenation_car_data');
add_filter("filter_drivenation_field_description", "filter_drivenation_field_description");

    function filter_drivenation_field_description($description) {
         $description=preg_replace("/<a href=[^>]+>/", "", $description);
         $description=str_replace(['&#8211;','&#8217;'], ["",''], $description);
         return strip_tags($description);
     }

function filter_drivenation_field_images($im_urls)
{
    return array_filter($im_urls, function ($im_url) 
    {
        return !endsWith($im_url, 'new_vehicles_images_coming.png');
    });
}

function filter_drivenation_car_data($car)
{
    $arenas =
    [
        'abbotsford'    => 'abbotsford',
        'prince albert' => 'prince_albert',
        'edmonton'      => 'edmonton',
        'calgary'       => 'calgary',
        'regina'        => 'regina',
        'S7K 3T8'       => 'saskatoon_north',
        'S7N 2G9'       => 'saskatoon_south',
        'Abbotsford'    => 'abbotsford',
        'Prince Albert' => 'prince_albert',
        'Edmonton'      => 'edmonton',
        'Calgary'       => 'calgary',
        'Regina'        => 'regina',
        'Saskatoon'       => 'saskatoon_north',
        'Saskatoon'       => 'saskatoon_south',
    ];

    foreach ($arenas as $key => $value)
    {
        if (stripos($car['city'], $key) !== FALSE)
        {
            $car['city'] = $value;
            break;
        }
    }

    return $car;
}