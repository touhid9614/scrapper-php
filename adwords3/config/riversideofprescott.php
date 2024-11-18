<?php

global $CronConfigs;
$CronConfigs["riversideofprescott"] = array(
    'password' => 'riversideofprescott',
    "email" => "regan@smedia.ca",
    'log' => true,
    // "fb_new_title" => "[year] [make] [model] - [body_style] [biweekly] Bi-weekly",
    // "fb_new_2019_title" => "[year] [make] [model] - [price]",
    'max_cost' => 700,
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        //https://app.asana.com/0/687248649257779/1200570003527790
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
        // don't enable v1 campaign - Arif
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
    'customer_id' => '100-285-7366',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "riversideofprescott",
        // "fb_description_new" => 'Finance this [year] [make] [model] from [biweekly] b/w for [finance_term] months at [finance_rate]% APR. Shop now!',
        'fb_retargeting_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today! Click for more information.',
        'fb_dynamiclead_description' => 'Still interested in the [year] [make] [model] [trim]? Click below and fill in your information. A product specialist will be in touch to answer any questions.',
        "flash_style" => "default",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        "border_color" => "#282828",
        "font_color" => "#f7f7f7",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#f26522",
            "#f26522",
),
        'button_color_hover' => array(
            "#f26522",
            "#f26522",
),
        'button_color_active' => array(
            "#333333",
            "#333333",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$200 OFF coupon from Riverside of Prescott",
        'response_email' => "Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Riverside of Prescott Team",
        'forward_to' => array(
            "jenn.hughes@riversidegm.ca",
            "marshal@smedia.ca",
            "emil@smedia.ca",
),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
),
    'lead_to' => array(
        'riversidemail@ripnet.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        //        'request-a-quote' => [
        //            'url-match' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
        //            'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
        //            'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
        //            'button_action' => [
        //                'form',
        //                'e-price',
        //            ],
        //            'sizes' => [
        //                '100' => [
        //                    'font-size' => '1.4rem',
        //                ],
        //            ],
        //            'texts' => [
        //                'request-a-quote' => [
        //                    'target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
        //                    'values' => array(
        //                        'Get Internet Price',
        //                        'Get Your Price Today',
        //                        'Get Our Best Price',
        //                        'Riverside Auto\'s Price',
        //                        'Get Special Price Today',
        //                        'Check Availability',
        //                        'SPECIAL PRICING!',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#F26522,#F26522)',
        //                        'border-color' => '#f06b20',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#CF540E,#CF540E)',
        //                        'border-color' => '#cf540e',
        //                    ),
        //                ),
        //                'red' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#B60833,#B60833)',
        //                        'border-color' => '#e01212',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
        //                        'border-color' => '#c60c0d',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#4AAF08,#4AAF08)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#359D22,#359D22)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //                'blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#20609D,#20609D)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#188BB7,#188BB7)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //                'Platinum' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#B9B099,#B9B099)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#ABA085,#ABA085)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //                'Black' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#333333,#333333)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#000000,#000000)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //                'Cyan' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#0093CF,#0093CF)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //            ),
        //        ],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.btns-price-incentives-new span:nth-of-type(5) a',
            'css-class' => '.btns-price-incentives-new span:nth-of-type(5) a',
            'css-hover' => '.btns-price-incentives-new span:nth-of-type(5) a:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '.btns-price-incentives-new span:nth-of-type(5) a',
                    'values' => array(
                        'Schedule My Test Drive',
                        'Schedule My Visit',
                        'Want to Test Drive?',
                        'Book My Test Drive',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F26522,#F26522)',
                        'border-color' => '#F06B20',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#CF540E',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B60833,#B60833)',
                        'border-color' => '#E01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#C60C0D',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4AAF08,#4AAF08)',
                        'border-color' => '#54B740',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359D22',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#20609D,#20609D)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
),
],
        'Used test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button',
                    'values' => array(
                        'Schedule My Test Drive',
                        'Schedule My Visit',
                        'Want to Test Drive?',
                        'Book My Test Drive',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F26522,#F26522)',
                        'border-color' => '#F06B20',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#CF540E',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B60833,#B60833)',
                        'border-color' => '#E01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#C60C0D',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4AAF08,#4AAF08)',
                        'border-color' => '#54B740',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359D22',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#20609D,#20609D)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'p.btns-price-incentives-new span:nth-of-type(3) a',
            'css-class' => 'p.btns-price-incentives-new span:nth-of-type(3) a',
            'css-hover' => 'p.btns-price-incentives-new span:nth-of-type(3) a:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'p.btns-price-incentives-new span:nth-of-type(3) a',
                    'values' => array(
                        'Trade Appraisal',
                        'We Want Your Car',
                        'WHAT\'S YOUR TRADE WORTH?',
                        'Trade Appraisal',
                        'What is Your Trade Worth?',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F26522,#F26522)',
                        'border-color' => '#F06B20',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#CF540E',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B60833,#B60833)',
                        'border-color' => '#E01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#C60C0D',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4AAF08,#4AAF08)',
                        'border-color' => '#54B740',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359D22',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#20609D,#20609D)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '16px',
),
),
),
],
        'Used trade-in' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) button:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
                    'values' => array(
                        'Trade Appraisal',
                        'We Want Your Car',
                        'WHAT\'S YOUR TRADE WORTH?',
                        'Trade Appraisal',
                        'What is Your Trade Worth?',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F26522,#F26522)',
                        'border-color' => '#F06B20',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#CF540E',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B60833,#B60833)',
                        'border-color' => '#E01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#C60C0D',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4AAF08,#4AAF08)',
                        'border-color' => '#54B740',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359D22',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#20609D,#20609D)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                        'font-size' => '12px',
),
),
),
],
],
    'cost_distribution' => array(
        'adwords' => 700,
),
);
/*
add_filter('filter_riversideofprescott_fb_title', 'filter_riversideofprescott_fb_title', 10, 3);
function filter_riversideofprescott_fb_title($title, $car, $feed_type)
{
    if ($car['stock_type']=='new' && $car['year']=='2019') {
        
        $title_template = "[year] [make] [model] - [price]";
        
        $title = processTextTemplate($title_template, $car, true);
    }
    return $title;
}
*/
/*
add_filter('filter_riversideofprescott_fb_description', 'filter_riversideofprescott_fb_description', 10, 3);
function filter_riversideofprescott_fb_description($description, $car, $feed_type)
{
     if ($car['stock_type']=='new' && $car['year']=='2019') {
        
        $description_template  = 'Are you still interested in the [year] [make] [model]? Click for more info!';
        
        $description = processTextTemplate($title_template, $car, true);
    }
    return $description;
}
*/