<!--
    Hours wasted = 20;
    Step 1 : Try to fix this code.
    Step 2 : Realize it was a mistake.
    Step 3 : Press 'CNTL + Z' repeatedly.
    Step 4 : Increment the value of 'Hours wasted' for next developer.
-->

<?php
include 'includes/preview.php';
global $BannerConfigs, $tabs, $cron_name, $cron_config, $good_car, $is_good, $select, $ignore;

$car_type = filter_input(INPUT_GET, 'car_type');

$table             = "{$cron_name}_scrapped_data";
$query             = "SELECT * FROM {$table} where deleted = '0' AND price != 'Please Call' AND all_images != '' AND stock_number != '' AND url != ''";
$queryResult       = DbConnect::get_instance()->query($query);
$new_car_data      = [];
$preowned_car_data = [];

while ($row = mysqli_fetch_assoc($queryResult)) {
	if ($row['stock_type'] == 'new') {
		$titles = explode('|', $row['title'], 2);
		$title  = ucfirst(trim($titles[0]));

		if (array_key_exists($title, $new_car_data)) {
			continue;
		}

		$new_car_data[$title] = $row['stock_number'];
	} else {
		$titles = explode('|', $row['title'], 2);
		$title  = ucfirst(trim($titles[0]));

		if (array_key_exists($title, $new_car_data)) {
			continue;
		}

		$preowned_car_data[$title] = $row['stock_number'];
	}
}

krsort($new_car_data);
krsort($preowned_car_data);

echo "<script> \n";
echo "var new_car_data = " . json_encode($new_car_data, JSON_PRETTY_PRINT) . "; \n";
echo "var preowned_car_data = " . json_encode($preowned_car_data, JSON_PRETTY_PRINT) . "; \n";
echo "</script>";

$selected_car_type = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'banner-refresh') == 'get-specificad')) {
	$car_stock_number  = filter_input(INPUT_POST, 'car_stock_number');
	$selected_car_type = filter_input(INPUT_POST, 'car_type');
	$good_car          = isset($all_cars_db[$car_stock_number]) ? $all_cars_db[$car_stock_number] : [];
}

if (!$ignore) {
?>


	<form method="POST" class="form-bordered" enctype="multipart/form-data" action="?dealership=<?= $cron_name ?>">
		<div class="panel-body">
			<div class="row mb-md">
				<div class="col-md-4 col-sm-5">
					<div class="form-group">
						<label class="col-sm-4 control-label">Car Type</label>
						<div class="col-sm-8">
							<select class="form-control" name="car_type" id="car_type" onchange="enableCar()">
								<option value="">--Select Car Type--</option>
								<option value="new">New</option>
								<option value="used">Preowned</option>
							</select>
						</div>
					</div>
				</div>

				<div class="col-md-4 col-sm-5" id="appear" name="appear">
					<div class="form-group">
						<label class="col-sm-4 control-label">Car Title</label>
						<div class="col-sm-8">
							<select class="form-control" name="car_stock_number" id="car_stock_number">
								<option value="">--Select Car--</option>
							</select>
						</div>
					</div>
				</div>

				<div class="col-md-4 col-sm-2 pull-right">
					<div class="form-group">
						<label class="col-sm-4 control-label"></label>
						<div class="col-sm-8 clearfix">
							<button type="submit" value="get-specificad" name="banner-refresh" class="btn btn-info mr-xs pull-right ml-xs">Refresh Banner
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div class="row">
		<?php
		foreach ($tabs as $tab) {
			$headerStart = '<div class="col-md-12">
    <section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
        </div>
        <h2 class="panel-title">';
			$headerEnd = '</h2></header>';
			$finalEnd  = '</div></section>';

			if ($selected_car_type == "" or $selected_car_type == $tab['stock_type']) {
				echo $headerStart;
				echo ucwords($tab['stock_type'] . ' ' . $tab['directive']);
				echo $headerEnd;
			} else {
				continue;
			}
		?>

			<div class="panel-body">
				<h3>Banner Ads</h3>
				<div class="banner-container-wrapper">
					<?php
					$car = $good_car;

					if ($car) {
						$key        = $tab['stock_type'] . '_' . $tab['t_directive'];
						$style_name = $cron_config['banner']['styels'][$key];
						$style      = isset($BannerConfigs[$style_name]) ? $BannerConfigs[$style_name] : false;

						$car['stock_type'] = $tab['stock_type'];

						if ($style) {
							foreach ($style as $config => $value) {
								$url    = getBannerURL($tab['t_directive'], $cron_config, $car, $config, $is_good);
								$wh     = explode('x', $config);
								$width  = $wh[0];
								$height = $wh[1];
					?>
								<div class="banner-container" style="width: <?= $width ?>px;">
									<h5><?= $config ?></h5>
									<img src="<?= $url ?>" style="width: <?= $width ?>px; height: <?= $height ?>px; display: block !important;">
								</div>
					<?php
							}
						} else {
							echo 'Style named ' . $style_name . ' unavailable';
						}
					} else {
						echo 'Appropriate car for generating advertisement unavailable';
					}
					?>
				</div>
				<?php
				if ($selected_car_type == "" or $selected_car_type == $tab['stock_type']) {
					echo $finalEnd;
				} else {
					continue;
				}
				?>
			</div>
		<?php
		}
		?>
	</div>

<?php
}
?>

<style type="text/css">
	#appear {
		display: none;
	}
</style>

<script type="text/javascript">
	function enableCar() {
		var car_type = $("#car_type").val();

		if (car_type != '') {
			$("#appear").show();

			let dropdown = $("#car_stock_number");
			dropdown.empty();
			dropdown.append('<option selected="true" disabled>--Select Car--</option>');
			dropdown.prop('selectedIndex', 0);

			var car_data;

			if (car_type == 'new') {
				car_data = new_car_data;
			} else {
				car_data = preowned_car_data;
			}

			$.each(car_data, function(key, entry) {
				dropdown.append($('<option></option>').prop('value', entry).text(key));
			})
		} else {
			$("#appear").hide();
		}
	}
</script>
