<?php

namespace sMedia\AdSync\Controller;

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Collection;
use sMedia\AdSync\Model\Car;
use sMedia\AdSync\Model\AdModel;
use sMedia\AdSync\Utils;
use sMedia\Logger\Logger;

class AdSyncBase
{
	const SERVICE_BING = 'bing';
	const SERVICE_ADWORDS = 'adwords';

	const TAGS = [
		'NONE' => '',
		'HIGH_FUNNEL_BRAND_RESEARCH' => 'HighFunnelBrandResearch',
		'HIGH_FUNNEL_BODYSTYLE_RESEARCH' => 'HighFunnelBodystyleResearch',
		'HIGH_FUNNEL_MODEL_RESEARCH' => 'HighFunnelModelResearch',
		'MID_FUNNEL_MODEL_AFFORDABILITY' => 'MidFunnelModelAffordability',
		'MID_FUNNEL_MODEL_DEALS' => 'MidFunnelModelDeals',
		'LOW_FUNNEL_BRAND_WHERE_TO_BUY' => 'LowFunnelBrandWhereToBuy',
		'LOW_FUNNEL_MODEL_WHERE_TO_BUY' => 'LowFunnelModelWhereToBuy',
		'RESERCH' => 'Research',
		'RESERCH_OFFER' => 'ResearchOffer',
		'RESERCH_LEASE' => 'ResearchLease',
		'RESERCH_FINANCE' => 'ResearchFinance',
	];

	/**
	 * logger
	 *
	 * @var \Monolog\Logger
	 */
	public $logger;
	public $dealership;
	public $accountId = '';
	public $dealershipData;
	public $tableName;
	public $keywordTableName;
	public $campaignKeywordTableName = null;
	public $serviceType;
	public $version;
	// public $tag = AdSyncBase::TAGS['HIGH_FUNNEL_BRAND_RESEARCH'];
	public $tag = "";
	/**
	 * cars
	 *
	 * @var Collection
	 */
	public $cars;
	public $stockType;
	public $dry;
	public $budget;
	public $keywords;
	public $groupKeywords = [];
	public $campaigns;
	public $genericCampaigns;
	public $validCampaigns = [];
	public $altCampaignNames = [];
	public $specialCampaigns = null;
	/** publishedAdGroupes
	 *
	 * @var Collection
	 */
	public $publishedAdGroupes;
	/** groupIds
	 *
	 * @var Collection
	 */
	public $groupIds;
	/**
	 * newAdGroupes
	 *
	 * @var Collection
	 */
	public $newAdGroupes;
	/** totalAdsInGroups
	 *
	 * @var Collection
	 */
	public $totalAdsInGroups;
	/** emptyAdGroups
	 *
	 * @var Collection
	 */
	public $epmtyAdGroups;
	public $keywordOptions = [
		"group_positive"	=> true,
		"group_negative"	=> true,
		"group_negative_year"	=> true,
		"campaign_positive" => false,
		"campaign_negative" => false,
		"year_negative_keywords_type" => "BROAD",
	];
	public $allKeywords;
	public $allCampaignKeywords;
	/** publishedKeywords
	 *
	 * @var Collection
	 */
	public $publishedKeywords;
	public $publishedCampaignKeywords;
	public $newKeywords;
	/** newCampaignKeywords
	 *
	 * @var Collection
	 */
	public $newCampaignKeywords;
	/**
	 * deletedKeywords
	 *
	 * @var Collection
	 */
	public $deletedKeywords;
	public $deletedCampaignKeywords;
	public $newAds;
	public $allAds;
	public $deletedAds;
	public $titles;
	public $descriptions;
	public $cpc;
	public $groupCpc;
	public $listingPageUrl;
	public $combinations;
	public $allPublishedAds;
	public $affectedAdGroupes;
	public $disabled;
	public $utmSource = "";
	public $utmMedium = "";
	public $utmCampaign = false;
	public $modelMap = [];
	public $valueMap = [];
	public $adTypes = ['esa'];
	public $adReset = 0;
	public $year_negative_keywords = [];
	public static $defaultBid = 5.0;
	public static $defaultSettings = [
		'esa' => [
			't1' => "[year(1)] [make(2)] [model] [price(3)]",
			't2' => "Book a Test Drive",
			't3' => "View Prices, Deals and Offers",
			'd1' => "[year] [make] [model]",
			'd2' => "See Inventory, Specs & Get a Quote. Call Today & Schedule A Test Drive!",
		],
		'rsa' => [
			'new' => [
				'make' => [
					'titles' => [
						[
							"[company_name]",
							"Shop New & Used [make]",
							"[make] Sales & Service",
							"[company_name] in [city]",
						], [
							"[make] Dealer",
						], [], [],
					],
					'descriptions' => [
						[
							"We've got the best selection of new & used [make].",
							"Your full service [make] dealer.",
							"Get Directions, call, text or chat with us today.",
							"We're committed to our customer satisfaction",
						], [], [],
					]
				],
				'make_model' => [
					'titles' => [
						[
							"[model] from [price]",
							"Shop [model] Inventory",
							"[company_name]",
							"[make(1)] [model] for Sale",
							"See Photos & Get Payments",
						], [
							"New [make(1)] [model]",
						], [], [],
					],
					'descriptions' => [
						[
							"Get the latest deals & best selection on new [make] [model]s in [city].",
							"The Best Selection & Deals on new [model] in stock at [company_name] in [city].",
							"Shop our inventory of the new [make] [model].",
							"[company_name] is committed to our customers. Call, text or chat today."
						], [], [],
					]
				],
				'make_model_year' => [
					'titles' => [
						[
							"Starting at [price]",
							"For Sale at [company_name]",
							"Shop [model] Inventory",
							"[year(1)] [model] in Stock",
							"See Photos & Get Payments",
						], [
							"[year(1)] [make(2)] [model] ",
						], [], [],
					],
					'descriptions' => [
						[
							// "Equipped with [options]",
							"[car_models] in stock.",
							"[year(1)] [model]  for sale at [company_name] in [city].",
							"Shop our inventory of the new [make(1)] [model].",
							"[company_name] is committed to our customers. Call, text or chat today."
						], [], [],
					]
				],
				'make_model_year_trim' => [
					'titles' => [[], [], [], []],
					'descriptions' => [[], [], []]
				]
			],
			'used' => [
				'make' => [
					'titles' => [
						[
							"[company_name]",
							"Shop Used [make]",
							"Used [make] Sales",
							"[company_name] in [city]",
						], [
							"Used [make] Dealer",
						], [], []
					],

					'descriptions' => [
						[
							"We've got the best selection of pre-owned used [make].",
							"Your pre-owned [make] dealer.",
							"Get Directions, call, text or chat with us today.",
							"We're committed to our customers' satisfaction.",
						], [], [],
					]
				],
				'make_model' => [
					'titles' => [
						[
							"[model] from [price]",
							"Shop [model] Inventory",
							"[company_name]",
							"[make(1)] [model] for Sale",
							"See Photos & Get Payments",
						], [
							"Used [make(1)] [model]",
						], [], [],
					],
					'descriptions' => [
						[
							"Get the latest deals & best selection on Used [make] [model]s in [city].",
							"The Best Selection & Deals on Used [model] in stock at [company_name] in [city].",
							"Shop our inventory of the Used [make] [model].",
							"[company_name] is committed to our customers. Call, text or chat today.",
						], [], [],

					]
				],
				'make_model_year' => [
					'titles' => [
						[
							"Starting at [price]",
							"For Sale at [company_name]",
							"Shop [model] Inventory ",
							"Used [model] in Stock ",
							"See Photos & Get Payments",
						], [
							"[year(2)] [make(1)] [model]",
						], [], [],
					],
					'descriptions' => [
						[
							// "Equipped with [options]",
							"Used [car_models] in stock.",
							"Used [year(1)] [model]  for sale at [company_name] in [city].",
							"Shop our inventory of the Pre-owned [make] [model].",
							"[company_name] is committed to our customers. Call, text or chat today.",
						], [], [],
					]
				],
				'make_model_year_trim' => [
					'titles' => [[], [], [], []],
					'descriptions' => [[], [], []]
				]
			]
		]
	];


	public function __construct($dealership, $service_type)
	{
		$this->serviceType  = $service_type;
		$this->tableName  = "tbl_{$this->serviceType}_ad";
		$this->newAds  = [];
		$this->allAds  = [];
		$this->deletedAds  = [];
		$this->allPublishedAds  = [];
		$this->cars  = collect([]);
		$this->stockType  = 'used';
		$this->affectedAdGroupes = [];
		$this->setLogger();
		$this->setDealership($dealership);
		$this->disabled  = false;
		$this->campaignPrefix = [
			'new' => strtolower("smedia_{$this->dealership}_new_"),
			'used' => strtolower("smedia_{$this->dealership}_used_")
		];

		$this->genericCampaigns =  [
			"make",
			"make_model",
			"make_model_year",
			"make_model_year_trim",
		];

		$this->loadDealershipData();
		$this->loadAltCampaignNames();
		$this->negativeYearkeywordTemplates();
	}

