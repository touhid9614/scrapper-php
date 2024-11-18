<?php
    global $scrapper_configs;

    $scrapper_configs['granitetransformations'] = array(
        'entry_points'      => array(),
        'url_resolve'       => array(
            'granitetransformations'            => '/granitetransformations.com\//i',
            'granitetransformations_regina'     => '/granitetransformations.com\/regina\//i',
            'granitetransformations_calgary'    => '/granitetransformations.com\/calgary\//i',
            'granitetransformations_kelowna'    => '/granitetransformations.com\/kelowna\//i',
            'granitetransformations_alberta'    => '/granitetransformations.com\/alberta\//i',
        ),
        'vdp_url_regex'     => '/granitetransformations.com\//i',
        'ty_url_regex'      => '/\/consultation-header\/thank-you\//i',
        'inpage_cont_match' => 'Thanks for contacting us',
        'no_scrap'          => true
    );
    
    $scrapper_configs['granitetransformations_regina']  = array(
        'entry_points'      => array(),
        'url_resolve'       => array(
            'granitetransformations'            => '/granitetransformations.com\//i',
            'granitetransformations_regina'     => '/granitetransformations.com\/regina\//i',
            'granitetransformations_calgary'    => '/granitetransformations.com\/calgary\//i',
            'granitetransformations_kelowna'    => '/granitetransformations.com\/kelowna\//i',
            'granitetransformations_alberta'    => '/granitetransformations.com\/alberta\//i',
        ),
        'vdp_url_regex'     => '/granitetransformations.com\//i',
        'ty_url_regex'      => '/\/consultation-header\/regina\/thank-you\//i',
        'inpage_cont_match' => 'Thanks for contacting us',
        'no_scrap'          => true
    );
    
    $scrapper_configs['granitetransformations_calgary']  = array(
        'entry_points'      => array(),
        'url_resolve'       => array(
            'granitetransformations'            => '/granitetransformations.com\//i',
            'granitetransformations_regina'     => '/granitetransformations.com\/regina\//i',
            'granitetransformations_calgary'    => '/granitetransformations.com\/calgary\//i',
            'granitetransformations_kelowna'    => '/granitetransformations.com\/kelowna\//i',
            'granitetransformations_alberta'    => '/granitetransformations.com\/alberta\//i',
        ),
        'vdp_url_regex'     => '/granitetransformations.com\//i',
        'ty_url_regex'      => '/\/consultation-header\/calgary\/thank-you\//i',
        'inpage_cont_match' => 'Thanks for contacting us',
        'no_scrap'          => true
    );
    
    $scrapper_configs['granitetransformations_kelowna']  = array(
        'entry_points'      => array(),
        'url_resolve'       => array(
            'granitetransformations'            => '/granitetransformations.com\//i',
            'granitetransformations_regina'     => '/granitetransformations.com\/regina\//i',
            'granitetransformations_calgary'    => '/granitetransformations.com\/calgary\//i',
            'granitetransformations_kelowna'    => '/granitetransformations.com\/kelowna\//i',
            'granitetransformations_alberta'    => '/granitetransformations.com\/alberta\//i',
        ),
        'vdp_url_regex'     => '/granitetransformations.com\//i',
        'ty_url_regex'      => '/\/consultation-header\/kelowna\/thank-you\//i',
        'inpage_cont_match' => 'Thanks for contacting us',
        'no_scrap'          => true
    );
    
    $scrapper_configs['granitetransformations_alberta']  = array(
        'entry_points'      => array(),
        'url_resolve'       => array(
            'granitetransformations'            => '/granitetransformations.com\//i',
            'granitetransformations_regina'     => '/granitetransformations.com\/regina\//i',
            'granitetransformations_calgary'    => '/granitetransformations.com\/calgary\//i',
            'granitetransformations_kelowna'    => '/granitetransformations.com\/kelowna\//i',
            'granitetransformations_alberta'    => '/granitetransformations.com\/alberta\//i',
        ),
        'vdp_url_regex'     => '/granitetransformations.com\//i',
        'ty_url_regex'      => '/\/consultation-header\/alberta\/thank-you\//i',
        'inpage_cont_match' => 'Thanks for contacting us',
        'no_scrap'          => true
    );