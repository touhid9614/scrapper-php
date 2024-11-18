<?php

//namespace Microsoft\BingAds\Samples\V13;

// For more information about installing and using the Bing Ads PHP SDK,
// see https://go.microsoft.com/fwlink/?linkid=838593.

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

include __DIR__ . "/V13/AuthHelper.php";
include __DIR__ . "/V13/CampaignManagementExampleHelper.php";
include __DIR__ . "/V13/ReportingExampleHelper.php";

//use SoapVar;
//use SoapFault;
//use Exception;

//Specify the Microsoft\BingAds\V13\CampaignManagement classes that will be used.
use Microsoft\BingAds\Samples\V13\AuthHelper;
use Microsoft\BingAds\Samples\V13\CampaignManagementExampleHelper;
use Microsoft\BingAds\Samples\V13\ReportingExampleHelper;
use Microsoft\BingAds\V13\CampaignManagement\AdGroup;
use Microsoft\BingAds\V13\CampaignManagement\AdGroupStatus;
use Microsoft\BingAds\V13\CampaignManagement\AssetLink;
use Microsoft\BingAds\V13\CampaignManagement\Bid;
use Microsoft\BingAds\V13\CampaignManagement\Budget;
use Microsoft\BingAds\V13\CampaignManagement\BudgetLimitType;
use Microsoft\BingAds\V13\CampaignManagement\CallToAction;
use Microsoft\BingAds\V13\CampaignManagement\Campaign;
use Microsoft\BingAds\V13\CampaignManagement\CampaignType;
use Microsoft\BingAds\V13\CampaignManagement\EntityNegativeKeyword;
use Microsoft\BingAds\V13\CampaignManagement\ExpandedTextAd;
use Microsoft\BingAds\V13\CampaignManagement\Image;
use Microsoft\BingAds\V13\CampaignManagement\ImageAsset;

// Specify the Microsoft\BingAds\Auth classes that will be used.
use Microsoft\BingAds\V13\CampaignManagement\Keyword;
use Microsoft\BingAds\V13\CampaignManagement\MatchType;

// Specify the Microsoft\BingAds\Samples classes that will be used.
use Microsoft\BingAds\V13\CampaignManagement\NegativeKeyword;
use Microsoft\BingAds\V13\CampaignManagement\ResponsiveAd;
use Microsoft\BingAds\V13\CampaignManagement\ResponsiveSearchAd;
use Microsoft\BingAds\V13\Reporting\AccountPerformanceReportColumn;
use Microsoft\BingAds\V13\Reporting\AccountPerformanceReportRequest;
use Microsoft\BingAds\V13\Reporting\AccountReportScope;
use Microsoft\BingAds\V13\Reporting\AccountThroughAdGroupReportScope;
use Microsoft\BingAds\V13\Reporting\AdPerformanceReportColumn;
use Microsoft\BingAds\V13\Reporting\AdPerformanceReportRequest;
use Microsoft\BingAds\V13\Reporting\AudiencePerformanceReportColumn;
use Microsoft\BingAds\V13\Reporting\AudiencePerformanceReportRequest;
use Microsoft\BingAds\V13\Reporting\CampaignPerformanceReportColumn;
use Microsoft\BingAds\V13\Reporting\CampaignPerformanceReportRequest;
use Microsoft\BingAds\V13\Reporting\ReportAggregation;
use Microsoft\BingAds\V13\Reporting\ReportFormat;
use Microsoft\BingAds\V13\Reporting\ReportRequestStatusType;
use Microsoft\BingAds\V13\Reporting\ReportTime;

function handleError($run)
{
	global $worker_logfile;
	$error_streak = 0;
	do {
		unset($error);
		try {
			$existing_open_resources = get_resources('stream');
			$r                       = $run();
			$new_open_resources      = array_diff(get_resources('stream'), $existing_open_resources);
			foreach ($new_open_resources as $rs) {
				// force closing open stream resources to avoid hang up after 1012 request.
				fclose($rs);
			}
		} catch (Exception $e) {
			$error_streak++;
			$error = true;
			if (isset($worker_logfile) && !empty($worker_logfile) && function_exists('writeLog')) {
				$error_info = ['errorType' => get_class($e), 'errorStreak' => $error_streak, 'code' => $e->getCode(), 'trace' => $e->getTrace()];
				writeLog($worker_logfile, json_encode($error_info));
			}
			if ($error_streak > 2) {
				throw $e;
			}
			sleep(0 + $error_streak * 10);
		}
	} while (isset($error) && !empty($error));

	return $r;
}

