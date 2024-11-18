<?php

global $CronConfigs;
$CronConfigs["winegardford"] = array(
    'password' => 'winegardford',
    "email" => "regan@smedia.ca",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'log' => true,
    "customer_id" => "100-617-8627",
    'max_cost' => 1250,
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_combined" => yes,
        "used_combined" => yes,
),
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
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#166ca0",
            "#023069",
),
        'button_color_hover' => array(
            "#54ce1c",
            "#0c6f15",
),
        'button_color_active' => array(
            "#e1a504",
            "#e1a504",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "Get \$200 off with this offer from WINEGARD MOTORS",
        'response_email' => "Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>WINEGARD MOTORS",
        'forward_to' => array(
            "barrie@winegardford.com",
            "marshal@smedia.ca",
),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
),
    "banner" => array(
        "template" => "winegardford",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Build your deal online at Winegard Ford! Stay home and buy your new vehicle online.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Build your deal online at Winegard Ford! Stay home and buy your new vehicle online.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "fb_style" => "facebook_new_ad",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.mod.inventory-lead-default .inner .inner2 .bd2 .ui-button.ui-widget.ui-state-default.ui-corner-all.ui-button-text-only.ui-button-submit',
            'css-class' => '.mod.inventory-lead-default .inner .inner2 .bd2 .ui-button.ui-widget.ui-state-default.ui-corner-all.ui-button-text-only.ui-button-submit',
            'css-hover' => '.mod.inventory-lead-default .inner .inner2 .bd2 .ui-button.ui-widget.ui-state-default.ui-corner-all.ui-button-text-only.ui-button-submit:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.mod.inventory-lead-default .inner .inner2 .bd2 .ui-button.ui-widget.ui-state-default.ui-corner-all.ui-button-text-only.ui-button-submit span',
                    'values' => array(
                        'Get More Info',
                        'Request Info',
                        'Learn More',
                        'Check Availability',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#004C82,#004C82)',
                        'border-color' => '004C82',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB1300,#CB1300)',
                        'border-color' => 'CB1300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#009922,#009922)',
                        'border-color' => '009922',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB7300,#CB7300)',
                        'border-color' => 'CB7300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => 'CB7300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => 'CB7300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
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
            'action-target' => '.ui-button.ui-widget.ui-state-default.ui-corner-all.icon-mycars-alerts.ui-button-text-icon-primary.mycars-btn.mycars-add-alert-btn.btn-no-decoration.medium',
            'css-class' => '.ui-button.ui-widget.ui-state-default.ui-corner-all.icon-mycars-alerts.ui-button-text-icon-primary.mycars-btn.mycars-add-alert-btn.btn-no-decoration.medium',
            'css-hover' => '.ui-button.ui-widget.ui-state-default.ui-corner-all.icon-mycars-alerts.ui-button-text-icon-primary.mycars-btn.mycars-add-alert-btn.btn-no-decoration.medium:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => '.ui-button.ui-widget.ui-state-default.ui-corner-all.icon-mycars-alerts.ui-button-text-icon-primary.mycars-btn.mycars-add-alert-btn.btn-no-decoration.medium span.ui-button-text',
                    'values' => array(
                        'Price Watch',
                        'Track Price',
                        'Price Track',
                        'Follow Price',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#004C82,#004C82)',
                        'border-color' => '004C82',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB1300,#CB1300)',
                        'border-color' => 'CB1300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#009922,#009922)',
                        'border-color' => '009922',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CB7300,#CB7300)',
                        'border-color' => 'CB7300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => 'CB7300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => 'CB7300',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
],
);