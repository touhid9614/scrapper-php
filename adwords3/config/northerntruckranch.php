<?php

global $CronConfigs;
$CronConfigs["northerntruckranch"] = array(
    "name" => " northerntruckranch",
    "email" => "regan@smedia.ca",
    "password" => " northerntruckranch",
    "log" => true,
    "banner" => array(
        "template" => "northerntruckranch",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
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
            '#E00417',
            '#E00417',
),
        'button_color_hover' => array(
            '#111111',
            '#111111',
),
        'button_color_active' => array(
            '#111111',
            '#111111',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 off coupon from Northern Truck Ranch',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Northern Truck Ranch Team',
        'forward_to' => array(
            'sales@northerntruckranch.com',
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
),
    'lead_to' => array(
        '',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'financing' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.apply-for-finnance a[href *=financing-application]',
            'css-class' => 'div.apply-for-finnance a[href *=financing-application]',
            'css-hover' => 'div.apply-for-finnance a[href *=financing-application]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div.apply-for-finnance a[href *=financing-application]',
                    'values' => array(
                        'Get Your Financing',
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E90D21,#E90D21)',
                        'border-color' => 'E90D21',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C40C1C,#C40C1C)',
                        'border-color' => 'C40C1C',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#20225F,#20225F)',
                        'border-color' => '20225F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#161847,#161847)',
                        'border-color' => '161847',
),
),
),
],
],
);