	public function negativeYearkeywordTemplates()
	{
		$year = 1950;
		$end_year = intval(date("Y", time())) + 3;
		$years = [];

		while ($year <= $end_year) {
			$years[] = $year++;
		}

		$this->year_negative_keywords =
			array_combine($years, array_map(function ($y) {
				switch ($this->keywordOptions["year_negative_keywords_type"]) {
					case "BROAD":
						$kw = ['text' => "+{$y}", 'matchType' => "BROAD"];
						break;
					case "PHRASE":
						$kw = ['text' => "$y", 'matchType' => "PHRASE"];
						break;
					case "EXACT":
						$kw = ['text' => "$y", 'matchType' => "EXACT"];
						break;
				}

				return $kw;
			}, $years));
	}

	public function setLogger($logger = null)
	{

		/* unset($this->logger);
		$formatter = new LineFormatter(null, null, false, true);
		if (!empty($path)) {
			$handler = new StreamHandler($path, Logger::DEBUG);
		} else {
			$handler = new StreamHandler('php://stdout', Logger::DEBUG);
		}
		$handler->setFormatter($formatter);
		$this->logger = new Logger("{$this->dealership}_adwords");
		$this->logger->pushHandler($handler);
		$this->logger->pushProcessor(new IntrospectionProcessor(Logger::ERROR, array(), 1)); */

		if (empty($logger)) {
			$this->logger = Logger::get('default');
		} else {
			$this->logger = $logger;
		}
		// $this->logger->pushHandler(new FirePHPHandler());

		return $this;
	}

	protected function setDealership($dealership)
	{
		$this->dealership = $dealership;
		$this->keywordTableName  = "tbl_{$this->serviceType}_keyword_{$this->dealership}";
		$this->logger->info("Dealership: {$this->dealership}");
	}

	protected function loadDealershipData()
	{
		$dealershipData = DB::table('dealerships')->select('dealership', 'city', 'company_name')->where('dealership', $this->dealership)->get();
		if ($dealershipData->count()) {
			$this->dealershipData = (array)$dealershipData->first();
		}
	}

	public function setTag($tag)
	{
		$this->tag = $tag;
		return $this;
	}

	public function setType($stockType)
	{
		$this->stockType = $stockType;
		return $this;
	}

	public function setStockType($stock_type)
	{
		return $this->setType($stock_type);
	}

	public function setAdTypes(array $adTypes)
	{
		$this->adTypes = $adTypes;
		return $this;
	}

	public function setDry($dry)
	{
		$this->dry = $dry;
		return $this;
	}

	public function useCronConfig(array $configs)
	{
		$this->version = $configs && isset($configs['adgroup_version']) ? $configs['adgroup_version'] : "v4";
		$this->host_url = isset($configs['host_url']) ? $configs['host_url'] : '';
		$this->modelMap = isset($configs['model_map']) ? $configs['model_map'] : [];
		if ($this->serviceType === self::SERVICE_ADWORDS) {
			$this->accountId = 	isset($configs['customer_id']) ? $configs['customer_id'] : '';
		} else if ($this->serviceType === self::SERVICE_BING) {
			$this->accountId = 	isset($configs['bing_account_id']) ? $configs['bing_account_id'] : '';
		}

		$this->logger->info("Version: {$this->version}");
		// empty($this->host_url) && $this->logger->warning('host_url not found');

		return $this;
	}
	/**
	 * createCustomCapaignsNames
	 *
	 * @param array $vars this will contain stock_type, make, model, year and trim
	 * @param array $generic_campaigns list of default campaings, base on this custom campaing will be created
	 * @param string $stock_type if need to filter single stock type
	 */
	public function createCustomCapaignsNames($vars = [], $generic_campaigns, $stock_type = "")
	{
		// Remove empty key from vars
		$vars = Utils::removeEmptyArrayValues($vars);
		// get key of vars
		$var_keys = array_keys($vars);
		$var_vals = array_values($vars);
		// filter $generic_campaigns wich does't contain any of vars
		$generic_campaigns = array_filter($generic_campaigns, function ($v) use ($var_keys, $stock_type) {
			$parts = explode('_', $v);
			// if $stock_type provided, ingnore other stock types
			if (!empty($stock_type) && !in_array($stock_type, $parts)) {
				return false;
			}

			// check all keys exist in campaing name
			if (empty(array_diff($var_keys, $parts))) {
				return true;
			}
			return false;
		});

		// replace var key with var value from filtered generic_campaigns
		return array_map(function ($v) use ($var_keys, $var_vals) {
			return str_replace($var_keys, $var_vals, $v);
		}, $generic_campaigns);
	}

	/**
	 * overrideCampaignStatus
	 *
	 * @param Collection array $status_data
	 * @param array $status
	 *
	 * @return array
	 */
	private function overrideCampaignStatus($status_data, $status)
	{
		if ($status_data->count()) {
			foreach ($status_data->groupBy('stock_type') as $stock_type => $gs) {
				$status[$stock_type]['make'] = $gs[0]->make;
				$status[$stock_type]['model'] = $gs[0]->model;
				$status[$stock_type]['year'] = $gs[0]->year;
				$status[$stock_type]['trim'] = $gs[0]->trim;
			}
		}

		return $status;
	}

	/**
	 * filterCampaignUsingStatus
	 *
	 * @param array $campaigns
	 * @param array $status
	 */
	function filterCampaignUsingStatus($campaigns, $status)
	{
		$filter = function ($c) use ($status) {
			$parts = explode('_', $this->getShortCampaignName($c));
			$stock_type = $parts[1];
			$last = array_pop($parts);
			return isset($status[$stock_type]) && isset($status[$stock_type][$last]) && $status[$stock_type][$last] === 1;
		};
		return array_filter($campaigns, $filter);
	}

	/**
	 * createCustomCampaingNamesFromSettings
	 *
	 * @param Collection $custom_campaign_settings
	 * @param array $generic_campaigns
	 */
	private function createCustomCampaingNamesFromSettings($custom_campaign_settings, $generic_campaigns)
	{
		$custom_campaigns = [];

		if ($custom_campaign_settings->count()) {
			foreach ($custom_campaign_settings as $ccd) {
				$vars = ['make' => $ccd->make, 'year' => $ccd->year, 'model' => $ccd->model, 'trim' => $ccd->trim];
				$stock_type = empty($ccd->stock_type) ? $this->stockType : $ccd->stock_type;
				if ($stock_type != $this->stockType) continue;
				$custom_campaigns = array_merge($custom_campaigns, $this->createCustomCapaignsNames($vars, $generic_campaigns, $stock_type));
			}
		}

		return $custom_campaigns;
	}

	private function loadCustomCampaignSettings()
	{
		return DB::table('tbl_ad_custom_campaigns')
			->select('stock_type', 'make', 'model', 'year', 'trim')
			->where('dealership', $this->dealership)
			->where($this->serviceType, 1)
			->get();
	}

	private function loadCampaignStatusData()
	{
		$query = DB::table('tbl_ad_campaigns')
			->select('stock_type', 'make', 'model', 'year', 'trim', 'type', 'dealership', 'service', 'tag')
			->whereIn('dealership', [
				"global",
				"{$this->dealership}",
			])
			->where('service', $this->serviceType)
			->where('tag', $this->tag);

		return $query->get();
	}

	private function getStatusFor($type, $settings)
	{
		$status = [];
		foreach ($settings->where('type', $type)->where('dealership', 'global')->groupBy('stock_type') as $stock_type => $gs) {
			$status[$stock_type] = [
				'make' => $gs[0]->make,
				'model' => $gs[0]->model,
				'year' => $gs[0]->year,
				'trim' => $gs[0]->trim,
			];
		}
		return $status;
	}

	public function loadSpecialCampaigns()
	{
		$data = DB::table('tbl_ad_special_campaigns')
			->where('dealership', $this->dealership)
			->where('type', 'generic')
			->where('tag', $this->tag)
			->where('stock_type', $this->stockType)
			->where('service', $this->serviceType)
			->get();

		$campaigns = [];
		foreach ($data as $d) {
			$fields = json_decode($d->field_map, true);
			$car_filters = json_decode($d->car_filters, true);
			$value_map = json_decode($d->value_map, true);
			$campaigns[$d->structure] = [
				"name" => "smedia_{$this->stockType}_" . $d->structure,
				"fields" => is_array($fields) ? $fields : [],
				"car_filters" => is_array($car_filters) ? $car_filters : [],
				"value_map" => is_array($value_map) ? $value_map : []
			];
		}
		return $campaigns;
	}

