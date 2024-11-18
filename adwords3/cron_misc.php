<?php

use sMedia\AdSync\Utils;
use sMedia\Banner\BannerService;
use sMedia\Core\Registry;

global $bannerService;

$bannerService = null;

/**
 * Generates text ad description based on dealer specific configuration.
 * @param type $car             The car data array
 * @param type $cron_config     Config for the dealership
 * @param type $campaign        Campaign type search/display/color
 */
function getDescs($car, $cron_name, $cron_config, $campaign)
{
	$retval = [];
	$descs = apply_filters("filter_{$cron_name}_description", isset($cron_config["{$car['stock_type']}_descs"]) ? $cron_config["{$car['stock_type']}_descs"] : [], $car, $campaign);

	slecho("Description template count: " . count($descs));

	foreach ($descs as $desc) {
		$title2       = isset($desc['title2']) ? processTextTemplate($desc['title2'], $car, true) : null;
		$title3       = isset($desc['title3']) ? processTextTemplate($desc['title3'], $car, true) : 'View Prices, Deals and Offers';
		$desc1        = isset($desc['desc1']) ? processTextTemplate($desc['desc1'], $car, true) : null;
		$desc2        = isset($desc['desc2']) ? processTextTemplate($desc['desc2'], $car, true) : null;
		$old_desc     = isset($desc['desc']) ? processTextTemplate($desc['desc'], $car, true) : null;
		$description  = isset($desc['description']) ? processTextTemplate($desc['description'], $car, true) : $old_desc;
		$description2 = isset($desc['description2']) ? processTextTemplate($desc['description2'], $car, true) : 'See Inventory, Specs & Get a Quote. Call Today & Schedule A Test Drive!';

		if (!$description && ($desc1 && $desc2)) {
			$description = "$desc1 $desc2";
		}

		if ($description) {
			$retval[] = [
				'title2'       => $title2,
				'title3'       => $title3,
				'description'  => $description,
				'description2' => $description2,
			];
		} else {
			slecho("Description template was: " . json_encode($desc));
		}
	}

	slecho("Description count: " . count($retval));

	return $retval;
}

/**
 * Gets the keywords.
 *
 * @param      <type>  $car    The car
 *
 * @return     array   The keywords.
 */
function getKeywords($car)
{

	$keyword_templates = [
		'[year] [make] [model]',
		'[year] [model]',
		'[model] [make]',
		'[year] [make] [model] [trim]',
		'[make] [model] [trim]',
		'buy [year] [make] [model]',
		'[year] [make] [model] sale',
		'[year] [make] [model] for sale',
		'[year] [make] [model] msrp',
		'[year] [make] [model] price',
		'[year] [make] [model] cost',
	];

	if (!empty($car['msrp'])) {
		$keyword_templates[] = '[year] [make] [model] [msrp]';
	}

	if (!empty($car['price'])) {
		$keyword_templates[] = '[year] [make] [model] [price]';
	}

	$keywords = [];

	foreach ($keyword_templates as $template) {
		$keyword = str_replace("\n", '', processTextTemplate($template, $car, true));
		if ($keyword) {
			$keywords[] = $keyword;
		}
	}

	slecho("Debug keyword after before" . json_encode($keywords));
	return $keywords;
}

/**
 * Gets the text headline.
 *
 * @param      <type>  $car               The car
 * @param      <type>  $cron_config       The cron configuration
 * @param      string  $default_template  The default template
 * @param      bool    $check             The check
 * @param      <type>  $campaign_type     The campaign type
 *
 * @return     <type>  The text headline.
 */
function getTextHeadline($car, $cron_config, $default_template = "[year(2)] [make(1)] [model] [trim]", $check = true, $campaign_type = null)
{
	$template = $default_template;

	slecho("search config for headline 1 : " . json_encode([
		"title"                                       => $cron_config['title'],
		"{$car['stock_type']}_title"                  => $cron_config["{$car['stock_type']}_title"],
		"{$car['stock_type']}_{$campaign_type}_title" => $cron_config["{$car['stock_type']}_{$campaign_type}_title"],
	]));

	if (isset($cron_config['title'])) {
		slecho("getTextHeadline: title conf found " . $cron_config['title']);
		$template = $cron_config['title'];
	}

	if (isset($cron_config["{$car['stock_type']}_title"])) {
		slecho("getTextHeadline: stock_type_title conf found " . $cron_config["{$car['stock_type']}_title"]);
		$template = $cron_config["{$car['stock_type']}_title"];
	}

	if (!empty($campaign_type) && isset($cron_config["{$car['stock_type']}_{$campaign_type}_title"])) {
		slecho("getTextHeadline: stock_type_campaign_type_title conf found " . $cron_config["{$car['stock_type']}_{$campaign_type}_title"]);
		$template = $cron_config["{$car['stock_type']}_{$campaign_type}_title"];
	}

	$template_and_var_priorities = Utils::templateVarPriorities($template);

	foreach (['price', 'biweekly', 'msrp'] as $key) {
		if (isset($car[$key])) {
			$val = numarifyPrice($car[$key]);

			if ($val != -1) {
				$car[$key] = $val;
			}
		}
	}

	$headline = ucfirst(Utils::processTemplate(
		$template_and_var_priorities['template'],
		(array) $car,
		30,
		$template_and_var_priorities['priorities']
	));

	if (strlen($headline) > 30) {
		if (strlen($car['year'] . ' ' . $car['make'] . ' ' . $car['model']) <= 30) {
			$headline = $car['year'] . ' ' . $car['make'] . ' ' . $car['model'];
		} else if (strlen($car['make'] . " " . $car["model"]) <= 30) {
			$headline = $car['make'] . " " . $car["model"];
		} else {
			$headline = $car['year'] . " " . $car["make"];
			if ($check) {
				if (strlen($headline) > 25) {
					slecho("ERROR: Title '$headline' length exceeded for stock number \"" . $car['stock_number'] . "\"");
					return null;
				}
			}
		}
	}

	return str_replace("\n", '', $headline);
}

/**
 * Gets the text headline 2.
 *
 * @param      <type>  $car            The car
 * @param      <type>  $cron_config    The cron configuration
 * @param      <type>  $campaign_type  The campaign type
 *
 * @return     <type>  The text headline 2.
 */
function getTextHeadline2($car, $cron_config, $campaign_type = null)
{
	slecho("search config for headline 2 : " . json_encode([
		"title2"                                       => $cron_config['title2'],
		"{$car['stock_type']}_title2"                  => $cron_config["{$car['stock_type']}_title2"],
		"{$car['stock_type']}_{$campaign_type}_title2" => $cron_config["{$car['stock_type']}_{$campaign_type}_title2"],
	]));

	$headline_2_template =
		(!empty($campaign_type) && isset($cron_config["{$car['stock_type']}_{$campaign_type}_title2"]))
		? $cron_config["{$car['stock_type']}_{$campaign_type}_title2"]
		: (isset($cron_config["{$car['stock_type']}_title2"])
			? $cron_config["{$car['stock_type']}_title2"]
			: (isset($cron_config['title2'])
				? $cron_config['title2']
				: 'Book a Test Drive'));

	return processTextTemplate($headline_2_template, $car);
}

/**
 * Gets the text headline 3.
 *
 * @param      <type>  $car            The car
 * @param      <type>  $cron_config    The cron configuration
 * @param      <type>  $campaign_type  The campaign type
 *
 * @return     <type>  The text headline 3.
 */
function getTextHeadline3($car, $cron_config, $campaign_type = null)
{

	slecho("search config for headline 3 : " . json_encode([
		"title3"                                       => $cron_config['title3'],
		"{$car['stock_type']}_title3"                  => $cron_config["{$car['stock_type']}_title3"],
		"{$car['stock_type']}_{$campaign_type}_title3" => $cron_config["{$car['stock_type']}_{$campaign_type}_title3"],
	]));

	$headline_3_template =
		(!empty($campaign_type) && isset($cron_config["{$car['stock_type']}_{$campaign_type}_title3"]))
		? $cron_config["{$car['stock_type']}_{$campaign_type}_title3"]
		: (isset($cron_config["{$car['stock_type']}_title3"])
			? $cron_config["{$car['stock_type']}_title3"]
			: (isset($cron_config['title3'])
				? $cron_config['title3']
				: 'View Prices, Deals and Offers'));

	return processTextTemplate($headline_3_template, $car);
}

