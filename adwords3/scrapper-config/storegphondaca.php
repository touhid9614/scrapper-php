<?php
global $scrapper_configs;
$scrapper_configs["storegphondaca"] = array( 
	'entry_points'        => array(
        'new' => array(
            'https://store.gphonda.ca/collections/mens',
            'https://store.gphonda.ca/collections/womens',
            'https://store.gphonda.ca/collections/youth',
            'https://store.gphonda.ca/collections/winter-safety-gear',
            'https://store.gphonda.ca/collections/all-helmets/helmet',
            'https://store.gphonda.ca/collections/mx-bags',
            
            'https://store.gphonda.ca/collections/lifestyle-clothing',
            'https://store.gphonda.ca/collections/lifestyle-clothing/mens',
            'https://store.gphonda.ca/collections/lifestyle-clothing/womens',
            'https://store.gphonda.ca/collections/lifestyle-clothing/youth',
            'https://store.gphonda.ca/collections/lifestyle-clothing/infant',
            'https://store.gphonda.ca/collections/accessories',
            /*
            'https://store.gphonda.ca/collections/mono-suit-1',
            'https://store.gphonda.ca/collections/jackets-1',
            'https://store.gphonda.ca/collections/winter-pants',
            'https://store.gphonda.ca/collections/under-layer-1',
            'https://store.gphonda.ca/collections/mens-winter-boots/MENS-WINTER-BOOTS',
            'https://store.gphonda.ca/collections/winter-helmet-1',
            'https://store.gphonda.ca/collections/sled-goggles',
            'https://store.gphonda.ca/collections/winter-gloves-1',
            'https://store.gphonda.ca/collections/hats-beanies',
            'https://store.gphonda.ca/collections/lens',
            'https://store.gphonda.ca/collections/mono-suit',
            'https://store.gphonda.ca/collections/jackets',
            'https://store.gphonda.ca/collections/winter-helmet',
            'https://store.gphonda.ca/collections/winter-boots',
            'https://store.gphonda.ca/collections/winter-gloves',
            'https://store.gphonda.ca/collections/hats-beanies-1',
            'https://store.gphonda.ca/collections/mono-suit-2',
            
            'https://store.gphonda.ca/collections/mono-suit-2',
            'https://store.gphonda.ca/collections/jackets-2',
            'https://store.gphonda.ca/collections/snow-pants',
            'https://store.gphonda.ca/collections/under-layer-1',
            'https://store.gphonda.ca/collections/winter-boots-2',
            '',
            'https://store.gphonda.ca/collections/sled-goggles',
            'https://store.gphonda.ca/collections/winter-gloves-2',
            'https://store.gphonda.ca/collections/hats-beanies-3',
            'https://store.gphonda.ca/collections/lens',
            'https://store.gphonda.ca/collections/mono-suit',
            'https://store.gphonda.ca/collections/jackets',
            'https://store.gphonda.ca/collections/winter-helmet',
            'https://store.gphonda.ca/collections/winter-boots',
            'https://store.gphonda.ca/collections/winter-gloves',
            'https://store.gphonda.ca/collections/hats-beanies-1',
            'https://store.gphonda.ca/collections/mono-suit-2',
             
             */
            )
    ),
    'vdp_url_regex'       => '/\/collections\//',
    'use-proxy'           => true,
    'refine' => false,
    'details_start_tag' => '<div class="grid grid--no-gutters grid--uniform">',
    'details_end_tag'   => '<div id="shopify-section-footer"',
    'details_spliter'   => '<div class="grid__item small--one-half medium-up--one-fifth">',
    'data_capture_regx' => array(
        'url'   => '/<a href="(?<url>[^"]+)" class="product-card">/',
        'title' => '/<div class="product-card__name">(?<title>[^<]+)/',
        'make'  => '/<div class="product-card__brand">(?<make>[^<]+)/',
        'model' => '/<div class="product-card__name">(?<model>[^<]+)/',
        'price' => '/Regular price<\/span>\s*(?<price>\$[0-9,.]+)/',
    ),
    'data_capture_regx_full' => array(
        
    ),
    
    'next_page_regx' => '/<span class="next"><a href="(?<next>[^"]+)"/',
    'images_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'

);

