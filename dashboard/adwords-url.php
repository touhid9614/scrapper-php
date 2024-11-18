<?php

use sMedia\AdSync\Utils;

error_reporting(E_ERROR | E_PARSE);

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';
require_once '../includes/init-db.php';

session_start();

require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $user;
$all_dealerships = $db_connect->get_all_dealers(1);
$dealership = $user['cron_name'];

$used_special = Utils::getSpecialCampaigns('used', $dealership);
$new_special = Utils::getSpecialCampaigns('new', $dealership);

$campaignTypes =
	array_merge(
		[
			'smedia_used_make',
			'smedia_used_make_model',
			'smedia_used_make_model_year',
			'smedia_used_make_model_year_trim',
		],
		$used_special,
		[
			'smedia_new_make',
			'smedia_new_make_model',
			'smedia_new_make_model_year',
			'smedia_new_make_model_year_trim',
		],
		$new_special
	);


$db_connect = new DbConnect('');
$db_connect_write = $db_connect->get_connection_write();

$result = $db_connect->query("SELECT * FROM ad_url_pattern WHERE  dealership='$dealership' ");
$urlPattern = [];
while ($row = mysqli_fetch_array($result)) {
    $urlPattern[$row['campaign']] = $row['urlPattern'];
    $bing_enabled[$row['campaign']] = $row['bing'];
    $adwords_enabled[$row['campaign']] = $row['adwords'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["update_url"]) {
    if (!empty($dealership)) {
        foreach ($campaignTypes as $campaignType) {
            $urlPatt = $_POST[$campaignType];
            $bing = isset($_POST["{$campaignType}_bing"]) ? "1" : "0";
            $adwords = isset($_POST["{$campaignType}_adwords"]) ? "1" : "0";;

            if (!empty($urlPatt)) {
                if (isset($urlPattern[$campaignType])) {
                    $sql = "UPDATE ad_url_pattern SET	urlPattern='$urlPatt', bing=$bing, adwords=$adwords WHERE dealership='$dealership' AND campaign = '$campaignType'";
                } else {
                    $sql = "INSERT INTO ad_url_pattern (campaign, dealership, urlPattern, bing, adwords) VALUES ('$campaignType', '$dealership', '$urlPatt', $bing, $adwords)";
                }
            } else {
                $sql = "DELETE FROM ad_url_pattern WHERE dealership='$dealership' AND campaign = '$campaignType'";
            }

            if (isset($sql)) {
                $db_connect_write->query($sql);
            }
        }
    }
    echo ("<script type='text/javascript'> location.href = location.href; </script>");
}

$result = $db_connect->query("SELECT * FROM ad_url_pattern WHERE  dealership='$dealership' ");
$urlPattern = [];
while ($row = mysqli_fetch_array($result)) {
    $urlPattern[$row['campaign']] = $row['urlPattern'];
    $bing_enabled[$row['campaign']] = $row['bing'];
    $adwords_enabled[$row['campaign']] = $row['adwords'];
}

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

include 'bolts/header.php';
?>

<div class="inner-wrapper">

    <?php
    $select = 'url';
    include 'bolts/sidebar.php'
    ?>
    <section role="main" class="content-body">
        <header class="page-header"></header>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title"> Configuration Panel </h2>
                    </header>
                    <div class="panel-body">
                        <form method="GET" class="form-inline">
                            <label class="  mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
                            &nbsp; &nbsp;
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership" onchange="(function(e){e.target.closest('form').submit()})(event)" data-plugin-selectTwo>
                                <?php
                                if ($user['type'] == 'a') {
                                    foreach ($all_dealerships as $dealer) {
                                        $selected = ($dealership == $dealer['dealership']) ? ' selected' : '';
                                ?>
                                        <option value="<?= $dealer['dealership'] ?>" <?= $selected ?>><?= $dealer['dealership'] ?></option>
                                    <?php

                                    }
                                } else {
                                    ?>
                                    <option value="<?= $user['cron_name'] ?>" <?= ' selected' ?>><?= $user['cron_name'] ?> </option>
                                <?php
                                } ?>
                            </select>

                            <!--button class="btn btn-primary ml-md"> Submit</button-->
                        </form>
                    </div>

                </section>
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Google AdWords campaign pattern URL for :: <b><?= $dealership ?></b></h2>
                    </header>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?= $test ?>
                                <form method="post">
                                    <div class="col-md-12" style="margin-left: -15px">
                                        <div class="table-responsive">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-3">Campaign Name</th>
                                                        <th class="col-md-7">Url </th>
                                                        <th class="col-md-1">Enable Adwords </th>
                                                        <th class="col-md-1">Enable Bing </th>
                                                    </tr>
                                                </thead>
                                                <tr>
                                                    <?php
                                                    foreach ($campaignTypes as $campaign) {
                                                        $listOfCam = explode('_', $campaign);
                                                        echo '<tr><td>';
                                                        for ($i = 1; $i < count($listOfCam); $i++) {
                                                            echo ucfirst($listOfCam[$i]) . ' ';
                                                        }
                                                        echo '</td>';

                                                    ?>
                                                        <td>
                                                            <input name='<?= $campaign ?>' value='<?= isset($urlPattern[$campaign]) ? $urlPattern[$campaign] : ''  ?>' type='text' class='form-control' />
                                                        </td>
                                                        <td>
                                                            <input name='<?= $campaign ?>_adwords' value="1" type="checkbox" <?= isset($adwords_enabled[$campaign]) && $adwords_enabled[$campaign] == '1' ? 'checked="checked"' : ''  ?> type='text' class='form-control' />
                                                        </td>
                                                        <td>
                                                            <input name='<?= $campaign ?>_bing' value="1" type="checkbox" <?= isset($bing_enabled[$campaign]) && $bing_enabled[$campaign] == '1' ? 'checked="checked"' : ''  ?> type='text' class='form-control' />
                                                        </td>
                                                </tr>
                                            <?php
                                                    }
                                            ?>
                                            </tbody>
                                            </table>
                                            <input name="update_url" type="submit" value="Save" class=" btn btn-info">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
