<?php

global $CronConfigs;
$CronConfigs["nelsonsford"] = array(
    'password' => 'nelsonsford',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'no_adv' => true,
    'max_cost' => 2400,
    'bing_account_id' => 156003422,
    'bing_create' => array(
        'new_search' => true,
),
    'cost_distribution' => array(
        'adwords' => 2400,
),
    'create' => array(),
    'new_descs' => array(
        0 => array(
            'title2' => 'Shop & Finance Online',
            'title3' => 'Nelson Ford',
            'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
            'description2' => 'Shop online & create your deal from home',
),
        1 => array(
            'title2' => 'Shop & Finance Online',
            'title3' => 'Nelson Ford',
            'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
            'description2' => 'Shop online & create your deal from home',
),
),
    'used_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '240-862-3119',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'nelsonsford',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today.',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'adf_to' => array(
        0 => 'leads@nelsonfordmazda.net',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/(?:exotic-new|new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[href*=eprice-form]',
            'css-class' => 'a[href*=eprice-form]',
            'css-hover' => 'a[href*=eprice-form]:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[href*=eprice-form]',
                    'values' => array(
                        0 => 'Get E-Price',
                        1 => 'Get Internet Price',
                        2 => 'Get Your Price',
                        3 => 'Get Our Best Price',
                        4 => 'Lock This Price',
                        5 => 'Local Pricing',
                        6 => 'Best Price',
                        7 => 'Get Current Market Price',
                        8 => 'Get Details',
                        9 => 'Get Internet Price Now',
                        10 => 'Get your Price!',
                        11 => 'Confirm Availability',
                        12 => 'Get Your Exclusive Price',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF9900,#D78100)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD0006,#D50005)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0BDC00,#09AE00)',
                        'border-color' => '359D22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1DA7DB,#1DA7DB)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/(?:exotic-new|new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => '.payment-summary-cta',
            'css-class' => '.payment-summary-cta',
            'css-hover' => '.payment-summary-cta:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => '.payment-summary-cta',
                    'values' => array(
                        0 => 'Get Pre-Approved',
                        1 => 'Get Prequalified for Credit',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF9900,#D78100)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD0006,#D50005)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0BDC00,#09AE00)',
                        'border-color' => '359D22',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1DA7DB,#1DA7DB)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
),
),
),
),
        'apply-for-credit' => array(
            'url-match' => '/\\/(?:exotic-new|new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'li a[href*=credit-application]',
            'css-class' => 'li a[href*=credit-application]',
            'css-hover' => 'li a[href*=credit-application]:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'li a[href*=credit-application]',
                    'values' => array(
                        0 => 'No Hassle Financing',
                        1 => 'Get Financed Today',
                        2 => 'Financing Available',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF9900,#D78100)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD0006,#D50005)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0BDC00,#09AE00)',
                        'border-color' => '359D22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1DA7DB,#1DA7DB)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
),
        'trade-in' => array(
            'url-match' => '/\\/(?:exotic-new|new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[href*=trade].btn',
            'css-class' => 'a[href*=trade].btn',
            'css-hover' => 'a[href*=trade].btn:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'trade-in',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'trade-in' => array(
                    'target' => 'a[href*=trade].btn',
                    'values' => array(
                        0 => 'Appraise My Trade',
                        1 => 'What is Your Trade Worth?',
                        2 => 'We Want Your Trade',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF9900,#D78100)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD0006,#D50005)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0BDC00,#09AE00)',
                        'border-color' => '359D22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1DA7DB,#1DA7DB)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/(?:exotic-new|new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[href*=schedule].btn',
            'css-class' => 'a[href*=schedule].btn',
            'css-hover' => 'a[href*=schedule].btn:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a[href*=schedule].btn',
                    'values' => array(
                        0 => 'Book a Test Drive',
                        1 => 'Request Test Drive',
                        2 => 'Test Drive Today',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF9900,#D78100)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD0006,#D50005)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0BDC00,#09AE00)',
                        'border-color' => '359D22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1DA7DB,#1DA7DB)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
),
        'request-information' => array(
            'url-match' => '/\\/(?:exotic-new|new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[href*=lead].btn',
            'css-class' => 'a[href*=lead].btn',
            'css-hover' => 'a[href*=lead].btn:hover',
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-information' => array(
                    'target' => 'a[href*=lead].btn',
                    'values' => array(
                        0 => 'Get More Info',
                        1 => 'More Info',
                        2 => 'Learn More',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF9900,#D78100)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FD0006,#D50005)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0BDC00,#09AE00)',
                        'border-color' => '359D22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1DA7DB,#1DA7DB)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17540',
        'promotion_text' => 'FREE VISA GIFT CARD',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#1D82B6',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#1D82B6',
        'coupon_validity' => '60',
),
    'name' => 'nelsonsford',
);