/**
 * Gets the text description 2.
 *
 * @param      <type>  $car          The car
 * @param      <type>  $cron_config  The cron configuration
 *
 * @return     <type>  The text description 2.
 */
function getTextDescription2($car, $cron_config)
{
	$description_2_template = isset($cron_config["{$car['stock_type']}_description2"]) ? $cron_config["{$car['stock_type']}_description2"] : (isset($cron_config['description3']) ? $cron_config['description3'] : 'See Inventory, Specs & Get a Quote. Call Today & Schedule A Test Drive!');
	return processTextTemplate($description_2_template, $car);
}

/**
 * Gets the negative keywords.
 *
 * @param      <type>  $car    The car
 *
 * @return     array   The negative keywords.
 */
function getNegativeKeywords($car)
{
	$negative_keywords = [];
	if ($car['stock_type'] == 'used') {
		$negative_keywords = array(
			'new',
			'2015',
			'tires',
			'parts-new',
			'accessories',
			'theft',
			'recalls',
			'tire pressure',
			'replacement',
			'belt',
			'muffler',
			'tire',
			'symbols',
			'helpline',
			'bolt',
			'pattern',
			'remote start',
			'picture',
			'background',
			'muffler',
			'parts-new',
			'oil',
			'kits',
			'breaks',
			'roaters',
			'transmission',
			'radiator',
			'spark plugs',
			'racing',
			'videos',
			'rims',
			'dealership',
			'remote starter',
			'wheels',
			'fuel',
			'Bumper',
			'Fender',
			'hood',
			'Spoiler',
			'grill',
			'Quarter panel',
			'Antenna',
			'radio',
			'Alternator',
			'battery',
			'Speedometer',
			'Spark plug',
			'Ignition coil',
			'sensor',
			'Alarm',
			'Seat belt',
			'brake',
			'running ',
			'boards',
			'side steps',
			'Air filter',
			'cap',
			'pump',
			'axel',
			'Clutch',
			'disk',
			'hose',
		);
	} elseif ($car['stock_type'] == 'new') {
		$negative_keywords = array(
			'2001',
			'2002',
			'2003',
			'2004',
			'2005',
			'2006',
			'2007',
			'2008',
			'2009',
			'2010',
			'2011',
			'2012',
			'2013',
			'parts-new',
			'tires',
			'used',
			'tires',
			'parts-new',
			'accessories',
			'theft',
			'recalls',
			'tire pressure',
			'replacement',
			'belt',
			'muffler',
			'tire',
			'symbols',
			'helpline',
			'bolt',
			'pattern',
			'remote start',
			'picture',
			'background',
			'muffler',
			'parts-new',
			'oil',
			'kits',
			'breaks',
			'roaters',
			'transmission',
			'radiator',
			'spark plugs',
			'racing',
			'videos',
			'rims',
			'dealership',
			'remote starter',
			'wheels',
			'fuel',
			'Bumper',
			'Fender',
			'hood',
			'Spoiler',
			'grill',
			'Quarter panel',
			'Antenna',
			'radio',
			'Alternator',
			'battery',
			'Speedometer',
			'Spark plug',
			'Ignition coil',
			'sensor',
			'Alarm',
			'Seat belt',
			'brake',
			'running ',
			'boards',
			'side steps',
			'Air filter',
			'cap',
			'pump',
			'axel',
			'Clutch',
			'disk',
			'hose',
		);
	}
	return $negative_keywords;
}

/**
 * Sets the keywords.
 *
 * @param      AdwordsService  $service    The service
 * @param      <type>          $cron_name  The cron name
 * @param      <type>          $car        The car
 * @param      <type>          $adGroupId  The ad group identifier
 * @param      string          $directive  The directive
 * @param      string          $matchType  The match type
 *
 * @return     int             ( description_of_the_return_value )
 */
function setKeywords(AdwordsService $service, $cron_name, $car, $adGroupId, $directive, $matchType = 'BROAD')
{
	$keywords = apply_filters('filter_keywords', getKeywords($car), $car, $directive);
	slecho("Debug keyword after filter" . json_encode($keywords));
	# $keywords = apply_filters("filter_keywords_{$cron_name}", $_keywords, $car, $directive);
	# Disable dealership wise keyword filtering

	$keyword_count = 0;
	$n             = 0;

	for ($i = 0; $i < count($keywords); $i++) {
		$keyword = $keywords[$i];
		$n       = $i + 1;

		slecho("Keyword $n is: $keyword");
		if ($service->SetKeywords($adGroupId, $keyword, $matchType)) {
			$keyword_count++;
		}
	}
	if ($directive == 'search') {
		/* Additional keyword for all*/
		$keyword_templates = [
			'PHRASE' => '"[year] [make] [model]"',
			'EXACT'  => '[[year] [make] [model]]',
		];

		foreach ($keyword_templates as $type => $template) {
			$keyword = str_replace("\n", '', processTextTemplate($template, $car, true));
			if ($keyword) {
				$n++;
				slecho("Keyword $n is: $keyword");
				if ($service->SetKeywords($adGroupId, $keyword, $type)) {
					$keyword_count++;
				}
			}
		}
	}

	//set negative keywords
	$negative_keywords = getNegativeKeywords($car);
	foreach ($negative_keywords as $negative_keyword) {
		slecho("Setting Negative Keyword: $negative_keyword");
		$service->SetNegativeKeywords($adGroupId, $negative_keyword);
	}

	return $keyword_count;
}

/**
 * Creates a text ad.
 *
 * @param      AdwordsService  $service        The service
 * @param      <type>          $cron_name      The cron name
 * @param      <type>          $cron_config    The cron configuration
 * @param      <type>          $car            The car
 * @param      <type>          $campaignId     The campaign identifier
 * @param      <type>          $campaign_name  The campaign name
 * @param      float           $default_bid    The default bid
 *
 * @return     int             ( description_of_the_return_value )
 */
