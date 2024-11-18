<?php
global $scrapper_configs;
$scrapper_configs["verypetcomau"] = array( 
	'entry_points' => array(
            'new'   => array(
                'https://verypet.com.au/shop/brand/orijen/',
                'https://verypet.com.au/shop/brand/acana/',
                'https://verypet.com.au/shop/brand/taste-of-the-wild/',
                'https://verypet.com.au/shop/brand/diamond-care/',
                'https://verypet.com.au/shop/brand/diamond-naturals/',
                'https://verypet.com.au/shop/brand/nutragold-grain-free/',
                'https://verypet.com.au/shop/brand/moshizon/',
                'https://verypet.com.au/shop/brand/diamond-pro89/',
                'https://verypet.com.au/shop/brand/professional/',
                'https://verypet.com.au/shop/brand/the-golden-bone-bakery/',
                'https://verypet.com.au/shop/brand/zealandia/',
                
                
                ),
        ),
        'vdp_url_regex'     => '/\/shop/product\//i',
        'use-proxy'         => true,
        'refine'            => false,
        
        'details_start_tag' => '<ul class="jet-woo-builder-products',
        'details_end_tag'   => '<div data-elementor-type="footer" ',
        'details_spliter'   => '<li class="jet-woo-builder-product',
        
        'data_capture_regx' => array(
            'make'          => '/<div class="elementor-widget-container">\s*<div class="jet-woo-builder-archive[^>]+><span class=[^>]+>(?<make>[^<]+)/',
            'model'         => '/<h2 class="jet-woo-builder-a[^>]+><a href="(?<url>[^"]+)">(?<model>[^<]+)/',        
            'url'           => '/<h2 class="jet-woo-builder-a[^>]+><a href="(?<url>[^"]+)">(?<model>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'price'         => '/display_regular_price\&quot\;\:(?<price>[0-9,.]{5})/',
            
        ),
        
        'images_regx'       => '/class="woocommerce-product-gallery__image"><a href="(?<img_url>[^"]+)"/',
       
    );
