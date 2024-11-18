<?php

class LosslessTag2 implements SWFTag
{
    public function read($data)
    {
        $characterId    = unpack("v", substr($data, 0, 2));
        $bitmapFormat   = ord($data[2]);
        $bitmapWidth    = unpack("v", substr($data, 3, 2));
        $bitmapHeight   = unpack("v", substr($data, 5, 2));
        
        $tag = new LosslessBits2($characterId[1], $bitmapFormat, $bitmapWidth[1], $bitmapHeight[1]);
        
        $offset = 7;
        
        if($bitmapFormat == 3)
        {
            $tag->BitmapColorTableSize = ord($data[$offset]);
            $offset++;
        }
        
        $tag->BitmapData = gzuncompress(substr($data, $offset));
        
        return $tag;
    }
    
    public function write($object)
    {
        if($object->BitmapFormat == 3) throw new Exception("Unable to handle colormap data");
        
        $data = pack("v", $object->CharacterId) .
                chr($object->BitmapFormat) .
                pack("v", $object->BitmapWidth) .
                pack("v", $object->BitmapHeight);
        
        if($object->BitmapFormat == 3) $data .= chr($object->BitmapColorTableSize);
        
        $data .= gzcompress($object->BitmapData);
        
        return $data;
    }
}

global $Tags;

$Tags[36] = new LosslessTag2();

?>
