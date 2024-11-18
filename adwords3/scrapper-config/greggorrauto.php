<?php
global $scrapper_configs;
 $scrapper_configs["greggorrauto"] = array( 
   'entry_points'      => array(),
        'no_scrap'          => true
     
     );
     
     
//	 'entry_points' => array(
//            'new'   => 'https://www.greggorrauto.com/search/new/',
//            'used'  => 'https://www.greggorrauto.com/search/used/',
//           
//        ),
//        'use-proxy' => true,
//        'vdp_url_regex'     => '/\/[^\/]+\/(?:new|used)-[0-9]{4}-/i',
//        'ty_url_regex'      => '/\/thank-you-/i',
//        'picture_selectors' => ['.dep_image_slider_ul_style li'],
//        'picture_nexts'     => ['.dep_image_slider_alt_next_btn'],
//        'picture_prevs'     => ['.dep_image_slider_alt_prev_btn'],
//        'details_start_tag' => '<div class="srp_results_count_container">',
//        'details_end_tag'   => '<div id="details-disclaimer"',
//        'details_spliter'   => '<div class="srp_vehicle_wrapper srp_vehicle_item_container"',
//        
//        'data_capture_regx' => array(
//            'stock_number'  => '/<meta\s*itemprop="sku"\s*content="(?<stock_number>[^"]+)/',
//            'year'          => '/<meta\s*itemprop="releaseDate"\s*content="(?<year>[^"]+)/',
//            'make'          => '/<meta\s*itemprop="brand"\s*content="(?<make>[^"]+)/',
//            'model'         => '/<meta\s*itemprop="model"\s*content="(?<model>[^"]+)/',
//            'transmission'  => '/<meta\s*itemprop="vehicleTransmission"\s*content="(?<transmission>[^"]+)/',
//            'price'         => '/(?:Gregg Orr Price|Price)\s*<\/dt>[^\$]+\s*(?<price>\$[0-9,]+)/',
//            'exterior_color'=> '/<meta\s*itemprop="color"\s*content="(?<exterior_color>[^"]+)/',
//            'interior_color'=> '/<meta\s*itemprop="vehicleInteriorColor"\s*content="(?<interior_color>[^"]+)/',
//            'kilometres'    => '/Mileage:<\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',
//            'url'           => '/srp_vehicle_titlebar.*\s.*<h2\s*><a href="(?<url>[^"]+)".*title="(?<title>[^"]+)/',
//            'title'         => '/srp_vehicle_titlebar.*\s.*<h2\s*><a href="(?<url>[^"]+)".*title="(?<title>[^"]+)/'
//        ),
//        'data_capture_regx_full' => array(
//            'engine'        => '/Engine<\/td>\s*<td[^>]+>(?<engine>[^<]+)/',
//            'trim'          => '/Trim<\/td>\s*<td[^>]+>(?<trim>[^<]+)/',
//            'model'         => '/<meta itemprop="model"\s*content="(?<model>[^"]+)/',
//            'certified'     => '/<img\s*class="(?<certified>certified)"/'
//            
//            
//        ),
//        'next_page_regx'        => '/<li class="active[^>]+.*<\/li>\s*<li[^>]+>\s*<a\s*class="[^"]+"\s*href="(?<next>[^"]+)/',
//       'images_regx'          => '/<\/div>\s*<meta itemprop="image"\s*content="(?<img_url>[^"]+)"/',
//    );
//    
//    add_filter('filter_greggorrauto_field_images', 'filter_greggorrauto_field_images');
//    
//    
//    function filter_greggorrauto_field_images($im_urls)
//    {
//        return array_filter($im_urls, function ($im_url){
//            return !endsWith($im_url,'null_o.jpg');
//        });
//    }
//    
//    