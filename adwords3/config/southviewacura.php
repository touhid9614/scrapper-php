<?php

global $CronConfigs;
$CronConfigs["southviewacura"] = array(
    'password' => 'southviewacura',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'tag_debug' => false,
    "banner" => array(
        "template" => "southviewacura",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "fb_title" => "[year] [make] [model] [price]",
),
    'adf_to' => array(
        'leads@southviewacura.motosnap.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-target*=vdp-inquire-modal]',
            'css-class' => 'a[data-target*=vdp-inquire-modal]',
            'css-hover' => 'a[data-target*=vdp-inquire-modal]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[data-target*=vdp-inquire-modal]',
                    'values' => array(
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Internet Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Internet Price!',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get E-Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Your Best Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Best Price!',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Today\'s Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Today\'s Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Today\'s Price!',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Best Price',
),
],
],
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
),
],
        'Used request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-target*=vdp-inquire-modal]',
            'css-class' => 'a[data-target*=vdp-inquire-modal]',
            'css-hover' => 'a[data-target*=vdp-inquire-modal]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[data-target*=vdp-inquire-modal]',
                    'values' => array(
                        '<i class="ddc-icon ddc-icon-banknote"></i>Confirm Availability',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Price Watch',
                        '<i class="ddc-icon ddc-icon-banknote"></i>More Information',
                        '<i class="ddc-icon ddc-icon-banknote"></i>More Info',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Track Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i> Ask a Question',
),
],
],
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'C38820',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'A9761C',
),
),
),
],
],
);