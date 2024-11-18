<?php

global $CronConfigs;
$CronConfigs["woodstockhyundai"] = array(
    "name" => "woodstockhyundai",
    "email" => "regan@smedia.ca",
    "password" => "woodstockhyundai",
    "log" => true,
    //    'adf_to' => '',
    'form_live' => false,
    'buttons_live' => true,
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#184d7f',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                        'color' => '#fff',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#060D4C,#060D4C)',
                        'border-color' => '#060d4c',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#040934,#040934)',
                        'border-color' => '#040934',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '#838383',
                        'color' => '#fff',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#545454,#545454)',
                        'border-color' => '#545454',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
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
                        'More Info</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Ask a Question</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Let Our Experts Help</span>',
                        '<span style="font-family: roboto;display: inline-block;margin-bottom: 10px;vertical-align: bottom;">Ask an Expert</span>',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#184d7f',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                        'color' => '#fff',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#060D4C,#060D4C)',
                        'border-color' => '#060d4c',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#040934,#040934)',
                        'border-color' => '#040934',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '#838383',
                        'color' => '#fff',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#545454,#545454)',
                        'border-color' => '#545454',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#184d7f',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                        'color' => '#fff',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#060D4C,#060D4C)',
                        'border-color' => '#060d4c',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#040934,#040934)',
                        'border-color' => '#040934',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '#838383',
                        'color' => '#fff',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#545454,#545454)',
                        'border-color' => '#545454',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#184d7f',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                        'color' => '#fff',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#060D4C,#060D4C)',
                        'border-color' => '#060d4c',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#040934,#040934)',
                        'border-color' => '#040934',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '#838383',
                        'color' => '#fff',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#545454,#545454)',
                        'border-color' => '#545454',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
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
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive Now',
                    ),
                ],
            ],
            'styles' => array(
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
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#060d4c,#060d4c)',
                        'border-color' => '#060d4c',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#040934,#040934)',
                        'border-color' => '#040934',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9e9e9e,#9e9e9e)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '#838383',
                        'color' => '#fff',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#545454,#545454)',
                        'border-color' => '#545454',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3d3d3d,#3d3d3d)',
                        'border-color' => '#3d3d3d',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#184d7f',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                        'color' => '#fff',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#060D4C,#060D4C)',
                        'border-color' => '#060d4c',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#040934,#040934)',
                        'border-color' => '#040934',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '#838383',
                        'color' => '#fff',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#545454,#545454)',
                        'border-color' => '#545454',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
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
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                        'Value Your Trade',
                    ),
                ],
            ],
            'styles' => array(
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
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#060d4c,#060d4c)',
                        'border-color' => '#060d4c',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#040934,#040934)',
                        'border-color' => '#040934',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9e9e9e,#9e9e9e)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '#838383',
                        'color' => '#fff',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#545454,#545454)',
                        'border-color' => '#545454',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3d3d3d,#3d3d3d)',
                        'border-color' => '#3d3d3d',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#184d7f',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                        'color' => '#fff',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#060D4C,#060D4C)',
                        'border-color' => '#060d4c',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#040934,#040934)',
                        'border-color' => '#040934',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '#838383',
                        'color' => '#fff',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#545454,#545454)',
                        'border-color' => '#545454',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#184D7F,#184D7F)',
                        'border-color' => '#184d7f',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#123E65,#123E65)',
                        'border-color' => '#123e65',
                        'color' => '#fff',
                    ),
                ),
                'dark-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#060D4C,#060D4C)',
                        'border-color' => '#060d4c',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#040934,#040934)',
                        'border-color' => '#040934',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#838383,#838383)',
                        'border-color' => '#838383',
                        'color' => '#fff',
                    ),
                ),
                'dark-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#545454,#545454)',
                        'border-color' => '#545454',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
    ],
);