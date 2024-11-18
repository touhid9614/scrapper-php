<?php
    global $scrapper_configs;

    $scrapper_configs['villagerv'] = array(
        'entry_points' => array(
            'new'   => 'http://villagerv.ca/vehicle?condition=new',
            'used'  => 'http://villagerv.ca/vehicle?condition=used'
        ),
        'vdp_url_regex'     => '/\/vehicle\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-contacting-us/i',
        'avoid_carlist' => true,
        'use-proxy' => true,
        'details_start_tag' => '<ul class="list">',
        'details_end_tag'   => '</ul>',
        'details_spliter'   => '<li>',
        'data_capture_regx' => array(
            'stock_number'  => '/<meta name="stock_number" content="(?<stock_number>[^"]+)"/',
            'year'          => '/<meta name="year" content="(?<year>[^"]+)"/',
            'make'          => '/<meta name="make" content="(?<make>[^"]+)"/',
            'model'         => '/<meta name="model" content="(?<model>[^"]+)"/',
            'price'         => '/<meta name="price" content="(?<price>[^"]+)"/',
            
            'engine'        => '/Engine:<\/label>\s[^<]+<span>(?<engine>[^<]+)<\/span>/',               //no match here
            'transmission'  => '/Transmission:<\/label>\s[^<]+<span>(?<transmission>[^<]+)<\/span>/',   //no match here
            'kilometres'    => '/(?<kilometres>[0-9,]+) Kilometers/',                                   //no match here
            
            'url'           => '/<meta name="url" content="(?<url>[^"]+)"/',
            
            'exterior_color'=> '/Exterior:<\/label>\s[^<]+<span>(?<exterior_color>[^<]+)<\/span>/', //no match here
            'interior_color'=> '/Interior:<\/label>\s[^<]+<span>(?<interior_color>[^<]+)<\/span>/', //no match here
            'body_style'    => '/Variation : (?<body_style>[^<]+)/'                                 //no match here
        ),
        'data_capture_regx_full' => array(
        ) ,
        'next_page_regx'    => '@<li><a class="active" href="[^"]+">[0-9]+</a></li><li><a href="(?<next>[^"]+)@',
        'images_regx'       => '/<li><img src="(?<img_url>[^"]+)" style=""><\/li>/'
    );
