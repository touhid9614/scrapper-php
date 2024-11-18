<?php

class JPEGEncoder
{
    public $Quality;
    
    public function __construct($quality)
    {
        $this->Quality = $quality;
    }
    
    public function Encode($image)
    {
        ob_start();
        imagejpeg($image, null, $this->Quality);
        return ob_get_clean();
    }
}

?>
