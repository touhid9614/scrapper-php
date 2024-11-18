<?php

global $scrapper_configs;
$scrapper_configs["infinitisherbrooke"] = array(
    'entry_points' => array(
        'new' => 'https://www.infinitisherbrooke.com/vehicules-neufs/',
        'used' => 'https://www.infinitisherbrooke.com/auto-usage/?cities%5B%5D=Sherbrooke&dealers%5B%5D=14'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/(?:showroom|used)\//i',
    'picture_selectors' => ['#imagePreview', '.open-vdp-popover'],
    'picture_nexts' => ['.slick-next.slick-arrow'],
    'picture_prevs' => ['.slick-prev.slick-arrow'],
    'new' => array(
        'details_start_tag' => '<main id="main" class="site-main clr"',
        'details_end_tag' => '<div data-elementor-type="footer"',
        'details_spliter' => '<section class="elementor-element elementor-element-',
        'data_capture_regx' => array(
            'url' => '/<a href="(?<url>[^"]+)">(?<title>(?<make>[^ ]+) *(?<year>[0-9]+) *[^<]*)/',
            'title' => '/<a href="(?<url>[^"]+)">(?<title>(?<make>[^ ]+) *(?<year>[0-9]+) *[^<]*)/',
            'year' => '/<a href="(?<url>[^"]+)">(?<title>(?<make>[^ ]+) *(?<year>[0-9]+) *[^<]*)/',
            'make' => '/<a href="(?<url>[^"]+)">(?<title>(?<make>[^ ]+) *(?<year>[0-9]+) *[^<]*)/',
            'model' => '/itemprop="name">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'price' => '/class="elementor_widget_beaucage_cars_acf">(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
        ),
        'images_regx' => '/<meta property="og:image:secure_url" content="(?<img_url>[^"]+)"/',
    ),
    'used' => array(
        'details_start_tag' => '<section class="elementor-element elementor-element-6c55715f stock-search-section elementor-section-boxed',
       'details_end_tag' => '<div data-elementor-type="footer"',
        'details_spliter' => '<div class="elementor-section-wrap">',
        'data_capture_regx' => array(
            'stock_number' => '/class=\'stock-number\'>(?<stock_number>[^<]+)/',
            'url' => '/<h2 class="elementor_widget_beaucage_cars_acf"><a href="(?<url>[^"]+)"/',
            'title' => '/class=\'vehicule_model_trim_year\'>(?<title>(?<make>[^ ]+) *(?<model>[^ ]+)*(?<year>[^<]+) *?[^<]*)/',
            'year' => '/class=\'vehicule_model_trim_year\'>(?<title>(?<make>[^ ]+) *(?<model>[^ ]+)*(?<year>[^<]+) *?[^<]*)/',
            'make' => '/class=\'vehicule_model_trim_year\'>(?<title>(?<make>[^ ]+) *(?<model>[^ ]+)*(?<year>[^<]+) *?[^<]*)/',
            'model' => '/class=\'vehicule_model_trim_year\'>(?<title>(?<make>[^ ]+) *(?<model>[^ ]+)*(?<year>[^<]+) *?[^<]*)/',
            'price' => '/<span class="stock-price">(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'vin' => '/VIN :\s<\/span>(?<vin>[^-]+)/',
        ),
           'next_query_regx' => '/class=\'page-numbers current\'>[0-9]*<\/span><\/li>\s*<li><a class=\'page-numbers\' href=\'(?<next>[^\&]+)/',
        'images_regx' => '/class="slick-slide-inner"><img class="slick-slide-image" src="(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/<meta property="og:image:secure_url" content="(?<img_url>[^"]+)"/',
    ),
);
