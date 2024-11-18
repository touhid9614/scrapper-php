<?php
require_once 'config.php';
//require_once 'includes/loader.php';
//require_once 'includes/crm-defaults.php';

# ini_set('display_errors', 1);
# ini_set('display_startup_errors', 1);
# error_reporting(E_ALL);

session_start();

require_once ADSYNCPATH . 'config.php';
//require_once ADSYNCPATH . 'Google/Util.php';
//require_once ADSYNCPATH . 'utils.php';
//require_once ADSYNCPATH . 'db_connect.php';
require_once 'configuration-manager/config-template.php';
require_once 'configuration-manager/config-processor.php';

global $config_template;

use League\HTMLToMarkdown\HtmlConverter;

$converter = new HtmlConverter();

$data = [
    'password'  => 'barbermotors*pass',
    'banner'    => [
        'template'  => 'barbermotors',
        "styels"            => array(
            "new_display"       => "dynamic_banner",
            "new_retargeting"   => "dynamic_banner",
            "new_marketbuyers"  => "dynamic_banner",
        )
    ],
    "lead"  => array(
        'email_types'           => ['adf'],
        'live'                  => true,
        'lead_type_'            => true,
        'lead_type_new'         => true,
        'lead_type_used'        => true,
        'bg_color'              => "#efefef",
        'text_color'            => "#404450",
        'border_color'          => "#e5e5e5",
        'button_color'          => array("#003399", "#003399"),
        'button_color_hover'    => array("#0033cc", "#0033cc"),
        'button_color_active'   => array("#e1a504", "#e1a504"),
        'button_text_color'     => "#ffffff",
        'response_email_subject'=> "Get $200 off with this offer from Auffenberg of Carbondale",
        'response_email'        => "Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Auffenberg of Carbondale",
        'forward_to'            => array("avanvooren@chrisauffenberg.com", "AUFFENBERGOFCARBONDALE2032@ADFLEADS.COM", "marshal@smedia.ca"),
        'respond_from'          => "offers@smedia.ca",
        'forward_from'          => "offers@smedia.ca",
        'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
        'enable_adf'            => 'yes',
        'special_to'            => array('leads@bonitamitsu.motosnap.com'),
        'special_email'         =>  '<?xml version="1.0"?>
                    <?adf version="1.0"?>
                    <adf>
                        <prospect>
                            <id sequence="[total_count]" source="Bonita Springs Mitsubishi"></id>
                            <requestdate>[fdt]</requestdate>
                            <vehicle interest="buy" status="[stock_type]">
                                <year>[year]</year>
                                <make>[make]</make>
                                <model>[model]</model>
                                <stock>[stock_number]</stock>
                            </vehicle>

                           <customer>
                               <contact>
                                    <name part="full">[name]</name>
                                    <email>[email]</email>
                                    <phone>[phone]</phone>
                                </contact>
                           </customer>

                            <vendor>
                                <contact>
                                    <name part="full">Bonita Springs Mitsubishi</name>
                                    <email>[dealer_email]</email>
                                </contact>
                            </vendor>
                            <provider>
                                <name part="full">sMedia</name>
                                <url>https://smedia.ca</url>
                                <email>offers@smedia.ca</email>
                                <phone>855-775-0062</phone>
                            </provider>
                        </prospect>
                    </adf>',
    ),
    'enable_smart-offer'    => true,
    'enable_ai-buttons'    => true,
    'buttons_live'  => false,
    'button_text'   => [[
                    'name' => 'test-drive',
                    'target' => 'li.invScheduleRide a  > span.textbuttonContent',
                    'values' => [
                        'TEST RIDE TODAY',
                        'BOOK TEST RIDE',
                        'REQUEST A TEST RIDE',
                        'WANT TO TEST RIDE?',
                        'TEST RIDE',
                        'SCHEDULE MY VISIT',
                    ]
    ]],
    'button_styles'    => [
                'orange'  => [
                    'name'      => 'orange',
                    'normal'    => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#f06b20',
                        'border-color'     => '#f06b20',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ]),
                    'hover'     => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#cf540e',
                        'border-color'     => '#cf540e',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ])
                ],
                'red'  => [
                    'name'      => 'red',
                    'normal'    => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#e01212',
                        'border-color'     => '#e01212',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ]),
                    'hover'     => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#c60c0d',
                        'border-color'     => '#c60c0d',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ])
                ],
                'green'  => [
                    'name'      => 'green',
                    'normal'    => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#54b740',
                        'border-color'     => '#54b740',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ]),
                    'hover'     => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#359d22',
                        'border-color'     => '#359d22',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ])
                ],
                'blue'  => [
                    'name'      => 'blue',
                    'normal'    => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#1ca0d1',
                        'border-color'     => '#1ca0d1',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ]),
                    'hover'     => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#188bb7',
                        'border-color'     => '#188bb7',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ])
                ]
            ],
    'buttons'       => [
        'request-a-quote'  => [
            'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
            'target'    => null,        //Don't move button
            'locations' => [
                'default'   => null,    //Don't need to change location
            ],
            'action-target' => 'a.btn.eprice.dialog.button',
            'css-class' => 'a.btn.btn-default.eprice.dialog.button',
            'css-hover' => 'a.btn.btn-default.eprice.dialog.button:hover',
            'button_action' => ['form','e-price'],
            'sizes'     => [
                '100'   => [
                    //'font-size' => '1.4rem'
                ]
            ],
            'texts'     => [
                'request-a-quote'  => [
                    'target'    => 'a.btn.eprice.dialog.button',
                    'values'    => [
                        'Request A Quote',
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'E- Price',
                        'Get Internet Price Now!',
                        'Contact Us.',
                        'Get Our Best Price',
                        'Best Price',
                        'Contact Us',
                        'Contact Store',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing'
                    ]
                ]
            ],
            'styles'    => array_asoc_to_pair([
                'orange'  => [
                    'normal'    => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#f06b20',
                        'border-color'     => '#f06b20',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ]),
                    'hover'     => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#cf540e',
                        'border-color'     => '#cf540e',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ])
                ],
                'red'  => [
                    'normal'    => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#e01212',
                        'border-color'     => '#e01212',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ]),
                    'hover'     => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#c60c0d',
                        'border-color'     => '#c60c0d',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ])
                ],
                'green'  => [
                    'normal'    => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#54b740',
                        'border-color'     => '#54b740',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ]),
                    'hover'     => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#359d22',
                        'border-color'     => '#359d22',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ])
                ],
                'blue'  => [
                    'normal'    => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#1ca0d1',
                        'border-color'     => '#1ca0d1',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ]),
                    'hover'     => array_asoc_to_pair([
                        'background'       => 'none',
                        'background-color' => '#188bb7',
                        'border-color'     => '#188bb7',
                        'color'=> '#fff',
                        'display'=> 'block',
                        'float'=> 'none',
                        'font-family'=> 'Raleway, arial, sans-serif',
                        'font-size'=> '14px',
                        'font-weight'=> '700',
                        'line-height'=> '17px',
                        'margin'=> '30px 0 0',
                        'padding'=> '9px 10px',
                        'position'=> 'relative',
                        'text-align'=> 'center',
                        'text-decoration'=> 'none',
                    ])
                ]
            ])
        ]
    ]
];

