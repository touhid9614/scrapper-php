<?php

global $CronConfigs;
$CronConfigs["andreselectronicexperts"] = array(
    'password' => 'andreselectronicexperts',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'combined_feed_mode' => true,
    'customer_id' => '697-438-0109',
    'max_cost' => 3120,
    'fb_title' => '[make] [model]',
    'fb_new_title' => '[make] [model]',
    'cost_distribution' => array(
        'new' => 3120,
),
    'create' => array(
        "new_search" => true,
),
    'title' => '[make] [model]',
    'title2' => 'Buy Online Or Visit In Store',
    'new_descs' => array(
        'description' => 'Find Best Deals on [make] [model].',
        'description2' => 'Shop Now & Save!',
),
    'banner' => array(
        'fb_banner_title' => '[make] [model]',
        'fb_description' => 'Checkout [make] [model]. Shop now!',
        'old_price' => 'msrp',
        'fb_retargeting_description' => 'Don\'t miss out on your opportunity - buy the [make] [model] today!',
        'fb_dynamiclead_description' => 'Buy the [make] [model] today! Click below and fill in your information now.',
        'template' => 'andreselectronicexperts',
        'fb_style' => 'andreselectronicexperts',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
),
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => array(
        'buy' => array(
            'url-match' => '/\\/catalog\\/product\\/[0-9]+/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.buyNowForm button.primaryButton',
            'css-class' => '.buyNowForm button.primaryButton',
            'css-hover' => '.buyNowForm button.primaryButton:hover',
            'sizes' => array(
                100 => array(
                    'font-size' => '0.9em',
                    'padding' => '0.35714em 1.07142857em',
),
                120 => array(
                    'font-size' => '1.08em',
                    'padding' => '0.428568em 1.285714284em',
),
                140 => array(
                    'font-size' => '1.26em',
                    'padding' => '0.499996em 1.499999998em',
),
),
            'texts' => array(
                'buy' => array(
                    'target' => '.buyNowForm button.primaryButton',
                    'values' => array(
                        'Purchase',
                        'Buy Online',
                        'Buy Now',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC159,#EFC159)',
                        'color' => '#6f5127',
                        'border-color' => 'EFC159',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BF9A47,#BF9A47)',
                        'color' => '#ffffff',
                        'border-color' => 'BF9A47',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D75453,#D75453)',
                        'border-color' => 'D75453',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#AC4342,#AC4342)',
                        'border-color' => 'AC4342',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#60B660,#60B660)',
                        'border-color' => '60B660',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4D924D,#4D924D)',
                        'border-color' => '4D924D',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#60C0DC,#60C0DC)',
                        'border-color' => '60C0DC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4D9AB0,#4D9AB0)',
                        'border-color' => '4D9AB0',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '60C0DC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '4D9AB0',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '60C0DC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '4D9AB0',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '60C0DC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '4D9AB0',
),
),
),
),
        'learn-more' => array(
            'url-match' => '/\\/catalog\\/product\\/[0-9]+/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.ask-expert-button',
            'css-class' => '.ask-expert-button',
            'css-hover' => '.ask-expert-button:hover',
            'sizes' => array(
                100 => array(
                    'font-size' => '0.9em',
                    'width' => '210px',
                    'padding' => '10px',
),
                120 => array(
                    'font-size' => '1.08em',
                    'width' => '252px',
                    'padding' => '12px',
),
                140 => array(
                    'font-size' => '1.26em',
                    'width' => '294px',
                    'padding' => '14px',
),
),
            'texts' => array(
                'learn-more' => array(
                    'target' => '.ask-expert-button',
                    'values' => array(
                        'Get More Information',
                        'Learn More',
                        'Let our Experts Help',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EFC159,#EFC159)',
                        'color' => '#6f5127',
                        'border-color' => 'EFC159',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BF9A47,#BF9A47)',
                        'color' => '#ffffff',
                        'border-color' => 'BF9A47',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D75453,#D75453)',
                        'border-color' => 'D75453',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#AC4342,#AC4342)',
                        'border-color' => 'AC4342',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#60B660,#60B660)',
                        'border-color' => '60B660',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4D924D,#4D924D)',
                        'border-color' => '4D924D',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#60C0DC,#60C0DC)',
                        'border-color' => '60C0DC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4D9AB0,#4D9AB0)',
                        'border-color' => '4D9AB0',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '60C0DC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '4D9AB0',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '60C0DC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '4D9AB0',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '60C0DC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '4D9AB0',
),
),
),
),
),
    'name' => 'andreselectronicexperts',
);