	public function loadAltCampaignNames()
	{
		$this->altCampaignNames = [];
		$alt_names = DB::table('tbl_alt_campaign_name')
			->where('dealership', $this->dealership)
			->where('service', $this->serviceType)
			->get();

		foreach ($alt_names as $n) {
			$this->altCampaignNames[$n->name] = $n->alt_name;
		}
	}

	public function generateSpacialValidCampaigns()
	{
		return array_map(function ($c) {
			return $this->getFullCampaignName($this->campaignPrefix[$this->stockType] . $c);
		}, array_keys($this->specialCampaigns));
	}

	public function generateValidCampaignNames($include_special = true)
	{
		$generic_campaigns = array_map(function ($v) {
			return $this->getFullCampaignName($this->campaignPrefix[$this->stockType] . $v);
		}, $this->genericCampaigns);

		$custom_campaign_settings = $this->loadCustomCampaignSettings();
		$custom_campaigns = $this->createCustomCampaingNamesFromSettings($custom_campaign_settings, $generic_campaigns);
		$campaign_status_data = $this->loadCampaignStatusData();
		$status = $this->getStatusFor("generic", $campaign_status_data);
		$custom_status = $this->getStatusFor("custom", $campaign_status_data);

		$dealer_generic = $campaign_status_data->where('type', "generic")->where('dealership', $this->dealership);
		$status = $this->overrideCampaignStatus($dealer_generic, $status);
		$generic_campaigns = $this->filterCampaignUsingStatus($generic_campaigns, $status);

		foreach ($campaign_status_data->where('type', "custom")->where('dealership', 'global')->groupBy('stock_type') as $stock_type => $gs) {
			$custom_status[$stock_type] = [$gs[0]->make, $gs[0]->model, $gs[0]->year, $gs[0]->trim];
		}

		$dealer_custom_generic = $campaign_status_data->where('type', "custom")->where('dealership', $this->dealership);
		$custom_status = $this->overrideCampaignStatus($dealer_custom_generic, $custom_status);
		$custom_campaigns = $this->filterCampaignUsingStatus($custom_campaigns, $custom_status);

		$this->specialCampaigns = $this->loadSpecialCampaigns();
		if ($include_special) {
			$special_campaigns = $this->generateSpacialValidCampaigns();
		} else {
			$special_campaigns = [];
		}

		$this->validCampaigns = array_merge($generic_campaigns, $custom_campaigns, $special_campaigns);

		$this->logger->debug("Valid campaigns", $this->validCampaigns);

		return $this;
	}

	public function loadCars()
	{
		$this->carModel = new Car();
		$this->cars = $this->carModel->setTable("{$this->dealership}_scrapped_data")
			->where('deleted', 0)
			->where('stock_type', $this->stockType)
			->select(
				[
					'year',
					'make',
					'model',
					'trim',
					'body_style',
					'msrp',
					'price',
					'currency',
					'city',
					'biweekly',
					'finance',
					'lease',
					'lease_term',
					'lease_rate',
					'finance',
					'finance_term',
					'finance_rate',
					'engine',
					'cylinder',
					'transmission',
					'fuel_type',
					'drivetrain',
					'exterior_color',
					'interior_color',
					'url',
				]
			)
			->get()
			->map(function($v) {
				$v->make = ucwords($v->make);
				$v->model = ucwords($v->model);
				$v->trim = ucwords($v->trim);
				return $v;
			});
		$this->logger->info("Car loaded: ", [
			'stock type' => $this->stockType,
			'total' => count($this->cars)
		]);

		return $this;
	}

	protected function loadTitleDescription()
	{
		$this->titles = [];
		$this->descriptions = [];
		$query = DB::table('ad_details')->where('dealership', '=', $this->dealership);
		$settings = $query->where('tag', $this->tag)->get();

		if ($settings->count() == 0) {
			$settings = $query->where('tag', '')->get();
		}

		$settings = $settings->toArray();

		if (count($settings)) {
			foreach ($settings as $setting) {
				$make = !empty($setting->make) ? $setting->make : 'make';
				$model = !empty($setting->model) ? $setting->model : 'model';
				$year = !empty($setting->year) ? $setting->year : 'year';
				$trim = !empty($setting->trim) ? $setting->trim : 'trim';
				$key = str_replace(['make', 'model', 'year', 'trim'], [$make, $model, $year, $trim], $setting->campaign);
				if (!isset($this->titles[$setting->ad_type][$key])) {
					$this->titles[$setting->ad_type][$key] = [[], [], [], []];
					$this->descriptions[$setting->ad_type][$key] = [[], [], []];
				}
				if ($setting->entryType == 'h') {
					$this->titles[$setting->ad_type][$key][0][] = $setting->value;
				} else if ($setting->entryType == 'h1') {
					$this->titles[$setting->ad_type][$key][1][] = $setting->value;
				} else if ($setting->entryType == 'h2') {
					$this->titles[$setting->ad_type][$key][2][] = $setting->value;
				} else if ($setting->entryType == 'h3') {
					$this->titles[$setting->ad_type][$key][3][] = $setting->value;
				} else if ($setting->entryType == 'd') {
					$this->descriptions[$setting->ad_type][$key][0][] = $setting->value;
				} else if ($setting->entryType == 'd1') {
					$this->descriptions[$setting->ad_type][$key][1][] = $setting->value;
				} else if ($setting->entryType == 'd2') {
					$this->descriptions[$setting->ad_type][$key][2][] = $setting->value;
				}
			}
		}
	}

	protected function loadCpc()
	{
		$settings = DB::table('ad_cpc')
			->where('dealership', '=', $this->dealership)
			->where('campaign', 'like', "smedia_{$this->stockType}_%")
			->where('service', '=', $this->serviceType)
			->get()
			->toArray();
		if (count($settings)) {
			foreach ($settings as $setting) {
				$make = !empty($setting->make) ? $setting->make : 'make';
				$model = !empty($setting->model) ? $setting->model : 'model';
				$year = !empty($setting->year) ? $setting->year : 'year';
				$trim = !empty($setting->trim) ? $setting->trim : 'trim';
				$key = str_replace(['make', 'model', 'year', 'trim'], [$make, $model, $year, $trim], $setting->campaign);
				if (!isset($this->cpc[$key])) {
					$this->cpc[$key] = floatval($setting->amount);
				}
			}
		}
	}

	protected function loadKeywords()
	{
		$this->keywords = [];
		$global_keywords = DB::table('ad_keywords')
			->where('dealership', "=", 'global')
			->where($this->serviceType, "=", 1)
			->where('tag', "=", $this->tag)
			->get();
		$custom_keywords = DB::table('ad_keywords')
			->where('dealership', "=", $this->dealership)
			->where($this->serviceType, "=", 1)
			->where('tag', "=", $this->tag)
			->get();
		$filter = $custom_keywords->map(function ($v) {
			return $v->campaign . "__" . $v->keyWordType;
		})->unique()->toArray();

		$combined_keywords = $global_keywords->filter(function ($v) use ($filter) {
			return !in_array($v->campaign . "__" . $v->keyWordType, $filter);
		})->merge($custom_keywords)->groupBy(['campaign', 'keyWordType']);

		foreach ($combined_keywords as $campaign => $type_keywords) {
			foreach ($type_keywords as $type => $keywords) {
				foreach ($keywords as $keyword) {
					$this->keywords[$campaign][strtolower($type)][] = ['text' => $keyword->pattern, 'matchType' => $keyword->matchType];
				}
			}
		}
	}

	protected function loadListingPageUrl()
	{
		$urls = DB::table('ad_url_pattern')->where('dealership', '=', $this->dealership)->where('campaign', 'LIKE', "%{$this->stockType}%")->where($this->serviceType, '=', '1')->get()->toArray();
		if (count($urls)) {
			foreach ($urls as $url) {
				$this->listingPageUrl[$url->campaign] = $url->urlPattern;
			}
			$this->disabled = false;
		} else {
			$this->disabled = true;
			$this->logger->info("Disable $this->stockType");
		}
	}

	protected function loadBudget()
	{
		// TODO get budget info from ad settings
		$this->budget = [
			"smedia_{$this->stockType}_make" => .3,
			"smedia_{$this->stockType}_make_model" => .3,
			"smedia_{$this->stockType}_make_model_year" => .3,
			"smedia_{$this->stockType}_make_model_year_trim" => .3,
		];
	}

	protected function loadConfigs()
	{
		$this->loadCpc();
		$this->loadTitleDescription();
		$this->loadListingPageUrl();
		$this->loadBudget();
	}

