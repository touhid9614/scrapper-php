<?php

use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Scalar;
use PhpParser\Node\Name;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Array_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\PrettyPrinter;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;

require_once 'client-management/configUpdater.php';

$no_scrap_status = isset($dealership['no_scrap']) ? $dealership['no_scrap'] : false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-scrap-setting')) {

    $no_scrap = isset($_POST['no_scrap_status']) ? 1 : 0;

    $quary = "UPDATE dealerships SET no_scrap = $no_scrap  WHERE dealership = '$cron_name';";
    $db_connect->query($quary);


    /*
    * Log added start
    */
    $log_no_scrap_status = $no_scrap ? $no_scrap : 0;
    DbConnect::store_log($user_id, $user['type'], 'Dealer scrapper setting', 'Dealer scrapper setting change where dealer name- ' . $cron_name . ' and No scrap status is- ' . $log_no_scrap_status, $cron_name);
    /*
    * Log added end
    */

    /*
     * Refresh page after updation
     */

    echo("<script type='text/javascript'> location.href= location.href; </script>");
}

?>

<form method="POST" class="form-horizontal form-bordered" action="?dealership=<?php echo $cron_name ?>">

    <div class="row form-group-row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <div class="checkbox-custom chekbox-primary">
                        <input id="no_scrap_status" value="1" type="checkbox"
                               name="no_scrap_status" <?= $no_scrap_status ? 'data-current="checked" checked' : 'data-current=""'; ?> />
                        <label for="no_scrap_status">Enable No Scrap
                            <span>( If you don't want to run scraper then enable this)</span></label>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row form-group-row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button name="btn" value="save-scrap-setting" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>