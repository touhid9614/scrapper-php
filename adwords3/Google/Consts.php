<?php

/**
 * This class describes consts.
 */
class Consts
{
    const CampaignServiceWsdl          = 'https://adwords.google.com/api/adwords/cm/v201809/CampaignService?wsdl';
    const CampaignCriterionServiceWsdl = 'https://adwords.google.com/api/adwords/cm/v201809/CampaignCriterionService?wsdl';
    const AdGroupServiceWsdl           = 'https://adwords.google.com/api/adwords/cm/v201809/AdGroupService?wsdl';
    const CriterionServiceWsdl         = 'https://adwords.google.com/api/adwords/cm/v201809/AdGroupCriterionService?wsdl';
    const AdGroupAdServiceWsdl         = 'https://adwords.google.com/api/adwords/cm/v201809/AdGroupAdService?wsdl';
    const UserListServiceNamespace     = 'https://adwords.google.com/api/adwords/rm/v201809';
    const UserListServiceWsdl          = 'https://adwords.google.com/api/adwords/rm/v201809/AdwordsUserListService?wsdl';
    const ConversionTrackerServiceWsdl = 'https://adwords.google.com/api/adwords/cm/v201809/ConversionTrackerService?wsdl';
    const ServiceNamespace             = 'https://adwords.google.com/api/adwords/cm/v201809';
    const BudgetServiceWsdl            = 'https://adwords.google.com/api/adwords/cm/v201809/BudgetService?wsdl';
    const ReportDownloadURL            = 'https://adwords.google.com/api/adwords/reportdownload/v201809';

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
}
