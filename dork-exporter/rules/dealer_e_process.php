<?php

global $site_rules;

$site_rules['dealer_e_process'] = array(
    'match-rules'   => array(
        '/href="(?<url>\/search\/(?:new|used)\/tp(?:\/v:2\/)?)/'
    ),
    'entry_points'  => array(
        'new'       => array(
            '/href="(?<url>\/search\/new\/tp(?:\/v:2\/)?)/'
        ),
        'used'      => array(
            '/href="(?<url>\/search\/used\/tp(?:\/v:2\/)?)/'
        )
    ),
    'scrapper'      => 'dealer_e_process'
);

function dealer_e_process_dealer_address($host, $data)
{
    $regexes = array(
        'name'          => '/<option value="(?<lat>[^,]+),(?<long>[^,]+)">(?<name>[^:]+):\s*(?<address_line1>.+?) (?<city>\b\w+),\s?(?<state>.+?)\s?,\s?(?<post_code>[^<]+)/',
        'address_line1' => '/<option value="(?<lat>[^,]+),(?<long>[^,]+)">(?<name>[^:]+):\s*(?<address_line1>.+?) (?<city>\b\w+),\s?(?<state>.+?)\s?,\s?(?<post_code>[^<]+)/',
        'city'          => '/<option value="(?<lat>[^,]+),(?<long>[^,]+)">(?<name>[^:]+):\s*(?<address_line1>.+?) (?<city>\b\w+),\s?(?<state>.+?)\s?,\s?(?<post_code>[^<]+)/',
        'state'         => '/<option value="(?<lat>[^,]+),(?<long>[^,]+)">(?<name>[^:]+):\s*(?<address_line1>.+?) (?<city>\b\w+),\s?(?<state>.+?)\s?,\s?(?<post_code>[^<]+)/',
        'post_code'     => '/<option value="(?<lat>[^,]+),(?<long>[^,]+)">(?<name>[^:]+):\s*(?<address_line1>.+?) (?<city>\b\w+),\s?(?<state>.+?)\s?,\s?(?<post_code>[^<]+)/',
        'lat'           => '/<option value="(?<lat>[^,]+),(?<long>[^,]+)">(?<name>[^:]+):\s*(?<address_line1>.+?) (?<city>\b\w+),\s?(?<state>.+?)\s?,\s?(?<post_code>[^<]+)/',
        'long'          => '/<option value="(?<lat>[^,]+),(?<long>[^,]+)">(?<name>[^:]+):\s*(?<address_line1>.+?) (?<city>\b\w+),\s?(?<state>.+?)\s?,\s?(?<post_code>[^<]+)/'
    );
    
    $phone_regex = '/(?<phone>\(?[0-9]{3}\)?[\s.-]?[0-9]{3}[\s.-][0-9]{4})/';
    
    $address = array();
    $match = null;
    
    $url = "http://$host/hours-and-directions/";
    $data = load_url_data($url);

    foreach($regexes as $name => $regex)
    {
        if(preg_match($regex, $data, $match))
        {
            $address[$name] = $match[$name];
        }
    }
    
    $regexes_2 = array(
        'name'          => '/<p class="fl_l thm-light_text_color">\s*<span class="bold">(?<name>[^<]+)<\/span><br\s?\/>(?<address_line1>[^<]+)<br\s?\/>(?<city>[^,]+),\s*(?<state>[A-Z]{2})\s*(?<post_code>[^<]+)/',
        'address_line1' => '/<p class="fl_l thm-light_text_color">\s*<span class="bold">(?<name>[^<]+)<\/span><br\s?\/>(?<address_line1>[^<]+)<br\s?\/>(?<city>[^,]+),\s*(?<state>[A-Z]{2})\s*(?<post_code>[^<]+)/',
        'city'          => '/<p class="fl_l thm-light_text_color">\s*<span class="bold">(?<name>[^<]+)<\/span><br\s?\/>(?<address_line1>[^<]+)<br\s?\/>(?<city>[^,]+),\s*(?<state>[A-Z]{2})\s*(?<post_code>[^<]+)/',
        'state'         => '/<p class="fl_l thm-light_text_color">\s*<span class="bold">(?<name>[^<]+)<\/span><br\s?\/>(?<address_line1>[^<]+)<br\s?\/>(?<city>[^,]+),\s*(?<state>[A-Z]{2})\s*(?<post_code>[^<]+)/',
        'post_code'     => '/<p class="fl_l thm-light_text_color">\s*<span class="bold">(?<name>[^<]+)<\/span><br\s?\/>(?<address_line1>[^<]+)<br\s?\/>(?<city>[^,]+),\s*(?<state>[A-Z]{2})\s*(?<post_code>[^<]+)/',
        'lat'           => '/var latLng  = new google.maps.LatLng\((?<lat>[^,]+),\s*(?<long>[^\)]+)/',
        'long'          => '/var latLng  = new google.maps.LatLng\((?<lat>[^,]+),\s*(?<long>[^\)]+)/'
    );
    
    if(!isset($address['name']))
    {
        foreach($regexes_2 as $name => $regex)
        {
            if(preg_match($regex, $data, $match))
            {
                $address[$name] = $match[$name];
            }
        }
    }
    
    if(preg_match_all($phone_regex, $data, $match))
    {
        $address['phones'][] = $match['phone'];
    }
    
    return $address;
}

?>
