<?php

global $scrapper_configs;
$scrapper_configs["holidayfordusa"] = array(
    "entry_points" => array(
        'new' => 'https://www.holidayfordusa.com/new-cars-fond-du-lac-wi.html',
        'used' => 'https://www.holidayfordusa.com/used-cars-fond-du-lac-wi.html'
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'picture_selectors' => ['div.carousel__item img'],
    'picture_nexts' => ['.js-carousel__control--next'],
    'picture_prevs' => ['.js-carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<footer class="full margin-top-4x',
    'details_spliter' => '<div id="srpVehicle',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)">\s*<span class="notranslate">(?<title>[^<]+)/',
        'title' => '/<a href="(?<url>[^"]+)">\s*<span class="notranslate">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^\"]+)/',
        'make' => '/data-make="(?<make>[^\"]+)/',
        'model' => '/data-model="(?<model>[^\"]+)/',
        'trim' => '/data-trim="(?<trim>[^\"]+)/',
        'stock_number' => '/Stock #: <\/strong>\s*(?<stock_number>[^<]+)/',
        'price' => '/Simplified Price: <\/span><span [^>]+>(?<price>\$[0-9,]+)/',
        'engine' => '/Engine: <\/strong>(?<engine>[^<]+)/',
        'transmission' => '/Transmission: <\/strong>(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext. Color: <\/strong>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Int. Color: <\/strong>(?<interior_color>[^<]+)/',
        'kilometres' => '/Mileage: <\/strong>(?<kilometres>[^<]+)/',
        'body_style' => '/Body Style: <\/strong>(?<body_style>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<li\s*class="active[^>]+>[\s\S]+?<\/li>\s*<li\s*>\s*<a[\s\S]+?href="(?<next>[^"]+)"/',
    'images_regx' => '/<img src="(?<img_url>[^"]+)height=[^"]+" alt="/'
);
