<?php

global $special_configs;

$special_configs[] = array(
    'type'          => 'dealerlist',
    'url_identity'  => '/autotrader.ca\/dealer\/dealerfinder\/dealerfinder.aspx/',
    'sections'      => array(
        'dealerships'   => array(
            'pre_process'   => array(
                'start_tag'     => '<div class="df">',
                'end_tag'       => '<div class="pagerContainer">',
                'split_tag'     => '<div class="dfBox">'
            ),
            'fields'        => array(
                'company_name'      => '/<div class="dfCompanyName">(?<company_name>[^<]+)/',
                'address_line1'     => '/<div class="dfCompanyAddress">(?<address_line1>[^<]+)<br[^>]+>\s*(?<city>[^\(<]+)(?:\((?<state>[^\)]+)\))?<br[^>]+>\s*(?<zip>[^<]+)(?:<br[^>]+>\s*Phone: (?<phone>.+))?/',
                'city'              => '/<div class="dfCompanyAddress">(?<address_line1>[^<]+)<br[^>]+>\s*(?<city>[^\(<]+)(?:\((?<state>[^\)]+)\))?<br[^>]+>\s*(?<zip>[^<]+)(?:<br[^>]+>\s*Phone: (?<phone>.+))?/',
                'state'             => '/<div class="dfCompanyAddress">(?<address_line1>[^<]+)<br[^>]+>\s*(?<city>[^\(<]+)(?:\((?<state>[^\)]+)\))?<br[^>]+>\s*(?<zip>[^<]+)(?:<br[^>]+>\s*Phone: (?<phone>.+))?/',
                'zip'               => '/<div class="dfCompanyAddress">(?<address_line1>[^<]+)<br[^>]+>\s*(?<city>[^\(<]+)(?:\((?<state>[^\)]+)\))?<br[^>]+>\s*(?<zip>[^<]+)(?:<br[^>]+>\s*Phone: (?<phone>.+))?/',
                'phone'             => '/<div class="dfCompanyAddress">(?<address_line1>[^<]+)<br[^>]+>\s*(?<city>[^\(<]+)(?:\((?<state>[^\)]+)\))?<br[^>]+>\s*(?<zip>[^<]+)(?:<br[^>]+>\s*Phone: (?<phone>.+))?/',
                'dealer_website'    => '/href="(?<dealer_website>[^"]+)" target="_blank">Visit Dealer Website/',
                'dealer_inventory'  => '/href="(?<dealer_inventory>[^"]+)">View Dealer Inventory</'
            ),
            'fields_cal'    => array(
                /*'dealer_website' => array(
                    'func'  => 'get_redirected_host',
                    'args'  => array(
                        'dealer_website'
                    )
                ),*/
                'dealer_inventory'  => [
                    'func'  => 'strictURLCombine',
                    'args'  => [
                        '_url',
                        'dealer_inventory'
                    ]
                ],
                'inventory_count'   => [
                    'func'  => 'get_dealer_inventory_count',
                    'args'  => [
                        'dealer_inventory'
                    ]
                ]
            )
        )
    ),
    'fields'    => array(
        'next_page_url' => '/href="(?<next_page_url>[^"]+)">Next</'
    ),
    'fields_cal'    => array(
        'next_page_url' => array(
            'func'  => 'urlCombine',
            'args'  => array(
                '_url',
                'next_page_url'
            )
        )
    )
);

function strictURLCombine($base_url, $relative_url) {
    if($relative_url) {
        return urlCombine($base_url, $relative_url);
    }
    
    return null;
}

function get_dealer_inventory_count($url) {
    if(!$url) { return 0; }
    
    usleep(2000000 + rand(0, 5000000));
    
    $result = http_get($url);
    
    if($result) {
        
        $inventory_count_regex = '/<meta itemprop="itemcount" content="(?<inventory_count>[^"]+)/';
        $matches = [];
        if(preg_match($inventory_count_regex, $result, $matches)) {
            return $matches['inventory_count'];
        }
    }
    
    return 0;
}

function get_redirected_host($url)
{
    global $proxy_list;
    
    if(endsWith($url, '?ddcref=tm-df-link')) $url = str_replace ('?ddcref=tm-df-link', '', $url);
    
    $curl = curl_init();
    $p = getSequentialProxy($proxy_list);
    
    $proxy_parts = explode(':', $p);
    $pwd = $proxy_parts[2] . ':' . $proxy_parts[3];
    curl_setopt($curl, CURLOPT_PROXY, $proxy_parts[0] . ':' . $proxy_parts[1]);
    curl_setopt($curl, CURLOPT_PROXYUSERPWD, $pwd);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt(
        $curl,
        CURLOPT_USERAGENT,
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:30.0) Gecko/20100101 Firefox/30.0'
    );
    
    curl_exec($curl);
    $info = curl_getinfo($curl);
    curl_close($curl);
    
    $new_url = $info && isset($info['url'])?$info['url']:$url;
    
    return GetDomain($new_url);
}
