<?php

namespace sMedia\AdSync\Service;

use Exception;
use Microsoft\BingAds\Samples\V13\AuthHelper;
use Microsoft\BingAds\Samples\V13\BulkExampleHelper;
use Microsoft\BingAds\Samples\V13\CampaignManagementExampleHelper;
use Microsoft\BingAds\V13\Bulk\CampaignScope;
use Microsoft\BingAds\V13\Bulk\CompressionType;
use Microsoft\BingAds\V13\Bulk\DataScope;
use Microsoft\BingAds\V13\Bulk\DownloadEntity;
use Microsoft\BingAds\V13\Bulk\DownloadFileType;
use Microsoft\BingAds\V13\CampaignManagement\MatchType;
use Microsoft\BingAds\V13\CampaignManagement\Keyword;
use Microsoft\BingAds\V13\CampaignManagement\NegativeKeyword;
use Microsoft\BingAds\V13\CampaignManagement\AdGroup;
use Microsoft\BingAds\V13\CampaignManagement\AdGroupStatus;
use Microsoft\BingAds\V13\CampaignManagement\AdType;
use Microsoft\BingAds\V13\CampaignManagement\AssetLink;
use Microsoft\BingAds\V13\CampaignManagement\Bid;
use Microsoft\BingAds\V13\CampaignManagement\Budget;
use Microsoft\BingAds\V13\CampaignManagement\BudgetLimitType;
use Microsoft\BingAds\V13\CampaignManagement\Campaign;
use Microsoft\BingAds\V13\CampaignManagement\EntityNegativeKeyword;
use Microsoft\BingAds\V13\CampaignManagement\ExpandedTextAd;
use Microsoft\BingAds\V13\CampaignManagement\ResponsiveSearchAd;
use Microsoft\BingAds\V13\CampaignManagement\TextAsset;
use SoapVar;
use ZipArchive;

class BingAdService
{
	public $accountId;
	private $logger;
	private $log_file;
	private $errorSleep = 0;
	private $successfullBingRequest = 0;
	private $campaigns = [];
	private $adGroups = [];
	private $dry;
	public function __construct($account_id, \Monolog\Logger $logger, $dry = false)
	{
		$this->accountId = $account_id;
		$this->logger = $logger;
		$log_handler = $this->logger->getHandlers();
		$this->log_file = $log_handler[0]->getUrl();
		$this->dry = $dry;

		$this->authenticate();
		$logger->info("Initialized bing service for {$account_id}");
		$logger->info("system limits: ", posix_getrlimit());
	}

	private function authenticate()
	{
		// Just to increase debug speed in localhost
		if (!$this->dry) {
			AuthHelper::Authenticate($this->accountId, $this->log_file);
		}
	}

	public function setLogger(\Monolog\Logger $logger)
	{
		$this->logger = $logger;
	}

	private function handleError($run)
	{
		$error_streak = 0;
		do {
			unset($error);
			try {
				$existing_open_resources = get_resources('stream');
				$r = $run();
				$new_open_resources = array_diff(get_resources('stream'), $existing_open_resources);
				foreach ($new_open_resources as $rs) {
					// force closing open stream resources to avoid hang up after 1012 request.
					fclose($rs);
				}
				$this->successfullBingRequest++;
			} catch (Exception $e) {
				$error_streak++;
				$this->logger->error($e->getMessage(), ['errorType' => get_class($e), 'errorStreak' => $error_streak, 'successfullBingRequest' => $this->successfullBingRequest, 'code' => $e->getCode(), 'trace' => $e->getTrace()]);
				$error = true;
				if ($error_streak > 3) {
					throw new \Error($e->getMessage());
				}
				$this->logger->info("Pausing for " . ($this->errorSleep + $error_streak * 5) . "s");
				sleep($this->errorSleep + $error_streak * 5);
			}
		} while (isset($error) && !empty($error));

		return $r;
	}

	public function GetCampaigns()
	{
		if (empty($this->campaigns)) {
			$r = $this->handleError(function () {
				return CampaignManagementExampleHelper::GetCampaignsByAccountId(
					$this->accountId,
					null,
					null
				);
			});

			if (
				isset($r->Campaigns) &&
				isset($r->Campaigns->Campaign) &&
				is_array($r->Campaigns->Campaign)
			) {
				foreach ($r->Campaigns->Campaign as $campaign) {
					$this->campaigns[$campaign->Name] = (object) [
						'id' => $campaign->Id,
						'name' => $campaign->Name
					];
				}
			}
		}

		return $this->campaigns;
	}

