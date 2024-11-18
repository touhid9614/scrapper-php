<?php
global $scrapper_configs;
 $scrapper_configs["regencymotors"] = array( 
	"entry_points" => array(
        'used' => 'https://www.regencymotors.biz/InventoryModule/RefreshInventoryModule?pagename=newandusedcars&newused=&year=&makename=&color=&intcolor=&inttype=&alltype=&fueltype=&cylinders=&vehicledrivetypename=&trans=&opensearch=&pricelowpricehigh=1999%3B48850&pricelow=&pricehigh=&mileagelowmileagehigh=2347%3B230500&mileagelow=&mileagehigh=&sortby=abc&pagesize=100&did=17912&page=1&issidefiltershown=false&X-Requested-With=XMLHttpRequest&_=1564896320023',
    ),

    'vdp_url_regex' => '/\/vdp\/[0-9]+\/Used-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.carousel-inner div img'],
    'picture_nexts' => ['.carousel-control-next'],
    'picture_prevs' => ['.carousel-control-prev'],
    'details_start_tag' => '<div class="topResults row">',
    'details_end_tag' => '<div id="PagerBottom" class="PagerBottom row">',
    'details_spliter' => '<div class="i11r-vehicle">',

    'data_capture_regx' => array(
        'stock_number' => '/Stock #:<\/label>\s*(?<stock_number>[^<\n]+)/',
        'url'       => '/vehicleTitle">\s*<a.*href="(?<url>[^"]+)">/',
        'year'      => '/vehicleTitle">\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'make'      => '/vehicleTitle">\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'model'     => '/vehicleTitle">\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'trim'      => '/vehicleTitle">\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'price'     => '/price-1\'>(?<price>\$[0-9,]+)/',
        'exterior_color' => '/Color:<\/label>(?<exterior_color>[^<\n]+)/',
        'engine' => '/Engine:<\/label>(?<engine>[^<\n]+)/',
        'transmission' => '/Trans:<\/label>(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/label>\s*(?<kilometres>[^<\n]+)/',
    ),

    'data_capture_regx_full' => array(
        'interior_color' => '/Interior Color:<\/label>\s*(?<interior_color>[^<]+)/',
        'description' => '/aria-labelledby="detailsHeading[^>]+>[^>]+>\s*(?<description>[^<]+)/',
        'vin' => '/Vin:<\/label>\s*(?<vin>[^<]+)/',
        'drivetrain' => '/Drive Train:<\/label>\s*(?<drivetrain>[^<]+)/',
        'fuel_type' => '/Fuel Economy:<\/label>\s*(?<fuel_type>[^<]+)/',
        'transmission' => '/Transmission:<\/label>\s*(?<transmission>[^<]+)/',
    ),

    'next_query_regx' => '/dxp-num dxp-current">[^\/]+\/b><a class="dxp-num" onclick="__doPostBack\(&#39;ctl02\$ctl00\$ctl00\$ASPxPager(?:1|2)&#39;,+&#39;(?<param>PN)(?<value>[0-9]+)+/',
    'images_regx' => '/src="(?<img_url>[^"]+)" class="img-fluid inv-image img-thumbnail/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
