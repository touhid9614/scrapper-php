<?php
global $scrapper_configs;
 $scrapper_configs["cindoraautosales"] = array( 
	 "entry_points"=>array(
        'new'    => 'https://www.cindoraautosales.ca/new-arrival.htm',
        'used'  => 'https://www.cindoraautosales.ca/used-inventory/index.htm',
         ),
     
         'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
        'ty_url_regex'      => '/\/contact-form-confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['a.imageScrollNext.next'],
        'picture_prevs'     => ['a.imageScrollPrev.previous'],
        
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/final-price.*class=\'value[^>]+>\$(?<price>[^<]+)/',
            'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometres:<\/dt>\s+<dd>(?<kilometres>[^<]+)/',
            'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
        ),
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
//        'images_regx'       => '/<li>\s*<a href="(?<img_url>(?:https?:)?\/\/pictures.dealer.com\/c\/[^"]+)" class="">/',
        'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/',
    
	//"no_scrap"=>true
	);
 
   add_filter("filter_cindoraautosales_field_images", "filter_cindoraautosales_field_images");
    
    function filter_cindoraautosales_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'unavailable_stockphoto.png');
        });
    }
