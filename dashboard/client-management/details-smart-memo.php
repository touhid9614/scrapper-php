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

global $scrapper_configs, $single_config, $smart_memo_default;

$single_config 		= $_GET['dealership'];
$template_directory = ADSYNCPATH . "templates/{$cron_name}/";

$smart_memo = isset($cron_config['smart_memo']) ? array_merge($smart_memo_default, $cron_config['smart_memo']) : $smart_memo_default;

$string_elements_color = ['bg_color', 'text_color', 'border_color', 'button_text_color'];
$typearr_color         = ['button_color', 'button_color_hover', 'button_color_active'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-smart-memo')) {
	$smart_memo['url']  		 = $_POST['smart_memo_url'];
	$smart_memo['home_url']  	 = $_POST['smart_memo_home_url'];
	$smart_memo['service_regex'] = $_POST['smart_memo_service_regex'];
	$smart_memo['button_text']   = $_POST['smart_button_text'];
	$smart_memo['video_url']     = $_POST['smart_memo_video_url'];

	foreach ($smart_memo as $sf_key => $sf_value) {
		$type = gettype($sf_value);

		if ($type == 'boolean') {
            $smart_memo[$sf_key] = filter_input(INPUT_POST, $sf_key) ? true : false;
        } elseif ($type == 'string' && in_array($sf_key, $string_elements_color)) {
            $smart_memo[$sf_key] = '#' . filter_input(INPUT_POST, $sf_key);
        } elseif ($type == 'array' && in_array($sf_key, $typearr_color)) {
            $color_values = $_POST[$sf_key];
            $colors       = [];

            for ($ci = 0, $cvc = count($color_values); $ci < $cvc; $ci++) {
                $colors[] = '#' . $color_values[$ci];
            }

            $smart_memo[$sf_key] = $colors;
        } else {
            $smart_memo[$sf_key] = $sf_value;
        }
	}

    $configFile = s3DealerConfig($cron_name);
    $sf_parser  = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

    try {
        $sf_ast = $sf_parser->parse($configFile);
    } catch (Error $error) {
        echo 'Error Parse';
        print_r($error->getMessage());
        return;
    }

	$sf_traverser = new NodeTraverser();

    if (isset($cron_config['smart_memo'])) {
        $sf_traverser->addVisitor(new configUpdater([
            'key'   => ['smart_memo'],
            'value' => $smart_memo,
        ]));
    } else {
        $sf_traverser->addVisitor(new configCreator('smart_memo', $smart_memo));
    }

    $cron_config['smart_memo'] = $smart_memo;

    configsUpdate($cron_config, $cron_name);

    try {
        $sf_ast              = $sf_traverser->traverse($sf_ast);
        $prettyPrinter       = new ePrinter();
        $config_file_content = $prettyPrinter->prettyPrintFile($sf_ast);
    } catch (Error $error) {
        echo 'Error in traverse';
    }

    s3Update($config_file_content, $cron_name);

    $key = ['new', 'used', 'home', 'service'];

    foreach ($key as $memo_type) {
        $file      = $memo_type . '_smart_memo_file';
        $file_name = isset($_FILES[$file]) ? $_FILES[$file] : '';

        if (isset($file_name['tmp_name']) && !empty($file_name['tmp_name'])) {
            $type       = $file_name['type'];
            $temp_dir   = $file_name['tmp_name'];
            $target_dir = $template_directory . $memo_type . '-smart-memo-bg.png';

            if ($type == 'image/png') {
                move_uploaded_file($temp_dir, $target_dir);
            }
        }

        DbConnect::store_log($user_id, $user['type'], 'Dealer smart memo image uploaded', 'Dealer smart memo image uploaded where dealer name- ' . $cron_name, $cron_name);
    }

    echo("<script type='text/javascript'> location.href = location.href; </script>");
}
?>

