<?php

global $CronConfigs;

$CronConfigs["amarillohyundai"] = array(
    'name'             => 'amarillohyundai',
    'email'            => 'regan@smedia.ca',
    'password'         => 'amarillohyundai',
    'log'              => true,
    'lead'             => array(
        'new' => array(
            'live'                   => true,
            'lead_type_'             => true,
            'lead_type_new'          => true,
            'lead_type_used'         => false,
            'lead_type_service'      => false,
            'shown_cap'              => false,
            'fillup_cap'             => false,
            'session_close'          => false,
            'device_type'            => array(
                'mobile'  => true,
                'desktop' => true,
                'tablet'  => true,
            ),
            'sent_client_email'      => true,
            'offer_minimum_price'    => 0,
            'offer_maximum_price'    => 10000000,
            'bg_color'               => '#EFEFEF',
            'text_color'             => '#404450',
            'border_color'           => '#E5E5E5',
            'button_color'           => array(
                '#005DA1',
                '#005DA1',
            ),
            'button_color_hover'     => array(
                '#121212',
                '#121212',
            ),
            'button_color_active'    => array(
                '#121212',
                '#121212',
            ),
            'button_text_color'      => '#FFFFFF',
            'response_email_subject' => '$200 off coupon from Amarillo Hyundai',
            'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Amarillo Hyundai Team',
            'forward_to'             => array(
                'marshal@smedia.ca',
            ),
            'special_to'             => array(
                'leads@tristateford.motosnap.com',
                'tristatefordandhyundai@crm.eautodealerhub.com',
            ),
            'special_email'          => '<?xml version="1.0"?>
                <?adf version="1.0"?>
                <adf>
                  <prospect>
                    <id sequence="[total_count]" source="Amarillo Hyundai"></id>
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
                        <name part="full">Amarillo Hyundai</name>
                        <email>[dealer_email]</email>
                      </contact>
                    </vendor>
                    <provider>
                      <name part="full">sMedia</name>
                      <url>https://smedia.ca</url>
                      <email>offers@mail.smedia.ca</email>
                      <phone>855-775-0062</phone>
                    </provider>
                  </prospect>
                </adf>',
            'display_after'          => 30000,
            'retarget_after'         => 5000,
            'fb_retarget_after'      => 5000,
            'adword_retarget_after'  => 5000,
            'visit_count'            => 0,
            'video_smart_offer'      => false,
            'video_smart_offer_form' => false,
            'video_url'              => '',
            'video_title'            => '',
            'video_description'      => '',
            'lead_in'                => array(
                'vdp'           => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
                'service_regex' => '',
            ),
        ),
    ),
    // 'adf_to'           => array(
    //     'leads@tristateford.motosnap.com',
    // ),
    // 'form_live'        => true,
    // 'buttons_live'     => true,
    // 'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    // 'buttons'          => array(
    //     'request-information' => array(
    //         'url-match'     => '/\\/new\\/[^\\/]+\\/[0-9]{4}-/i',
    //         'target'        => null,
    //         'locations'     => array(
    //             'default' => null,
    //         ),
    //         'action-target' => 'button[href*="/eprice-form.htm"]',
    //         'css-class'     => 'button[href*="/eprice-form.htm"]',
    //         'css-hover'     => 'button[href*="/eprice-form.htm"]:hover',
    //         'button_action' => array(
    //             'form',
    //             'e-price',
    //         ),
    //         'sizes'         => array(
    //             100 => array(),
    //         ),
    //         'texts'         => array(
    //             'request-information' => array(
    //                 'target' => 'button[href*="/eprice-form.htm"]',
    //                 'values' => array(
    //                     'Buy Online Now!',
    //                     'Click Here To Buy Online',
    //                     'Buy Now!',
    //                     'Buy Online',
    //                 ),
    //             ),
    //         ),
    //         'styles'        => array(
    //             'blue'   => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#1F4581,#1F4581)',
    //                     'border-color' => '1F4581',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#193767,#193767)',
    //                     'border-color' => '193767',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'red'    => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C33320,#C33320)',
    //                     'border-color' => 'C33320',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A92C1C,#A92C1C)',
    //                     'border-color' => 'A92C1C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'orange' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C38820,#C38820)',
    //                     'border-color' => 'C38820',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A9761C,#A9761C)',
    //                     'border-color' => 'A9761C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'green'  => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#189138,#189138)',
    //                     'border-color' => '189138',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#14782E,#14782E)',
    //                     'border-color' => '14782E',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'purple' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#BE29EC,#BE29EC)',
    //                     'border-color' => 'BE29EC',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#951DBA,#951DBA)',
    //                     'border-color' => '951DBA',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //         ),
    //     ),
    //     'request-a-quote'     => array(
    //         'url-match'     => '/\\/(?:used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
    //         'target'        => null,
    //         'locations'     => array(
    //             'default' => null,
    //         ),
    //         'action-target' => 'button[href*="/eprice-form.htm"]',
    //         'css-class'     => 'button[href*="/eprice-form.htm"]',
    //         'css-hover'     => 'button[href*="/eprice-form.htm"]:hover',
    //         'button_action' => array(
    //             'form',
    //             'e-price',
    //         ),
    //         'sizes'         => array(
    //             100 => array(),
    //         ),
    //         'texts'         => array(
    //             'request-a-quote' => array(
    //                 'target' => 'button[href*="/eprice-form.htm"]',
    //                 'values' => array(
    //                     'Get ePrice',
    //                     'Get Internet Price',
    //                     'Get Our Best Price',
    //                     'Get Sale Price',
    //                     'Get Special Price',
    //                     'Get Your Price',
    //                 ),
    //             ),
    //         ),
    //         'styles'        => array(
    //             'blue'   => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#1F4581,#1F4581)',
    //                     'border-color' => '1F4581',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#193767,#193767)',
    //                     'border-color' => '193767',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'red'    => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C33320,#C33320)',
    //                     'border-color' => 'C33320',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A92C1C,#A92C1C)',
    //                     'border-color' => 'A92C1C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'orange' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C38820,#C38820)',
    //                     'border-color' => 'C38820',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A9761C,#A9761C)',
    //                     'border-color' => 'A9761C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'green'  => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#189138,#189138)',
    //                     'border-color' => '189138',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#14782E,#14782E)',
    //                     'border-color' => '14782E',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'purple' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#BE29EC,#BE29EC)',
    //                     'border-color' => 'BE29EC',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#951DBA,#951DBA)',
    //                     'border-color' => '951DBA',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //         ),
    //     ),
    //     'financing'           => array(
    //         'url-match'     => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
    //         'target'        => null,
    //         'locations'     => array(
    //             'default' => null,
    //         ),
    //         'action-target' => 'a.btn.btn-primary.btn-block.calculate',
    //         'css-class'     => 'a.btn.btn-primary.btn-block.calculate',
    //         'css-hover'     => 'a.btn.btn-primary.btn-block.calculate:hover',
    //         'button_action' => array(
    //             'form',
    //             'finance',
    //         ),
    //         'sizes'         => array(
    //             100 => array(),
    //         ),
    //         'texts'         => array(
    //             'financing' => array(
    //                 'target' => 'a.btn.btn-primary.btn-block.calculate',
    //                 'values' => array(
    //                     'Special Finance Offers!',
    //                     'Explore Payments',
    //                     'Calculate Your Payments',
    //                     'Estimate Payments',
    //                 ),
    //             ),
    //         ),
    //         'styles'        => array(
    //             'blue'   => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#1F4581,#1F4581)',
    //                     'border-color' => '1F4581',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#193767,#193767)',
    //                     'border-color' => '193767',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'red'    => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C33320,#C33320)',
    //                     'border-color' => 'C33320',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A92C1C,#A92C1C)',
    //                     'border-color' => 'A92C1C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'orange' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C38820,#C38820)',
    //                     'border-color' => 'C38820',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A9761C,#A9761C)',
    //                     'border-color' => 'A9761C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'green'  => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#189138,#189138)',
    //                     'border-color' => '189138',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#14782E,#14782E)',
    //                     'border-color' => '14782E',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'purple' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#BE29EC,#BE29EC)',
    //                     'border-color' => 'BE29EC',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#951DBA,#951DBA)',
    //                     'border-color' => '951DBA',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //         ),
    //     ),
    //     'test-drive'          => array(
    //         'url-match'     => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
    //         'target'        => null,
    //         'locations'     => array(
    //             'default' => null,
    //         ),
    //         'action-target' => 'a.btn.btn-primary.btn-lg.dialog.btn-block',
    //         'css-class'     => 'a.btn.btn-primary.btn-lg.dialog.btn-block',
    //         'css-hover'     => 'a.btn.btn-primary.btn-lg.dialog.btn-block:hover',
    //         'button_action' => array(
    //             'form',
    //             'test-drive',
    //         ),
    //         'sizes'         => array(
    //             100 => array(),
    //         ),
    //         'texts'         => array(
    //             'test-drive' => array(
    //                 'target' => 'a.btn.btn-primary.btn-lg.dialog.btn-block',
    //                 'values' => array(
    //                     'Schedule My Visit',
    //                     'Test Drive',
    //                     'Request A Test Drive',
    //                     'Want to Test Drive It?',
    //                 ),
    //             ),
    //         ),
    //         'styles'        => array(
    //             'blue'   => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#1F4581,#1F4581)',
    //                     'border-color' => '1F4581',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#193767,#193767)',
    //                     'border-color' => '193767',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'red'    => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C33320,#C33320)',
    //                     'border-color' => 'C33320',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A92C1C,#A92C1C)',
    //                     'border-color' => 'A92C1C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'orange' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C38820,#C38820)',
    //                     'border-color' => 'C38820',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A9761C,#A9761C)',
    //                     'border-color' => 'A9761C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'green'  => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#189138,#189138)',
    //                     'border-color' => '189138',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#14782E,#14782E)',
    //                     'border-color' => '14782E',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'purple' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#BE29EC,#BE29EC)',
    //                     'border-color' => 'BE29EC',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#951DBA,#951DBA)',
    //                     'border-color' => '951DBA',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //         ),
    //     ),
    //     'trade-in'            => array(
    //         'url-match'     => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
    //         'target'        => null,
    //         'locations'     => array(
    //             'default' => null,
    //         ),
    //         'action-target' => 'a[href*=trade-in].btn',
    //         'css-class'     => 'a[href*=trade-in].btn',
    //         'css-hover'     => 'a[href*=trade-in].btn:hover',
    //         'button_action' => array(
    //             'form',
    //             'trade-in',
    //         ),
    //         'sizes'         => array(
    //             100 => array(),
    //         ),
    //         'texts'         => array(
    //             'trade-in' => array(
    //                 'target' => 'a[href*=trade-in].btn',
    //                 'values' => array(
    //                     'Get Trade-In Value',
    //                     'Trade Offer',
    //                     'What\'s Your Trade Worth?',
    //                     'Value Your Trade',
    //                     'We Want Your Car',
    //                     'We\'ll Buy Your Car',
    //                 ),
    //             ),
    //         ),
    //         'styles'        => array(
    //             'blue'   => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#1F4581,#1F4581)',
    //                     'border-color' => '1F4581',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#193767,#193767)',
    //                     'border-color' => '193767',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'red'    => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C33320,#C33320)',
    //                     'border-color' => 'C33320',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A92C1C,#A92C1C)',
    //                     'border-color' => 'A92C1C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'orange' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C38820,#C38820)',
    //                     'border-color' => 'C38820',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A9761C,#A9761C)',
    //                     'border-color' => 'A9761C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'green'  => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#189138,#189138)',
    //                     'border-color' => '189138',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#14782E,#14782E)',
    //                     'border-color' => '14782E',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'purple' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#BE29EC,#BE29EC)',
    //                     'border-color' => 'BE29EC',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#951DBA,#951DBA)',
    //                     'border-color' => '951DBA',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //         ),
    //     ),
    //     'Used financing'      => array(
    //         'url-match'     => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
    //         'target'        => null,
    //         'locations'     => array(
    //             'default' => null,
    //         ),
    //         'action-target' => 'a.btn.btn-primary.btn-block.calculate',
    //         'css-class'     => 'a.btn.btn-primary.btn-block.calculate',
    //         'css-hover'     => 'a.btn.btn-primary.btn-block.calculate:hover',
    //         'button_action' => array(
    //             'form',
    //             'finance',
    //         ),
    //         'sizes'         => array(
    //             100 => array(),
    //         ),
    //         'texts'         => array(
    //             'Used financing' => array(
    //                 'target' => 'a.btn.btn-primary.btn-block.calculate',
    //                 'values' => array(
    //                     'Special Finance Offers!',
    //                     'Explore Payments',
    //                     'Calculate Your Payments',
    //                     'Estimate Payments',
    //                 ),
    //             ),
    //         ),
    //         'styles'        => array(
    //             'blue'   => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#1F4581,#1F4581)',
    //                     'border-color' => '1F4581',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#193767,#193767)',
    //                     'border-color' => '193767',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'red'    => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C33320,#C33320)',
    //                     'border-color' => 'C33320',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A92C1C,#A92C1C)',
    //                     'border-color' => 'A92C1C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'orange' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C38820,#C38820)',
    //                     'border-color' => 'C38820',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A9761C,#A9761C)',
    //                     'border-color' => 'A9761C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'green'  => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#189138,#189138)',
    //                     'border-color' => '189138',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#14782E,#14782E)',
    //                     'border-color' => '14782E',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'purple' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#BE29EC,#BE29EC)',
    //                     'border-color' => 'BE29EC',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#951DBA,#951DBA)',
    //                     'border-color' => '951DBA',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //         ),
    //     ),
    //     'Used test-drive'     => array(
    //         'url-match'     => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
    //         'target'        => null,
    //         'locations'     => array(
    //             'default' => null,
    //         ),
    //         'action-target' => 'a.btn.btn-primary.btn-lg.dialog.btn-block',
    //         'css-class'     => 'a.btn.btn-primary.btn-lg.dialog.btn-block',
    //         'css-hover'     => 'a.btn.btn-primary.btn-lg.dialog.btn-block:hover',
    //         'button_action' => array(
    //             'form',
    //             'test-drive',
    //         ),
    //         'sizes'         => array(
    //             100 => array(),
    //         ),
    //         'texts'         => array(
    //             'Used test-drive' => array(
    //                 'target' => 'a.btn.btn-primary.btn-lg.dialog.btn-block',
    //                 'values' => array(
    //                     'Schedule My Visit',
    //                     'Test Drive',
    //                     'Request A Test Drive',
    //                     'Want to Test Drive It?',
    //                 ),
    //             ),
    //         ),
    //         'styles'        => array(
    //             'blue'   => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#1F4581,#1F4581)',
    //                     'border-color' => '1F4581',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#193767,#193767)',
    //                     'border-color' => '193767',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'red'    => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C33320,#C33320)',
    //                     'border-color' => 'C33320',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A92C1C,#A92C1C)',
    //                     'border-color' => 'A92C1C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'orange' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C38820,#C38820)',
    //                     'border-color' => 'C38820',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A9761C,#A9761C)',
    //                     'border-color' => 'A9761C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'green'  => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#189138,#189138)',
    //                     'border-color' => '189138',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#14782E,#14782E)',
    //                     'border-color' => '14782E',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'purple' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#BE29EC,#BE29EC)',
    //                     'border-color' => 'BE29EC',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#951DBA,#951DBA)',
    //                     'border-color' => '951DBA',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //         ),
    //     ),
    //     'Used trade-in'       => array(
    //         'url-match'     => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
    //         'target'        => null,
    //         'locations'     => array(
    //             'default' => null,
    //         ),
    //         'action-target' => 'a[href*=trade-in].btn',
    //         'css-class'     => 'a[href*=trade-in].btn',
    //         'css-hover'     => 'a[href*=trade-in].btn:hover',
    //         'button_action' => array(
    //             'form',
    //             'trade-in',
    //         ),
    //         'sizes'         => array(
    //             100 => array(),
    //         ),
    //         'texts'         => array(
    //             'Used trade-in' => array(
    //                 'target' => 'a[href*=trade-in].btn',
    //                 'values' => array(
    //                     'Get Trade-In Value',
    //                     'Trade Offer',
    //                     'What\'s Your Trade Worth?',
    //                     'Value Your Trade',
    //                     'We Want Your Car',
    //                     'We\'ll Buy Your Car',
    //                 ),
    //             ),
    //         ),
    //         'styles'        => array(
    //             'blue'   => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#1F4581,#1F4581)',
    //                     'border-color' => '1F4581',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#193767,#193767)',
    //                     'border-color' => '193767',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'red'    => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C33320,#C33320)',
    //                     'border-color' => 'C33320',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A92C1C,#A92C1C)',
    //                     'border-color' => 'A92C1C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'orange' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#C38820,#C38820)',
    //                     'border-color' => 'C38820',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#A9761C,#A9761C)',
    //                     'border-color' => 'A9761C',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'green'  => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#189138,#189138)',
    //                     'border-color' => '189138',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#14782E,#14782E)',
    //                     'border-color' => '14782E',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //             'purple' => array(
    //                 'normal' => array(
    //                     'background'   => 'linear-gradient(#BE29EC,#BE29EC)',
    //                     'border-color' => 'BE29EC',
    //                     'color'        => '#fff',
    //                 ),
    //                 'hover'  => array(
    //                     'background'   => 'linear-gradient(#951DBA,#951DBA)',
    //                     'border-color' => '951DBA',
    //                     'color'        => '#fff',
    //                 ),
    //             ),
    //         ),
    //     ),
    // ),
);
