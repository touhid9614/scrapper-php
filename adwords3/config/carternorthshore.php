<?php

global $CronConfigs;
$CronConfigs["carternorthshore"] = array(
    "name" => " carternorthshore",
    "email" => "regan@smedia.ca",
    "password" => " carternorthshore",
    "log" => true,
    'adf_to' => '',
    'form_live' => false,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => false,
    'buttons' => [
        //        'Listing request-a-quote' => [
        //            'url-match' => '/\\/used/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'div.vehicle-cta a.btn.ePrice',
        //            'css-class' => 'div.vehicle-cta a.btn.ePrice',
        //            'css-hover' => 'div.vehicle-cta a.btn.ePrice:hover',
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'request-a-quote' => [
        //                    'target' => 'div.vehicle-cta a.btn.ePrice',
        //                    'values' => array(
        //                        'Get A Quote',
        //                        'Get Internet Price',
        //                        'Get EPrice',
        //                        'Get Your Price',
        //                        'Get Special Price',
        //                        'Inquire Now',
        //                        'Inquire Today',
        //                        'Request A Quote',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#D47F00,#D47F00)',
        //                        'border-color' => '#f06b20',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#B97005,#B97005)',
        //                        'border-color' => '#cf540e',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //                'red' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#C3002F,#C3002F)',
        //                        'border-color' => '#e01212',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#AA0025,#AA0025)',
        //                        'border-color' => '#c60c0d',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#45BA00,#45BA00)',
        //                        'border-color' => '#54b740',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#3FA104,#3FA104)',
        //                        'border-color' => '#359d22',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //                'blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#0B498A,#0B498A)',
        //                        'border-color' => '#1ca0d1',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#0C4178,#0C4178)',
        //                        'border-color' => '#188bb7',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //            ),
        //        ],
        'request-a-quote' => [
            'url-match' => '/\\/new\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[href*="buildandprice"].btn-red-0',
            'css-class' => 'a[href*="buildandprice"].btn-red-0',
            'css-hover' => 'a[href*="buildandprice"].btn-red-0:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href*="buildandprice"].btn-red-0',
                    'values' => array(
                        'Get ePrice',
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Get Special Price',
                        'Get Your Price',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '#0B498A',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '#0C4178',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002F,#C3002F)',
                        'border-color' => '#C3002F',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#AA0025,#AA0025)',
                        'border-color' => '#AA0025',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47F00,#D47F00)',
                        'border-color' => '#D47F00',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B97005,#B97005)',
                        'border-color' => '#B97005',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3FA104,#3FA104)',
                        'border-color' => '#3FA104',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '#0B498A',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '#0C4178',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002F,#C3002F)',
                        'border-color' => '#C3002F',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#AA0025,#AA0025)',
                        'border-color' => '#AA0025',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47F00,#D47F00)',
                        'border-color' => '#D47F00',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B97005,#B97005)',
                        'border-color' => '#B97005',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3FA104,#3FA104)',
                        'border-color' => '#3FA104',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'test-drive' => [
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
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(5) a.btn-incentives-new',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '#0B498A',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '#0C4178',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002F,#C3002F)',
                        'border-color' => '#C3002F',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#AA0025,#AA0025)',
                        'border-color' => '#AA0025',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47F00,#D47F00)',
                        'border-color' => '#D47F00',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B97005,#B97005)',
                        'border-color' => '#B97005',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3FA104,#3FA104)',
                        'border-color' => '#3FA104',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'financing' => [
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
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new',
                    'values' => array(
                        '<span style="font-family: roboto;">No Hassle Financing</span>',
                        '<span style="font-family: roboto;">Get Financed Today</span>',
                        '<span style="font-family: roboto;">Financing Available</span>',
                        '<span style="font-family: roboto;">Apply for Financing</span>',
                        '<span style="font-family: roboto;">Special Finance Offers</span>',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '#0B498A',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '#0C4178',
                        'color' => '#fff',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002F,#C3002F)',
                        'border-color' => '#C3002F',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#AA0025,#AA0025)',
                        'border-color' => '#AA0025',
                        'color' => '#fff',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47F00,#D47F00)',
                        'border-color' => '#D47F00',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B97005,#B97005)',
                        'border-color' => '#B97005',
                        'color' => '#fff',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                        'color' => '#fff',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3FA104,#3FA104)',
                        'border-color' => '#3FA104',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
        'Used request-a-quote' => [
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) button',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) button',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) button:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) button',
                    'values' => array(
                        'Get A Quote',
                        'Get Internet Price',
                        'Get E Price',
                        'Inquire Now',
                        'Inquire Today',
                        'Request A Quote',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002F,#C3002F)',
                        'border-color' => '#C3002F',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#AA0025,#AA0025)',
                        'border-color' => '#AA0025',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '#0B498A',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '#0C4178',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47F00,#D47F00)',
                        'border-color' => '#D47F00',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B97005,#B97005)',
                        'border-color' => '#B97005',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3FA104,#3FA104)',
                        'border-color' => '#3FA104',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
            ),
        ],
        //        'Listing request-information' => [
        //            'url-match' => '/\\/used/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'div.vehicle-cta a',
        //            'css-class' => 'div.vehicle-cta a',
        //            'css-hover' => 'div.vehicle-cta a:hover',
        //            'button_action' => [
        //                'form',
        //                'e-price',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'request-information' => [
        //                    'target' => 'div.vehicle-cta a',
        //                    'values' => array(
        //                        'Get More Information',
        //                        'Ask for More Info',
        //                        'Learn More',
        //                        'More Info',
        //                        'Ask a Question',
        //                        'Let Our Experts Help',
        //                        'Ask an Expert',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#D47F00,#D47F00)',
        //                        'border-color' => '#f06b20',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#B97005,#B97005)',
        //                        'border-color' => '#cf540e',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //                'red' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#C3002F,#C3002F)',
        //                        'border-color' => '#e01212',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#AA0025,#AA0025)',
        //                        'border-color' => '#c60c0d',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#45BA00,#45BA00)',
        //                        'border-color' => '#54b740',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#3FA104,#3FA104)',
        //                        'border-color' => '#359d22',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //                'blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#0B498A,#0B498A)',
        //                        'border-color' => '#1ca0d1',
        //                        'color' => '#fff',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#0C4178,#0C4178)',
        //                        'border-color' => '#188bb7',
        //                        'color' => '#fff',
        //                    ),
        //                ),
        //            ),
        //        ],
        'Used test-drive' => [
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(5) button',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(5) button',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(5) button:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(5) button',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Test Drive No',
                    ),
                ],
            ],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '#0B498A',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '#0C4178',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002F,#C3002F)',
                        'border-color' => '#C3002F',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#AA0025,#AA0025)',
                        'border-color' => '#AA0025',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47F00,#D47F00)',
                        'border-color' => '#D47F00',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B97005,#B97005)',
                        'border-color' => '#B97005',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3FA104,#3FA104)',
                        'border-color' => '#3FA104',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
            ),
        ],
        //
        'Used trade-in' => [
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(4) button',
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
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                        'color' => '#fff',
                        'font-size' => '12px',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3FA104,#3FA104)',
                        'border-color' => '#3FA104',
                        'color' => '#fff',
                        'font-size' => '12px',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '#0B498A',
                         'color' => '#fff',
                        'font-size' => '12px',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '#0C4178',
                        'color' => '#fff',
                        'font-size' => '12px',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002F,#C3002F)',
                        'border-color' => '#C3002F',
                          'color' => '#fff',
                        'font-size' => '14px',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#AA0025,#AA0025)',
                        'border-color' => '#AA0025',
                         'color' => '#fff',
                        'font-size' => '12px',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47F00,#D47F00)',
                        'border-color' => '#D47F00',
                         'color' => '#fff',
                        'font-size' => '12px',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B97005,#B97005)',
                        'border-color' => '#B97005',
                         'color' => '#fff',
                        'font-size' => '12px',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
            ),
        ],
        //
        'Used financing' => [
            'url-match' => '/\\/used\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) button',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) button',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) button:hover',
            'button_action' => [
                'form',
                'finance',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'financing-color' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) button',
                    'values' => array(
                        'No Hassle Financing',
                        'Get Financed Today',
                        'Financing Available',
                        'Apply for Financing',
                        'Special Finance Offers',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C3002F,#C3002F)',
                        'border-color' => '#C3002F',
                         'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#AA0025,#AA0025)',
                        'border-color' => '#AA0025',
                         'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B498A,#0B498A)',
                        'border-color' => '#0B498A',
                        'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#0C4178,#0C4178)',
                        'border-color' => '#0C4178',
                         'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D47F00,#D47F00)',
                        'border-color' => '#D47F00',
                         'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#B97005,#B97005)',
                        'border-color' => '#B97005',
                          'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#45BA00,#45BA00)',
                        'border-color' => '#45BA00',
                          'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3FA104,#3FA104)',
                        'border-color' => '#3FA104',
                         'color' => '#fff',
                        'font-family' => 'ed-icons, roboto',
                    ),
                ),
            ),
        ],
    ],
);
