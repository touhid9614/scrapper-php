<?php

global $scrapper_configs;
$scrapper_configs["nissandowntownca"] = array(
    'entry_points' => array(
        'new' => 'https://www.nissandowntown.ca/New-Inventory',
        'used' => 'https://www.nissandowntown.ca/Used-Inventory',
    ),
    'vdp_url_regex' => '/\/(?:New|Used|Certified)-Inventory\/[0-9]{4}-/i',
    'picture_selectors' => ['.slideshowThumbnails'],
    'picture_nexts' => ['.navButton.navRight'],
    'picture_prevs' => ['.navButton.navLeft'],
    'no_scrap'     => true,
    'use-proxy'    => true,
);
