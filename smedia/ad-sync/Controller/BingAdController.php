<?php
// TRUNCATE TABLE spidri_ads.tbl_bing_keyword_kamloopskiacom;
// DELETE FROM tbl_bing_ad_deleted WHERE dealership='kamloopskiacom';
// DELETE FROM tbl_bing_ad WHERE dealership='kamloopskiacom';
// DELETE FROM tbl_bing_ad_group WHERE dealership='kamloopskiacom';
namespace sMedia\AdSync\Controller;

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Collection;
use sMedia\AdSync\Service\BingAdService;

class BingAdController extends AdSyncBase
{
	/**
	 * bingService
	 *
	 * @var BingAdService
	 */
	public $bingService;

	/**
	 * localCache
	 *
	 * @var bool
	 */
	private $localCache = false;

	/**
	 * localCacheDir
	 *
	 * @var string
	 */
	private $localCacheDir;

	public static $defaultBid = 3.0;

	public function __construct($dealership)
	{
		$this->utmSource = "bing_smedia";
		$this->utmMedium = "cpc";
		$this->utmCampaign = true;
		$this->campaignKeywordTableName = "tbl_bing_ad_campaign_keywords";
		$this->keywordOptions = [
			"group_positive"	=> true,
			"group_negative"	=> false,
			"group_negative_year"	=> true,
			"campaign_positive" => false,
			"campaign_negative" => true,
			"year_negative_keywords_type" => "PHRASE",
		];
		// increase this value if you need to recreate all ads
		$this->adReset = 3;
		parent::__construct($dealership, AdSyncBase::SERVICE_BING);
	}

	public function setCacheOptions($enable, $dir)
	{
		if ($enable && file_exists($dir)) {
			$this->logger->warning("Caching enabled");
			$this->localCache = true;
			$this->localCacheDir = $dir;
		}

		return $this;
	}

	/**
	 * This function can be used to reduce development time
	 * by caching api data. Its only for development purpse
	 *
	 * @param Closure $run
	 * @param string $file_name
	 */
	private function withCache($run, $file_name)
	{
		$content = null;
		$cahce_enabled = isset($this->localCache) && $this->localCache == true;

		if ($cahce_enabled) {
			$this->logger->debug("<>cache " . basename($file_name), [file_exists($file_name), $cahce_enabled]);
		}

		if ($cahce_enabled && !empty($file_name) && file_exists($file_name)) {
			$content = unserialize(file_get_contents($file_name));
			$this->logger->debug("<<cache " . basename($file_name));
		} else {
			$content = $run();
			if ($cahce_enabled && !empty($file_name)) {
				$this->logger->debug(">>cache " . basename($file_name));
				file_put_contents($file_name, serialize($content));
			}
		}

		return $content;
	}

	/**
	 * setBingAdService
	 *
	 * @param BingAdService $bing_service
	 */
	public function setBingAdService(BingAdService $bing_service)
	{
		$this->bingService = $bing_service;
		return $this;
	}

	/**
	 * getCampaigns
	 *
	 * @param bool $active_only
	 * @param bool $v2_only
	 *
	 * @return array
	 */
	public function getCampaigns($active_only = true, $v2_only = true)
	{
		$this->logger->debug('getting campaings');
		$campaigns = $this->bingService->GetCampaigns();
		$active_campaigns = [];
		if (!empty($campaigns) && is_array($campaigns)) {
			foreach ($campaigns as $campaign) {
				if ($v2_only && !in_array($this->getOriginalCampaignName($campaign->name), $this->validCampaigns)) {
					continue;
				}
				if ($active_only && $campaign->status !== 'ENABLED') {
					continue;
				}
				$active_campaigns[] = $campaign;
			}
		}

		$this->logger->info('campaign found: ', ['total' => count($active_campaigns), 'active_only' => $active_only, 'v2_only' => $v2_only]);
		return $active_campaigns;
	}

	public function getAdGroupsFromCampaigns($campaigns)
	{
		$groups = collect();
		$this->logger->info("getAdGroupsFromCampaigns: Collecting ad groups");
		foreach ($campaigns as $c) {
			$c_groups = collect($this->withCache(function () use ($c) {
				return $this->bingService->GetAdGroups($c->name);
			}, "{$this->localCacheDir}/campaign-group-{$c->name}"))
				->map(function ($g) use ($c) {
					$g->_CampaignName = $this->getOriginalCampaignName($c->name);
					return $g;
				});
			$groups = $groups->merge($c_groups->values());
		}

		return $groups;
	}

	public function getAdsFromAdGroups($group_ids, $chunk_size = 1)
	{
		$all_ads = [];

		foreach ($group_ids->chunk($chunk_size) as $gi_chunk) {
			$group_id = $gi_chunk->values()[0];
			$this->logger->debug("Getting ads for group $group_id");

			$ads = $this->withCache(function () use ($group_id) {
				return $this->bingService->GetAds($group_id);
			},  "{$this->localCacheDir}/group-ads-$group_id");

			$this->logger->debug("Found " . count($ads) . " ads for group $group_id");

			if (!empty($ads)) {
				$all_ads = array_merge($all_ads, array_map(function ($v) use ($group_id) {
					$v->_AdGroupId = $group_id;
					return $v;
				}, $ads));
			}
		}

		return $all_ads;
	}

	private function updateAdGroupBid($campaign_id, $ad_group_id, $bid = null)
	{
		$bid = $bid == null ? self::$defaultBid : $bid;
		$result = $this->bingService->UpdateAdGroupBid($campaign_id, $ad_group_id, $bid);
		if ($result) {
			$this->handleSqlError(function () use ($ad_group_id, $bid) {
				DB::table("{$this->tableName}_group")
					->where('bing_id', $ad_group_id)
					->update(['cpc' => $bid]);
			});
		}
		return $result;
	}

	/**
	 * removeAds
	 *
	 * @param \Illuminate\Support\Collection $ads_info
	 * @param string $reason
	 */
	public function removeAds($ads_info, $reason = "Unknown")
	{
		$all_removed_ads = [];
		/** @var \Illuminate\Support\Collection $ads */
		foreach ($ads_info->groupBy("group_id") as $group_id => $ads) {
			$removing_count = count($ads);
			$this->logger->info("Removing " . $removing_count . " ads $reason");
			$removed_ads = $ads->toArray();
			$undeleted_ads = [];

			$ids = $ads->map(function ($v) {
				return $v['ad_id'];
			})->values()->toArray();

			$r = $this->bingService->RemoveAd("$group_id", $ids);
			$this->logger->debug("RemoveAds", [$r]);

			if (isset($r->PartialErrors) && isset($r->PartialErrors->BatchError) && is_array($r->PartialErrors->BatchError)) {
				foreach ($r->PartialErrors->BatchError as $e) {
					if (!in_array($e->Message, ["The Ad Id is invalid."])) {
						$undeleted_ads[] = $removed_ads[intval($e->Index)];
						unset($removed_ads[intval($e->Index)]);
					}
				}
			}

			if (!empty($removed_ads)) {
				$all_removed_ads = array_merge($all_removed_ads, $removed_ads);
				$remove_ids = array_map(function ($v) {
					return $v['ad_id'];
				}, $removed_ads);

				$this->removeAdsFromDb('bing_id', $remove_ids, $reason);
			} else {
				$removed_ads = [];
			}
			$this->logger->info("Removed " . count($removed_ads) . " ads");
			if ($removing_count != count($removed_ads)) {
				$this->logger->warning("Some ads can not be deleted", $undeleted_ads);
			}
		}

		return $all_removed_ads;
	}

