<?php

global $scrapper_configs;

$scrapper_configs['lithianissaneugene'] = array(
    'entry_points' => array(
        'new' => 'https://www.lithianissaneugene.com/new-inventory/index.htm',
        'used' => 'https://www.lithianissaneugene.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/+[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.jcarousel-item'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.previous'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/final-price.*class=\'value[^>]+>(?<price>[^<]+)/',
        // 'body_style' => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
        'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
        'transmission' => '/Transmission:<\/dt>\s<dd>(?<transmission>[^<]+)/',
        'kilometres' => '/<dt>Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'data_capture_regx_full' => array(
         'body_style' => '/bodyStyle: \'(?<body_style>[^\']+)/',
         'price' => '/class="(?:askingPrice|stackedConditionalFinal).*"\s*data-attribute-value="(?<price>[^"]+)/',
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
   'images_regx'       => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
 add_filter("filter_lithianissaneugene_field_price", "filter_lithianissaneugene_field_price", 10, 3);
  
    
    
    function filter_lithianissaneugene_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
        $internet_regex   =  '/Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
        $market_regex     =  '/class="(?:askingPrice|stackedConditionalFinal).*"\s*data-attribute-value="(?<price>[^"]+)/';
       

                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex internet: {$matches['price']}");
        }
       
         if(preg_match($market_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("market_regex : {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
    
   
add_filter("filter_lithianissaneugene_field_images", "filter_lithianissaneugene_field_images");
function filter_lithianissaneugene_field_images($im_urls)
{
    
    if(count($im_urls) < 2) { return array(); }

     return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'unavailable_stockphoto.png');
        });
   
}