<?php

global $CronConfigs;
$CronConfigs["sierramotorsports"] = array(
    "name" => " sierramotorsports",
    "email" => "regan@smedia.ca",
    "password" => " sierramotorsports",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    "banner" => array(
        "template" => "sierramotorsports",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
),
    'lead_to' => array(
        'sms@sierramotorsports.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-information' => [
            'url-match' => '/\\/[A-Za-z]+-.*[0-9]{4}-Grass/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '#dnn_ctr26123_Details_ctl08_RequestMoreInfoButton',
            'css-class' => '#dnn_ctr26123_Details_ctl08_RequestMoreInfoButton',
            'css-hover' => '#dnn_ctr26123_Details_ctl08_RequestMoreInfoButton:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => '#dnn_ctr26123_Details_ctl08_RequestMoreInfoButton',
                    'values' => array(
                        '<span class="btn-icon"><span class="fa fa-info-circle" aria-hidden="true"></span></span>Get More Details',
                        '<span class="btn-icon"><span class="fa fa-info-circle" aria-hidden="true"></span></span>More Info',
                        '<span class="btn-icon"><span class="fa fa-info-circle" aria-hidden="true"></span></span>Ask an Expert!',
                        '<span class="btn-icon"><span class="fa fa-info-circle" aria-hidden="true"></span></span>Ask for More Info',
                        '<span class="btn-icon"><span class="fa fa-info-circle" aria-hidden="true"></span></span>Request More Info',
                        '<span class="btn-icon"><span class="fa fa-info-circle" aria-hidden="true"></span></span>Ask a Question!',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE7512,#EE7512)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#670000,#670000)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
                'dark-gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#242424,#242424)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/[A-Za-z]+-.*[0-9]{4}-Grass/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '#dnn_ctr26123_Details_ctl09_FinanceApplicationButton',
            'css-class' => '#dnn_ctr26123_Details_ctl09_FinanceApplicationButton',
            'css-hover' => '#dnn_ctr26123_Details_ctl09_FinanceApplicationButton:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '#dnn_ctr26123_Details_ctl09_FinanceApplicationButton',
                    'values' => array(
                        '<span class="btn-icon"><span class="fa fa-dollar" aria-hidden="true"></span></span>Financing Options',
                        '<span class="btn-icon"><span class="fa fa-dollar" aria-hidden="true"></span></span>Special Finance Offers!',
                        '<span class="btn-icon"><span class="fa fa-dollar" aria-hidden="true"></span></span>Special Finance Offers',
                        '<span class="btn-icon"><span class="fa fa-dollar" aria-hidden="true"></span></span>No Hassle Financing',
                        '<span class="btn-icon"><span class="fa fa-dollar" aria-hidden="true"></span></span>Get Financed Today',
                        '<span class="btn-icon"><span class="fa fa-dollar" aria-hidden="true"></span></span>Get Your Loan Online',
                        '<span class="btn-icon"><span class="fa fa-dollar" aria-hidden="true"></span></span>Get Approved',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE7512,#EE7512)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#670000,#670000)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
                'dark-gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#242424,#242424)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
),
],
        'oem-promotions' => [
            'url-match' => '/\\/[A-Za-z]+-.*[0-9]{4}-Grass/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-default.btn-cta',
            'css-class' => 'a.btn.btn-default.btn-cta',
            'css-hover' => 'a.btn.btn-default.btn-cta:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a.btn.btn-default.btn-cta',
                    'values' => array(
                        '<span class="btn-icon"><span class="fa fa-file-text-o" aria-hidden="true"></span></span>OEM Offers',
                        '<span class="btn-icon"><span class="fa fa-file-text-o" aria-hidden="true"></span></span>OEM Special Offers',
                        '<span class="btn-icon"><span class="fa fa-file-text-o" aria-hidden="true"></span></span>OEM Discounts',
                        '<span class="btn-icon"><span class="fa fa-file-text-o" aria-hidden="true"></span></span>OEM Promo',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE7512,#EE7512)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#670000,#670000)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
                'dark-gray' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#242424,#242424)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => 'C60C0D',
),
),
),
],
],
);