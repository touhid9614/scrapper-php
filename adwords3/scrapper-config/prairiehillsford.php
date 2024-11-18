<?php
    global $scrapper_configs;

    $scrapper_configs['prairiehillsford'] = array(
        'entry_points' => array(
            'new'   => 'http://www.prairiehillsford.us/new-inventory/index.htm',
            'used'  => 'http://www.prairiehillsford.us/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
         'use-proxy' => true,
        
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.previous'],
       
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare"> ',
     
        'data_capture_regx' => array(
            'url'           => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
            'title'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          =>'/ data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'stock_number'  => '/Stock\s*#:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
            'msrp'          => '/msrp"><span[^>]+.*<span class=\'value\'\s*>(?<msrp>\$[0-9,]+)/',
            'price'         => '/(?:Final|final-price)"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
          
        ),
        'data_capture_regx_full' => array(  
               
               
        ),
        'next_page_regx'    => '/href="(?<next>[^"]+)" rel="next"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
        'images_fallback_regx'   => '/<meta\s*name="og:image"\s*content="(?<img_url>[^"]+)/'

    );
    add_filter("filter_prairiehillsford_field_images", "filter_prairiehillsford_field_images");
    add_filter("filter_prairiehillsford_field_price", "filter_prairiehillsford_field_price",10,2);
    
    function filter_prairiehillsford_field_price($price,$cardata)
    {
        slecho("Filtering Price");
        slecho ("Car price:{$price}");
        slecho ("msrp price:{$cardata['msrp']}");
        if(!empty($cardata['msrp']) && $cardata['msrp'])
        {
            if(!empty($price))
            {
               $price=min($price,$cardata['msrp']); 
            }
            else{
                $price=$cardata['msrp'];
            }
            
        }
        slecho ("Car price is :{$price}");
        return $price;
    }
    function filter_prairiehillsford_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_replace('|', '%7C', $url);
        }

        return array_filter($retval, function($img_url){
            return !endsWith($img_url, "unavailable_stockphoto.png");
        });
    }

