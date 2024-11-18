<?php

global $CronConfigs;
$CronConfigs["revolutionkia"] = array(
    "name" => " revolutionkia",
    "email" => "regan@smedia.ca",
    "password" => " revolutionkia",
    "log" => true,
    //'no_adv' => true,
    "customer_id" => "323-379-7891",
    'max_cost' => 760,
    'cost_distribution' => array(
        'adwords' => 760,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "banner" => array(
        "template" => "revolutionkia",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'bing_account_id' => 156003053,
    "new_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
),
    "used_descs" => array(
        array(
            "desc1" => "[year] [make] [model] ",
            "desc2" => "only [Price]! Call Today",
),
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
),
    "lead" => array(
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
            '#BB162B',
            '#BB162B',
),
        'button_color_hover' => array(
            '#1A1A1A',
            '#1A1A1A',
),
        'button_color_active' => array(
            '#1A1A1A',
            '#1A1A1A',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $200 off coupon from Revolution Kia',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Revolution Kia Team',
        'forward_to' => array(
            'imakarov@revolutionautogroup.ca',
            'lobrien@revolutionautogroup.ca',
            'jdeblois@revolutionautogroup.ca',
            'leadtracking@branduagency.ca',
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
            'vdp' => '/\\/cars\\/[0-9]{4}-/i',
            'service' => '',
),
),
    'adf_to' => array(
        '',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-information' => [
            'url-match' => '/\\/cars\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-target*="#request_more_info_mdl"]',
            'css-class' => 'a[data-target*="#request_more_info_mdl"]',
            'css-hover' => 'a[data-target*="#request_more_info_mdl"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'a[data-target*="#request_more_info_mdl"]',
                    'values' => array(
                        'Get More Information',
                        'Ask for More Info',
                        'Learn More',
                        'More Info',
                        'Ask a Question',
                        'Let Our Experts Help',
                        'Ask an Expert',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2F64AA,#2F64AA)',
                        'border-color' => '2F64AA',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A944,#00A944)',
                        'border-color' => '00A944',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#008335,#008335)',
                        'border-color' => '008335',
                        'color' => '#fff',
),
),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#848484,#848484)',
                        'border-color' => '848484',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#6A6A6A,#6A6A6A)',
                        'border-color' => '6A6A6A',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/cars\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-target*="#shedule_test_drive"]',
            'css-class' => 'a[data-target*="#shedule_test_drive"]',
            'css-hover' => 'a[data-target*="#shedule_test_drive"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[data-target*="#shedule_test_drive"]',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
                        'Request Walk-Around Video',
                        'Request Video Tour',
                        'Request Virtual Test Drive',
                        'Remote Test Drive',
                        'Virtual Test Drive',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2F64AA,#2F64AA)',
                        'border-color' => '2F64AA',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00A944,#00A944)',
                        'border-color' => '00A944',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#008335,#008335)',
                        'border-color' => '008335',
                        'color' => '#fff',
),
),
                'gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#848484,#848484)',
                        'border-color' => '848484',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#6A6A6A,#6A6A6A)',
                        'border-color' => '6A6A6A',
                        'color' => '#fff',
),
),
),
],
],
);