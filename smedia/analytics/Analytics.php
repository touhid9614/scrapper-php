<?php

namespace sMedia\Analytics;

use sMedia\Google\Authenticator;
use sMedia\Google\Type\AccessToken;

/**
 * This class describes analytics.
 */
class Analytics
{
	/**
	 * access_token
	 *
	 * @var AccessToken
	 */
	public $access_token;
	public $retries;
	/**
	 * google_customer
	 *
	 * @var string
	 */
	public $google_customer;

	# Analytics
	##########################################################################################################################
	# Params
	const PARAM_MAX_RESULTS   = 'max-results';
	const PARAM_START_INDEX   = 'start-index';
	const PARAM_IDS           = 'ids';
	const PARAM_START_DATE    = 'start-date';
	const PARAM_END_DATE      = 'end-date';
	const PARAM_METRICS       = 'metrics';
	const PARAM_DIMENSIONS    = 'dimensions';
	const PARAM_FILTERS       = 'filters';
	const PARAM_INCLUDE_EMPTY = 'include-empty-rows';

	# Values
	const VALUE_ID_ALL             = '~all';
	const VALUE_MAX_RESULTS        = 10000;
	const VALUE_DONT_INCLUDE_EMPTY = 'false';

	# Urls
	const URL_ACCOUNT_LIST       = 'https://www.googleapis.com/analytics/v3/management/accounts';
	const URL_CORE_REPORTING_API = 'https://www.googleapis.com/analytics/v3/data/ga';


	/**
	 * Constructs a new instance.
	 *
	 * @param string $google_customer The google customer
	 */
	public function __construct($google_customer)
	{
		$this->google_customer = $google_customer;
		$access_token = Authenticator::getTokenFor($this->google_customer);
		if ($access_token) {
			$this->access_token = $access_token;
		} else {
			die("ERROR: Unable to get access token for " . $this->google_customer);
		}
		$this->retries = 0;
	}

	/**
	 * Gets the accounts.
	 *
	 * @param integer $max_results The maximum results
	 * @param integer $start_index The start index
	 *
	 * @return     boolean  The accounts.
	 */
	public function GetAccounts($max_results = 1000, $start_index = 1)
	{
		$fields = array(
			self::PARAM_MAX_RESULTS => $max_results,
			self::PARAM_START_INDEX => $start_index,
		);

		$data = $this->Query(self::URL_ACCOUNT_LIST, $fields);

		if (!$data) {
			return null;
		}

		$obj = json_decode($data);

		if ($this->HasError($obj)) {
			if ($this->HandleError($obj->error)) {
				return $this->GetAccounts($max_results, $start_index);
			} else {
				return false;
			}
		}

		return $obj;
	}

	/**
	 * Gets the web properties.
	 *
	 * @param <type> $accountId The account identifier
	 * @param integer $max_results The maximum results
	 * @param integer $start_index The start index
	 *
	 * @return     boolean  The web properties.
	 */

	public function GetWebProperties($accountId, $max_results = 1000, $start_index = 1)
	{
		$url = "https://www.googleapis.com/analytics/v3/management/accounts/{$accountId}/webproperties";

		$fields = array(
			self::PARAM_MAX_RESULTS => $max_results,
			self::PARAM_START_INDEX => $start_index,
		);

		$data = $this->Query($url, $fields);

		if (!$data) {
			return null;
		}

		$obj = json_decode($data);

		if ($this->HasError($obj)) {
			if ($this->HandleError($obj->error)) {
				return $this->GetWebProperties($accountId, $max_results, $start_index);
			} else {
				return false;
			}
		}

		return $obj;
	}

	/**
	 * Gets the view profiles.
	 *
	 * @param <type> $accountId The account identifier
	 * @param <type> $webPropertyId The web property identifier
	 * @param integer $max_results The maximum results
	 * @param integer $start_index The start index
	 *
	 * @return     <type>   The view profiles.
	 */
	public function GetViewProfiles($accountId, $webPropertyId, $max_results = 1000, $start_index = 1)
	{
		$url = "https://www.googleapis.com/analytics/v3/management/accounts/{$accountId}/webproperties/{$webPropertyId}/profiles";

		$fields = array(
			self::PARAM_MAX_RESULTS => $max_results,
			self::PARAM_START_INDEX => $start_index
		);

		$data = $this->Query($url, $fields);

		if (!$data) {
			return null;
		}

		$obj = json_decode($data);

		if ($this->HasError($obj)) {
			if ($this->HandleError($obj->error)) {
				return $this->GetViewProfiles($accountId, $webPropertyId, $max_results, $start_index);
			} else {
				return null;
			}
		}

		return $obj;
	}

	/**
	 * Gets the view profiles by hostname.
	 *
	 * @param <type> $hostName The host name
	 *
	 * @return     array|boolean  The view profiles by hostname.
	 */
	public function GetViewProfilesByHostname($hostName)
	{
		$profiles = $this->GetViewProfiles(self::VALUE_ID_ALL, self::VALUE_ID_ALL);

		if (!$profiles) {
			return false;
		}

		// print_r($profiles);
		// die('oks');

		$selected = array();
		$host_match_regex = '/(?:https?:\/\/)?(?:www.)?(?<host>[^\/\s]+)/';
		$match = array();

		if (!preg_match($host_match_regex, $hostName, $match)) {
			return false;
		}

		$host = $match['host'];

		foreach ($profiles->items as $profile) {
			if (!preg_match($host_match_regex, $profile->websiteUrl, $match)) {
				continue;
			}

			if ($host == $match['host']) {
				$selected[] = $profile;
			}
		}

		return $selected;
	}

	/**
	 * Gets the host report.
	 *
	 * @param <type> $hostName The host name
	 * @param <type> $startDate The start date
	 * @param <type> $endDate The end date
	 * @param array $metrics The metrics
	 *
	 * @return     array|boolean  The host report.
	 */
	public function GetHostReport($hostName, $startDate, $endDate, $metrics = array('ga:pageviews', 'ga:bounceRate'))
	{
		$profiles = $this->GetViewProfilesByHostname($hostName);

		if (!$profiles) {
			return false;
		}

		$reports = array();

		foreach ($profiles as $profile) {
			if (in_array('READ_AND_ANALYZE', $profile->permissions->effective)) {
				$reports[] = $this->GetReport($profile->id, $startDate, $endDate, $metrics);
			}
		}

		return $reports;
	}

	/**
	 * Gets the host summary.
	 *
	 * @param <type> $hostName The host name
	 *
	 * @return     <type>  The host summary.
	 */
	public function GetHostSummary($hostName)
	{
		$startDate = new DateTime(date('Y-m-d'));
		$startDate->sub(new DateInterval('P1M'));

		return $this->GetHostReport($hostName, $startDate->format('Y-m-d'), date('Y-m-d'));
	}

	/**
	 * Gets the url report.
	 *
	 * @param <type> $profileId The profile identifier
	 * @param <type> $url The url
	 * @param <type> $startDate The start date
	 * @param <type> $endDate The end date
	 * @param array $metrics The metrics
	 *
	 * @return     mixed  The url report.
	 */
	public function GetURLReport($profileId, $url, $startDate, $endDate, $metrics = array('ga:pageviews', 'ga:avgTimeOnPage', 'ga:bounceRate'))
	{
		$path_match_regex = '/(?:https?:\/\/)(?:[^\/\s]+)(?<path>\/.*)/';

		$matches = array();
		if (!preg_match($path_match_regex, $url, $matches)) {
			return false;
		}
		$path = $matches['path'];

		return $this->GetReport($profileId, $startDate, $endDate, $metrics, array('ga:pagePath'), "ga:pagePath==$path");
	}

