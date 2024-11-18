<?php

global $CronConfigs;
$CronConfigs["enstoyota"] = array(
    'password'     => 'enstoyota',
    'email'        => 'regan@smedia.ca',
    'log'          => true,
    'banner'       => array(
        'template'                   => 'enstoyota',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.',
        'fb_aia_description'         => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
    ),
    'lead'         => array(
        'used' => array(
            'live'                   => true,
            'lead_type_'             => true,
            'lead_type_new'          => false,
            'lead_type_used'         => true,
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
                '#AE1E25',
                '#AE1E25',
            ),
            'button_color_hover'     => array(
                '#6D1317',
                '#6D1317',
            ),
            'button_color_active'    => array(
                '#6D1317',
                '#6D1317',
            ),
            'button_text_color'      => '#FFFFFF',
            'response_email_subject' => 'Get $200 off voucher from ENS Toyota',
            'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Ens Toyota Team',
            'forward_to'             => array(
                'marshal@smedia.ca',
            ),
            'special_to'             => array(
                'adf_to@smedia.ca',
            ),
            'special_email'          => '',
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
                'vdp'           => '/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
                'service_regex' => '',
            ),
        ),
        'new'  => array(
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
                '#AE1E25',
                '#AE1E25',
            ),
            'button_color_hover'     => array(
                '#6D1317',
                '#6D1317',
            ),
            'button_color_active'    => array(
                '#6D1317',
                '#6D1317',
            ),
            'button_text_color'      => '#FFFFFF',
            'response_email_subject' => 'Red Tag Days Sales Event at Ens Toyota',
            'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Ens Toyota Team',
            'forward_to'             => array(
                'marshal@smedia.ca',
            ),
            'special_to'             => array(
                'smedia@enstoyota.net',
                'adf_to@smedia.ca',
            ),
            'special_email'          => '<?xml version="1.0"?>
            <?adf version="1.0"?>
            <adf>
                <prospect>
                    <id sequence="[total_count]" source="Ens Toyota"></id>
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
                            <name part="full">Ens Toyota</name>
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
                'vdp'           => '/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
                'service_regex' => '',
            ),
        ),
    ),
    'adf_to'       => array(
        'smedia@enstoyota.net',
    ),
    'buttons_live' => true,
    'form_live'    => true,
    'buttons'      => array(
        'request-a-quote' => array(
            'url-match'     => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'div.vdp-price-box__main-cta-wrapper a',
            'css-class'     => 'div.vdp-price-box__main-cta-wrapper a',
            'css-hover'     => 'div.vdp-price-box__main-cta-wrapper a:hover',
            'button_action' => array(
                'form',
                'e-price',
            ),
            'sizes'         => array(
                100 => array(),
            ),
            'texts'         => array(
                'request-a-quote' => array(
                    'target' => 'div.vdp-price-box__main-cta-wrapper a',
                    'values' => array(
                        'Get Special Pricing',
                        'Special Price',
                        'Get e-price!',
                        'Get Price Updates',
                        'Get Current Market Price',
                        'Get More Details',
                        'Get Internet Price Now',
                        'Get A Quote',
                        'Inquire Now!',
                        'Confirm Availability',
                    ),
                ),
            ),
            'styles'        => array(
                'red'       => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#ED1C24,#ED1C24)',
                        'border-color' => 'ED1C24',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#425368,#425368)',
                        'border-color' => '425368',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
                    ),
                ),
                'black'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
                    ),
                ),
            ),
        ),
    ),
    'name'         => 'enstoyota',
);