function getAuthentication($account_id = null, $log_file_path = null)
{

	writeLog($log_file_path, "***** My Bing Call");
	AuthHelper::Authenticate($account_id, $log_file_path);
}

function getAllCampaign($accountId = "")
{
	$getCampaignsResponse = handleError(function () use ($accountId) {
		return CampaignManagementExampleHelper::GetCampaignsByAccountId(
			$accountId,
			null,
			null
		);
	});

	return $getCampaignsResponse;
}

function createBudget($name, $amount = 0.05)
{
	$budgets            = [];
	$budget             = new Budget();
	$budget->Amount     = $amount;
	$budget->BudgetType = BudgetLimitType::DailyBudgetStandard;
	$budget->Name       = $name;
	$budgets[]          = $budget;
	$addBudgetsResponse = handleError(function () use ($budgets) {
		return CampaignManagementExampleHelper::AddBudgets(
			$budgets
		);
	});
	$budgetIds = $addBudgetsResponse->BudgetIds;
	return $budgetIds->long[0];
}

function createCampaign($accountId, $budgetId, $campaign_name, $campaign_des = 'bing ads description')
{
	$campaigns = [];
	$campaign  = new Campaign();
	//$campaign->CampaignType = CampaignType::Shopping;
	$campaign->Name        = $campaign_name;
	$campaign->Description = $campaign_des;
	$campaign->BudgetId    = $budgetId;
	$campaign->BudgetType  = BudgetLimitType::DailyBudgetStandard;
	$campaign->DailyBudget = 0.05;
	$campaign->Languages   = array("All");
	$campaign->TimeZone    = "PacificTimeUSCanadaTijuana";
	$campaigns[]           = $campaign;

	$addCampaignsResponse = handleError(function () use ($accountId, $campaigns) {
		return CampaignManagementExampleHelper::AddCampaigns(
			$accountId,
			$campaigns,
			false
		);
	});
	$campaignIds = $addCampaignsResponse->CampaignIds;
	return $campaignIds->long[0];
}

function createAdGroup($campaignId, $CpcBid, $Name)
{
	$adGroups                = [];
	$adGroup                 = new AdGroup();
	$adGroup->CpcBid         = new Bid();
	$adGroup->CpcBid->Amount = $CpcBid;
	date_default_timezone_set('UTC');
	$adGroup->EndDate    = null;
	$adGroup->Name       = $Name;
	$adGroup->Status     = AdGroupStatus::Active;
	$adGroup->StartDate  = null;
	$adGroups[]          = $adGroup;
	$addAdGroupsResponse = handleError(function () use ($campaignId, $adGroups) {
		return CampaignManagementExampleHelper::AddAdGroups(
			$campaignId,
			$adGroups,
			null
		);
	});
	$adGroupIds = $addAdGroupsResponse->AdGroupIds;
	return $adGroupIds->long[0];
}

function getAdGroupsByCampaignId($campaignId)
{
	$adGroupsResponse = handleError(function () use ($campaignId) {
		return CampaignManagementExampleHelper::GetAdGroupsByCampaignId(
			$campaignId
		);
	});
	$AdGroups     = $adGroupsResponse->AdGroups;
	$adGroupsData = [];
	if (count((array) $AdGroups)) {
		$AdGroup = $AdGroups->AdGroup;
		foreach ($AdGroup as $adgroup_data) {
			$adGroupsData[$adgroup_data->Name] = $adgroup_data;
		}
	}
	return $adGroupsData;
}

function addKeyword($adGroupId, $Text, $MatchType = 'Broad')
{
	$keywords             = [];
	$keyword              = new Keyword();
	$keyword->Bid         = new Bid();
	$keyword->Bid->Amount = 0.05;
	$keyword->MatchType   = $MatchType;
	$keyword->Text        = $Text;
	$keywords[]           = $keyword;
	$addKeywordsResponse  = handleError(function () use ($adGroupId, $keywords) {
		return CampaignManagementExampleHelper::AddKeywords(
			$adGroupId,
			$keywords,
			null
		);
	});
	return $addKeywordsResponse->KeywordIds;
}

