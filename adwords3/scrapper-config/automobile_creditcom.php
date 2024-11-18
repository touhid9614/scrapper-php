<?php
global $scrapper_configs;
$scrapper_configs["automobile_creditcom"] = array( 
	"entry_points" => array(
	    'used' => 'https://automobile-credit.com/vehicules-actuellement-disponible/',
    ),
    'vdp_url_regex' => '/\/vehicule-disponible-en-financement-specialise\/[A-Za-z0-9]+-[A-Za-z0-9]+-/i',
    'use-proxy' => true,
    
    'details_start_tag' => '<div class="auto-listings-view-switcher">',
    'details_end_tag' => '<div class="full-width lower">',
    'details_spliter' => '<li class="col-2 post-',
    
    'data_capture_regx' => array(
        
        'title' => '/<h3 class="title">\s*<a href="(?<url>[^"]+)"\s*title="(?<title>[^"]+)"/',
        'price' => '/<span class="currency-symbol">[^>]+>(?<price>[0-9,.]+)/',
        'transmission' => '/<i class="auto-icon-transmission">[^>]+>(?<transmission>[^<]+)/',
        'kilometres' => '/<i class="auto-icon-odometer"><\/i>\s*(?<kilometres>[0-9,\s]+)/',
        'url' => '/<h3 class="title">\s*<a href="(?<url>[^"]+)"\s*title="(?<title>[^"]+)"/'
    ),
    
    'data_capture_regx_full' => array(   
            'year'  =>  '/Ann\ée<\/th>\s*<td>(?<year>[0-9]{4})/',
            'make'  => '/Marque<\/th>\s*<td>(?<make>[^<]+)/',
            'model' => '/Mod\èle<\/th>\s*<td>(?<model>[^<]+)/',
            'exterior_color' => '/Couleur<\/th>\s*<td>(?<exterior_color>[^<]+)/',
            'trim'  => '/V\éhicule<\/th>\s*<td>(?<trim>[^<]+)/',
            'stock_number'   => '/Enregistrement<\/th>\s*<td>(?<stock_number>[^<]+)/',
        ) ,
    'images_regx' => '/<li data-thumb="(?<img_url>[^\?]+)\?/',
);