<?php

class Pix
{
    public $R, $G, $B;
    
    public function __construct($r = 0, $g = 0, $b = 0)
    {
        $this->R = $r;
        $this->G = $g;
        $this->B = $b;
    }
}

class Pix32 extends Pix
{
    public $A;
    
    public function __construct($a = 0, $r = 0, $g = 0, $b = 0)
    {
        $this->A = $a;
        $this->R = $r;
        $this->G = $g;
        $this->B = $b;
    }
}

?>
