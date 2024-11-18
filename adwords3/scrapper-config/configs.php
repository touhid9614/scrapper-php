<?php

global $CronConfigs, $scrapper_configs, $nlp_api;

$CronConfigs["401dixiehyundaicom"] = array(
    'name' => '401dixiehyundaicom',
    'email' => 'regan@smedia.ca',
    'password' => '401dixiehyundaicom',
    'log' => true,
    'combined_feed_mode' => true,
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => false,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0A2972',
            '#0A2972',
),
        'button_color_hover' => array(
            '#000000',
            '#000000',
),
        'button_color_active' => array(
            '#25448D',
            '#25448D',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Claim $200 Off with a purchase from 401 Dixie Hyundai',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>401 Dixie Hyundai Team',
        'forward_to' => array(),
        'special_to' => array(
            'leads@Dixiehyundai.motosnap.com',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
            'service_regex' => '',
),
        'custom_div' => '',
),
    'max_cost' => 0,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
),
);

$CronConfigs["417nissancom"] = array(
    'name'               => '417nissancom',
    'email'              => 'regan@smedia.ca',
    'password'           => '417nissancom',
    'log'                => true,
    'combined_feed_mode' => true,
    'lead'               => array(
        'live'                   => true,
        'lead_type_'             => true,
        'lead_type_new'          => true,
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
        'sent_client_email'      => false,
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#C4172C',
            '#C4172C',
        ),
        'button_color_hover'     => array(
            '#000000',
            '#000000',
        ),
        'button_color_active'    => array(
            '#DF3247',
            '#DF3247',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Claim $200 Off with a purchase from 417 Nissan',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>417 Nissan Team',
        'forward_to'             => array(),
        'special_to'             => array(
            'leads@417auto.motosnap.com',
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
            'vdp'           => '/\\/vehicles\\/[0-9]{4}\\//',
            'service_regex' => '',
        ),
        'custom_div'             => '',
    ),
);

$CronConfigs["VolvoNB"] = array(
    'password' => 'VolvoNB',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'adgroup_version' => 'v10',
    'max_cost' => 4800,
    'cost_distribution' => array(
        'adwords' => 4800,
),
    'customer_id' => '765-174-5633',
    'create' => array(
        'new_search' => true,
        'used_search' => true,
        'new_placement' => true,
        'used_placement' => true,
        'new_display' => true,
        'used_display' => true,
        'new_retargeting' => true,
        'used_retargeting' => true,
        'new_marketbuyers' => false,
        'used_marketbuyers' => false,
        'new_combined' => true,
        'used_combined' => true,
),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'VolvoNB',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => null,
    'name' => 'VolvoNB',
);

$CronConfigs["a1tiresaskatoon"] = array(
    'max_cost' => 300,
    'customer_id' => '224-883-3827',
    'password' => 'a1tiresaskatoon',
    'email' => 'regan@smedia.ca',
    'no_adv' => true,
    'cost_distribution' => array(),
    'name' => 'a1tiresaskatoon',
);

$CronConfigs["abbotsfordnissan"] = array(
    'name' => 'abbotsfordnissan',
    'email' => 'regan@smedia.ca',
    'password' => 'abbotsfordnissan',
    'customer_id' => '861-042-1098',
    'log' => true,
    'banner' => array(
        'template' => 'abbotsfordnissan',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 2600,
    'cost_distribution' => array(
        'new' => 886,
        'used' => 1714,
),
    'lead' => null,
);

$CronConfigs["abbotsfordvw"] = array(
    'name' => 'abbotsfordvw',
    'email' => 'regan@smedia.ca',
    'password' => 'abbotsfordvw',
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'max_cost' => 800,
    'cost_distribution' => array(
        'adwords' => 800,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '206-759-1830',
    'banner' => array(
        'template' => 'abbotsfordvw',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
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
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => true,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => false,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0070BB',
            '#0070BB',
),
        'button_color_hover' => array(
            '#003D66',
            '#003D66',
),
        'button_color_active' => array(
            '#003D66',
            '#003D66',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'Get $250 off your vehicle purchase at Abbotsford Volkswagen',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Abbotsford VW Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@abbotsfordvw.motosnap.com',
            'adf_to@smedia.ca',
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
                        <name part="full">Abbotsford Volkswagen Team</name>
                        <email>[dealer_email]</email>
                    </contact>
                </vendor>
                <provider>
                    <name part="full">sMedia Coupon</name>
                    <url>https://smedia.ca</url>
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
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia Coupon',
        'source' => 'sMedia smartoffer',
),
);

$CronConfigs["acuraofhamiltonca"] = array( 
	"name"  => "acuraofhamiltonca",
	"email" => "regan@smedia.ca",
	"password" => "acuraofhamiltonca",
	// "no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["acuraofnorthtorontoca"] = array (
  'name' => 'acuraofnorthtorontoca',
  'email' => 'regan@smedia.ca',
  'password' => 'acuraofnorthtorontoca',
  'log' => true,
);

$CronConfigs["adamsautosales"] = array(
    "name" => " adamsautosales",
    "email" => "regan@smedia.ca",
    "password" => " newwayford",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    "combined_feed_mode" => true,
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
    "create" => array(),
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
    'customer_id' => '483-415-7680',
    "banner" => array(
        "template" => "adamsautosales",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_lookalike_description"	=> "Test drive the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
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
    "lead" => null,
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17563',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);

$CronConfigs["adventurervca"] = array(
    'name' => 'adventurervca',
    'email' => 'regan@smedia.ca',
    'password' => 'adventurervca',
    'combined_feed_mode' => true,
    'log' => true,
    'fb_title' => '[make] [model] [price]',
    'banner' => array(
        'template' => 'adventurervca',
        'fb_description' => 'Are you still interested in the [make] [model]? We\'re offering FREE storage with RV purchase. Order now & Pick up in the SPRING!',
        //'fb_aia_description' => 'Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'We\'re offering FREE storage with RV purchase. Order this [make] [model] now & Pick up in the SPRING!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'max_cost' => 400,
    'cost_distribution' => array(
        'new' => 200,
        'used' => 200,
),
);

$CronConfigs["airdriedodge"] = array(
    'name'     => 'airdriedodge',
    'email'    => 'regan@smedia.ca',
    'password' => 'airdriedodge',
    'log'      => true
);

$CronConfigs["alexandriacampingcentre"] = array(
    'password' => 'alexandriacampingcentre',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'combined_feed_mode' => true,
    'lead' => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#008CD5',
            '#008CD5',
),
        'button_color_hover' => array(
            '#009549',
            '#009549',
),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Your  50% off an RV Cover Coupon',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Alexandria Camping Centre Team',
        'forward_to' => array(
            'dtan@alexandriacc.ca',
            'marshal@smedia.ca',
),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in' => array(
            'vdp' => '/\\/default.asp\\?page=x(?:New|PreOwned)InventoryDetail/i',
            'service_regex' => '',
),
),
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'alexandriacampingcentre',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click below for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out the [year] [make] [model] today!',
        'fb_dynamiclead_description' => 'Still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to help.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'name' => 'alexandriacampingcentre',
    'max_cost' => 1000,
    'cost_distribution' => array(
        'adwords' => 1000,
),
);

$CronConfigs["allstarrvca"] = array (
  'name' => 'allstarrvca',
  'email' => 'regan@smedia.ca',
  'password' => 'allstarrvca',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'allstarrvca',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["andreselectronicexperts"] = array(
    'password' => 'andreselectronicexperts',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'combined_feed_mode' => true,
    'customer_id' => '697-438-0109',
    'max_cost' => 2800,
    'fb_title' => '[make] [model]',
    'fb_new_title' => '[make] [model]',
    'cost_distribution' => array(
        'adwords' => 2800,
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

$CronConfigs["apollorvsalescomau"] = array( 
	"name"  => "apollorvsalescomau",
	"email" => "regan@smedia.ca",
	"password" => "apollorvsalescomau",
	"log" => true,
        'fb_title' => "[year] [make] [model]",
);

$CronConfigs["arbogastrvs"] = array(
    'name' => 'arbogastrvs',
    'email' => 'regan@smedia.ca',
    'password' => 'arbogastrvs',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'max_cost' => 100,
    'cost_distribution' => array(
        'adwords' => 100,
),
    'bing_account_id' => 156003169,
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
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
    'banner' => array(
        'template' => 'arbogastrvs',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'styels' => array(
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
    'lead' => null,
    'adf_to' => array(
        'rvsales@davearbogast.com',
),
    'button_auto_reply' => true,
    'button_auto_reply_text' => 'Hello [first_name], We received your inquiry and will be in touch very soon. <br> Car URL: [url] <br> Pricing: [price]  <br> Stock Number: [stock_number]',
);

$CronConfigs["arlingtonacura"] = array(
    'password' => 'arlingtonacura',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'arlingtonacura',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'name' => 'arlingtonacura',
    'max_cost' => 1366,
    'cost_distribution' => array(
        'new' => 683,
        'used' => 683,
),
);

$CronConfigs["arlingtonnissan"] = array(
    'password' => 'arlingtonnissan',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'combined_feed_mode' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'fb_title' => "[year] [make] [model] [trim]",
    'banner' => array(
        'template' => 'arlingtonnissan',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'name' => 'arlingtonnissan',
    'max_cost' => 880,
    'cost_distribution' => array(
        'new' => 440,
        'used' => 440,
),
);

$CronConfigs["audielkgrovecom"] = array( 
	"name"  => "audielkgrovecom",
	"email" => "regan@smedia.ca",
	"password" => "audielkgrovecom",
	"no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["audiwindsorcom"] = array( 
	"name"  => "audiwindsorcom",
	"email" => "regan@smedia.ca",
	"password" => "audiwindsorcom",
	//"no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["audiwinnipegcom"] = array(
    'name' => 'audiwinnipegcom',
    'email' => 'regan@smedia.ca',
    'password' => 'audiwinnipegcom',
    'log' => true,
	"banner" => array(
        "template" => "audiwinnipegcom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
		'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
    /*'lead' => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => false,
        'exit_intent' => false,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => false,
            'tablet' => false,
),
        'sent_client_email' => false,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0070BB',
            '#0070BB',
),
        'button_color_hover' => array(
            '#003D66',
            '#222222',
),
        'button_color_active' => array(
            '#003D66',
            '#003D66',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'Receive free pre-paid maintenance with the purchase of any in-stock new or demo Audi. ',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Audi Winnipeg  Team',
        'forward_to' => array(
            '',
),
        'special_to' => array(
            'leads@audiwinnipeg.motosnap.com',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'SMEDIA COUPON',
),*/
);

$CronConfigs["auffenbergcarbondale"] = array (
  'password' => 'auffenbergcarbondale',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'auffenbergcarbondale',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
    'fb_lookalike_description' => 'Test drive the [year] [make] [model] today.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'name' => 'auffenbergcarbondale',
);

$CronConfigs["autoformco"] = array (
  'name' => 'autoformco',
  'email' => 'regan@smedia.ca',
  'password' => 'autoformco',
  'log' => true,
  'banner' => 
  array (
    'template' => 'autoformco',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["autogalleryofwinnipeg"] = array(
    'name' => 'autogalleryofwinnipeg',
    'email' => 'regan@smedia.ca',
    'password' => 'autogalleryofwinnipeg',
    'log' => true,
    'combined_feed_mode' => true,
    'customer_id' => '453-629-0425',
    'max_cost' => 2550,
    'cost_distribution' => array(
        'adwords' => 2550,
),
    'banner' => array(
        'template' => 'autogalleryofwinnipeg',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
);

$CronConfigs["automarketsales"] = array(
    'bid' => 3.0,
    'password' => 'automarketsales',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'email' => 'regan@smedia.ca',
    'lead' => null,
    'banner' => array(
        'template' => 'automarketsales',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'name' => 'automarketsales',
);

$CronConfigs["automaxxcalgary"] = array(
    'name' => 'automaxxcalgary',
    'email' => 'regan@smedia.ca',
    'password' => 'automaxxcalgary',
    'log' => true,
    'banner' => array(
        'template' => 'automaxxcalgary',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out the [year] [make] [model] today! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info to claim a $250 off, and a product specialist will be in touch to aid in any questions.',
        'fb_marketplace_description' => '[description]',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
);

$CronConfigs["automaxxcom"] = array( 
	"name"  => "automaxxcom",
	"email" => "regan@smedia.ca",
	"password" => "automaxxcom",
//	"no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["automaxxon16thcom"] = array( 
	"name"  => "automaxxon16thcom",
	"email" => "regan@smedia.ca",
	"password" => "automaxxon16thcom",
	// "no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["autoparkbarrie"] = array(
    'password' => 'autoparkbarrie',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'banner' => array(
        'template' => 'autoparkbarrie',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'form_live' => false,
    'buttons_live' => false,
    'name' => 'autoparkbarrie',
);

$CronConfigs["autoparkbrampton"] = array (
  'name' => 'autoparkbrampton',
  'email' => 'regan@smedia.ca',
  'password' => 'autoparkbrampton',
  'log' => true,
  'form_live' => false,
  'buttons_live' => false,
);

$CronConfigs["autopartszone"] = array(
    "name" => "autopartszone",
    "email" => "regan@smedia.ca",
    "password" => "autopartszone",
    "log" => true,
    "combined_feed_mode" => true,
    'max_cost' => 400,
    'cost_distribution' => array(
        'new' => 200,
        'used' => 200,
),
);

$CronConfigs["autoplanetca"] = array( 
	"name"  => "autoplanetca",
	"email" => "regan@smedia.ca",
	"password" => "autoplanetca",
	"no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["autosbynelson"] = array(
    'password' => 'autosbynelson',
    'email' => 'regan@smedia.ca',
    'log' => true,
    //'no_adv' => true,
    'max_cost' => 21300,
    'bing_account_id' => 156003424,
    'bing_create' => array(
        'used_search' => true,
),
    'cost_distribution' => array(
        'adwords' => 21300,
),
    'create' => array(),
    'new_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        0 => array(
            'title2' => 'Shop & Finance Online',
            'title3' => 'Autos By Nelson',
            'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
            'description2' => 'Shop online & create your deal from home',
),
        1 => array(
            'title2' => 'Shop & Finance Online',
            'title3' => 'Autos By Nelson',
            'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
            'description2' => 'Shop online & create your deal from home',
),
),
    'customer_id' => '512-027-9350',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'autosbynelson',
        //'old_price_new' => 'msrp',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
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
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17549',
        'promotion_text' => 'FREE VISA GIFT CARD',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#EA2627',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#EA2627',
        'coupon_validity' => '60',
),
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[data-href*=eprice]',
            'css-class' => 'a[data-href*=eprice]',
            'css-hover' => 'a[data-href*=eprice]:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[data-href*=eprice]',
                    'values' => array(
                        0 => 'Get Your Price',
                        1 => 'Get Our Best Price',
                        2 => 'Local Pricing',
                        3 => 'Best Price',
                        4 => 'Get Current Market Price',
                        5 => 'Get Details',
                        6 => 'Get Internet Price Now',
                        7 => 'Get e-price',
                        8 => 'Get your Price!',
                        9 => 'Confirm Availability',
                        10 => 'Get Your Exclusive Price',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'padding-top' => '12px',
                        'width' => '264px',
                        'height' => '42px',
),
),
),
),
        'trade-in' => array(
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'div[data-widget-name="links-list"] a[href *=trade-in-form]',
            'css-class' => 'div[data-widget-name="links-list"] a[href *=trade-in-form]',
            'css-hover' => 'div[data-widget-name="links-list"] a[href *=trade-in-form]:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'trade-in',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'trade-in' => array(
                    'target' => 'div[data-widget-name="links-list"] a[href *=trade-in-form]',
                    'values' => array(
                        0 => 'Get Trade-In Value',
                        1 => 'Value Your Trade',
                        2 => 'Trade Offer',
                        3 => 'What\'s Your Trade Worth?',
                        4 => 'We Want Your Car!',
),
),
),
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
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[href *=schedule]',
            'css-class' => 'a[href *=schedule]',
            'css-hover' => 'a[href *=schedule]:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[href *=schedule]',
                    'values' => array(
                        0 => 'Request a Test Drive',
                        1 => 'Test Drive Now',
                        2 => 'Test Drive Today',
                        3 => 'Want To Test Drive',
                        4 => 'Schedule My Visit',
),
),
),
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
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
),
),
    'name' => 'autosbynelson',
);

$CronConfigs["autoshowwinnipeg"] = array (
  'name' => 'autoshowwinnipeg',
  'email' => 'regan@smedia.ca',
  'password' => 'autoshowwinnipeg',
  'combined_feed_mode' => true,
  'log' => true,
  'banner' => 
  array (
    'template' => 'autoshowwinnipeg',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["avenuenissancom"] = array (
  'name' => 'avenuenissancom',
  'email' => 'regan@smedia.ca',
  'password' => 'avenuenissancom',
  'no_adv' => true,
);

$CronConfigs["bannisterford"] = array(
    "name" => " bannisterford",
    "email" => "regan@smedia.ca",
    "password" => "bannisterford",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    'max_cost' => 1010,
    'bing_account_id' => 156002882,
    'cost_distribution' => array(
        'new' => 505,
        'used' => 505,
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
    'customer_id' => '310-828-5484',
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "bannisterford",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        /*"fb_marketplace_description" => "[description]",
          "fb_marketplace_title" => "[year] [make] [model] [trim]",
          "old_price" => "msrp",*/
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
),
    "lead" => null,
);

$CronConfigs["bannistergmcom"] = array (
  'name' => 'bannistergmcom',
  'email' => 'regan@smedia.ca',
  'password' => 'bannistergmcom',
  'log' => true,
  'max_cost' => 555,
  'cost_distribution' => 
  array (
    'adwords' => 555,
  ),
  'customer_id' => '898-820-1909',
  'create' => 
  array (
  ),
  'banner' => 
  array (
    'template' => 'bannistergmcom',
    'fb_retargeting_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
);

$CronConfigs["bannistergpkiaca"] = array( 
	"name"  => "bannistergpkiaca",
	"email" => "regan@smedia.ca",
	"password" => "bannistergpkiaca",
	"no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["bannisterhonda"] = array(
    'password' => 'bannisterhonda',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'customer_id' => '426-078-4225',
    'max_cost' => 0,
    'bing_account_id' => 156002883,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'lead' => array(
        'live' => true,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#222222',
            '#222222',
),
        'button_color_active' => array(
            '#222222',
            '#222222',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'Your offer from [dealership]',
        'response_email' => '',
        'forward_to' => array(
            '',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
    'banner' => array(
        'template' => 'bannisterhonda',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click to get your best deal!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
),
    'name' => 'bannisterhonda',
);

$CronConfigs["bannisterkelowna"] = array(
    'password' => 'bannisterkelowna',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'combined_feed_mode' => true,
    'customer_id' => '252-687-9577',
    'max_cost' => 4108,
    'cost_distribution' => array(
        'adwords' => 4108,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'lead' => null,
    'banner' => array(
        'template' => 'bannisterkelowna',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => '#ffffff',
),
    'name' => 'bannisterkelowna',
);

$CronConfigs["bannisterkelownacom"] = array (
  'name' => 'bannisterkelownacom',
  'email' => 'regan@smedia.ca',
  'password' => 'bannisterkelownacom',
  'no_adv' => true,
);

$CronConfigs["bannisters"] = array(
    'name' => 'bannisters',
    'email' => 'regan@smedia.ca',
    'password' => 'bannisters',
    'log' => true,
    'max_cost' => 1526,
    'cost_distribution' => array(
        'adwords' => 1526,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '859-937-1576',
    'banner' => array(
        'template' => 'bannisters',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in [Year] [Make] [Model]? Click below and fill in your information to get our best price.',
        'hst' => true,
        'flash_style' => 'default',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#EB242E',
            '#EB242E',
),
        'button_color_hover' => array(
            '#9C1519',
            '#9C1519',
),
        'button_color_active' => array(
            '#9C1519',
            '#9C1519',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Claim an extra $200 off coupon from Bannister GM Vernon',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bannister GM Vernon Team',
        'forward_to' => array(
            'seanm@bannisters.com',
            'sales@bannisters.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'cdkileads@bannisters.com',
            'adf_to@smedia.ca',
            'leads@bannistergmvernon.ca',
),
        'special_email' => '<?xml version="1.0"?>
        <?adf version="1.0"?>
        <adf>
            <prospect>
                <id sequence="[total_count]" source="Bannister Vernon GM"></id>
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
                        <name part="full">Bannister Vernon GM</name>
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
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'service_regex' => '',
),
        'custom_div' => '',
),
);

$CronConfigs["barbermotors"] = array(
    'name'                   => 'barbermotors',
    'bid'                    => 3.0,
    'log'                    => true,
    'password'               => 'barbermotors',
    'customer_id'            => '451-710-0704',
    'bid_modifier'           => array(
        'after' => 45,
        'bid'   => 1.5,
    ),
    'max_cost'               => 1000,
    'cost_distribution'      => array(),
    'email'                  => 'regan@smedia.ca',
    'retargetting_delay'     => 30000,
    'post_code'              => 'S4H 0N8',
    'trackers'               => array(
        'new_search'       => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_search'      => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_display'      => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_display'     => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_retargeting'  => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_retargeting' => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'new_combined'     => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
        'used_combined'    => 'utm_source=smedia&utm_medium=google&utm_campaign=inventory',
    ),
    'bing_account_id'        => 156002978,
    'create'                 => array(),
    'host_url'               => 'http://www.barbermotors.com',
    'display_url'            => 'www.barbermotors.com',
    'new_descs'              => array(
        array(
            'desc' => 'Test Drive the [year]',
            'desc' => '[make] [model] today.',
        ),
        array(
            'desc' => 'Call us today about the ',
            'desc' => '[year] [make] [model]',
        ),
    ),
    'used_descs'             => array(
        array(
            'desc' => 'Test Drive the [year]',
            'desc' => '[make] [model] today.',
        ),
        array(
            'desc' => 'Call us today about the ',
            'desc' => '[year] [make] [model]',
        ),
    ),
    'options_descs'          => array(
        array(
            'desc' => 'Equipped with [option]',
            'desc' => 'and [option]',
        ),
    ),
    'ymmcount_descs'         => array(
        array(
            'desc' => 'We have [ymmcount] [make]',
            'desc' => '[model] in stock',
        ),
    ),
    'fb_brand'               => '[year] [make] [model] - [body_style]',
    'banner'                 => array(
        'template'                   => 'barbermotors',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.',
        'flash_style'                => 'default',
        'border_color'               => '#101010',
        'font_color'                 => '333333',
        'styels'                     => array(
            'new_display'       => 'custom_banner',
            'used_display'      => 'custom_banner',
            'new_retargeting'   => 'custom_banner',
            'used_retargeting'  => 'custom_banner',
            'new_marketbuyers'  => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
        ),
    ),
    'powered_by_live'        => false,
    'buttons_powered_by'     => array(
        'icon_alt'     => 'powered by smedia',
        'icon_class'   => 'powered_by_smedia',
        'icon'         => 'SMEDIA-vertical-dark.png',
        'location_tag' => '.vehicle-details > .deck [class*="vehicleGalleryDetailsAndLinks"] [class*="vehicleSpecificationsAndLogos"] > .content .link',
        'styles'       => array(
            'normal' => array(
                'background-color' => '#FFFFFF',
            ),
        ),
    ),
    'lead_to'                => array(
        'salesmanager@barbermotors.com',
        'andybarber@barbermotors.com',
        'amandagriffin@barbermotors.com',
        'internetsales@barbermotors.com',
    ),
    'button_auto_reply'      => true,
    'button_auto_reply_text' => 'Hello [first_name], We received your inquiry and will be in touch very soon.',
    'form_live'              => true,
    'buttons_live'           => true,
    'buttons'                => array(
        'request-a-quote' => array(
            'url-match'     => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'a.di-modal.main-cta.vdp-pricebox-cta-button[href*="#modal__main-form"]',
            'css-class'     => 'a.di-modal.main-cta.vdp-pricebox-cta-button[href*="#modal__main-form"]',
            'css-hover'     => 'a.di-modal.main-cta.vdp-pricebox-cta-button[href*="#modal__main-form"]:hover',
            'button_action' => array(
                'form',
                'e-price',
            ),
            'sizes'         => array(
                100 => array(),
            ),
            'texts'         => array(
                'request-a-quote' => array(
                    'target' => 'a.di-modal.main-cta.vdp-pricebox-cta-button[href*="#modal__main-form"]',
                    'values' => array(
                        'Request A Quote',
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'E- Price',
                        'Get Internet Price Now!',
                        'Contact Us.',
                        'Get Our Best Price',
                        'Best Price',
                        'Contact Us',
                        'Contact Store',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing',
                        'Special Finance Offers!',
                        'Special Finance Offers',
                        'TODAY\'S MARKET PRICE',
                        'Confirm Availability',
                    ),
                ),
            ),
            'styles'        => array(
                'orange'   => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                    ),
                ),
                'red'      => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E0121',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                    ),
                ),
                'green'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D2',
                    ),
                ),
                'blue'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Black'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
                'ol'       => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
        'test-drive'      => array(
            'url-match'     => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => '.button.secondary-button.block.di-modal[href*="#modal__gform_7"]',
            'css-class'     => '.button.secondary-button.block.di-modal[href*="#modal__gform_7"]',
            'css-hover'     => '.button.secondary-button.block.di-modal[href*="#modal__gform_7"]:hover',
            'button_action' => array(
                'form',
                'test-drive',
            ),
            'sizes'         => array(
                100 => array(),
            ),
            'texts'         => array(
                'test-drive' => array(
                    'target' => '.button.secondary-button.block.di-modal[href*="#modal__gform_7"]',
                    'values' => array(
                        'Test drive',
                        'Book Test Drive',
                        'Schedule Test Drive',
                        'Test Drive Now',
                        'Test Drive today',
                        'Test Ride',
                        'Book My Test Drive',
                        'Schedule My Test Drive',
                        'Schedule Virtual Test Drive',
                    ),
                ),
            ),
            'styles'        => array(
                'orange'   => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                    ),
                ),
                'red'      => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E0121',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                    ),
                ),
                'green'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D2',
                    ),
                ),
                'blue'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Black'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
                'ol'       => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
        'financing'       => array(
            'url-match'     => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class'     => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover'     => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' => array(
                'form',
                'finance',
            ),
            'sizes'         => array(
                100 => array(),
            ),
            'texts'         => array(
                'financing' => array(
                    'target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
                    'values' => array(
                        'Estimate Payments',
                        'Financing Options',
                        'Special Finance Offers!',
                        'Calculate my Payments',
                        'Payment options',
                        'Special Finance Offers',
                        'Explore Payments',
                        'Financing Available',
                    ),
                ),
            ),
            'styles'        => array(
                'orange'   => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                    ),
                ),
                'red'      => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E0121',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                    ),
                ),
                'green'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D2',
                    ),
                ),
                'blue'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Black'    => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan'     => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
                'ol'       => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
    ),
    'mail_retargeting'       => array(
        'enabled'   => null,
        'client_id' => '',
        'new'       => array(
            'promotion_text'      => '',
            'promotion_color'     => '#567DC0',
            'overlay_color'       => '#ff8500',
            'overlay_text_colour' => '#ffffff',
            'price_color'         => '#ff8500',
            'coupon_validity'     => '7',
        ),
    ),
    'adf_to'                 => '',
);

