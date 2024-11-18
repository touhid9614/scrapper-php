<?php

global $CronConfigs;
$CronConfigs["reliablemotors"] = array(
    //'budget'    => 2.0,
    'bid' => 3.0,
    'log' => true,
    'password' => 'reliablemotors',
    'post_code' => 'N8M 2C8',
    "email" => "regan@smedia.ca",
    "banner" => array(
        "template" => "reliablemotors",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "hst" => yes,
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
            '#000000',
            '#000000',
),
        'button_color_hover' => array(
            '#0D65BF',
            '#0D65BF',
),
        'button_color_active' => array(
            '#0D65BF',
            '#0D65BF',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$200 OFF coupon from Reliable Motors',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Reliable Motors Team',
        'forward_to' => array(
            'ryangillis@reliablemotors.ca',
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
            'vdp' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}/i',
            'service' => '',
),
),
    "log" => true,
    'lead_to' => array(
        'ryangillis@reliablemotors.ca',
),
    'form_live' => true,
    'buttons_live' => false,
    'buttons' => [
        //Used//
        'request-information' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-default.eprice.dialog.button',
            'css-class' => 'a.btn.btn-default.eprice.dialog.button',
            'css-hover' => 'a.btn.btn-default.eprice.dialog.button:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'a.btn.btn-default.eprice.dialog.button',
                    'values' => array(
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Special Price',
                        'Get Your Price',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
                        'color' => '#fff',
),
),
),
],
        //used//
        'Used test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'ul.pricing.single-price.has-eprice.inv-type-used.list-unstyled  li a[href*=schedule-form]',
            'css-class' => 'ul.pricing.single-price.has-eprice.inv-type-used.list-unstyled  li a[href*=schedule-form]',
            'css-hover' => 'ul.pricing.single-price.has-eprice.inv-type-used.list-unstyled  li a[href*=schedule-form]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'Used test-drive' => [
                    'target' => 'ul.pricing.single-price.has-eprice.inv-type-used.list-unstyled  li a[href*=schedule-form]',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
                        'color' => '#fff',
),
),
),
],
        ///new//
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'ul.pricing.multiple-prices.inv-type-new  li a[href*=schedule-form].btn',
            'css-class' => 'ul.pricing.multiple-prices.inv-type-new  li a[href*=schedule-form].btn',
            'css-hover' => 'ul.pricing.multiple-prices.inv-type-new  li a[href*=schedule-form].btn:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'ul.pricing.multiple-prices.inv-type-new  li a[href*=schedule-form].btn',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
                        'color' => '#fff',
),
),
),
],
        //text us//
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.content a.btn.btn-primary.btn-lg.btn-block',
            'css-class' => 'div.content a.btn.btn-primary.btn-lg.btn-block',
            'css-hover' => 'div.content a.btn.btn-primary.btn-lg.btn-block:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.content a.btn.btn-primary.btn-lg.btn-block',
                    'values' => array(
                        'Send Us A Text',
                        'Send SMS',
                        'Message Us',
                        'Text Us Now',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
                        'color' => '#fff',
),
),
),
],
        ///structure my deal///
        'financing' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.btn.btn-primary.btn-lg.btn-block.btn-no-decoration.tool.incomplete',
            'css-class' => '.btn.btn-primary.btn-lg.btn-block.btn-no-decoration.tool.incomplete',
            'css-hover' => '.btn.btn-primary.btn-lg.btn-block.btn-no-decoration.tool.incomplete:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '.btn.btn-primary.btn-lg.btn-block.btn-no-decoration.tool.incomplete',
                    'values' => array(
                        'Click Here To Structure My Deal',
                        'Structure Your Deal Online',
                        'Configure My Deal',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => 'C21116',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '9D0A0E',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '184D7F',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '123E65',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '31A413',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '288A0F',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => 'A96B14',
                        'color' => '#fff',
),
),
),
],
],
);