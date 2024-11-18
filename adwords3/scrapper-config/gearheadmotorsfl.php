<?php

    global $scrapper_configs;

    $scrapper_configs['gearheadmotorsfl'] = array(
        'entry_points' => array(
            'used' => 'http://gearheadmotorsfl.com/inventory.php'
        ),
        'vdp_url_regex'     => '/\/details./i',
        'required_params'   => ['stockid'],
        'use-proxy' => true,
        'picture_selectors' => ['.flexslider .slides > li'],
        'picture_nexts'     => ['.fancybox-next'],
        'picture_prevs'     => ['.fancybox-prev'],
        
        'details_start_tag' => '<section class="content padding-bottom-30 padding-top-10">',
        'details_end_tag'   => '<footer',
        'details_spliter'   => '<div class="inventory',
        'must_not_contain_regx' => '/<div class="figure">SOLD.*</div>/',
        'data_capture_regx' => array(
            'url'           => '/<a href="(?<url>[^"]+)" class="inventory"/',
            'title'         => '/title">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)[^<]+)/',
            'year'          => '/title">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)[^<]+)/',
            'make'          => '/title">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)[^<]+)/',
            'model'         => '/title">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)[^<]+)/',
            'price'         => '/Price:[^\n]+\s*<div[^>]+>(?<price> \$[0-9,]+)/',
            'kilometres'    => '/Mileage<\/td>\s*<td[^>]+>(?<kilometres>[^<]+)/',
            'stock_number'  => '/Stock #:<\/td>\s*<td[^>]+>(?<stock_number>[^<]+)/',
            'engine'        => '/Engine:<\/td>\s*<td[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/td>\s*<td[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior color:<\/td>\s*<td[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color:<\/td>\s*<td[^>]+>(?<interior_color>[^<]+)/'
        ),
        'data_capture_regx_full' => array(        
            'make'          => '@Make:\s*<\/td>\s*<td>(?<make>[^<]+)@',
            'model'         => '@Model:\s*<\/td>\s*<td>(?<model>[^<]+)@',
            'body_style' => '@Vehicle Type:\s*<\/td>\s*<td>(?<body_style>[^<]+)@',
            'trim' => '@Trim:\s*<\/td>\s*<td>(?<trim>[^<]+)@'
        ) ,
      //  'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<img alt="[^"]+" src="[^"]+" alt=\'\' data-full-image="(?<img_url>[^"]+)/'
    );

