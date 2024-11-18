<?php
    global $scrapper_configs;

    $scrapper_configs['planetkia'] = array(
        'entry_points' => array(
            'used'  => 'http://www.planetkia.ca/used.php?s2=1&search.results_per_page=1000&search.order=1&search.order.dir=2'
        ),
        'vdp_url_regex'     => '/\/used-cars\//',
        'ty_url_regex'      => '/\/thankYou.do/i',
        'ajax_url_match'    => 'callback=secureLeadSubmission',
        'required_params'   => array('car-id'),
        'use-proxy'         => true,
        'used'              => array(
            'details_start_tag' => '<div class="searchResultsList">',
            'details_end_tag'   => '<div class="searchResultsFooter">',
            'details_spliter'   => '<div class="searchResultBoxWrapper',
            'data_capture_regx' => array(
                'url'           => '/<span class="searchResultTitle"\>\<a href="(?<url>[^"]+)"\>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^\<]+))/',
            ),
            'data_capture_regx_full' => array(
                'stock_number'  => '/Stock number<\/td>\s*<td>(?<stock_number>[^&]+)/',
                'year'          => '/Year<\/td>\s*<td>(?<year>[^&]+)/',
                'make'          => '/Make<\/td>\s*<td>(?<make>[^&]+)/',
                'model'         => '/Model<\/td>\s*<td>(?<model>[^&]+)/',
                'price'         => '/(?<price>\$[0-9\,\.]+?)\s/',
                'title'         => '/<h1 class="pageHead">\s+(?<title>[^&]+)<\/h1>/',
                'engine'        => '/Engine<\/td>\s*<td>\s*(?<engine>[^&]+)/',
                'transmission'  => '/Transmission<\/td>\s*<td>\s*(?<transmission>[^&]+)/',
                'kilometres'    => '/Odometer<\/td>\s*<td>\s*(?<kilometres>[0-9]+)/',
                'exterior_color'=> '/Exterior color<\/td>\s*<td>\s*(?<exterior_color>[^&]+)/',
                'interior_color'=> '/Interior color<\/td>\s*<td>\s*(?<interior_color>[^&]+)/',
                'body_style'    => '/Body Type<\/td>\s*<td colspan="3">(?<body_style>[^&]+)/'
            ) ,
            'options_start_tag' => '<h2>Details</h2>',       
            'options_end_tag'   => 'detailsElement',        
            'options_regx'      => '/<li[^>]*>(?<option>[^<]+)/',
            'next_page_regx'    => '/<a href="(?<next>[^"]+)" class="searchPageLinkArrows searchPageLinkNext/',
            'images_regx'       => '/<a href="(?<img_url>\/images\/image\.php\?file=[^\.]+\.jpg)"/',
            'images_fallback_regx' => '/<img src="(?<img_url>http:\/\/jato\.aslinternet\.com[^"]+)/'
        )
    );
