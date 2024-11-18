<?php

/**
 * { function_description }
 *
 * @param      <type>  $strs      The strs
 * @param      <type>  $begining  The begining
 *
 * @return     array   ( description_of_the_return_value )
 */
function excludeBegining($strs, $begining)
{
    $retval = [];

    foreach ($strs as $str) {
        if (stripos($str, $begining) === 0) {
            $retval[] = substr($str, strlen($begining));
        } else {
            $retval[] = $str;
        }
    }

    return $retval;
}

/**
 * { function_description }
 *
 * @param      <type>  $urls      The urls
 * @param      <type>  $patterns  The patterns
 *
 * @return     array   ( description_of_the_return_value )
 */
function classifyURLs($urls, $patterns)
{
    $retval = [];

    foreach ($urls as $url) {
        $retval[$url] = 'other';

        foreach ($patterns as $type => $regex) {
            if (@preg_match($regex, $url)) {
                $retval[$url] = $type;
            }
        }
    }

    return $retval;
}

/**
 * Gets the sitemap.
 *
 * @param      <type>  $sitemap_url  The sitemap url
 *
 * @return     array   The sitemap.
 */
function getSitemap($sitemap_url)
{
    $data = HttpGet($sitemap_url);

    try
    {
        # Intentionally suppress warning, for non xml sitemaps
        $xml = @simplexml_load_string($data);

        if (!$xml) {
            if (endsWith($sitemap_url, '.xml.gz')) {
                $decoded_data = @simplexml_load_string(@gzdecode($data));

                if ($decoded_data->url) {
                    for ($i = 0, $urlLen = count($decoded_data->url); $i < $urlLen; $i++) {
                        $retval[] = strval($decoded_data->url[$i]->loc);
                    }

                    return $retval;
                }
            }

            //return ['not_xml' => $sitemap_url, 'xml' => $xml, 'data' => $data, 'decoded_data' => $decoded_data];
            return [];
        }

        $retval = [];

        if ($xml->sitemap) {
            for ($i = 0, $siteLen = count($xml->sitemap); $i < $siteLen; $i++) {
                $retval = array_merge($retval, getSitemap(trim(strval($xml->sitemap[$i]->loc))));
            }
        }

        if ($xml->url) {
            for ($i = 0, $urlLen = count($xml->url); $i < $urlLen; $i++) {
                $retval[] = strval($xml->url[$i]->loc);
            }
        }

        return $retval;
    } catch (Exception $ex) {
        //return ['Exception' => [$ex => $sitemap_url]];
        return [];
    }
}
