<?php

    use PhpParser\Error;
    use PhpParser\ParserFactory;
    use PhpParser\NodeTraverser;

    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;
    use Aws\Common\Exception\MultipartUploadException;
    use Aws\S3\MultipartUploader;

    require_once 'client-management/configUpdater.php';

    //Find the config file name by searching into all files
    $config_file_name = get_config_path($cron_name);
    $mail_retargeting_status = isset($cron_config['mail_retargeting']) ? true : false;
    $selected_option = 'defult';
    $mail_retargeting_value = '';

    $template_directory = ADSYNCPATH . 'templates/' . $cron_name . '/';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-mail-retargeting')) 
    {
        $enable_mail_retargetting = filter_input(INPUT_POST, 'enable_mail_retargetting', FILTER_VALIDATE_BOOLEAN);
        $reach_dynamic_client_id = filter_input(INPUT_POST, 'reach_dynamic_client_id');
        $selected_option = filter_input(INPUT_POST, 'selected_option');
        $promotion_text = filter_input(INPUT_POST, 'promotion_text');
        $promotion_color = filter_input(INPUT_POST, 'promotion_color');
        $overlay_color = filter_input(INPUT_POST, 'overlay_color');
        $overlay_text_colour = filter_input(INPUT_POST, 'overlay_text_colour');
        $price_color = filter_input(INPUT_POST, 'price_color');
        $coupon_validity = filter_input(INPUT_POST, 'coupon_validity');



        $mail_retargeting = array(
            "enabled" => $enable_mail_retargetting,
            "client_id" => $reach_dynamic_client_id
        );

        $mail_retargeting_value = $cron_config['mail_retargeting'];

        if ($selected_option == 'new') 
        {
            isset($mail_retargeting_value['promotion_text']) ? $mail_retargeting += ["promotion_text" => $mail_retargeting_value['promotion_text']] : '';
            isset($mail_retargeting_value['promotion_color']) ? $mail_retargeting += ["promotion_color" => $mail_retargeting_value['promotion_color']] : '';
            isset($mail_retargeting_value['overlay_color']) ? $mail_retargeting += ["overlay_color" => $mail_retargeting_value['overlay_color']] : '';
            isset($mail_retargeting_value['overlay_text_colour']) ? $mail_retargeting += ["overlay_text_colour" => $mail_retargeting_value['overlay_text_colour']] : '';
            isset($mail_retargeting_value['price_color']) ? $mail_retargeting += ["price_color" => $mail_retargeting_value['price_color']] : '';
            isset($mail_retargeting_value['coupon_validity']) ? $mail_retargeting += ["coupon_validity" => $mail_retargeting_value['coupon_validity']] : '';

            if (isset($mail_retargeting_value['used'])) 
            {
                $mail_retargeting_used = array(
                    "promotion_text" => $mail_retargeting_value['used']['promotion_text'],
                    "promotion_color" => $mail_retargeting_value['used']['promotion_color'],
                    "overlay_color" => $mail_retargeting_value['used']['overlay_color'],
                    "overlay_text_colour" => $mail_retargeting_value['used']['overlay_text_colour'],
                    "price_color" => $mail_retargeting_value['used']['price_color'],
                    "coupon_validity" => $mail_retargeting_value['used']['coupon_validity']
                );

                $mail_retargeting += ["used" => $mail_retargeting_used];
            }

            $mail_retargeting_new = array(
                "promotion_text" => $promotion_text,
                "promotion_color" => '#' . $promotion_color,
                "overlay_color" => '#' . $overlay_color,
                "overlay_text_colour" => '#' . $overlay_text_colour,
                "price_color" => '#' . $price_color,
                "coupon_validity" => $coupon_validity
            );

            $mail_retargeting += ["new" => $mail_retargeting_new];

        } 
        else if ($selected_option == 'used') 
        {

            isset($mail_retargeting_value['promotion_text']) ? $mail_retargeting += ["promotion_text" => $mail_retargeting_value['promotion_text']] : '';
            isset($mail_retargeting_value['promotion_color']) ? $mail_retargeting += ["promotion_color" => $mail_retargeting_value['promotion_color']] : '';
            isset($mail_retargeting_value['overlay_color']) ? $mail_retargeting += ["overlay_color" => $mail_retargeting_value['overlay_color']] : '';
            isset($mail_retargeting_value['overlay_text_colour']) ? $mail_retargeting += ["overlay_text_colour" => $mail_retargeting_value['overlay_text_colour']] : '';
            isset($mail_retargeting_value['price_color']) ? $mail_retargeting += ["price_color" => $mail_retargeting_value['price_color']] : '';
            isset($mail_retargeting_value['coupon_validity']) ? $mail_retargeting += ["coupon_validity" => $mail_retargeting_value['coupon_validity']] : '';

            if (isset($mail_retargeting_value['new'])) 
            {
                $mail_retargeting_new = array(
                    "promotion_text" => $mail_retargeting_value['new']['promotion_text'],
                    "promotion_color" => $mail_retargeting_value['new']['promotion_color'],
                    "overlay_color" => $mail_retargeting_value['new']['overlay_color'],
                    "overlay_text_colour" => $mail_retargeting_value['new']['overlay_text_colour'],
                    "price_color" => $mail_retargeting_value['new']['price_color'],
                    "coupon_validity" => $mail_retargeting_value['new']['coupon_validity']
                );

                $mail_retargeting += ["new" => $mail_retargeting_new];
            }

            $mail_retargeting_used = array(
                "promotion_text" => $promotion_text,
                "promotion_color" => '#' . $promotion_color,
                "overlay_color" => '#' . $overlay_color,
                "overlay_text_colour" => '#' . $overlay_text_colour,
                "price_color" => '#' . $price_color,
                "coupon_validity" => $coupon_validity
            );

            $mail_retargeting += ["used" => $mail_retargeting_used];

        } 
        else 
        {
            $mail_retargeting += 
            [
                "promotion_text" => $promotion_text,
                "promotion_color" => '#' . $promotion_color,
                "overlay_color" => '#' . $overlay_color,
                "overlay_text_colour" => '#' . $overlay_text_colour,
                "price_color" => '#' . $price_color,
                "coupon_validity" => $coupon_validity
            ];

            if (isset($mail_retargeting_value['new'])) 
            {
                $mail_retargeting_new = array(
                    "promotion_text" => $mail_retargeting_value['new']['promotion_text'],
                    "promotion_color" => $mail_retargeting_value['new']['promotion_color'],
                    "overlay_color" => $mail_retargeting_value['new']['overlay_color'],
                    "overlay_text_colour" => $mail_retargeting_value['new']['overlay_text_colour'],
                    "price_color" => $mail_retargeting_value['new']['price_color'],
                    "coupon_validity" => $mail_retargeting_value['new']['coupon_validity']
                );

                $mail_retargeting += ["new" => $mail_retargeting_new];
            }

            if (isset($mail_retargeting_value['used'])) 
            {
                $mail_retargeting_used = array(
                    "promotion_text" => $mail_retargeting_value['used']['promotion_text'],
                    "promotion_color" => $mail_retargeting_value['used']['promotion_color'],
                    "overlay_color" => $mail_retargeting_value['used']['overlay_color'],
                    "overlay_text_colour" => $mail_retargeting_value['used']['overlay_text_colour'],
                    "price_color" => $mail_retargeting_value['used']['price_color'],
                    "coupon_validity" => $mail_retargeting_value['used']['coupon_validity']
                );

                $mail_retargeting += ["used" => $mail_retargeting_used];
            }

        }

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

        if ($mail_retargeting_status) {
            $traverser->addVisitor(new configUpdater([
                'key' => ['mail_retargeting'],
                'value' => $mail_retargeting
            ]));
        } else {
            $traverser->addVisitor(new configCreator('mail_retargeting', $mail_retargeting));
        }

        $cron_config['mail_retargeting']=$mail_retargeting;

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
        * Log added start
        */
        $log_mail_status= $enable_mail_retargetting ? $enable_mail_retargetting : 0;
        DbConnect::store_log($user_id, $user['type'],  'Dealer mail retargeting', 'Dealer mail retargeting change where dealer name- ' . $cron_name . ' and status is- ' . $log_mail_status , $cron_name );
        /*
        * Log added end
        */

        /*
         * Refresh page after updation
         */
        echo ("<script type='text/javascript'> location.href= location.href; </script>");
    }

    $mail_retargeting = $cron_config['mail_retargeting'];


    $mail_retargeting_value['defult'] = 
    [
        'promotion_text' => isset($mail_retargeting['promotion_text']) ? $mail_retargeting['promotion_text'] : '',
        'promotion_color' => isset($mail_retargeting['promotion_color']) ? $mail_retargeting['promotion_color'] : '567DC0',
        'overlay_color' => isset($mail_retargeting['overlay_color']) ? $mail_retargeting['overlay_color'] : 'ff8500',
        'overlay_text_colour' => isset($mail_retargeting['overlay_text_colour']) ? $mail_retargeting['overlay_text_colour'] : 'ffffff',
        'price_color' => isset($mail_retargeting['price_color']) ? $mail_retargeting['price_color'] : 'ff8500',
        'coupon_validity' => isset($mail_retargeting['coupon_validity']) ? $mail_retargeting['coupon_validity'] : '7',
    ];


    $mail_retargeting_value['new'] = 
    [
        'promotion_text' => isset($mail_retargeting['new']['promotion_text']) ? $mail_retargeting['new']['promotion_text'] : $mail_retargeting_value['defult']['promotion_text'],
        'promotion_color' => isset($mail_retargeting['new']['promotion_color']) ? $mail_retargeting['new']['promotion_color'] : $mail_retargeting_value['defult']['promotion_color'],
        'overlay_color' => isset($mail_retargeting['new']['overlay_color']) ? $mail_retargeting['new']['overlay_color'] : $mail_retargeting_value['defult']['overlay_color'],
        'overlay_text_colour' => isset($mail_retargeting['new']['overlay_text_colour']) ? $mail_retargeting['new']['overlay_text_colour'] : $mail_retargeting_value['defult']['overlay_text_colour'],
        'price_color' => isset($mail_retargeting['new']['price_color']) ? $mail_retargeting['new']['price_color'] : $mail_retargeting_value['defult']['price_color'],
        'coupon_validity' => isset($mail_retargeting['new']['coupon_validity']) ? $mail_retargeting['new']['coupon_validity'] : $mail_retargeting_value['defult']['coupon_validity'],
    ];


    $mail_retargeting_value['used'] = 
    [
        'promotion_text' => isset($mail_retargeting['used']['promotion_text']) ? $mail_retargeting['used']['promotion_text'] : $mail_retargeting_value['defult']['promotion_text'],
        'promotion_color' => isset($mail_retargeting['used']['promotion_color']) ? $mail_retargeting['used']['promotion_color'] : $mail_retargeting_value['defult']['promotion_color'],
        'overlay_color' => isset($mail_retargeting['used']['overlay_color']) ? $mail_retargeting['used']['overlay_color'] : $mail_retargeting_value['defult']['overlay_color'],
        'overlay_text_colour' => isset($mail_retargeting['used']['overlay_text_colour']) ? $mail_retargeting['used']['overlay_text_colour'] : $mail_retargeting_value['defult']['overlay_text_colour'],
        'price_color' => isset($mail_retargeting['used']['price_color']) ? $mail_retargeting['used']['price_color'] : $mail_retargeting_value['defult']['price_color'],
        'coupon_validity' => isset($mail_retargeting['used']) ? $mail_retargeting['used']['coupon_validity'] : $mail_retargeting_value['defult']['coupon_validity'],
    ];


    foreach ($mail_retargeting_value as $key => $oldvalue) 
    {
        $mail_retargeting_value[$key]['promotion_color'] = str_replace("#", "", $mail_retargeting_value[$key]['promotion_color']);
        $mail_retargeting_value[$key]['overlay_color'] = str_replace("#", "", $mail_retargeting_value[$key]['overlay_color']);
        $mail_retargeting_value[$key]['overlay_text_colour'] = str_replace("#", "", $mail_retargeting_value[$key]['overlay_text_colour']);
        $mail_retargeting_value[$key]['price_color'] = str_replace("#", "", $mail_retargeting_value[$key]['price_color']);
    }


    if ($mail_retargeting_status) 
    {
        $mail_retargeting = $cron_config['mail_retargeting'];

        $query_params = 
        [
            'logo' => "https://tm.smedia.ca/adwords3/templates/$cron_name/directmail/logo.png",
            'front_banner' => "https://tm.smedia.ca/adwords3/templates/$cron_name/directmail/front_left.png",
            'back_banner' => "https://tm.smedia.ca/adwords3/templates/$cron_name/directmail/back_left.png",

            'coupon_offer' => $mail_retargeting['promotion_text'],
            'offer_color' => $mail_retargeting['promotion_color'],
            'promo_bg_color' => $mail_retargeting['overlay_color'],
            'promo_color' => $mail_retargeting['overlay_text_colour'],
            'promo_text' => 'FEATURED VEHICLE',
            'price_color' => $mail_retargeting['price_color'],
            'coupon_date' => date('m/d/Y'),
            'coupon_validity' => $mail_retargeting['coupon_validity'],

            'vehicle_1_stock' => '18JC03A',
            'vehicle_1_year' => '2017',
            'vehicle_1_make' => 'Chevrolet Silverado',
            'vehicle_1_model' => 'North 4x4',
            'vehicle_1_price' => '$9,994',
            'vehicle_1_img' => 'https://s3.amazonaws.com/rd-dmcc/smedia/car1.png',

            'vehicle_2_stock' => '18JC03A',
            'vehicle_2_year' => '2017',
            'vehicle_2_make' => 'Chevrolet Silverado',
            'vehicle_2_model' => 'North 4x4',
            'vehicle_2_price' => '$9,994',
            'vehicle_2_img' => 'https://s3.amazonaws.com/rd-dmcc/smedia/car1.png',
        ];

        $query = "";

        foreach ($query_params as $name => $val) 
        {
            if ($query) 
            {
                $query .= '&';
            }

            $query .= rawurlencode($name) . '=' . rawurlencode($val);
        }


        if (isset($mail_retargeting['used'])) 
        {
            $query_used_params = 
            [
                'logo' => "https://tm.smedia.ca/adwords3/templates/$cron_name/directmail/logo.png",
                'front_banner' => "https://tm.smedia.ca/adwords3/templates/$cron_name/directmail/front_left.png",
                'back_banner' => "https://tm.smedia.ca/adwords3/templates/$cron_name/directmail/back_left.png",

                'coupon_offer' => $mail_retargeting['used']['promotion_text'],
                'offer_color' => $mail_retargeting['used']['promotion_color'],
                'promo_bg_color' => $mail_retargeting['used']['overlay_color'],
                'promo_color' => $mail_retargeting['used']['overlay_text_colour'],
                'promo_text' => 'FEATURED VEHICLE',
                'price_color' => $mail_retargeting['used']['price_color'],
                'coupon_date' => date('m/d/Y'),
                'coupon_validity' => $mail_retargeting['used']['coupon_validity'],

                'vehicle_1_stock' => '18JC03A',
                'vehicle_1_year' => '2017',
                'vehicle_1_make' => 'Chevrolet Silverado',
                'vehicle_1_model' => 'North 4x4',
                'vehicle_1_price' => '$9,994',
                'vehicle_1_img' => 'https://s3.amazonaws.com/rd-dmcc/smedia/car1.png',

                'vehicle_2_stock' => '18JC03A',
                'vehicle_2_year' => '2017',
                'vehicle_2_make' => 'Chevrolet Silverado',
                'vehicle_2_model' => 'North 4x4',
                'vehicle_2_price' => '$9,994',
                'vehicle_2_img' => 'https://s3.amazonaws.com/rd-dmcc/smedia/car1.png',
            ];

            $query_used = "";

            foreach ($query_used_params as $name => $val) 
            {
                if ($query_used) 
                {
                    $query_used .= '&';
                }

                $query_used .= rawurlencode($name) . '=' . rawurlencode($val);
            }
        }


        if (isset($mail_retargeting['new'])) 
        {
            $query_new_params = 
            [
                'logo' => "https://tm.smedia.ca/adwords3/templates/$cron_name/directmail/logo.png",
                'front_banner' => "https://tm.smedia.ca/adwords3/templates/$cron_name/directmail/front_left.png",
                'back_banner' => "https://tm.smedia.ca/adwords3/templates/$cron_name/directmail/back_left.png",

                'coupon_offer' => $mail_retargeting['new']['promotion_text'],
                'offer_color' => '#fofofo',
                'promo_bg_color' => $mail_retargeting['new']['overlay_color'],
                'promo_color' => $mail_retargeting['new']['overlay_text_colour'],
                'promo_text' => 'FEATURED VEHICLE',
                'price_color' => $mail_retargeting['new']['price_color'],
                'coupon_date' => date('m/d/Y'),
                'coupon_validity' => $mail_retargeting['new']['coupon_validity'],

                'vehicle_1_stock' => '18JC03A',
                'vehicle_1_year' => '2017',
                'vehicle_1_make' => 'Chevrolet Silverado',
                'vehicle_1_model' => 'North 4x4',
                'vehicle_1_price' => '$9,994',
                'vehicle_1_img' => 'https://s3.amazonaws.com/rd-dmcc/smedia/car1.png',

                'vehicle_2_stock' => '18JC03A',
                'vehicle_2_year' => '2017',
                'vehicle_2_make' => 'Chevrolet Silverado',
                'vehicle_2_model' => 'North 4x4',
                'vehicle_2_price' => '$9,994',
                'vehicle_2_img' => 'https://s3.amazonaws.com/rd-dmcc/smedia/car1.png',
            ];


            $query_new = "";

            foreach ($query_new_params as $name => $val) 
            {
                if ($query_new) 
                {
                    $query_new .= '&';
                }

                $query_new .= rawurlencode($name) . '=' . rawurlencode($val);
            }
        }
    }
