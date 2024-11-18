<?php

require_once 'utils.php';
require_once 'config.php';
require_once 'tag_db_connect.php';
$_GET['customer'] = isset($_GET['customer']) ? $_GET['customer'] : 'analytics.h-o';
require_once 'Google/Consts.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/SessionManager.php';
require_once 'Google/Analytics.php';

echo "<pre>";

$analytics = new Analytics(get_current_google_customer());

//$account = $analytics->GetAccounts();
//echo "Account <br>";
//print_r($account);
//echo "<br>==================<br><br>";

$accountSummaries = $analytics->GetAccountSummaries();
//echo "Account Summaries<br>";
//print_r($accountSummaries);
//echo "<br>==================<br><br>";

if (count($accountSummaries)) {
	if (count($accountSummaries->items)) {
		foreach ($accountSummaries->items as $account) {
			/*
			 * We need to match in which account this dealer property account create
			 * Currently we create it under "Test Account"
			 */
//			echo $account->name.' :: '.$account->id.'<br>';
			if ($account->name == "Test Account 2") {
				/*
				 * Check webProperties exist or not
				 * For testing :: web Properties Name = "Test 100"
				 */
				$accountId = trim($account->id);

				$webPropertyName = "Test 1211";
				$webPropertyUrl = "http://test1211.ca";

				$webPropertyData = false;
				$webPropertyExist = false;
				foreach ($account->webProperties as $webProperty) {

					if ($webProperty->name == $webPropertyName) {
						echo "Get Web Properties. $accountId :: $webPropertyName :: $webPropertyUrl <br>";
						$webPropertyExist = true;
						$webPropertyData = $webProperty;
						break;
					}
				}
				if (!$webPropertyExist) {
					echo "Creating new Web Properties. $accountId :: $webPropertyName :: $webPropertyUrl <br>";
					$webPropertyData = $analytics->CreateWebPropertie($accountId, $webPropertyName, $webPropertyUrl);
					//print_r($webPropertyData);
				}


				echo "<br>==================<br><br>";
				print_r($webPropertyData);


				/*
				 * Now Check View Profile
				 * If not create View profile.
				 */
				$webPropertyId = trim($webPropertyData->id);

				if (!empty($webPropertyId)) {
					$viewProfileName = "sMedia View";

					$viewProfileData = false;
					$viewProfileExist = false;
					foreach ($webPropertyData->profiles as $viewProfile) {
						if ($viewProfile->name == $viewProfileName) {
							echo "Get View Profile. $accountId :: $webPropertyId :: $viewProfileName :: $webPropertyUrl <br>";
							$viewProfileExist = true;
							$viewProfileData = $viewProfile;
							break;
						}
					}

					if (!$viewProfileExist) {
						echo "Creating new View Profile. $accountId :: $webPropertyId :: $viewProfileName :: $webPropertyUrl <br>";
						$viewProfileData = $analytics->CreateViewProfiles($accountId, $webPropertyId, $viewProfileName, $webPropertyUrl);
						//print_r($viewProfileData);
					}

					echo "<br>==================<br><br>";
					print_r($viewProfileData);

					/*
					 * Get the list of goal
					 * IF no goal found create new goal
					 */
					$viewId = trim($viewProfileData->id);
					if (!empty($viewId)) {
						$goalData = $analytics->GetAllGoal($accountId, $webPropertyId, $viewId);

						//echo "<br>==================<br><br>";
						//print_r($goalData);

						$allGoal = [
							"Engaged Prospect" => ["Category" => "Profitable Engagement"],
							"Engaged Prospect 1 Min" => ["Action" => "Time on page more than a minute"],
							"Engaged Prospect 1 Min 30 Sec" => ["Action" => "Time on page more than 1 minute 30 seconds"],
							"Picture View Count" => ["Category" => "Picture Viewed"],
							"AI Button Clicks" => ["Category" => "Button Clicked", "Action" => "AI Button"],
							"AI Form Leads" => ["Category" => "Form Fillup", "Action" => "AI Form"],
							"Goal smedia_lead" => ["Category" => "smedia_lead"],
							"Smart Offer Displayed" => ["Category" => "smart_offer"],
							"Smart Offer Lead" => ["Category" => "smart_offer"],
						];

						if (!count($goalData->items)) {
							$goalId = 1;
							foreach ($allGoal as $name => $goal) {
								$eventConditions = [];
								foreach ($goal as $type => $expression) {
									$eventDetails = [
										"type" => $type,
										"matchType" => "EXACT",
										"expression" => $expression
									];
									$eventConditions[] = $eventDetails;
								}
								$eventDetails = [
									"useEventValue" => true,
									"eventConditions" => $eventConditions
								];

								$createGoalData = $analytics->CreateGoal($accountId, $webPropertyId, $viewId, $goalId, $name, $eventDetails);
								$goalId++;
							}
						} else {
							$clientGoal = [];
							$lastGoalid = 1;
							foreach ($goalData->items as $goal) {
								$clientGoal[] = $goal->name;
								if ($lastGoalid < $goal->id) {
									$lastGoalid = $goal->id;
								}
							}

							echo "<br>==================<br><br>";
							print_r($clientGoal);

							foreach ($allGoal as $name => $goal) {
								if (!in_array($name, $clientGoal)) {
									$eventConditions = [];
									foreach ($goal as $type => $expression) {
										$eventDetails = [
											"type" => $type,
											"matchType" => "EXACT",
											"expression" => $expression
										];
										$eventConditions[] = $eventDetails;
									}
									$eventDetails = [
										"useEventValue" => true,
										"eventConditions" => $eventConditions
									];
									$lastGoalid++;
									echo "<br> Goal not found create new goal. $name :: $lastGoalid<br>";
									$createGoalData = $analytics->CreateGoal($accountId, $webPropertyId, $viewId, $lastGoalid, $name, $eventDetails);

								}
							}

						}

						echo "Get Goal.  $accountId :: $webPropertyId :: $viewId  <br>";

						$FinalGoalData = $analytics->GetAllGoal($accountId, $webPropertyId, $viewId);

						echo "<br>==================<br><br>";
						print_r($FinalGoalData);
					}

				}

			}
		}
	} else {
		echo " Sorry!! No Account item found.";
	}

} else {
	echo " Sorry!! No Account found.";
}