function createTextAd(AdwordsService $service, $cron_name, $cron_config, $car, $campaignId, $campaign_name, $default_bid = 4.0)
{
	slecho('debuginim : createTextAd');
	$AdUrl = withTracker($cron_name, $cron_config, $car, 'search');

	if (!$AdUrl) {
		slecho('Info: skiping search add creation, commanded by smart ad handler');
		return 0;
	}

	$engine = $car['engine'];

	if (stripos($engine, ' ') > 0) {
		$engine = substr($engine, 0, stripos($engine, ' '));
	}

	if (endsWith($engine, ',')) {
		$engine = substr($engine, 0, strlen($engine) - 1);
	}

	$displayUrl    = GetDomain($car['url']);
	$headline      = getTextHeadline($car, $cron_config, "[year(2)] [make(1)] [model] [trim]", true, "search");
	$headline_2    = getTextHeadline2($car, $cron_config, "search");
	$headline_3    = getTextHeadline3($car, $cron_config, "search");
	$description_2 = getTextDescription2($car, $cron_config);

	if (!$headline) {
		// Can't create a suitable headline based on the template
		slecho('Error: Unable to create headline 1');
		return -1;
	}

	$is_new        = false; // If the adgroup is newly created (Not stock type)
	$ad_group_name = get_ad_group_name($car, $cron_config);
	$adGroupId     = get_ad_group_id($service, $campaign_name, $campaignId, $ad_group_name, $default_bid, $is_new);

	secho("TextAd AdGroupId is: $adGroupId<br/>");

	$ad_count = 0;

	// Keywords shall be set regardless of adgroup is newly created or already existed
	// Set Keywords and Negative Keywords
	if (!setKeywords($service, $cron_name, $car, $adGroupId, "search")) {
		$service->SetAdGroupStatus($adGroupId, false);
		slecho("Error: Unable to create any keyword, pausing adgroup. Please see the fault strings above.");
		return $ad_count;
	}

	secho("TextAd Headline is: {$headline}<br/>");

	$options = isset($car['options']) ? json_decode($car['options']) : false;

	if (is_array($options)) {
		for ($i = 0; $i < count($options); $i += 2) {
			if (isset($options[$i]) && isset($options[$i + 1])) {
				$description = 'Equipped with ' . $options[$i] . ' and ' . $options[$i + 1];
				// Create text ad
				$adId = $service->CreateAd($adGroupId, $AdUrl, $displayUrl, $headline, $headline_2, $headline_3, $description, $description_2);
				secho("TextAd Id is: " . $adId . "<br/><br/>");

				if ($adId) {
					$ad_count++;
				}
			}
		}
	} else {
		secho("Options tag is empty");
	}

	$descs = getDescs($car, $cron_name, $cron_config, 'search');

	foreach ($descs as $desc) {
		$title2       = $desc['title2'];
		$title3       = $desc['title3'];
		$description  = $desc['description'];
		$description2 = $desc['description2'];

		if (!$title2) {
			$title2 = $headline_2;
		}

		secho("\nfirst\nTitle2 is: $title2<br/>\nTitle3 is: $title3<br/>\nDesc is: $description<br/> \nDesc2 is: $description2<br/>");

		//Create text ad
		$adId = $service->CreateAd($adGroupId, $AdUrl, $displayUrl, $headline, $title2, $title3, $description, $description2);
		secho("TextAd Id is: " . $adId . "<br/><br/>");

		if ($adId) {
			$ad_count++;
		}
	}

	foreach ($car['auto_texts'] as $full_desc) {
		$spltd_desc = descSplit($full_desc);

		if (!$spltd_desc) {
			continue;
		}

		$description = $spltd_desc[0] . " " . $spltd_desc[1];

		slecho("\nautotext\nDesc is: $description");

		$AdUrl = withTracker($cron_name, $cron_config, $car, 'search');

		if (!$AdUrl) {
			slecho('Info: no add url present, skiping add creation');
			continue;
		}

		//Create text ad
		$adId = $service->CreateAd($adGroupId, $AdUrl, $displayUrl, $headline, $headline_2, $headline_3, $description, $description_2);
		secho("TextAd Id is: $adId<br/><br/>");

		if ($adId) {
			$ad_count++;
		}
	}

	if ($adGroupId) {
		if ($ad_count == 0) {
			secho("No TextAd created.<br/><br/>");
			$service->SetAdGroupStatus($adGroupId, false);
			secho("AdGroup is paused: " . $adGroupId . "<br/><br/>");
		}
	}

	return $ad_count;
}

/**
 * Creates a retargeting ad.
 *
 * @param      AdwordsService  $service        The service
 * @param      <type>          $cron_name      The cron name
 * @param      <type>          $cron_config    The cron configuration
 * @param      <type>          $car            The car
 * @param      <type>          $campaignId     The campaign identifier
 * @param      <type>          $campaign_name  The campaign name
 * @param      float           $default_bid    The default bid
 * @param      <type>          $userListId     The user list identifier
 *
 * @return     int             ( description_of_the_return_value )
 */
function createRetargetingAd(AdwordsService $service, $cron_name, $cron_config, $car, $campaignId, $campaign_name, $default_bid = 4.0, $userListId = null)
{
	slecho('debuginim : createSearchRemarketingAd');
	$AdUrl = withTracker($cron_name, $cron_config, $car, 'retargeting');

	if (!$AdUrl) {
		slecho('Info: skiping search retargeting add creation, commanded by smart ad handler');
		return 0;
	}

	$engine = $car['engine'];
	if (stripos($engine, ' ') > 0) {
		$engine = substr($engine, 0, stripos($engine, ' '));
	}
	if (endsWith($engine, ',')) {
		$engine = substr($engine, 0, strlen($engine) - 1);
	}

	$displayUrl = GetDomain($car['url']);

	$headline      = getTextHeadline($car, $cron_config);
	$headline_2    = getTextHeadline2($car, $cron_config);
	$headline_3    = getTextHeadline3($car, $cron_config);
	$description_2 = getTextDescription2($car, $cron_config);

	if (!$headline) {
		#Can't create a suitable headline based on the template
		return -1;
	}

	$is_new        = false;
	$ad_group_name = get_ad_group_name($car, $cron_config);
	$adGroupId     = get_ad_group_id($service, $campaign_name, $campaignId, $ad_group_name, $default_bid, $is_new);

	secho("Text Retargeting Ad AdGroupId is: $adGroupId<br/>");

	$ad_count = 0;

	# Set Keywords and Negative Keywords
	if (!setKeywords($service, $cron_name, $car, $adGroupId, "search")) {
		$service->SetAdGroupStatus($adGroupId, false);
		slecho("Error: Unable to create any keyword, pausing adgroup. Please see the fault strings above.");
		return $ad_count;
	}

	if ($userListId) {
		$service->EnableRetargeting($adGroupId, $userListId);
	}

	secho("Text Retargeting Ad Headline is: $headline<br/>");

	$options = isset($car['options']) ? json_decode($car['options']) : false;

	if (is_array($options)) {
		for ($i = 0; $i < count($options); $i += 2) {
			if (isset($options[$i]) && isset($options[$i + 1])) {
				$description = 'Equipped with ' . $options[$i] . ' and ' . $options[$i + 1];
				//Create text ad
				$adId = $service->CreateAd($adGroupId, $AdUrl, $displayUrl, $headline, $headline_2, $headline_3, $description, $description_2);
				secho("Text Retargeting Ad Id is: " . $adId . "<br/><br/>");

				if ($adId) {
					$ad_count++;
				}
			}
		}
	} else {
		secho("Options tag is empty");
	}

	$descs = getDescs($car, $cron_name, $cron_config, 'search');

	foreach ($descs as $desc) {
		$title2       = $desc['title2'];
		$title3       = $desc['title3'];
		$description  = $desc['description'];
		$description2 = $desc['description2'];

		if (!$title2) {
			$title2 = $headline_2;
		}

		secho("\nfirst\nTitle2 is: $title2<br/>\nDesc is: $description<br/>");

		//Create text ad
		$adId = $service->CreateAd($adGroupId, $AdUrl, $displayUrl, $headline, $title2, $title3, $description, $description2);
		secho("Text Retargeting Ad Id is: " . $adId . "<br/><br/>");

		if ($adId) {
			$ad_count++;
		}
	}

	foreach ($car['auto_texts'] as $full_desc) {
		$spltd_desc = descSplit($full_desc);

		if (!$spltd_desc) {
			continue;
		}

		$description = $spltd_desc[0] . " " . $spltd_desc[1];

		slecho("\nautotext\nDesc is: $description");

		$AdUrl = withTracker($cron_name, $cron_config, $car, 'search');

		if (!$AdUrl) {
			slecho('Info: no add url present, skiping add creation');
			continue;
		}

		//Create text ad
		$adId = $service->CreateAd($adGroupId, $AdUrl, $displayUrl, $headline, $headline_2, $headline_3, $description, $description_2);
		secho("Text Retargeting Ad Id is: $adId<br/><br/>");

		if ($adId) {
			$ad_count++;
		}
	}

	if ($adGroupId) {
		if ($ad_count == 0) {
			secho("No Text Retargeting Ad created.<br/><br/>");
			$service->SetAdGroupStatus($adGroupId, false);
			secho("AdGroup is paused: " . $adGroupId . "<br/><br/>");
		}
	}

	return $ad_count;
}

/**
 * Creates a color ad.
 *
 * @param      AdwordsService  $service        The service
 * @param      <type>          $cron_name      The cron name
 * @param      <type>          $cron_config    The cron configuration
 * @param      <type>          $car            The car
 * @param      <type>          $campaignId     The campaign identifier
 * @param      <type>          $campaign_name  The campaign name
 * @param      float           $default_bid    The default bid
 *
 * @return     int             ( description_of_the_return_value )
 */
