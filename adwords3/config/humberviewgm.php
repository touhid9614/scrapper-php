<?php

global $CronConfigs;
$CronConfigs["humberviewgm"] = array(
    "name" => "humberviewgm",
    "email" => "regan@smedia.ca",
    "password" => "humberviewgm",
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
                'test-drive' => [
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#c33320',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#a92c1c',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#1f4581',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#193767',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#189138',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#14782e',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#c38820',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#a9761c',
                        'color' => '#fff',
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
                'request-information' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) .btn-orange-vehicles1',
                    'values' => array(
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Get More Information</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Ask for More Info</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Learn More</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">More Info</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Ask a Question</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Let Our Experts Help</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Ask an Expert</span>',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#c33320',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#a92c1c',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#1f4581',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#193767',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#189138',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#14782e',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#c38820',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#a9761c',
                        'color' => '#fff',
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
                'trade-in' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) .btn-orange-vehicles1',
                    'values' => array(
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Get Trade-In Value</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Trade Offer</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">What\'s Your Trade Worth?</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Trade-In Appraisal</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Appraise Your Trade</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">We Want Your Car</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">We\'ll Buy Your Car</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Value Your Trade</span>',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#c33320',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#a92c1c',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#1f4581',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#193767',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#189138',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#14782e',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#c38820',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#a9761c',
                        'color' => '#fff',
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
                'test-drive' => [
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#c33320',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#a92c1c',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#1f4581',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#193767',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#189138',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#14782e',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#c38820',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#a9761c',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        ///NEW  Book a Test Drive///
        'test-drive' => [
            'url-match' => '/\\/new\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new',
            'css-class' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new',
            'css-hover' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new',
                    'values' => array(
                        '<span style="font-family: roboto;">Request a Test Drive</span>',
                        '<span style="font-family: roboto;">Schedule a Test Drive</span>',
                        '<span style="font-family: roboto;">Book Test Drive</span>',
                        '<span style="font-family: roboto;">Want to Test Drive?</span>',
                        '<span style="font-family: roboto;">Test Drive Today</span>',
                        '<span style="font-family: roboto;">Test Drive Now</span>',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#c21116,#c21116)',
                        'border-color' => '#c21116',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9d0a0e,#9d0a0e)',
                        'border-color' => '#9d0a0e',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184d7f,#184d7f)',
                        'border-color' => '#184d7f',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123e65,#123e65)',
                        'border-color' => '#123e65',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31a413,#31a413)',
                        'border-color' => '#31a413',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#288a0f,#288a0f)',
                        'border-color' => '#288a0f',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#c47c18,#c47c18)',
                        'border-color' => '#c47c18',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#a96b14,#a96b14)',
                        'border-color' => '#a96b14',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        /// Get Our Best Price///
        'request-a-quote' => [
            'url-match' => '/\\/new\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(5) a.btn-incentives-new',
            'css-class' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(5) a.btn-incentives-new',
            'css-hover' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(5) a.btn-incentives-new:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(5) a.btn-incentives-new',
                    'values' => array(
                        '<span style="font-family: roboto;">Get A Quote</span>',
                        '<span style="font-family: roboto;">Get Internet Price</span>',
                        '<span style="font-family: roboto;">Get EPrice</span>',
                        '<span style="font-family: roboto;">Get Your Price</span>',
                        '<span style="font-family: roboto;">Get Special Price</span>',
                        '<span style="font-family: roboto;">Inquire Now</span>',
                        '<span style="font-family: roboto;">Inquire Today</span>',
                        '<span style="font-family: roboto;">Request A Quote</span>',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#c33320',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#a92c1c',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#1f4581',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#193767',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#189138',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#14782e',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#c38820',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#a9761c',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        ///NEW  Get Instant Trade Value///
        'trade-in' => [
            'url-match' => '/\\/new\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(3) a.btn-incentives-new',
            'css-class' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(3) a.btn-incentives-new',
            'css-hover' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(3) a.btn-incentives-new:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(3) a.btn-incentives-new',
                    'values' => array(
                        '<span style="font-family: roboto;">Get Trade-In Value</span>',
                        '<span style="font-family: roboto;">Trade Offer</span>',
                        '<span style="font-family: roboto;">What\'s Your Trade Worth?</span>',
                        '<span style="font-family: roboto;">Trade-In Appraisal</span>',
                        '<span style="font-family: roboto;">Appraise Your Trade</span>',
                        '<span style="font-family: roboto;">We Want Your Car</span>',
                        '<span style="font-family: roboto;">We\'ll Buy Your Car</span>',
                        '<span style="font-family: roboto;">Value Your Trade</span>',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#c21116,#c21116)',
                        'border-color' => '#c21116',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9d0a0e,#9d0a0e)',
                        'border-color' => '#9d0a0e',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184d7f,#184d7f)',
                        'border-color' => '#184d7f',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123e65,#123e65)',
                        'border-color' => '#123e65',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#31a413,#31a413)',
                        'border-color' => '#31a413',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#288a0f,#288a0f)',
                        'border-color' => '#288a0f',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#c47c18,#c47c18)',
                        'border-color' => '#c47c18',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#a96b14,#a96b14)',
                        'border-color' => '#a96b14',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        ///NEW SRP///
        'Listing request-a-quote' => [
            'url-match' => '/\\/new\\//i',
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
                        'Get A Quote',
                        'Get Internet Price',
                        'Get EPrice',
                        'Get Your Price',
                        'Get Special Price',
                        'Inquire Now',
                        'Inquire Today',
                        'Request A Quote',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#c33320',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#a92c1c',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#1f4581',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#193767',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#189138',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#14782e',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#c38820',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#a9761c',
                        'color' => '#fff',
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C33320,#C33320)',
                        'border-color' => '#c33320',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => '#a92c1c',
                        'color' => '#fff',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '#1f4581',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '#193767',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '#189138',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '#14782e',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => '#c38820',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => '#a9761c',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
    ],
);