<?php

class JPEGTag3 implements SWFTag
{
    public function read($data)
    {
        $characterId        = unpack("v", substr($data, 0, 2));
        $alphaDataOffset    = unpack("V", substr($data, 2, 4));
        
        $tag = new JPEGBits3($characterId[1], $alphaDataOffset[1]);
        
        $tag->ImageData = substr($data, 6, $alphaDataOffset[1]);
        
        $tag->BitmapAlphaData = gzuncompress(substr($data, 6 + $alphaDataOffset[1]));
        
        return $tag;
    }
    
    public function write($object)
    {
        $data = pack("v", $object->CharacterId) . $object->ImageData;
        
        return $data;
    }
}

global $Tags;

$Tags[35] = new JPEGTag3();

?>