$CronConfigs["barkermitsubishi"] = array (
  'name' => 'barkermitsubishi',
  'email' => 'regan@smedia.ca',
  'password' => 'barkermitsubishi',
  'log' => true,
  'banner' => 
  array (
    'template' => 'barkermitsubishi',
    'fb_description' => 'Are you still interested in this [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["barneswheatongmnorthsurrey"] = array (
  'password' => 'barneswheatongmnorthsurrey',
  'email' => 'regan@smedia.ca',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'banner' => 
  array (
    'template' => 'barneswheatongmnorthsurrey',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'name' => 'barneswheatongmnorthsurrey',
);

$CronConfigs["barrycullen"] = array(
    'password' => 'barrycullen',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'max_cost' => 0,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
        'brand' => 0,
),
    'create' => array(),
    'new_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
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
    'customer_id' => '922-323-8795',
    'lead' => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            0 => '#151419',
            1 => '#151419',
),
        'button_color_hover' => array(
            0 => '#E1A504',
            1 => '#E1A504',
),
        'button_color_active' => array(
            0 => '#E1A504',
            1 => '#E1A504',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $200 off with this offer from Barry Cullen',
        'response_email' => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Barry Cullen',
        'forward_to' => array(
            0 => 'hinoonchev@hotmail.com',
            1 => 'marshal@smedia.ca',
),
        'special_to' => array(
            0 => 'rabbi@smedia.ca',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'service_regex' => '',
),
        'custom_div' => '',
),
    'banner' => array(
        'template' => 'barrycullen',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? We\'re still here for you online!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] - We\'re still here for you online!',
        'fb_marketplace_description' => '[description]',
        'flash_style' => 'default',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'border_color' => '#282828',
        'hst' => true,
        'font_color' => '#ffffff',
),
    'name' => 'barrycullen',
);

$CronConfigs["basswoodcdjr"] = array(
    'password'     => 'basswoodcdjr',
    'email'        => 'regan@smedia.ca',
    'log'          => true,
    'banner'       => array(
        'template'                 => 'basswoodcdjr',
        'fb_description'           => 'Are you still interested in the [year] [make] [model] [trim]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today! Click for more information.',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => '#ffffff',
    ),
    'buttons_live' => false,
    'name'         => 'basswoodcdjr',
);

$CronConfigs["bcvehiclefinanceca"] = array(
    "name" => "bcvehiclefinanceca",
    "email" => "regan@smedia.ca",
    "password" => "bcvehiclefinanceca",
    "no_adv" => true,
    "log" => false,
    "combined_feed_mode" => true,
    'max_cost' => 1500,
    'cost_distribution' => array(
        'new' => 750,
        'used' => 750,
),
);

$CronConfigs["beancars"] = array(
    'password' => 'beancars',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'customer_id' => '348-758-6111',
    'max_cost' => 1300,
    'cost_distribution' => array(
        'adwords' => 1300,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'banner' => array(
        'template' => 'beancars',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click for more info!',
        'fb_marketplace_description' => '[description]',
        'fb_alt_marketplace_description' => '[year] [make] [model]. Check it out today!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
),
    'lead' => null,
    'name' => 'beancars',
);

$CronConfigs["beanpartsca"] = array( 
	"name"  => "beanpartsca",
	"email" => "regan@smedia.ca",
	"password" => "beanpartsca",
	"no_adv" => true,
	"log" => false,
	"combined_feed_mode" => true,
);

$CronConfigs["beckerautoscom"] = array(
    "name" => "beckerautoscom",
    "email" => "regan@smedia.ca",
    "password" => "beckerautoscom",
    //"no_adv" => true,
    "log" => true,
    "combined_feed_mode" => true,
    'fb_title' => '[year] [make] [model] [trim]',
    'banner' => array(
        'template' => 'beckerautoscom',
        'fb_description' => 'Check out this [year] [make] [model] [trim] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 2446,
    'cost_distribution' => array(
        'new' => 1223,
        'used' => 1223,
),
);

$CronConfigs["bensonfordnet"] = array (
  'name' => 'bensonfordnet',
  'email' => 'regan@smedia.ca',
  'password' => 'bensonfordnet',
  'log' => true,
  'banner' => 
  array (
    'template' => 'bensonfordnet',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["bensonhyundaicom"] = array (
  'name' => 'bensonhyundaicom',
  'email' => 'regan@smedia.ca',
  'password' => 'bensonhyundaicom',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'bensonhyundaicom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["bigvalleyautoford"] = array(
    'password'     => 'bigvalleyautoford',
    'email'        => 'regan@smedia.ca',
    'log'          => true,
    'banner'       => array(
        'template'     => 'bigvalleyautoford',
        'flash_style'  => 'default',
        'border_color' => '#282828',
        'font_color'   => '#ffffff',
    ),
    'buttons_live' => false,
    'buttons'      => array(
        'request-a-quote' => array(
            'url-match'     => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'a.btn.btn-default.eprice.dialog.button',
            'css-class'     => 'a.btn.btn-default.eprice.dialog.button',
            'css-hover'     => 'a.btn.btn-default.eprice.dialog.button:hover',
            'sizes'         => array(
                100 => array(
                ),
            ),
            'texts'         => array(
                'request-a-quote' => array(
                    'target' => 'a.btn.btn-default.eprice.dialog.button',
                    'values' => array(
                        0  => 'Request A Quote',
                        1  => 'Get E Price Now!',
                        2  => 'Internet Price',
                        3  => 'Get your Price!',
                        4  => 'E- Price',
                        5  => 'Get Internet Price Now!',
                        6  => 'Contact Us.',
                        7  => 'Get Our Best Price',
                        8  => 'Best Price',
                        9  => 'Contact Us',
                        10 => 'Contact Store',
                        11 => 'Local Pricing',
                        12 => 'Special Pricing!',
                        13 => 'Get More Information',
                        14 => 'Ask a Question',
                        15 => 'Inquire Now',
                        16 => 'Get Active Market Price',
                        17 => 'Get Market Price',
                        18 => 'Market Pricing',
                    ),
                ),
            ),
            'styles'        => array(
                'orange' => array(
                    'normal' => array(
                        'background'   => '#f06b20',
                        'border-color' => '#f06b20',
                    ),
                    'hover'  => array(
                        'background'   => '#cf540e',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red'    => array(
                    'normal' => array(
                        'background'   => '#e01212',
                        'border-color' => '#e01212',
                    ),
                    'hover'  => array(
                        'background'   => '#c60c0d',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green'  => array(
                    'normal' => array(
                        'background'   => '#54b740',
                        'border-color' => '#54b740',
                    ),
                    'hover'  => array(
                        'background'   => '#359d22',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue'   => array(
                    'normal' => array(
                        'background'   => '#1ca0d1',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover'  => array(
                        'background'   => '#188bb7',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ),
        'test-drive'      => array(
            'url-match'     => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'a.btn.btn-success.dialog.btn-block.btn-lg',
            'css-class'     => 'a.btn.btn-success.dialog.btn-block.btn-lg',
            'css-hover'     => 'a.btn.btn-success.dialog.btn-block.btn-lg:hover',
            'sizes'         => array(
                100 => array(
                ),
            ),
            'texts'         => array(
                'test-drive' => array(
                    'target' => 'a.btn.btn-success.dialog.btn-block.btn-lg',
                    'values' => array(
                        0 => 'Test drive',
                        1 => 'Book Test Drive',
                        2 => 'Schedule Test Drive',
                        3 => 'Test Drive Now',
                        4 => 'Test Drive today',
                    ),
                ),
            ),
            'styles'        => array(
                'orange' => array(
                    'normal' => array(
                        'background'   => '#f06b20',
                        'border-color' => '#f06b20',
                    ),
                    'hover'  => array(
                        'background'   => '#cf540e',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red'    => array(
                    'normal' => array(
                        'background'   => '#e01212',
                        'border-color' => '#e01212',
                    ),
                    'hover'  => array(
                        'background'   => '#c60c0d',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green'  => array(
                    'normal' => array(
                        'background'   => '#54b740',
                        'border-color' => '#54b740',
                    ),
                    'hover'  => array(
                        'background'   => '#359d22',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue'   => array(
                    'normal' => array(
                        'background'   => '#1ca0d1',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover'  => array(
                        'background'   => '#188bb7',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ),
    ),
    'name'         => 'bigvalleyautoford',
);

$CronConfigs["billalexanderford"] = array(
    'name' => 'billalexanderford',
    'email' => 'regan@smedia.ca',
    'password' => 'billalexanderford',
    'log' => true,
    'banner' => array(
        'template' => 'billalexanderford',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0D65BF',
            '#0D65BF',
),
        'button_color_hover' => array(
            '#0B55A6',
            '#0B55A6',
),
        'button_color_active' => array(
            '#0D65BF',
            '#0D65BF',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'We\'ll Buy Your Car!!',
        'response_email' => 'Hello [name],<p> Thank you for filling up for the form. Our product specialist will get in touch with you soon.</p><br><img src=\\"[image]\\"/><p><br><br>Bill Alexander Ford Team',
        'forward_to' => array(
            'edawson@billalexanderford.com',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
);

$CronConfigs["bmwlavalcom"] = array (
  'name' => 'bmwlavalcom',
  'email' => 'regan@smedia.ca',
  'password' => 'bmwlavalcom',
  'log' => true,
);

$CronConfigs["bmwmcseattlecom"] = array(
    'name' => 'bmwmcseattlecom',
    'email' => 'regan@smedia.ca',
    'password' => 'bmwmcseattlecom',
    'log' => true,
    'combined_feed_mode' => true,
    'customer_id' => '198-780-4246',
    'max_cost' => 1240,
    'cost_distribution' => array(
        'adwords' => 1240,
),
    "banner" => array(
        "template" => "bmwmcseattlecom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);

$CronConfigs["bmwmonctoncom"] = array (
  'name' => 'bmwmonctoncom',
  'email' => 'regan@smedia.ca',
  'password' => 'bmwmonctoncom',
  'log' => true,
);

$CronConfigs["bmwmontrealcentreca"] = array(
  'name'     => 'bmwmontrealcentreca',
  'email'    => 'regan@smedia.ca',
  'password' => 'bmwmontrealcentreca',
  'log'      => true,
  'lead'     => array(
    'live'                   => true,
    'lead_type_'             => true,
    'lead_type_new'          => true,
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
    'sent_client_email'      => false,
    'offer_minimum_price'    => 0,
    'offer_maximum_price'    => 10000000,
    'bg_color'               => '#EFEFEF',
    'text_color'             => '#404450',
    'border_color'           => '#E5E5E5',
    'button_color'           => array(
      '#018BD3',
      '#018BD3',
    ),
    'button_color_hover'     => array(
      '#1C69D4',
      '#1C69D4',
    ),
    'button_color_active'    => array(
      '#1C69D4',
      '#1C69D4',
    ),
    'button_text_color'      => '#FFFFFF',
    'response_email_subject' => '$500 off coupon from BMW Canbec',
    'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>BMW Canbec Team',
    'forward_to'             => array(
      'marshal@smedia.ca',
    ),
    'special_to'             => array(
      'smedia-bmwcanbec@leadactivix.ca',
      'adf_to@smedia.ca',
    ),
    'special_email'          => '<?xml version="1.0"?>
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
              <vendorname>BMW Canbec</vendorname>
              <contact>
                <name part="full">BMW Canbec</name>
                <email>[dealer_email]</email>
              </contact>
            </vendor>
            <provider>
              <name part="full">sMedia Coupon</name>
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
      'vdp'           => '/\\/(?:new|used|occasion|neufs)\\/.*[0-9]{4}-/i',
      'service_regex' => '',
    ),
    'provider_name'          => 'sMedia Coupon',
  ),
);

$CronConfigs["bmwmontrealcentreca_fr"] = array (
  'name' => 'bmwmontrealcentreca_fr',
  'email' => 'regan@smedia.ca',
  'password' => 'bmwmontrealcentreca_fr',
  'no_adv' => true,
);

$CronConfigs["bmwnorthwest"] = array(
    'password' => 'bmwnorthwest',
    'email' => 'regan@smedia.ca',
    'log' => true,
    "customer_id" => "512-824-2115",
    "log" => true,
    'bing_account_id' => 156003207,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'max_cost' => 6900,
    'cost_distribution' => array(
        'adwords' => 6900,
),
    'new_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
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
    'banner' => array(
        'template' => 'bmwnorthwest',
        'old_price' => 'msrp',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today. Click for more information.',
        'fb_description_2018_bmw' => 'Our 2018\'s need to go so we\'ve priced them to move! Below you will find BMW\'s we think you\'d be interested in with some up to $19,000 off MSRP. Shop below before they are gone!',
        'fb_description_x5' => 'Confidence Never Detours. The leader. The style maker. The benchmark. This is the All-New BMW X5. Shop below.',
        'fb_description_330i' => 'Lower, sleeker, and perched on a wider stance, the striking presence of the All-New BMW 3 Series presents a new standard for the modern sports sedan. Shop below.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'adf_to' => array(
        0 => 'bmwnw@eleadtrack.net',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[data-href*=eprice].btn',
            'css-class' => 'a[data-href*=eprice].btn',
            'css-hover' => 'a[data-href*=eprice].btn:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[data-href*=eprice].btn',
                    'values' => array(
                        0 => 'Request A Quote',
                        1 => 'Get E Price Now!',
                        2 => 'Internet Price',
                        3 => 'Get Internet Price Now!',
                        4 => 'Get Our Best Price',
                        5 => 'Best Price',
                        6 => 'Local Pricing',
                        7 => 'Special Pricing!',
                        8 => 'Get More Information',
                        9 => 'Get Market Price',
                        10 => 'Check Availability',
                        11 => 'Get Special Price!',
                        12 => 'SPECIAL PRICING!',
                        13 => 'Confirm Availability',
),
),
),
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
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[data-href*=schedule].btn',
            'css-class' => 'a[data-href*=schedule].btn',
            'css-hover' => 'a[data-href*=schedule].btn:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a[data-href*=schedule].btn',
                    'values' => array(
                        0 => 'Test drive',
                        1 => 'Book Test Drive',
                        2 => 'Book My Test Drive',
),
),
),
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
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'li a[href*=financing].btn',
            'css-class' => 'li a[href*=financing].btn',
            'css-hover' => 'li a[href*=financing].btn:hover',
            'button_action' => array(
                0 => 'form',
                1 => 'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'li a[href*=financing].btn',
                    'values' => array(
                        0 => 'No hassle financing',
                        1 => 'Explore Payments',
                        2 => 'Special Finance Offers!',
),
),
),
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
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17719',
        'promotion_text' => 'VISIT US TODAY!',
        'promotion_color' => '#3B6BB3',
        'overlay_color' => '#3B6BB3',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#3B6BB3',
        'coupon_validity' => '30',
),
    'name' => 'bmwnorthwest',
);

$CronConfigs["bobrohrmanschaumburgford"] = array(
    'name' => 'bobrohrmanschaumburgford',
    'email' => 'regan@smedia.ca',
    'password' => 'bobrohrmanschaumburgford',
    'max_cost' => 1244,
    'cost_distribution' => array(
        'adwords' => 1244,
),
    'customer_id' => '609-509-5046',
    'combined_feed_mode' => true,
    'log' => true,
    'fb_title' => '[make] [model] [trim] [price]',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'bobrohrmanschaumburgford',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
);

$CronConfigs["bobschwartzchryslerdodgejeep"] = array(
    'password' => 'bobschwartzchryslerdodgejeep',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'max_cost' => 1200.0,
    'cost_distribution' => array(
        'adwords' => 1200,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'lead' => null,
    'customer_id' => '652-735-5986',
    'banner' => array(
        'template' => 'bobschwartzchryslerdodgejeep',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click below for more info!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'lead_to' => array(
        'sarahpayne@schwartzcdj.com',
),
    'adf_to' => array(
        'leads@bobschwartzcdj.motosnap.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a.btn.eprice.dialog.epriceLink',
            'css-class' => 'a.btn.eprice.dialog.epriceLink',
            'css-hover' => 'a.btn.eprice.dialog.epriceLink:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a.btn.eprice.dialog.epriceLink',
                    'values' => array(
                        'Request A Quote',
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'E- Price',
                        'Get Internet Price Now!',
                        'Get Our Best Price',
                        'Best Price',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#f06b20',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#cf540e',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#e01212',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#c60c0d',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#54b740',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#359d22',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#1ca0d1',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#188bb7',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
),
),
        'request-information' => array(
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a.btn.price-btn.btn-block.priceButton-1',
            'css-class' => 'a.btn.price-btn.btn-block.priceButton-1',
            'css-hover' => 'a.btn.price-btn.btn-block.priceButton-1:hover',
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-information' => array(
                    'target' => 'a.btn.price-btn.btn-block.priceButton-1',
                    'values' => array(
                        'Get More Information',
                        'Request Information',
                        'Contact Us.',
                        'Contact Us',
                        'Contact Store',
                        'Book Test Drive',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#f06b20',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#cf540e',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#e01212',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#c60c0d',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#54b740',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#359d22',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#1ca0d1',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#188bb7',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a.btn.price-btn.btn-block.priceButton-2',
            'css-class' => 'a.btn.price-btn.btn-block.priceButton-2',
            'css-hover' => 'a.btn.price-btn.btn-block.priceButton-2:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'a.btn.price-btn.btn-block.priceButton-2',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Get Financed Today',
                        'Explore Payments',
                        'Get Pre-Approved',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#f06b20',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#cf540e',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#e01212',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#c60c0d',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#54b740',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#359d22',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'none',
                        'background-color' => '#1ca0d1',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'none',
                        'background-color' => '#188bb7',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '14px',
                        'font-weight' => '700',
                        'line-height' => '17px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
),
),
),
    'name' => 'bobschwartzchryslerdodgejeep',
);

$CronConfigs["bockerautogroup"] = array (
  'password' => 'bockerautogroup',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'banner' => 
  array (
    'template' => 'bockerautogroup',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'form_live' => false,
  'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
  'buttons_live' => false,
  'name' => 'bockerautogroup',
);

$CronConfigs["boeckmanford"] = array (
  'name' => 'boeckmanford',
  'email' => 'regan@smedia.ca',
  'password' => 'boeckmanford',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'banner' => 
  array (
    'template' => 'boeckmanford',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information. Stock #-[stock_number].',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information. Stock #-[stock_number].',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'lead_to' => 
  array (
    0 => 'boeckman@pldi.net',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' => 
  array (
    'request-a-quote' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.btn.btn-default.eprice.dialog.button',
      'css-class' => 'a.btn.btn-default.eprice.dialog.button',
      'css-hover' => 'a.btn.btn-default.eprice.dialog.button:hover',
      'button_action' => 
      array (
        0 => 'form',
        1 => 'e-price',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'request-a-quote' => 
        array (
          'target' => 'a.btn.btn-default.eprice.dialog.button',
          'values' => 
          array (
            0 => 'Get ePrice',
            1 => 'Get Internet Price',
            2 => 'Get Our Best Price',
            3 => 'Get Your Best Price!',
            4 => 'Get Special Price',
            5 => 'Get Your Price',
            6 => 'Confirm Availability',
            7 => 'Special Pricing!',
            8 => 'Get Our Best Price',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#1F4581,#1F4581)',
            'border-color' => '1F4581',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#193767,#193767)',
            'border-color' => '193767',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C38820,#C38820)',
            'border-color' => 'C38820',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A9761C,#A9761C)',
            'border-color' => 'A9761C',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#189138,#189138)',
            'border-color' => '189138',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#14782E,#14782E)',
            'border-color' => '14782E',
          ),
        ),
        'purple' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#BE29EC,#BE29EC)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#951DBA,#951DBA)',
            'border-color' => '951DBA',
          ),
        ),
        'platinum' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#948D7A,#948D7A)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#787263,#787263)',
            'border-color' => '951DBA',
          ),
        ),
      ),
    ),
    'financing' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.btn.btn-primary.btn-block.calculate',
      'css-class' => 'a.btn.btn-primary.btn-block.calculate',
      'css-hover' => 'a.btn.btn-primary.btn-block.calculate:hover',
      'button_action' => 
      array (
        0 => 'form',
        1 => 'finance',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'financing' => 
        array (
          'target' => 'a.btn.btn-primary.btn-block.calculate',
          'values' => 
          array (
            0 => 'Special Finance Offers!',
            1 => 'Estimate Payments',
            2 => 'Financing Options',
            3 => 'Calculate my Payments',
            4 => 'Payment options',
            5 => 'Explore Payments',
            6 => 'Financing Available',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#1F4581,#1F4581)',
            'border-color' => '1F4581',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#193767,#193767)',
            'border-color' => '193767',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C38820,#C38820)',
            'border-color' => 'C38820',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A9761C,#A9761C)',
            'border-color' => 'A9761C',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#189138,#189138)',
            'border-color' => '189138',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#14782E,#14782E)',
            'border-color' => '14782E',
          ),
        ),
        'purple' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#BE29EC,#BE29EC)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#951DBA,#951DBA)',
            'border-color' => '951DBA',
          ),
        ),
        'platinum' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#948D7A,#948D7A)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#787263,#787263)',
            'border-color' => '951DBA',
          ),
        ),
      ),
    ),
    'test-drive' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(1)',
      'css-class' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(1)',
      'css-hover' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(1):hover',
      'button_action' => 
      array (
        0 => 'form',
        1 => 'test-drive',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'test-drive' => 
        array (
          'target' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(1)',
          'values' => 
          array (
            0 => 'Schedule My Visit',
            1 => 'Request A Test Drive',
            2 => 'Want to Test Drive It?',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#1F4581,#1F4581)',
            'border-color' => '1F4581',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#193767,#193767)',
            'border-color' => '193767',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C38820,#C38820)',
            'border-color' => 'C38820',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A9761C,#A9761C)',
            'border-color' => 'A9761C',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#189138,#189138)',
            'border-color' => '189138',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#14782E,#14782E)',
            'border-color' => '14782E',
          ),
        ),
        'purple' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#BE29EC,#BE29EC)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#951DBA,#951DBA)',
            'border-color' => '951DBA',
          ),
        ),
        'platinum' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#948D7A,#948D7A)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#787263,#787263)',
            'border-color' => '951DBA',
          ),
        ),
      ),
    ),
    'request-information' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(2)',
      'css-class' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(2)',
      'css-hover' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(2):hover',
      'button_action' => 
      array (
        0 => 'form',
        1 => 'e-price',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'request-information' => 
        array (
          'target' => 'a.btn.btn-primary.dialog.btn-block.btn-lg:nth-of-type(2)',
          'values' => 
          array (
            0 => 'Get More Information',
            1 => 'More Info',
            2 => 'Ask a Question!',
            3 => 'Ask an Expert',
            4 => 'More information',
            5 => 'Get More Details',
            6 => 'Get Availability',
            7 => 'Confirm Availability',
            8 => 'Request More Info',
            9 => 'Ask for Availability',
            10 => 'Want to Learn More?',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#1F4581,#1F4581)',
            'border-color' => '1F4581',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#193767,#193767)',
            'border-color' => '193767',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C38820,#C38820)',
            'border-color' => 'C38820',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A9761C,#A9761C)',
            'border-color' => 'A9761C',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#189138,#189138)',
            'border-color' => '189138',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#14782E,#14782E)',
            'border-color' => '14782E',
          ),
        ),
        'purple' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#BE29EC,#BE29EC)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#951DBA,#951DBA)',
            'border-color' => '951DBA',
          ),
        ),
        'platinum' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#948D7A,#948D7A)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#787263,#787263)',
            'border-color' => '951DBA',
          ),
        ),
      ),
    ),
    'trade-in' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(4)',
      'css-class' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(4)',
      'css-hover' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(4):hover',
      'button_action' => 
      array (
        0 => 'form',
        1 => 'trade-in',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'trade-in' => 
        array (
          'target' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(4)',
          'values' => 
          array (
            0 => 'Trade Offer',
            1 => 'We Want Your Car',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#1F4581,#1F4581)',
            'border-color' => '1F4581',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#193767,#193767)',
            'border-color' => '193767',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C38820,#C38820)',
            'border-color' => 'C38820',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A9761C,#A9761C)',
            'border-color' => 'A9761C',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#189138,#189138)',
            'border-color' => '189138',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#14782E,#14782E)',
            'border-color' => '14782E',
          ),
        ),
        'purple' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#BE29EC,#BE29EC)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#951DBA,#951DBA)',
            'border-color' => '951DBA',
          ),
        ),
        'platinum' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#948D7A,#948D7A)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#787263,#787263)',
            'border-color' => '951DBA',
          ),
        ),
      ),
    ),
    'apply-for-credit' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(5)',
      'css-class' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(5)',
      'css-hover' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(5):hover',
      'button_action' => 
      array (
        0 => 'form',
        1 => 'e-price',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'apply-for-credit' => 
        array (
          'target' => 'a.btn.btn-primary.btn-block.btn-lg:nth-of-type(5)',
          'values' => 
          array (
            0 => 'Get Financed Today',
            1 => 'Special Finance Offers',
            2 => 'Apply for Financing',
            3 => 'Get Prequalified for Credit',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#1F4581,#1F4581)',
            'border-color' => '1F4581',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#193767,#193767)',
            'border-color' => '193767',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C38820,#C38820)',
            'border-color' => 'C38820',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A9761C,#A9761C)',
            'border-color' => 'A9761C',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#189138,#189138)',
            'border-color' => '189138',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#14782E,#14782E)',
            'border-color' => '14782E',
          ),
        ),
        'purple' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#BE29EC,#BE29EC)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#951DBA,#951DBA)',
            'border-color' => '951DBA',
          ),
        ),
        'platinum' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#948D7A,#948D7A)',
            'border-color' => 'BE29EC',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#787263,#787263)',
            'border-color' => '951DBA',
          ),
        ),
      ),
    ),
  ),
);

