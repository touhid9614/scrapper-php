<?php
    global $scrapper_configs;

    $scrapper_configs['megaautomobile'] = array(
        'entry_points' => array(
            'used'  => 'http://www.megaautomobile.com/en/for-sale/all/used/'
        ),
        'vdp_url_regex'     => '/\/inventory\/(?:new|used)\/vehicle\//i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        
        'picture_selectors' => ['.connected-carousels.carousel-navigation li img'],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        'details_start_tag' => '<div class="inventory-list__vehicles clearfix">',
        'details_end_tag'   => '<footer class="footer"',
        'details_spliter'   => '<article class="block-inventory-vehicle clearfix',
        'data_capture_regx' => array(
            'stock_number'  => '/block-inventory-vehicle__stockNo[^\n]+\s*#\s*(?<stock_number>[^\n]+)/',
            'title'         => '/inventory-vehicle__name"\s*href="(?<url>[^"]+)"\s*title="(?<title>[^"]+)/',
            'year'          => '/inventory-vehicle__name"\s*href="[^"]+"\s*title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
            'make'          => '/inventory-vehicle__name"\s*href="[^"]+"\s*title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
            'model'         => '/inventory-vehicle__name"\s*href="[^"]+"\s*title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
            'price'         => '/priceInventory">\s*(?<price>\$[0-9,]+)/',
            'transmission'  => '/(?<kilometres>[0-9,]+) KM.*&nbsp;\|&nbsp;<span>(?<transmission>Automatic|Manual)/',
            'kilometres'    => '/(?<kilometres>[0-9,]+) KM.*&nbsp;\|&nbsp;<span>(?<transmission>Automatic|Manual)/',
            'url'           => '/inventory-vehicle__name"\s*href="(?<url>[^"]+)"\s*title="(?<title>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'          => '/make:\'(?<make>[^\']+)/',
            'model'         => '/model:\'(?<model>[^\']+)/',
            'body_style'    => '/Bodystyle<\/td>\s*<td>(?<body_style>[^<]+)/',
            'engine'        => '/Cylinders<\/td>\s*<td>(?<engine>[^<]+)/',
            'exterior_color'=> '/Ext. Color<\/td>\s*<td>(?<exterior_color>[^<]+)/',
        ),
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/(?:data-view="ninjabox-gallery">|<\/div>\s*<\/div>\s*)<\/div>\s*<img src="(?<img_url>[^"]+)" alt=/'
    );
    
    add_filter("filter_megaautomobile_field_images", "filter_megaautomobile_field_images");
    
    function filter_megaautomobile_field_images($im_urls)
    {
        $retval = array();
        
        foreach($im_urls as $url) {
            $retval[] = str_replace('w127h80c', 'w770h577', $url);
        }
        
        return $retval;
    }
