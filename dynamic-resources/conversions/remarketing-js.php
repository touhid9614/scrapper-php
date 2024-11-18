<?php header('Content-type: text/javascript; charset=UTF-8'); ?>

window.sm_include_iframe("//tm.smedia.ca/conversions/remarketing.html?conversion_id=<?= filter_input(INPUT_GET, 'conversion_id') ?>");