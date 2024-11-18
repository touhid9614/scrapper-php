<?php

header('Content-type: application/xml');

$view = filter_input(INPUT_GET, 'view');

define('ENABLE_ADS_PREVIEW', $view == 'ads');
define('ENABLE_OLD_ADS', $view == 'old');

# when view is set to 'ads' it will preview from dev server
# when view is set to 'live' it will preview from live server
# when view is set to 'old' it will preview from old server
if ($view == 'ads' || $view == 'live' || $view == 'old') {
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<?xml-stylesheet type=\"text/xsl\" href=\"../marketplace-feed.xsl\" ?>\n";
} else {
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
}

require_once "../vendor/autoload.php";

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "$base_dir/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

global $CronConfigs;

$cron_name   = "drivenation";
$cron_config = $CronConfigs[$cron_name];

$all_cars_db = [];

$db_connect = new DbConnect($cron_name);
$result     = $db_connect->query("SELECT * FROM {$cron_name}_scrapped_data WHERE deleted = 0");

while ($row = mysqli_fetch_assoc($result)) {
    $images = explode("|", $row["all_images"]);

    if ($images[0] == "") {
        $images = [];
    }

    $auto_text = explode("|", $row["auto_texts"]);

    if ($auto_text[0] == "") {
        $auto_text = [];
    }

    $all_cars_db[$row["stock_number"]] = [
        "vin"             => isset($row["vin"]) ? $row["vin"] : $row["stock_number"],
        "stock_type"      => $row["stock_type"],
        "year"            => $row["year"],
        "make"            => $row["make"],
        "model"           => $row["model"],
        "trim"            => $row["trim"],
        "title"           => $row["title"],
        "msrp"            => $row["msrp"],
        "price"           => $row["price"],
        "city"            => $row["city"],
        "biweekly"        => $row["biweekly"],
        "lease"           => $row["lease"],
        "lease_term"      => $row["lease_term"],
        "lease_rate"      => $row["lease_rate"],
        "finance"         => $row["finance"],
        "finance_term"    => $row["finance_term"],
        "finance_rate"    => $row["finance_rate"],
        "weekly"          => /*butifyPrice*/(numarifyPrice($row["biweekly"]) / 2),
        "price_history"   => $row["price_history"] ? unserialize($row["price_history"]) : [],
        "body_style"      => $row["body_style"],
        "engine"          => $row["engine"],
        "transmission"    => $row["transmission"],
        "fuel_type"       => $row["fuel_type"],
        "drivetrain"      => $row["drivetrain"],
        "kilometers"      => $row["kilometres"],
        "kilometres"      => $row["kilometres"],
        "color"           => $row["exterior_color"],
        'exterior_color'  => $row['exterior_color'],
        'interior_color'  => $row['interior_color'],
        "url"             => $row["url"],
        "host"            => $row["host"],
        "arrival_date"    => $row["arrival_date"],
        "updated_at"      => $row["updated_at"],
        "handled_at"      => $row["handled_at"],
        "bing_handled_at" => isset($row["bing_handled_at"]) ? $row["bing_handled_at"] : 0,
        "certified"       => $row["certified"] ? 1 : 0,
        "deleted"         => $row["deleted"] ? 1 : 0,
        "images"          => $images,
        "description"     => $row["description"],
        "auto_texts"      => $auto_text,
        "custom"          => $row["custom"],
    ];
}

//print_r($all_cars_db);

$deal               = $db_connect->query("SELECT * FROM dealerships WHERE dealership = '$cron_name';");
$dealership_details = mysqli_fetch_assoc($deal);

$country_name = $dealership_details['country_name'];
$currency     = get_currency($country_name);
$mileage_unit = get_mileage($country_name);
$city         = false;

//print_r($dealership_details);
?>
<listings>
	<?php
