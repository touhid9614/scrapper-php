<?php
require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
include 'bolts/header.php';

$cron_name           = $user['cron_name'];
$form_directory_file = dirname(ADSYNCPATH) . '/forms/third-party-code/' . $cron_name . '.js';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-third-party-code')) {
    $third_party_code = trim(filter_input(INPUT_POST, 'third_party_code'));
    $fopen            = fopen($form_directory_file, "w");
    fwrite($fopen, $third_party_code);
    fclose($fopen);
    chmod($form_directory_file, 0777);
}

if (file_exists($form_directory_file)) {
    $file_content = file_get_contents($form_directory_file);
} else {
    $file_content = "";
}
?>


<div class="inner-wrapper">
<?php
$select = 'thirty-party-code';
include 'bolts/sidebar.php'
?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="panel-title"> Add Third-Party JS Code for Forms </h2>
        </header>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <form method="POST" class="form-horizontal form-bordered">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Add your code here  </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" cols="15" rows="10" name="third_party_code" required><?=$file_content?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button name="btn" value="save-third-party-code"  class="btn btn-primary pull-right"> Submit </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
