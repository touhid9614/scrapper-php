<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $user;
$all_dealerships = DbConnect::get_instance()->get_all_dealers(1);
$cron_name       = $user['cron_name'];

//$dealership = filter_input(INPUT_GET, 'dealership');
$flag    = 0;
$all_car = [];

if (!isset($cron_name)) {
    $flag = 1;
} else {
    $query  = 'SELECT * FROM ' . $cron_name . '_scrapped_data';
    $result = DbConnect::get_instance()->query($query);

    while ($row = mysqli_fetch_assoc($result)) {
        $car                 = [];
        $car['stock_number'] = $row['stock_number'];
        $car['vin']          = $row['vin'];
        $car['stock_type']   = $row['stock_type'];
        $car['title']        = $row['title'];
        $car['price']        = $row['price'];
        $car['url']          = $row['url'];
        $car['db_insert']    = date('Y/m/d H:i:s', $row['arrival_date']);
        $car['google_ads']   = $row['handled_at'] > 0 ? date('Y/m/d H:i:s', $row['handled_at']) : 'No add';
        $car['bing_ads']     = $row['bing_handled_at'] > 0 ? date('Y/m/d H:i:s', $row['bing_handled_at']) : 'No add';
        $car['deleted']      = $row['deleted'] ? 'YES' : 'NO';
        $car['sold_date']    = $row['deleted'] ? ($row['updated_at'] > 0 ? date('Y/m/d H:i:s', $row['updated_at']) : 'No Update') : '';

        $all_car[$row['stock_number']] = $car;
    }
}
?>

<?php include 'bolts/header.php'?>

<div class="inner-wrapper">
    <?php
$select = 'sold-and-active-car';
include 'bolts/sidebar.php'
?>

    <section role="main" class="content-body">

        <header class="page-header">

        </header>
        <div class="row">
            <div class="col-lg-12">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                    </div>
                    <h2 class="panel-title"> Configuration Panel </h2>
                </header>

                <div class="panel-body">
                    <form method="GET" class="
                        form-inline">
                        <label class="  mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
                        &nbsp; &nbsp;
                        <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership" data-plugin-selectTwo>
                            <?php
if ($user['type'] == 'a') {
    foreach ($all_dealerships as $dealership) {
        $selected = ($cron_name == $dealership['dealership']) ? ' selected' : '';
        ?>
                                    <option value="<?=$dealership['dealership']?>"<?=$selected?>><?=$dealership['dealership']?></option>
                                    <?php

    }
} else {
    ?>
                                <option value="<?=$user['cron_name']?>"<?=' selected'?>><?=$user['cron_name']?> </option>
                                <?php
}?>
                        </select>
                        &nbsp; &nbsp;
                        <button class="btn btn-primary ml-md"> Submit </button>
                    </form>
                </div>
                <br>
                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <?php $filename = $cron_name . "_sold_vs_active.csv"?>
                            <button class="btn btn-danger" onclick="exportTableToCSV('<?=$filename?>')"> Export</button>
                        </div>
                        <h2 class="panel-title"> Report of Sold and Active car for  <?=$cron_name?> in our Database</h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
if ($flag) {
    echo '<h3>Give dealership Name</h3>';
    exit();
} else {
    ?>
                                <table class="table table-bordered table-striped mb-none table-advanced" >
                                    <thead>
                                    <tr>
                                        <th> Stock Number </th>
                                        <th> VIN </th>
                                        <th> Car Type </th>
                                        <th> Title </th>
                                        <th> Price </th>
                                        <th> URL </th>
                                        <th> DB Insert </th>
                                        <th> Google Add Created Date </th>
                                        <th> Bing Add Created Date </th>
                                        <th> Sold </th>
                                        <th> Sold Date </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($all_car as $key => $car): ?>
                                        <tr>
                                            <td> <?=$car['stock_number']?> </td>
                                            <td> <?=$car['vin']?> </td>
                                            <td> <?=$car['stock_type']?> </td>
                                            <td> <?=$car['title']?> </td>
                                            <td> <?=$car['price']?> </td>
                                            <td> <a href="<?=$car['url']?>" target=”_blank”  ><?=$car['url']?></a></td>
                                            <td> <?=$car['db_insert']?> </td>
                                            <td> <?=$car['google_ads']?> </td>
                                            <td> <?=$car['bing_ads']?> </td>
                                            <td> <?=$car['deleted']?> </td>
                                            <td> <?=$car['sold_date']?> </td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>

                                <table  style="display: none" id="exportTable">
                                    <tr>
                                        <th> Stock Number </th>
                                        <th> VIN </th>
                                        <th> Car Type </th>
                                        <th> Title </th>
                                        <th> Price </th>
                                        <th> URL </th>
                                        <th> DB Insert </th>
                                        <th> Google Add Created Date </th>
                                        <th> Bing Add Created Date </th>
                                        <th> Sold </th>
                                        <th> Sold Date </th>
                                    </tr>
                                    <?php foreach ($all_car as $key => $car): ?>
                                        <tr>
                                            <td> <?=$car['stock_number']?> </td>
                                            <td> <?=$car['vin']?> </td>
                                            <td> <?=$car['stock_type']?> </td>
                                            <td> <?=$car['title']?> </td>
                                            <td> <?=$car['price']?> </td>
                                            <td> <?=$car['url']?> </td>
                                            <td> <?=$car['db_insert']?> </td>
                                            <td> <?=$car['google_ads']?> </td>
                                            <td> <?=$car['bing_ads']?> </td>
                                            <td> <?=$car['deleted']?> </td>
                                            <td> <?=$car['sold_date']?> </td>
                                        </tr>
                                    <?php endforeach;?>
                                </table>
                                <?php }?>
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

?>
<script>
    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.getElementById("exportTable").querySelectorAll("table tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                row.push(cols[j].innerText.replace(',',''));

            csv.push(row.join(","));
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
    }

    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob([csv], {type: "text/csv"});

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    }
</script>

