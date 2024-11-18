<?php

    global $scrapper_configs;

    $scrapper_configs['kobzamotorsinc'] = array(
        'entry_points' => array(
            'used'      => 'https://www.kobzamotorsinc.com/inventory.aspx?pagesize=500',
        ),
        'vdp_url_regex'     => '/\/[0-9]{4}_[^_]+_[^_]+.*\.veh/i',
        
        'init_method'       => 'GET',
        'use-proxy' => true,
        //'proxy-area'  => 'FL',

        'picture_selectors' => [],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        
        'details_start_tag' => '<table id="ctl00_cphBody_inv1_tblInventory2Ins" width="100%" cellpadding="0" cellspacing="0" style="border: solid 5px white">',
        'details_end_tag'   => '<div id="ctl00_cphBody_inv1_pnlPageNavBottom" class="normal" style="text-align:right;">',
        'details_spliter'   => '<td colspan="3">',
        
        'must_not_contain_regx' => '/<span[^>]+>SOLD\!<\/span>/',
        
        'data_capture_regx' => array(
            //'stock_number'  => '/Stk #:(?<stock_number>[^\)]+)/',
            'url'           => '/xlargeBoldBlack">\s*<a id="[^"]+" href="(?<url>(?<year>[0-9]{4})_(?<make>[^_]+)_(?<model>[^_]+)[^"]+)">(?<title>[^<]+)/',
            'title'         => '/xlargeBoldBlack">\s*<a id="[^"]+" href="(?<url>(?<year>[0-9]{4})_(?<make>[^_]+)_(?<model>[^_]+)[^"]+)">(?<title>[^<]+)/',
            'year'          => '/xlargeBoldBlack">\s*<a id="[^"]+" href="(?<url>(?<year>[0-9]{4})_(?<make>[^_]+)_(?<model>[^_]+)[^"]+)">(?<title>[^<]+)/',
            'make'          => '/xlargeBoldBlack">\s*<a id="[^"]+" href="(?<url>(?<year>[0-9]{4})_(?<make>[^_]+)_(?<model>[^_]+)[^"]+)">(?<title>[^<]+)/',
            'model'         => '/xlargeBoldBlack">\s*<a id="[^"]+" href="(?<url>(?<year>[0-9]{4})_(?<make>[^_]+)_(?<model>[^_]+)[^"]+)">(?<title>[^<]+)/',
            //'special'       => '/Special\s*(?<special>\$[0-9,]+)/',
            'price'         => '/Price:\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/(?<kilometres>[0-9,]+) Miles/',
            
        ),
        'data_capture_regx_full' => array( 
            'trim'          => '/Trim\/Package:\s*[^\n]+\s*[^\n]+\s*<span id="[^"]+">(?<trim>[^<]*)/',
            'engine'        => '/Engine:\s*[^\n]+\s*[^\n]+\s*<span id="[^"]+">(?<engine>[^<]*)/',
            'transmission'  => '/Transmission:\s*[^\n]+\s*[^\n]+\s*<span id="[^"]+">(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:\s*[^\n]+\s*[^\n]+\s*<span id="[^"]+">(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:\s*[^\n]+\s*[^\n]+\s*<span id="[^"]+">(?<interior_color>[^<]+)/',
            
        ) ,
      
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" id=".*_anchor" class="thickbox"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    );
    
    add_filter("filter_kobzamotorsinc_field_price", "filter_kobzamotorsinc_field_price",10,2);
    
    function filter_kobzamotorsinc_field_price($price,$cardata)
    {
        slecho("Filtering Price");
        if(!empty($cardata['special']) && $cardata['special'])
        {
            $price=$cardata['special'];
        }
        
        return $price;
    }



