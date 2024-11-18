<?php

global $CronConfigs;
$CronConfigs["sellersbuickgmccom"] = array(
    "name" => " sellersbuickgmccom",
    "email" => "regan@smedia.ca",
    "password" => " sellersbuickgmccom",
    "log" => true,
    'adf_to' => array(
        '',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[name="9c7bb80f-3c53-45e4-8745-471554ab838c"]',
            'css-class' => 'a[name="9c7bb80f-3c53-45e4-8745-471554ab838c"]',
            'css-hover' => 'a[name="9c7bb80f-3c53-45e4-8745-471554ab838c"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name="9c7bb80f-3c53-45e4-8745-471554ab838c"]',
                    'values' => array(
                        'Lease Quote',
                        'Request Lease Quote',
                        'Get Best Lease Deal',
                        'Lease Payments',
                        'Lease Offer',
),
],
],
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#009800,#009800)',
                        'border-color' => '009800',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#007000,#007000)',
                        'border-color' => '007000',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0A9FDB,#0A9FDB)',
                        'border-color' => '0A9FDB',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0A88BB,#0A88BB)',
                        'border-color' => '0A88BB',
),
),
),
],
],
);