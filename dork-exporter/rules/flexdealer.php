<?php

global $site_rules;

$site_rules['flexdealer'] = array(
    'match-rules'   => array(
        '/Car Dealer Website by FlexDealer&trade;/',
        '/(?:New|Used|Pre-Owned) Vehicle/',
        '/<a href="\/avlogin">Dealer Login<\/a>/'
    ),
    'entry_points'  => array(
        'new'       => array(
            '/<a.+?(?=href)href="(?<url>[^"]+)"[^>]+>.*(?:New)\s*(?:Vehicle(?:s|\sInventory)|Inventory)/'
        ),
        'used'      => array(
            '/<a.+?(?=href)href="(?<url>[^"]+)"[^>]+>.*(?:Used|Pre-Owned|All)\s*(?:Vehicle(?:s|\sInventory)|Inventory)/'
        )
    ),
    'scrapper'      => 'flexdealer'
);

function flexdealer_dealer_address($host, $data)
{
    $regexes = array(
        'address_line1' => '/<div class="address">(?<address_line1>[^,]+),\s*(?<city>[^,]+),\s*(?<state>[^\s,]+).\s*(?<post_code>[^<]+)/',
        'city'          => '/<div class="address">(?<address_line1>[^,]+),\s*(?<city>[^,]+),\s*(?<state>[^\s,]+).\s*(?<post_code>[^<]+)/',
        'state'         => '/<div class="address">(?<address_line1>[^,]+),\s*(?<city>[^,]+),\s*(?<state>[^\s,]+).\s*(?<post_code>[^<]+)/',
        'post_code'     => '/<div class="address">(?<address_line1>[^,]+),\s*(?<city>[^,]+),\s*(?<state>[^\s,]+).\s*(?<post_code>[^<]+)/',
        'lat'           => '/new google.maps.LatLng\((?<lat>[^,]+),\s*(?<long>[^\)]+)/',
        'long'          => '/new google.maps.LatLng\((?<lat>[^,]+),\s*(?<long>[^\)]+)/'
    );
    
    $phone_regex = '/class="phone-value"[^>]+>(?<phone>[^<]+)/';
    
    $address = array();
    $match = null;
    
    foreach($regexes as $name => $regex)
    {
        if(preg_match($regex, $data, $match))
        {
            $address[$name] = $match[$name];
        }
    }
    
    if(preg_match_all($phone_regex, $data, $match))
    {
        $address['phones'] = $match['phone'];
    }
    
    return $address;
}

?>