	/**
	 * getKeywordsFromMultiGroups
	 *
	 * @param \Illuminate\Support\Collection $group_ids
	 * @param string $type
	 */
	public function getKeywordsFromMultiGroups($group_ids)
	{
		$all_keywords = [];

		foreach ($group_ids as $gid) {
			$this->logger->debug('Now Getting keywords for ' . $gid);

			$keywords = $this->withCache(function () use ($gid) {
				return 	$this->bingService->GetKeywords($gid, false);
			},  "{$this->localCacheDir}/group-keywords-$gid");

			$this->logger->debug('found keywords ' . count((array)$keywords));

			if (!empty($keywords)) {
				$all_keywords = array_merge($all_keywords, array_map(function ($k) use ($gid) {
					$k->_AdGroupId = $gid;
					return $k;
				}, $keywords));

				$this->logger->debug('total keywords ' . count((array)$all_keywords));
			}
		}
		return $all_keywords;
	}

	/**
	 * getKeywordsFromMultiCampaign
	 *
	 * @param string $campaign_id
	 * @param \Illuminate\Support\Collection $group_ids
	 */
	public function getNegativeKeywordsFromMultiGroup($campaign_id, $group_ids)
	{
		$all_keywords = [];

		foreach ($group_ids as $gid) {
			$this->logger->debug('Getting negative keywords for group ' . $gid);
			$r =

				$this->withCache(function () use ($campaign_id, $gid) {
					return $this->bingService->GetGroupNegativeKeywords($campaign_id, $gid);
				}, "{$this->localCacheDir}/group-ne-keywords-$gid");
			foreach ($r as $_r) {
				if (
					isset($_r->NegativeKeywords) && isset($_r->NegativeKeywords->NegativeKeyword) &&
					!empty($_r->NegativeKeywords->NegativeKeyword) &&
					is_array($_r->NegativeKeywords->NegativeKeyword)
				) {
					$keywords = $_r->NegativeKeywords->NegativeKeyword;
					$this->logger->debug('found negative keywords ' . count((array)$keywords), (array)$keywords);

					$all_keywords = array_merge($all_keywords, array_map(function ($k) use ($_r, $campaign_id) {
						$k->_AdGroupId = $_r->EntityId;
						return $k;
					}, (array)$keywords));

					$this->logger->debug('total negative keywords ' . count((array)$all_keywords));
				}
			}
		}
		return $all_keywords;
	}

	/**
	 * getKeywordsFromMultiCampaign
	 *
	 * @param \Illuminate\Support\Collection $campaign_ids
	 */
	public function getNegativeKeywordsFromMultiCampaign($campaign_ids)
	{
		$all_keywords = [];

		foreach ($campaign_ids as $cid) {
			$this->logger->debug('Getting keywords for campaign ' . $cid);
			$r = $this->withCache(function () use ($cid) {
				return $this->bingService->GetCampaignNegativeKeywords($cid, false);
			}, "{$this->localCacheDir}/campaign-keywords-$cid");
			foreach ($r as $_r) {
				if (
					isset($_r->NegativeKeywords) && isset($_r->NegativeKeywords->NegativeKeyword) &&
					!empty($_r->NegativeKeywords->NegativeKeyword) &&
					is_array($_r->NegativeKeywords->NegativeKeyword)
				) {
					$keywords = $_r->NegativeKeywords->NegativeKeyword;
					$this->logger->debug('found keywords ' . count((array)$keywords), (array)$keywords);

					$all_keywords = array_merge($all_keywords, array_map(function ($k) use ($_r) {
						$k->_CampaignId = $_r->EntityId;
						return $k;
					}, (array)$keywords));

					$this->logger->debug('total keywords ' . count((array)$all_keywords));
				} else {
					$this->logger->warning("No negative keywords foun for campaign $cid");
				}
			}
		}
		return $all_keywords;
	}

	public function removeAdsFromDb($field, $values, $reason)
	{
		$existing_ads = DB::table($this->tableName)
			->whereIn($field, $values)
			->get();

		if ($existing_ads->count()) {
			DB::table("{$this->tableName}_deleted")->insert($existing_ads->map(function ($v) use ($reason) {
				$val = (array)$v;
				$val['reason'] = $reason;
				return $val;
			})->toArray());
		}

		DB::table($this->tableName)->whereIn($field, $values)->delete();
	}

	/**
	 * makeAsset return a function to make rsa ad asset
	 *
	 * @param mixed $positions
	 *
	 * @return Closure
	 */
	public function makeAsset($positions)
	{
		return function ($v) use ($positions) {
			return [
				'text' => $v->Asset->Text,
				'position' => $positions[isset($v->PinnedField) ? $v->PinnedField : 'NONE']
			];
		};
	}