	public function GetCampaign($name)
	{
		if (empty($this->campaigns)) {
			$this->GetCampaigns();
		}

		if (isset($this->campaigns[$name])) {
			return [$this->campaigns[$name]];
		}

		return [];
	}


	public function CreateBudget($name, $amount)
	{
		$budgets            = array();
		$budget             = new Budget();
		$budget->Amount     = $amount;
		$budget->BudgetType = BudgetLimitType::DailyBudgetStandard;
		$budget->Name       = $name;
		$budgets[]          = $budget;

		$r = $this->handleError(function () use ($budgets) {
			return CampaignManagementExampleHelper::AddBudgets(
				$budgets
			);
		});

		if (
			isset($r->BudgetIds) &&
			isset($r->BudgetIds->long) &&
			is_array($r->BudgetIds->long) &&
			isset($r->BudgetIds->long[0])
		) {
			return $r->BudgetIds->long[0];
		} else {
			$this->logger->error("Budget create error", [$r]);
			return null;
		}
	}


	public function CreateCampaign($name, $budget_id, $description = "Bing ads")
	{
		$campaigns              = array();
		$campaign               = new Campaign();
		//$campaign->CampaignType = CampaignType::Shopping;
		$campaign->Name         = $name;
		$campaign->Description  = $description;
		$campaign->BudgetId     = $budget_id;
		$campaign->BudgetType   = BudgetLimitType::DailyBudgetStandard;
		$campaign->DailyBudget  = 0.05;
		$campaign->Languages    = array("All");
		$campaign->TimeZone     = "PacificTimeUSCanadaTijuana";
		$campaigns[]            = $campaign;

		$r = $this->handleError(function () use ($campaigns) {
			return CampaignManagementExampleHelper::AddCampaigns(
				$this->accountId,
				$campaigns,
				false
			);
		});
		if (
			isset($r->CampaignIds) &&
			isset($r->CampaignIds->long) &&
			is_array($r->CampaignIds->long) &&
			isset($r->CampaignIds->long[0])
		) {
			if (empty($this->campaigns)) {
				$this->GetCampaigns();
			}
			$this->campaigns[$name] = (object) [
				'id' => $r->CampaignIds->long[0],
				'name' => $name
			];
			return $r->CampaignIds->long[0];
		} else {
			$this->logger->error("Campaign create error", [$r]);
			return null;
		}
	}

	/**
	 * SetCampaignNegativeKeywords
	 *
	 * @param int|string $campaign_id
	 * @param [][] $keywords Allowed aatchTypes are EXACT and PRASE. Example: [['matchType' => 'EXACT', 'text' => 'Keyword Text'], ['matchType' => 'PHRASE', 'text' => 'Another Keyword Text']]
	 */
	public function SetCampaignNegativeKeywords($campaign_id, $keywords)
	{
		$negativeKeywords = [];
		$kws = [];
		foreach ($keywords as $keyword) {
			$negativeKeyword                = new NegativeKeyword();
			if ($keyword['matchType'] == 'EXACT') {
				$negativeKeyword->MatchType     = MatchType::Exact;
			} else if ($keyword['matchType'] == 'PHRASE') {
				$negativeKeyword->MatchType     = MatchType::Phrase;
			} else if ($keyword['matchType'] == 'BROAD') {
				$this->logger->warning("BROAD keywords is not allowed in negative campaign kewords");
				continue;
			}
			$kws[] = $keyword;
			$negativeKeyword->Text          = $keyword['text'];
			$negativeKeywords[] = $negativeKeyword;
		}
		$created_keywords = $kws;
		$entityNegativeKeyword                      = new EntityNegativeKeyword();
		$entityNegativeKeyword->EntityId            = $campaign_id;
		$entityNegativeKeyword->EntityType          = "Campaign";
		$entityNegativeKeyword->NegativeKeywords    = $negativeKeywords;
		$r = $this->handleError(function () use ($entityNegativeKeyword) {
			return CampaignManagementExampleHelper::AddNegativeKeywordsToEntities(
				array($entityNegativeKeyword)
			);
		});

		if (
			isset($r->NegativeKeywordIds) &&
			isset($r->NegativeKeywordIds->IdCollection) &&
			is_array($r->NegativeKeywordIds->IdCollection)
		) {
			foreach ($r->NegativeKeywordIds->IdCollection as $ids) {
				if (
					isset($ids->Ids) &&
					isset($ids->Ids->long) &&
					is_array($ids->Ids->long)
				) {
					foreach ($ids->Ids->long as $i => $id) {
						if ($id === null) {
							unset($created_keywords[$id]);
						} else {
							$created_keywords[$i]['id'] = $id;
							$created_keywords[$i]['campaign_id'] = $campaign_id;
						}
					}
				}
			}
		}

		if (
			isset($r->NestedPartialErrors) &&
			isset($r->NestedPartialErrors->BatchErrorCollection) &&
			is_array($r->NestedPartialErrors->BatchErrorCollection)
		) {
			foreach ($r->NestedPartialErrors->BatchErrorCollection as $errs) {
				if (
					isset($errs->BatchErrors)
					&& isset($errs->BatchErrors->BatchError) &&
					is_array($errs->BatchErrors->BatchError)

				) {
					foreach ($errs->BatchErrors->BatchError as $e) {
						$i = intval($e->Index);
						switch ($e->Message) {
							case "Duplicate negative keyword are not allowed.":
								$this->logger->error("Keyword already exists", [$kws[$i]]);
								break;
							default:
								$this->logger->error("Can't create a positive keyword", [$kws[$i], $e]);
								break;
						}
						if (isset($created_keywords[$i])) {
							unset($created_keywords[$i]);
						}
					}
				}
			}
		}

		return $created_keywords;
	}

