<?php

require_once(__DIR__ . "/SWFTagCollection.php");

class LosslessEncoder
{
    public $EncodingType;

    public function __construct($encodingType)
    {
        if($encodingType != LosslessEncodingType::Bitmap24 &&
           $encodingType != LosslessEncodingType::Bitmap32)
            throw new Exception("Encoding type not supported");

        $this->EncodingType = $encodingType;
    }

    public function Encode($image)
    {
        $width  = imagesx($image);
        $height = imagesy($image);

        imagealphablending($image, false);
        imagesavealpha($image, true);

        $tagData = $this->EncodingType == LosslessEncodingType::Bitmap32?
                new LosslessBits2(null, 5, $width, $height):
                new LosslessBits(null, 5, $width, $height);

        $tagData->BitmapData = "";

        for($y = 0; $y < $height; $y++)
        {
            for($x = 0; $x < $width; $x++)
            {
                $colorInxed = imagecolorat($image, $x, $y);
                $color = imagecolorsforindex($image, $colorInxed);

                if($this->EncodingType == LosslessEncodingType::Bitmap32)
                {
                    $rescaledAlpha = floor(((127 - $color['alpha'])/127) * 255);
                    $tagData->BitmapData .= chr($rescaledAlpha);
                    
                    $color['red']   = floor($color['red'] * ($rescaledAlpha/255));
                    $color['green'] = floor($color['green'] * ($rescaledAlpha/255));
                    $color['blue']  = floor($color['blue'] * ($rescaledAlpha/255));
                }
                else
                {
                    $tagData->BitmapData .= chr(0);
                }

                $tagData->BitmapData .= chr($color['red']) . chr($color['green']) . chr($color['blue']);
            }
        }

        return $tagData;
    }
}

class LosslessEncodingType
{
    const Bitmap24  = 1;
    const Bitmap32  = 2;
}
?>
