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

global $scrapper_configs, $single_config, $smart_offer_default;

$single_config   = $_GET['dealership'];
$smart_offer_for = isset($_GET['for']) ? $_GET['for'] : 'default';
$url             = $_SERVER['REQUEST_URI'];

$new_lead_arr = $smart_offer_default;

$popover_texts = [
    'live'                   => "Show smart offer",
    'lead_type_'             => "Show smart offer on vdp pages",
    'lead_type_new'          => "Show smart offer only for new cars",
    'lead_type_used'         => "Show smart offer only for used cars",
    'lead_type_service'      => "Show smart offer only for service page",
    'shown_cap'              => "Show smart offer limited times (default once) in a day",
    'fillup_cap'             => "Show smart offer after certain days (default 7 days) if submitted",
    'session_close'          => "Show smart offer limited times (default 3 times) in a session",
    'inactivity'             => "Remove smart offer after certain time (default 600 sec) in a session",
    'exit_intent'            => "Remove smart offer after certain time (default 10 sec) if user is leaving page or left page",
    'session_depth'          => "Show smart offer after certain number of page visits (default 0 page)",
    'campaign_cap_google'    => "Show smart offer certain times (default 3) within certain period (default 7 days) if arrives from google retargeting ads",
    'campaign_cap_fb'        => "Show smart offer certain times (default 3) within certain period (default 7 days) if arrives from facebook ads",
    'mobile'                 => "Show smart offer only on mobile devices",
    'desktop'                => "Show smart offer only on desktop devices",
    'tablet'                 => "Show smart offer only on tablet devices",
    'video_smart_offer'      => "Show smart offer Video",
    'video_smart_offer_form' => "Show smart offer Video with form",
    'sent_client_email'      => "When checked, an auto response email will be sent to the user",
    'offer_minimum_price'    => "Minimun price for which smart offer is shown",
    'offer_maximum_price'    => "Maximun price for which smart offer is shown",
];

$diff_config = false;
$msg         = "The changes you just made will be applied to <br>";
$service_msg = "";

if ($smart_offer_for == "new") {
    $msg .= <<<NEW_STR
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> New VDP <i class="fa fa-check" aria-hidden="true"></i>
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> Used VDP <i class="fa fa-times" aria-hidden="true"></i>
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> Service VDP <i class="fa fa-times" aria-hidden="true"></i>
    <br>
NEW_STR;
} else if ($smart_offer_for == "used") {
    $msg .= <<<USED_STR
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> New VDP <i class="fa fa-times" aria-hidden="true"></i>
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> Used VDP <i class="fa fa-check" aria-hidden="true"></i>
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> Service VDP <i class="fa fa-times" aria-hidden="true"></i>
    <br>
USED_STR;
} else if ($smart_offer_for == "service") {
    $msg .= <<<SERVICE_STR
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> New VDP <i class="fa fa-times" aria-hidden="true"></i>
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> Used VDP <i class="fa fa-times" aria-hidden="true"></i>
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> Service VDP <i class="fa fa-check" aria-hidden="true"></i>
    <br>
SERVICE_STR;
} else {
    $MSG .= <<<ALL_STR
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> New VDP <i class="fa fa-check" aria-hidden="true"></i>
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> Used VDP <i class="fa fa-check" aria-hidden="true"></i>
    <br>
    <i class="fa fa-angle-right" aria-hidden="true"></i> Service VDP <i class="fa fa-check" aria-hidden="true"></i>
    <br>
    <br>
    And all custom settings will be deleted (If Any Exists)
ALL_STR;
}

$lead_configured = isset($cron_config['lead']);

if ($lead_configured) {
    if (isset($cron_config['lead']['new'])) {
        $service_msg = "Smart offer custom setting available for <strong>New VDP</strong>";
    }

    if (isset($cron_config['lead']['used'])) {
        if (empty($service_msg)) {
            $service_msg = "Smart offer custom setting available for <strong>Used VDP</strong>";
        } else {
            $service_msg .= " , <strong>Used VDP</strong>";
        }
    }

    if (isset($cron_config['lead']['service'])) {
        if (empty($service_msg)) {
            $service_msg = "Smart offer custom setting available for <strong> Service VDP </strong>";
        } else {
            $service_msg .= " , <strong>Service VDP</strong>";
        }
    }

    if (empty($service_msg)) {
        $service_msg = "One Smart offer setting for all";
    }
}

$cron_configLead = [];

if (!$lead_configured) {
    $cron_configLead = $new_lead_arr;
    $service_msg     = "No Smart offer setting available";
} else {
    if (isset($cron_config['lead']['new']) && $smart_offer_for == 'new') {
        $alead_config = $cron_config['lead']['new'];
    } else if (isset($cron_config['lead']['used']) && $smart_offer_for == 'used') {
        $alead_config = $cron_config['lead']['used'];
    } else if (isset($cron_config['lead']['service']) && $smart_offer_for == 'service') {
        $alead_config = $cron_config['lead']['service'];
    } else {
        $alead_config = $cron_config['lead'];
        $diff_config  = true;
    }

    foreach ($new_lead_arr as $lead_key => $default_value) {
        $cron_configLead[$lead_key] = isset($alead_config[$lead_key]) ? $alead_config[$lead_key] : $default_value;
    }
}

$msg .= "<br> * Previously " . $service_msg;

if (count($cron_configLead['lead_in']) == 0 && isset($scrapper_configs[$cron_name])) {
    $cron_configLead['lead_in'] = [
        'vdp'     => $scrapper_configs[$cron_name]['vdp_url_regex'] ? $scrapper_configs[$cron_name]['vdp_url_regex'] : '',
        'service_regex' => '',
    ];
}

// Define which item you want ot show or not
$boolian_element       = ['shown_cap', 'fillup_cap', 'session_close', 'video_smart_offer', 'video_smart_offer_form', 'inactivity', 'exit_intent', 'session_depth', 'campaign_cap_google', 'campaign_cap_fb'];
$string_elements_color = ['bg_color', 'text_color', 'border_color', 'button_text_color'];
$string_elements_video = ['video_url', 'video_title', 'video_description'];
$errors                = ['video_url' => '(Input a valid youtube url)', 'video_title' => "(Max 50 characters)", 'video_description' => "(Max 750 characters)"];
$typearr_color         = ['button_color', 'button_color_hover', 'button_color_active'];
$typearr_email         = ['forward_to', 'special_to'];
$number_element        = ['offer_minimum_price', 'offer_maximum_price', 'display_after', 'retarget_after', 'fb_retarget_after', 'adword_retarget_after', 'visit_count', 'shown_cap_count', 'fillup_cap_time_days', 'session_close_timeout', 'session_cap_count', 'session_depth_page', 'inactivity_timeout', 'exit_intent_timeout', 'campaign_google_cap_count', 'campaign_google_cap_days', 'campaign_fb_cap_count', 'campaign_fb_cap_days'];
$typearr_associatives  = [
    'device_type' => ['mobile', 'desktop', 'tablet'],
    'lead_in' => ['vdp', 'service_regex']
];