?>


<form method="POST" class="form-horizontal form-bordered" action="?dealership=<?php echo $cron_name ?>">
    <div class="row form-group-row">
        <div class="col-md-12"> 
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <div class="checkbox-custom chekbox-primary">
                        <input id="enable_mail_retargetting" value="1" type="checkbox" name="enable_mail_retargetting" <?= $cron_config['mail_retargeting']['enabled'] ? 'data-current="checked" checked' : 'data-current=""'; ?> />
                        <label for="enable_mail_retargetting"> Enable Mail Retargetting </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group-row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-sm-3 control-label"> Client ID </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="reach_dynamic_client_id" value="<?= isset($cron_config['mail_retargeting']['client_id']) ? $cron_config['mail_retargeting']['client_id'] : ''; ?>"  />
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group-row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-sm-3 control-label">Stock Type</label>
                <div class="col-sm-3">
                    <select class="form-control" name="selected_option" id="mySelect" onchange="mySelectFunction()" data-plugin-multiselect data-plugin-options='{ "maxHeight": 400 }'>
                        <option value="defult" <?php echo $selected_option = "defult" ? '' : 'selected=""' ?>>Defult</option>
                        <option value="new" <?php echo $selected_option = "new" ? '' : 'selected=""' ?>>New</option>
                        <option value="used" <?php echo $selected_option = "used" ? '' : 'selected=""' ?>>Used</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group-row">
        <div class="col-md-12"> 
            <div class="form-group">
                <label class="col-sm-3 control-label">Promotion</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="promotion_text" name="promotion_text" value="<?= isset($cron_config['mail_retargeting']['promotion_text']) ? $cron_config['mail_retargeting']['promotion_text'] : ''; ?>" placeholder="YOUR PROMOTION HERE" />
                </div>
                <div class="col-sm-3">
                    <input type="text" id="promotion_color" name="promotion_color" class="form-control jscolor" value="<?= isset($cron_config['mail_retargeting']['promotion_color']) ? $cron_config['mail_retargeting']['promotion_color'] : '567DC0'; ?>">
                </div>
            </div>
        </div>
    </div>
    
    <div class="row form-group-row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-sm-3 control-label">Featured Overlay </label>
                <div class="col-sm-3">
                    <input  type="text" id="overlay_color" name="overlay_color" class="form-control jscolor" value="<?= isset($cron_config['mail_retargeting']['overlay_color']) ? $cron_config['mail_retargeting']['overlay_color'] : 'ff8500'; ?>">
                </div>
                <div class="col-sm-3">
                    <input type="text" id="overlay_text_colour" name="overlay_text_colour" class="form-control jscolor" value="<?= isset($cron_config['mail_retargeting']['overlay_text_colour']) ? $cron_config['mail_retargeting']['overlay_text_colour'] : 'ffffff'; ?>">
                </div>
            </div>
        </div>
    </div>
    
    <div class="row form-group-row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-sm-3 control-label">Price Colour</label>
                <div class="col-sm-3">
                    <input type="text" name="price_color" id="price_color" class="form-control jscolor" value="<?= isset($cron_config['mail_retargeting']['price_color']) ? $cron_config['mail_retargeting']['price_color'] : 'ff8500'; ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group-row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-sm-3 control-label">Coupon Validity</label>
                <div class="col-sm-3">
                    <input class="form-control" type="number" id="coupon_validity" name="coupon_validity"  value="<?= isset($cron_config['mail_retargeting']['coupon_validity']) ? $cron_config['mail_retargeting']['coupon_validity'] : '7'; ?>"/>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group-row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button name="btn" value="save-mail-retargeting" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>


