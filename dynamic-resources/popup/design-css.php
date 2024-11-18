<?php

header('Content-type: text/css; charset=UTF-8');

$adwords_dir = dirname(dirname(__DIR__)) . "/adwords3/";

require_once $adwords_dir . 'config.php';
require_once __DIR__ . '/popup.php';

global $CronConfigs;

$cron_name      = filter_input(INPUT_GET, 'dealership');
$stock_type     = filter_input(INPUT_GET, 'stock_type');
$year           = filter_input(INPUT_GET, 'year');
$make           = filter_input(INPUT_GET, 'make');
$model           = filter_input(INPUT_GET, 'model');
$cron_config    = isset($CronConfigs[$cron_name])?$CronConfigs[$cron_name]:null;

if(!$cron_config) { die("/* No Such Dealership */"); }

$dir = $adwords_dir . "templates/$cron_name/";
$file_name = '';

if(check_popup_file($dir, populate_popup_files(strtolower($stock_type), $year,strtolower($make),strtolower($model)), $file_name)) {
    $bg_file_url = "https://tm.smedia.ca/adwords3/templates/$cron_name/$file_name";
}

$alead_config = isset($cron_config['lead'][$stock_type])?$cron_config['lead'][$stock_type]:(isset($cron_config['lead'])?$cron_config['lead']:array());

$default = array(
    'bg_color'              => "#efefef",
    'text_color'            => "#404450",
    'border_color'          => "#e5e5e5",
    'button_color'          => array("#bd0000", "#800000"),
    'button_color_hover'    => array("#b00000", "#700000"),
    'button_color_active'   => array("#700000", "#b00000"),
    'button_text_color'     => "#ffffff"
);

$padding_bottom = $cron_name == 'autoparkbarrie' ? '40px' : '0px';

$lead_config = array_merge($default, $alead_config);

if(!is_array($lead_config['button_color'])) { $lead_config['button_color'] = array($lead_config['button_color']); }
if(!is_array($lead_config['button_color_hover'])) { $lead_config['button_color_hover'] = array($lead_config['button_color_hover']); }
if(!is_array($lead_config['button_color_active'])) { $lead_config['button_color_active'] = array($lead_config['button_color_active']); }
$sm_row_margin = (isset($lead_config['dropdown_values']) && count($lead_config['dropdown_values'])) ? '4px' : '15px';
$sm_row_margin = (isset($lead_config['extra_text']) && strlen($lead_config['extra_text'])) ? '2px' : '15px';

?>
/*
 * Popup Design CSS for
 ******************************************************************************/
#smedia-overlay {
    position:fixed;
    width:100%;
    height:100%;
    top: 0px;
    left: 0px;
    display: none;
    z-index: 4999999999;
    background: #000000;
    display: none;
    opacity: 0.5;
}

.sm-lead-collect-form {
    position:fixed;
    font-family: Arial;
    font-size: 18px;
    background-color: <?php echo $lead_config['bg_color'] ?>;
    width: 900px;
    height: auto;
    top: 50%;
    left: 50%;
    margin-left: -450px;
    margin-top: -225px;
    display:none;
    z-index: 5000000000;
    max-height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
}

.sm-lead-collect-form-image {
    width: 499px;
    height: 450px;
    background-image: url('<?php echo $bg_file_url ?>');
    background-repeat: no-repeat;
    background-position: center center;
    float: left;
}

.sm-lead-collect-form-body {
    width: 401px;
    height: 450px;
    float: left;
    overflow: hidden;
}

.sm-lead-collect-form-body form {
    margin: 27px !important;
    width:87% !important;
}

.sm-row {
    margin: <?= $sm_row_margin ?>  0px;
}

.sm-lead-collect-form-body form input,
.sm-lead-collect-form-body form select,
.sm-lead-collect-form-body form button,
.sm-lead-collect-form-body form label {
    width: 100%;
    display: inline-block;
    font-weight: bold;
    height: auto !important;
}

.sm-lead-collect-form-body form label {
    font-size: 16px;
    color: <?php echo $lead_config['text_color'] ?>;
    margin: 0 !important;
    padding: 0 !important;
}

.sm-lead-collect-form-body form input,
.sm-lead-collect-form-body form select{
    width: 98%;
    padding: 0px 1%;
    line-height: 36px !important;
    margin: 10px 0px;
    border: solid <?php echo $lead_config['border_color'] ?> 2px;
    color: <?php echo $lead_config['text_color'] ?>;
    background-color: #ffffff;
}

.sm-lead-collect-form-body form select{
    padding: 12px;
 }

.sm-lead-submit-btn {
    background: <?php echo $lead_config['button_color'][0] ?>;
<?php if(count($lead_config['button_color']) > 1): ?>
    background-image: -webkit-linear-gradient(top, <?php echo $lead_config['button_color'][0] ?>, <?php echo $lead_config['button_color'][1] ?>);
    background-image: -moz-linear-gradient(top, <?php echo $lead_config['button_color'][0] ?>, <?php echo $lead_config['button_color'][1] ?>);
    background-image: -ms-linear-gradient(top, <?php echo $lead_config['button_color'][0] ?>, <?php echo $lead_config['button_color'][1] ?>);
    background-image: -o-linear-gradient(top, <?php echo $lead_config['button_color'][0] ?>, <?php echo $lead_config['button_color'][1] ?>);
    background-image: linear-gradient(to bottom, <?php echo $lead_config['button_color'][0] ?>, <?php echo $lead_config['button_color'][1] ?>);
<?php endif; ?>
    color: <?php echo $lead_config['button_text_color'] ?>;
    border: solid <?php echo $lead_config['border_color'] ?> 2px;
    text-decoration: none;
    line-height: 36px !important;
    display: inline-block;
    text-align: center;
    cursor: pointer;
    margin-top: 15px;
}

