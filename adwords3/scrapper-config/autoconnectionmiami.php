<?php
    global $scrapper_configs;

    $scrapper_configs['autoconnectionmiami'] = array (
        'entry_points'          => array(
            'used'              => 'https://www.autoconnectionmiami.com/inventory.aspx?pagesize=500',
        ),

        'vdp_url_regex'         => '/[0-9]{4}_[^_]+_[^_]+.*\.veh/i',
        'use-proxy'             => true,
      //'proxy-area'            => 'FL',
        'picture_selectors'     => ['#ctl00_cphBody_inv1_dlImage'],
        'picture_nexts'         => ['#TB_Next'],
        'picture_prevs'         => ['#TB_Previous'],
        
        'details_start_tag'     => '<a id="ctl00_cphBody_inv1_lbNextTop"',
        'details_end_tag'       => '<div id="ctl00_cphBody_inv1_pnlPageNavBottom"',
        'details_spliter'       => '<tr class="trthree">',

       // 'must_not_contain_regx' => '/<strong><span[^>]+>SOLD\!<\/span>/',

        'data_capture_regx'     => array(
            'stock_number'      => '/Stk #:(?<stock_number>[^\)]+)/',
            'url'               => '/<a id=".*_hlDetails2" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]+)/',
          //'url'               => '/<a id=".*_hlDetails2" href="(?<url>[^"]+\"\>)/',
            'title'             => '/<a id=".*_hlDetails2" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]+)/',
            'year'              => '/<a id=".*_hlDetails2" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]+)/',
            'make'              => '/<a id=".*_hlDetails2" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]+)/',
            'model'             => '/<a id=".*_hlDetails2" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]+)/',
            'price'             => '/Special\s*(?<price>\$[0-9,]+)/',
            'trim'              => '/Trim:<\/span><\/td>\s*<td[^>]+><span[^>]+>(?<trim>[^<]+)/',
            'exterior_color'    => '/Exterior:<\/span><\/td>\s*<td[^>]+><span[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'    => '/Interior:<\/span><\/td>\s*<td[^>]+><span[^>]+>(?<interior_color>[^<]+)/',
            'engine'            => '/Engine:<\/span><\/td>\s*<td[^>]+><span[^>]+>(?<engine>[^<]+)/',
            'transmission'      => '/Transmission:<\/span><\/td>\s*<td[^>]+><span[^>]+>(?<transmission>[^<]+)/',
            'kilometres'        => '/Mileage:<\/span><\/td>\s*<td[^>]+><span[^>]+>(?<kilometres>[^<]+)/',
           // 'images_regx'           => '/<img src=\'(?<img_url>[^"]+)\' class="carPic"/',
          //'certified'         =>'/<img\s*src="[^"]+"\s*alt="Certified"\s*class="[^"]+"\s*title="(?<certified>[^"]+)"/'
        ),

        'data_capture_regx_full'=> array(
          //'trim'              => '/Trim:<\/strong><\/span>\s*<span[^>]+>(?<trim>[^<]+)/',                 //available only in vdp
          //'model'             => '/Model:<\/strong><\/span>\s*<span[^>]+>(?<model>[^<]+)/',               //available only in vdp
            'body_style'        => '/<\/span>\s*<span[^>]+>(?<body_style>[^<]+)/',           //matches neither in srp nor in vdp
          //'interior_color'    => '/Interior:<\/strong><\/span>\s*<span[^>]+>(?<interior_color>[^<]+)/',   //available only in vdp
          //'kilometres'        => '/Mileage:<\/strong><\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',        //available only in vdp
        ),

        //'next_page_regx'        => '/ctl00_cphBody_inv1_lbNextBottom".* href="(?<next>[^"]+)/',             //available only in srp
       'images_regx'           => '/<a href="(?<img_url>[^"]+)" id=".*_anchor" class="thickbox"/',                       //available only in vdp
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
/*
    add_filter("filter_autoconnectionmiami_field_images", "filter_autoconnectionmiami_field_images");
    add_filter('filter_autoconnectionmiami_field_price', 'filter_autoconnectionmiami_field_price',10,3);

    function filter_autoconnectionmiami_field_images($im_urls)
    {
        if(count($im_urls) < 2) 
        { 
            return array(); 
        }
        return array_filter($im_urls, function($im_url)
        {
            return !endsWith($im_url, 'photo_unavailable_320.gif');
        });
    }
 
    function filter_autoconnectionmiami_field_price($price,$car_data,$spltd_data)
    {
        $prices         = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) 
        {
            $prices[]   = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex     = '/<td.*class="styleTitle">\s*<strong>(?<span>[^>]+>)?(?<price>\$[0-9,]+)/';
        
        $matches        = [];
        
        //if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0)
        if(preg_match($msrp_regex, $spltd_data, $matches) && (numarifyPrice($matches['price'])))
        {
            $prices[]   = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
      
        //if(count($prices) > 0) 
        if(count($prices)) 
        {
            $price      = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
 */