	public function GetGroupNegativeKeywords($campaign_id, $group_id)
	{
		$r = $this->handleError(function () use ($group_id, $campaign_id) {
			return CampaignManagementExampleHelper::GetNegativeKeywordsByEntityIds(
				[$group_id],
				"AdGroup",
				$campaign_id
			);
		});
		if (
			isset($r->EntityNegativeKeywords) &&
			isset($r->EntityNegativeKeywords->EntityNegativeKeyword) &&
			is_array($r->EntityNegativeKeywords->EntityNegativeKeyword) &&
			!empty($r->EntityNegativeKeywords->EntityNegativeKeyword)
		) {
			return $r->EntityNegativeKeywords->EntityNegativeKeyword;
		}

		return null;
	}

	public function SetGroupNegativeKeywords($group_id, $keywords)
	{
		$negativeKeywords = [];
		$kws = [];
		foreach ($keywords as $keyword) {
			$negativeKeyword                = new NegativeKeyword();
			if ($keyword['matchType'] == 'EXACT') {
				$negativeKeyword->MatchType     = MatchType::Exact;
			} else if ($keyword['matchType'] == 'PHRASE') {
				$negativeKeyword->MatchType     = MatchType::Phrase;
			} else if ($keyword['matchType'] == 'BROAD') {
				$this->logger->warning("Broad negative keyword is not allowed");
				continue;
			}
			$kws[] = $keyword;
			$negativeKeyword->Text          = $keyword['text'];
			$negativeKeywords[] = $negativeKeyword;
		}
		$created_keywords = $kws;
		$entityNegativeKeyword                      = new EntityNegativeKeyword();
		$entityNegativeKeyword->EntityId            = $group_id;
		$entityNegativeKeyword->EntityType          = "AdGroup";
		$entityNegativeKeyword->NegativeKeywords    = $negativeKeywords;
		$r = $this->handleError(function () use ($entityNegativeKeyword) {
			return CampaignManagementExampleHelper::AddNegativeKeywordsToEntities(
				array($entityNegativeKeyword)
			);
		});

		if (
			isset($r->NegativeKeywordIds) &&
			isset($r->NegativeKeywordIds->IdCollection) &&
			is_array($r->NegativeKeywordIds->IdCollection)
		) {
			foreach ($r->NegativeKeywordIds->IdCollection as $ids) {
				if (
					isset($ids->Ids) &&
					isset($ids->Ids->long) &&
					is_array($ids->Ids->long)
				) {
					foreach ($ids->Ids->long as $i => $id) {
						if ($id === null) {
							unset($created_keywords[$i]);
						} else {
							$created_keywords[$i]['id'] = $id;
						}
					}
				}
			}
		} else if (
			isset($r->NestedPartialErrors) &&
			isset($r->NestedPartialErrors->BatchErrorCollection) &&
			is_array($r->NestedPartialErrors->BatchErrorCollection)
		) {
			foreach ($r->NestedPartialErrors->BatchErrorCollection as $errs) {
				if (
					isset($errs->BatchErrors)
					&& isset($errs->BatchErrors->BatchError) &&
					is_array($errs->BatchErrors->BatchError)

				) {
					foreach ($errs->BatchErrors->BatchError as $e) {
						$i = intval($e->Index);
						switch ($e->Message) {
							case "A keyword with the specified match type already exists.":
								$this->logger->error("Keyword already exists", [$kws[$i]]);
								break;
							default:
								$this->logger->error("Can't create a negative keyword", [$kws[$i], $e]);
								break;
						}

						if (isset($created_keywords[$i])) {
							unset($created_keywords[$i]);
						}
					}
				}
			}
		} else {
			throw new Exception("Can not set ad group keyword: group id <$group_id> error: <" . json_encode($r) . ">");
		}

		return $created_keywords;
	}

