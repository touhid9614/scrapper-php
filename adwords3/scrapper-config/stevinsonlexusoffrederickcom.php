<?php
global $scrapper_configs;
$scrapper_configs["stevinsonlexusoffrederickcom"] = array( 
	'entry_points' => array(
	//	'new' => '',
		//'used' => '',
	),
	
	
    'vdp_url_regex' => '/\/(?:new|used)\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.cld-vehicle-img-wrapper img'],
    'picture_nexts' => ['.dep_image_slider_alt_next_btn'],
    'picture_prevs' => ['.dep_image_slider_alt_prev_btn'],


);