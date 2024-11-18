<?php

    global $scrapper_configs;

    $scrapper_configs['murraywin'] = array(        
	'entry_points' => array(            
		'new'   => 'http://www.murraychevrolet.ca/new-inventory/index.htm',            
		'used'  => 'http://www.murraychevrolet.ca/used-inventory/index.htm'        
		),  
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
	'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.previous'],
        
	'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',        
	'details_end_tag'   => '<div class="ft">',        
	'details_spliter'   => '<div class="item-compare">',        
	'data_capture_regx' => array(            
		'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',            
		'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',            
		'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',            
		'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',            
		'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',            
		'price'         => '/final-price.*class=\'value[^>]+>(?<price>[^<]+)/',            
		'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',           
		'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',            
		'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',            
		'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',            
		'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',            
		'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',            
		'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
                'certified'     => '/class="url" *href="(?<url>(?:\/(?<certified>certified)\/)?[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
	),        
	'data_capture_regx_full' => array(
	    'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
	    'trim' => '@Trim:\s*</strong>\s*<span class="value">(?<trim>[^<]+)@'
	),
        'options_start_tag' => '<dt>Options</dt>',        
        'options_end_tag'   => '</dd>',        
        'options_regx'      => '/<li><span>(?<option>[^<]+)/',        
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/',
        'auto_texts_regx'   => '/<a href="#" class="dialog xsmall" data-href="[^>]+>\s*(?<auto_text>[^<]+)<\/a>/'
    );
