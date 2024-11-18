<?php
global $scrapper_configs;
$scrapper_configs["cittecenter"] = array(
    "entry_points" => array(
        'used' => 'https://cittecenter.com/newandusedcars?clearall=1&pagesize=75',
    ),
    'vdp_url_regex' => '/\/vdp\/[0-9].*\//i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['#SinglePhotoCarousel > div > div > img'],
    'picture_nexts' => ['span.carousel-control-next-icon'],
    'picture_prevs' => ['span.carousel-control-prev-icon'],
    'details_start_tag' => '<div id="ContentPane"',
    'details_end_tag' => '</main>',
    'details_spliter' => '<div class="i05r-vehicle">',

    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>\s(?<stock_number>[^<]+)/',
        'url' => '/vehicleTitleWrap.*\s.*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+))/',
        'title' => '/vehicleTitleWrap.*\s.*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+))/',
        'year' => '/vehicleTitleWrap.*\s.*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+))/',
        'make' => '/vehicleTitleWrap.*\s.*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+))/',
        'model' => '/vehicleTitleWrap.*\s.*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+))/',
        'price' => '/lblPrice">(?<price>[^<]+)/',
        'exterior_color' => '/Color:[^>]+>\s(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior:[^>]+>\s(?<interior_color>[^\s]+)/',
        'engine' => '/Engine:[^>]+>\s(?<engine>[^<]+)/',
        'transmission' => '/Trans:[^>]+>\s(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:[^>]+>\s(?<kilometres>[^\s]+)/',
        'drivetrain' => '/Drive:[^>]+>\s(?<drivetrain>[^<]+)/',
        'vin' => '/VIN:[^>]+>\s(?<vin>[^<]+)/'
    ),
    'data_capture_regx_full' => array(
       // 'trim' => '/<label>Trim:[^>]+>\s(?<trim>[^<]+)/',
    ),
    'images_regx' => '/<img data-src=\'(?<img_url>[^\']+)/'
);

   add_filter("filter_cittecenter_field_images", "filter_cittecenter_field_images");
    
    function filter_cittecenter_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'newarrivalphoto.jpg');
        });
    }