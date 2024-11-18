<?php

global $CronConfigs;

$CronConfigs["bennettgm"] = array(
    'password' => 'bennettgm',
    'log' => true,
    'bid' => 3.0,
    'bid_modifier' =>
    array(
        'after' => 45,
        'bid' => 1.5,
    ),
    'max_cost' => 2600,
    'cost_distribution' =>
    array(
        'youtube' => 0,
        'new' => 2600,
        'used' => 0,
        'service' => 0,
    ),
    'post_code' => 'N1R 6J2',
    'email' => 'regan@smedia.ca',
    'retargetting_delay' => 30000,
    'button_auto_reply' => true,
    'smart_ad_url' => 'http://www.bennettgm.com/VehicleSearchResults?make=[make]&year=[year]&model=[model]',
    'lead' =>
    array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#efefef',
        'text_color' => '#404450',
        'border_color' => '#e5e5e5',
        'button_color' =>
        array(
             '#383838',
             '#383838',
        ),
        'button_color_hover' =>
        array(
             '#000000',
             '#000000',
        ),
        'button_color_active' =>
        array(
             '#383838',
             '#383838',
        ),
        'button_text_color' => '#ffffff',
        'response_email_subject' => 'Offer from Bennett GM',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bennett GM Team',
        'forward_to' =>
        array(
             'kkruger@bennettgm.com',
             'marshal@smedia.ca',
        ),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in' =>
        array(
            'vdp' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
    'create' =>
    array(
    ),
    'new_descs' =>
    array(
        
        array(
            'desc1' => 'Get a free trip',
            'desc2' => 'with every purchase!',
        ),
        
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
        ),
    ),
    'used_descs' =>
    array(
        
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'customer_id' => '309-847-3181',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' =>
    array(
        'template' => 'bennettgm',
        'old_price_new' => 'msrp',
        'fb_retargeting_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click for more info!',
        'fb_retargeting_description_equinox' => 'Are you still interested in the [year] [make] [model] [trim]? The Equinox is Proudly built in Ingersoll, Ontario!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today! Click for more information.',
        'fb_lookalike_description_equinox' => 'Check out this [year] [make] [model] [trim] today. The Equinox is Proudly built in Ingersoll, Ontario!',
        'fb_dynamiclead_description' => 'Are you still interested in [Year] [Make] [Model] [trim]? Click below and fill in your information to get our best price.',
        'hst' => true,
        'flash_style' => 'default',
        'styels' =>
        array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
        ),
        'font_color' => '#ffffff',
    ),
    'adf_to' =>
    array(
         'webleads@bennettgm.com',
    ),
    'lead_to' =>
    array(
         'leads@bennettgm.com',
    ),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' =>
    array(
        'request-a-quote' =>
        array(
            'url-match' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' =>
            array(
                'default' => NULL,
            ),
            'action-target' => 'button#request-info',
            'css-class' => 'button#request-info',
            'css-hover' => 'button#request-info:hover',
            'button_action' =>
            array(
                 'form',
                 'e-price',
            ),
            'sizes' =>
            array(
                100 =>
                array(
                ),
            ),
            'texts' =>
            array(
                'request-a-quote' =>
                array(
                    'target' => 'button#request-info',
                    'values' =>
                    array(
                         'Get E Price Now!',
                         'E- Price',
                         'Get Our Best Price',
                         'Best Price',
                         'Local Pricing',
                         'Special Pricing!',
                         'Get More Information',
                         'Get Market Price',
                         'Check Availability',
                         'Get Special Price!',
                         'SPECIAL PRICING!',
                    ),
                ),
            ),
            'styles' =>
            array(
                'orange' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                    ),
                ),
                'red' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                    ),
                ),
                'green' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                    ),
                ),
                'blue' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Platinum' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Black' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
        'test-drive' =>
        array(
            'url-match' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' =>
            array(
                'default' => NULL,
            ),
            'action-target' => 'p.btns-price-incentives-new span:nth-of-type(4) a',
            'css-class' => 'p.btns-price-incentives-new span:nth-of-type(4) a',
            'css-hover' => 'p.btns-price-incentives-new span:nth-of-type(4) a:hover',
            'button_action' =>
            array(
                 'form',
                 'test-drive',
            ),
            'sizes' =>
            array(
                100 =>
                array(
                ),
            ),
            'texts' =>
            array(
                'test-drive' =>
                array(
                    'target' => 'p.btns-price-incentives-new span:nth-of-type(4) a',
                    'values' =>
                    array(
                         'Schedule Test Drive',
                         'Book My Test Drive',
                    ),
                ),
            ),
            'styles' =>
            array(
                'orange' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                    ),
                ),
                'red' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                    ),
                ),
                'green' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                    ),
                ),
                'blue' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Platinum' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Black' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan' =>
                array(
                    'normal' =>
                    array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
                    ),
                    'hover' =>
                    array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
    ),
    'name' => 'bennettgm',
);
