<?php
global $scrapper_configs;
$scrapper_configs["avenuenissancom"] = array(
    "entry_points"      => array(
        'used' => 'https://www.avenuenissan.com/Used-Inventory',
        'new'  => 'https://www.avenuenissan.com/New-Inventory',
    ),

    'vdp_url_regex' => '/\/(?:New|Used|Certified)-Inventory\/[0-9]{4}-/i',
    'picture_selectors' => ['.slideshowThumbnails'],
    'picture_nexts' => ['.navButton.navRight'],
    'picture_prevs' => ['.navButton.navLeft'],
    'no_scrap'     => true,
    'use-proxy'    => true,
);
