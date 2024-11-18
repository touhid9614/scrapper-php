<?php
    global $scrapper_configs;

    $scrapper_configs['downtownbuick'] = array(
        'entry_points' => array(
            'new'   => 'http://www.downtownbuick.com/VehicleSearchResults?search=new',
            'used'  => 'http://www.downtownbuick.com/VehicleSearchResults?search=preowned'
        ),
        'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',

        'use-proxy' => true,
        'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
        'picture_nexts'     => ['.arrow.single.next'],
        'picture_prevs'     => ['.arrow.single.prev'],

        'details_start_tag'    => '<ul each="cards">',
        'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
        'details_spliter'   => '<div class="deck" each="cards">',

        'data_capture_regx' => array(
            'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
            // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
            'year'              => '/<span itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
            'make'              => '/<span .*itemprop="manufacturer">(?<make>[^<]+)/',
            'model'             => '/<span itemprop="model">(?<model>[^<]+)/',
            'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
            'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
            'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
            'transmission'      => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
            'price'             => '/itemprop="price" data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
            'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
          ),
         'next_page_regx'    => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
        'images_regx'        => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    );
    
//    add_filter("filter_downtownbuick_field_images", "filter_downtownbuick_field_images");
//    function filter_downtownbuick_field_images($im_urls)
//    {
//       $retval = array();
//
////        foreach($im_urls as $url) {
////            $retval[] = trim($url);
////        }
//    array_reverse($im_urls);
//
//        return $im_urls;
//    }
