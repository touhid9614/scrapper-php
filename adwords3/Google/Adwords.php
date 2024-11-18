<?php

require_once 'Types.php';
require_once 'Consts.php';
require_once 'TokenHelper.php';

/**
 * This class describes an adwords service.
 */
class AdwordsService
{
    public $namespace, $access_token, $developer_token, $customer_id;

    protected $CampaignService, $CampaignCriterionService, $AdGroupService, $CriterionService, $AdService,
    $UserListService, $ConversionTrackerService, $BudgetService;

    /**
     * Initializes the object.
     */
    private function Init()
    {
        // Used to manage campaign
        $this->CampaignService          = $this->CreateClient(Consts::CampaignServiceWsdl);
        $this->CampaignCriterionService = $this->CreateClient(Consts::CampaignCriterionServiceWsdl);
        // Used to manage group
        $this->AdGroupService = $this->CreateClient(Consts::AdGroupServiceWsdl);
        // Used to add keywords to ad group
        $this->CriterionService = $this->CreateClient(Consts::CriterionServiceWsdl);
        // Used to manage ad
        $this->AdService = $this->CreateClient(Consts::AdGroupAdServiceWsdl);
        // Used to manage retargeting
        $this->UserListService          = $this->CreateClient(Consts::UserListServiceWsdl, Consts::UserListServiceNamespace);
        $this->ConversionTrackerService = $this->CreateClient(Consts::ConversionTrackerServiceWsdl);
        $this->BudgetService            = $this->CreateClient(Consts::BudgetServiceWsdl);
    }

    /**
     * Constructs a new instance.
     *
     * @param <type> $namespace The namespace
     * @param AccessToken $access_token The access token
     * @param <type> $developer_token The developer token
     * @param <type> $customer_id The customer identifier
     */
    public function __construct($namespace, AccessToken $access_token, $developer_token, $customer_id)
    {
        $this->namespace       = $namespace;
        $this->access_token    = $access_token;
        $this->developer_token = $developer_token;
        $this->customer_id     = $customer_id;
        $this->Init();
    }

    /**
     * Creates a client.
     *
     * @param <type> $wsdl The wsdl
     * @param boolean $namespace The namespace
     *
     * @return     SoapClient  The soap client.
     */
    public function CreateClient($wsdl, $namespace = false)
    {
        $options = array(
            'features'       => SOAP_SINGLE_ELEMENT_ARRAYS,
            'ssl_method'     => SOAP_SSL_METHOD_SSLv23,
            'encoding'       => 'utf-8',
            'stream_context' => stream_context_create(array('http' => array('header' =>
                'Authorization: Bearer ' . $this->access_token->Token))),
        );

        $client = new SoapClient($wsdl, $options);

        $header_vals = array(
            'userAgent'      => "Smedia-InventoryManager-1.0",
            'developerToken' => $this->developer_token,
        );

        if ($this->customer_id) {
            $header_vals['clientCustomerId'] = $this->customer_id;
        }

        if (!$namespace) {
            $namespace = $this->namespace;
        }

        $headers = new SoapHeader($namespace, 'RequestHeader', $header_vals);
        $client->__setSoapHeaders($headers);

        return $client;
    }

