<?php

global $scrapper_configs;

$scrapper_configs['lawless'] = array(
    "entry_points" => array(
        
    ),
    'vdp_url_regex' => '/\/details\/(?:new|used)\/.*\/[0-9]{4}\//i',

    # Client side scrapping configuration
    'client_scrapping'  => 
    [
        'enabled'       => true,
        'idx'           => 
        [
            'vin'       => '/<td><strong>VIN<\/strong><\/td>\s*<td>(?<vin>[^<]+)<\/td>/'
        ],

        'data'          		=> 
        [
        	'stock_number' 		=> '/<td><strong>Stock No\.<\/strong><\/td>\s*<td>(?<stock_number>[^<]+)<\/td>/',
        	'stock_type'     	=> '/<span class=\'result\-condition\'>(?<stock_type>[^<]+)<\/span>/',
	        'year'           	=> '/<span class=\'result\-year\'>(?<year>[^<]+)<\/span>/',
	        'make'           	=> '/<span class=\'result\-make\'>(?<make>[^<]+)<\/span>/',
	        'model'          	=> '/<span class=\'result\-model\'>(?<model>[^<]+)<\/span>/',
	        'engine'         	=> '/<td><strong>Engine<\/strong><\/td>\s*<td>(?<engine>[^<]+)<\/td>/',
	        'trim'           	=> '/<td><strong>Package<\/strong><\/td>\s*<td>(?<trim>[^<]+)<\/td>/',
	        'url'            	=> '/<h4 class=\"panel\-title\">\s*<a href=\"(?<url>[^"]+)">/',
	        'transmission'   	=> '/<td><strong>Transmission<\/strong><\/td>\s*<td>(?<transmission>[^<]+)<\/td>/',
	        'price'          	=> '/Price<\/td>\s*<td class=\"right\">\s*(?<price>[^<]+)\s*<\/td>/',
            'exterior_color'	=> '/<td><strong>Color<\/strong><\/td>\s*<td>(?<exterior_color>[^<]+)<\/td>/',
            'interior_color'	=> '/<td><strong>Interior<\/strong><\/td>\s*<td>(?<interior_color>[^<]+)<\/td>/',
            'kilometres'    	=> '/<td><strong>Mileage<\/strong><\/td>\s*<td>(?<kilometres>[^<]+)<\/td>/'
        ]
    ],


    'picture_selectors' => ['.fotorama__thumb.fotorama__loaded.fotorama__loaded--img'],
    'picture_nexts' 	=> ['.fotorama__arr.fotorama__arr--next'],
    'picture_prevs' 	=> ['.fotorama__arr.fotorama__arr--prev'],
    "no_scrap" 			=> false,
    'use-proxy'         => true
);


