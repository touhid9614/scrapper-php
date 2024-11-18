<?php

class JPEGBits
{
    public $CharacterId, $ImageData;
    
    public function __construct($characterId)
    {
        $this->CharacterId  = $characterId;
    }
}

class JPEGBits2 extends JPEGBits
{
    
}

class JPEGBits3 extends JPEGBits2
{
    public $AlphaDataOffset, $BitmapAlphaData;
    
    public function __construct($characterId, $alphaDataOffset)
    {
        $this->CharacterId      = $characterId;
        $this->AlphaDataOffset  = $alphaDataOffset;
    }
}

?>
