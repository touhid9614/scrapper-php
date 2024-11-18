<?php

global $CronConfigs;
$CronConfigs["brianjesselbmw"] = array(
    "name" => " brianjesselbmw",
    "email" => "regan@smedia.ca",
    "password" => " brianjesselbmw",
    "log" => true,
    'adf_to' => array(
        'albuttons-smedia@brianjesselbmw-bc.net',
        'thamina.ahamed@gmail.com',
        'masterkeyy@gmail.com',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        //contact us//
        'more-information' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '#vdp_button_widget-5 .button-group__button.button.button--alternate.button--centered.modal-trigger',
            'css-class' => '#vdp_button_widget-5 .button-group__button.button.button--alternate.button--centered.modal-trigger',
            'css-hover' => '#vdp_button_widget-5 .button-group__button.button.button--alternate.button--centered.modal-trigger:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'more-information' => [
                    'target' => '#vdp_button_widget-5 .button-group__button.button.button--alternate.button--centered.modal-trigger',
                    'values' => array(
                        'Get Your E-Price',
                        'Check Availability',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
                        'color' => '#FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0653B6,#0653B6)',
                        'border-color' => '0653B6',
                        'color' => '#FFFFFF',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '#vdp_button_widget-3 .button-group__button.button.button--alternate.button--centered.modal-trigger',
            'css-class' => '#vdp_button_widget-3 .button-group__button.button.button--alternate.button--centered.modal-trigger',
            'css-hover' => '#vdp_button_widget-3 .button-group__button.button.button--alternate.button--centered.modal-trigger:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '#vdp_button_widget-3 .button-group__button.button.button--alternate.button--centered.modal-trigger',
                    'values' => array(
                        'BOOK TEST DRIVE',
                        'REQUEST TEST DRIVE',
                        'TEST DRIVE TODAY',
                        'TEST DRIVE NOW',
                        'WANT TO TEST DRIVE?',
                        'TEST RIDE',
                        'Book My Test Drive',
                        'SCHEDULE MY TEST DRIVE',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
                        'color' => '#FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0653B6,#0653B6)',
                        'border-color' => '0653B6',
                        'color' => '#FFFFFF',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '#vdp_button_widget-4 a[href *=credit]',
            'css-class' => '#vdp_button_widget-4 a[href *=credit]',
            'css-hover' => '#vdp_button_widget-4 a[href *=credit]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '#vdp_button_widget-4 a[href *=credit]',
                    'values' => array(
                        'Calculate Lease Payment',
                        'Payment options',
                        'Special Finance Offers',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1C69D4,#1C69D4)',
                        'border-color' => '1C69D4',
                        'color' => '#FFFFFF',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0653B6,#0653B6)',
                        'border-color' => '0653B6',
                        'color' => '#FFFFFF',
),
),
),
],
],
);