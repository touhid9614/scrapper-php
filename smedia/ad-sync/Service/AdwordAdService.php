<?php

namespace sMedia\AdSync\Service;

use AccessToken;
use AdwordsService;
use Consts;
use sMedia\Logger\Logger;
use SoapFault;
use SoapVar;

class AdwordAdService extends AdwordsService
{
	/**
	 * logger
	 *
	 * @var \Monolog\Logger
	 */
	public $logger;

	public function __construct($namespace, AccessToken $access_token, $developer_token, $customer_id, $logger = null)
	{
		if (empty($logger)) {
			$this->logger = Logger::get('default');
		} else {
			$this->logger = $logger;
		}
		parent::__construct($namespace, $access_token, $developer_token, $customer_id);
	}

	/**
	 * Removes multiple ads from multiple groups if necessary.
	 *
	 * @param      array    $ads       ['ad\_id' => "ad\_id", 'group\_id' => 'group\_id']
	 *
	 * @return     array  ( description_of_the_return_value )
	 */
	public function RemoveAds($ads)
	{
		$operations = [];

		foreach ($ads as $ad) {
			$text_ad = array('id' => $ad['ad_id']);
			$ad_group_ad  = array('adGroupId' => $ad['group_id'], 'ad' => $text_ad, 'status' => 'ENABLED');
			$ad_operation = array('operator' => 'REMOVE', 'operand' => $ad_group_ad);
			$operations[] = $ad_operation;
		}

		try {
			$rval = $this->AdService->mutate(array('operations' => $operations));

			if (isset($rval->rval->value)) {
				return $rval->rval->value;
			} else {
				return false;
			}
		} catch (SoapFault $ex) {
			$reason = @$ex->detail->ApiExceptionFault->errors->enc_value->reason;
			if (in_array($reason, ['OAUTH_TOKEN_INVALID', 'RATE_EXCEEDED'])) {
				if ($this->HandleSoapFault($ex)) {
					return $this->RemoveAds($ads);
				} else {
					return false;
				}
			} else {
				$errors = !is_array($ex->detail->ApiExceptionFault->errors)
					? [$ex->detail->ApiExceptionFault->errors]
					: $ex->detail->ApiExceptionFault->errors;

				$removed_ads = [];

				foreach ($errors as $_e) {
					if ($_e->enc_value->reason == 'CANNOT_OPERATE_ON_REMOVED_ADGROUPAD') {
						$i = $_e->enc_value->fieldPathElements[0]->index;
						$removed_ads[] = (object) [
							'adGroupId' => $ads[$i]['group_id'],
							'err' => $_e->enc_value->reason,
							'ad' => (object)['id' => $ads[$i]['ad_id']],
						];
					} else {
						$this->logger->error('Unhandled error', [$_e]);
					}
				}

				return $removed_ads;
			}
		}
	}

	/**
	 * Creates an responsive search ad.
	 *
	 * @param      string   $ad_group_id   The ad group identifier
	 * @param      string   $url           The url
	 * @param      string   $display_url   The display url
	 * @param      array	$headlines     The headlines
	 * @param      array	$descriptions  The descriptions
	 *
	 * @return     array | boolean  ( description_of_the_return_value )
	 */
	public function CreateResponsiveSearchAd($ad_group_id, $url, $display_url, $headlines, $descriptions)
	{
		$make_asset = function ($positions) {
			return function ($v) use ($positions) {
				$asset = new SoapVar(['assetText' => $v['text']], XSD_ANYTYPE, 'TextAsset', Consts::ServiceNamespace);
				// $asset = (object)['assetText' => "$v"];
				$data = ['asset' => $asset];
				if ($v['position'] != 0) {
					$data['pinnedField'] = $positions[$v['position']];
				}
				return  (object)$data;
			};
		};
		$headline_assets = array_map($make_asset(['NONE', 'HEADLINE_1', 'HEADLINE_2', 'HEADLINE_3']), $headlines);
		$description_assets = array_map($make_asset(['NONE', 'DESCRIPTION_1', 'DESCRIPTION_2']), $descriptions);
		$responsive_search_ad = (object)['finalUrls' => array($url), 'headlines' => $headline_assets, 'descriptions' => $description_assets];
		$TextAd       = new SoapVar($responsive_search_ad, XSD_ANYTYPE, 'ResponsiveSearchAd', Consts::ServiceNamespace);
		$ad_group_ad  = array('adGroupId' => $ad_group_id, 'ad' => $TextAd, 'status' => 'ENABLED');
		$ad_operation = array('operator' => 'ADD', 'operand' => $ad_group_ad);
		try {
			$rval = $this->AdService->mutate(array('operations' => array($ad_operation)));
			if (isset($rval->rval->value)) {
				return $rval->rval->value;
			} else {
				//return $rval->rval;
				return false;
			}
		} catch (SoapFault $ex) {
			if ($this->HandleSoapFault($ex)) {
				return $this->CreateResponsiveSearchAd($ad_group_id, $url, $display_url, $headlines, $descriptions);
			} else {
				return false;
			}
		}
	}

	/**
	 * Create multiple responsive ads
	 *
	 * @param mixed $ads_data
	 * @return     array | boolean  ( description_of_the_return_value )
	 */
	public function CreateResponsiveSearchAds($ads_data)
	{
		$make_asset = function ($positions) {
			return function ($v) use ($positions) {
				$asset = new SoapVar(['assetText' => $v->text], XSD_ANYTYPE, 'TextAsset', Consts::ServiceNamespace);
				// $asset = (object)['assetText' => "$v"];
				$data = ['asset' => $asset];
				if ($v->position != 0) {
					$data['pinnedField'] = $positions[$v->position];
				}
				return  (object)$data;
			};
		};
		$ad_operations = array_map(function ($v) use ($make_asset) {
			$headline_assets = array_map($make_asset(['NONE', 'HEADLINE_1', 'HEADLINE_2', 'HEADLINE_3']), $v->ad["titles"]);
			$description_assets = array_map($make_asset(['NONE', 'DESCRIPTION_1', 'DESCRIPTION_2']), $v->ad["descriptions"]);

			$responsive_search_ad = (object)[
				'finalUrls' => $v->ad["urls"],
				'headlines' => $headline_assets,
				'descriptions' => $description_assets,
			];

			$ad       = new SoapVar($responsive_search_ad, XSD_ANYTYPE, 'ResponsiveSearchAd', Consts::ServiceNamespace);
			$ad_group_ad  = array('adGroupId' => $v->adGroupId, 'ad' => $ad, 'status' => 'ENABLED');
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
				return $this->CreateResponsiveSearchAds($ads_data);
			} else {
				return false;
			}
		}
	}
}