<div class="row">
    <div class="col-md-12">
        <h2>Preview</h2>
        <i>Only works on chrome</i>
    </div>

    <div class="col-md-12">
        <style>
            iframe.front-preview, iframe.back-preview 
            {
                width: 6in;
                height: 4in;
                overflow: hidden;
                border: 1px solid #ccc;
                margin: 10px;
            }
        </style>

        <?php
            if($mail_retargeting_status)
            {
        ?>
        <div id="query_defult" style="">
            <iframe class="front-preview" scrolling="no" src="https://tm.smedia.ca/dashboard/reachdynamics/preview.php?template=v6&side=front&<?= $query ?>">
            </iframe>
            <iframe class="back-preview" scrolling="no" src="https://tm.smedia.ca/dashboard/reachdynamics/preview.php?template=v6&side=back&<?= $query ?>">
            </iframe>
        </div>

        <?php
        if (isset($query_new)) 
        {
        ?>
            <div id="query_new" style="display: none;">
                <iframe class="front-preview" scrolling="no" src="https://tm.smedia.ca/dashboard/reachdynamics/preview.php?template=v6&side=front&<?= $query_new ?>">
                </iframe>
                <iframe class="back-preview" scrolling="no" src="https://tm.smedia.ca/dashboard/reachdynamics/preview.php?template=v6&side=back&<?= $query_new ?>">
                </iframe>
            </div>

        <?php
        } 
        else 
        {
            echo '<h3 id="query_new"  style="display: none;">Sorry!! No mail retargeting configuration save for new stock type.</h3>';
        }

        if (isset($query_used)) 
        {
        ?>
            <div id="query_used" style="display: none;">
                <iframe class="front-preview" scrolling="no" src="https://tm.smedia.ca/dashboard/reachdynamics/preview.php?template=v6&side=front&<?= $query_used ?>">
                </iframe>
                <iframe class="back-preview" scrolling="no" src="https://tm.smedia.ca/dashboard/reachdynamics/preview.php?template=v6&side=back&<?= $query_used ?>">
                </iframe>
            </div>

        <?php
        } 
        else 
        {
            echo '<h3 id="query_used"  style="display: none;">Sorry!! No mail retargeting configuration save for used stock type.</h3>';
        }
    } 
    else 
    {
        echo '<h3>Sorry!! No mail retargeting configuration save for '.$cron_name.'.</h3>';
    }
        ?>
    </div>
