<?php
    global $scrapper_configs;

    $scrapper_configs['bathursthonda_fr'] = array(
        'entry_points' => array(
            'new'   => array(
                'http://www.bathursthonda.com/fr/a-vendre/auto/neuf/honda/',
                'http://www.bathursthonda.com/fr/a-vendre/tous/produits-motorises-neufs'
            ),
            'used'  => array(
                'http://www.bathursthonda.com/fr/a-vendre/auto/occasion/',
                'http://www.bathursthonda.com/fr/a-vendre/tous/moto-vtt-occasion'
            )
        ),
        'url_resolve'       => array(
            'bathursthonda'     => '/www.bathursthonda.com\/en\//',
            'bathursthonda_fr'  => '/www.bathursthonda.com\/fr\//'
        ),
        'vdp_url_regex'     => '/\/inventaire\/(?:neuf|occasion)\/vehicule\//i',
        'ty_url_regex'      => '/\/vous-remercie\//i',
        'use-proxy' => true,
        'details_start_tag' => '<div class="listingchange listingchange__column js-column-change " data-theme-icon="panel">',
        'details_end_tag'   => '<div class="inventory-list__results footer-list"',
        'details_spliter'   => '<article class="inventory-list-layout"',
        'must_contain_regx' => '/<div class="inventory-list-layout__preview-price-current">\s*(?:(?!sold).)*<\/div>/i',
        'data_capture_regx' => array(
            'stock_number'  => '/# stock<\/span>\s*<span>(?<stock_number>[^<]+)/',
            'url'           => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"/',
            'price'         => '/<div class="inventory-list-layout__preview-price-current">\s*(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'title'         => '/<span class="title__primary display__block">\s*(?<title>(?<make>.*)\s*(?<year>\d{4})\s*(?<model>[^ <]+)[^<]*)/',
            'year'          => '/<span class="title__primary display__block">\s*(?<title>(?<make>.*)\s*(?<year>\d{4})\s*(?<model>[^ <]+)[^<]*)/',
            'make'          => '/<span class="title__primary display__block">\s*(?<title>(?<make>.*)\s*(?<year>\d{4})\s*(?<model>[^ <]+)[^<]*)/',
            'model'         => '/<span class="title__primary display__block">\s*(?<title>(?<make>.*)\s*(?<year>\d{4})\s*(?<model>[^ <]+)[^<]*)/',
            'body_style'    => '/Cat&eacute;gorie&nbsp;:&#32;\s*(?<body_style>[^\n]+)/',
            'engine'        => '/Cylindres&nbsp;:&#32;\s*.*(?<engine>\d.\dL)/',
            'transmission'  => '/Transmission&nbsp;:&#32;\s*(?<transmission>[^<\n]+)/',
            'exterior_color'=> '/Couleur ext.&nbsp;:&#32;\s*(?<exterior_color>[^<\n]+)/',
            'interior_color'=> '/Couleur int.&nbsp;:&#32;\s*(?<interior_color>[^<\n]+)/',
            'kilometres'    => '/>(?<kilometres>[0-9,\s]*) KM<\/li>/'
        ),
        'next_page_regx'    => '/href="(?<next>[^"]+)" data-theme-icon="arrowcercleright"/',
        'images_regx'       => '/data-picture-index="[^12]*"\s*data-picture-url="(?<img_url>[^"]+)" data-view="ninjabox-gallery"/'
    );
    
    add_filter("filter_bathursthonda_fr_field_images", "filter_bathursthonda_field_images");