<?php
 
    global $scrapper_configs;

    $scrapper_configs['dickbrookshonda'] = array(
        'entry_points' => array(
            'new'   => 'https://www.dickbrookshonda.com/available-inventory/',
            'used'  => 'https://www.dickbrookshonda.com/used-cars/'
        ),
        'vdp_url_regex'     => '/(?:new|certified|used)-cars\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/contact-form-confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.slides  li a img'],
        'picture_nexts'     => ['.imagelightbox-arrow-righ'],
        'picture_prevs'     => ['.imagelightbox-arrow-left'],
        'details_start_tag' => '<div class="vehicle-list">',
        'details_end_tag'   => '<footer class="footer">',
        'details_spliter'   => 'vehicle-picture">',
        
        'data_capture_regx' => array(
            'stock_number'  => '/STOCK#(?<stock_number>[^<]+)/',
            'title'         => '/<a href=\'(?<url>[^"]+)\'>\s*<span class="CarTitle">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'year'          => '/<a href=\'(?<url>[^"]+)\'>\s*<span class="CarTitle">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'make'          => '/<a href=\'(?<url>[^"]+)\'>\s*<span class="CarTitle">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'model'         => '/<a href=\'(?<url>[^"]+)\'>\s*<span class="CarTitle">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
            'price'         => '/No Hassle Price[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/',
//            'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:[^>]+>\s*[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Miles[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/<a href=\'(?<url>[^"]+)\'>\s*<span class="CarTitle">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/'
        ),
        'next_page_regx'    => '/<a class="page-link" href="(?<next>[^"]+)" aria-label="Next">/',
        'images_regx' => '/<a href="(?<img_url>[^"]+)" data-imagelightbox="a">/',
     //  'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );

    add_filter("filter_dickbrookshonda_field_price", "filter_dickbrookshonda_field_price", 10, 3);
    add_filter("filter_dickbrookshonda_field_images", "filter_dickbrookshonda_field_images");
    
    function filter_dickbrookshonda_field_price($price,$car_data, $spltd_data)
       {
           $prices = [];

           slecho('');

           if($price && numarifyPrice($price) > 0) {
               $prices[] = numarifyPrice($price);
               slecho("dickbrookshonda Price: $price");
           }

        $msrp_regex       =  '/<li class="price--msrp">\s*[^>]+>MSRP<\/span>[^>]+>(?<price>\$[0-9,]+)/';
        $retail_regex     =  '/<li class="price--msrp">\s*[^>]+>Retail Price[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/';
    

                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
      
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Retail Price: {$matches['price']}");
        }
     
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }

           slecho("Sale Price: {$price}".'<br>');
           return $price;
       }
    function filter_dickbrookshonda_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_replace(['|',"%20"], ['%7C'," "], $url);   
        }

        return $retval;
    }