<?php
global $scrapper_configs;
 $scrapper_configs["autoshowwinnipeg"] = array( 
	'entry_points' => array(
            'used'  => 'https://www.autoshowwinnipeg.com/isapi_xml.php?module=inventory&pageID=741&main=&limit=220&orderby=make&offset=0'
        ),
        'vdp_url_regex'     => '/\/inventory\//i',
        'use-proxy' => true,
        //'proxy-area'        => 'FL',
        'picture_selectors' => ['.photo'],
        'picture_nexts'     => ['.slick-next'],
        'picture_prevs'     => ['.slick-prev'],
        
       // 'details_start_tag' => '<body class="page-template',
       // 'details_end_tag'   => '<div id="footer">',
        'details_spliter'   => '<div class="car-col col-xs-12 col-sm-6 col-md-4 col-lg-3">',
        'data_capture_regx' => array(
            'url'           => '/<div class="titleBox" onclick="[^.]+.href=\'(?<url>[^\']+)\'">\s*<h2>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'title'         => '/<div class="titleBox" onclick="[^.]+.href=\'(?<url>[^\']+)\'">\s*<h2>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'year'          => '/<div class="titleBox" onclick="[^.]+.href=\'(?<url>[^\']+)\'">\s*<h2>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'make'          => '/<div class="titleBox" onclick="[^.]+.href=\'(?<url>[^\']+)\'">\s*<h2>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'model'         => '/<div class="titleBox" onclick="[^.]+.href=\'(?<url>[^\']+)\'">\s*<h2>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
             'price'         => '/(?:Vehicle Price:|Sale Price:)\s*<\/td>\s*<td>\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Odometer:<\/td>\s*<td>(?<kilometres>[^\<]+)/',
            'stock_number'  => '/Stock#<\/td>\s*<td>(?<stock_number>[^\<]+)/',
            'engine'        => '/Engine Size:<\/td>\s*<td>\s*(?<engine>[^\<]+)/',
           'transmission'  => '/Transmission:<\/td>\s*<td>\s*(?<transmission>[^\<]+)/',
            'exterior_color'=> '/Exterior Color:<\/td>\s*<td>\s*(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Color:<\/td>\s*<td>\s*(?<interior_color>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(        
            
        ) ,
       // 'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<div class="photo">\s*<[^>]+>\s*<img href="(?<img_url>[^"]+)"/',
      //  'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
  