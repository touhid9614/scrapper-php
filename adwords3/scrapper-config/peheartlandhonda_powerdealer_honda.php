<?php
global $scrapper_configs;
 $scrapper_configs["peheartlandhonda_powerdealer_honda"] = array( 
	'entry_points' => array(
         'new'  => array(
            'https://peheartlandhonda.powerdealer.honda.com/products/generators',
//            'http://peheartlandhonda.powerdealer.honda.com/products/lawnmowers',
//            'http://peheartlandhonda.powerdealer.honda.com/products/pumps',
//            'http://peheartlandhonda.powerdealer.honda.com/products/snowblowers',
//            'http://peheartlandhonda.powerdealer.honda.com/products/tillers',
//            'http://peheartlandhonda.powerdealer.honda.com/products/trimmers',
            
        ),
    ),

    'vdp_url_regex' => '/\/products\/[^\/]+\/[^\s]+/i',
    //'ty_url_regex' => '/\/thank-you\?formName/i',
    'use-proxy' => true,
    
    
    'picture_selectors' => ['.popup-img.overlay-link'],
    'picture_nexts' => ['.mfp-arrow-right'],
    'picture_prevs' => ['.mfp-arrow-left'],
    
    'details_start_tag' => '<div id="Container"',
    'details_end_tag' => '<!-- pills end -->',
    'details_spliter' => '<i class="fa fa-cart-arrow-down">',

    'data_capture_regx' => array(
        'stock_number' =>'/data-sku="(?<stock_number>[^"]+)/',
        'title' => '/data-description="(?<title>[^"]+)/',
         'year' => '/class="body productdescbox">\s*<h5><a[^>]+>(?<year>[^<]+)/',
         'make' => '/class="img-responsive[^"]+"[^\.]+\.[^\.]+\.(?<make>[^\.]+)/',
         'model' => '/class="overlay-link " href="\/products\/(?<model>[^\/]+)/',
        'price' => '/data-price="(?<price>[^"]+)/',
        'url' => '/class="overlay-link " href="(?<url>[^"]+)/'
    ),
    'data_capture_regx_full' => array(
        //'year' => '/Engine<\/td>\s*<td>(?<year>[^<]+)/',
         
    ),
    'images_regx' => '/class="img-responsive" src="(?<img_url>[^"]+)/',
);
 
 
 
    add_filter("filter_peheartlandhonda_powerdealer_honda_field_images", "filter_peheartlandhonda_powerdealer_honda_field_images");

    
    function filter_peheartlandhonda_powerdealer_honda_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'img450.jpg');
        });
    }
 