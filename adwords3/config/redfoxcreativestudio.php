<?php

global $CronConfigs;
$CronConfigs["redfoxcreativestudio"] = array(
    //'max_cost'      => 400,
    // "customer_id"   => "746-226-8900",
    'password' => 'redfoxcreativestudio',
    "email" => "regan@smedia.ca",
    'no_adv' => true,
    "banner" => array(
        "template" => "velocitycars",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'register' => [
            'url-match' => '/\\/adult-[^\\/]+\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.sqs-add-to-cart-button.sqs-suppress-edit-mode.sqs-editable-button',
            'css-class' => '.sqs-add-to-cart-button.sqs-suppress-edit-mode.sqs-editable-button',
            'css-hover' => '.sqs-add-to-cart-button.sqs-suppress-edit-mode.sqs-editable-button:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'register' => [
                    'target' => '.sqs-add-to-cart-button-inner',
                    'values' => array(
                        'ADD TO BAG',
                        'ADD TO BASKET',
                        'JOIN CLASS',
                        'SIGN UP NOW',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DD820D,#DD820D)',
                        'border-color' => 'DD820D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C51616,#C51616)',
                        'border-color' => 'C51616',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#63B428,#63B428)',
                        'border-color' => '63B428',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#287AB4,#287AB4)',
                        'border-color' => '287AB4',
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