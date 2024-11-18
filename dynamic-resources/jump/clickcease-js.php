<?php header('Content-type: text/javascript; charset=UTF-8'); ?>
var script = document.createElement("script");
script.async = true; script.type = "text/javascript";
var target = 'https://www.clickcease.com/monitor/stat.js';
script.src = target;
var elem = document.head;
elem.appendChild(script);