function addNegativeKeyword($campaignId, $Text)
{
	$negativeKeyword                         = new NegativeKeyword();
	$negativeKeyword->MatchType              = MatchType::Phrase;
	$negativeKeyword->Text                   = $Text;
	$entityNegativeKeyword                   = new EntityNegativeKeyword();
	$entityNegativeKeyword->EntityId         = $campaignId;
	$entityNegativeKeyword->EntityType       = "Campaign";
	$entityNegativeKeyword->NegativeKeywords = array($negativeKeyword);
	$addNegativeKeywordsToEntitiesResponse   = handleError(function () use ($entityNegativeKeyword) {
		return CampaignManagementExampleHelper::AddNegativeKeywordsToEntities(
			array($entityNegativeKeyword)
		);
	});
	return $addNegativeKeywordsToEntitiesResponse;
}

function getImageMedia($mediaType, $image_data)
{
	$image            = new Image();
	$image->Data      = $image_data;
	$image->MediaType = 'Image' . $mediaType;
	$image->Type      = "Image";
	$encodedImage     = new SoapVar(
		$image,
		SOAP_ENC_OBJECT,
		'Image',
		$GLOBALS['CampaignManagementProxy']->GetNamespace()
	);
	return $encodedImage;
}

function addMedia($accountId, $addMedia)
{
	$mediaIds = handleError(function () use ($accountId, $addMedia) {
		return CampaignManagementExampleHelper::AddMedia(
			$accountId,
			$addMedia
		)->MediaIds;
	});
	return $mediaIds->long[0];
}

function expandedTextAds($adGroupId, $TitlePart1, $TitlePart2, $TitlePart3, $Text, $TextPart2, $FinalUrls)
{
	$ads                        = [];
	$expandedTextAd             = new ExpandedTextAd();
	$expandedTextAd->TitlePart1 = substr($TitlePart1, 0, 30);
	$expandedTextAd->TitlePart2 = substr($TitlePart2, 0, 30);
	$expandedTextAd->TitlePart3 = substr($TitlePart3, 0, 30);
	$expandedTextAd->Text       = substr($Text, 0, 90);
	$expandedTextAd->TextPart2  = substr($TextPart2, 0, 90);
	$expandedTextAd->Path1      = "";
	$expandedTextAd->Path2      = "";
	$expandedTextAd->FinalUrls  = array($FinalUrls);
	$ads[]                      = new SoapVar(
		$expandedTextAd,
		SOAP_ENC_OBJECT,
		'ExpandedTextAd',
		$GLOBALS['CampaignManagementProxy']->GetNamespace()
	);
	$addAdsResponse = handleError(function () use ($adGroupId, $ads) {
		return CampaignManagementExampleHelper::AddAds(
			$adGroupId,
			$ads
		);
	});
	return $addAdsResponse;
}

