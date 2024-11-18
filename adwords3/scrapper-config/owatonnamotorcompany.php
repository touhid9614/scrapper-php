<?php
global $scrapper_configs;
 $scrapper_configs["owatonnamotorcompany"] = array( 
	 'entry_points' => array(
            'new'   => 'https://www.owatonnamotorcompany.com/new-cars-owatonna-mn',
            'used'  => 'https://www.owatonnamotorcompany.com/used-cars-owatonna-mn'
        ),
        'vdp_url_regex'     => '/\/vehicle-details\/[0-9]{4}-/i',
       'ty_url_regex'      => '/\/eprice-[^\?]+\?.*form-action=success/i',
        'use-proxy' => true,
        'picture_selectors' => ['.slick-slide img'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
         'details_start_tag' => '<div class="vehicle-page"',
        'details_end_tag'   => '<div class="quick-preview-wrapper">',
        'details_spliter'   => '<div class="vehicle clearfix"',
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
     
        ),
        'data_capture_regx_full' => array(
            'transmission'  => '/Transmission:[^>]+>[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
            'kilometres'    => '/Mileage:[^>]+>[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
             'engine'        => '/Engine:[^>]+>[^>]+>\s*[^>]+>(?<engine>[^<]+)/',
            'trim'          => '/Trim:.*\s*<span class="value">(?<trim>[^ <]+)/',
            'body_style'    => '/Body:.*\s*<span class="value">(?<body_style>[^<]+)/',
            'interior_color'=> '/Interior:.*\s*<span class="value">(?<interior_color>[^<]+)/'
        ),
        'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/li><img src="(?<img_url>[^"]+)"\s*alt=".*"/'
    );

 
 
add_filter("filter_owatonnamotorcompany_field_images", "filter_owatonnamotorcompany_field_images");
function filter_owatonnamotorcompany_field_images($im_urls) {
    
    return array_filter($im_urls, function($img_url) {
        return !endsWith($img_url, "noimage.jpg");
    }
    );
}