$CronConfigs["bonifacehierschevrolet"] = array (
  'name' => 'bonifacehierschevrolet',
  'email' => 'regan@smedia.ca',
  'password' => 'bonifacehierschevrolet',
  'log' => true,
  'banner' => 
  array (
    'template' => 'bonifacehierschevrolet',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["bonifacehierskia"] = array (
  'name' => 'bonifacehierskia',
  'email' => 'regan@smedia.ca',
  'password' => 'bonifacehierskia',
  'log' => true,
  'banner' => 
  array (
    'template' => 'bonifacehierskia',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["bonitaspringsmitsubishi"] = array (
  'name' => 'bonitaspringsmitsubishi',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'email' => 'regan@smedia.ca',
  'password' => 'bonitaspringsmitsubishi',
  'log' => true,
  'bing_account_id' => 156002960,
  'max_cost' => 0,
  'create' => 
  array (
    	"used_search" => true,
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'customer_id' => '935-051-1225',
  'banner' => 
  array (
    'template' => 'bonitaspringsmitsubishi',
    'fb_description_new' => 'Are you still interested in the [year] [make] [model]? Roadside assistance plan, 10 year/100,000 Mile limited powertrain warranty, 5 year bumper to bumper new vehicle warranty. Ask us for details!',
    'fb_description_used' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description_new' => 'Check out this [year] [make] [model] today! Roadside assistance plan, 10 year/100,000 Mile limited powertrain warranty, 5 year bumper to bumper new vehicle warranty. Ask us for details!',
    'fb_lookalike_description_used' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
  ),
  'mail_retargeting' => 
  array (
    'enabled' => true,
    'client_id' => '17567',
    'promotion_text' => 'CLAIM $200 OFF!',
    'promotion_color' => '#567DC0',
    'overlay_color' => '#CD3134',
    'overlay_text_colour' => '#FFFFFF',
    'price_color' => '#CD3134',
    'coupon_validity' => '30',
  ),
);

$CronConfigs["bowmargm"] = array(
    'name' => 'bowmargm',
    'email' => 'regan@smedia.ca',
    'password' => 'bowmargm',
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'bowmargm',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'lead_to' => array(
        'rolly.bowmar@sasktel.net',
        'bowmar@sasktel.net',
),
    'form_live' => false,
    'buttons_live' => false,
);

$CronConfigs["brantfordhonda"] = array (
  'name' => 'brantfordhonda',
  'email' => 'regan@smedia.ca',
  'password' => 'brantfordhonda',
  'log' => true,
  'fb_title' => '[year] [make] [model] [price]',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' => 
  array (
    'template' => 'brantfordhonda',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
  ),
);

$CronConfigs["brantfordhondacom"] = array( 
	"name"  => "brantfordhondacom",
	"email" => "regan@smedia.ca",
	"password" => "brantfordhondacom",
	// "no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["brewsterhondacom"] = array (
  'name' => 'brewsterhondacom',
  'email' => 'regan@smedia.ca',
  'password' => 'brewsterhondacom',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'brewsterhondacom',
    // 'fb_aia_description'       => '[description]',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["brianjesselbmw"] = array (
  'name' => 'brianjesselbmw',
  'email' => 'regan@smedia.ca',
  'password' => 'brianjesselbmw',
  'log' => true,
  'adf_to' => 
  array (
    0 => 'albuttons-smedia@brianjesselbmw-bc.net',
    1 => 'thamina.ahamed@gmail.com',
    2 => 'masterkeyy@gmail.com',
  ),
  'form_live' => false,
  'buttons_live' => false,
);

$CronConfigs["brianjesselbmwpreowned"] = array(
    'name' => 'brianjesselbmwpreowned',
    'email' => 'regan@smedia.ca',
    'password' => 'brianjesselbmwpreowned',
    'log' => true,
    'lead' => null,
    'adf_to' => array(
        'albuttons-smedia@brianjesselbmwpreowned.net',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-information' => array(
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'div.button-group a',
            'css-class' => 'div.button-group a',
            'css-hover' => 'div.button-group a:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-information' => array(
                    'target' => 'div.button-group a',
                    'values' => array(
                        'Ask a Question',
                        'Ask Our Experts',
                        'Get More Details',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
                        'color' => '#FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0653B6,#0653B6)',
                        'border-color' => '0653B6',
                        'color' => '#FFFFFF',
),
),
),
),
),
);

$CronConfigs["briantoliverford"] = array (
  'name' => 'briantoliverford',
  'email' => 'regan@smedia.ca',
  'password' => 'briantoliverford',
  'log' => true,
  'banner' => 
  array (
    'template' => 'briantoliverford',
    'fb_marketplace_description' => '[description]',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["bridgesgm"] = array(
    'name'     => 'bridgesgm',
    'email'    => 'regan@smedia.ca',
    'password' => 'bridgesgm',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log'      => true,
    'lead'     => array(
        'live'                   => true,
        'lead_type_'             => true,
        'lead_type_new'          => true,
        'lead_type_used'         => true,
        'lead_type_service'      => true,
        'shown_cap'              => false,
        'fillup_cap'             => false,
        'session_close'          => false,
        'device_type'            => array(
            'mobile'  => true,
            'desktop' => true,
            'tablet'  => true,
        ),
        'sent_client_email'      => false,
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#CC9834',
            '#CC9834',
        ),
        'button_color_hover'     => array(
            '#343434',
            '#343434',
        ),
        'button_color_active'    => array(
            '#343434',
            '#343434',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Get $200 off! coupon from Bridges GM',
        'response_email'         => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bridges GM Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
            'emil@smedia.ca',
        ),
        'special_to'             => array(
            'leads@bridgesgm.motosnap.com',
            'adf_to@smedia.ca',
        ),
        'special_email'          => '<?xml version="1.0"?>
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
                        <vendorname>Bridges GM</vendorname>
                        <contact>
                            <name part="full">Bridges GM</name>
                            <email>[dealer_email]</email>
                        </contact>
                    </vendor>
                    <provider>
                        <name part="full">sMedia Coupon</name>
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
            'vdp'           => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/',
            'service_regex' => '',
        ),
        'provider_name'          => 'sMedia Coupon',
    ),
    'banner'   => array(
        'template'                   => 'bridgesgm',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Test drive the [year] [make] [model] today!',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.',
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
    ),
);

$CronConfigs["brodheadsvillechevy"] = array(
    'name' => 'brodheadsvillechevy',
    'email' => 'regan@smedia.ca',
    'password' => 'brodheadsvillechevy',
    'log' => true,
    'banner' => array(
        'template' => 'brodheadsvillechevy',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Shop Online and Take Delivery at Home!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]. Shop Online and Take Delivery at Home!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'adf_to' => array(
        'sales@brodheadsvillechevrolet.edealerhub.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/VehicleDetails\\/(?:new|used)-[0-9]{4}/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-class' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
            'css-hover' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
                    'values' => array(
                        'Get a Quote',
                        'Request a Quote',
                        'Inquire Today',
                        'Inquire Now',
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Sale Price',
                        'Get Our Best Price',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E6A42D,#E6A42D)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C78D25,#C78D25)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#7E110A,#7E110A)',
                        'border-color' => 'C60C0D',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0669B2,#0669B2)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#055895,#055895)',
                        'border-color' => 'C60C0D',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#676B70,#676B70)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4D5054,#4D5054)',
                        'border-color' => 'C60C0D',
),
),
),
),
        'request-information' => array(
            'url-match' => '/\\/VehicleDetails\\/(?:new|used)-[0-9]{4}/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-class' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
            'css-hover' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-information' => array(
                    'target' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
                    'values' => array(
                        'Get Price Alerts',
                        'Watch Price',
                        'Watch This Price',
                        'Follow Price',
                        'Follow This Price',
                        'Track Price',
                        'Track This Price',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E6A42D,#E6A42D)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C78D25,#C78D25)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#7E110A,#7E110A)',
                        'border-color' => 'C60C0D',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0669B2,#0669B2)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#055895,#055895)',
                        'border-color' => 'C60C0D',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#676B70,#676B70)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4D5054,#4D5054)',
                        'border-color' => 'C60C0D',
),
),
),
),
),
    'max_cost' => 0,
    'cost_distribution' => array(
        'dynamic' => 0,
),
);

$CronConfigs["brogdenbuickgmccadillaccom"] = array (
  'name' => 'brogdenbuickgmccadillaccom',
  'email' => 'regan@smedia.ca',
  'password' => 'brogdenbuickgmccadillaccom',
  'combined_feed_mode' => true,
  'log' => true,
  'customer_id' => '602-453-5423',
  'max_cost' => 0,
  'cost_distribution' => 
  array (
    'adwords' => 0,
  ),
  'banner' => 
  array (
    'template' => 'brogdenbuickgmccadillaccom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["brownschev"] = array(
    'name' => 'brownschev',
    'email' => 'regan@smedia.ca',
    'password' => 'brownschev',
    'log' => true,
    'customer_id' => '416-405-1294',
    'max_cost' => 780,
    'cost_distribution' => array(
        'adwords' => 780,
),
    'banner' => array(
        'template' => 'brownschev',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim]! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
);

$CronConfigs["budgetautocentrecom"] = array (
  'name' => 'budgetautocentrecom',
  'email' => 'regan@smedia.ca',
  'password' => 'budgetautocentrecom',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'budgetautocentrecom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["buerkleacuracom"] = array (
  'name' => 'buerkleacuracom',
  'email' => 'regan@smedia.ca',
  'password' => 'buerkleacuracom',
  'log' => true,
  'banner' => 
  array (
    'template' => 'buerkleacuracom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["cadillackelownacom"] = array(
    'name' => 'cadillackelownacom',
    'email' => 'regan@smedia.ca',
    'password' => 'cadillackelownacom',
    'log' => true,
    'combined_feed_mode' => true,
    'customer_id' => '593-029-4452',
    'max_cost' => 3129,
    'cost_distribution' => array(
        'adwords' => 3129,
),
    'banner' => array(
        'template' => 'cadillackelownacom',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click to learn more.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today. Click for further information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
);

$CronConfigs["cambrianford"] = array (
  'name' => 'cambrianford',
  'email' => 'regan@smedia.ca',
  'password' => 'cambrianford',
  'log' => true,
  'banner' => 
  array (
    'template' => 'cambrianford',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["cambridgehyundaicom"] = array(
    'name'               => 'cambridgehyundaicom',
    'email'              => 'regan@smedia.ca',
    'password'           => 'cambridgehyundaicom',
    'log'                => true,
    'combined_feed_mode' => true,
    'lead'               => array(
        'live'                   => true,
        'lead_type_'             => true,
        'lead_type_new'          => true,
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
        'sent_client_email'      => false,
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#0A2972',
            '#0A2972',
        ),
        'button_color_hover'     => array(
            '#000000',
            '#000000',
        ),
        'button_color_active'    => array(
            '#25448D',
            '#25448D',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Claim $200 Off with a purchase from Cambridge Hyundai',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Cambridge Hyundai Team',
        'forward_to'             => array(
            '',
        ),
        'special_to'             => array(
            'leads@Cambridgehyundai.motosnap.com',
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
            'vdp'           => '/\\/vehicles\\/[0-9]{4}\\//',
            'service_regex' => '',
        ),
        'custom_div'             => '',
    ),
);

$CronConfigs["camclarkfordreddeercom"] = array (
  'name' => 'camclarkfordreddeercom',
  'email' => 'regan@smedia.ca',
  'password' => 'camclarkfordreddeercom',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'camclarkfordreddeercom',
    'fb_description' => 'Are you still interested in the [year] [make] [model] [trim] Stock #: [stock_number]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] Stock #: [stock_number] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["campbellrivertoyota"] = array(
    'name' => 'campbellrivertoyota',
    'email' => 'regan@smedia.ca',
    'password' => 'campbellrivertoyota',
    'log' => true,
    'banner' => array(
        'template' => 'campbellrivertoyota',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 2450,
    'cost_distribution' => array(
        'adwords' => 2450,
),
);

$CronConfigs["campkins"] = array(
    'bid' => 3.0,
    'password' => 'campkins',
    'post_code' => 'L0B 1A0',
    'log' => true,
    'customer_id' => '136-113-8695',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'campkins',
        'flash_style' => 'default',
        'fb_description' => 'Are you still interested in the [make] [model]? Click for more info.',
        'fb_lookalike_description' => 'Check out the [make] [model] today! Click for details.',
        'fb_dynamiclead_description' => 'Are you still interested in the [make] [model]? Click below, fill in your info to get an additional $100 store credit, and a product specialist will be in touch to aid in any questions',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => array(
        'new' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => true,
            'lead_type_used' => false,
            'lead_type_service' => false,
            'shown_cap' => true,
            'fillup_cap' => true,
            'session_close' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => true,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#FB5523',
                '#FB5523',
),
            'button_color_hover' => array(
                '#FF7036',
                '#FF7036',
),
            'button_color_active' => array(
                '#FB5523',
                '#FB5523',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => 'Your offer from Campkin\'s RV Centre',
            'response_email' => 'Hello [name],<p> Thanks for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Campkin\'s Team',
            'forward_to' => array(
                'sales@campkins.com',
                'marshal@smedia.ca',
),
            'special_to' => array(
                '',
),
            'special_email' => '',
            'display_after' => 30000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/\\/rv-inventory\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
                'service_regex' => '',
),
            'custom_div' => '',
),
),
    'max_cost' => 0,
    'cost_distribution' => array(),
    'name' => 'campkins',
);

$CronConfigs["camrosechryslercom"] = array(
    "name" => "camrosechryslercom",
    "email" => "regan@smedia.ca",
    "password" => "camrosechryslercom",
    // "no_adv" => true,
    "log" => true,
    "combined_feed_mode" => true,
    'max_cost' => 800,
    'cost_distribution' => array(
        'new' => 400,
        'used' => 400,
),
);

$CronConfigs["canadacarapprovals"] = array (
  'name' => 'canadacarapprovals',
  'email' => 'regan@smedia.ca',
  'password' => 'canadacarapprovals',
  'log' => true,
);

$CronConfigs["cansofordca"] = array(
    "name" => "cansofordca",
    "email" => "regan@smedia.ca",
    "password" => "cansofordca",
    //"no_adv" => true,
    "log" => true,
    "combined_feed_mode" => true,
    "banner" => array(
        "template" => "cansofordca",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
       // 'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 500,
    'cost_distribution' => array(
        'new' => 250,
        'used' => 250,
),
);

$CronConfigs["capitalautoorg"] = array (
  'name' => 'capitalautoorg',
  'email' => 'regan@smedia.ca',
  'password' => 'capitalautoorg',
  'log' => true,
);

$CronConfigs["capitalfordlincoln"] = array (
  'name' => 'capitalfordlincoln',
  'email' => 'regan@smedia.ca',
  'password' => 'capitalfordlincoln',
  'log' => true,
);

$CronConfigs["capitaljeepcom"] = array(
    'name' => 'capitaljeepcom',
    'email' => 'regan@smedia.ca',
    'password' => 'capitaljeepcom',
    'log' => true,
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "capitaljeepcom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'lead' => array(
        'new' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => true,
            'lead_type_used' => true,
            'lead_type_service' => false,
            'shown_cap' => false,
            'fillup_cap' => false,
            'session_close' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => false,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#BD1F1B',
                '#BD1F1B',
),
            'button_color_hover' => array(
                '#A90B07',
                '#A90B07',
),
            'button_color_active' => array(
                '#D83A36',
                '#D83A36',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => 'Claim $500 Off with purchase from Capital CDJR',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Capital CDJR Team',
            'forward_to' => array(
                '',
),
            'special_to' => array(
                'leads@capitalchryslerjeepdodge.motosnap.com',
                'tamissy13@gmail.com',
),
            'special_email' => '',
            'display_after' => 10000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
                'service_regex' => '',
),
            'custom_div' => '',
),
        'used' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => false,
            'lead_type_used' => true,
            'lead_type_service' => false,
            'shown_cap' => false,
            'fillup_cap' => false,
            'session_close' => false,
            'inactivity' => true,
            'exit_intent' => true,
            'session_depth' => false,
            'campaign_cap_google' => false,
            'campaign_cap_fb' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => false,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#BD1F1B',
                '#BD1F1B',
),
            'button_color_hover' => array(
                '#A90B07',
                '#A90B07',
),
            'button_color_active' => array(
                '#D83A36',
                '#D83A36',
),
            'button_text_color' => '#FFFFFF',
            'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
            'response_email_subject' => 'Claim $500 Off with purchase from Capital CDJR',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Capital CDJR Team',
            'forward_to' => array(
                '',
),
            'special_to' => array(
                'leads@capitalchryslerjeepdodge.motosnap.com',
                'tamissy13@gmail.com',
),
            'special_email' => '',
            'display_after' => 10000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'shown_cap_count' => 1,
            'fillup_cap_time_days' => 7,
            'session_close_cap' => 3,
            'inactivity_timeout' => 600000,
            'exit_intent_timeout' => 10000,
            'session_depth_page' => 0,
            'campaign_google_cap_count' => 3,
            'campaign_google_cap_days' => 7,
            'campaign_fb_cap_count' => 3,
            'campaign_fb_cap_days' => 7,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
                'service_regex' => '',
),
            'custom_div' => '',
            'provider_name' => 'sMedia',
            'source' => 'sMedia smartoffer',
),
),
);

