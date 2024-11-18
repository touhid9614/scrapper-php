<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$bing_logs_dealers = ADSYNCPATH . 'caches/bingads-log/';
$bing_logs_dirs = scandir($dealer_template_dir);
$bing_logs_dirs = array_slice($ng_logs_dirs, 2);

$file_location = 'http://' . $_SERVER['SERVER_NAME'] . '/adwords3/caches/bingads-log/';

$bing_logs_files = array();

if (is_dir($bing_logs_dealers)) {
    $i = 0;
    foreach (glob($bing_logs_dealers . "*.txt") as $file) {
        $i++;
        $bing_logs_files[$i]['name'] = basename($file);
        $bing_logs_files[$i]['full_file_dir'] = $file;
        $bing_logs_files[$i]['file_path'] = $file_location . basename($file);
        $bing_logs_files[$i]['file_size'] = formatSizeUnits(filesize($file));
    }
}

include 'bolts/header.php';
?>


<div class="inner-wrapper">
    <?php
    $select = 'bing-log-file';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="panel-title">Log Access</h2>
        </header>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped mb-none table-advanced">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>File Size</th>
                                <th>Last Modified</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($bing_logs_files)) :
                                foreach ($bing_logs_files as $value) :
                            ?>
                                    <tr>
                                        <td> <a href="<?= $value['file_path'] ?>" download> <?= $value['name'] ?> </a></td>
                                        <td> <?= $value['file_size'] ?> </td>
                                        <td> <?= date("F d Y H:i:s.", filemtime($value['full_file_dir'])) ?> </td>
                                    </tr>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
</div>

</section>


</div>

<?php
include 'bolts/footer.php';