	public function getRsaSetting($campaign, $vars)
	{
		$make = isset($vars['make']) ? $vars['make'] : 'make';
		$model = isset($vars['model']) ? $vars['model'] : 'model';
		$year = isset($vars['year']) ? $vars['year'] : 'year';
		$trim = isset($vars['trim']) ? $vars['trim'] : 'trim';

		$titles = [];
		$descriptions = [];

		array_map(function ($v) use ($campaign, $make, $model, $year, $trim, &$titles) {
			$titles[$v] = $this->getSetting('rsa', 'titles', $v, $campaign, $make, $model, $year, $trim);
		}, [0, 1, 2, 3]);


		array_map(function ($v) use ($campaign, $make, $model, $year, $trim, &$descriptions) {
			$descriptions[$v] = $this->getSetting('rsa', 'descriptions', $v, $campaign, $make, $model, $year, $trim);
		}, [0, 1, 2]);

		return [
			"titles" => $titles,
			"descriptions" => $descriptions
		];
	}

	protected function possibleKeyss($make, $model, $year, $trim)
	{

		return [
			[
				"smedia_{$this->stockType}_{$make}",
				"smedia_{$this->stockType}_make",
			],
			[
				"smedia_{$this->stockType}_{$make}_{$model}",
				"smedia_{$this->stockType}_make_{$model}",
				"smedia_{$this->stockType}_{$make}_model",
				"smedia_{$this->stockType}_make_model",
			],
			[
				"smedia_{$this->stockType}_{$make}_{$model}_{$year}",
				"smedia_{$this->stockType}_{$make}_{$model}_year",
				"smedia_{$this->stockType}_make_{$model}_{$year}",
				"smedia_{$this->stockType}_{$make}_model_{$year}",
				"smedia_{$this->stockType}_make_{$model}_year",
				"smedia_{$this->stockType}_{$make}_model_year",
				"smedia_{$this->stockType}_make_model_{$year}",
				"smedia_{$this->stockType}_make_model_year",
			],
			[
				"smedia_{$this->stockType}_{$make}_{$model}_{$year}_{$trim}",
				"smedia_{$this->stockType}_{$make}_{$model}_{$year}_trim",
				"smedia_{$this->stockType}_{$make}_{$model}_year_{$trim}",
				"smedia_{$this->stockType}_{$make}_{$model}_year_trim",
				"smedia_{$this->stockType}_make_{$model}_{$year}_{$trim}",
				"smedia_{$this->stockType}_make_{$model}_{$year}_trim",
				"smedia_{$this->stockType}_{$make}_model_{$year}_{$trim}",
				"smedia_{$this->stockType}_{$make}_model_{$year}_trim",
				"smedia_{$this->stockType}_make_{$model}_year_{$trim}",
				"smedia_{$this->stockType}_make_{$model}_year_trim",
				"smedia_{$this->stockType}_{$make}_model_year_{$trim}",
				"smedia_{$this->stockType}_{$make}_model_year_trim",
				"smedia_{$this->stockType}_make_model_{$year}_{$trim}",
				"smedia_{$this->stockType}_make_model_{$year}_trim",
				"smedia_{$this->stockType}_make_model_year_{$trim}",
				"smedia_{$this->stockType}_make_model_year_trim",
			]
		];
	}

	protected function getSetting($ad_type, $type, $number, $campaign, $make, $model, $year, $trim)
	{
		if (isset($this->specialCampaigns[$campaign])) {
			$campaign_name = $this->specialCampaigns[$campaign]['name'];

			if (
				isset($this->{$type}[$ad_type][$campaign_name]) &&
				is_array($this->{$type}[$ad_type][$campaign_name]) &&
				isset($this->{$type}[$ad_type][$campaign_name][$number]) &&
				!empty($this->{$type}[$ad_type][$campaign_name][$number])
			) {
				return 	$this->{$type}[$ad_type][$campaign_name][$number];
			} else {
				return [""];
			}
		}
		$possible_keys = $this->possibleKeyss($make, $model, $year, $trim);

		$campaign_type = count(explode('_', $campaign)) - 1;

		$keys = $possible_keys[$campaign_type];

		foreach ($keys as $key) {
			if (
				isset($this->{$type}[$ad_type][$key]) &&
				is_array($this->{$type}[$ad_type][$key]) &&
				isset($this->{$type}[$ad_type][$key][$number]) &&
				!empty($this->{$type}[$ad_type][$key][$number])
			) {
				return 	$this->{$type}[$ad_type][$key][$number];
			}
		}

		return $ad_type == 'esa'
			? [self::$defaultSettings[$ad_type][substr($type, 0, 1) . $number]]
			: self::$defaultSettings[$ad_type][$this->stockType][$campaign][$type][$number];
	}

	protected function getCpc($campaign, $make, $model, $year, $trim, $default_bid = null)
	{
		$default_bid = $default_bid == null ? self::$defaultBid : $default_bid;
		$possible_keys = $this->possibleKeyss($make, $model, $year, $trim);

		$campaign_type = count(explode('_', $campaign)) - 1;

		$keys = $possible_keys[$campaign_type];

		foreach ($keys as $key) {
			if (isset($this->cpc[$key])) {
				return 	$this->cpc[$key];
			}
		}

		return $default_bid;
	}

	protected function createCombination($campaign, $vars = [], $take = 'first_last')
	{
		$make = isset($vars['make']) ? $vars['make'] : 'make';
		$model = isset($vars['model']) ? $vars['model'] : 'model';
		$year = isset($vars['year']) ? $vars['year'] : 'year';
		$trim = isset($vars['trim']) ? $vars['trim'] : 'trim';

		$titles = [];
		$descriptions = [];

		array_map(function ($v) use ($campaign, $make, $model, $year, $trim, &$titles) {
			$titles[$v] = $this->getSetting('esa', 'titles', $v, $campaign, $make, $model, $year, $trim);
		}, [1, 2, 3]);

		array_map(function ($v) use ($campaign, $make, $model, $year, $trim, &$descriptions) {
			$descriptions[$v] = $this->getSetting('esa', 'descriptions', $v, $campaign, $make, $model, $year, $trim);
		}, [1, 2]);

		$key = md5(json_encode([$titles, $descriptions]));

		if (isset($this->combinations[$key])) {
			return $this->combinations[$key];
		}

		$combinations = Utils::createCombination($titles[1], $titles[2]);
		$combinations = Utils::createCombination($combinations, $titles[3]);
		$combinations = Utils::createCombination($combinations, $descriptions[1]);
		$combinations = Utils::createCombination($combinations, $descriptions[2]);

		$this->combinations[$key] = $combinations;
		return $this->combinations[$key];
	}

	protected function mapModel($make, $model)
	{
		return isset($this->modelMap[$make]) && isset($this->modelMap[$make][$model]) ?  $this->modelMap[$make][$model] : $model;
	}

	protected function mapValue($source)
	{

		$target = $source;
		foreach ($source as $key => $value) {
			if (isset($this->valueMap[$key])) {
				if (isset($this->valueMap[$key][$value])) {
					$target[$key] = $this->valueMap[$key][$value];
				}
			}
		}
		return $target;
	}

	protected function generalCampaignKey($campaign_name_parts_count)
	{
		switch ($campaign_name_parts_count) {
			case 1:
				$campaign_name_parts[2] = 'make';
				break;
			case 2:
				$campaign_name_parts[2] = 'make';
				$campaign_name_parts[3] = 'model';
				break;
			case 3:
				$campaign_name_parts[2] = 'make';
				$campaign_name_parts[3] = 'model';
				$campaign_name_parts[4] = 'year';
				break;
			case 4:
				$campaign_name_parts[2] = 'make';
				$campaign_name_parts[3] = 'model';
				$campaign_name_parts[4] = 'year';
				$campaign_name_parts[5] = 'trim';
				break;
		}

		return implode('_', $campaign_name_parts);
	}

	/**
	 * getTemplatesFromCombination
	 *
	 * @param string $combination
	 * @param bool $is_srp
	 *
	 * @return string[]
	 */
	protected function getTemplatesFromCombination($combination, $is_srp)
	{
		return array_map(function ($t) use ($is_srp) {
			if (strpos($t, '<srp|vdp>') !== false) {
				$parts = explode('<srp|vdp>', $t);
				return $is_srp === true ? $parts[0] : $parts[1];
			} else {
				return $t;
			}
		},  explode('{||}', $combination));
	}