	public function GetAdGroups($campaign_name)
	{
		$this->logger->debug("Getting ad groups for $campaign_name");
		$this->adGroups[$campaign_name] = [];
		$campaign = $this->GetCampaign($campaign_name);

		if (empty($campaign) || !is_array($campaign) || !isset($campaign[0]) || !isset($campaign[0]->id)) {
			$this->logger->warning("Campaign not found '$campaign_name'");
		}

		$r = $this->handleError(function () use ($campaign) {
			return CampaignManagementExampleHelper::GetAdGroupsByCampaignId($campaign[0]->id);
		});

		if (isset($r->AdGroups)) {
			$AdGroups       =   $r->AdGroups;
			if (!empty((array) $AdGroups) && isset($AdGroups->AdGroup)) {
				$AdGroup    =   $AdGroups->AdGroup;
				foreach ($AdGroup as $adgroup_data) {
					$this->adGroups[$campaign_name][strtolower($adgroup_data->Name)]  =  (object) [
						'id' => $adgroup_data->Id,
						'name' => $adgroup_data->Name,
						'data' => $adgroup_data,
					];
				}
			}
		}

		return $this->adGroups[$campaign_name];
	}

	public function GetAdGroup($campaign_name, $ad_group_name)
	{
		$ad_group_name = strtolower($ad_group_name);
		$this->GetAdGroups($campaign_name);
		if (
			isset($this->adGroups[$campaign_name]) &&
			isset($this->adGroups[$campaign_name][$ad_group_name])
		) {
			return [$this->adGroups[$campaign_name][$ad_group_name]];
		}

		return null;
	}

	public function CreateAdGroup($campaign_name, $ad_group_name, $default_bid = .1)
	{
		$campaign = $this->GetCampaign($campaign_name);
		if (empty($campaign)) {
			$this->logger->warning("Ad Group create failed because campaign not found $campaign_name");
			return null;
		}
		$adGroup            = new AdGroup();
		$adGroup->CpcBid    = new Bid();
		$adGroup->CpcBid->Amount = $default_bid;
		date_default_timezone_set('UTC');
		$adGroup->EndDate = null;
		$adGroup->Name = $ad_group_name;
		$adGroup->Status = AdGroupStatus::Active;
		$adGroup->StartDate = null;
		$r = $this->handleError(function () use ($campaign, $adGroup) {
			return CampaignManagementExampleHelper::AddAdGroups(
				$campaign[0]->id,
				[$adGroup],
				null
			);
		});

		if (
			isset($r->AdGroupIds) &&
			isset($r->AdGroupIds->long) &&
			is_array($r->AdGroupIds->long) &&
			isset($r->AdGroupIds->long[0])
		) {
			if (!isset($this->adGroups[$campaign_name])) {
				$this->GetAdGroups($campaign_name);
			}
			if (isset($this->adGroups[$campaign_name])) {
				$this->adGroups[$campaign_name][$ad_group_name] = (object) [
					'id' => $r->AdGroupIds->long[0],
					'name' => $ad_group_name
				];
			}
			return $r->AdGroupIds->long[0];
		} else {
			$this->logger->error("Ad group create error: $ad_group_name in $campaign_name", [$r]);
			return null;
		}
	}

