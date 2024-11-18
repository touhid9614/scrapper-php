<?php

global $scrapper_configs;
$scrapper_configs["stephenwadehonda"] = array(
    "entry_points" => array(
        'new' => 'https://www.stephenwadehonda.com/new-car-inventory/pageSizeChange/1/100/~/VehicleType_~Make_~Model_~Trim_~Year_~Price1_~Mileage_~EPAHighway_~TransmissionGeneric_~ExteriorColorGeneric_/~/1000',
        'used' => 'https://www.stephenwadehonda.com/used-car-inventory/pageSizeChange/7/100/~/VehicleType_~Make_~Model_~Trim_~Year_~Price1_~Mileage_~EPAHighway_~TransmissionGeneric_~ExteriorColorGeneric_/~/1000'
    ),
    'vdp_url_regex' => '/\/detail\/(?:New|Certified|Used)-[0-9]{4}-/i',
     'picture_selectors' => ['.item img'],
    'picture_nexts' => ['.glyphicon-chevron-right'],
    'picture_prevs' => ['.glyphicon-chevron-left'],
    'details_start_tag' => '<div class="col-md-9">',
    'details_end_tag' => '<footer id="footer"',
    'details_spliter' => 'class="col-sm-6 col-md-4 col-lg-3 block-section ">',
    'data_capture_regx' => array(
        'url' => '/d="link_[^"]+" value="(?<url>[^"]+)">.*\s*<h4>(?<title>(?:New|Used)\s*(?<year>[0-9]{4}) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'title' => '/d="link_[^"]+" value="(?<url>[^"]+)">.*\s*<h4>(?<title>(?:New|Used)\s*(?<year>[0-9]{4}) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'year' => '/d="link_[^"]+" value="(?<url>[^"]+)">.*\s*<h4>(?<title>(?:New|Used)\s*(?<year>[0-9]{4}) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'make' => '/d="link_[^"]+" value="(?<url>[^"]+)">.*\s*<h4>(?<title>(?:New|Used)\s*(?<year>[0-9]{4}) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'model' => '/d="link_[^"]+" value="(?<url>[^"]+)">.*\s*<h4>(?<title>(?:New|Used)\s*(?<year>[0-9]{4}) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'stock_number' => '/Stock #:<\/span><[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/SWAG Price:<\/span><[^>]+>(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'engine' => '/Engine:<\/span><[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span><[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color:<\/span><[^>]+>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Color:<\/span><[^>]+>(?<interior_color>[^<\[]+)/',
        'kilometres' => '/Mileage:<\/span><[^>]+>(?<kilometres>[^<]+)/',
        'price' => '/SWAG Price.*:<\/span><[^>]+>(?<price>\$[0-9,]+)/',
    ),
    //'next_page_regx' => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '/<img class="img-responsive center-block" src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
