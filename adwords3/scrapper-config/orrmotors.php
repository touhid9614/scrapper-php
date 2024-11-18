<?php
    global $scrapper_configs;

    $scrapper_configs['orrmotors'] = array(
        'entry_points' => array(
            'used'  => 'https://orrmotors.com/inventory/'
        ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        'inpage_cont_match' => 'Your message has been sent',
        'use-proxy' => true,
        'picture_selectors' => ['.multi-list>li'],
        'picture_nexts'     => ['.carousel__button--next'],
        'picture_prevs'     => ['.carousel__button--previous'],
        'details_start_tag' => '<article class="rule--top">',
        'details_end_tag'   => '</article>',
        'details_spliter'   => '<div id="item-',
        'data_capture_regx' => array(
            'url'               => '/<div class="l-column--large-5  push-half--bottom  flush--large">\s*<a href="(?<url>[^"]+)" class="" title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)(?: (?<trim>[^"]+))?)/',
            'title'             => '/<div class="l-column--large-5  push-half--bottom  flush--large">\s*<a href="(?<url>[^"]+)" class="" title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)(?: (?<trim>[^"]+))?)/',
            'year'              => '/<div class="l-column--large-5  push-half--bottom  flush--large">\s*<a href="(?<url>[^"]+)" class="" title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)(?: (?<trim>[^"]+))?)/',
            'make'              => '/<div class="l-column--large-5  push-half--bottom  flush--large">\s*<a href="(?<url>[^"]+)" class="" title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)(?: (?<trim>[^"]+))?)/',
            'model'             => '/<div class="l-column--large-5  push-half--bottom  flush--large">\s*<a href="(?<url>[^"]+)" class="" title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)(?: (?<trim>[^"]+))?)/',
            'price'             => '/<div itemprop="price"><div class="display--inline-block">\s*<strong class="delta">(?<price>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number'      => '/Stock No:\s*(?<stock_number>[^ <]+)/',
            'kilometres'        => '/Odometer:<\/span>\s*<strong>(?<kilometres>[^<]+)/',
            'body_style'        => '/Body Style<\/strong>[\s\S]*?<ul class="list--no-style">\s*<li>(?<body_style>[^&<]+)/',
            'engine'            => '/Engine Type<\/strong>[\s\S]*?<ul class="list--no-style">\s*<li>(?<engine>[^&<]+)/',
            'transmission'      => '/Transmission<\/strong>[\s\S]*?<ul class="list--no-style">\s*<li>(?<transmission>[^&<]+)/',
            'exterior_color'    => '/Exterior Colour<\/strong>[\s\S]*?<ul class="list--no-style">\s*<li>(?<exterior_color>[^&<]+)/',
            'interior_color'    => '/Interior Colour<\/strong>[\s\S]*?<ul class="list--no-style">\s*<li>(?<interior_color>[^&<]+)/'
        ) ,
        #'next_page_regx'    => '/<a href="(?<next>[^"]+)" alt="Next Page">Next Page<\/a>/', # All contents are in single page
        'images_regx'       => '/<a class="modal-item fit" data-index="[0-9]*" href="(?<img_url>[^"]+)"/',
    );

    add_filter('filter_orrmotors_single_data', 'filter_orrmotors_single_data');
    
    function filter_orrmotors_single_data($single_data) {
        if(stripos($single_data, '1 Photos') !== false) {
            slecho('Info: Skip sold cars');
            return false;
        }
        return $single_data;
    }
    
    add_filter('filter_orrmotors_car_data', 'filter_orrmotors_car_data');
    
    function filter_orrmotors_car_data($car_data) {
        slecho ("Price : ".numarifyPrice($car_data['price']));
        if($car_data['year']<=2010) {
            slecho("Excluding cars that have a year of 2010 or older {$car_data['url']}");
            return null;
        }
        
        if(numarifyPrice($car_data['price'])<=12000) {
            slecho("Excluding cars that are under \$12000 {$car_data['url']}");
            return null;
        }
        
        
        return $car_data;
    }