	public function UpdateAdGroupBid($campaign_id, $group_data, $bid)
	{
		$group = new AdGroup();
		$group->Id = $group_data->Id;
		$group->CpcBid = new Bid();
		$group->CpcBid->Amount = $bid;

		$this->logger->debug("Update bid request", [$group]);

		$r = $this->handleError(function () use ($campaign_id, $group) {
			$groups = [$group];
			return CampaignManagementExampleHelper::UpdateAdGroups($campaign_id, $groups, true, true);
		});

		if (isset($r->PartialErrors) && isset($r->PartialErrors->BatchError)) {
			$this->logger->error("Update bid error campaign: $campaign_id, group id $group_data->Id", [$r->PartialErrors]);
			return false;
		}
		return true;
	}

	public function CreateResponsiveSearchAds($ad_data)
	{
		$make_asset = function ($positions) {
			return function ($v) use ($positions) {
				$asset = new TextAsset();
				$asset->Text = $v->text;
				$assetLink = new AssetLink();
				$assetLink->Asset = new SoapVar(
					$asset,
					SOAP_ENC_OBJECT,
					'TextAsset',
					$GLOBALS['CampaignManagementProxy']->GetNamespace()
				);
				if ($v->position != 0) {
					$assetLink->PinnedField = $positions[$v->position];
				}
				return  $assetLink;
			};
		};

		$headline_assets = array_map($make_asset(['NONE', 'Headline1', 'Headline2', 'Headline3']), $ad_data->ad["titles"]);
		$description_assets = array_map($make_asset(['NONE', 'Description1', 'Description2']), $ad_data->ad["descriptions"]);

		$ad       = new ResponsiveSearchAd();
		$ad->Headlines = $headline_assets;
		$ad->Descriptions = $description_assets;
		$ad->FinalUrls = $ad_data->ad['urls'];

		$ads[] = new SoapVar(
			$ad,
			SOAP_ENC_OBJECT,
			'ResponsiveSearchAd',
			$GLOBALS['CampaignManagementProxy']->GetNamespace()
		);

		return $this->_CreatAd($ad_data->adGroupId, $ads);
	}

	public function CreateAd($ad_group_id, $ad_url, $title_1, $title_2, $title_3, $text_1, $text_2)
	{
		$ads                        = array();
		$expandedTextAd             = new ExpandedTextAd();
		$expandedTextAd->TitlePart1 = $title_1;
		$expandedTextAd->TitlePart2 = $title_2;
		$expandedTextAd->TitlePart3 = $title_3;
		$expandedTextAd->Text       = $text_1;
		$expandedTextAd->TextPart2  = $text_2;
		$expandedTextAd->Path1      = "";
		$expandedTextAd->Path2      = "";
		$expandedTextAd->FinalUrls  = array($ad_url);
		$ads[] = new SoapVar(
			$expandedTextAd,
			SOAP_ENC_OBJECT,
			'ExpandedTextAd',
			$GLOBALS['CampaignManagementProxy']->GetNamespace()
		);

		return $this->_CreatAd($ad_group_id, $ads);
	}

	private function _CreatAd($ad_group_id, $ads)
	{
		$r = $this->handleError(function () use ($ad_group_id, $ads) {
			return CampaignManagementExampleHelper::AddAds(
				$ad_group_id,
				$ads
			);
		});

		if (
			isset($r->AdIds) &&
			isset($r->AdIds->long) &&
			is_array($r->AdIds->long) &&
			isset($r->AdIds->long[0]) &&
			$r->AdIds->long[0] != null
		) {
			return $r->AdIds->long[0];
		} else {
			$this->logger->error("Ad create error", [$r]);
			return null;
		}
	}

	/**
	 * GetAds
	 *
	 * @param string|int $group_id
	 * @param string[] $types
	 * @return array
	 */
	public function GetAds($group_id, $types = [AdType::ExpandedText, AdType::ResponsiveSearch])
	{
		$r = $this->handleError(function () use ($group_id, $types) {
			return CampaignManagementExampleHelper::GetAdsByAdGroupId(
				$group_id,
				$types,
				''
			);
		});

		if (
			isset($r->Ads) &&
			isset($r->Ads->Ad) &&
			is_array($r->Ads->Ad)
		) {
			return $r->Ads->Ad;
		} else {
			return [];
		}
	}