.sm-lead-submit-btn:hover {
    background: <?php echo $lead_config['button_color_hover'][0] ?>;
<?php if(count($lead_config['button_color_hover']) > 1): ?>
    background-image: -webkit-linear-gradient(top, <?php echo $lead_config['button_color_hover'][0] ?>, <?php echo $lead_config['button_color_hover'][1] ?>);
    background-image: -moz-linear-gradient(top, <?php echo $lead_config['button_color_hover'][0] ?>, <?php echo $lead_config['button_color_hover'][1] ?>);
    background-image: -ms-linear-gradient(top, <?php echo $lead_config['button_color_hover'][0] ?>, <?php echo $lead_config['button_color_hover'][1] ?>);
    background-image: -o-linear-gradient(top, <?php echo $lead_config['button_color_hover'][0] ?>, <?php echo $lead_config['button_color_hover'][1] ?>);
    background-image: linear-gradient(to bottom, <?php echo $lead_config['button_color_hover'][0] ?>, <?php echo $lead_config['button_color_hover'][1] ?>);
<?php endif; ?>
    text-decoration: none;
}

.sm-lead-submit-btn:active {
    background: <?php echo $lead_config['button_color_active'][0] ?>;
<?php if(count($lead_config['button_color_active']) > 1): ?>
    background-image: -webkit-linear-gradient(top, <?php echo $lead_config['button_color_active'][0] ?>, <?php echo $lead_config['button_color_active'][1] ?>);
    background-image: -moz-linear-gradient(top, <?php echo $lead_config['button_color_active'][0] ?>, <?php echo $lead_config['button_color_active'][1] ?>);
    background-image: -ms-linear-gradient(top, <?php echo $lead_config['button_color_active'][0] ?>, <?php echo $lead_config['button_color_active'][1] ?>);
    background-image: -o-linear-gradient(top, <?php echo $lead_config['button_color_active'][0] ?>, <?php echo $lead_config['button_color_active'][1] ?>);
    background-image: linear-gradient(to bottom, <?php echo $lead_config['button_color_active'][0] ?>, <?php echo $lead_config['button_color_active'][1] ?>);
<?php endif; ?>
    text-decoration: none;
}

.sm-lead-submit-btn:disabled {
    background: <?php echo $lead_config['button_color_hover'][0] ?>;
<?php if(count($lead_config['button_color_hover']) > 1): ?>
    background-image: -webkit-linear-gradient(top, <?php echo $lead_config['button_color_hover'][0] ?>, <?php echo $lead_config['button_color_hover'][1] ?>);
    background-image: -moz-linear-gradient(top, <?php echo $lead_config['button_color_hover'][0] ?>, <?php echo $lead_config['button_color_hover'][1] ?>);
    background-image: -ms-linear-gradient(top, <?php echo $lead_config['button_color_hover'][0] ?>, <?php echo $lead_config['button_color_hover'][1] ?>);
    background-image: -o-linear-gradient(top, <?php echo $lead_config['button_color_hover'][0] ?>, <?php echo $lead_config['button_color_hover'][1] ?>);
    background-image: linear-gradient(to bottom, <?php echo $lead_config['button_color_hover'][0] ?>, <?php echo $lead_config['button_color_hover'][1] ?>);
<?php endif; ?>
    text-decoration: none;
}

.sm-close-btn {
    width: 24px;
    height: 24px;
    border: none;
    margin: 0px 15px;
    background: url('https://tm.smedia.ca/adwords3/templates/close_wb.png');
    background-repeat: no-repeat;
    background-position: center center;
    cursor: pointer;
    position: absolute !important ;
    right: 0px;
}

.sm-loading-spinner {
    width: 36px;
    height: 36px;
    margin: -10px auto;
    display: none;
}

@media screen and (max-height: 450px) {
    .sm-lead-collect-form
    {
        top: 0px;
        margin-top: 0px;
    }
}

@media screen and (min-width: 450px) and (max-width: 767px) {
    .sm-lead-collect-form
    {
        width: 499px;
        height: auto;
        margin-left: -250px;
    }

    .sm-lead-collect-form-image
    {
        float: none;
    }

    .sm-lead-collect-form-body
    {
        float: none;
        margin: 0px auto;
        height: auto;
    }

    #sm-close-btn
    {
        margin-top: -450px;
    }

    @media screen and (max-height: 900px) {
        .sm-lead-collect-form
        {
            top: 0px;
            margin-top: 0px;
        }
    }
}

@media screen and (min-width: 768px) and (max-width: 900px) {
    .sm-lead-collect-form
    {
        width: 499px;
        height: auto;
        margin-left: -250px;
    }

    .sm-lead-collect-form-image
    {
        float: none;
    }

    .sm-lead-collect-form-body
    {
        float: none;
        margin: 0px auto;
        height: auto;
    }

    #sm-close-btn
    {
        margin-top: -450px;
    }

    @media screen and (max-height: 1024px) {
        .sm-lead-collect-form
        {
            top: 0px;
            margin-top: 50px;
        }
    }
}

@media screen and (max-width: 449px) {
    .sm-lead-collect-form
    {
        width: 360px;
        height: auto;
        margin-left: -180px;
        padding-bottom: <?php echo $padding_bottom ?>;
    }

    .sm-lead-collect-form-image
    {
        width: 360px;
        height: 325px;
        background-size: 360px 325px;
        float: none;
    }

    .sm-lead-collect-form-body
    {
        width: 360px;
        float: none;
        margin: 0px auto;
        height: auto;
    }

    #sm-close-btn
    {
        margin-top: -330px;
    }

    @media screen and (max-height: 900px) {
        .sm-lead-collect-form
        {
            top: 0px;
            margin-top: 0px;
        }
    }
}