	/**
	 * generateAds
	 *
	 * @param string $campaign
	 * @param string $ad_group
	 * @param Collection $cars
	 * @param array $combinations
	 * @param array $rsa_data
	 */
	protected function generateAds($campaign, $ad_group, $cars, $combinations, $rsa_data)
	{
		switch (count(explode('_', $campaign))) {
			case 1:
				$campaign_type = 'make';
				break;
			case 2:
				$campaign_type = 'make_model';
				break;
			case 3:
				$campaign_type = 'make_model_year';
				break;
			case 4:
				$campaign_type = 'make_model_year_trim';
				break;
		}

		$ad_group = preg_replace('/\s+/', ' ', trim($ad_group));
		$ads = [];
		$invalidAds = [];

		$car_prices = $cars->map(function ($c) {
			$price = numarifyPrice($c->price);
			// If unable to get price value make it to large
			return $price == -1 ? 99999999 : $price;
		});



		$min_price = $car_prices->min();
		/* if($cars[0]['make'] == 'Kia' && $cars[0]['body_style'] == 'Sedan' && $cars[0]['year'] == 2021) {
			die(json_encode($min_price));
		} */
		$min_price_car = $min_price != 0 ? $cars[$car_prices->search($min_price)] : null;

		$car_biweeklies = $cars->map(function ($c) {
			$price = numarifyPrice($c->biweekly);
			return $price == -1 ? 0 : $price;
		});

		$min_biweekly = $car_biweeklies->min();

		$min_biweekly_car = $min_biweekly != 0 ? $cars[$car_biweeklies->search($min_biweekly)] : null;

		$biweekly_value = $min_biweekly_car ? butifyPrice($min_biweekly_car->price) : "";
		$selected_car = $min_price_car ? $min_price_car : $cars[0];
		$price_value = butifyPrice($selected_car->price);

		$template_values = array_merge(
			$selected_car->toArray(),
			[
				'car_models' => 'car_models',
				'stock_type' => $this->stockType,
				'model' => $this->mapModel($selected_car->make, $selected_car->model),
				'years' => $cars->pluck('year')->unique()->implode(', '),
				// 'price' => $price_value,
				'price' => $price_value == "$0.00" ? "" : $price_value,
				'biweekly' => $biweekly_value,
				'biweekly_or_price' => empty($biweekly_value) ? $price_value : "$biweekly_value bi-weekly",
				'lease_term' => str_replace(['months', 'Months'], ['Mths', 'Mths'], $selected_car->lease_term),
				'car_count' => count($cars),
			],
			$this->dealershipData
		);

		$template_values = $this->mapValue($template_values);

		$model_vars  = $cars->reduce(function ($all, $v) {
			$model = strtolower($v["model"]);
			$model_arr = explode(" ", $model);
			$all[implode("_", $model_arr)] = implode(" ", array_map(function ($s) {
				return ucfirst($s);
			}, $model_arr));
			return $all;
		}, []);

		$model_numbers = implode(', ', $model_vars);

		$replace_models = function ($models, $text, $length) {
			if (strpos($text, 'car_models') !== false) {
				$available_length = $length - 10;
				if (strlen($models) > $available_length) {
					$models = substr($models, 0, $available_length);
					$comma_pos = strpos(strrev($models), ',');
					if ($comma_pos !== false) {
						$models = substr($models, 0, - ($comma_pos + 1));
					}
				}
				$text = str_replace('car_models', $models, $text);
			}

			return $text;
		};

		if (count($cars) > 1) {
			if (isset($this->specialCampaigns[$campaign])) {
				$url_key = $this->specialCampaigns[$campaign]['name'];
			} else {
				$url_key = "smedia_{$this->stockType}_$campaign_type";
			}
			if (!isset($this->listingPageUrl[$url_key])) {
				$this->logger->error("Listing page url pattern doesn't exists for smedia_$url_key");
				return [];
			}
			$url = Utils::processTemplate($this->listingPageUrl[$url_key], $template_values);
		} else {
			$url = $cars[0]->url;
		}

		$template_values['url'] = $url;

		foreach ($combinations as $combination) {
			$combination_array = $this->getTemplatesFromCombination($combination, $template_values['car_count'] > 1);
			$ad = [];
			// If you change array key order, hash will be different
			$ad['title'] = $this->processTitle($combination_array[0], $template_values, 1);
			$ad['title_2'] = $this->processTitle($combination_array[1], $template_values, 2);
			$ad['title_3'] = $this->processTitle($combination_array[2], $template_values, 3);
			$description_template_and_var_prorities = Utils::templateVarPriorities($combination_array[3]);
			$ad['description'] = ucfirst($replace_models($model_numbers, Utils::processTemplate(
				$description_template_and_var_prorities['template'],
				$template_values,
				90,
				$description_template_and_var_prorities['priorities']
			), 90));
			$description_2_template_and_var_prorities = Utils::templateVarPriorities($combination_array[4]);
			$ad['description_2'] = ucfirst($replace_models($model_numbers, Utils::processTemplate(
				$description_2_template_and_var_prorities['template'],
				$template_values,
				90,
				$description_2_template_and_var_prorities['priorities']
			), 90));
			$ad['url'] = $this->processUrl($url);
			$ad['campaign'] = "smedia_{$this->stockType}_$campaign";
			$ad['ad_group'] = "{$ad_group} #{$this->version}";
			$ad['dealership'] = $this->dealership;

			$hash = $this->calculateAdHash($ad);

			$ad['stock_type'] = $this->stockType;
			$ad['ad_type'] = 'esa';
			$ad['hash'] = $hash;
			$ad['template_values'] = $template_values;
			$valid = $this->isValidAd($ad);
			if ($valid === true) {
				$ads[$hash] = $ad;
			} else {
				$invalidAds[] = ['reasons' => $valid, 'ad' => $ad];
			}
		}

		if (
			isset($rsa_data['titles']) &&
			!empty($rsa_data['titles']) &&
			isset($rsa_data['descriptions']) &&
			!empty($rsa_data['descriptions'])
		) {
			$template_processor = function ($max_len) use ($template_values, $replace_models, $model_numbers) {
				return function ($v, $k) use ($template_values, $max_len, $replace_models, $model_numbers) {
					return array_map(function ($_v) use ($k, $template_values, $max_len, $replace_models, $model_numbers) {
						$template_and_var_prorities = Utils::templateVarPriorities($_v);
						return (object)[
							'text'	=> ucfirst($replace_models($model_numbers, Utils::processTemplate(
								$template_and_var_prorities['template'],
								$template_values,
								$max_len,
								$template_and_var_prorities['priorities']
							), $max_len)),
							'position'	=> $k,
						];
					}, $v);
				};
			};
			$ad = [];
			// If you change array key order, hash will be different
			$ad['rsa_titles'] = collect($rsa_data['titles'])
				->map($template_processor(30))
				->flatten()
				->unique(function ($v) {
					return "{$v->text}{$v->position}";
				})
				->filter(function ($v) {
					return !empty($v->text);
				})
				->values()
				->toJson();

			$ad['rsa_descriptions'] = collect($rsa_data['descriptions'])
				->map($template_processor(90))
				->flatten()
				->unique(function ($v) {
					return "{$v->text}{$v->position}";
				})
				->filter(function ($v) {
					return !empty($v->text);
				})
				->values()
				->toJson();

			$ad['url'] = $this->processUrl($url);
			$ad['campaign'] = "smedia_{$this->stockType}_$campaign";
			$ad['ad_group'] = "{$ad_group} #{$this->version}";
			$ad['dealership'] = $this->dealership;

			$hash = $this->calculateAdHash($ad);
			$ad['stock_type'] = $this->stockType;
			$ad['ad_type'] = 'rsa';
			$ad['hash'] = $hash;
			$ad['template_values'] = $template_values;
			$valid = $this->isValidAd($ad);

			if ($valid === true) {
				$ads[$hash] = $ad;
			} else {
				$invalidAds[] = ['reasons' => $valid, 'ad' => $ad];
			}
		}

		if (!empty($invalidAds)) {
			$this->logger->warning("Invalid ads found", ['total' => count($invalidAds), 'data' => $invalidAds]);
		}

		return $ads;
	}

	private function isValidAd($ad)
	{
		$reasons = [];
		if ($ad['ad_type'] == 'esa') {
			if (strlen($ad['title']) > 30) {
				$reasons[] = "Headline 1 has more than 30 chars";
			}
			if (strlen($ad['title_2']) > 30) {
				$reasons[] = "Headline 2 has more than 30 chars";
			}
			if (strlen($ad['title_3']) > 30) {
				$reasons[] = "Headline 3 has more than 30 chars";
			}
			if (strlen($ad['description']) > 90) {
				$reasons[] = "Headline 1 has more than 90 chars";
			}
			if (strlen($ad['description_2']) > 90) {
				$reasons[] = "Headline 2 has more than 90 chars";
			}
		} else if ($ad['ad_type'] == 'rsa') {
			array_map(function ($v) use (&$reasons) {
				if (strlen($v->text) > 30) {
					$reasons[] = "Headline \"{$v->text}\" has more than 30 chars";
				}
			}, json_decode($ad['rsa_titles']));

			array_map(function ($v) use (&$reasons) {
				if (strlen($v->text) > 90) {
					$reasons[] = "Description \"{$v->text}\" has more than 90 chars";
				}
			}, json_decode($ad['rsa_descriptions']));
		}

		if (!empty($reasons)) return $reasons;

		return true;
	}


