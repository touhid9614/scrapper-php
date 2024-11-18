<?php

global $CronConfigs;
$CronConfigs["eagleridgegm"] = array(
    'name' => 'eagleridgegm',
    'password' => 'eagleridgegm',
    'max_cost' => 2400,
    'cost_distribution' => array(
        'adwords' => 2300,
        'youtube' => 100,
),
    'tag_debug' => false,
    'tag_settings' => array(
        'event_tracking' => true,
        'button' => false,
),
    'email' => 'regan@smedia.ca',
    'log' => true,
    'create' => array(),
    'new_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'used_descs' => array(
        array(
            'desc1' => 'Test Drive the [year]',
            'desc2' => '[make] [model] today.',
),
        array(
            'desc1' => 'Call us today about the ',
            'desc2' => '[year] [make] [model] today',
),
),
    'customer_id' => '163-396-9643',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'eagleridgegm',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Price: [price]. Click for more info.',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today. Price: [price].',
        'fb_dynamiclead_description_new' => 'Are you still interested in the [year] [make] [model]? Eagle Ridge has a price match guarantee and will give you top value for your trade! Click below, fill in your info and get a $25 gas card for test driving! A product specialist will be in touch to help you out.',
        'fb_dynamiclead_description_used' => 'Are you still interested in the [year] [make] [model]? Eagle ridge GM saves you money and will give you top value for your trade. Click below, fill out your info and a product specialist will be in touch to help out.',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'styels' => array(
            'new_display' => 'dynamic_banner',
            'used_display' => 'dynamic_banner',
            'new_retargeting' => 'dynamic_banner',
            'used_retargeting' => 'dynamic_banner',
            'new_marketbuyers' => 'dynamic_banner',
            'used_marketbuyers' => 'dynamic_banner',
),
        'font_color' => '#ffffff',
),
    'lead' => null,
    'adf_to' => array(
        'internetleads@eagleridgegm.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => array(
        'test-drive' => array(
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel span',
            'css-class' => 'a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel span',
            'css-hover' => 'a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel span:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'a.iframe-link.ed-custom-cta.btn-red-0.btn-incentives-new.btn-lg.btn-incentives-big.icon-Wheel span',
                    'values' => array(
                        'Schedule Test Drive',
                        'Schedule My Visit',
                        'Want To Test Drive?',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'request-a-quote' => array(
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.payment-calculator-base .sect-5 a[onclick*=QuickQuote].cta.leasing div.ctas_container',
            'css-class' => '.payment-calculator-base .sect-5 a[onclick*=QuickQuote].cta.leasing div.ctas_container',
            'css-hover' => '.payment-calculator-base .sect-5 a[onclick*=QuickQuote].cta.leasing div.ctas_container:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => '.payment-calculator-base .sect-5 a[onclick*=QuickQuote].cta.leasing div.ctas_container',
                    'values' => array(
                        'Request a Quote',
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Your Price',
                        'Get Special Price',
                        'Today\'s Market Price',
                        'SPECIAL PRICING!',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'financing' => array(
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.payment-calculator-base .sect.sect-5  a[onclick*=CTA_ApplyForFinancing-new].cta.financing div.ctas_container',
            'css-class' => '.payment-calculator-base .sect.sect-5  a[onclick*=CTA_ApplyForFinancing-new].cta.financing div.ctas_container',
            'css-hover' => '.payment-calculator-base .sect.sect-5  a[onclick*=CTA_ApplyForFinancing-new].cta.financing div.ctas_container:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => '.payment-calculator-base .sect.sect-5  a[onclick*=CTA_ApplyForFinancing-new].cta.financing div.ctas_container',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Special Finance Offers',
                        'Special Finance Offers!',
                        'TODAY\'S MARKET PRICE',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'lease' => array(
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.payment-calculator-base .sect-5 a[onclick*=CTA_ApplyForLeasing].cta.financing div.ctas_container',
            'css-class' => '.payment-calculator-base .sect-5 a[onclick*=CTA_ApplyForLeasing].cta.financing div.ctas_container',
            'css-hover' => '.payment-calculator-base .sect-5 a[onclick*=CTA_ApplyForLeasing].cta.financing div.ctas_container:hover',
            'button_action' => array(
                'form',
                'lease',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'lease' => array(
                    'target' => '.payment-calculator-base .sect-5 a[onclick*=CTA_ApplyForLeasing].cta.financing div.ctas_container',
                    'values' => array(
                        'Lease Payments',
                        'Lease Quote',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'trade-in' => array(
            'url-match' => '/\\/(?:new)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => '.payment-calculator-base .sect-5 a[onclick*=trade-in].cta.leasing div.ctas_container',
            'css-class' => '.payment-calculator-base .sect-5 a[onclick*=trade-in].cta.leasing div.ctas_container',
            'css-hover' => '.payment-calculator-base .sect-5 a[onclick*=trade-in].cta.leasing div.ctas_container:hover',
            'button_action' => array(
                'form',
                'trade-in',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'trade-in' => array(
                    'target' => '.payment-calculator-base .sect-5 a[onclick*=trade-in].cta.leasing div.ctas_container',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade-In Your Ride',
                        'We Want Your Car',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'Used request-a-quote' => array(
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'a.iframe-link.btn-incentives-new.icon-Wheel,button.btn-grey-vehicles1.cube',
            'css-class' => 'a.iframe-link.btn-incentives-new.icon-Wheel,button.btn-grey-vehicles1.cube',
            'css-hover' => 'a.iframe-link.btn-incentives-new.icon-Wheel,button.btn-grey-vehicles1.cube:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'request-a-quote' => array(
                    'target' => 'a.iframe-link.btn-incentives-new.icon-Wheel,button.btn-grey-vehicles1.cube',
                    'values' => array(
                        'Get Internet Price',
                        'Get Our Best Price',
                        'Get Your Price',
                        'Get Special Price',
                        'Today\'s Market Price',
                        'Get a Quote',
                        'Request a Quote',
                        'SPECIAL PRICING!',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'Used financing' => array(
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'button#apply-for-finance.btn-orange-vehicles1',
            'css-class' => 'button#apply-for-finance.btn-orange-vehicles1',
            'css-hover' => 'button#apply-for-finance.btn-orange-vehicles1:hover',
            'button_action' => array(
                'form',
                'finance',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'button#apply-for-finance.btn-orange-vehicles1',
                    'values' => array(
                        'No Hassle Financing',
                        'Financing Available',
                        'Explore Payments',
                        'Get Financed Today',
                        'Special Finance Offers',
                        'Special Finance Offers!',
                        'TODAY\'S MARKET PRICE',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'Used request-info' => array(
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'button#request-info.btn-orange-vehicles1',
            'css-class' => 'button#request-info.btn-orange-vehicles1',
            'css-hover' => 'button#request-info.btn-orange-vehicles1:hover',
            'button_action' => array(
                'form',
                'e-price',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'financing' => array(
                    'target' => 'button#request-info.btn-orange-vehicles1',
                    'values' => array(
                        'Get More Information',
                        'Request More Info',
                        'Contact Us Now',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
        'Used test-drive' => array(
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            'locations' => array(
                'default' => null,
),
            'action-target' => 'button.btn-grey-vehicles1.book-vehicle-cta',
            'css-class' => 'button.btn-grey-vehicles1.book-vehicle-cta',
            'css-hover' => 'button.btn-grey-vehicles1.book-vehicle-cta:hover',
            'button_action' => array(
                'form',
                'test-drive',
),
            'sizes' => array(
                100 => array(),
),
            'texts' => array(
                'test-drive' => array(
                    'target' => 'button.btn-grey-vehicles1.book-vehicle-cta',
                    'values' => array(
                        'Test Drive Today',
                        'Schedule Test Drive',
                        'Schedule My Visit',
                        'Want To Test Drive?',
),
),
),
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'border-color' => 'CC0000',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'border-color' => '00A300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Black' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
),
),
);