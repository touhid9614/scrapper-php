<?php

global $special_configs;

$special_configs[] = array(
    'type'          => 'dealerlist',
    'url_identity'  => '/autotrader.ca\/cars\//',
    'sections'      => array(
        'dealerships'   => array(
            'pre_process'   => array(
                'start_tag'     => '<div class="listingHeading ">',
                'end_tag'       => 'itemprop="offers"',
                'split_tag'     => '<div class="srpPager">'
            ),
            'fields'        => array(
                'company_name'      => '/<div class="dfCompanyName">(?<company_name>[^<]+)/',
                'address_line1'     => '/<div class="dfCompanyAddress">(?<address_line1>[^<]+)<br[^>]+>\s*(?<city>[^\(<]+)(?:\((?<state>[^\)]+)\))?<br[^>]+>\s*(?<zip>[^<]+)(?:<br[^>]+>\s*Phone: (?<phone>.+))?/',
                'city'              => '/<div class="dfCompanyAddress">(?<address_line1>[^<]+)<br[^>]+>\s*(?<city>[^\(<]+)(?:\((?<state>[^\)]+)\))?<br[^>]+>\s*(?<zip>[^<]+)(?:<br[^>]+>\s*Phone: (?<phone>.+))?/',
                'state'             => '/<div class="dfCompanyAddress">(?<address_line1>[^<]+)<br[^>]+>\s*(?<city>[^\(<]+)(?:\((?<state>[^\)]+)\))?<br[^>]+>\s*(?<zip>[^<]+)(?:<br[^>]+>\s*Phone: (?<phone>.+))?/',
                'zip'               => '/<div class="dfCompanyAddress">(?<address_line1>[^<]+)<br[^>]+>\s*(?<city>[^\(<]+)(?:\((?<state>[^\)]+)\))?<br[^>]+>\s*(?<zip>[^<]+)(?:<br[^>]+>\s*Phone: (?<phone>.+))?/',
                'phone'             => '/<div class="dfCompanyAddress">(?<address_line1>[^<]+)<br[^>]+>\s*(?<city>[^\(<]+)(?:\((?<state>[^\)]+)\))?<br[^>]+>\s*(?<zip>[^<]+)(?:<br[^>]+>\s*Phone: (?<phone>.+))?/',
                'dealer_website'    => '/href="(?<dealer_website>[^"]+)" target="_blank">Visit Dealer Website/',
                'dealer_inventory'  => '/href="(?<dealer_inventory>[^"]+)">View Dealer Inventory</'
            ),
            'fields_cal'    => array(
                /*'dealer_website' => array(
                    'func'  => 'get_redirected_host',
                    'args'  => array(
                        'dealer_website'
                    )
                ),*/
                'dealer_inventory'  => [
                    'func'  => 'strictURLCombine',
                    'args'  => [
                        '_url',
                        'dealer_inventory'
                    ]
                ],
                'inventory_count'   => [
                    'func'  => 'get_dealer_inventory_count',
                    'args'  => [
                        'dealer_inventory'
                    ]
                ]
            )
        )
    ),
    'fields'    => array(
        'next_page_url' => '/href="(?<next_page_url>[^"]+)">Next</'
    ),
    'fields_cal'    => array(
        'next_page_url' => array(
            'func'  => 'urlCombine',
            'args'  => array(
                '_url',
                'next_page_url'
            )
        )
    )
);

