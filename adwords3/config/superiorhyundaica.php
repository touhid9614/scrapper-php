<?php

global $CronConfigs;

$CronConfigs["superiorhyundaica"] = array(
    "name"                 => "superiorhyundaica",
    "email"                => "regan@smedia.ca",
    "password"             => "superiorhyundaica",
    "log"                  => true,
    'customer_id'          => '329-898-8748',
    'max_cost'             => 900,
    'cost_distribution'    => array(
        'adwords' => 900,
    ),
    'combined_feed_mode'   => true,
    "banner"               => array(
        "template"                      => "superiorhyundaica",
        "hst"                           => yes,
        "fb_description"           => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "fb_dynamiclead_description"    => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style"                   => "default",
        "border_color"                  => "#282828",
        "font_color"                    => "#ffffff",
    ),
    'lead'                 => array(
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
            'bg_color'               => '#FFFFFF',
            'text_color'             => '#404450',
            'border_color'           => '#E5E5E5',
            'button_color'           => array(
                '#002C5F',
                '#002C5F',
            ),
            'button_color_hover'     => array(
                '#001A38',
                '#001A38',
            ),
            'button_color_active'    => array(
                '#101010',
                '#101010',
            ),
            'button_text_color'      => '#FFFFFF',
            'response_email_subject' => 'Get $200 off coupon from Superior Hyundai',
            'response_email'         => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Superior Hyundai Team',
            'forward_to'             => array(
                'khurdis@superiorhyundai.ca',
                'amendes@superiorhyundai.ca',
                'wmair@superiorhyundai.ca',
                'marshal@smedia.ca',
                'jniskanen@superiorhyundai.ca',
            ),
            'special_to'             => array(
                'smedia@marosticahyundai.net',
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
                'vdp'     => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
                'service' => '',
            ),
            'custom_div'             => '',
        ),
    ),
    'lead_config_function' => function ($lead_config) {
        $lead_config['special_to'] = array_diff($lead_config['special_to'], [
            'adf_to@smedia.ca',
        ]);
        return $lead_config;
    },
);
