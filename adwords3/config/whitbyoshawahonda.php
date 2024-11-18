<?php

global $CronConfigs;
$CronConfigs["whitbyoshawahonda"] = array(
    'password' => 'whitbyoshawahonda',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'tag_debug' => false,
    "banner" => array(
        "template" => "whitbyoshawahonda",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#db161c",
            "#db161c",
),
        'button_color_hover' => array(
            "#750e11",
            "#750e11",
),
        'button_color_active' => array(
            "#750e11",
            "#750e11",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$500 Credit towards Any Extended Coverages on New Vehicles",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Whitby Oshawa Honda Team",
        'forward_email_subject' => 'Pop-Up Offer',
        'forward_to' => array(
            "marshal@smedia.ca",
),
        'special_to' => array(
            'leads@whitbyoshawahonda.motosnap.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="sMedia Coupon"></id>
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
						<name part="full">Whitby Oshawa Honda</name>
						<email>[dealer_email]</email>
					</contact>
				</vendor>
				<provider>
					<name part="full">sMedia Coupon</name>
					<url>http://smedia.ca</url>
					<email>offers@mail.smedia.ca</email>
					<phone>855-775-0062</phone>
				</provider>
			</prospect>
		</adf>',
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
),
    'adf_to' => array(
        'leads@whitbyoshawahonda.motosnap.com',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'email_templates' => [
        'e-price' => [
            'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Question:[comments]<br/> First Name: [first_name]  Last Name: [last_name]  Email: [email] Phone:[phone] Sent From: [url] Button Clicked: [button_text]<br/>Referrer: [referrer]",
            'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model] Sent From: [url]</model>
            <stock>[stock_number]</stock>
        </vehicle>



       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments] Sent From: [url]  First Name: [first_name]  Last Name: [last_name]  Email: [email] Phone:[phone] </comments>
       </customer>
        <vendor>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>http://smedia.ca</url>
            <email>offers@mail.smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
],
        'finance' => [
            'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Question:[comments]<br/> First Name: [first_name]  Last Name: [last_name]  Email: [email] Phone:[phone] Sent From: [url] Button Clicked: [button_text]<br/>Referrer: [referrer]",
            'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model] Sent From: [url]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments] Sent From: [url] First Name: [first_name]  Last Name: [last_name]  Email: [email] Phone:[phone]</comments>
       </customer>

        <vendor>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>http://smedia.ca</url>
            <email>offers@mail.smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
],
        'trade-in' => [
            'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Question:[comments]<br/> First Name: [first_name]  Last Name: [last_name]  Email: [email] Phone:[phone] Sent From: [url] Button Clicked: [button_text]<br/>Referrer: [referrer]",
            'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="trade-in" status="used">
            <year>[trade_year]</year>
            <make>[trade_make]</make>
            <model>[trade_model]</model>
             <stock>[stock_number]</stock>
            
           
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments] Sent From: [url] First Name: [first_name]  Last Name: [last_name]  Email: [email] Phone:[phone]</comments>
       </customer>

        <vendor>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>http://smedia.ca</url>
            <email>offers@mail.smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
],
        'test-drive' => [
            'email' => "First Name: [first_name]<br/>Last Name: [last_name]<br/>Email: [email]<br/>Phone:[phone]<br/>Address:[address]<br/>Vehicle Use: [vehicle_use]<br/>Living: [living]<br/>Living Since: [living_since]<br/>Mortgage/Rent Payment: [mortgage_payment]<br/>Marital Status: [marital_status]<br/>Sent From: [url]<br/>Question:[comments]<br/> First Name: [first_name]  Last Name: [last_name]  Email: [email] Phone:[phone] Sent From: [url] <br/>Button Clicked: [button_text]<br/>Referrer: [referrer]",
            'ADF' => '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="sMedia"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model] Sent From: [url] </model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments] Sent From: [url] First Name: [first_name]  Last Name: [last_name]  Email: [email] Phone:[phone]</comments>
       </customer>
        <vendor>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia :: [button_name]</name>
            <url>http://smedia.ca</url>
            <email>offers@mail.smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>',
],
],
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-target="vdp_button_widget-8-modal"]',
            'css-class' => 'a[data-target="vdp_button_widget-8-modal"]',
            'css-hover' => 'a[data-target="vdp_button_widget-8-modal"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[data-target="vdp_button_widget-8-modal"]',
                    'values' => array(
                        '<i class="ddc-icon ddc-icon-banknote"></i>Best Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Internet Price Now',
                        '<i class="ddc-icon ddc-icon-banknote"></i>GET E-PRICE',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get your Price!',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Your Exclusive Price',
                        '<i class="ddc-icon ddc-icon-banknote"></i>SPECIAL PRICING!',
                        '<i class="ddc-icon ddc-icon-banknote"></i>GET SPECIAL OFFER',
                        '<i class="ddc-icon ddc-icon-banknote"></i>Special Pricing!',
                        '<i class="ddc-icon ddc-icon-banknote"></i>CURRENT MARKET PRICE',
                        '<i class="ddc-icon ddc-icon-banknote"></i>GET INTERNET SPECIAL',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE3000,#EE3000)',
                        'border-color' => 'EE3000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'platinum ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '00ABF1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '0093CF',
),
),
),
],
        'get-lease' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div a[data-target="vdp-inquire-modal"]',
            'css-class' => 'div a[data-target="vdp-inquire-modal"]',
            'css-hover' => 'div a[data-target="vdp-inquire-modal"]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div a[data-target="vdp-inquire-modal"]',
                    'values' => array(
                        'Financing Options',
                        'Calculate Your Payments',
                        'Estimate Payments',
                        'Payment options',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'Black' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
),
],
        //        'Used request-a-quote' => [
        //            'url-match' => '/\/vehicles\/[0-9]{4}/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'a[data-href*=eprice-form].btn.ddc-btn',
        //            'css-class' => 'a[data-href*=eprice-form].btn.ddc-btn',
        //            'css-hover' => 'a[data-href*=eprice-form].btn.ddc-btn:hover',
        //            'button_action' => [
        //                'form',
        //                'e-price',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'request-a-quote' => [
        //                    'target' => 'a[data-href*=eprice-form].btn.ddc-btn',
        //                    'values' => array(
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>Local Pricing',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>Best Price',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Internet Price Now',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>GET E-PRICE',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>Get your Price!',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Your Exclusive Price',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>SPECIAL PRICING!',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>GET SPECIAL OFFER',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>Special Pricing!',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>CURRENT MARKET PRICE',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>GET INTERNET SPECIAL',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>GET CURRENT MARKET DEAL',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Special Price!',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>Internet Price',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Sale Price',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>E- Price',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>Get Our Best Price',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>TODAY\'S MARKET PRICE',
        //                        '<i class="ddc-icon ddc-icon-banknote"></i>GET SPECIAL PRICE',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#F06B20,#F06B20)',
        //                        'border-color' => '#f06b20',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#CF540E,#CF540E)',
        //                        'border-color' => '#cf540e',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#54B740,#54B740)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#359D22,#359D22)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //                'Platinum' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#B9B099,#B9B099)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#ABA085,#ABA085)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //                'Black' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#333333,#333333)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#000000,#000000)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //            ),
        //        ],
        //        'request-information' => [
        //            'url-match' => '/\/vehicles\/[0-9]{4}/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'a[href*=lead-form].btn.ddc-btn.btn-default',
        //            'css-class' => 'a[href*="lead-form"].btn.ddc-btn.btn-default',
        //            'css-hover' => 'a[href*="lead-form"].btn.ddc-btn.btn-default:hover',
        //            'button_action' => [
        //                'form',
        //                'e-price',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'request-information' => [
        //                    'target' => 'a[href*=lead-form].btn.ddc-btn.btn-default',
        //                    'values' => array(
        //                        'More Info',
        //                        'Confirm Availability',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#F06B20,#F06B20)',
        //                        'border-color' => '#f06b20',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#CF540E,#CF540E)',
        //                        'border-color' => '#cf540e',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#54B740,#54B740)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#359D22,#359D22)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //                'Platinum' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#B9B099,#B9B099)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#ABA085,#ABA085)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //                'Black' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#333333,#333333)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#000000,#000000)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //            ),
        //        ],
        // 'Used request-information' => [
        //     'url-match' => '/\/vehicles\/[0-9]{4}/i',
        //     'target' => null,
        //     //Don't move button
        //     'locations' => [
        //         'default' => null,
        //     ],
        //     'action-target' => 'a[data-href*=lead-form].btn.ddc-btn.btn-default',
        //     'css-class' => 'a[data-href*=lead-form].btn.ddc-btn.btn-default',
        //     'css-hover' => 'a[data-href*=lead-form].btn.ddc-btn.btn-default:hover',
        //     'button_action' => [
        //         'form',
        //         'e-price',
        //     ],
        //     'sizes' => [
        //         '100' => [],
        //     ],
        //     'texts' => [
        //         'request-information' => [
        //             'target' => 'a[data-href*=lead-form].btn.ddc-btn.btn-default',
        //             'values' => array(
        //                 'More Info',
        //                 'Confirm Availability',
        //             ),
        //         ],
        //     ],
        //     'styles' => array(
        //         'orange' => array(
        //             'normal' => array(
        //                 'background' => 'linear-gradient(#F06B20,#F06B20)',
        //                 'border-color' => '#f06b20',
        //             ),
        //             'hover' => array(
        //                 'background' => 'linear-gradient(#CF540E,#CF540E)',
        //                 'border-color' => '#cf540e',
        //             ),
        //         ),
        //         'green' => array(
        //             'normal' => array(
        //                 'background' => 'linear-gradient(#54B740,#54B740)',
        //                 'border-color' => '#54b740',
        //             ),
        //             'hover' => array(
        //                 'background' => 'linear-gradient(#359D22,#359D22)',
        //                 'border-color' => '#359d22',
        //             ),
        //         ),
        //         'Platinum' => array(
        //             'normal' => array(
        //                 'background' => 'linear-gradient(#B9B099,#B9B099)',
        //                 'border-color' => '#1ca0d1',
        //             ),
        //             'hover' => array(
        //                 'background' => 'linear-gradient(#ABA085,#ABA085)',
        //                 'border-color' => '#188bb7',
        //             ),
        //         ),
        //         'Black' => array(
        //             'normal' => array(
        //                 'background' => 'linear-gradient(#333333,#333333)',
        //                 'border-color' => '#1ca0d1',
        //             ),
        //             'hover' => array(
        //                 'background' => 'linear-gradient(#000000,#000000)',
        //                 'border-color' => '#188bb7',
        //             ),
        //         ),
        //     ),
        // ],
        //        'trade-in' => [
        //            'url-match' => '/\/vehicles\/[0-9]{4}/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'a[href*=trade].btn.ddc-btn.btn-default',
        //            'css-class' => 'a[href*="trade"].btn.ddc-btn.btn-default',
        //            'css-hover' => 'a[href*="trade"].btn.ddc-btn.btn-default:hover',
        //            'button_action' => [
        //                'form',
        //                'trade-in',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'trade-in' => [
        //                    'target' => 'a[href*=trade].btn.ddc-btn.btn-default',
        //                    'values' => array(
        //                        'We\'ll Buy Your Car',
        //                        'Trade-in Offer',
        //                        'Trade In Your Ride',
        //                        'Trade Offer',
        //                        'Trade-in Special',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#F06B20,#F06B20)',
        //                        'border-color' => '#f06b20',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#CF540E,#CF540E)',
        //                        'border-color' => '#cf540e',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#54B740,#54B740)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#359D22,#359D22)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //                'Platinum' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#B9B099,#B9B099)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#ABA085,#ABA085)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //                'Black' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#333333,#333333)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#000000,#000000)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //            ),
        //        ],
        'test-drive' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-target="vdp_button_widget-5-modal"]',
            'css-class' => 'a[data-target="vdp_button_widget-5-modal"]',
            'css-hover' => 'a[data-target="vdp_button_widget-5-modal"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[data-target="vdp_button_widget-5-modal"]',
                    'values' => array(
                        'Schedule a Test Drive',
                        'Schedule My Visit',
                        'Want to Test Drive?',
                        'SCHEDULE A TEST DRIVE',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE3000,#EE3000)',
                        'border-color' => 'EE3000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'platinum ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '00ABF1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '0093CF',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '#vdp_button_widget-6 a[href*=trade-appraisal]',
            'css-class' => '#vdp_button_widget-6 a[href*=trade-appraisal]',
            'css-hover' => '#vdp_button_widget-6 a[href*=trade-appraisal]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => '#vdp_button_widget-6 a[href*=trade-appraisal]',
                    'values' => array(
                        'Appraise my trade in',
                        'Value your trade',
                        'What\'s your trade worth?',
                        'We want your car',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'Black' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'red' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#EE3000,#EE3000)',
                        'border-color' => 'EE3000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'platinum ' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '00ABF1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '0093CF',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '#vdp_button_widget-7 a[href*=financing-center]',
            'css-class' => '#vdp_button_widget-7 a[href*=financing-center]',
            'css-hover' => '#vdp_button_widget-7 a[href*=financing-center]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '#vdp_button_widget-7 a[href*=financing-center]',
                    'values' => array(
                        'No Hassle Financing',
                        'Get Financed Today',
                        'No hassle financing',
                        'Special Finance Offers!',
                        'Explore Payments',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#F06B20',
),
                    'hover' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359D22',
),
),
                'Black' => array(
                    'normal' => array(
                        'color' => '#ffffff',
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188BB7',
),
),
),
],
],
);