<?php
    global $scrapper_configs;

    $scrapper_configs['happyrv'] = array(
        'entry_points' => array(
            'new'   => 'http://happyrv.com/vehicle/?condition=new',
            'used'  => 'http://happyrv.com/vehicle/?condition=used'
        ),
        'vdp_url_regex'     => '/\/vehicle\/[0-9]{4}-/i',
        'ajax_url_match'    => 'wp-admin/admin-ajax.php',
        'ajax_resp_match'   => 'Sent Successfully',

        'use-proxy' => true,
        'picture_selectors' => ['#content #pager a'],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        
        'details_start_tag' => '<ul class=\'inventory\'>',
        'details_end_tag'   => '<footer>',
        'details_spliter'   => '<div class=\'info\'>',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock No.<\/span><span>#(?<stock_number>[^<]+)/',
            'year'          => '/<a class=\'title\' href=\'[^\']+\'><span>(?<year>[^\s*]+)\s*(?<make>[^0-9]*)\s*(?<model>[^<]+)/',
            'make'          => '/<a class=\'title\' href=\'[^\']+\'><span>(?<year>[^\s*]+)\s*(?<make>[^0-9]*)\s*(?<model>[^<]+)/',
            'model'         => '/<a class=\'title\' href=\'[^\']+\'><span>(?<year>[^\s*]+)\s*(?<make>[^0-9]*)\s*(?<model>[^<]+)/',
            'price'         => '/Price<\/p>\s*<h2>(?<price>\$[0-9,]+)/',
            'body_style'    => '/RV Type<\/span><span>(?<body_style>[^<]+)/',
            'url'           => '/<a class=\'title\' href=\'(?<url>[^\']+)/'
        ),
        'data_capture_regx_full' => array(
            
        ),
        'next_page_regx'      => '/page active\'><a[^\n]+\s*<div class=\'page\s*\'><a href="(?<next>[^"]+)/',
        'images_regx'          => '/<li style="background: url\(\'(?<img_url>[^\']+)/',
    );
    
  