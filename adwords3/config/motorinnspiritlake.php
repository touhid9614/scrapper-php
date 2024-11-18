<?php

global $CronConfigs;
$CronConfigs["motorinnspiritlake"] = array(
    'password' => 'motorinnspiritlake',
    "email" => "regan@smedia.ca",
    'log' => true,
    'combined_feed_mode' => true,
    //'no_adv' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "customer_id" => "160-678-4885",
    'max_cost' => 3100,
    'cost_distribution' => array(
        'adwords' => 3100,
),
    'bing_account_id' => 156002897,
    "create" => array(
		"used_search" => true, // Enable https://app.asana.com/0/1130574294408771/1200541154201687
		"new_search" => true, // Enable https://app.asana.com/0/1130574294408771/1200541154201687
        // don't enable v1 campaign - Arif
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
    "banner" => array(
        "template" => "motorinnspiritlake",
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => '[year] [make] [model] - Click to check availability or see discounts and details!',
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
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
            '#0054A6',
            '#0054A6',
),
        'button_color_hover' => array(
            '#004E9B',
            '#004E9B',
),
        'button_color_active' => array(
            '#004E9B',
            '#004E9B',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$1000 cash back from Motor Inn Auto',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Motor Inn Auto Team',
        'forward_to' => array(
            'Spencer.heywood@motorinnmail.com',
            'shahadathossainece08@gmail.com',
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
        'Spencer.heywood@motorinnmail.com',
),
    'form_live' => false,
    'buttons_live' => false,
    // 'buttons' => [
        // ///SRP///
        // 'Listing make-offer' => [
            // 'url-match' => '/\\/(?:new|used)-/i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
// ],
            // 'action-target' => 'a.btn.btn-default.btn-offer',
            // 'css-class' => 'a.btn.btn-default.btn-offer',
            // 'css-hover' => 'a.btn.btn-default.btn-offer:hover',
            // 'sizes' => [
                // '100' => [],
// ],
            // 'texts' => [
                // 'make-offer' => [
                    // 'target' => 'a.btn.btn-default.btn-offer',
                    // 'values' => array(
                        // 'Make Your Deal',
                        // 'Send an Offer',
                        // 'Get live market price',
                        // 'Get Your Price',
// ),
// ],
// ],
            // 'styles' => array(
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C21116,#C21116)',
                        // 'border-color' => 'C21116',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        // 'border-color' => '9D0A0E',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#184D7F,#184D7F)',
                        // 'border-color' => '184D7F',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#123E65,#123E65)',
                        // 'border-color' => '123E65',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'green' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#31A413,#31A413)',
                        // 'border-color' => '31A413',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#288A0F,#288A0F)',
                        // 'border-color' => '288A0F',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C47C18,#C47C18)',
                        // 'border-color' => 'C47C18',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#A96B14,#A96B14)',
                        // 'border-color' => 'A96B14',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
// ),
// ],
        // 'Listing test-drive' => [
            // 'url-match' => '/\\/(?:new|used)-/i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
// ],
            // 'action-target' => 'div.btn-group button:nth-of-type(2)',
            // 'css-class' => 'div.btn-group button:nth-of-type(2)',
            // 'css-hover' => 'div.btn-group button:nth-of-type(2):hover',
            // 'sizes' => [
                // '100' => [],
// ],
            // 'texts' => [
                // 'test-drive' => [
                    // 'target' => 'div.btn-group button:nth-of-type(2)',
                    // 'values' => array(
                        // 'Request a Test Drive',
                        // 'Schedule a Test Drive',
                        // 'Book Test Drive',
                        // 'Want to Test Drive?',
                        // 'Test Drive Today',
                        // 'Test Drive Now',
// ),
// ],
// ],
            // 'styles' => array(
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C21116,#C21116)',
                        // 'border-color' => 'C21116',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        // 'border-color' => '9D0A0E',
                        // 'color' => '#fff',
// ),
// ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#184D7F,#184D7F)',
                        // 'border-color' => '184D7F',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#123E65,#123E65)',
                        // 'border-color' => '123E65',
                        // 'color' => '#fff',
// ),
// ),
                // 'green' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#31A413,#31A413)',
                        // 'border-color' => '31A413',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#288A0F,#288A0F)',
                        // 'border-color' => '288A0F',
                        // 'color' => '#fff',
// ),
// ),
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C47C18,#C47C18)',
                        // 'border-color' => 'C47C18',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#A96B14,#A96B14)',
                        // 'border-color' => 'A96B14',
                        // 'color' => '#fff',
// ),
// ),
// ),
// ],
        // 'Listing request-a-quote' => [
            // 'url-match' => '/\\/(?:new|used)-/i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
// ],
            // 'action-target' => 'div.btn-group button:nth-of-type(1)',
            // 'css-class' => 'div.btn-group button:nth-of-type(1)',
            // 'css-hover' => 'div.btn-group button:nth-of-type(1):hover',
            // 'sizes' => [
                // '100' => [],
// ],
            // 'texts' => [
                // 'request-a-quote' => [
                    // 'target' => 'div.btn-group button:nth-of-type(1)',
                    // 'values' => array(
                        // 'Send Us A Text',
                        // 'Send SMS',
                        // 'Message Us',
                        // 'Text Us Now',
// ),
// ],
// ],
            // 'styles' => array(
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C21116,#C21116)',
                        // 'border-color' => 'C21116',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        // 'border-color' => '9D0A0E',
                        // 'color' => '#fff',
// ),
// ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#184D7F,#184D7F)',
                        // 'border-color' => '184D7F',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#123E65,#123E65)',
                        // 'border-color' => '123E65',
                        // 'color' => '#fff',
// ),
// ),
                // 'green' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#31A413,#31A413)',
                        // 'border-color' => '31A413',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#288A0F,#288A0F)',
                        // 'border-color' => '288A0F',
                        // 'color' => '#fff',
// ),
// ),
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C47C18,#C47C18)',
                        // 'border-color' => 'C47C18',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#A96B14,#A96B14)',
                        // 'border-color' => 'A96B14',
                        // 'color' => '#fff',
// ),
// ),
// ),
// ],
        // ///VDP///
        // 'make-offer' => [
            // 'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}\\//i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
// ],
            // 'action-target' => '.list-group.vdp-button-group a.list-group-item.pricedrop-btn',
            // 'css-class' => '.list-group.vdp-button-group a.list-group-item.pricedrop-btn',
            // 'css-hover' => '.list-group.vdp-button-group a.list-group-item.pricedrop-btn:hover',
            // 'button_action' => [
                // 'form',
                // 'e-price',
// ],
            // 'sizes' => [
                // '100' => [],
// ],
            // 'texts' => [
                // 'make-offer' => [
                    // 'target' => '.list-group.vdp-button-group a.list-group-item.pricedrop-btn',
                    // 'values' => array(
                        // '<i class="fa fa-fw fa-lg fa-send-o"></i>Make Your Deal',
                        // '<i class="fa fa-fw fa-lg fa-send-o"></i>Send an Offer',
                        // '<i class="fa fa-fw fa-lg fa-send-o"></i>Get live market price',
                        // '<i class="fa fa-fw fa-lg fa-send-o"></i>Get Your Price',
// ),
// ],
// ],
            // 'styles' => array(
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#c21116,#c21116)',
                        // 'border-color' => '#c21116',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#9d0a0e,#9d0a0e)',
                        // 'border-color' => '#9d0a0e',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#184d7f,#184d7f)',
                        // 'border-color' => '#184d7f',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#123e65,#123e65)',
                        // 'border-color' => '#123e65',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'green' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#31a413,#31a413)',
                        // 'border-color' => '#31a413',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#288a0f,#288a0f)',
                        // 'border-color' => '#288a0f',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#c47c18,#c47c18)',
                        // 'border-color' => '#c47c18',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#a96b14,#a96b14)',
                        // 'border-color' => '#a96b14',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
// ),
// ],
        // ///text me///
        // 'request-a-quote' => [
            // 'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}\\//i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
// ],
            // 'action-target' => 'div.thumbnail.text-dealer-thumbnail div.caption a.btn',
            // 'css-class' => 'div.thumbnail.text-dealer-thumbnail div.caption a.btn',
            // 'css-hover' => 'div.thumbnail.text-dealer-thumbnail div.caption a.btn:hover',
            // 'button_action' => [
                // 'form',
                // 'e-price',
// ],
            // 'sizes' => [
                // '100' => [],
// ],
            // 'texts' => [
                // 'request-a-quote' => [
                    // 'target' => 'div.thumbnail.text-dealer-thumbnail div.caption a.btn',
                    // 'values' => array(
                        // 'Send Us A Text',
                        // 'Send SMS',
                        // 'Message Us',
                        // 'Text Us Now',
// ),
// ],
// ],
            // 'styles' => array(
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#c21116,#c21116)',
                        // 'border-color' => '#c21116',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#9d0a0e,#9d0a0e)',
                        // 'border-color' => '#9d0a0e',
                        // 'color' => '#fff',
// ),
// ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#184d7f,#184d7f)',
                        // 'border-color' => '#184d7f',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#123e65,#123e65)',
                        // 'border-color' => '#123e65',
                        // 'color' => '#fff',
// ),
// ),
                // 'green' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#31a413,#31a413)',
                        // 'border-color' => '#31a413',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#288a0f,#288a0f)',
                        // 'border-color' => '#288a0f',
                        // 'color' => '#fff',
// ),
// ),
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#c47c18,#c47c18)',
                        // 'border-color' => '#c47c18',
                        // 'color' => '#fff',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#a96b14,#a96b14)',
                        // 'border-color' => '#a96b14',
                        // 'color' => '#fff',
// ),
// ),
// ),
// ],
        // ///trade in//
        // 'trade-in' => [
            // 'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}\\//i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
// ],
            // 'action-target' => 'a.list-group-item.value-your-trade-btn',
            // 'css-class' => 'a.list-group-item.value-your-trade-btn',
            // 'css-hover' => 'a.list-group-item.value-your-trade-btn:hover',
            // 'button_action' => [
                // 'form',
                // 'trade-in',
// ],
            // 'sizes' => [
                // '100' => [],
// ],
            // 'texts' => [
                // 'trade-in' => [
                    // 'target' => 'a.list-group-item.value-your-trade-btn',
                    // 'values' => array(
                        // '<i class="fa fa-fw fa-lg fa-usd"></i>Get Trade-In Value',
                        // '<i class="fa fa-fw fa-lg fa-usd"></i>Trade Offer',
                        // '<i class="fa fa-fw fa-lg fa-usd"></i>What\'s Your Trade Worth?',
                        // '<i class="fa fa-fw fa-lg fa-usd"></i>Trade-In Appraisal',
                        // '<i class="fa fa-fw fa-lg fa-usd"></i>Appraise Your Trade',
                        // '<i class="fa fa-fw fa-lg fa-usd"></i>We Want Your Car',
                        // '<i class="fa fa-fw fa-lg fa-usd"></i>We\'ll Buy Your Car',
                        // '<i class="fa fa-fw fa-lg fa-usd"></i>Value Your Trade',
// ),
// ],
// ],
            // 'styles' => array(
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C21116,#C21116)',
                        // 'border-color' => 'C21116',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        // 'border-color' => '9D0A0E',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#184D7F,#184D7F)',
                        // 'border-color' => '184D7F',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#123E65,#123E65)',
                        // 'border-color' => '123E65',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'green' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#31A413,#31A413)',
                        // 'border-color' => '31A413',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#288A0F,#288A0F)',
                        // 'border-color' => '288A0F',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C47C18,#C47C18)',
                        // 'border-color' => 'C47C18',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#A96B14,#A96B14)',
                        // 'border-color' => 'A96B14',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
// ),
// ],
        // ///financing//
        // 'financing' => [
            // 'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}\\//i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
// ],
            // 'action-target' => 'a.list-group-item.credit-app-btn',
            // 'css-class' => 'a.list-group-item.credit-app-btn',
            // 'css-hover' => 'a.list-group-item.credit-app-btn:hover',
            // 'button_action' => [
                // 'form',
                // 'finance',
// ],
            // 'sizes' => [
                // '100' => [],
// ],
            // 'texts' => [
                // 'financing' => [
                    // 'target' => 'a.list-group-item.credit-app-btn',
                    // 'values' => array(
                        // '<i class="fa fa-fw fa-lg fa-pencil"></i>No Hassle Financing',
                        // '<i class="fa fa-fw fa-lg fa-pencil"></i>Get Financed Today',
                        // '<i class="fa fa-fw fa-lg fa-pencil"></i>Financing Available',
                        // '<i class="fa fa-fw fa-lg fa-pencil"></i>Special FInance Offers',
                        // '<i class="fa fa-fw fa-lg fa-pencil"></i>Apply for Financing',
// ),
// ],
// ],
            // 'styles' => array(
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C21116,#C21116)',
                        // 'border-color' => 'C21116',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        // 'border-color' => '9D0A0E',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#184D7F,#184D7F)',
                        // 'border-color' => '184D7F',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#123E65,#123E65)',
                        // 'border-color' => '123E65',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'green' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#31A413,#31A413)',
                        // 'border-color' => '31A413',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#288A0F,#288A0F)',
                        // 'border-color' => '288A0F',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C47C18,#C47C18)',
                        // 'border-color' => 'C47C18',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#A96B14,#A96B14)',
                        // 'border-color' => 'A96B14',
                        // 'color' => '#fff',
                        // 'border' => '1px solid #ddd',
// ),
// ),
// ),
// ],
// ],
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '18061',
        'promotion_text' => '$25 Gift Card With Test Drive',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);
