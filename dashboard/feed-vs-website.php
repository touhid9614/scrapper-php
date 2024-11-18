<?php
    include 'feed-vs-website-data.php';
    include 'bolts/header.php'
?>

<div class="inner-wrapper">

<?php
    $select = 'feed-vs-website';
    include 'bolts/sidebar.php'
?>

    <section role="main" class="content-body">
        <header class="page-header">
			<h2> Dynamic Feed vs Website Vehicle Comparison </h2>
        </header>

        <div class="row">
			<div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title"> Dynamic Feed vs Website </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row">
								<div class="col-lg-12">
                                    <table class="table table-bordered table-striped mb-none table-advanced">
                                        <thead style="text-align: center;">
                                            <tr>
                                            	<th rowspan="2">Dealership Name</th>
                                                <th rowspan="2">Website URL</th>
                                                <th colspan="3">Vehicles in Website</th>
                                                <th colspan="3">Vehicles in Feed</th>
                                                <th colspan="3">No Image</th>
                                                <th colspan="3">No Image (marketplace)</th>
                                                <th colspan="3">No Price</th>
                                            </tr>
                                            <tr>
                                                <!-- In Website -->
                                            	<th>New</th>
                                                <th>Used</th>
                                                <th>Certified</th>

                                                <!-- In Feed -->
                                                <th>New</th>
                                                <th>Used</th>
                                                <th>Certified</th>

                                                <!-- No Image -->
                                                <th>New</th>
                                                <th>Used</th>
                                                <th>Certified</th>

                                                <!-- No Image (marketplace) -->
                                                <th>New</th>
                                                <th>Used</th>
                                                <th>Certified</th>

                                                <!-- No Price -->
                                                <th>New</th>
                                                <th>Used</th>
                                                <th>Certified</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach ($data as $dealer => $report) 
                                            {
                                        ?>
                                            <tr>
                                                <td><i><a href="details.php?dealership=<?= $dealer ?>" target="_blank"><?= $dealer ?></a></i></td>
                                                <td><i><a href="<?= $report["url"] ?>" target="_blank"><?= $report["url"] ?></a></i></td>
                                                <td><?= $report["site"]["new"] ?></td>
                                                <td><?= $report["site"]["used"] ?></td>
                                                <td><?= $report["site"]["certified"] ?></td>
                                                <td><?= $report["feed"]["new"] ?></td>
                                                <td><?= $report["feed"]["used"] ?></td>
                                                <td><?= $report["feed"]["certified"] ?></td>

                                                <!-- No Image -->
                                                <td><?= $report["image"]["new"] ?></td>
                                                <td><?= $report["image"]["used"] ?></td>
                                                <td><?= $report["image"]["certified"] ?></td>

                                                <!-- No Image (marketplace) -->
                                                <td><?= $report["marketplace_image"]["new"] ?></td>
                                                <td><?= $report["marketplace_image"]["used"] ?></td>
                                                <td><?= $report["marketplace_image"]["certified"] ?></td>
                                                
                                                <!-- No Price -->
                                                <td><?= $report["price"]["new"] ?></td>
                                                <td><?= $report["price"]["used"] ?></td>
                                                <td><?= $report["price"]["certified"] ?></td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
    include 'bolts/footer.php';