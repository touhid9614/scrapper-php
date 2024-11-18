<?php
global $scrapper_configs;
$scrapper_configs["palmenkiacom"] = array( 
	"entry_points" => array(
	    'new' => 'https://www.palmenkia.com/new-kia-kenosha-wi?limit=300',
        'used' => 'https://www.palmenkia.com/used-cars-kenosha-wi?limit=300',
    ),
     'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
    
        'picture_selectors' => ['.zoom-thumbnails__thumbnail'],
        'picture_nexts'     => ['.df-icon-chevron-right '],
        'picture_prevs'     => ['.df-icon-chevron-left'],
    
    'details_start_tag' => '<div class="inventory-listing',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div class="vehicle-item inventory-listing__item',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'year' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'make' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'model' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'trim' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
         'price' => '/Palmen Price\s*<\/div>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
        
        
    ),
    'data_capture_regx_full' => array(
       'stock_number' => '/Stock<\/div>[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/Body<\/div>\s*[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'kilometres' => '/Mileage[^>]+>\s*[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
        'year' => '/>Year[^>]+>\s*[^>]+>\s*[^>]+>(?<year>[0-9]{4})/',
        'make' => '/>Make[^>]+>\s*[^>]+>\s*[^>]+>(?<make>[^<]+)/',
        'model' => '/>Model<\/div>\s*[^>]+>\s*[^>]+>(?<model>[^<]+)/',
        'exterior_color' => '/Exterior Color[^>]+>\s*[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color[^>]+>\s*[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'transmission' => '/>Transmission<\/div>\s*[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
        'drive_train' => '/>Drivetrain<\/div>\s*[^>]+>\s*[^>]+>(?<drive_train>[^<]+)/',
        'fuel_type' => '/>Fuel Type<\/div>\s*[^>]+>\s*[^>]+>(?<fuel_type>[^<]+)/',
        'vin' => '/>VIN<\/div>\s*[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        
    ),
   // 'next_page_regx'    => '/<a class="pagination-next js-pagination-btn"\s*href="(?<next>[^"]+)"/',
     'images_regx'  => '/<source data-srcset="(?<img_url>[^\s]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
