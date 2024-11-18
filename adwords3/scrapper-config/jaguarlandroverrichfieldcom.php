<?php
global $scrapper_configs;
 $scrapper_configs["jaguarlandroverrichfieldcom"] = array( 
	'entry_points' => array(
        'all'  => 'https://www.jaguarlandroverrichfield.com/',  
    ),
    'vdp_url_regex' => '/jaguarlandroverrichfield.com/i',
    'use-proxy' => true,
    'picture_selectors' => ['.primary-button'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],
   );
    