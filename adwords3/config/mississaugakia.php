<?php

global $CronConfigs;
$CronConfigs["mississaugakia"] = array(
    "name" => "mississaugakia",
    "email" => "regan@smedia.ca",
    "password" => "mississaugakia",
    "log" => true,
    //    'adf_to' => '',
    'form_live' => false,
    'buttons_live' => true,
    'buttons' => [
        ///NEW  Book a Test Drive///
        'test-drive' => [
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
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(3) a.btn-incentives-new',
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
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
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
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#171717,#171717)',
                        'border-color' => '#171717',
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
            'action-target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new',
            'css-class' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new',
            'css-hover' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new',
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
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
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
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#171717,#171717)',
                        'border-color' => '#171717',
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
            'action-target' => 'a[href *=trade-in-appraisal].trade_value__cta',
            'css-class' => 'a[href *=trade-in-appraisal].trade_value__cta',
            'css-hover' => 'a[href *=trade-in-appraisal].trade_value__cta:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href *=trade-in-appraisal].trade_value__cta',
                    'values' => array(
                        '<i class="icon-Finance"></i>Get Trade-In Value',
                        '<i class="icon-Finance"></i>Trade Offer',
                        '<i class="icon-Finance"></i>What\'s Your Trade Worth?',
                        '<i class="icon-Finance"></i>Trade-In Appraisal',
                        '<i class="icon-Finance"></i>Appraise Your Trade',
                        '<i class="icon-Finance"></i>We Want Your Car',
                        '<i class="icon-Finance"></i>We\'ll Buy Your Car',
                        '<i class="icon-Finance"></i>Value Your Trade',
                    ),
                ],
            ],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
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
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',
                        'font-family' => '\'designkiav3\'',
                        'font-weight' => '400',
                        'padding-top' => '8px',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#171717,#171717)',
                        'border-color' => '#171717',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
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
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                      
                        'font-weight' => '400',                        
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                       
                        'font-weight' => '400',                        
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
                        'letter-spacing' => '0.1px',                      
                        'font-weight' => '400',                        
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                 
                        'font-weight' => '400',                        
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#171717,#171717)',
                        'border-color' => '#171717',
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
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) #request-info',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) #request-info',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) #request-info:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'request-information' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) #request-info',
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
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                    
                        'font-weight' => '400',                       
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                       
                        'font-weight' => '400',                       
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
                        'letter-spacing' => '0.1px',                      
                        'font-weight' => '400',                       
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                     
                        'font-weight' => '400',                     
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#171717,#171717)',
                        'border-color' => '#171717',
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
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                      
                        'font-weight' => '400',                       
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                      
                        'font-weight' => '400',                        
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
                        'letter-spacing' => '0.1px',                      
                        'font-weight' => '400',                        
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                      
                        'font-weight' => '400',                        
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#171717,#171717)',
                        'border-color' => '#171717',
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
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) div:nth-of-type(4) .btn-orange-vehicles1',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) div:nth-of-type(4) .btn-orange-vehicles1',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) div:nth-of-type(4) .btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'test-drive',
            ],
            'sizes' => [
                '100' => [],
            ],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) div:nth-of-type(4) .btn-orange-vehicles1',
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
                        'background' => 'linear-gradient(#C21116,#C21116)',
                        'border-color' => '#c21116',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                    
                        'font-weight' => '400',                       
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
                        'border-color' => '#9d0a0e',
                        'color' => '#fff',
                    ),
                ),
                'light-grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#9E9E9E,#9E9E9E)',
                        'border-color' => '#9e9e9e',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                      
                        'font-weight' => '400',                       
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
                        'letter-spacing' => '0.1px',                      
                        'font-weight' => '400',                       
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#3D3D3D,#3D3D3D)',
                        'border-color' => '#3d3d3d',
                        'color' => '#fff',
                    ),
                ),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#000000',
                        'color' => '#fff',
                        'letter-spacing' => '0.1px',                       
                        'font-weight' => '400',                      
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#171717,#171717)',
                        'border-color' => '#171717',
                        'color' => '#fff',
                    ),
                ),
            ),
        ],
    ],
);