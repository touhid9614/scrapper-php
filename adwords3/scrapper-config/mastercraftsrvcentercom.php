<?php
global $scrapper_configs;
$scrapper_configs["mastercraftsrvcentercom"] = array( 
	'entry_points' => array(
            //https://app.asana.com/0/1145853562025778/1198993294811818/f
        'used' => 'https://www.mastercraftsrvcenter.com/--inventory?condition=pre-owned&sortby=Price|desc',
        'new' => 'https://www.mastercraftsrvcenter.com/--inventory?condition=new&sortby=Price|desc&sz=50&pg=1',
    ),
    'vdp_url_regex' => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['.lS-image-wrapper'],
    'picture_nexts' => ['.lSNext'],
    'picture_prevs' => ['.lSPrev'],
    'details_start_tag' => 'class="v7list-results listview',
    'details_end_tag' => '<div class="v7list-footer">',
    'details_spliter' => '<li class="v7list-results__item"',
    'data_capture_regx' => array(
       
        'year' => '/vehicle-heading__year">(?<year>[0-9]{4})/',
        'make' => '/vehicle-heading__name">(?<make>[^<]+)/',
        'model' => '/vehicle-heading__model">(?<model>[^<]+)/',
        'url' => '/<a class="vehicle-heading__link" href="(?<url>[^"]+)"/',
        'price' => '/class="vehicle-price__price ">\s*(?<price>[^\s]+)/',
      //  'exterior_color' => '/Color:[^>]+>(?<exterior_color>[^<]+)/',
       // 'fuel_type' => '/Fuel Type:[^>]+>(?<fuel_type>[^<]+)/',
        'engine' => '/Category:[^>]+>(?<engine>[^<]+)/',
        'body_style' => '/Category:[^>]+>(?<body_style>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Stock Number[^>]+>\s*[^>]+>(?<stock_number>[^\<]+)/',
        'vin' => '/Stock Number[^>]+>\s*[^>]+>(?<vin>[^\<]+)/',
    ),
    'next_page_regx' => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results" >/',
    'images_regx' => '/lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
);
add_filter('filter_mastercraftsrvcentercom_car_data', 'filter_mastercraftsrvcentercom_car_data');

function filter_mastercraftsrvcentercom_car_data($car_data) {

    if(!isset($car_data['exterior_color'])){
        $car_data['exterior_color']="other";
    }
    if(!isset($car_data['vin'])){
        $car_data['vin']=md5($car_data['url']);
    }

    return $car_data;
}
add_filter("filter_mastercraftsrvcentercom_field_images", "filter_mastercraftsrvcentercom_field_images");
function filter_mastercraftsrvcentercom_field_images($im_urls)
{
    $retval = [];

    foreach($im_urls as $img)
    {
        $retval[] = str_replace(["&#x2F;","https://www.mastercraftsrvcenter.com/"], ["/",""], $img);
    }

    return $retval;
}
 add_filter("filter_mastercraftsrvcentercom_next_page", "filter_mastercraftsrvcentercom_next_page",10,2);

    
       function filter_mastercraftsrvcentercom_next_page($next,$current_page) {
           
           slecho($current_page);
          $next=explode('/',$next);
           $index=count($next)-1;
           $next=($next[$index]);
           $next++;
           $peg="pg=" . $next;
           $prev="pg=" . ($next-1);
           $url= str_replace($prev, $peg, $current_page);
           
            return $url;
           
   }
