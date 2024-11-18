<?php

global $scrapper_configs;

$scrapper_configs['actionautochryslerdodgejeep'] = array(
    'entry_points' => array(
        'used' => 'https://www.actionautochryslerdodgejeep.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        'new' => 'https://www.actionautochryslerdodgejeep.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1'
    ),
       'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
       // 'ajax_url_match' => '/ajax/xxSubmitForm.asp',
        'use-proxy' => true,
        'picture_selectors' => ['.pswp-thumbnail'],
        'picture_nexts' => ['.pswp__button--arrow--right'],
        'picture_prevs' => ['.pswp__button--arrow--left'],
        'custom_data_capture' => function($url, $data) {

            $objects = json_decode($data);

            if (!$objects) {
                slecho($data);
            }

            $to_return = array();

            foreach ($objects->pageInfo->trackingData as $obj) {

                $car_data = array(
                    'stock_number' => !empty($obj->stockNumber) ? $obj->stockNumber : $obj->vin,
                    'stock_type' => $obj->newOrUsed,
                    'vin' => $obj->vin,
                    'year' => $obj->modelYear,
                    'make' => $obj->make,
                    'model' => $obj->model,
                    'body_style' => $obj->bodyStyle,
                    'price' => $obj->pricing->finalPrice,
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                    'url' => "https://www.actionautochryslerdodgejeep.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                                
                );

                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   
);
        
 add_filter("filter_actionautochryslerdodgejeep_next_page", "filter_actionautochryslerdodgejeep_next_page", 10, 2);       
 function filter_actionautochryslerdodgejeep_next_page($next, $current_page) {

    
        slecho("Filtering Next url :");
	$page_nums  = explode('/', $current_page);
        $page_num   = $page_nums[count($page_nums) - 1];
        $str_prev   = "pagenum/" . $page_num;
        $page_num   = $page_num + 1;
        $str_next   = "pagenum/" . $page_num;
        
        $next       = $current_page . str_replace($str_prev,$str_next,$current_page);
	return urlCombine($current_page, "?search={$car_type[count($car_type) - 1]}");

        if (stripos($current_page, $start_tag)) {
            $resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
        }

        if (strpos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }

        $rep_value = $resp + 16;


        $find = "start=" . $resp;
        $rep = "start=" . $rep_value;
        $next = str_replace($find, $rep, $current_page);
        slecho($next);
    
    return $next;
}
add_filter("filter_actionautochryslerdodgejeep_field_images", "filter_actionautochryslerdodgejeep_field_images");
    
    function filter_actionautochryslerdodgejeep_field_images($im_urls)
    {
       if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }