<?php
header('Content-type: text/javascript; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$adwords_dir = dirname(dirname(__DIR__)) . "/adwords3/";
global $CronConfigs, $single_config;
$single_config = $cron_name = filter_input(INPUT_GET, 'dealership');

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'uuid.php';

use Detection\MobileDetect;

/* if (file_exists("/mnt/smedia-prod/data/tests/video-design-js.php")) {
    include('/mnt/smedia-prod/data/tests/video-design-js.php');
    exit();
} */

$detectDevice = new MobileDetect();

$cron_name   = filter_input(INPUT_GET, 'dealership');
$stock_type  = filter_input(INPUT_GET, 'stock_type');
$year        = filter_input(INPUT_GET, 'year');
$make        = filter_input(INPUT_GET, 'make');
$model       = filter_input(INPUT_GET, 'model');
$stock_no    = filter_input(INPUT_GET, 'stock_number');
$price       = filter_input(INPUT_GET, 'price');
$session_id  = filter_input(INPUT_GET, 'session_id');
$page_title  = htmlentities(isset($_GET['page_title']) ? filter_input(INPUT_GET, 'page_title') : '', ENT_QUOTES);

$cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;

$url = filter_input(INPUT_GET, 'ref', FILTER_SANITIZE_URL);
$smart_offer_debug = stripos($url, 'smart_offer_debug=true') !== false;

if (!$cron_config) {
    die("/* No Such Dealership */");
}

echo "\n/* smart offer debug: " . json_encode($smart_offer_debug) . " */\n";
echo "\n/* smart offer local*/\n";

$alead_config = isset($cron_config['lead'][$stock_type]) ? $cron_config['lead'][$stock_type] : (isset($cron_config['lead']['live']) ? $cron_config['lead'] : array());

if (!count($alead_config)) {
    echo "\n/* No Lead Config found for stock type : $stock_type */\n";
}

$default = [
    'live'              => false,
    'lead_type_'        => false,
    'lead_type_new'     => false,
    'lead_type_used'    => false,
    'lead_type_service' => false,
    'shown_cap'         => false,
    'fillup_cap'        => false,
    'session_close'     => false,
    'device_type' => array(
        'desktop' => true,
        'tablet'  => true,
        'mobile'  => true
    ),
    'offer_minimum_price'    => 0,
    'offer_maximum_price'    => 10000000,
    'bg_color'               => '#EFEFEF',
    'text_color'             => '#FFFFFF',
    'border_color'           => '#FFFFFF',
    'button_color'           => ['#FFFFFF', '#FFFFFF'],
    'button_color_hover'     => ['#FFFFFF', '#FFFFFF'],
    'button_color_active'    => ['#FFFFFF', '#FFFFFF'],
    'button_text_color'      => '#FFFFFF',
    'response_email_subject' => '',
    'response_email'         => '',
    'forward_to'             => [''],
    'special_to'             => [''],
    'special_email'          => '',
    'display_after'          => 30000,
    'retarget_after'         => 5000,
    'fb_retarget_after'      => 5000,
    'adword_retarget_after'  => 5000,
    'visit_count'            => 0,
    'video_smart_offer_form' => false,
    'lead_in'                => []
];

$lead_config = array_merge($default, $alead_config);

$smart_offer_live          = (isset($lead_config['live']) && $lead_config['live']) ? true                                    : false;
$show_for_mobile           = (isset($lead_config['device_type']['mobile'])) ? $lead_config['device_type']['mobile']          : true;
$show_for_desktop          = (isset($lead_config['device_type']['desktop'])) ? $lead_config['device_type']['desktop']        : true;
$show_for_tablet           = (isset($lead_config['device_type']['tablet'])) ? $lead_config['device_type']['tablet']          : true;
$session_close_value       = (isset($lead_config['session_close'])) ? $lead_config['session_close']                          : false;
$video_url                 = (isset($lead_config['video_url'])) ? $lead_config['video_url']                                  : null;
$video_description         = (isset($lead_config['video_description'])) ? $lead_config['video_description']                  : '';
$video_title               = (isset($lead_config['video_title'])) ? $lead_config['video_title']                              : '';
$video_smart_offer_form    = (isset($lead_config['video_smart_offer_form']) && $lead_config['video_smart_offer_form']) ? true: false;
$show_based_on_device_type = false;

echo "\n/* smart offer live: $smart_offer_live */\n";

if ($detectDevice->isMobile()) {
    if ($show_for_mobile) {
        $show_based_on_device_type = true;
    }
} elseif ($detectDevice->isTablet()) {
    if ($show_for_tablet) {
        $show_based_on_device_type = true;
    }
} else {
    if ($show_for_desktop) {
        $show_based_on_device_type = true;
    }
}

if (isset($lead_config['dropdown_values']) && sizeof($lead_config['dropdown_values']) > 0) {
    $locationValue = $lead_config['dropdown_values'];
} else {
    $locationValue = [];
}

$user_unique_id = filter_input(INPUT_GET, 'user_unique_id');
/*
 * If uuid not send or uuid is null/blank
 */
if (empty($user_unique_id) || is_null($user_unique_id) || $user_unique_id == 'null') {
    $user_unique_id = UUID::v4();
}


$display_after         = isset($lead_config['display_after']) ? $lead_config['display_after']                : 30000;
$retarget_after        = isset($lead_config['retarget_after']) ? $lead_config['retarget_after']              : 5000;
$fb_retarget_after     = isset($lead_config['fb_retarget_after']) ? $lead_config['fb_retarget_after']        : $retarget_after;
$adword_retarget_after = isset($lead_config['adword_retarget_after']) ? $lead_config['adword_retarget_after']: $retarget_after;
$config_visit_count    = isset($lead_config['visit_count']) ? $lead_config['visit_count']                    : 0;

# Show based on minimum price
$show_status_based_on_minimum_price = true;

if (isset($lead_config['offer_minimum_price'])) {
    $config_minimum_price = (int) preg_replace('/[^0-9]/', '', $lead_config['offer_minimum_price']);
    $current_price = (int) preg_replace('/[^0-9]/', '', $price);

    if ($current_price < $config_minimum_price) {
        $show_status_based_on_minimum_price = false;
    }
}

if (isset($lead_config['offer_maximum_price'])) {
    $config_minimum_price = (int) preg_replace('/[^0-9]/', '', $lead_config['offer_maximum_price']);
    $current_price = (int) preg_replace('/[^0-9]/', '', $price);

    if ($current_price > $config_minimum_price) {
        $show_status_based_on_minimum_price = false;
    }
}

$check_types = [$stock_type];

if ($stock_type == 'vdp') {
    $check_types[] = '';
}

$smart_offer_enabled = false;

foreach ($check_types as $check_type) {
    $smart_offer_enabled |= isset($lead_config["lead_type_{$check_type}"]) ? $lead_config["lead_type_{$check_type}"] : false;
}

if (!$smart_offer_enabled) {
    die('/* Offer Form is turned off */');
}

$shown = customer_get_views($user_unique_id, $cron_name);

if ($shown) {
    $shown = $shown['at'];
    while (count($shown) < 4) {
        $shown[] = 0;
    }
} else {
    $shown = array(0, 0, 0, 0);
}

$submitted_at = customer_get_fillups($user_unique_id, $cron_name);

if ($submitted_at) {
    $submitted_at = max($submitted_at['at']);
} else {
    $submitted_at = 0;
}

$shown_cap  = $lead_config['shown_cap'];
$fillup_cap = $lead_config['fillup_cap'];

$now = time();
#if submitted turn off for 7 days
$submitted = ($submitted_at > 0 && ($now - $submitted_at) < (7 * 24 * 60 * 60));
#Show twice in every 24 hours (Unless submitted)
$elapsed = $now - min($shown);
#
if (!$shown_cap) {
    $elapsed = 48 * 3600;
}   #If shown cap is disabled, make elapsed big so that cap is removed

if (!$fillup_cap) {
    $submitted = false;
}    #If fillup cap is disabled, set submitted to false

$to_show = ($elapsed > (24 * 60 * 60)) && (!$submitted);

# Based on user visit
$user_visit       = user_visit_get_count($user_unique_id, $cron_name);
$user_visit_count = $user_visit ? $user_visit['visit_count'] : 0;
$visit_status     = $config_visit_count > $user_visit_count ? false : true;

# Update user visit on each
update_user_visit($user_unique_id, $cron_name);

echo file_get_contents(dirname($adwords_dir) . "/dynamic-resources/popup-video/video.min.js");
echo file_get_contents(dirname($adwords_dir) . "/dynamic-resources/popup-video/Youtube.min.js");

?>
/*
* Popup JS for <?= $cron_name ?>
******************************************************************************/


function iOSversion() {
if (/iP(hone|od|ad)/.test(navigator.platform)) {
    var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
        return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];
    }
}