function createColorAd(AdwordsService $service, $cron_name, $cron_config, $car, $campaignId, $campaign_name, $default_bid = 4.0)
{
	slecho('debuginim : createColorAd');
	$AdUrl = withTracker($cron_name, $cron_config, $car, 'color');

	if (!$AdUrl) {
		slecho('Info: skiping color ad creation, URL is not present');
		return 0;
	}

	if ((!isset($car['color'])) || (!$car['color'])) {
		slecho('Info: Color not present, skipping ad creation');
		return 0;
	}

	$engine = $car['engine'];
	if (stripos($engine, ' ') > 0) {
		$engine = substr($engine, 0, stripos($engine, ' '));
	}
	if (endsWith($engine, ',')) {
		$engine = substr($engine, 0, strlen($engine) - 1);
	}
	$car['engine'] = $engine;

	$displayUrl = GetDomain($car['url']);

	$headline      = getTextHeadline($car, $cron_config, "[year] [color] [model] [price]");
	$headline_2    = getTextHeadline2($car, $cron_config);
	$headline_3    = getTextHeadline3($car, $cron_config);
	$description_2 = getTextDescription2($car, $cron_config);

	if (!$headline) {
		return -1;
	}

	$is_new        = false;
	$ad_group_name = get_ad_group_name($car, $cron_config);
	$adGroupId     = get_ad_group_id($service, $campaign_name, $campaignId, $ad_group_name, $default_bid, $is_new);

	secho("ColorAd AdGroupId is: $adGroupId<br/>");

	$ad_count = 0;

	# Set Keywords and Negative Keywords
	if (!setKeywords($service, $cron_name, $car, $adGroupId, "color", 'EXACT')) {
		$service->SetAdGroupStatus($adGroupId, false);
		slecho("Error: Unable to create any keywords, pausing adgroup. Please see the fault strings above.");
		return $ad_count;
	}

	secho("ColorAd Headline is: $headline<br/>");

	//$descs = $car['stock_type'] == 'new' ? $cron_config['color']['new_descs'] : $cron_config['color']['used_descs'];

	$descs = array(
		array(
			"desc1" => "Test drive a [color]",
			"desc2" => "[model] of your dreams.",
		),
	);

	foreach ($descs as $desc) {
		$desc1 = processTextTemplate($desc['desc1'], $car, true);
		$desc2 = processTextTemplate($desc['desc2'], $car, true);

		if ($desc1 && $desc2) {
			$description = "$desc1 $desc2";

			$adId = $service->CreateAd($adGroupId, $AdUrl, $displayUrl, $headline, $headline_2, $headline_3, $description, $description_2);
			secho("ColorAd Id is: " . $adId . "<br/><br/>");

			if ($adId) {
				$ad_count++;
			}
		} else {
			slecho("Unable to process desc $desc1 and $desc2");
			continue;
		}
	}

	if ($adGroupId) {
		if ($ad_count == 0) {
			secho("No ColorAd created.<br/><br/>");
			$service->SetAdGroupStatus($adGroupId, false);
			secho("AdGroup is paused: " . $adGroupId . "<br/><br/>");
		}
	}

	return $ad_count;
}

/**
 * Creates a banner with text.
 *
 * @param      AdwordsService  $service        The service
 * @param      DbConnect       $db_connect     The database connect
 * @param      <type>          $cron_name      The cron name
 * @param      <type>          $cron_config    The cron configuration
 * @param      <type>          $car            The car
 * @param      <type>          $campaignId     The campaign identifier
 * @param      <type>          $campaign_name  The campaign name
 * @param      string          $directive      The directive
 * @param      <type>          $SWFConfigs     The swf configs
 * @param      <type>          $BannerConfigs  The banner configs
 * @param      <type>          $userListId     The user list identifier
 * @param      float           $default_bid    The default bid
 * @param      <type>          $userInterests  The user interests
 * @param      bool            $onlyText       The only text
 *
 * @return     int             ( description_of_the_return_value )
 */