	protected function calculateAdHash($ad)
	{
		$utm = [];

		if (!empty($this->utmSource)) {
			$utm['utm_source'] = $this->utmSource;
		}
		if (!empty($this->utmMedium)) {
			$utm['utm_medium'] = $this->utmMedium;
		}
		if ($this->utmCampaign == true) {
			$utm['utm_campaign'] = $ad['campaign'];
		}

		return  md5(implode(' | ', $ad) .
			(count($utm) ? (' | ' . implode(' | ', $utm)) : '') .  " | {$this->adReset}");
	}

	protected function processUrl($url)
	{

		$temp_url = str_replace('>', '', str_replace('&amp;', '&', $url));
		$url = str_replace(' ', '%20', $temp_url);

		return $url;
	}

	protected function processTitle($template, $values, $type = 1)
	{
		if (empty($template)) {
			if ($type == 2) {
				$template = 'Book a Test Drive';
			} else if ($type == 3) {
				$template = 'View Prices, Deals and Offers';
			} else {
				$template = '[year(1)] [make(2)] [model]';
			}
		}

		$template_and_var_priorities = Utils::templateVarPriorities($template);
		$title = ucfirst(Utils::processTemplate(
			$template_and_var_priorities['template'],
			$values,
			30,
			$template_and_var_priorities['priorities']
		));

		if (strlen($title) > 30) {
			$title = ucfirst(Utils::processTemplate(
				$template,
				[
					'make' => $values['make'],
					'model' => $values['model'],
					'year' => $values['year'],
					'price' => ''
				]
			));
			if (strlen($title) > 30) {
				$title = ucfirst(Utils::processTemplate(
					$template,
					[
						'make' => $values['make'],
						'model' => $values['model'], 'year' => '', 'price' => ''
					]
				));
				if (strlen($title) > 30) {
					$title = ucfirst(Utils::processTemplate(
						$template,
						[
							'make' => $values['make'],
							'model' => '', 'year' => $values['year'], 'price' => ''
						]
					));
					if (strlen($title) > 30) {
						if (strlen($values['year'] . ' ' . $values['make'] . ' ' . $values['model']) <= 30) {
							$title = $values['year'] . ' ' . $values['make'] . ' ' . $values['model'];
						} else if (strlen($values['make'] . " " . $values["model"]) <= 30) {
							$title = $values['make'] . " " . $values["model"];
						} else if (strlen($values['make'] . " " . $values["year"]) <= 30) {
							$title = $values['year'] . " " . $values["make"];
						} else {
							$title = $values["make"];
						}
					}
				}
			}
		}

		return $title;
	}


	/* protected function findAffectedAdGroupes()
	{
		$this->affectedAdGroupes = [];
		foreach (array_merge($this->deletedAds, $this->newAds) as $hash => $ad) {
			if (!isset($this->affectedAdGroupes[$ad['campaign']])) {
				$this->affectedAdGroupes[$ad['campaign']] = [];
			}
			$this->affectedAdGroupes[$ad['campaign']][$ad['ad_group']] = true;
		}
	} */

	protected function possibleCampaignNames($type, $prefix = '', $exclude_pattern = '', $vars = [])
	{
		if (isset($this->specialCampaigns[$type])) {
			return [$type];
		}
		$make = isset($vars['make']) ? $vars['make'] : '';
		$model = isset($vars['model']) ? $vars['model'] : '';
		$year = isset($vars['year']) ? $vars['year'] : '';
		$trim = isset($vars['trim']) ? $vars['trim'] : '';

		$campaings = [
			'make' => [
				"$make",
				"make"
			],
			'make_model' => [
				"{$make}_$model",
				"make_$model",
				"{$make}_model",
				"make_model",
			],
			'make_model_year' => [
				"{$make}_{$model}_{$year}",
				"{$make}_{$model}_year",
				"make_{$model}_{$year}",
				"{$make}_model_{$year}",
				"make_{$model}_year",
				"{$make}_model_year",
				"make_model_{$year}",
				"make_model_year",
			],
			'make_model_year_trim' => [
				"{$make}_{$model}_{$year}_{$trim}",
				"{$make}_{$model}_{$year}_trim",
				"{$make}_{$model}_year_{$trim}",
				"{$make}_{$model}_year_trim",
				"make_{$model}_{$year}_{$trim}",
				"make_{$model}_{$year}_trim",
				"{$make}_model_{$year}_{$trim}",
				"{$make}_model_{$year}_trim",
				"make_{$model}_year_{$trim}",
				"make_{$model}_year_trim",
				"{$make}_model_year_{$trim}",
				"{$make}_model_year_trim",
				"make_model_{$year}_{$trim}",
				"make_model_{$year}_trim",
				"make_model_year_{$trim}",
				"make_model_year_trim",
			]
		];

		return array_reduce(
			$campaings[$type],
			function ($acc, $v) use ($prefix, $exclude_pattern) {
				$name = "$prefix$v";
				if (empty($exclude_pattern) || preg_match($exclude_pattern, $name) != 1) {
					$acc[] = $name;
				}
				return $acc;
			},
			[]
		);
	}

	public function generateCampaignAds($key_list, $cars, $vars = [], $cursor = 1, $skip = [], $db_keys = [], $valid_campaigns = [])
	{
		if (empty($valid_campaigns)) {
			$valid_campaigns = $this->validCampaigns;
		}

		if (empty($valid_campaigns)) {
			return;
		}

		// Base case for recursion: if $cursor greater than the total
		// number for key, recursion will stop
		if ($cursor > count($key_list)) {
			return;
		}

		if (empty($db_keys)) {
			$db_keys = $key_list;
		}

		$keys = array_slice($key_list, 0, $cursor);
		$last_key = $key_list[$cursor - 1];

		$groupBy = $db_keys[$cursor - 1];
		// Group by cars with last key
		$grouped_cars = $cars->where($groupBy, '!=', "")->groupBy($groupBy);

		foreach ($grouped_cars as $value => $current_cars) {
			// Some cars has no trim
			if (empty($value)) continue;
			$vars[$last_key] = $value;
			if (count($current_cars) > 0) {
				if (!in_array($last_key, $skip)) {
					$possible_campaigns = $this->possibleCampaignNames(implode('_', $keys), '', '', $vars);

					foreach ($possible_campaigns as $campaign_name) {
						$prefix = $this->campaignPrefix[$this->stockType];
						if (in_array($this->getFullCampaignName("$prefix$campaign_name"), $valid_campaigns)) {
							$rsa_setting = in_array('rsa', $this->adTypes) ? $this->getRsaSetting(implode('_', $keys), $vars) : [];
							$esa_combination = in_array('esa', $this->adTypes) ? $this->createCombination(implode('_', $keys), $vars) : [];
							/* die(json_encode(array_map(function ($v) {
								return explode('{||}', $v);
							}, $esa_combination))); */

							$make = isset($vars['make']) ? $vars['make'] : "";
							$model = isset($vars['model']) ? $vars['model'] : "";
							$year = isset($vars['year']) ? $vars['year'] : "";
							$trim = isset($vars['trim']) ? $vars['trim'] : "";
							$vars = $this->mapValue($vars);
							$group_name = implode(' ', $vars);
							$group_key = "$group_name #{$this->version}{||}smedia_{$this->stockType}_$campaign_name";
							$cpc_in_db = isset($this->publishedAdGroupes[$group_key]) ? $this->publishedAdGroupes[$group_key]->cpc : null;
							$this->groupCpc[$group_key] = $this->getCpc($campaign_name, $make, $model, $year, $trim, $cpc_in_db);
							$newAds = $this->generateAds($campaign_name, $group_name, $current_cars, $esa_combination, $rsa_setting);
							$this->allAds = array_merge($this->allAds, $newAds);
							break;
						} else {
							// $this->logger->debug("Not a valid v2 campaign $prefix$campaign_name");
						}
					}
				}

				$this->generateCampaignAds($key_list, $current_cars, $vars, $cursor + 1, $skip, $db_keys, $valid_campaigns);
			}
		}
	}

