<?php

global $CronConfigs;
$CronConfigs["islandlincoln"] = array(
    "name" => " islandlincoln",
    "email" => "regan@smedia.ca",
    "password" => " islandlincoln",
    "log" => true,
    'adf_to' => array(
        'islandautogroup@newsales.leads.cmdlr.com',
        'shahadathossainece08@gmail.com'
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '[data-url*=eprice-request]',
            'css-class' => '[data-url*=eprice-request]',
            'css-hover' => '[data-url*=eprice-request]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[data-url*=eprice-request]',
                    'values' => array(
                        'Get Price Updates',
                        'Get Your Best Price',
                        'Get Internet Price',
                        'Get A Quote',
                        'Get Your Exclusive Price',
                        'Get Current Market Price',
                        'Get Special Price',
                    ),
                ],
            ],
           'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115285,#115285)',
                        'border-color' => '#3585CB',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3585CB,#3585CB)',
                        'border-color' => '#276499',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#098E55,#098E55)',
                        'border-color' => '#48E62F',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D6525,#2D6525)',
                        'border-color' => '#2D6525',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CF240E,#CF240E)',
                        'border-color' => '#FB3342',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B53343,#B53343)',
                        'border-color' => '#772B31',
                        'color' => '#fff',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB9B0B,#CB9B0B)',
                        'border-color' => '#FB3342',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B57033,#B57033)',
                        'border-color' => '#772B31',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#calculatePayments',
            'css-class' => '#calculatePayments',
            'css-hover' => '#calculatePayments:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => '#calculatePayments',
                    'values' => array(
                        'Calculate Your Payments',
                        'Estimate Payments',
                        'Explore Payments',
                        'Payment Options',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115285,#115285)',
                        'border-color' => '#3585CB',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3585CB,#3585CB)',
                        'border-color' => '#276499',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#098E55,#098E55)',
                        'border-color' => '#48E62F',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D6525,#2D6525)',
                        'border-color' => '#2D6525',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CF240E,#CF240E)',
                        'border-color' => '#FB3342',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B53343,#B53343)',
                        'border-color' => '#772B31',
                        'color' => '#fff',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB9B0B,#CB9B0B)',
                        'border-color' => '#FB3342',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B57033,#B57033)',
                        'border-color' => '#772B31',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#scheduleTestDrive',
            'css-class' => '#scheduleTestDrive',
            'css-hover' => '#scheduleTestDrive:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => '#scheduleTestDrive',
                    'values' => array(
                        'Book Test Drive',
                        'Test Drive Now',
                        'Schedule a Test Drive',
                        'Schedule Your Test Drive',
                        'Request A Test Drive',
                    ),
                ],
            ],
           'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115285,#115285)',
                        'border-color' => '#3585CB',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3585CB,#3585CB)',
                        'border-color' => '#276499',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#098E55,#098E55)',
                        'border-color' => '#48E62F',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D6525,#2D6525)',
                        'border-color' => '#2D6525',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CF240E,#CF240E)',
                        'border-color' => '#FB3342',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B53343,#B53343)',
                        'border-color' => '#772B31',
                        'color' => '#fff',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB9B0B,#CB9B0B)',
                        'border-color' => '#FB3342',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B57033,#B57033)',
                        'border-color' => '#772B31',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'apply_now' => [
            'url-match' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#getApproved',
            'css-class' => '#getApproved',
            'css-hover' => '#getApproved:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => '#getApproved',
                    'values' => array(
                        'Get Your Loan Online',
                        'Get Approved',
                        'Financing Options',
                        'Special Finance Offers!',
                        'Apply for Financing',
                        'Get Financed Today',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115285,#115285)',
                        'border-color' => '#3585CB',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3585CB,#3585CB)',
                        'border-color' => '#276499',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#098E55,#098E55)',
                        'border-color' => '#48E62F',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D6525,#2D6525)',
                        'border-color' => '#2D6525',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CF240E,#CF240E)',
                        'border-color' => '#FB3342',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B53343,#B53343)',
                        'border-color' => '#772B31',
                        'color' => '#fff',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB9B0B,#CB9B0B)',
                        'border-color' => '#FB3342',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B57033,#B57033)',
                        'border-color' => '#772B31',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/vehicle-details\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => '#tradeIn',
            'css-class' => '#tradeIn',
            'css-hover' => '#tradeIn:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => '#tradeIn',
                    'values' => array(
                        'What\'s Your Trade Worth?',
                        'Value Your Trade',
                        'We\'ll Buy Your Car',
                        'Trade-In Offer',
                        'Trade In Your Ride',
                        'We Want Your Car',
                        'Trade Offer',
                        'Trade-In Your Ride',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#115285,#115285)',
                        'border-color' => '#3585CB',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3585CB,#3585CB)',
                        'border-color' => '#276499',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#098E55,#098E55)',
                        'border-color' => '#48E62F',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D6525,#2D6525)',
                        'border-color' => '#2D6525',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CF240E,#CF240E)',
                        'border-color' => '#FB3342',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B53343,#B53343)',
                        'border-color' => '#772B31',
                        'color' => '#fff',
                    ),
                ),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB9B0B,#CB9B0B)',
                        'border-color' => '#FB3342',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B57033,#B57033)',
                        'border-color' => '#772B31',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
    ],
);