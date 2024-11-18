<?php
    global $scrapper_configs;

    $scrapper_configs['marlboroughford'] = array(
        'entry_points' => array(
            'new'   => 'http://www.marlboroughford.com/new-ford-calgary-ab',
            'used'  => 'http://www.marlboroughford.com/used-cars-calgary-ab',
          //  'certified' => 'https://www.marlboroughford.com/used-cars-westmont-il'
        ),
        'vdp_url_regex'     => '/\/vehicle-details\/[0-9]{4}-/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.slick-slide'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div class="c-vehicles list">',
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
            'engine'        => '/<span class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
            'transmission'  => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
            'kilometres'    => '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
            'certified'     =>'/<img\s*src="[^"]+"\s*alt="Certified"\s*class="[^"]+"\s*title="(?<certified>[^"]+)"/'

        ),
        'data_capture_regx_full' => array(
            'price'         => '/<span class= "price-value" itemprop="price">(?<price>\$[0-9,]+)/',
            'trim'          => '/Trim:<\/[^\n]+\s*<span[^>]+>(?<trim>[^<]+)/',
            'model'         => '/Model:<\/[^\n]+\s*<span[^>]+>(?<model>[^<]+)/',
            'body_style'    => '/Body:<\/[^\n]+\s*<span[^>]+>(?<body_style>[^<]+)/',
            'interior_color'=> '/Interior:<\/[^\n]+\s*<span[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometrs:<\/[^\n]+\s*<span[^>]+>(?<kilometres>[^<]+)/',
        ),
        'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<li><img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+" class="img-responsive" itemprop="image"/'
    );
//    add_filter("filter_marlboroughford_field_images", "filter_marlboroughford_field_images");
//
//    function filter_marlboroughford_field_images($im_urls)
//    {
//        return array_filter($im_urls, function($im_url){
//            return !endsWith($im_url, 'noimage.jpg');
//        });
//    }