	/**
	 * RemoveAd
	 *
	 * @param string $ad_group_id
	 * @param string[] $ad_ids
	 */
	public function RemoveAd($ad_group_id, $ad_ids)
	{
		$r = $this->handleError(function () use ($ad_group_id, $ad_ids) {
			$this->logger->info("Removing ", [$ad_group_id, $ad_ids]);
			return CampaignManagementExampleHelper::DeleteAds(
				$ad_group_id,
				$ad_ids
			);
		});
		return $r;
	}

	public function SetAdGroupKeywords($ad_group_id, $keywords, $bid = 7)
	{
		$newKeywords = [];
		$created_keywords = $keywords;
		foreach ($keywords as $keyword) {
			$newKeyword                = new Keyword();
			if ($keyword['matchType'] == 'EXACT') {
				$newKeyword->MatchType     = MatchType::Exact;
			} else if ($keyword['matchType'] == 'PHRASE') {
				$newKeyword->MatchType     = MatchType::Phrase;
			} else if ($keyword['matchType'] == 'BROAD') {
				$newKeyword->MatchType     = MatchType::Broad;
			}
			$newKeyword->Bid           = new Bid();
			$newKeyword->Bid->Amount   = $bid;
			$newKeyword->Text          = $keyword['text'];
			$newKeywords[] = $newKeyword;
		}
		$r = $this->handleError(function () use ($ad_group_id, $newKeywords) {
			return CampaignManagementExampleHelper::AddKeywords(
				$ad_group_id,
				$newKeywords,
				null
			);
		});

		if (isset($r->KeywordIds) && isset($r->KeywordIds->long)) {
			foreach ($r->KeywordIds->long as $i => $id) {
				if ($id === null) {
					unset($created_keywords[$i]);
				} else {
					$created_keywords[$i]['id'] = $id;
				}
			}
		} else if (isset($r->PartialErrors) && isset($r->PartialErrors->BatchError) && is_array($r->PartialErrors->BatchError)) {
			foreach ($r->PartialErrors->BatchError as $e) {
				$i = intval($e->Index);
				switch ($e->Message) {
					case "A keyword with the specified match type already exists.":
						$this->logger->error("Keyword already exists", [$keywords[$i]]);
						break;
					default:
						$this->logger->error("Can't create a positive keyword", [$keywords[$i], $e]);
						break;
				}
				if (isset($created_keywords[$i])) {
					unset($created_keywords[$i]);
				}
			}
		} else {
			throw new Exception("Can not set ad group keyword: group id <$ad_group_id> error: <" . json_encode($r) . ">");
		}

		return $created_keywords;
	}

	/**
	 * DownloadCampaignsByCampaignIds - request a campaign data csv
	 *
	 * @param int[] $ids
	 * @param int|string $acc_id
	 */
	public function DownloadCampaignsByCampaignIds($ids, $acc_id)
	{
		$time = new \DateTime('now');
		$time = $time->format('c');
		$sids = array_map(function ($v) use ($acc_id) {
			$scope = new CampaignScope();
			$scope->CampaignId = $v;
			$scope->ParentAccountId = $acc_id;
			return $scope;
		}, $ids);


		$download = BulkExampleHelper::DownloadCampaignsByCampaignIds(
			$sids,
			CompressionType::Zip,
			DataScope::EntityData,
			[
				DownloadEntity::Campaigns,
				DownloadEntity::AdGroups,
				DownloadEntity::Ads,
				DownloadEntity::Keywords,
				DownloadEntity::AdGroupNegativeKeywords,
				DownloadEntity::CampaignNegativeKeywords,
			],
			DownloadFileType::Csv,
			"6.0",
			null
		);

		if (isset($download->DownloadRequestId)) {
			return $download->DownloadRequestId;
		}

		return null;
	}

	/**
	 * GetReportUrl
	 *
	 * @param int $req_id
	 */
	function GetReportUrl($req_id)
	{
		$data = BulkExampleHelper::GetBulkDownloadStatus($req_id);
		if (isset($data->ResultFileUrl)) {
			return $data->ResultFileUrl;
		} else {
			return null;
		}
	}

