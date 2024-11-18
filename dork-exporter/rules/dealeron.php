<?php

global $site_rules;

$site_rules['dealeron'] = array(
    'match-rules'   => array(
        '/(?:DoesDealeronCookieExist\(\)|var DealerOn_BTS_Details)/'
    ),
    'entry_points'  => array(
        'new'       => array(
            '/href=\'(?<url>searchnew.aspx+)\'/'
        ),
        'used'      => array(
            '/href=\'(?<url>searchused.aspx+)\'/'
        )
    ),
    'scrapper'      => 'dealeron'
);

function dealeron_dealer_address($host, $data)
{
    $regexes = array(
        'address_line1' => '/<span itemprop="streetAddress">(?<address_line1>[^<]+)/',
        'city'          => '/<span itemprop="addressLocality">(?<city>[^<]+)/',
        'state'         => '/<span itemprop="addressRegion">(?<state>[^<]+)/',
        'post_code'     => '/<span itemprop="postalCode">(?<post_code>[^<]+)/',
        'lat'           => '/<meta name=geo.position content="(?<lat>[^,]+),(?<long>[^"]+)/',
        'long'          => '/<meta name=geo.position content="(?<lat>[^,]+),(?<long>[^"]+)/'
    );
    
    $phone_regex = '/<li class="tel[0-9]"><label>(?<phone>[^<]+)<\/label>\s*(?:<span class="callNowClass">)?\s*(?<number>[^<]+)/';
    
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
