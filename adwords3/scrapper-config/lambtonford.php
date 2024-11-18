<?php
    global $scrapper_configs;

    $scrapper_configs['lambtonford'] = array(
        'entry_points' => array(
            'new'   => 'http://www.lambtonford.com/new-inventory?lang=en&view=list&offset=0&limit=100',
            'used'  => 'http://www.lambtonford.com/used-inventory?lang=en&view=list&offset=0&limit=100'
        ),
        'use-proxy' => true,
        'details_start_tag' => '<ul class="inventory-list inventory-list-',
        'details_end_tag'   => '</ul>',
        'details_spliter'   => '<li class="row-fluid inventory-item hover-root" itemscope itemtype="http://schema.org/IndividualProduct">',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock ID:<\/dt>\s*<dd[^>]*>(?<stock_number>[^<]+)/',
            'year'          => '/<time itemprop="releaseDate">(?<year>[0-9]{4})/',
            'make'          => '/<b itemprop="brand">(?<make>[^<]+)/',
            'model'         => '/<b itemprop="model">(?<model>[^<]+)/',
            'trim'          => '/<b class="hidden-tile">(?<trim>[^<]+)/',
            'price'         => '/<span class="amount" itemprop="price">(?<price>[^<]+)/',
            'body_style'    => '/id="car_type" value="(?<body_style>[^"]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd[^>]*>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd[^>]*>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/dt>\s*<dd[^>]*>\s*(?:<span .*<\/span>\s*)?(?<exterior_color>[^<\n]+)/',
            'interior_color'=> '/Interior:<\/dt>\s*<dd[^>]*>\s*(?:<span .*<\/span>\s*)?(?<interior_color>[^<\n]+)/',
            'kilometres'    => '/Odometer:<\/dt>\s*<dd[^>]*>\s*(?<kilometres>[^<\n]+)/',
            'url'           => '/<div class="vehicle-image[^"]*">\s*<a href=\'(?<url>[^\']+)\'/'
        ),
        'images_regx'       => '/itemprop="image"(?: class="item[^"]*")? src="(?<img_url>[^"]+)/'
    );