$tdata = [
        'request-a-quote'  => [
            'target'    => 'a.btn.eprice.dialog.button',
            'values'    => [
                'Request A Quote',
                'Get E Price Now!',
                'Internet Price',
                'Get your Price!',
                'E- Price',
                'Get Internet Price Now!',
                'Contact Us.',
                'Get Our Best Price',
                'Best Price',
                'Contact Us',
                'Contact Store',
                'Local Pricing',
                'Special Pricing!',
                'Get More Information',
                'Ask a Question',
                'Inquire Now',
                'Get Active Market Price',
                'Get Market Price',
                'Market Pricing'
            ]
        ]
    ];

include 'bolts/header.php'
?>

<div class="inner-wrapper">

    <?php
    $select = 'config-add';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Configurations</h2>
                    </header>
                    
                    <div id="config-manager" class="panel-body">
                        
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
<?php
include 'bolts/footer.php';
?>
<script>
    (function($) {
        smedia_prepare_configuration($);
        sMedia.Configuration.init('#config-manager', <?= json_encode($config_template) ?>, <?= json_encode(array_remake($data)) ?>);
        /*
        sMedia.Configuration.rendered(function(){
            alert('Hello, render completed');
        });
        */
        sMedia.Configuration.render();
        //var control = new sMedia.Configuration.Types.string('banner[template]', {name : 'Template Directory'}, 'barbermotors');
        //alert(control.render());
    })(jQuery);
</script>