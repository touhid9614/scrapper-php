<?php

global $CronConfigs;

$CronConfigs["arbogastrvs"] = array(
    'name' => 'arbogastrvs',
    'email' => 'regan@smedia.ca',
    'password' => 'arbogastrvs',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'max_cost' => 100,
    'cost_distribution' =>
    array(
        'adwords' => 100,
    ),
    'bing_account_id' => 156003169,
    'create' =>
    array(
    ),
    'new_descs' =>
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
    'customer_id' => '603-729-9609',
    'banner' =>
    array(
        'template' => 'arbogastrvs',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'styels' =>
        array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
        ),
        'border_color' => '#282828',
        'font_color' => 'ffffff',
    ),
    'lead' =>
    array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' =>
        array(
            '#8F1528',
            '#8F1528',
        ),
        'button_color_hover' =>
        array(
            '#0A0A0A',
            '#0A0A0A',
        ),
        'button_color_active' =>
        array(
            '#0A0A0A',
            '#0A0A0A',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$100 ArboBucks voucher from Dave Arbogast RV',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Dave Arbogast RV Team',
        'forward_to' =>
        array(
            'rvsales@davearbogast.com',
        ),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in' =>
        array(
            'vdp' => '/\\/product\\/(?:new|used)-/i',
            'service_regex' => '',
        ),
    ),
    'adf_to' =>
    array(
        'rvsales@davearbogast.com',
    ),
    'button_auto_reply' => true,
    'button_auto_reply_text' => 'Hello [first_name], We received your inquiry and will be in touch very soon. <br> Car URL: [url] <br> Pricing: [price]  <br> Stock Number: [stock_number]',
);
