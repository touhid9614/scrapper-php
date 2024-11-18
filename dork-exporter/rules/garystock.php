<?php

global $site_rules;

$site_rules['garystock'] = array(
    'match-rules'   => array(
        '/Developed By:\s*The Gary Stock Company/',
        '/href="\/inventory\/(?:new|used)\/"/'
    ),
    'entry_points'  => array(
        'new'       => array(
            '/href="(?<url>\/inventory\/new\/)"/'
        ),
        'used'      => array(
            '/href="(?<url>\/inventory\/used\/)"/'
        )
    ),
    'scrapper'      => 'garystock'
);

function garystock_dealer_address($host, $data)
{
    $regexes = array(
        'address_line1' => '/<span class="street-address">(?<address_line1>[^|<]+)(?(?=\|)\|\s(?<city>[^,]+),\s(?<state>[^,]+),\s(?<post_code>[^<]+)|<\/span>\s*<span class="city state postal">(?<city_2>[^,]+),\s(?<state_2>[^,]+),\s(?<post_code_2>[^<]+))/',
        'city'          => '/<span class="street-address">(?<address_line1>[^|<]+)(?(?=\|)\|\s(?<city>[^,]+),\s(?<state>[^,]+),\s(?<post_code>[^<]+)|<\/span>\s*<span class="city state postal">(?<city_2>[^,]+),\s(?<state_2>[^,]+),\s(?<post_code_2>[^<]+))/',
        'state'         => '/<span class="street-address">(?<address_line1>[^|<]+)(?(?=\|)\|\s(?<city>[^,]+),\s(?<state>[^,]+),\s(?<post_code>[^<]+)|<\/span>\s*<span class="city state postal">(?<city_2>[^,]+),\s(?<state_2>[^,]+),\s(?<post_code_2>[^<]+))/',
        'post_code'     => '/<span class="street-address">(?<address_line1>[^|<]+)(?(?=\|)\|\s(?<city>[^,]+),\s(?<state>[^,]+),\s(?<post_code>[^<]+)|<\/span>\s*<span class="city state postal">(?<city_2>[^,]+),\s(?<state_2>[^,]+),\s(?<post_code_2>[^<]+))/',
        'city_2'        => '/<span class="street-address">(?<address_line1>[^|<]+)(?(?=\|)\|\s(?<city>[^,]+),\s(?<state>[^,]+),\s(?<post_code>[^<]+)|<\/span>\s*<span class="city state postal">(?<city_2>[^,]+),\s(?<state_2>[^,]+),\s(?<post_code_2>[^<]+))/',
        'state_2'       => '/<span class="street-address">(?<address_line1>[^|<]+)(?(?=\|)\|\s(?<city>[^,]+),\s(?<state>[^,]+),\s(?<post_code>[^<]+)|<\/span>\s*<span class="city state postal">(?<city_2>[^,]+),\s(?<state_2>[^,]+),\s(?<post_code_2>[^<]+))/',
        'post_code_2'   => '/<span class="street-address">(?<address_line1>[^|<]+)(?(?=\|)\|\s(?<city>[^,]+),\s(?<state>[^,]+),\s(?<post_code>[^<]+)|<\/span>\s*<span class="city state postal">(?<city_2>[^,]+),\s(?<state_2>[^,]+),\s(?<post_code_2>[^<]+))/'
    );
    
    $phone_regex = '/<h4 class="white_text">(?<phone>Sales|Service|Parts) -\s*(?<number>[^<]+)/';
    
    $address = array();
    $match = null;
    
    foreach($regexes as $name => $regex)
    {
        if(preg_match($regex, $data, $match))
        {
            $address[$name] = $match[$name];
        }
    }
    
    if(isset($address['city_2']))
    {
        $address['city'] = $address['city_2'];
        unset($address['city_2']);
    }
    
    if(isset($address['state_2']))
    {
        $address['state'] = $address['state_2'];
        unset($address['state_2']);
    }
    
    if(isset($address['post_code_2']))
    {
        $address['post_code'] = $address['post_code_2'];
        unset($address['post_code_2']);
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
        $url = "http://$host/about_us/find_us.php";
        $data = load_url_data($url);
        
        $geo_regexes = array(
            'lat'           => '/var mapConfig = \{\s*latitude: \'(?<lat>[^\']+)\',\s*longitude: \'(?<long>[^\']+)\'/',
            'long'          => '/var mapConfig = \{\s*latitude: \'(?<lat>[^\']+)\',\s*longitude: \'(?<long>[^\']+)\'/'
        );
        
        foreach($geo_regexes as $name => $regex)
        {
            if(preg_match($regex, $data, $match))
            {
                $address[$name] = $match[$name];
            }
        }
    }
    
    return $address;
}

?>