$config_file_name = get_config_path($cron_name);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-smart-offer-config')) {
    $lead_arr = [];

    $cron_configLead['response_email_subject'] = $_POST['response_email_subject'];
    $cron_configLead['response_email']         = $_POST['response_email'];
    $cron_configLead['custom_div']             = trim($_POST['custom_div']);
    $cron_configLead['source']                 = $_POST['source'];
    $cron_configLead['provider_name']          = $_POST['provider_name'];
    $cron_configLead['button_text']            = $_POST['button_text'];
    $cron_configLead['display_after']          = (int) $_POST['display_after'] * 1000;
    $cron_configLead['retarget_after']         = (int) $_POST['retarget_after'] * 1000;
    $cron_configLead['fb_retarget_after']      = (int) $_POST['fb_retarget_after'] * 1000;
    $cron_configLead['adword_retarget_after']  = (int) $_POST['adword_retarget_after'] * 1000;
    $cron_configLead['inactivity_timeout']     = (int) $_POST['inactivity_timeout'] * 1000;
    $cron_configLead['exit_intent_timeout']    = (int) $_POST['exit_intent_timeout'] * 1000;
    $cron_configLead['visit_count']            = (int) $_POST['visit_count'];
    $cron_configLead['offer_minimum_price']    = (int) $_POST['offer_minimum_price'];
    $cron_configLead['offer_maximum_price']    = (int) $_POST['offer_maximum_price'];

    if (isset($alead_config['provider_name'])) {
        $cron_configLead['provider_name'] = $alead_config['provider_name'];
    }

    $cron_configLead['response_email_subject'] = $_POST['response_email_subject'];

    foreach ($cron_configLead as $lead_key => $lead_value) {
        $type = gettype($lead_value);

        if ($type == 'boolean') {
            $lead_arr[$lead_key] = filter_input(INPUT_POST, $lead_key) ? true : false;
        } elseif ($type == 'array' && array_key_exists($lead_key, $typearr_associatives)) {
            $submittedValues = $_POST[$lead_key];

            foreach ($typearr_associatives[$lead_key] as $item) {
                if (isset($submittedValues[$item])) {
                    $lead_arr[$lead_key][$item] = ($lead_key == 'device_type') ? ($submittedValues[$item] ? true : false) : $submittedValues[$item];
                } else {
                    $lead_arr[$lead_key][$item] = ($lead_key == 'device_type') ? false : '';
                }
            }
        } elseif ($type == 'string' && in_array($lead_key, $string_elements_color)) {
            $lead_arr[$lead_key] = '#' . filter_input(INPUT_POST, $lead_key);
        } elseif ($type == 'string' && in_array($lead_key, $string_elements_video)) {
            $string_value = filter_input(INPUT_POST, $lead_key);
            $lead_arr[$lead_key] = $string_value;
        } elseif ($type == 'array' && in_array($lead_key, $typearr_color)) {
            $color_values = $_POST[$lead_key];
            $colors       = [];

            for ($ci = 0, $cvc = count($color_values); $ci < $cvc; $ci++) {
                $colors[] = '#' . $color_values[$ci];
            }

            $lead_arr[$lead_key] = $colors;
        } elseif ($type == 'array' && in_array($lead_key, $typearr_email)) {
            $lead_arr[$lead_key] = explode(',', $_POST[$lead_key]);
        } else {
            $lead_arr[$lead_key] = $lead_value;
        }
    }

    // Parser & traverser
    $configFile = s3DealerConfig($cron_name);
    $so_parser  = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

    try {
        $so_ast = $so_parser->parse($configFile);
    } catch (Error $error) {
        echo 'Error Parse';
        print_r($error->getMessage());
        return;
    }

    $so_traverser = new NodeTraverser();

    if ($smart_offer_for == 'new') {
        $newlead = ['lead', 'new'];

        if (isset($cron_config['lead']['new'])) {
            $so_traverser->addVisitor(new configUpdater([
                'key'   => $newlead,
                'value' => $lead_arr,
            ]));
        } else {
            $new_lead['new'] = $lead_arr;

            if (isset($cron_config['lead'])) {
                if (isset($cron_config['lead']['used'])) {
                    $new_lead['used'] = $cron_config['lead']['used'];
                }

                if (isset($cron_config['lead']['service'])) {
                    $new_lead['service'] = $cron_config['lead']['service'];
                }

                $so_traverser->addVisitor(new configUpdater([
                    'key'   => ['lead'],
                    'value' => $new_lead,
                ]));
            } else {
                $so_traverser->addVisitor(new configCreator('lead', $new_lead));
            }
        }

        $cron_config['lead']['new'] = $lead_arr;
        $url .= '&for=new';
    } else if ($smart_offer_for == 'used') {
        $usedlead = ['lead', 'used'];

        if (isset($cron_config['lead']['used'])) {
            $so_traverser->addVisitor(new configUpdater([
                'key'   => $usedlead,
                'value' => $lead_arr,
            ]));
        } else {
            $used_lead['used'] = $lead_arr;

            if (isset($cron_config['lead'])) {
                if (isset($cron_config['lead']['new'])) {
                    $used_lead['new'] = $cron_config['lead']['new'];
                }

                if (isset($cron_config['lead']['service'])) {
                    $used_lead['service'] = $cron_config['lead']['service'];
                }

                $so_traverser->addVisitor(new configUpdater([
                    'key'   => ['lead'],
                    'value' => $used_lead,
                ]));
            } else {
                $so_traverser->addVisitor(new configCreator('lead', $used_lead));
            }
        }

        $cron_config['lead']['used'] = $lead_arr;
        $url .= '&for=used';
    } else if ($smart_offer_for == 'service') {
        $servicelead = ['lead', 'service'];

        if (isset($cron_config['lead']['service'])) {
            $so_traverser->addVisitor(new configUpdater([
                'key'   => $servicelead,
                'value' => $lead_arr,
            ]));
        } else {
            $service_lead['service'] = $lead_arr;

            if (isset($cron_config['lead'])) {
                if (isset($cron_config['lead']['new'])) {
                    $service_lead['new'] = $cron_config['lead']['new'];
                }

                if (isset($cron_config['lead']['used'])) {
                    $service_lead['used'] = $cron_config['lead']['used'];
                }

                $so_traverser->addVisitor(new configUpdater([
                    'key'   => ['lead'],
                    'value' => $service_lead,
                ]));
            } else {
                $so_traverser->addVisitor(new configCreator('lead', $service_lead));
            }
        }

        $cron_config['lead']['service'] = $lead_arr;
        $url .= '&for=service';
    } else {
        $defaultlead = ['lead'];

        if (isset($cron_config['lead'])) {
            $so_traverser->addVisitor(new configUpdater([
                'key'   => $defaultlead,
                'value' => $lead_arr,
            ]));
        } else {
            $so_traverser->addVisitor(new configCreator('lead', $lead_arr));
        }

        $cron_config['lead'] = $lead_arr;
    }

    // Update Configs
    configsUpdate($cron_config, $cron_name);

    try {
        $so_ast              = $so_traverser->traverse($so_ast);
        $prettyPrinter       = new ePrinter();
        $config_file_content = $prettyPrinter->prettyPrintFile($so_ast);
    } catch (Error $error) {
        echo 'Error in traverse';
    }

    // Update s3 dealer config
    s3Update($config_file_content, $cron_name);

    // Log added start
    $status = $lead_arr[['live']] ? 'ON' : 'OFF';
    $db_connect->store_log($user_id, $user['type'], "Smart offer {$status}", "Dealer smart offer change where dealer name- {$cron_name}. And smart offer status is {$status}", $cron_name);
    // Log added end

    // Refresh page after updation
    echo("<script type='text/javascript'> location.href = location.href; </script>");
}

