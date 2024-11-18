<?php

global $site_rules;

$site_rules['dealercom'] = array(
    'match-rules'   => array(
        '/<a.+?(?=href)href="(?<url>\/(?:new|used)-inventory\/index.htm)/',
        '/"\/\/static.dealer.com/'
    ),
    'entry_points'  => array(
        'new'       => array(
            '/<a.+?(?=href)href="(?<url>\/new-inventory\/index.htm)/'
        ),
        'used'      => array(
            '/<a.+?(?=href)href="(?<url>\/used-inventory\/index.htm)/'
        )
    ),
    'scrapper'      => array(
        array('rule'  => '/<ul class="inventoryList data full">/', 'name'  => 'dealercom'),
        array('rule'  => '/<ul id="fullview">/', 'name'  => 'dealercomvr')
    )
);

function dealercom_dealer_address($host, $data)
{
    $regexes = array(
        'address_line1' => '/<span class="street-address">(?<address_line1>[^<]+)/',
        'city'          => '/<span class="locality">(?<city>[^<]+)/',
        'state'         => '/<span class="region">(?<state>[^<]+)/',
        'post_code'     => '/<span class="postal-code">(?<post_code>[^<]+)/',
        'lat'           => '/data-markers-list="\[\[(?<lat>[-0-9.]+), (?<long>[-0-9.]+)\]\]"/',
        'long'          => '/data-markers-list="\[\[(?<lat>[-0-9.]+), (?<long>[-0-9.]+)\]\]"/'
    );
    
    $phone_regex = '/(?<phone>Studio|Sales|Service|Parts)<\/span><span class="separator">:<\/span>\s*<span class="value">(?<number>[^<]+)/';
    
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
    
    if(!isset($address['lat']))
    {
        $url = "http://$host/dealership/directions.htm";
        $data = load_url_data($url);
        
        foreach($regexes as $name => $regex)
        {
            if(preg_match($regex, $data, $match))
            {
                $address[$name] = $match[$name];
            }
        }
    }
    
    return $address;
}