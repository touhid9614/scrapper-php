<?php
global $scrapper_configs;
$scrapper_configs["everestmotorsinccom"] = array( 
	'entry_points' => array(
            'used'   => 'http://www.everestmotorsinc.com/newandusedcars.aspx?clearall=1&pagesize=200',
            
        ),
        'vdp_url_regex'     => '/vdp/i',
       
        'use-proxy' => true,
        'next_method'       => 'POST',
        
        'picture_selectors' => ['.carousel-inner > .item'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div id="ContentPane" class="">',
        'details_end_tag'   => '<div id="FooterPane"',
        'details_spliter'   => '<div class="i11r_detailsPhone',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:<\/label>\s*(?<stock_number>[^<]+)/',
            'url'           => '/i11r_vehicleTitle">\s*<a[^"]+"[^"]+"[^"]+"[^"]+"\s*href="(?<url>[^"]+)/',
            'year'          => '/Year:<\/label>\s*\&nbsp;(?<year>[^<]+)/',
            'make'          => '/Make:<\/label>\s*\&nbsp;(?<make>[^<]+)/',
            'model'         => '/Model:<\/label>\s*\&nbsp;(?<model>[^<]+)/',
            'trim'          => '/Trim:<\/label>\s*\&nbsp;\s*(?<trim>[^\n]+)',
            'price'         => '/<span class=\'price-2\'>(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/>Color:<\/label>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color:<\/label>\s*(?<interior_color>[^<]+)/',
            'engine'        => '/Engine:<\/label>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Trans:<\/label>\s*(?<transmission>[^<]+)/',
            'kilometres'    => '/Mileage:<\/label>\s*(?<kilometres>[^<]+)/',
            'body_style'=> '/Body Type:<\/label>\s*(?<body_style>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'make'     => '/ctl02_ctl02_ctl00_lblMake">(?<make>[^<]+)/',
            'model'    => '/ctl02_ctl02_ctl00_lblModel">(?<model>[^<]+)/',
            
        ),
        //'next_query_regx'    => '/dxp-num dxp-current">[^<]+<\/b><a class="dxp-num" onclick="__doPostBack\(&#39;ctl02\$ctl02\$ctl00\$ASPxPager(?:1|2)&#39;,&#39;(?<param>PN)(?<value>[0-9]+)+&#39;\)/',
        'images_regx'       => '/<img data-src=\'(?<img_url>[^\']+)/'
    );
    add_filter('filter_everestmotorsinccom_field_url', 'filter_everestmotorsinccom_field_url');
    
    function filter_everestmotorsinccom_field_url($url)
    {
        return trim($url);
    }
   