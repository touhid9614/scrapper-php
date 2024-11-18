<?php
    global $scrapper_configs;

    $scrapper_configs['spanglermotors'] = array(
        'entry_points' => array(
            'new'   => 'http://www.spanglermotors.net/new-inventory/?vehicle_type=All',
            'used'  => 'http://www.spanglermotors.net/used-inventory/'
        ),
        'vdp_url_regex'     => '/\/details\//i',
        
        'required_params'   => [],
        //'use-proxy' => true,
        
        'picture_selectors' => [],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        
        'details_start_tag' => '<ul class="inventory-list inventory-list',
        'details_end_tag'   => '<footer data-dimension="footer">',
        'details_spliter'   => '<li class="row-fluid inventory-item',
        
        'data_capture_regx' => array(
            'url_inc'           => '/<a href="(?<url_inc>[^"]+)" itemprop="url"/',
            'url'           => '/<a href="(?<url>[^"]+)" itemprop="url"/',
            'stock_number'  => '/Stock ID:<\/dt>\s*<dd[^>]*>(?<stock_number>[^<]+)/',
            'year'          => '/itemprop="releaseDate">(?<year>[0-9]{4})/',
            'make'          => '/(?:itemprop="brand">(?<make>[^<]+)|<a href="[^\&]+\&amp;make=(?<make>[^\&]+))/',
            'model'         => '/itemprop="model">(?<model>[^<]+)/',
            'trim'          => '/hidden-tile">(?<trim>[^<]+)/',
            'price'         => '/itemprop="price">\s*(?<price>[0-9,]+)/',
            
            'engine'        => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>\s*(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/dt>\s*<dd[^>]+>\s*(<span[^>]+><\/span>\s*)?(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/dt>\s*<dd[^>]+>\s*<span[^>]+><\/span>\s*(?<interior_color>[^\n]+)/',
            'kilometres'    => '/Mileage:<\/dt><dd>\s*(?<kilometres>[^\n]+)/',
            
        ),
        'data_capture_regx_full' => array(
            'make'          => '/car_make" value="(?<make>[^"]+)/',
            'model'         => '/car_model" value="(?<model>[^"]+)/',
            
        ),
       // 'next_page_regx'    => '//',
        'images_regx'       => '/data-slide-to="[0-9]*"\s*src="(?<img_url>[^"]+)/',
       // 'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
   add_filter("filter_spanglermotors_field_url", "filter_spanglermotors_field_url",10,2);
   add_filter("filter_spanglermotors_field_images", "filter_spanglermotors_field_images");
   
   function filter_spanglermotors_field_url($url,$cardata)
   {
        slecho("Appending URL");
        $url='';
        if(!empty($cardata['url_inc']) && $cardata['url_inc'])
        {
            $url="/".$cardata['url_inc'];
        }
        
        return $url;
   }
    
    function filter_spanglermotors_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_replace('tn_', '', $url);
            $retval[] = str_replace('|', '%7C', $url);
        }

        return $retval;
    }