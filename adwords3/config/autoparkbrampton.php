<?php

global $CronConfigs;
$CronConfigs["autoparkbrampton"] = array(
    "name" => "autoparkbrampton",
    "email" => "regan@smedia.ca",
    "password" => "autoparkbrampton",
    "log" => true,
    //    'adf_to' => '',
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        ///USED Get Credit Approval///
        'Used financing' => [
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) div:nth-of-type(1) .btn-orange-vehicles1',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) div:nth-of-type(1) .btn-orange-vehicles1',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) div:nth-of-type(1) .btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'Used financing' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) div:nth-of-type(1) .btn-orange-vehicles1',
                    'values' => array(
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">No Hassle Financing</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Get Financed Today</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Financing Available</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Apply for Financing</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Special Finance Offers</span>',
                    ),
                ],
            ],
            'styles' => array(
                'orange ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => '#c47c18',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => '#a96b14',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => ' #184d7f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '#31a413',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '#288a0f',
                    ),
                ),
            ),
        ],
        ///USED Request More Information////
        'Used request-information' => [
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) .btn-orange-vehicles1',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) .btn-orange-vehicles1',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) .btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'Used request-information' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) .btn-orange-vehicles1',
                    'values' => array(
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Get More Information</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Ask for More Info</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Learn More</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Ask a Question</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Let Our Experts Help</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Ask an Expert</span>',
                    ),
                ],
            ],
            'styles' => array(
                'orange ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => ' #184d7f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '#31a413',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '#288a0f',
                    ),
                ),
            ),
        ],
        ///USED  Instant Trade Value///
        'Used trade-in' => [
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) .btn-orange-vehicles1',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) .btn-orange-vehicles1',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) .btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'Used trade-in' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) .btn-orange-vehicles1',
                    'values' => array(
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Get Trade-In Value</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Trade Offer</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">What\'s Your Trade Worth?</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Trade-In Appraisal</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Appraise Your Trade</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Value Your Trade</span>',
                    ),
                ],
            ],
            'styles' => array(
                'orange ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => ' #184d7f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '#31a413',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '#288a0f',
                    ),
                ),
            ),
        ],
        ///USED Book a Test Drive///
        'Used test-drive' => [
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) .btn-orange-vehicles1',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) .btn-orange-vehicles1',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) .btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'Used test-drive' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) .btn-orange-vehicles1',
                    'values' => array(
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Request a Test Drive</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Schedule a Test Drive</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Book Test Drive</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Want to Test Drive?</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Test Drive Today</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Test Drive Now</span>',
                    ),
                ],
            ],
            'styles' => array(
                'orange ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => ' #184d7f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '#31a413',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '#288a0f',
                    ),
                ),
            ),
        ],
        ///USED SRP///
        'Listing request-information' => [
            'url-match' => '/\\/used\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.vehicle-cta a',
            'css-class' => 'div.vehicle-cta a',
            'css-hover' => 'div.vehicle-cta a:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'div.vehicle-cta a',
                    'values' => array(
                        'Get More Information',
                        'Ask for More Info',
                        'Learn More',
                        'More Info',
                        'Ask a Question',
                        'Let Our Experts Help',
                        'Ask an Expert',
                    ),
                ],
            ],
            'styles' => array(
                'orange ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => ' #184d7f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '#31a413',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#288A0F,#288A0F)',
                        'border-color' => '#288a0f',
                    ),
                ),
            ),
        ],
    ],
);