function createBannerWithText(AdwordsService $service, DbConnect $db_connect, $cron_name, $cron_config, $car, $campaignId, $campaign_name, $directive, $SWFConfigs, $BannerConfigs, $userListId = null, $default_bid = 4.0, $userInterests = null, $onlyText = false)
{
	slecho('debuginim : createBannerWithText');
	$AdUrlDisplay = withTracker($cron_name, $cron_config, $car, $directive);

	if (!$AdUrlDisplay) {
		slecho('Info: skipping ' . $directive . ' ad creation as commanded by smart ad handler');

		return 0;
	}

	$price = $car['price'];

	$displayUrl = GetDomain($car['url']);
	if (!$displayUrl) {
		$displayUrl = GetDomain($car['regular_url']);
	}

	$flash_style  = isset($cron_config['banner']['flash_style']) ? $cron_config['banner']['flash_style'] : false;
	$create_flash = !!($flash_style);

	$headline = getTextHeadline($car, $cron_config);

	if (!$headline) {
		return -1;
	}

	$headline_2    = getTextHeadline2($car, $cron_config);
	$headline_3    = getTextHeadline3($car, $cron_config);
	$description_2 = getTextDescription2($car, $cron_config);

	$config_names = [];

	if (!$onlyText) {
		$config_names = [
			'120x600', '160x600', '200x200', '250x250', '300x250',
			'300x600', '320x50', '336x280', '468x60', '728x90', '970x90',
		];
	}

	$print_directive = prettyString($car['stock_type'] . ' ' . $directive);

	$tmp_directive = $directive;
	if ($directive == 'combined' || $directive == 'placement') {
		$tmp_directive = 'display';
	}

	$is_new        = false;
	$ad_group_name = get_ad_group_name($car, $cron_config);
	$adGroupId     = get_ad_group_id($service, $campaign_name, $campaignId, $ad_group_name, $default_bid, $is_new);

	slecho($print_directive . "Ad AdGroupId is: $adGroupId");

	#Set Keywords for display and combined campaigns
	if ($directive === 'display' || $directive === 'combined') {
		# Set Keywords and Negative Keywords
		if (!setKeywords($service, $cron_name, $car, $adGroupId, $directive)) {
			$service->SetAdGroupStatus($adGroupId, false);
			slecho("Error: Unable to create any keywords, pausing adgroup. Please see the fault strings above.");
			return 0;
		}
	}

	if ($directive === 'placement') {

		$placement_urls = get_placement_urls($db_connect, $cron_config, $car);

		/**
		 * Fall back to default placement
		 */
		if (count($placement_urls) == 0) {
			slecho("No placement for this car. Use Default Placement.");

			$placement_urls = get_default_placement_urls();

			if (count($placement_urls) > 0) {
				slecho("Default Placement found and using it.");
			}
		}

		/**
		 * No placement found, skip ads
		 */
		if (count($placement_urls) == 0) {
			slecho("No Placement Found.");
			$service->SetAdGroupStatus($adGroupId, false);
			slecho("AdGroup is paused: " . $adGroupId);
			return;
		}

		/**
		 * Try to set placements
		 */
		slecho("Numper of placement found: " . count($placement_urls));
		slecho("Setting placement for adGroup: " . $adGroupId);
		if (!$service->SetAdGroupPlacements($adGroupId, $placement_urls)) {
			slecho("Unable to set placement for this car. See the fault string above.");
			$service->SetAdGroupStatus($adGroupId, false);
			slecho("AdGroup is paused: " . $adGroupId);
			return;
		}
	}

	if ($directive === 'retargeting' && isset($car['droppedby'])) {
		$tmp_directive = 'pricedrop';
	}

	if ($is_new) {
		if ($userInterests != null) {
			foreach ($userInterests as $userInterestId) {
				$service->SetUserInterest($adGroupId, $userInterestId);
				slecho("Info: Including market buyers list with id $userInterestId");
			}
		}
	}

	//set retargeting
	if ($directive === 'retargeting') {
		$service->EnableRetargeting($adGroupId, $userListId);
	}

	$year      = $car['year'];
	$headline2 = processTextTemplate("[make] [model]", $car);
	if (isset($cron_config['display_title'])) {
		$headline2 = processTextTemplate($cron_config['display_title'], $car);
	}
	$template   = $cron_config['banner']['template'];
	$image_url1 = $car['images'][0];
	$image_url2 = $car['images'][1];

	$banner_count = 0;

	$custom_horizontals = getCustomFiles(
		$car['year'],
		$car['make'],
		$car['model'],
		isset($car['trim']) ? $car['trim'] : null,
		$car['stock_type'],
		$tmp_directive,
		$template,
		'horizontal'
	);

	$custom_verticals = getCustomFiles(
		$car['year'],
		$car['make'],
		$car['model'],
		isset($car['trim']) ? $car['trim'] : null,
		$car['stock_type'],
		$tmp_directive,
		$template,
		'vertical'
	);

	if (numarifyPrice($price) == 0) {
		$price = '';
	}

	$min_images = isset($cron_config['banner']['min_images']) ? $cron_config['banner']['min_images'] : 1;

	foreach ($config_names as $config) {

		if (count($car["images"]) < $min_images) {
			slecho("Skiping " . $print_directive . "Ad creation process. Not enough image.");
			break;
		}

		$skey        = $car['stock_type'] . '_' . $tmp_directive;
		$is_vertical = isset($BannerConfigs[$cron_config['banner']['styels'][$skey]][$config]['canvas']['parts-new']['vertical']);
		$is_horizontal = isset($BannerConfigs[$cron_config['banner']['styels'][$skey]][$config]['canvas']['parts-new']['horizontal']);
		$flash_is_vertical = isset($BannerConfigs['quick_banner'][$config]['canvas']['parts-new']['vertical']);
		$flash_is_horizontal = isset($BannerConfigs['quick_banner'][$config]['canvas']['parts-new']['horizontal']);

		$can_create_flash = $create_flash && count($car['images']) > 4;

		$additional_queries = get_banner_query($car, $cron_config, $config, $tmp_directive);

		foreach ($additional_queries as $additional_query) {
			$banner_count += createImageAd(
				$service,
				$adGroupId,
				$AdUrlDisplay,
				$displayUrl,
				$print_directive,
				$car,
				$config,
				$template,
				$year,
				$headline2,
				$price,
				$image_url1,
				$image_url2,
				$cron_config,
				$tmp_directive,
				null,
				null,
				$additional_query
			);
		}

		//create custom
		if ($is_horizontal) {
			foreach ($custom_horizontals as $custom_horizontal) {
				$banner_count += createImageAd(
					$service,
					$adGroupId,
					$AdUrlDisplay,
					$displayUrl,
					$print_directive,
					$car,
					$config,
					$template,
					$year,
					$headline2,
					$price,
					$image_url1,
					$image_url2,
					$cron_config,
					$tmp_directive,
					$custom_horizontal,
					null
				);
			}
		}

		if ($is_vertical) {
			foreach ($custom_verticals as $custom_vertical) {
				$banner_count += createImageAd(
					$service,
					$adGroupId,
					$AdUrlDisplay,
					$displayUrl,
					$print_directive,
					$car,
					$config,
					$template,
					$year,
					$headline2,
					$price,
					$image_url1,
					$image_url2,
					$cron_config,
					$tmp_directive,
					null,
					$custom_vertical
				);
			}
		}

		if (isset($cron_config['weekly']) && $cron_config['weekly']) {
			if (($directive === 'display'
					|| $directive === 'marketbuyers'
					|| $directive === 'combined'
					|| $directive === 'retargeting')
				&& isset($car['weekly'])
			) {

				$weekly_price = $car['weekly'];
				if (numarifyPrice($weekly_price) > 0) {
					$weekly_price = $weekly_price . '* /weekly';
					foreach ($additional_queries as $additional_query) {
						$banner_count += createImageAd(
							$service,
							$adGroupId,
							$AdUrlDisplay,
							$displayUrl,
							$print_directive,
							$car,
							$config,
							$template,
							$year,
							$headline2,
							$weekly_price,
							$image_url1,
							$image_url2,
							$cron_config,
							$tmp_directive,
							null,
							null,
							$additional_query
						);
					}
					//create custom
					if ($is_horizontal) {
						foreach ($custom_horizontals as $custom_horizontal) {
							$banner_count += createImageAd(
								$service,
								$adGroupId,
								$AdUrlDisplay,
								$displayUrl,
								$print_directive,
								$car,
								$config,
								$template,
								$year,
								$headline2,
								$weekly_price,
								$image_url1,
								$image_url2,
								$cron_config,
								$tmp_directive,
								$custom_horizontal,
								null
							);
						}
					}

					if ($is_vertical) {
						foreach ($custom_verticals as $custom_vertical) {
							$banner_count += createImageAd(
								$service,
								$adGroupId,
								$AdUrlDisplay,
								$displayUrl,
								$print_directive,
								$car,
								$config,
								$template,
								$year,
								$headline2,
								$weekly_price,
								$image_url1,
								$image_url2,
								$cron_config,
								$tmp_directive,
								null,
								$custom_vertical
							);
						}
					}
				}
			}
		}

		if (isset($cron_config['biweekly']) && $cron_config['biweekly']) {
			if (($directive === 'display'
					|| $directive === 'marketbuyers'
					|| $directive === 'combined'
					|| $directive === 'retargeting')
				&& isset($car['biweekly'])
			) {

				$biweekly_price = $car['biweekly'];
				if (numarifyPrice($biweekly_price) > 0) {
					$biweekly_price = $biweekly_price . '* b/w';
					foreach ($additional_queries as $additional_query) {
						$banner_count += createImageAd(
							$service,
							$adGroupId,
							$AdUrlDisplay,
							$displayUrl,
							$print_directive,
							$car,
							$config,
							$template,
							$year,
							$headline2,
							$biweekly_price,
							$image_url1,
							$image_url2,
							$cron_config,
							$tmp_directive,
							null,
							null,
							$additional_query
						);
					}
					//create custom
					if ($is_horizontal) {
						foreach ($custom_horizontals as $custom_horizontal) {
							$banner_count += createImageAd(
								$service,
								$adGroupId,
								$AdUrlDisplay,
								$displayUrl,
								$print_directive,
								$car,
								$config,
								$template,
								$year,
								$headline2,
								$biweekly_price,
								$image_url1,
								$image_url2,
								$cron_config,
								$tmp_directive,
								$custom_horizontal,
								null
							);
						}
					}

					if ($is_vertical) {
						foreach ($custom_verticals as $custom_vertical) {
							$banner_count += createImageAd(
								$service,
								$adGroupId,
								$AdUrlDisplay,
								$displayUrl,
								$print_directive,
								$car,
								$config,
								$template,
								$year,
								$headline2,
								$biweekly_price,
								$image_url1,
								$image_url2,
								$cron_config,
								$tmp_directive,
								null,
								$custom_vertical
							);
						}
					}
				}
			}
		}
	}

	$descs = getDescs($car, $cron_name, $cron_config, 'display');

	foreach ($descs as $desc) {
		$title2       = $desc['title2'];
		$title3       = $desc['title3'];
		$description  = $desc['description'];
		$description2 = $desc['description2'];

		if (!$title2) {
			$title2 = $headline_2;
		}

		secho("\nfirst\nTitle2 is: $title2<br/>\nDesc is: $description<br/>");

		$adId = $service->CreateAd($adGroupId, $AdUrlDisplay, $displayUrl, $headline, $title2, $title3, $description, $description2);
		secho("TextAd in $print_directive Id is: $adId<br/><br/>");

		if ($adId) {
			$banner_count++;
		}
	}

	foreach ($car['auto_texts'] as $full_desc) {
		$spltd_desc = descSplit($full_desc);

		if (!$spltd_desc) {
			continue;
		}

		//$desc1 = prettyString($spltd_desc[0]);
		//$desc2 = prettyString($spltd_desc[1]);
		$description = $spltd_desc[0] . " " . $spltd_desc[1];

		slecho("\nautotext\nDesc1 is: $description");
		/*
         * This check is not necessary any more
         * ----------------------------------------------
        if (strlen($desc1) > 35 || strlen($desc2) > 35) {
        secho(
        "Descs does not qualify: desc1 length "
        . strlen($desc1) . "desc2 length "
        . strlen($desc2) . "<br/><br/>"
        );
        continue;
        }
         */
		//Create text ad
		if (!$AdUrlDisplay = withTracker($cron_name, $cron_config, $car, $directive)) {
			continue;
		}

		$adId = $service->CreateAd($adGroupId, $AdUrlDisplay, $displayUrl, $headline, $headline_2, $headline_3, $description, $description_2);
		secho("TextAd in $print_directive Id is: $adId<br/><br/>");

		if ($adId) {
			$banner_count++;
		}
	}

	secho('<br/>');

	if ($banner_count == 0) {
		secho("No ImageAd created.<br/><br/>");
		$service->SetAdGroupStatus($adGroupId, false);
		secho("AdGroup is paused: " . $adGroupId . "<br/><br/>");
	}
}

