<?php

header('Content-type: text/javascript; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$adwords_dir = dirname(dirname(__DIR__)) . "/adwords3";

require_once $adwords_dir . '/config.php';
require_once $adwords_dir . '/utils.php';
require_once $adwords_dir . '/tag_db_connect.php';
require_once $adwords_dir . '/uuid.php';
require_once __DIR__ . '/popup.php';
global $CronConfigs;

use Detection\MobileDetect;

$detectDevice = new MobileDetect();

$cron_name   = filter_input(INPUT_GET, 'dealership');
$stock_type  = strtolower(filter_input(INPUT_GET, 'stock_type'));
$stock_no    = filter_input(INPUT_GET, 'stock_number');
$year        = filter_input(INPUT_GET, 'year');
$make        = filter_input(INPUT_GET, 'make');
$model       = filter_input(INPUT_GET, 'model');
$price       = filter_input(INPUT_GET, 'price');
$session_id  = filter_input(INPUT_GET, 'session_id');
$page_title  = htmlentities(isset($_GET['page_title']) ? filter_input(INPUT_GET, 'page_title') : '', ENT_QUOTES);
$custom_div  = isset($_GET['custom_div']) ? filter_input(INPUT_GET, 'custom_div') : '';

$cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;

$url               = filter_input(INPUT_GET, 'ref', FILTER_SANITIZE_URL);
$smart_offer_debug = stripos($url, 'smart_offer_debug=true') !== false;

if (!$cron_config) {
    die("/* No Such Dealership */");
}

if ($smart_offer_debug) {
    echo "/* smart offer debug: $smart_offer_debug */\n";
}

$alead_config = isset($cron_config['lead'][$stock_type]) ? $cron_config['lead'][$stock_type] : (isset($cron_config['lead']['live']) ? $cron_config['lead'] : array());

if (!count($alead_config)) {
    echo "\n/* No Lead Config found for stock type : $stock_type */\n";
}

$default = [
    'live'                   => false,
    'lead_type_'             => false,
    'lead_type_new'          => false,
    'lead_type_used'         => false,
    'lead_type_service'      => false,
    'shown_cap'              => false,
    'fillup_cap'             => false,
    'session_close'          => false,
    'device_type'            => array(
        'desktop' => true,
        'tablet'  => true,
        'mobile'  => true,
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
    'extra_text'             => '',
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
    'lead_in'                => []
];

$lead_config               = array_merge($default, $alead_config);
$smart_offer_live          = (isset($lead_config['live']) && $lead_config['live']) ? true : false;
$show_for_mobile           = (isset($lead_config['device_type']['mobile'])) ? $lead_config['device_type']['mobile'] : true;
$show_for_desktop          = (isset($lead_config['device_type']['desktop'])) ? $lead_config['device_type']['desktop'] : true;
$show_for_tablet           = (isset($lead_config['device_type']['tablet'])) ? $lead_config['device_type']['tablet'] : true;
$session_close_value       = (isset($lead_config['session_close'])) ? $lead_config['session_close'] : false;
$show_based_on_device_type = false;

echo "/* smart offer live: $smart_offer_live */\n";

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

if ($lead_config['extra_text']) {
    $extraText = $lead_config['extra_text'];
} else {
    $extraText = '';
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

$dir = "{$adwords_dir}/templates/{$cron_name}/";

if (!check_popup_file($dir, populate_popup_files(strtolower($stock_type), $year, strtolower($make), strtolower($model)))) {
    exit("/* No banner found for $stock_type, $year , $make , $model  inventory */");
}

$display_after         = isset($lead_config['display_after']) ? $lead_config['display_after'] : 30000;
$retarget_after        = isset($lead_config['retarget_after']) ? $lead_config['retarget_after'] : 5000;
$fb_retarget_after     = isset($lead_config['fb_retarget_after']) ? $lead_config['fb_retarget_after'] : $retarget_after;
$adword_retarget_after = isset($lead_config['adword_retarget_after']) ? $lead_config['adword_retarget_after'] : $retarget_after;
$config_visit_count    = isset($lead_config['visit_count']) ? $lead_config['visit_count'] : 0;

# Show based on minimum price
$show_status_based_on_minimum_price = true;

if (isset($lead_config['offer_minimum_price'])) {
    $config_minimum_price = (int) preg_replace('/[^0-9]/', '', $lead_config['offer_minimum_price']);
    $current_price        = (int) preg_replace('/[^0-9]/', '', $price);

    if ($current_price < $config_minimum_price) {
        $show_status_based_on_minimum_price = false;
    }
}

if (isset($lead_config['offer_maximum_price'])) {
    $config_minimum_price = (int) preg_replace('/[^0-9]/', '', $lead_config['offer_maximum_price']);
    $current_price        = (int) preg_replace('/[^0-9]/', '', $price);

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
    if ($smart_offer_debug) {
        echo "/* smart offer stock Type: $check_type */\n";
    }
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
$submitted = ($submitted_at > 0 && ($now - $submitted_at) < (604800));
#Show twice in every 24 hours (Unless submitted)
$elapsed = $now - min($shown);

if (!$shown_cap) {
    $elapsed = 172800;  // 2 days
} #If shown cap is disabled, make elapsed big so that cap is removed
if (!$fillup_cap) {
    $submitted = false;
} #If fillup cap is disabled, set submitted to false
$to_show = ($elapsed > (86400)) && (!$submitted);

# Based on user visit
$user_visit       = user_visit_get_count($user_unique_id, $cron_name);
$user_visit_count = $user_visit ? $user_visit['visit_count'] : 0;
$visit_status     = $config_visit_count > $user_visit_count ? false : true;

# Update user visit on each
update_user_visit($user_unique_id, $cron_name);

?>
/*
* Popup JS for <?= $cron_name ?>
******************************************************************************/
smedia_lead_popup_design = 'https://tm.smedia.ca/popup/design.css?dealership=<?= urlencode($cron_name) ?>&stock_type=<?= urlencode($stock_type) ?>&year=<?= urlencode($year) ?>&make=<?= urlencode($make) ?>&model=<?= urlencode($model) ?>';
smedia_lead_popup_design_style = document.createElement('link');
smedia_lead_popup_design_style.setAttribute("href", smedia_lead_popup_design);
smedia_lead_popup_design_style.setAttribute("rel", "stylesheet");
smedia_lead_popup_design_style.setAttribute("type", "text/css");
document.getElementsByTagName("head")[0].appendChild(smedia_lead_popup_design_style);
var referrer = document.referrer;

var smedia_form_html_content_middle = '';


var locationValue = <?= json_encode(array_values($locationValue)); ?>;


if (locationValue.length > 0) {
    var index, len, allOption = '<option value="">--Select--</option>\n';
    locationValue.forEach(function(element) {
        allOption += '<option value="' + element + '">' + element + ' </option>\n';
    });
    var smedia_form_html_content_middle= '<div class="sm-row">\n' +
    '<label for="sm-name">Nearest Location</label>\n' +
    '<select class="form-control" name="nearest_location" id="nearest_location">\n' +
        allOption +
        '</select>' +
    '</div>\n';
}

var extraText = <?= json_encode($extraText); ?>;

if (extraText.length) {
    var smedia_form_html_content_middle= '<div class="sm-row">\n' +
    '<p style="margin-top: 0 !important; margin-bottom: 0 !important; font-size: 12px !important; text-align: justify;">'+ extraText +'</p>\n' +
    '</div>\n';
}

var smedia_form_html_content_first = '<div id="smedia-overlay" style="display:none"></div>\n' +
'<div id="smedia-lead-collect-form" class="sm-lead-collect-form" style="display:none">\n' +
    '<div class="sm-lead-collect-form-image">\n' +
        '</div>\n' +
    '<div class="sm-lead-collect-form-body">\n' +
        '<div class="sm-row">\n' +
            '<button class="sm-close-btn" id="sm-close-btn"></button>\n' +
            '</div>\n' +
        '<div id="sm-form-container">\n' +
            '<form id="sm-lead-form" method="post" action="https://tm.smedia.ca/services/smart-offer-lead.php">\n' +
                '<input type="hidden" name="act" value="submit"/>\n' +
                '<input type="hidden" name="dealership" value="<?= $cron_name ?>"/>\n' +
                '<input type="hidden" name="stock_type" value="<?= $stock_type ?>"/>\n' +
                '<input type="hidden" name="year" value="<?= $year ?>"/>\n' +
                '<input type="hidden" name="make" value="<?= $make ?>"/>\n' +
                '<input type="hidden" name="model" value="<?= $model ?>"/>\n' +
                '<input type="hidden" name="stock_number" value="<?= $stock_no ?>"/>\n' +
                '<input type="hidden" name="url" value="<?= $url ?>"/>\n' +
                '<input type="hidden" name="smedia_smart_lead_uuid" value="<?= $user_unique_id ?>"/>\n' +
                '<input type="hidden" name="page_title" value="<?= $page_title ?>"/>\n' +
                '<input type="hidden" name="referrer" value="<?= $referrer ?>"/>\n' +
                '<div class="sm-row">\n' +
                    '<label for="sm-name">Name</label>\n' +
                    '<input type="text" id="sm-name" name="name" value="" required/>\n' +
                    '</div>\n' +
                '<div class="sm-row">\n' +
                    '<label for="sm-email">Email</label>\n' +
                    '<input type="email" id="sm-email" name="email" value="" required/>\n' +
                    '</div>\n' +
                '<div class="sm-row">\n' +
                    '<label for="sm-phone">Phone</label>\n' +
                    '<input type="tel" id="sm-phone" name="phone" value="" required/>\n' +
                    '</div>\n' ;

var smedia_form_html_content_before_last = $custom_div;

var smedia_form_html_content_last = '<div class="sm-row">\n' +
                    '<button class="sm-lead-submit-btn">Submit</button>\n' +
                    '</div>\n' +
                '</form>\n' +
            '</div>\n' +
        '<div class="sm-row">\n' +
            '<div id="sm-loading-spinner" class="sm-loading-spinner">\n' +
                '<img src="https://tm.smedia.ca/adwords3/templates/balls.svg" />\n' +
                '</div>\n' +
            '</div>\n' +
        '</div>\n' +
    '</div>';

var smedia_form_html_content = smedia_form_html_content_first + smedia_form_html_content_middle + smedia_form_html_content_before_last + smedia_form_html_content_last;
var smedia_temp_div = document.createElement('div');
smedia_temp_div.innerHTML = smedia_form_html_content;
var smedia_form_elements = smedia_temp_div.childNodes;
document.getElementsByTagName("body")[0].appendChild(smedia_form_elements[0]);
document.getElementsByTagName("body")[0].appendChild(smedia_form_elements[1]);

var sMedia = sMedia || {};

function jQueryReady($) {

sMedia.Lead = {
    form            : null,
    initialized     : false,
    closeTimeout    : null,
    initialForm     : null,
    uniqueUserId    : '<?=$user_unique_id?>',
    init    : function() {
        $("#smedia-overlay").click(function() {
            sMedia.Lead.close();
        });

        $("#sm-close-btn").click(function() {
            sMedia.Lead.close();
        });

        $("#sm-lead-form").submit(function(e) {
            e.preventDefault();
            sMedia.Lead.form = this;
            var form_data = $(this).serialize();
            var action = $(sMedia.Lead.form).prop("action");

            sMedia.Lead.disable(sMedia.Lead.form);

            $.ajax({
                type  : "POST",
                url   : action,
                data  : form_data,
                crossDomain   : true
            }).done(function(data, textStatus, jqXHR) {
                ga('smedia_analytics_tracker.send', {
                    hitType: 'event',
                    eventCategory: 'smart_offer',
                    eventAction: 'lead',
                    nonInteraction: true
                });

                if (data.response) {
                    $("#sm-form-container").html(data.response);
                    setTimeout("sMedia.Lead.close()", 3000);
                } else {
                    alert(data.error);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log('Smart Offer Submission Issue: ' + textStatus);
                console.log(jqXHR);
                sMedia.Lead.close();
            }).always(function() {
                sMedia.Lead.enable(sMedia.Lead.form);
            });
        });

        this.initialized = true;
    },
    delayClose    : function() {
        if ($("#sm-lead-form").serialize() !== sMedia.Lead.initialForm) {
            if (sMedia.Lead.closeTimeout) {
                clearTimeout(sMedia.Lead.closeTimeout);
            }
            return;
        }
        sMedia.Lead.close();
    },
    show    : function() {
        if (!this.initialized) {
            this.init();
        }
        console.log("Smart offer show function call");
        ga('smedia_analytics_tracker.send', {
            hitType: 'event',
            eventCategory: 'smart_offer',
            eventAction: 'shown',
            nonInteraction: true
        });
        $("#smedia-overlay").css("display", "block");
        $("#smedia-lead-collect-form").css("display", "block");
        sMedia.Lead.initialForm = '';   /* Avoid auto close by setting initial form to nothing */   //$("#sm-lead-form").serialize();
        sMedia.Lead.closeTimeout = setTimeout("sMedia.Lead.delayClose()", 20000);

        $.ajax({
            type  : "POST",
            url   : $("#sm-lead-form").prop("action"),
            data  : "act=shown&dealership=<?= $cron_name ?>&smedia_smart_lead_uuid=<?= $user_unique_id ?>",
            crossDomain   : true
        }).done(function(data, textStatus, jqXHR) {
            // Don't need to do anything as it's just tracking form shown
        }).fail(function(jqXHR, textStatus, errorThrown) {

        }).always(function() {

        });
    },
    close   : function() {
        $("#smedia-overlay").css("display", "none");
        $("#smedia-lead-collect-form").css("display", "none");
        $.ajax({
            type  : "POST",
            url   : $("#sm-lead-form").prop("action"),
            data  : "act=closed&dealership=<?= $cron_name ?>&smedia_smart_lead_uuid=<?= $user_unique_id ?>&session_id=<?= $session_id ?>",
            crossDomain   : true
        }).done(function(data, textStatus, jqXHR) {
            // Don't need to do anything as it's just tracking form shown
        }).fail(function(jqXHR, textStatus, errorThrown) {

        }).always(function() {

        });
    },
    disable : function(form) {
        $(form).find('input').prop("disabled", true);
        $(form).find('button').prop("disabled", true);
        $("#sm-loading-spinner").css("display", "block");
    },
    enable  : function(form) {
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
    $customer_session         = customer_get_session($session_id, $cron_name);

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

    $criteria_to_show = [
        'timelimit'                          => $timelimit,
        'smart_offer_live'                   => $smart_offer_live,
        'visit_status'                       => $visit_status,
        'show_status_based_on_minimum_price' => $show_status_based_on_minimum_price,
        'show_based_on_device_type'          => $show_based_on_device_type,
        'show_based_on_last_close'           => $show_based_on_last_close
    ];

    echo "\n// criteria_to_show: " . json_encode($criteria_to_show) . "\n";
    ?>
    <?php if ($timelimit >= 0 && $smart_offer_live && $visit_status && $show_status_based_on_minimum_price && $show_based_on_device_type && $show_based_on_last_close): ?>
        setTimeout('sMedia.Lead.show()', <?php print $timelimit;?>);
    <?php endif;?>
<?php }?>

<?php if ($smart_offer_debug): ?>
    setTimeout('sMedia.Lead.show()', 2000);
<?php endif;?>
}

confirmjQueryLoaded(function($) { jQueryReady($); });
