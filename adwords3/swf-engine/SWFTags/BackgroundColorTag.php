<?php

class BackgroundColorTag implements SWFTag
{
    public function read($data)
    {
        if(strlen($data) != 3) throw  new Exception("Invalid Tag9 data");
        
        $response = new Pix(
            ord($data[0]),
            ord($data[1]),
            ord($data[2])
        );
        
        return $response;
    }
    
    public function write($object)
    {
        return chr($object->R) . chr($object->G) . chr($object->B);
    }
}

global $Tags;

$Tags[9] = new BackgroundColorTag();

?>
