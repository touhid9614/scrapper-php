<?php

global $site_rules;

$site_rules['srathcom'] = array(
    'match-rules'   => array(
        '/<a.+?(?=href)href="\/inventory\/search\?stock_type=(?:NEW|USED)"/'
    ),
    'entry_points'  => array(
        'new'       => array(
            '/<a.+?(?=href)href="(?<url>\/inventory\/search\?stock_type=NEW)"/'
        ),
        'used'      => array(
            '/<a.+?(?=href)href="(?<url>\/inventory\/search\?stock_type=USED)"/'
        )
    ),
    'scrapper'      => 'srathcom'
);

function srathcom_dealer_address($host, $data)
{
    $regexes = array(
        'address_line1' => '/<span itemprop="streetAddress">(?<address_line1>[^<]+)/',
        'city'          => '/<span itemprop="addressLocality">(?<city>[^<]+)/',
        'state'         => '/<span itemprop="addressRegion">(?<state>[^<]+)/',
        'post_code'     => '/<span itemprop="postalCode">(?<post_code>[^<]+)/',
        'lat'           => '/<meta itemprop="latitude" content="(?<lat>[^"]+)"/',
        'long'          => '/<meta itemprop="longitude" content="(?<long>[^"]+)"/'
    );
    
    $phone_regex = '/<span itemprop="telephone">(?<phone>[^<]+)/';
    
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
