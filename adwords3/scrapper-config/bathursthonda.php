<?php
    global $scrapper_configs;

    $scrapper_configs['bathursthonda'] = array(
        'entry_points' => array(
            'new'   => array(
                'http://www.bathursthonda.com/en/for-sale/car/new/honda/',
                'http://www.bathursthonda.com/en/for-sale/all/new-motorised-products/'
            ),
            'used'  => array(
                'http://www.bathursthonda.com/en/for-sale/car/pre-owned/',
                'http://www.bathursthonda.com/en/for-sale/all/used-moto-atv'
            )
        ),
        'url_resolve'       => array(
            'bathursthonda'     => '/www.bathursthonda.com\/en\//',
            'bathursthonda_fr'  => '/www.bathursthonda.com\/fr\//'
        ),
        'vdp_url_regex'     => '/\/inventory\/(?:new|used)\/vehicle\//i',
        'ty_url_regex'      => '/\/thank-you\//i',
        'use-proxy' => true,
        'details_start_tag' => '<div class="listingchange listingchange__column js-column-change " data-theme-icon="panel">',
        'details_end_tag'   => '<div class="inventory-list__results footer-list"',
        'details_spliter'   => '<article class="inventory-list-layout"',
        'must_contain_regx' => '/<div class="inventory-list-layout__preview-price-current">\s*(?:(?!sold).)*<\/div>/i',
        'data_capture_regx' => array(
            'stock_number'  => '/# stock<\/span>\s*<span>(?<stock_number>[^<]+)/',
            'url'           => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]*)"/',
            'title'         => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]*)"/',
            'year'          => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]*)"/',
            'make'          => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]*)"/',
            'model'         => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]*)"/',
            'price'         => '/<div class="inventory-list-layout__preview-price-current">\s*(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'body_style'    => '/Category:(?:&#32;)?\s*(?<body_style>[^<\n]+)/',
            'engine'        => '/Cylinders:(?:&#32;)?\s*(?<engine>[^<\n]+)/',
            'transmission'  => '/Transmission:(?:&#32;)?\s*(?<transmission>[^<\n]+)/',
            'exterior_color'=> '/Exterior colour:(?:&#32;)?\s*(?<exterior_color>[^<\n]+)/',
            'interior_color'=> '/Interior colour:(?:&#32;)?\s*(?<interior_color>[^<\n]+)/',
            'kilometres'    => '/>(?<kilometres>[0-9,]*) KM<\/li>/'
        ),
        'next_page_regx'    => '/href="(?<next>[^"]+)" data-theme-icon="arrowcercleright"/',
        'images_regx'       => '/data-picture-index="[^12]*"\s*data-picture-url="(?<img_url>[^"]+)" data-view="ninjabox-gallery"/'
    );
    
    add_filter("filter_bathursthonda_field_images", "filter_bathursthonda_field_images");
    
    function filter_bathursthonda_field_images($im_urls)
    {
        if(count($im_urls) < 4) { return array(); }
        
        return $im_urls;
    }
