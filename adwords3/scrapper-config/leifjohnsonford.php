<?php
    global $scrapper_configs;

    $scrapper_configs['leifjohnsonford'] = array(
        'entry_points' => array(
            'new'   => 'http://www.leifjohnsonford.com/search/New+t',
            'used'  => 'http://www.leifjohnsonford.com/search/Used+t'
        ),
        'vdp_url_regex'     => '/\/details\//i',
        'ty_url_regex'      => '/\/thank_you.html/i',
        'required_params'   => ['vin','type','desc'],
        'use-proxy' => true,
        
        'picture_selectors' => ['.sp-thumbnail-container'],
        'picture_nexts'     => ['.sp-next-arrow'],
        'picture_prevs'     => ['.sp-previous-arrow'],
        'details_start_tag' => '<div id="resultsdiv">',
        'details_end_tag'   => '<footer>',
        'details_spliter'   => '<div class="af-vehicle-result clearfix"',
       
        
        'data_capture_regx' => array(
            'stock_number'  => '/<meta\s*itemprop="sku"\s*content="(?<stock_number>[^"]+)/',
            'year'          => '/itemscope.*data-year="(?<year>[^"]+)/',
            'trim'          => '/itemscope.*data-trim="(?<trim>[^"]+)/',
            'make'          => '/<meta\s*itemprop="manufacturer"\s*content="(?<make>[^"]+)/',
            'model'         => '/<meta\s*itemprop="model"\s*content="(?<model>[^"]+)/',
            'engine'        => '/itemscope.*data-engine="(?<engine>[^"]+)/',
            'exterior_color'=> '/itemscope.*data-exterior="(?<exterior_color>[^"]+)/',
            'interior_color'=> '/itemscope.*data-interior="(?<interior_color>[^"]+)/',
            'kilometres'    => '/<meta\s*itemprop="mileageFromOdometer"\s*content="(?<kilometres>[^"]+)/',
            'url'           => '/<meta\s*itemprop="url"\s*content="(?<url>[^"]+)/',
            'original'      => '/MSRP:<\/td>\s*<td[^>]+><span[^>]+>(?<original>\$[0-9,]+)/',
            'price'         => '/Sale Price:<\/td>\s*<td[^>]+>(?<price>\$[0-9,]+)/',
            'certified'     => '/<img class="af-cpo-badge-img"\s*.*alt="(?<certified>Certified)[^>]+/'
        ),
        'data_capture_regx_full' => array(
            'transmission'  => '/Transmission<\/td>\s*<td[^>]+>(?<transmission>[^<]+)/',
            'body_style'    => '/itemscope.*data-bodystyle="(?<body_style>[^"]+)/',
           
        ),
        'next_page_regx'    => '/<a href="[^\?]+(?<next>\?[^\']+)\';" aria-label="Next">/',
        'images_regx'       => '/<\/div><meta\s*itemprop="image"\s*content="(?<img_url>[^"]+)/'
    );
    
   /// $leifjohnsonford_offers = [];
    
    add_filter("filter_leifjohnsonford_field_price", "filter_leifjohnsonford_field_price", 10, 2);
    add_filter('filter_leifjohnsonford_post_data', 'filter_leifjohnsonford_post_data', 10, 2);
    add_filter('filter_leifjohnsonford_next_page', 'filter_leifjohnsonford_next_page');
    function filter_leifjohnsonford_field_price($price, $car_data) {
        slecho("Price is $price");
       // global $leifjohnsonford_offers;
        slecho("Filtering Price");
        if(isset($car_data['original']) && $car_data['original']) {
         
                $price = min(numarifyPrice($price), numarifyPrice($car_data['original']));
            
            slecho("Original Price: {$car_data['original']}");
            slecho("Sale Price: $price");
        }
        
        return $price;
    }
    
    function filter_leifjohnsonford_next_page($next,$current_page) {
       slecho("Filtering Next url using {$next}");
       slecho("Current page ".$current_page);
       slecho ("Next page ".urlCombine($current_page, "{$next}"));
        return urlCombine($current_page, "{$next}");
    }
    

    
  