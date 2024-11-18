<?php
    global $scrapper_configs;

    $scrapper_configs['integritywheels'] = array(
        'entry_points' => array(
            'used'  => 'http://www.integritywheels.ca/inventory/used'
        ),
        'use-proxy' => true,
        'details_start_tag' => '<div class="column-right vehicle-list">',
        'details_end_tag'   => '<div class="bottom">',
        'details_spliter'   => '<a class="article statevent-click',
        'data_capture_regx' => array(
            'url'           => '/href="(?<url>[^"]+)">[^<]+<img src="http:\/\/sites.autovelocity.ca\/images\/vehicles\/srp-blank.png"/',
            'title'         => '/<span class="vehicle-header">(?<title>(?<year>[^ ]+) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'year'          => '/<span class="vehicle-year">(?<year>[0-9]{4})/',
            'make'          => '/<span class="vehicle-make">(?<make>[^<]+)/',
            'model'         => '/<span class="vehicle-model">(?<model>[^<]+)/',
            'trim'          => '/<span class="vehicle-trim">(?<trim>[^<]+)/',
            'stock_number'  => '/<span class="vehicle-stock">(?<stock_number>[^<]+)/',
            'price'         => '/<span class="vehicle-price">(?<price>[^<]+)/',
            'engine'        => '/<span class="vehicle-engine">(?<engine>[^<]+)/',
            'transmission'  => '/<span class="vehicle-transmission">(?<transmission>[^<]+)/',
            'kilometres'    => '/<span class="vehicle-odometer">(?<kilometres>[^<]+)/',
            'exterior_color'=> '/<span class="vehicle-color">(?<exterior_color>[^<]+)/',
            'body_style'    => '/<span class="vehicle-style">(?<body_style>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            // 'stock_number'  => '/Stock #:<\/span><\/div> <span class="field-text">(?<stock_number>[^<]+)/',
            // 'price'         => '/class="price"[^>]*>(?<price>[^<]+)<\/span>(?:<br \/><span style="font-size: 10pt;" class="oldprice">[^<]+<\/span>)?<\/div><div style="[^"]+" class="internetprice">Price:/',
            // 'engine'        => '/Engine:<\/span><\/div> <span class="field-text">(?<engine>[^<]+)/',
            // 'transmission'  => '/Transmission:<\/span><\/div> <span class="field-text">(?<transmission>[^<]+)/',
            // 'kilometres'    => '/Kilometers:<\/span><\/div> <span class="field-text">(?<kilometres>[^<]+)/',
            // 'exterior_color'=> '/Colour:<\/span><\/div> <span class="field-text">(?<exterior_color>[^<]+)/',
            // 'body_style'    => '/Body Style:<\/span><\/div> <span class="field-text">(?<body_style>[^<]+)/'
        ) ,
        'options_start_tag' => '<h3>Features</h3>',        
        'options_end_tag'   => '$(document).ready(function() {',        
        'options_regx'      => '/<li>(?<option>[^<]+)</',        
        'images_regx'       => '/<img src=\'(?<img_url>http:\/\/media.[^-]+-large\.jpg)\'/'
    );


