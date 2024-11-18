<?php

global $CronConfigs;
$CronConfigs["lathamfordmotors"] = array(
    'password' => 'lathamfordmotors',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
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
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#0D65BF',
            '#094481',
),
        'button_color_hover' => array(
            '#094481',
            '#0D65BF',
),
        'button_color_active' => array(
            '#E1A504',
            '#E1A504',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $200 off with this offer from  Latham Ford',
        'response_email' => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br> Latham Ford',
        'forward_to' => array(
            'lathammotors@forddirectcrm.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'lathammotors@forddirectcrm.com',
),
        'special_email' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="Latham Ford"></id>
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
                <name part="full">Latham Ford</name>
                <email>[dealer_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia</name>
            <url>http://smedia.ca</url>
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
            'vdp' => '/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service' => '',
),
),
    'max_cost' => 0,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => yes,
        "used_display" => yes,
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
    'customer_id' => '995-961-5451',
    "banner" => array(
        "template" => "lathamfordmotors",
        "fb_retargeting_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_retargetingv2_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_lookalikev2_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information - a product specialist will get in touch to help.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "font_color" => "#ffffff",
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17594',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);