	/**
	 * DownloadFile
	 *
	 * @param string $downloadUrl
	 * @param string $downloadPath
	 */
	function DownloadFile($downloadUrl, $downloadPath)
	{
		if (empty($downloadUrl)) return false;
		if (!$reader = fopen($downloadUrl, 'rb')) {
			throw new Exception("Failed to open URL " . $downloadUrl . ".");
		}

		if (!$writer = fopen($downloadPath, 'wb')) {
			fclose($reader);
			throw new Exception("Failed to create ZIP file " . $downloadPath . ".");
		}

		$bufferSize = 100 * 1024;

		while (!feof($reader)) {
			if (false === ($buffer = fread($reader, $bufferSize))) {
				fclose($reader);
				fclose($writer);
				throw new Exception("Read operation from URL failed.");
			}

			if (fwrite($writer, $buffer) === false) {
				fclose($reader);
				fclose($writer);
				throw new Exception("Write operation to ZIP file failed.");
			}
		}

		fclose($reader);
		fflush($writer);
		fclose($writer);
		return true;
	}


	/**
	 * GetCsv
	 * Get array from csv.
	 * @param string $fromZipArchive - zip file path
	 *
	 * # Usage
	 * ```php
	 *  $req_id = $bingService->DownloadCampaignsByCampaignIds(
	 *		[287717249, 287717250],
	 *		$CronConfigs[$single_config]['bing_account_id']
	 *  );
	 *	if ($req_id) {
	 *		$dl_path = Conf::DATA_DIR . "/bing_data.zip";
	 *		$report_urle = $bingService->GetReportUrl($req_id);
	 *		if ($bingService->DownloadFile($report_urle, $dl_path)) {
	 *			$values = $bingService->GetCsv($dl_path);
	 *			print_r($values);
	 *		}
	 *	}
	 *	```
	 */

	function GetCsv($fromZipArchive)
	{
		$archive = new ZipArchive();
		$values = [];
		// $archive->open(__DIR__ . "/bing_data.zip");
		if ($archive->open($fromZipArchive) === TRUE) {
			$c = $archive->getNameIndex(0, ZipArchive::FL_UNCHANGED);
			$d = $archive->getStream($c);
			$keys = fgetcsv($d);
			$type_field = $keys[0];
			$parse_next = true;
			while ($parse_next) {
				$vals = fgetcsv($d);
				if ($vals) {
					$line_array = array_combine($keys, $vals);
				} else {
					$parse_next = false;
				}

				if (!isset($values[$line_array[$type_field]])) {
					$values[$line_array["﻿Type"]] = [];
				}

				$values[$line_array[$type_field]][] = array_filter($line_array);

				/* if (!in_array($line_array[$type_field], [
					'Campaign',
					'Campaign Negative Keyword',
					'Ad Group',
					'Keyword',
					'Expanded Text Ad',
					'Ad Group Negative Keyword',
				])) {
					$parse_next = false;
				} */
			}

			// $archive->extractTo(dirname($toExtractedFile));
			fclose($d);
			$archive->close();
			return $values;
		} else {
			throw new Exception("Decompress operation from ZIP file failed.");
		}
		return [];
	}


	public function GetKeywords($ad_group_id, $ids_only = true)
	{
		$r = $this->handleError(function () use ($ad_group_id) {
			return CampaignManagementExampleHelper::GetKeywordsByAdGroupId(
				$ad_group_id
			);
		});

		if (
			isset($r->Keywords) &&
			isset($r->Keywords->Keyword) &&
			is_array($r->Keywords->Keyword) &&
			!empty($r->Keywords->Keyword)
		) {
			if ($ids_only == true) {
				$ids = [];
				foreach ($r->Keywords->Keyword as $keyword) {
					$ids[] = $keyword->Id;
				}
				return $ids;
			}
			return $r->Keywords->Keyword;
		}

		return null;
	}

	public function RemoveKeywords($ad_group_id, $keyword_ids)
	{
		$deleted_keywords = $keyword_ids;
		$r = $this->handleError(function () use ($ad_group_id, $keyword_ids) {
			return CampaignManagementExampleHelper::DeleteKeywords(
				$ad_group_id,
				$keyword_ids
			);
		});

		if (isset($r->PartialErrors) && isset($r->PartialErrors->BatchError) && is_array($r->PartialErrors->BatchError)) {
			foreach ($r->PartialErrors->BatchError as $e) {
				$i = intval($e->Index);
				$this->logger->error("Can't delete a positive keyword id: {$deleted_keywords[$i]}", (array)$e);
				if (isset($deleted_keywords[$i])) {
					unset($deleted_keywords[$i]);
				}
			}
		}

		return $deleted_keywords;
	}

