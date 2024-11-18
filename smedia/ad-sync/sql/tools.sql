-- keywords count in different group
SELECT count(k.id) total_keywords, k.group_id, g.* FROM tbl_adwords_keyword_mercedesbenzofstpaul as k JOIN tbl_adwords_ad_group as g on k.group_id = g.adword_id where k.`type` = 'positive'  GROUP BY k.group_id

-- rsa ad count in different campaigns
SELECT campaign, count(hash), dealership as ad_count FROM tbl_adwords_ad taa where dealership ='brownschev' and ad_type ='rsa' group by campaign


-- Update keywords
UPDATE ad_details SET value='[year(1)] [make(2)] [model] for sale' where dealership ='crownhondaca' and value ='[year] [make] [model] for sale'

-- Check for wrong ad type


-- active group keyword stat
SELECT ag.campaign  ,ag.name as group_name,`type` as keyword_type, matchType as match_type, COUNT(text) as total
	FROM spidri_ads_db.tbl_bing_keyword_bannisterford as k
	RIGHT JOIN tbl_bing_ad_group AS ag ON k.group_id = ag.bing_id
	WHERE ag.active = 1
	GROUP BY ag.name, `type`, k.matchType
	HAVING total > 0
	ORDER BY campaign, name, k.`type` , k.matchType ;



-- tag changer
ALTER TABLE ad_details MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;
ALTER TABLE ad_keywords MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;
ALTER TABLE tbl_ad_campaigns MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;
ALTER TABLE tbl_ad_special_campaigns MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;
ALTER TABLE tbl_adwords_ad MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;
ALTER TABLE tbl_adwords_ad_deleted MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;
ALTER TABLE tbl_adwords_ad_group MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;
ALTER TABLE tbl_bing_ad MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;
ALTER TABLE tbl_bing_ad_deleted MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;
ALTER TABLE tbl_bing_ad_group MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;
ALTER TABLE tbl_bing_ad_campaign_keywords MODIFY COLUMN tag enum('','HighFunnelBrandResearch','HighFunnelBodystyleResearch','HighFunnelModelResearch','MidFunnelModelAffordability','MidFunnelModelDeals','LowFunnelBrandWhereToBuy','LowFunnelModelWhereToBuy', 'Research', 'ResearchFinance', 'ResearchLease', 'ResearchOffer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL;




-- find duplicate ad details
SELECT
	id,
	REPLACE(GROUP_CONCAT(DISTINCT id SEPARATOR ' '), id, '') AS ids,
    value,
    dealership,
    campaign,
    tag,
    ad_type ,
    entryType ,
    make,
    model ,
    `year` ,
    trim ,
    COUNT(value) as count
FROM
    ad_details
-- Where value IN ('See Photos & Get Payments', 'Book a Test Drive')
-- WHERE
-- dealership='audilacrosse'
-- and tag='HighFunnelBrandResearch'
-- and ad_type = 'rsa'
-- and entryType = 'h'
GROUP BY
dealership,
campaign,
tag,
ad_type,
entryType,
make,
model,
`year`,
trim,
value
HAVING count > 1
ORDER BY count DESC, dealership, tag, campaign, id asc ;
