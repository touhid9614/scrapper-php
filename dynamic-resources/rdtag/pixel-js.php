<?php header('Content-type: text/javascript; charset=UTF-8'); ?>

var rdim1 = document.createElement("img"); 
rdim1.src = 'https://rdcdn.com/rt?aid=<?= filter_input(INPUT_GET, 'pixel_id') ?>&e=1&img=1';
rdim1.height = 1;
rdim1.width = 1;
document.getElementsByTagName("body")[0].appendChild(rdim1);

var rdim2 = document.createElement("img"); 
rdim2.src = 'https://rdcdn.com/ct?aid=<?= filter_input(INPUT_GET, 'pixel_id') ?>&e=1';
rdim2.height = 1;
rdim2.width = 1;
document.getElementsByTagName("body")[0].appendChild(rdim2);