<?php
    global $scrapper_configs;

    $scrapper_configs['coleautomotive'] = array(
        'entry_points' => array(
            'new'       => 'http://www.coleautomotive.com/new-cars-southwest-mi',
            'used'      => 'http://www.coleautomotive.com/used-cars-southwest-mi',
           // 'certified' =>'http://www.coleautomotive.com/certified-used-cars-southwest-mi'
        ),
        'vdp_url_regex'     => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/form-action=success-/i',
        //'use-proxy' => true,
        'proxy-area'        => 'FL',
        'picture_selectors' => ['.thumb'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div class="c-vehicles grid">',
        'details_end_tag'   => '<div class="com-inventory-listing-pagination row',
        'details_spliter'   => '<div class="vehicle"',
        'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/',
            'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/<meta itemprop="price" content="(?<price>[^"]+)/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'interior_color'=> '/<span class="spec-value spec-value-interiorcolor">(?<interior_color>[^<]+)/',
            'engine'        => '/<span class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
            'transmission'  => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
            'kilometres'    => '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
            //'certified'     =>'/alt="Certified"\s*class="[^"]+"\s*title="(?<certified>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            'trim'          => '/Trim:.*\s*<span class="value">(?<trim>[^<]+)/',
            'body_style'    => '/Body:.*\s*<span class="value">(?<body_style>[^<]+)/',
           
        ),
        'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<li><img src="(?<img_url>[^"]+)" alt="[^"]+" class="img-responsive" itemprop="image"/'
    );
    add_filter("filter_coleautomotive_field_images", "filter_coleautomotive_field_images");
    function filter_coleautomotive_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'noimage.jpg');
        });
    }