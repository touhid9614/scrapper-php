<?php

global $user;

error_reporting(E_ERROR | E_PARSE);

require_once 'sidebar-data.php';
?>

<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">
	<div class="sidebar-header">
		<div class="sidebar-title"> Navigation </div>
		<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">
					<?php
					if ($user['type'] == 'a' || $user['type'] == 'g') {
					?>
						<li class="nav-parent">
							<a>
								<span>
									<select id='dynamic_select' data-plugin-selectTwo class="form-control populate">
										<option value="-----">-- All --</option>
										<?php
										foreach ($dealership_company_mapped as $key => $value) {
										?>
											<option value="<?= $key ?>" <?= $user['cron_name'] == $key ? 'selected' : '' ?>><?= $dealership_company_mapped[$key] ?></option>
										<?php
										}
										?>
									</select>
								</span>
							</a>
						</li>
					<?php
					}
					?>
					<li <?= $select == 'Dashboard' ? ' class="nav-active"' : '' ?>>
						<a href="index.php?dealership=<?= $user['cron_name'] ?>">
							<i class="fas fa-tachometer-alt" aria-hidden="true"></i>
							<span> Dashboard </span>
						</a>
					</li>

					<?php
					if ($user['type'] == 'a') {
					?>
						<li class="nav-parent<?= in_array($select, ['check-dealer', 'crm-addnew', 'crm-overview', 'crm-details', 'crm-inactive', 'crm-conflict', 'crm-lead-export', 'crm-trial-conflict', 'custom-dealer', 'black-list', 'vinnauto']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fa fa-briefcase" aria-hidden="true"></i>
								<span> Client Management </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'check-dealer' ? ' class="nav-active"' : '' ?>>
									<a href="check-dealer.php">
										<i class="fas fa-clipboard-check" aria-hidden="true"></i>
										<span> Check Dealer </span>
									</a>
								</li>

								<li <?= $select == 'crm-addnew' ? ' class="nav-active"' : '' ?>>
									<a href="addnew.php">
										<i class="fas fa-user-plus" aria-hidden="true"></i>
										<span> Register New Dealer </span>
									</a>
								</li>

								<li <?= $select == 'custom-dealer' ? ' class="nav-active"' : '' ?>>
									<a href="custom-dealer.php">
										<i class="far fa-address-book" aria-hidden="true"></i>
										<span> Custom Dealer </span>
									</a>
								</li>

								<li <?= $select == 'black-list' ? ' class="nav-active"' : '' ?>>
									<a href="black-list.php">
										<i class="fas fa-ban" aria-hidden="true"></i>
										<span> Black List </span>
									</a>
								</li>

								<li <?= $select == 'crm-overview' ? ' class="nav-active"' : '' ?>>
									<a href="overview.php">
										<i class="fas fa-dice-d20" aria-hidden="true"></i>
										<span> Overview </span>
									</a>
								</li>

								<li <?= $select == 'crm-details' ? ' class="nav-active"' : '' ?>>
									<a href="details.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-info-circle" aria-hidden="true"></i>
										<span> Details </span>
									</a>
								</li>

								<li <?= $select == 'vinnauto' ? ' class="nav-active"' : '' ?>>
									<a href="vinnauto.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fab fa-vuejs" aria-hidden="true"></i>
										<span> Vinn Auto </span>
									</a>
								</li>

								<li <?= $select == 'crm-inactive' ? ' class="nav-active"' : '' ?>>
									<a href="crm-inactive.php">
										<i class="fas fa-toggle-off" aria-hidden="true"></i>
										<span> Inactive </span>
									</a>
								</li>

								<li <?= $select == 'crm-conflict' ? ' class="nav-active"' : '' ?>>
									<a href="conflict.php">
										<i class="far fa-times-circle" aria-hidden="true"></i>
										<span> Conflict </span>
									</a>
								</li>

								<li <?= $select == 'crm-trial-conflict' ? ' class="nav-active"' : '' ?>>
									<a href="trial-conflict.php">
										<i class="fas fa-stopwatch" aria-hidden="true"></i>
										<span> Trial Conflict </span>
									</a>
								</li>
							</ul>
						</li>

						<li class="nav-parent<?= in_array($select, ['epm-monthly', 'engaged-user', 'sold_vs_engaged', 'engaged-cars-graph']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fas fa-mouse-pointer" aria-hidden="true"></i>
								<span> Engagement </span>
							</a>
							<ul class="nav nav-children">
								<li <?= $select == 'epm-monthly' ? ' class="nav-active"' : '' ?>>
									<a href="epm-date.php">
										<i class="far fa-calendar-alt" aria-hidden="true"></i>
										<span> EPM monthly report </span>
									</a>
								</li>

								<li <?= $select == 'engaged-user' ? ' class="nav-active"' : '' ?>>
									<a href="engaged-user.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-users" aria-hidden="true"></i>
										<span> Engaged User </span>
									</a>
								</li>

								<li <?= $select == 'sold_vs_engaged' ? ' class="nav-active"' : '' ?>>
									<a href="sold-vs-engaged.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-bullseye" aria-hidden="true"></i>
										<span> Engaged User Correlation </span>
									</a>
								</li>

								<li <?= $select == 'engaged-cars-graph' ? ' class="nav-active"' : '' ?>>
									<a href="engaged-cars-graph.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-car" aria-hidden="true"></i>
										<span> Engaged Cars Graph </span>
									</a>
								</li>
							</ul>
						</li>
					<?php
					}
					?>

					<?php
					if ($user['type'] == 'a') {
						if ($user['super_admin'] == true) {
					?>
						<li class="nav-parent<?= in_array($select, ['crm-users', 'dealers', 'dealer_groups']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fas fa-users-cog" aria-hidden="true"></i>
								<span> User Management </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'crm-users' ? ' class="nav-active"' : '' ?>>
									<a href="users.php">
										<i class="fas fa-users" aria-hidden="true"></i>
										<span> Users </span>
									</a>
								</li>
							</ul>
						</li>

						<?php
						}
						?>

						<li class="nav-parent<?= in_array($select, ['keyword', 'rsa-ad-setting', 'esa-ad-setting', 'url']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fab fa-adversal"></i>
								<span> Ad Campaign Setting </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'keyword' ? ' class="nav-active"' : '' ?>>
									<a href="keyword.php">
										<i class="fab fa-korvue" aria-hidden="true"></i>
										<span>Keywords</span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'adwords-cpc' ? ' class="nav-active"' : '' ?>>
									<a href="adwords-cpc-setting.php">
										<i class="fab fa-korvue" aria-hidden="true"></i>
										<span>CPC</span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'esa-ad-setting' ? ' class="nav-active"' : '' ?>>
									<a href="adwords-search-setting.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fab fa-centos"></i>
										<span> Search Ad Setting </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'rsa-ad-setting' ? ' class="nav-active"' : '' ?>>
									<a href="adwords-responsive-search-setting.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fab fa-centos"></i>
										<span> Responsive Ad Setting </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'custom-campaign' ? ' class="nav-active"' : '' ?>>
									<a href="adwords-custom-campaign.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fab fa-centos"></i>
										<span> Custom Campaign </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'url' ? ' class="nav-active"' : '' ?>>
									<a href="adwords-url.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-globe"></i>
										<span>SRP Urls</span>
									</a>
								</li>
							</ul>
						</li>

						<li class="nav-parent<?= in_array($select, ['dealer-ab-testing', 'wheelstv-ab-test-report']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fas fa-vial"></i>
								<span> A\B Testing </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'dealer-ab-testing' ? ' class="nav-active"' : '' ?>>
									<a href="dealer-ab-testing.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-vote-yea"></i>
										<span> Dealer A\B Settings </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'wheelstv-ab-test-report' ? ' class="nav-active"' : '' ?>>
									<a href="wheelstv-ab-test-report.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-vote-yea"></i>
										<span> WheelsTv A\B Test Report </span>
									</a>
								</li>
							</ul>
						</li>
					<?php
					}
					?>

					<?php
					if ($user['type'] == 'a') {
					?>
						<li class="nav-parent<?= in_array($select, ['feeds', 'google_ads', 'bing_ads', 'twitter_ads', 'youtube_ads', 'facebook_ads', 'snapchat_ads', 'instagram_ads', 'ad-checker']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fas fa-ad" aria-hidden="true"></i>
								<span> Advertisement </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'google_ads' ? ' class="nav-active"' : '' ?>>
									<a href="google_ads.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fab fa-google" aria-hidden="true"></i>
										<span> Google Ads </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'facebook_ads' ? ' class="nav-active"' : '' ?>>
									<a href="facebook_ads.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fab fa-facebook-f" aria-hidden="true"></i>
										<span> Facebook Ads </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'bing_ads' ? ' class="nav-active"' : '' ?>>
									<a href="bing_ads.php?dealership=<?= $user['cron_name'] ?>">
										<?php
										if ($select == 'bing_ads') {
										?>
											<img class="image-icon" src="assets/images/bing-blue.svg">
										<?php
										} else {
										?>
											<img class="image-icon" src="assets/images/bing-grey.svg">
										<?php
										}
										?>
										<span> Bing Ads </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'youtube_ads' ? ' class="nav-active"' : '' ?>>
									<a href="youtube_ads.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fab fa-youtube" aria-hidden="true"></i>
										<span> Youtube Ads </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'twitter_ads' ? ' class="nav-active"' : '' ?>>
									<a href="twitter_ads.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fab fa-twitter" aria-hidden="true"></i>
										<span> Twitter Ads </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'snapchat_ads' ? ' class="nav-active"' : '' ?>>
									<a href="snapchat_ads.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fab fa-snapchat" aria-hidden="true"></i>
										<span> Snapchat Ads </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'instagram_ads' ? ' class="nav-active"' : '' ?>>
									<a href="instagram_ads.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fab fa-instagram" aria-hidden="true"></i>
										<span> Instagram Ads </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'ad-checker' ? ' class="nav-active"' : '' ?>>
									<a href="ad-checker.php?dealership=<?= $user['cron_name'] ?>">
										<i class="far fa-check-circle" aria-hidden="true"></i>
										<span> Ad Checker </span>
									</a>
								</li>
							</ul>
						</li>

						<li class="nav-parent<?= in_array($select, ['ai-button-alert', 'analytics-double-reporting', 'analytics-zero-reporting']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fas fa-file-powerpoint" aria-hidden="true"></i>
								<span> Alert Report </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'analytics-double-reporting' ? ' class="nav-active"' : '' ?>>
									<a href="analytics-double-reporting.php">
										<i class="fas fa-chart-line" aria-hidden="true"></i>
										<span> Analytics Double Report </span>
									</a>
								</li>

								<li <?= $select == 'analytics-zero-reporting' ? ' class="nav-active"' : '' ?>>
									<a href="analytics-zero-reporting.php">
										<i class="fas fa-chart-line" aria-hidden="true"></i>
										<span> Analytics Zero Report </span>
									</a>
								</li>

								<li <?= $select == 'debug-report' ? ' class="nav-active"' : '' ?>>
									<a href="debug-report.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-spider" aria-hidden="true"></i>
										<span> Debug Report </span>
									</a>
								</li>
							</ul>
						</li>


						<li class="nav-parent<?= in_array($select, ['scrapper-last-update', 'soldcar-vs-actual', 'sold-and-active-car', 'dealer-status-service', 'report-smart-offer', 'feed-vs-website', 'csv-dealers', 'proxy-info', 'ads-spending', 'directmail-reporter', 'web-providers', 'dealer-groups']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fas fa-bars" aria-hidden="true"></i>
								<span> Reports </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'scrapper-last-update' ? ' class="nav-active"' : '' ?>>
									<a href="report-scrapper-last-update.php">
										<i class="fas fa-chart-bar" aria-hidden="true"></i>
										<span> Scrapper Last Update </span>
									</a>
								</li>

								<li <?= $select == 'soldcar-vs-actual' ? ' class="nav-active"' : '' ?>>
									<a href="report-soldcar-vs-actual.php">
										<i class="fas fa-chart-line" aria-hidden="true"></i>
										<span> Sold Car Vs Actual </span>
									</a>
								</li>

								<li <?= $select == 'sold-and-active-car' ? ' class="nav-active"' : '' ?>>
									<a href="report-sold-active-car.php">
										<i class="fas fa-tasks" aria-hidden="true"></i>
										<span> Sold And Active Car List </span>
									</a>
								</li>

								<li <?= $select == 'dealer-status-service' ? ' class="nav-active"' : '' ?>>
									<a href="report-all-service.php">
										<i class="fas fa-clipboard-list" aria-hidden="true"></i>
										<span> Report of all active services </span>
									</a>
								</li>

								<li <?= $select == 'report-smart-offer' ? ' class="nav-active"' : '' ?>>
									<a href="report-smart-offer.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-tags" aria-hidden="true"></i>
										<span> Report of Smart Offer </span>
									</a>
								</li>

								<li <?= $select == 'feed-vs-website' ? ' class="nav-active"' : '' ?>>
									<a href="feed-vs-website.php">
										<i class="fas fa-not-equal" aria-hidden="true"></i>
										<span> Feed & Website Comparison </span>
									</a>
								</li>

								<li <?= $select == 'csv-dealers' ? ' class="nav-active"' : '' ?>>
									<a href="csv-dealers.php">
										<i class="fas fa-file-csv" aria-hidden="true"></i>
										<span> CSV Dealerships </span>
									</a>
								</li>

								<li <?= $select == 'proxy-info' ? ' class="nav-active"' : '' ?>>
									<a href="proxy-info.php">
										<i class="fas fa-info-circle" aria-hidden="true"></i>
										<span> Proxy Information </span>
									</a>
								</li>

								<li <?= $select == 'ads-spending' ? ' class="nav-active"' : '' ?>>
									<a href="adwords-spending.php">
										<i class="fab fa-adversal" aria-hidden="true"></i>
										<span> Adwords Spending </span>
									</a>
								</li>

								<li <?= $select == 'directmail-reporter' ? ' class="nav-active"' : '' ?>>
									<a href="directmail-reporter.php">
										<i class="fas fa-mail-bulk" aria-hidden="true"></i>
										<span> Directmail Reporter </span>
									</a>
								</li>

								<li <?= $select == 'web-providers' ? ' class="nav-active"' : '' ?>>
									<a href="web-providers.php">
										<i class="fab fa-servicestack" aria-hidden="true"></i>
										<span> Website Providers </span>
									</a>
								</li>

								<li <?= $select == 'dealer-groups' ? ' class="nav-active"' : '' ?>>
									<a href="dealer-groups.php">
										<i class="far fa-object-group" aria-hidden="true"></i>
										<span> Dealership Groups </span>
									</a>
								</li>
							</ul>
						</li>

						<li class="nav-parent<?= in_array($select, ['sale-report', 'readd-report', 'cartrack-apis', 'sold-cars', 'daily-sold-cars', 'readd-cars']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fas fa-location-arrow" aria-hidden="true"></i>
								<span> Car Tracker </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'sale-report' ? ' class="nav-active"' : '' ?>>
								<a href="car-sale-report.php">
										<i class="fas fa-file-export" aria-hidden="true"></i>
										<span> Car Removal Overview </span>
									</a>
								</li>

								<li <?= $select == 'sold-cars' ? ' class="nav-active"' : '' ?>>
									<a href="sold-cars-list.php">
										<i class="far fa-paper-plane" aria-hidden="true"></i>
										<span> Removed cars </span>
									</a>
								</li>

								<li <?= $select == 'daily-sold-cars' ? ' class="nav-active"' : '' ?>>
									<a href="sold-car-daily-view.php">
										<i class="fas fa-calendar-day" aria-hidden="true"></i>
										<span> Daily Removed cars </span>
									</a>
								</li>

								<li <?= $select == 'readd-report' ? ' class="nav-active"' : '' ?>>
									<a href="car-readd-report.php">
										<i class="fas fa-undo-alt" aria-hidden="true"></i>
										<span> Car Readd Overview </span>
									</a>
								</li>

								<li <?= $select == 'readd-cars' ? ' class="nav-active"' : '' ?>>
									<a href="readd-cars-list.php?dealership=<?= $cron_name ?>">
										<i class="fas fa-fast-backward" aria-hidden="true"></i>
										<span> Readded Cars </span>
									</a>
								</li>
							</ul>
						</li>

						<li class="nav-parent<?= in_array($select, ['log-file', 'ng_clear_logs', 'ng_cost_logs', 'bing-log-file', 'report-log', 'view-log']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fas fa-scroll" aria-hidden="true"></i>
								<span> Logs </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'log-file' ? ' class="nav-active"' : '' ?>>
									<a href="log-file.php">
										<i class="fas fa-scroll" aria-hidden="true"></i>
										<span> Ng Logs </span>
									</a>
								</li>

								<li <?= $select == 'ng_clear_logs' ? ' class="nav-active"' : '' ?>>
									<a href="ng_clear_logs.php">
										<i class="fas fa-scroll" aria-hidden="true"></i>
										<span> Ng Clear Logs </span>
									</a>
								</li>

								<li <?= $select == 'ng_cost_logs' ? ' class="nav-active"' : '' ?>>
									<a href="ng_cost_logs.php">
										<i class="fas fa-scroll" aria-hidden="true"></i>
										<span> Ng Cost Logs </span>
									</a>
								</li>

								<li <?= $select == 'bing-log-file' ? ' class="nav-active"' : '' ?>>
									<a href="bing-log-file.php">
										<i class="fas fa-scroll" aria-hidden="true"></i>
										<span> Bing Logs </span>
									</a>
								</li>

								<li <?= $select == 'report-log' ? ' class="nav-active"' : '' ?>>
									<a href="report-log.php">
										<i class="fas fa-scroll" aria-hidden="true"></i>
										<span> Report Logs </span>
									</a>
								</li>

								<li <?= $select == 'view-log' ? ' class="nav-active"' : '' ?>>
									<a href="view_log.php">
										<i class="fas fa-briefcase" aria-hidden="true"></i>
										<span> User Logs </span>
									</a>
								</li>
							</ul>
						</li>


						<li class="nav-parent<?= in_array($select, ['vs_scraper_dashboard', 'vs_configuration']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fab fa-vimeo-v" aria-hidden="true"></i>
								<span> Visual Scraper </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'vs_scraper_dashboard' ? ' class="nav-active"' : '' ?>>
									<a href="vs_dashboard.php">
										<i class="fas fa-gamepad" aria-hidden="true"></i>
										<span> Control Panel </span>
									</a>
								</li>

								<li <?= $select == 'vs_configuration' ? ' class="nav-active"' : '' ?>>
									<a href="vs_configuration.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-cogs" aria-hidden="true"></i>
										<span> Configuration Panel </span>
									</a>
								</li>
							</ul>
						</li>
					<?php
					}
					?>

					<?php
					if ($user['type'] == 'a') {
					?>
						<li class="nav-parent<?= in_array($select, ['button-issues', 'button-overview', 'button-details', 'button-analysis', 'button-overall', 'overall-details', 'ai-lead-export', 'ai-button-statistics']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="far fa-hand-pointer" aria-hidden="true"></i>
								<span> AI Optimizer </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'button-overview' ? ' class="nav-active"' : '' ?>>
									<a href="button-overview.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-dice-d20" aria-hidden="true"></i>
										<span> Overview </span>
									</a>
								</li>

								<li <?= $select == 'button-details' ? ' class="nav-active"' : '' ?>>
									<a href="button-details.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-asterisk" aria-hidden="true"></i>
										<span> Details </span>
									</a>
								</li>

								<li <?= $select == 'button-analysis' ? ' class="nav-active"' : '' ?>>
									<a href="button-analysis.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-chart-pie" aria-hidden="true"></i>
										<span> Analysis </span>
									</a>
								</li>

								<li <?= $select == 'overall-details' ? ' class="nav-active"' : '' ?>>
									<a href="overall-details.php?dealership=<?= $user['cron_name'] ?>">
										<i class="far fa-eye" aria-hidden="true"></i>
										<span> Overall </span>
									</a>
								</li>

								<li <?= $select == 'button-issues' ? ' class="nav-active"' : '' ?>>
									<a href="button-issues.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
										<span> Issues </span>
									</a>
								</li>

								<li <?= $select == 'ai-lead-export' ? ' class="nav-active"' : '' ?>>
									<a href="ai-lead-stats.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-directions" aria-hidden="true"></i>
										<span> Lead Statistics </span>
									</a>
								</li>

								<li <?= $select == 'ai-button-statistics' ? ' class="nav-active"' : '' ?>>
									<a href="vehicle-statistics.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-car" aria-hidden="true"></i>
										<span> Vehicle Statistics </span>
									</a>
								</li>
							</ul>

						</li>
					<?php
					} else if (isset($user['cron_config']['buttons'])) {
					?>
						<li <?= $select == 'button-details' ? ' class="nav-active"' : '' ?>>
							<a href="button-details.php?dealership=<?= $user['cron_name'] ?>">
								<i class="fas fa-asterisk" aria-hidden="true"></i>
								<span> AI Optimizer Statistics </span>
							</a>
						</li>
					<?php
					}
					?>

					<?php
					if ($user['type'] == 'u') {
					?>
						<li class="nav-parent<?= in_array($select, ['crm-details']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fa fa-bug" aria-hidden="true"></i>
								<span> Services </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'crm-details' ? ' class="nav-active"' : '' ?>>
									<a href="details.php?dealership=<?= $user['cron_name'] ?>">
										<i class="fas fa-asterisk" aria-hidden="true"></i>
										<span> Details </span>
									</a>
								</li>
							</ul>
						</li>
					<?php
					}
					?>

					<!-- Debugger -->
					<?php
					if ($user['type'] == 'a') {
					?>
						<li class="nav-parent<?= in_array($select, ['feed-debugger', 'button-debugger']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fa fa-bug" aria-hidden="true"></i>
								<span> Debuggers </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'feed-debugger' ? ' class="nav-active"' : '' ?>>
									<a href="feed-debugger.php">
										<i class="fas fa-spider" aria-hidden="true"></i>
										<span> Feed Debugger </span>
									</a>
								</li>

								<li <?= $select == 'button-debugger' ? ' class="nav-active"' : '' ?>>
									<a href="button-debugger.php">
										<i class="fas fa-spider" aria-hidden="true"></i>
										<span> Button Debugger </span>
									</a>
								</li>
							</ul>
						</li>
					<?php
					}

					// Only visible to developers mentioned in the following file
					// smedia-inventory/dashboard/sepecial/super_admins.php
					if ($user['type'] == 'a' && isset($user['developer']) && $user['developer'] == true) {
					?>
						<li class="nav-parent<?= in_array($select, ['dealer-config', 'dealer-ops', 'emi-calculator']) ? ' nav-expanded nav-active' : '' ?>">
							<a>
								<i class="fa fa-code" aria-hidden="true"></i>
								<span> Dev Panel </span>
							</a>

							<ul class="nav nav-children">
								<li <?= $select == 'dealer-config' ? ' class="nav-active"' : '' ?>>
									<a href="dealer_config.php">
										<i class="fas fa-tools" aria-hidden="true"></i>
										<span> Dealer Config </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'dealer-ops' ? ' class="nav-active"' : '' ?>>
									<a href="dealer-operations.php">
										<i class="fas fa-toolbox" aria-hidden="true"></i>
										<span> Dealer Operations </span>
									</a>
								</li>
							</ul>

							<ul class="nav nav-children">
								<li <?= $select == 'emi-calculator' ? ' class="nav-active"' : '' ?>>
									<a href="emi-calculator.php">
										<i class="fas fa-landmark" aria-hidden="true"></i>
										<span> EMI Calculator </span>
									</a>
								</li>
							</ul>
						</li>
					<?php
					}
					?>

					<li <?= $select == 'tracking-config' ? ' class="nav-active"' : '' ?>>
						<a href="tracking-config.php?dealership=<?= $user['cron_name'] ?>">
							<i class="fas fa-tags" aria-hidden="true"></i>
							<span> Tracking Config </span>
						</a>
					</li>

					<li <?= $select == 'facebook-campaign' ? ' class="nav-active"' : '' ?>>
						<a href="facebook-campaign.php?dealership=<?= $user['cron_name'] ?>">
							<i class="fab fa-facebook-f" aria-hidden="true"></i>
							<span> Facebook Campaign</span>
						</a>
					</li>


					<?php
					if (isset($user['cron_config']['lead'])) {
					?>
						<li <?= $select == 'Offer Stats' ? ' class="nav-active"' : '' ?>>
							<a href="smart-offer-stats.php?dealership=<?= $user['cron_name'] ?>">
								<i class="fas fa-chart-bar" aria-hidden="true"></i>
								<span> Smart Offer Statistics </span>
							</a>
						</li>
					<?php
					}
					?>

					<li <?= $select == 'Site Tag' ? ' class="nav-active"' : '' ?>>
						<a href="tag.php?dealership=<?= $user['cron_name'] ?>">
							<i class="fa fa-tag" aria-hidden="true"></i>
							<span> Site Tag </span>
						</a>
					</li>

					<!-- <li <?= $select == 'tag-control' ? ' class="nav-active"' : '' ?>>
						<a href="tag-control.php?dealership=<?= $user['cron_name'] ?>">
							<i class="fas fa-gamepad" aria-hidden="true"></i>
							<span>Tag Control</span>
						</a>
					</li> -->

					<?php
					if ($user['type'] == 'a') {
					?>
						<li <?= $select == 'Bounce Rate' ? ' class="nav-active"' : '' ?>>
							<a href="bounce-rate.php?dealership=<?= $user['cron_name'] ?>">
								<i class="fas fa-undo" aria-hidden="true"></i>
								<span> Bounce Rate </span>
							</a>
						</li>

						<li <?= $select == 'Promotion Checklist' ? ' class="nav-active"' : '' ?>>
							<a href="promot-preview.php">
								<i class="fas fa-ad" aria-hidden="true"></i>
								<span> Promotion Checklist </span>
							</a>
						</li>

						<li <?= $select == 'Banner Checklist' ? ' class="nav-active"' : '' ?>>
							<a href="banner-preview.php">
								<i class="fa fa-list" aria-hidden="true"></i>
								<span> Banner Checklist </span>
							</a>
						</li>

						<li <?= $select == 'control' ? ' class="nav-active"' : '' ?>>
							<a href="external.php?page=control">
								<i class="fa fa-cogs" aria-hidden="true"></i>
								<span> Control Panel </span>
							</a>
						</li>

						<li <?= $select == 'sold-ad-cleaner' ? ' class="nav-active"' : '' ?>>
							<a href="external.php?page=sold-ad-cleaner">
								<i class="fa fa-cogs" aria-hidden="true"></i>
								<span> Sold Ad Cleaner </span>
							</a>
						</li>

						<li <?= $select == 'clear' ? ' class="nav-active"' : '' ?>>
							<a href="clear_ads.php">
								<i class="fa fa-eraser" aria-hidden="true"></i>
								<span> Clear Ads </span>
							</a>
						</li>

						<li <?= $select == 'carlisteditor' ? ' class="nav-active"' : '' ?>>
							<a href="external.php?page=carlisteditor">
								<i class="fa fa-edit" aria-hidden="true"></i>
								<span> Carlist Editor </span>
							</a>
						</li>

						<li <?= $select == 'tagchecker' ? ' class="nav-active"' : '' ?>>
							<a href="external.php?page=tagchecker">
								<i class="fa fa-tags" aria-hidden="true"></i>
								<span> Tag Checker </span>
							</a>
						</li>

					<?php
					}
					?>
					<li <?= $select == 'my_account' ? ' class="nav-active"' : '' ?>>
						<a href="user_profile.php">
							<i class="far fa-user" aria-hidden="true"></i>
							<span> My Account </span>
						</a>
					</li>

					<li>
						<a href="signout.php">
							<i class="fa fa-power-off" aria-hidden="true"></i>
							<span> Sign Out </span>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</aside>
<!-- end: sidebar -->