	public function loadPublishedCampaignKeywords($types = ['positive', 'negative'])
	{
		$all_kws = collect([]);
		if (!empty($this->campaignKeywordTableName)) {
			$db_kws = DB::table($this->campaignKeywordTableName)
				->where("dealership", "=", $this->dealership)
				->where("tag", "=", $this->tag)
				->whereIn('type', $types)->get();


			foreach ($db_kws as $keyword) {
				$hash = $this->keywordHash($keyword->type, $keyword->campaign, "", $keyword->text, $keyword->matchType);
				$all_kws[$hash] = [
					"campaign" => $keyword->campaign,
					"id" => $keyword->id,
					"campaign_id" => $keyword->campaign_id,
					"type" => $keyword->type,
					"matchType" => $keyword->matchType,
					"text" => $keyword->text,
				];
			}
		}

		return $all_kws;
	}
	public function prepareAllCampaignKeywords($types = ['positive', 'negative'])
	{
		$all_kws = collect([]);
		foreach ($this->keywords as $campaign => $ckws) {
			if (!in_array($this->getFullCampaignName($campaign), $this->validCampaigns)) {
				continue;
			}
			foreach ($ckws as $type => $tkws) {
				if (!in_array($type, $types)) {
					continue;
				}

				foreach ($tkws as $keyword) {
					$hash = $this->keywordHash($type, $campaign, "", $keyword["text"], $keyword["matchType"]);
					$all_kws[$hash] = [
						"campaign" => $campaign,
						"tag" => $this->tag,
						"id" => null,
						"campaign_id" => null,
						"type" => $type,
						"matchType" => $keyword["matchType"],
						"text" => $keyword["text"],
						"dealership" => $this->dealership,
					];
				}
			}
		}

		return $all_kws;
	}

	public function generateCampaigns()
	{
		$this->valueMap = [];
		$this->allAds = [];
		$this->groupKeywords = [];
		$this->deletedAds = [];
		$this->newAds = [];
		$this->loadConfigs();
		$this->loadKeywords();
		// $this->logger->info("Keywords loaded: ", $this->keywords);

		if ($this->disabled == true) {
			$this->logger->info("Disabled");
			return $this;
		}
		if (empty($this->cars)) {
			$this->logger->info("No car found");
			return $this;
		}

		$this->generateValidCampaignNames(false);
		$this->loadPublishedAd();

		$this->loadExistingGroupData();
		$this->generateCampaignAds(['make', 'model', 'year', 'trim'], $this->cars);

		foreach ($this->specialCampaigns as $campaign => $data) {
			$keys = explode('_', $campaign);
			$db_keys = array_map(function ($k) use ($data) {
				return isset($data['fields'][$k]) ? $data['fields'][$k] : $k;
			}, $keys);

			$cars = $this->cars;
			foreach ($data['car_filters'] as $key => $val) {
				if (is_array($val)) {
					$cars = $cars->whereIn($key, $val);
				} else {
					$cars = $cars->where($key, $val);
				}
			}

			$this->valueMap = $data['value_map'];
			$this->generateCampaignAds($keys, $cars, [], 1, array_slice($keys, 0, -1), $db_keys, [$this->getFullCampaignName($this->campaignPrefix[$this->stockType] . $campaign)]);
		}

		$this->deletedAds = array_diff_key($this->allPublishedAds, $this->allAds);
		$this->newAds = array_diff_key($this->allAds, $this->allPublishedAds);

		$campaign_keywords_type = [];

		if ($this->keywordOptions['campaign_positive'] == true) {
			$campaign_keywords_type[] = 'positive';
		}

		if ($this->keywordOptions['campaign_negative'] == true) {
			$campaign_keywords_type[] = 'negative';
		}

		$this->allCampaignKeywords = $this->prepareAllCampaignKeywords($campaign_keywords_type);
		$this->publishedCampaignKeywords = $this->loadPublishedCampaignKeywords(['negative']);
		$this->deletedCampaignKeywords = $this->publishedCampaignKeywords->diffKeys($this->allCampaignKeywords);
		$this->newCampaignKeywords =  $this->allCampaignKeywords->diffKeys($this->publishedCampaignKeywords);

		$this->allKeywords = collect([]);

		$this->totalAdsInGroups = array_reduce($this->allAds, function ($acc, $ad) {
			$group_key = "{$ad["ad_group"]}{||}{$ad["campaign"]}";
			$acc->put($group_key,  $acc->get($group_key, 0) + 1);
			return $acc;
		}, collect([]));

		foreach ($this->allAds as $ad) {
			$group_keywords = $this->getKeywords($ad["ad_group"], $ad["campaign"], $ad["template_values"]);
			foreach ($group_keywords as $type => $keywords) {
				foreach ($keywords as $keyword) {
					$hash = $this->keywordHash($type, $ad["campaign"], $ad["ad_group"], $keyword["text"], $keyword["matchType"]);
					$this->allKeywords[$hash] = isset($this->publishedKeywords[$hash]) ? $this->publishedKeywords[$hash] : [
						"campaign" => $ad["campaign"],
						"id" => null,
						"group_id" => null,
						"group_name" => $ad["ad_group"],
						"type" => $type,
						"matchType" => $keyword["matchType"],
						"text" => $keyword["text"],
					];
				}
			}
		}

		$this->newAdGroupes = $this->totalAdsInGroups
			->diffKeys($this->publishedAdGroupes)
			->keys()
			->map(function ($v) {
				$parts = explode("{||}", $v);
				return ["name" => $parts[0], "campaign" => $parts[1]];
			});

		$this->epmtyAdGroups = $this->publishedAdGroupes->diffKeys($this->totalAdsInGroups);
		$this->deletedKeywords = $this->publishedKeywords->diffKeys($this->allKeywords);
		$this->newKeywords = $this->allKeywords->diffKeys($this->publishedKeywords);


		$this->logger->info("------- StockType: {$this->stockType} -------", []);
		$this->logger->info("------- Tag: {$this->tag} -------", []);
		$this->logger->info('New ad group', ['total' => count($this->newAdGroupes)]);
		$this->logger->info('Empty group', ['total' => count($this->epmtyAdGroups)]);
		$this->logger->info('Total active group', ['total' => count($this->totalAdsInGroups->keys())]);

		$this->logger->info('Deleted ads', ['total' => count($this->deletedAds)]);
		$this->logger->info('New ads', ['total' => count($this->newAds)]);

		$this->logger->info('Deleted keywords', ['total' => count($this->deletedKeywords)]);
		$this->logger->info('New keywords', ['total' => count($this->newKeywords), 'positive' => $this->newKeywords->where('type', 'positive')->count(), 'negative' => $this->newKeywords->where('type', 'negative')->count()]);

		return $this;
	}

	/* public function saveAds($truncate = true, $table_name = 'tbl_adwords_ad')
	{
		$table = DB::table($table_name);
		if ($truncate == true) {
			$table->truncate();
		}
		$table->insert($this->allAds);
		return $this;
	} */

	protected function loadPublishedAd()
	{
		$adwordsAd = new AdModel();
		$query = $adwordsAd
			->setTable($this->tableName)
			->where('dealership', '=', $this->dealership)
			->where('stock_type', '=', $this->stockType)
			->where('tag', '=', $this->tag);


		$all_ads = $query->get()->toArray();
		$this->allPublishedAds = [];
		foreach ($all_ads as $ad) {
			$this->allPublishedAds[$ad['hash']]  = $ad;
		}
		$this->logger->info('Existing ads', ['total' => count($this->allPublishedAds)]);
	}

	protected function keywordHash($type, $campaign, $ad_group, $text, $match_type)
	{
		return  md5("$type $campaign $ad_group $text $match_type");
	}

	protected function loadExistingGroupData()
	{
		$get_group_id = function ($group) {
			return $this->serviceType == 'adwords' ? $group->adword_id : $group->bing_id;
		};
		$this->groupIds = collect([]);
		$this->publishedAdGroupes = collect([]);
		$this->publishedKeywords = collect([]);
		$query = DB::table("{$this->tableName}_group")
			->where('dealership', '=', $this->dealership)
			->where('campaign', 'LIKE', "smedia_{$this->stockType}%")
			->where('tag', '=', $this->tag);

		$groups = $query->get();
		if ($groups->isNotEmpty()) {
			$keywords = DB::table("{$this->keywordTableName}")
				->whereIn('group_id', $groups->map(function ($v) use ($get_group_id) {
					return $get_group_id($v);
				}))->get();

			if (!empty($keywords)) {
				$keywords = $keywords->groupBy('group_id');
			}

			foreach ($groups as $group) {
				$group_key = "{$group->name}{||}{$group->campaign}";
				$id_key = $this->serviceType == 'adwords' ? 'adword_id' : 'bing_id';
				$this->publishedAdGroupes->put($group_key, (object)[
					'name' => $group->name,
					'campaign' => $group->campaign,
					"$id_key" => $get_group_id($group),
					'active' => $group->active,
					'cpc' => $group->cpc,
				]);

				$this->groupIds->put($group_key, $get_group_id($group));

				if (!empty($keywords)) {
					foreach ($keywords->get($get_group_id($group), collect([]))->toArray() as $kw) {
						$hash = $this->keywordHash($kw->type, $group->campaign, $group->name, $kw->text, $kw->matchType);
						$this->publishedKeywords[$hash] = [
							"campaign" => $group->campaign,
							"id" => $kw->id,
							"group_id" => $get_group_id($group),
							"ad_group" => $group->name,
							"type" => $kw->type,
							"matchType" => $kw->matchType,
							"text" => $kw->text,
						];
					}
				}
			}
		}
	}

