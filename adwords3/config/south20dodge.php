<?php

global $CronConfigs;
$CronConfigs["south20dodge"] = array(
    'password' => 'south20dodge',
    "email" => "regan@smedia.ca",
    'log' => true,
    'bing_account_id' => 156004318,
    'customer_id' => '163-918-5023',
    'max_cost' => 1000,
    'cost_distribution' => array(
        'adwords' => 1000,
    ),
    "banner" => array(
        "template" => "south20dodge",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner"
        ),
    ),
    //  'lead_to'=>[],
  //  'form_live' => false,
    'buttons_live' => false,
    // 'buttons' => [
        // 'request-a-quote' => [
            // 'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            // 'target' => null,
            // 'locations' => [
                // 'default' => null,
            // ],
            // 'action-target' => 'a.cta.leasing[onclick*=GetaQuote] div.ctas_container',
            // 'css-class' => 'a.cta.leasing[onclick*=GetaQuote] div.ctas_container',
            // 'css-hover' => 'a.cta.leasing[onclick*=GetaQuote] div.ctas_container:hover',
// //            'button_action' => [
// //                'form',
// //                'e-price',
// //            ],
            // 'sizes' => [
                // '100' => [],
            // ],
            // 'texts' => [
                // 'request-a-quote' => [
                    // 'target' => 'a.cta.leasing[onclick*=GetaQuote] div.ctas_container',
                    // 'values' => array(
                        // 'Request a Quote',
                        // 'Get E-Price',
                        // 'Get Internet Price',
                        // 'Get Our Best Price',
                        // 'Get Your Price',
                        // 'Get Special Price',
                        // 'Today\'s Market Price',
                        // 'Check Availability',
                        // 'Get Special Price!',
                        // 'SPECIAL PRICING!',
                    // ),
                // ],
            // ],
            // 'styles' => array(
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cc7500',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cf540e',
                    // ),
                // ),
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#cc0000',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#c60c0d',
                    // ),
                // ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
                // 'Cyan' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
            // ),
        // ],
        // 'Used request-a-quote' => [
            // 'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
            // ],
            // 'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) button.btn-green',
            // 'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) button.btn-green',
            // 'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) button.btn-green:hover',
            // 'button_action' => [
                // 'form',
                // 'e-price',
            // ],
            // 'sizes' => [
                // '100' => [],
            // ],
            // 'texts' => [
                // 'request-a-quote' => [
                    // 'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) button.btn-green',
                    // 'values' => array(
                        // 'Request a Quote',
                        // 'Get E-Price',
                        // 'Get Internet Price',
                        // 'Get Our Best Price',
                        // 'Get Your Price',
                        // 'Get Special Price',
                        // 'Today\'s Market Price',
                        // 'Check Availability',
                        // 'Get Special Price!',
                        // 'SPECIAL PRICING!',
                    // ),
                // ],
            // ],
            // 'styles' => array(
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cc7500',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cf540e',
                    // ),
                // ),
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#cc0000',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#c60c0d',
                    // ),
                // ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
                // 'Cyan' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
            // ),
        // ],
        // 'Used request-information' => [
            // 'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
            // ],
            // 'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(6) button.btn-orange-vehicles1',
            // 'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(6) button.btn-orange-vehicles1',
            // 'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(6) button.btn-orange-vehicles1:hover',
            // 'sizes' => [
                // '100' => [],
            // ],
            // 'texts' => [
                // 'request-information' => [
                    // 'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(6) button.btn-orange-vehicles1',
                    // 'values' => array(
                        // 'Get More Information',
                        // 'Request Information',
                        // 'Contact Us.',
                        // 'Contact Us',
                        // 'Contact Store',
                        // 'Book Test Drive',
                        // 'Get More Information',
                        // 'Ask a Question',
                        // 'Inquire Now',
                        // 'Let our Experts Help',
                        // 'Ask an Expert',
                    // ),
                // ],
            // ],
            // 'styles' => array(
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cc7500',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cf540e',
                    // ),
                // ),
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#cc0000',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#c60c0d',
                    // ),
                // ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
                // 'Cyan' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
            // ),
        // ],
        // 'financing' => [
            // 'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
            // ],
            // 'action-target' => 'a.cta.financing[onclick*=ApplyForFinancing] div.ctas_container',
            // 'css-class' => 'a.cta.financing[onclick*=ApplyForFinancing] div.ctas_container',
            // 'css-hover' => 'a.cta.financing[onclick*=ApplyForFinancing] div.ctas_container:hover',
            // 'button_action' => [
                // 'form',
                // 'finance',
            // ],
            // 'sizes' => [
                // '100' => [],
            // ],
            // 'texts' => [
                // 'financing' => [
                    // 'target' => 'a.cta.financing[onclick*=ApplyForFinancing] div.ctas_container',
                    // 'values' => array(
                        // 'Apply for Financing',
                        // 'No hassle financing',
                        // 'Financing Available',
                        // 'Get Financed Today',
                        // 'Explore Payments',
                        // 'Special Finance Offers!',
                        // 'Special Finance Offers',
                    // ),
                // ],
            // ],
            // 'styles' => array(
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cc7500',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cf540e',
                    // ),
                // ),
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#cc0000',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#c60c0d',
                    // ),
                // ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
                // 'Cyan' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
            // ),
        // ],
        // 'trade-in' => [
            // 'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
            // ],
            // 'action-target' => 'a.cta.leasing[onclick*=AppraisemyTrade] div.ctas_container',
            // 'css-class' => 'a.cta.leasing[onclick*=AppraisemyTrade] div.ctas_container',
            // 'css-hover' => 'a.cta.leasing[onclick*=AppraisemyTrade] div.ctas_container:hover',
            // 'button_action' => [
                // 'form',
                // 'trade-in',
            // ],
            // 'sizes' => [
                // '100' => [],
            // ],
            // 'texts' => [
                // 'trade-in' => [
                    // 'target' => 'a.cta.leasing[onclick*=AppraisemyTrade] div.ctas_container',
                    // 'values' => array(
                        // 'Value Your Trade',
                        // 'Get Trade-In Value',
                        // 'Trade-In Your Ride',
                        // 'Trade Appraisal',
                        // 'What\'s Your Trade Worth?',
                        // 'We Want Your Car',
                        // 'Trade Appraisal',
                    // ),
                // ],
            // ],
            // 'styles' => array(
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cc7500',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cf540e',
                    // ),
                // ),
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#cc0000',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#c60c0d',
                    // ),
                // ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
                // 'Cyan' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
            // ),
        // ],
        // 'Used trade-in' => [
            // 'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            // 'target' => null,
            // //Don't move button
            // 'locations' => [
                // 'default' => null,
            // ],
            // 'action-target' => 'button[onclick*=TRADE].btn-orange-vehicles1.dealertrack-button-used.dollar-sign',
            // 'css-class' => 'button[onclick*=TRADE].btn-orange-vehicles1.dealertrack-button-used.dollar-sign',
            // 'css-hover' => 'button[onclick*=TRADE].btn-orange-vehicles1.dealertrack-button-used.dollar-sign:hover',
            // 'button_action' => [
                // 'form',
                // 'trade-in',
            // ],
            // 'sizes' => [
                // '100' => [],
            // ],
            // 'texts' => [
                // 'trade-in' => [
                    // 'target' => 'button[onclick*=TRADE].btn-orange-vehicles1.dealertrack-button-used.dollar-sign',
                    // 'values' => array(
                        // 'Value Your Trade',
                        // 'Get Trade-In Value',
                        // 'Trade-In Your Ride',
                        // 'Trade Appraisal',
                        // 'What\'s Your Trade Worth?',
                        // 'We Want Your Car',
                        // 'Trade Appraisal',
                    // ),
                // ],
            // ],
            // 'styles' => array(
                // 'orange' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cc7500',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#CF540E,#CF540E)',
                        // 'border-color' => '#cf540e',
                    // ),
                // ),
                // 'red' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#cc0000',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        // 'border-color' => '#c60c0d',
                    // ),
                // ),
                // 'blue' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#188BB7,#188BB7)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
                // 'Cyan' => array(
                    // 'normal' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#094e83',
                    // ),
                    // 'hover' => array(
                        // 'background' => 'linear-gradient(#0093CF,#0093CF)',
                        // 'border-color' => '#188bb7',
                    // ),
                // ),
            // ),
        // ],
    // ],
);
