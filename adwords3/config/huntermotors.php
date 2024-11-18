<?php

global $CronConfigs;
$CronConfigs["huntermotors"] = array(
    'password' => 'huntermotors',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    "customer_id" => "937-797-9125",
    'max_cost' => 1000,
    'cost_distribution' => array(
        'adwords' => 1000,
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
    "banner" => array(
        "template" => "huntermotors",
        "fb_description_new" => "[year] [make] [model] [trim] - CASH PRICE [price]. MSRP [msrp]. Stock: [stock_number]. Amvic Licensed Dealership",
        //"fb_description_new" => "Are you still interested in the [year] [make] [model]? Click for more information",
        "fb_description_used" => "[year] [make] [model] [trim] - CASH PRICE [price] Stock: [stock_number]. Amvic Licensed Dealership",
        "fb_lookalike_description_new" => "Test drive the [year] [make] [model] [trim] today. CASH PRICE [price]. MSRP [msrp]. Stock: [stock_number]. Amvic Licensed Dealership",
        "fb_lookalike_description_used" => "Test drive the [year] [make] [model] [trim] today. CASH PRICE [price]. Stock: [stock_number]. Amvic Licensed Dealership",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
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
    "lead" => array(
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
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#204291',
            '#204291',
),
        'button_color_hover' => array(
            '#204291',
            '#204291',
),
        'button_color_active' => array(
            '#204291',
            '#204291',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$250 OFF coupon from Hunter Motors',
        'response_email' => 'Hello [name],<p> Thanks for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Hunter Motors Team',
        'forward_to' => array(
            'admin@huntermotors.ca',
            'marshal@smedia.ca',
            'ahunter@huntermotors.ca',
            ' saraho@huntermotors.ca',
            ' dhunter@huntermotors.ca',
            'marct@huntermotors.ca',
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
            'vdp' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
            'service' => '',
),
),
    'adf_to' => array(
        '',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:used|new)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.row.vdp-all-ctas-container div:nth-of-type(2) button',
            'css-class' => '.row.vdp-all-ctas-container div:nth-of-type(2) button',
            'css-hover' => '.row.vdp-all-ctas-container div:nth-of-type(2) button:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.row.vdp-all-ctas-container div:nth-of-type(2) button',
                    'values' => array(
                        'Get Your Price',
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#7E140D,#7E140D)',
                        'border-color' => '7E140D',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1877F2,#1877F2)',
                        'border-color' => '1877F2',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1460C3,#1460C3)',
                        'border-color' => '1460C3',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CD9834,#CD9834)',
                        'border-color' => 'CD9834',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#535454,#535454)',
                        'border-color' => '535454',
                        'color' => '#fff',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B7C7D,#7B7C7D)',
                        'border-color' => '7B7C7D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:used|new)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.row.vdp-all-ctas-container div:nth-of-type(3) button',
            'css-class' => '.row.vdp-all-ctas-container div:nth-of-type(3) button',
            'css-hover' => '.row.vdp-all-ctas-container div:nth-of-type(3) button:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '.row.vdp-all-ctas-container div:nth-of-type(3) button',
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
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#7E140D,#7E140D)',
                        'border-color' => '7E140D',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1877F2,#1877F2)',
                        'border-color' => '1877F2',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1460C3,#1460C3)',
                        'border-color' => '1460C3',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CD9834,#CD9834)',
                        'border-color' => 'CD9834',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#535454,#535454)',
                        'border-color' => '535454',
                        'color' => '#fff',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B7C7D,#7B7C7D)',
                        'border-color' => '7B7C7D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/(?:used|new)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.row.vdp-all-ctas-container div:nth-of-type(4) button',
            'css-class' => '.row.vdp-all-ctas-container div:nth-of-type(4) button',
            'css-hover' => '.row.vdp-all-ctas-container div:nth-of-type(4) button:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => '.row.vdp-all-ctas-container div:nth-of-type(4) button',
                    'values' => array(
                        'Request More Info',
                        'Ask a Question',
                        'Ask an Expert',
                        'Let Our Experts Help',
                        'More Information',
                        'Contact Us',
                        'Contact Us Now',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#7E140D,#7E140D)',
                        'border-color' => '7E140D',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1877F2,#1877F2)',
                        'border-color' => '1877F2',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1460C3,#1460C3)',
                        'border-color' => '1460C3',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CD9834,#CD9834)',
                        'border-color' => 'CD9834',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#535454,#535454)',
                        'border-color' => '535454',
                        'color' => '#fff',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B7C7D,#7B7C7D)',
                        'border-color' => '7B7C7D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
],
        //        ///used///
        'Used request-information' => [
            'url-match' => '/\\/used\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.row.vdp-all-ctas-container div:nth-of-type(1) button',
            'css-class' => '.row.vdp-all-ctas-container div:nth-of-type(1) button',
            'css-hover' => '.row.vdp-all-ctas-container div:nth-of-type(1) button:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => '.row.vdp-all-ctas-container div:nth-of-type(1) button',
                    'values' => array(
                        'Get Your Price',
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#97140C,#97140C)',
                        'border-color' => '97140C',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#7E140D,#7E140D)',
                        'border-color' => '7E140D',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1877F2,#1877F2)',
                        'border-color' => '1877F2',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#1460C3,#1460C3)',
                        'border-color' => '1460C3',
                        'color' => '#fff',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CD9834,#CD9834)',
                        'border-color' => 'CD9834',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#535454,#535454)',
                        'border-color' => '535454',
                        'color' => '#fff',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B7C7D,#7B7C7D)',
                        'border-color' => '7B7C7D',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#801608,#801608)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
),
),
),
],
],
);