<?php

namespace sMedia\AdSync\Controller;

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Collection;
use sMedia\AdSync\Service\AdwordAdService;
// use sMedia\AdSync\Utils;

class AdwordsController extends AdSyncBase
{
	/**
	 * adwordService
	 *
	 * @var AdwordAdService
	 */
	public $adwordService;

	public function __construct($dealership)
	{
		// increase this value if you need to recreate all ads
		$this->adReset = 5;
		parent::__construct($dealership, self::SERVICE_ADWORDS);
	}

	// This function should be removed after all scrapper ran once
	public function preSync()
	{
		DB::connection()->statement(
			"CREATE TABLE IF NOT EXISTS `{$this->keywordTableName}` (
					`id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
					`type` enum('positive','negative') COLLATE utf8mb4_unicode_ci NOT NULL,
					`text` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
					`matchType` enum('BROAD','PHRASE','EXACT') COLLATE utf8mb4_unicode_ci NOT NULL,
					`group_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
					PRIMARY KEY (`id`,`group_id`)
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

		$campaign_groups = $this->getAdGroupsFromCampaigns(false, null, ['Id', 'CpcBid', 'Status', 'CampaignName', 'Name'])
			->map(function ($v) {
				return [
					'name' => $v->name,
					'campaign' => $this->getShortCampaignName($v->campaignName),
					'tag' => $this->tag,
					'adword_id' => "$v->id",
					'active' => $v->status == "ENABLED" ? 1 : 0,
					'dealership' => $this->dealership,
					'cpc' => $v->biddingStrategyConfiguration->bids[0]->bid->microAmount / 1000000
				];
			});

		$this->logger->info("PreSync: group found in adwords: " . $campaign_groups->count());

		$groups_in_db = DB::table("{$this->tableName}_group")
			->where('dealership', '=', $this->dealership)
			->where('tag', '=', $this->tag)
			->get()
			->map(function ($v) {
				return (array)$v;
			});
		$this->logger->info("PreSync: group found in db: " . $groups_in_db->count());

		$comparator = function ($a, $b) {
			$aid = "{$a['adword_id']}|{$a['active']}|{$a['cpc']}";
			$bid = "{$b['adword_id']}|{$b['active']}|{$b['cpc']}";
			return $aid == $bid ? 0 : ($aid > $bid ? 1 : -1);
		};
		$to_add_in_db = $campaign_groups->diffUsing($groups_in_db, $comparator);
		$to_remove_from_db = $groups_in_db->diffUsing($campaign_groups, $comparator);
		$this->logger->info("PreSync: group found in adwords: " . $campaign_groups->count());
		$this->logger->info("PreSync: group found in ad: " . $groups_in_db->count());
		$this->logger->info("PreSync: group to remove from db: " . $to_remove_from_db->count());
		$this->logger->info("PreSync: group to add in db: " . $to_add_in_db->count());

		if ($to_remove_from_db->isNotEmpty()) {
			DB::table("{$this->tableName}_group")->whereIn('adword_id', $to_remove_from_db->pluck('adword_id')->toArray())->delete();
		}

		if ($to_add_in_db->isNotEmpty()) {
			DB::table("{$this->tableName}_group")->insert($to_add_in_db->toArray());
		}

		$group_ids = $campaign_groups->pluck('adword_id');
		$group_data = $campaign_groups->reduce(function ($acc, $v) {
			$acc->put($v['adword_id'], ['name' => $v['name'], 'campaign' => $v['campaign']]);
			return $acc;
		}, collect([]));

		$ads_in_db = DB::table("{$this->tableName}")
			->where('dealership', '=', $this->dealership)
			->where('tag', '=', $this->tag)
			->get()
			->reduce(function ($acc, $v) {
				$acc->put($v->hash, (array)$v);
				return $acc;
			}, collect([]));
		$duplicate_ads = collect([]);
		$ads_in_adwords = collect($this->getAdsFromAdGroups($group_ids))->reduce(function ($acc, $v) use ($group_data) {
			if ($v->ad->type == 'RESPONSIVE_SEARCH_AD') {
				$ad_data = [
					'rsa_titles'	=> json_encode(array_map(
						$this->makeAsset(['NONE' => 0, 'HEADLINE_1' => 1, 'HEADLINE_2' => 2, 'HEADLINE_3' => 3]),
						$v->ad->headlines
					)),

					'rsa_descriptions'	=> json_encode(array_map(
						$this->makeAsset(['NONE' => 0, 'DESCRIPTION_1' => 1, 'DESCRIPTION_2' => 2]),
						$v->ad->descriptions
					)),
				];

				$empty_fields = [
					'title'	=> '',
					'title_2'	=> '',
					'title_3'	=> '',
					'description'	=> '',
					'description_2'	=> '',
				];
			} else if ($v->ad->type == 'EXPANDED_TEXT_AD') {
				$ad_data = [
					'title'	=> $v->ad->headlinePart1,
					'title_2'	=> $v->ad->headlinePart2,
					'title_3'	=> $v->ad->headlinePart3,
					'description'	=> $v->ad->description,
					'description_2'	=> $v->ad->description2,
				];
				$empty_fields = [
					'rsa_titles' => '',
					'rsa_descriptions' => '',
				];
			} else {
				return $acc;
			}

			$ad = array_merge($ad_data, [
				'url' => $v->ad->finalUrls[0],
				'campaign' => $group_data[$v->adGroupId]['campaign'],
				'ad_group' => $group_data[$v->adGroupId]['name'],
				'dealership' => $this->dealership,
			]);

			$campaign_parts = explode('_', $ad['campaign']);

			$ad['hash'] = $this->calculateAdHash($ad);
			$ad['tag'] = $this->tag;
			$ad['adword_id'] = "{$v->ad->id}";
			$ad['stock_type'] = $campaign_parts[1];
			$ad['group_id'] = $v->adGroupId;
			$ad['ad_type'] = [
				'RESPONSIVE_SEARCH_AD' => 'rsa',
				'EXPANDED_TEXT_AD' => 'esa'
			][$v->ad->type];

			$ad = array_merge($ad, $empty_fields);
			$acc->push($ad);
			return $acc;
		}, collect([]))->groupBy('hash')
			->map(function ($v) use ($ads_in_db, &$duplicate_ads) {
				if ($v->count() > 1) {
					$keep = $v->search(function ($val, $_) use ($ads_in_db) {
						$existing = $ads_in_db->get($val['hash']);
						if ($existing == null ||  $val['adword_id'] == $existing['adword_id']) {
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
				unset($keep_val['group_id']);
				return $keep_val;
			});

		/* $ads_in_db = DB::table("{$this->tableName}")
			->where('dealership', '=', $this->dealership)
			->where('tag', '=', $this->tag)
			->get()
			->reduce(function ($acc, $v) {
				$acc->put($v->hash, (array)$v);
				return $acc;
			}, collect([])); */

		$ads_to_remove_from_db = $ads_in_db->diffKeys($ads_in_adwords);
		$ads_to_add_in_db = $ads_in_adwords->diffKeys($ads_in_db);

		$this->logger->info("PreSync: ads found in adwords: " . $ads_in_adwords->count());
		$this->logger->info("PreSync: ads found in db: " . $ads_in_db->count());
		$this->logger->info("PreSync: ads to remove from db: " . $ads_to_remove_from_db->count());
		$this->logger->info("PreSync: ads to add in db: " . $ads_to_add_in_db->count(), $ads_to_add_in_db->toArray());

		$to_be_deleted_ads = collect($duplicate_ads)->map(function ($v) {
			return ["ad_id" => $v["adword_id"], "group_id" => $v['group_id']];
		});

		if ($to_be_deleted_ads->isNotEmpty()) {
			$this->logger->info("PreSync: duplicate ads found " . $duplicate_ads->count());
			$this->removeAds($to_be_deleted_ads, 1, "Duplicate ads");
		}

		if ($ads_to_remove_from_db->isNotEmpty()) {
			$this->handleSqlError(function () use ($ads_to_remove_from_db) {
				$hash_to_remove = $ads_to_remove_from_db->keys()->toArray();

				$this->removeAdsFromDb('hash', $hash_to_remove, "PreSync: not exist in adword anymore");
			});
		}

		if ($ads_to_add_in_db->isNotEmpty()) {
			$chunks = $ads_to_add_in_db->chunk(200);
			$this->logger->debug("PreSync: ads to add in db chunk total: ", [$chunks->count()]);
			foreach ($chunks as $chunk) {
				$this->logger->debug("PreSync: ads to add in db chunk");
				$this->handleSqlError(function () use ($chunk) {
					DB::table("{$this->tableName}")->insert($chunk->values()->toArray());
				});
			}
		}

		$this->preSyncKeywords($group_ids, 'positive');
		$this->preSyncKeywords($group_ids, 'negative');

		return $this;
	}

	/**
	 * preSyncKeywords
	 *
	 * @param Collection $group_ids
	 * @param string $type
	 */
	public function preSyncKeywords($group_ids, $type)
	{
		$keywords = collect($this->getKeywordsFromMultiGroups($group_ids, $type))->reduce(function ($acc, $v) use ($type) {
			$acc->put("{$v->adGroupId}|{$v->criterion->id}", [
				'id' => $v->criterion->id,
				'type' => $type,
				'text' => $v->criterion->text,
				'matchType' => $v->criterion->matchType,
				'group_id' => $v->adGroupId,
			]);
			return $acc;
		}, collect([]));

		$db_keywords = $this->handleSqlError(function () use ($type, $group_ids) {
			return DB::table("{$this->keywordTableName}")
				->where('type', '=', $type)
				->whereIn('group_id', $group_ids)
				->lock(false)
				->get()->reduce(function ($acc, $v) {
					$acc->put("{$v->group_id}|{$v->id}", $v);
					return $acc;
				}, collect([]));
		});

		$to_db_keywords = $keywords->diffKeys($db_keywords);
		$to_remove_keywords = $db_keywords->diffKeys($keywords);

		$this->logger->info("PreSync: {$type} keywords found in adwords: " . count($keywords));
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
	 * setAdwordService
	 *
	 * @param AdwordAdService $adword_service
	 */
	public function setAdwordService(AdwordAdService $adword_service)
	{
		$this->adwordService = $adword_service;
		return $this;
	}

	private function getCampaignIdByName($name, $create_if_not_existing = true)
	{
		$campaign = $this->adwordService->GetCampaign($name);
		$campaign_id = null;

		if ((!$campaign || count($campaign) == 0) && $create_if_not_existing) {
			$this->logger->info("Campaing not found: creating ", ["name" => $name]);
			$budget_name = "$name" . time();
			$budget_key = str_replace("{$this->dealership}_", '', $name);
			$budget_id = $this->adwordService->CreateBudget($budget_name, isset($this->budget[$budget_key]) ? $this->budget[$budget_key] : 3);
			if ($budget_id) {
				$this->logger->info("Budget created: ", ["name" => $budget_name, "id" => $budget_id]);
				$campaign_id = $this->adwordService->CreateCampaign($name, $budget_id, true, false);
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

	private function getCombinedUserList()
	{
		$result = DB::table('combined_userlist')
			->select(['userlist_id'])
			->where('cron_name', '=', $this->dealership)
			->first();
		if (!$result) {
			return null;
		}
		return $result->userlist_id;
	}

	private function createCombinedUserList()
	{
		$userlist = $this->adwordService->CreateUserList("Rest of the Website Users");
		$userlist_id = $userlist->id;
		$conversion_id = $userlist->conversionTypes[0]->id;
		$conversion_tracker = $this->adwordService->GetConversionTracker($conversion_id);
		$conversion_tracker[0]->snippet = 'sdf';

		if (isset($conversion_tracker[0]->snippet)) {
			$this->storeAdwordsTag($conversion_tracker[0]->snippet, $userlist_id);
		}

		$combined_userlist = $this->adwordService->CreateCombinedUserList("All Users of Website", $userlist_id);

		if ($combined_userlist) {
			$this->storeCombinedUserList($combined_userlist->id);
		}
	}

	private function storeAdwordsTag($codes, $userlist_id)
	{

		$match = false;

		preg_match(
			'/var google_conversion_id ?= ?(?<conversion_id>[0-9]+);\s*var google_conversion_label ?= ?"(?<label>[^"]+)"/',
			$codes,
			$match
		);

		if ($match && $match['conversion_id'] && isset($match['label'])) {
			DB::table('tracker_tags')->insert([
				'url' => $this->host_url,
				'cron_name' => $this->dealership,
				'year' => '',
				'make' => '',
				'model' => '',
				'conversion_id' => $match['conversion_id'],
				'label' => $match['label'],
				'userlist_id' => $userlist_id,
			]);
		}
	}

	private function storeCombinedUserList($userlist_id)
	{
		DB::table('combined_userlist')->insert([
			'cron_name' => $this->dealership,
			'userlist_id' => $userlist_id
		]);
	}

	/* private function pauseAdGroup($ad_group_id)
	{
		return $this->adwordService->SetAdGroupStatus($ad_group_id, false);
	} */

	/* private function activateAdGroup($ad_group_id)
	{
		return $this->adwordService->SetAdGroupStatus($ad_group_id, true);
	} */

	private function updateAdGroupBid($ad_group_id, $bid = null)
	{
		$bid = $bid == null ? self::$defaultBid : $bid;
		$result = $this->adwordService->UpdateAdGroupBid($ad_group_id, $bid);
		if ($result) {
			$this->handleSqlError(function () use ($ad_group_id, $bid) {
				DB::table("{$this->tableName}_group")
					->where('adword_id', $ad_group_id)
					->update(['cpc' => $bid]);
			});
		}
		return $result;
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
				'text' => $v->asset->assetText,
				'position' => $positions[isset($v->pinnedField) ? $v->pinnedField : 'NONE']
			];
		};
	}


	public function createAds($ads_data, $type, $chunk_size = 1)
	{
		$all_ads = [];

		foreach ($ads_data->chunk($chunk_size) as $chunk) {
			$this->logger->info("Creating " . min($chunk_size, $chunk->count()) . " ads", $chunk->values()->toArray());
			if ($type == 'rsa') {
				$created_ads = $this->adwordService->CreateResponsiveSearchAds($chunk->values()->toArray());
			} else if ($type == 'esa') {
				$created_ads = $this->adwordService->CreateAds($chunk->values()->toArray());
			}

			if (!empty($created_ads)) {
				$all_ads = array_merge($all_ads, $created_ads);
				$ads = array_map(function ($v) use ($type) {
					$parts = explode('{||}', $this->groupIds->search($v->adGroupId));
					if ($type == 'rsa') {
						$ad_data = [
							'rsa_titles' => json_encode(array_map(
								$this->makeAsset(['NONE' => 0, 'HEADLINE_1' => 1, 'HEADLINE_2' => 2, 'HEADLINE_3' => 3]),
								$v->ad->headlines
							)),

							'rsa_descriptions' => json_encode(array_map(
								$this->makeAsset(['NONE' => 0, 'DESCRIPTION_1' => 1, 'DESCRIPTION_2' => 2]),
								$v->ad->descriptions
							)),
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
							'title'	=> $v->ad->headlinePart1,
							'title_2'	=> $v->ad->headlinePart2,
							'title_3'	=> $v->ad->headlinePart3,
							'description'	=> $v->ad->description,
							'description_2'	=> $v->ad->description2,
						];
						$empty_fields = [
							'rsa_titles' => '',
							'rsa_descriptions' => '',
						];
					}
					$ad = array_merge(
						$ad_data,
						[
							'url' => $v->ad->finalUrls[0],
							'campaign' => $parts[1],
							'tag' => $this->tag,
							'ad_group' => $parts[0],
							'dealership' => $this->dealership,
						]
					);

					$ad['hash'] = $this->calculateAdHash($ad);
					$ad['tag'] = $this->tag;
					$ad['adword_id'] = $v->ad->id;
					$ad['stock_type'] = $this->stockType;
					$ad['ad_type'] = $type;
					return array_merge($ad, $empty_fields);
				}, $created_ads);

				$this->handleSqlError(function () use ($ads) {
					return DB::table($this->tableName)->insert($ads);
				});
			} else {
				$created_ads = [];
			}
			$this->logger->info("Created " . count($created_ads) . " ads");
		}

		return $all_ads;
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
			$this->logger->info("Userlist");
			$user_list = $this->getCombinedUserList();
			if (!$user_list) {
				$this->createCombinedUserList();
			}

			$this->unpublishPositiveKeywords();
			$this->unpublishNegativeKeywords();
			// $this->unpublishNegativeCampaignKeywords();
			$this->unpublishAds();
			$this->unpublishGroups();
			$campaign_ids = $this->publishCampaigns();
			$this->publishGroups($campaign_ids);
			$this->publishNegativeKeywords();
			$this->publishPositiveKeywords();
			// $this->publishNegativeCampaignKeywords();
			$this->publishAds();
			$this->reactivatePausedGroups();
			$this->adjustGroupBids();
		} catch (Exception $error) {
			$this->logger->error("Publish ad error " . $error->getMessage());
		}
		$this->logger->info("Ad publishing complete.", ['type' => $this->stockType]);
	}

	/**
	 * publishCampaigns - Create campaigns if not exists
	 */
	public function publishCampaigns()
	{
		$campaign_ids = $this->totalAdsInGroups->keys()->reduce(function ($all, $v) {
			$parts = explode("{||}", $v);
			if ($all->get($parts[1], null) == null) {
				$adwords_campaign_name = $this->getAltCampaignName($this->getFullCampaignName($parts[1]));
				$campaign_id = $this->getCampaignIdByName($adwords_campaign_name);
				$all->put($parts[1], $campaign_id);
			}
			return $all;
		}, collect([]));

		$this->logger->info("Campaigns", $campaign_ids->toArray());

		return $campaign_ids;
	}

	/**
	 * unpublishGroups
	 * Deactivate empty ad groups
	 */
	public function unpublishGroups()
	{
		$groups_to_disable = DB::table("{$this->tableName}_group")
			->select(['adword_id'])
			->whereIn('adword_id', $this->epmtyAdGroups->pluck('adword_id'))
			->where('active', 1)
			->pluck('adword_id');

		$this->logger->info("Groups to disable: ", $groups_to_disable->toArray());
		$this->logger->info("Disabling ad groups " . $this->epmtyAdGroups->count());

		$disable_groups = [];
		if ($groups_to_disable->isNotEmpty()) {
			$disable_groups = $this->setAdGroupsStatus($this->epmtyAdGroups->pluck("adword_id"), false);
		}
		$this->logger->info("Disabled ad groups", ["to" => $this->epmtyAdGroups->count(), "done" => is_array($disable_groups) ? count($disable_groups) : 0]);
	}

	/**
	 * publishGroups - Create new ad groups and reactivate paused group
	 * @param Collection $campaign_ids
	 */
	public function publishGroups($campaign_ids)
	{
		// Create new ad groups
		$getter = function ($campaign_name, $ad_group_name) {
			return $this->adwordService->GetAdGroup($campaign_name, $ad_group_name);
		};
		$status_updater = function ($group_id) {
			$this->adwordService->SetAdGroupStatus($group_id, true);
		};
		$creator = function ($campaign_id, $ad_group_name, $bid) {
			return $this->adwordService->CreateAdGroup($campaign_id, $ad_group_name, $bid);
		};

		foreach ($this->newAdGroupes as $new_group) {
			$key = "{$new_group["name"]}{||}{$new_group["campaign"]}";
			if ($this->groupIds->get($key, null) == null) {
				$this->getAdGroupId(
					$new_group["name"],
					$new_group["campaign"],
					$campaign_ids[$new_group["campaign"]],
					$getter,
					$status_updater,
					$creator,
					$this->groupCpc[$key]
				);
			}
		}
	}

	/**
	 * reactivatePausedGroups
	 * Reactived paused group
	 */
	public function reactivatePausedGroups()
	{
		$activate_groups = $this->publishedAdGroupes->filter(function ($v) {
			return $v->active == 0;
		})->intersectByKeys($this->totalAdsInGroups)->pluck('adword_id');

		$activated_groups = $this->setAdGroupsStatus($activate_groups, true);
		$this->logger->info("Reactived ad groups", ["to" => $activate_groups->count(), "done" => is_array($activated_groups) ? count($activated_groups) : 0]);
	}

	public function adjustGroupBids()
	{
		// Update ad group bid
		$bid_updated =
			$this->getAdGroupsFromCampaigns(false, null, ['Id', 'CpcBid', 'Status', 'CampaignName', 'Name'])
			->filter(function ($v) {
				$campaign_name = $this->getShortCampaignName($v->campaignName);
				$key = "{$v->name}{||}$campaign_name";
				$bid = $this->groupCpc[$key];
				return $v->status == "ENABLED" &&
					$v->biddingStrategyConfiguration->bids[0]->bid->microAmount != $bid * 1000000;
			})
			->map(function ($v) {
				$campaign_name = $this->getShortCampaignName($v->campaignName);
				$key = "{$v->name}{||}$campaign_name";
				$bid = isset($this->groupCpc[$key]) ? $this->groupCpc[$key] : self::$defaultBid;
				$this->logger->info("Updating bid to $bid", (array)$v);
				return $this->updateAdGroupBid($v->id, $bid);
			});
		if (!empty($bid_updated)) {
			$this->logger->info("Bid updated", $bid_updated->toArray());
		}
	}

	/**
	 * publishAds
	 */
	public function publishAds()
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
				"{$ad['ad_type']}" => (object)[
					"adGroupId" => isset($this->groupIds[$key]) ? $this->groupIds[$key] : null,
					"ad" => array_merge(["urls"	=> [$ad["url"]]], $ad_data),
				],
			];
		});

		// Create new rsa ads
		if (isset($new_ads_data['rsa'])) {
			$this->logger->info("Creating responsive search ads " . $new_ads_data['rsa']->count());
			$new_rsa_created = $this->createAds($new_ads_data['rsa'], 'rsa');
			$this->logger->info(
				"Created new responsive search ads",
				["to" => $new_ads_data['rsa']->count(), "done" => is_array($new_rsa_created) ? count($new_rsa_created) : 0]
			);
		};

		// Create new esa ads
		if (isset($new_ads_data['esa'])) {
			$this->logger->info("Creating extended text ads " . $new_ads_data['esa']->count());
			$new_esa_created = $this->createAds($new_ads_data['esa'], 'esa');
			$this->logger->info(
				"Created new extended text ads",
				["to" => $new_ads_data['esa']->count(), "done" => is_array($new_esa_created) ? count($new_esa_created) : 0]
			);
		};
	}

	/**
	 * unpublishPositiveKeywords
	 * Delete unused positive keywords
	 */
	public function unpublishPositiveKeywords()
	{
		$to_be_deleted_positive_keywords = $this->deletedKeywords->where('type', 'positive')->map(function ($v) {
			return ["id" => $v["id"], "group_id" => $v["group_id"]];
		})->values();

		$this->logger->info("Deleting positive keywords " . $to_be_deleted_positive_keywords->count());
		$deleted_positive_keywords = [];
		if ($to_be_deleted_positive_keywords->isNotEmpty()) {
			$deleted_positive_keywords = $this->removeKeywordsFromMultiGroup($to_be_deleted_positive_keywords, "positive");
		}
		$this->logger->info("Deleted positive keywords", ["to" => $to_be_deleted_positive_keywords->count(), "done" => is_array($deleted_positive_keywords) ? count($deleted_positive_keywords) : 0]);
	}

	/**
	 * unpublishNegativeKeywords
	 * Delete unused negative keywords
	 */
	public function unpublishNegativeKeywords()
	{
		$to_be_deleted_negative_keywords = $this->deletedKeywords->where('type', 'negative')->map(function ($v) {
			return ["id" => $v["id"], "group_id" => $v["group_id"]];
		})->values();
		$this->logger->info("Deleting negative keywords " . $to_be_deleted_negative_keywords->count());
		$deleted_negative_keywords = [];
		if ($to_be_deleted_negative_keywords->isNotEmpty()) {
			$deleted_negative_keywords = $this->removeKeywordsFromMultiGroup($to_be_deleted_negative_keywords, "negative");
		}
		$this->logger->info("Deleted negative keywords", ["to" => $to_be_deleted_negative_keywords->count(), "done" => is_array($deleted_negative_keywords) ? count($deleted_negative_keywords) : 0]);
	}

	/**
	 * publishNegativeKeywords
	 * Create new negative keywords
	 */
	public function publishNegativeKeywords()
	{
		$new_negative_keywords = $this->newKeywords->where('type', 'negative')->map(function ($v) {
			$group_key = "{$v['group_name']}{||}{$v['campaign']}";
			$group_id = $this->groupIds->get($group_key);
			if ($group_id) {
				return ['text' => $v['text'], 'matchType' => $v['matchType'], 'group_id' => $group_id];
			} else {
				$this->logger->info("Keyword group id not found", [$v]);
				return null;
			}
		})->filter(function ($v) {
			return $v != null;
		});
		$this->logger->info("Creating negative keywords " . $new_negative_keywords->count());
		$new_negative_keywords_created = $this->setKeywordsInMultiGroup($new_negative_keywords, 'negative');
		$this->logger->info("Created new negative keywords", ["to" => $new_negative_keywords->count(), "done" => is_array($new_negative_keywords_created) ? count($new_negative_keywords_created) : 0]);
	}

	/**
	 * publishPositiveKeywords
	 * Create new positive keywords
	 */
	public function publishPositiveKeywords()
	{
		$new_positive_keywords = $this->newKeywords->where('type', 'positive')->map(function ($v) {
			return ['text' => $v['text'], 'matchType' => $v['matchType'], 'group_id' => $this->groupIds->get("{$v['group_name']}{||}{$v['campaign']}")];
		});
		$this->logger->info("Creating positive keywords " . $new_positive_keywords->count());
		$new_positive_keywords_created = $this->setKeywordsInMultiGroup($new_positive_keywords, 'positive');
		$this->logger->info("Created new positive keywords", ["to" => $new_positive_keywords->count(), "done" => is_array($new_positive_keywords_created) ? count($new_positive_keywords_created) : 0]);
	}

	/**
	 * unpublishAds
	 * Delete unnecessary ads
	 */
	public function unpublishAds()
	{
		$this->logger->info("Deleting ads details", $this->deletedAds);
		$to_be_deleted_ads = collect($this->deletedAds)->map(function ($v) {
			return ["ad_id" => $v["adword_id"], "group_id" => $this->groupIds["{$v['ad_group']}{||}{$v['campaign']}"]];
		});
		$deleted_ads = [];
		if ($to_be_deleted_ads->isNotEmpty()) {
			$deleted_ads = $this->removeAds($to_be_deleted_ads, 1, 'Deleted during publishing campaigns');
		}
		$this->logger->info("Deleted ads", ["to" => $to_be_deleted_ads->count(), "done" => is_array($deleted_ads) ? count($deleted_ads) : 0]);
	}

	private function dryRun()
	{
		DB::table('tbl_adwords_ad_test')->truncate();
		/* foreach ($this->affectedAdGroupes as $campaign => $ad_groups) {
			foreach ($ad_groups as $ad_group => $ads) {
				if (empty($ads)) {
					$this->logger->error("Dry: Empty group will be cleared ", ['campaign' => $campaign, 'group_name' => $ad_group]);
				} else {
					foreach ($ads as $ad) {
						$this->getKeywords($ad_group, $campaign, $ad['template_values']);
						$this->dryAd($ad);
					}
				}
			}
		} */
	}

	private function dryAd($ad)
	{
		$this->logger->info("Dry: Createing ad", [$ad['hash']]);

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
			unset($ad['template_values']);
			DB::table('tbl_adwords_ad_test')->insert($ad);
		}
	}

	/**
	 * getKeywordsFromMultiGroups
	 *
	 * @param Collection $group_ids
	 * @param string $type
	 * @param int $chunk_size
	 */
	public function getKeywordsFromMultiGroups($group_ids, $type = "positive", $chunk_size = 50)
	{
		$all_keywords = [];

		foreach ($group_ids->chunk($chunk_size) as $gi_chunk) {
			if ($type == "positive") {
				$keywords = $this->adwordService->GetKeywordsFromMultiGroups($gi_chunk->values()->toArray(), ['Id', 'KeywordText']);
			} else {
				$keywords = $this->adwordService->GetNegativeKeywordsFromMultiGroups($gi_chunk->values()->toArray(), ['Id', 'KeywordText']);
			}

			if (!empty($keywords)) {
				$all_keywords = array_merge($all_keywords, $keywords);
			}
		}
		return $all_keywords;
	}

	public function removeKeywordsFromMultiGroup($keyword_info, $type = "positive", $chunk_size = 200)
	{
		$all_removed_keywords = [];

		foreach ($keyword_info->chunk($chunk_size) as $keywords) {
			$this->logger->info("Removing " . min($chunk_size, $keywords->count()) . " $type keyword");
			if ($type == "positive") {
				$removed_keywords = $this->adwordService->RemoveKeywords($keywords->values()->toArray());
			} else {
				$removed_keywords = $this->adwordService->RemoveNegativeKeywords($keywords->values()->toArray());
			}

			if (!empty($removed_keywords)) {
				$this->handleSqlError(function () use ($removed_keywords) {
					$query = DB::table("{$this->keywordTableName}");
					foreach ($removed_keywords as $kw) {
						$query->orWhere([["id", $kw->criterion->id], ["group_id", $kw->adGroupId]]);
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

	public function getAdsFromAdGroups($group_ids, $chunk_size = 80)
	{
		$all_ads = [];

		foreach ($group_ids->chunk($chunk_size) as $gi_chunk) {
			$ads = $this->adwordService->GetAdsFromAdGroups($gi_chunk->values()->toArray());
			if (!empty($ads)) {
				$all_ads = array_merge($all_ads, $ads);
			}
		}

		return $all_ads;
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

	public function removeAds($ads_info, $chunk_size = 1, $reason = "Unknown")
	{
		$all_removed_ads = [];
		foreach ($ads_info->chunk($chunk_size) as $chunk) {
			$removing_count = min($chunk_size, $chunk->count());
			$this->logger->info("Removing " . $removing_count . " ads $reason");
			$removed_ads = $this->adwordService->RemoveAds($chunk->values()->toArray());
			if (!empty($removed_ads)) {
				$all_removed_ads = array_merge($all_removed_ads, $removed_ads);
				$remove_ids = array_map(function ($v) {
					return $v->ad->id;
				}, $removed_ads);

				$this->removeAdsFromDb('adword_id', $remove_ids, $reason);
			} else {
				$removed_ads = [];
			}
			$this->logger->info("Removed " . count($removed_ads) . " ads");
			if ($removing_count != count($removed_ads)) {
				$this->logger->warning("Some ads can not be deleted", $chunk->toArray());
			}
		}

		return $all_removed_ads;
	}

	public function setAdGroupsStatus($group_ids, $active, $chunk_size = 50)
	{
		$all_disabled_groups = [];

		foreach ($group_ids->chunk($chunk_size) as $chunk) {
			$to_disable = $chunk->values()->map(function ($v) use ($active) {
				return ['group_id' => $v, 'active' => $active];
			});
			$this->logger->info("Disableing " . min($chunk_size, $chunk->count()) . " groups", $to_disable->toArray());
			$disabled_groups = $this->adwordService->SetMultiAdGroupStatus($to_disable);

			if (!empty($disabled_groups)) {
				DB::table("{$this->tableName}_group")->whereIn("adword_id", $disabled_groups)->update(["active" => $active]);
				$all_disabled_groups = array_merge($all_disabled_groups, $disabled_groups);
			} else {
				$disabled_groups = [];
			}

			$this->logger->info("Disabled " . count($disabled_groups) . " groups");
		}

		return $all_disabled_groups;
	}

	public function setKeywordsInMultiGroup($keyword_info, $type = "positive", $chunk_size = 200)
	{

		$all_created_keywords = [];

		foreach ($keyword_info->chunk($chunk_size) as $keywords) {
			$this->logger->info("Creating " . min($chunk_size, $keywords->count()) . " $type keyword");
			if ($type == "positive") {
				$created_keywords = $this->adwordService->SetMultiGroupKeywords($keywords->values()->toArray());
			} else {
				$created_keywords = $this->adwordService->SetMultiGroupNegativeKeywords($keywords->values()->toArray());
			}

			if (!empty($created_keywords)) {
				$insert_data = collect($created_keywords)->map(function ($v) use ($type) {
					return [
						"id" => $v->criterion->id,
						"text" => $v->criterion->text,
						"matchType" => $v->criterion->matchType,
						"group_id" => $v->adGroupId,
						"type" => $type
					];
				});

				$this->handleSqlError(function () use ($insert_data) {
					return DB::table("{$this->keywordTableName}")->lock(false)->insert($insert_data->toArray());
				});

				$all_created_keywords = array_merge($all_created_keywords, $created_keywords);
			} else {
				$created_keywords = [];
			}
			$this->logger->info("Created " . count($created_keywords) . " $type keyword");
		}

		return $all_created_keywords;
	}

	public function clearAllAds($stock_type = ["new", "used"])
	{
		if ($this->dry == true) {
			$this->logger->info("This is a dry run. Not clearing ads");
			// return;
		}

		$temp_stock_type = $this->stockType;
		$this->validCampaigns = array_reduce($stock_type, function ($all, $v) {
			$this->stockType = $v;
			$this->generateValidCampaignNames();
			$all = array_merge($all, $this->validCampaigns);
			return $all;
		}, []);

		$this->stockType = $temp_stock_type;

		$campaign_groups = $this->getAdGroupsFromCampaigns(false, null);
		if ($campaign_groups->isEmpty()) return;
		$enabled_groupes = $campaign_groups->filter(function ($v) {
			return $v->status == "ENABLED";
		});
		$group_ids = $campaign_groups->pluck('id');

		if (empty($group_ids)) return;

		$this->setAdGroupsStatus($enabled_groupes->pluck('id'), false);

		$raw_keywords = $this->getKeywordsFromMultiGroups($group_ids, 'positive');

		$this->logger->info("Positive keywords found: " . count($raw_keywords));

		if (!empty($raw_keywords)) {
			$all_keywords = collect($raw_keywords)
				->map(function ($v) {
					return ['id' => $v->criterion->id, 'group_id' => $v->adGroupId];
				});

			$removed_keywords = $this->removeKeywordsFromMultiGroup($all_keywords, "positive");
			$this->logger->info("Removed positive keywords: " . count($removed_keywords));
		}

		$raw_negative_keywords = $this->getKeywordsFromMultiGroups($group_ids, 'negative');
		$this->logger->info("Negative keywords found: " . count($raw_negative_keywords));

		if (!empty($raw_negative_keywords)) {
			$all_negative_keywords = collect($raw_negative_keywords)
				->map(function ($v) {
					return ['id' => $v->criterion->id, 'group_id' => $v->adGroupId];
				});

			$removed_negative_keywords = $this->removeKeywordsFromMultiGroup($all_negative_keywords, "negative");
			$this->logger->info("Removed negative keywords: " . count($removed_negative_keywords));
		}


		$raw_ads = $this->getAdsFromAdGroups($group_ids);

		$this->logger->info("Ads found: " . count($raw_ads));

		if (!empty($raw_ads)) {
			$ads = collect($raw_ads)
				->map(function ($v) {
					return ['ad_id' => $v->ad->id, 'group_id' => $v->adGroupId];
				});
			$removed_ads = $this->removeAds($ads, 1, "Clearing all ads");
			$this->logger->info("Removed ads: " . count($removed_ads));
		}

		$this->logger->info("Ad clear complete");
	}

	public function getCampaigns($active_only = true, $v2_only = true)
	{
		$campaigns = $this->adwordService->GetCampaigns();
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

	public function getAdGroupsFromCampaigns($active_only = false, $group_by = 'campaignName', $fields = [])
	{
		$campaings = $this->getCampaigns($active_only);
		$campaign_ids = array_reduce($campaings, function ($all, $campaign) {
			if (in_array($this->getOriginalCampaignName($campaign->name), $this->validCampaigns)) {
				$all[] = $campaign->id;
			}
			return $all;
		}, []);

		if (!empty($campaign_ids)) {
			$raw_groups = $this->adwordService->GetAdGroupsFromMultiCampaignById($campaign_ids, $fields);
			$groups = collect([]);
			if (!empty($raw_groups)) {
				foreach ($raw_groups as $g) {
					$g->campaignName = $this->getOriginalCampaignName($g->campaignName);
					$groups->push($g);
				}
			}

			if (!empty($group_by)) {
				$groups = $groups->groupBy($group_by);
			}

			return $groups;
		} else {
			return collect([]);
		}
	}

	private function getAdGroups($campaign_name)
	{
		$ad_groups = $this->adwordService->GetAdGroups($campaign_name);
		$this->logger->info('Ad group found: ', ['total' => count($ad_groups), 'campaign' => $campaign_name]);
		return $ad_groups;
	}

	private function getDisapprovedAds($ad_group_id, $ad_group_name = '')
	{
		$ads = $this->adwordService->GetDisapprovedAds($ad_group_id);
		$disapproved_ads = [];
		if (is_array($ads) && count($ads)) {
			$disapproved_ads = $ads;
			$this->logger->info('Disapproved ad found: ', ['total' => count($disapproved_ads), 'ad_group' => ['id' => $ad_group_id, 'name' => $ad_group_name]]);
		} else {
			$this->logger->info('No disapproved ad found ', ['id' => $ad_group_id, 'name' => $ad_group_name]);
		}
		return $disapproved_ads;
	}

	public function removeDisapprovedAds()
	{
		$campaigns = $this->getCampaigns(true, false);
		if (empty($campaigns) || !is_array($campaigns)) return;

		foreach ($campaigns as $campaign) {
			$ad_groups = $this->getAdGroups($campaign->name);
			if (empty($ad_groups) || !is_array($ad_groups)) continue;
			foreach ($ad_groups as $ad_group) {
				$ads = $this->getDisapprovedAds($ad_group->id, $ad_group->name);
				if (empty($ads) || !is_array($ads)) continue;
				foreach ($ads as $ad) {
					$ads_to_be_removed = [];
					if (!isset($ad->policySummary)) continue;
					if (!isset($ad->policySummary->policyTopicEntries)) continue;
					$policyTopicEntries = $ad->policySummary->policyTopicEntries;
					if (empty($policyTopicEntries) || !is_array($policyTopicEntries)) continue;
					foreach ($policyTopicEntries as $policyTopicEntry) {
						if (isset($policyTopicEntry->policyTopicName) && $policyTopicEntry->policyTopicName === "Destination not working") {
							$ads_to_be_removed[] = $ad->ad->id;
							$this->logger->info("Disapproved reason: {$policyTopicEntry->policyTopicName}.", ['id' => $ad->ad->id, 'group' => $ad_group->name]);
						}
					}
					if (!empty($ads_to_be_removed)) {
						if ($this->adwordService->RemoveAd($ad->adGroupId, $ads_to_be_removed) != false) {
						}
						if ($this->dry == false) {
							$this->logger->info("Removed ads.", $ads_to_be_removed);
						}
					}
				}
			}
		}
		$this->logger->info("Removing disapproved ads complete.");
	}
}
