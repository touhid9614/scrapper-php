<?php

global $site_rules;

$site_rules['cobalt'] = array(
    'match-rules'   => array(
        '/<a.+?(?=href)href="(?<url>VehicleSearchResults\?search=(?:new|preowned))/'
    ),
    'entry_points'  => array(
        'new'       => array(
            '/<a.+?(?=href)href="(?<url>VehicleSearchResults\?search=new)/'
        ),
        'used'      => array(
            '/<a.+?(?=href)href="(?<url>VehicleSearchResults\?search=preowned)/'
        )
    ),
    'scrapper'      => 'cobalt'
);

function cobalt_dealer_address($host, $data)
{
    $regexes = array(
        'address_line1' => '/"addressLine1":"(?<address_line1>[^"]+)"/',
        'address_line2' => '/"addressLine2":"(?<address_line2>[^"]+)"/',
        'city'          => '/"city":"(?<city>[^"]+)"/',
        'state'         => '/"preferredState":"(?<state>[^"]+)"/',
        'zip'           => '/"zip":"(?<zip>[^"]+)"/',
        'lat'           => '/"latitude":"(?<lat>[^"]+)"/',
        'long'          => '/"longitude":"(?<long>[^"]+)"/'
    );
    
    $phone_regex = '/"(?<phone>[a-z]+?(?=Phone)Phone)":"(?<number>[^"]+)"/';
    
    $address = array();
    $match = null;
    
    foreach($regexes as $name => $regex)
    {
        if(preg_match($regex, $data, $match))
        {
            $address[$name] = $match[$name];
        }
    }
    
    $count = preg_match_all($phone_regex, $data, $match);
    
    if($count)
    {
        for($i = 0; $i < count($match['phone']); $i++)
        {
            $address['phones'][$match['phone'][$i]] = $match['number'][$i];
        }
    }
    
    return $address;
}

?>
