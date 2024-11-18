<?php
global $scrapper_configs;
$scrapper_configs["ottawachryslerjeepdodgecom"] = array( 
	"entry_points" => array(
      'new' => 'https://www.ottawachryslerjeepdodge.com/new/',
      'used' =>'https://www.ottawachryslerjeepdodge.com/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
   
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer wp"',
    'details_spliter' => '<div itemprop="ItemOffered"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><\/a><\/p><span/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\s*]+)/',
        'model' => '/itemprop=\'model\' notranslate>(?<model>[^<]+)/',
        'price' => '/<span itemprop="price"[^\>]+>(?<price>[^\<]+)<\/span><\/span>/',
        'stock_number' => '/STK#\s*(?<stock_number>[^\s*]+)/',
        'transmission' => '/"transmission":"(?<transmission>[^"]+)/',
        'exterior_color' => '/"exteriorColour":"(?<exterior_color>[^"]+)/',
         'interior_color' => '/"interiorColour":"(?<interior_color>[^"]+)/',
        'engine' => '/"engine":"(?<engine>[^"]+)/',
        'kilometres' => '/"mileage":"(?<kilometres>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
       
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)"/'
);
