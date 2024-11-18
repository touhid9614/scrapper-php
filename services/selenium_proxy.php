<?php

$PROXY  = "149.215.113.110:70";
$PROXY2 = '127.0.0.1:2043';

/*webdriver.DesiredCapabilities.FIREFOX['proxy'] =
{
"httpProxy":PROXY,
"ftpProxy":PROXY,
"sslProxy":PROXY,
"noProxy":None,
"proxyType":"MANUAL",
"class":"org.openqa.selenium.Proxy",
"autodetect":False
}

# you have to use remote, otherwise you'll have to code it yourself in python to
$driver = webdriver.Remote("http://localhost:4444/wd/hub", webdriver.DesiredCapabilities.FIREFOX)*/

$capabilities = [
    WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::CHROME,
    WebDriverCapabilityType::PLATFORM     => WebDriverPlatform::ANY,
    WebDriverCapabilityType::PROXY        => [
        'proxyType'  => 'MANUAL',
        'httpProxy'  => $PROXY,
        'sslProxy'   => $PROXY,
        "ftpProxy"   => $PROXY,
        "noProxy"    => None,
        "autodetect" => false,
    ],
];

$driver = RemoteWebDriver::create($wd_host, $capabilities);
