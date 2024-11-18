<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $user, $connection;

$placementList = [];
$fileName = dirname(__DIR__) . "/adwords3/caches/defaultPlacementList.txt";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'add-placement')) {
    $url = $_POST['url'];
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $file = fopen($fileName, "a+");
        fwrite($file, "\n" . $url);
        fclose($file);
    }

}

$file = fopen($fileName, "r");
while (!feof($file)) {
    $data = fgets($file);
    if (strlen($data) > 2) {
        array_push($placementList, $data);
    }
}
fclose($file);

?>

<?php include 'bolts/header.php' ?>

    <div class="inner-wrapper">
        <?php
        $select = 'default-placement';
        include 'bolts/sidebar.php';
        $i = 1;
        ?>

        <section role="main" class="content-body">
            <header class="page-header">
            </header>

            <div class="row">
                <div class="col-md-8">
                    <section class="panel panel-info">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="fa fa-caret-down"></a>
                            </div>

                            <h2 class="panel-title"> Add New Default Placement </h2>
                        </header>

                        <div class="panel-body">
                            <form method="POST">
                                <div class="row form-group-row" style="padding: 0px 15px 15px">
                                    <div class="col-sm-12" style="padding: 0px; margin-bottom:15px;">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label class="control-label"><b>URL</b></label>
                                                <input type="text" class="form-control" name="url" value=""
                                                       placeholder="http://car.com" required/>
                                                <p>* Please add url with http or https</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">

                                        <button name="btn" value="add-placement" class="btn btn-block btn-primary ">
                                            Add
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </section>
                    <section class="panel panel">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="fa fa-caret-down"></a>
                            </div>

                            <h2 class="panel-title"> Default Placement List </h2>
                        </header>

                        <div class="panel-body">
                            <?php if (count($placementList)) { ?>
                                <!--                            <table class="table table-bordered mb-none table-advanced">-->
                                <!--                                <thead>-->
                                <!--                                <tr>-->
                                <!--                                    <th> #</th>-->
                                <!--                                    <th> Website URL</th>-->
                                <!--                                    <th> Action</th>-->
                                <!--                                </tr>-->
                                <!--                                </thead>-->
                                <!---->
                                <!--                                <tbody>-->
                                <?php foreach ($placementList as $list): ?>
                                    <!--                                    <tr>-->
                                    <!--                                        <td>--><? //= $i++; ?><!--</td>-->
                                    <!--                                        <td><a target='_blank' href="--><? //= $list ?><!--">--><? //= $list ?><!--</a></td>-->
                                    <!--                                        <td>-->
                                    <!--                                            <a class="btn btn-sm btn-info"> Delete </a>-->
                                    <!--                                        </td>-->
                                    <!--                                    </tr>-->
                                <?php endforeach; ?>
                                <!--                                </tbody>-->
                                <!--                            </table>-->
                            <?php } ?>

                            <?php
                            if (count($placementList)) {
                                foreach ($placementList as $url) {
                                    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                                        $url = "http://" . $url;
                                    }
                                    echo " <a target='_blank' href='$url'><h4>$i. $url</h4></a>";
                                    $i++;
                                }

                            } else {
                                echo '<h4>No Default Placement Found !!</h4>';
                            }
                            ?>

                        </div>
                    </section>

                </div>
            </div>
        </section>
    </div>

<?php
include 'bolts/footer.php';