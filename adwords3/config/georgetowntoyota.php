<?php

global $CronConfigs;
$CronConfigs["georgetowntoyota"] = array(
    "name" => "georgetowntoyota",
    "email" => "regan@smedia.ca",
    "password" => "georgetowntoyota",
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#ED1A3B,#ED1A3B)',
                        'border-color' => '#ED1A3B',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '#0B9EEB',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6FB944,#6FB944)',
                        'border-color' => '#6FB944',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6900,#FF6900)',
                        'border-color' => '#FF6900',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
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
                        'background' => 'linear-gradient(#ED1A3B,#ED1A3B)',
                        'border-color' => '#ED1A3B',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '#0B9EEB',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6FB944,#6FB944)',
                        'border-color' => '#6FB944',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6900,#FF6900)',
                        'border-color' => '#FF6900',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
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
                        'background' => 'linear-gradient(#ED1A3B,#ED1A3B)',
                        'border-color' => '#ED1A3B',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '#0B9EEB',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6FB944,#6FB944)',
                        'border-color' => '#6FB944',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6900,#FF6900)',
                        'border-color' => '#FF6900',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
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
                        'background' => 'linear-gradient(#ED1A3B,#ED1A3B)',
                        'border-color' => '#ED1A3B',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '#0B9EEB',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6FB944,#6FB944)',
                        'border-color' => '#6FB944',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6900,#FF6900)',
                        'border-color' => '#FF6900',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
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
                        'background' => 'linear-gradient(#ED1A3B,#ED1A3B)',
                        'border-color' => '#ED1A3B',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2f,#151F2f)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '#0B9EEB',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2f,#151F2f)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6FB944,#6FB944)',
                        'border-color' => '#6FB944',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2f,#151F2f)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6900,#FF6900)',
                        'border-color' => '#FF6900',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2f,#151F2f)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
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
                        'background' => 'linear-gradient(#ED1A3B,#ED1A3B)',
                        'border-color' => '#ED1A3B',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '#0B9EEB',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6FB944,#6FB944)',
                        'border-color' => '#6FB944',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6900,#FF6900)',
                        'border-color' => '#FF6900',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
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
                        'background' => 'linear-gradient(#ED1A3B,#ED1A3B)',
                        'border-color' => '#ED1A3B',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2f,#151F2f)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '#0B9EEB',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2f,#151F2f)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6FB944,#6FB944)',
                        'border-color' => '#6FB944',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2f,#151F2f)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6900,#FF6900)',
                        'border-color' => '#FF6900',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2f,#151F2f)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
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
                        'background' => 'linear-gradient(#ED1A3B,#ED1A3B)',
                        'border-color' => '#ED1A3B',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '#0B9EEB',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6FB944,#6FB944)',
                        'border-color' => '#6FB944',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6900,#FF6900)',
                        'border-color' => '#FF6900',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
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
                        'background' => 'linear-gradient(#ED1A3B,#ED1A3B)',
                        'border-color' => '#ED1A3B',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#0B9EEB,#0B9EEB)',
                        'border-color' => '#0B9EEB',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6FB944,#6FB944)',
                        'border-color' => '#6FB944',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FF6900,#FF6900)',
                        'border-color' => '#FF6900',
                        'color' => '#FFFFFF',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#151F2F,#151F2F)',
                        'border-color' => '#151F2f',
                        'color' => '#FFFFFF',
                    ),
                ),
            ),
        ],
    ],
);