<div class="row form-group-row clearfix">
	<form method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data" action="?dealership=<?= $cron_name ?>">
		<div class="col-md-12">
			<section class="panel panel-info">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action"></a>
					</div>
					<h2 class="panel-title"> Smart Memo </h2>
				</header>

			    <div class="panel-body clearfix">
					<div class="row form-group-row">
				        <div class="col-md-6">
			                <label class="col-md-4 control-label">Smart Memo Live<span style="color: red;">*</span></label>
			                <div class="col-md-8">
	                            <label class="ios7-switch">
									<input type="checkbox" name="live" value="1" data-plugin-ios-switch <?= $smart_memo['live'] ? 'checked' : '' ?>/>
								</label>
	                        </div>
				        </div>

				        <div class="col-md-6">
			                <label class="col-md-4 control-label">Hide Redirection Button</label>
			                <div class="col-md-8">
	                            <label class="ios7-switch">
									<input type="checkbox" name="hide_redirection" value="1" data-plugin-ios-switch <?= $smart_memo['hide_redirection'] ? 'checked' : '' ?>/>
								</label>
	                        </div>
				        </div>
				    </div>

				    <div class="row form-group-row">
				        <div class="col-md-6">
			                <label class="col-md-4 control-label">Smart Memo Live (New VDPs)</label>
			                <div class="col-md-8">
	                            <label class="ios7-switch">
									<input type="checkbox" name="live_new" value="1" data-plugin-ios-switch <?= $smart_memo['live_new'] ? 'checked' : '' ?>/>
								</label>
	                        </div>
				        </div>

				        <div class="col-md-6">
			                <label class="col-md-4 control-label">Smart Memo Live (Used VDPs)</label>
			                <div class="col-md-8">
	                            <label class="ios7-switch">
									<input type="checkbox" name="live_used" value="1" data-plugin-ios-switch <?= $smart_memo['live_used'] ? 'checked' : '' ?>/>
								</label>
	                        </div>
				        </div>
				    </div>

				    <div class="row form-group-row">
				        <div class="col-md-6">
			                <label class="col-md-4 control-label">Smart Memo Live (Home Page)</label>
			                <div class="col-md-8">
	                            <label class="ios7-switch">
									<input type="checkbox" name="live_home" value="1" data-plugin-ios-switch <?= $smart_memo['live_home'] ? 'checked' : '' ?>/>
								</label>
	                        </div>
				        </div>

				        <div class="col-md-6">
			                <label class="col-md-4 control-label">Smart Memo Live (Service Pages)</label>
			                <div class="col-md-8">
	                            <label class="ios7-switch">
									<input type="checkbox" name="live_service" value="1" data-plugin-ios-switch <?= $smart_memo['live_service'] ? 'checked' : '' ?>/>
								</label>
	                        </div>
				        </div>
				    </div>

				    <div class="row form-group-row">
				        <?php
				        foreach ($string_elements_color as $item) {
				        ?>
				            <div class="col-md-6 mt-md">
				                <div class="form-group">
				                    <label class="col-md-4 control-label"><?= ucwords(str_replace('_', ' ', $item)) ?></label>
				                    <div class="col-md-8">
				                        <input type="text" name="<?= $item ?>" class="form-control jscolor" value="<?= $smart_memo[$item] ?>">
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
				                    <?php for ($ci = 0, $itemLen = count($smart_memo[$item]); $ci < $itemLen; $ci++) { ?>
			                        <div class="col-md-4">
			                            <input type="text" name="<?= $item ?>[]" class="form-control jscolor" value="<?= $smart_memo[$item][$ci] ?>">
			                        </div>
				                    <?php } ?>
				                </div>
				            </div>
				        <?php
				        }
				        ?>
				    </div>

					<div class="row form-group-row">
				        <div class="col-md-12">
			                <label class="col-md-4 control-label">Smart Memo Submit Button Text<span style="color: red;">*</span></label>
			                <div class="col-md-8">
	                            <input type="text" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter Smart Form Submit Button Text" data-current="<?= $smart_memo['button_text'] ?>" placeholder="learn more" name="smart_button_text" class="form-control" value="<?= $smart_memo['button_text'] ?>">
	                        </div>
				        </div>
				    </div>

					<div class="row form-group-row">
				        <div class="col-md-12">
			                <label class="col-md-4 control-label">Smart Memo Redirect URL<span style="color: red;">*</span></label>
			                <div class="col-md-8">
	                            <input type="text" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter Smart Memo Redirect URL" data-current="<?= $smart_memo['url'] ?>" placeholder="https://www.example.com/contact-us/" name="smart_memo_url" class="form-control italic-placeholder" value="<?= $smart_memo['url'] ?>">
	                        </div>
				        </div>
				    </div>

				    <div class="row form-group-row">
				        <div class="col-md-12">
			                <label class="col-md-4 control-label">Smart Memo Homepage URL<span style="color: red;">*</span></label>
			                <div class="col-md-8">
	                            <input type="text" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter Smart Memo homepage URL with https" data-current="<?= $smart_memo['home_url'] ?>" placeholder="https://www.example.com/en/" name="smart_memo_home_url" class="form-control italic-placeholder" value="<?= $smart_memo['home_url'] ?>">
	                        </div>
				        </div>
				    </div>

				    <div class="row form-group-row">
				        <div class="col-md-12">
			                <label class="col-md-4 control-label">Service Page Regex</label>
			                <div class="col-md-8">
	                            <input type="text" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter dealership service page regex" data-current="<?= $smart_memo['service_regex'] ?>" placeholder="" name="smart_memo_service_regex" class="form-control italic-placeholder" value="<?= $smart_memo['service_regex'] ?>">
	                        </div>
				        </div>
				    </div>

				    <div class="row form-group-row">
				        <div class="col-md-6 mt-md">
				            <h4>Only For Video Smart Memo</h4>
				        </div>
				    </div>

				    <div class="row form-group-row">
				        <div class="col-md-6">
			                <label class="col-md-4 control-label">Video Smart Memo</label>
			                <div class="col-md-8">
	                            <label class="ios7-switch">
									<input type="checkbox" name="video" value="1" data-plugin-ios-switch <?= $smart_memo['video'] ? 'checked' : '' ?>/>
								</label>
	                        </div>
				        </div>

				        <div class="row form-group-row">
					        <div class="col-md-6">
				                <label class="col-md-4 control-label">Smart Memo Video URL</span></label>
				                <div class="col-md-8">
		                            <input type="text" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter Smart Memo video URL with https" data-current="<?= $smart_memo['video_url'] ?>" placeholder="https://www.youtube.com/" name="smart_memo_video_url" class="form-control italic-placeholder" value="<?= $smart_memo['video_url'] ?>">
		                        </div>
					        </div>
					    </div>
				    </div>

					<div class="row form-group-row">
						<div class="col-md-12">
					        <?php
					        $key = ['new', 'used', 'home', 'service'];

					        foreach ($key as $memo_type) {
					        	if (file_exists($template_directory . $memo_type . '-smart-memo-bg.png')) {
				                    $template_filename = '../adwords3/templates/' . $cron_name . '/' . $memo_type . '-smart-memo-bg.png';
				                } else {
				                    $template_filename = '../adwords3/templates/' . $cron_name . '/popup-bg.png';
				                }
					        ?>
				                <div class="col-md-12">
				                    <label class="col-md-4 control-label" for="inputDefault"> <?= ucwords($memo_type) ?> File</label>

				                    <div class="col-md-4">
				                        <div class="thumbnail-gallery">
				                            <a class="img-thumbnail lightbox" href="<?= $template_filename ?>" data-plugin-options="{ &quot;type&quot;:&quot;image&quot; }">
				                                <img class="img-responsive" width="215" src="<?= $template_filename ?>">
				                            </a>
				                        </div>
				                    </div>

				                    <div class="col-md-4">
				                        <input type="file" name="<?= $memo_type ?>_smart_memo_file" class="form-control" accept="image/x-png">
				                    </div>
				                </div>
					        <?php
					        }
					        ?>
					        <div class="col-md-4">
					            <div class="form-group">
					                <button name="btn" value="save-smart-memo" class="btn btn-primary pull-right">Save Changes</button>
					            </div>
					        </div>
				    	</div>
				    </div>
				</div>
			</section>
		</div>
	</form>
</div>