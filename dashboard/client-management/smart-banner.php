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

$smart_banner_status = isset($cron_config['smart_banner']) ? true : false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-smart-banner')) {

    $live = filter_input(INPUT_POST, 'live', FILTER_VALIDATE_BOOLEAN);
    $title = filter_input(INPUT_POST, 'title');


    /*
    *  Parser & traverser
    */
    $configFile  = s3DealerConfig($cron_name);
    $parser     = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

    try
    {
        $ast = $parser->parse($configFile);
    }
    catch (Error $error)
    {
        echo 'Error Parse';
        print_r($error->getMessage());
        return;
    }

    $traverser = new NodeTraverser();


    $smart_banner = array(
        "live" => $live,
        "title" => $title,
    );

    if ($smart_banner_status) {
        $traverser->addVisitor(new configUpdater([
            'key' => ['smart_banner'],
            'value' => $smart_banner
        ]));
    } else {
        $traverser->addVisitor(new configCreator('smart_banner', $smart_banner));
    }

    $cron_config['smart_banner']=$smart_banner;

    /*
     * Update Configs
     */
    configsUpdate($cron_config,$cron_name);

    try{
        $ast = $traverser->traverse($ast);
        $prettyPrinter = new ePrinter();
        $config_file_content = $prettyPrinter->prettyPrintFile($ast);
    } catch (Error $error){
        echo 'Error in traverse';
    }

    /*
     * Update s3 dealer config
     */
    s3Update($config_file_content,$cron_name);
    
    /*
    * Log added start
    */
    $log_smart_offer_status= $live ? $live : 0;
    DbConnect::store_log($user_id, $user['type'], 'Dealer smart banner', 'Dealer smart banner change where dealer name- ' . $cron_name . ' and status is- ' . $log_smart_offer_status , $cron_name );
    /*
    * Log added end
    */

    /*
     * Refresh page after updation
     */
    echo ("<script type='text/javascript'> location.href= location.href; </script>");
}

?>

<form method="POST" class="form-horizontal form-bordered" action="?dealership=<?php echo $cron_name ?>">
    <div class="row form-group-row">
        <div class="col-md-12"> 
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <div class="checkbox-custom chekbox-primary">
                        <input id="live" value="1" type="checkbox" name="live" <?= $cron_config['smart_banner']['live'] ? 'data-current="checked" checked' : 'data-current=""'; ?> />
                        <label for="live">Enable Smart Banner</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row form-group-row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-sm-3 control-label">Title</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="title" value="<?= isset($cron_config['smart_banner']['title']) ? $cron_config['smart_banner']['title'] : ''; ?>" placeholder="Would you like to continue shopping for [year] [make] [model]" />
                </div>
            </div>
        </div>
    </div>
 
    <div class="row form-group-row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button name="btn" value="save-smart-banner" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>