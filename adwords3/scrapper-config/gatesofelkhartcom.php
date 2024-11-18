<?php
global $scrapper_configs;
$scrapper_configs["gatesofelkhartcom"] = array( 
	 'entry_points' => array(
      
        'used' => 'https://www.gatesofelkhart.com/used-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="gv-inventory-list simple-grid list-unstyled">',
    'details_end_tag' => '<div class="clearfix ft">',
    'details_spliter' => '<li class="item hproduct clearfix',
    'data_capture_regx' => array(
        'url' => '/<h3 class="[^>]+>\s*<a href="(?<url>[^"]+)"\sclass=[^>]+>(?<title>[^<]+)/',
        'title' => '/<h3 class="[^>]+>\s*<a href="(?<url>[^"]+)"\sclass=[^>]+>(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/Price\s*[^>]+>:[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
        'stock_number' => '/Stock Number<\/label>\s*<span>(?<stock_number>[^\<]+)/',
        'exterior_color' => '/Exterior Color<\/label>\s*<span>(?<exterior_color>[^\<]+)/',
        
    ),
    'data_capture_regx_full' => array(
        'engine' => '/Engine<\/dt>[^>]+>[^>]+>(?<engine>[^\<]+)/',
         'transmission' => '/Transmission<\/dt>[^>]+>[^>]+>(?<transmission>[^\<]+)/',
          'interior_color' => '/Interior Color<\/dt>[^>]+>[^>]+>[^>]+>[^>]+>(?<interior_color>[^\<]+)/',
          'kilometres' => '/Odometer<\/dt>[^>]+>[^>]+>(?<kilometres>[^\<]+)/',
    ),
    'next_page_regx' => '/next-btn" data-href="(?<next>[^"]+)">/',
    'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)","thumbnail"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
  add_filter("filter_gatesofelkhartcom_field_images", "filter_gatesofelkhartcom_field_images");
    
    function filter_gatesofelkhartcom_field_images($im_urls)
    {
        $retval = [];
        
        foreach($im_urls as $img)
        {
            $retval[] = str_replace('|', '%7c', $img);
        }
        
        return $retval;
    }
