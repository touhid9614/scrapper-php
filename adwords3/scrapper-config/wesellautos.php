<?php
    global $scrapper_configs;

    $scrapper_configs['wesellautos'] = array(
        'entry_points' => array(
            'used'  => 'https://www.wesellautos.com/vehicles/'
        ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        'inpage_cont_match' => 'Your message has been sent',
        'use-proxy'         => true,
        'details_start_tag' => '<article class="rule--top">',
        'details_end_tag'   => '</article>',
        'details_spliter'   => '<div id="item-',
        'data_capture_regx' => array(
            'stock_number'      => '/itemprop="productID"><strong>VIN:<\/strong>\s*<span class="truncate">(?<stock_number>[^<]+)/',
            'title'             => '/<h4 class="gamma--large  flush">\s*<a title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]*)" href="(?<url>[^"]+)" itemprop="name">/',
            'year'              => '/<h4 class="gamma--large  flush">\s*<a title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]*)" href="(?<url>[^"]+)" itemprop="name">/',
            'make'              => '/<h4 class="gamma--large  flush">\s*<a title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]*)" href="(?<url>[^"]+)" itemprop="name">/',
            'model'             => '/<h4 class="gamma--large  flush">\s*<a title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]*)" href="(?<url>[^"]+)" itemprop="name">/',
            'trim'              => '/<h5 class="hN grey zeta gamma--large" itemprop="description">(?<trim>[^<]+)/',
            'price'             => '/<div itemprop="price"><div class="display--inline-block">\s*<strong class="delta">(?<price>[^<]+)/',
            'url'               => '/<h4 class="gamma--large  flush">\s*<a title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]*)" href="(?<url>[^"]+)" itemprop="name">/',
            'kilometres'        => '/<p class="push-half--bottom  align--right  align--medium-left"><strong>(?<kilometres>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'body_style'        => '/<strong>Body Style<\/strong><\/dt>\s*<dd class="stat__value">\s*<ul[^>]+>\s*<li>(?<body_style>[^&<]+)/',
            'engine'            => '/<strong>Engine Type<\/strong><\/dt>\s*<dd class="stat__value">\s*<ul[^>]+>\s*<li>(?<engine>[^&<]+)/',
            'transmission'      => '/<strong>Transmission<\/strong><\/dt>\s*<dd class="stat__value">\s*<ul[^>]+>\s*<li>(?<transmission>[^&<]+)/',
            'exterior_color'    => '/<strong>Exterior Colour<\/strong><\/dt>\s*<dd class="stat__value">\s*<ul[^>]+>\s*<li>(?<exterior_color>[^&<]+)/',
            'interior_color'    => '/<strong>Interior Colour<\/strong><\/dt>\s*<dd class="stat__value">\s*<ul[^>]+>\s*<li>(?<interior_color>[^&<]+)/'
        ),
        'next_page_regx'    => '/<li class="pagination__current">[0-9]*<\/li><li class="pagination__page"><a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<a class="modal-item fit" data-index="[0-9]*" href="(?<img_url>[^"]+)"/',
    );

    add_filter("filter_wesellautos_field_images", "filter_wesellautos_field_images");
    
    function filter_wesellautos_field_images($im_urls)
    {
        if(count($im_urls) < 2) { return array(); }
        return $im_urls;
    }