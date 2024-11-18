<?php

namespace sMedia\AdWords\Service;

use Exception;
use Microsoft\BingAds\Samples\V13\AuthHelper;
use Microsoft\BingAds\Samples\V13\CampaignManagementExampleHelper;
use Microsoft\BingAds\V13\CampaignManagement\MatchType;
use Microsoft\BingAds\V13\CampaignManagement\Keyword;
use Microsoft\BingAds\V13\CampaignManagement\NegativeKeyword;
use Microsoft\BingAds\V13\CampaignManagement\AdGroup;
use Microsoft\BingAds\V13\CampaignManagement\Bid;
use Microsoft\BingAds\V13\CampaignManagement\Budget;
use Microsoft\BingAds\V13\CampaignManagement\BudgetLimitType;
use Microsoft\BingAds\V13\CampaignManagement\Campaign;
use Microsoft\BingAds\V13\CampaignManagement\EntityNegativeKeyword;
use Microsoft\BingAds\V13\CampaignManagement\ExpandedTextAd;
use SoapVar;

class BingAdService
{
    public $accountId;
    private $logger;
    private $log_file;
    private $errorSleep = 0;
    private $successfullBingRequest = 0;
    private $campaigns = [];
    private $adGroups = [];
    public function __construct($account_id, \Monolog\Logger $logger)
    {
        $this->accountId = $account_id;
        $this->logger = $logger;
        $log_handler = $this->logger->getHandlers();
        $this->log_file = $log_handler[0]->getUrl();

        $this->authenticate();
        $logger->info("Initialized bing service for {$account_id}");
        $logger->info("system limits: ", posix_getrlimit());
    }

    private function authenticate()
    {
        AuthHelper::Authenticate($this->accountId, $this->log_file);
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
                if($error_streak > 15) {
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

    public function SetCampaignNegetiveKeywords($campaign_id, $keywords)
    {
        $negativeKeywords = [];
        foreach ($keywords as $keyword) {
            $negativeKeyword                = new NegativeKeyword();
            if ($keyword['matchType'] == 'EXACT') {
                $negativeKeyword->MatchType     = MatchType::Exact;
            } else if ($keyword['matchType'] == 'PHRASE') {
                $negativeKeyword->MatchType     = MatchType::Phrase;
            } else if ($keyword['matchType'] == 'BROAD') {
                // Broad keyword is not allowed in negetiv keyWord
                continue;
            }
            $negativeKeyword->Text          = $keyword['text'];
            $negativeKeywords[] = $negativeKeyword;
        }
        $entityNegativeKeyword                      = new EntityNegativeKeyword();
        $entityNegativeKeyword->EntityId            = $campaign_id;
        $entityNegativeKeyword->EntityType          = "Campaign";
        $entityNegativeKeyword->NegativeKeywords    = $negativeKeywords;
        $r = $this->handleError(function () use ($entityNegativeKeyword) {
            return CampaignManagementExampleHelper::AddNegativeKeywordsToEntities(
                array($entityNegativeKeyword)
            );
        });
        return $r;
    }

    public function GetAdGroups($campaign_name)
    {
        $this->adGroups[$campaign_name] = [];
        $campaign = $this->GetCampaign($campaign_name);

        if (empty($campaign) || !is_array($campaign) || !isset($campaign[0]->id)) {
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
                    $this->adGroups[$campaign_name][$adgroup_data->Name]  =  (object) [
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
            isset($r->AdIds->long[0])
        ) {
            return $r->AdIds->long[0];
        } else {
            $this->logger->error("Ad create error", [$r]);
            return null;
        }
    }

    public function GetAds($group_id, $types = ['ExpandedText'])
    {
        $r = $this->handleError(function () use ($group_id, $types) {
            return CampaignManagementExampleHelper::GetAdsByAdGroupId(
                $group_id,
                $types,
                ''
            );
        });
        $ids = [];
        if (
            isset($r->Ads) &&
            isset($r->Ads->Ad) &&
            is_array($r->Ads->Ad)
        ) {
            foreach ($r->Ads->Ad as $ad) {
                array_push($ids, $ad->Id);
            }
        }
        return $ids;
    }

    public function RemoveAd($ad_group_id, $ad_ids)
    {
        $r = $this->handleError(function () use ($ad_group_id, $ad_ids) {
            return CampaignManagementExampleHelper::DeleteAds(
                $ad_group_id,
                $ad_ids
            );
        });
        return $r;
    }

    public function SetAdGroupKeywords($ad_group_id, $keywords)
    {
        $newKeywords = [];
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
            $newKeyword->Bid->Amount   = 0.05;
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
        return $r;
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
        $r = $this->handleError(function () use ($ad_group_id, $keyword_ids) {
            return CampaignManagementExampleHelper::DeleteKeywords(
                $ad_group_id,
                $keyword_ids
            );
        });

        return $r;
    }

    public function GetCampaignNegetiveKeywords($campaign_id)
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
        }

        return null;
    }

    public function RemoveCampaignNegetiveKeywords($entityNegativeKeyword)
    {
        $r = $this->handleError(function () use ($entityNegativeKeyword) {
            return CampaignManagementExampleHelper::DeleteNegativeKeywordsFromEntities(
                $entityNegativeKeyword
            );
        });
        return $r;
    }
}
