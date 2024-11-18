<?php

global $CronConfigs;
$CronConfigs["clarkcullengroup"] = array(
    'max_cost' => 385,
    'cost_distribution' => [
        'adwords' => 385,
],
    "customer_id" => "249-795-4054",
    'password' => 'clarkcullengroup',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "clarkcullengroup",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        "fb_title" => "[model],[make],[price]",
        'fb_description' => 'Check out this [model], [make] today! Click for more information.',
		//'fb_retargeting_description' => 'Are you still interested in this beautiful home? Click for more info!',
        //'fb_lookalike_description' => 'Check out this beautiful home! Click for more info!',
        "font_color" => "#ffffff",
),
    'lead_to' => [
        'clarkcullengroup@gmail.com',
],
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/listing\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.button.inquire',
            'css-class' => ' a.button.button--strong.inquire',
            'css-hover' => ' a.button.button--strong.inquire:hover',
            //  'button_action' => ['form','e-price'],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.button.inquire',
                    'values' => array(
                        'Get More Information',
                        'Ask a Question',
                        'Request a Quote',
                        'Contact Our Agent',
                        'Contact Us Now',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(90deg,#fdc94d 30%,#fdd166 70%)',
                        'border-color' => null,
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(90deg,#81e88e 30%,#5ad86a 70%)',
                        'border-color' => null,
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(90deg,#ffbdba 30%,#ff948f 70%)',
                        'border-color' => null,
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(90deg,#b7c1f0 30%,#8897de 70%)',
                        'border-color' => null,
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
],
);