var iosVersion = iOSversion();
var noAutoplay = !!iosVersion && (iosVersion[0] <= 9); var noTranslate=!!iosVersion && (iosVersion[0] <=8); console.log('Smart Offer noAutoplay: ', noAutoplay);

var custom_font = ' https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@600&display=swap'; smedia_lead_popup_font=document.createElement('link') smedia_lead_popup_font.setAttribute("href", custom_font); smedia_lead_popup_font.setAttribute("rel", "stylesheet" ); smedia_lead_popup_font.setAttribute("type", "text/css" ); smedia_lead_popup_font.setAttribute("id", "video-popup-font" ); document.getElementsByTagName("head")[0].appendChild(smedia_lead_popup_font); smedia_lead_popup_design='https://tm.smedia.ca/popup-video/design.css?dealership=<?= urlencode($cron_name) ?>&stock_type=<?= urlencode($stock_type) ?>&year=<?= urlencode($year) ?>&make=<?= urlencode($make) ?>&model=<?= urlencode($model) ?>' ; smedia_lead_popup_design_style=document.createElement('link') smedia_lead_popup_design_style.setAttribute("href", smedia_lead_popup_design); smedia_lead_popup_design_style.setAttribute("rel", "stylesheet" ); smedia_lead_popup_design_style.setAttribute("type", "text/css" ); document.getElementsByTagName("head")[0].appendChild(smedia_lead_popup_design_style); var referrer=document.referrer; /* var locationValue=<?= json_encode(array_values($locationValue)); ?>; var smedia_form_html_content_middle='' ; if(locationValue.length> 0){
    var index, len, allOption = '<option value="">--Select--</option>\n';
    locationValue.forEach(function(element){
    allOption += '<option value="' + element + '">' + element + ' </option>\n';
    });
    var smedia_form_html_content_middle= '<div class="sm-row">\n' +
        '<label for="sm-name">Nearest Location</label>\n' +
        '<select class="form-control" name="nearest_location" id="nearest_location">\n' +
            allOption +
            '</select>' +
        '</div>\n';
    } */

    var video_width = document.body.clientWidth >= 640 ? 640 : document.body.clientWidth - (16*2);
    var video_height = video_width * (9/16);
    var lead_form_html = '';
    <?php if ($video_smart_offer_form) { ?>
        lead_form_html = '<div class="sm-lead-collect-form-body">\n' +
            '<div class="sm-lead-collect-form-video-title ibm-font">\n' + '<?= $video_title ?>' + '</div>\n' +
            '<div id="sm-form-container">\n' +
                '<form id="sm-lead-form" method="post" action="https://tm.smedia.ca/services/smart-offer-lead.php">\n' +
                    '<input type="hidden" name="act" value="submit" />\n' +
                    '<input type="hidden" name="dealership" value="<?= $cron_name ?>" />\n' +
                    '<input type="hidden" name="stock_type" value="<?= $stock_type ?>" />\n' +
                    '<input type="hidden" name="year" value="<?= $year ?>" />\n' +
                    '<input type="hidden" name="make" value="<?= $make ?>" />\n' +
                    '<input type="hidden" name="model" value="<?= $model ?>" />\n' +
                    '<input type="hidden" name="stock_number" value="<?= $stock_no ?>" />\n' +
                    '<input type="hidden" name="url" value="<?= $url ?>" />\n' +
                    '<input type="hidden" name="smedia_smart_lead_uuid" value="<?= $user_unique_id ?>" />\n' +
                    <!-- '<input type="hidden" name="page_title" value="<?=  $page_title ?>" />\n' + -->
                    '<input type="hidden" name="referrer" value="'+ referrer +'" />\n' +
                    '<div class="sm-row">\n' +
                        '<div class="sm-col ">\n' + '<input type="text" class="ibm-font" id="sm-name" name="name" value="" required placeholder="Name" />\n' + '</div>\n' +
                        '<div class="sm-col">\n' + '<input type="email" class="ibm-font" id="sm-email" name="email" value="" required placeholder="Email" />\n' + '</div>\n' +
                        '<div class="sm-col">\n' + '<input type="tel" class="ibm-font" id="sm-phone" name="phone" value="" required placeholder="Phone" />\n' + '</div>\n'+
                        // smedia_form_html_content_middle +
                        '<div class="sm-col">\n' + '<button class="sm-lead-submit-btn ibm-font">Submit</button>\n' + '</div>\n' +
                        '</div>\n' +
                    '</form>\n'
                '</div>\n' +
            '<div class="sm-row">\n' +
                '<div id="sm-loading-spinner" class="sm-loading-spinner">\n' + '<img src="https://tm.smedia.ca/adwords3/templates/balls.svg" />\n' + '</div>\n' +
                '</div>\n' +
            '</div>\n';
    <?php } ?>
    var smedia_popup_html = '<div id="smedia-overlay" style="display:none"></div>\n' +
    '<div id="smedia-lead-collect-form" class="sm-lead-collect-form" style="display:none">\n' +
        '<button class="sm-close-btn" id="sm-close-btn"></button>\n' +
        '<div class="sm-lead-collect-form-wrap">\n' +
            '<div class="form-<?= json_encode($video_smart_offer_form) ?>">' +
                '<div class="sm-lead-collect-form-video">\n' +
                    '<video id="sm-lead-video" class="video-js vjs-default-skin" autobuffer="true" controlslist="nodownload" autoplay muted controls width="'+video_width+'" height="'+video_height+'" data-setup=\'{ "techOrder" : ["youtube"], "sources" : [{ "type" : "video/youtube" , "src" : "<?= $video_url ?>" }], "youtube" : { "playsinline" : 1, "modestbranding" : 1, "autoplay" : 1 } }\'></video>\n' +
                    '<div class="sm-lead-collect-form-video-desc ibm-font">\n' + '<?= $video_description ?>' + '</div>\n' +
                    '</div>\n' +
                lead_form_html +
                '</div>\n' +
            '</div>\n' +
        '</div>';
    // >
    var smedia_temp_div = document.createElement('div');
    smedia_temp_div.innerHTML = smedia_popup_html;
    var smedia_form_elements = smedia_temp_div.childNodes;
    document.getElementsByTagName("body")[0].appendChild(smedia_form_elements[0]);
    document.getElementsByTagName("body")[0].appendChild(smedia_form_elements[1]);

    var sMedia = sMedia || {};

    function jQueryReady($) {

    sMedia.Lead = {
    form : null,
    initialized : false,
    closeTimeout : null,
    initialForm : null,
    uniqueUserId : '<?= $user_unique_id ?>',
    init : function() {
    $("#smedia-overlay").click(function(){sMedia.Lead.close();});
    $("#sm-close-btn").click(function(){sMedia.Lead.close();});
    $("#sm-lead-form").submit(function(e){
    e.preventDefault();
    sMedia.Lead.form = this;
    var form_data = $(this).serialize();
    var action = $(sMedia.Lead.form).prop("action");

    sMedia.Lead.disable(sMedia.Lead.form);

    $.ajax({
    type : "POST",
    url : action,
    data : form_data,
    crossDomain : true
    })
    .done(function(data, textStatus, jqXHR) {
    ga('smedia_analytics_tracker.send', {
    hitType: 'event',
    eventCategory: 'smart_offer_video',
    eventAction: 'lead',
    nonInteraction: true
    });
    if(data.response) {
    $("#sm-form-container").html(data.response);
    setTimeout("sMedia.Lead.close()", 3000);
    }
    else {
    alert(data.error);
    }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
    console.log('Smart Offer Submission Issue: ' + textStatus);
    console.log(jqXHR);
    sMedia.Lead.close();
    })
    .always(function() {
    sMedia.Lead.enable(sMedia.Lead.form);
    });
    });
    this.initialized = true;
    },
    delayClose : function() {
    if($("#sm-lead-form").serialize() !== sMedia.Lead.initialForm){
    if(sMedia.Lead.closeTimeout) clearTimeout(sMedia.Lead.closeTimeout);
    return;
    }
    sMedia.Lead.close();
    },
    show : function() {
    if(!this.initialized) this.init();
    console.log("Smart offer video show function call");
    // await document.fonts.load('16px "IBM Plex Sans Condensed"');
    if($("#smedia-lead-collect-form").hasClass('loaded')) return;
    $("#smedia-lead-collect-form").css("display", "block").css('left', -9999).addClass('loading');
    if(noTranslate){
    var ml = ($("#smedia-lead-collect-form").width()) / 2;
    var mt = ($("#smedia-lead-collect-form").height()) / 2;
    $("#smedia-lead-collect-form").css('margin-left', -ml).css('margin-top', -mt);
    }
    var player = videojs('sm-lead-video');
    window.smPlayer = player;
    if(noAutoplay) {
    console.log('Smart Offer ios detected');
    player.muted(false);
    player.pause();
    } else {
    player.muted(true);
    player.play();
    }
    console.log('Smart Offer: Waiting for for video to load');
    player.on('firstplay', function(){
    console.log('Smart offer video loaded');

    if(!noAutoplay){
    console.log('Smart offer triyng to unmute');
    player.muted(false);
    setTimeout(function() {
    if(player.paused()){
    console.log('Smart offer video unable to play with sound.');
    player.muted(true);
    player.play();
    }
    }, 500);
    }

    $("#smedia-lead-collect-form").css("display", "block").css('left', '50%').removeClass('loading').addClass('loaded');
    ga('smedia_analytics_tracker.send', {
    hitType: 'event',
    eventCategory: 'smart_offer_video',
    eventAction: 'shown',
    nonInteraction: true
    });
    $("#smedia-overlay").css("display", "block");
    $("#smedia-lead-collect-form").css("display", "block");
    sMedia.Lead.initialForm = ''; /* Avoid auto close by setting initial form to nothing */ //$("#sm-lead-form").serialize();
    // sMedia.Lead.closeTimeout = setTimeout("sMedia.Lead.delayClose()", 20000);
    $.ajax({
    type : "POST",
    url : $("#sm-lead-form").prop("action"),
    data : "act=shown&dealership=<?php echo $cron_name ?>&smedia_smart_lead_uuid=<?php echo $user_unique_id ?>",
    crossDomain : true
    })
    .done(function(data, textStatus, jqXHR) {
    //Don't need to do anything as it's just tracking form shown
    })
    .fail(function(jqXHR, textStatus, errorThrown) {

    })
    .always(function() {

    });
    });

    var waitForVideo = noAutoplay ? 1 : 15000;

    console.log("Smart offer max wait time: " + waitForVideo);

    setTimeout(function() {
    if($("#smedia-lead-collect-form").hasClass('loaded')) return;
    console.log('Smart Offe: video taking to long to load. showing popup');
    $("#smedia-lead-collect-form").css("display", "block").css('left', '50%').removeClass('loading').addClass('loaded');
    $("#smedia-overlay").css("display", "block");
    if(!noAutoplay) player.play();
    }, waitForVideo);
    },
    close : function() {
    var player = videojs('sm-lead-video');
    player.pause();
    $("#smedia-overlay").css("display", "none");
    $("#smedia-lead-collect-form").css("display", "none");
    $.ajax({
    type : "POST",
    url : $("#sm-lead-form").prop("action"),
    data : "act=closed&dealership=<?php echo $cron_name ?>&smedia_smart_lead_uuid=<?php echo $user_unique_id ?>&session_id=<?php echo $session_id ?>",
    crossDomain : true
    })
    .done(function(data, textStatus, jqXHR) {
    //Don't need to do anything as it's just tracking form shown
    })
    .fail(function(jqXHR, textStatus, errorThrown) {

    })
    .always(function() {

    });
    },
    disable : function(form) {
    $(form).find('input').prop("disabled", true);
    $(form).find('button').prop("disabled", true);
    $("#sm-loading-spinner").css("display", "block");
    },
    enable : function(form) {
    $(form).find('input').prop("disabled", false);
    $(form).find('button').prop("disabled", false);
    $("#sm-loading-spinner").css("display", "none");
    }
    };

    <?php if ($to_show) {
        $timelimit = $display_after;
        if (stripos($url, "smedia_facebook") > 0) {
            $timelimit = $fb_retarget_after;
        } else if (stripos($url, "retargeting") > 0) {
            $timelimit = $adword_retarget_after;
        }
        $show_based_on_last_close = true;
        $customer_session = customer_get_session($session_id, $cron_name);
        if ($customer_session && $session_close_value) {
            $last_closed_time = strtotime($customer_session['closed_at']);
            if ($customer_session['count'] == 1) {
                $timelimit = 60000;
            } elseif ($customer_session['count'] == 2) {
                $timelimit = 90000;
            } elseif ($customer_session['count'] > 2) {
                $show_based_on_last_close = false;
            }
        }

    ?>
        <?php if ($timelimit >= 0 && $smart_offer_live && $visit_status && $show_status_based_on_minimum_price && $show_based_on_device_type && $show_based_on_last_close) : ?>
            setTimeout('sMedia.Lead.show()', <?php print $timelimit; ?>);
        <?php endif; ?>
    <?php } ?>

    <?php if ($smart_offer_debug) : ?>
        setTimeout('sMedia.Lead.show()', 2000);
    <?php endif; ?>
    }

    confirmjQueryLoaded(function($) { jQueryReady($); });
