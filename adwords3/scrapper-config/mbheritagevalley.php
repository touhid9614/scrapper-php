<?php

    global $scrapper_configs;

    $scrapper_configs['mbheritagevalley'] = array(
        'entry_points' => array(
            'new'   => 'https://heritagevalley.mercedes-benz.ca/en-CA/search-inventory/',
            'used'  => 'http://certified.mercedes-benz.ca/heritagevalley/used'
        ),
        'vdp_url_regex'     => '/(?:certified.mercedes-benz.ca\/heritagevalley\/used\/[0-9]{4}\/|heritagevalley.mercedes-benz.ca\/en-CA\/[0-9]{4}\/)/i',
        'ajax_url_match'    => '/enquiry/91217',
        'vdp_page_regex'    => '/(?:certified.mercedes-benz.ca\/heritagevalley\/used\/[0-9]{4}\/|heritagevalley.mercedes-benz.ca\/en-CA\/[0-9]{4}\/)/',
        'required_params'   => array('id'),
        'use-proxy' => true,
        'new'       => array(
            'details_start_tag' => '<div id="inventory-listing">',
            'details_end_tag'   => '<div class="inventory-refine bottom">',
            'details_spliter'   => '<li class="liItems rollover opacity">',
            'data_capture_regx' => array(
                'title'         => '/<p class="view-details"><a data-href="(?<url>[^"]+)" data-title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^"]*)/',
                'year'          => '/<p class="view-details"><a data-href="(?<url>[^"]+)" data-title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^"]*)/',
                'make'          => '/<p class="view-details"><a data-href="(?<url>[^"]+)" data-title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^"]*)/',
                'model'         => '/<p class="view-details"><a data-href="(?<url>[^"]+)" data-title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^"]*)/',
                'price'         => '/<h6 class="price-amount cufon">\s*(?<price>[^<]+)/',
                'stock_number'  => '/Stock Number:<\/span>\s*(?<stock_number>[^<]+)/',
                'body_style'    => '/Body Style:<\/span>\s*(?<body_style>[^<]+)/',
                'transmission'  => '/Transmission:<\/span>\s*(?<transmission>[^<\n]+)/',
                'exterior_color'=> '/Ext. Color:<\/span>\s*(?<exterior_color>[^<\n]+)/',
                'interior_color'=> '/Int. Color:<\/span>\s*(?<interior_color>[^<\n]+)/',
                'url'           => '/<p class="view-details"><a data-href="(?<url>[^"]+)" data-title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^"]*)/'
            ),
            'data_capture_regx_full' => array(
                'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            ),
            'next_page_regx'    => '/<li class=\'arrow-right\'><a href=\'(?<next>[^\']+)/',
            'images_regx'       => '/<li><a href=\'(?<img_url>[^\']+)\'>\s*<img/'
        ),
        'used'      => array(
            'details_start_tag' => '<div id="Hitlist"',
            'details_end_tag'   => '<div id="footer">',
            'details_spliter'   => '</a>',
            'data_capture_regx' => array(
                'title'         => '/<a href="(?<url>[^"]+)" title="(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ ]+)[^"]+)"/',
                'year'          => '/<a href="(?<url>[^"]+)" title="(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ ]+)[^"]+)"/',
                'make'          => '/<a href="(?<url>[^"]+)" title="(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ ]+)[^"]+)"/',
                'model'         => '/<a href="(?<url>[^"]+)" title="(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ ]+)[^"]+)"/',
                'price'         => '/<div class="Price border-bottom">&#36;(?<price>[^<]+)/',
                'kilometres'    => '/<div class="Mileage">(?<kilometres>[^<]+)/',
                'url'           => '/<a href="(?<url>[^"]+)" title="(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ ]+)[^"]+)"/'
            ),
            'data_capture_regx_full' => array(
                'stock_number'  => '/VIN:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
                'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
                'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
                'transmission'  => '/Transmission:<[^>]+>[^>]+>(?<transmission>[^<]+)/',
                'exterior_color'=> '/Exterior:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
                'interior_color'=> '/Interior:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            ),
            'options_start_tag' => '<div class="tab_containerHitlist">',        
            'options_end_tag'   => '<div id="bottomUtility">',        
            'options_regx'      => '/<li>(?<option>[^<]+)/',        
            //'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
            'images_regx'       => '/<img src="(?<img_url>\/photo\/[^"]+?81-[0-9]+.jpg)"/'
        )
    );
    
    function mbheritagevalley_images_proc($url)
    {
        return preg_replace('/-81-([0-9]+).jpg/', '-1024-$1.jpg', $url);
    }