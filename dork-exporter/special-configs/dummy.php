<?php

global $special_configs;

$special_configs[] = array(
    'type'          => 'testtype',      #would define the type of page it is (Required)
    'url_identity'  => '/test.com/',    #the regex to determine if it is capable to scrap a page
    'pre_process'   => array(
        'start_tag'     => '',          #an unique starting tag that can be used to reject all data starting before this tag
        'end_tag'       => '',          #an unique ending tag that can be used to reject all data that appears after this tag
        'split_tag'     => ''           #if provided, this tag will be used to split data prior processing
    ),
    'sections'      => array(
        'movies'        => array(
            'pre_process'   => array(
                'start_tag'     => '',      #an unique starting tag that can be used to reject all data starting before this tag
                'end_tag'       => '',      #an unique ending tag that can be used to reject all data that appears after this tag
                'split_tag'     => ''       #if provided, this tag will be used to split data prior processing
            ),
            'fields'        => array(           #regex is applied on pre processed data

            ),
            'fields_all'    => array(           #regexs is applied with preg_match_all

            ),
            'fields_cal'    => array(           #computed fields based on command and previous section fields

            )
        )
    ),
    'fields'       => array(            #regex is applied on raw data
        
    ),
    'fields_all'   => array(            #regex is applied on raw data with preg_match_all
        
    ),
    'fields_cal'   => array(            #computed fields based on command and previous page fields
        'field1'        => array(
            'func'  => 'scrap',
            'args'  => array(
                '_url'
            )
        )
    )
);

?>