/*******************************************************************************
 * Actual advertisement creation code
 *******************************************************************************/

/**
 * Creates an image ad.
 *
 * @param      AdwordsService  $service            The service
 * @param      <type>          $adGroupId          The ad group identifier
 * @param      <type>          $AdUrlDisplay       The ad url display
 * @param      <type>          $displayUrl         The display url
 * @param      string          $print_directive    The print directive
 * @param      <type>          $car                The car
 * @param      <type>          $config             The configuration
 * @param      <type>          $template           The template
 * @param      <type>          $year               The year
 * @param      <type>          $headline2          The headline 2
 * @param      <type>          $price              The price
 * @param      <type>          $image_url1         The image url 1
 * @param      <type>          $image_url2         The image url 2
 * @param      <type>          $cron_config        The cron configuration
 * @param      <type>          $tmp_directive      The temporary directive
 * @param      <type>          $custom_horizontal  The custom horizontal
 * @param      <type>          $custom_vertical    The custom vertical
 * @param      <type>          $additional_query   The additional query
 *
 * @return     int             ( description_of_the_return_value )
 */
function createImageAd(AdwordsService $service, $adGroupId, $AdUrlDisplay, $displayUrl, $print_directive, $car, $config, $template, $year, $headline2, $price, $image_url1, $image_url2, $cron_config, $tmp_directive, $custom_horizontal = null, $custom_vertical = null, $additional_query = null)
{
	slecho('debuginim : createImageAd');
	if (!trim($image_url1 . $image_url2)) {
		slecho('Error - createImageAd called with no image urls');

		return 0;
	}

	slecho("Generating banner for $config");

	$image_data = getBanner(
		$car,
		$config,
		$template,
		$year,
		$headline2,
		$price,
		$image_url1,
		$image_url2,
		$cron_config,
		$tmp_directive,
		$custom_horizontal,
		$custom_vertical,
		$additional_query
	);

	if (!$image_data) {
		slecho("Unable to create banner ad $config");
		return 0;
	}

	slecho("Banner generated for $config");

	$image  = imagecreatefromstring($image_data);
	$width  = imagesx($image);
	$height = imagesy($image);
	imagedestroy($image);

	slecho("Generated Image width $width and height $height");

	$url = urlCombine($AdUrlDisplay, "?utm_content={$config}static");

	slecho("Creating image ad");

	$adId = $service->CreateImageAd(
		$adGroupId,
		$url,
		$displayUrl,
		$headline2,
		$image_data,
		$width,
		$height
	);

	if (!$adId) {
		slecho($print_directive . "Ad ($config) could not be created");

		return 0;
	}

	$extra_data = '';
	if ($custom_horizontal) {
		$extra_data = ". horizontal file $custom_horizontal";
	}
	if ($custom_vertical) {
		$extra_data = ". vertical file $custom_vertical";
	}
	if ($additional_query) {
		$extra_data = ". additional query $additional_query";
	}

	slecho($print_directive . "Ad ($config) Id is: $adId$extra_data");

	return 1;
}

/**
 * Maps template path
 *
 * @param      <type>   $dirs           The dirs
 * @param      <type>   $file           The file
 * @param      string $template_name The template name
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function map_template_path($dirs, $file, $template_name)
{
	global $bannerService;

	if (!$bannerService) {
		$bannerService = new BannerService(
			Registry::get('banner_s3'),
			Registry::get('cache_dir'),
			Registry::get('template_bucket'),
			Registry::get('banner_redis'),
			Registry::get('banner_prefix'),
			Registry::get('template_prefix')
		);
	}

	return $bannerService->template_service->mapTemplatePath($template_name, $dirs, $file);
}

/**
 * Gets the banner.
 *
 * @param      <type>              $car                The car
 * @param      <type>              $config             The configuration
 * @param      string              $template           The template
 * @param      <type>              $year               The year
 * @param      <type>              $headline2          The headline 2
 * @param      <type>              $price              The price
 * @param      <type>              $image_url1         The image url 1
 * @param      <type>              $image_url2         The image url 2
 * @param      <type>              $cron_config        The cron configuration
 * @param      <type>              $directive          The directive
 * @param      <type>              $custom_horizontal  The custom horizontal
 * @param      <type>              $custom_vertical    The custom vertical
 * @param      <type>              $additional_query   The additional query
 *
 * @return     BannerService|bool  The banner.
 */
function getBanner($car, $config, $template, $year, $headline2, $price, $image_url1, $image_url2, $cron_config, $directive, $custom_horizontal = null, $custom_vertical = null, $additional_query = null)
{
	global $BannerConfigs, $bannerService;

	if (!$bannerService) {
		$bannerService = new BannerService(
			Registry::get('banner_s3'),
			Registry::get('cache_dir'),
			Registry::get('template_bucket'),
			Registry::get('banner_redis'),
			Registry::get('banner_prefix'),
			Registry::get('template_prefix')
		);
	}

	$key  = $car['stock_type'] . '_' . $directive;
	$type = $car['stock_type'] . $directive;

	$certified_dir = __DIR__ . '/templates/' . $template . '/' . 'certified-' . $type . '/';
	if ($car['certified'] && is_dir($certified_dir)) {
		$type = 'certified-' . $type;
	}

	if (!array_key_exists($mystyle = @$cron_config['banner']['styels'][$key], $BannerConfigs)) {
		slecho("IMGDEBUG BANNERDEBUG requested invalid banner style $mystyle");
		return false;
	}
	if (!array_key_exists($config, $BannerConfigs[$cron_config['banner']['styels'][$key]])) {
		slecho("IMGDEBUG BANNERDEBUG requested invalid banner resolution $config for style $mystyle");
		return false;
	}
	$hst    = isset($cron_config['banner']['hst']) ? $cron_config['banner']['hst'] : false;
	$hst_l1 = isset($cron_config['banner']['hst_l1']) ? $cron_config['banner']['hst_l1'] : false;
	$hst_l2 = isset($cron_config['banner']['hst_l2']) ? $cron_config['banner']['hst_l2'] : false;
	if ($hst) {
		$price = $car['banner_price'];
	}

	$image_url3 = count($car['images']) > 2 ? $car['images'][2] : $image_url1;
	$image_url4 = count($car['images']) > 3 ? $car['images'][3] : $image_url1;

	$banner_params                      = $car;
	$banner_params['template']          = $template;
	$banner_params['style']             = apply_filters("filter_style_$template", isset($cron_config['banner']['styels'][$key]) ? $cron_config['banner']['styels'][$key] : '', $car, $key);
	$banner_params['config']            = $config;
	$banner_params['title']             = $headline2;
	$banner_params['lang']              = defined('adlang') ? adlang : 'en';
	$banner_params['img1']              = $image_url1;
	$banner_params['img2']              = $image_url2;
	$banner_params['img3']              = $image_url3;
	$banner_params['img4']              = $image_url4;
	$banner_params['old_price']         = isset($car['old_price']) ? $car['old_price'] : '';
	$banner_params['droppedby']         = isset($car['droppedby']) ? $car['droppedby'] : '';
	$banner_params['title_color']       = isset($cron_config['banner']['font_color']) ? $cron_config['banner']['font_color'] : '';
	$banner_params['hst_l1']            = $hst_l1;
	$banner_params['hst_l2']            = $hst_l2;
	$banner_params['hst']               = $hst ? 'true' : '';
	$banner_params['price']             = $price;
	$banner_params['type']              = $type;
	$banner_params['year']              = $year;
	$banner_params['show_was_is_price'] = 1;

	if (isset($cron_config['banner']['marketting_lines'])) {
		$marketting_lines = $cron_config['banner']['marketting_lines']($car);
		$banner_params    = array_merge($banner_params, $marketting_lines);
	}

	if ($custom_horizontal) {
		$banner_params['horizontal'] = $custom_horizontal;
	}
	if ($custom_vertical) {
		$banner_params['vertical'] = $custom_vertical;
	}

	if ($additional_query) {
		$params = [];
		parse_str($additional_query, $params);
		$banner_params = array_merge($banner_params, $params);
	}

	slecho("Requesting banner with parameters " . json_encode($banner_params));

	if (isset($cron_config['banner']['params'])) {
		$banner_params = array_merge($banner_params, $cron_config['banner']['params']);
	}

	if (isset($cron_config['proxy-area'])) {
		$banner_params['proxy-area'] = $cron_config['proxy-area'];
	}

	$image_data = $bannerService->generateFromDescription($template, $banner_params);

	slecho("Banner generated");

	if (!$image_data) {
		secho("Error: Unable to create banner." . serialize($banner_params));
		return false;
	}

	return $image_data;
}

