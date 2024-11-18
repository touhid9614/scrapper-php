<?php

global $CronConfigs;
$CronConfigs["martinsmall"] = array(
    "name" => " martinsmall",
    "email" => "regan@smedia.ca",
    "password" => " martinsmall",
    "log" => true,
    "banner" => array(
        "template" => "martinsmall",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
),
    'lead_to' => 'remi@martinsmall.ca',
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        'request-information' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'button.list-group-item.makeOfferCTA',
            'css-class' => 'button.list-group-item.makeOfferCTA',
            'css-hover' => 'button.list-group-item.makeOfferCTA:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'button.list-group-item.makeOfferCTA',
                    'values' => array(
                        'Create Your Deal',
                        'Send Your Offer',
                        'Negotiate Price',
                        'Make Your Deal',
                        'Place Your Bid',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F59110,#F59110)',
                        'border-color' => 'F06B20',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'CF540E',
                        'color' => '#FFFFFF',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F84A52,#F84A52)',
                        'border-color' => 'E01212',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'C60C0D',
                        'color' => '#FFFFFF',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D0D0D0,#D0D0D0)',
                        'border-color' => 'E01212',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'C60C0D',
                        'color' => '#FFFFFF',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFD53A,#FFD53A)',
                        'border-color' => 'E01212',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'C60C0D',
                        'color' => '#FFFFFF',
),
),
),
],
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'button.list-group-item.requestBrochureCTA',
            'css-class' => 'button.list-group-item.requestBrochureCTA',
            'css-hover' => 'button.list-group-item.requestBrochureCTA:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'button.list-group-item.requestBrochureCTA',
                    'values' => array(
                        'Request Flyer',
                        'Ask for Flyer',
                        'Request Pamphlet',
                        'Get Brochure',
                        'Get Flyer',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F59110,#F59110)',
                        'border-color' => 'F06B20',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'CF540E',
                        'color' => '#FFFFFF',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F84A52,#F84A52)',
                        'border-color' => 'E01212',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'C60C0D',
                        'color' => '#FFFFFF',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D0D0D0,#D0D0D0)',
                        'border-color' => 'E01212',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'C60C0D',
                        'color' => '#FFFFFF',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFD53A,#FFD53A)',
                        'border-color' => 'E01212',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'C60C0D',
                        'color' => '#FFFFFF',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/inventory\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'button.list-group-item.scheduleTestDriveCTA',
            'css-class' => 'button.list-group-item.scheduleTestDriveCTA',
            'css-hover' => 'button.list-group-item.scheduleTestDriveCTA:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'button.list-group-item.scheduleTestDriveCTA',
                    'values' => array(
                        'Book Test Drive',
                        'Test Drive Now',
                        'Schedule a Test Drive',
                        'Schedule Your Test Drive',
                        'Request A Test Drive',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F59110,#F59110)',
                        'border-color' => 'F06B20',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'CF540E',
                        'color' => '#FFFFFF',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F84A52,#F84A52)',
                        'border-color' => 'E01212',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'C60C0D',
                        'color' => '#FFFFFF',
),
),
                'grey' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D0D0D0,#D0D0D0)',
                        'border-color' => 'E01212',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'C60C0D',
                        'color' => '#FFFFFF',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFD53A,#FFD53A)',
                        'border-color' => 'E01212',
                        'color' => '#555555',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#191815,#191815)',
                        'border-color' => 'C60C0D',
                        'color' => '#FFFFFF',
),
),
),
],
],
);