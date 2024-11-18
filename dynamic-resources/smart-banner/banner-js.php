<?php
header('Content-type: text/javascript; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$adwords_dir = dirname(dirname(__DIR__)) . "/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'uuid.php';

global $CronConfigs;

$dealership = filter_input(INPUT_GET, 'dealership');
$year = filter_input(INPUT_GET, 'year');
$make = filter_input(INPUT_GET, 'make');
$model = filter_input(INPUT_GET, 'model');
$vdp = filter_input(INPUT_GET, 'vdp');

$inputs = filter_input_array(INPUT_GET);

$car_data['year'] = $year;
$car_data['make'] = $make;
$car_data['model'] = $model;

$cron_config = isset($CronConfigs[$dealership]) ? $CronConfigs[$dealership] : null;
$url = filter_input(INPUT_GET, 'ref', FILTER_SANITIZE_URL);
$user_unique_id = filter_input(INPUT_GET, 'user_unique_id');

$inputs['uuid'] = $user_unique_id;

$smartbanner_live = isset($cron_config['smart_banner']['live']) ? $cron_config['smart_banner']['live'] : false;
$smartbanner_config_title = isset($cron_config['smart_banner']['title']) ? $cron_config['smart_banner']['title'] : 'Are you still interested in the';


$smartbanner_debug = stripos($url, 'smartbanner_debug=true') !== false;
?>

var smedia_smart_banner_inputs = <?= json_encode($inputs) ?>;
var cookie_name =  smedia_smart_banner_inputs.dealership + '_smart_banner_data';
var is_vdp     = "<?= $vdp ?>";
var smartbanner_config_title = "<?= $smartbanner_config_title ?>";

var sMedia = sMedia || {};

function bannerjQueryReady($) {
<?php
if ($smartbanner_debug || $smartbanner_live) {

    /*
    $banner_data_cookie_name = $dealership . '_smart_banner_data';

    $smart_banner_data = rawurldecode(filter_input(INPUT_COOKIE, $banner_data_cookie_name));

    if (!$smart_banner_data) {
        saveEngagedIntoCookie();
    } else {
        $engaged_data = [];
        $smart_banner_data = json_encode($engaged_data);
    }  */
    ?>

    /*
    var engaged_data = '<div id="smedia-smartbanner-overlay" style="display:none"></div>\n' +
    '<div id="smedia-smartbanner-data" style="display:none">\n' +
        '</div>';
    var smartbanner_temp_div = document.createElement('div');
    smartbanner_temp_div.innerHTML = engaged_data;
    document.getElementsByTagName("body")[0].appendChild(smartbanner_temp_div);  */


    var base_style = document.createElement('link');
    base_style.setAttribute("href", "//tm.smedia.ca/dynamic-resources/smart-banner/style.css?v=1.0");
    base_style.setAttribute("rel", "stylesheet");
    base_style.setAttribute("type", "text/css");
    document.getElementsByTagName('head')[0].appendChild(base_style);

    console.log("cookie_name=" + cookie_name);
    var get_cookie_data = get_cookie(cookie_name);
    console.log("get_cookie_data=" + get_cookie_data);

    if(get_cookie_data && !is_vdp) {
        var smart_banner_data = JSON.parse(get_cookie_data);
        console.log("smart_banner_data=" + smart_banner_data);

        var base_style = document.createElement('link');
        base_style.setAttribute("href", "//tm.smedia.ca/dynamic-resources/smart-banner/style.css?v=1.0");
        base_style.setAttribute("rel", "stylesheet");
        base_style.setAttribute("type", "text/css");
        document.getElementsByTagName('head')[0].appendChild(base_style);

        var cookie_dealership = smedia_smart_banner_inputs.dealership + '_recordedsession_or_close';
        var recordedsession_or_close = get_cookie(cookie_dealership);
        console.log("recordedsession_or_close=" + recordedsession_or_close);
        var banner_title = smart_banner_data.title;

        console.group("VDP Compare");
        console.log(smart_banner_data.vdp);
        console.log(smedia_smart_banner_inputs.vdp);
        console.groupEnd();

    if(smart_banner_data.vdp && smart_banner_data.vdp != smedia_smart_banner_inputs.vdp && recordedsession_or_close !='yes') {

        if(!banner_title) {
            banner_title = smart_banner_data.year + ' ' + smart_banner_data.make + ' ' + smart_banner_data.model;
        }

    var banner_div = '<div class="smedia-smart-banner">';
        banner_div += '<div class="image-part">';
        banner_div += '<img src="' + smart_banner_data.car_image + '" alt="'+ banner_title +'">';
        banner_div += '</div>';
        banner_div += '<div class="content-part">';
        banner_div += '<a href="javascript:void(0)" class="close">&times;</a>';
        banner_div += '<div class="car_title">'+ banner_title +'</div>';
        banner_div += '<div class="car_sub_title">' + smartbanner_config_title + ' ' + banner_title + '?</div>';
        banner_div += '<div class="button_link">';
        banner_div += '<a href="'+ smart_banner_data.vdp +'" class="click_here" target="_blank">See details here</a>';
        banner_div += '</div>';
        banner_div += '</div>';
        banner_div += '</div>';


        /*
    var banner_div = '<div class="smedia-smart-banner"> Would you like to continue shopping for ' +
        banner_title + '?  <a href="' + smart_banner_data.vdp + '" class="click_here" target="_blank"><b>Click here </b></a>' +
        '<a href="javascript:void(0)" class="close">&times;</a></div>';  */


    var checkActiveLastVdp = {
        'act'               : 'check_active_last_vdp',
        'sb_dealership'     : smart_banner_data.dealership,
        'sb_vdp'            : smart_banner_data.vdp
    };
    jQuery.ajax({
        type: "POST",
        url: '//tm.smedia.ca/services/smart-banner.php',
        data: checkActiveLastVdp,
        crossDomain: true
    }).done(function (response) {
        console.log(response);
        if(response.success){
            $('body').prepend(banner_div);
        };
    });

        }

    }

    $(document).on('click', '.smedia-smart-banner .close', function (event) {
        $('.smedia-smart-banner').remove();
        var dealership = smedia_smart_banner_inputs.dealership;
        document.cookie = dealership + "_recordedsession_or_close=yes";
    });

    function get_cookie(Name) {
        var search = Name + "="
        var returnvalue = "";
        if (document.cookie.length > 0) {
            offset = document.cookie.indexOf(search)
        // if cookie exists
        if (offset != -1) {
            offset += search.length
        // set index of beginning of value
            end = document.cookie.indexOf(";", offset);
        // set index of end of cookie value
        if (end == -1) end = document.cookie.length;
            returnvalue=unescape(document.cookie.substring(offset, end))
        }
        }
        return returnvalue;
    }

    <?php
}
?>

var formData = {
        'act'                  : 'save',
        'sb_dealership'        : smedia_smart_banner_inputs.dealership,
        'sb_uuid'              : smedia_smart_banner_inputs.uuid,
        'sb_make'              : smedia_smart_banner_inputs.make,
        'sb_model'             : smedia_smart_banner_inputs.model,
        'sb_year'              : smedia_smart_banner_inputs.year,
        'sb_vdp'               : smedia_smart_banner_inputs.vdp
};

function save_engaged_car() {
    jQuery.ajax({
        type: "POST",
        url: '//tm.smedia.ca/services/smart-banner.php',
        data: formData,
        crossDomain: true
        }).done(function (response) {
            var cookieData = {
                    'vdp'                  : smedia_smart_banner_inputs.vdp,
                    'title'                : smedia_smart_banner_inputs.year + ' ' + smedia_smart_banner_inputs.make + ' ' + smedia_smart_banner_inputs.model,
                    'car_image'            : response.data.car_image,
                    'dealership'           : response.data.dealership
                };
           //document.cookie = cookie_name + "=" + JSON.stringify(cookieData);
           console.log(response);
           setCookie(cookie_name, JSON.stringify(cookieData));
    });
}

if(is_vdp) {
	if(window.sMedia.epmCallbacks !== undefined) {
		window.sMedia.epmCallbacks.push(function() {
			save_engaged_car();
		});
	}
}

 function setCookie(c_name,value,exdays = 365)
    {
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value=escape(value) + ((exdays==null)
                                     ? "" : "; expires="+exdate.toUTCString())
                                    + "; path=/";
        document.cookie=c_name + "=" + c_value;
    }



<?php
    /*
    function saveEngagedIntoCookie(){
        global $dealership, $user_unique_id, $banner_data_cookie_name;

        $engaged_query = "SELECT * FROM user_engagement WHERE dealership='$dealership' AND uuid='$user_unique_id'";
        $user_engagement = tagdb_query($engaged_query);

        if ($user_engagement) {
            $engaged_data = mysqli_fetch_assoc($user_engagement);
            mysqli_free_result($user_engagement);
        }

        //echo "\n//$engaged_query\n";

        $scrapper_table = $dealership . '_scrapped_data';
        $delete_check_query = "SELECT all_images FROM $scrapper_table WHERE url='" . tagdb_real_escape_string($engaged_data['last_engaged_vdp']) . "' AND deleted = 0";
        $deleted_status = tagdb_query($delete_check_query);
        $deleted_numrows = mysqli_num_rows($deleted_status);

        //echo "\n//$delete_check_query\n";

        if ($engaged_data && $deleted_numrows) {
            //Get first url of engaged user car
            $cars_data = mysqli_fetch_assoc($deleted_status);
            $car_image  = explode("|", $cars_data['all_images']);
            $engaged_data['car_image']  = $car_image[0];

            $engaged_data['vdp'] = urlCombine($engaged_data['last_engaged_vdp'], '?utm_source=smedia&utm_medium=smart-banner');

            $config_bannertitle = isset($cron_config['smart_banner']['title']) ? $cron_config['smart_banner']['title'] : '[year] [make] [model]';
            $banner_title = processTextTemplate($config_bannertitle, $engaged_data);
            $engaged_data['title'] = $banner_title;

            $status = true;
        } else {
            $engaged_data = [];
            $status = false;
        }

        $smart_banner_data = json_encode($engaged_data);

        setcookie($banner_data_cookie_name, rawurlencode($smart_banner_data), 0, '/', '.smedia.ca');
    }   */
 ?>
}

confirmjQueryLoaded(function($) { bannerjQueryReady($); });
