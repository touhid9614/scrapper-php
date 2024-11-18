<?php

global $CronConfigs;

$CronConfigs["folsomlakevw"] = array (
  'name' => 'folsomlakevw',
  'email' => 'regan@smedia.ca',
  'password' => 'folsomlakevw',
  'log' => true,
  'banner' => 
  array (
    'template' => 'folsomlakevw',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => 'ffffff',
  ),
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
    'shown_cap' => false,
    'fillup_cap' => false,
    'session_close' => false,
    'device_type' => 
    array (
      'mobile' => true,
      'desktop' => true,
      'tablet' => true,
    ),
    'offer_minimum_price' => 0,
    'offer_maximum_price' => 10000000,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' => 
    array (
       '#00477C',
       '#00477C',
    ),
    'button_color_hover' => 
    array (
       '#0072C9',
       '#0072C9',
    ),
    'button_color_active' => 
    array (
       '#0072C9',
       '#0072C9',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$250 off coupon from Folsom Lake VW',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Folsom Lake VW Team',
    'forward_to' => 
    array (
       'ckoupas@folsomlakevw.com',
       'marshal@smedia.ca',
    ),
    'special_to' => 
    array (
       '',
    ),
    'special_email' => '',
    'display_after' => 30000,
    'retarget_after' => 5000,
    'fb_retarget_after' => 5000,
    'adword_retarget_after' => 5000,
    'visit_count' => 0,
    'lead_in' => 
    array (
      'vdp' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
  'lead_to' => 
  array (
     'ckoupas@folsomlakevw.com',
     'aileads@smedia.ca',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' => 
  array (
    'request-a-quote' => 
    array (
      'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => '.vehicle-action-btn button[data-url*=contact-form]',
      'css-class' => '.vehicle-action-btn button[data-url*=contact-form]',
      'css-hover' => '.vehicle-action-btn button[data-url*=contact-form]:hover',
      'button_action' => 
      array (
         'form',
         'e-price',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'request-a-quote' => 
        array (
          'target' => '.vehicle-action-btn button[data-url*=contact-form]',
          'values' => 
          array (
             'Get More Information',
             'Ask for More Info',
             'Learn More',
             'More Info',
             'Ask a Question',
             'Let Our Experts Help',
             'Ask an Expert',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#083167,#083167)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#06254E,#06254E)',
            'border-color' => 'C60C0D',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#FF6633,#FF6633)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#D05329,#D05329)',
            'border-color' => 'C60C0D',
          ),
        ),
        'light-blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#01B1EB,#01B1EB)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#009CCF,#009CCF)',
            'border-color' => 'C60C0D',
          ),
        ),
        'dark-grey' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#32312C,#32312C)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#252421,#252421)',
            'border-color' => 'C60C0D',
          ),
        ),
      ),
    ),
    'test-drive' => 
    array (
      'url-match' => '/\\/vehicle-details\\/(?:new|used)-[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => '.vehicle-action-btn button[data-url*=schedule-testdrive]',
      'css-class' => '.vehicle-action-btn button[data-url*=schedule-testdrive]',
      'css-hover' => '.vehicle-action-btn button[data-url*=schedule-testdrive]:hover',
      'button_action' => 
      array (
         'form',
         'test-drive',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'test-drive' => 
        array (
          'target' => '.vehicle-action-btn button[data-url*=schedule-testdrive]',
          'values' => 
          array (
             'Request a Test Drive',
             'Schedule a Test Drive',
             'Book Test Drive',
             'Want to Test Drive?',
             'Test Drive Today',
             'Test Drive Now',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#083167,#083167)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#06254E,#06254E)',
            'border-color' => 'C60C0D',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#FF6633,#FF6633)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#D05329,#D05329)',
            'border-color' => 'C60C0D',
          ),
        ),
        'light-blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#01B1EB,#01B1EB)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#009CCF,#009CCF)',
            'border-color' => 'C60C0D',
          ),
        ),
        'dark-grey' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#32312C,#32312C)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#252421,#252421)',
            'border-color' => 'C60C0D',
          ),
        ),
      ),
    ),
  ),
);