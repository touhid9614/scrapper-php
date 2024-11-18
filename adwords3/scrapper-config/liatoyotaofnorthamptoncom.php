<?php

global $scrapper_configs;
$scrapper_configs["liatoyotaofnorthamptoncom"] = array(
   'entry_points' => array(
        'new'   => 'https://smartpath.liatoyotaofnorthampton.com',
       
    ),
    'vdp_url_regex'     => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
    'required_params'   => array('page','id'),
    'use-proxy' => false,
    'refine'    => false,
    'picture_selectors' => ['.vehicle-thumb '],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],
    'custom_data_capture' => function($url, $resp){
           
            slecho("responeeeeeeee" . $resp) ;
           return $to_return;
       },
    
);