    /**
     * Gets the ads from ad groups.
     *
     * @param <type> $adGroupIds The ad group identifiers
     *
     * @return mixed  The ads from ad groups.
     */
    public function GetAdsFromAdGroups($adGroupIds, $fields = null)
    {
        $fields = !empty($fields) ? $fields : array(
            'Id',
            'Description',
            'ResponsiveSearchAdDescriptions',
            'ExpandedTextAdDescription2',
            'ExpandedTextAdHeadlinePart3',
            'ResponsiveSearchAdHeadlines',
            'HeadlinePart1',
            'HeadlinePart2',
            'CreativeFinalUrls',
        );

        $predicate = array(
            'field'    => 'AdGroupId',
            'operator' => 'IN',
            'values'   => $adGroupIds,
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->AdService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetAdsFromAdGroups($adGroupIds, $fields);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the ads.
     *
     * @param <type> $adGroupId The ad group identifier
     *
     * @return mixed  The ads.
     */
    public function GetAds($adGroupId)
    {
        $fields = array(
            'Id', 'MediaId', 'Type', 'MimeType', 'SourceUrl', 'TemplateElementFieldName',
            'TemplateElementFieldType', 'TemplateElementFieldText',
        );

        $predicate1 = array(
            'field'    => 'AdGroupId',
            'operator' => 'EQUALS',
            'values'   => array($adGroupId),
        );

        $predicate2 = array(
            'field'    => 'Status',
            'operator' => 'IN',
            'values'   => array('ENABLED', 'PAUSED'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->AdService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetAds($adGroupId);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the disapproved ads.
     *
     * @param <type> $adGroupId The ad group identifier
     *
     * @return mixed  The disapproved ads.
     */
    public function GetDisapprovedAds($adGroupId)
    {
        $fields = array(
            'Id', 'MediaId', 'Type', 'MimeType', 'SourceUrl', 'TemplateElementFieldName',
            'TemplateElementFieldType', 'TemplateElementFieldText', 'PolicySummary',
        );

        $predicate = array(
            'field'    => 'AdGroupId',
            'operator' => 'EQUALS',
            'values'   => array($adGroupId),
        );

        $disapproved_predicate = array(
            'field'    => 'CombinedApprovalStatus',
            'operator' => 'EQUALS',
            'values'   => array('DISAPPROVED'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate, $disapproved_predicate),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->AdService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetAds($adGroupId);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the campaigns.
     *
     * @return     array | boolean The campaigns.
     */
    public function GetCampaigns()
    {
        $fields = array('Id', 'Name', 'Status', 'Settings', 'AdvertisingChannelType', 'TargetGoogleSearch', 'TargetSearchNetwork', 'TargetContentNetwork');

        $predicate1 = array(
            'field'    => 'Status',
            'operator' => 'IN',
            'values'   => array('ENABLED', 'PAUSED'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1),
        );

        try {
            $rval = $this->CampaignService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetCampaigns();
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the ad groups.
     *
     * @param <type> $campaign_name The campaign name
     *
     * @return     array | boolean  The ad groups.
     */
    public function GetAdGroups($campaign_name)
    {
        $fields = array('Id', 'Name', 'Status');

        $predicate1 = array(
            'field'    => 'CampaignName',
            'operator' => 'EQUALS',
            'values'   => array($campaign_name),
        );

        $predicate2 = array(
            'field'    => 'Status',
            'operator' => 'NOT_EQUALS',
            'values'   => array('REMOVED'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->AdGroupService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetAdGroups($campaign_name);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the ad groups from multiple campaigns.
     *
     * @param <type> $campaign_name The campaign name
     *
     * @return     array | boolean  The ad groups.
     */
    public function GetAdGroupsFromMultiCampaign($campaign_names)
    {
        $fields = array('Id', 'Name', 'Status', 'CampaignName');

        $predicate1 = array(
            'field'    => 'CampaignName',
            'operator' => 'IN',
            'values'   => is_array($campaign_names) ? $campaign_names : [$campaign_names],
        );

        $predicate2 = array(
            'field'    => 'Status',
            'operator' => 'NOT_EQUALS',
            'values'   => array('REMOVED'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->AdGroupService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetAdGroupsFromMultiCampaign($campaign_names);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the ad groups from multiple campaigns.
     *
     * @param array | string $campaign_ids The campaign ids
     *
     * @return     array | boolean  The ad groups.
     */
    public function GetAdGroupsFromMultiCampaignById($campaign_ids, $fields = [])
    {
        $fields = empty($fields) ? array('Id', 'Name', 'Status', 'CampaignName') : $fields;

        $predicate1 = array(
            'field'    => 'CampaignId',
            'operator' => 'IN',
            'values'   => is_array($campaign_ids) ? $campaign_ids : [$campaign_ids],
        );

        $predicate2 = array(
            'field'    => 'Status',
            'operator' => 'NOT_EQUALS',
            'values'   => array('REMOVED'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->AdGroupService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetAdGroupsFromMultiCampaign($campaign_ids);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the ad group.
     *
     * @param <type> $campaign_name The campaign name
     * @param <type> $ad_group_name The ad group name
     *
     * @return mixed  The ad group.
     */
    public function GetAdGroup($campaign_name, $ad_group_name)
    {
        $fields = array('Id', 'CampaignId', 'CampaignName', 'Name', 'Status');

        $predicate1 = array(
            'field'    => 'CampaignName',
            'operator' => 'EQUALS',
            'values'   => array($campaign_name),
        );

        $predicate2 = array(
            'field'    => 'Name',
            'operator' => 'EQUALS',
            'values'   => array($ad_group_name),
        );

		$predicate3 = array(
			'field'	=> 'Status',
			'operator' => 'NOT_EQUALS',
			'values' => array('REMOVED'),
		);

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2, $predicate3),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->AdGroupService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetAdGroup($campaign_name, $ad_group_name);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the ad group.
     *
     * @param <type> $campaign_name The campaign name
     * @param <type> $ad_group_name The ad group name
     *
     * @return mixed  The ad group.
     */
    public function GetAdGroupByCampaignId($campaign_id, $ad_group_name)
    {
        $fields = array('Id', 'CampaignId', 'CampaignName', 'Name', 'Status');

        $predicate1 = array(
            'field'    => 'CampaignId',
            'operator' => 'EQUALS',
            'values'   => array($campaign_id),
        );

        $predicate2 = array(
            'field'    => 'Name',
            'operator' => 'EQUALS',
            'values'   => array($ad_group_name),
        );

		$predicate3 = array(
			'field'	=> 'Status',
			'operator' => 'NOT_EQUALS',
			'values' => array('REMOVED'),
		);

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2, $predicate3),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->AdGroupService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetAdGroupByCampaignId($campaign_id, $ad_group_name);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the ad group by identifier.
     *
     * @param <type> $adGroupId The ad group identifier
     *
     * @return     boolean  The ad group by identifier.
     */
    public function GetAdGroupById($adGroupId)
    {
        $fields = array('Id', 'CampaignId', 'CampaignName', 'Name', 'Status');

        $predicate = array(
            'field'    => 'Id',
            'operator' => 'EQUALS',
            'values'   => array($adGroupId),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->AdGroupService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetAdGroupById($adGroupId);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the campaign.
     *
     * @param <type> $campaign_name The campaign name
     *
     * @return mixed  The campaign.
     */
    public function GetCampaign($campaign_name)
    {
        $fields = array('Id', 'Name', 'Status', 'Settings', 'AdvertisingChannelType', 'TargetGoogleSearch', 'TargetSearchNetwork', 'TargetContentNetwork');

        $predicate1 = array(
            'field'    => 'Name',
            'operator' => 'EQUALS',
            'values'   => array($campaign_name),
        );

		$predicate2 = array(
			'field'	=> 'Status',
			'operator' => 'NOT_EQUALS',
			'values' => array('REMOVED'),
		);

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2),
        );

        try {
            $rval = $this->CampaignService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetCampaign($campaign_name);
            } else {
                return false;
            }

        }
    }

    /**
     * Gets the campaign.
     *
     * @param <type> $campaign_name The campaign name
     *
     * @return mixed  The campaign.
     */
    public function GetCampaignById($campaign_id)
    {
        $fields = array('Id', 'Name', 'Status', 'Settings', 'AdvertisingChannelType', 'TargetGoogleSearch', 'TargetSearchNetwork', 'TargetContentNetwork');

        $predicate1 = array(
            'field'    => 'Id',
            'operator' => 'EQUALS',
            'values'   => array($campaign_id),
        );

		/* $predicate2 = array(
			'field'	=> 'Status',
			'operator' => 'NOT_EQUALS',
			'values' => array('REMOVED'),
		); */

        $selector = array(
            'fields'     => $fields,
            // 'predicates' => array($predicate1, $predicate2),
            'predicates' => array($predicate1),
        );

        try {
            $rval = $this->CampaignService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetCampaignById($campaign_id);
            } else {
                return false;
            }

        }
    }

    /**
     * Creates a budget.
     *
     * @param <type> $budgetName The budget name
     * @param integer $budgetAmount The budget amount
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function CreateBudget($budgetName, $budgetAmount)
    {
        $amount          = array('microAmount' => $budgetAmount * 1000000);
        $budget          = array('name' => $budgetName, 'amount' => $amount);
        $budgetOperation = array('operator' => 'ADD', 'operand' => $budget);

        try {
            $rval = $this->BudgetService->mutate(array('operations' => array($budgetOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->budgetId;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->CreateBudget($budgetName, $budgetAmount);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the budget.
     *
     * @param <type> $budgetId The budget identifier
     * @param integer $budgetAmount The budget amount
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function SetBudget($budgetId, $budgetAmount)
    {
        $amount          = array('microAmount' => $budgetAmount * 1000000);
        $budget          = array('budgetId' => $budgetId, 'amount' => $amount);
        $budgetOperation = array('operator' => 'SET', 'operand' => $budget);

        try {
            $rval = $this->BudgetService->mutate(array('operations' => array($budgetOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->budgetId;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetBudget($budgetId, $budgetAmount);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets budgets of one or more campaigns.
     *
     * @param int | int[] $campaign_ids The campaign ids
     *
     * @return     array | boolean  The ad groups.
     */
    public function GetCampaignBudget($campaign_ids)
    {
        $fields = array('Id', 'Name', 'Status', 'BudgetId', 'Amount');

        $campaign_ids = !is_array($campaign_ids) ? [$campaign_ids] : $campaign_ids;

        $predicate1 = array(
            'field'    => 'CampaignId',
            'operator' => 'IN',
            'values'   => $campaign_ids,
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->CampaignService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetCampaignBudget($campaign_ids);
            } else {
                return false;
            }
        }
    }

    /**
     * Creates a campaign.
     *
     * @param <type> $campaign_name The campaign name
     * @param <type> $budgetId The budget identifier
     * @param boolean $search The search
     * @param <type> $display The display
     * @param string $status The status
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function CreateCampaign($campaign_name, $budgetId, $search, $display, $status = 'PAUSED')
    {
        $biddingStrategy        = array('biddingStrategyType' => 'MANUAL_CPC');
        $budget                 = array('budgetId' => $budgetId);
        $geoTargetTypeSetting   = array('positiveGeoTargetType' => 'LOCATION_OF_PRESENCE');
        $GeoTargetTypeSetting   = new SoapVar($geoTargetTypeSetting, XSD_ANYTYPE, 'GeoTargetTypeSetting', Consts::ServiceNamespace);
        $networkSetting         = array('targetGoogleSearch' => $search, 'targetSearchNetwork' => $search, 'targetContentNetwork' => $display);
        $advertisingChannelType = $search ? 'SEARCH' : 'DISPLAY';
        $campaign               = array('name' => $campaign_name, 'budget' => $budget, 'biddingStrategyConfiguration' => $biddingStrategy, 'settings' => array($GeoTargetTypeSetting), 'networkSetting' => $networkSetting, 'advertisingChannelType' => $advertisingChannelType, 'status' => $status);
        $campaignOperation      = array('operator' => 'ADD', 'operand' => $campaign);

        try {
            $rval = $this->CampaignService->mutate(array('operations' => array($campaignOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->CreateCampaign($campaign_name, $budgetId, $search, $display);
            } else {
                return false;
            }
        }
    }

    /**
     * { function_description }
     *
     * @param <type> $campaignId The campaign identifier
     * @param <type> $search_network The search network
     * @param <type> $content_network The content network
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function UpdateCampaignNetwork($campaignId, $search_network, $content_network)
    {
        $networkSetting    = array('targetGoogleSearch' => $search_network, 'targetSearchNetwork' => $search_network, 'targetContentNetwork' => $content_network);
        $campaign          = array('id' => $campaignId, 'networkSetting' => $networkSetting);
        $campaignOperation = array('operator' => 'SET', 'operand' => $campaign);

        try {
            $rval = $this->CampaignService->mutate(array('operations' => array($campaignOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                // return $this->UpdateCampaignNetwork($campaignId, $google_search, $search_network, $content_network);
                return $this->UpdateCampaignNetwork($campaignId, $search_network, $content_network);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the campaign status.
     *
     * @param <type> $campaignId The campaign identifier
     * @param <type> $status The status
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function SetCampaignStatus($campaignId, $status)
    {
        //            $status = 'ACTIVE';
        //          if(!$active) $status = 'PAUSED';

        $campaign          = array('id' => $campaignId, 'status' => $status);
        $campaignOperation = array('operator' => 'SET', 'operand' => $campaign);

        try {
            $rval = $this->CampaignService->mutate(array('operations' => array($campaignOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetCampaignStatus($campaignId, $status);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the ad group status.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param <type> $active The active
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function SetAdGroupStatus($adGroupId, $active)
    {
        $status = 'ENABLED';

        if (!$active) {
            $status = 'PAUSED';
        }

        $campaign          = array('id' => $adGroupId, 'status' => $status);
        $campaignOperation = array('operator' => 'SET', 'operand' => $campaign);

        try {
            $rval = $this->AdGroupService->mutate(array('operations' => array($campaignOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetAdGroupStatus($adGroupId, $active);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets status for multiple ad groups.
     *
     * @param array $statuses [group_id => groupid, active => true/false]
     *
     * @return     array | boolean  ( description_of_the_return_value )
     */
    public function SetMultiAdGroupStatus($statuses)
    {
        $campaignOperations = [];
        foreach ($statuses as $status) {
            $campaign             = array('id' => $status['group_id'], 'status' => $status['active'] == true ? 'ENABLED' : 'PAUSED');
            $campaignOperations[] = array('operator' => 'SET', 'operand' => $campaign);
        }

        try {
            $rval = $this->AdGroupService->mutate(array('operations' => $campaignOperations));

            if (isset($rval->rval->value)) {
                return array_map(function ($v) {
                    return $v->id;
                }, $rval->rval->value);
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetMultiAdGroupStatus($statuses);
            } else {
                return false;
            }
        }
    }

    /**
     * { function_description }
     *
     * @param <type> $campaignId The campaign identifier
     * @param <type> $search The search
     * @param <type> $display The display
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function UpdateNetwork($campaignId, $search, $display)
    {
        $networkSetting    = array('targetGoogleSearch' => $search, 'targetSearchNetwork' => $search, 'targetContentNetwork' => $display);
        $campaign          = array('id' => $campaignId, 'networkSetting' => $networkSetting);
        $campaignOperation = array('operator' => 'SET', 'operand' => $campaign);

        try {
            $rval = $this->CampaignService->mutate(array('operations' => array($campaignOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->UpdateNetwork($campaignId, $search, $display);
            } else {
                return false;
            }
        }
    }

    /**
     * Creates an ad group.
     *
     * @param <type> $campaignId The campaign identifier
     * @param <type> $adGroupName The ad group name
     * @param integer $default_bid The default bid
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function CreateAdGroup($campaignId, $adGroupName, $default_bid)
    {
        $bidAmount        = array('microAmount' => $default_bid * 1000000);
        $contentBidAmount = array('microAmount' => $default_bid * 1000000);
        $cpcBid           = array('bid' => $bidAmount, 'contentBid' => $contentBidAmount);
        $CpcBid           = new SoapVar($cpcBid, XSD_ANYTYPE, 'CpcBid', Consts::ServiceNamespace);
        $biddingStrategy  = array('bids' => array($CpcBid));
        $addGroup         = array('campaignId' => $campaignId, 'name' => $adGroupName, 'biddingStrategyConfiguration' => $biddingStrategy);
        $adGroupOperation = array('operator' => 'ADD', 'operand' => $addGroup);

        try {
            $rval = $this->AdGroupService->mutate(array('operations' => array($adGroupOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->CreateAdGroup($campaignId, $adGroupName, $default_bid);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the interests.
     *
     * @param <type> $adGroupId The ad group identifier
     *
     * @return     boolean  The interests.
     */
    public function GetInterests($adGroupId)
    {
        $fields = array('Id', 'UserInterestId', 'UserInterestName');

        $predicate1 = array(
            'field'    => 'AdGroupId',
            'operator' => 'EQUALS',
            'values'   => array($adGroupId),
        );

        $predicate2 = array(
            'field'    => 'Status',
            'operator' => 'EQUALS',
            'values'   => array('ENABLED'),
        );

        $predicate3 = array(
            'field'    => 'CriteriaType',
            'operator' => 'EQUALS',
            'values'   => array('USER_INTEREST'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2, $predicate3),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->CriterionService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetInterests($adGroupId);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the topics.
     *
     * @param <type> $adGroupId The ad group identifier
     *
     * @return     boolean  The topics.
     */
    public function GetTopics($adGroupId)
    {
        $fields = array('Id', 'VerticalId', 'VerticalParentId', 'Path');

        $predicate1 = array(
            'field'    => 'AdGroupId',
            'operator' => 'EQUALS',
            'values'   => array($adGroupId),
        );

        $predicate2 = array(
            'field'    => 'Status',
            'operator' => 'EQUALS',
            'values'   => array('ENABLED'),
        );

        $predicate3 = array(
            'field'    => 'CriteriaType',
            'operator' => 'EQUALS',
            'values'   => array('VERTICAL'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2, $predicate3),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );
        try {
            $rval = $this->CriterionService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetInterests($adGroupId);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the keywords.
     *
     * @param mixed $adGroupId The ad group identifier
     *
     * @return     array|boolean  The keywords.
     */
    public function GetKeywords($adGroupId)
    {
        $fields = array('Id', 'KeywordText', 'QualityScore');

        $predicate1 = array(
            'field'    => 'AdGroupId',
            'operator' => 'EQUALS',
            'values'   => is_array($adGroupId) ? $adGroupId : array($adGroupId),
        );

        $predicate2 = array(
            'field'    => 'CriterionUse',
            'operator' => 'EQUALS',
            'values'   => array('BIDDABLE'),
        );

        $predicate3 = array(
            'field'    => 'Status',
            'operator' => 'EQUALS',
            'values'   => array('ENABLED'),
        );

        $predicate4 = array(
            'field'    => 'CriteriaType',
            'operator' => 'EQUALS',
            'values'   => array('KEYWORD'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2, $predicate3, $predicate4),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->CriterionService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetKeywords($adGroupId);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the keywords from multiple groups.
     *
     * @param mixed $adGroupId The ad group identifier
     *
     * @return     array|boolean  The keywords.
     */
    public function GetKeywordsFromMultiGroups($adGroupIds, $fields = null)
    {
        $fields = !empty($fields) ? $fields : array('Id', 'KeywordText', 'QualityScore');

        $predicate1 = array(
            'field'    => 'AdGroupId',
            'operator' => 'IN',
            'values'   => is_array($adGroupIds) ? $adGroupIds : array($adGroupIds),
        );

        $predicate2 = array(
            'field'    => 'CriterionUse',
            'operator' => 'EQUALS',
            'values'   => array('BIDDABLE'),
        );

        $predicate3 = array(
            'field'    => 'Status',
            'operator' => 'EQUALS',
            'values'   => array('ENABLED'),
        );

        $predicate4 = array(
            'field'    => 'CriteriaType',
            'operator' => 'EQUALS',
            'values'   => array('KEYWORD'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2, $predicate3, $predicate4),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->CriterionService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetKeywordsFromMultiGroups($adGroupIds, $fields);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the negative keywords.
     *
     * @param <type> $adGroupId The ad group identifier
     *
     * @return     array|boolean  The negative keywords.
     */
    public function GetNegativeKeywords($adGroupId)
    {
        $fields = array('Id', 'KeywordText', 'QualityScore');

        $predicate1 = array(
            'field'    => 'AdGroupId',
            'operator' => 'EQUALS',
            'values'   => array($adGroupId),
        );

        $predicate2 = array(
            'field'    => 'CriterionUse',
            'operator' => 'EQUALS',
            'values'   => array('NEGATIVE'),
        );

        $predicate3 = array(
            'field'    => 'Status',
            'operator' => 'EQUALS',
            'values'   => array('ENABLED'),
        );

        $predicate4 = array(
            'field'    => 'CriteriaType',
            'operator' => 'EQUALS',
            'values'   => array('KEYWORD'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2, $predicate3, $predicate4),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->CriterionService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetNegativeKeywords($adGroupId);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the negative keywords from multiple group.
     *
     * @param <type> $adGroupId The ad group identifier
     *
     * @return     array|boolean  The negative keywords.
     */
    public function GetNegativeKeywordsFromMultiGroups($adGroupIds, $fields = null)
    {
        $fields = !empty($fields) ? $fields : array('Id', 'KeywordText', 'QualityScore');

        $predicate1 = array(
            'field'    => 'AdGroupId',
            'operator' => 'IN',
            'values'   => is_array($adGroupIds) ? $adGroupIds : [$adGroupIds],
        );

        $predicate2 = array(
            'field'    => 'CriterionUse',
            'operator' => 'EQUALS',
            'values'   => array('NEGATIVE'),
        );

        $predicate3 = array(
            'field'    => 'Status',
            'operator' => 'EQUALS',
            'values'   => array('ENABLED'),
        );

        $predicate4 = array(
            'field'    => 'CriteriaType',
            'operator' => 'EQUALS',
            'values'   => array('KEYWORD'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2, $predicate3, $predicate4),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->CriterionService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetNegativeKeywordsFromMultiGroups($adGroupIds, $fields);
            } else {
                return false;
            }
        }
    }

    /**
     * Removes a keyword.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param array $keyword_ids The keyword identifiers
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function RemoveKeyword($adGroupId, $keyword_ids)
    {
        if (!is_array($keyword_ids)) {
            $keyword_ids = array($keyword_ids);
        }

        $operations = [];

        foreach ($keyword_ids as $keyword_id) {
            $adGroupKeywords    = array('id' => $keyword_id);
            $AdGroupKeywords    = new SoapVar($adGroupKeywords, XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
            $criterion          = array('adGroupId' => $adGroupId, 'criterion' => $AdGroupKeywords);
            $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
            $criterionOperation = array('operator' => 'REMOVE', 'operand' => $Criterion);
            $operations[]       = $criterionOperation;
        }

        try {
            $rval = $this->CriterionService->mutate(array('operations' => $operations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->RemoveKeyword($adGroupId, $keyword_id);
            } else {
                return false;
            }
        }
    }

    /**
     * Removes keywords from multiple group if necessary.
     *
     * @param array $keywords ['id' => "keyword id", 'group\_id' => 'group id']
     *
     * @return     array | boolean  ( description_of_the_return_value )
     */
    public function RemoveKeywords($keywords)
    {
        $operations = [];

        foreach ($keywords as $keyword) {
            $adGroupKeywords    = array('id' => $keyword['id']);
            $AdGroupKeywords    = new SoapVar($adGroupKeywords, XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
            $criterion          = array('adGroupId' => $keyword['group_id'], 'criterion' => $AdGroupKeywords);
            $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
            $criterionOperation = array('operator' => 'REMOVE', 'operand' => $Criterion);
            $operations[]       = $criterionOperation;
        }

        try {
            $rval = $this->CriterionService->mutate(array('operations' => $operations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->RemoveKeywords($keywords);
            } else {
                return false;
            }
        }
    }

    /**
     * Removes a negative keyword.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param array $keyword_ids The keyword identifiers
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function RemoveNegativeKeyword($adGroupId, $keyword_ids)
    {
        if (!is_array($keyword_ids)) {
            $keyword_ids = array($keyword_ids);
        }

        $operations = [];

        foreach ($keyword_ids as $keyword_id) {
            $adGroupKeywords    = array('id' => $keyword_id);
            $AdGroupKeywords    = new SoapVar($adGroupKeywords, XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
            $criterion          = array('adGroupId' => $adGroupId, 'criterion' => $AdGroupKeywords);
            $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'NegativeAdGroupCriterion', Consts::ServiceNamespace);
            $criterionOperation = array('operator' => 'REMOVE', 'operand' => $Criterion);
            $operations[]       = $criterionOperation;
        }

        try {
            $rval = $this->CriterionService->mutate(array('operations' => $operations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->RemoveNegativeKeyword($adGroupId, $keyword_id);
            } else {
                return false;
            }
        }
    }

    /**
     * Removes negative keywords from multiple groups.
     *
     * @param array $keywords ['id' => "keyword id", 'group\_id' => 'group id']
     *
     * @return     array | boolean  ( description_of_the_return_value )
     */
    public function RemoveNegativeKeywords($keywords)
    {
        $operations = [];

        foreach ($keywords as $keyword) {
            $adGroupKeywords    = array('id' => $keyword['id']);
            $AdGroupKeywords    = new SoapVar($adGroupKeywords, XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
            $criterion          = array('adGroupId' => $keyword['group_id'], 'criterion' => $AdGroupKeywords);
            $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'NegativeAdGroupCriterion', Consts::ServiceNamespace);
            $criterionOperation = array('operator' => 'REMOVE', 'operand' => $Criterion);
            $operations[]       = $criterionOperation;
        }

        try {
            $rval = $this->CriterionService->mutate(array('operations' => $operations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->RemoveNegativeKeywords($keywords);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the keywords.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param <type> $keywords The keywords
     * @param string $matchType The match type
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function SetKeywords($adGroupId, $keywords, $matchType = 'BROAD')
    {
        $adGroupKeywords    = array('text' => $keywords, 'matchType' => $matchType);
        $AdGroupKeywords    = new SoapVar($adGroupKeywords, XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
        $criterion          = array('adGroupId' => $adGroupId, 'criterion' => $AdGroupKeywords);
        $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
        $criterionOperation = array('operator' => 'ADD', 'operand' => $Criterion);

        try {
            $rval = $this->CriterionService->mutate(array('operations' => array($criterionOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetKeywords($adGroupId, $keywords);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the multiple negative keywords.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param array|string $keywords The keywords
     * @param boolean $isExact Indicates if exact
     *
     * @return     array | boolean       ( description_of_the_return_value )
     */
    public function SetMultipleNegativeKeywords($adGroupId, $keywords, $isExact = false)
    {
        /* it is a quick fix to make all negative key word exact.
        TODO find a better way to handle exact match type
         */

        if (!is_array($keywords)) {
            $matchType = 'EXACT';
            if (1 != preg_match('/^\[.+\]$/', $keywords)) {
                $keywords = "[$keywords]";
            }
            $keywords = ['text' => $keywords, 'matchType' => $matchType];
        }

        $criterionOperations = [];

        foreach ($keywords as $keyword) {
            $AdGroupKeywords       = new SoapVar($keyword, XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
            $criterion             = array('adGroupId' => $adGroupId, 'criterion' => $AdGroupKeywords);
            $Criterion             = new SoapVar($criterion, XSD_ANYTYPE, 'NegativeAdGroupCriterion', Consts::ServiceNamespace);
            $criterionOperations[] = array('operator' => 'ADD', 'operand' => $Criterion);
        }

        try {
            $rval = $this->CriterionService->mutate(array('operations' => $criterionOperations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetNegativeKeywords($adGroupId, $keywords, $isExact);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the multiple keywords.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param array $keywords The keywords
     * @param string $matchType The match type
     *
     * @return     array | boolean  ( description_of_the_return_value )
     */
    public function SetMultipleKeywords($adGroupId, $keywords, $matchType = 'BROAD')
    {
        if (!is_array($keywords)) {
            $keywords = ['text' => $keywords, 'matchType' => $matchType];
        }

        $criterionOperations = [];

        foreach ($keywords as $keyword) {
            $AdGroupKeywords       = new SoapVar($keyword, XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
            $criterion             = array('adGroupId' => $adGroupId, 'criterion' => $AdGroupKeywords);
            $Criterion             = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
            $criterionOperations[] = array('operator' => 'ADD', 'operand' => $Criterion);
        }

        try {
            $rval = $this->CriterionService->mutate(array('operations' => $criterionOperations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetKeywords($adGroupId, $keywords);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the multiple keywords.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param array $keywords The keywords
     * @param string $matchType The match type
     *
     * @return     array | boolean  ( description_of_the_return_value )
     */
    public function SetMultiGroupKeywords($keywords)
    {
        $criterionOperations = [];

        foreach ($keywords as $keyword) {
            $AdGroupKeywords       = new SoapVar(['text' => $keyword['text'], 'matchType' => $keyword['matchType']], XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
            $criterion             = array('adGroupId' => $keyword['group_id'], 'criterion' => $AdGroupKeywords);
            $Criterion             = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
            $criterionOperations[] = array('operator' => 'ADD', 'operand' => $Criterion);
        }

        try {
            $rval = $this->CriterionService->mutate(array('operations' => $criterionOperations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetMultiGroupKeywords($keywords);
            } else {
                return false;
            }
        }
    }

    /**
     * { function_description }
     *
     * @param <type> $adGroupId The ad group identifier
     * @param <type> $keywordId The keyword identifier
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function PauseKeyword($adGroupId, $keywordId)
    {
        $adGroupKeywords    = array('id' => $keywordId);
        $AdGroupKeywords    = new SoapVar($adGroupKeywords, XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
        $criterion          = array('adGroupId' => $adGroupId, 'criterion' => $AdGroupKeywords, 'userStatus' => 'PAUSED');
        $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
        $criterionOperation = array('operator' => 'SET', 'operand' => $Criterion);

        try {
            $rval = $this->CriterionService->mutate(array('operations' => array($criterionOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->PauseKeyword($adGroupId, $keywordId);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the match type.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param <type> $keywordId The keyword identifier
     * @param string $match_type The match type
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function SetMatchType($adGroupId, $keywordId, $match_type = 'EXACT')
    {
        $adGroupKeywords    = array('id' => $keywordId, 'matchType' => $match_type);
        $AdGroupKeywords    = new SoapVar($adGroupKeywords, XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
        $criterion          = array('adGroupId' => $adGroupId, 'criterion' => $AdGroupKeywords, 'userStatus' => 'PAUSED');
        $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
        $criterionOperation = array('operator' => 'SET', 'operand' => $Criterion);

        try {
            $rval = $this->CriterionService->mutate(array('operations' => array($criterionOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->PauseKeyword($adGroupId, $keywordId);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the negative keywords.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param string $keywords The keywords
     * @param boolean $isExact Indicates if exact
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function SetNegativeKeywords($adGroupId, $keywords, $isExact = false)
    {
        /* it is a quick fix to make all negative key word exact.
        TODO find a better way to handle exact match type
         */
        // $matchType          = 'PHRASE';
        // if($isExact) $matchType = 'EXACT';
        $matchType = 'EXACT';

        if (1 != preg_match('/^\[.+\]$/', $keywords)) {
            $keywords = "[$keywords]";
        }
        $adGroupKeywords    = array('text' => $keywords, 'matchType' => $matchType);
        $AdGroupKeywords    = new SoapVar($adGroupKeywords, XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
        $criterion          = array('adGroupId' => $adGroupId, 'criterion' => $AdGroupKeywords);
        $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'NegativeAdGroupCriterion', Consts::ServiceNamespace);
        $criterionOperation = array('operator' => 'ADD', 'operand' => $Criterion);

        try {
            $rval = $this->CriterionService->mutate(array('operations' => array($criterionOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetNegativeKeywords($adGroupId, $keywords, $isExact);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the multiple negative keywords.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param array|string $keywords The keywords
     * @param boolean $isExact Indicates if exact
     *
     * @return     array | boolean       ( description_of_the_return_value )
     */
    public function SetMultiGroupNegativeKeywords($keywords)
    {
        $criterionOperations = [];

        foreach ($keywords as $keyword) {
            $AdGroupKeywords       = new SoapVar(['text' => $keyword['text'], 'matchType' => $keyword['matchType']], XSD_ANYTYPE, 'Keyword', Consts::ServiceNamespace);
            $criterion             = array('adGroupId' => $keyword['group_id'], 'criterion' => $AdGroupKeywords);
            $Criterion             = new SoapVar($criterion, XSD_ANYTYPE, 'NegativeAdGroupCriterion', Consts::ServiceNamespace);
            $criterionOperations[] = array('operator' => 'ADD', 'operand' => $Criterion);
        }

        try {
            $rval = $this->CriterionService->mutate(array('operations' => $criterionOperations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetMultiGroupNegativeKeywords($keywords);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the placements.
     *
     * @param <type> $campaignId The campaign identifier
     *
     * @return     boolean  The placements.
     */
    public function GetPlacements($campaignId)
    {
        $fields = array('Id', 'PlacementUrl', 'IsNegative');

        $predicate1 = array(
            'field'    => 'CampaignId',
            'operator' => 'EQUALS',
            'values'   => array($campaignId),
        );

        $predicate2 = array(
            'field'    => 'CriteriaType',
            'operator' => 'EQUALS',
            'values'   => array('PLACEMENT'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->CampaignCriterionService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetPlacements($campaignId);
            } else {
                return false;
            }
        }
    }

    /**
     * { function_description }
     *
     * @param <type> $campaignId The campaign identifier
     * @param array $urls The urls
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function ExcludePlacement($campaignId, $urls)
    {
        if (!is_array($urls)) {
            $urls = array($urls);
        }

        $operations = [];

        foreach ($urls as $url) {
            $placement          = array('url' => $url);
            $Placement          = new SoapVar($placement, XSD_ANYTYPE, 'Placement', Consts::ServiceNamespace);
            $criterion          = array('campaignId' => $campaignId, 'criterion' => $Placement);
            $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'NegativeCampaignCriterion', Consts::ServiceNamespace);
            $criterionOperation = array('operator' => 'ADD', 'operand' => $Criterion);
            $operations[]       = $criterionOperation;
        }

        try {
            $rval = $this->CampaignCriterionService->mutate(array('operations' => $operations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->ExcludePlacement($campaignId, $url);
            } else {
                return false;
            }
        }
    }

    /**
     * Enables the retargeting.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param <type> $userListId The user list identifier
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function EnableRetargeting($adGroupId, $userListId)
    {
        $userListCriterion  = array('userListId' => $userListId);
        $UserListCriterion  = new SoapVar($userListCriterion, XSD_ANYTYPE, 'CriterionUserList', Consts::ServiceNamespace);
        $criterion          = array('adGroupId' => $adGroupId, 'criterion' => $UserListCriterion);
        $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
        $criterionOperation = array('operator' => 'ADD', 'operand' => $Criterion);

        try {
            $rval = $this->CriterionService->mutate(array('operations' => array($criterionOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->EnableRetargeting($adGroupId, $userListId);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the user interest.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param <type> $userInterestId The user interest identifier
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function SetUserInterest($adGroupId, $userInterestId)
    {
        $userInterestCriterion = array('userInterestId' => $userInterestId);
        $UserInterestCriterion = new SoapVar($userInterestCriterion, XSD_ANYTYPE, 'CriterionUserInterest', Consts::ServiceNamespace);
        $criterion             = array('adGroupId' => $adGroupId, 'criterion' => $UserInterestCriterion);
        $Criterion             = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
        $criterionOperation    = array('operator' => 'ADD', 'operand' => $Criterion);

        try {
            $rval = $this->CriterionService->mutate(array('operations' => array($criterionOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetUserInterest($adGroupId, $userInterestId);
            } else {
                return false;
            }
        }
    }

    /**
     * Creates an user list.
     *
     * @param string $userListName The user list name
     *
     * @return     object | boolean  ( description_of_the_return_value )
     */
    public function CreateUserList($userListName)
    {
        $userListConversionType = array('name' => $userListName . ' - ' . time());
        $basicUserList          = array(
            'name'               => $userListName . ' - ' . time(),
            'description'        => 'A list of ' . $userListName . ' customers',
            'status'             => 'OPEN',
            'membershipLifeSpan' => 365,
            'conversionTypes'    => array($userListConversionType),
        );
        $BasicUserList     = new SoapVar($basicUserList, XSD_ANYTYPE, 'BasicUserList', Consts::UserListServiceNamespace);
        $userListOperation = array('operator' => 'ADD', 'operand' => $BasicUserList);

        try {
            $rval = $this->UserListService->mutate(array('operations' => array($userListOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->CreateUserList($userListName);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the user lists.
     *
     * @return     boolean  The user lists.
     */
    public function GetUserLists()
    {
        $fields = array('Id', 'Name', 'Status', 'ConversionTypes');

        $predicate1 = array(
            'field'    => 'AccessReason',
            'operator' => 'EQUALS',
            'values'   => array('OWNED'),
        );

        $predicate2 = array(
            'field'    => 'Status',
            'operator' => 'EQUALS',
            'values'   => array('OPEN'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2),
        );

        try {
            $rval = $this->UserListService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetUserLists();
            } else {
                return false;
            }
        }
    }

    /**
     * { function_description }
     *
     * @param <type> $id The identifier
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function DeleteUserList($id)
    {
        $userList  = array('id' => $id, 'status' => 'CLOSED');
        $Operation = array('operator' => 'SET', 'operand' => $userList);

        try {
            $rval = $this->UserListService->mutate(array('operations' => array($Operation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->DeleteUserList($id);
            } else {
                return false;
            }
        }
    }

    /**
     * { function_description }
     *
     * @param <type> $id The identifier
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function DeleteConversionTracker($id)
    {
        $adWordsConversionTracker = array('id' => $id, 'status' => 'DISABLED');
        $AdWordsConversionTracker = new SoapVar($adWordsConversionTracker, XSD_ANYTYPE, 'AdWordsConversionTracker', Consts::ServiceNamespace);
        $Operation                = array('operator' => 'SET', 'operand' => $AdWordsConversionTracker);

        try {
            $rval = $this->ConversionTrackerService->mutate(array('operations' => array($Operation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->DeleteConversionTracker($id);
            } else {
                return false;
            }
        }
    }

    /**
     * Creates a combined user list.
     *
     * @param string $userListName The user list name
     * @param <type> $basicListId The basic list identifier
     *
     * @return     object | boolean  ( description_of_the_return_value )
     */
    public function CreateCombinedUserList($userListName, $basicListId)
    {
        $basicUserList = array('id' => $basicListId);
        $BasicUserList = new SoapVar($basicUserList, XSD_ANYTYPE, 'BasicUserList', Consts::UserListServiceNamespace);

        $operand = array("UserList" => $BasicUserList, "UserInterest" => null);

        $rule = array(
            'operator'     => 'ANY',
            'ruleOperands' => array($operand),
        );

        $logicalUserList = array(
            'name'  => $userListName . ' - ' . time(),
            'rules' => array($rule),
        );

        $LogicalUserList   = new SoapVar($logicalUserList, XSD_ANYTYPE, 'LogicalUserList', Consts::UserListServiceNamespace);
        $userListOperation = array('operator' => 'ADD', 'operand' => $LogicalUserList);

        try {
            $rval = $this->UserListService->mutate(array('operations' => array($userListOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->CreateCombinedUserList($userListName, $basicListId);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the combined user list.
     *
     * @param <type> $userListId The user list identifier
     *
     * @return mixed  The combined user list.
     */
    public function GetCombinedUserList($userListId)
    {
        $fields = array('Id', 'Rules');

        $predicate = array(
            'field'    => 'Id',
            'operator' => 'EQUALS',
            'values'   => array($userListId),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate),
        );

        try {
            $rval = $this->UserListService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetCombinedUserList($userListId);
            } else {
                return false;
            }
        }
    }

    /**
     * Appends a combined user list.
     *
     * @param <type> $userListId The user list identifier
     * @param <type> $basicListId The basic list identifier
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function AppendCombinedUserList($userListId, $basicListId)
    {
        $result = $this->GetCombinedUserList($userListId);

        if (!$result || count($result) == 0) {
            return false;
        }

        $operands                   = $result[0]->rules[0]->ruleOperands;
        $basicUserList              = array('id' => $basicListId);
        $BasicUserList              = new SoapVar($basicUserList, XSD_ANYTYPE, 'BasicUserList', Consts::UserListServiceNamespace);
        $operand                    = array("UserList" => $BasicUserList, "UserInterest" => null);
        $operands[count($operands)] = $operand;

        $rule = array(
            'operator'     => 'ANY',
            'ruleOperands' => $operands,
        );

        $logicalUserList = array(
            'id'    => $userListId,
            'rules' => array($rule),
        );

        $LogicalUserList   = new SoapVar($logicalUserList, XSD_ANYTYPE, 'LogicalUserList', Consts::UserListServiceNamespace);
        $userListOperation = array('operator' => 'SET', 'operand' => $LogicalUserList);

        try {
            $rval = $this->UserListService->mutate(array('operations' => array($userListOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->AppendCombinedUserList($userListId, $basicListId);
            } else {
                return false;
            }
        }
    }

    /**
     * Gets the conversion tracker.
     *
     * @param <type> $conversionId The conversion identifier
     *
     * @return     boolean  The conversion tracker.
     */
    public function GetConversionTracker($conversionId)
    {
        $fields = array('Id');

        $predicate = array(
            'field'    => 'Id',
            'operator' => 'IN',
            'values'   => array($conversionId),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate),
        );

        try {
            $rval = $this->ConversionTrackerService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetConversionTracker($conversionId);
            } else {
                return false;
            }
        }
    }

    /**
     * { function_description }
     *
     * @param <type> $adGroupId The ad group identifier
     * @param float|integer $bid The bid
     *
     * @return     boolean        ( description_of_the_return_value )
     */
    public function UpdateAdGroupBid($adGroupId, $bid = 2.0)
    {
        $bidAmount        = array('microAmount' => $bid * 1000000);
        $contentBidAmount = array('microAmount' => $bid * 1000000);
        $cpcBid           = array('bid' => $bidAmount, 'contentBid' => $contentBidAmount);
        $CpcBid           = new SoapVar($cpcBid, XSD_ANYTYPE, 'CpcBid', Consts::ServiceNamespace);
        $biddingStrategy  = array('bids' => array($CpcBid));
        $addGroup         = array('id' => $adGroupId, 'biddingStrategyConfiguration' => $biddingStrategy);
        $adGroupOperation = array('operator' => 'SET', 'operand' => $addGroup);

        try {
            $rval = $this->AdGroupService->mutate(array('operations' => array($adGroupOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->UpdateAdGroupBid($adGroupId, $bid);
            } else {
                return false;
            }
        }
    }

    /**
     * Removes an ad group.
     *
     * @param <type> $adGroupId The ad group identifier
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function RemoveAdGroup($adGroupId)
    {
        $addGroup         = array('id' => $adGroupId, 'status' => 'REMOVED');
        $adGroupOperation = array('operator' => 'SET', 'operand' => $addGroup);

        try {
            $rval = $this->AdGroupService->mutate(array('operations' => array($adGroupOperation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->RemoveAdGroup($adGroupId);
            } else {
                return false;
            }
        }
    }

    /**
     * Creates an ad.
     *
     * @param <type> $ad_group_id The ad group identifier
     * @param <type> $url The url
     * @param <type> $display_url The display url
     * @param <type> $headline The headline
     * @param <type> $headline2 The headline 2
     * @param <type> $headline3 The headline 3
     * @param <type> $description The description
     * @param <type> $description2 The description 2
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function CreateAd($ad_group_id, $url, $display_url, $headline, $headline2, $headline3, $description, $description2)
    {
        // @TODO: Need to modify configs and system to support two headline and a description
        $text_ad      = array('finalUrls' => array($url), 'headlinePart1' => $headline, 'headlinePart2' => $headline2, 'headlinePart3' => $headline3, 'description' => $description, 'description2' => $description2);
        $TextAd       = new SoapVar($text_ad, XSD_ANYTYPE, 'ExpandedTextAd', Consts::ServiceNamespace);
        $ad_group_ad  = array('adGroupId' => $ad_group_id, 'ad' => $TextAd, 'status' => 'ENABLED');
        $ad_operation = array('operator' => 'ADD', 'operand' => $ad_group_ad);

        try {
            $rval = $this->AdService->mutate(array('operations' => array($ad_operation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->ad->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->CreateAd($ad_group_id, $url, $display_url, $headline, $headline2, $headline3, $description, $description2);
            } else {
                return false;
            }
        }
    }

    public function CreateAds($ads_data)
    {
        $ad_operations = array_map(function ($v) {
            $text_ad = array(
                'finalUrls'     => $v->ad["urls"],
                'headlinePart1' => $v->ad["title"],
                'headlinePart2' => $v->ad["title_2"],
                'headlinePart3' => $v->ad["title_3"],
                'description'   => $v->ad["description"],
                'description2'  => $v->ad["description_2"],
            );
            $TextAd      = new SoapVar($text_ad, XSD_ANYTYPE, 'ExpandedTextAd', Consts::ServiceNamespace);
            $ad_group_ad = array('adGroupId' => $v->adGroupId, 'ad' => $TextAd, 'status' => 'ENABLED');
            return array('operator' => 'ADD', 'operand' => $ad_group_ad);
        }, $ads_data);

        try {
            $rval = $this->AdService->mutate(array('operations' => $ad_operations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->CreateAds($ads_data);
            } else {
                return false;
            }
        }
    }

    /**
     * Creates an image ad.
     *
     * @param <type> $ad_group_id The ad group identifier
     * @param <type> $url The url
     * @param <type> $display_url The display url
     * @param <type> $headline The headline
     * @param <type> $image_data The image data
     * @param <type> $width The width
     * @param <type> $height The height
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function CreateImageAd($ad_group_id, $url, $display_url, $headline, $image_data, $width, $height)
    {
        slecho("Image add URL is ==> {$url}");
        $dimensions = array(array("key" => "FULL", "value" => array("width" => $width, "height" => $height)));
        $image      = array("dimensions" => $dimensions, "name" => $headline, 'data' => $image_data);
        $Image      = new SoapVar($image, XSD_ANYTYPE, 'Image', Consts::ServiceNamespace);

        $image_ad     = array('finalUrls' => array($url), 'displayUrl' => $display_url, 'image' => $Image, 'name' => $headline);
        $ImageAd      = new SoapVar($image_ad, XSD_ANYTYPE, 'ImageAd', Consts::ServiceNamespace);
        $ad_group_ad  = array('adGroupId' => $ad_group_id, 'ad' => $ImageAd, 'status' => 'ENABLED');
        $ad_operation = array('operator' => 'ADD', 'operand' => $ad_group_ad);

        try {
            $rval = $this->AdService->mutate(array('operations' => array($ad_operation)));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->ad->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->CreateImageAd($ad_group_id, $url, $display_url, $headline, $image_data, $width, $height);
            } else {
                return false;
            }
        }
    }

    /**
     * Removes an ad.
     *
     * @param <type> $ad_group_id The ad group identifier
     * @param array $ad_ids The ad identifiers
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function RemoveAd($ad_group_id, $ad_ids)
    {
        if (!is_array($ad_ids)) {
            $ad_ids = array($ad_ids);
        }

        $operations = [];

        foreach ($ad_ids as $ad_id) {
            $text_ad      = array('id' => $ad_id);
            $ad_group_ad  = array('adGroupId' => $ad_group_id, 'ad' => $text_ad, 'status' => 'ENABLED');
            $ad_operation = array('operator' => 'REMOVE', 'operand' => $ad_group_ad);
            $operations[] = $ad_operation;
        }

        try {
            $rval = $this->AdService->mutate(array('operations' => $operations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0]->ad->id;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->RemoveAd($ad_group_id, $ad_id);
            } else {
                return false;
            }
        }
    }

    ############################################################################################################################
    #   Adgroup Placements
    ############################################################################################################################

    /**
     * Gets the ad group placements.
     *
     * @param <type> $adGroupId The ad group identifier
     *
     * @return mixed  The ad group placements.
     */
    public function GetAdGroupPlacements($adGroupId)
    {
        $fields = array('Id', 'PlacementUrl', 'QualityScore');

        $predicate1 = array(
            'field'    => 'AdGroupId',
            'operator' => 'EQUALS',
            'values'   => array($adGroupId),
        );

        $predicate2 = array(
            'field'    => 'CriterionUse',
            'operator' => 'EQUALS',
            'values'   => array('BIDDABLE'),
        );

        $predicate3 = array(
            'field'    => 'Status',
            'operator' => 'EQUALS',
            'values'   => array('ENABLED'),
        );

        $predicate4 = array(
            'field'    => 'CriteriaType',
            'operator' => 'EQUALS',
            'values'   => array('PLACEMENT'),
        );

        $selector = array(
            'fields'     => $fields,
            'predicates' => array($predicate1, $predicate2, $predicate3, $predicate4),
            'dateRange'  => null,
            'ordering'   => null,
            'paging'     => null,
        );

        try {
            $rval = $this->CriterionService->get(array('serviceSelector' => $selector));
            if (isset($rval->rval->entries)) {
                return $rval->rval->entries;
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->GetAdGroupPlacements($adGroupId);
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the ad group placements.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param <type> $urls The urls
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function SetAdGroupPlacements($adGroupId, $urls)
    {
        $criterionOperations = array('operations' => []);

        foreach ($urls as $url) {
            $adGroupPlacements                   = array('url' => $url);
            $AdGroupPlacements                   = new SoapVar($adGroupPlacements, XSD_ANYTYPE, 'Placement', Consts::ServiceNamespace);
            $criterion                           = array('adGroupId' => $adGroupId, 'criterion' => $AdGroupPlacements);
            $Criterion                           = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
            $criterionOperation                  = array('operator' => 'ADD', 'operand' => $Criterion);
            $criterionOperations['operations'][] = $criterionOperation;
        }

        try {
            $rval = $this->CriterionService->mutate($criterionOperations);

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->SetAdGroupPlacements($adGroupId, $urls);
            } else {
                return false;
            }
        }
    }

    /**
     * Removes ad group placements.
     *
     * @param <type> $adGroupId The ad group identifier
     * @param array $placement_ids The placement identifiers
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function RemoveAdGroupPlacements($adGroupId, $placement_ids)
    {
        if (!is_array($placement_ids)) {
            $placement_ids = array($placement_ids);
        }

        $operations = [];

        foreach ($placement_ids as $placement_id) {
            $adGroupPlacements  = array('id' => $placement_id);
            $AdGroupPlacements  = new SoapVar($adGroupPlacements, XSD_ANYTYPE, 'Placement', Consts::ServiceNamespace);
            $criterion          = array('adGroupId' => $adGroupId, 'criterion' => $AdGroupPlacements);
            $Criterion          = new SoapVar($criterion, XSD_ANYTYPE, 'BiddableAdGroupCriterion', Consts::ServiceNamespace);
            $criterionOperation = array('operator' => 'REMOVE', 'operand' => $Criterion);
            $operations[]       = $criterionOperation;
        }

        try {
            $rval = $this->CriterionService->mutate(array('operations' => $operations));

            if (isset($rval->rval->value)) {
                return $rval->rval->value[0];
            } else {
                return false;
            }
        } catch (SoapFault $ex) {
            if ($this->HandleSoapFault($ex)) {
                return $this->RemoveAdGroupPlacements($adGroupId, $placement_ids);
            } else {
                return false;
            }
        }
    }

    ############################################################################################################################
    #   Reporting
    ############################################################################################################################

    /**
     * Gets during.
     *
     * @param <type> $on15 On 15
     * @param <type> $range The range
     *
     * @return     string  During.
     */
    private function GetDuring($on15, $range)
    {
        $during = '';

        if ($range) {
            $from = strtotime($range['start']);
            $end  = strtotime($range['end']) + 86400;
            $to   = min(array(time(), $end));

            $during = date('Ymd', $from) . ',' . date('Ymd', $to);
        } elseif ($on15) {
            $day = date('j');

            if ($day > 15) {
                $to     = time() + (86400);
                $during = date('Ym') . '16,' . date('Ymd', $to);

                $from = mktime(0, 0, 0, date('n'), 16, date('Y'));

                $days_past      = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y')) - 15;
                $days_remaining = 15 + cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y')) - date('d');
            } else {
                $to = time() + (86400);

                $month = date('n') - 1 == 0 ? 12 : date('n') - 1;
                $year  = $month == 12 ? date('Y') - 1 : date('Y');

                $from = mktime(0, 0, 0, $month, 16, $year);

                $during = date('Ymd', $from) . ',' . date('Ymd', $to);

                $days_past      = cal_days_in_month(CAL_GREGORIAN, $month, $year) - 15 + date('d');
                $days_remaining = 15 - date('d');
            }
        } else {
            $from   = mktime(0, 0, 0, date('n'), 1, date('Y'));
            $to     = time() + (686400);
            $during = date('Ym') . '01,' . date('Ymd', $to);

            $days_past      = date('d');
            $days_remaining = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y')) - date('d');
        }

        return $during;
    }

    /**
     * Gets the account cost.
     *
     * @param boolean $on15 On 15
     * @param boolean $range The range
     *
     * @return     array | boolean   The account cost.
     */
    public function GetAccountCost($on15 = false, $range = false)
    {
        $during = $this->GetDuring($on15, $range);
        $query  = "SELECT CampaignId, CampaignName, CampaignStatus, Impressions, Clicks, Cost, Ctr FROM CAMPAIGN_PERFORMANCE_REPORT WHERE Impressions > 0 DURING " . $during;

        return $this->DownloadReport($query);
    }

    /*
     * @min_impression  :   impression is grater than given value @max_ctr
     * :   ctr is less than given value
     *
     * Gets the ad group performance.
     *
     * @param      integer|string  $min_impression  The minimum impression
     * @param      bool            $on15            On 15
     * @param      bool            $range           The range
     *
     * @return     mixed           The ad group performance.
     */
    public function GetAdGroupPerformance($min_impression = 0, $on15 = false, $range = false)
    {
        $during = $this->GetDuring($on15, $range);
        $query  = "SELECT AdGroupId, AdGroupName, AdGroupStatus, CampaignName, CampaignId, Clicks, Impressions, Ctr, Cost, BounceRate FROM ADGROUP_PERFORMANCE_REPORT WHERE AdGroupStatus != REMOVED AND Impressions > " . $min_impression . " DURING " . $during;

        return $this->DownloadReport($query);
    }

    /*
     * Creat By rabbi
     * Return AdGroup Cost
     *
     * Gets the ad group performance cost.
     *
     * @param      <type>          $on15            On 15
     * @param      <type>          $range           The range
     * @param      integer|string  $min_impression  The minimum impression
     *
     * @return     mixed          The ad group performance cost.
     */
    public function GetAdGroupPerformanceCost($on15, $range, $min_impression = 0)
    {
        $during = $this->GetDuring($on15, $range);
        $query  = "SELECT AdGroupId, AdGroupName, AdGroupStatus, CampaignName, CampaignId, Clicks, Impressions, Ctr, Cost, BounceRate FROM ADGROUP_PERFORMANCE_REPORT WHERE AdGroupStatus != REMOVED AND Impressions > " . $min_impression . " DURING " . $during;

        return $this->DownloadReport($query);
    }

    /**
     * Gets the keyword performance.
     *
     * @param string $network_type The network type
     * @param integer|string $min_impression The minimum impression
     * @param integer|string $max_ctr The maximum counter
     *
     * @return     mixed          The keyword performance.
     */
    public function GetKeywordPerformance($network_type = 'SEARCH', $min_impression = 0, $max_ctr = 0)
    {
        $today = date('Ymd');
        $from  = date('Ymd', time() - (60 * 60 * 24 * 365));
        $query = "SELECT Id, KeywordText, AdGroupId, CampaignName, Impressions, Ctr FROM KEYWORDS_PERFORMANCE_REPORT WHERE Status = ENABLED AND AdGroupStatus = ENABLED AND CampaignStatus = ENABLED AND Impressions > " . $min_impression . " AND Ctr < " . $max_ctr . " AND AdNetworkType1 = " . $network_type . " DURING " . $from . "," . $today;

        return $this->DownloadReport($query);
    }

    /**
     * Gets the keyword performance.
     *
     * @param string $network_type The network type
     * @param integer|string $min_impression The minimum impression
     * @param integer|string $max_ctr The maximum counter
     *
     * @return mixed          The keyword performance.
     */
    public function GetKeywordPerformanceByNewwork($during)
    {
        $query = "SELECT AdNetworkType2, Impressions FROM KEYWORDS_PERFORMANCE_REPORT DURING " . $during;
        return $this->DownloadReport($query);
    }

    public function GetCampaignPerformanceByNewwork($during)
    {
        $query = "SELECT AdNetworkType2, Impressions FROM CAMPAIGN_PERFORMANCE_REPORT DURING " . $during;
        return $this->DownloadReport($query);
    }

    /**
     * Gets the paused ad groups.
     *
     * @return mixed  The paused ad groups.
     */
    public function GetPausedAdGroups()
    {
        $today = date('Ymd');
        $from  = date('Ymd', time() - (31536000)); // 60 * 60 * 24 * 365 = 31536000
        $query = "SELECT AdGroupId, AdGroupName, CampaignName, Impressions, Ctr FROM ADGROUP_PERFORMANCE_REPORT WHERE Status = PAUSED DURING " . $from . "," . $today;

        return $this->DownloadReport($query);
    }

    /**
     * Gets the report.
     *
     * @param boolean $on15 On 15
     * @param boolean $range The range
     *
     * @return mixed   The report.
     */
    public function GetReport($on15 = false, $range = false)
    {
        $during = 'LAST_MONTH';

        if ($range) {
            $from = strtotime($range['start']);
            $end  = strtotime($range['end']) + 86400;
            $to   = min(array(time(), $end));

            $during = date('Ymd', $from) . ',' . date('Ymd', $to);
        } elseif ($on15) {
            $today          = '';
            $first_of_month = '';
            $day            = date('j');

            if ($day < 15) {
                $year  = date('Y');
                $month = date('n');

                if ($month == 1) {
                    $year  = $year - 1;
                    $month = 12;
                } else {
                    $month = $month - 1;
                }

                $time  = mktime(0, 0, 0, $month, 16, $year);
                $today = date('Ymd', $time);

                // one month ago
                if ($month == 1) {
                    $year  = $year - 1;
                    $month = 12;
                } else {
                    $month = $month - 1;
                }

                $time           = mktime(0, 0, 0, $month, 16, $year);
                $first_of_month = date('Ymd', $time);
            } else {
                $today = date('Ym') . '16';
                $year  = date('Y');
                $month = date('n');

                if ($month == 1) {
                    $year  = $year - 1;
                    $month = 12;
                } else {
                    $month = $month - 1;
                }

                $time           = mktime(0, 0, 0, $month, 16, $year);
                $first_of_month = date('Ymd', $time);
            }

            $during = $first_of_month . ',' . $today;
        }

        $query = 'SELECT CampaignId, CampaignName, Impressions, Clicks, Cost, Ctr FROM CAMPAIGN_PERFORMANCE_REPORT WHERE Impressions > 0 DURING ' . $during;

        return $this->DownloadReport($query);
    }

    /**
     * Gets the ranged report.
     *
     * @param <type> $during During
     *
     * @return mixed  The ranged report.
     */
    public function GetRangedReport($during)
    {
        $query = 'SELECT CampaignId, CampaignName, Impressions, Clicks, Cost, Amount, BudgetId, Ctr FROM CAMPAIGN_PERFORMANCE_REPORT WHERE Impressions > 0 DURING ' . $during;

        return $this->DownloadReport($query);
    }

    /**
     * Gets the ranged report.
     *
     * @param <type> $during During
     *
     * @return mixed  The ranged report.
     */
    public function GetROIReport($during)
    {
        $query = 'SELECT CampaignId, CampaignName, Impressions, Clicks, Cost, Ctr, AverageCpc, SearchExactMatchImpressionShare,
                SearchImpressionShare,SearchBudgetLostImpressionShare, SearchRankLostImpressionShare,
                ContentImpressionShare, ContentBudgetLostImpressionShare, ContentRankLostImpressionShare
                FROM CAMPAIGN_PERFORMANCE_REPORT WHERE Impressions > 0 DURING ' . $during;
        return $this->DownloadReport($query);
    }

    /**
     * Gets the roi report overview.
     *
     * @param      <type>  $during  During
     *
     * @return mixed  The roi report overview.
     */
    public function GetROIReportOverview($during)
    {
        $query = 'SELECT Impressions, Clicks, Cost, Conversions
        FROM CAMPAIGN_PERFORMANCE_REPORT WHERE Impressions > 0 DURING ' . $during;
        return $this->DownloadReport($query);
    }

    /**
     * Gets the account ranged report.
     *
     * @param <type> $during During
     *
     * @return mixed  The account ranged report.
     */
    public function GetAccountRangedReport($during)
    {
        $query = 'SELECT AccountDescriptiveName, Impressions, Clicks, Cost, Ctr FROM ACCOUNT_PERFORMANCE_REPORT WHERE Impressions > 0 DURING ' . $during;

        return $this->DownloadReport($query);
    }

    /**
     * Gets the car performance.
     *
     * @param boolean $on15 On 15
     * @param boolean $range The range
     *
     * @return mixed   The car performance.
     */
    public function GetCarPerformance($on15 = false, $range = false)
    {
        $during = 'LAST_MONTH';

        if ($range) {
            $from = strtotime($range['start']);
            $end  = strtotime($range['end']) + 86400;
            $to   = min(array(time(), $end));

            $during = date('Ymd', $from) . ',' . date('Ymd', $to);
        } elseif ($on15) {
            $today          = '';
            $first_of_month = '';
            $day            = date('j');

            if ($day < 15) {
                $year  = date('Y');
                $month = date('n');

                if ($month == 1) {
                    $year  = $year - 1;
                    $month = 12;
                } else {
                    $month = $month - 1;
                }

                $time  = mktime(0, 0, 0, $month, 15, $year);
                $today = date('Ymd', $time);

                // one month ago
                if ($month == 1) {
                    $year  = $year - 1;
                    $month = 12;
                } else {
                    $month = $month - 1;
                }

                $time           = mktime(0, 0, 0, $month, 15, $year);
                $first_of_month = date('Ymd', $time);
            } else {
                $today = date('Ym') . '15';
                $year  = date('Y');
                $month = date('n');

                if ($month == 1) {
                    $year  = $year - 1;
                    $month = 12;
                } else {
                    $month = $month - 1;
                }

                $time           = mktime(0, 0, 0, $month, 15, $year);
                $first_of_month = date('Ymd', $time);
            }

            $during = $first_of_month . ',' . $today;
        }

        $query = 'SELECT AdGroupId, AdGroupName, Impressions FROM ADGROUP_PERFORMANCE_REPORT WHERE Impressions > 0 AND AdNetworkType1 = SEARCH DURING ' . $during;

        return $this->DownloadReport($query);
    }

    /**
     * Downloads a report.
     *
     * @param string $query The query
     *
     * @return mixed  ( description_of_the_return_value )
     */
    private function DownloadReport($query)
    {
        $post_fields = "__rdquery=" . $query . "&__fmt=CSV";

        // Initialize curl request
        $curl = curl_init();

        // configure curl
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, Consts::ReportDownloadURL);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->access_token->Token,
            'developerToken: ' . $this->developer_token,
            'clientCustomerId: ' . $this->customer_id,
        ));
        curl_setopt($curl, CURLOPT_USERAGENT, 'smedia adsync 3');

        // execute curl request
        $data = curl_exec($curl);

        // close curl request
        curl_close($curl);

        if (stripos($data, 'OAUTH_TOKEN_INVALID') !== false) {
            global $google_config, $Configs, $customer, $CurrentConfig, $set_path;

            $token_helper = new TokenHelper();
            $access_token = $token_helper->RefreshAccessToken($google_config, $CurrentConfig);

            if ($access_token) {
                $CurrentConfig                    = $access_token;
                $Configs->AccessTokens[$customer] = $CurrentConfig;
                SaveConfig($Configs, $set_path);
                slecho("Info: Access token renewed.");
                $this->access_token = $CurrentConfig;
                $this->Init();
                return $this->DownloadReport($query);
            } else {
                return false;
            }
        }

        return $data ? $this->csv_real_decode($data) : false;
    }

    /**
     * { function_description }
     *
     * @param <type> $data The data
     *
     * @return     array   ( description_of_the_return_value )
     */
    private function csv_real_decode($data)
    {
        $result   = [];
        $lines    = explode("\n", $data);
        $headings = explode(',', $lines[1]);

        for ($i = 2, $line_count = count($lines); $i < $line_count; $i++) {
            if (!$lines[$i]) {
                continue;
            }

            $result[$i - 2] = [];
            $elems          = explode(',', $lines[$i]);
            $index          = 0;
            $quote          = false;

            for ($j = 0, $elem_count = count($elems); $j < $elem_count; $j++) {
                if ($elems[$j][0] == '"') {
                    $quote     = true;
                    $elems[$j] = substr($elems[$j], 1);
                }

                if ($quote) {
                    $result[$i - 2][$headings[$index]] .= $elems[$j];

                    if ($elems[$j][strlen($elems[$j]) - 1] == '"') {
                        $result[$i - 2][$headings[$index]] = substr($result[$i - 2][$headings[$index]], 0, strlen($result[$i - 2][$headings[$index]]) - 1);
                        $quote                             = false;
                    }
                } else {
                    $result[$i - 2][$headings[$index]] = $elems[$j];
                }

                if (!$quote) {
                    $index++;
                }
            }
        }

        return $result;
    }

    /**
     * { function_description }
     *
     * @param SoapFault $ex { parameter_description }
     *
     * @return     boolean    ( description_of_the_return_value )
     */
    protected function HandleSoapFault(SoapFault $ex)
    {
        global $google_config, $Configs, $customer, $CurrentConfig, $set_path;

        $reason = @$ex->detail->ApiExceptionFault->errors->enc_value->reason;

        if ($reason == 'OAUTH_TOKEN_INVALID') {
            $token_helper = new TokenHelper();
            $access_token = $token_helper->RefreshAccessToken($google_config, $CurrentConfig);

            if ($access_token) {
                $CurrentConfig                    = $access_token;
                $Configs->AccessTokens[$customer] = $CurrentConfig;
                SaveConfig($Configs, $set_path);
                slecho("Info: Access token renewed.");
                $this->access_token = $CurrentConfig;
                $this->Init();
                return true;
            } else {
                die("ERROR: Unable to renew access token after token has expired.");
            }
        } elseif ($reason == 'RATE_EXCEEDED') {
            $waitSeconds = isset($ex->detail->ApiExceptionFault->errors->enc_value->retryAfterSeconds) ? $ex->detail->ApiExceptionFault->errors->enc_value->retryAfterSeconds + 1 : 5;
            slecho("Rate Limit Exceeded: Need to wait {$waitSeconds} seconds before retry.");
            sleep($waitSeconds);
            return true;
        } else {
			$eo = json_encode([
				$ex,
				array_map(function ($v) {
					return [$v["file"], $v["line"]];
				}, debug_backtrace())
			]);
			slecho($eo, 'error');
            return false;
        }
    }
}
