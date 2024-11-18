<?php

global $CronConfigs;
$CronConfigs["watrousmainline"] = array(
    'name' => 'watrousmainline',
    'email' => 'regan@smedia.ca',
    'password' => 'watrousmainline',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'fb_title' => '[year] [make] [model] - [body_style] [price]',
    'log' => true,
    'customer_id' => '605-857-8737',
    'max_cost' => 200,
    'cost_distribution' => array(
        'adwords' => 200,
),
    'banner' => array(
        'template' => 'watrousmainline',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
         'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_marketplace_description' => '[description]',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'display_after' => 45000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            0 => '#075799',
            1 => '#075799',
),
        'button_color_hover' => array(
            0 => '#000000',
            1 => '#000000',
),
        'button_color_active' => array(
            0 => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '54B740',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '359D22',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2C62B8,#2C62B8)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC900,#EFC900)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D7B501,#D7B501)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
),
            1 => '#000000',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Watrous Mainline',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Watrous Mainline Team',
        'forward_to' => array(
            0 => 'smedia@watrousmainline.net',
            1 => 'marshal@smedia.ca',
),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'service_regex' => '',
),
),
    'adf_to' => array(
        0 => array(
            'Check Availability',
            'Get Your e-Price',
            'Special Pricing!',
            'Submit Request',
            'Send Message',
),
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) button:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) button span',
                    'values' => array(
                        0 => 'Get A Quote',
                        1 => 'Request A Quote',
                        2 => 'Get Special Price',
                        3 => 'Get Your Exclusive Price',
                        4 => 'Get Internet Price',
),
),
),
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '54B740',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '359D22',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2C62B8,#2C62B8)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC900,#EFC900)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D7B501,#D7B501)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
),
),
        'request-information' => array(
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-information' => array(
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button span',
                    'values' => array(
                        0 => 'Request Information',
                        1 => 'Get More Information',
                        2 => 'Ask for More Info',
                        3 => 'Learn More',
                        4 => 'More Info',
                        5 => 'Ask a Question',
                        6 => 'Let Our Experts Help',
                        7 => 'Ask an Expert',
),
),
),
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '54B740',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '359D22',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2C62B8,#2C62B8)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC900,#EFC900)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D7B501,#D7B501)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
),
),
        'confirm-availibility' => array(
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(6) button',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(6) button',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(6) button:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'confirm-availibility' => array(
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(6) button span',
                    'values' => array(
                        0 => 'Check Availability',
                        1 => 'Get Your e-Price',
                        2 => 'Special Pricing!',
                        3 => 'Submit Request',
                        4 => 'Send Message',
),
),
),
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '54B740',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '359D22',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2C62B8,#2C62B8)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC900,#EFC900)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D7B501,#D7B501)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
                'purple' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BE29EC,#BE29EC)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#951DBA,#951DBA)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
),
),
),
),
),
);