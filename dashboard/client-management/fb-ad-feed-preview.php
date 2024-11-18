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


require_once ADSYNCPATH . 'cron_misc.php';

    ini_set('memory_limit', -1);

    global $CronConfigs, $connection;

    $cron_name     = filter_input(INPUT_GET, 'dealership');
    $inc_type      = filter_input(INPUT_GET, 'type');
    $_format       = filter_input(INPUT_GET, 'format');
    $plain         = filter_input(INPUT_GET, 'plain') == 'true';
    $include_stock = filter_input(INPUT_GET, 'stock_number') == 'true';
    $feed_type     = filter_input(INPUT_GET, 'feed_type');
    $older_than    = filter_input(INPUT_GET, 'older_than', FILTER_VALIDATE_INT);

    $inc_stock_type = $inc_type;

    if ($inc_stock_type == 'certified')
    {
        $inc_stock_type = 'used';
    }

    if (!$inc_stock_type)
    {
        $inc_stock_type = 'all';
    }
    if (!$feed_type)
    {
        $feed_type = 'retargeting';
    }

    if (!$_format)
    {
        $_format = 'desktop';
    }

    $formats = [$_format];

    if ($_format == 'all')
    {
        $formats = ['desktop', 'mobile', 'instagram'];
    }

    $all_cars_db = array();

    if (isset($CronConfigs[$cron_name]))
    {
        $cron_config = $CronConfigs[$cron_name];

        $cars_db     = array();
        $ads_db      = array();
        $all_cars_db = array();

        $db_connect = new DbConnect($cron_name);
        $db_connect->LoadCarAds($cars_db, $ads_db, $all_cars_db, $cron_config);

        $db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

        $stock_numbers = array_keys($all_cars_db);
        $domain        = count($stock_numbers) > 0 ? GetDomain($all_cars_db[$stock_numbers[0]]['url']) : '';

        $calculated_hash = calculate_template_hash($cron_name);
    }

    $total        = 0;
    $fb_fulfilled = 0;
    $time         = time();

    $lang = isset($cron_config['lang']) ? $cron_config['lang'] : 'en';

    if (!defined('adlang'))
    {
        define('adlang', $lang);
    }

    ob_start();

    if ($older_than)
    {
        $day_minus       = "-" . $older_than . " days";
        $older_than_date = strtotime($day_minus, strtotime(date('Y-m-d')));
    }
    else
    {
        $older_than_date = strtotime(date('Y-m-d'));
    }

    $table 			= $cron_name . '_scrapped_data';
    $feed_query 	= "SELECT year, make, model, title, url, stock_number FROM $table WHERE deleted = 0";
    $feed_result 	= DbConnect::get_instance()->query($feed_query);
    $feed_data 		= [];
    $feed_array 	= [];

    while ($row 	= mysqli_fetch_assoc($feed_result))
    {
    	$feed_array[$row['stock_number']] =
    	[
    		'year' 	=> $row['year'],
    		'make' 	=> $row['make'],
    		'model' => $row['model'],
    		'title' => $row['title'],
    		'url' 	=> $row['url']
    	];

    	$len = sizeof($feed_data[$row['make']][$row['model']]);
    	$feed_data[$row['make']][$row['model']][$len] = $row['stock_number'];
    }

    echo "<script> \n";
    echo "var feed_data = " . json_encode($feed_data, JSON_PRETTY_PRINT) . "; \n ";
    echo "var feed_array = " . json_encode($feed_array, JSON_PRETTY_PRINT) . "; \n";
    echo "</script>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'feed-preview-button'))
    {
        $selected_make 	= filter_input(INPUT_POST, 'make');
        $selected_model = filter_input(INPUT_POST, 'model');

        if ($selected_make != null && $selected_model != null)
        {
	        foreach ($feed_data['make']['model'] as $key => $value)
	        {
	        	$selected_all_cars_db[$key] = $all_cars_db[$key];
	        }

	        echo "<script> \n";
	    	echo "var selected_make = " . json_encode($selected_make) . "; \n";
	    	echo "var selected_model = " . json_encode($selected_model) . "; \n";
	    	echo "</script>";
		}
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'facebook-save-changes'))
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


        $banner_ar = $CronConfigs[$cron_name]['banner'];
        $fb_marketplace_description 	= filter_input(INPUT_POST, 'fb_marketplace_description');
        $fb_marketplace_description_input = trim(filter_input(INPUT_POST, 'fb_marketplace_description_input'));
        if ($fb_marketplace_description) {
            $banner_ar['fb_marketplace_description'] = $fb_marketplace_description_input;
//            $CronConfigs[$cron_name]['banner']['fb_marketplace_description'] = $fb_marketplace_description_input;
        }else {
            if (isset($banner_ar['fb_marketplace_description'])) {
                unset($banner_ar['fb_marketplace_description']);
//                unset($CronConfigs[$cron_name]['banner']['fb_marketplace_description']);
            }
        }
        $traverser->addVisitor(new configUpdater([
            'key' => ['banner'],
            'value' => $banner_ar
        ]));


        $cron_config['banner']=$banner_ar;

        /*
         * Update Configs
         */
        configsUpdate($cron_config,$cron_name);

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
         * Refresh page after updation
         */
        echo ("<script type='text/javascript'> location.href= location.href; </script>");
    }
