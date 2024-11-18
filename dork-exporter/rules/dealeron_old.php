<?php

global $site_rules;

$site_rules['dealeron_old'] = array(
    'match-rules'   => array(
        '/ Site designed by <a href="http:\/\/www.dealeron.com">DealerOn<\/a>, Inc.<\/div>/'
    ),
    'entry_points'  => array(
        'new'       => array(
            '/href=\"(?<url>.+?searchnew.aspx+)\"/'
        ),
        'used'      => array(
            '/href=\"(?<url>.+?searchused.aspx+)\"/'
        )
    ),
    'scrapper'      => 'dealeron'
);

function dealeron_old_dealer_address($host, $data)
{
    $regexes = array(
        'address_line1' => '/<div id="home_adr">(?<address_line1>[^,]+),\s*(?<city>[^,]+),\s*(?<state>[^\s]+)\s*(?<post_code>[^<]+)/',
        'city'          => '/<div id="home_adr">(?<address_line1>[^,]+),\s*(?<city>[^,]+),\s*(?<state>[^\s]+)\s*(?<post_code>[^<]+)/',
        'state'         => '/<div id="home_adr">(?<address_line1>[^,]+),\s*(?<city>[^,]+),\s*(?<state>[^\s]+)\s*(?<post_code>[^<]+)/',
        'post_code'     => '/<div id="home_adr">(?<address_line1>[^,]+),\s*(?<city>[^,]+),\s*(?<state>[^\s]+)\s*(?<post_code>[^<]+)/',
        'lat'           => '/<meta name=geo.position content="(?<lat>[^,]+),(?<long>[^"]+)/',
        'long'          => '/<meta name=geo.position content="(?<lat>[^,]+),(?<long>[^"]+)/'
    );
    
    $phone_regex = '/<span class="dynamic-phone-number">(?<phone>[^<]+)/';
    
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
        $address['phones'][] = $match['phone'];
    }
    
    return $address;
}

?>
