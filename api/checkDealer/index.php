<?php

$file = fopen('alldealer.csv', 'r');

$count = 1;
$allDealer = [];
$allDealerGUID = [];

while (($line = fgetcsv($file)) !== FALSE) {

    if ($count > 1) {
        $dealer_info = array();
        $dealer_info['guid'] = $guid = $line[3];
        $dealer_info['name'] = $line[0];
        $dealer_info['domain'] = $line[1];
        $dealer_info['cron']  = $line[2];
        $dealer_info['mongoExist']  = false;
        $dealer_info['mongoId']  = '';
        $dealer_info['mongoStatus']  = '';
        $dealer_info['mongoGroupId']  = '';
        $dealer_info['mongoGroupName']  = '';
        $dealer_info['mongoGroupStatus']  = '';
        if ($guid) {
            array_push($allDealer, $dealer_info);
            $allDealerGUID[$guid] = $dealer_info;
        }
    }
    $count++;
}

$file = fopen('dashboardDealer.csv', 'r');

$count = 1;
$allDealerMongo = [];
$allDealerGUIDMongo = [];
$allDealerCronMongo = [];

while (($line = fgetcsv($file)) !== FALSE) {

    if ($count > 1) {
        $dealer_info = array();
        $dealer_info['guid'] = $guid = $line[5];
        $dealer_info['mongoId'] = $line[4];
        $dealer_info['mongoStatus'] = $line[9];
        $dealer_info['mongoGroupId'] = $line[1];
        $dealer_info['mongoGroupName']  = $line[2];
        $dealer_info['mongoGroupStatus'] = $line[3];
        $cron = $line[7];
        if ($guid) {
            array_push($allDealerMongo, $dealer_info);
            $allDealerGUIDMongo[$guid] = $dealer_info;
            $allDealerCronMongo[$cron] = $dealer_info;
        }
    }
    $count++;
}

$active = "<p class='ac'>Active</p>";
$deactive = "<p class='de'>Inactivte</p>";

if (count($allDealerGUID)) {
    foreach ($allDealerGUID as $guid => $dealer) {
        $cron = $dealer['cron'];
        if (array_key_exists($guid, $allDealerGUIDMongo)) {

            $allDealerGUID[$guid]['mongoExist']  = true;
            $allDealerGUID[$guid]['mongoId']  = $allDealerGUIDMongo[$guid]['mongoId'];
            $allDealerGUID[$guid]['mongoStatus']  = $allDealerGUIDMongo[$guid]['mongoStatus'] ? $active : $deactive;
            $allDealerGUID[$guid]['mongoGroupId']  = $allDealerGUIDMongo[$guid]['mongoGroupId'];
            $allDealerGUID[$guid]['mongoGroupName']  = $allDealerGUIDMongo[$guid]['mongoGroupName'];
            $allDealerGUID[$guid]['mongoGroupStatus']  = $allDealerGUIDMongo[$guid]['mongoGroupStatus'] ? $active : $deactive;
        } else if (array_key_exists($cron, $allDealerCronMongo)) {
            $allDealerGUID[$guid]['mongoExist']  = true;
            $allDealerGUID[$guid]['mongoId']  = $allDealerCronMongo[$cron]['mongoId'];
            $allDealerGUID[$guid]['mongoStatus']  = $allDealerCronMongo[$cron]['mongoStatus'] ? $active : $deactive;
            $allDealerGUID[$guid]['mongoGroupId']  = $allDealerCronMongo[$cron]['mongoGroupId'];
            $allDealerGUID[$guid]['mongoGroupName']  = $allDealerCronMongo[$cron]['mongoGroupName'];
            $allDealerGUID[$guid]['mongoGroupStatus']  = $allDealerCronMongo[$cron]['mongoGroupStatus'] ? $active : $deactive;
        }
    }
}
?>

<style>
    .ac {
        color: green;
    }

    .de {
        color: red;
    }
</style>

<title>Dealer List</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css" rel="stylesheet">

<body>

    <div class="card" style="margin: 10px 20px;">
        <h5 class="card-header bg-info">Final List</h5>
        <div class="card-body">
            <table id="myTable" class="table table-striped table-bordered cell-border display nowrap" style="width:100%">
                <thead class="text-center">
                    <tr>
                        <th>SL</th>
                        <th>GUId</th>
                        <th>Dealer Name</th>
                        <th>Domain</th>
                        <th>Cron</th>
                        <th>Mongo Exist</th>
                        <th>Dealer Id</th>
                        <th>Dealer Status</th>
                        <th>Group Name</th>
                        <th>Group Id</th>
                        <th>Group Status</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $co = 1;
                    $yes = "<p class='ac'>Yes</p>";
                    $no = "<p class='ac'>No</p>";

                    if (count($allDealerGUID)) {
                        foreach ($allDealerGUID as $guid => $dealer) {
                    ?>
                            <tr scope="row">
                                <td><?= $co++ ?></td>
                                <td><?= $dealer['guid'] ?></td>
                                <td><?= $dealer['name'] ?></td>
                                <td><?= $dealer['domain'] ?></td>
                                <td><?= $dealer['cron'] ?></td>
                                <td><?= $dealer['mongoExist']  ? $yes : $no ?></td>
                                <td><?= $dealer['mongoId'] ?></td>
                                <td><?= $dealer['mongoStatus']  ?></td>
                                <td><?= $dealer['mongoGroupName'] ?></td>
                                <td><?= $dealer['mongoGroupId'] ?></td>
                                <td><?= $dealer['mongoGroupStatus'] ?></td>

                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>

<?php
// print_r($allDealerCronMongo['vernondodge'])
?>

</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            scrollX: true,
            responsive: true,
            scrollCollapse: true,
            pageLength: 100,
            // fixedColumns: {
            //     leftColumns: 3,
            // },
            "pageLength": 50,
            "lengthMenu": [
                [50, 100, 200, 300, 400, -1],
                [50, 100, 200, 300, 400, "All"]
            ],
            dom: 'lBfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                // 'pdfHtml5',
                // 'print'
            ]
        });
    });
</script>