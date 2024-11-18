<?php

global $scrapper_configs;

$scrapper_configs['harleydavidsonofyorkton'] = array(
    'entry_points' => array(
            'new'  => 'https://www.harleydavidsonofyorkton.com/default.asp?page=inventory&condition=new',
            'used' => 'https://www.harleydavidsonofyorkton.com/default.asp?page=inventory&condition=pre-owned'
        ),
        'vdp_url_regex'     => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-Harley-Davidson-/i',
        'ty_url_regex'      => '/\/thank-you/i',
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.prev'],
        
        'details_start_tag' => '<h2 class="v7list-subheader__heading">',
        'details_end_tag'   => '<div class="v7list-footer">',
        'details_spliter'   => '<li class="v7list-results__item"',
        'data_capture_regx' => array(
            'url'           => '/vehicle-heading__link" href="(?<url>[^"]+)/',
            'year'          => '/<span class="vehicle-heading__year">(?<year>[^<]+)/',
            'make'          => '/vehicle-heading__name">(?<make>[^<]+)/',
            'model'         => '/vehicle-heading__model">(?<model>[^<]+)/',
            'price'         => '/class="vehicle-price__price ">\s*(?<price>\$[0-9,]+)/',
            'stock_number'  => '/Stock Number:\s[^>]+>(?<stock_number>[^<]+)/',
         
        ),
        'data_capture_regx_full' => array(        
           
        ) ,
       'images_regx'       => '/<div class="lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
);
    add_filter('filter_harleydavidsonofyorkton_field_make', 'unicodify');
    add_filter('filter_harleydavidsonofyorkton_field_model', 'unicodify');
  

    function harleydavidsonofyorkton_images_proc($image_url)
    {
        $tmp = str_replace('&#x2F;', '/', $image_url);
        return $tmp;
    }