<?php
    global $scrapper_configs;

    $scrapper_configs['briggskia'] = array(
        'entry_points' => array(
            'new'   => 'http://www.briggskia.com/new-inventory/index.htm',
            'used'  => 'http://www.briggskia.com/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.previous'],
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
       
        'data_capture_regx' => array(
            'url'           => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<\/]+))/',
            'title'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<\/]+))/',
            'year'          => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<\/]+))/',
            'make'          => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<\/]+))/',
            'model'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<\/]+))/', 
            'exterior_color'=> '/Exterior\s*Color:<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior\s*Color:<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',          
            'stock_number'  => '/Stock\s*#:<\/dt>\s*<dd>(?<stock_number>[^<]+)/',
            'kilometres'    => '/Mileage\s*:<\/dt>\s*<dd>(?<kilometres>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'         => '/name="dl.make".*value="(?<make>[^"]*)/',
            'model'        => '/name="dl.model".*value="(?<model>[^"]*)/',
            'trim'         => '/name="dl.trim".*value="(?<trim>[^"]*)/',
            'price'         => '/class="dollar-sign">[^>]+>[^>]+>(?<price>[^<]+)/',
           
        ),
        'next_page_regx'    => '/<a class="ddc-btn\s*ddc-btn-link[^"]+"\s*href="(?<next>[^"]+)"\srel="next"/',
        'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/'
    );
    