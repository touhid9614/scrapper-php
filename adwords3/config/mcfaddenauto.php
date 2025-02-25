<?php

global $CronConfigs;
$CronConfigs["mcfaddenauto"] = array(
    'password' => 'mcfaddenauto',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        'fb_description' => '[year] [make] [model] - Contact us today!',
        "template" => "mcfaddenauto",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'sales@mcfaddenhonda.ca',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'trade-in' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.row.margin-buttons-used.buttons1 div:nth-of-type(1) button',
            'css-class' => '.row.margin-buttons-used.buttons1 div:nth-of-type(1) button',
            'css-hover' => '.row.margin-buttons-used.buttons1 div:nth-of-type(1) button:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => '.row.margin-buttons-used.buttons1 div:nth-of-type(1) button',
                    'values' => array(
                        'GET TRADE-IN VALUE',
                        'TRADE OFFER',
                        'WHAT\'S YOUR TRADE WORTH?',
                        'TRADE-IN APPRAISAL',
                        'VALUE YOUR TRADE',
                        'WE WANT YOUR CAR',
                        'WE\'LL BUY YOUR CAR',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2A6DBF,#2A6DBF)',
                        'border-color' => '54B740',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#01A6F3,#01A6F3)',
                        'border-color' => '01A6F3',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#008ACA,#008ACA)',
                        'border-color' => '008ACA',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '7B5647',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
            'css-class' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
            'css-hover' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
                    'values' => array(
                        'NO HASSLE FINANCING',
                        'FINANCING AVAILABLE',
                        'GET FINANCED TODAY',
                        'SPECIAL FINANCE OFFERS',
                        'EXPLORE PAYMENTS',
                        'SPECIAL FINANCE OFFERS!',
                        'SPECIAL FINANCE OFFERS',
                        'TODAY\'S MARKET PRICE',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2A6DBF,#2A6DBF)',
                        'border-color' => '54B740',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#01A6F3,#01A6F3)',
                        'border-color' => '01A6F3',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#008ACA,#008ACA)',
                        'border-color' => '008ACA',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '7B5647',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.row.margin-buttons-used.buttons1 div:nth-of-type(2) button',
            'css-class' => '.row.margin-buttons-used.buttons1 div:nth-of-type(2) button',
            'css-hover' => '.row.margin-buttons-used.buttons1 div:nth-of-type(2) button:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '.row.margin-buttons-used.buttons1 div:nth-of-type(2) button',
                    'values' => array(
                        'BOOK TEST DRIVE',
                        'REQUEST TEST DRIVE',
                        'SCHEDULE TEST DRIVE',
                        'TEST DRIVE INQUIRY',
                        'WANT A TEST DRIVE?',
                        'TEST DRIVE TODAY!',
                        'TEST RIDE',
                        'BOOK MY TEST DRIVE',
                        'SCHEDULE MY TEST DRIVE',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2A6DBF,#2A6DBF)',
                        'border-color' => '54B740',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#01A6F3,#01A6F3)',
                        'border-color' => '01A6F3',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#008ACA,#008ACA)',
                        'border-color' => '008ACA',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#7B5647,#7B5647)',
                        'border-color' => '7B5647',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                        'padding' => '9px 10px',
                        'font-size' => '10px',
                        'text-align' => 'center',
                        'color' => '#fff',
),
),
),
],
],
);