function createResponsiveSearchAds($adGroupId, $BusinessName, $FinalUrls, $Headline, $assetName, $LongHeadline, $Text)
{
	$ads                          = [];
	$responsiveSearchAd           = new ResponsiveSearchAd();
	$descriptionAssetLinks        = [];
	$descriptionAssetLinkA        = new AssetLink();
	$descriptionTextAssetA        = new ImageAsset();
	$descriptionTextAssetA->Text  = $Text;
	$descriptionAssetLinkA->Asset = new SoapVar(
		$descriptionTextAssetA,
		SOAP_ENC_OBJECT,
		'TextAsset',
		$GLOBALS['CampaignManagementProxy']->GetNamespace()
	);
	$descriptionAssetLinkA->PinnedField = "Description1";
	$descriptionAssetLinks[]            = $descriptionAssetLinkA;
	$responsiveSearchAd->Descriptions   = $descriptionAssetLinks;

	$headlineAssetLinks        = [];
	$headlineAssetLinkA        = new AssetLink();
	$headlineTextAssetA        = new ImageAsset();
	$headlineTextAssetA->Text  = $Headline;
	$headlineAssetLinkA->Asset = new SoapVar(
		$headlineTextAssetA,
		SOAP_ENC_OBJECT,
		'TextAsset',
		$GLOBALS['CampaignManagementProxy']->GetNamespace()
	);
	$headlineAssetLinkA->PinnedField = "Headline1";
	$headlineAssetLinks[]            = $headlineAssetLinkA;

	$headlineAssetLinkB        = new AssetLink();
	$headlineTextAssetB        = new ImageAsset();
	$headlineTextAssetB->Text  = $LongHeadline;
	$headlineAssetLinkB->Asset = new SoapVar(
		$headlineTextAssetB,
		SOAP_ENC_OBJECT,
		'TextAsset',
		$GLOBALS['CampaignManagementProxy']->GetNamespace()
	);
	$headlineAssetLinkB->PinnedField = null;
	$headlineAssetLinks[]            = $headlineAssetLinkB;

	$headlineAssetLinkC        = new AssetLink();
	$headlineTextAssetC        = new ImageAsset();
	$headlineTextAssetC->Text  = $BusinessName;
	$headlineAssetLinkC->Asset = new SoapVar(
		$headlineTextAssetC,
		SOAP_ENC_OBJECT,
		'TextAsset',
		$GLOBALS['CampaignManagementProxy']->GetNamespace()
	);
	$headlineAssetLinkC->PinnedField = null;
	$headlineAssetLinks[]            = $headlineAssetLinkC;
	$responsiveSearchAd->Headlines   = $headlineAssetLinks;
	$responsiveSearchAd->Path1       = $assetName;
	$responsiveSearchAd->Path2       = $assetName;
	$responsiveSearchAd->FinalUrls   = array($FinalUrls);
	$ads[]                           = new SoapVar(
		$responsiveSearchAd,
		SOAP_ENC_OBJECT,
		'ResponsiveSearchAd',
		$GLOBALS['CampaignManagementProxy']->GetNamespace()
	);
	$addAdsResponse = handleError(function () use ($adGroupId, $ads) {
		return CampaignManagementExampleHelper::AddAds(
			$adGroupId,
			$ads
		);
	});
	return $addAdsResponse;
	return $addAdsResponse->AdIds;
}

function createResponsiveAds($adGroupId, $BusinessName, $FinalUrls, $Headline, $assetName, $LongHeadline, $Text, $mediaId, $SubType = 'LandscapeImageMedia')
{
	$ads                                  = [];
	$responsiveAd                         = new ResponsiveAd();
	$responsiveAd->BusinessName           = $BusinessName;
	$responsiveAd->CallToAction           = CallToAction::VisitSite;
	$responsiveAd->FinalUrls              = $FinalUrls;
	$responsiveAd->Headline               = $Headline;
	$images                               = [];
	$landscapeImageMediaAssetLink         = new AssetLink();
	$landscapeImageMediaAsset             = new ImageAsset();
	$landscapeImageMediaAsset->CropHeight = null;
	$landscapeImageMediaAsset->CropWidth  = null;
	$landscapeImageMediaAsset->CropX      = null;
	$landscapeImageMediaAsset->CropY      = null;
	$landscapeImageMediaAsset->Id         = $mediaId;
	$landscapeImageMediaAsset->Name       = $assetName;
	$landscapeImageMediaAsset->SubType    = $SubType;
	$landscapeImageMediaAssetLink->Asset  = new SoapVar(
		$landscapeImageMediaAsset,
		SOAP_ENC_OBJECT,
		'ImageAsset',
		$GLOBALS['CampaignManagementProxy']->GetNamespace()
	);
	$images[]                   = $landscapeImageMediaAssetLink;
	$responsiveAd->Images       = $images;
	$responsiveAd->LongHeadline = $LongHeadline;
	$responsiveAd->Text         = $Text;

	$ads[] = new SoapVar(
		$responsiveAd,
		SOAP_ENC_OBJECT,
		'ResponsiveAd',
		$GLOBALS['CampaignManagementProxy']->GetNamespace()
	);
	$addAdsResponse = handleError(function () use ($adGroupId, $ads) {
		return CampaignManagementExampleHelper::AddAds(
			$adGroupId,
			$ads
		);
	});
	return $addAdsResponse;
}

function GetAdsByAdGroupId($adGroupId, $adTypes = ['ExpandedText'])
{
	$adsResponse = handleError(function () use ($adGroupId, $adTypes) {
		return CampaignManagementExampleHelper::GetAdsByAdGroupId(
			$adGroupId,
			$adTypes,
			''
		);
	});
	$adsId = [];
	foreach ($adsResponse->Ads->Ad as $ad) {
		array_push($adsId, $ad->Id);
	}
	return $adsId;
}

