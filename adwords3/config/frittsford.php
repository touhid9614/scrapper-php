<?php

global $CronConfigs;
$CronConfigs["frittsford"] = array(
    'password' => 'frittsford',
    "email" => "regan@smedia.ca",
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "frittsford",
        "old_price" => "msrp",
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
        "fb_lookalike_description" => "Huge savings on the [year] [make] [model]! Click for more info!",
        "fb_dynamiclead_description" => "Drive away in a brand new Ford with only \$399 Down!. *You must have a 600 credit score, with a provable income of \$1850/month. For a limited time only!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
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
            '#003366',
            '#003366',
),
        'button_color_active' => array(
            '#333333',
            '#333333',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get your Labor Day price at Fritts Ford',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fritts Ford Team',
        'forward_to' => array(
            'marshal@smedia.ca',
            'sshoemaker@frittsford.com',
),
        'special_to' => array(
            'frittsfordleads@host.udcnet.com',
),
        'special_email' => '<?xml version="1.0"?>
	<?adf version="1.0"?>
        <adf>
            <prospect>
                <id sequence="[total_count]"  source="Fritts Ford"></id>
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
                    <name part="full">Fritts Ford</name>
                    <email>sshoemaker@frittsford.com</email>
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
            'vdp' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service' => '',
),
),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17582',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
    'adf_to' => array(
        '',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => false,
    'buttons' => [
        //////srp////
        'interested' => [
            'url-match' => '/\\/(?:new|used|certified|certified-used)-ford-buy-lease-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.ncs-button.main-cta.dt-get-special-btn',
            'css-class' => 'a.ncs-button.main-cta.dt-get-special-btn',
            'css-hover' => 'a.ncs-button.main-cta.dt-get-special-btn:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'interested' => [
                    'target' => 'a.ncs-button.main-cta.dt-get-special-btn',
                    'values' => array(
                        'Get Lower Price',
                        'Take Home Today',
                        'Buy It Now',
                        'Make Your Offer',
),
],
],
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#07730A,#07730A)',
                        'border-color' => '07730A',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#065808,#065808)',
                        'border-color' => '065808',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F90100,#F90100)',
                        'border-color' => 'F90100',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CA0302,#CA0302)',
                        'border-color' => 'CA0302',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#003366,#003366)',
                        'border-color' => '003366',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#00284F,#00284F)',
                        'border-color' => '00284F',
                        'color' => '#fff',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/(?:new|used|certified|certified-used)-ford-buy-lease-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.ncs-button.dt-finance-btn',
            'css-class' => 'a.ncs-button.dt-finance-btn',
            'css-hover' => 'a.ncs-button.dt-finance-btn:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a.ncs-button.dt-finance-btn',
                    'values' => array(
                        'Financing Options',
                        'Explore Payments',
                        'Special Finance Offers',
                        'Financing Available',
                        'Apply For Financing',
                        'No Hassle Financing',
                        'Get Financed Today',
),
],
],
            'styles' => array(
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#003366,#003366)',
                        'border-color' => '003366',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#00284F,#00284F)',
                        'border-color' => '00284F',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F90100,#F90100)',
                        'border-color' => 'F90100',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CA0302,#CA0302)',
                        'border-color' => 'CA0302',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#07730A,#07730A)',
                        'border-color' => '07730A',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#065808,#065808)',
                        'border-color' => '065808',
                        'color' => '#fff',
),
),
),
],
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used|certified|certified-used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.vehicle-ctas div a[href *=eprice].btn',
            'css-class' => '.vehicle-ctas div a[href *=eprice].btn',
            'css-hover' => '.vehicle-ctas div a[href *=eprice].btn:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.vehicle-ctas div a[href *=eprice].btn',
                    'values' => array(
                        'Get E-Price',
                        'Get Internet Price',
                        'Get Your Price',
                        'Get Our Best Price',
                        'Contact Us Now',
                        'Call Us Now',
                        'Inquire Now',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F90100,#F90100)',
                        'border-color' => 'F90100',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CA0302,#CA0302)',
                        'border-color' => 'CA0302',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#07730A,#07730A)',
                        'border-color' => '07730A',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#065808,#065808)',
                        'border-color' => '065808',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#003366,#003366)',
                        'border-color' => '003366',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#00284F,#00284F)',
                        'border-color' => '00284F',
                        'color' => '#fff',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/(?:new|used|certified|certified-used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.flex-col.mr-3 a[href *=lead].btn',
            'css-class' => '.flex-col.mr-3 a[href *=lead].btn',
            'css-hover' => '.flex-col.mr-3 a[href *=lead].btn:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => '.flex-col.mr-3 a[href *=lead].btn',
                    'values' => array(
                        'Ask A Question',
                        'Request More Info',
                        'Learn More',
                        'Ask More Info',
                        'Ask an Expert',
                        'Get More Details',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F90100,#F90100)',
                        'border-color' => 'F90100',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CA0302,#CA0302)',
                        'border-color' => 'CA0302',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#07730A,#07730A)',
                        'border-color' => '07730A',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#065808,#065808)',
                        'border-color' => '065808',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#003366,#003366)',
                        'border-color' => '003366',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#00284F,#00284F)',
                        'border-color' => '00284F',
                        'color' => '#fff',
),
),
),
],
],
);