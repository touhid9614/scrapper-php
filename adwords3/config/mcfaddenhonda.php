<?php

global $CronConfigs;
$CronConfigs["mcfaddenhonda"] = array(
    'password' => 'mcfaddenhonda',
    "email" => "regan@smedia.ca",
    'log' => true,
    'max_cost' => 125,
    'cost_distribution' => array(
        'new' => 62.5,
        'used' => 62.5,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    'customer_id' => '223-400-9942',
    "banner" => array(
        "template" => "mcfaddenhonda",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description_new" => "Check out this [year] [make] [model] today! Click for more information",
        "fb_lookalike_description_used" => 'Honda Canada\'s Certified Used Vehicles are the best-used cars to buy, due to these key features: 
		 7-year/160,000 km Transferable Powertrain Warranty Coverage
		 100 Point Mechanical and Appearance Inspection
		 7 day/1,000 km Exchange Privilege
		 CarProof Vehicle History Report
		 Available Service History Report
		 Upgrade to a Honda Plus Comprehensive Warranty at a Reduced Price
		 Exclusive Membership to MyHonda.ca
		 plus
		 For every Certified Used Honda sold, your will be eligible to Spin and Win for a service credit that can be used towards your first service appointment at McFadden Honda.‌',
        "fb_lookalike_description_certified" => 'Honda Canada\'s Certified Used Vehicles are the best-used cars to buy, due to these key features: 
		 7-year/160,000 km Transferable Powertrain Warranty Coverage
		 100 Point Mechanical and Appearance Inspection
		 7 day/1,000 km Exchange Privilege
		 CarProof Vehicle History Report
		 Available Service History Report
		 Upgrade to a Honda Plus Comprehensive Warranty at a Reduced Price
		 Exclusive Membership to MyHonda.ca
		 plus
		 For every Certified Used Honda sold, your will be eligible to Spin and Win for a service credit that can be used towards your first service appointment at McFadden Honda.‌',
        /* "fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.", */
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    /*    "lead" => array(
                'live' => false,
                'lead_type_' => false,
                'lead_type_new' => false,
                'lead_type_used' => false,
                'shown_cap' => false,
                'fillup_cap' => false,
                'session_close' => false,
                'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
                ),
                'offer_minimum_price' => 0,
                'offer_maximum_price' => 10000000,
                'bg_color' => '#EFEFEF',
                'text_color' => '#404450',
                'border_color' => '#E5E5E5',
                'button_color' => array(
                '#EC1614',
                '#EC1614',
                ),
                'button_color_hover' => array(
                '#000000',
                '#000000',
                ),
                'button_color_active' => array(
                '#000000',
                '#000000',
                ),
                'button_text_color' => '#FFFFFF',
                'response_email_subject' => '$200 off coupon from McFadden Honda',
                'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>McFadden Honda Team',
                'forward_to' => array(
                'marshal@smedia.ca',
                ),
                'special_to' => array(
                '1213mfadsalesleads11@dealermineinc.com',
                'mcfaddenhonda1@pbssystems.com',
                ),
                'special_email' => '<?xml version="1.0"?>
                <?adf version="1.0"?>
                <adf>
                <prospect>
                <id sequence="[total_count]" source="sMedia Coupon"></id>
                <requestdate>[fdt]</requestdate>
                <vehicle interest="buy" status="[stock_type]">
                <year>[year]</year>
                <make>[make]</make>
                <model>[model]</model>
                <stock>[stock_number]</stock>
                </vehicle>
          
                <customer>
                <contact>
                <name part="full">[name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
                </contact>
                </customer>
          
                <vendor>
                <contact>
                <name part="full">McFadden Honda</name>
                <email>[dealer_email]</email>
                </contact>
                </vendor>
                <provider>
                <name part="full">sMedia</name>
                <url>http://smedia.ca</url>
                <email>offers@mail.smedia.ca</email>
                <phone>855-775-0062</phone>
                </provider>
                </prospect>
                </adf>',
                'display_after' => 30000,
                'retarget_after' => 5000,
                'fb_retarget_after' => 5000,
                'adword_retarget_after' => 5000,
                'visit_count' => 0,
                ), */
    'adf_to' => array(
        'sales@mcfaddenhonda.ca',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        //new finance//
        'Used financing' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.btn-orange-vehicles1.icon-coin-dollar.apply-for-financing',
            'css-class' => '.btn-orange-vehicles1.icon-coin-dollar.apply-for-financing',
            'css-hover' => '.btn-orange-vehicles1.icon-coin-dollar.apply-for-financing:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '.btn-orange-vehicles1.icon-coin-dollar.apply-for-financing',
                    'values' => array(
                        'Get Financed Today',
                        'Financing Available',
                        'Apply for Financing',
                        'No Hassle Financing',
                        'Special Finance Offers',
),
],
],
            'styles' => array(
                'orange ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'span a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-coin-dollar',
            'css-class' => 'span a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-coin-dollar',
            'css-hover' => 'span a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-coin-dollar:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'span a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-coin-dollar',
                    'values' => array(
                        'Get Financed Today',
                        'Financing Available',
                        'Apply for Financing',
                        'No Hassle Financing',
                        'Special Finance Offers',
),
],
],
            'styles' => array(
                'orange ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => '#c47c18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => '#a96b14',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => ' #184d7f',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '#31a413',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '#288a0f',
),
),
),
],
        //        ///USED  Instant Trade Value///
        //        'trade-in' => [
        //            'url-match' => '/\\/new\\/vehicle\\/[0-9]{4}-/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'a[onclick*=trade-in].btn-incentives-new.btn-lg.btn-incentives-big.icon-coin-dollar',
        //            'css-class' => 'a[onclick*=trade-in].btn-incentives-new.btn-lg.btn-incentives-big.icon-coin-dollar',
        //            'css-hover' => 'a[onclick*=trade-in].btn-incentives-new.btn-lg.btn-incentives-big.icon-coin-dollar:hover',
        //            'button_action' => [
        //                'form',
        //                'trade-in',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'trade-in' => [
        //                    'target' => 'a[onclick*=trade-in].btn-incentives-new.btn-lg.btn-incentives-big.icon-coin-dollar',
        //                    'values' => array(
        //                        'Get Trade-In Value',
        //                        'Trade Offer',
        //                        'What\'s Your Trade Worth?',
        //                        'Trade-In Appraisal',
        //                        'Appraise Your Trade',
        //                        'Value Your Trade',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange ' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#C47C18,#C47C18)',
        //                        'border-color' => ' #C47C18',
        //                        'font-family' => 'Raleway, arial, sans-serif',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#A96B14,#A96B14)',
        //                        'border-color' => ' #A96B14',
        //                        'font-family' => 'Raleway, arial, sans-serif',
        //                    ),
        //                ),
        ////                'blue' => array(
        ////                    'normal' => array(
        ////                        'background' => 'linear-gradient(#184D7F,#184D7F)',
        ////                        'border-color' => ' #184d7f',
        ////                        'font-family' => 'roboto',
        ////                    ),
        ////                    'hover' => array(
        ////                        'background' => 'linear-gradient(#123E65,#123E65)',
        ////                        'border-color' => '#123e65',
        ////                        'font-family' => 'roboto',
        ////                    ),
        ////                ),
        ////                'red' => array(
        ////                    'normal' => array(
        ////                        'background' => 'linear-gradient(#C21116,#C21116)',
        ////                        'border-color' => '#c21116',
        ////                        'font-family' => 'roboto',
        ////                    ),
        ////                    'hover' => array(
        ////                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
        ////                        'border-color' => '#9d0a0e',
        ////                        'font-family' => 'roboto',
        ////                    ),
        ////                ),
        ////                'green' => array(
        ////                    'normal' => array(
        ////                        'background' => 'linear-gradient(#31A413,#31A413)',
        ////                        'border-color' => '#31a413',
        ////                        'font-family' => 'roboto',
        ////                    ),
        ////                    'hover' => array(
        ////                        'background' => 'linear-gradient(#288A0F,#288A0F)',
        ////                        'border-color' => '#288a0f',
        ////                        'font-family' => 'roboto',
        ////                    ),
        ////                ),
        //            ),
        //        ],
        //        'Used trade-in' => [
        //            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1',
        //            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1',
        //            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1:hover',
        //            'button_action' => [
        //                'form',
        //                'trade-in',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'trade-in' => [
        //                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1',
        //                    'values' => array(
        //                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;font-size: 9px;width: 60px;vertical-align: baseline;">Get Trade-In Value</span>',
        //                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;font-size: 9px;width: 60px;vertical-align: baseline;">Trade Offer</span>',
        //                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;font-size: 9px;width: 60px;vertical-align: baseline;">What\'s Your Trade Worth?</span>',
        //                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;font-size: 9px;width: 60px;vertical-align: baseline;">Trade-In Appraisal</span>',
        //                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;font-size: 9px;width: 60px;vertical-align: baseline;">Appraise Your Trade</span>',
        //                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;font-size: 9px;width: 60px;vertical-align: baseline;">Value Your Trade</span>',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange ' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#C47C18,#C47C18)',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#A96B14,#A96B14)',
        //                    ),
        //                ),
        //                'blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#184D7F,#184D7F)',
        //                        'border-color' => ' #184d7f',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#123E65,#123E65)',
        //                        'border-color' => '#123e65',
        //                    ),
        //                ),
        //                'red' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#C21116,#C21116)',
        //                        'border-color' => '#c21116',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
        //                        'border-color' => '#9d0a0e',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#31A413,#31A413)',
        //                        'border-color' => '#31a413',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#288A0F,#288A0F)',
        //                        'border-color' => '#288a0f',
        //                    ),
        //                ),
        //            ),
        //        ],
        //        'test-drive' => [
        //            'url-match' => '/\\/new\\/vehicle\\/[0-9]{4}-/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'a[onclick*=BookATestDrive].btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel',
        //            'css-class' => 'a[onclick*=BookATestDrive].btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel',
        //            'css-hover' => 'a[onclick*=BookATestDrive].btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel:hover',
        //            'button_action' => [
        //                'form',
        //                'test-drive',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'Used test-drive' => [
        //                    'target' => 'a[onclick*=BookATestDrive].btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel',
        //                    'values' => array(
        //                        'Request a Test Drive',
        //                        'Schedule a Test Drive',
        //                        'Book Test Drive',
        //                        'Want to Test Drive?',
        //                        'Test Drive Today',
        //                        'Test Drive Now',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange ' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#C47C18,#C47C18)',
        //                        'font-family' => 'roboto',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#A96B14,#A96B14)',
        //                        'font-family' => 'roboto',
        //                    ),
        //                ),
        //                'blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#184D7F,#184D7F)',
        //                        'border-color' => ' #184d7f',
        //                        'font-family' => 'roboto',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#123E65,#123E65)',
        //                        'border-color' => '#123e65',
        //                        'font-family' => 'roboto',
        //                    ),
        //                ),
        //                'red' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#C21116,#C21116)',
        //                        'border-color' => '#c21116',
        //                        'font-family' => 'roboto',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
        //                        'border-color' => '#9d0a0e',
        //                        'font-family' => 'roboto',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#31A413,#31A413)',
        //                        'border-color' => '#31a413',
        //                        'font-family' => 'roboto',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#288A0F,#288A0F)',
        //                        'border-color' => '#288a0f',
        //                        'font-family' => 'roboto',
        //                    ),
        //                ),
        //            ),
        //        ],
        'Used test-drive' => [
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'Used test-drive' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
                        'font-size' => '14px',
                        'font-weight' => '400',
                        'text-align' => 'left !important',
                        'line-height' => '17px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
                        'font-size' => '14px',
                        'font-weight' => '400',
                        'text-align' => 'left !important',
                        'line-height' => '17px',
),
),
                'orange ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
                        'font-size' => '14px',
                        'font-weight' => '400',
                        'text-align' => 'left !important',
                        'line-height' => '17px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
                        'font-size' => '14px',
                        'font-weight' => '400',
                        'text-align' => 'left !important',
                        'line-height' => '17px',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
                        'font-size' => '14px',
                        'font-weight' => '400',
                        'text-align' => 'left !important',
                        'line-height' => '17px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
                        'font-size' => '14px',
                        'font-weight' => '400',
                        'text-align' => 'left !important',
                        'line-height' => '17px',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
                        'font-size' => '14px',
                        'font-weight' => '400',
                        'text-align' => 'left !important',
                        'line-height' => '17px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
                        'font-size' => '14px',
                        'font-weight' => '400',
                        'text-align' => 'left !important',
                        'line-height' => '17px',
),
),
),
],
],
);