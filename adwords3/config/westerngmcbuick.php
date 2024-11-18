<?php
global $CronConfigs;
$CronConfigs['westerngmcbuick'] = array(
    //'budget'        => 2.0,
    'password' => 'westerngmcbuick',
    'bid' => 3.0,
    'log' => true,
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
    ),
    'on15' => true,
    "email" => "regan@smedia.ca",
    'max_cost' => 0,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
        'youtube' => 0,
        'service' => 0,
    ),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_display" => yes,
        "used_display" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => yes,
        "used_marketbuyers" => yes,
        "new_combined" => yes,
        "used_combined" => yes,
    ),
    "post_code" => "T5S 1C6",
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
        ),
    ),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
        ),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
        ),
    ),
    "options_descs" => array(
        array(
            "desc1" => "Equipped with [option]",
            "desc2" => "and [option]",
        ),
    ),
    "ymmcount_descs" => array(
        array(
            "desc1" => "We have [ymmcount] [make]",
            "desc2" => "[model] in stock",
        ),
    ),
    "customer_id" => "380-035-2228",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "westerngmcbuick",
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click here for more info or give us a call for a test drive! Amvic Licensed Dealership.',
		'fb_lookalike_description' => "Check out this [year] [make] [model] today! Amvic Licensed Dealership.",
        //custom-caption-retargeting
		//'fb_retargeting_description_2019_sierra 1500' => 'Are you still interested in the [year] [make] [model]? Truck Month is on now at Western GMC Buick. Get up to $10,000 total value on select Sierra models. Shop now!',
		//'fb_retargeting_description_2020_sierra 1500' => 'Are you still interested in the [year] [make] [model]? Truck Month is on now at Western GMC Buick. Get up to $10,000 total value on select Sierra models. Shop now!',
		//'fb_retargeting_description_2020_sierra 2500hd' => 'Are you still interested in the [year] [make] [model]? Truck Month is on now at Western GMC Buick. Get up to $10,000 total value on select Sierra models. Shop now!',
		//'fb_retargeting_description_2020_terrain' => 'Are you still interested in the [year] [make] [model]? Eligible Costco Member receive Costco Member Pricing PLUS $500 Costco Shop Card. Shop now!',
		//'fb_retargeting_description_2020_acadia' => 'Are you still interested in the [year] [make] [model]? Eligible Costco Member receive Costco Member Pricing PLUS $500 Costco Shop Card. Shop now!',
		//'fb_retargeting_description_2020_yukon' => 'Are you still interested in the [year] [make] [model]? Eligible Costco Member receive Costco Member Pricing PLUS $500 Costco Shop Card. Shop now!',
		//'fb_retargeting_description_2019_envision' => 'Are you still interested in the [year] [make] [model]? 15% of MSRP cash purchase credit on select new 2019 Buick Models In Stock. Shop now!',
		//'fb_retargeting_description_2019_enclave' => 'Are you still interested in the [year] [make] [model]? 15% of MSRP cash purchase credit on select new 2019 Buick Models In Stock. Shop now!',
		//'fb_retargeting_description_2019_encore' => 'Are you still interested in the [year] [make] [model]? 15% of MSRP cash purchase credit on select new 2019 Buick Models In Stock. Shop now!',
        //custom-caption-lookalike
		//'fb_lookalike_description_2019_sierra 1500' => "Check out this [year] [make] [model] today! Truck Month is on now at Western GMC Buick. Get up to $10,000 total value on select Sierra models. Click for more info!",
		//'fb_lookalike_description_2020_sierra 1500' => "Check out this [year] [make] [model] today! Truck Month is on now at Western GMC Buick. Get up to $10,000 total value on select Sierra models. Click for more info!",
		//'fb_lookalike_description_2020_sierra 2500hd' => "Check out this [year] [make] [model] today! Truck Month is on now at Western GMC Buick. Get up to $10,000 total value on select Sierra models. Click for more info!",
		//'fb_lookalike_description_2020_terrain' => "Check out this [year] [make] [model] today! Eligible Costco Member receive Costco Member Pricing PLUS $500 Costco Shop Card. Click for more info!",
		//'fb_lookalike_description_2020_acadia' => "Check out this [year] [make] [model] today! Eligible Costco Member receive Costco Member Pricing PLUS $500 Costco Shop Card. Click for more info!",
		//'fb_lookalike_description_2020_yukon' => "Check out this [year] [make] [model] today! Eligible Costco Member receive Costco Member Pricing PLUS $500 Costco Shop Card. Click for more info!",
		//'fb_lookalike_description_2019_envision' => "Check out this [year] [make] [model] today! 15% of MSRP cash purchase credit on select new 2019 Buick Models In Stock. Click for more info!",
		//'fb_lookalike_description_2019_enclave' => "Check out this [year] [make] [model] today! 15% of MSRP cash purchase credit on select new 2019 Buick Models In Stock. Click for more info!",
		//'fb_lookalike_description_2019_encore' => "Check out this [year] [make] [model] today! 15% of MSRP cash purchase credit on select new 2019 Buick Models In Stock. Click for more info!",
		//end-of-custom-caption
        "flash_style" => "default",
        "border_color" => "#7e7e7e",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
        ),
        'fb_style' => 'facebook_new_ad',
        "font_color" => "#ffffff",
    ),
    'adf_to' => array(
        'smedia@westerngmcbuick.net',
        'shahadathossainece08@gmail.com',
    ),
    'lead_to' => array(
        'ewsales@westerngm.com',
        'ellingson@westerngm.com',
        'adams@westerngm.com',
        'customercare1@westerngm.com',
        'customercare2@westerngm.com',
        'jstolk@westerngm.com',
    ),
    'form_live' => true,
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
            <model>[model]</model>
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
            <model>[model]</model>
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
  /*  'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
            'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => [
                'form',
                'e-price',
            ],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
                ],
            ],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
                    'values' => array(
                        'GET INTERNET PRICE',
                        'GET WESTERN PRICE',
                        'GET SPECIAL PRICE',
                        'GET OUR BEST PRICE',
                        'GET YOUR PRICE',
                        'INQUIRE TODAY',
                        'INQUIRE NOW',
                        'TODAY\'S MARKET PRICE',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
                        'Get Your Best Price',
                        'Internet Price',
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
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'financing' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            // 'button_action' => [
            //     'form',
            //     'finance',
            // ],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
                ],
            ],
            'texts' => [
                'financing' => [
                    'target' => 'a[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
                    'values' => array(
                        'Calculate Your Payments',
                        'Estimate Payments',
                        'Special Finance Offers',
                        'Financing Options',
                        'Explore Payments',
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
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
        'trade-in' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
            ],
            'action-target' => 'a#at_instantoffer_cta',
            'css-class' => 'a#at_instantoffer_cta',
            'css-hover' => 'a#at_instantoffer_cta:hover',
            'button_action' => [
                'form',
                'trade-in',
            ],
            'sizes' => [
                '100' => [
                    'font-size' => '1.4rem',
                ],
            ],
            'texts' => [
                'trade-in' => [
                    'target' => 'a#at_instantoffer_cta',
                    'values' => array(
                        'Trade-in your ride',
                        'Appraise Your Trade',
                        'Get Trade-In Value',
                        'What\'s Your Trade Worth',
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
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#cf540e',
                    ),
                ),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#c60c0d',
                    ),
                ),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#359d22',
                    ),
                ),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#188bb7',
                    ),
                ),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                    ),
                    'hover' => array(
                        'background' => 'linear-gradient(#F9F9F9,#E9E9E9)',
                        'border-color' => '#188bb7',
                    ),
                ),
            ),
        ],
    ],*/
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17476',
        'promotion_text' => 'Test Drive Today!',
        'promotion_color' => '#383838',
        'overlay_color' => '#FF0000',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF0000',
        'coupon_validity' => '7',
    ),
);