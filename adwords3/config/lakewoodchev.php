<?php

global $CronConfigs;
$CronConfigs["lakewoodchev"] = array(
    'password' => 'lakewoodchev',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    'tag_debug' => false,
    "banner" => array(
        "template" => "lakewoodchev",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#EEB30E',
            '#EEB30E',
),
        'button_color_hover' => array(
            '#94700A',
            '#94700A',
),
        'button_color_active' => array(
            '#000000',
            '#000000',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Schedule A Virtual Test Drive',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Lakewood Chevrolet Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@lakewoodchevrolet.motosnap.com',
),
        'special_email' => '',
        'display_after' => 20000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
    'adf_to' => array(
        'leads@lakewoodchevrolet.motosnap.com',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1',
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=eprice-form].btn',
            'css-class' => 'a[href*=eprice-form].btn',
            'css-hover' => 'a[href*=eprice-form].btn:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href*=eprice-form].btn',
                    'values' => array(
                        'Get E-Price',
                        'Get Your Price!',
                        'Local Pricing',
                        'Best Price',
                        'Get Your Exclusive Price',
                        'SPECIAL PRICING!',
                        'Get Special Price',
                        'Get Internet Price',
                        'Get Our Best Price',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '54B740',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-href*=lead-form].btn',
            'css-class' => 'a[data-href*=lead-form].btn',
            'css-hover' => 'a[data-href*=lead-form].btn:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'a[data-href*=lead-form].btn',
                    'values' => array(
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>Confirm Availability',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>More Info',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>Get More Information',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>Get More Info',
                        '<i class="ddc-icon-size-large ddc-icon-help-circle ddc-icon d-block pb-1 text-neutral-800"></i>Get More Details',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '54B740',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
),
],
        /*    'trade-in' => [
              'url-match' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
              'target' => null,
              //Don't move button
              'locations' => [
              'default' => null,
              ],
              'action-target' => 'a[href*=trade].btn.ddc-btn',
              'css-class' => 'a[href*="trade"].btn.ddc-btn',
              'css-hover' => 'a[href*="trade"].btn.ddc-btn:hover',
              'button_action' => [
              'form',
              'trade-in',
              ],
              'sizes' => [
              '100' => [],
              ],
              'texts' => [
              'trade-in' => [
              'target' => 'a[href*=trade].btn.ddc-btn',
              'values' => array(
              'What\'s Your Trade Worth?',
              'Trade In Your Ride',
              'Trade Offer',
              'Appraise Your Trade',
              'Get Trade-In Value',
              'Value Your Trade',
              ),
              ],
              ],
              'styles' => array(
              'blue' => array(
              'normal' => array(
              'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
              'border-color' => '#1CA0D1',
              ),
              'hover' => array(
              'background' => 'linear-gradient(#188BB7,#188BB7)',
              'border-color' => '#188BB7',
              ),
              ),
              'orange' => array(
              'normal' => array(
              'background' => 'linear-gradient(#F06B20,#F06B20)',
              'border-color' => '#F06B20',
              ),
              'hover' => array(
              'background' => 'linear-gradient(#CF540E,#CF540E)',
              'border-color' => '#CF540E',
              ),
              ),
              'red' => array(
              'normal' => array(
              'background' => 'linear-gradient(#E01212,#E01212)',
              'border-color' => '#E01212',
              ),
              'hover' => array(
              'background' => 'linear-gradient(#C60C0D,#C60C0D)',
              'border-color' => '#C60C0D',
              ),
              ),
              'green' => array(
              'normal' => array(
              'background' => 'linear-gradient(#54B740,#54B740)',
              'border-color' => '#54B740',
              ),
              'hover' => array(
              'background' => 'linear-gradient(#359D22,#359D22)',
              'border-color' => '#359D22',
              ),
              ),
              ),
              ], */
        'financing' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.payment-calculator-wrapper.bg-contrast-med.px-4.pb-4',
            'css-class' => 'div.payment-calculator-wrapper.bg-contrast-med.px-4.pb-4',
            'css-hover' => 'div.payment-calculator-wrapper.bg-contrast-med.px-4.pb-4:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div.payment-calculator-wrapper.bg-contrast-med.px-4.pb-4',
                    'values' => array(
                        '<i class="ddc-icon-dr-payment ddc-icon ddc-icon-size-"></i>Calculate Your Payments',
                        '<i class="ddc-icon-dr-payment ddc-icon ddc-icon-size-"></i>Estimate Payments',
                        '<i class="ddc-icon-dr-payment ddc-icon ddc-icon-size-"></i>Special Finance Offers',
                        '<i class="ddc-icon-dr-payment ddc-icon ddc-icon-size-"></i>Financing Options',
                        '<i class="ddc-icon-dr-payment ddc-icon ddc-icon-size-"></i>Payment Options',
                        '<i class="ddc-icon-dr-payment ddc-icon ddc-icon-size-"></i>Explore Payments',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'text-align' => 'center',
                        'line-height' => '17px',
                        'padding' => '15px 0px',
                        'margin' => '10px',
                        'font-weight' => '500',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'text-align' => 'center',
                        'line-height' => '17px',
                        'padding' => '15px 0px',
                        'margin' => '10px',
                        'font-weight' => '500',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'text-align' => 'center',
                        'line-height' => '17px',
                        'padding' => '15px 0px',
                        'margin' => '10px',
                        'font-weight' => '500',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '54B740',
                        'text-align' => 'center',
                        'line-height' => '17px',
                        'padding' => '15px 0px',
                        'margin' => '10px',
                        'font-weight' => '500',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'text-align' => 'center',
                        'line-height' => '17px',
                        'padding' => '15px 0px',
                        'margin' => '10px',
                        'font-weight' => '500',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'text-align' => 'center',
                        'line-height' => '17px',
                        'padding' => '15px 0px',
                        'margin' => '10px',
                        'font-weight' => '500',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'text-align' => 'center',
                        'line-height' => '17px',
                        'padding' => '15px 0px',
                        'margin' => '10px',
                        'font-weight' => '500',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'text-align' => 'center',
                        'line-height' => '17px',
                        'padding' => '15px 0px',
                        'margin' => '10px',
                        'font-weight' => '500',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.price-btn.cst-btn-1.mb-3 a[href*=schedule-form]',
            'css-class' => 'div.price-btn.cst-btn-1.mb-3 a[href*=schedule-form]',
            'css-hover' => 'div.price-btn.cst-btn-1.mb-3 a[href*=schedule-form]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.price-btn.cst-btn-1.mb-3 a[href*=schedule-form]',
                    'values' => array(
                        'WANT TO TEST RIDE?',
                        'Request a Test Drive',
                        'Test Drive',
                        'Schedule A Test Drive',
                        'TEST RIDE',
                        'Schedule My Visit',
                        'Want to Test Drive?',
                        'SCHEDULE A TEST DRIVE',
                        'Book My Test Drive',
),
],
],
            'styles' => array(
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '54B740',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'font-weight' => '700',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'font-weight' => '700',
                        'color' => '#fff',
),
),
),
],
],
);