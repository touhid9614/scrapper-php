<?php

    global $scrapper_configs;

    $scrapper_configs['dilawrinissan'] = array(
        'entry_points' => array(
            'new'   => 'http://dilawrinissan.ca/inventory/new/',
//            'new' => 'http://dilawrinissan.ca/inventory/?limit=100000&page=1&condition=new',
            'used'  => 'http://dilawrinissan.ca/inventory/used/'
        ),
        //'use-proxy' => true,
        'details_start_tag' => '<div id="inventory-list">',
        'details_end_tag'   => '<div id="paging_footer">',
        'details_spliter'   => '<div class="inventory-listing"',
        'data_capture_regx' => array(
            'url'           => '/data-url="(?<url>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/<dt>Stock #:<\/dt>\s*<dd>(?<stock_number>[^<]+)/',
            'title'         => '/<h1 class="(?:new|used)-page-header">\s*(?:New|Used) (?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^\s]+)[^\n]*)/',
            'year'          => '/<h1 class="(?:new|used)-page-header">\s*(?:New|Used) (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^\s]+)/',
            'make'          => '/<h1 class="(?:new|used)-page-header">\s*(?:New|Used) (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^\s]+)/',
            'model'         => '/<h1 class="(?:new|used)-page-header">\s*(?:New|Used) (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^\s]+)/',
            'price'         => '/<strong id="vehicle-detail-price">(?<price>[^\.<]+)/',
            'transmission'  => '/<dt>Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'exterior_color'=> '/<dt>Colour:<\/dt>\s*<dd>(?<exterior_color>[^\/<]+)/',
            'kilometres'    => '/<dt>Mileage:<\/dt>\s*<dd>(?<kilometres>[^&<]+)/'
        ) ,
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" class="nav-arrow" title="Next"><i class="glyphicon glyphicon-chevron-right">/',
        'images_regx'       => '/<a href="(?<img_url>\/images\/thumbnail.php\?type=inventory[^"]+)/'
    );
?>
