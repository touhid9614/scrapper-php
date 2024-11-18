<?php

use Facebook\Facebook;
use FacebookAds\Api;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdsInsightsFields;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Values\CampaignObjectiveValues;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Fields\ConversionActionQueryFields;
use FacebookAds\Object\Targeting;
use FacebookAds\Object\Fields\TargetingFields;
use FacebookAds\Object\Fields\AdPromotedObjectFields;
use FacebookAds\Object\Values\AdSetBillingEventValues;
use FacebookAds\Object\Values\AdSetOptimizationGoalValues;
use FacebookAds\Object\CustomAudience;
use FacebookAds\Object\Fields\CustomAudienceFields;
use FacebookAds\Object\Values\CustomAudienceSubtypes;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\Fields\AdCreativeFields;
use FacebookAds\Object\AdCreativeLinkData;
use FacebookAds\Object\Fields\AdCreativeLinkDataFields;
use FacebookAds\Object\AdCreativeObjectStorySpec;
use FacebookAds\Object\Fields\AdCreativeObjectStorySpecFields;
use FacebookAds\Object\Ad;
use FacebookAds\Object\Fields\AdFields;

class Fb {
    
    public $account_id, $adAccount, $cron_config, $page_id, $pixel_id, $dataset, $form_id, $facebook;
    
    protected $campaigns, $campaigns_by_id, $app_id, $app_secret, $access_token, $ads;
    
    const TARGETING_TYPE_RETARGETING    = 'retargeting';
    const TARGETING_TYPE_POLKDATE       = 'polkdata';
    
    const ACTION_TYPE_CLICK             = 'click';
    const ACTION_TYPE_MESSENGER         = 'messenger';
    const ACTION_TYPE_LEAD              = 'lead';
    
    public function __construct($app_id, $app_secret, $access_token, $account_id, $page_id, $pixel_id, $dataset, $form_id, $cron_config) {
        $this->facebook = new Facebook([
            'app_id'        => $app_id,
            'app_secret'    => $app_secret
        ]);
        Api::init($app_id, $app_secret, $access_token);

        if($access_token) {
            $this->facebook->setDefaultAccessToken($access_token);
        }
        $this->cron_config  = $cron_config;
        $this->account_id   = "act_$account_id";                    #FB ad account's ID starts with act_
        $this->adAccount    = new AdAccount($this->account_id);
        $this->page_id      = $page_id;
        $this->pixel_id     = $pixel_id;
        $this->dataset      = $dataset;
        $this->form_id      = $form_id;
        $this->app_id       = $app_id;
        $this->app_secret   = $app_secret;
        $this->access_token = $access_token;
    }
    
