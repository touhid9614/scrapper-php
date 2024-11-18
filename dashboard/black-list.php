<?php

    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once 'includes/crm-defaults.php';

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';


    $black_list_dir = dirname(ABSPATH) . '/black-list/';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $domain_name = trim(filter_input(INPUT_POST, 'domain_name'));
        $block_ip = trim(filter_input(INPUT_POST, 'block_ip'));
        $domain_name = GetDomain($domain_name);
        $btn = trim(filter_input(INPUT_POST, 'btn'));

        /*
         * Log added start
         */
        DbConnect::store_log($user_id, $user['type'], 'Block List', 'Add block ip list where domain name- ' . $domain_name . ' and ip- ' . $block_ip);
        /*
         * Log added end
         */


        $black_list_file = $black_list_dir . $domain_name . '.txt';

        if (file_exists($black_list_file)) 
        {
            $black_file_open = fopen($black_list_file, "a");
            fwrite($black_file_open, PHP_EOL);
        } 
        else 
        {
            $black_file_open = fopen($black_list_file, "w");
        }
        
        $block_ip = explode(',', $block_ip);
        if($btn == 'add-list') {
            foreach ($block_ip as $ip) {
                fwrite($black_file_open, $ip);
                fwrite($black_file_open, PHP_EOL);
            }
        } else if($btn == 'remove-list') {
            $contents = file_get_contents($black_list_file);
            foreach ($block_ip as $ip) {
                $contents = str_replace($ip, '', $contents);
            }
            file_put_contents($black_list_file, $contents);
        }
         
       /*
        * To remove extra blank line from file
        */ 
        $lines           = file($black_list_file, FILE_IGNORE_NEW_LINES);
        $black_file_open = fopen($black_list_file, "w");    //to truncate file, reopen with write mode
        foreach ($lines as $ip) {
            if($ip) {
                fwrite($black_file_open, $ip);
                fwrite($black_file_open, PHP_EOL);
            }
        }
        fclose($black_file_open);
        chmod($black_list_file, 0777);
    }


    $file_location = 'http://' . $_SERVER['SERVER_NAME'] . '/black-list/';
    //$file_location = 'http://localhost/smedia-inventory/black-list/';

    if (is_dir($black_list_dir)) 
    {
        $i = 0;

        foreach (glob($black_list_dir . "*.txt") as $file) 
        {
            $i++;
            $black_list_files[$i]['name'] = basename($file);
            $black_list_files[$i]['full_file_dir'] = $file;
            $black_list_files[$i]['file_path'] = $file_location . basename($file);
        }
    }

    include 'bolts/header.php';
?>

<div class="inner-wrapper">

    <?php
        $select = 'black-list';
        include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="panel-title">Remove/Add IP Address -  Black List</h2>
        </header>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <form method="POST" class="form-horizontal form-bordered">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Domain Name </label>
                                    <div class="col-sm-9">
                                        <input name="domain_name" class="form-control" type="text" value="" placeholder="www.example.com" data-current_value='' required=""/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> IP Address </label>
                                    <div class="col-sm-9">                                      
                                        <input name="block_ip" class="form-control" type="text" placeholder="Multiple ip should be seperated by commas," data-current_value='' required=""/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">    
                                    <button name="btn" value="add-list" class="col-sm-6 btn btn-primary pull-right"> Add </button> 
                                    </div>
                                    <div class="col-sm-6">    
                                    <button name="btn" value="remove-list" class="col-sm-6 btn btn-danger"> Remove </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped mb-none table-advanced">
                        <thead>
                            <tr>
                                <th> File </th>
                                <th> Last Modified </th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                            if (count($black_list_files)) :
                                foreach ($black_list_files as $value) :
                        ?>
                                    <tr>
                                        <td> <a href="<?= $value['file_path'] ?>" download> <?= $value['name'] ?>   </a></td>
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
    </section>
</div>

<?php
    include 'bolts/footer.php';