$template_directory = ADSYNCPATH . "templates/{$cron_name}/";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-smart-offer-image')) {
    $key = ['new', 'used', 'service'];

    foreach ($key as $lead_type) {
        if ($smart_offer_for == "default" || $smart_offer_for == $lead_type) {
            $file      = $lead_type . '_smartoffer_file';
            $file_name = isset($_FILES[$file]) ? $_FILES[$file] : '';

            if (isset($file_name['tmp_name']) && !empty($file_name['tmp_name'])) {
                $type       = $file_name['type'];
                $temp_dir   = $file_name['tmp_name'];
                $target_dir = $template_directory . $lead_type . '-popup-bg.png';

                if ($type == 'image/png') {
                    move_uploaded_file($temp_dir, $target_dir);
                }
            }
        }

        // Log added start
        DbConnect::store_log($user_id, $user['type'], 'Dealer smart offer image uploaded', 'Dealer smart offer image uploaded where dealer name- ' . $cron_name, $cron_name);
        // Log added end
    }
}
?>

<div class="row form-group-row clearfix">
    <form method="GET" class="form-inline">
        <input type="hidden" name="dealership" value="<?= $cron_name ?>">
        <label class="  mb-2 mr-sm-2 mb-sm-0 ml-md"> Select Smart offer </label>
        &nbsp; &nbsp;
        <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="for" data-plugin-selectTwo onchange="(function(e){e.target.closest('form').submit()})(event)" style="width: 200px !important;">
            <option value="default" <?= 'default' == $smart_offer_for ? 'selected' : ' ' ?>>Default (All)</option>
            <option value="new" <?= 'new' == $smart_offer_for ? 'selected' : ' ' ?>>New</option>
            <option value="used" <?= 'used' == $smart_offer_for ? 'selected' : ' ' ?>>Used</option>
            <option value="service" <?= 'service' == $smart_offer_for ? 'selected' : ' ' ?>>Service</option>
        </select>

        <label class="mb-8 mr-sm-8 mb-sm-0 ml-md"> <?= $service_msg ?> </label>
    </form>