/**
 * { function_description }
 *
 * @param      <type>  $cron_name    The cron name
 * @param      <type>  $cron_config  The cron configuration
 * @param      <type>  $car          The car
 * @param      string  $directive    The directive
 *
 * @return     bool    ( description_of_the_return_value )
 */
function withTracker($cron_name, $cron_config, $car, $directive)
{
	slecho('debuginim : withTracker');
	$temp_url = str_replace('>', '', str_replace('&amp;', '&', $car["url"]));
	$color_ad_url = isset($cron_config['color_ad_url']) ? $cron_config['color_ad_url'] : false;

	if ($directive == 'color' && $color_ad_url) {
		$temp_url = str_replace(
			array('[year]', '[make]', '[model]', '[color]'),
			array($car['year'], $car['make'], $car['model'], $car['color']),
			$color_ad_url
		);
	}

	if ($directive == 'retargeting' && isset($car['regular_url'])) {
		$temp_url = $car['regular_url'];
	}

	$url = str_replace(' ', '%20', $temp_url);

	if (empty($url)) {
		return false;
	}

	$fragment = '';

	if (stripos($url, '#', 0) !== false) {
		$fragment = substr($url, stripos($url, '#', 0));
		$url      = substr($url, 0, stripos($url, '#', 0));
	}

	$key          = $car['stock_type'] . '_' . $directive;
	$directivekey = $car['stock_type'] . $directive;
	$banner_ext   = 'utm_template=' . $cron_config['banner']['template'] . '&utm_cron=' . $cron_name;

	if (isset($cron_config['trackers']) && isset($cron_config['trackers'][$key])) {
		if (stripos($url, '?', 0) !== false) {
			$url .= '&' . $banner_ext;
		} else {
			$url .= '?' . $banner_ext;
		}

		$url .= '&' . $cron_config['trackers'][$key];
	}

	// utm_source is removed according to Regan's request on 31/01/2019
	// https://app.asana.com/0/71555384446080/1156543055715609
	// utm_source and directive is reformated according to anand sings request on 10/01/2020
	// Anand Singh: ?utm_directive=usedretargeting&utm_medium=sMedia#usedretargeting should be change to ?utm_directive=sMedia_usedretargeting&utm_medium=cpc&utm_source=google
	if (stripos($url, '?', 0) !== false) {
		$url .= "&utm_directive=sMedia_{$directivekey}&utm_medium=cpc&utm_source=google";
	} else {
		$url .= "?utm_directive=sMedia_{$directivekey}&utm_medium=cpc&utm_source=google";
	}

	if ($fragment) {
		$url .= $fragment;
	}

	return $url;
}

/**
 * Calculates the top car.
 *
 * @param      <type>  $car_performance  The car performance
 *
 * @return     array   The top car.
 */
function calculateTopCar($car_performance)
{
	$temp_new  = [];
	$temp_used = [];

	$extraction_pattern = '/^(?<year>(:?19|20)[0-9]{2}) (?<make>[^ ]+) (?<model>[^ ]+) - (?<stock_type>[^ ]+)/';

	foreach ($car_performance as $car) {
		$adgroup_name = $car['Ad group'];
		$impressions  = $car['Impressions'];

		$match = [];

		if (!preg_match($extraction_pattern, $adgroup_name, $match)) {
			continue;
		}

		$stock_type = $match['stock_type'];
		$make       = $match['make'];
		$model      = $match['model'];
		$year       = $match['year'];

		$stock_key = $make . '_' . $model . '_' . $year;

		if ($stock_type == 'new') {
			if (!isset($temp_new[$stock_key])) {
				$temp_new[$stock_key] = new PerformanceAdGroup($make, $model, $year, $impressions);
			} else {
				$temp_new[$stock_key]->impressions = $temp_new[$stock_key]->impressions + $impressions;
			}
		} else {
			if (!isset($temp_used[$stock_key])) {
				$temp_used[$stock_key] = new PerformanceAdGroup($make, $model, $year, $impressions);
			} else {
				$temp_used[$stock_key]->impressions = $temp_used[$stock_key]->impressions + $impressions;
			}
		}
	}

	$temp_new_keyless  = [];
	$temp_used_keyless = [];

	foreach ($temp_new as $value) {
		$i                    = count($temp_new_keyless);
		$temp_new_keyless[$i] = $value;
	}

	foreach ($temp_used as $value) {
		$i                     = count($temp_used_keyless);
		$temp_used_keyless[$i] = $value;
	}

	$temp_new_keyless_sorted  = sortByProperty($temp_new_keyless, 'impressions');
	$temp_used_keyless_sorted = sortByProperty($temp_used_keyless, 'impressions');

	$to_return =
		[
			'new'  => [],
			'used' => [],
		];

	for ($i = 0; $i < 5; $i++) {
		$new_index  = (count($temp_new_keyless_sorted) - 1) - $i;
		$used_index = (count($temp_used_keyless_sorted) - 1) - $i;

		if ($new_index >= 0) {
			$to_return['new'][count($to_return['new'])] =
				[
					'year'        => $temp_new_keyless_sorted[$new_index]->year,
					'make'        => $temp_new_keyless_sorted[$new_index]->make,
					'model'       => $temp_new_keyless_sorted[$new_index]->model,
					'impressions' => $temp_new_keyless_sorted[$new_index]->impressions,
				];
		}

		if ($used_index >= 0) {
			$to_return['used'][count($to_return['used'])] =
				[
					'year'        => $temp_used_keyless_sorted[$used_index]->year,
					'make'        => $temp_used_keyless_sorted[$used_index]->make,
					'model'       => $temp_used_keyless_sorted[$used_index]->model,
					'impressions' => $temp_used_keyless_sorted[$used_index]->impressions,
				];
		}
	}

	return $to_return;
}

/**
 * Gets the custom files.
 *
 * @param      string  $year        The year
 * @param      <type>  $make        The make
 * @param      <type>  $model       The model
 * @param      <type>  $trim        The trim
 * @param      <type>  $stock_type  The stock type
 * @param      <type>  $directive   The directive
 * @param      string  $template    The template
 * @param      string  $vh          { parameter_description }
 *
 * @return     array   The custom files.
 */
function getCustomFiles($year, $make, $model, $trim, $stock_type, $directive, $template, $vh)
{
	$dir = __DIR__ . '/templates/' . $template . '/' . $stock_type . $directive;

	$to_return = [];

	$l_make  = strtolower(str_replace(' ', '-', $make));
	$l_model = strtolower(str_replace(' ', '-', $model));

	if ($trim) {
		$l_trim = strtolower(str_replace('/', '\/', str_replace(' ', '-', $trim)));

		$trim_regx = '/' . $year . '_' . $l_make . '_' . $l_model . '_' . $l_trim . '_' . $vh . '_[0-9]+.png/';
	}

	$regx = '/' . $year . '_' . $l_make . '_' . $l_model . '_' . $vh . '_[0-9]+.png/';

	foreach (array_filter(glob($dir . '/*.png'), 'is_file') as $file) {
		$name = basename($file);

		if ($trim && preg_match($trim_regx, $name)) {
			$to_return[count($to_return)] = $name;
		} elseif (preg_match($regx, $name)) {
			$to_return[count($to_return)] = $name;
		}
	}

	return $to_return;
}

