<?php

include_once '../adwords3/utils.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';

$full_url = urlCombine($url, "?vl=smedia-js-hook-editor");
?>
<!doctype html>
<html>
    <head>
        <title>smedia :: js hook editor</title>
        <link type="text/css" rel="stylesheet" href="assets/css/hook-editor.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="assets/js/hook-editor.js"></script>
    </head>
    <body>
        <div class="address-bar">
            <form method="get">
                <div class="inline-block address-container">
                    <input type="text" name="url" value="<?= $url ?>" placeholder="Provide URL to load"/>
                </div>
                <div class="inline-block button-container">
                    <button>Load</button>
                </div>
            </form>
        </div>
        <div class="main-content">
            <iframe id="content-frame" src="<?= $full_url ?>"></iframe>
        </div>
        <div class="hook-editor">
            <form id="hook-form">
                <input type="hidden" name="act" value="save"/>
                <input type="hidden" name="url" value="<?php echo $url ?>"/>
                <div class="data-row">
                    <label for="button-selector">Target Path</label>
                    <input id="button-selector" type="text" name="path" value="" readonly=""/>
                </div>
                <div class="data-row">
                    <label for="on-click">On Click</label>
                    <input id="on-click" type="text" name="onclick" value="" placeholder="JS statement"/>
                </div>
                <div class="data-row">
                    <button>Save</button>
                </div>
            </form>
        </div>
    </body>
</html>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