    public function getCampaigns() {
        if($this->campaigns) { return $this->campaigns; }
        
        try {
            
            $this->campaigns = [];
            $this->campaigns_by_id = [];
            
            $local_campaigns = $this->adAccount->getCampaigns([CampaignFields::NAME, CampaignFields::EFFECTIVE_STATUS, CampaignFields::STATUS, CampaignFields::OBJECTIVE, CampaignFields::PROMOTED_OBJECT]);
            
            while($local_campaigns->current()) {
                $campaign_data = $local_campaigns->current()->getData();
                $this->campaigns[$campaign_data['name']] = array_merge($this->clearArray($campaign_data), ['adsets' => [], 'adsets_by_id' => []]);
                $this->campaigns_by_id[$campaign_data['id']] = &$this->campaigns[$campaign_data['name']];
                $local_campaigns->next();
            }
            
            return $this->campaigns;
            
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function getCampaign($campaign_name) {
        if(!$this->campaigns) { $this->getCampaigns(); }
        
        return isset($this->campaigns[$campaign_name])?$this->campaigns[$campaign_name]:false;
    }
    
    public function getCampaignById($campaign_id) {
        if(!$this->campaigns) { $this->getCampaigns(); }
        
        return isset($this->campaigns_by_id[$campaign_id])?$this->campaigns_by_id[$campaign_id]:false;
    }
    
    public function createCampaign($campaign_name, $campaign_objective = CampaignObjectiveValues::LINK_CLICKS, $promoted_object = null, $status = Campaign::STATUS_PAUSED) {
        
        if($this->getCampaign($campaign_name)) { return $this->getCampaign($campaign_name); }
        
        try {
            $campaign = new Campaign(null, $this->account_id);

            $campaign_data = array(
                CampaignFields::NAME      => $campaign_name,
                CampaignFields::OBJECTIVE => $campaign_objective,
                CampaignFields::ACCOUNT_ID=> $this->account_id
            );
            
            if($promoted_object) {
                $campaign_data[CampaignFields::PROMOTED_OBJECT] = $promoted_object;
            }
            
            $campaign->setData($campaign_data);

            $campaign->create(array(
                Campaign::STATUS_PARAM_NAME => $status,
            ));
            
            if($campaign->id) {
                
                $campaign = $campaign->getSelf([CampaignFields::NAME, CampaignFields::EFFECTIVE_STATUS, CampaignFields::STATUS, CampaignFields::OBJECTIVE]);
                
                $this->campaigns[$campaign_name] = array_merge($this->clearArray($campaign->getData()), ['adsets' => [], 'adsets_by_id' => []]);
                $this->campaigns_by_id[$campaign->id] = &$this->campaigns[$campaign_name];
                
                return $this->campaigns[$campaign_name];
                
            } else {
                return false;
            }
            
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function getAdSetIds($campaign_id) {
        if($this->getAdSets($campaign_id)) {
            return array_keys($this->campaigns_by_id[$campaign_id]['adsets_by_id']);
        }
    }
    
    public function getAdSets($campaign_id) {
        if(!$this->campaigns) { $this->getCampaigns(); }
        
        if(!isset($this->campaigns_by_id[$campaign_id])) { return false; }
        
        if(count($this->campaigns_by_id[$campaign_id]['adsets']) > 0) { return $this->campaigns_by_id[$campaign_id]['adsets']; }
        
        try {
            
            $campaign = new Campaign($campaign_id);
            $local_adsets = $campaign->getAdSets([AdSetFields::NAME,
            AdSetFields::BID_AMOUNT,
            AdSetFields::BID_INFO,
            AdSetFields::CREATIVE_SEQUENCE,
                
                AdSetFields::EFFECTIVE_STATUS,
                AdSetFields::STATUS,
                AdSetFields::DAILY_BUDGET,
                AdSetFields::OPTIMIZATION_GOAL,
                AdSetFields::IS_AUTOBID,
                AdSetFields::TARGETING,
                AdSetFields::BILLING_EVENT,
                AdSetFields::BUDGET_REMAINING
            ]);
            
            while($local_adsets->current()) {
                $adset_data = $local_adsets->current()->getData();
                $this->campaigns_by_id[$campaign_id]['adsets'][$adset_data['name']] = array_merge($this->clearArray($adset_data), ['ads' => []]);
                $this->campaigns_by_id[$campaign_id]['adsets_by_id'][$adset_data['id']] = &$this->campaigns_by_id[$campaign_id]['adsets'][$adset_data['name']];
                $local_adsets->next();
            }
            
            return $this->campaigns_by_id[$campaign_id]['adsets'];
            
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function getAdSet($campaign_id, $adset_name) {
        if(!$this->getAdSets($campaign_id)) { return false; }
        
        return isset($this->campaigns_by_id[$campaign_id]['adsets'][$adset_name])?$this->campaigns_by_id[$campaign_id]['adsets'][$adset_name]:false;
    }
    
    public function getAdSetById($campaign_id, $adset_id) {
        if(!$this->getAdSets($campaign_id)) { return false; }
        
        return isset($this->campaigns_by_id[$campaign_id]['adsets_by_id'][$adset_id])?$this->campaigns_by_id[$campaign_id]['adsets_by_id'][$adset_id]:false;
    }
    
    /**
     * Create an adset with default
     * @param type $campaign_id
     * @param type $adset_name
     * @param type $bid_amount
     * @param type $daily_budget
     * @param type $targetting_data
     * @return boolean
     */
    public function createAdSet(
            $campaign_id,
            $adset_name,
            $daily_budget = 1,
            $targetting_data = []
        ) {
        
        if($this->getAdSet($campaign_id, $adset_name)) { return $this->getAdSet($campaign_id, $adset_name); }
        
        try {
            
            $adset = new AdSet(null, $this->account_id);
            $adset->setData(array(
                AdSetFields::NAME => $adset_name,
                AdSetFields::ACCOUNT_ID => $this->account_id,
                AdSetFields::OPTIMIZATION_GOAL => AdSetOptimizationGoalValues::LINK_CLICKS,
                AdSetFields::BILLING_EVENT => AdSetBillingEventValues::IMPRESSIONS,
                AdSetFields::IS_AUTOBID => true,
                AdSetFields::DAILY_BUDGET => $daily_budget * 100,                               #Budget is in cents
                AdSetFields::CAMPAIGN_ID => $campaign_id,
                AdSetFields::PROMOTED_OBJECT => [
                    AdPromotedObjectFields::PAGE_ID => $this->page_id
                ],
                AdSetFields::TARGETING => (new Targeting())->setData($targetting_data)
            ));

            $adset->create([AdSet::STATUS_PARAM_NAME => AdSet::STATUS_ACTIVE]);
            
            if($adset->id) {
                
                $adset = $adset->getSelf([AdSetFields::NAME,
                    AdSetFields::EFFECTIVE_STATUS,
                    AdSetFields::STATUS,
                    AdSetFields::DAILY_BUDGET,
                    AdSetFields::OPTIMIZATION_GOAL,
                    AdSetFields::IS_AUTOBID,
                    AdSetFields::TARGETING,
                    AdSetFields::BILLING_EVENT,
                    AdSetFields::BUDGET_REMAINING
                ]);
                
                $adset_data = $adset->getData();
                
                $this->campaigns_by_id[$campaign_id]['adsets'][$adset_data['name']] = array_merge($this->clearArray($adset_data), ['ads' => []]);
                $this->campaigns_by_id[$campaign_id]['adsets_by_id'][$adset_data['id']] = &$this->campaigns_by_id[$campaign_id]['adsets'][$adset_data['name']];
                
                return $this->campaigns_by_id[$campaign_id]['adsets'][$adset_data['name']];
            } else {
                return false;
            }
            
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function createCustomAudience($adset_name, $car) {
        try {
            $my_audience_name = "{$adset_name}_audience";
            
            #Create custom audience
            $custom_audience = new CustomAudience(null, $this->account_id);
            $custom_audience->setData(array(
                CustomAudienceFields::PIXEL_ID => $this->pixel_id,
                CustomAudienceFields::NAME => $my_audience_name,
                CustomAudienceFields::ACCOUNT_ID => $this->account_id,
                CustomAudienceFields::SUBTYPE => CustomAudienceSubtypes::WEBSITE,
                CustomAudienceFields::RETENTION_DAYS => 60,
                CustomAudienceFields::RULE => ['and' => [['event' => ['i_contains' => 'ViewContent']], ['year' => ['i_contains' => $car['year']]], ['make' => ['i_contains' => $car['make']]], ['model' => ['i_contains' => $car['model']]]]],
                CustomAudienceFields::PREFILL => true,
            ));
            $custom_audience->create();
            
            if(!$custom_audience->id) {
                return false;               #Failed to create custom audience
            }
            
            return $custom_audience->id;    #Enabled retargetting successfully
        } catch(Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function enableRetargeting($adset_id, $car) {
        try {
            $adset = new AdSet($adset_id);
            $adset->read([AdSetFields::NAME, AdSetFields::TARGETING]);
            
            $custom_audiences = isset($adset->targeting[TargetingFields::CUSTOM_AUDIENCES])? $adset->targeting[TargetingFields::CUSTOM_AUDIENCES] : [];
            
            $my_audience_name = "{$adset->name}_audience";
                        
            foreach($custom_audiences as $ca) {
                if($ca['name'] == $my_audience_name) { return $adset->getData(); } #Already enabled
            }
            
            #Create custom audience
            $custom_audience = new CustomAudience(null, $this->account_id);
            $custom_audience->setData(array(
                CustomAudienceFields::PIXEL_ID => $this->pixel_id,
                CustomAudienceFields::NAME => $my_audience_name,
                CustomAudienceFields::SUBTYPE => CustomAudienceSubtypes::WEBSITE,
                CustomAudienceFields::RETENTION_DAYS => 60,
                CustomAudienceFields::RULE => ['and' => [['event' => ['i_contains' => 'ViewContent']], ['year' => ['i_contains' => $car['year']]], ['make' => ['i_contains' => $car['make']]], ['model' => ['i_contains' => $car['model']]]]],
                CustomAudienceFields::PREFILL => true,
                CustomAudienceFields::ACCOUNT_ID => $this->account_id
            ));
            $custom_audience->create();
            
            if(!$custom_audience->id) {
                return false;               #Failed to create custom audience
            }
            
            $targeting = $adset->targeting;
            
            $targeting[TargetingFields::CUSTOM_AUDIENCES] = [
                CustomAudienceFields::ID    => $custom_audience->id
            ];
            
            $adset->targeting = $targeting;
            
            $adset->update();
            
            return true;                    #Enabled retargetting successfully
        } catch(Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function createAd($type, $adset_id, $car, $title, $description, $banner_url, $targeting_type, $format) {
        
        switch($type) {
            case self::ACTION_TYPE_CLICK:
                return $this->createClickAd($adset_id, $car, $title, $description, $banner_url, $targeting_type, $format);
            case self::ACTION_TYPE_MESSENGER:
                return $this->createMessengerAd($adset_id, $car, $title, $description, $banner_url, $targeting_type, $format);
            case self::ACTION_TYPE_LEAD:
                return $this->createLeadAd($adset_id, $car, $title, $description, $banner_url, $targeting_type, $format);
        }
    }
    
    public function createMessengerAd($adset_id, $car, $title, $description, $banner_url, $targeting_type, $format) {
        
        try {
            
            $link_data = new AdCreativeLinkData();

            $welcome_message = [[
                "message" => [
                    "attachment" => [
                      "type" => "template",
                      "payload" => [
                            "template_type" => "generic",
                            "elements" => [
                                [
                                    "title" => $title,
                                    "image_url" => $banner_url,
                                    "subtitle" => "",
                                    "default_action" => [
                                        "type"      => "postback",
                                        "title"     => "Start Chatting",
                                        "payload"   => [
                                            'title'         => $title,
                                            'url'           => $car['url'],
                                            'image_url'     => $banner_url,
                                            'stock_number'  => $car['stock_number']
                                        ]
                                    ],
                                    "buttons" => [
                                        [
                                            "type"      => "postback",
                                            "title"     => "Start Chatting",
                                            "payload"   => [
                                                'title'     => $title,
                                                'url'       => $car['url'],
                                                'image_url' => $banner_url,
                                                'stock_number'  => $car['stock_number']
                                            ]
                                       ]
                                    ]
                                ]
                             ]
                        ]
                    ]
                ]
            ]];

            $call_to_action = [
                'type'  => 'MESSAGE_PAGE',
                'value' => [
                    'app_destination' => 'MESSENGER'
                ]
            ];

            $l_data = [
                AdCreativeLinkDataFields::MESSAGE => $description,
                AdCreativeLinkDataFields::NAME => $title,
                AdCreativeLinkDataFields::DESCRIPTION => GetDomain($car['url']),
                AdCreativeLinkDataFields::LINK => $car['url'],
                AdCreativeLinkDataFields::PICTURE => $banner_url,
                AdCreativeLinkDataFields::CALL_TO_ACTION => $call_to_action,
                "page_welcome_message"  => $welcome_message
            ];

            $link_data->setData($l_data);

            $object_story_spec = new AdCreativeObjectStorySpec();

            $os_spec_data = [
                AdCreativeObjectStorySpecFields::PAGE_ID    => $this->page_id,
                AdCreativeObjectStorySpecFields::LINK_DATA  => $link_data
            ];

            $object_story_spec->setData($os_spec_data);

            $ad_creative = new AdCreative(null, $this->account_id);

            $ad_creative->setData([
                AdCreativeFields::NAME => $this->getCreativeName($car, $targeting_type, self::ACTION_TYPE_MESSENGER, $format),
                AdCreativeFields::OBJECT_STORY_SPEC => $object_story_spec,
                AdCreativeFields::ACCOUNT_ID => $this->account_id
            ]);

            $ad_creative->create();
            
            if(!$ad_creative->id) { return false; }
            
            $data = [
                AdFields::NAME      => $this->getAdName($car, $targeting_type, self::ACTION_TYPE_MESSENGER, $format),
                AdFields::ADSET_ID  => $adset_id,
                AdFields::CREATIVE  => [
                    'creative_id' => $ad_creative->id,
                ],
                AdFields::ACCOUNT_ID => $this->account_id,
                AdFields::TRACKING_SPECS => [
                    [
                        ConversionActionQueryFields::FIELD_ACTION_TYPE  => ['offsite_conversion'],
                        ConversionActionQueryFields::FB_PIXEL           => [$this->pixel_id]
                    ],
                    [
                        ConversionActionQueryFields::FIELD_ACTION_TYPE  => ['offline_conversion'],
                        ConversionActionQueryFields::DATASET            => [$this->dataset]
                    ],
                ]
            ];

            $ad = new Ad(null, $this->account_id);
            $ad->setData($data);
            $ad->create(array(
                Ad::STATUS_PARAM_NAME => Ad::STATUS_ACTIVE,
            ));
            
            if(!$ad->id) { return false; }
            
            
            $this->ads[$adset_id]['by_name'][$data['name']] = $this->clearArray($ad->getData());
            $this->ads[$adset_id]['by_id'][$ad->id]         = $this->clearArray($ad->getData());
            
            return $this->clearArray($ad->getData());
            
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function createClickAd($adset_id, $car, $title, $description, $banner_url, $targeting_type, $format) {
        
        try {
            $utm_tags = isset($this->cron_config['utm_tags'])?$this->cron_config['utm_tags']:true;
            $url = $car['url'];

            if($utm_tags) {
                $url = urlCombine($url, '?utm_medium=facebook');
            }
            
            $link_data = new AdCreativeLinkData();

            $call_to_action = [
                'type'  => 'LEARN_MORE'
            ];

            $l_data = [
                AdCreativeLinkDataFields::MESSAGE => $description,
                AdCreativeLinkDataFields::NAME => $title,
                AdCreativeLinkDataFields::DESCRIPTION => ' ',//GetDomain($car['url']),
                AdCreativeLinkDataFields::LINK => $url,
                AdCreativeLinkDataFields::PICTURE => $banner_url,
                AdCreativeLinkDataFields::CALL_TO_ACTION => $call_to_action,
            ];

            $link_data->setData($l_data);

            $object_story_spec = new AdCreativeObjectStorySpec();

            $os_spec_data = [
                AdCreativeObjectStorySpecFields::PAGE_ID    => $this->page_id,
                AdCreativeObjectStorySpecFields::LINK_DATA  => $link_data
            ];

            $object_story_spec->setData($os_spec_data);

            $ad_creative = new AdCreative(null, $this->account_id);

            $ad_creative->setData([
                AdCreativeFields::NAME => $this->getCreativeName($car, $targeting_type, self::ACTION_TYPE_CLICK, $format),
                AdCreativeFields::OBJECT_STORY_SPEC => $object_story_spec,
                AdCreativeFields::ACCOUNT_ID => $this->account_id
            ]);

            $ad_creative->create();
            
            if(!$ad_creative->id) { return false; }
            
            $data = [
                AdFields::NAME      => $this->getAdName($car, $targeting_type, self::ACTION_TYPE_CLICK, $format),
                AdFields::ADSET_ID  => $adset_id,
                AdFields::CREATIVE  => [
                    'creative_id' => $ad_creative->id,
                ],
                AdFields::ACCOUNT_ID => $this->account_id,
                AdFields::TRACKING_SPECS => [
                    [
                        ConversionActionQueryFields::FIELD_ACTION_TYPE  => ['offsite_conversion'],
                        ConversionActionQueryFields::FB_PIXEL           => [$this->pixel_id]
                    ],
                    [
                        ConversionActionQueryFields::FIELD_ACTION_TYPE  => ['offline_conversion'],
                        ConversionActionQueryFields::DATASET            => [$this->dataset]
                    ],
                ]
            ];

            $ad = new Ad(null, $this->account_id);
            $ad->setData($data);
            $ad->create(array(
                Ad::STATUS_PARAM_NAME => Ad::STATUS_ACTIVE,
            ));
            
            if(!$ad->id) { return false; }
            
            
            $this->ads[$adset_id]['by_name'][$data['name']] = $this->clearArray($ad->getData());
            $this->ads[$adset_id]['by_id'][$ad->id]         = $this->clearArray($ad->getData());
            
            return $this->clearArray($ad->getData());
            
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function createLeadAd($adset_id, $car, $title, $description, $banner_url, $targeting_type, $format) {
        
        try {
            
            $link_data = new AdCreativeLinkData();

            $call_to_action = [
                'type'  => 'LEARN_MORE',
                'value' => [
                    'lead_gen_form_id' => $this->form_id
                ]
            ];

            $l_data = [
                AdCreativeLinkDataFields::MESSAGE => $description,
                AdCreativeLinkDataFields::NAME => $title,
                AdCreativeLinkDataFields::DESCRIPTION => GetDomain($car['url']),
                AdCreativeLinkDataFields::LINK => $car['url'],
                AdCreativeLinkDataFields::PICTURE => $banner_url,
                AdCreativeLinkDataFields::CALL_TO_ACTION => $call_to_action,
            ];

            $link_data->setData($l_data);

            $object_story_spec = new AdCreativeObjectStorySpec();

            $os_spec_data = [
                AdCreativeObjectStorySpecFields::PAGE_ID    => $this->page_id,
                AdCreativeObjectStorySpecFields::LINK_DATA  => $link_data
            ];

            $object_story_spec->setData($os_spec_data);

            $ad_creative = new AdCreative(null, $this->account_id);

            $ad_creative->setData([
                AdCreativeFields::NAME => $this->getCreativeName($car, $targeting_type, self::ACTION_TYPE_LEAD, $format),
                AdCreativeFields::OBJECT_STORY_SPEC => $object_story_spec,
                AdCreativeFields::ACCOUNT_ID => $this->account_id
            ]);

            $ad_creative->create();
            
            if(!$ad_creative->id) { return false; }
            
            $data = [
                AdFields::NAME      => $this->getAdName($car, $targeting_type, self::ACTION_TYPE_LEAD, $format),
                AdFields::ADSET_ID  => $adset_id,
                AdFields::CREATIVE  => [
                    'creative_id' => $ad_creative->id,
                ],
                AdFields::ACCOUNT_ID => $this->account_id,
                AdFields::TRACKING_SPECS => [
                    [
                        ConversionActionQueryFields::FIELD_ACTION_TYPE  => ['offsite_conversion'],
                        ConversionActionQueryFields::FB_PIXEL           => [$this->pixel_id]
                    ],
                    [
                        ConversionActionQueryFields::FIELD_ACTION_TYPE  => ['offline_conversion'],
                        ConversionActionQueryFields::DATASET            => [$this->dataset]
                    ],
                ]
            ];

            $ad = new Ad(null, $this->account_id);
            $ad->setData($data);
            $ad->create(array(
                Ad::STATUS_PARAM_NAME => Ad::STATUS_ACTIVE,
            ));
            
            if(!$ad->id) { return false; }
            
            
            $this->ads[$adset_id]['by_name'][$data['name']] = $this->clearArray($ad->getData());
            $this->ads[$adset_id]['by_id'][$ad->id]         = $this->clearArray($ad->getData());
            
            return $this->clearArray($ad->getData());
            
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function deleteAd($campaign_id, $adset_id, $ad_id) {
        try {
            $ad = $this->getAdById($campaign_id, $adset_id, $ad_id);
            if(!$ad) { return true; }
            Ad::deleteIds([$ad['id']]);
            AdCreative::deleteIds([$ad['creative']['id']]);

            unset($this->ads[$adset_id]['by_name'][$ad['name']]);
            unset($this->ads[$adset_id]['by_id'][$ad['id']]);
            
            return true;
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function deleteAdSet($campaign_id, $adset_id) {
        try {
            $adset = $this->getAdSetById($campaign_id, $adset_id);
            $ads = $this->getAds($campaign_id, $adset_id);

            $creative_ids = [];
            $ad_ids = [];

            foreach($ads as $ad) {
                $ad_ids[] = $ad['id'];
                $creative_ids[] = $ad['creative']['id'];
            }

            Ad::deleteIds($ad_ids);
            AdCreative::deleteIds($creative_ids);
            
            $audiences = isset($adset['targeting']['custom_audiences'])?$adset['targeting']['custom_audiences']:[];
            
            $audience_ids = [];
            
            foreach($audiences as $audience) {
                $audience_ids[] = $audience['id'];
            }
            
            CustomAudience::deleteIds($audience_ids);
            AdSet::deleteIds([$adset_id]);
            
            unset($this->campaigns_by_id[$campaign_id]['adsets'][$adset['name']]);
            unset($this->campaigns_by_id[$campaign_id]['adsets_by_id'][$adset['id']]);
            
            return true;
        } catch(Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function pauseAd($campaign_id, $adset_id, $ad_id) {
        try {
            $ad = $this->getAdById($campaign_id, $adset_id, $ad_id);
            if(!$ad) { return true; }
            
            $w_ad = new Ad($ad_id, $this->account_id);
            $w_ad->save([Ad::STATUS_PARAM_NAME => Ad::STATUS_PAUSED]);

            return true;
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function archiveAd($campaign_id, $adset_id, $ad_id) {
        try {
            $ad = $this->getAdById($campaign_id, $adset_id, $ad_id);
            if(!$ad) { return true; }
            
            $w_ad = new Ad($ad_id, $this->account_id);
            $w_ad->save([Ad::STATUS_PARAM_NAME => Ad::STATUS_ARCHIVED]);

            return true;
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function resumeAd($campaign_id, $adset_id, $ad_id) {
        try {
            $ad = $this->getAdById($campaign_id, $adset_id, $ad_id);
            if(!$ad) { return true; }
            
            $w_ad = new Ad($ad_id, $this->account_id);
            $w_ad->save([Ad::STATUS_PARAM_NAME => Ad::STATUS_ACTIVE]);

            return true;
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function pauseCampaign($campaign_id) {
        try {
            $campaign = $this->getCampaignById($campaign_id);
            if(!$campaign) { return true; }
            
            $w_campaign = new Campaign($campaign_id, $this->account_id);
            $w_campaign->save([Campaign::STATUS_PARAM_NAME => Campaign::STATUS_PAUSED]);

            return true;
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function resumeCampaign($campaign_id) {
        try {
            $campaign = $this->getCampaignById($campaign_id);
            if(!$campaign) { return true; }
            
            $w_campaign = new Campaign($campaign_id, $this->account_id);
            $w_campaign->save([Campaign::STATUS_PARAM_NAME => Campaign::STATUS_ACTIVE]);

            return true;
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function getAdCreative($creative_id) {
        
        if(!$creative_id) { return false; }
        
        try {
            
            $ad_creative = new AdCreative($creative_id, $this->account_id);
            $_ad_creative = $ad_creative->getSelf([
                AdCreativeFields::BODY,
                AdCreativeFields::CALL_TO_ACTION_TYPE,
                AdCreativeFields::IMAGE_URL,
                AdCreativeFields::LINK_URL,
                AdCreativeFields::PRODUCT_SET_ID,
                AdCreativeFields::NAME,
                AdCreativeFields::TITLE,
                AdCreativeFields::ID,
                AdCreativeFields::OBJECT_STORY_SPEC
            ]);
            //$ad_creatives = $this->adAccount->getAdCreatives(array_keys((new AdCreativeFields())->getFieldTypes()));
            
            return $_ad_creative->getData();//s->current()->getData();
            
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function getAds($campaign_id, $adset_id) {
        
        if(isset($this->ads[$adset_id]['by_name'])) { return $this->ads[$adset_id]['by_name']; }
        
        $adset = $this->getAdSetById($campaign_id, $adset_id);
        
        try{
            $actual_adset = new AdSet($adset['id']);
            
            $ads = $actual_adset->getAds(array_keys((new AdFields)->getFieldTypes()));//[AdFields::NAME, AdFields::CREATIVE]);
            
            $retval = [];
            
            while($ads->current()) {
                $adsData    = $ads->current()->getData();
                $ads_data   = $this->clearArray($adsData);
                $retval[$adsData['name']] = $ads_data;
                $this->ads[$adset_id]['by_name'][$adsData['name']] = $ads_data;
                $this->ads[$adset_id]['by_id'][$adsData['id']]     = $ads_data;
                $ads->next();
            }
            
            return $retval;
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function getAdByName($campaign_id, $adset_id, $ad_name) {
        $ads = $this->getAds($campaign_id, $adset_id);
        
        return isset($ads[$ad_name])?$ads[$ad_name]:false;
    }
    
    public function getAdById($campaign_id, $adset_id, $ad_id) {
        $this->getAds($campaign_id, $adset_id); //If not loaded, load it
        
        return isset($this->ads[$adset_id]['by_id'][$ad_id])? $this->ads[$adset_id]['by_id'][$ad_id] : false;
    }
    
    public function getAdIds($campaign_id, $adset_id) {
        $ads = $this->getAds($campaign_id, $adset_id);
        
        if(!$ads) { return []; }
        
        $retval = [];
        
        foreach($ads as $ad) {
            $retval[] = $ad['id'];
        }
        
        return $retval;
    }

    /**
     * Returns the campaign name based on car data and campaign types
     * 
     * @param array  $car is the actual car data
     * @param string $targeting_type is either retargeting or polkdata
     * @param string $action_type is click, messenger or lead
     * @param string $platform is fb or instagram
     */
    public function getCampaignName($car, $targeting_type, $action_type, $platform = 'fb') {
        return "sMedia_campaigns_{$car['stock_type']}_{$platform}_{$action_type}_{$targeting_type}";
    }
    
    public function getAdsetName($car, $targeting_type, $action_type, $format, $platform = 'fb') {
        return "{$car['stock_type']}_{$car['year']}_{$car['make']}_{$car['model']}_{$car['stock_number']}_{$platform}_{$format}_{$action_type}_{$targeting_type}";
    }
    
    public function getPolkdataAdsetName($car, $targeting_type, $action_type, $format, $platform = 'fb') {
        return "{$car['stock_type']}_{$car['make']}_{$platform}_{$format}_{$action_type}_{$targeting_type}";
    }
    
    public function getCreativeName($car, $targeting_type, $action_type, $format, $platform = 'fb') {
        return $this->getAdsetName($car, $targeting_type, $action_type, $format, $platform) . "_creative";
    }
    
    public function getAdName($car, $targeting_type, $action_type, $format, $platform = 'fb') {
        return md5(serialize($car)) . "_{$platform}_{$format}_{$action_type}_{$targeting_type}_ad";
    }
    
    public function getUserDetails() {
        try {
            return json_decode($this->facebook->get('/me?fields=id,name,picture')->getBody());
        } catch(Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function getTokenStatus() {
        return $this->facebook->getOAuth2Client()->debugToken($this->access_token);
    }

    public function isValidAccessToken() {
        $status = $this->getTokenStatus();
        
        if(!$status) { return false; }
        
        return $status->getField('is_valid');
    }

    public function getAccessToken() {
        
        global $fb_token_path;
        
        $helper = $this->facebook->getRedirectLoginHelper();
        
        try {
            $access_token = (string) $helper->getAccessToken();
            $this->facebook->setDefaultAccessToken($access_token);
            Api::init($this->app_id, $this->app_secret, $access_token);
            $this->access_token = $access_token;
            
            if($fb_token_path) {
                file_put_contents($fb_token_path, $access_token);
            }
            
            return $access_token;
        } catch(Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    public function getLoginUrl() {
        $helper = $this->facebook->getRedirectLoginHelper();
        $permissions = ['ads_management'];
        $redirect_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        return $helper->getLoginUrl($redirect_url, $permissions);
    }

    public function getAccountCost($since, $until) {
        
        try {
            
            $_since = date('Y-m-d', $since);
            $_until = date('Y-m-d', $until);
            
            $insight = $this->adAccount->getInsights([AdsInsightsFields::SPEND], ['time_range' => ['since' => $_since, 'until' => $_until]])->current();
            
            return $insight?$this->clearArray($insight->getData()) : 0;
            
        } catch (Exception $ex) {
            return $this->handleError($ex);
        }
    }
    
    protected function clearArray($data) {
        
        if(!is_array($data)) { return $data; }
        
        $retval = [];
        
        foreach($data as $k => $v) {
            if($v !== null) {
                $retval[$k] = $v;
            }
        }
        
        return $retval;
    }

    protected function handleError(Exception $ex) {
        if(function_exists('slecho')) {
            slecho("Facebook Error: " . $ex->getMessage());
            slecho("Error Dump: \n" . print_r($ex, true));
        } else {
            echo "<pre>";
            print_r($ex);
            echo "</pre>";
        }
        
        return false;
    }
}