	public function preSync()
	{
		$this->logger->info("PreSync: started");
		DB::connection()->statement(
			"CREATE TABLE IF NOT EXISTS `{$this->keywordTableName}` (
					`id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
					`type` enum('positive','negative') COLLATE utf8mb4_unicode_ci NOT NULL,
					`text` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
					`matchType` enum('BROAD','PHRASE','EXACT') COLLATE utf8mb4_unicode_ci NOT NULL,
					`group_id` varchar(100) COLLATE utf8mb4_unicode_ci,
					`campaign_id` varchar(100) COLLATE utf8mb4_unicode_ci,
					PRIMARY KEY (`id`),
					CONSTRAINT `{$this->keywordTableName}` CHECK (`group_id` is not null or `campaign_id` is not null)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
		);

		$temp_stock_type = $this->stockType;
		$this->validCampaigns = array_reduce(['new', 'used'], function ($all, $v) {
			$this->stockType = $v;
			$this->generateValidCampaignNames();
			$all = array_merge($all, $this->validCampaigns);
			return $all;
		}, []);
		$this->stockType = $temp_stock_type;

		/** @var array $campaings */
		$campaings = $this->withCache(function () {
			return $this->getCampaigns(false);
		}, "{$this->localCacheDir}/campaings");

		$this->logger->info("PreSync: campaings found", [$campaings]);

		/** @var \Illuminate\Support\Collection $campaign_groups */
		$campaign_groups = $this->getAdGroupsFromCampaigns($campaings)
			->map(function ($v) {
				return [
					'name' => $v->name,
					'campaign' => $this->getShortCampaignName($v->_CampaignName),
					'tag' => $this->tag,
					'bing_id' => "$v->id",
					'active' => $v->data->Status == "Active" ? 1 : 0,
					'dealership' => $this->dealership,
					'cpc' => $v->data->CpcBid->Amount,
				];
			});

		$this->logger->info("PreSync: group found in bing: " . $campaign_groups->count());

		if ($campaign_groups->isNotEmpty()) {
			$groups_in_db = DB::table("{$this->tableName}_group")
				->where('dealership', '=', $this->dealership)
				->where('tag', '=', $this->tag)
				->get()
				->map(function ($v) {
					return (array)$v;
				});
			$this->logger->info("PreSync: group found in db: " . $groups_in_db->count());

			$comparator = function ($a, $b) {
				$aid = "{$a['bing_id']}|{$a['active']}|{$a['cpc']}";
				$bid = "{$b['bing_id']}|{$b['active']}|{$b['cpc']}";
				return $aid == $bid ? 0 : ($aid > $bid ? 1 : -1);
			};
			$to_add_in_db = $campaign_groups->diffUsing($groups_in_db, $comparator);
			$to_remove_from_db = $groups_in_db->diffUsing($campaign_groups, $comparator);
			$this->logger->info("PreSync: group to remove from db: " . $to_remove_from_db->count());
			$this->logger->info("PreSync: group to add in db: " . $to_add_in_db->count());

			if ($to_remove_from_db->isNotEmpty()) {
				DB::table("{$this->tableName}_group")->whereIn('bing_id', $to_remove_from_db->pluck('bing_id')->toArray())->delete();
			}

			if ($to_add_in_db->isNotEmpty()) {
				DB::table("{$this->tableName}_group")->insert($to_add_in_db->toArray());
			}

			$group_ids = $campaign_groups->pluck('bing_id');
			$group_data = $campaign_groups->reduce(function ($acc, $v) {
				$acc->put($v['bing_id'], ['name' => $v['name'], 'campaign' => $v['campaign']]);
				return $acc;
			}, collect([]));

			$ads_in_db = DB::table("{$this->tableName}")->where('dealership', '=', $this->dealership)->get()->reduce(function ($acc, $v) {
				$acc->put($v->hash, (array)$v);
				return $acc;
			}, collect([]));
			$duplicate_ads = collect([]);
			$_ads_in_bing = $this->getAdsFromAdGroups($group_ids->shuffle());
			$ads_in_bing = collect($_ads_in_bing)->reduce(function ($acc, $v) use ($group_data) {
				if ($v->Type == 'ResponsiveSearch') {
					$ad_data = [
						'rsa_titles'	=> json_encode(array_map(
							$this->makeAsset(['NONE' => 0, 'Headline1' => 1, 'Headline2' => 2, 'Headline3' => 3]),
							$v->Headlines->AssetLink
						)),

						'rsa_descriptions'	=> json_encode(array_map(
							$this->makeAsset(['NONE' => 0, 'Description1' => 1, 'Description1' => 2]),
							$v->Descriptions->AssetLink
						)),
					];

					$empty_fields = [
						'title'	=> '',
						'title_2'	=> '',
						'title_3'	=> '',
						'description'	=> '',
						'description_2'	=> '',
					];
				} else if ($v->Type == 'ExpandedText') {
					$ad_data = [
						'title'	=> $v->TitlePart1,
						'title_2'	=> $v->TitlePart2,
						'title_3'	=> $v->TitlePart3,
						'description'	=> $v->Text,
						'description_2'	=> $v->TextPart2,
					];
					$empty_fields = [
						'rsa_titles' => '',
						'rsa_descriptions' => '',
					];
				} else {
					return $acc;
				}

				$ad = array_merge($ad_data, [
					'url' => $v->FinalUrls->string[0],
					'campaign' => $group_data[$v->_AdGroupId]['campaign'],
					'ad_group' => $group_data[$v->_AdGroupId]['name'],
					'dealership' => $this->dealership,
				]);

				$campaign_parts = explode('_', $ad['campaign']);

				$ad['hash'] = $this->calculateAdHash($ad);
				$ad['tag'] = $this->tag;
				$ad['bing_id'] = "{$v->Id}";
				$ad['group_id'] = $v->_AdGroupId;
				$ad['ad_type'] = [
					'ResponsiveSearch' => 'rsa',
					'ExpandedText' => 'esa'
				][$v->Type];
				$ad['stock_type'] = $campaign_parts[1];

				$ad = array_merge($ad, $empty_fields);
				$acc->push($ad);
				return $acc;
			}, collect([]))->groupBy('hash')
				->map(function ($v) use ($ads_in_db, &$duplicate_ads) {
					if ($v->count() > 1) {
						$keep = $v->search(function ($val, $_) use ($ads_in_db) {
							$existing = $ads_in_db->get($val['hash']);
							if ($existing == null ||  $val['bing_id'] == $existing['bing_id']) {
								return true;
							}
						});

						$keep = $keep == false ? 0 : $keep;
						$keep_val = $v[$keep];

						$v->forget($keep);
						$duplicate_ads = $duplicate_ads->merge($v);
					} else {
						$keep_val = $v[0];
					}
					// unset($keep_val['group_id']);
					return $keep_val;
				});

			$ads_in_db = DB::table("{$this->tableName}")
				->where('dealership', '=', $this->dealership)
				->where('tag', '=', $this->tag)
				->get()
				->reduce(function ($acc, $v) {
					$acc->put($v->hash, (array)$v);
					return $acc;
				}, collect([]));

			$ads_to_remove_from_db = $ads_in_db->diffKeys($ads_in_bing);
			/** @var \Illuminate\Support\Collection $ads_to_add_in_db */
			$ads_to_add_in_db = $ads_in_bing->diffKeys($ads_in_db);

			$this->logger->info("PreSync: ads found in bing: " . $ads_in_bing->count());
			$this->logger->info("PreSync: ads found in db: " . $ads_in_db->count());
			$this->logger->info("PreSync: ads to remove from db: " . $ads_to_remove_from_db->count());
			$this->logger->info("PreSync: ads to add in db: " . $ads_to_add_in_db->count(), $ads_to_add_in_db->toArray());

			$to_be_deleted_ads = collect($duplicate_ads)->map(function ($v) {
				return ["ad_id" => $v["bing_id"], "group_id" => $v['group_id']];
			});

			if ($to_be_deleted_ads->isNotEmpty()) {
				$this->logger->info("PreSync: duplicate ads found " . $duplicate_ads->count(), $duplicate_ads->toArray());
				$this->removeAds($to_be_deleted_ads, 1, "Duplicate ads");
			}

			if ($ads_to_remove_from_db->isNotEmpty()) {
				$this->handleSqlError(function () use ($ads_to_remove_from_db) {
					$hash_to_remove = $ads_to_remove_from_db->keys()->toArray();
					$this->removeAdsFromDb('hash', $hash_to_remove, "PreSync: not exist in bing anymore");
				});
			}

			if ($ads_to_add_in_db->isNotEmpty()) {
				$this->handleSqlError(function () use ($ads_to_add_in_db) {
					DB::table("{$this->tableName}")->insert($ads_to_add_in_db->map(function ($v) {
						unset($v['group_id']);
						return $v;
					})->values()->toArray());
				});
			}

			$this->preSyncKeywords($group_ids, 'positive');
			$this->preSyncKeywords($campaign_groups, 'negative', $campaings);
			$this->preSyncCampaignKeywords(collect($campaings), 'negative');
		}


		return $this;
	}

	/**
	 * preSyncKeywords
	 *
	 * @param \Illuminate\Support\Collection $entity_ids
	 * @param string $type
	 */
	public function preSyncKeywords($entity_ids, $type, $campaings = null)
	{
		$keywords = collect([]);
		if ($type == 'positive') {
			$_keywords = $this->getKeywordsFromMultiGroups($entity_ids->shuffle());

			$keywords = collect($_keywords)->reduce(function ($acc, $v) use ($type) {
				$acc->put("{$v->_AdGroupId}|{$v->Id}", [
					'id' => $v->Id,
					'type' => $type,
					'text' => $v->Text,
					'matchType' => strtoupper($v->MatchType),
					'group_id' => $v->_AdGroupId,
				]);
				return $acc;
			}, collect([]));
		} else if ($type == 'negative' && $campaings) {

			$_ne_keywords = [];

			foreach ($entity_ids->shuffle()->groupBy('campaign') as $campaign_name => $cgroup) {
				$campaign = array_filter($campaings, function ($v) use ($campaign_name) {
					return str_replace("_{$this->dealership}", '', $v->name) == $campaign_name;
				});


				if (!empty($campaign)) {
					$this->logger->debug("Getting negative keywords for the groups of campaign", (array)$campaign);
					$_ne_keywords = array_merge($_ne_keywords, $this->getNegativeKeywordsFromMultiGroup(array_pop($campaign)->id, $cgroup->pluck('bing_id')));
				}
			}

			$keywords = collect($_ne_keywords)->reduce(function ($acc, $v) use ($type) {
				$acc->put("{$v->_AdGroupId}|{$v->Id}", [
					'id' => $v->Id,
					'type' => $type,
					'text' => $v->Text,
					'matchType' => strtoupper($v->MatchType),
					'group_id' => $v->_AdGroupId,
				]);

				return $acc;
			}, collect([]));
		} else {
			$this->logger->warning("PreSync: Invalid keyword type");
		}

		$db_keywords = $this->handleSqlError(function () use ($type) {
			return DB::table("{$this->keywordTableName}")
				->where('type', '=', $type)
				->lock(false)
				->get()->reduce(function ($acc, $v) {
					$acc->put("{$v->group_id}|{$v->id}", $v);
					return $acc;
				}, collect([]));
		});

		$to_db_keywords = $keywords->diffKeys($db_keywords);
		$to_remove_keywords = $db_keywords->diffKeys($keywords);

		$this->logger->info("PreSync: {$type} keywords found in bing: " . count($keywords));
		$this->logger->info("PreSync: {$type} keywords found in db: " . count($db_keywords));
		$this->logger->info("PreSync: {$type} keywords to add in db: " . count($to_db_keywords));
		$this->logger->info("PreSync: {$type} keywords to remove from db: " . count($to_remove_keywords));

		if ($to_remove_keywords->isNotEmpty()) {
			$count = 0;
			foreach ($to_remove_keywords->chunk(200) as $chunk) {
				$count += $this->handleSqlError(function () use ($chunk) {
					return DB::table("{$this->keywordTableName}")->whereIn('id', $chunk->map(function ($v) {
						return $v->id;
					})->values()->toArray())->lock(false)->delete();
				});
			}
			$this->logger->info("PreSync: {$type} keywords removed from db: " . $count);
		}

		if ($to_db_keywords->isNotEmpty()) {
			$count = 0;
			foreach ($to_db_keywords->chunk(200) as $chunk) {
				$result = $this->handleSqlError(function () use ($chunk) {
					return DB::table("{$this->keywordTableName}")->lock(false)->insert($chunk->values()->toArray());
				});
				if ($result == true) {
					$count += $chunk->count();
				}
			}
			$this->logger->info("PreSync: {$type} keywords added in db: " . $count);
		}
	}


	/**
	 * preSyncCampaignKeywords
	 *
	 * @param \Illuminate\Support\Collection $campaings
	 * @param string $type
	 */
	public function preSyncCampaignKeywords($campaings, $type)
	{
		$keywords = collect([]);
		// $nkeywords_cf = '_presync-campaign-keywords.bing_cache';
		if ($type == 'positive') {
		} else if ($type == 'negative') {
			$_keywords = $this->getNegativeKeywordsFromMultiCampaign($campaings->pluck('id')->toArray());;
			$keywords = collect($_keywords)->reduce(function ($acc, $v) use ($type, $campaings) {
				$acc->put("{$v->_CampaignId}|{$v->Id}", [
					'id' => $v->Id,
					'campaign' => $this->getShortCampaignName($campaings->firstWhere('id', '=', $v->_CampaignId)->name),
					'tag' => $this->tag,
					'campaign_id' => $v->_CampaignId,
					'type' => $type,
					'matchType' => strtoupper($v->MatchType),
					'text' => $v->Text,
					'dealership' => $this->dealership
				]);
				return $acc;
			}, collect([]));
		}

		$db_keywords = $this->handleSqlError(function () use ($type) {
			return DB::table("{$this->campaignKeywordTableName}")
				->where('dealership', '=', $this->dealership)
				->where('type', '=', $type)
				->where('tag', '=', $this->tag)
				->lock(false)
				->get()->reduce(function ($acc, $v) {
					$acc->put("{$v->campaign_id}|{$v->id}", $v);
					return $acc;
				}, collect([]));
		});

		$to_db_keywords = $keywords->diffKeys($db_keywords);
		$to_remove_keywords = $db_keywords->diffKeys($keywords);

		$this->logger->info("PreSync: {$type} campaign_keywords found in bing: " . count($keywords));
		$this->logger->info("PreSync: {$type} campaign_keywords found in db: " . count($db_keywords));
		$this->logger->info("PreSync: {$type} campaign_keywords to add in db: " . count($to_db_keywords));
		$this->logger->info("PreSync: {$type} campaign_keywords to remove from db: " . count($to_remove_keywords));

		if ($to_remove_keywords->isNotEmpty()) {
			$count = 0;
			foreach ($to_remove_keywords->chunk(200) as $chunk) {
				$count += $this->handleSqlError(function () use ($chunk) {
					return DB::table("{$this->campaignKeywordTableName}")
						->whereIn(
							'id',
							$chunk->map(function ($v) {
								return $v->id;
							})->values()->toArray()
						)
						->lock(false)
						->delete();
				});
			}
			$this->logger->info("PreSync: {$type} campaing_keywords removed from db: " . $count);
		}

		if ($to_db_keywords->isNotEmpty()) {
			$count = 0;
			foreach ($to_db_keywords->chunk(200) as $chunk) {
				$result = $this->handleSqlError(function () use ($chunk) {
					return DB::table("{$this->campaignKeywordTableName}")
						->lock(false)
						->insert($chunk->values()->toArray());
				});
				if ($result == true) {
					$count += $chunk->count();
				}
			}
			$this->logger->info("PreSync: {$type} campaign-keywords added in db: " . $count);
		}
	}

	protected function getCampaignIdByName($name, $create_if_not_existing = true)
	{
		$campaign = $this->withCache(function () use ($name) {
			return $this->bingService->GetCampaign($name);
		},  "{$this->localCacheDir}/campaigns-info-$name");
		$campaign_id = null;

		if ((!$campaign || count($campaign) == 0) && $create_if_not_existing) {
			$this->logger->info("Campaing not found: creating ", ["name" => $name]);
			$budget_name = "$name" . time();
			$budget_key = str_replace("{$this->dealership}_", '', $name);
			$budget_id = $this->bingService->CreateBudget($budget_name, isset($this->budget[$budget_key]) ? $this->budget[$budget_key] : 3);

			if ($budget_id) {
				$this->logger->info("Budget created: ", ["name" => $budget_name, "id" => $budget_id]);
				$campaign_id = $this->bingService->CreateCampaign($name, $budget_id);
				if ($campaign_id) {
					$this->logger->info("Campaing created: ", ["name" => $name, "id" => $campaign_id]);
				} else {
					$this->logger->info("Campaing can't be created: ", ["name" => $name]);
				}
			} else {
				$this->logger->info("Budget can't be created: ", ["name" => $budget_name]);
			}
		} else {
			$campaign_id = $campaign[0]->id;
			$this->logger->info("Campaing found: ", ["name" => $name, "id" => $campaign_id]);
		}

		return $campaign_id;
	}

	protected function clearAdGroup($ad_group_id, $ad_group_name, $campaign_name)
	{
		$this->logger->info("Clearing ad group {$ad_group_name} #{$ad_group_id}");
		$ads = collect($this->bingService->GetAds($ad_group_id))->pluck('Id')->toArray();
		if ($ads) {
			$this->logger->info("Ad found", ['total' => count($ads)]);
			$this->logger->info('Deleting ads ', [$ads]);
			$this->bingService->RemoveAd($ad_group_id, $ads);
			$this->deleteAdByAdGroup($ad_group_name, $campaign_name);
		}

		$keywords = $this->bingService->GetKeywords($ad_group_id);

		if ($keywords) {
			$this->logger->info("Keyword found", ['total' => count($keywords), 'ad group id' => $ad_group_id]);
			$this->logger->info("Removing keywords", ['total' => count($keywords)]);
			$this->bingService->RemoveKeywords($ad_group_id,  $keywords);
		}
		// $this->logger->info("Pausing ad group $ad_group_name #{$ad_group_id}, because no ads");
		// $this->pauseAdGroup($ad_group_id);
	}

	/* protected function getAdGroupId($ad_group_name, $campaign_name, $create_if_not_existing = true, $bid = null)
	{
		$bid = $bid == null ? self::$defaultBid : $bid;
		$ad_group_id = null;

		$ad_groups = $this->withCache(function () use ($campaign_name, $ad_group_name) {
			return $this->bingService->GetAdGroup($campaign_name, $ad_group_name);
		}, "{$this->localCacheDir}/group-info-$ad_group_name-of-$campaign_name");

		if ($ad_groups && count($ad_groups) > 0) {
			$ad_group = $ad_groups[0];
			$ad_group_id = $ad_group->id;
			$this->logger->info("Ad group found: ", ["name" => $ad_group_name, "id" => $ad_group_id]);
		} else {
			$this->logger->info("Ad group not found: ", ["name" => $ad_group_name]);
			if ($create_if_not_existing) {
				$ad_group_id = $this->bingService->CreateAdGroup($campaign_name, $ad_group_name, $bid);
				if ($ad_group_id) {
					$group_data = [
						'name' => $ad_group_name,
						'campaign' => str_replace("{$this->dealership}_", "", $campaign_name),
						'campaign' => $this->getShortCampaignName($campaign_name),
						'tag' => $this->tag,
						'adword_id' => "$ad_group_id",
						'active' => 1,
						'dealership' => $this->dealership,
						'cpc' => $bid,
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
	} */

	protected function setKeywords($ad_group_id, $campaign_name, $template_values)
	{

		$processed_keywords = [];
		$keyword_count = 0;
		$keywords = $this->keywords[$campaign_name]['positive'];
		$processed_keywords = $this->processKeywords($keywords, $template_values);

		if (count($processed_keywords) < 1) {
			$this->logger->error("No positive keywords for group $ad_group_id");
		} else {
			$ids = $this->bingService->SetAdGroupKeywords($ad_group_id, $processed_keywords);

			$this->logger->info("Set positive keywords for group $ad_group_id", ['total' => count($processed_keywords), 'ids' => $ids]);
		}



		return $keyword_count;
	}

	/* protected function pauseAdGroup($ad_group_id)
    {
        $this->bingService->SetAdGroupStatus($ad_group_id, false);
    }

    protected function activateAdGroup($ad_group_id)
    {
        $this->bingService->SetAdGroupStatus($ad_group_id, true);
    } */

	protected function saveAd($ad, $bing_id)
	{
		$result = DB::table($this->tableName)
			->where('hash', '=', $ad['hash'])
			->first();
		if ($result) {
			$this->logger->warning("This hash has been existed in db", ['new' => $ad, 'old' => $result]);
			DB::table($this->tableName)
				->where('hash', '=', $ad['hash'])
				->delete();
		}
		$ad['bing_id'] = $bing_id;
		$this->logger->info('Saving ad', $ad);
		unset($ad['template_values']);
		DB::table($this->tableName)->insert($ad);
	}

	/* protected function deleteAdByHash($hash)
    {
        DB::table($this->tableName)->where('hash', '=', $hash)->delete();
    } */

	/* protected function deleteAdByBingId($id)
    {
        DB::table($this->tableName)->where('bing_id', '=', $id)->delete();
    } */

	protected function deleteAdByAdGroup($group_name, $campaign_name)
	{
		DB::table($this->tableName)
			->where('ad_group', '=', $group_name)
			->where('campaign', '=', $campaign_name)
			->where('dealership', '=', $this->dealership)
			->delete();
	}

	protected function deleteAllAds()
	{
		$this->logger->info('Deleting all ads for ' . $this->dealership);
		DB::table($this->tableName)->where('dealership', '=', $this->dealership)->delete();
	}

	protected function createAd($ad, $ad_group_id)
	{
		$this->logger->info("Createing ad", [$ad['hash']]);

		if (strlen($ad['title']) > 30) {
			$this->logger->error("Headline has more than 30 chars", [$ad['title']]);
		} else if (strlen($ad['title_2']) > 30) {
			$this->logger->error("Headline 2 has more than 30 chars", [$ad['title_2']]);
		} else if (strlen($ad['title_3']) > 30) {
			$this->logger->error("Headline 3 has more than 30 chars", [$ad['title_3']]);
		} else if (strlen($ad['description']) > 90) {
			$this->logger->error("Description has more than 90 chars", [$ad['description']]);
		} else if (strlen($ad['description_2']) > 90) {
			$this->logger->error("Description 2 has more than 90 chars", [$ad['description_2']]);
		} else {
			if (!empty($this->utmSource)) {
				$utm['utm_source'] = $this->utmSource;
			}
			if (!empty($this->utmMedium)) {
				$utm['utm_medium'] = $this->utmMedium;
			}
			if ($this->utmCampaign == true) {
				$utm['utm_campaign'] = $ad['campaign'];
			}
			$url =  add_query_arg($utm, $ad['url']);
			$this->logger->info("url with utm {$url}");
			$bing_id = $this->bingService->CreateAd($ad_group_id, $url, $ad['title'], $ad['title_2'], $ad['title_3'], $ad['description'], $ad['description_2']);
			if ($bing_id) {
				$this->logger->info("Ad created id: " . $bing_id);
				$this->saveAd($ad, $bing_id);
				return $bing_id;
			}
		}

		$this->logger->error("Ad creation failed", array_merge($ad));
		return null;
	}

	/**
	 * removeKeywordsFromMultiGroup
	 *
	 * @param Collection $keyword_info
	 */
	public function removeKeywordsFromMultiGroup($keyword_info, $type)
	{
		$all_removed_keywords = [];
		$this->logger->info("Removing $type keywords from groups", (array)$keyword_info->keys()->toArray());

		/** @var Collection $keywords */
		foreach ($keyword_info as $group_id => $keywords) {
			$this->logger->debug("Removing " . $keywords->count() . " $type keywords from group $group_id");
			if ($type == 'positive') {
				$removed_keywords = $this->bingService->RemoveKeywords($group_id, $keywords->pluck('id')->values()->toArray());
			} else {
				$removed_keywords = $this->bingService->RemoveGroupNegativeKeywords($group_id, $keywords->pluck('id')->values()->toArray());
			}

			if (!empty($removed_keywords)) {
				$this->handleSqlError(function () use ($removed_keywords, $group_id) {
					$query = DB::table("{$this->keywordTableName}");
					foreach ($removed_keywords as $kw) {
						$query->orWhere([["id", $kw], ["group_id", $group_id]]);
					}
					return $query->lock(false)->delete();
				});
				$all_removed_keywords = array_merge($all_removed_keywords, $removed_keywords);
			} else {
				$removed_keywords = [];
			}
			$this->logger->info("Removed " . count($removed_keywords) . " $type keyword");
		}

		return $all_removed_keywords;
	}

	/**
	 * removeKeywordsFromMultiCampaigns
	 *
	 * @param Collection $keyword_info
	 */
	public function removeKeywordsFromMultiCampaigns($keyword_info, $type)
	{
		$all_removed_keywords = [];

		/** @var Collection $keywords */
		foreach ($keyword_info as $campaign_id => $keywords) {
			$this->logger->info("Removing " . $keywords->count() . " $type campaign keyword");

			$this->logger->debug("Removing $type keywords from campaign $campaign_id");
			if ($type == 'positive') {
				$this->logger->warning("Delete positive keywords for campaign is not implemented yet");
			} else {
				$removed_keywords = $this->bingService->RemoveCampaignNegativeKeywords(
					$campaign_id,
					$keywords->pluck('id')->values()->toArray()
				);
			}

			if (!empty($removed_keywords)) {
				$this->handleSqlError(function () use ($removed_keywords, $campaign_id) {
					$query = DB::table("{$this->campaignKeywordTableName}");
					foreach ($removed_keywords as $kw) {
						$query->orWhere([["id", $kw], ["campaign_id", $campaign_id]]);
					}
					return $query->lock(false)->delete();
				});
				$all_removed_keywords = array_merge($all_removed_keywords, $removed_keywords);
			} else {
				$removed_keywords = [];
			}
			$this->logger->info("Removed " . count($removed_keywords) . " $type campaign keyword");
		}

		return $all_removed_keywords;
	}

	public function setKeywordsInMultiGroup($keyword_info, $type)
	{
		$all_created_keywords = [];

		foreach ($keyword_info as $group_id => $keywords) {
			try {
				if (empty($group_id)) {
					throw new Exception("Keyword group id can not be empty");
				} else {
					$this->logger->info("Creating " . $keywords->count() . " $type keyword in $group_id");
					if ($type == 'positive') {
						$created_keywords = $this->bingService->SetAdGroupKeywords($group_id, $keywords->toArray());
					} else {
						$created_keywords = $this->bingService->SetGroupNegativeKeywords($group_id, $keywords->toArray());
					}
					$this->logger->debug("Created keywords:", $created_keywords);

					if (!empty($created_keywords)) {
						foreach ($created_keywords as $k) {
							$insert_data[] = [
								"id" => $k['id'],
								"text" => $k['text'],
								"matchType" => $k['matchType'],
								"group_id" => $group_id,
								"type" => $type
							];
						}
						$this->handleSqlError(function () use ($created_keywords) {
							return DB::table("{$this->keywordTableName}")->lock(false)->insert($created_keywords);
						});
						$all_created_keywords = array_merge($all_created_keywords, $created_keywords);
					}

					$this->logger->info("Created " . count($created_keywords) . " $type keyword");
				}
			} catch (Exception $e) {
				$this->logger->debug("keywords creating error", [$e->getMessage()]);
			}
		}

		return $all_created_keywords;
	}

	function setKeywordsInMultiCampaigns($keywords, $type)
	{
		$created = [];

		foreach ($keywords as $campaign => $c_kws) {
			$c_kws = collect($c_kws);
			$full_name = $this->getFullCampaignName($campaign);
			$campaign_id = $this->getCampaignIdByName($full_name);
			if ($type == "negative") {
				$kws = $this->bingService->SetCampaignNegativeKeywords($campaign_id, $c_kws->toArray());
			} else {
				$kws = [];
				$this->logger->warning("Positive keywords for campaign is not implemented yet");
			}
			if (is_array($kws) && !empty($kws)) {
				$created = array_merge($created, $kws);
				DB::table($this->campaignKeywordTableName)->insert($kws);
			}
		}

		return $created;
	}

	public function createAds($ads_data, $type)
	{
		$all_ads = [];

		foreach ($ads_data as $ad) {
			$this->logger->info("Creating 1 ads", (array)$ad);
			if ($type == 'rsa') {
				$created_ids = $this->bingService->CreateResponsiveSearchAds($ad);
			} else if ($type == 'esa') {
				$created_ids = $this->bingService->CreateAd($ad->adGroupId, $ad->ad['urls'][0], $ad->ad['title'], $ad->ad['title_2'], $ad->ad['title_3'], $ad->ad['description'], $ad->ad['description_2']);
			}

			$this->logger->info('Created ' . $type . ' ads', [$created_ids]);

			if (!empty($created_ids)) {
				$created_ads = array_map(function ($ad_id) use ($type, $ad) {
					$parts = explode('{||}', $this->groupIds->search($ad->adGroupId));
					if ($type == 'rsa') {
						$ad_data = [
							'rsa_titles' => json_encode((array)$ad->ad['titles']),
							'rsa_descriptions' => json_encode((array)$ad->ad['descriptions']),
						];
						$empty_fields = [
							'title'	=> '',
							'title_2'	=> '',
							'title_3'	=> '',
							'description'	=> '',
							'description_2'	=> '',
						];
					} else if ($type == 'esa') {
						$ad_data = [
							'title'	=> $ad->ad['title'],
							'title_2'	=> $ad->ad['title_2'],
							'title_3'	=> $ad->ad['title_3'],
							'description'	=> $ad->ad['description'],
							'description_2'	=> $ad->ad['description_2'],
						];
						$empty_fields = [
							'rsa_titles' => '',
							'rsa_descriptions' => '',
						];
					}
					$ad = array_merge(
						$ad_data,
						[
							'url' => $ad->ad['urls'][0],
							'campaign' => $parts[1],
							'ad_group' => $parts[0],
							'dealership' => $this->dealership,
						]
					);

					$ad['hash'] = $this->calculateAdHash($ad);
					$ad['tag'] = $this->tag;
					$ad['ad_type'] = $type;
					$ad['bing_id'] = $ad_id;
					$ad['stock_type'] = $this->stockType;
					$this->logger->debug('processed ad', $ad);
					return array_merge($ad, $empty_fields);
				}, [$created_ids]);

				$all_ads = array_merge($all_ads, $created_ads);

				$this->handleSqlError(function () use ($created_ads) {
					return DB::table($this->tableName)->insert($created_ads);
				});
			} else {
				$created_ads = [];
			}
			$this->logger->debug("Created " . (isset($created_ads) ? count($created_ads) : 0)  . " ads");
		}

		return $all_ads;
	}

	private function unpublishPositiveKeywords()
	{
		$to_be_deleted_positive_keywords = $this->deletedKeywords->where('type', 'positive');

		$this->logger->info("Deleting positive keywords " . $to_be_deleted_positive_keywords->count());
		if ($to_be_deleted_positive_keywords->isNotEmpty()) {
			$deleted_positive_keywords = $this->removeKeywordsFromMultiGroup(
				$to_be_deleted_positive_keywords->groupBy('group_id'),
				"positive"
			);
		}

		$this->logger->info("Deleted positive keywords", [
			"to" => $to_be_deleted_positive_keywords->count(),
			"done" => isset($deleted_positive_keywords) &&
				is_array($deleted_positive_keywords) ?
				count($deleted_positive_keywords) : 0
		]);
	}

	private function unpublishNegativeKeywords()
	{
		$to_be_deleted_negative_keywords = $this->deletedKeywords
			->where('type', 'negative');

		$this->logger->info("Deleting negative keywords " . $to_be_deleted_negative_keywords->count());
		if ($to_be_deleted_negative_keywords->isNotEmpty()) {
			$deleted_negative_keywords = $this->removeKeywordsFromMultiGroup(
				$to_be_deleted_negative_keywords->groupBy('group_id'),
				"negative"
			);
		}

		$this->logger->info("Deleted negative keywords", [
			"to" => $to_be_deleted_negative_keywords->count(),
			"done" => isset($deleted_negative_keywords) &&
				is_array($deleted_negative_keywords) ?
				count($deleted_negative_keywords) : 0
		]);
	}

	private function unpublishNegativeCampaignKeywords()
	{

		// Delete unused negative keywords for campaigns
		$to_be_deleted_campaign_negative_keywords = $this->deletedCampaignKeywords
			->where('type', 'negative');

		$this->logger->info("Deleting negative campaign keywords " . $to_be_deleted_campaign_negative_keywords->count());
		if ($to_be_deleted_campaign_negative_keywords->isNotEmpty()) {
			$deleted_campaign_negative_keywords = $this->removeKeywordsFromMultiCampaigns(
				$to_be_deleted_campaign_negative_keywords->groupBy('campaign_id'),
				"negative"
			);
		}

		$this->logger->info("Deleted negative campaign keywords", [
			"to" => $to_be_deleted_campaign_negative_keywords->count(),
			"done" => isset($deleted_negative_keywords) &&
				is_array($deleted_campaign_negative_keywords) ?
				count($deleted_campaign_negative_keywords) : 0
		]);
	}

	private function unpublishAds()
	{
		$this->logger->info("Deleting ads details", $this->deletedAds);
		$to_be_deleted_ads = collect($this->deletedAds)->map(function ($v) {
			return [
				"ad_id" => $v["bing_id"],
				"group_id" => $this->groupIds["{$v['ad_group']}{||}{$v['campaign']}"]
			];
		});
		if ($to_be_deleted_ads->isNotEmpty()) {
			$deleted_ads = $this->removeAds($to_be_deleted_ads, 1, 'Deleted during publishing campaigns');
		}
		$this->logger->info("Deleted ads", [
			"to" => $to_be_deleted_ads->count(),
			"done" => isset($deleted_ads) && is_array($deleted_ads) ? count($deleted_ads) : 0
		]);
	}


	private function publishNegativeKeywords()
	{
		// Create new negative keywords for groups
		$new_negative_keywords = $this->newKeywords->where('type', 'negative')->map(function ($v) {
			return [
				'text' => $v['text'],
				'matchType' => $v['matchType'],
				'group_id' => $this->groupIds->get("{$v['group_name']}{||}{$v['campaign']}")
			];
		});

		$this->logger->info("Creating negative keywords " . $new_negative_keywords->count());
		$new_negative_keywords_created = $this->setKeywordsInMultiGroup(
			$new_negative_keywords->groupBy('group_id'),
			'negative'
		);

		$this->logger->info("Created new negative keywords", [
			"to" => $new_negative_keywords->count(),
			"done" => is_array($new_negative_keywords_created) ? count($new_negative_keywords_created) : 0
		]);
	}

	private function publishPositiveKeywords()
	{
		// Create new positive keywords for groups
		$new_positive_keywords = $this->newKeywords->where('type', 'positive')->map(function ($v) {
			return [
				'text' => $v['text'],
				'matchType' => $v['matchType'],
				'group_id' => $this->groupIds->get("{$v['group_name']}{||}{$v['campaign']}")
			];
		});
		$this->logger->info("Creating positive keywords " . $new_positive_keywords->count());
		$new_positive_keywords_created = $this->setKeywordsInMultiGroup(
			$new_positive_keywords->groupBy('group_id'),
			'positive'
		);
		$this->logger->info("Created new positive keywords", [
			"to" => $new_positive_keywords->count(),
			"done" => is_array($new_positive_keywords_created) ? count($new_positive_keywords_created) : 0
		]);
	}

	private function publishNegativeCampaignKeywords()
	{
		// Create new negative keywords for campaigns
		$new_negative_campaign_keywords = $this->newCampaignKeywords->filter(function ($k) {
			return $k["matchType"] != "BROAD";
		})->where('type', 'negative');

		$this->logger->info("Creating negative keywords for campaigns" . $new_negative_campaign_keywords->count());

		$new_negative_campaign_keywords_created = $this->setKeywordsInMultiCampaigns(
			$new_negative_campaign_keywords->groupBy('campaign'),
			'negative'
		);

		$this->logger->info("Created new negative campaign keywords", [
			"to" => $new_negative_campaign_keywords->count(),
			"done" => is_array($new_negative_campaign_keywords_created) ? count($new_negative_campaign_keywords_created) : 0
		]);
	}

	private function publishAds()
	{
		$new_ads_data = collect($this->newAds)->mapToGroups(function ($ad) {
			if ($ad['ad_type'] == 'esa') {
				$ad_data = [
					"title"	=> $ad["title"],
					"title_2"	=> $ad["title_2"],
					"title_3"	=> $ad["title_3"],
					"description"	=> $ad["description"],
					"description_2"	=> $ad["description_2"],
				];
			} else if ($ad['ad_type'] == 'rsa') {
				$ad_data = [
					"titles"	=> json_decode($ad["rsa_titles"]),
					"descriptions"	=> json_decode($ad["rsa_descriptions"]),
				];
			}

			$key = "{$ad["ad_group"]}{||}{$ad["campaign"]}";

			return [
				$ad["ad_type"] => (object)[
					"adGroupId" => isset($this->groupIds[$key]) ? $this->groupIds[$key] : null,
					"ad" => array_merge(["urls"	=> [$ad["url"]]], $ad_data),
				],
			];
		});

		if (isset($new_ads_data['rsa'])) {
			$this->logger->info("Creating responsive search ads " . $new_ads_data['rsa']->count());
			$new_rsa_created = $this->createAds($new_ads_data['rsa'], 'rsa');
			$this->logger->info(
				"Created new responsive search ads",
				["to" => $new_ads_data['rsa']->count(), "done" => is_array($new_rsa_created) ? count($new_rsa_created) : 0]
			);
		};

		if (isset($new_ads_data['esa'])) {
			$this->logger->info("Creating extended text ads " . $new_ads_data['esa']->count());
			$new_esa_created = $this->createAds($new_ads_data['esa'], 'esa');
			$this->logger->info(
				"Created new extended text ads",
				[
					"to" => $new_ads_data['esa']->count(),
					"done" => is_array($new_esa_created) ? count($new_esa_created) : 0
				]
			);
		};
	}

	private function publishGroups()
	{
		/* $this->newAdGroupes = $this->newAdGroupes->slice(0, 1)->map(function ($v) {
			$v['name'] = $v['name'] . " zzzz6";
			return $v;
		}); */
		$getter = function ($campaign_name, $ad_group_name) {
			return $this->withCache(function () use ($campaign_name, $ad_group_name) {
				return $this->bingService->GetAdGroup($campaign_name, $ad_group_name);
			}, "{$this->localCacheDir}/group-info-$ad_group_name-of-$campaign_name");
		};
		$creator = function ($campaign_name, $ad_group_name, $bid) {
			return $this->bingService->CreateAdGroup($campaign_name, $ad_group_name, $bid);
		};

		foreach ($this->newAdGroupes as $new_group) {
			$key = "{$new_group["name"]}{||}{$new_group["campaign"]}";
			if ($this->groupIds->get($key, null) == null) {
				$this->getAdGroupId(
					$new_group["name"],
					$this->getAltCampaignName($this->getFullCampaignName($new_group["campaign"])),
					null,
					$getter,
					null,
					$creator,
					$this->groupCpc[$key]
				);
			}
		}
	}

	private function publishCampaigns()
	{
		$ids = $this->totalAdsInGroups->keys()->reduce(function ($all, $v) {
			$parts = explode("{||}", $v);
			if ($all->get($parts[1], null) == null) {
				$bing_campaign_name = $this->getAltCampaignName($this->getFullCampaignName($parts[1]));
				$campaign_id = $this->getCampaignIdByName($bing_campaign_name);
				$all->put($parts[1], $campaign_id);
			}
			return $all;
		}, collect([]));

		$this->logger->info("Campaigns", $ids->toArray());
		return $ids;
	}

	public function publishCampaign()
	{
		if ($this->disabled == true) {
			$this->logger->info("Disabled: {$this->stockType}");
			return;
		};

		if ($this->dry == true) {
			$this->logger->info("This is a dry run. Not publishing ads");
			$this->dryRun();
			$this->logger->info("Dry: complete");
			return;
		}

		try {
			$this->unpublishPositiveKeywords();
			$this->unpublishNegativeKeywords();
			$this->unpublishNegativeCampaignKeywords();
			$this->unpublishAds();
			$this->publishCampaigns();
			$this->publishGroups();
			$this->publishNegativeKeywords();
			$this->publishPositiveKeywords();
			$this->publishNegativeCampaignKeywords();
			$this->publishAds();
		} catch (Exception $error) {
			$this->logger->error("Publish ad error " . $error->getMessage());
		}

		$this->logger->info("Ad publishing complete.", ['type' => $this->stockType]);

		/* $groups_to_disable = DB::table("{$this->tableName}_group")
				->select(['bing_id'])
				->whereIn('bing_id', $this->epmtyAdGroups->pluck('bing_id'))
				->where('active', 1)
				->pluck('bing_id');
			$this->logger->info("Groups to disable: ", $groups_to_disable->toArray());
			$this->logger->info("Disabling ad groups " . $this->epmtyAdGroups->count());
			if ($groups_to_disable->isNotEmpty()) {
				$disable_groups = $this->setAdGroupsStatus($this->epmtyAdGroups->pluck("bing_id"), false);
			}
			$this->logger->info("Disabled ad groups", ["to" => $this->epmtyAdGroups->count(), "done" => is_array($disable_groups) ? count($disable_groups) : 0]); */


		/* $activate_groups = $this->publishedAdGroupes->filter(function ($v) {
				return $v->active == 0;
			})->intersectByKeys($this->totalAdsInGroups)->pluck('bing_id');

			$activated_groups = $this->setAdGroupsStatus($activate_groups, true);
			$this->logger->info("Reactived ad groups", ["to" => $activate_groups->count(), "done" => is_array($activated_groups) ? count($activated_groups) : 0]); */

		/* $bid_updated =
				$this->getAdGroupsFromCampaigns($campaings)
				->filter(function ($v) {
					$campaign_name = str_replace("_{$this->dealership}", '', $v->_CampaignName);
					$key = "{$v->name}{||}$campaign_name";
					$bid = isset($this->groupCpc[$key]) ? $this->groupCpc[$key] : self::$defaultBid;
					$this->logger->debug("Update bid: is active {$v->data->Status}, bid ammount {$v->data->CpcBid->Amount}");
					$this->logger->debug("Update bid: should update? " . ($v->data->Status == "Active" && $v->data->CpcBid->Amount != $bid) ? "yes" : "no");
					return $v->data->Status == "Active" && $v->data->CpcBid->Amount != $bid;
				})->map(function ($v) {
					$campaign_name = str_replace("_{$this->dealership}", '', $v->_CampaignName);
					$campaign = $this->bingService->GetCampaign('smedia_ledinghamgm_new_make_model');
					$this->logger->debug("Updating bid: campaing-group $campaign_name {$v->name}");
					if (is_array($campaign) && isset($campaign[0]) && isset($campaign[0]->id)) {
						$this->logger->debug("Updating bid: campain found");
						$key = "{$v->name}{||}$campaign_name";
						$bid = isset($this->groupCpc[$key]) ? $this->groupCpc[$key] : self::$defaultBid;
						$this->logger->info("Updating bid to $bid", (array)$v);
						return [$v->id, $this->updateAdGroupBid($campaign[0]->id, $v->id, $bid)];
					} else {
						return null;
					}
				});

			if (!empty($bid_updated)) {
				$this->logger->info("Bid updated", $bid_updated->toArray());
			} */
	}


	public function clearAds()
	{
		if ($this->dry == true) {
			$this->logger->info("This is a dry run. Not clearing ads");
			return;
		}

		$campaigns = $this->bingService->GetCampaigns();
		$del_campaigns =  [
			strtolower("smedia_{$this->dealership}_used_make"),
			strtolower("smedia_{$this->dealership}_used_make_model"),
			strtolower("smedia_{$this->dealership}_used_make_model_year"),
			strtolower("smedia_{$this->dealership}_new_make"),
			strtolower("smedia_{$this->dealership}_new_make_model"),
			strtolower("smedia_{$this->dealership}_new_make_model_year"),
		];

		foreach ($campaigns as $campaign) {
			$this->logger->info("Checking ", [$campaign->name]);
			if (!in_array(strtolower($campaign->name), $del_campaigns)) {
				continue;
			}

			$this->logger->info('Clearing adgroups in ' . $campaign->name);

			$adgroups = $this->bingService->GetAdGroups($campaign->name);
			$this->logger->info("Adgroup found " . count($adgroups));

			if (!$adgroups) {
				continue;
			}

			foreach ($adgroups as $adgroup) {
				$this->logger->info("Group info", [$adgroup]);
				$this->clearAdGroup($adgroup->id, $adgroup->name, $campaign->name);
			}
		}

		$this->deleteAllAds();
		$this->logger->info("Ad clear complete");
	}

	private function dump($output,  $die = true, $type = "json")
	{
		if ($output != "~") {
			switch ($type) {
				case "json":
					echo json_encode($output);
					break;
				case "php";
					var_export($output);
					break;
				default:
					var_dump($output);
					break;
			}
		}

		if ($die) {
			exit();
		}
	}

	private function dryRun()
	{
		$this->logger->warning("Dry run is not implemented");
	}
}
