<?php

class LosslessBits
{
    public $CharacterId, $BitmapFormat, $BitmapWidth, $BitmapHeight, $BitmapColorTableSize, $BitmapData;
    
    public function __construct($characterId, $bitmapFormat, $bitmapWidth, $bitmapHeight)
    {
        $this->CharacterId  = $characterId;
        $this->BitmapFormat = $bitmapFormat;
        $this->BitmapWidth  = $bitmapWidth;
        $this->BitmapHeight = $bitmapHeight;
    }
    
    public function getPixel($x, $y)
    {
        if($this->BitmapFormat == 3) throw new Exception("Unable to handle colormap data");
        
        $offset = (($this->BitmapWidth * $y) + $x) * 4;
        
        $r = ord($this->BitmapData[$offset + 1]);
        $g = ord($this->BitmapData[$offset + 2]);
        $b = ord($this->BitmapData[$offset + 3]);
        
        return new Pix($r, $g, $b);
    }
    
    public function setPixel($x, $y, $p)
    {
        if($this->BitmapFormat == 3 || $this->BitmapFormat == 4) throw new Exception("Unable to handle colormap data");
        
        $offset = (($this->BitmapWidth * $y) + $x) * 4;
        
        $this->BitmapData[$offset + 0] = 0x00;
        $this->BitmapData[$offset + 1] = chr($p->R);
        $this->BitmapData[$offset + 2] = chr($p->G);
        $this->BitmapData[$offset + 3] = chr($p->B);
    }
}

class LosslessBits2 extends LosslessBits
{
    public function getPixel($x, $y)
    {
        if($this->BitmapFormat == 3) throw new Exception("Unable to handle colormap data");
        
        $offset = (($this->BitmapWidth * $y) + $x) * 4;
        
        $a = ord($this->BitmapData[$offset + 0]);
        $r = ord($this->BitmapData[$offset + 1]);
        $g = ord($this->BitmapData[$offset + 2]);
        $b = ord($this->BitmapData[$offset + 3]);
        
        if($a != 0)
        {
            $r = floor($r * (255/$a));
            $g = floor($g * (255/$a));
            $b = floor($b * (255/$a));
        }
        
        return new Pix32($a, $r, $g, $b);
    }
    
    public function setPixel($x, $y, $p)
    {
        if($this->BitmapFormat == 3) throw new Exception("Unable to handle colormap data");
        
        $offset = (($this->BitmapWidth * $y) + $x) * 4;
        
        $this->BitmapData[$offset + 0] = chr($p->A);
        $this->BitmapData[$offset + 1] = chr(floor($p->R * ($p->A/255)));
        $this->BitmapData[$offset + 2] = chr(floor($p->G * ($p->A/255)));
        $this->BitmapData[$offset + 3] = chr(floor($p->B * ($p->A/255)));
    }
}

?>