$CronConfigs["carefreervca"] = array(
    "name" => "carefreervca",
    "email" => "regan@smedia.ca",
    "password" => "carefreervca",
    'customer_id' => '696-080-0582',
    'bing_account_id' => 156004865,
    'fb_brand' => '[year] [make] [model] [trim]',
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
    "log" => true,
    "combined_feed_mode" => true,
    "banner" => array(
        "template" => "carefreervca",
        "fb_banner_title" => '[year] [make] [model] [trim]',
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);

$CronConfigs["carimex"] = array(
    'name' => 'carimex',
    'email' => 'regan@smedia.ca',
    'password' => 'carimex',
    'log' => true,
    'banner' => array(
        'template' => 'carimex',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => false,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#CC2229',
            '#CC2229',
),
        'button_color_hover' => array(
            '#303132',
            '#303132',
),
        'button_color_active' => array(
            '#CC2229',
            '#CC2229',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'We\'ll Buy Your Vehicle',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\\"[image]\\"/><p><br><br>Carimex Auto Sales Team',
        'forward_to' => array(
            'sales@carimex.ca',
),
        'special_to' => array(
            'adf_to@smedia.ca',
            'sales@carimex.ca',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/vehicle\\/[0-9]{4}-/i',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
);

$CronConfigs["carlsbadlandrover"] = array (
  'name' => 'carlsbadlandrover',
  'email' => 'regan@smedia.ca',
  'password' => 'carlsbadlandrover',
  'log' => true,
  'banner' => 
  array (
    'template' => 'carlsbadlandrover',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["carltoncarco"] = array(
    'name' => 'carltoncarco',
    'email' => 'regan@smedia.ca',
    'password' => 'carltoncarco',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
    'create' => array(),
    'new_title2' => 'See Inventory, Prices & Offers',
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '804-493-9523',
    'banner' => array(
        'template' => 'carltoncarco',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
),
    'lead' => null,
);

$CronConfigs["carlylegm"] = array(
    'name' => 'carlylegm',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'password' => 'carlylegm',
    'log' => true,
    'customer_id' => '196-215-8837',
    'max_cost' => 300,
    'cost_distribution' => array(
        'adwords' => 300,
),
    'combined_feed_mode' => true,
    'lead' => null,
    'fb_title' => '[year] [make] [model] [price]',
    'banner' => array(
        'template' => 'dealership',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
);

$CronConfigs["carriagekiawoodstock"] = array(
    'name' => 'carriagekiawoodstock',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'email' => 'regan@smedia.ca',
    'password' => 'carriagekiawoodstock',
    'customer_id' => '175-014-2242',
    'log' => true,
    'max_cost' => 5120,
    'cost_distribution' => array(
        'adwords' => 5120,
),
    'banner' => array(
        'template' => 'carriagekiawoodstock',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17944',
        'promotion_text' => 'Call Us Today! 678.717.4012',
        'promotion_color' => '#C32032',
        'overlay_color' => '#C32032',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#C32032',
        'coupon_validity' => '30',
),
);

$CronConfigs["carriageusedcarscom"] = array(
    "name" => "carriageusedcarscom",
    "email" => "regan@smedia.ca",
    "password" => "carriageusedcarscom",
    //"no_adv" => true,
    "log" => true,
    "combined_feed_mode" => true,
    'max_cost' => 2430,
    'cost_distribution' => array(
        'adwords' => 2430,
),
    "banner" => array(
        "template" => "carriageusedcarscom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);

$CronConfigs["carsforsalecom"] = array(
    "name" => "carsforsalecom",
    "email" => "regan@smedia.ca",
    "password" => "carsforsalecom",
    "log" => true,
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "carsforsalecom",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => null,
);

$CronConfigs["carsonpassrvcom"] = array(
    "name" => "carsonpassrvcom",
    "email" => "regan@smedia.ca",
    "password" => "carsonpassrvcom",
    "log" => true,
    "combined_feed_mode" => true,
    "banner" => array(
        "template" => "carsonpassrvcom",
        "fb_description" => "Are you still interested in this [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 1250,
    'cost_distribution' => array(
        'new' => 625,
        'used' => 625,
),
);

$CronConfigs["cartercadillacbccom"] = array(
    'name' => 'cartercadillacbccom',
    'email' => 'regan@smedia.ca',
    'password' => 'cartercadillacbccom',
    'log' => true,
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'cartercadillacbccom',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click to learn more.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Test drive this [year] [make] [model] [trim] today. Click for further information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 5600,
    'cost_distribution' => array(
        'new' => 5600,
        'used' => 0,
),
);

$CronConfigs["cartergm"] = array(
    'name' => 'cartergm',
    'email' => 'regan@smedia.ca',
    'password' => 'cartergm',
    'log' => true,
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'cartergm',
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click to learn more.',
        'fb_lookalike_description' => 'Test drive this [year] [make] [model] [trim] at Carter GM Burnaby. Click for further information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click below and fill in your information - a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => 'ffffff',
),
    'max_cost' => 2500,
    'cost_distribution' => array(
        'new' => 1500,
        'used' => 1000,
),
);

$CronConfigs["carternorthshore"] = array(
    'name' => 'carternorthshore',
    'email' => 'regan@smedia.ca',
    'password' => 'carternorthshore',
    'log' => true,
    'banner' => array(
        'template' => 'carternorthshore',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'combined_feed_mode' => true,
    'max_cost' => 1500,
    'cost_distribution' => array(
        'new' => 1500,
        'used' => 0,
),
);

$CronConfigs["ccnorthwestcom"] = array(
    'name' => 'ccnorthwestcom',
    'email' => 'regan@smedia.ca',
    'password' => 'ccnorthwestcom',
    'log' => true,
    'max_cost' => 1400,
    'cost_distribution' => array(
        'adwords' => 1400,
),
);

$CronConfigs["centennialautogroup"] = array (
  'name' => 'centennialautogroup',
  'email' => 'regan@smedia.ca',
  'password' => 'centennialautogroup',
  'log' => true,
);

$CronConfigs["centennialcertified"] = array (
  'name' => 'centennialcertified',
  'email' => 'regan@smedia.ca',
  'password' => 'centennialcertified',
  'log' => true,
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' => 
  array (
    'template' => 'dealership',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["centennialhonda"] = array (
  'name' => 'centennialhonda',
  'email' => 'regan@smedia.ca',
  'bing_account_id' => 156003557,
  'password' => 'centennialhonda',
  'create' => 
  array (
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'banner' => 
  array (
    'template' => 'centennialhonda',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["centennialkia"] = array (
  'name' => 'centennialkia',
  'email' => 'regan@smedia.ca',
  'password' => 'centennialkia',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'bing_account_id' => 156003558,
  'customer_id' => NULL,
  'create' => 
  array (
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'banner' => 
  array (
    'template' => 'centennialkia',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["centennialmazda"] = array (
  'name' => 'centennialmazda',
  'email' => 'regan@smedia.ca',
  'password' => 'centennialmazda',
  'log' => true,
  'bing_account_id' => 156003554,
  'create' => 
  array (
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'banner' => 
  array (
    'template' => 'dealership',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["centennialnissanofcharlottetown"] = array (
  'name' => 'centennialnissanofcharlottetown',
  'email' => 'regan@smedia.ca',
  'password' => 'centennialnissanofcharlottetown',
  'log' => true,
  'bing_account_id' => 156003555,
  'create' => 
  array (
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' => 
  array (
    'template' => 'dealership',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["centennialnissanofsummerside"] = array (
  'name' => 'centennialnissanofsummerside',
  'email' => 'regan@smedia.ca',
  'password' => 'centennialnissanofsummerside',
  'log' => true,
  'bing_account_id' => '156003559',
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'banner' => 
  array (
    'template' => 'dealership',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["centerlineauto"] = array(
    'name' => 'centerlineauto',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'password' => 'centerlineauto',
    'bing_account_id' => 156004845,
    'log' => true,
    'max_cost' => 700,
    'cost_distribution' => array(
        'adwords' => 700,
),
    'create' => array(),
    'new_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
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
    'customer_id' => '593-369-1503',
    'fb_title' => '[year] [make] [model]',
    'banner' => array(
        'template' => 'Centerline RV',
        'fb_retargeting_description' => 'Are you still interested in the [year] [make] [model] ? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
),
);

$CronConfigs["centurybuickgmc"] = array (
  'password' => 'centurybuickgmc',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'centurybuickgmc',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'buttons_live' => false,
  'name' => 'centurybuickgmc',
);

$CronConfigs["champaignchryslerdodgejeep"] = array(
    'name' => 'champaignchryslerdodgejeep',
    'email' => 'regan@smedia.ca',
    'password' => 'champaignchryslerdodgejeep',
    'log' => true,
    'banner' => array(
        'template' => 'champaignchryslerdodgejeep',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'adf_to' => array(),
    'form_live' => false,
    'buttons_live' => false,
);

$CronConfigs["championshippowersportscom"] = array (
  'name' => 'championshippowersportscom',
  'email' => 'regan@smedia.ca',
  'password' => 'championshippowersportscom',
  'log' => true,
);

$CronConfigs["chevroletofalbertlea"] = array (
  'name' => 'chevroletofalbertlea',
  'email' => 'regan@smedia.ca',
  'password' => 'chevroletofalbertlea',
  'log' => true,
  'banner' => 
  array (
    'template' => 'dealership',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["chilliwackvw"] = array(
    'name'              => 'chilliwackvw',
    'email'             => 'regan@smedia.ca',
    'password'          => 'chilliwackvw',
    'log'               => true,
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    'max_cost'          => 250,
    'cost_distribution' => array(
        'adwords' => 250,
    ),
    'create'            => array(),
    'new_descs'         => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'used_descs'        => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'banner'            => array(
        'template'                   => 'chilliwackvw',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'styels'                     => array(
            'new_display'       => 'dynamic_banner',
            'used_display'      => 'dynamic_banner',
            'new_retargeting'   => 'dynamic_banner',
            'used_retargeting'  => 'dynamic_banner',
            'new_marketbuyers'  => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
        ),
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
    ),
    'lead'              => array(
        'live'                   => true,
        'lead_type_'             => true,
        'lead_type_new'          => true,
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
        'sent_client_email'      => false,
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#0070BB',
            '#0070BB',
        ),
        'button_color_hover'     => array(
            '#003D66',
            '#003D66',
        ),
        'button_color_active'    => array(
            '#003D66',
            '#003D66',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Chilliwack Volkswagen',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Chilliwack Volkswagen Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'leads@chilliwackvw.motosnap.com',
            'adf_to@smedia.ca',
            'chilliwack@matador.ai',
        ),
        'special_email'          => '<?xml version="1.0"?>
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
                    <vendorname>Chilliwack Volkswagen</vendorname>
                    <contact>
                        <name part="full">Chilliwack Volkswagen</name>
                        <email>[dealer_email]</email>
                    </contact>
                </vendor>
                <provider>
                    <name part="full">sMedia Coupon</name>
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
            'vdp'           => '/\\/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
            'service_regex' => '',
        ),
        'provider_name'          => 'sMedia Coupon',
    ),
);

$CronConfigs["cittecenter"] = array(
    'name' => 'cittecenter',
    'email' => 'regan@smedia.ca',
    'password' => 'cittecenter',
    'log' => true,
    'customer_id' => '951-934-7100',
    'max_cost' => 800,
    'cost_distribution' => array(
        'adwords' => 800,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'banner' => array(
        'template' => 'cittecenter',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
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
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#efefef',
        'text_color' => '#404450',
        'border_color' => '#e5e5e5',
        'button_color' => array(
            '#1e4387',
            '#1e4387',
),
        'button_color_hover' => array(
            '#1a3972',
            '#1a3972',
),
        'button_color_active' => array(
            '#1a3972',
            '#1a3972',
),
        'button_text_color' => '#ffffff',
        'response_email_subject' => '$250 offer from Citte Center',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Citte Center Team',
        'forward_to' => array(
            'cittecenter@comcast.net',
            'marshal@smedia.ca',
),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'lead_in' => array(
            'vdp' => '/\\/vdp\\/[0-9].*\\//i',
            'service_regex' => '',
),
),
);

$CronConfigs["clawsonhondacom"] = array( 
	"name"  => "clawsonhondacom",
	"email" => "regan@smedia.ca",
	"password" => "clawsonhondacom",
	"log" => true,
	'combined_feed_mode' => true,
);

$CronConfigs["coastchryslernorthvanca"] = array(
    "name" => "coastchryslernorthvanca",
    "email" => "regan@smedia.ca",
    "password" => "coastchryslernorthvanca",
    "log" => true,
    "combined_feed_mode" => true,
    "customer_id" => "701-871-3376",
    'max_cost' => 1500,
    'cost_distribution' => array(
        'adwords' => 1500,
),
    "banner" => array(
        "template" => "coastchryslernorthvanca",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
);

$CronConfigs["coastmountaingm"] = array(
    'password' => 'coastmountaingm',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'lead' => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#4E8AA4',
            '#4E8AA4',
),
        'button_color_hover' => array(
            '#3E6D81',
            '#3E6D81',
),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'Get $500 OFF from Coast Mountain GM',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Coast Mountain GM Team',
        'forward_to' => array(
            'cameron@coastmountaingm.com',
            'sinead@coastmountaingm.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
        'button_text' => 'submit',
),
    'banner' => array(
        'template' => 'coastmountaingm',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'name' => 'coastmountaingm',
);

$CronConfigs["cochranenissancom"] = array(
    'name' => 'cochranenissancom',
    'email' => 'regan@smedia.ca',
    'password' => 'cochranenissancom',
    'log' => true,
    'max_cost' => 0.1,
    'customer_id' => '217-451-6845',
    'create' => array(
        'new_search' => true,
        'used_search' => true,
        'new_placement' => true,
        'used_placement' => true,
        'new_display' => true,
        'used_display' => true,
        'new_retargeting' => true,
        'used_retargeting' => true,
        'new_marketbuyers' => false,
        'used_marketbuyers' => false,
        'new_combined' => true,
        'used_combined' => true,
),
    'new_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
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
    'banner' => array(
        'template' => 'cochranenissancom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#C51734',
            '#C51734',
),
        'button_color_hover' => array(
            '#821023',
            '#821023',
),
        'button_color_active' => array(
            '#C51734',
            '#C51734',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'We Will Buy Your Car - even if you don\'t buy ours!',
        'response_email' => 'Hello [name],<p> Thank you for filling out the form. Our product specialist will contact you soon.</p><br><img src=\\"[image]\\"/><p><br><br>Cochrane Nissan Team',
        'forward_to' => array(
            'dbeaulieu@cochranenissan.com',
            'gminhas@cochranenissan.com',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/inventory\\//i',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
        'button_text' => 'submit',
),
);

$CronConfigs["collegeparkgm"] = array(
    'name' => 'collegeparkgm',
    'email' => 'regan@smedia.ca',
    'password' => 'collegeparkgm',
    'log' => true,
    'banner' => array(
        'template' => 'collegeparkgm',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
);

$CronConfigs["colonychevgmcbuick"] = array(
    'name' => 'colonychevgmcbuick',
    'email' => 'regan@smedia.ca',
    'password' => 'colonychevgmcbuick',
    'log' => true,
    'banner' => array(
        'template' => 'colonychevgmcbuick',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_marketplace_description' => '[description]',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'lead_to' => array(
        'kevin@colonychevgmcbuick.com',
        'jerry@colonychevgmcbuick.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        //Check Availability//
        'request-a-quote' => array(
            'url-match' => '/\/inventory\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href*="#modal__gform_10"]',
            'css-class' => 'a[href*="#modal__gform_10"]',
            'css-hover' => 'a[href*="#modal__gform_10"]:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[href*="#modal__gform_10"]',
                    'values' => array(
                        'Get a Quote',
                        'Request a Quote',
                        'Inquire Today',
                        'Inquire Now',
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Sale Price',
                        'Get Our Best Price',
                        'Check Availability',

),
),
),
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#29BD4C,#29BD4C)',
                        'border-color' => '29BD4C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#20933B,#20933B)',
                        'border-color' => '20933B',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF2715,#FF2715)',
                        'border-color' => 'FF2715',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D41F10,#D41F10)',
                        'border-color' => 'D41F10',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#014984,#014984)',
                        'border-color' => '014984',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#01325B,#01325B)',
                        'border-color' => '01325B',
                        'color' => '#fff',
),
),
),
),
),
);

$CronConfigs["companyofcarscom"] = array(
    'name'               => 'companyofcarscom',
    'email'              => 'regan@smedia.ca',
    'password'           => 'companyofcarscom',
    'log'                => true,
    'combined_feed_mode' => true,
    'cities'            => array(
		'kelowna'     => array(
			'address'      => 'Suite B, #23 – 2670 Enterprise Way',
			'city'         => 'Kelowna',
			'state'        => 'BC',
			'country_name' => 'Canada',
			'post_code'    => 'V1X 4J7',
			'full_address' => 'Suite B, #23 – 2670 Enterprise Way, Kelowna, BC, V1X 4J7',
			'phone'        => '1-250-860-0994',
			'lat'          => '49.895830',
			'lng'          => '-119.415660',
		),
		'vancouver'      => array(
			'address'      => '1885 Clark Drive',
			'city'         => 'Vancouver',
			'state'        => 'BC',
			'country_name' => 'Canada',
			'post_code'    => 'V5N 3G5',
			'full_address' => '1885 Clark Drive, Vancouver, BC, V5N 3G5',
			'phone'        => '1-604-239-3888',
			'lat'          => '49.268020',
			'lng'          => '-123.078020',
		),
	),
	"banner" => array(
        "template" => "companyofcarscom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",

		'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
		
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

$CronConfigs["competitionchev"] = array(
    'name' => 'competitionchev',
    'password' => 'competitionchev',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'max_cost' => 900,
    'cost_distribution' => array(
        'adwords' => 900,
),
    'lead' => null,
    'create' => array(
        "used_search" => yes,
        "new_search" => yes,
),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'banner' => array(
        'template' => 'competitionchev',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click below for more info!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => '#ffffff',
),
);

$CronConfigs["cookford"] = array(
    'bid' => 3.0,
    'log' => true,
    'password' => 'cookford',
    'post_code' => 'N8M 2C8',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'customer_id' => '721-007-3127',
    'banner' => array(
        'template' => 'cookford',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in [Year] [Make] [Model]? Click below and fill in your information to secure your bottom line price.',
        'flash_style' => 'default',
        'hst' => true,
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
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
            '#2A8BBE',
            '#2A8BBE',
),
        'button_color_hover' => array(
            '#004286',
            '#004286',
),
        'button_color_active' => array(
            '#004286',
            '#004286',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Cook County Ford will buy your car!',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Cook County Ford Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'webleads@cookcountyford.dsmessage.com',
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
                    <vendorname>Cook County Ford</vendorname>
                    <contact>
                        <name part="full">Cook County Ford</name>
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
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used)-[^-]+-[0-9]{4}-/i',
            'service_regex' => '',
),
),
    'adf_to' => array(
        'cookcountyford@eleadtrack.net',
),
    'form_live' => false,
    'buttons_live' => false,
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17570',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
    'max_cost' => 500,
    'cost_distribution' => array(
        'adwords' => 500,
),
    'name' => 'cookford',
);

$CronConfigs["country chevrolet"] = array (
  'name' => 'country chevrolet',
  'email' => 'regan@smedia.ca',
  'password' => 'country chevrolet',
  'no_adv' => true,
);

$CronConfigs["countrylincoln"] = array (
  'password' => 'countrylincoln',
  'email' => 'regan@smedia.ca',
  'log' => false,
  'banner' => 
  array (
    'template' => 'countrylincoln',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'form_live' => false,
  'buttons_live' => false,
  'name' => 'countrylincoln',
);

$CronConfigs["countrysidefordcolumbuscom"] = array (
  'name' => 'countrysidefordcolumbuscom',
  'email' => 'regan@smedia.ca',
  'password' => 'countrysidefordcolumbuscom',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'countrysidefordcolumbuscom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["courtesychryslercom"] = array(
    'name'     => 'courtesychryslercom',
    'email'    => 'regan@smedia.ca',
    'password' => 'courtesychryslercom',
    'log'      => true,
    'lead'     => array(
        'live'                   => true,
        'lead_type_'             => true,
        'lead_type_new'          => true,
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
        'sent_client_email'      => false,
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#9D0A0E',
            '#9D0A0E',
        ),
        'button_color_hover'     => array(
            '#890000',
            '#890000',
        ),
        'button_color_active'    => array(
            '#890000',
            '#890000',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Get $500 off coupon from Courtesy Chrysler',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Courtesy Chrysler Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'leads@courtesychryslerdodgejeepram.motosnap.com',
            'tamissy13@gmail.com',
        ),
        'special_email'          => '<?xml version="1.0"?>
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
                    <vendorname>Courtesy Chrysler</vendorname>
                    <contact>
                        <name part="full">Courtesy Chrysler</name>
                        <email>[dealer_email]</email>
                    </contact>
                </vendor>
                <provider>
                    <name part="full">sMedia Coupon</name>
                    <url>https://smedia.ca</url>
                    <email>offers@mail.smedia.ca</email>
                    <phone>855-775-0062</phone>
                </provider>
            </prospect>
        </adf>',
        'display_after'          => 20000,
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
            'vdp'           => '/\\/vehicles\\/[0-9]{4}\\//i',
            'service_regex' => '',
        ),
    ),
);

$CronConfigs["coventrynorthlandrovercom"] = array (
  'name' => 'coventrynorthlandrovercom',
  'email' => 'regan@smedia.ca',
  'password' => 'coventrynorthlandrovercom',
  'no_adv' => true,
);

$CronConfigs["covingtonhondanissan"] = array(
    'password'         => 'covingtonhondanissan',
    'email'            => 'regan@smedia.ca',
    'log'              => true,
    'lead'             => array(
        'live'                   => false,
        'lead_type_'             => false,
        'lead_type_new'          => false,
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
            '#0D79B2',
            '#0D79B2',
        ),
        'button_color_hover'     => array(
            '#119FEB',
            '#13ADFF',
        ),
        'button_color_active'    => array(
            '#052D42',
            '#052D42',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Lifetime Limited Powertrain Warranty from Covington Honda Nissan',
        'response_email'         => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Covington Honda Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'leads@covington.dsmessage.com',
        ),
        'special_email'          => '<?xml version="1.0"?>
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
                    <vendorname>Covington Honda</vendorname>
                    <contact>
                        <name part="full">Covington Honda</name>
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
            'vdp'           => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
    'banner'           => array(
        'template'                   => 'covingtonhondanissan',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_marketplace_description' => '[description]',
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'font_color'                 => '#ffffff',
    ),
    'adf_to'           => array(
        'leads@covington.dsmessage.com',
    ),
    'form_live'        => false,
    'buttons_live'     => false,
    'mail_retargeting' => array(
        'enabled'             => null,
        'client_id'           => '17573',
        'promotion_text'      => '',
        'promotion_color'     => '#567DC0',
        'overlay_color'       => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color'         => '#FF8500',
        'coupon_validity'     => '7',
    ),
    'name'             => 'covingtonhondanissan',
);

$CronConfigs["cranbrookdodgeca"] = array(
    "name" => "cranbrookdodgeca",
    "email" => "regan@smedia.ca",
    "password" => "cranbrookdodgeca",
    //"no_adv" => true,
    "log" => true,
    "combined_feed_mode" => true,
    "banner" => array(
        "template" => "cranbrookdodgeca",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 700,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 700,
),
);

$CronConfigs["creditguys"] = array(
    'bid'               => 3.0,
    'password'          => 'creditguys',
    'post_code'         => 't18 4p8',
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    'email'             => 'regan@smedia.ca',
    'max_cost'          => 600.0,
    'cost_distribution' => array(
        'adwords' => 600,
    ),
    'log'               => true,
    'banner'            => array(
        'template'                 => 'creditguys',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? We have financing available for all levels of credit and we encourage you to apply for pre-approval today!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! We have financing available for all levels of credit and we encourage you to apply for pre-approval today!',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'styels'                   => array(
            'new_display'       => 'custom_banner',
            'used_display'      => 'custom_banner',
            'new_retargeting'   => 'custom_banner',
            'used_retargeting'  => 'custom_banner',
            'new_marketbuyers'  => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
        ),
        'font_color'               => '#ffffff',
    ),
    'lead_to'           => array(
        'info@creditguys.ca',
    ),
    'form_live'         => true,
    'buttons_live'      => true,
    'buttons'           => array(
        'financing'                => array(
            'url-match'     => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'a#discount',
            'css-class'     => 'a#discount',
            'css-hover'     => 'a#discount:hover',
            'button_action' => array(
                'form',
                'finance',
            ),
            'sizes'         => array(
                100 => array(
                ),
            ),
            'texts'         => array(
                'financing' => array(
                    'target' => 'a#discount',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
                        'Special Finance Offers!',
                    ),
                ),
            ),
            'styles'        => array(
                'red'   => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => 'CC0000',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00A300,#00A300)',
                        'border-color' => '00A300',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                    ),
                ),
                'blue'  => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#094E83,#094E83)',
                        'border-color' => '094E83',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan'  => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '094E83',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
        'Used financing'           => array(
            'url-match'     => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'button#apply-for-finance.btn-orange-vehicles1',
            'css-class'     => 'button#apply-for-finance.btn-orange-vehicles1',
            'css-hover'     => 'button#apply-for-finance.btn-orange-vehicles1:hover',
            'button_action' => array(
                'form',
                'finance',
            ),
            'sizes'         => array(
                100 => array(
                ),
            ),
            'texts'         => array(
                'financing' => array(
                    'target' => 'button#apply-for-finance.btn-orange-vehicles1',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
                        'Special Finance Offers!',
                    ),
                ),
            ),
            'styles'        => array(
                'red'   => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => 'CC0000',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00A300,#00A300)',
                        'border-color' => '00A300',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                    ),
                ),
                'blue'  => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#094E83,#094E83)',
                        'border-color' => '094E83',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan'  => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '094E83',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
        'Used request-information' => array(
            'url-match'     => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target'        => null,
            'locations'     => array(
                'default' => null,
            ),
            'action-target' => 'button#request-info.btn-orange-vehicles1',
            'css-class'     => 'button#request-info.btn-orange-vehicles1',
            'css-hover'     => 'button#request-info.btn-orange-vehicles1:hover',
            'button_action' => array(
                'form',
                'e-price',
            ),
            'sizes'         => array(
                100 => array(
                ),
            ),
            'texts'         => array(
                'request-information' => array(
                    'target' => 'button#request-info.btn-orange-vehicles1',
                    'values' => array(
                        'Request Information',
                        'Get More Information',
                        'Ask for More Info',
                        'Ask an Expert',
                        'Ask a Question',
                    ),
                ),
            ),
            'styles'        => array(
                'red'   => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#CC0000,#CC0000)',
                        'border-color' => 'CC0000',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00A300,#00A300)',
                        'border-color' => '00A300',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                    ),
                ),
                'blue'  => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#094E83,#094E83)',
                        'border-color' => '094E83',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                    ),
                ),
                'Cyan'  => array(
                    'normal' => array(
                        'background'   => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '094E83',
                    ),
                    'hover'  => array(
                        'background'   => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                    ),
                ),
            ),
        ),
    ),
    'name'              => 'creditguys',
);

$CronConfigs["crickshighwaycomau"] = array (
  'name' => 'crickshighwaycomau',
  'email' => 'regan@smedia.ca',
  'password' => 'crickshighwaycomau',
  'log' => true,
  'combined_feed_mode' => true,
  'fb_title' => '[year] [make] [model] [trim]',
  'banner' => 
  array (
    'template' => 'crickshighwaycomau',
    'fb_description' => '[description]',

    'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',

    
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["crickshighwaykiacomau"] = array (
  'name' => 'crickshighwaykiacomau',
  'email' => 'regan@smedia.ca',
  'password' => 'crickshighwaykiacomau',
  'log' => true,
  'combined_feed_mode' => true,
  'fb_title' => '[year] [make] [model] [trim]',
  'banner' => 
  array (
    'template' => 'crickshighwaykiacomau',
   // 'fb_style' => 'facebook_raw_img',
    'fb_description' => '[description]',
    'fb_lookalike_description' => '[description]',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["crickshighwayrenaultcomau"] = array (
  'name' => 'crickshighwayrenaultcomau',
  'email' => 'regan@smedia.ca',
  'password' => 'crickshighwayrenaultcomau',
  'log' => true,
  'combined_feed_mode' => true,
  'fb_title' => '[year] [make] [model] [trim]',
  'banner' => 
  array (
    'template' => 'crickshighwayrenaultcomau',
    //'fb_style' => 'facebook_raw_img',
    'fb_description' => '[description]',
    'fb_lookalike_description' => '[description]',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["crickshighwayssangyongcomau"] = array (
  'name' => 'crickshighwayssangyongcomau',
  'email' => 'regan@smedia.ca',
  'password' => 'crickshighwayssangyongcomau',
  'log' => true,
  'combined_feed_mode' => true,
  'fb_title' => '[year] [make] [model] [trim]',
  'banner' => 
  array (
    'template' => 'crickshighwayssangyongcomau',
    //'fb_style' => 'facebook_raw_img',
    'fb_description' => '[description]',
    'fb_lookalike_description' => '[description]',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["crickshighwaysubarucomau"] = array (
  'name' => 'crickshighwaysubarucomau',
  'email' => 'regan@smedia.ca',
  'password' => 'crickshighwaysubarucomau',
  'log' => true,
  'combined_feed_mode' => true,
  'fb_title' => '[year] [make] [model] [trim]',
  'banner' => 
  array (
    'template' => 'crickshighwaysubarucomau',
   // 'fb_style' => 'facebook_raw_img',
    'fb_description' => '[description]',
    'fb_lookalike_description' => '[description]',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["crickshighwayvolkswagencomau"] = array (
  'name' => 'crickshighwayvolkswagencomau',
  'email' => 'regan@smedia.ca',
  'password' => 'crickshighwayvolkswagencomau',
  'log' => true,
  'combined_feed_mode' => true,
  'fb_title' => '[year] [make] [model] [trim]',
  'banner' => 
  array (
    'template' => 'crickshighwayvolkswagencomau',
   // 'fb_style' => 'facebook_raw_img',
    'fb_description' => '[description]',
    'fb_lookalike_description' => '[description]',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["cricksmaroochydorevwcomau"] = array (
  'name' => 'cricksmaroochydorevwcomau',
  'email' => 'regan@smedia.ca',
  'password' => 'cricksmaroochydorevwcomau',
  'log' => true,
  'fb_title' => "[year] [make] [model] [trim]",
  'combined_feed_mode' => true,
);

$CronConfigs["crosstownautocentrecom"] = array(
    'name'               => 'crosstownautocentrecom',
    'email'              => 'regan@smedia.ca',
    'password'           => 'crosstownautocentrecom',
    'log'                => true,
    'combined_feed_mode' => true,
    'lead'               => array(
        'new'     => array(
            'live'                      => true,
            'lead_type_'                => true,
            'lead_type_new'             => true,
            'lead_type_used'            => false,
            'lead_type_service'         => false,
            'shown_cap'                 => false,
            'fillup_cap'                => false,
            'session_close'             => false,
            'inactivity'                => true,
            'exit_intent'               => true,
            'session_depth'             => false,
            'campaign_cap_google'       => false,
            'campaign_cap_fb'           => false,
            'device_type'               => array(
                'mobile'  => true,
                'desktop' => true,
                'tablet'  => true,
            ),
            'sent_client_email'         => false,
            'offer_minimum_price'       => 0,
            'offer_maximum_price'       => 10000000,
            'bg_color'                  => '#EFEFEF',
            'text_color'                => '#404450',
            'border_color'              => '#E5E5E5',
            'button_color'              => array(
                '#BD1F1B',
                '#BD1F1B',
            ),
            'button_color_hover'        => array(
                '#A90B07',
                '#A90B07',
            ),
            'button_color_active'       => array(
                '#BD1F1B',
                '#BD1F1B',
            ),
            'button_text_color'         => '#FFFFFF',
            'response_email_subject'    => 'Get up to $500 off with purchase at Crosstown CDJR',
            'response_email'            => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Crosstown CDJR Team',
            'forward_to'                => array(
                '',
            ),
            'special_to'                => array(
                'tamissy13@gmail.com',
                'adf_to@smedia.ca',
                'leads@crosstownautocentre.motosnap.com',
            ),
            'special_email'             => '',
            'display_after'             => 20000,
            'retarget_after'            => 5000,
            'fb_retarget_after'         => 5000,
            'adword_retarget_after'     => 5000,
            'visit_count'               => 0,
            'shown_cap_count'           => 1,
            'fillup_cap_time_days'      => 7,
            'session_close_cap'         => 3,
            'inactivity_timeout'        => 600000,
            'exit_intent_timeout'       => 10000,
            'session_depth_page'        => 0,
            'campaign_google_cap_count' => 3,
            'campaign_google_cap_days'  => 7,
            'campaign_fb_cap_count'     => 3,
            'campaign_fb_cap_days'      => 7,
            'video_smart_offer'         => false,
            'video_smart_offer_form'    => false,
            'video_url'                 => '',
            'video_title'               => '',
            'video_description'         => '',
            'lead_in'                   => array(
                'vdp'           => '/\\/vehicles\\/[0-9]{4}\\//i',
                'service_regex' => '',
            ),
            'custom_div'                => '',
        ),
        'used'    => array(
            'live'                      => true,
            'lead_type_'                => true,
            'lead_type_new'             => false,
            'lead_type_used'            => true,
            'lead_type_service'         => false,
            'shown_cap'                 => false,
            'fillup_cap'                => false,
            'session_close'             => false,
            'inactivity'                => true,
            'exit_intent'               => true,
            'session_depth'             => false,
            'campaign_cap_google'       => false,
            'campaign_cap_fb'           => false,
            'device_type'               => array(
                'mobile'  => true,
                'desktop' => true,
                'tablet'  => true,
            ),
            'sent_client_email'         => false,
            'offer_minimum_price'       => 0,
            'offer_maximum_price'       => 10000000,
            'bg_color'                  => '#EFEFEF',
            'text_color'                => '#404450',
            'border_color'              => '#E5E5E5',
            'button_color'              => array(
                '#BD1F1B',
                '#BD1F1B',
            ),
            'button_color_hover'        => array(
                '#A90B07',
                '#A90B07',
            ),
            'button_color_active'       => array(
                '#BD1F1B',
                '#BD1F1B',
            ),
            'button_text_color'         => '#FFFFFF',
            'response_email_subject'    => 'Get up to $500 off with purchase at Crosstown CDJR',
            'response_email'            => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Crosstown CDJR Team',
            'forward_to'                => array(
                '',
            ),
            'special_to'                => array(
                'tamissy13@gmail.com',
                'adf_to@smedia.ca',
                'leads@crosstownautocentre.motosnap.com',
            ),
            'special_email'             => '',
            'display_after'             => 30000,
            'retarget_after'            => 5000,
            'fb_retarget_after'         => 5000,
            'adword_retarget_after'     => 5000,
            'visit_count'               => 0,
            'shown_cap_count'           => 1,
            'fillup_cap_time_days'      => 7,
            'session_close_cap'         => 3,
            'inactivity_timeout'        => 600000,
            'exit_intent_timeout'       => 10000,
            'session_depth_page'        => 0,
            'campaign_google_cap_count' => 3,
            'campaign_google_cap_days'  => 7,
            'campaign_fb_cap_count'     => 3,
            'campaign_fb_cap_days'      => 7,
            'video_smart_offer'         => false,
            'video_smart_offer_form'    => false,
            'video_url'                 => '',
            'video_title'               => '',
            'video_description'         => '',
            'lead_in'                   => array(
                'vdp'           => '/\\/vehicles\\/[0-9]{4}\\//i',
                'service_regex' => '',
            ),
            'custom_div'                => '',
        ),
        'service' => array(
            'live'                      => false,
            'lead_type_'                => false,
            'lead_type_new'             => false,
            'lead_type_used'            => false,
            'lead_type_service'         => false,
            'shown_cap'                 => false,
            'fillup_cap'                => false,
            'session_close'             => false,
            'inactivity'                => true,
            'exit_intent'               => true,
            'session_depth'             => false,
            'campaign_cap_google'       => false,
            'campaign_cap_fb'           => false,
            'device_type'               => array(
                'mobile'  => true,
                'desktop' => true,
                'tablet'  => true,
            ),
            'sent_client_email'         => false,
            'offer_minimum_price'       => 0,
            'offer_maximum_price'       => 10000000,
            'bg_color'                  => '#EFEFEF',
            'text_color'                => '#404450',
            'border_color'              => '#E5E5E5',
            'button_color'              => array(
                '#BD1F1B',
                '#BD1F1B',
            ),
            'button_color_hover'        => array(
                '#A90B07',
                '#A90B07',
            ),
            'button_color_active'       => array(
                '#BD1F1B',
                '#BD1F1B',
            ),
            'button_text_color'         => '#FFFFFF',
            'response_email_subject'    => 'Free Diagnosis for your Air Conditioning System',
            'response_email'            => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Crosstown CJDR Team',
            'forward_to'                => array(
                '',
            ),
            'special_to'                => array(
                'tamissy13@gmail.com',
                'adf_to@smedia.ca',
                'leads@crosstownautocentre.motosnap.com',
            ),
            'special_email'             => '',
            'display_after'             => 30000,
            'retarget_after'            => 5000,
            'fb_retarget_after'         => 5000,
            'adword_retarget_after'     => 5000,
            'visit_count'               => 0,
            'shown_cap_count'           => 1,
            'fillup_cap_time_days'      => 7,
            'session_close_cap'         => 3,
            'inactivity_timeout'        => 600000,
            'exit_intent_timeout'       => 10000,
            'session_depth_page'        => 0,
            'campaign_google_cap_count' => 3,
            'campaign_google_cap_days'  => 7,
            'campaign_fb_cap_count'     => 3,
            'campaign_fb_cap_days'      => 7,
            'video_smart_offer'         => false,
            'video_smart_offer_form'    => false,
            'video_url'                 => '',
            'video_title'               => '',
            'video_description'         => '',
            'lead_in'                   => array(
                'vdp'           => '',
                'service_regex' => '/\\/(service|specials\\/edmonton-cdjr-mopar-service-parts-coupons)/gi',
            ),
            'custom_div'                => '',
        ),
    ),
);

$CronConfigs["crowfootdodgechryslercom"] = array( 
	"name"  => "crowfootdodgechryslercom",
	"email" => "regan@smedia.ca",
	"password" => "crowfootdodgechryslercom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["crowfoothyundaicom"] = array(
    'name'               => 'crowfoothyundaicom',
    'email'              => 'regan@smedia.ca',
    'password'           => 'crowfoothyundaicom',
    'log'                => true,
    'combined_feed_mode' => true,
    'lead'               => array(
        'live'                   => true,
        'lead_type_'             => true,
        'lead_type_new'          => true,
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
            '#0A2972',
            '#0A2972',
        ),
        'button_color_hover'     => array(
            '#000000',
            '#000000',
        ),
        'button_color_active'    => array(
            '#25448D',
            '#25448D',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => 'Claim $200 Off with a purchase from Crowfoot Hyundai',
        'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Crowfoot Hyundai Team',
        'forward_to'             => array(
            '',
        ),
        'special_to'             => array(
            'leads@crowfoot.motosnap.com',
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
            'vdp'           => '/\\/vehicles\\/[0-9]{4}\\//',
            'service_regex' => '',
        ),
        'custom_div'             => '',
    ),
);

$CronConfigs["cumberlandhondacom"] = array(
    'name' => 'cumberlandhondacom',
    'email' => 'regan@smedia.ca',
    'password' => 'cumberlandhondacom',
    'log' => true,
    'customer_id' => '345-687-9011',
    'max_cost' => 250,
    'cost_distribution' => array(
        'adwords' => 250,
),
    'banner' => array(
        'template' => 'cumberlandhondacom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
);

$CronConfigs["currychevroletca"] = array(
    'name' => 'currychevroletca',
    'email' => 'regan@smedia.ca',
    'password' => 'currychevroletca',
    'log' => true,
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'currychevroletca',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 620,
    'cost_distribution' => array(
        'new' => 310,
        'used' => 310,
),
);

$CronConfigs["cuttervolvocarshawaii"] = array (
  'name' => 'cuttervolvocarshawaii',
  'email' => 'regan@smedia.ca',
  'password' => 'cuttervolvocarshawaii',
  'log' => true,
);

$CronConfigs["cyclenorthcom"] = array( 
	"name"  => "cyclenorthcom",
	"email" => "regan@smedia.ca",
	"password" => "cyclenorthcom",
	"no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["dalhousielounsbury"] = array (
  'name' => 'dalhousielounsbury',
  'email' => 'regan@smedia.ca',
  'password' => 'dalhousielounsbury',
  'log' => true,
  'banner' => 
  array (
    'template' => 'dalhousielounsbury',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["danmurphyford"] = array(
    'bid' => 3.0,
    'password' => 'danmurphyford',
    'post_code' => 'L2R5L3',
    'log' => true,
    'email' => 'regan@smedia.ca',
    'banner' => array(
        'template' => 'danmurphyford',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style' => 'default',
        'hst' => true,
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => null,
    'name' => 'danmurphyford',
);

$CronConfigs["danobrienkia"] = array (
  'password' => 'danobrienkia',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'banner' => 
  array (
    'template' => 'danobrienkia',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'name' => 'danobrienkia',
);

$CronConfigs["davewheatongmcom"] = array(
    'name' => 'davewheatongmcom',
    'email' => 'regan@smedia.ca',
    'password' => 'davewheatongmcom',
    'log' => true,
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'davewheatongmcom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 1200,
    'cost_distribution' => array(
        'new' => 600,
        'used' => 600,
),
);

$CronConfigs["ddodgecom"] = array(
    'name' => 'ddodgecom',
    'email' => 'regan@smedia.ca',
    'password' => 'ddodgecom',
    'log' => true,
    'combined_feed_mode' => true,
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#222222',
            '#222222',
),
        'button_color_active' => array(
            '#222222',
            '#222222',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'Claim $500 Off with purchase from Dartmouth CDJR',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Dartmouth CDJR Team',
        'forward_to' => array(
            '',
),
        'special_to' => array(
            'leads@dartmouthcdjr.motosnap.com',
            'tamissy13@gmail.com',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
);

$CronConfigs["demo_performancehondabountiful_dealerinspire"] = array(
    "name"               => "demo_performancehondabountiful_dealerinspire",
    "email"              => "regan@smedia.ca",
    "password"           => "demo_performancehondabountiful_dealerinspire",
    "log"                => true,
    "combined_feed_mode" => true,
    "tag_debug"          => true,
);

$CronConfigs["denhamchryslerjeep"] = array(
    'name' => 'denhamchryslerjeep',
    'email' => 'regan@smedia.ca',
    'password' => 'denhamchryslerjeep',
    'log' => true,
    'customer_id' => '961-077-5599',
    'max_cost' => 1230,
    'cost_distribution' => array(
        'adwords' => 1230,
),
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'denhamchryslerjeep',
        'fb_description' => 'Test drive and buy today. No need to wait for your dream vehicle, at Denham Chrysler Jeep you can drive it off the lot today! We have a wide variety of inventory to choose from.',
        //'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        //'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_dynamiclead_description' => 'Check out this [year] [make] [model] today! Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => true,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#222222',
            '#222222',
),
        'button_color_active' => array(
            '#222222',
            '#222222',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'Your offer from [dealership]',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Denham Chrysler Lloydminster Team',
        'forward_to' => array(
            '',
),
        'special_to' => array(
            'leads@denhamchrysler.ca',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
    'smart_memo' => array(
        'live' => true,
        'live_new' => false,
        'live_used' => false,
        'live_home' => true,
        'live_service' => false,
        'video' => false,
        'hide_redirection' => true,
        'video_url' => '',
        'button_text' => 'learn more',
        'url' => 'https://www.denhamchryslerjeep.com/buildandprice/index.htm',
        'home_url' => 'https://www.denhamchryslerjeep.com/',
        'service_regex' => '',
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_text_color' => '#FFFFFF',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#222222',
            '#222222',
),
        'button_color_active' => array(
            '#222222',
            '#222222',
),
),
);

$CronConfigs["dicknorrispalmharborcom"] = array (
  'name' => 'dicknorrispalmharborcom',
  'email' => 'regan@smedia.ca',
  'password' => 'dicknorrispalmharborcom',
  'combined_feed_mode' => true,
  'log' => true,
  'bing_account_id' => 156003925,
  'banner' => 
  array (
    'template' => 'dicknorrispalmharborcom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["dinsdaleautonet"] = array (
  'name' => 'dinsdaleautonet',
  'email' => 'regan@smedia.ca',
  'password' => 'dinsdaleautonet',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'dinsdaleautonet',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["dinsdalehyundaicom"] = array(
    'name' => 'dinsdalehyundaicom',
    'email' => 'regan@smedia.ca',
    'password' => 'dinsdalehyundaicom',
    'log' => true,
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'dinsdalehyundaicom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 300,
    'cost_distribution' => array(
        'new' => 300,
),
);

$CronConfigs["discoveryrvca"] = array( 
	"name"  => "discoveryrvca",
	"email" => "regan@smedia.ca",
	"password" => "discoveryrvca",
	//"no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
	"banner" => array(
        "template" => "discoveryrvca",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
		'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
);

$CronConfigs["docksidemarinecom"] = array(
    "name" => "docksidemarinecom",
    "email" => "regan@smedia.ca",
    "password" => "docksidemarinecom",
    //"no_adv" => true,
    "log" => true,
    "combined_feed_mode" => true,
    "banner" => array(
        "template" => "docksidemarinecom",
        'fb_style' => 'facebook_raw_img',
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'max_cost' => 1762,
    'cost_distribution' => array(
        'new' => 729,
        'used' => 1033,
),
);

$CronConfigs["dodgecityautocom"] = array(
    'name' => 'dodgecityautocom',
    'email' => 'regan@smedia.ca',
    'password' => 'dodgecityautocom',
    'log' => true,
    'combined_feed_mode' => true,
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#BD1F1B',
            '#BD1F1B',
),
        'button_color_hover' => array(
            '#A90B07',
            '#A90B07',
),
        'button_color_active' => array(
            '#D83A36',
            '#D83A36',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'Claim $500 Off with purchase from Dodge City CDJR',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Dodge City CDJR Team',
        'forward_to' => array(
            '',
),
        'special_to' => array(
            'leads@dodgecitycdjr.motosnap.com',
            'adf_to@smedia.ca',
            'tamissy13@gmail.com',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
);

$CronConfigs["dothanchryslerdodge"] = array (
  'name' => 'dothanchryslerdodge',
  'email' => 'regan@smedia.ca',
  'password' => 'dothanchryslerdodge',
  'log' => true,
  'banner' => 
  array (
    'template' => 'dothanchryslerdodge',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["dothankianet"] = array (
  'name' => 'dothankianet',
  'email' => 'regan@smedia.ca',
  'password' => 'dothankianet',
  'log' => true,
  'max_cost' => 0,
  'cost_distribution' => 
  array (
    'adwords' => 0,
  ),
  'create' => 
  array (
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'customer_id' => '302-758-9782',
  'banner' => 
  array (
    'template' => 'dothankianet',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
  ),
);

$CronConfigs["dothanvw"] = array(
    'name' => 'dothanvw',
    'email' => 'regan@smedia.ca',
    'password' => 'dothanvw',
    'log' => true,
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '816-764-0356',
    'banner' => array(
        'template' => 'dothanvw',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'smart_memo' => array(
        'live' => true,
        'live_new' => false,
        'live_used' => false,
        'live_home' => true,
        'live_service' => false,
        'video' => false,
        'video_url' => '',
        'button_text' => 'Learn More',
        'url' => 'https://www.dothanvw.com/new-vehicles/',
        'home_url' => 'https://www.dothanvw.com',
        'service_regex' => '',
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_text_color' => '#FFFFFF',
        'button_color' => array(
            '#029DDD',
            '#029DDD',
),
        'button_color_hover' => array(
            '#0279AA',
            '#0279AA',
),
        'button_color_active' => array(
            '#428BCA',
            '#428BCA',
),
),
);

$CronConfigs["doubleeagleharley"] = array (
  'name' => 'doubleeagleharley',
  'email' => 'regan@smedia.ca',
  'password' => 'doubleeagleharley',
  'log' => true,
  'banner' => 
  array (
    'template' => 'doubleeagleharley',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
    'fb_lookalike_description' => 'Test drive the [year] [make] [model] today.',
    'fb_marketplace_description' => 'Come check out this [year][make][model] today!',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'styels' => 
    array (
      'new_display' => 'custom_banner',
      'used_display' => 'custom_banner',
      'new_retargeting' => 'custom_banner',
      'used_retargeting' => 'custom_banner',
      'new_marketbuyers' => 'custom_banner',
      'used_marketbuyers' => 'custom_banner',
    ),
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["dougmarshallgmcom"] = array(
    'name' => 'dougmarshallgmcom',
    'email' => 'regan@smedia.ca',
    'password' => 'dougmarshallgmcom',
    'log' => true,
    'customer_id' => '411-852-6217',
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'dougmarshallgmcom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'max_cost' => 2975,
    'cost_distribution' => array(
        'new' => 1083,
        'used' => 1892,
),
    'adf_to' => array(),
    'form_live' => false,
    'buttons_live' => false,
);

$CronConfigs["downtownhyundaicom"] = array (
  'name' => 'downtownhyundaicom',
  'email' => 'regan@smedia.ca',
  'password' => 'downtownhyundaicom',
  'log' => true,
);

$CronConfigs["drivederrow"] = array (
  'name' => 'drivederrow',
  'email' => 'regan@smedia.ca',
  'password' => 'drivederrow',
  'log' => true,
  'banner' => 
  array (
    'template' => 'drivederrow',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
  ),
);

$CronConfigs["drivenation"] = array(
    'password'          => 'drivenation',
    'email'             => 'regan@smedia.ca',
    'log'               => true,
    'form_live'         => false,
    'buttons_live'      => false,
    'fb_title'          => '[year] [make] [model] Our Price [price]. Click to get approved in 60 seconds.',
    'max_cost'          => 1000,
    'cost_distribution' => array(
        'adwords' => 1000.0,
    ),
    'create'            => array(
    ),
    'used_descs'        => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'customer_id'       => '788-942-5719',
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    'banner'            => array(
        'template'                   => 'drivenation',
        'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_style'                   => 'drivenation',
        'fb_marketplace_title'       => '[year] [make] [model] [trim] [price]',
        'fb_marketplace_description' => '[description]',
        'fb_lookalike_description'   => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_dynamiclead_description' => 'Still interested in the [year] [make] [model]? Click below and fill in your information, and a product specialist will be in touch to answer any questions.',
        'flash_style'                => 'default',
        'border_color'               => '#282828',
        'old_price'                  => 'msrp',
        'styels'                     => array(
            'new_display'       => 'custom_banner',
            'used_display'      => 'custom_banner',
            'new_retargeting'   => 'custom_banner',
            'used_retargeting'  => 'custom_banner',
            'new_marketbuyers'  => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
        ),
        'font_color'                 => '#ffffff',
    ),
    'lead'              => array(
        'new' => array(
            'live'                   => false,
            'lead_type_'             => false,
            'lead_type_new'          => false,
            'lead_type_used'         => false,
            'lead_type_service'      => true,
            'shown_cap'              => false,
            'fillup_cap'             => false,
            'session_close'          => false,
            'device_type'            => array(
                'mobile'  => true,
                'desktop' => true,
                'tablet'  => true,
            ),
            'sent_client_email'      => false,
            'offer_minimum_price'    => 0,
            'offer_maximum_price'    => 10000000,
            'bg_color'               => '#EFEFEF',
            'text_color'             => '#404450',
            'border_color'           => '#E5E5E5',
            'button_color'           => array(
                '#FD8524',
                '#FD8524',
            ),
            'button_color_hover'     => array(
                '#FF6900',
                '#FF6900',
            ),
            'button_color_active'    => array(
                '#FF6900',
                '#FF6900',
            ),
            'button_text_color'      => '#FFFFFF',
            'response_email_subject' => '$500 offer from DriveNation',
            'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>DriveNation Team',
            'forward_to'             => array(
                'marketing@drivenation.ca',
                'andrew.potter@drivenation.ca',
                'kyle.senger@ffun.com',
            ),
            'special_to'             => array(
            ),
            'special_email'          => '',
            'display_after'          => 5000,
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
                'vdp'           => '/\\/(?:new|used|all)\\/vehicle\\/[0-9]{4}-/i',
                'service_regex' => '',
            ),
        ),
    ),
    'cities'            => array(
        'abbotsford'      => array(
            'address'      => '32835 S Fraser Way',
            'city'         => 'Abbotsford',
            'state'        => 'British Columbia',
            'country_name' => 'Canada',
            'post_code'    => 'V2S 2A6',
            'full_address' => '32835 S Fraser Way, Abbotsford, British Columbia, V2S 2A6',
            'phone'        => '1-604-330-8263',
            'lat'          => '49.0512595',
            'lng'          => '-122.3140293',
        ),
        'prince_albert'   => array(
            'address'      => '240 38 St East',
            'city'         => 'Prince Albert',
            'state'        => 'Saskatchewan',
            'country_name' => 'Canada',
            'post_code'    => 'S6W 1A6',
            'full_address' => '240 38 St East, Prince Albert, Saskatchewan, S6W 1A6',
            'phone'        => '1-306-700-3537',
            'lat'          => '53.178999',
            'lng'          => '-105.747791',
        ),
        'edmonton'        => array(
            'address'      => '17250 Mayfield RD N.W',
            'city'         => 'Edmonton',
            'state'        => 'Alberta',
            'country_name' => 'Canada',
            'post_code'    => 'T5S 1K6',
            'full_address' => '17250 Mayfield RD N.W., Edmonton, Alberta, T5S 1K6',
            'phone'        => '1-587-400-2145',
            'lat'          => '53.5422452',
            'lng'          => '-113.6176757',
        ),
        'calgary'         => array(
            'address'      => '204 Meridian Rd NE',
            'city'         => 'Calgary',
            'state'        => 'Alberta',
            'country_name' => 'Canada',
            'post_code'    => 'T2A 2N6',
            'full_address' => '204 Meridian Rd NE, Calgary, Alberta, T2A 2N6',
            'phone'        => '1-587-355-6435',
            'lat'          => '51.0535319',
            'lng'          => '-114.0002743',
        ),
        'regina'          => array(
            'address'      => '1440 Albert Street',
            'city'         => 'Regina',
            'state'        => 'Saskatchewan',
            'country_name' => 'Canada',
            'post_code'    => 'S4R 2R7',
            'full_address' => '1440 Albert Street, Regina, Saskatchewan, S4R 2R7',
            'phone'        => '1-306-994-6045',
            'lat'          => '50.455832',
            'lng'          => '-104.6190736',
        ),
        'saskatoon_north' => array(
            'address'      => '806 Circle Drive',
            'city'         => 'Saskatoon North',
            'state'        => 'Saskatchewan',
            'country_name' => 'Canada',
            'post_code'    => 'S7K 3T8',
            'full_address' => '806 Circle Drive, Saskatoon, Saskatchewan, S7K 3T8',
            'phone'        => '1-306-700-5403',
            'lat'          => '52.1583357',
            'lng'          => '-106.6543874',
        ),
        'saskatoon_south' => array(
            'address'      => '1012 Central Ave',
            'city'         => 'Saskatoon South',
            'state'        => 'Saskatchewan',
            'country_name' => 'Canada',
            'post_code'    => 'S7N 2G9',
            'full_address' => '1012 Central Ave, Saskatoon, Saskatchewan, S7N 2G9',
            'phone'        => '1-306-700-5284',
            'lat'          => '52.139256',
            'lng'          => '-106.5991231',
        ),
    ),
    'name'              => 'drivenation',
);

$CronConfigs["drumhellerchrysler"] = array(
    'name' => 'drumhellerchrysler',
    'email' => 'regan@smedia.ca',
    'password' => 'drumhellerchrysler',
    'log' => true,
    'banner' => array(
        'template' => 'drumhellerchrysler',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
);

$CronConfigs["drummondmotors"] = array(
    'name' => 'drummondmotors',
    'email' => 'regan@smedia.ca',
    'password' => 'drummondmotors',
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'bing_account_id' => 156002954,
    'customer_id' => '217-956-5962',
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'banner' => array(
        'template' => 'drummondmotors',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'lead_to' => array(
        'leads@drummondmotors.ca',
        'karl.schulz@drummondmotors.ca',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'Used test-drive' => array(
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
            'css-class' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
            'css-hover' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
                    'values' => array(
                        'Schedule a Test Drive',
                        'Test Drive Today',
                        'Test Drive Now',
                        'Want to Test Drive?',
                        'Request a Test Drive',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FE7C42,#FE7C42)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#DC6B39,#DC6B39)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#7A100A,#7A100A)',
                        'border-color' => 'C60C0D',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3E5C78,#3E5C78)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D4358,#2D4358)',
                        'border-color' => '188BB7',
),
),
                'pink' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C3D92,#0C3D92)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#083075,#083075)',
                        'border-color' => '188BB7',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => '[onclick*=BookATestDrive]',
            'css-class' => '[onclick*=BookATestDrive]',
            'css-hover' => '[onclick*=BookATestDrive]:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => '[onclick*=BookATestDrive]',
                    'values' => array(
                        'Schedule a Test Drive',
                        'Test Drive Today',
                        'Test Drive Now',
                        'Want to Test Drive?',
                        'Request a Test Drive',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FE7C42,#FE7C42)',
                        'border-color' => '#f06b20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#DC6B39,#DC6B39)',
                        'border-color' => '#cf540e',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#7A100A,#7A100A)',
                        'border-color' => '#c60c0d',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3E5C78,#3E5C78)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D4358,#2D4358)',
                        'border-color' => '#188bb7',
),
),
                'pink' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0C3D92,#0C3D92)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#083075,#083075)',
                        'border-color' => '#188bb7',
),
),
),
),
),
);

$CronConfigs["drydengm"] = array(
    'password' => 'drydengm',
    'bid' => 3.0,
    'bid_modifier' => array(
        'after' => 45,
        'bid' => 1.5,
),
    'log' => true,
    'host_url' => 'http://www.drydengm.ca',
    'max_cost' => 1375,
    'cost_distribution' => array(
        'adwords' => 1375,
),
    'email' => 'regan@smedia.ca',
    'retargetting_delay' => 30000,
    'lead' => null,
    'create' => [],
    'post_code' => 'P8N 2P6',
    'new_descs' => array(
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Call us today about the ',
            'desc2' => '[model] starting at [price]',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Call us today about the ',
            'desc2' => '[color] [make] [model]',
),
),
    'used_descs' => array(
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model].',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => 'Call us today about the ',
            'desc2' => '[model] starting at [price]',
),
        array(
            'title2' => 'Take a Virtual Test Drive',
            'desc1' => '[make] [model] starting',
            'desc2' => ' at [price]. Only [kilometers]km ',
),
),
    'options_descs' => array(
        array(
            'desc1' => 'Equipped with [option]',
            'desc2' => 'and [option]',
),
),
    'ymmcount_descs' => array(
        array(
            'desc1' => 'We have [ymmcount] [make]',
            'desc2' => '[model] in stock',
),
),
    'bing_account_id' => 156003017,
    'customer_id' => '503-930-9378',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'drydengm',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'fb_retargeting_description_equinox' => 'Dryden GM has the Largest Selection of SUV\'s in the Region! Click below to browse.',
        'fb_retargeting_description_terrain' => 'Dryden GM has the Largest Selection of SUV\'s in the Region! Click below to browse.',
        'fb_lookalike_description_equinox' => 'Dryden GM has the Largest Selection of SUV\'s in the Region! Click below to browse.',
        'fb_lookalike_description_terrain' => 'Dryden GM has the Largest Selection of SUV\'s in the Region! Click below to browse.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info to get $200 accessory credit with purchase, and a product specialist will be in touch to aid in any questions.',
        'flash_style' => 'default',
        'hst' => true,
        'border_color' => '#dfdfdf',
        'styels' => array(
            'new_display' => 'custom_banner',
            'used_display' => 'custom_banner',
            'new_retargeting' => 'custom_banner',
            'used_retargeting' => 'custom_banner',
            'new_marketbuyers' => 'custom_banner',
            'used_marketbuyers' => 'custom_banner',
),
        'font_color' => '#ffffff',
),
    'lead_to' => array(
        'info@drydengm.ca',
        'trevor@drydengm.ca',
        'doug@drydengm.ca',
        'aileads@smedia.ca',
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => array(
        'Used request-a-quote' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.btn-alpha.btn-alpha--ghost.inventory-vehicle-infos__prices-link',
            'css-class' => '.btn-alpha.btn-alpha--ghost.inventory-vehicle-infos__prices-link',
            'css-hover' => '.btn-alpha.btn-alpha--ghost.inventory-vehicle-infos__prices-link:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => '.btn-alpha.btn-alpha--ghost.inventory-vehicle-infos__prices-link',
                    'values' => array(
                        'Get Our Best Price',
                        'Get Special Price Today',
                        'Get Special Price',
                        'Get Current Market Price',
                        'GET E-PRICE',
                        'SPECIAL PRICING!',
                        'Calculate your payments!',
                        'Test Drive at Home',
                        'Inquire Now',
                        'Inquire Online',
                        'Request Information',
                        'Special pricing!',
                        'You are Eligible for Special Pricing',
                        'Your exclusive price!',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '188BB7',
),
),
),
),
        'request-a-quote' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.btn-alpha.btn-alpha--ghost.header-info-alpha__ctas-item.stat-button-link',
            'css-class' => '.btn-alpha.btn-alpha--ghost.header-info-alpha__ctas-item.stat-button-link',
            'css-hover' => '.btn-alpha.btn-alpha--ghost.header-info-alpha__ctas-item.stat-button-link:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => '.btn-alpha.btn-alpha--ghost.header-info-alpha__ctas-item.stat-button-link',
                    'values' => array(
                        'Get Our Best Price',
                        'Get Special Price Today',
                        'Get Special Price',
                        'Get Current Market Price',
                        'GET E-PRICE',
                        'SPECIAL PRICING!',
                        'Calculate your payments!',
                        'Test Drive at Home',
                        'Inquire Now',
                        'Inquire Online',
                        'Request Information',
                        'Special pricing!',
                        'You are Eligible for Special Pricing',
                        'Your exclusive price!',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '#188bb7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '#188bb7',
),
),
),
),
        'trade-in' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href*=trade]',
            'css-class' => 'a[href*=trade]',
            'css-hover' => 'a[href*=trade]:hover',
            'button_action' => array(
                'form',
                'trade-in',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'trade-in' => array(
                    'target' => 'a[href*=trade]',
                    'values' => array(
                        'Get Trade-In Value',
                        'Value Your Trade Now',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                        'What\'s Your Car Worth?',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '188BB7',
),
),
),
),
        'Used test-drive' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href*="road-test-used"]',
            'css-class' => 'a[href*="road-test-used"]',
            'css-hover' => 'a[href*="road-test-used"]:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a[href*="road-test-used"]',
                    'values' => array(
                        'Test Drive Now',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Book My Test Drive',
                        'Schedule My Test Drive',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '188BB7',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href*=book-a-test-drive]',
            'css-class' => 'a[href*=book-a-test-drive]',
            'css-hover' => 'a[href*=book-a-test-drive]:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a[href*=book-a-test-drive]',
                    'values' => array(
                        'Test Drive Now',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Book My Test Drive',
                        'Schedule My Test Drive',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '#188bb7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '#188bb7',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[href*=financing-request]',
            'css-class' => 'a[href*=financing-request]',
            'css-hover' => 'a[href*=financing-request]:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => [],
),
            'texts' => array(
                'financing' => array(
                    'target' => 'a[href*=financing-request]',
                    'values' => array(
                        'No Hassle Financing',
                        'Special Finance Offers',
                        'Apply For Financing',
                        'Explore Payments',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#B0E0FF)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#C4C4C4)',
                        'border-color' => '188BB7',
),
),
),
),
),
    'name' => 'drydengm',
    'smart_memo' => array(
        'live' => false,
        'live_new' => false,
        'live_used' => false,
        'live_home' => false,
        'live_service' => false,
        'video' => false,
        'hide_redirection' => false,
        'video_url' => 'https://www.youtube.com/watch?v=wCFi9s3LhBU&ab_channel=sMediaProofs',
        'button_text' => 'BUILD AND PRICE',
        'url' => 'https://www.drydengm.ca/en/shop-online',
        'home_url' => 'https://www.drydengm.ca/en',
        'service_regex' => '',
        'bg_color' => '#ADADAD',
        'text_color' => '#404450',
        'border_color' => '#969696',
        'button_text_color' => '#DEDEDE',
        'button_color' => array(
            '#FF0000',
            '#FF0000',
),
        'button_color_hover' => array(
            '#D92929',
            '#D92929',
),
        'button_color_active' => array(
            '#D92929',
            '#D92929',
),
),
);

$CronConfigs["eaglebuickgmccom"] = array (
  'name' => 'eaglebuickgmccom',
  'email' => 'regan@smedia.ca',
  'password' => 'eaglebuickgmccom',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'eaglebuickgmccom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["eagleridgegm"] = array(
    'name' => 'eagleridgegm',
    'password' => 'eagleridgegm',
    'max_cost' => 2400,
    'cost_distribution' => array(
        'adwords' => 2300,
        'youtube' => 100,
),
    'tag_debug' => false,
    'tag_settings' => array(
        'event_tracking' => true,
        'button' => false,
),
    'email' => 'regan@smedia.ca',
    'log' => true,
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '163-396-9643',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'eagleridgegm',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Price: [price]. Click for more info.',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today. Price: [price].',
        'fb_dynamiclead_description_new' => 'Are you still interested in the [year] [make] [model]? Eagle Ridge has a price match guarantee and will give you top value for your trade! Click below, fill in your info and get a $25 gas card for test driving! A product specialist will be in touch to help you out.',
        'fb_dynamiclead_description_used' => 'Are you still interested in the [year] [make] [model]? Eagle ridge GM saves you money and will give you top value for your trade. Click below, fill out your info and a product specialist will be in touch to help out.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => null,
    'adf_to' => array(
        'internetleads@eagleridgegm.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'test-drive' => array(
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel span',
            'css-class' => 'a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel span',
            'css-hover' => 'a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel span:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel span',
                    'values' => array(
                        'Schedule Test Drive',
                        'Schedule My Visit',
                        'Want To Test Drive?',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.payment-calculator-base .sect-5 a[onclick*=QuickQuote].cta.leasing div.ctas_container',
            'css-class' => '.payment-calculator-base .sect-5 a[onclick*=QuickQuote].cta.leasing div.ctas_container',
            'css-hover' => '.payment-calculator-base .sect-5 a[onclick*=QuickQuote].cta.leasing div.ctas_container:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => '.payment-calculator-base .sect-5 a[onclick*=QuickQuote].cta.leasing div.ctas_container',
                    'values' => array(
                        'Request a Quote',
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Your Price',
                        'Get Special Price',
                        'Today\'s Market Price',
                        'SPECIAL PRICING!',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.payment-calculator-base .sect.sect-5  a[onclick*=CTA_ApplyForFinancing-new].cta.financing div.ctas_container',
            'css-class' => '.payment-calculator-base .sect.sect-5  a[onclick*=CTA_ApplyForFinancing-new].cta.financing div.ctas_container',
            'css-hover' => '.payment-calculator-base .sect.sect-5  a[onclick*=CTA_ApplyForFinancing-new].cta.financing div.ctas_container:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => '.payment-calculator-base .sect.sect-5  a[onclick*=CTA_ApplyForFinancing-new].cta.financing div.ctas_container',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Special Finance Offers',
                        'Special Finance Offers!',
                        'TODAY\'S MARKET PRICE',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'lease' => array(
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.payment-calculator-base .sect-5 a[onclick*=CTA_ApplyForLeasing].cta.financing div.ctas_container',
            'css-class' => '.payment-calculator-base .sect-5 a[onclick*=CTA_ApplyForLeasing].cta.financing div.ctas_container',
            'css-hover' => '.payment-calculator-base .sect-5 a[onclick*=CTA_ApplyForLeasing].cta.financing div.ctas_container:hover',
            'button_action' => array(
                'form',
                'lease',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'lease' => array(
                    'target' => '.payment-calculator-base .sect-5 a[onclick*=CTA_ApplyForLeasing].cta.financing div.ctas_container',
                    'values' => array(
                        'Lease Payments',
                        'Lease Quote',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'trade-in' => array(
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.payment-calculator-base .sect-5 a[onclick*=trade-in].cta.leasing div.ctas_container',
            'css-class' => '.payment-calculator-base .sect-5 a[onclick*=trade-in].cta.leasing div.ctas_container',
            'css-hover' => '.payment-calculator-base .sect-5 a[onclick*=trade-in].cta.leasing div.ctas_container:hover',
            'button_action' => array(
                'form',
                'trade-in',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'trade-in' => array(
                    'target' => '.payment-calculator-base .sect-5 a[onclick*=trade-in].cta.leasing div.ctas_container',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade-In Your Ride',
                        'We Want Your Car',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'Used request-a-quote' => array(
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a.iframe-link.btn-incentives-new.icon-Wheel,button.btn-grey-vehicles1.cube',
            'css-class' => 'a.iframe-link.btn-incentives-new.icon-Wheel,button.btn-grey-vehicles1.cube',
            'css-hover' => 'a.iframe-link.btn-incentives-new.icon-Wheel,button.btn-grey-vehicles1.cube:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a.iframe-link.btn-incentives-new.icon-Wheel,button.btn-grey-vehicles1.cube',
                    'values' => array(
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Your Price',
                        'Get Special Price',
                        'Today\'s Market Price',
                        'Get a Quote',
                        'Request a Quote',
                        'SPECIAL PRICING!',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'Used financing' => array(
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'button#apply-for-finance.btn-orange-vehicles1',
            'css-class' => 'button#apply-for-finance.btn-orange-vehicles1',
            'css-hover' => 'button#apply-for-finance.btn-orange-vehicles1:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'button#apply-for-finance.btn-orange-vehicles1',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
                        'Special Finance Offers!',
                        'TODAY\'S MARKET PRICE',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'Used request-info' => array(
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'button#request-info.btn-orange-vehicles1',
            'css-class' => 'button#request-info.btn-orange-vehicles1',
            'css-hover' => 'button#request-info.btn-orange-vehicles1:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'button#request-info.btn-orange-vehicles1',
                    'values' => array(
                        'Get More Information',
                        'Request More Info',
                        'Contact Us Now',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'Used test-drive' => array(
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'button.btn-grey-vehicles1.book-vehicle-cta',
            'css-class' => 'button.btn-grey-vehicles1.book-vehicle-cta',
            'css-hover' => 'button.btn-grey-vehicles1.book-vehicle-cta:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'button.btn-grey-vehicles1.book-vehicle-cta',
                    'values' => array(
                        'Test Drive Today',
                        'Schedule Test Drive',
                        'Schedule My Visit',
                        'Want To Test Drive?',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
),
);

$CronConfigs["easternchrysler"] = array(
    'name' => 'easternchrysler',
    'email' => 'regan@smedia.ca',
    'password' => 'easternchrysler',
    'log' => true,
    'banner' => array(
        'template' => 'easternchrysler',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => array(
        'new' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => true,
            'lead_type_used' => true,
            'lead_type_service' => false,
            'shown_cap' => false,
            'fillup_cap' => false,
            'session_close' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => true,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#BD1F1B',
                '#BD1F1B',
),
            'button_color_hover' => array(
                '#A90B07',
                '#A90B07',
),
            'button_color_active' => array(
                '#D83A36',
                '#D83A36',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => 'Claim $500 Off with purchase from Eastern CDJR',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Eastern CDJR Team',
            'forward_to' => array(
                '',
),
            'special_to' => array(
                'leads@easterncdj.motosnap.com',
                'tamissy13@gmail.com',
),
            'special_email' => '',
            'display_after' => 20000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
                'service_regex' => '',
),
            'custom_div' => '',
),
        'used' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => false,
            'lead_type_used' => true,
            'lead_type_service' => false,
            'shown_cap' => false,
            'fillup_cap' => false,
            'session_close' => false,
            'inactivity' => true,
            'exit_intent' => true,
            'session_depth' => false,
            'campaign_cap_google' => false,
            'campaign_cap_fb' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => true,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#BD1F1B',
                '#BD1F1B',
),
            'button_color_hover' => array(
                '#A90B07',
                '#A90B07',
),
            'button_color_active' => array(
                '#D83A36',
                '#D83A36',
),
            'button_text_color' => '#FFFFFF',
            'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
            'response_email_subject' => '',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Eastern CDJR Team',
            'forward_to' => array(
                '',
),
            'special_to' => array(
                'leads@easterncdj.motosnap.com',
                'tamissy13@gmail.com',
),
            'special_email' => '',
            'display_after' => 20000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'shown_cap_count' => 1,
            'fillup_cap_time_days' => 7,
            'session_close_cap' => 3,
            'inactivity_timeout' => 600000,
            'exit_intent_timeout' => 10000,
            'session_depth_page' => 0,
            'campaign_google_cap_count' => 3,
            'campaign_google_cap_days' => 7,
            'campaign_fb_cap_count' => 3,
            'campaign_fb_cap_days' => 7,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
                'service_regex' => '',
),
            'custom_div' => '',
            'provider_name' => 'sMedia',
            'source' => 'sMedia smartoffer',
),
),
);

$CronConfigs["eastsidekia"] = array (
  'name' => 'eastsidekia',
  'email' => 'regan@smedia.ca',
  'password' => 'eastsidekia',
  'log' => true,
);

$CronConfigs["eastsidekiaca"] = array (
  'name' => 'eastsidekiaca',
  'email' => 'regan@smedia.ca',
  'password' => 'eastsidekiaca',
  'log' => true,
);

$CronConfigs["echovalleygm"] = array(
    'name' => 'echovalleygm',
    'email' => 'regan@smedia.ca',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'password' => 'echovalleygm',
    'log' => true,
    'max_cost' => 1588,
    'cost_distribution' => array(
        'adwords' => 1588,
),
    'create' => array(
        'new_search' => true,
        'used_search' => true,
),
    'new_descs' => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '939-726-0009',
    'banner' => array(
        'template' => 'echovalleygm',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'old_price_new' => 'msrp',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
),
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#222222',
            '#222222',
),
        'button_color_active' => array(
            '#222222',
            '#222222',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => '$200 off coupon from Echo Valley Motor Products ',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Echo Valley Motor Products Team',
        'forward_to' => array(
            'echovalleygm@sasktel.net',
            'leads@echovalleygm.com',
            'echovalleymotorsproductsltd@qleads.xsellerator.com',
            'jason@echovalleygm.com',
            'tamissy13@gmail.com',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}/',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
    'lead_to' => array(
        'echovalleygm@sasktel.net',
        'murraykurtz@yahoo.ca',
        'leads@echovalleygm.com',
        'wecare@echovalleygm.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
                    'values' => array(
                        'Get a Quote',
                        'Request a Quote',
                        'Inquire Today',
                        'Inquire Now',
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Sale Price',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#18549E,#18549E)',
                        'border-color' => '18549E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'C33320',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'A92C1C',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
                    'values' => array(
                        'Schedule My Visit',
                        'Test Drive',
                        'Request A Test Drive',
                        'Want to Test Drive It?',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#18549E,#18549E)',
                        'border-color' => '18549E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '193767',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => 'C33320',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'A92C1C',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
),
),
),
);

$CronConfigs["econoautosalecom"] = array( 
	"name"  => "econoautosalecom",
	"email" => "regan@smedia.ca",
	"password" => "econoautosalecom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["edkenleyford"] = array (
  'name' => 'edkenleyford',
  'email' => 'regan@smedia.ca',
  'password' => 'edkenleyford',
  'log' => true,
  'banner' => 
  array (
    'template' => 'edkenleyford',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => 'ffffff',
  ),
);

$CronConfigs["edmondsautocreditcom"] = array (
  'name' => 'edmondsautocreditcom',
  'email' => 'regan@smedia.ca',
  'password' => 'edmondsautocreditcom',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'edmondsautocreditcom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["edwardsgarage"] = array(
    'password' => 'edwardsgarage',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'customer_id' => '556-377-2536',
    'max_cost' => 150,
    'cost_distribution' => array(
        'adwords' => 150,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today.',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today.',
),
),
    'lead' => null,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'edwardsgarage',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click below for more info! Stock #-[stock_number].',
        'fb_lookalike_description' => 'Interested in this [year] [make] [model]? Check with us today for discounts!. Stock #- [stock_number].',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => '#ffffff',
),
    'name' => 'edwardsgarage',
);

$CronConfigs["elkgrovesubarucom"] = array( 
	"name"  => "elkgrovesubarucom",
	"email" => "regan@smedia.ca",
	"password" => "elkgrovesubarucom",
	//"no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["emcedarviewsmediaca"] = array( 
	"name"  => "emcedarviewsmediaca",
	"email" => "regan@smedia.ca",
	"password" => "emcedarviewsmediaca",
	"no_adv" => true,
	"log" => false,
	"combined_feed_mode" => true,
);

$CronConfigs["emchevroletsmediaca"] = array( 
	"name"  => "emchevroletsmediaca",
	"email" => "regan@smedia.ca",
	"password" => "emchevroletsmediaca",
	"no_adv" => true,
	"log" => false,
	"combined_feed_mode" => true,
);

$CronConfigs["emcjdrsmediaca"] = array( 
	"name"  => "emcjdrsmediaca",
	"email" => "regan@smedia.ca",
	"password" => "emcjdrsmediaca",
	"no_adv" => true,
	"log" => false,
	"combined_feed_mode" => true,
);

$CronConfigs["emnissansmediaca"] = array( 
	"name"  => "emnissansmediaca",
	"email" => "regan@smedia.ca",
	"password" => "emnissansmediaca",
	"no_adv" => true,
	"log" => false,
	"combined_feed_mode" => true,
);

$CronConfigs["emtoyotasmediaca"] = array( 
	"name"  => "emtoyotasmediaca",
	"email" => "regan@smedia.ca",
	"password" => "emtoyotasmediaca",
	"no_adv" => true,
	"log" => false,
	"combined_feed_mode" => true,
);

$CronConfigs["energydodgecom"] = array(
    "name" => "energydodgecom",
    "email" => "regan@smedia.ca",
    "password" => "energydodgecom",
    "no_adv" => true,
    "log" => true,
    "combined_feed_mode" => true,
    'max_cost' => 300,
    'cost_distribution' => array(
        'new' => 150,
        'used' => 150,
),
);

$CronConfigs["ennsbrotherscom"] = array(
    'name' => 'ennsbrotherscom',
    'email' => 'regan@smedia.ca',
    'password' => 'ennsbrotherscom',
    'log' => true,
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'ennsbrotherscom',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'max_cost' => 1500,
    'cost_distribution' => array(
        'adwords' => 1500,
),
);

$CronConfigs["enslexus"] = array(
    "name" => " enslexus",
    "email" => "regan@smedia.ca",
    "password" => "enslexus",
    "log" => true,
    "banner" => array(
        "template" => "enslexus",
        'fb_description' => "Are you still interested in the [year] [make] [model]? Click for more information.",
        'fb_lookalike_description' => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    //    'adf_to' => array(
    //        '',
    //    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.vdp-price-box__main-cta-wrapper [href="#modal__main-form"]',
            'css-class' => '.vdp-price-box__main-cta-wrapper [href="#modal__main-form"]',
            'css-hover' => '.vdp-price-box__main-cta-wrapper [href="#modal__main-form"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.vdp-price-box__main-cta-wrapper [href="#modal__main-form"]',
                    'values' => array(
                        'Get Price Updates',
                        'Local Pricing',
                        'Best Price',
                        'Get Active Market Price',
                        'E-Price',
                        'Internet Price',
                        'Get Special Price',
                        'Get Your Exclusive Price',
                        'Get A Quote',
),
],
],
            'styles' => array(
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#767676,#767676)',
                        'border-color' => '767676',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '333333',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C71229,#C71229)',
                        'border-color' => 'C71229',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C71229,#C71229)',
                        'border-color' => 'C71229',
                        'color' => '#fff',
),
),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '333333',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
                        'color' => '#fff',
),
),
),
],
],
);

$CronConfigs["enstoyota"] = array(
    'password' => 'enstoyota',
    'email' => 'regan@smedia.ca',
    'log' => true,
    'banner' => array(
        'template' => 'enstoyota',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => array(
        'used' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => false,
            'lead_type_used' => true,
            'lead_type_service' => false,
            'shown_cap' => false,
            'fillup_cap' => false,
            'session_close' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => true,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#AE1E25',
                '#AE1E25',
),
            'button_color_hover' => array(
                '#6D1317',
                '#6D1317',
),
            'button_color_active' => array(
                '#6D1317',
                '#6D1317',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => 'Get $200 off voucher from ENS Toyota',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Ens Toyota Team',
            'forward_to' => array(
                'marshal@smedia.ca',
),
            'special_to' => array(
                'adf_to@smedia.ca',
),
            'special_email' => '',
            'display_after' => 30000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
                'service_regex' => '',
),
),
        'new' => array(
            'live' => true,
            'lead_type_' => true,
            'lead_type_new' => true,
            'lead_type_used' => false,
            'lead_type_service' => false,
            'shown_cap' => false,
            'fillup_cap' => false,
            'session_close' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => true,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#AE1E25',
                '#AE1E25',
),
            'button_color_hover' => array(
                '#6D1317',
                '#6D1317',
),
            'button_color_active' => array(
                '#6D1317',
                '#6D1317',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => 'Red Tag Days Sales Event at Ens Toyota',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Ens Toyota Team',
            'forward_to' => array(
                'marshal@smedia.ca',
),
            'special_to' => array(
                'smedia@enstoyota.net',
                'adf_to@smedia.ca',
),
            'special_email' => '<?xml version="1.0"?>
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
            'display_after' => 30000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/inventory\\/(?:new|used|certified-used)-[0-9]{4}-/',
                'service_regex' => '',
),
),
),
    'adf_to' => array(
        'smedia@enstoyota.net',
),
    'buttons_live' => true,
    'form_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'div.vdp-price-box__main-cta-wrapper a',
            'css-class' => 'div.vdp-price-box__main-cta-wrapper a',
            'css-hover' => 'div.vdp-price-box__main-cta-wrapper a:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
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
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#ED1C24,#ED1C24)',
                        'border-color' => 'ED1C24',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
),
),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#425368,#425368)',
                        'border-color' => '425368',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
),
),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '000000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#424242,#424242)',
                        'border-color' => '424242',
),
),
),
),
),
    'name' => 'enstoyota',
);

$CronConfigs["enterprisechevy"] = array (
  'name' => 'enterprisechevy',
  'email' => 'regan@smedia.ca',
  'password' => 'enterprisechevy',
  'log' => true,
  'banner' => 
  array (
    'template' => 'enterprisechevy',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["erinmillsmazda"] = array(
    'name' => 'erinmillsmazda',
    'email' => 'regan@smedia.ca',
    'password' => 'erinmillsmazda',
    'log' => true,
    'customer_id' => '954-929-6462',
    'max_cost' => 885,
    'cost_distribution' => array(
        'adwords' => 885,
),
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'erinmillsmazda',
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => false,
        'exit_intent' => false,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => true,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#222222',
            '#222222',
),
        'button_color_active' => array(
            '#222222',
            '#222222',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'Claim $300 off a purchase of any vehicle!',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\\"[image]\\"/><p><br><br>Erin Mills Mazda Team',
        'forward_to' => array(
            'a_soos@erinmillsmazda.com',
            'f_choudary@erinmillsmazda.com',
),
        'special_to' => array(
            'a_soos@erinmillsmazda.com',
            'f_choudary@erinmillsmazda.com',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
        'button_text' => 'submit',
),
    'smart_memo' => array(
        'live' => false,
        'live_new' => false,
        'live_used' => false,
        'live_home' => false,
        'live_service' => false,
        'video' => false,
        'hide_redirection' => false,
        'video_url' => '',
        'button_text' => 'learn more',
        'url' => 'https://www.erinmillsmazda.ca/contact/',
        'home_url' => 'https://www.erinmillsmazda.ca/',
        'service_regex' => '',
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_text_color' => '#FFFFFF',
        'button_color' => array(
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#222222',
            '#222222',
),
        'button_color_active' => array(
            '#222222',
            '#222222',
),
),
);

$CronConfigs["escoauto"] = array(
    'name' => 'escoauto',
    'email' => 'regan@smedia.ca',
    'password' => 'escoauto',
    'log' => true,
    'max_cost' => 1150,
    'cost_distribution' => array(
        'adwords' => 1150,
),
    'create' => array(),
    'new_descs' => array(
        0 => array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        1 => array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
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
    'customer_id' => '386-001-0505',
    'banner' => array(
        'template' => 'escoauto',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
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
);

$CronConfigs["essendonfordcomau"] = array (
  'name' => 'essendonfordcomau',
  'email' => 'regan@smedia.ca',
  'password' => 'essendonfordcomau',
  'log' => true,
  'combined_feed_mode' => true,
  'fb_title' => '[year] [make] [model] [trim]',
  'banner' => 
  array (
    'template' => 'essendonfordcomau',
    'fb_description' => '[description]',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["essendonmitsubishicomau"] = array (
  'name' => 'essendonmitsubishicomau',
  'email' => 'regan@smedia.ca',
  'password' => 'essendonmitsubishicomau',
  'log' => true,
  'combined_feed_mode' => true,
  'fb_title' => '[year] [make] [model] [trim]',
  'banner' => 
  array (
    'template' => 'essendonmitsubishicomau',
    'fb_description' => '[description]',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["estevanmotors"] = array(
    'name' => 'estevanmotors',
    'email' => 'regan@smedia.ca',
    'password' => 'estevanmotors',
    'log' => true,
    'max_cost' => 300,
    'cost_distribution' => array(
        'adwords' => 300,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '913-873-3864',
    'banner' => array(
        'template' => 'estevanmotors',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
);

$CronConfigs["evergreennissan"] = array(
    'name' => 'evergreennissan',
    'email' => 'regan@smedia.ca',
    'password' => 'evergreennissan',
    'log' => true,
    'max_cost' => 150,
    'cost_distribution' => array(
        'adwords' => 150,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '877-581-2807',
    'bing_account_id' => 156003510,
    'fb_title' => '[year] [make] [model] [price]',
    'banner' => array(
        'template' => 'evergreennissan',
        'fb_description_new' => 'Are you still interested in the [year] [make] [model] [trim]? Click here for more information or give us a call to take it for a test drive!',
        'fb_lookalike_description_new' => 'Check out this [year] [make] [model] [trim]! Click for more information.',
        'fb_description_used' => 'Are you still interested in the [year] [make] [model]? Up To 120% of Market Value on Your Trade! Click here for more information or give us a call to take it for a test drive!',
        'fb_lookalike_description_used' => 'Check out this [year] [make] [model]. Up To 120% of Market Value on Your Trade! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your information, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => 'ffffff',
),
    'lead' => null,
);

$CronConfigs["examplecom"] = array (
  'name' => 'examplecom',
  'email' => 'regan@smedia.ca',
  'password' => 'examplecom',
  'no_adv' => true,
);

$CronConfigs["fairwayfordhendersonnet"] = array( 
	"name"  => "fairwayfordhendersonnet",
	"email" => "regan@smedia.ca",
	"password" => "fairwayfordhendersonnet",
	// "no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["familypowersportscom"] = array (
  'name' => 'familypowersportscom',
  'email' => 'regan@smedia.ca',
  'password' => 'familypowersportscom',
  'log' => true,
  'cities' => 
  array (
    'lubbock' => 
    array (
      'address' => '4202 W Loop 289',
      'city' => 'Lubbock',
      'state' => 'Texas',
      'country_name' => 'USA',
      'post_code' => '79407',
      'full_address' => '4202 W Loop 289 Lubbock, Texas 79407',
      'phone' => '1-806-793-2551',
      'lat' => '33.556870',
      'lng' => '-101.944070',
    ),
    'odessa' => 
    array (
      'address' => '4306 Andrews Hwy',
      'city' => 'Odessa',
      'state' => 'Texas',
      'country_name' => 'USA',
      'post_code' => '79762',
      'full_address' => '4306 Andrews Hwy,Odessa Texas 79762',
      'phone' => '1-432-368-7907',
      'lat' => '31.884480',
      'lng' => '-102.385000',
    ),
  ),
);

$CronConfigs["faulknercdjrfcom"] = array( 
	"name"  => "faulknercdjrfcom",
	"email" => "regan@smedia.ca",
	"password" => "faulknercdjrfcom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["faulknerhondaharrisburgcom"] = array( 
	"name"  => "faulknerhondaharrisburgcom",
	"email" => "regan@smedia.ca",
	"password" => "faulknerhondaharrisburgcom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["faulknernissanmechanicsburgcom"] = array( 
	"name"  => "faulknernissanmechanicsburgcom",
	"email" => "regan@smedia.ca",
	"password" => "faulknernissanmechanicsburgcom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["faulknersubarubethlehemcom"] = array( 
	"name"  => "faulknersubarubethlehemcom",
	"email" => "regan@smedia.ca",
	"password" => "faulknersubarubethlehemcom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["faulknersubaruharrisburgcom"] = array( 
	"name"  => "faulknersubaruharrisburgcom",
	"email" => "regan@smedia.ca",
	"password" => "faulknersubaruharrisburgcom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["faulknersubarumechanicsburgcom"] = array( 
	"name"  => "faulknersubarumechanicsburgcom",
	"email" => "regan@smedia.ca",
	"password" => "faulknersubarumechanicsburgcom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["faulknertoyotaharrisburgcom"] = array( 
	"name"  => "faulknertoyotaharrisburgcom",
	"email" => "regan@smedia.ca",
	"password" => "faulknertoyotaharrisburgcom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["faulknertoyotatrevosecom"] = array( 
	"name"  => "faulknertoyotatrevosecom",
	"email" => "regan@smedia.ca",
	"password" => "faulknertoyotatrevosecom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["faulknervolkswagencom"] = array( 
	"name"  => "faulknervolkswagencom",
	"email" => "regan@smedia.ca",
	"password" => "faulknervolkswagencom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["faulknervolvocarstrevosecom"] = array( 
	"name"  => "faulknervolvocarstrevosecom",
	"email" => "regan@smedia.ca",
	"password" => "faulknervolvocarstrevosecom",
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["fedderlychryslerdodgejeep"] = array(
    'name' => 'fedderlychryslerdodgejeep',
    'email' => 'regan@smedia.ca',
    'password' => 'fedderlychryslerdodgejeep',
    'log' => true,
    'max_cost' => 500,
    'cost_distribution' => array(
        'adwords' => 500,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'live' => false,
            'lead_type_' => false,
            'lead_type_new' => false,
            'lead_type_used' => false,
            'lead_type_service' => false,
            'shown_cap' => false,
            'fillup_cap' => false,
            'session_close' => false,
            'inactivity' => true,
            'exit_intent' => true,
            'session_depth' => false,
            'campaign_cap_google' => false,
            'campaign_cap_fb' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => true,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#FF1010',
                '#FF1010',
),
            'button_color_hover' => array(
                '#002B33',
                '#002B33',
),
            'button_color_active' => array(
                '#002B33',
                '#002B33',
),
            'button_text_color' => '#FFFFFF',
            'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
            'response_email_subject' => '$200 OFF coupon from Fedderly Chrysler',
            'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fedderly Chrysler Team',
            'forward_to' => array(
                'sales@fedderlychrysler.com',
                'mike@fedderlychrysler.com',
                'david@fedderlychrylser.com',
                'marshal@smedia.ca',
),
            'special_to' => array(
                '',
),
            'special_email' => '',
            'display_after' => 30000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'shown_cap_count' => 1,
            'fillup_cap_time_days' => 7,
            'session_close_cap' => 3,
            'inactivity_timeout' => 600000,
            'exit_intent_timeout' => 10000,
            'session_depth_page' => 0,
            'campaign_google_cap_count' => 3,
            'campaign_google_cap_days' => 7,
            'campaign_fb_cap_count' => 3,
            'campaign_fb_cap_days' => 7,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
                'service_regex' => '',
),
            'custom_div' => '',
            'provider_name' => 'sMedia',
            'source' => 'sMedia smartoffer',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '434-979-3525',
    'banner' => array(
        'template' => 'fedderlychryslerdodgejeep',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
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
    'lead' => null,
    'adf_to' => array(
        'sales@fedderlychrysler.com',
        'mike@fedderlychrysler.com',
        'david@fedderlychylser.com',
        'tania102028@gmail.com',
),
    'form_live' => false,
    'buttons_live' => false,
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17579',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);

$CronConfigs["fieldofrvdreamscom"] = array (
  'name' => 'fieldofrvdreamscom',
  'email' => 'regan@smedia.ca',
  'password' => 'fieldofrvdreamscom',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'fieldofrvdreamscom',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["fishcreeknissancalgaryca"] = array(
    'name' => 'fishcreeknissancalgaryca',
    'email' => 'regan@smedia.ca',
    'password' => 'fishcreeknissancalgaryca',
    'log' => true,
    'combined_feed_mode' => true,
    'lead' => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'inactivity' => true,
        'exit_intent' => true,
        'session_depth' => false,
        'campaign_cap_google' => false,
        'campaign_cap_fb' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'sent_client_email' => false,
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#C4172C',
            '#C4172C',
),
        'button_color_hover' => array(
            '#000000',
            '#000000',
),
        'button_color_active' => array(
            '#DF3247',
            '#DF3247',
),
        'button_text_color' => '#FFFFFF',
        'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
        'response_email_subject' => 'Claim $200 Off with a purchase from Fish Creek Nissan',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fish Creek Nissan Team',
        'forward_to' => array(
            '',
),
        'special_to' => array(
            'Array',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
        'shown_cap_count' => 1,
        'fillup_cap_time_days' => 7,
        'session_close_cap' => 3,
        'inactivity_timeout' => 600000,
        'exit_intent_timeout' => 10000,
        'session_depth_page' => 0,
        'campaign_google_cap_count' => 3,
        'campaign_google_cap_days' => 7,
        'campaign_fb_cap_count' => 3,
        'campaign_fb_cap_days' => 7,
        'video_smart_offer' => false,
        'video_smart_offer_form' => false,
        'video_url' => '',
        'video_title' => '',
        'video_description' => '',
        'lead_in' => array(
            'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
            'service_regex' => '',
),
        'custom_div' => '',
        'provider_name' => 'sMedia',
        'source' => 'sMedia smartoffer',
),
    'form_live' => true,
    'buttons_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1',
    'buttons' => array(
        'payment-options' => array(
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '#av_widget-f7ff483b-bd30-45f2-85aa-508d8803de41 div div  a',
            'css-class' => '#av_widget-f7ff483b-bd30-45f2-85aa-508d8803de41 div div  a',
            'css-hover' => '#av_widget-f7ff483b-bd30-45f2-85aa-508d8803de41 div div  a:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'payment-options' => array(
                    'target' => '#av_widget-f7ff483b-bd30-45f2-85aa-508d8803de41 div div  a',
                    'values' => array(
                        'Explore Payments',
                        'Calculate Your Payments',
                        'Estimate Payments',
                        'Payment Options',
                        'Financing Options',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0E5BFF,#0E5BFF)',
                        'border-color' => '0E5BFF',
                        'color' => '#fff',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '16px',
                        'line-height' => '40px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#192EFF,#192EFF)',
                        'border-color' => '192EFF',
                        'color' => '#fff',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '16px',
                        'line-height' => '40px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFA500,#FFA500)',
                        'border-color' => 'FFA500',
                        'color' => '#fff',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '16px',
                        'line-height' => '40px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#E49300,#E49300)',
                        'border-color' => 'E49300',
                        'color' => '#fff',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '16px',
                        'line-height' => '40px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BEBE00,#CDCD00)',
                        'border-color' => 'D2D200',
                        'color' => '#fff',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '16px',
                        'line-height' => '40px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D2AB07,#CDA707)',
                        'border-color' => 'DAB108',
                        'color' => '#fff',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '16px',
                        'line-height' => '40px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#07A73A,#07A73A)',
                        'border-color' => '07A73A',
                        'color' => '#fff',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '16px',
                        'line-height' => '40px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#069C36,#069734)',
                        'border-color' => '07A238',
                        'color' => '#fff',
                        'font-family' => 'Raleway, arial, sans-serif',
                        'font-size' => '16px',
                        'line-height' => '40px',
                        'margin' => '10px 0 0',
                        'padding' => '9px 10px',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
),
),
        'request-a-quote' => array(
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '#vdp_button_widget-8 a',
            'css-class' => '#vdp_button_widget-8 a',
            'css-hover' => '#vdp_button_widget-8 a:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => '#vdp_button_widget-8 a',
                    'values' => array(
                        'Get a Quote',
                        'Request a Quote',
                        'Get Internet Price',
                        'Get E-Price Now',
                        'Get Special Price',
                        'Get Your Best Price',
                        'Get Your Exclusive Price',
                        'Today\'s Quote',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0E5BFF,#0E5BFF)',
                        'border-color' => '0E5BFF',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#192EFF,#192EFF)',
                        'border-color' => '192EFF',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFA500,#FFA500)',
                        'border-color' => 'FFA500',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#E49300,#E49300)',
                        'border-color' => 'E49300',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BEBE00,#CDCD00)',
                        'border-color' => 'D2D200',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D2AB07,#CDA707)',
                        'border-color' => 'DAB108',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#07A73A,#07A73A)',
                        'border-color' => '07A73A',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#069C36,#069734)',
                        'border-color' => '07A238',
                        'color' => '#fff',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '#vdp_button_widget-10  a',
            'css-class' => '#vdp_button_widget-10 a',
            'css-hover' => '#vdp_button_widget-10 a:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => '#vdp_button_widget-10 a',
                    'values' => array(
                        'Schedule a Test Drive',
                        'Request a Test Drive',
                        'Schedule Your Visit',
                        'Test Drive Today',
                        'Want To Test Drive?',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0E5BFF,#0E5BFF)',
                        'border-color' => '0E5BFF',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#192EFF,#192EFF)',
                        'border-color' => '192EFF',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFA500,#FFA500)',
                        'border-color' => 'FFA500',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#E49300,#E49300)',
                        'border-color' => 'E49300',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BEBE00,#CDCD00)',
                        'border-color' => 'D2D200',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D2AB07,#CDA707)',
                        'border-color' => 'DAB108',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#07A73A,#07A73A)',
                        'border-color' => '07A73A',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#069C36,#069734)',
                        'border-color' => '07A238',
                        'color' => '#fff',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'div a[data-av-button-product="credit"]',
            'css-class' => 'div a[data-av-button-product="credit"]',
            'css-hover' => 'div a[data-av-button-product="credit"]:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'div a[data-av-button-product="credit"]',
                    'values' => array(
                        'Get Financed Today!',
                        'Apply For Financing',
                        'Financing Available',
                        'Special Finance Offers',
                        'Get Approved Today',
                        'Get Your Loan Online',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0E5BFF,#0E5BFF)',
                        'border-color' => '0E5BFF',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#192EFF,#192EFF)',
                        'border-color' => '192EFF',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFA500,#FFA500)',
                        'border-color' => 'FFA500',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#E49300,#E49300)',
                        'border-color' => 'E49300',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BEBE00,#CDCD00)',
                        'border-color' => 'D2D200',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D2AB07,#CDA707)',
                        'border-color' => 'DAB108',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#07A73A,#07A73A)',
                        'border-color' => '07A73A',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#069C36,#069734)',
                        'border-color' => '07A238',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
),
),
        'trade-in' => array(
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'div a[data-av-button-product="tradein"]',
            'css-class' => 'div a[data-av-button-product="tradein"]',
            'css-hover' => 'div a[data-av-button-product="tradein"]:hover',
            'button_action' => array(
                'form',
                'trade-in',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'trade-in' => array(
                    'target' => 'div a[data-av-button-product="tradein"]',
                    'values' => array(
                        'Value Your Trade',
                        'Trade-In Offer',
                        'We Want Your Trade!',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0E5BFF,#0E5BFF)',
                        'border-color' => '0E5BFF',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#192EFF,#192EFF)',
                        'border-color' => '192EFF',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFA500,#FFA500)',
                        'border-color' => 'FFA500',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#E49300,#E49300)',
                        'border-color' => 'E49300',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BEBE00,#CDCD00)',
                        'border-color' => 'D2D200',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D2AB07,#CDA707)',
                        'border-color' => 'DAB108',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#07A73A,#07A73A)',
                        'border-color' => '07A73A',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#069C36,#069734)',
                        'border-color' => '07A238',
                        'color' => '#fff',
                        'display' => 'block',
                        'float' => 'none',
                        'font-size' => '16px',
                        'font-weight' => '400',
                        'line-height' => '17px',
                        'margin' => '10px 0px',
                        'padding' => '12px 10px',
                        'position' => 'relative',
                        'text-align' => 'center',
                        'text-decoration' => 'none',
),
),
),
),
),
);

$CronConfigs["flexibuycomau"] = array (
  'name' => 'flexibuycomau',
  'email' => 'regan@smedia.ca',
  'password' => 'flexibuycomau',
  'log' => true,
  'fb_title' => '[year] [make] [model] [trim]',
);

$CronConfigs["flexigocomau"] = array (
  'name' => 'flexigocomau',
  'email' => 'regan@smedia.ca',
  'password' => 'flexigocomau',
  'log' => true,
  'combined_feed_mode' => true,
  'fb_title' => '[year] [make] [model] [trim]',
);

$CronConfigs["folsombuickgmc"] = array(
    'name' => 'folsombuickgmc',
    'email' => 'regan@smedia.ca',
    'password' => 'folsombuickgmc',
    'combined_feed_mode' => true,
    'log' => true,
    'banner' => array(
        'template' => 'folsombuickgmc',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
);

$CronConfigs["folsomlakevw"] = array(
    'name' => 'folsomlakevw',
    'email' => 'regan@smedia.ca',
    'password' => 'folsomlakevw',
    'log' => true,
    'banner' => array(
        'template' => 'folsomlakevw',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => 'ffffff',
),
    'lead' => null,
    'lead_to' => array(
        'ckoupas@folsomlakevw.com',
        'aileads@smedia.ca',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => '.vehicle-action-btn button[data-url*=contact-form]',
            'css-class' => '.vehicle-action-btn button[data-url*=contact-form]',
            'css-hover' => '.vehicle-action-btn button[data-url*=contact-form]:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => '.vehicle-action-btn button[data-url*=contact-form]',
                    'values' => array(
                        'Get More Information',
                        'Ask for More Info',
                        'Learn More',
                        'More Info',
                        'Ask a Question',
                        'Let Our Experts Help',
                        'Ask an Expert',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#083167,#083167)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#06254E,#06254E)',
                        'border-color' => 'C60C0D',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6633,#FF6633)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D05329,#D05329)',
                        'border-color' => 'C60C0D',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#01B1EB,#01B1EB)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#009CCF,#009CCF)',
                        'border-color' => 'C60C0D',
),
),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#32312C,#32312C)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#252421,#252421)',
                        'border-color' => 'C60C0D',
),
),
),
),
        'test-drive' => array(
            'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => '.vehicle-action-btn button[data-url*=schedule-testdrive]',
            'css-class' => '.vehicle-action-btn button[data-url*=schedule-testdrive]',
            'css-hover' => '.vehicle-action-btn button[data-url*=schedule-testdrive]:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => '.vehicle-action-btn button[data-url*=schedule-testdrive]',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
),
),
),
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#083167,#083167)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#06254E,#06254E)',
                        'border-color' => 'C60C0D',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6633,#FF6633)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D05329,#D05329)',
                        'border-color' => 'C60C0D',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#01B1EB,#01B1EB)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#009CCF,#009CCF)',
                        'border-color' => 'C60C0D',
),
),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#32312C,#32312C)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#252421,#252421)',
                        'border-color' => 'C60C0D',
),
),
),
),
),
);

$CronConfigs["forbeskiabridgewaterca"] = array (
  'name' => 'forbeskiabridgewaterca',
  'email' => 'regan@smedia.ca',
  'password' => 'forbeskiabridgewaterca',
  'log' => true,
  'combined_feed_mode' => true,
  'banner' => 
  array (
    'template' => 'forbeskiabridgewaterca',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
);

$CronConfigs["fortfrancesgm"] = array(
    'name' => 'fortfrancesgm',
    'email' => 'regan@smedia.ca',
    'password' => 'fortfrancesgm',
    'log' => true,
    'combined_feed_mode' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'fb_title' => '[year] [make] [model] [price]',
    'bing_account_id' => 156002977,
    'max_cost' => 500,
    'cost_distribution' => array(
        'adwords' => 500,
        'youtube' => 0,
),
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '298-616-7164',
    'banner' => array(
        'template' => 'fortfrancesgm',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
),
    'lead' => null,
    'smart_memo' => array(
        'live' => false,
        'live_new' => false,
        'live_used' => false,
        'live_home' => false,
        'live_service' => false,
        'video' => false,
        'hide_redirection' => false,
        'video_url' => 'https://www.youtube.com/watch?v=wCFi9s3LhBU&ab_channel=sMediaProofs',
        'button_text' => 'BUILD AND PRICE',
        'url' => 'https://www.fortfrancesgm.com/en/shop-online',
        'home_url' => 'https://www.fortfrancesgm.com/en',
        'service_regex' => '',
        'bg_color' => '#ADADAD',
        'text_color' => '#404450',
        'border_color' => '#969696',
        'button_text_color' => '#DEDEDE',
        'button_color' => array(
            '#FF0000',
            '#FF0000',
),
        'button_color_hover' => array(
            '#D92929',
            '#D92929',
),
        'button_color_active' => array(
            '#D92929',
            '#D92929',
),
),
);

$CronConfigs["fortmotors"] = array(
    'name' => 'fortmotors',
    'email' => 'regan@smedia.ca',
    'password' => 'fortmotors',
    'log' => true,
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'fortmotors',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'lead_to' => array(
        'mshant1@fortmotors.ca',
        'alanbourdon1@outlook.com',
        'ctymchuk@fortmotors.ca',
),
    'form_live' => false,
    'buttons_live' => false,
);

$CronConfigs["fortmyersmitsubishi"] = array (
  'password' => 'fortmyersmitsubishi',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'bing_account_id' => 156002961,
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'max_cost' => 0,
  'cost_distribution' => 
  array (
    'adwords' => 0,
  ),
  'create' => 
  array (
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'customer_id' => '157-509-1231',
  'banner' => 
  array (
    'template' => 'fortmyersmitsubishi',
    'fb_description_new' => 'Are you still interested in the [year] [make] [model]? Roadside assistance plan, 10 year/100,000 Mile limited powertrain warranty, 5 year bumper to bumper new vehicle warranty. Ask us for details!',
    'fb_description_used' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description_new' => 'Check out this [year] [make] [model] today! Roadside assistance plan, 10 year/100,000 Mile limited powertrain warranty, 5 year bumper to bumper new vehicle warranty. Ask us for details!',
    'fb_lookalike_description_used' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'font_color' => '#ffffff',
  ),
  'name' => 'fortmyersmitsubishi',
);

$CronConfigs["fortwayneinfiniti"] = array(
    'name' => 'fortwayneinfiniti',
    'email' => 'regan@smedia.ca',
    'password' => 'fortwayneinfiniti',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'combined_feed_mode' => true,
    'banner' => array(
        'template' => 'fortwayneinfiniti',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
);

$CronConfigs["fortwaynekia"] = array(
    'name' => 'fortwaynekia',
    'email' => 'regan@smedia.ca',
    'password' => 'fortwaynekia',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'fb_title' => '[year] [make] [model] [price]',
    'banner' => array(
        'template' => 'fortwaynekia',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
        'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'max_cost' => 400,
    'cost_distribution' => array(
        'adwords' => 400,
),
);

$CronConfigs["fortwaynenissan"] = array(
    'name'              => 'fortwaynenissan',
    'email'             => 'regan@smedia.ca',
    'password'          => 'fortwaynenissan',
    'log'               => true,
    'customer_id'       => '581-258-4035',
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    'fb_title'          => '[year] [make] [model] [trim] [price]',
    'banner'            => array(
        'template'                 => 'fortwaynenissan',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click to view discounts!',
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'font_color'               => '#ffffff',
    ),
    'lead'              => array(
        'live'                   => false,
        'lead_type_'             => false,
        'lead_type_new'          => false,
        'lead_type_used'         => false,
        'shown_cap'              => false,
        'fillup_cap'             => false,
        'session_close'          => false,
        'device_type'            => array(
            'mobile'  => true,
            'desktop' => true,
            'tablet'  => true,
        ),
        'offer_minimum_price'    => 0,
        'offer_maximum_price'    => 10000000,
        'bg_color'               => '#EFEFEF',
        'text_color'             => '#404450',
        'border_color'           => '#E5E5E5',
        'button_color'           => array(
            '#C3002F',
            '#C3002F',
        ),
        'button_color_hover'     => array(
            '#000000',
            '#000000',
        ),
        'button_color_active'    => array(
            '#000000',
            '#000000',
        ),
        'button_text_color'      => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Fort Wayne Nissan',
        'response_email'         => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fort Wayne Nissan Team',
        'forward_to'             => array(
            'marshal@smedia.ca',
        ),
        'special_to'             => array(
            'leads@fortwaynenissan.com',
        ),
        'special_email'          => '',
        'display_after'          => 30000,
        'retarget_after'         => 5000,
        'fb_retarget_after'      => 5000,
        'adword_retarget_after'  => 5000,
        'visit_count'            => 0,
        'lead_in'                => array(
            'vdp'           => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
    'max_cost'          => 814,
    'cost_distribution' => array(
        'new'  => 407,
        'used' => 407,
    ),
);

$CronConfigs["fortwaynetoyota"] = array(
    "name" => " fortwaynetoyota",
    "email" => "regan@smedia.ca",
    "password" => " fortwaynetoyota",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    //=====dynamic social ads=====
    "banner" => array(
        "template" => "fortwaynetoyota",
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => null,
);

$CronConfigs["foundationchryslergrouplogincmsdealercom"] = array( 
	"name"  => "foundationchryslergrouplogincmsdealercom",
	"email" => "regan@smedia.ca",
	"password" => "foundationchryslergrouplogincmsdealercom",
	"no_adv" => true,
	"log" => false,
	"combined_feed_mode" => true,
);

$CronConfigs["foundationsquamishchrysler"] = array(
    'name' => 'foundationsquamishchrysler',
    'email' => 'regan@smedia.ca',
    'password' => 'foundationsquamishchrysler',
    'no_adv' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'banner' => array(
        'template' => 'foundationsquamishchrysler',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
    'lead_to' => array(
        'adamm@foundationauto.com',
        'anthonym@foundationsquamish.com',
        'sales@foundationsquamish.com',
        'daveb@foundationsquamish.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => NULL,
            'locations' => array(
                'default' => NULL,
),
            'action-target' => 'a[href*=eprice-form]',
            'css-class' => 'a[href*=eprice-form]',
            'css-hover' => 'a[href*=eprice-form]:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a[href*=eprice-form]',
                    'values' => array(
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Current Market Price',
                        'Today\'s Market Price',
                        'Get Special Price',
                        'Request a Quote',
                        'Get a Quote',
                        'Inquire Now',
                        'Inquire Today',
),
),
),
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BF0E0D,#BF0E0D)',
                        'border-color' => 'BF0E0D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ECF3FA,#ECF3FA)',
                        'border-color' => 'D1E2F3',
                        'color' => ' #0D65BF',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#65BF0D,#65BF0D)',
                        'border-color' => '65BF0D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ECF3FA,#ECF3FA)',
                        'border-color' => 'D1E2F3',
                        'color' => ' #0D65BF',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#08A8A9,#08A8A9)',
                        'border-color' => '08A8A9',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ECF3FA,#ECF3FA)',
                        'border-color' => 'D1E2F3',
                        'color' => ' #0D65BF',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0D65BF,#0D65BF)',
                        'border-color' => '0D65BF',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ECF3FA,#ECF3FA)',
                        'border-color' => 'D1E2F3',
                        'color' => ' #0D65BF',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#BF670D,#BF670D)',
                        'border-color' => 'BF670D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ECF3FA,#ECF3FA)',
                        'border-color' => 'D1E2F3',
                        'color' => ' #0D65BF',
),
),
),
),
),
);

$CronConfigs["fourseasonssales"] = array (
  'name' => 'fourseasonssales',
  'email' => 'regan@smedia.ca',
  'password' => 'fourseasonssales',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'banner' => 
  array (
    'template' => 'fourseasonssales',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'cities' => 
  array (
    'Virden' => 
    array (
      'address' => 'Box 968 Trans-Canada Highway No 1',
      'city' => 'Virden',
      'state' => 'Manitoba',
      'country_name' => 'Canada',
      'post_code' => 'R0M 2C0',
      'full_address' => 'Box 968 Trans-Canada Highway No 1, Virden, Manitoba MB R0M 2C0',
      'phone' => '1-888-934-4444',
      'lat' => '49.879290',
      'lng' => '-100.981490',
    ),
    'Winnipeg' => 
    array (
      'address' => '5130 Portage Avenue',
      'city' => 'Winnipeg',
      'state' => 'Manitoba',
      'country_name' => 'Canada',
      'post_code' => 'R4H 1E1',
      'full_address' => '5130 Portage Avenue, Headingley, Winnipeg, MB, R4H 1E1',
      'phone' => '1-204-895-8882',
      'lat' => '49.875180',
      'lng' => '-97.394350',
    ),
    'Regina' => 
    array (
      'address' => 'Hwy 1 and 6',
      'city' => 'Regina',
      'state' => 'Saskatchewan',
      'country_name' => 'Canada',
      'post_code' => 'S4P 5A8',
      'full_address' => 'Hwy 1 and 6, Regina, SK, S4P 5A8',
      'phone' => '1-877-789-3311',
      'lat' => '50.407970',
      'lng' => '-104.589690',
    ),
  ),
);

$CronConfigs["frankdunntrailersales"] = array(
  'name'     => 'frankdunntrailersales',
  'email'    => 'regan@smedia.ca',
  'password' => 'frankdunntrailersales',
  'log'      => true,
  'banner'   => array(
    'template'                   => 'frankdunntrailersales',
    'fb_description'             => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description'   => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_snowbird_description'    => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_nonblowout_description'  => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style'                => 'default',
    'border_color'               => '#282828',
    'font_color'                 => '#ffffff',
  ),
  'lead'     => array(
    'live'                   => true,
    'lead_type_'             => true,
    'lead_type_new'          => true,
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
      '#00FFBA',
      '#0084FF',
    ),
    'button_color_hover'     => array(
      '#005941',
      '#0084FF',
    ),
    'button_color_active'    => array(
      '#005941',
      '#0084FF',
    ),
    'button_text_color'      => '#FFFFFF',
    'response_email_subject' => 'Spring Fever - Frank Dunn RV Sales',
    'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Frank Dunn RV Sales Team',
    'forward_to'             => array(
      'marshal@smedia.ca',
      'gwoytowich@frankdunnrv.com',
    ),
    'special_to'             => array(
      'gwoytowich@frankdunnrv.com',
    ),
    'special_email'          => '<?xml version="1.0"?>
        <?adf version="1.0"?>
        <adf>
          <prospect>
            <id sequence="[total_count]" source="Frank Dunn RV"></id>
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
                <name part="full">Frank Dunn RV</name>
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
      'vdp'           => '/\\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
      'service_regex' => '',
    ),
    'custom_div'             => '',
  ),
);

$CronConfigs["fraservalleyalfaromeoca"] = array( 
	"name"  => "fraservalleyalfaromeoca",
	"email" => "regan@smedia.ca",
	"password" => "fraservalleyalfaromeoca",
	// "no_adv" => true,
	"log" => true,
	"combined_feed_mode" => true,
);

$CronConfigs["frederictonhyundai"] = array(
    'name' => 'frederictonhyundai',
    'email' => 'regan@smedia.ca',
    'password' => 'frederictonhyundai',
    'log' => true,
    'banner' => array(
        'template' => 'frederictonhyundai',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
),
    'lead' => null,
);

$CronConfigs["frederictonmitsubishi"] = array(
    'password'          => 'frederictonmitsubishi',
    'email'             => 'regan@smedia.ca',
    'log'               => true,
    'adgroup_version'   => 'v8',
    'fb_title'          => '[year] [make] [model] [trim] [price]',
    'fb_brand'          => '[year] [make] [model] - [trim]',
    'customer_id'       => '388-803-1635',
    'max_cost'          => 3900,
    'cost_distribution' => array(
        'adwords' => 3900,
    ),
    'create'            => array(),
    'new_descs'         => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'used_descs'        => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
        ),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
        ),
    ),
    'banner'            => array(
        'template'                 => 'frederictonmitsubishi',
        'fb_description'           => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style'              => 'default',
        'border_color'             => '#282828',
        'styels'                   => array(
            'new_display'       => 'dynamic_banner',
            'used_display'      => 'dynamic_banner',
            'new_retargeting'   => 'dynamic_banner',
            'used_retargeting'  => 'dynamic_banner',
            'new_marketbuyers'  => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
        ),
        'font_color'               => '#ffffff',
    ),
    'name'              => 'frederictonmitsubishi',
);

$CronConfigs["freespiritmarinecom"] = array(
    "name" => "freespiritmarinecom",
    "email" => "regan@smedia.ca",
    "password" => "freespiritmarinecom",
    //"no_adv" => true,
    "log" => true,
    "combined_feed_mode" => true,
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
);

$CronConfigs["freewaymazda"] = array(
    'name' => 'freewaymazda',
    'password' => 'freewaymazda',
    'max_cost' => 1241,
    'email' => 'regan@smedia.ca',
    'retargetting_delay' => 30000,
    'combined_feed_mode' => true,
    'log' => true,
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model]',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'options_descs' => array(
        array(
            'desc1' => 'Equipped with [option]',
            'desc2' => 'and [option]',
),
),
    'ymmcount_descs' => array(
        array(
            'desc1' => 'We have [ymmcount] [make]',
            'desc2' => '[model] in stock',
),
),
    'customer_id' => '576-499-2788',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'freewaymazda',
        'fb_description' => 'Are yo