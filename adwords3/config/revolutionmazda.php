<?php

global $CronConfigs;
$CronConfigs["revolutionmazda"] = array(
    "name" => " revolutionmazda",
    "email" => "regan@smedia.ca",
    "password" => " revolutionmazda",
    "log" => true,
    "customer_id" => "979-921-0156",
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
    'fb_title' => '[year] [make] [model] [body_style] [price]',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "revolutionmazda",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information",
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
    'bing_account_id' => 156003054,
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
            '#910A2D',
            '#910A2D',
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
        'response_email_subject' => 'Get $200 off coupon from Revolution Mazda',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Revolution Mazda Team',
        'forward_to' => array(
            'imakarov@revolutionautogroup.ca',
            'pjohnson@revolutionautogroup.ca',
            'mparreno@revolutionautogroup.ca',
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
            'vdp' => '/\\/inventory\\/[0-9]{4}-/i',
            'service' => '',
),
),
    'adf_to' => array(
        '',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'test-drive' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href *=test-drive].car-action-unit.stm-schedule',
            'css-class' => 'a[href *=test-drive].car-action-unit.stm-schedule',
            'css-hover' => 'a[href *=test-drive].car-action-unit.stm-schedule:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href *=test-drive].car-action-unit.stm-schedule',
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
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4977C1,#4977C1)',
                        'border-color' => '4977C1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#375C97,#375C97)',
                        'border-color' => '375C97',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#800000,#800000)',
                        'border-color' => '800000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5E0000,#5E0000)',
                        'border-color' => '5E0000',
                        'color' => '#fff',
),
),
                'grey' => array(
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
        'request-information' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.stm-car_dealer-buttons.heading-font a[href *=tab-dealer-contact]',
            'css-class' => 'div.stm-car_dealer-buttons.heading-font a[href *=tab-dealer-contact]',
            'css-hover' => 'div.stm-car_dealer-buttons.heading-font a[href *=tab-dealer-contact]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'div.stm-car_dealer-buttons.heading-font a[href *=tab-dealer-contact]',
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
                'grey' => array(
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#800000,#800000)',
                        'border-color' => '800000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5E0000,#5E0000)',
                        'border-color' => '5E0000',
                        'color' => '#fff',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4977C1,#4977C1)',
                        'border-color' => '4977C1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#375C97,#375C97)',
                        'border-color' => '375C97',
                        'color' => '#fff',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.stm-car_dealer-buttons.heading-font a[href *=financing]',
            'css-class' => 'div.stm-car_dealer-buttons.heading-font a[href *=financing]',
            'css-hover' => 'div.stm-car_dealer-buttons.heading-font a[href *=financing]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div.stm-car_dealer-buttons.heading-font a[href *=financing]',
                    'values' => array(
                        'No Hassle Financing',
                        'Get Financed Today',
                        'Financing Available',
                        'Apply for Financing',
                        'Special Finance Offers',
),
],
],
            'styles' => array(
                'grey' => array(
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#800000,#800000)',
                        'border-color' => '800000',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5E0000,#5E0000)',
                        'border-color' => '5E0000',
                        'color' => '#fff',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4977C1,#4977C1)',
                        'border-color' => '4977C1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#375C97,#375C97)',
                        'border-color' => '375C97',
                        'color' => '#fff',
),
),
),
],
],
);