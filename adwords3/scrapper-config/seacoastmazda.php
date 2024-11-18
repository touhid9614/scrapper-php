<?php
    global $scrapper_configs;

    $scrapper_configs['seacoastmazda'] = array(
        'entry_points' => array(
            'new'   => 'https://www.seacoastmazda.com/new-cars-portsmouth-nh',
            'used'  => 'https://www.seacoastmazda.com/used-cars-portsmouth-nh'
        ),
        
        'vdp_url_regex'     => '/\/vehicle-details\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/',
        'use-proxy' => true,
        
        'picture_selectors' => ['.slick-slide .thumb-image'],
        'picture_nexts'     => ['.navigation-right'],
        'picture_prevs'     => ['.navigation-left'],
        
        'details_start_tag' => '<div class="vehicles"> ',
        'details_end_tag'   => '<div class="car-finder">',
        'details_spliter'   => '<div class="vehicle"',
        
        
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/class="price js-price-info" itemprop="price">[^\$]*(?<price>\$[0-9,]+)/',           
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'body_style'    => 'Body style:.*\s*<span class="value">(?<body_style>[^<]+)',
            'engine'        => 'Engine:.*\s*<span class="value">(?<engine>[^<]+)',
            'trim'          => 'Trim:.*\s*<span class="value">(?<trim>[^ <]+)'
        ),
        'next_page_regx'    => '/<a .* active\s*"\s*.*<\/a>\s*<a[^\n]+\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/thumb-preview">\s*<img src="[^"]+" alt="[0-9]{4}[^"]+" class="img-responsive" itemprop="image" data-preview="(?<img_url>[^"]+)"/',
        
    );
    
    add_filter('filter_seacoastmazda_field_images','filter_seacoast_field_images');
    
   
    function filter_seacoastmazda_field_images($im_urls)
    {
        return array_filter($im_urls,function($url){
            return !endsWith($url, 'noimage.jpg');
        });
    }
