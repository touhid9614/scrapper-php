<?php

global $CronConfigs;
$CronConfigs["northwestpreownedcenter"] = array(
    'password' => 'northwestpreownedcenter',
    "email" => "regan@smedia.ca",
    'log' => true,
    //'no_adv' => true,
    'bing_account_id' => 156003208,
    //    "lead"  => array(
    //        'live'                  => false,
    //        'lead_type_'            => true,
    //        'lead_type_new'         => true,
    //        'lead_type_used'        => true,
    //        'bg_color'              => "#efefef",
    //        'text_color'            => "#404450",
    //        'border_color'          => "#e5e5e5",
    //        'button_color'          => array("#891c1d", "#891c1d"),
    //        'button_color_hover'    => array("#711314", "#711314"),
    //        'button_color_active'   => array("#891c1d", "#891c1d"),
    //        'button_text_color'     => "#ffffff",
    //        'response_email_subject'=> "$250 off from Northwest Pre-owned",
    //        'response_email'        => "Hello [name],<p> Thanks for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Northwest Pre-owned",
    //        'forward_to'            => array("jeff.burley@bmwnorthwest.com", "marshal@smedia.ca"),
    //        'respond_from'          => "offers@mail.smedia.ca",
    //        'forward_from'          => "offers@mail.smedia.ca",
    //        'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
    //    ),
    'max_cost' => 2325,
    "create" => array(
        "new_search" => no,
        "used_search" => yes,
        "new_display" => no,
        "used_display" => no,
        "new_retargeting" => no,
        "used_retargeting" => no,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => no,
        "used_combined" => no,
        "new_placement" => no,
        "used_placement" => no,
),
    "post_code" => "V9Y 8P2",
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
    "options_descs" => array(
        array(
            "desc1" => "Equipped with [option]",
            "desc2" => "and [option]",
),
),
    "ymmcount_descs" => array(
        array(
            "desc1" => "We have [ymmcount] [make]",
            "desc2" => "[model] in stock",
),
),
    "customer_id" => "423-491-0778",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "northwestpreownedcenter",
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info to get an additional \$200 OFF, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        "font_color" => "#ffffff",
),
    'lead_to' => array(
        'jeff.burley@bmwnorthwest.com',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/detail-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div#vdp-price-buttons div.col-xs-12.col-md-12 a',
            'css-class' => 'div#vdp-price-buttons div.col-xs-12.col-md-12 a',
            'css-hover' => 'div#vdp-price-buttons div.col-xs-12.col-md-12 a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div#vdp-price-buttons div.col-xs-12.col-md-12 a',
                    'values' => array(
                        'Get More Information',
                        'Inquire Now',
                        'I\'m interested!',
                        'Check Availability',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
),
],
],
    'cost_distribution' => array(
        'used' => 2325,
),
);