	/**
	 * Gets the report.
	 *
	 * @param <type> $profileId The profile identifier
	 * @param <type> $startDate The start date
	 * @param <type> $endDate The end date
	 * @param array $metrics The metrics
	 * @param array $dimensions The dimensions
	 * @param string $filters The filters
	 *
	 * @return     <type>  The report.
	 */
	public function GetReport($profileId, $startDate, $endDate, $metrics = array('ga:avgTimeOnPage', 'ga:bounceRate'), $dimensions = array(), $filters = '')
	{
		$ids = startsWith($profileId, 'ga:') ? $profileId : "ga:$profileId";

		if (is_array($metrics)) {
			$metrics = implode(',', $metrics);
		}

		if (is_array($dimensions)) {
			$dimensions = implode(',', $dimensions);
		}

		$fields = array(self::PARAM_IDS => $ids, self::PARAM_START_DATE => $startDate, self::PARAM_END_DATE => $endDate, self::PARAM_METRICS => $metrics, self::PARAM_MAX_RESULTS => self::VALUE_MAX_RESULTS, self::PARAM_INCLUDE_EMPTY => self::VALUE_DONT_INCLUDE_EMPTY);

		if ($dimensions) {
			$fields[self::PARAM_DIMENSIONS] = $dimensions;
		}

		if ($filters) {
			$fields[self::PARAM_FILTERS] = $filters;
		}

		$data = $this->Query(self::URL_CORE_REPORTING_API, $fields);

		if (!$data) {
			return null;
		}

		$obj = json_decode($data);

		if ($this->HasError($obj)) {
			return $this->HandleError($obj->error) ? $this->GetReport($ids, $startDate, $endDate, $metrics, $dimensions, $filters) : false;
		}

		return $obj;
	}

