<?php

/**
 * This document contains a generic scrapper which can scrap any given URL
 * provided that a valid scrapper configuration is present in the
 * scrapper-configs directory
 */

if (!function_exists('http_get')) {
	/**
	 * { function_description }
	 *
	 * @param      <type>  $url    The url
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function http_get($url)
	{
		return ScrapperHttpGet($url);
	}

	function ScrapperHttpGet($url, $proxy = false, $random_proxy = false)
	{
		$curl = curl_init();

		if ($proxy) {
			if ($random_proxy) {
				$p = getRandomProxy($proxy);
			} else {
				$p = getSequentialProxy($proxy);
			}

			$proxy_parts = explode(':', $p);
			$pwd         = $proxy_parts[2] . ':' . $proxy_parts[3];

			curl_setopt($curl, CURLOPT_PROXY, $proxy_parts[0] . ':' . $proxy_parts[1]);
			curl_setopt($curl, CURLOPT_PROXYUSERPWD, $pwd);
		}

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_URL, str_replace('~', '%7E', $url));
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en; rv:1.9.0.4) Gecko/2009011913 Firefox/3.0.6");

		$headers = [
			'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
			'accept-language: en-US,en;q=0.9,bn;q=0.8',
			'cookie: atOptUser=4031d6dd-adf8-4db2-a248-adb6f286801c; 383_MVT=Beta; visid_incap_820268=vr05vAsBTO6Sl9Za3I7C/qeGAV0AAAAAQUIPAAAAAACfXnN/pfTX0V5veQay6yCT; nlbi_820268_1623878=A6quUaXm8GjzSCNhf23nSQAAAADzakJ6tJECh1ULrtS2TrOy; incap_ses_390_820268=NIqFHTe34j0JtehOoo9pBaeGAV0AAAAAdMWI2C68JXJJ6maTY/tT3g==; _gcl_au=1.1.1220608631.1560381141; _ga=GA1.2.224743949.1560381142; _gid=GA1.2.432535763.1560381142; pCode=S4V 0A7; srchLocation=%7B%22Location%22:%7B%22Address%22:null,%22City%22:%22Regina%22,%22Latitude%22:50.426639556884766,%22Longitude%22:-104.56497955322266,%22Province%22:%22SK%22,%22PostalCode%22:%22S4V%200A7%22,%22Type%22:%22%22%7D,%22UnparsedAddress%22:%22s4v0a7%22%7D; {E7ABF06F-D6A6-4c25-9558-3932D3B8A04D}=; lastsrpurl=/cars/sk/?rcp=15&rcs=0&srt=3&prx=-2&prv=Saskatchewan&loc=s4v0a7&hprc=True&wcp=True&sts=New-Used&inMarket=advancedSearch; PageSize=15; SortOrder=PriceDesc; cto_lwid=8bac775d-3014-4774-b6aa-148ce246b4f8; AMCVS_2650037254CC132F0A4C98A6%40AdobeOrg=1; AMCV_2650037254CC132F0A4C98A6%40AdobeOrg=1099438348%7CMCIDTS%7C18060%7CMCMID%7C00465228858557492594479272682723177564%7CMCOPTOUT-1560388349s%7CNONE%7CvVersion%7C2.1.0; AAMC_traderca_0=REGION%7C6; aam_uuid=00624953844861509754490895510268204008; searchState={"isUniqueSearch":false,"make":null,"model":null}; _4c_=jVLJbtswEP2VgAedHJuUKFE0IBRFCrQB2lzSoMdgRI5sw4okkLSVNPC%2Fdyg7KbJ00YGa5c32Zh7ZuMaOLUVe8KwUKVd5Ws7YFh88Wz4yM8R3H5%2Bda9mSrUMY%2FHKxGMexnsMu9MGBRTc3sDDg%2FMJvFx%2BcGSqRJ874iifehSpLBndfnaf021fX4LcQzBpH6JK2N5WXew4qWQ%2FOVN%2FdDpOR4ifBB19d4Xh%2B49Emm%2B4buC2GCuweOoP2GsGZNZsx01uk1oSeqzknPfwkrYgSdtQ6G5wl%2BfPH28tPpKWpVDLTUs9PMwuZkntwvd2ZcBsehphsxPrM2y05Nv5rv1qhvSSW2BUZvoC%2F6LsAJsQe2hbdyVG7fvSTdrF2%2FR2eqZysPRHJfmw6S05SHTbo3IQizW9CrPaCyJOZVvDCcz55hjiQIIGYgzbG0vZi1qGFh9uNjQOCqE1mFWoJ0vISuGxMUQsphWgMqpgfvd%2F03QRvSmEzXgooAEtd27KRpdGpMRZUU2B%2BpO7mz9wdZuz%2BeECyULnMC61oB4GupSwkjx8hXKw1XRIzoARaDdwWBQCqpsxqmwooteAmb2LBY75S5ErIrOApJRjaU7x4LpfpPCe3lqdyNOFTuWH%2FBj01l73b3HFxf4nR7wxknuYJdKqve1ZcRkw4YRpoPb6BaIKYzrT%2FBN39Ju8%2FlvtOgpVrnlp5XlymBH8NFvxwOPwC',
			'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.80 Safari/537.36'
		];

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_AUTOREFERER, true);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 10);

		$contents       = curl_exec($curl);
		$httpcode       = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$header         = curl_getinfo($curl);

		$header_content = substr($contents, 0, $header['header_size']);
		$body_content   = trim(str_replace($header_content, '', $contents));
		$pattern        = '/Set-Cookie:\s+(?<cookie>(?<name>[^=]+)=(?<value>[^;]+))/';

		$in_cookies  = '';

		if (preg_match_all($pattern, $header_content, $matches)) {
			$out_cookies = cookie_combine($in_cookies, implode("; ", $matches['cookie']));
		} else {
			$out_cookies = $in_cookies;
		}

		if ($curl) {
			curl_close($curl);
		}

		if ($httpcode > 400) {
			return null;
		}

		if ($contents) {
			return $body_content;
		} else {
			return null;
		}
	}
}


/**
 * { function_description }
 *
 * @param      <type>  $url    The url
 *
 * @return     mixed  ( description_of_the_return_value )
 */
function scrap_url($url)
{
	global $special_configs;

	set_time_limit(0);

	$temp_sc = resolve_scrapper_config($url, $special_configs);
	$scrapper_config = apply_filters('scrapjack_config', $temp_sc, $url);

	if (!$scrapper_config) {
		return null;
	}

	$try_remaining = 3;

	while ($try_remaining > 0) {
		$raw_data = http_get($url);
		$try_remaining--;

		if ($raw_data) {
			file_put_contents("autotrader.html", $raw_data);
			exit;
			break;
		}
	}

	if (!$raw_data) {
		slecho('Unable to connect to Website');
		return null;
	}

	$data = apply_filters('filter_' . $scrapper_config['type'] . '_data', $raw_data);

	if (!$data) {
		return null;
	}

	$result = extract_data($scrapper_config['type'], $data, $scrapper_config, $url);

	return $result;
}


/**
 * Generates an object from an array
 * @param array $value that need to be objectified
 * @return object generated from the array
 */
function array_to_obj($value)
{
	$json = json_encode($value);

	return json_decode($json);
}


/**
 * { function_description }
 *
 * @param      string  $sub_section  The sub section
 * @param      string  $data         The data
 * @param      array  $config       The configuration
 *
 * @return     array   ( description_of_the_return_value )
 */
function pre_process($sub_section, $data, $config)
{
	if (!$data) {
		return $data;
	}

	if (isset($config['pre_process'])) {
		if (isset($config['pre_process']['start_tag'])) {
			if (stripos($data, $config['pre_process']['start_tag']) === false) {
				return null;
			}

			$data = substr($data, stripos($data, $config['pre_process']['start_tag']));
		}

		if (isset($config['pre_process']['end_tag'])) {
			if (stripos($data, $config['pre_process']['end_tag']) !== false) {
				$data = substr($data, 0, stripos($data, $config['pre_process']['end_tag']));
			}
		}

		if (isset($config['pre_process']['split_tag'])) {
			$data = explode($config['pre_process']['split_tag'], $data);

			if (isset($config['pre_process']['require'])) {
				foreach ($data as $index => $segment) {
					if (!preg_match($config['pre_process']['require'], $segment)) {
						unset($data[$index]);
					}
				}
			}
		}
	}

	if (is_array($data)) {
		$i = 0;
		$temp_data = array();

		foreach ($data as $index => $segment) {
			$segment = apply_filters('filter_' . $sub_section . '_processed_data', $segment);

			if ($segment != null) {
				$temp_data[$i] = $segment;
				$i++;
			}
		}

		$data = $temp_data;
	} else {
		$data = apply_filters('filter_' . $sub_section . '_processed_data', $data);
	}

	return $data;
}


/**
 * { function_description }
 *
 * @param      string  $sub_section  The sub section
 * @param      <type>  $data         The data
 * @param      <type>  $config       The configuration
 * @param      <type>  $url          The url
 *
 * @return     array   ( description_of_the_return_value )
 */
function extract_data($sub_section, $data, $config, $url)
{
	$p_data = pre_process($sub_section, $data, $config);

	$array_out = is_array($p_data);

	if (!is_array($p_data)) {
		$p_data = array($p_data);
	}

	$result = array();

	foreach ($p_data as $s_data) {
		$match = null;

		$single_result = array('_url' => $url);

		if (isset($config['fields'])) {
			foreach ($config['fields'] as $key => $regx) {
				if (preg_match($regx, $s_data, $match)) {
					$single_result[$key] = apply_filters('filter_field_' . $sub_section . '_' . $key, $match[$key]);
				}
			}
		}

		if (isset($config['fields_all'])) {
			foreach ($config['fields_all'] as $key => $regx) {
				if (preg_match_all($regx, $s_data, $match)) {
					$single_result[$key] = apply_filters('filter_field_' . $sub_section . '_' . $key, $match[$key]);
				}
			}
		}

		if (isset($config['sections'])) {
			foreach ($config['sections'] as $key => $section_config) {
				$res = extract_data($sub_section . '_' . $key, $data, $section_config, $url);
				$single_result[$key] = apply_filters('filter_field_' . $sub_section . '_' . $key, $res);
			}
		}

		if (isset($config['fields_cal'])) {
			foreach ($config['fields_cal'] as $key => $cmd) {
				$res = execute_cmd($cmd, $single_result);
				$single_result[$key] = apply_filters('filter_field_' . $sub_section . '_' . $key, $res);
			}
		}

		$result[] = array_to_obj($single_result);
	}

	return $array_out ? $result : $result[0];
}


/**
 * { function_description }
 *
 * @param      <type>  $cmd     The command
 * @param      <type>  $result  The result
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function execute_cmd($cmd, $result)
{
	if (!isset($cmd['func']) || !function_exists($cmd['func'])) {
		return null;
	}

	$args = isset($cmd['args']) ? $cmd['args'] : array();

	if (!is_array($args)) {
		$args = array($args);
	}

	$args_to_pass = array();

	foreach ($args as $arg_name) {
		$args_to_pass[] = isset($result[$arg_name]) ? $result[$arg_name] : null;
	}

	$combs = arg_combinations($args_to_pass);

	if (count($combs) == 0) {
		return null;
	}

	$response = array();

	foreach ($combs as $args_combination) {
		$response[] = call_user_func_array($cmd['func'], $args_combination);
	}

	return count($response) == 1 ? $response[0] : $response;
}


/**
 * { function_description }
 *
 * @param      <type>  $args   The arguments
 *
 * @return     array   ( description_of_the_return_value )
 */
function arg_combinations($args)
{
	$pointer = array();

	for ($i = 0, $args_len = count($args); $i < $args_len; $i++) {
		if (!is_array($args[$i])) {
			$args[$i] = array($args[$i]);
		}

		$pointer[$i] = count($args[$i]);
	}

	$result_count = array_product($pointer);
	$result = array();
	$segment_size = $result_count;

	for ($i = 0, $args_len = count($args); $i < $args_len; $i++) {
		$j = 0;

		while ($j < $result_count) {
			for ($round = 0; $round < $result_count / $segment_size; $round++) {
				for ($k = 0; $k < count($args[$i]); $k++) {
					while ($j < ($k + 1) * ($segment_size / count($args[$i])) + $round * $segment_size) {
						$result[$j][$i] = $args[$i][$k];
						$j++;
					}
				}
			}
		}

		$segment_size = $segment_size / count($args[$i]);
	}

	return $result;
}


/**
 * { function_description }
 *
 * @param      <type>  $url              The url
 * @param      <type>  $special_configs  The special configs
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function resolve_scrapper_config($url, $special_configs)
{
	foreach ($special_configs as $scrapper_config) {
		if (@preg_match($scrapper_config['url_identity'], $url)) {
			return $scrapper_config;
		}
	}
}