?>
<style type="text/css">
    .feed-log {
        width: calc(100% - 20px);
        padding: 10px;
        background: #ebebeb;
        margin: 10px;
        border: 1px solid #e3e3e3;
        border-radius: 3px;
    }
    .feed-log p {
        line-height: 25px;
        color: #000;
    }

    .feed-log p.fb-issue.fb-error {
        color: red;
    }

    .feed-log p.fb-issue.fb-error:before {
        content: "[ERROR] ";
    }

    .feed-log p.fb-issue.fb-warning {
        color: orange;
    }

    .feed-log p.fb-issue.fb-warning:before {
        content: "[WARNING] ";
    }
</style>
<div class="row form-group-row">
    <div class="col-md-12 feed-log">
        <h4>Marketplace Feed Status</h4>
        <?php

        $log_file = dirname(dirname(__DIR__)) . "/adwords3/caches/marketplace-feeds-log/$cron_name.log";

        if(file_exists($log_file) && filemtime($log_file) > time() - 7 * 24 * 60 * 60) {
            echo file_get_contents($log_file);
        } else {
            echo "No log found for the dealership, <a href=\"https://tm.smedia.ca/marketplace-feed.php?dealership=$cron_name\" target=\"_blank\">Refresh Now.</a><br/><i>** Please reload the page once the feed is loaded in the new tab.</i>";
        }

        ?>
    </div>
</div>

<form method="POST" class="form-bordered" enctype="multipart/form-data" action="?dealership=<?= $cron_name ?>">
    <div class="panel-body">
        <div class="row mb-md">
            <div class="col-md-4 col-sm-5">
                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-8">
                        <div class="checkbox-custom chekbox-primary">
                            <input value="fb_marketplace_description" type="checkbox"
                                   name="fb_marketplace_description" id="fb_marketplace_description" <?= isset($CronConfigs[$cron_name]['banner']['fb_marketplace_description']) ? 'data-current="checked" checked' : 'data-current=""'; ?>/>
                            <label>Fb Marketplace Description</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-5" id="fb_marketplace_description_input" style="display: none">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Description</label>
                    <div class="col-sm-8">
                        <textarea rows = "3" cols = "50" name = "fb_marketplace_description_input"><?= isset($CronConfigs[$cron_name]['banner']['fb_marketplace_description']) ? $CronConfigs[$cron_name]['banner']['fb_marketplace_description'] : "[year] [make] [model]. Check it out today!"; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-2 pull-right">
                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-8 clearfix">
                        <button type="submit" id="facebook-save-changes" value="facebook-save-changes" name="btn" class="btn btn-info mr-xs pull-right ml-xs""> Save Changes </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<form method="POST" class="form-bordered" enctype="multipart/form-data" action="?dealership=<?= $cron_name ?>">
    <div class="panel-body">
        <div class="row mb-md">
            <div class="col-md-4 col-sm-5">
                <div class="form-group">
                    <label class="col-sm-4 control-label"> Make </label>

                    <div class="col-sm-8">
                        <select class="form-control" name="make" id="make" onchange="showCarModels()">
                            <option value="">--Select Make--</option>
                            <?php foreach ($feed_data as $key => $value): ?>
                            <option value="<?= $key ?>" <?php if ($selected_make == $key) echo 'selected' ; ?>> <?= $key ?> </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-5" id="model_div" name="model_div" class="hideMe">
                <div class="form-group">
                    <label class="col-sm-4 control-label"> Model </label>
                    <div class="col-sm-8">
                        <select class="form-control" name="model" id="model">
                            <option value="">--Select Model--</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-2 pull-right">
                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-8 clearfix">
                        <button type="submit" id="feed-preview-button" value="feed-preview-button" name="btn" class="btn btn-info mr-xs pull-right ml-xs" onclick="showModelDiv()"> Show Advertisement </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<style type="text/css">
    .hideMe
    {
        display: none;
    }
