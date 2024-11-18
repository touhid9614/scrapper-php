<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

add_script('addnew', 'app/js/template-manager.js');

$cron_name           = $user['cron_name'];
$dealer_template_dir = ADSYNCPATH . 'templates/' . $cron_name . '/';
$full_directory      = '';
// $active_dir = [" $cron_name , '$dealer_template_dir'"] ;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_directory = filter_input(INPUT_POST, 'full_directory');
    $submit_button  = filter_input(INPUT_POST, 'submit_button');

    if ($submit_button == 'delete') {
        $path = filter_input(INPUT_POST, 'path');
        if (file_exists($path)) {
            unlink($path);
            // rmdir($path);
            echo $path;
        }
    } else if ($submit_button == 'file') {
        $file_name  = $_FILES['file_name'];
        $type       = $file_name['type'];
        $temp_dir   = $file_name['tmp_name'];
        $target_dir = $full_directory . $file_name['name'];
        if ($type == 'image/png') {
            move_uploaded_file($temp_dir, $target_dir);
        }
    } else {
        $folder_name      = filter_input(INPUT_POST, 'folder_name');
        $folder_directory = $full_directory . $folder_name;
        if (!file_exists($folder_directory)) {
            mkdir($folder_directory, 0777, true);
        }
    }
}

if (!empty($full_directory)) {
    $dealer_template_dir = $full_directory;
}

$files_data = [];
if (is_dir($dealer_template_dir)) {
    $files_data = getAllDirectoris($dealer_template_dir);
}

include 'bolts/header.php';
?>


<div class="inner-wrapper">
    <?php
$select = 'template-manager';
include 'bolts/sidebar.php'
?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="panel-title">Template Grapuhics Management</h2>
        </header>

        <section class="panel panel-info">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                </div>
                <h2 class="panel-title"> Configuration Panel </h2>
            </header>
            <div class="panel-body">
                <form method="GET" class="
                form-inline">
                    <label class="  mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
                    &nbsp; &nbsp;
                    <select class="form-control populate mb-2 mr-sm-2 mb-sm-0" name="dealership" id="dealership" data-plugin-selectTwo >
                        <?php
if ($user['type'] == 'a') {
    foreach ($cron_names as $c_name) {
        $selected = ($cron_name == $c_name) ? ' selected' : '';
        ?>
                                <option value="<?=$c_name?>"<?=$selected?>><?=$c_name?></option>
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
        </section>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" >
                    <h4 id="active_dir">
                    Active Directori : templates /
                    <?php
if (empty($full_directory)) {
    ?>
                        <a href='#' onclick='createNew("<?=$dealer_template_dir?>")'> <?=$cron_name?></a> /
                    <?php
} else {
    $fullDir     = explode("/", $full_directory);
    $removeIndex = array_search("templates", $fullDir);
    $newPath     = '';
    for ($i = 0, $fullDirLength = count($fullDir) - 1; $i < $fullDirLength; $i++) {
        $newPath = $newPath . $fullDir[$i] . '/';
        if ($i > $removeIndex) {
            ?>
                                <a href='#' onclick='createNew("<?=$newPath?>")'> <?=$fullDir[$i]?></a> /
                            <?php
}
    }
}
?>
                    </h4>
                </div>
            </div>
        </div>

        <div class="panel-body marTop20">
            <div class="row">
                <div class="col-md-12"  id="new_dir">
                    <?php
foreach ($files_data as $key => $value):
    if ($value['type'] == 'folder') {
        ?>

                            <div class="col-md-2 temp-manager">
                                <a href="#" onclick='createNew("<?=$value['path']?>")'> <i class="fas fa-folder-open font120"></i> <br><?=$value['name']?> </a>
                            </div>


                        <?php } else {?>

                            <div class="col-md-2 temp-manager">
                                <a href="#" onclick='viewImage("<?=$value['path']?>")'> <i class="far fa-image font120"></i> <br><?=$value['name']?> </a>
                            </div>

                        <?php }
endforeach;?>

                        <div class="col-md-2 temp-manager">
                            <a href="#" onclick='createNewFolder("<?=$dealer_template_dir?>")'> <i class="fas fa-plus-square font120"></i> <br>Create Folder or Upload file</a>
                        </div>

                </div>
                <div class="col-md-12" id="loding" data-loading-overlay data-loading-overlay-options='{ "startShowing": true }' style="min-height: 150px;">
                        </div>
            </div>
        </div>

    </section>
</div>


<div id="modalForm" class="modal-block modal-block-primary mfp-hide">
    <section class="panel">
    <form method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data">
    <input type="hidden" name="full_directory" id="full_directory">
        <header class="panel-heading">
            <h2 class="panel-title">Create Folder or Upload file</h2>
        </header>
        <div class="panel-body">
            <div class="tabs">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a href="#file" data-toggle="tab" class="text-center">Upload file</a>
                    </li>
                    <li>
                        <a href="#folder" data-toggle="tab" class="text-center">Create Folder</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="file" class="tab-pane active">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="inputPlaceholder">Select File</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="file_name" accept="image/png">
                                <span class="help-block">only png type</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                            <button type="submit" name="submit_button" value="file" class="btn btn-info btn-block">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div id="folder" class="tab-pane">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="inputPlaceholder">Folder Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="New Folder" name="folder_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                            <button type="submit" name="submit_button" value="folder" class="btn btn-info btn-block">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </section>
</div>

<div id="viewTheImage" class="modal-block modal-block-primary mfp-hide">
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Image</h2>
        </header>
        <div class="panel-body">
        <img id="imgLink" src="https://dummyimage.com/600x400/ccc8cc/ccc8cc.png" alt='Wrong Image Path' width='550' height="400" style='display: block !important'/>
        <div  id="myImage" style="margin-top: 10px;">
        </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