foreach ($all_cars_db as $stock_number => $car) {
    ?>
		<listing>
			<vehicle_id><?=$stock_number?></vehicle_id>
			<title><?=$car["stock_type"] . " " . $car["year"] . " " . $car["make"] . " " . $car["model"]?></title>
			<stock_number><?=$stock_number?></stock_number>
			<description><?=$car["$description"]?></description>
			<url><?=$car["url"]?></url>
			<?php
foreach ($car["images"] as $img) {
        ?>
				<image>
					<url><?=$img?></url>
				</image>
			<?php
}
    ?>
			<year><?=$car["year"]?></year>
			<make><?=$car["make"]?></make>
			<model><?=$car["model"]?></model>
			<mileage>
				<value><?=numarifyKm($car["kilometres"])?></value>
				<unit><?=$mileage_unit?></unit>
			</mileage>
			<vin><?=str_pad($car["vin"], 17, '0', STR_PAD_LEFT)?></vin>
			<body_style><?=$car["body_style"]?></body_style>
			<fuel_type><?=$car["fuel_type"]?></fuel_type>
			<drivetrain><?=$car["drivetrain"]?></drivetrain>
			<transmission><?=$car["transmission"]?></transmission>
			<state_of_vehicle><?=$car["stock_type"]?></state_of_vehicle>
			<price><?=$car["price"]?></price>
			<?php
if ($dealership_details && isset($dealership_details['address'])) {
        $checkCity = false;

        if (isset($car["city"]) && $car["city"] != "") {
            $checkCity = $car["city"];
        }

        if ($city != false && isset($cron_config['cities']) && isset($cron_config['cities'][$city])) {
            $dealership_details['address']      = $cron_config['cities'][$city]['address'];
            $dealership_details['city']         = $cron_config['cities'][$city]['city'];
            $dealership_details['state']        = $cron_config['cities'][$city]['state'];
            $dealership_details['country_name'] = $cron_config['cities'][$city]['country_name'];
            $dealership_details['post_code']    = $cron_config['cities'][$city]['post_code'];
            $dealership_details['phone']        = $cron_config['cities'][$city]['phone'];

            $location = getGeoLocation($cron_config['cities'][$city]['full_address']);
        } else if ($city == false && $checkCity && isset($cron_config['cities']) && isset($cron_config['cities'][$checkCity])) {
            $dealership_details['address']      = $cron_config['cities'][$checkCity]['address'];
            $dealership_details['city']         = $cron_config['cities'][$checkCity]['city'];
            $dealership_details['state']        = $cron_config['cities'][$checkCity]['state'];
            $dealership_details['country_name'] = $cron_config['cities'][$checkCity]['country_name'];
            $dealership_details['post_code']    = $cron_config['cities'][$checkCity]['post_code'];
            $dealership_details['phone']        = $cron_config['cities'][$checkCity]['phone'];

            if (isset($cron_config['cities'][$checkCity]['full_address'])) {
                $location = getGeoLocation($cron_config['cities'][$checkCity]['full_address']);
            }
        }
        ?>

				<address format="simple">
					<component name="addr1"><?=$dealership_details['address']?></component>
					<component name="city"><?=$dealership_details['city']?></component>
					<component name="region"><?=$dealership_details['state']?></component>
					<component name="country"><?=$dealership_details['country_name']?></component>
					<component name="postal_code"><?=$dealership_details['post_code']?></component>
				</address>
				<?php
if ($location) {
            ?>
					<latitude><?=$location['lat']?></latitude>
					<longitude><?=$location['lng']?></longitude>
			<?php
}
    }
    ?>
			<exterior_color><?=$car["exterior_color"]?></exterior_color>
			<fb_page_id><?=$dealership_details['fb_page_id']?></fb_page_id>
			<dealer_id><?=$cron_name?></dealer_id>
			<dealer_name><?=$dealership_details['company_name']?></dealer_name>
			<dealer_phone><?=$dealership_details['phone']?></dealer_phone>
			<dealer_privacy_policy_url><?=$dealership_details['privacy_policy_url']?></dealer_privacy_policy_url>
		</listing>
	<?php
}
?>
</listings>