</div>

<form method="POST" class="form-bordered" enctype="multipart/form-data" action="?dealership=<?= $cron_name ?>&for=<?= $smart_offer_for ?> ">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <div class="checkbox-custom chekbox-primary" title="<?= $popover_texts['live'] ?>">
                    <input type="checkbox" name="live" value="1" <?= $cron_configLead['live'] ? 'checked' : '' ?>>
                    <label for="live">Live</label>
                </div>
            </div>
        </div>
        <?php
        if ($smart_offer_for != 'service') {
        ?>
            <div class="col-md-2">
                <div class="form-group">
                    <div class="checkbox-custom chekbox-primary" title="<?= $popover_texts['lead_type_'] ?>">
                        <input type="checkbox" name="lead_type_" value="1" <?= $cron_configLead['lead_type_'] ? 'checked' : '' ?>>
                        <label for="lead_type_">Lead Type</label>
                    </div>
                </div>
            </div>
            <?php
            if ($smart_offer_for == 'new' || $smart_offer_for == 'default') {
            ?>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="checkbox-custom chekbox-primary" title="<?= $popover_texts['lead_type_new'] ?>">
                            <input type="checkbox" name="lead_type_new" value="1" <?= $cron_configLead['lead_type_new'] ? 'checked' : '' ?>>
                            <label for="lead_type_new">Lead Type New</label>
                        </div>
                    </div>
                </div>
            <?php
            }
            if ($smart_offer_for == 'used' || $smart_offer_for == 'default') {
            ?>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="checkbox-custom chekbox-primary" title="<?= $popover_texts['lead_type_used'] ?>">
                            <input type="checkbox" name="lead_type_used" value="1" <?= $cron_configLead['lead_type_used'] ? 'checked' : '' ?>>
                            <label for="lead_type_used">Lead Type Used</label>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
        if ($smart_offer_for == 'service' || $smart_offer_for == 'default') {
            ?>
            <div class="col-md-3 ">
                <div class="form-group">
                    <div class="checkbox-custom chekbox-primary" title="<?= $popover_texts['lead_type_service'] ?>">
                        <input type="checkbox" name="lead_type_service" value="1" <?= $cron_configLead['lead_type_service'] ? 'checked' : '' ?>>
                        <label for="lead_type_service">Lead Type Service</label>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="row form-group-row">
        <?php
        foreach ($boolian_element as $item) {
        ?>
            <div class=" <?= ($item == 'video_smart_offer') || ($item == 'video_smart_offer_form') ? 'col-md-3 mt-md' : 'col-md-2 mt-md' ?>">
                <div class="form-group">
                    <div class="checkbox-custom chekbox-primary" title="<?= $popover_texts[$item] ?>">
                        <input type="checkbox" name="<?= $item ?>" value="1" <?= $cron_configLead[$item] ? 'checked' : '' ?>>
                        <label for="<?= $item ?>"><?= ucwords(str_replace('_', ' ', $item)) ?></label>
                    </div>
                </div>
            </div>
        <?php
        }
        foreach ($cron_configLead['device_type'] as $device_type => $value) {
        ?>
            <div class="col-md-2 mt-md">
                <div class="form-group">
                    <div class="checkbox-custom chekbox-primary" title="<?= $popover_texts[$device_type] ?>">
                        <input type="checkbox" name="device_type[<?= $device_type ?>]" value="1" <?= $value ? 'checked' : '' ?>>
                        <label for="<?= $device_type ?>"><?= ucwords(str_replace('_', ' ', $device_type)) ?></label>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="col-md-3 mt-md">
            <div class="form-group">
                <div class="checkbox-custom chekbox-primary" title="<?= $popover_texts['sent_client_email'] ?>">
                    <input type="checkbox" name="sent_client_email" value="1" <?= $cron_configLead['sent_client_email'] ? 'checked' : '' ?>>
                    <label for="sent_client_email">Send Client Email</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php
        foreach ($string_elements_color as $item) {
        ?>
            <div class="col-md-6 mt-md">
                <div class="form-group">
                    <label class="col-md-4 control-label"><?= ucwords(str_replace('_', ' ', $item)) ?></label>
                    <div class="col-md-8">
                        <input type="text" name="<?= $item ?>" class="form-control jscolor" value="<?= $cron_configLead[$item] ?>">
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="row form-group-row">
        <?php
        foreach ($typearr_color as $item) {
        ?>
            <div class="col-md-6 mt-md">
                <div class="form-group">
                    <label class="col-md-4 control-label"><?= ucwords(str_replace('_', ' ', $item)) ?></label>
                    <?php for ($ci = 0, $itemLen = count($cron_configLead[$item]); $ci < $itemLen; $ci++) { ?>
                        <div class="col-md-4">
                            <input type="text" name="<?= $item ?>[]" class="form-control jscolor" value="<?= $cron_configLead[$item][$ci] ?>">
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="row form-group-row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">Response Email Subject</label>
                <div class="col-md-7" style="padding: 0">
                    <textarea class="form-control" cols="35" rows="6" name="response_email_subject"><?= $cron_configLead['response_email_subject'] ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-5 control-label">Response Email</label>
                <div class="col-md-7" style="padding: 0">
                    <textarea class="form-control" cols="35" rows="6" name="response_email"><?= $cron_configLead['response_email'] ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group-row" style="margin-bottom: 0px">
        <?php
        foreach ($typearr_email as $item) {
        ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-5 control-label"> <?= ucwords(str_replace('_', ' ', $item)) . " (" . ($item == 'special_to' ? "ADF" : "Normal") . ")" ?> </label>
                    <div class="col-md-7" style="padding: 0">
                        <textarea class="form-control" cols="35" rows="6" name="<?= $item ?>"><?= implode(",", $cron_configLead[$item]) ?></textarea>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="row form-group-row" style="margin-bottom: 0">
        <?php
        foreach ($number_element as $item) {
        ?>
            <div class="col-md-6 mt-md">
                <div class="form-group">
                    <label class="col-md-5 control-label"><?= ucwords(str_replace('_', ' ', $item)) ?></label>
                    <div class="col-md-7" style="padding: 0">
                        <input type="number" min="0" max="10000000" step="1" name="<?= $item ?>" class="form-control" value="<?= ($cron_configLead[$item] / (!in_array($item, ['display_after', 'retarget_after', 'fb_retarget_after', 'adword_retarget_after', 'inactivity_timeout', 'exit_intent_timeout']) ? 1 : 1000)) ?>">
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="row form-group-row">
        <div class="col-md-6 mt-md">
            <div class="form-group">
                <label class="col-md-5 control-label">Provider Name</label>
                <div class="col-md-7" style="padding: 0">
                    <input type="text" name="provider_name" class="form-control" value="<?= $cron_configLead['provider_name'] ?>">
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-md">
            <div class="form-group">
                <label class="col-md-5 control-label">Source</label>
                <div class="col-md-7" style="padding: 0">
                    <input type="text" name="source" class="form-control" value="<?= $cron_configLead['source'] ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group-row">
        <div class="col-md-6 mt-md">
            <div class="form-group">
                <label class="col-md-5 control-label">Custom Div</label>
                <div class="col-md-7" style="padding: 0">
                    <textarea class="form-control" cols="35" rows="6" name="custom_div">
                        <?= $cron_configLead['custom_div'] ?>
                    </textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-md">
            <div class="form-group">
                <label class="col-md-5 control-label">Submit Button Text</label>
                <div class="col-md-7" style="padding: 0">
                    <input type="text" name="button_text" class="form-control" value="<?= $cron_configLead['button_text'] ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group-row">
        <div class="col-md-6 mt-md">
            <h4>Only for video smart offer</h4>
        </div>
    </div>

    <div class="row form-group-row">
        <?php
        foreach ($string_elements_video as $item) {
        ?>
            <div class="col-md-6 mt-md">
                <div class="form-group">
                    <label class="col-md-4 control-label"><?= ucwords(str_replace('_', ' ', $item)) . " " . $errors[$item] ?></label>
                    <div class="col-md-8">
                        <?php if ($item != 'video_description') { ?>
                            <input type="text" name="<?= $item ?>" class="form-control" value="<?= $cron_configLead[$item] ?>">
                        <?php } else { ?>
                            <textarea name="<?= $item ?>" class="form-control"><?= $cron_configLead[$item] ?></textarea>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="row form-group-row">
        <?php
        if ($smart_offer_for == 'default') {
            foreach ($cron_configLead['lead_in'] as $lead => $regex) {
        ?>
                <div class="col-md-12 mt-md">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Regex for '<?= str_replace(['_', 'regex'], [' ', 'page'], $lead) ?>'</label>
                        <div class="col-md-6 ml-lg">
                            <input type="text" name="lead_in[<?= $lead ?>]" class="form-control" value="<?= $regex ?>">
                        </div>
                    </div>
                </div>
            <?php
            }
        } else if ($smart_offer_for == 'service') {
            ?>
            <div class="col-md-12 mt-md">
                <div class="form-group">
                    <label class="col-md-2 control-label">Regex for service</label>
                    <div class="col-md-6 ml-lg">
                        <input type="text" name="lead_in[service_regex]" class="form-control" value="<?= $cron_configLead['lead_in']['service_regex'] ?>">
                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="col-md-12 mt-md">
                <div class="form-group">
                    <label class="col-md-2 control-label">Regex for vdp</label>
                    <div class="col-md-6 ml-lg">
                        <input type="text" name="lead_in[vdp]" class="form-control" value="<?= $cron_configLead['lead_in']['vdp'] ?>">
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="col-md-12 mt-sm">
            <div class="form-group">
                <button type="button" class="btn btn-primary pull-right" id="smart-offer-save">Save Changes </button>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel"><strong>Heads up!</strong></h3>
                </div>
                <div class="modal-body">
                    <?= $msg ?>
                    <br><br>
                    <h4><strong>Do you want to proceed?</strong></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button name="btn" value="save-smart-offer-config" class="btn btn-primary pull-right">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group-row clearfix">
        <?php
        $key = ['new', 'used', 'service'];
        foreach ($key as $lead_type) {
            if ($smart_offer_for == "default" || $smart_offer_for == $lead_type) {
				$vdp_url = $db_connect->GetVdpUrl($cron_name,$lead_type);
				if($vdp_url){
					if (strpos($vdp_url, '?') !== false) {
						$vdp_url .="&smart_offer_debug=true";
					} else {
						$vdp_url .="?smart_offer_debug=true";
					}
				}
                if (file_exists($template_directory . $lead_type . '-popup-bg.png')) {
                    $template_filename = '../adwords3/templates/' . $cron_name . '/' . $lead_type . '-popup-bg.png';
                } else {
                    $template_filename = '../adwords3/templates/' . $cron_name . '/popup-bg.png';
                }
        ?>
                <div class="col-md-12 mt-xl">
                    <label class="col-md-3 control-label" for="inputDefault"> <?= ucwords($lead_type) ?> File</label>

                    <div class="col-md-4">
                        <div class="thumbnail-gallery">
                            <a class="img-thumbnail lightbox" href="<?= $template_filename ?>" data-plugin-options="{ &quot;type&quot;:&quot;image&quot; }">
                                <img class="img-responsive" width="215" src="<?= $template_filename ?>">
                            </a>
                        </div>
                    </div>

					<div class="col-md-3">
						<input type="file" name="<?= $lead_type ?>_smartoffer_file" class="form-control" accept="image/x-png">
					</div>

					<div class="col-md-2">
						<?php
						if($vdp_url){
							?>
							<a href="<?= $vdp_url ?> " class="btn btn-info" target="_blank">Preview</a>
							<?php
						}
						?>

					</div>
                </div>
        <?php
            }
        }
        ?>
        <div class="col-md-4 mt-xl">
            <div class="form-group">
                <button name="btn" value="save-smart-offer-image" class="btn btn-primary pull-right"> Upload Files</button>
            </div>
        </div>
    </div>
</form>