	public function GetReportv4($profileId, $startDate, $endDate, $metrics_data = array('ga:avgTimeOnPage', 'ga:bounceRate'), $dimensions_data = array(), $filters = '')
	{
		$viewId = startsWith($profileId, 'ga:') ? ltrim($profileId, 'ga:') : $profileId;
		$dateRanges = array(
			array(
				"startDate" => $startDate,
				"endDate" => $endDate
			)
		);

		$metrics = array();
		foreach ($metrics_data as $item) {
			$metrics[] = array(
				'expression' => $item
			);
		}

		$dimensions = array();
		foreach ($dimensions_data as $item) {
			$dimensions[] = array(
				'name' => $item
			);
		}

		$params = array(
			'viewId' => $viewId,
			'dateRanges' => $dateRanges,
			'metrics' => $metrics,
			'dimensions' => $dimensions,
			'filtersExpression' => $filters
		);

		$reportRequests = array(
			'reportRequests' => array($params)
		);

		$ch = curl_init();
		$header = array();
		$header[] = "Content-length: 0";
		$header[] = "Authorization: Bearer {$this->access_token->Token}";

		// configure curl
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_URL, "https://analyticsreporting.googleapis.com/v4/reports:batchGet");
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($reportRequests));

		// execute curl request
		$contents = curl_exec($ch);
		// check error
		// $err  = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		//close curl request
		curl_close($ch);

		print_r($contents);
		die();

		$data = $contents ? $contents : false;

		if (!$data) {
			return null;
		}

		$obj = json_decode($data);

		if ($this->HasError($obj)) {
			return $this->HandleError($obj->error) ? $this->GetReportV4($viewId, $startDate, $endDate, $metrics, $dimensions, $filters) : false;
		}

		return $obj;
	}

	/**
	 * { function_description }
	 *
	 * @param <type> $url The url
	 * @param array $fields The fields
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function Query($url, $fields = array())
	{
		if (!$this->access_token) {
			slecho("ERROR: Analytics isn't initialized properly");
			return false;
		}

		// Initialize curl request
		$curl = curl_init();

		$fields_string = '';
		foreach ($fields as $key => $value) {
			$fields_string .= $key . '=' . urlencode($value) . '&';
		}
		rtrim($fields_string, '&');

		$new_url = urlCombine($url, "?$fields_string");

		$header = array();
		$header[] = "Content-length: 0";
		$header[] = "Authorization: Bearer {$this->access_token->Token}";

		// configure curl
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_URL, $new_url);

		// execute curl request
		$contents = curl_exec($curl);
		// check error
		// $err  = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		// close curl request
		curl_close($curl);

		// return data if no error
		if ($contents) {
			return $contents;
		} else {
			return false;
		}
	}

	/**
	 * { function_description }
	 *
	 * @param <type> $url The url
	 * @param array $fields The fields
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function QueryPOST($url, $post_data)
	{
		if (!$this->access_token && !count($post_data)) {
			slecho("ERROR: Analytics isn't initialized properly");
			return false;
		}

		$json_data = json_encode($post_data);
		//slecho($json_data);
		//slecho($url);

		// Initialize curl request
		$curl = curl_init();


		//$new_url = urlCombine($url, "?$fields_string");

		$header = array();
		$header[] = "Authorization: Bearer {$this->access_token->Token}";
		$header[] = "Accept: application/json";
		$header[] = "Content-Type: application/json";


		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt($curl, CURLOPT_URL, $url);

		// execute curl request
		$contents = curl_exec($curl);
		// check error
		//$err  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		//slecho($curl);
		// close curl request
		curl_close($curl);

		//slecho($contents);
		//slecho($err);

		// return data if no error
		if ($contents) {
			return $contents;
		} else {
			return false;
		}
	}

	/**
	 * Determines if error.
	 *
	 * @param <type> $obj The object
	 *
	 * @return     <type>  True if error, False otherwise.
	 */
	private function HasError($obj)
	{
		return property_exists($obj, 'error');
	}

	/**
	 * { function_description }
	 *
	 * @param <type> $error The error
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	private function HandleError($error)
	{
		if ($error->code == 401) {
			slecho("Account: " . $this->google_customer);
			$access_token = Authenticator::getTokenFor($this->google_customer, true, true);
			if ($access_token) {
				slecho("Info:: Access token renewed for " . $this->google_customer);
				$this->access_token = $access_token;
				return true;
			}

			die("ERROR: Unable to renew access token for {$this->google_customer} after token has expired");
		} elseif ($error->code == 403 && $error->message = 'User Rate Limit Exceeded' && $this->retries < 6) {
			$this->retries++;
			$min = $this->retries * 1000000;
			$max = ($this->retries + 2) * 1000000;
			$micro_seconds = rand($min, $max);
			usleep($micro_seconds);
			return true;
		}

		if (defined("debug")) {
			$this->DumpObject($error);
		}

		return false;
	}

	/**
	 * Gets the associative rows.
	 *
	 * @param <type> $analyticsReport The analytics report
	 *
	 * @return     array   The associative rows.
	 */
	public function GetAssociativeRows($analyticsReport)
	{
		$headerNames = array();
		$retval = array();

		if (!isset($analyticsReport->rows)) {
			return $retval;
		}

		foreach ($analyticsReport->columnHeaders as $header) {
			$headerNames[] = substr($header->name, 3);
		}

		foreach ($analyticsReport->rows as $row) {
			$obj = array();

			for ($i = 0; $i < count($row); $i++) {
				$obj[$headerNames[$i]] = $row[$i];
			}

			$retval[] = $obj;
		}

		return $retval;
	}

	/**
	 * Dumps an object.
	 *
	 * @param <type> $obj The object
	 */
	public function DumpObject($obj)
	{
		echo '<pre>';
		print_r($obj);
		echo '</pre>';
	}

	public function GetAccountSummaries($max_results = 1000, $start_index = 1)
	{
		$url = "https://www.googleapis.com/analytics/v3/management/accountSummaries";

		$fields = array(
			self::PARAM_MAX_RESULTS => $max_results,
			self::PARAM_START_INDEX => $start_index,
		);

		$data = $this->Query($url, $fields);

		if (!$data) {
			return null;
		}

		$obj = json_decode($data);

		if ($this->HasError($obj)) {
			if ($this->HandleError($obj->error)) {
				return $this->GetAccountSummaries($max_results, $start_index);
			} else {
				return false;
			}
		}

		return $obj;
	}

	public function CreateWebPropertie($accountId, $name, $websiteUrl)
	{
		$url = "https://www.googleapis.com/analytics/v3/management/accounts/{$accountId}/webproperties";

		$fields = array(
			"name" => $name,
			"websiteUrl" => $websiteUrl,
			"kind" => "analytics#webproperty",
			"industryVertical" => "AUTOMOTIVE",
			"level" => "STANDARD",
			"dataRetentionResetOnNewActivity" => false,
			"dataRetentionTtl" => "INDEFINITE"
		);

		$data = $this->QueryPOST($url, $fields);

		if (!$data) {
			return null;
		}

		$obj = json_decode($data);

		if ($this->HasError($obj)) {
			if ($this->HandleError($obj->error)) {
				return $this->CreateWebPropertie($accountId, $name, $websiteUrl);
			} else {
				return false;
			}
		}

		return $obj;
	}

	public function CreateViewProfiles($accountId, $webPropertyId, $name, $websiteUrl, $currency = 'USD', $timezone = 'America/Regina')
	{
		$url = "https://www.googleapis.com/analytics/v3/management/accounts/{$accountId}/webproperties/{$webPropertyId}/profiles";


		$fields = array(
			"name" => $name,
			"websiteUrl" => $websiteUrl,
			"kind" => "analytics#webproperty",
			"currency" => $currency,
			"timezone" => $timezone,
			"type" => "WEB"
		);

		$data = $this->QueryPOST($url, $fields);

		if (!$data) {
			return null;
		}

		$obj = json_decode($data);

		if ($this->HasError($obj)) {
			if ($this->HandleError($obj->error)) {
				return $this->CreateViewProfiles($accountId, $webPropertyId, $name, $websiteUrl, $currency, $timezone);
			} else {
				return false;
			}
		}

		return $obj;
	}

	public function CreateGoal($accountId, $webPropertyId, $profileId, $id, $name, $eventDetails)
	{

		$url = "https://www.googleapis.com/analytics/v3/management/accounts/{$accountId}/webproperties/{$webPropertyId}/profiles/{$profileId}/goals";


		$fields = array(
			"id" => $id,
			"name" => $name,
			"kind" => "analytics#goal",
			"type" => "EVENT",
			"active" => true,
			"eventDetails" => $eventDetails
		);

		$data = $this->QueryPOST($url, $fields);

		if (!$data) {
			return null;
		}

		$obj = json_decode($data);

		if ($this->HasError($obj)) {
			if ($this->HandleError($obj->error)) {
				return $this->CreateGoal($accountId, $webPropertyId, $profileId, $id, $name, $eventDetails);
			} else {
				return false;
			}
		}

		return $obj;
	}

	public function GetAllGoal($accountId, $webPropertyId, $profileId, $max_results = 1000, $start_index = 1)
	{

		$url = "https://www.googleapis.com/analytics/v3/management/accounts/{$accountId}/webproperties/{$webPropertyId}/profiles/$profileId/goals";

		$fields = array(
			self::PARAM_MAX_RESULTS => $max_results,
			self::PARAM_START_INDEX => $start_index
		);

		$data = $this->Query($url, $fields);

		if (!$data) {
			return null;
		}

		$obj = json_decode($data);

		if ($this->HasError($obj)) {
			if ($this->HandleError($obj->error)) {
				return $this->GetAllGoal($accountId, $webPropertyId, $profileId, $max_results, $start_index);
			} else {
				return null;
			}
		}

		return $obj;
	}
}
