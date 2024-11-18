<?php

    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once 'includes/crm-defaults.php';

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';

    $dealer_template_dir = ADSYNCPATH . 'ng_clear_logs/';
    $ng_logs_dirs = scandir($dealer_template_dir);
    $ng_logs_dirs = array_slice($ng_logs_dirs, 2);


    $ng_logs_files = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $directory_name = filter_input(INPUT_POST, 'directory_name');
        $ng_logs_dealer = $dealer_template_dir . $directory_name . '/';
        $file_location = 'https://' . $_SERVER['SERVER_NAME'] . '/adwords3/ng_clear_logs/' . $directory_name . '/';

        if (is_dir($ng_logs_dealer))
        {
            $i = 0;

            foreach (glob($ng_logs_dealer . "*.log") as $file)
            {
                $i++;
                $ng_logs_files[$i]['name'] = basename($file);
                $ng_logs_files[$i]['full_file_dir'] = $file;
                $ng_logs_files[$i]['file_path'] = $file_location . basename($file);
                $ng_logs_files[$i]['file_size'] = formatSizeUnits(filesize($file));
            }
        }
    }

    include 'bolts/header.php';
?>


<div class="inner-wrapper">
    <?php
    $select = 'ng_clear_logs';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="panel-title">Log Access</h2>
        </header>

        <div class="panel-body">
            <div class="row">
                <form method="POST" class="form-horizontal form-bordered">
                    <div class="col-lg-10 col-md-12">                   
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Directory Name</label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control populate" name="directory_name">
                                        <option value="">-- Select --</option>
                                        <?php
                                        foreach ($ng_logs_dirs as $value)
                                        {
                                        ?>
                                            <option value="<?= $value ?>" <?= $directory_name == $value ? 'selected' : '' ?>><?= $value ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>   
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button name="btn" value="nglogs-access" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </div>  
                    </div>
                </form>
            </div>

            <br>
            <br>

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
                            if (count($ng_logs_files))
                            {
                                foreach ($ng_logs_files as $value)
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="<?= $value['file_path'] ?>" download> <?= $value['name'] ?></a>
                                        </td>
                                        <td> <?= $value['file_size'] ?> </td>
                                        <td> <?= date("F d Y H:i:s.", filemtime($value['full_file_dir'])) ?> </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>   
                    </table>
                </div>
            </div>    
        </div>
    </section>
</div>

<?php
    include 'bolts/footer.php';
