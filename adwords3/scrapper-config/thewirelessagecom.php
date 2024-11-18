
<?php

	global $scrapper_configs;

    $scrapper_configs['thewirelessagecom'] = array(
        'entry_points' => array(
            'new'    => array(
                'https://www.thewirelessage.com/samsung/',
                'https://www.thewirelessage.com/lg/',
                //'https://www.thewirelessage.com/huawei-1/',
               // 'https://www.thewirelessage.com/alcatel/',
			)
        ),
		'use_proxy' => true,
		'vdp_url_regex'     => '/\/[A-Za-z0-9]+-[A-Za-z0-9]+-/i',
		
        'picture_selectors' => ['.product-images-pagination li'],
        'picture_nexts'     => ['.pswp__button.pswp__button--arrow--right'],
		'picture_prevs'     => ['.pswp__button.pswp__button--arrow--left'],
		'refine'            => false,
		
        'details_start_tag' => '<main class="main-content">',
        'details_end_tag'   => '<footer class="site-footer">',
        'details_spliter'   => 'class="product-grid-item product-block"',
        
        'data_capture_regx'     => array(
            //'stock_number'      => '/ajaxdata="product-(?<stock_number>[^\-]+)/',
            'make'              => '/product-item-title">\s*<a href="(?<url>[^"]+)">(?<title>(?<make>[^\s*]+)\s*(?<model>[^<]+)[^<]+)/',
            'model'             => '/product-item-title">\s*<a href="(?<url>[^"]+)">(?<title>(?<make>[^\s*]+)\s*(?<model>[^<]+)[^<]+)/',
            'title'             => '/product-item-title">\s*<a href="(?<url>[^"]+)">(?<title>(?<make>[^\s*]+)\s*(?<model>[^<]+)[^<]+)/',
            'url'               => '/product-item-title">\s*<a href="(?<url>[^"]+)">(?<title>(?<make>[^\s*]+)\s*(?<model>[^<]+)[^<]+)/',
            'price'             => '/Starting at\s*<\/label>\s*[^>]+>\s*(?<price>[^\s*]+)/',
        ),

        'data_capture_regx_full' => array(
            'body_style'        => '/data-swatch-value="(?<body_style>[^"]+)/',
            'description'        => '/product-description-wrapper">\s*<p>(?<description>[^<]+)/',
        ),

        //'next_page_regx'    => '/<a class="activepage".*\s*<\/li>\s*<li class="page">\s*- <a href="(?<next>[^"]+)/',
        'images_regx'       => '/class="product-image"\s*href="(?<img_url>[^"]+)/',
    );

add_filter('filter_style_thewirelessagecom', 'filter_style_thewirelessagecom', 10, 3);

function filter_style_thewirelessagecom($style, $car, $source) {

    global $BannerConfigs;

    
    if (startsWith($car['make'], 'Samsung')) {
        $style = 'thewirelessagecom_Samsung';
    }

    if (startsWith($car['make'], 'LG')) {
        $style = 'thewirelessagecom_LG';
    }

    
    if ($source == 'fb_style') {
        if (startsWith($car['make'], 'Samsung')) {
        $style = 'thewirelessagecom_Samsung';
    }

    if (startsWith($car['make'], 'LG')) {
        $style = 'thewirelessagecom_LG';
    }
    }
    return $style;
}