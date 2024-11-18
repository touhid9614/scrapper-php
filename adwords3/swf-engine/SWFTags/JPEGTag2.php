<?php

class JPEGTag2 implements SWFTag
{
    public function read($data)
    {
        $characterId    = unpack("v", substr($data, 0, 2));
        
        $tag = new JPEGBits2($characterId[1]);
        
        $tag->ImageData = substr($data, 2);
        
        return $tag;
    }
    
    public function write($object)
    {
        $data = pack("v", $object->CharacterId) . $object->ImageData;
        
        return $data;
    }
}

global $Tags;

$Tags[21] = new JPEGTag2();

?>