function DeleteCampaigns($accountId, $campaignIds)
{
	$deleteCampaignsResponse = handleError(function () use ($accountId, $campaignIds) {
		return CampaignManagementExampleHelper::DeleteCampaigns(
			$accountId,
			$campaignIds
		);
	});
	return $deleteCampaignsResponse;
}

function DeleteAdGroups($campaignId, $adGroupIds)
{
	$deleteAdGroupResponse = handleError(function () use ($campaignId, $adGroupIds) {
		return CampaignManagementExampleHelper::DeleteAdGroups(
			$campaignId,
			$adGroupIds
		);
	});
	return $deleteAdGroupResponse;
}

/*
 * https://docs.microsoft.com/en-us/advertising/campaign-management-service/deleteads?view=bingads-13
 * $adIds = array[];
 */
function DeleteAds($adGroupId, $adIds)
{
	$deleteAdsResponse = handleError(function () use ($adGroupId, $adIds) {
		return CampaignManagementExampleHelper::DeleteAds(
			$adGroupId,
			$adIds
		);
	});
	return $deleteAdsResponse;
}

/*
 * https://docs.microsoft.com/en-us/advertising/campaign-management-service/updatecampaigns?view=bingads-13
 */
function UpdateCampaigns($accountId, $campaigns, $includeDynamicSearchAdsSource)
{
	$updateCampaignsResponse = handleError(function () use ($accountId, $campaigns, $includeDynamicSearchAdsSource) {
		return CampaignManagementExampleHelper::UpdateCampaigns(
			$accountId,
			$campaigns,
			$includeDynamicSearchAdsSource
		);
	});
	return $updateCampaignsResponse;
}

/*
 *  https://docs.microsoft.com/en-us/advertising/campaign-management-service/updateadgroups?view=bingads-13
 */
function UpdateAdGroups($campaignId, $adGroups, $updateAudienceAdsBidAdjustment, $returnInheritedBidStrategyTypes)
{
	$updateAdGroupResponse = handleError(function () use ($campaignId, $adGroups, $updateAudienceAdsBidAdjustment, $returnInheritedBidStrategyTypes) {
		return CampaignManagementExampleHelper::UpdateAdGroups(
			$campaignId,
			$adGroups,
			$updateAudienceAdsBidAdjustment,
			$returnInheritedBidStrategyTypes
		);
	});
	return $updateAdGroupResponse;
}

/*
 *   https://docs.microsoft.com/en-us/advertising/campaign-management-service/updateads?view=bingads-13
 */
function UpdateAds($adGroupId, $ads)
{
	$updateAdsResponse = handleError(function () use ($adGroupId, $ads) {
		return CampaignManagementExampleHelper::UpdateAds(
			$adGroupId,
			$ads
		);
	});
	return $updateAdsResponse;
}

function GetAccountPerformanceReportRequest($accountId, $timePeriod)
{
	$report = new AccountPerformanceReportRequest();

	$report->Format                 = ReportFormat::Csv;
	$report->ReportName             = 'My Account Performance Report';
	$report->ReturnOnlyCompleteData = false;
	$report->Aggregation            = ReportAggregation::Monthly;

	$report->Scope               = new AccountReportScope();
	$report->Scope->AccountIds   = [];
	$report->Scope->AccountIds[] = $accountId;

	$report->Time                 = new ReportTime();
	$report->Time->PredefinedTime = $timePeriod;

	$report->Columns = array(
		AccountPerformanceReportColumn::TimePeriod,
		AccountPerformanceReportColumn::AccountId,
		AccountPerformanceReportColumn::AccountName,
		AccountPerformanceReportColumn::Clicks,
		AccountPerformanceReportColumn::Impressions,
		AccountPerformanceReportColumn::Ctr,
		AccountPerformanceReportColumn::AverageCpc,
		AccountPerformanceReportColumn::Spend,
		AccountPerformanceReportColumn::DeviceOS,
	);

	$encodedReport = new SoapVar(
		$report,
		SOAP_ENC_OBJECT,
		'AccountPerformanceReportRequest',
		$GLOBALS['ReportingProxy']->GetNamespace()
	);

	return $encodedReport;
}

