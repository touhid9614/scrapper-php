<?php

global $CronConfigs;
$CronConfigs["barneshdvictoria"] = array(
    'password' => 'barneshdvictoria',
    "email" => "regan@smedia.ca",
    'log' => true,
    "banner" => array(
        "template" => "barneshdvictoria",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
/*    'adf_to' => array(
        'victorialeads@barneshd.com',
    ),
    //This is for ADF XML eamils to CRM, usually this email addresses start with leads@ webleads@ etc, check special_to eamils for clarification
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/default.asp\\?page=x(?:New|PreOwned|)InventoryDetail/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'li.invGetQuote a > span.textbuttonContent',
            'css-class' => 'li.invGetQuote a',
            'css-hover' => 'li.invGetQuote a:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'li.invGetQuote a > span.textbuttonContent',
                    'values' => array(
                        'REQUEST A QUOTE',
                        'GET YOUR PRICE',
                        'GET CURRENT MARKET PRICE',
                        'GET OUR BEST PRICE',
                        'GET SPECIAL PRICING',
                        'INTERNET PRICE',
                        'BEST PRICE',
                        'Check Availability',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F68E1E,#F68E1E)',
                        'border-color' => '#f68e1e',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F62E1E,#F62E1E)',
                        'border-color' => '#f62e1e',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#178C34,#178C34)',
                        'border-color' => '#178c34',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#18779A,#18779A)',
                        'border-color' => '#18779a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#18779a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/default.asp\\?page=x(?:New|PreOwned|)InventoryDetail/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'li.invGetFinancing a > span.textbuttonContent',
            'css-class' => 'li.invGetFinancing a',
            'css-hover' => 'li.invGetFinancing a:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'li.invGetFinancing a > span.textbuttonContent',
                    'values' => array(
                        'NO HASSLE FINANCING',
                        'FINANCING AVAILABLE',
                        'GET FINANCED TODAY',
                        'SPECIAL FINANCE OFFERS',
                        'EXPLORE PAYMENTS',
                        'Special Finance Offers!',
                        'Special Finance Offers',
                        'TODAY\'S MARKET PRICE',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F68E1E,#F68E1E)',
                        'border-color' => '#f68e1e',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F62E1E,#F62E1E)',
                        'border-color' => '#f62e1e',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#178C34,#178C34)',
                        'border-color' => '#178c34',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#18779A,#18779A)',
                        'border-color' => '#18779a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#18779a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/default.asp\\?page=x(?:New|PreOwned|)InventoryDetail/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'li.invValueTrade a > span.textbuttonContent',
            'css-class' => 'li.invValueTrade a',
            'css-hover' => 'li.invValueTrade a:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'li.invValueTrade a > span.textbuttonContent',
                    'values' => array(
                        'VALUE YOUR TRADE',
                        'TRADE OFFER',
                        'TRADE APPRAISAL',
                        'TRADE-IN APPRAISAL',
                        'TRADE-IN YOUR RIDE',
                        'WHAT\'S YOUR TRADE WORTH?',
                        'GET TRADE-IN VALUE',
                        'WHAT\'S YOUR TRADE WORTH?',
                        'What is Your Trade Worth?',
                        'Trade Appraisal',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F68E1E,#F68E1E)',
                        'border-color' => '#f68e1e',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F62E1E,#F62E1E)',
                        'border-color' => '#f62e1e',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#178C34,#178C34)',
                        'border-color' => '#178c34',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#18779A,#18779A)',
                        'border-color' => '#18779a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#18779a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'test-drive' => [
            'url-match' => '/\\/default.asp\\?page=x(?:New|PreOwned|)InventoryDetail/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'li.invScheduleRide a  > span.textbuttonContent',
            'css-class' => 'li.invScheduleRide a',
            'css-hover' => 'li.invScheduleRide a:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'li.invScheduleRide a  > span.textbuttonContent',
                    'values' => array(
                        'TEST RIDE TODAY',
                        'BOOK TEST RIDE',
                        'REQUEST A TEST RIDE',
                        'WANT TO TEST RIDE?',
                        'TEST RIDE',
                        'SCHEDULE MY VISIT',
                        'TEST RIDE',
                        'Book My Test Drive',
                        'SCHEDULE MY TEST DRIVE',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F68E1E,#F68E1E)',
                        'border-color' => '#f68e1e',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F62E1E,#F62E1E)',
                        'border-color' => '#f62e1e',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#178C34,#178C34)',
                        'border-color' => '#178c34',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#18779A,#18779A)',
                        'border-color' => '#18779a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#18779a',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
    ],  */
);