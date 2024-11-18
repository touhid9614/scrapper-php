<?php

class Stopwatch {
    private $time, $init;
    
    public function __construct() {
        $this->init = microtime(true);
        $this->time = microtime(true);
    }

    public function start() {
        $this->init = microtime(true);
        $this->time = microtime(true);
    }
    
    public function elapsed($continue = false) {
        if($this->time < 0) { return false;}
        $now = microtime(true);
        $retval = $now - $this->time;
        if(!$continue) { $this->time = $now; }
        return $retval;
    }
    
    public function total() {
        if($this->time < 0) { return false;}
        $now = microtime(true);
        return $now - $this->init;
    }
    
    public function stop() {
        $this->init = -1;
        $this->time = -1;
    }
}