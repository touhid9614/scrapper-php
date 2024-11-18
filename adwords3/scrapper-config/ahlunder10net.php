<?php
global $scrapper_configs;
$scrapper_configs["ahlunder10net"] = array( 
	 'entry_points' => array(
        'used' => 'https://www.ahlunder10.net/bargain-inventory/index.htm',
    ),
    'vdp_url_regex' => '/bargain\/[^\/]+\/[0-9]{4}-/i', 
    'use-proxy' => true,
    'picture_selectors' => ['.pswp-thumbnail'],
    'picture_nexts' => ['.ddc-icon-carousel-arrow-right'],
    'picture_prevs' => ['.ddc-icon-carousel-arrow-left'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div  class="ddc-footer">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',    
        'stock_number' => '/Stock #[^>]+>\s*[^>]+>(?<stock_number>[^\<]+)/',
        'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'exterior_color' => '/Exterior Colou?r:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Colou?r:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
        'transmission' => '/Transmission:[^>]+>\s*[^>]+>(?<transmission>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/>Odometer[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
    ),
    'next_page_regx' => '/<a rel="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/id"[^"]+"src"[^"]+"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_ahlunder10net_field_images", "filter_ahlunder10net_field_images");
  

function filter_ahlunder10net_field_images($im_urls) {
   $retval = [];
         foreach($im_urls as $img)
        {
            
             $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
        }
        
        return $retval;
}
