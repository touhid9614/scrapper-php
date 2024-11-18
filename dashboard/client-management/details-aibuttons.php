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

use sMedia\AiButton\AiButtonCombination;

require_once 'client-management/configUpdater.php';

// Use a single db_connect;
$db_connect = new DbConnect('');

$last_lead_status   = getLastVES($cron_name, 'lead_to');
$last_adf_status    = getLastVES($cron_name, 'adf_to');

$adf_db = $db_connect->getADF($cron_name);
$button_status  = isset($adf_db) ? $adf_db['buttons_live'] : false;
$from_status    = isset($adf_db) ? $adf_db['form_live'] : false;
$lead_to        = (isset($adf_db) && is_array($adf_db['lead_to']) && count($adf_db['lead_to']) > 0) ? $adf_db['lead_to'] : ['leads_to@smedia.ca', 'aileads@smedia.ca'];
$adf_to         = isset($adf_db) ? $adf_db['adf_to'] : ['adf_to@smedia.ca'];

$led_to_check = remove_email($lead_to);
$adf_to_check = remove_email($adf_to);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-aibuttons' || filter_input(INPUT_POST, 'btn') == 'save-aibuttons-newstyle' || filter_input(INPUT_POST, 'btn') == 'clearandlaunch-aibuttons'))
{
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


    if (filter_input(INPUT_POST, 'btn') == 'clearandlaunch-aibuttons')
    {
        $db_connect->query("DELETE FROM tbl_btn_comb_stat WHERE dealership = '$cron_name'");
        $db_connect->query("DELETE FROM tbl_btn_opt_ext WHERE dealership = '$cron_name'");
        $db_connect->query("DELETE FROM tbl_btn_status WHERE dealership = '$cron_name'");
        $db_connect->query("UPDATE dealership SET buttons_live = true WHERE dealership = '$cron_name'");
    }

    if (filter_input(INPUT_POST, 'btn') == 'save-aibuttons')
    {
        if ($form_configured)
        {
            $form_live = filter_input(INPUT_POST, 'form_live', FILTER_VALIDATE_BOOLEAN);
            $lead_emails = filter_input(INPUT_POST, 'lead_emails');
            $adf_emails = filter_input(INPUT_POST, 'adf_emails');

            $lead_emails_commas = preg_replace('#\s+#', ',', trim($lead_emails));
            $adf_emails_commas = preg_replace('#\s+#', ',', trim($adf_emails));
            $leads_emailslist = !empty($lead_emails_commas) ? explode(',', $lead_emails_commas) : '';
            $adf_emailslist = !empty($adf_emails_commas) ? explode(',', $adf_emails_commas) : '';

            // Update in DB
            $adf_lead_form  =
                [
                    'lead_to'   => serialize($leads_emailslist),
                    'adf_to'    => serialize($adf_emailslist),
                    'form_live' => $form_live
                ];

            $query_prep = $db_connect->prepare_query_params($adf_lead_form, DbConnect::PREPARE_EQUAL);
            $query_str = "UPDATE dealerships SET $query_prep WHERE dealership = '$cron_name'";
            $db_connect->query($query_str);
        }

        //For button configuration
        $buttons_live = filter_input(INPUT_POST, 'buttons_live', FILTER_VALIDATE_BOOLEAN);

        // Update button live status in DB
        $db_connect->query("UPDATE dealerships SET buttons_live = '$buttons_live' WHERE dealership = '$cron_name'");

        $button_text = $_POST['button_text'];

        foreach ($cron_config['buttons'] as $button_name => $button_config)
        {
            foreach ($button_config['texts'] as $text_name => $text_config)
            {
                $button_text_values = $button_text[$button_name][$text_name];
                $button_textarr = explode("\n", $button_text_values);

                array_walk($button_textarr, function (&$val)
                {
                    $val = trim($val);
                });

                $traverser->addVisitor(new configUpdater(
                    [
                        'key' => ['buttons', $button_name, 'texts', $text_name, 'values'],
                        'value' => $button_textarr
                    ]));
                $cron_config['buttons'][$button_name]['texts'][$text_name]['values']=$button_textarr;
            }
        }

        $buttonstyle = $_POST['buttonstyle'];
        $delete_check = $_POST['delete_check'];
        $first_button_config = array();
        foreach ($cron_config['buttons'] as $button_name => $button_config)
        {
            $style_arr = [];
            //$first_button_config = count($first_button_config) ? $first_button_config : $button_config;
            $first_button_config = $button_config;
            foreach ($first_button_config['styles'] as $style_name => $style_value)
            {
                if (!$delete_check[$style_name])
                {
                    foreach ($style_value as $style_position => $style_position_value)
                    {
                        foreach ($style_position_value as $key => $val)
                        {
                            if (preg_match_all('/linear-gradient\((?<value1>[^\,]+),(?<value2>[^\)]+)/', $val, $match_result))
                            {
                                $color1 = $match_result[value1][0];
                            }
                            else
                            {
                                $color1 = "#";
                            }

                            if (($key == 'background-color' || $key == 'background') && $color1[0] == '#')
                            {
                                $key = 'background';
                                $val = "linear-gradient(#" . $buttonstyle[$style_name][$style_position]['bgcolor']['gcolor1'] . ",#" . $buttonstyle[$style_name][$style_position]['bgcolor']['gcolor2'] . ")";
                                $style_arr[$style_name][$style_position][$key] = $val;
                            }
                            else if ($key == 'border-color')
                            {
                                $style_arr[$style_name][$style_position]['border-color'] = $buttonstyle[$style_name][$style_position][$key];
                            }
                            else
                            {
                                if (isset($button_config['styles'][$style_name][$style_position][$key]))
                                {
                                    $style_arr[$style_name][$style_position][$key] = $button_config['styles'][$style_name][$style_position][$key];
                                }
                            }
                        }
                    }
                }
            }
            $traverser->addVisitor(new configUpdater(
                [
                    'key' => ['buttons', $button_name, 'styles'],
                    'value' => $style_arr
                ]));
            $cron_config['buttons'][$button_name]['styles']=$style_arr;
        }
    }


    if (filter_input(INPUT_POST, 'btn') == 'save-aibuttons-newstyle')
    {
        foreach ($cron_config['buttons'] as $button_name => $button_config)
        {
            $style_arr = [];
            //$first_button_config = count($first_button_config) ? $first_button_config : $button_config;
            $first_button_config = $button_config;

            foreach ($first_button_config['styles'] as $style_name => $style_value)
            {
                foreach ($style_value as $style_position => $style_position_value)
                {
                    foreach ($style_position_value as $key => $val)
                    {
                        $style_arr[$style_name][$style_position][$key] = $val;
                    }
                }
            }

            $new_style_name = filter_input(INPUT_POST, 'new_style_name');

            if ($new_style_name)
            {
                foreach ($style_value as $style_position => $style_position_value)
                {
                    foreach ($style_position_value as $key => $val)
                    {
                        $style_arr[$new_style_name][$style_position][$key] = $val;
                    }
                }
            }

            $traverser->addVisitor(new configUpdater(
                [
                    'key' => ['buttons', $button_name, 'styles'],
                    'value' => $style_arr
                ]));
            $cron_config['buttons'][$button_name]['styles']=$style_arr;
        }
    }


    /*
     * Update Configs
     */
    configsUpdate($cron_config,$cron_name);

    if (isset($cron_config['button_algorithm']) && isset($cron_config['buttons'])) {
        foreach(explode('|', $cron_config['button_algorithm']) as $algorithm) {
            $algorithm = trim($algorithm);
            if (!empty($algorithm) && $algorithm != 'default') {
                $combinations = new AiButtonCombination($cron_name, $cron_config['buttons'], DbConnect::get_connection_read(), $algorithm);
                $combinations->generateCombination()->saveCombination(DbConnect::get_connection_read(), DbConnect::get_connection_write());
                unset($combinations);
            }
        }
    }

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
    DbConnect::store_log($user_id, $user['type'], 'AI Button', 'AI Button change where domain name- ' . $cron_name, $cron_name);

    $base_filename = basename($config_file_name, ".php");
    $button_data_file = ADSYNCPATH . "caches/button-data/" . $base_filename . ".dat";
    unlink($button_data_file);

    echo ("<script type='text/javascript'> location.href= location.href; </script>");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'lead-resend-email'))
{
    $match_key  = $_POST['match_key'];
    $email_list = $_POST['email_list'];
    //echo $email_list ; echo $match_key ;
    reSendEmail($match_key,'lead_to',$email_list);
    echo '<script type=”javascript>alert("Verification Email resend successfully !!!")</script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'adf-resend-email'))
{
    $match_key  = $_POST['adf-match_key'];
    $email_list = $_POST['adf-email_list'];
    //echo $email_list ; echo $match_key ;
    reSendEmail($match_key,'adf_to',$email_list);
    echo '<script type=”javascript>alert("Verification Email resend successfully !!!")</script>';
}


if (count($adf_db['lead_to_new']) == 0)
{
    unset($adf_db['lead_to_new']);
}

if (count($adf_db['adf_to_new']) == 0)
{
    unset($adf_db['adf_to_new']);
}

if (count($adf_db['lead_to_used']) == 0)
{
    unset($adf_db['lead_to_used']);
}

if (count($adf_db['adf_to_used']) == 0)
{
    unset($adf_db['adf_to_used']);
}

$db_connect->close_connection();
?>



<form method="POST" class="form-bordered" action="?dealership=<?= $cron_name ?>">
    <div class="row form-group-row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"> Button Live </label>

                <div class="col-md-9">
                    <select class="form-control" name="buttons_live" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
                        <option value="" <?= $adf_db['buttons_live'] ? '' : 'selected=""' ?>>No</option>
                        <option value="yes" <?= $adf_db['buttons_live'] ? 'selected=""' : '' ?>>Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <?php
        if ($form_configured)
        {
            ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-3 control-label"> Form Live </label>

                    <div class="col-md-9">
                        <select class="form-control" name="form_live" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
                            <option value="" <?= $adf_db['form_live'] ? '' : 'selected=""' ?>>No</option>
                            <option value="yes" <?= $adf_db['form_live'] ? 'selected=""' : '' ?>>Yes</option>
                        </select>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <?php
    if ($form_configured)
    {
        ?>
        <div class="row form-group-row">
            <div class="col-md-6 mb-lg">
                <div class="form-group">
                    <label class="col-md-3 control-label"> Lead Emails </label>
                    <div class="col-md-9">
                        <textarea class="form-control" cols="35" rows="4" name="lead_emails" placeholder="One e-mail per line"><?= implode("\n", $adf_db['lead_to']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-lg">
                <div class="form-group">
                    <label class="col-md-3 control-label"> ADF Emails </label>
                    <div class="col-md-9">
                        <textarea class="form-control" cols="35" rows="4" name="adf_emails" placeholder="One e-mail per line"><?= implode("\n", $adf_db['adf_to']) ?></textarea>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }
    ?>


    <div class="row form-group-row">
        <?php
        $n = 0;
        foreach ($cron_config['buttons'] as $button_name => $button_config)
        {
        ?>
        <?php
        foreach ($button_config['texts'] as $text_name => $text_config)
        {
        ?>
        <?php
        if ($n > 0 && ($n % 2) == 0)
        {
        ?>
    </div>
    <div class="row form-group-row">
        <?php
        }
        ?>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label"><?= $button_name ?> Text (<?= $text_name ?>)</label>
                <div class="col-md-9">
                    <textarea class="form-control" cols="35" rows="4" name="button_text[<?= $button_name ?>][<?= $text_name ?>]" placeholder="One text per line"><?= implode("\n", $text_config['values']) ?></textarea>
                </div>
            </div>
        </div>
        <?php
        $n++;
        }
        }
        ?>
    </div>
    <!-- BUTTONS -->


    <!-- Start Global Button Styles -->
    <div class="row form-group-row">
        <?php
        $n = 0;
        foreach ($cron_config['buttons'] as $button_name => $button_config)
        {
        ?>
        <?php
        foreach ($button_config['styles'] as $style_name => $style_value)
        {
        foreach ($style_value as $style_position => $style_position_value)
        {
        $hide_delete = 0;
        $background_value = isset($style_position_value['background-color']) ? $style_position_value['background-color'] : (isset($style_position_value['background']) ? $style_position_value['background'] : '');
        $border_value = isset($style_position_value['border-color']) ? $style_position_value['border-color'] : '';

        if ($n > 0 && ($n % 2) == 0)
        {
        ?>
    </div>

    <div class="row form-group-row">
        <?php
        }
        ?>
        <div class="col-md-5">
            <div class="form-group">
                <?php
                if (preg_match_all('/linear-gradient\((?<value1>[^\,]+),(?<value2>[^\)]+)/', $background_value, $match_result))
                {
                    $color1 = $match_result[value1][0];
                    $color2 = $match_result[value2][0];

                    if ($color1[0] != "#")
                    {
                        $hide_delete = 1;
                    }

                    if (!$hide_delete)
                    {
                        ?>
                        <div class="col-md-3">
                            <label style="padding-top: 3px" class="control-label"> <?= ucfirst($style_position) ?>-<?= $style_name ?>   </label>
                            <label style="padding-top: 5px" class="control-label"> Border-Color   </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="buttonstyle[<?= $style_name ?>][<?= $style_position ?>][bgcolor][gcolor1]" class="form-control jscolor" value="<?= $color1 ?>">
                            <input type="text" name="buttonstyle[<?= $style_name ?>][<?= $style_position ?>][border-color]" class="form-control jscolor" value="<?= $border_value ?>">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="buttonstyle[<?= $style_name ?>][<?= $style_position ?>][bgcolor][gcolor2]" class="form-control jscolor" value="<?= $color2 ?>">

                        </div>
                        <?php
                    }

                }
                else
                {
                    ?>
                    <div class="col-md-3">
                        <label style="padding-top: 3px" class="control-label"> <?= ucfirst($style_position) ?>-<?= $style_name ?> sdf </label>
                        <label style="padding-top: 5px" class="control-label"> Border-Color   </label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="buttonstyle[<?= $style_name ?>][<?= $style_position ?>][bgcolor][gcolor1]" class="form-control jscolor" value="<?= $background_value ?>">
                        <input type="text" name="buttonstyle[<?= $style_name ?>][<?= $style_position ?>][border-color]" class="form-control jscolor" value="<?= $border_value ?>">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="buttonstyle[<?= $style_name ?>][<?= $style_position ?>][bgcolor][gcolor2]" class="form-control jscolor" value="<?= $background_value ?>">
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        $n++;
        }
        ?>
        <?php
        if (!$hide_delete)
        {
            ?>
            <div class="col-md-2">
                <div class="checkbox-custom chekbox-primary">
                    <input type="checkbox" name="delete_check[<?= $style_name ?>]" value="1">
                    <label for="remove-style"> Delete </label>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        }

        break;  // Why is there a break here?
        }
        ?>
    </div>
    <!-- End Global Button Styles -->


    <div class="row form-group-row clearfix">
        <div class="col-md-4">
            <div class="input-group mb-md">
                <input type="text" name="new_style_name" class="form-control" value="" placeholder="Enter New Style Name">
                <div class="input-group-btn">
                    <button name="btn" value="save-aibuttons-newstyle" class="btn btn-success pull-right"> Add </button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <?php
                if (!$adf_db['buttons_live'])
                {
                    ?>
                    <button name="btn" onClick="confSubmit(this.form);" value="clearandlaunch-aibuttons" class="btn btn-success pull-right"> Clear Data & Launch Button </button>
                    <?php
                }
                else
                {
                    ?>
                    <label class="text-danger" for="clear-data"> To Clear Data Switch Button to Debug Mode </label>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <button name="btn" value="save-aibuttons" class="btn btn-primary pull-right"> Save Changes </button>
            </div>
        </div>
    </div>
    <!-- END BUTTONS -->
</form>

<?php unset($adf_db); ?>
