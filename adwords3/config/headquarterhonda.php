<?php

global $CronConfigs;
$CronConfigs["headquarterhonda"] = array(
    'password' => 'headquarterhonda',
    "email" => "regan@smedia.ca",
    'log' => false,
    "banner" => array(
        "template" => "headquarterhonda",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.fw-cta-button.fw-cta.fw-cta-bottom-center div.voi-link-vdp',
            'css-class' => 'div.voi-btn-vdp.voi-icon-bounce-vdp',
            'css-hover' => 'div.voi-btn-vdp.voi-icon-bounce-vdp:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.voi-btn-vdp.voi-icon-bounce-vdp',
                    'values' => array(
                        'Get E-Price',
                        'Get Internet Price',
                        'Get Your Price',
                        'Get Special Price',
                        'Get Our Best Price',
                        'Get Price Updates',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F1212C,#F1212C)',
                        'border-color' => '#f1212c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#82080F,#82080F)',
                        'border-color' => '#82080f',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#24B149,#24B149)',
                        'border-color' => '#24b149',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#135C26,#135C26)',
                        'border-color' => '#135c26',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#20609F,#20609F)',
                        'border-color' => '#20609f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0F2D4A,#0F2D4A)',
                        'border-color' => '#0f2d4a',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#20609f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#8A816B,#8A816B)',
                        'border-color' => '#0f2d4a',
                    ),
                ),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#20609f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#0f2d4a',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#20609f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00648C,#00648C)',
                        'border-color' => '#0f2d4a',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.fw-cta-button.fw-cta.fw-cta-bottom-center div.trade-link-vdp div.trade-btn-vdp.trade-icon-bounce-vdp',
            'css-class' => 'div.trade-btn-vdp.trade-icon-bounce-vdp',
            'css-hover' => 'div.trade-btn-vdp.trade-icon-bounce-vdp:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'div.trade-btn-vdp.trade-icon-bounce-vdp',
                    'values' => array(
                        'Get Trade-In Value',
                        'What\'s Your Trade Worth?',
                        'We\'ll Buy Your Car',
                    ),
                ],
            ],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F1212C,#F1212C)',
                        'border-color' => '#f1212c',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#82080F,#82080F)',
                        'border-color' => '#82080f',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#24B149,#24B149)',
                        'border-color' => '#24b149',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#135C26,#135C26)',
                        'border-color' => '#135c26',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#20609F,#20609F)',
                        'border-color' => '#20609f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0F2D4A,#0F2D4A)',
                        'border-color' => '#0f2d4a',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#20609f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#8A816B,#8A816B)',
                        'border-color' => '#0f2d4a',
                    ),
                ),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#20609f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#0f2d4a',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#20609f',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#00648C,#00648C)',
                        'border-color' => '#0f2d4a',
                    ),
                ),
            ),
        ],
    ],
);