function GetAudiencePerformanceReportRequest($accountId, $timePeriod)
{
	$report = new AudiencePerformanceReportRequest();

	$report->Format                 = ReportFormat::Csv;
	$report->ReportName             = 'My Audience Performance Report';
	$report->ReturnOnlyCompleteData = false;
	$report->Aggregation            = ReportAggregation::Monthly;

	$report->Scope               = new AccountThroughAdGroupReportScope();
	$report->Scope->AccountIds   = [];
	$report->Scope->AccountIds[] = $accountId;
	//    $report->Scope->AdGroups = null;
	//    $report->Scope->Campaigns = null;

	$report->Time = new ReportTime();

	//    $report->Time->PredefinedTime = ReportTimePeriod::Yesterday;
	$report->Time->PredefinedTime = $timePeriod;

	$report->Columns = array(
		AudiencePerformanceReportColumn::TimePeriod,
		AudiencePerformanceReportColumn::AccountId,
		AudiencePerformanceReportColumn::CampaignId,
		AudiencePerformanceReportColumn::CampaignName,
		AudiencePerformanceReportColumn::CampaignStatus,
		AudiencePerformanceReportColumn::AudienceId,
		AudiencePerformanceReportColumn::Clicks,
		AudiencePerformanceReportColumn::Impressions,
		AudiencePerformanceReportColumn::Ctr,
		AudiencePerformanceReportColumn::AverageCpc,
		AudiencePerformanceReportColumn::Spend,
	);

	$encodedReport = new SoapVar(
		$report,
		SOAP_ENC_OBJECT,
		'AudiencePerformanceReportRequest',
		$GLOBALS['ReportingProxy']->GetNamespace()
	);

	return $encodedReport;
}

function GetAdPerformanceReportRequest($accountId, $timePeriod)
{
	$report = new AdPerformanceReportRequest();

	$report->Format                 = ReportFormat::Csv;
	$report->ReportName             = 'My Ad Account Performance Report';
	$report->ReturnOnlyCompleteData = false;
	$report->ExcludeReportHeader    = true;
	$report->ExcludeReportFooter    = true;
	$report->Aggregation            = ReportAggregation::Monthly;

	$report->Scope               = new AccountReportScope();
	$report->Scope->AccountIds   = [];
	$report->Scope->AccountIds[] = $accountId;

	$report->Time                 = new ReportTime();
	$report->Time->PredefinedTime = $timePeriod;

	$report->Columns = array(
		AdPerformanceReportColumn::TimePeriod,
		AdPerformanceReportColumn::AccountId,
		AdPerformanceReportColumn::AccountName,
		AdPerformanceReportColumn::CampaignName,
		AdPerformanceReportColumn::CampaignId,
		AdPerformanceReportColumn::CampaignStatus,
		AdPerformanceReportColumn::CampaignType,
		AdPerformanceReportColumn::Clicks,
		AdPerformanceReportColumn::Impressions,
		AdPerformanceReportColumn::Ctr,
		AdPerformanceReportColumn::AverageCpc,
		AdPerformanceReportColumn::Spend,
	);

	$encodedReport = new SoapVar(
		$report,
		SOAP_ENC_OBJECT,
		'AdPerformanceReportRequest',
		$GLOBALS['ReportingProxy']->GetNamespace()
	);

	return $encodedReport;
}

