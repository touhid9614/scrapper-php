<?php

    global $scrapper_configs;

    $scrapper_configs['allenspreowned'] = array(
        'entry_points' => array(
            'used'      => 'https://www.allenspreowned.com/inventory.aspx?pagesize=1000',
        ),
        'vdp_url_regex'     => '/\/[0-9]{4}_[^_]+_[^_]+.*\.veh/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['#ctl00_cphBody_inv1_dlImage td'],
        'picture_nexts'     => ['span#TB_next'],
        'picture_prevs'     => ['span#TB_Previous'],
        
        'details_start_tag' => '<table id="ctl00_cphBody_inv1_tblInventory2Ins"',
        'details_end_tag'   => '<div id="ctl00_cphBody_InventoryWhiteboard">',
        'details_spliter'   => '<table cellpadding="0" cellspacing="0" class="imageBorderBlack" style="height: 130px" width="100%">',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stk #:(?<stock_number>[^\)]+)/',
            'url'           => '/xlargeBoldBlack">\s*<a id="[^"]+" href="(?<url>(?<year>[0-9]{4})_(?<make>[^_]+)_(?<model>[^_]+)[^"]+)">(?<title>[^<]+)/',
            'title'         => '/xlargeBoldBlack">\s*<a id="[^"]+" href="(?<url>(?<year>[0-9]{4})_(?<make>[^_]+)_(?<model>[^_]+)[^"]+)">(?<title>[^<]+)/',
            'year'          => '/xlargeBoldBlack">\s*<a id="[^"]+" href="(?<url>(?<year>[0-9]{4})_(?<make>[^_]+)_(?<model>[^_]+)[^"]+)">(?<title>[^<]+)/',
            'make'          => '/xlargeBoldBlack">\s*<a id="[^"]+" href="(?<url>(?<year>[0-9]{4})_(?<make>[^_]+)_(?<model>[^_]+)[^"]+)">(?<title>[^<]+)/',
            'model'         => '/xlargeBoldBlack">\s*<a id="[^"]+" href="(?<url>(?<year>[0-9]{4})_(?<make>[^_]+)_(?<model>[^_]+)[^"]+)">(?<title>[^<]+)/',
            'special'       => '/Special\s*(?<special>\$[0-9,]+)/',
            'price'         => '/Price:\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/(?<kilometres>[0-9,]+) Miles/',
            
        ),
        'data_capture_regx_full' => array( 
            'trim'          => '/Trim/Package:\s*[^\n]+\s*[^\n]+\s*<span id="[^"]+">(?<trim>[^<]*)/',
            'engine'        => '/Engine:\s*[^\n]+\s*[^\n]+\s*<span id="[^"]+">(?<engine>[^<]*)/',
            'transmission'  => '/Transmission:\s*[^\n]+\s*[^\n]+\s*<span id="[^"]+">(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:\s*[^\n]+\s*[^\n]+\s*<span id="[^"]+">(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:\s*[^\n]+\s*[^\n]+\s*<span id="[^"]+">(?<interior_color>[^<]+)/'
            
        ) ,
       // 'next_page_regx'    => '//',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" id=".*_anchor" class="thickbox"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    
    add_filter("filter_allenspreowned_field_price", "filter_allenspreowned_field_price",10,2);
    
    function filter_allenspreowned_field_price($price,$cardata)
    {
        slecho("Filtering Price");
        if(!empty($cardata['special']) && $cardata['special'])
        {
            $price=$cardata['special'];
        }
        
        return $price;
    }



