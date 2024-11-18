<?php

require_once __DIR__ . '/simple_html_dom.php';

/**
@git        : https://github.com/samaybhavsar/google-scraper/
@author     : Samay Bhavsar <samay@samay.info>
@Version    : 1.2
*/
class GoogleScraper
{
    var $keyword    = "";
    var $urlList    = [];
    var $time1      = 4000000;
    var $time2      = 8000000;
    var $proxy      = "";
    var $proxy_pwd  = "";
    var $cookie     = "";
    var $header     = "";
    var $ei         = "";

    const Success       = 1;
    const UnableToMatch = 2;
    const UnableToFetch = 3;
    const IPBlocked     = 4;

    function __construct() {
        $this->cookie = tempnam ("/tmp", "cookie");
        $this->headers[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $this->headers[] = "Connection: keep-alive";
        $this->headers[] = "Keep-Alive: 115";
        $this->headers[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $this->headers[] = "Accept-Language: en-us,en;q=0.5";
        $this->headers[] = "Pragma: ";
        echo "Cookie Jar: $this->cookie\n";
    }

    function getpagedata($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_COOKIEFILE,  $this->cookie);
        curl_setopt($ch, CURLOPT_COOKIEJAR,  $this->cookie);
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pwd);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $data=curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    function pause() {
        usleep(rand($this->time1,$this->time2));
    }

    function initGoogle() {
        $this->getpagedata('https://www.google.com');	//	Open google.com ( Might redirect to country specific site e.g. www.google.co.in)
        $this->pause();
        $this->getpagedata('https://www.google.com/ncr');	//	Moves back to google.com
    }


    // This function opens the preference page and saves the count for "Results per page" to 100
    function setPreference() {
        $matches = [];
        $data = $this->getpagedata('https://www.google.com/preferences?hl=en');
        
        $match_regexs = [
            '/<input type="hidden" name="sig" value="(.*?)">/',
            '/<input value="(.*?)" name="sig" type="hidden">/'
        ];
        
        foreach($match_regexs as $regex) {
            if(preg_match($regex, $data, $matches)) {
                break;
            }
        }
        
        if(empty($matches)) {
            file_put_contents("sigmatch.html",$data);
            echo "Couldn't match sig value\n";
        } else {
            echo "Sig value: {$matches[1]}\n";
        }
        
        $this->pause();
        $this->getpagedata('https://www.google.com/setprefs?sig='.urlencode($matches[1]).'&hl=en&lr=lang_en&safeui=images&suggon=2&newwindow=0&num=100&q=&prev=http%3A%2F%2Fwww.google.com%2F&submit2=Save+Preferences+');
    }
    
    /**
     * { function_description }
     *
     * @param      <type>   $data      The data
     * @param      integer  $page      The page
     * @param      boolean  $has_more  Indicates if more
     *
     * @return     array    ( description_of_the_return_value )
     */
    function processResult($data, $page, &$has_more)
    {
        $results = array();
        //die($data);
        $html = new simple_html_dom();
        $html->load($data);
        /** @var $interest simple_html_dom_node */
        $interest = $html->find('div#ires ol div.g');
        echo "Info: found interesting elements: " . count($interest) . "\n";
        
        if(count($interest) == 0) 
        {
            echo "Possible change in google website please fix.\n";
            file_put_contents("changed.html", $data);
            return [];
        } else {
            file_put_contents("worked.html", $data);
        }
        
        $interest_num = 0;

        foreach ($interest as $li)
        {
            $result = array('title'=>'undefined','host'=>'undefined','url'=>'undefined','type'=>'organic');
            $interest_num++;
            $h3 = $li->find('h3.r',0);

            if (!$h3)
            {
                continue;
            }

            $a = $h3->find('a',0);

            if (!$a) 
            {
                continue;
            }

            $result['title'] = html_entity_decode($a->plaintext);
            $lnk = urldecode($a->href);

            if ($lnk)
            {
                $m = null;
                preg_match('/(ht[^&]*)/', $lnk, $m);

                if ($m && $m[1])
                {
                    $result['url']=$m[1];
                    $tmp=parse_url($m[1]);
                    $result['host']=$tmp['host'];
                }
                else
                {
                    if (strstr($result['title'],'News')) 
                    {
                        $result['type']='news';
                    }

                    if (strstr($result['title'],'Images')) 
                    {
                        $result['type']='images';
                    }
                }
            }

            $h3->clear();
            $a->clear();
            $li->clear();
            $results[]=$result;
        }

        $html->clear();

        // Analyze if more results are available (next page)
        $next = 0;

        if (strstr($data, "Next</a>"))
        {
            $next = 1;
        } 
        else
        {
            $needstart = ($page + 1) * 10;
            $findstr = "start=$needstart";

            if (strstr($data, $findstr))
            {
                $next = 1;
            }
        }

        if ($next)
        {
            $has_more = true;
        }
        else
        {
            $has_more = false;
        }

        return $results;
    }

    function fetchUrlList()
    {
        $matches = [];
        for($i=0; $i <1001; $i = $i + 100) {
            $data=$this->getpagedata('https://www.google.com/search?q='.$this->keyword.'&num=100&hl=en&biw=1280&bih=612&prmd=ivns&ei='.$this->ei.'&start='.$i.'&sa=N&gl=ca');
            preg_match('/;ei=(.*?)&amp;/', $data, $matches);
            if(empty($matches))
            {
                preg_match('/;sei=(.*?)"/', $data, $matches);
                $this->ei=urlencode($matches[1]);

                if(empty($matches))
                {
                    file_put_contents("data.html",$data);
                    return self::UnableToMatch;
                }
            } else {
                $this->ei=urlencode($matches[1]);
            }

            if ($data) {
                if(preg_match("/sorry.google.com/", $data)) {
                    echo "You are blocked\n";
                    return self::IPBlocked;
                } else {
                    $has_more = false;
                    $urls = $this->processResult($data, 1, $has_more);
                    if(empty($urls) || !$has_more) { break; }
                    $this->urlList = array_merge($this->urlList, $urls);
                    //preg_match_all('@<h3\s*class="r">\s*<a[^<>]*href="[^<>]*?q=([^<>]*)&amp;sa[^<>]*>(.*)</a>\s*</h3>@siU', $data, $matches);
                    //for ($j = 0; $j < count($matches[1]); $j++) {
                    //    array_push($this->urlList, $matches[1][$j]);
                    //}
                }
            }
            else
            {
                echo "Problem fetching the data\n";
                return self::UnableToFetch;
            }
            $this->pause();
        }
        
        return self::Success;
    }

    function getUrlList($keyword, $proxy = '', $proxy_pwd = '') {
        $this->urlList = [];
        $this->keyword=$keyword;
        $this->proxy=$proxy;
        $this->proxy_pwd = $proxy_pwd;
        $this->initGoogle();
        $this->pause();
        $this->setPreference();
        $this->pause();
        $this->fetchUrlList();
        return $this->urlList;
    }
}