	protected function isInvalidKeyword($text)
	{
		// https://developers.google.com/adwords/api/docs/reference/v201809/AdGroupCriterionService.Keyword
		// https://support.google.com/google-ads/answer/7476658?visit_id=637169059312275833-2081946861&rd=1#symbol
		if (count(explode(' ', $text)) > 10) {
			return "Keyword has more than 10 word";
		}

		if (strlen($text) > 80) {
			return "Keyword has more than 80 characters";
		}

		$invalid_chars = '/[,!@%^()={};~`<>?\\\\|]/m';

		preg_match_all($invalid_chars, $text, $matches, PREG_SET_ORDER, 0);

		if (count($matches)) {
			$list = '';
			array_walk_recursive($matches, function ($val) use (&$list) {
				$list .= $val;
			});
			return "Keyword contain invalid_chars: $list";
		}
		return false;
	}

	protected function processKeywords($keywords, $template_values)
	{
		$processed = [];
		$invalid_list = [];
		foreach ($keywords as $keyword) {
			$text = Utils::processTemplate($keyword['text'], $template_values);
			$invalid_keyword = $this->isInvalidKeyword($text);
			if ($invalid_keyword) {
				$invalid_list[] = ["reason" => $invalid_keyword, "keyword" => $keyword, "values" => $template_values, "processed_text" => $text];
				// $this->logger->warning($invalid_keyword, ['processed_text' => $text, 'keyword' => $keyword]);
				continue;
			}
			$processed[] = [
				'text' => $text,
				'matchType' => $keyword['matchType']
			];
		}

		if (!empty($invalid_list)) {
			$this->logger->warning("Invalid keywords", ["total" => count($invalid_list)]);
		}
		return $processed;
	}

	protected function getKeywords($group_name, $campaign_name, $template_values)
	{
		if (isset($this->groupKeywords[$campaign_name][$group_name])) {
			return $this->groupKeywords[$campaign_name][$group_name];
		}

		$short_key = str_replace($this->campaignPrefix[$this->stockType], '', $campaign_name);

		$generale_campaign_key = "smedia_{$this->stockType}_" .
			in_array($short_key, $this->specialCampaigns)
			? $campaign_name
			: $this->generalCampaignKey(count(explode('_', $campaign_name)) - 2);

		$keywords_for_campaign = isset($this->keywords[$campaign_name]) ? $this->keywords[$campaign_name] : $this->keywords[$generale_campaign_key];

		foreach ($keywords_for_campaign as $type => $keywords) {
			$processed_keywords = $this->keywordOptions["group_$type"] == true
				? $this->processKeywords($keywords, $template_values)
				: [];
			if ($type == 'negative' && $this->keywordOptions['group_negative_year'] == true) {
				$processed_keywords = array_merge($processed_keywords, $this->getNegativeYearKeywords($template_values['year']));
			}
			$this->groupKeywords[$campaign_name][$group_name][$type] = $processed_keywords;
		}

		return $this->groupKeywords[$campaign_name][$group_name];
	}

	public function getFullCampaignName($short_name)
	{
		if (!empty($this->tag) && strpos($short_name, $this->tag) === false) {
			$full_name = "$short_name #{$this->tag}";
		} else {
			$full_name = $short_name;
		}

		if (strpos($short_name, $this->dealership) === false) {
			$full_name = str_replace("smedia_", "smedia_{$this->dealership}_", $full_name);
		}

		return $full_name;
	}

	public function getAltCampaignName($name)
	{
		return isset($this->altCampaignNames[$name]) ? $this->altCampaignNames[$name] : $name;
	}

	public function getOriginalCampaignName($name)
	{
		$original_names = array_flip($this->altCampaignNames);
		return isset($original_names[$name]) ? $original_names[$name] : $name;
	}

	/**
	 * getAdGroupId
	 *
	 * @param string $ad_group_name
	 * @param string $campaign_name
	 * @param string $campaign_id
	 * @param Closure $getter - function which will get the group id from ad service
	 * @param Closure $status_updater - function which will update ad group status
	 * @param Closure $creator - if not exist, this function will be used to create the ad group
	 * @param float $bid
	 */
	protected function getAdGroupId($ad_group_name, $campaign_name, $campaign_id, $getter, $status_updater = null, $creator = null, $bid = null)
	{
		$bid = $bid == null ? self::$defaultBid : $bid;
		$ad_group_id = null;
		$ad_groups = $getter($campaign_name, $ad_group_name);
		if ($ad_groups && count($ad_groups) > 0) {
			$ad_group = $ad_groups[0];
			if ($status_updater) {
				$status_updater($ad_group->id, true);
			}
			$ad_group_id = $ad_group->id;
			$this->logger->info("Ad group found: ", ["name" => $ad_group_name, "id" => $ad_group_id]);
		} else {
			$this->logger->info("Ad group not found: ", ["name" => $ad_group_name]);
			if ($creator) {
				$ad_group_id = $creator($campaign_id ? $campaign_id : $campaign_name, $ad_group_name, $bid);
				if ($ad_group_id) {
					$campaign_short_name = $this->getShortCampaignName($campaign_name);
					$key = "$ad_group_name{||}$campaign_short_name";
					$this->groupIds->put($key, $ad_group_id);
					$id_name = $this->serviceType == 'bing' ? 'bing_id' : 'adword_id';
					$group_data = [
						'name' => $ad_group_name,
						'campaign' => $campaign_short_name,
						$id_name => "$ad_group_id",
						'active' => 1,
						'dealership' => $this->dealership,
						'cpc' => $bid,
						'tag' => $this->tag,
					];
					$this->handleSqlError(function () use ($group_data) {
						DB::table("{$this->tableName}_group")->insert([$group_data]);
					});
					$this->logger->info("Ad group created: ", ["name" => $ad_group_name, "id" => $ad_group_id]);
				} else {
					$this->logger->info("Ad group can't be created: ", ["name" => $ad_group_name]);
				}
			}
		}

		return $ad_group_id;
	}

	protected function getShortCampaignName($full_name)
	{
		return str_replace(["_{$this->dealership}", " #{$this->tag}"], ['', ''], $full_name);
	}

	protected function getNegativeYearKeywords($year)
	{
		$year = intval($year);

		if (empty($year)) return [];

		if ($this->stockType === "new") {
			$year_negative_keywords = [];
			foreach ($this->year_negative_keywords as $current_year => $keyword) {
				if ($current_year == $year)
					break;
				$year_negative_keywords[] = $keyword;
			}
			return $year_negative_keywords;
		} else {
			$year_negative_keywords = $this->year_negative_keywords;
			unset($year_negative_keywords[$year]);
			return $year_negative_keywords;
		}
	}

	protected function handleSqlError($run, $on_error = null, $rethrow_code = [40001, "HY000"], $max_retry = 3)
	{
		return $this->handleError($run, $on_error, $rethrow_code, $max_retry);
	}

	protected function handleError($run, $on_error = null, $rethrow_code = [40001, "HY000"], $max_retry = 3)
	{
		$error_streak = 0;
		do {
			try {
				$handled = true;
				$r = $run();
			} catch (Exception $e) {
				$handled = false;
				$error_streak++;
				$code = $e->getCode();
				$this->logger->error("Sql error occured", [
					'code' => $code,
					'errorStreak' => $error_streak,
					'msg' => $e->getMessage(),
					'errorType' => get_class($e)
				]);

				if ($on_error != null) {
					$error_handlers = is_array($on_error) ? [$on_error] : $on_error;
					while (!$handled && !empty($error_handlers)) {
						$handler = array_shift($error_handlers);
						if (is_object($handler) && get_class($handler) == 'Closure') {
							$handled = $handler($e);
							if ($handled) {
								break;
							}
						}
					}
				}

				if (!$handled) {
					if (in_array($code, $rethrow_code)) {
						throw $e;
					}
					if ($error_streak > $max_retry) {
						throw $e;
					}
				}
			}
		} while (!$handled);

		return $r;
	}
}
