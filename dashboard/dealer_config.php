<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $scrapper_configs;

$db_connect         = new DbConnect('');
$scrapper_type_query = "SELECT dealership, websites, scrapper_type, company_name FROM dealerships WHERE status = 'active' OR status = 'trial'";
$query_result       = $db_connect->query($scrapper_type_query);

$dealership = [];

while ($row = mysqli_fetch_assoc($query_result)) {
    $dealership[$row['dealership']]['scrapper_type'] = $row['scrapper_type'];
    $dealership[$row['dealership']]['websites']     = $row['websites'];
    $dealership[$row['dealership']]['company_name'] = $row['company_name'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['scrapper_type'];

    // Can we execute as just one query by storing in an array?
    foreach ($status as $dealer => $value) {
        if ($dealership[$dealer]['scrapper_type'] != $value[0]) {
            $db_connect->query("UPDATE dealerships SET scrapper_type = '$value[0]' WHERE dealership = '$dealer'");
        }
    }

    echo ("<script type='text/javascript'> location.href= location.href; </script>");
}

include 'bolts/header.php'
?>

<div class="inner-wrapper">

    <?php
    $select = 'dealer-config';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>

        <div class="row">
            <div class="col-lg-12">
                <form id="dealer_config" method="POST">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title"> Dealership Configuration </h2>
                        </header>
                    </section>

                    <div class="panel-body">
                        <div class="row form-group-row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-advanced mb-none">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2">Dealership</th>
                                            <th class="col-md-3">Company Name</th>
                                            <th class="col-md-2">Website URL</th>
                                            <th class="col-md-3">Scraper Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($dealership as $dealer => $data) {
                                    ?>
                                        <tr>
                                            <td><?=$dealer?></td>
                                            <td><?=$data['company_name']?></td>
                                            <td>
                                                <a href="<?=$data['websites']?>" target="_blank">
                                                    <i><?=URLPrint($data['websites'])?></i>
                                                </a>
                                            </td>
                                            <td>
                                                <select class="form-control" name="scrapper_type[<?=$dealer?>][]" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
                                                    <option value="RegEx" <?=$data['scrapper_type'] == 'RegEx' ? 'selected=""' : ''?>> Regular Expression
                                                    </option>
                                                    <option value="VS" <?=$data['scrapper_type'] == 'VS' ? 'selected=""' : ''?>> Visual Scraper
                                                    </option>
                                                    <option value="CSV" <?=$data['scrapper_type'] == 'CSV' ? 'selected' : ''?>> CSV File Data
                                                    </option>
                                                    <option value="NLP" <?=$data['scrapper_type'] == 'NLP' ? 'selected=""' : ''?>> Natural Language Processing
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="col-md-2">Dealership</th>
                                            <th class="col-md-3">Company Name</th>
                                            <th class="col-md-2">Website URL</th>
                                            <th class="col-md-3">Scraper Type</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" id="save_dealer_config" name="btn" value="save_dealer_config" class="btn btn-primary pull-right"> Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';