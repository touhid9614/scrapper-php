<?php

require_once DEBUGGER_PATH . 'bootstrap.php';

$logWriter = new LogWriter();
$debugger = new Debugger($logWriter);