/**
 * Gets the ad group name.
 *
 * @param      <type>  $car          The car
 * @param      <type>  $cron_config  The cron configuration
 *
 * @return     string  The ad group name.
 */
function get_ad_group_name($car, $cron_config)
{
	$version = $cron_config && isset($cron_config['adgroup_version']) ? $cron_config['adgroup_version'] : "v4";

	$id = preg_replace('/[\x00\x0A\x0D]/', '', $car['stock_number']);

	return "{$id}_{$version}";
}

/**
 * Gets the ad group identifier.
 *
 * @param      AdwordsService  $service        The service
 * @param      <type>          $campaign_name  The campaign name
 * @param      <type>          $campaign_id    The campaign identifier
 * @param      <type>          $ad_group_name  The ad group name
 * @param      <type>          $default_bid    The default bid
 * @param      bool            $is_new         Indicates if new
 * @param      bool            $activate       The activate
 *
 * @return     AdwordsService  The ad group identifier.
 */
function get_ad_group_id(AdwordsService $service, $campaign_name, $campaign_id, $ad_group_name, $default_bid, &$is_new, $activate = true)
{
	$adGroups = $service->GetAdGroupByCampaignId($campaign_id, $ad_group_name);

	if ($adGroups && count($adGroups) > 0) {
		$adGroup = $adGroups[0];

		if ($activate) {
			$service->SetAdGroupStatus($adGroup->id, true);
		}

		$is_new      = true; //always return new forcing to include keywords again
		$ad_group_id = $adGroup->id;
	} else {
		$is_new      = true;
		$ad_group_id = $service->CreateAdGroup($campaign_id, $ad_group_name, $default_bid);
	}

	return $ad_group_id;
}

/**
 * { function_description }
 *
 * @param      AdwordsService  $service      The service
 * @param      <type>          $ad_group_id  The ad group identifier
 */
function clear_ad_group(AdwordsService $service, $ad_group_id)
{
	$ads = $service->GetAds($ad_group_id);

	if ($ads) {
		foreach ($ads as $ad) {
			slecho('Removing ad ' . json_encode($ad));
			$service->RemoveAd($ad_group_id, $ad->ad->id);
		}
	}

	$keywords = $service->GetKeywords($ad_group_id);

	if ($keywords) {
		foreach ($keywords as $keyword) {
			$service->RemoveKeyword($ad_group_id, $keyword->criterion->id);
		}
	}

	# Also clear placements
	$placements = $service->GetAdGroupPlacements($ad_group_id);

	if ($placements) {
		foreach ($placements as $placement) {
			$service->RemoveAdGroupPlacements($ad_group_id, $placement->criterion->id);
		}
	}

	$service->SetAdGroupStatus($ad_group_id, false);
}

/**
 * Gets the banner query.
 *
 * @param      <type>  $car          The car
 * @param      <type>  $cron_config  The cron configuration
 * @param      <type>  $banner_size  The banner size
 * @param      <type>  $directive    The directive
 *
 * @return     <type>  The banner query.
 */
function get_banner_query($car, $cron_config, $banner_size, $directive)
{
	global $BannerConfigs;

	$template     = $cron_config['banner']['template'];
	$banner_style = $cron_config['banner']['styels']["{$car['stock_type']}_$directive"];

	$lyear  = strtolower($car['year']);
	$lmake  = strtolower($car['make']);
	$lmodel = strtolower($car['model']);

	$banner_config = $BannerConfigs[$banner_style][$banner_size];
	$template_base = __DIR__ . '/templates/' . $template . '/';
	$template_dir  = $template_base . "{$car['stock_type']}$directive" . '/';
	$template_dirs = array(
		$template_dir . "{$lyear}_{$lmake}_{$lmodel}/",
		$template_dir . "{$lmake}_{$lmodel}/",
		$template_dir . "{$lyear}_{$lmake}/",
		$template_dir . "{$lmake}/",
		$template_dir,
		$template_base,
	);

	if (!isset($banner_config['canvas']['parts-new'])) {
		return array(null);
	}

	$part_names = array_keys($banner_config['canvas']['parts-new']);

	$parts = [];

	foreach ($part_names as $part) {
		$part_regex = '/' . $part . '(?:-[0-9]+)?.png/';

		foreach ($template_dirs as $dir) {
			$found = [];

			foreach (array_filter(glob($dir . '/*.png'), 'is_file') as $file) {
				$name = basename($file);
				if (preg_match($part_regex, $name)) {
					$found[] = $name;
				}
			}

			if (count($found) > 0) {
				$parts[$part] = $found;
				break;
			}
		}
	}

	$kparts = array_keys($parts);
	$vparts = combinations(array_values($parts));

	array_walk($vparts, function (&$combs) use ($kparts) {
		array_walk($combs, function (&$comb, $i) use ($kparts) {
			$temp = rawurlencode($comb);
			$comb = "{$kparts[$i]}=$temp";
		});
		$combs = implode('&', $combs);
	});

	return $vparts;
}

/**
 * { function_description }
 *
 * @param      <type>  $arrays  The arrays
 * @param      int     $i       { parameter_description }
 *
 * @return     array   ( description_of_the_return_value )
 */
function combinations($arrays, $i = 0)
{
	if (!isset($arrays[$i])) {
		return [];
	}
	if ($i == count($arrays) - 1) {
		return $arrays[$i];
	}

	// get combinations from subsequent arrays
	$tmp = combinations($arrays, $i + 1);

	$result = [];

	// concat each array from tmp with each element from $arrays[$i]
	foreach ($arrays[$i] as $v) {
		foreach ($tmp as $t) {
			$result[] = is_array($t) ?
				array_merge(array($v), $t) :
				array($v, $t);
		}
	}

	return $result;
}

/**
 * Gets the placement urls.
 *
 * @param      DbConnect  $db_connect   The database connect
 * @param      <type>     $cron_config  The cron configuration
 * @param      <type>     $car          The car
 *
 * @return     array      The placement urls.
 */
function get_placement_urls(DbConnect $db_connect, $cron_config, $car)
{
	$query = "SELECT url FROM `posible_placement_criterias`, `posible_placement_urls` where (posible_placement_criterias.criteria like '{$car['year']} {$car['make']} {$car['model']} Review'";
	if (isset($cron_config['city'])) {
		$query .= " OR posible_placement_criterias.criteria like '{$car['year']} {$car['make']} {$car['model']} {$cron_config['city']}'";
	}
	$query .= ") and posible_placement_criterias.id = posible_placement_urls.criteria_id";

	$urls = [];

	$res = $db_connect->query($query);

	if ($res) {
		while ($row = mysqli_fetch_array($res)) {
			if ($row['url'] != 'undefined' && stripos($row['url'], 'youtube') === false) {
				$url = reformat_placement($row['url']);
				if ($url) {
					$urls[] = $url;
				}
			}
		}
	}

	mysqli_free_result($res);

	return $urls;
}

/**
 * Gets the default placement urls.
 *
 * @return     array  The default placement urls.
 */
function get_default_placement_urls()
{
	$fileName = dirname(__DIR__) . "/adwords3/caches/defaultPlacementList.txt";
	echo $fileName;
	$urls = [];
	$file = fopen($fileName, "r");
	while (!feof($file)) {
		$url = fgets($file);
		if (strlen($url) > 2) {
			$urls[] = $url;
		}
	}
	fclose($file);
	return $urls;
}

/**
 * { function_description }
 *
 * @param      <type>  $url    The url
 *
 * @return     bool    ( description_of_the_return_value )
 */
function reformat_placement($url)
{
	if (strlen($url) >= 220) {
		return false;
	}

	$parse             = parse_url($url);
	$parse['query']    = '';
	$parse['fragment'] = '';

	$dirs              = explode('/', $parse['path']);
	if (count($dirs) < 2) {
		return false;
	}

	$parse['path'] = implode('/', array_slice($dirs, 0, 3));
	$retval        = build_url($parse);

	if (stripos($retval, '%') !== false) {
		return false;
	}

	return $retval;
}