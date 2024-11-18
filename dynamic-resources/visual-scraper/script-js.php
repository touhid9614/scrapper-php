<?php
header('Content-type: text/javascript; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$adwords_dir = dirname(dirname(__DIR__)) . "/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'cron_misc.php';
require_once $adwords_dir . 'tag_db_connect.php';

$dealership = filter_input(INPUT_GET, 'dealership');
$required_parameters = null;    //Load array of required parameters based on dealership
$url = filter_input(INPUT_GET, 'ref', FILTER_SANITIZE_URL);
$vdp = mild_url_encode($url, $required_parameters);  //Need to process this url
$visual_scraper_debug = stripos($url, 'visual_scraper_debug=true') !== false;
$scraper_table = $dealership . '_scrapped_data';
$onedayago_time = time() - 24 * 60 * 60; 
$car_status_query = DbConnect::get_instance()->query("SELECT url FROM $scraper_table WHERE url='$vdp' and updated_at < $onedayago_time");
$car_status = mysqli_num_rows($car_status_query);
?>

<?php if($car_status || $visual_scraper_debug): ?>
    var script_link = 'https://tm.smedia.ca/visual-scraper/visual_scraper.js';
    var vs_script = document.createElement('script');
        vs_script.setAttribute("type","text/javascript");
        vs_script.setAttribute("src", script_link);
        document.getElementsByTagName('head')[0].appendChild(vs_script);
        console.log("sMedia Included Script '" + script_link + "'");
<?php endif;  ?>
    
    

    
    
    
