<?php

global $CronConfigs;
$CronConfigs["tritruckcentre"] = array(
    "name" => " tritruckcentre",
    "email" => "regan@smedia.ca",
    "password" => " tritruckcentre",
    "no_adv" => true,
    'buttons_live' => true,
    'buttons' => [
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'p.btns-price-incentives-new span:nth-of-type(2) a',
            'css-class' => 'p.btns-price-incentives-new span:nth-of-type(2) a',
            'css-hover' => 'p.btns-price-incentives-new span:nth-of-type(2) a:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'p.btns-price-incentives-new span:nth-of-type(2) a',
                    'values' => array(
                        '<span style="font-family: roboto;">Request a Test Drive</span>',
                        '<span style="font-family: roboto;">Schedule a Test Drive</span>',
                        '<span style="font-family: roboto;">Test Drive Today</span>',
                        '<span style="font-family: roboto;">Test Drive Now</span>',
                        '<span style="font-family: roboto;">Schedule Your Visit</span>',
                        '<span style="font-family: roboto;">Want to Test Drive It?</span>',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'p.btns-price-incentives-new span:nth-of-type(3) a',
            'css-class' => 'p.btns-price-incentives-new span:nth-of-type(3) a',
            'css-hover' => 'p.btns-price-incentives-new span:nth-of-type(3) a:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'p.btns-price-incentives-new span:nth-of-type(3) a',
                    'values' => array(
                        '<span style="font-family: roboto;">Get More Information</span>',
                        '<span style="font-family: roboto;">Ask a Question</span>',
                        '<span style="font-family: roboto;">Let Our Experts Help</span>',
                        '<span style="font-family: roboto;">Ask Our Experts</span>',
                        '<span style="font-family: roboto;">More Information</span>',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'Listing request-a-quote' => [
            'url-match' => '/\\/new/i',
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
                'request-a-quote' => [
                    'target' => 'div.vehicle-cta a',
                    'values' => array(
                        'Get More Information',
                        'Ask a Question',
                        'Let Our Experts Help',
                        'Ask Our Experts',
                        'More Information',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'p.btns-price-incentives-new span:nth-of-type(1) a',
            'css-class' => 'p.btns-price-incentives-new span:nth-of-type(1) a',
            'css-hover' => 'p.btns-price-incentives-new span:nth-of-type(1) a:hover',
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'p.btns-price-incentives-new span:nth-of-type(1) a',
                    'values' => array(
                        '<span style="font-family: roboto;">Get Trade-In Value</span>',
                        '<span style="font-family: roboto;">Request Trade-In Value</span>',
                        '<span style="font-family: roboto;">Trade-In Appraisal</span>',
                        '<span style="font-family: roboto;">Appraise Your Trade</span>',
                        '<span style="font-family: roboto;">What\'s Your Trade Worth?</span>',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C47C18,#C47C18)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A96B14,#A96B14)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31A413,#31A413)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
    ],
);