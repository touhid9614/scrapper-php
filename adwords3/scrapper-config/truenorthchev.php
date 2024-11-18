<?php
global $scrapper_configs;

$scrapper_configs['truenorthchev'] = array(
      'entry_points' => array(
            'new'   => 'https://www.truenorthchev.com/en/new-catalog',
           // 'used'  => 'https://www.truenorthchev.com/en/used-inventory?limit=500'
        ),
        'vdp_url_regex'     => '/\/en\/(?:used-inventory|new-catalog)\//i',
        //'ty_url_regex'      => '/\//en\/thank-you/i',
        //'ajax_url_match'    => 'callback=secureLeadSubmission',
        //'use-proxy'         => true,
       
      
        'picture_selectors' => ['.catalog-vehicle-gallery-popup__gallery-bxpager a'],
        'picture_nexts'     => ['.bx-next'],
        'picture_prevs'     => ['.bx-prev'],
        'new'   => array(
            'vdp_url_regex'     => '/\/en\/new-catalog\//i',
            'use-proxy'         => true,
            //'proxy-area'        => 'FL',
            'custom_data_capture' => function($url, $resp){
                global $proxy_list;
                
                $inventory = truenorthchev_get_newInventory($url,$resp);
                
                slecho("Count of vehicles :".count($inventory));
                
                $to_return = [] ;
                foreach($inventory as $url){
                    slecho("URL = " . $url);
                    $car_data  = [];
                    $car_data['url'] = $url;
                    $car_data['stock_number'] = md5($url);
                    $temp_data = HttpGet($url, $proxy_list);
                    $data_capture_regx_full = array(                       
                        'make'          => '/\&desired_make=(?<make>[^\&]+)/',
                        'model'         => '/\&desired_model=(?<model>[^\&]+)/',
                        'body_style'    => '/<meta property="og:image" content="https?:\/\/[^\/]+\/[^\/]+\/newcar\/[0-9]{4}\/[^\/]+\/[^\/]+\/[^\/]+\/(?<body_style>[^\/]+)/',
                        'year'          => '/year:\'(?<year>[^\']+)/',
                        'trim'          => '/desired_trim=(?<trim>[^(?:"|\&)]+)/',
                        'price'         => '/<span class="price__detail-price-price[^>]+>\s*(?<price>\$[0-9,]+)/',
                       
                    ) ;
                    foreach ($data_capture_regx_full as $key => $regx) {
                        if (preg_match($regx, $temp_data, $match)) {
                            if (array_key_exists($key, $match)) {
                                $car_data[$key] = str_replace("\n", '', $match[$key]);
                            } 
                        } else {
                            //slecho(print_r($match, true));
                            slecho("Error in $key regex");
                        }
                    }
                    $images_regex    = '/data-picture-index="[0-9]*"\s*data-view="ninjabox-gallery"><\/div>\s*<span class="overlay">\s*<img src="(?<img_url>[^"]+)/';
                    $images_fallback_regex = '/<meta property="og:image" content="(?<img_url>[^"]+)"/';

                    $matches = array();

                    if(preg_match_all($images_regex, $temp_data, $matches))
                    {
                        $car_data['images']     = $matches['img_url'];
                        $car_data['all_images'] = implode('|', $car_data['images']);

                    }elseif(preg_match_all($images_fallback_regex, $temp_data, $matches))
                    {
                        $car_data['images']     = $matches['img_url'];
                        $car_data['all_images'] = implode('|', $car_data['images']);

                    }

                    $to_return[] = $car_data;
                }
                return $to_return;
            },
            
           
        ),
   /* 'used'   => array(
            'vdp_url_regex'     => '/\/en\/inventory-used\//i',
            'use-proxy'         => true,
            'details_start_tag' => '<article class="inventory-list-vehicle-wrapper',
            'details_end_tag'   => '<span id="price-legal">',
            'details_spliter'   => '<div class="inventory-list-vehicle__preview-actions-cta">',
            'data_capture_regx' => array(
                'stock_number'  => '/Inventory #[^>]+>[^>]+>(?<stock_number>[^<]+)/',
                'title'         => '/<a class="inventory-list-vehicle__preview-name" href="(?<url>[^"]+)" title="(?<title>[^"]+)/',
                'year'          => '/desired_year=(?<year>[^"]+)/',
                'make'          => '/desired_make=(?<make>[^\&]+)/',
                'model'         => '/desired_model=(?<model>[^\&]+)/',
                'trim'          => '/desired_trim=(?<trim>[^"]+)/',
                'price'         => '/<span class="inventory-list-vehicle__preview-price[^>]+>\s*(?<price>\$[0-9,]+)/',
                'kilometres'    => '/(?<kilometres>[0-9 ,]+)\s*KM/',
                'transmission'  => '/transmission"[^\n]+\s*<span>(?<transmission>[^<]+)/',
                'url'           => '/<a class="inventory-list-vehicle__preview-name" href="(?<url>[^"]+)" title="(?<title>[^"]+)/'
            ),
            'data_capture_regx_full' => array(
                'body_style'    => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
                //'engine'        => '/engine-type">\s*[^\n]+\s*(?<engine>[^\n]+)/',
                
            ) ,
                   
            //'next_page_regx'    => '/<li class="current\s*test"><a href="[^"]+">[^<]+<\/a><\/li>\s*<li ><a href="(?<next>[^"]+)"/',
            'images_regx'       => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)/',
            
        ),
    
    */
            
    );
  
    add_filter("filter_truenorthchev_field_images", "filter_truenorthchev_field_images");
    
    function filter_truenorthchev_field_images($im_urls)
    {
        if(count($im_urls)<2) return [];
        for($i = 0; $i <count($im_urls); $i++) {
            $im_urls[$i] = str_replace(['w100h75','w195h145c'], 'w600h400', $im_urls[$i]);
        }
        
        return $im_urls;
    }
    
    
function truenorthchev_get_newInventory($url,$temp){
    global $proxy_list;
    $details_start_tag = '<div id="catalog-listing-alpha__chevrolet"';
    $details_end_tag = '<p class="catalog-listing-alpha__disclaimer';
    $details_spliter = '<span class="link__alpha-text ">More Details';

    if ($details_start_tag) {
        $temp = substr($temp, stripos($temp, $details_start_tag));
    }

    if ($details_end_tag) {
        $temp = substr($temp, 0, stripos($temp, $details_end_tag));
    }

    $spltd = $temp;
    if ($details_spliter) {
        $spltd = explode($details_spliter, $temp);
    }
    
    $vdp_url = '';
    $car_url = [];
    $ttl_inventory = [];
    foreach ($spltd as $data) {

        $url_regex = '/class="catalog-block-alpha__name-anchor" href="(?<url>[^"]+)"/';
        if (preg_match($url_regex, $data, $matches)) {
            $vdp_url = 'https://www.truenorthchev.com/'. $matches['url'];
        }
        $vdp_data = HttpGet($vdp_url, $proxy_list);
        $car_url_regx = '/class="catalog-details__header-vehicle-trims-items">\s*<a href="(?<car_url>[^"]+)"/';

        if(preg_match_all($car_url_regx, $vdp_data,$matches))
        {
            $car_url = $matches['car_url'];
        }
        $ttl_inventory  = array_merge($ttl_inventory,$car_url);

    }
    $ttl_inventory = array_map(function($url)
                    {return 'https://www.truenorthchev.com/'. $url;}
                    ,$ttl_inventory);   
    return $ttl_inventory;
}