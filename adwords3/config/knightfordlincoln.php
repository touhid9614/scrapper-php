<?php

global $CronConfigs;
$CronConfigs["knightfordlincoln"] = array(
    'name' => 'Knight Ford Lincoln',
    //'budget'    => 2.0,
    'log' => true,
    // 'no_adv' => true,
    'password' => 'knightfordlincoln',
    'max_cost' => 800,
    "email" => "regan@smedia.ca",
    'bing_account_id' => 156002895,
    //tracker
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#343434',
            '#343434',
),
        'button_color_hover' => array(
            '#494949',
            '#494949',
),
        'button_color_active' => array(
            '#343434',
            '#343434',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $100 off with this offer from Knight Ford Lincoln',
        'response_email' => 'Hello [name],<p> Thank you for signing up for this offer! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Knight Ford Lincoln Team',
        'forward_to' => array(
            'mponto@knightfordlincoln.ca',
            'marshal@smedia.ca',
),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'special_type' => 'application/x-adf+xml',
        'special_to' => array(
            'leads@knightforlincoln.com',
            'knightfor.smedia@quickestreply.com',
),
        'special_email' => '<?xml version="1.0" encoding="UTF-8"
			<?adf version="1.0"
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Knight Ford Lincoln"></id>
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
                            <name part="full">Knight Ford Lincoln</name>
                            <email>[dealer_email]</email>
                        </contact>
                    </vendor>
                    <provider>
                        <name part="full">sMedia</name>
                        <url>http://smedia.ca</url>
                        <email>offers@mail.smedia.ca</email>
                        <phone>855-775-0062</phone>
                    </provider>
                </prospect>
            </adf>',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
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
    "host_url" => "http://www.knightfordlincoln.ca",
    //must start with http or https and end without /
    "display_url" => "http://www.knightfordlincoln.ca",
    //Max lenght 35 char
    'new_title2' => 'See Inventory, Prices & Offers',
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Free Shipping to Regina ",
            "desc2" => "on all [model]s .",
),
        array(
            "desc1" => "Free Shipping to Regina ",
            "desc2" => "Book a test drive!",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model].",
),
),
    "customer_id" => "827-507-5798",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "knightfordlincoln",
        'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click below for more information or give us a call to take it for a test drive!',
        'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim] today! Click for more information.',
        //"fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#0481c2",
        //"fb_marketplace_description" => "[description]",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_combined" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_combined" => "custom_banner",
),
        "font_color" => "#ffffff",
),
    'adf_to' => array(
        'leads@knightfordlincoln.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.button.cta-button.block.button-form.fancybox',
            'css-class' => 'a.button.cta-button.block.button-form.fancybox',
            'css-hover' => 'a.button.cta-button.block.button-form.fancybox:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.button.cta-button.block.button-form.fancybox',
                    'values' => array(
                        'Get E-Price Now',
                        'E-Price',
                        'Get Internet Price Now',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
                        'Confirm Availability',
                        'Get Your Best Price',
                        'Get Our Best Price',
                        'Get Sale Price',
                        'Exclusive Price',
                        'More Information',
                        'Details',
                        'Request a Quote',
                        'Estimate Payments',
                        'Calculate Payments',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
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
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
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
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
],
    'cost_distribution' => array(
       // 'new' => 605,
      //  'used' => 605,
          'adwords' => 800,
),
);
add_filter('filter_keywords_knightfordlincoln', 'filter_keywords_knightfordlincoln', 10, 2);
function filter_keywords_knightfordlincoln($keywords, $car)
{
    $additional_keywords = [];
    $keyword_templates = [
        '[year] [make] [model]',
        '[year] [model]',
        '[model] [make]',
        '[year] [make] [model] [trim]',
        '[make] [model] [trim]',
        '[stock_type] [make] [model]',
        '[stock_type] [year] [make] [model]',
        '[stock_type] [year] [make]',
];
    foreach ($keyword_templates as $template) {
        $keyword = str_replace("\n", '', processTextTemplate($template, $car, true));
        if ($keyword) {
            $additional_keywords[] = "[{$keyword}]";
            # Exact match keywords
            $additional_keywords[] = "\"{$keyword}\"";
            # Phrase match keywords
        }
    }
    return array_merge($keywords, $additional_keywords);
}