</div>


<script>
/**
 * { function_description }
 */
function mySelectFunction() 
{
    var x = document.getElementById("mySelect").value;
    var myVariable = <?php echo (json_encode($mail_retargeting_value)); ?>;

    document.getElementById("promotion_text").value = myVariable[x]['promotion_text'];
    document.getElementById("promotion_color").value = myVariable[x]['promotion_color'];
    document.getElementById("overlay_color").value = myVariable[x]['overlay_color'];
    document.getElementById("overlay_text_colour").value = myVariable[x]['overlay_text_colour'];
    document.getElementById("price_color").value = myVariable[x]['price_color'];
    document.getElementById("coupon_validity").value = myVariable[x]['coupon_validity'];

    $('.jscolor').each(function()
    {
        var value = $(this).val();
        $(this).css({"background-color": "#" + value });
    }); 
    
    if(x==="new")
    {
        document.getElementById("query_defult").style.display = "none";
        document.getElementById("query_new").style.display = "block";
        document.getElementById("query_used").style.display = "none";
    } 
    else if(x==="used") 
    {
        document.getElementById("query_defult").style.display = "none";
        document.getElementById("query_new").style.display = "none";
        document.getElementById("query_used").style.display = "block";
    } 
    else 
    {    
        document.getElementById("query_defult").style.display = "block";
        document.getElementById("query_new").style.display = "none";
        document.getElementById("query_used").style.display = "none";
    }
}
</script>