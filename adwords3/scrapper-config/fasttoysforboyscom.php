<?php
global $scrapper_configs;
 $scrapper_configs["fasttoysforboyscom"] = array( 
	  'entry_points' => array(
        'new'   => 'https://www.fasttoysforboys.com/imglib/Inventory/cache/1790/VehInv.js?v=7833326',
        //'used'  => 'https://www.fasttoysforboys.com/imglib/Inventory/cache/2229/UVehInv.js?v=9727781',
    ),
    'vdp_url_regex'     => '/\/default.asp\?page=xInventoryDetail/i',
    'required_params'   => array('page','id'),
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.vehicle-thumb '],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],
   'details_start_tag'     => 'var Vehicles=',   
 
         
    'custom_data_capture' => function($url, $data) {
     
        $tdata = trim(substr($data, strlen('var Vehicles=')), ';');
        $objects = json_decode($tdata);

        if (!$objects) {
            slecho($tdata);
        }

        $to_return = array();

        foreach ($objects as $obj) {


    if ($obj->imageOverlayText === 'Sold') { continue; }
              
                   $url="https://www.fasttoysforboys.com/default.asp?page=xInventoryDetail";
               
               $car_data = array(

                   'transmission'      => $obj->transmission,
                   'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'year'              => $obj->bike_year,
                   'make'              => $obj->manuf,
                   'model'             => $obj->model,
                   'body_style'        => $obj->vehtypename,
                   'stock_type'        => $obj->type == 'U'?'used':'new',
                   'price'             => !empty($obj->price)?$obj->price :(!empty($obj->retail_price)?$obj->retail_price:'Call for Price'),
                   'kilometres'        => isset($obj->miles)?$obj->miles:'',
                   'url'               => $url.'&id='.$obj->id,
                   'exterior_color'    => $obj->color,
                   'engine'            => $obj->engine,

               );

               $to_return[] = $car_data;
           }

           return $to_return;
       },
    'images_regx'       => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
  


    
    

add_filter('filter_fasttoysforboyscom_car_data', 'filter_fasttoysforboyscom_car_data');

function filter_fasttoysforboyscom_car_data($car_data) {

    $car_data['model'] = str_replace('\'', ' inches ', $car_data['model']);

    return $car_data;
}
