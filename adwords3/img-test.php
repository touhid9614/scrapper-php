<?php

function loadProxies($path)
{
    return file($path, FILE_IGNORE_NEW_LINES);
}

function getSequentialProxy($path)
{
    $proxies = loadProxies($path);
    $data_file = __DIR__ . '/data/sequence.dat';
    $index = 0;

    if (file_exists($data_file)) {
        $index = file_get_contents($data_file);
        $index++;
    }

    if ($index >= count($proxies)) {
        $index = 0;
    }

    file_put_contents($data_file, $index, LOCK_EX);

    return $proxies[$index];
}

function getRandomProxy($path)
{
    $proxies = loadProxies($path);
    $rand = rand(0, count($proxies) - 1);

    return $proxies[$rand];
}

function commonCurlInit($url, $proxy = false, $random_proxy = false)
{
    //WARNING: do not echo here, this is called from all the curl functions
    //including the ones generating images and swf banners, it could corrupt the buffer
    global $argv;
    sleep(1);
    $curl = curl_init();

    if ($proxy) {
        if ($random_proxy) {
            $p = getRandomProxy($proxy);
        } else {
            $p = getSequentialProxy($proxy);
        }
        
        $proxy_parts = explode(':', $p);
        $pwd = $proxy_parts[2] . ':' . $proxy_parts[3];
        
        if (array_key_exists('2', $argv)) {
            slecho('Using proxy: ' . $proxy_parts[0] . ':' . $proxy_parts[1]);
            slecho("Requesting url $url");
        }
        
        curl_setopt($curl, CURLOPT_PROXY, $proxy_parts[0] . ':' . $proxy_parts[1]);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $pwd);
    }
    
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_URL, str_replace('~', '%7E', $url));
    curl_setopt(
        $curl,
        CURLOPT_USERAGENT,
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:30.0) Gecko/20100101 Firefox/30.0'
    );

    return $curl;
}

function HttpGetImage($url, $proxy = false, $random_proxy = false)
{
    $url = str_replace(' ', '%20', $url);
    $cachefile = __DIR__ . '/imgcache/' . md5($url);
    clearstatcache(true, $cachefile);
    //2 minue cache time test...
    if (file_exists($cachefile)) {
        if (filemtime($cachefile) > time() - 120) {
            return file_get_contents($cachefile);
        }
    }
    $curl = commonCurlInit($url, $proxy, $random_proxy);
    curl_setopt($curl, CURLOPT_MUTE, false);
    curl_setopt($curl, CURLOPT_HEADER, 0);

    $contents = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);
    
    echo "$httpcode";
    echo "$contents";
    
    if ($httpcode>400) {
        return false;
    }

    if ($contents) {
        file_put_contents($cachefile, $contents);
        return $contents;
    } else {
        return false;
    }
}

$url = 'http://inventory-dmg.assets-new-cdk.com/4/5/6/13999751654.jpg';
$proxy      = __DIR__ . '/data/proxy-list.txt';
$imagedata  = HttpGetImage($url, $proxy, true);

echo $imagedata;