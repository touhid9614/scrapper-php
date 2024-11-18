<?php

global $CronConfigs;
$CronConfigs["medicinehatnissan"] = array(
    "name" => " medicinehatnissan",
    "email" => "regan@smedia.ca",
    "password" => " medicinehatnissan",
    "log" => true,
    "customer_id" => "230-772-3480",
    'max_cost' => 0,
    'cost_distribution' => array(
        'adwords' => 0,
),
    "banner" => array(
        'template' => 'medicinehatnissan',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
        'fb_marketplace_description' => '[year] [make] [model]. Check it out today!',
),
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => true,
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
            '#C3002F',
            '#C3002F',
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
        'response_email_subject' => '$200 off coupon from Medicine Hat Nissan',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Medicine Hat Nissan Team',
        'forward_to' => array(
            'iknell@medicinehatnissan.com',
            'dmoran@medicinehatnissan.com',
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
            'vdp' => '/\\/en\\/(?:new|used)-[^\\/]+\\/[^\\/]+\\/[^\\/]+\\/[0-9]{4}-/i',
            'service' => '',
),
),
    'lead_to' => array(),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'Used request-a-quote' => [
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.link__alpha.link__alpha-primary.catalog-details__cta.catalog-details__cta-price',
            'css-class' => '.link__alpha.link__alpha-primary.catalog-details__cta.catalog-details__cta-price',
            'css-hover' => '.link__alpha.link__alpha-primary.catalog-details__cta.catalog-details__cta-price:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.link__alpha.link__alpha-primary.catalog-details__cta.catalog-details__cta-price',
                    'values' => array(
                        'Get A Quote',
                        'Get Internet Price',
                        'Get EPrice',
                        'Get Our Best Price',
                        'Get Special Price',
                        'Inquire Now',
                        'Inquire Today',
                        'Request A Quote',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2C61A6,#2C61A6)',
                        'border-color' => '2C61A6',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => 'FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#028034,#028034)',
                        'border-color' => '028034',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FB6400,#FB6400)',
                        'border-color' => 'FB6400',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C14F04,#C14F04)',
                        'border-color' => 'C14F04',
),
),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#636262,#636262)',
                        'border-color' => '636262',
),
),
),
],
        'request-a-quote' => [
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.link__alpha.link__alpha-primary.header-info-alpha__actions-cta',
            'css-class' => '.link__alpha.link__alpha-primary.header-info-alpha__actions-cta',
            'css-hover' => '.link__alpha.link__alpha-primary.header-info-alpha__actions-cta:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.link__alpha.link__alpha-primary.header-info-alpha__actions-cta',
                    'values' => array(
                        'Get A Quote',
                        'Get Internet Price',
                        'Get EPrice',
                        'Get Our Best Price',
                        'Get Special Price',
                        'Inquire Now',
                        'Inquire Today',
                        'Request A Quote',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879ce,#3879ce)',
                        'border-color' => '#3879ce',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2c61a6,#2c61a6)',
                        'border-color' => '#2c61a6',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#c00a944,#c00a944)',
                        'border-color' => '#c00a944',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#028034,#028034)',
                        'border-color' => '#028034',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#fb6400,#fb6400)',
                        'border-color' => '#fb6400',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#c14f04,#c14f04)',
                        'border-color' => '#c14f04',
),
),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#c47c18,#c47c18)',
                        'border-color' => '#c47c18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#636262,#636262)',
                        'border-color' => '#636262',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=trade]',
            'css-class' => 'a[href*=trade]',
            'css-hover' => 'a[href*=trade]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href*=trade]',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                        'Value Your Trade',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2C61A6,#2C61A6)',
                        'border-color' => '2C61A6',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => 'FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#028034,#028034)',
                        'border-color' => '028034',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FB6400,#FB6400)',
                        'border-color' => 'FB6400',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C14F04,#C14F04)',
                        'border-color' => 'C14F04',
),
),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#636262,#636262)',
                        'border-color' => '636262',
),
),
),
],
        'Used test-drive' => [
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*="road-test-used"]',
            'css-class' => 'a[href*="road-test-used"]',
            'css-hover' => 'a[href*="road-test-used"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*="road-test-used"]',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2C61A6,#2C61A6)',
                        'border-color' => '2C61A6',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => 'FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#028034,#028034)',
                        'border-color' => '028034',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FB6400,#FB6400)',
                        'border-color' => 'FB6400',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C14F04,#C14F04)',
                        'border-color' => 'C14F04',
),
),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#636262,#636262)',
                        'border-color' => '636262',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=book-a-test-drive]',
            'css-class' => 'a[href*=book-a-test-drive]',
            'css-hover' => 'a[href*=book-a-test-drive]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[href*=book-a-test-drive]',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879ce,#3879ce)',
                        'border-color' => '#3879ce',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2c61a6,#2c61a6)',
                        'border-color' => '#2c61a6',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#c00a944,#c00a944)',
                        'border-color' => '#c00a944',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#028034,#028034)',
                        'border-color' => '#028034',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#fb6400,#fb6400)',
                        'border-color' => '#fb6400',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#c14f04,#c14f04)',
                        'border-color' => '#c14f04',
),
),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#c47c18,#c47c18)',
                        'border-color' => '#c47c18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#636262,#636262)',
                        'border-color' => '#636262',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=detailed-financing-request]',
            'css-class' => 'a[href*=detailed-financing-request]',
            'css-hover' => 'a[href*=detailed-financing-request]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=detailed-financing-request]',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2C61A6,#2C61A6)',
                        'border-color' => '2C61A6',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => 'FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#028034,#028034)',
                        'border-color' => '028034',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FB6400,#FB6400)',
                        'border-color' => 'FB6400',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C14F04,#C14F04)',
                        'border-color' => 'C14F04',
),
),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#636262,#636262)',
                        'border-color' => '636262',
),
),
),
],
        'Used financing' => [
            'url-match' => '/\\/en\\/(?:new|used)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=financing-request-new]',
            'css-class' => 'a[href*=financing-request-new]',
            'css-hover' => 'a[href*=financing-request-new]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=financing-request-new]',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3879CE,#3879CE)',
                        'border-color' => '3879CE',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2C61A6,#2C61A6)',
                        'border-color' => '2C61A6',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFFFFF,#FFFFFF)',
                        'border-color' => 'FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#028034,#028034)',
                        'border-color' => '028034',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FB6400,#FB6400)',
                        'border-color' => 'FB6400',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C14F04,#C14F04)',
                        'border-color' => 'C14F04',
),
),
                'brown' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => 'C47C18',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#636262,#636262)',
                        'border-color' => '636262',
),
),
),
],
],
);