function GetCampaignerformanceReportRequest($accountId, $start_day, $start_month, $start_year, $end_day, $end_month, $end_year)
{
	$report = new CampaignPerformanceReportRequest();

	$report->Format                 = ReportFormat::Csv;
	$report->ReportName             = 'My Campaign Performance Report';
	$report->ReturnOnlyCompleteData = false;
	$report->ExcludeReportHeader    = true;
	$report->ExcludeReportFooter    = true;
	$report->Aggregation            = ReportAggregation::Monthly;

	$report->Scope               = new AccountReportScope();
	$report->Scope->AccountIds   = [];
	$report->Scope->AccountIds[] = $accountId;

	$report->Time = new ReportTime();

	$report->Time->CustomDateRangeStart->Day   = $start_day;
	$report->Time->CustomDateRangeStart->Month = $start_month;
	$report->Time->CustomDateRangeStart->Year  = $start_year;

	$report->Time->CustomDateRangeEnd->Day   = $end_day;
	$report->Time->CustomDateRangeEnd->Month = $end_month;
	$report->Time->CustomDateRangeEnd->Year  = $end_year;

	//    $report->Time->PredefinedTime = $timePeriod;

	$report->Columns = array(
		CampaignPerformanceReportColumn::TimePeriod,
		CampaignPerformanceReportColumn::AccountId,
		CampaignPerformanceReportColumn::AccountName,
		CampaignPerformanceReportColumn::CampaignName,
		CampaignPerformanceReportColumn::CampaignId,
		CampaignPerformanceReportColumn::CampaignStatus,
		CampaignPerformanceReportColumn::CampaignType,
		CampaignPerformanceReportColumn::Clicks,
		CampaignPerformanceReportColumn::Impressions,
		CampaignPerformanceReportColumn::ImpressionSharePercent,
		CampaignPerformanceReportColumn::ExactMatchImpressionSharePercent,
		CampaignPerformanceReportColumn::Ctr,
		CampaignPerformanceReportColumn::AverageCpc,
		CampaignPerformanceReportColumn::Spend,
		CampaignPerformanceReportColumn::ImpressionLostToBudgetPercent,
		CampaignPerformanceReportColumn::ImpressionLostToRankAggPercent,
	);

	$encodedReport = new SoapVar(
		$report,
		SOAP_ENC_OBJECT,
		'CampaignPerformanceReportRequest',
		$GLOBALS['ReportingProxy']->GetNamespace()
	);

	return $encodedReport;
}

function getRequestReportID($report)
{

	$reportRequestId = ReportingExampleHelper::SubmitGenerateReport(
		$report
	)->ReportRequestId;

	return $reportRequestId;
}
function pollGenerateReport($reportRequestId)
{
	$pollGenerateReportResponse = ReportingExampleHelper::PollGenerateReport(
		$reportRequestId
	);

	return $pollGenerateReportResponse;
}

function bingFileRead($file)
{
	$newfile = 'tmp_file.zip';

	if (!copy($file, $newfile)) {
		return false;
	}

	$z = new ZipArchive();
	if ($z->open($newfile)) {
		$index = $z->getFromIndex(0);
	}

	$data       = explode("\n", str_replace(["\r\n", "\n\r", "\r"], "\n", $index));
	$keys       = ["TimePeriod", "AccountId", "AccountName", "CampaignName", "CampaignId", "CampaignStatus", "CampaignType", "Clicks", "Impressions", "ImpressionSharePercent", "ExactMatchImpressionSharePercent", "Ctr", "AverageCpc", "Spend"];
	$final_data = [];

	for ($i = 1; $i < count($data); $i++) {
		$value = $data[$i];
		$row   = explode(",", $value);
		if ($row[0]) {
			$keyData = [];
			$j       = 0;
			foreach ($keys as $key) {
				$keyData[$key] = $row[$j];
				$j++;
			}
			$final_data[] = array_map('trim', $keyData);
		}
	}
	return $final_data;
}

function print_report($reportRequestId)
{

	$waitTime      = 15;
	$requestStatus = null;
	$resultFileUrl = null;

	for ($i = 1; $i < 5; $i++) {
		$wT = $waitTime * $i;
		//        print("<br>sleep($wT seconds)");
		sleep($wT);

		// Get the download request status.
		//        print("<br>PollGenerateReport:");
		$pollGenerateReportResponse = pollGenerateReport($reportRequestId);

		$requestStatus = $pollGenerateReportResponse->ReportRequestStatus->Status;
		$resultFileUrl = $pollGenerateReportResponse->ReportRequestStatus->ReportDownloadUrl;
		//        print("<br>RequestStatus: $requestStatus");
		//        print("<br>ReportDownloadUrl: $resultFileUrl\r\n");

		if ($requestStatus == ReportRequestStatusType::Success || $requestStatus == ReportRequestStatusType::Error) {
			//            echo "<br>++++++pollGenerateReportResponse+++++<br>";
			//            print_r($pollGenerateReportResponse);
			//            echo "<br>++++++pollGenerateReportResponse+++++<br>";
			return $resultFileUrl;
		}
	}
}

function DownloadFileBing($resultFileUrl, $downloadPath)
{
	if (!$reader = fopen($resultFileUrl, 'rb')) {
		throw new Exception("Failed to open URL " . $resultFileUrl . ".");
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
			$exception = new Exception("Write operation to ZIP file failed.");
		}
	}

	fclose($reader);
	fflush($writer);
	fclose($writer);
}

function getReportAsArray()
{
	return true;
}
