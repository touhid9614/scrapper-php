<?php
global $scrapper_configs;
$scrapper_configs["beanpartsca"] = array( 
 'entry_points' => array(
        'new' => array(
            'https://www.beanparts.ca/wheels',
            'https://www.beanparts.ca/cargo',
            'https://www.beanparts.ca/floor-mats',
            'https://www.beanparts.ca/splash-guards',
            'https://www.beanparts.ca/roof-racks',
            'https://www.beanparts.ca/exterior-accessories',
            'https://www.beanparts.ca/interior-accessories',
            'https://www.beanparts.ca/air-filters',
            'https://www.beanparts.ca/belts-and-hoses',
            'https://www.beanparts.ca/fuel-filters',
            'https://www.beanparts.ca/oil-filters',
            'https://www.beanparts.ca/spark-plugs',
            'https://www.beanparts.ca/wipers',
            
            ),
    ),
    'use-proxy'              => true,
    'refine'                 => false,
    'vdp_url_regex'          => '/\/oem-parts\//i',
   // 'srp_page_regex'          => '/\/inventory\/(?:New|certified|Used)\//i',
    
    'details_spliter'        => '<div class="catalog-product row ">',
    
    'data_capture_regx'      => array(
        'url'            => '/product-image-col col-xs-2">\s*<a href="(?<url>[^"]+)/',
        'stock_number'   => '/data-sku="(?<stock_number>[^"]+)/',
        'make'           => '/data-name="(?<make>[^\s]+)\s*(?<model>[^"]+)/',
        'model'          => '/data-name="(?<make>[^\s]+)\s*(?<model>[^"]+)/',
        'price'          => '/<div class="sale-price">\s*(?<price>\$[0-9,.]+)/',
        
    ),
    'data_capture_regx_full' => array(
        
    ),
    
    'images_regx'  => '/data-image-(?:main-|)url="(?<img_url>[^"]+)"\s*data-image-type="CATALOG"/',
    
);