	/**
	 * GetCampaignNegativeKeywords
	 *
	 * @param int|string $campaign_id
	 */
	public function GetCampaignNegativeKeywords($campaign_id)
	{
		$r = $this->handleError(function () use ($campaign_id) {
			return CampaignManagementExampleHelper::GetNegativeKeywordsByEntityIds(
				[$campaign_id],
				"Campaign",
				null
			);
		});
		if (
			isset($r->EntityNegativeKeywords) &&
			isset($r->EntityNegativeKeywords->EntityNegativeKeyword) &&
			is_array($r->EntityNegativeKeywords->EntityNegativeKeyword) &&
			!empty($r->EntityNegativeKeywords->EntityNegativeKeyword)
		) {
			return $r->EntityNegativeKeywords->EntityNegativeKeyword;
		} else {
			$this->logger->error("Can not get negative keyword for $campaign_id", [$r]);
		}

		return null;
	}

	public function RemoveGroupNegativeKeywords($group_id, $keyword_ids)
	{
		$entityNegativeKeyword = new EntityNegativeKeyword();
		$entityNegativeKeyword->EntityId = $group_id;
		$entityNegativeKeyword->EntityType = 'AdGroup';
		$entityNegativeKeyword->NegativeKeywords = [];
		$deleted_keywords = $keyword_ids;
		foreach ($keyword_ids as $kid) {
			$nk = new NegativeKeyword();
			$nk->Id = $kid;
			$entityNegativeKeyword->NegativeKeywords[] = $nk;
		}

		$r = $this->handleError(function () use ($entityNegativeKeyword) {
			return CampaignManagementExampleHelper::DeleteNegativeKeywordsFromEntities(
				[$entityNegativeKeyword]
			);
		});

		if (
			isset($r->NestedPartialErrors) &&
			isset($r->NestedPartialErrors->BatchErrorCollection) &&
			is_array($r->NestedPartialErrors->BatchErrorCollection)
		) {
			foreach ($r->NestedPartialErrors->BatchErrorCollection as $errs) {
				if (
					isset($errs->BatchErrors)
					&& isset($errs->BatchErrors->BatchError) &&
					is_array($errs->BatchErrors->BatchError)

				) {
					foreach ($errs->BatchErrors->BatchError as $e) {
						$i = intval($e->Index);
						$this->logger->error("Can't delete a negative keyword id: {$deleted_keywords[$i]}", (array)$e);
						if (isset($deleted_keywords[$i])) {
							unset($deleted_keywords[$i]);
						}
					}
				}
			}
		}

		return $deleted_keywords;
	}

	public function RemoveCampaignNegativeKeywords($campaign_id, $keyword_ids)
	{
		$entityNegativeKeyword = new EntityNegativeKeyword();
		$entityNegativeKeyword->EntityId = $campaign_id;
		$entityNegativeKeyword->EntityType = 'Campaign';
		$entityNegativeKeyword->NegativeKeywords = [];
		$deleted_keywords = $keyword_ids;

		foreach ($keyword_ids as $kid) {
			$nk = new NegativeKeyword();
			$nk->Id = $kid;
			$entityNegativeKeyword->NegativeKeywords[] = $nk;
		}

		$r = $this->handleError(function () use ($entityNegativeKeyword) {
			return CampaignManagementExampleHelper::DeleteNegativeKeywordsFromEntities(
				[$entityNegativeKeyword]
			);
		});

		if (
			isset($r->NestedPartialErrors) &&
			isset($r->NestedPartialErrors->BatchErrorCollection) &&
			is_array($r->NestedPartialErrors->BatchErrorCollection)
		) {
			foreach ($r->NestedPartialErrors->BatchErrorCollection as $errs) {
				if (
					isset($errs->BatchErrors)
					&& isset($errs->BatchErrors->BatchError) &&
					is_array($errs->BatchErrors->BatchError)

				) {
					foreach ($errs->BatchErrors->BatchError as $e) {
						$i = intval($e->Index);
						$this->logger->error("Can't delete a negative keyword id: {$deleted_keywords[$i]}", (array)$e);
						if (isset($deleted_keywords[$i])) {
							unset($deleted_keywords[$i]);
						}
					}
				}
			}
		}

		return $deleted_keywords;
	}
}