</style>


<script type="text/javascript">
	/**
	 * Shows the car models.
	 */
    function showCarModels()
    {
    	var make = $("#make").val();
    	var make_data = [];

		for(var key in feed_data[make])
		{
		  	if(feed_data[make].hasOwnProperty(key))
		  	{
		    	make_data.push(key);
		  	}
		}

		if (make != '')
    	{
    		$("#model_div").show();

	    	let dropdown = $("#model");
	        dropdown.empty();
	        dropdown.append('<option selected="true" disabled>--Select Model--</option>');
	        dropdown.prop('selectedIndex', 0);

	       	$.each(make_data, function (key, entry)
            {
                dropdown.append($("<option></option>").prop('value', entry).text(entry));
            })
	    }
	    else
        {
            $("#model_div").hide();
        }
    }


    /**
     * Shows the model div.
     */
    function showModelDiv()
    {
    	$("#model_div").removeClass("hideMe");
    }

    $(document).ready(function () {
        if ($('#fb_marketplace_description').is(":checked")) {
            $('#fb_marketplace_description_input').show();
        }
        $('#fb_marketplace_description').change(function () {
            $('#fb_marketplace_description_input').fadeToggle();
        });
    });
</script>

<?php

	foreach ($all_cars_db as $stock_number => $car):

    if ($car['arrival_date'] > $older_than_date && !empty($older_than))
    {
        continue;
    }

    if($car['make'] != $selected_make || $car['model'] != $selected_model)
    {
    	continue;
    }

    foreach ($formats as $format):
        $stock_number = trim($stock_number);

        if ((!$car['deleted']) && ($inc_stock_type == 'all' || $inc_stock_type == $car['stock_type'] || $inc_type == $car['stock_type'])):
            if ($inc_type == 'certified' && ($inc_type != $car['stock_type'] && $car['certified'] != 1))
            {
                continue; //For certified inventory only show certified
            }

            $car = apply_filters("filter_for_fb_$cron_name", $car, $feed_type, $stock_type);

            if (!$car)
            {
                continue;
            }

            $total++;
            $car['make']       	= prettyString($car['make']);
            $car['model']      	= prettyString($car['model']);
            $year              	= $car['year'];
            $make              	= $car['make'];
            $model             	= $car['model'];
            $trim              	= $car['trim'];
            $body_style        	= $car['body_style'];
            $price             	= butifyPrice($car['price']);
            $stock_type        	= $car['stock_type'];
            $actual_stock_type 	= $stock_type == 'device' ? 'new' : ($stock_type == 'accessory' ? 'new' : ($stock_type == 'new' ? 'new' : 'used'));
            $lyear 				= strtolower($year);
            $lmake  			= strtolower($make);
            $lmodel 			= strtolower($model);
            $ltrim  			= strtolower($trim);

            if ($actual_stock_type != 'new' && $actual_stock_type != 'used')
            {
                continue;
            }

            $image_url1 		= count($car['images']) > 0 ? $car['images'][0] : null;
            $image_url2 		= count($car['images']) > 1 ? $car['images'][1] : $image_url1;
            $image_url3 		= count($car['images']) > 2 ? $car['images'][2] : $image_url1;
            $image_url4 		= count($car['images']) > 3 ? $car['images'][3] : $image_url1;
            $utm_tags     		= isset($cron_config['utm_tags']) ? filter_var($cron_config['utm_tags'], FILTER_VALIDATE_BOOLEAN) : true;
            $utm_source   		= filter_input(INPUT_GET, 'utm_source');
            $utm_medium   		= filter_input(INPUT_GET, 'utm_medium');
            $utm_campaign 		= filter_input(INPUT_GET, 'utm_campaign');

            if (!$utm_source)
            {
                $utm_source = "smedia_$feed_type";
            }

            if (!$utm_medium)
            {
                $utm_medium = 'facebook';
            }

            $url = $car['url'];

            if ($utm_tags)
            {
                $utm_source   = apply_filters("filter_{$cron_name}_utm_source", $utm_source, $feed_type, $stock_type);
                $utm_medium   = apply_filters("filter_{$cron_name}_utm_medium", $utm_medium, $feed_type, $stock_type);
                $utm_campaign = apply_filters("filter_{$cron_name}_utm_campaign", $utm_campaign, $feed_type, $stock_type);

                $utm = "?utm_source=$utm_source";
                if ($utm_medium)
                {
                    $utm .= "&utm_medium=$utm_medium";
                }

                if ($utm_campaign)
                {
                    $utm .= "&utm_campaign=$utm_campaign";
                }

                $url = urlCombine($url, $utm);
            }

            $min_images = isset($cron_config['banner']['min_images']) ? $cron_config['banner']['min_images'] : 1;

            if (count($car["images"]) < $min_images)
            {
                continue;
            }

            if (!$image_url1)
            {
                continue;
            }

            if ($format && $format == 'mobile' && !($image_url1 && $image_url2 && $image_url3))
            {
                continue;
            }

            $sprice = $price;
            $hst    = isset($cron_config['banner']['hst']) ? $cron_config['banner']['hst'] : false;
            $hst_l1 = isset($cron_config['banner']['hst_l1']) ? $cron_config['banner']['hst_l1'] : false;
            $hst_l2 = isset($cron_config['banner']['hst_l2']) ? $cron_config['banner']['hst_l2'] : false;

            if ($hst)
            {
                if (!$hst_l1 && !$hst_l2)
                {
                    $sprice = "$price +HST&LIC";
                }
                else
                {
                    $sprice = trim("$price $hst_l1 $hst_l2");
                }
            }

            $car['price']    = $sprice; //force templates to render with +HST&LIC
            $car['biweekly'] = butifyPrice($car['biweekly']);

            $title    = "$year $make $model";
            $fb_title = $title;

            if (numarifyPrice($price) >= 0)
            {
                $title = $title . ' ' . $sprice;
            }

            if ($include_stock)
            {
                $title .= " Stock # $stock_number";
            }

            if (strlen($title) > 100)
            {
                if (strlen("$year $make $model") <= 100)
            	{
                    $title = "$year $make $model";
                }
                else
            	{
                    $title = $car['make'] . " " . $car["model"];
                    if (strlen($title) > 100)
            		{
                        continue;
                    }
                }
            }

            //$biweekly = $car['biweekly'];

            if (isset($cron_config['banner']['fb_title']))
            {
                $title_template = $cron_config['banner']['fb_title'];
                $title          = processTextTemplate($title_template, $car, true);
                $fb_title       = $title;
            }

            if (isset($cron_config['fb_title']))
            {
                $title_template = $cron_config['fb_title'];
                $title          = processTextTemplate($title_template, $car, true);
            }

            if (isset($cron_config['banner']["fb_{$feed_type}_title"]))
            {
                $title_template = $cron_config['banner']["fb_{$feed_type}_title"];
                $title          = processTextTemplate($title_template, $car, true);
                $fb_title       = $title;
            }

            if (isset($cron_config["fb_{$feed_type}_title"]))
            {
                $title_template = $cron_config["fb_{$feed_type}_title"];
                $title          = processTextTemplate($title_template, $car, true);
            }

            $fb_brand_template = "[year] [make] [model]";

            if (isset($cron_config['fb_brand']))
            {
                $fb_brand_template = $cron_config['fb_brand'];
            }

            $fb_brand = trim(processTextTemplate($fb_brand_template, $car, true));
            $fb_banner_title = $fb_title;

            if (isset($cron_config['banner']['fb_banner_title']))
            {
                $fb_banner_title_template = $cron_config['banner']['fb_banner_title'];
                $fb_banner_title          = processTextTemplate($fb_banner_title_template, $car, true);
            }

            if (isset($cron_config['banner']["fb_{$feed_type}_banner_title"]))
            {
                $fb_banner_title_template = $cron_config['banner']["fb_{$feed_type}_banner_title"];
                $fb_banner_title          = processTextTemplate($fb_banner_title_template, $car, true);
            }

            $description_template = "Test drive the [year] [make] [model] today.";

            if (isset($cron_config['banner']['fb_description']))
            {
                $description_template = $cron_config['banner']['fb_description'];
            }
            if (isset($cron_config['banner']["fb_description_$stock_type"]))
            {
                $description_template = $cron_config['banner']["fb_description_$stock_type"];
            }
            if (isset($cron_config['banner']["fb_description_$lmake"]))
            {
                $description_template = $cron_config['banner']["fb_description_$lmake"];
            }
            if (isset($cron_config['banner']["fb_description_{$lyear}_$lmake"]))
            {
                $description_template = $cron_config['banner']["fb_description_{$lyear}_$lmake"];
            }
            if (isset($cron_config['banner']["fb_description_$lmodel"]))
            {
                $description_template = $cron_config['banner']["fb_description_$lmodel"];
            }
            if (isset($cron_config['banner']["fb_description_{$lyear}_$lmodel"]))
            {
                $description_template = $cron_config['banner']["fb_description_{$lyear}_$lmodel"];
            }
            if (isset($cron_config['banner']["fb_description_{$stock_type}_{$lmake}"]))
            {
                $description_template = $cron_config['banner']["fb_description_{$stock_type}_{$lmake}"];
            }

            //Feed type
            if (isset($cron_config['banner']["fb_{$feed_type}_description"]))
            {
                $description_template = $cron_config['banner']["fb_{$feed_type}_description"];
            }
            if (isset($cron_config['banner']["fb_{$feed_type}_description_$stock_type"]))
            {
                $description_template = $cron_config['banner']["fb_{$feed_type}_description_$stock_type"];
            }
            if (isset($cron_config['banner']["fb_{$feed_type}_description_$lmake"]))
            {
                $description_template = $cron_config['banner']["fb_{$feed_type}_description_$lmake"];
            }
            if (isset($cron_config['banner']["fb_{$feed_type}_description_{$lyear}_$lmake"]))
            {
                $description_template = $cron_config['banner']["fb_{$feed_type}_description_{$lyear}_$lmake"];
            }
            if (isset($cron_config['banner']["fb_{$feed_type}_description_$lmodel"]))
            {
                $description_template = $cron_config['banner']["fb_{$feed_type}_description_$lmodel"];
            }
            if (isset($cron_config['banner']["fb_{$feed_type}_description_{$lyear}_$lmodel"]))
            {
                $description_template = $cron_config['banner']["fb_{$feed_type}_description_{$lyear}_$lmodel"];
            }
            if (isset($cron_config['banner']["fb_{$feed_type}_description_{$stock_type}_{$lmake}"]))
            {
                $description_template = $cron_config['banner']["fb_{$feed_type}_description_{$stock_type}_{$lmake}"];
            }

            $description = apply_filters("filter_{$cron_name}_fb_description", processTextTemplate($description_template, $car, true), $car, $feed_type); //"$make $model starting at $biweekly";
            $type = $stock_type . $feed_type;
            $certified_dir = dirname(__DIR__) . '/adwords3/templates/' . $cron_name . '/' . 'certified-' . $type . '/';

            if ($car['certified'] && is_dir($certified_dir))
            {
                $type = 'certified-' . $type;
            }

            $title_color = rawurlencode(@$cron_config['banner']['font_color']);

            $template_dirs     = getTemplateDirs($cron_name, $type, $year, $make, $model, $trim);

            $custom_file       	= map_template_path($template_dirs, "168x315.png", $cron_name);
            $custom_file_right 	= map_template_path($template_dirs, "356x630.png", $cron_name);
            $mobile_file       	= map_template_path($template_dirs, "382x98.png", $cron_name);
            $custom_file1200 	= map_template_path($template_dirs, "336x630.png", $cron_name);
            $mobile_file1200 	= map_template_path($template_dirs, "1200x315.png", $cron_name);

            $banner_size = ($format && $format == 'mobile') ? ($mobile_file1200 ? 'custom-mobile1200' : ($mobile_file ? 'custom-mobile' : 'mobile')) : ($custom_file1200 ? 'custom1200' : ($custom_file || $custom_file_right ? 'custom' : '600x315'));
            $style       = isset($cron_config['banner']["fb_style_$stock_type"]) ? $cron_config['banner']["fb_style_$stock_type"] : (isset($cron_config['banner']['fb_style']) ? $cron_config['banner']['fb_style'] : ($plain ? 'plainfbad' : 'facebook_new_ad')); //'facebookad'));
            $style_to_use = apply_filters("filter_style_$cron_name", $style, $car, 'fb_style');

            if ($format == "instagram")
            {
                $banner_size = "1080x1080";
                //$style          = "facebookad";
            }

            if ($include_stock)
            {
                $banner_size = "wstock_{$banner_size}";
            }

            $params = array(
                'lang'         => $lang,
                'config'       => $banner_size,
                'template'     => $cron_name,
                'style'        => $style_to_use,
                'type'         => $type,
                'stock_number' => $stock_number,
                'year'         => $year,
                'title'        => $fb_banner_title,
                'make'         => $make,
                'model'        => $model,
                'trim'         => $trim,
                'body_style'   => $body_style,
                'price'        => $price,
                'img1'         => $image_url1,
                'img2'         => $image_url2,
                'img3'         => $image_url3,
                'img4'         => $image_url4,
                'title_color'  => $title_color,
                'hst'          => $hst ? 'true' : 'false',
                'th'           => $calculated_hash,
            );

            if (isset($cron_config['proxy-area']))
            {
                $params['proxy-area'] = $cron_config['proxy-area'];
            }

            if (isset($cron_config['banner']['params']))
            {
                $params = array_merge($params, $cron_config['banner']['params']);
            }

            if (isset($cron_config['banner']['marketting_lines']))
            {
                $marketting_lines = $cron_config['banner']['marketting_lines']($car);
                $params           = array_merge($params, $marketting_lines);
            }

            if ($hst_l1)
            {
                $params['hst_l1'] = $hst_l1;
            }
            if ($hst_l2)
            {
                $params['hst_l2'] = $hst_l2;
            }

            $final_params = apply_filters("filter_{$cron_name}_banner_params", $params);
            $prev_img_query = http_build_query($final_params);
            $image_url = "https://tm.smedia.ca/adwords3/banner.php?$prev_img_query";

            echo "<script>";
            echo "var img_urls = " . json_encode($image_url) . "; \n";
            echo "var img_url1 = " . json_encode($image_url1) . "; \n";
            echo "var img_url2 = " . json_encode($image_url2) . "; \n";
            echo "var img_url3 = " . json_encode($image_url3) . "; \n";
            echo "var img_url4 = " . json_encode($image_url4) . "; \n";
			echo "console.log({img_urls, img_url1, img_url2, img_url3, img_url4});";
            echo "</script>";

            $was = isset($car['was']) ? $car['was'] : '';

            if (numarifyPrice($price) >= 0)
            {
                $price = numarifyPrice($price) . ' CAD';
            }
            else
            {
                $price = '';
            }

            if (numarifyPrice($was) >= 0)
            {
                $was = numarifyPrice($was) . ' CAD';
            }
            else
            {
                $was = null;
            }

            if (!$fb_banner_title || !$title || !$description)
            {
                continue;
            } //These are required

            if (!$price)
            {
                continue;
            } //Avoid error in feed

            $fb_fulfilled++;
?>
               	<div class="panel panel-info">
                    <div class="panel-heading">
                        <a href= "<?= $url ?>" target="_blank">
                            <?= $title ?>
                        </a>
                    </div>

                    <div class="panel-body">
                        <p>
                                <?= $description ?>
                        </p>
                        <img style="width: 100%" src="<?= str_replace('600x315', 'custom1200', $image_url) ?>"></img>
                    </div>
                </div>
<?php
            endif;
        endforeach;
    endforeach;
?>

