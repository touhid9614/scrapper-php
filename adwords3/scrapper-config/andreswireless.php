<?php
    global $scrapper_configs;

    $scrapper_configs['andreswireless'] = array(
        'entry_points' => array(
            'new'    => array(
                'http://www.andreswireless.com/telus-smartphones/',
                'http://www.andreswireless.com/telus-apple-iphones/',
                'http://www.andreswireless.com/telus-voice-and-message-phones/',
                'http://www.andreswireless.com/telus-apple-ipads/',
                'http://www.andreswireless.com/telus-tablets/',
                'http://www.andreswireless.com/telus-mobile-broadband-and-internet-devices/'
            ),/*
            'accessory' => array(
                'http://www.andreswireless.com/cases-and-protection/',
                'http://www.andreswireless.com/chargers/',
                'http://www.andreswireless.com/headphones-and-speakers/',
                'http://www.andreswireless.com/wearables/',
                'http://www.andreswireless.com/batteries/',
                'http://www.andreswireless.com/accessories/',
                'http://www.andreswireless.com/specialty/'
            )*/
        ),
        'vdp_url_regex'     => '/\/[^\/]+\/m[0-9]+\//i',
       
        'ajax_url_match'    => 'callback=secureLeadSubmission',
        'use-proxy'         => true,
        'refine'            => false,
        'picture_selectors' => ['ul.thumbnails-carousel .center li'],
        
//       ' picture_selectors' => ['ul.thumbnails-carousel .center li','.fl1xcarousel li'],
//        'picture_nexts'     => ['fl1xcarousel-control-next'],
//        'picture_prevs'     => ['fl1xcarousel-control-prev'],
        
        'details_start_tag' => '<section class="container content-page products-page">',
        'details_end_tag'   => '<footer>',
        'details_spliter'   => '<div class="product ">',
        
        'data_capture_regx' => array(
            'make'              => '/<span class="col-xs-12 no-padding product-manufacture">\s*(?<make>[^<]+)/',
            'trim'              => '/<a class="col-xs-12 no-padding product-model[^"]*"[^>]+>\s*(?<model>[^\n<]+)(?:\n\s*(?<trim>[^\n<]+))?/',
            'model'             => '/<a class="col-xs-12 no-padding product-model[^"]*"[^>]+>\s*(?<model>[^\n<]+)/',
            'url'               => '/<a class="col-xs-12 no-padding product-model".*\s*.*\s* href="(?<url>[^"]+)"/',
            'price'             => '/<p class="product-price".*>\s*(?:From<br[^>]+>\s*)?<span\s*>(?<price>[\$0-9\.,]+)/',
        ),
        'data_capture_regx_full' => array(
            
        ) ,
        //'next_page_regx'    => '/<li class="active"><a\s*>[0-9]*<\/a><\/li>\s*<li><a href="(?<next>[^"]+)">/',
        'images_regx'       => '/<div class="item[^"]*">\s*<img src="(?<img_url>[^"]+)"/',
    );
//    add_filter("filter_andreswireless_field_images", "filter_andreswireless_field_images");
//
//    function filter_andreswireless_field_images($im_urls)
//    {
//        if (count($im_urls) < 2) return array();
//     
//        return $im_urls;
//    }
   
