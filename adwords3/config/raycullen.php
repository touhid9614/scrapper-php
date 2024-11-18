<?php

global $CronConfigs;
$CronConfigs["raycullen"] = array(
    "name" => "raycullen",
    "email" => "regan@smedia.ca",
    "password" => "raycullen",
    "log" => true,
    "fb_title" => "[year] [make] [model] [price]",
    'combined_feed_mode' => true,
    "banner" => array(
        "template" => "raycullen",
        //"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_description" => "Check out this [year] [make] [model] today! Click for more information.",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#AD0E11',
            '#AD0E11',
),
        'button_color_hover' => array(
            '#4C0708',
            '#4C0708',
),
        'button_color_active' => array(
            '#4C0708',
            '#4C0708',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Come in for Rays May Days!',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Ray Cullen Team',
        'forward_to' => array(
            'sgetty@raycullen.com',
            'marshal@smedia.ca',
),
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
),
    'lead_to' => array(
        'sgetty@raycullen.com',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-class' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
            'css-hover' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
                    'values' => array(
                        'Request A Quote',
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'E- Price',
                        'Get Our Best Price',
                        'Best Price',
                        'Local Pricing',
                        'Special Pricing!',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing',
                        'Check Availability',
                        'Get Special Price!',
                        'Special Price!',
),
],
],
            'styles' => array(
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
),
],
        'test-drive' => [
            'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-class' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
            'css-hover' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '[name="4969ed15-0c26-4ba1-8a8d-81cdc4ec014a"]',
                    'values' => array(
                        'Test Drive Now',
                        'Book Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Today',
                        'Book My Test Drive',
                        'Schedule My Test Drive',
),
],
],
            'styles' => array(
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
),
],
],
);