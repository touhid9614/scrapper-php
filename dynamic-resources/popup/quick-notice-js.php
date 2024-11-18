<?php
$adwords_path = dirname(dirname(__DIR__)) . "/adwords3";

require_once $adwords_path . '/db-config.php';
require_once $adwords_path . '/config.php';
require_once $adwords_path . '/db_connect.php';
require_once $adwords_path . '/utils.php';
require_once $adwords_path . '/tag_db_connect.php';
require_once $adwords_path . '/uuid.php';

header('Content-type: text/javascript; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$dealership = filter_input(INPUT_GET, 'dealership', FILTER_SANITIZE_STRING);
$settigs = get_meta('popup_config', $dealership);
$url = filter_input(INPUT_GET, 'ref', FILTER_SANITIZE_URL);
$user_unique_id = filter_input(INPUT_GET, 'user_unique_id');
if (empty($user_unique_id) || is_null($user_unique_id) || $user_unique_id == 'null') {
    $user_unique_id = UUID::v4();
}
$debug = stripos($url, 'covid19_debug=true') !== false;
$home_page = false;
$parsed_url = parse_url($url);
// && strlen($parsed_url['fragment']) <= 0
if (strlen(trim($parsed_url['path'], '/')) <= 0 && ($debug || strlen($parsed_url['query']) <= 0)) {
    $home_page = true;
}

if($debug == false){
  if (empty($settigs['live']) || $home_page == false) exit();
}

$image = '';
if (!empty($settigs['image_file'])) {
    $image = s3GetUrl($settigs['image_file'], "smedia-user-photos");
}
//$image = "https://smedia-user-photos.s3.amazonaws.com/popup-heartlandhonda.jpg?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEHMaCXVzLWVhc3QtMSJIMEYCIQDd9SBR3lj7OQwS2TZDqHilg0OHWVYKukrC5LVKGn0AMAIhAPfwmFYrgXhw4GfpXBcp%2FVv%2BINBR22CWP97URgPquPiEKr0DCIv%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEQAxoMMzkxNDU5MzYxNTk1Igx3a0RloQliwyx7w0AqkQMxdGLmnyYFE3ke1GAepi6k20KzK9CGwEA6J8uEpyScLrFYidXM5li8sJcOvOtXULz9W9GGOfin15JrvHi8TkZs50vmMgxgogPjEHlQkp0o7lnmCZCwtOENzvc62OFTTo%2F598fh0Jx70gbFSqWupiUVtggOxK04tuUcVwYHUNl1GgvoVpGgatdl9UTqB8R021vGJ3y9E%2FyTu3R55UahZI%2BjRskoqy%2Ft3Udx%2Bw2u2p87nUtG3KB72%2FKo0Hcc6Vm2vDXm%2BI%2FRayLBeYzIwJpuoZ0pnnJ44wwFoDRpPtk5GojC0ddv5tglfjW9mjF6VmXhuf1um%2FQL0PqIiFC7bAu%2FR5JmxnzdZdt8PS%2BoEQ6JYF4ICxm%2FfiO41Q%2BKF9dqfbJ%2BxPvyIwpR7PFjgLc6i%2BtEm8PVx%2BfZhNsYP47QrdcAcn0GyNGKPr%2BUtJkqoAMrImvjCDv672u8PDqYzxxrJ%2BLhvRrM0r3WZ3%2FQzf0S9rLH43ZV5%2FoWlLVLl89fsfn%2Bs72m0VbVXusvYYZwk4oIM7iapv7YbzDXvdv0BTrqAfX4Fv4pfLYNsjOQy4%2FyZF7navL89QWfmHOtdZ6oObzXr914ZbQSiEQq2slmZTo%2BNH7Atozt1kgEyttEJScn4x5PeUmpZye2HkPZvIrOvsP%2BYQN6hZk4eQvKoLeX7rOvPKCKU%2FrfMFupJ1pNYFM8JwZKeSrxamMzhOSMHVGF2kE25%2FwPO0cijPRiMPyIX0Kbp0IQ%2FRWSpGxt%2FfoM5F0G5snEpsPXlrCsBHabyPOeQMyIlKCZk35vc2Jy9sQJWf8TJri0JohpZVGy3klyVH55mOcOyK7xVeu4AgDkvD9IA80NUp3%2BEv3ebGoKDA%3D%3D&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=ASIAVWJGL2M57YECRZNZ%2F20200415%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20200415T111218Z&X-Amz-SignedHeaders=host&X-Amz-Expires=1200&X-Amz-Signature=5c1279a012e28529255b265ea9cac8c2e4765eb555c2fa3df6b360e6d6ed7929";

$title = htmlspecialchars($settigs['headline'], ENT_QUOTES);
$desc = htmlspecialchars($settigs['details'], ENT_QUOTES);

$desc = str_replace(array("\n\r", "\n", "\r"), "</br>", $desc);

$button_text = htmlspecialchars($settigs['button_text'], ENT_QUOTES);
$button_link = $settigs['button_link'];
$headline_text_color = $settigs['headline_text_color'];
$text_color = $settigs['text_color'];
$background_color = $settigs['background_color'];
$button_bg = $settigs['button_color'];
$button_hover_bg = adjustHexColorBrightness($button_bg, -0.2);
$button_text_color = $settigs['button_text_color'];
$display_image = !empty($settigs['image_include']) && !empty($image);
$display_btn = !empty($settigs['button_include']) && !empty($button_link) && !empty($button_text);
$display_title = !empty($settigs['text_include']) && !empty($title);
$display_desc = !empty($settigs['text_include']) && !empty($desc);
$open_in_new = !empty($settigs['open_in_new']) ? 'target="_blank"' : '';


$css = <<<ABC
.ibm-font {
    font-family: "IBM Plex Sans Condensed", sans-serif;
}
.smedia-quick-notice-backdrop{
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: #000;
  z-index: 1000;
  opacity: .4;
}

.smedia-quick-notice{
  position: fixed;
  top: 50%;
  left: 50%;
  z-index: 10001;
  width: 50%;
  max-width: 840px;
  min-width: 600px;
  max-height: calc( 100% - 36px );
  transform-origin: 50% 50%;
  transform: translate(-50%, -50%);
}

.smedia-quick-notice-box{
  max-height: calc( 100vh - 36px );
  overflow: hidden;
  overflow-y: auto;
}

.smedia-quick-notice img{
  width: 100%;
}

.smedia-quick-notice-desc{
  text-align: justify;
  color: $text_color;
  font-size: 16px;
  font-weight: 600;
  line-height: 1.5;
  font-style: normal;
}
.smedia-quick-notice-title{
  padding-top: 10px;
}
.smedia-quick-notice-title h3{
  text-align: center;
  color: $headline_text_color;
  font-style: normal;
  font-weight: 600;
  font-size: 48px;
  line-height: 83px;
  text-transform: uppercase;
}

.smedia-quick-notice-text{
  background: $background_color;
  padding: 30px;
}
.smedia-quick-notice-button{
  margin-top: 28px;
  text-align: center;
}

.smedia-quick-notice-button a{
  display: inline-block;
  background: $button_bg;
  color: $button_text_color;
  padding: 9px 35px;
  font-size: 24px;
  text-decoration: none;
}
.smedia-quick-notice-button a:hover{
  background: $button_hover_bg;
  color: $button_text_color;
  text-decoration: none;
}
.smedia-quick-notice .qn-close{
  width: 27px;
  height: 27px;
  line-height: 27px; 
  cursor: pointer;
  position: absolute !important;
  background-color: #000;
  text-align: center;
  display: inline-block;
  font-size: 16px;
  font-style: normal;
  color: #fff;
  font-family: sans-serif;
  top: -16px;
  right: -16px;
  margin: 0;
  border-radius: 100%;
  border: 1px solid #fff;
  z-index: 9999;
}

.smedia-quick-notice .qn-close::after{
  content: "X";
  text-transform: uppercase;
}
.smedia-quick-notice .qn-close:hover{
  text-decoration: none;
}

.smedia-quick-notice-box::-webkit-scrollbar {
    width: 7px;
}
.smedia-quick-notice-box::-webkit-scrollbar-track {
    background: #dddddd;
    -webkit-box-shadow: inset 0 0 6px rgba(122,122,122,0.5);
}
.smedia-quick-notice-box::-webkit-scrollbar-thumb {
  background-color: darkgrey;
  border: 1px solid #dddddd;
  border-radius: 4px
}

@media screen and (max-width: 800px) {
    .smedia-quick-notice{
        width: calc( 100% - 36px );
        max-width: calc( 100% - 36px );
        min-width: calc( 100% - 36px );
    }
    .smedia-quick-notice-title h3{
        font-size: 44px;
    }
    .smedia-quick-notice-desc{
        font-size: 12px;
    }
    .smedia-quick-notice-button a{
        font-size: 24px;
    }
}
@media screen and (max-width: 500px) {
    .smedia-quick-notice-title h3{
      font-size: 32px;
      line-height: 39px;
    }
    .smedia-quick-notice-desc{
        font-size: 16px;
        line-height: 1.5;
    }
    .smedia-quick-notice-button a{
        font-size: 24px;
        display: inline-block;
        width: 100%;
        padding: 4px 20px;
    }
}
ABC;

$css = str_replace("\n", " ", $css);
?>


var custom_font = 'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@600&display=swap';
smedia_quick_popup_font = document.createElement('link')
smedia_quick_popup_font.setAttribute("href", custom_font);
smedia_quick_popup_font.setAttribute("rel", "stylesheet");
smedia_quick_popup_font.setAttribute("type", "text/css");
smedia_quick_popup_font.setAttribute("id", "quick-popup-font");
document.getElementsByTagName("head")[0].appendChild(smedia_quick_popup_font);

function showPopup() {
    var desc = '<?= $desc ?>';
    var html='<div class="smedia-quick-notice-backdrop" style="display: none"></div>' +
    '<div class="smedia-quick-notice" style="display:none">' +
        '<a class="qn-close"></a>' +
        '<div class="smedia-quick-notice-box">' +
            <?php if ($display_image) { ?>
                '<div class="smedia-quick-notice-image">' +
                    '<img src="<?= $image ?>" />' +
                '<div>' +
            <?php } ?>
            <?php if ($display_title || $display_desc || $display_btn) { ?>
                '<div class="smedia-quick-notice-text">' +
                    <?php if ($display_title) { ?>
                        '<div class="smedia-quick-notice-title">' +
                            '<h3 class="ibm-font"><?= $title ?></h3>' +
                        '</div>' +
                    <?php } ?>
                    <?php if ($display_desc) { ?>
                        '<div class="smedia-quick-notice-desc">' +
                            '<p class="ibm-font"><?= $desc ?></p>' +
                        '</div>' +
                    <?php } ?>
                    <?php if ($display_btn) { ?>
                        '<div class="smedia-quick-notice-button">' +
                            '<a class="ibm-font" href="<?= $button_link ?>" <?= $open_in_new ?> ><?= $button_text ?></a>' +
                        '</div>' +
                    <?php } ?>
                '<div>' +
            <?php } ?>
        '<div>' +
    '</div>';

    var smedia_temp_div = document.createElement('div');
    smedia_temp_div.innerHTML = html;
    document.getElementsByTagName("body")[0].appendChild(smedia_temp_div);

    var styleSheet = document.createElement("style")
    styleSheet.type = "text/css"
    styleSheet.innerText = `<?= $css ?>`;
    document.head.appendChild(styleSheet)

    console.log('Quick Notice');
    var notice = document.querySelector('.smedia-quick-notice')
    notice.style.display = 'block';
    notice.style.left = '-9999px';

    //await document.fonts.load('16px "IBM Plex Sans Condensed"');
    //console.log('Quick Notice font loaded');

    var closeBtn = document.querySelector('.qn-close')
    var backdrop = document.querySelector('.smedia-quick-notice-backdrop');
    backdrop.addEventListener("click", closePopup);
    closeBtn.addEventListener("click", closePopup);

    var popupReady = function () {
        backdrop.style.display = 'block'
        notice.style.left = '50%';
        sMedia.XDomainCookie.set('smedia_quick_notice', Date.now(), 1); //0.006944444
    }

    if($(".smedia-quick-notice-image img").length > 0) {
        $(".smedia-quick-notice-image img").one("load", function() {
            if(backdrop.style.display == 'block') return;
            popupReady();
        }).each(function() {
            if(this.complete) {
                $(this).trigger('load');
            }
        });

        setTimeout(function() {
            if(backdrop.style.display == 'block') return;

            console.log('quick notice taking to long to load. showing popup');

            popupReady();
        }, 3000);

    } else {
        popupReady();
    }


}

function closePopup(event) {
    event.preventDefault();
    var notice = document.querySelector('.smedia-quick-notice')
    var backdrop = document.querySelector('.smedia-quick-notice-backdrop');
    backdrop.style.display = 'none'
    notice.style.display = 'none';
    console.log(document.cookie)
;}

showPopup();

