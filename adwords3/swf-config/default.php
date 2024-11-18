<?php

global $SWFConfigs;

//width, height, backcolor, border, template, image, text

$SWFConfigs['default'] = array(
    
    #######################################     120x600     #############################################
    '120x600'   => array(
     
        9   => array(
            'width'     => 112,
            'height'    => 46,
            'template'  => array(
                'logo'  => new ImageConfig(0, 0, 112, 46, 0, 0, 0, 0, false, true, true)
            )
        ),
        12  => array(
            'width'     => 120,
            'height'    => 600,
            'border'    => array(
                'width' => 4,
                'color' => new Color(36, 135, 202)
            )
        ),
        16  => array(
            'width'     => 114,
            'height'    => 86,
            'image'     => array(
                'img1'  => new ImageConfig(0, 0, 114, 86)
            )
        ),
        19  => array(
            'width'     => 114,
            'height'    => 86,
            'image'     => array(
                'img2'  => new ImageConfig(0, 0, 114, 86)
            )
        ),
        22  => array(
            'width'     => 114,
            'height'    => 86,
            'image'     => array(
                'img3'  => new ImageConfig(0, 0, 114, 86)
            )
        ),
        25  => array(
            'width'     => 114,
            'height'    => 86,
            'image'     => array(
                'img4'  => new ImageConfig(0, 0, 114, 86)
            )
        ),
        28  => array(
            'width'     => 114,
            'height'    => 86,
            'image'     => array(
                'img5'  => new ImageConfig(0, 0, 114, 86)
            )
        ),
        32  => array(
            'width'     => 120,
            'height'    => 102,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 120, 102)
            )
        ),
        34  => array(
            'width'     => 105,
            'height'    => 64,
            'text'      => array(
                'year'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(2, 28), 100, 23, Alignment::Center),
                'make'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 12, 0, new Position(2, 46), 100, 13, Alignment::Center),
                'model'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 12, 0, new Position(2, 60), 100, 13, Alignment::Center)
            )
        ),
        38  => array(
            'width'     => 106,
            'height'    => 154,
            'template'  => array(
                'vertical'  => new ImageConfig(0, 0, 106, 154, 0, 0, 0, 0, false, false, true)
            )
        ),
        42  => array(
            'width'     => 120,
            'height'    => 78,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 120, 78)
            )
        ),
        2   => array(
            'width'     => 120,
            'height'    => 68,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(10, 49), 100, 32, Alignment::Center)
                //'biweekly'  => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 30, 0, new Position(3, 40), 110, 40, Alignment::Center),
                //'text'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 11, 0, new Position(5, 60), 110, 18, Alignment::Center)
            )
        ),
        5  => array(
            'width'     => 115,
            'height'    => 38,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(8, 34), 100, 32, Alignment::Center)
            )
        )
    ),
    #######################################     160x600     #############################################
    '160x600'   => array(

        2   => array(
            'width'     => 143,
            'height'    => 59,
            'template'  => array(
                'logo'  => new ImageConfig(0, 0, 143, 59, 0, 0, 0, 0, false, true, true)
//          'vertical'  => new ImageConfig(0, 0, 106, 154, 0, 0, 0, 0, false, false, true)
        //($x, $y, $width, $height, $source_x = 0, $source_y = 0, $source_ix = 0, $source_iy = 0, $enable_zooming = false, $source_origin = false, $truecolor = false)
            )
        ),
        5   => array(
            'width'     => 160,
            'height'    => 600,
            'border'    => array(
                'width' => 4,
                'color' => new Color(36, 135, 202)
            )
        ),
        9   => array(
            'width'     => 152,
            'height'    => 117,
            'image'     => array(
                'img1'  => new ImageConfig(0, 0, 152, 117)
            )
        ),
        12   => array(
            'width'     => 152,
            'height'    => 117,
            'image'     => array(
                'img2'  => new ImageConfig(0, 0, 152, 117)
            )
        ),
        15  => array(
            'width'     => 152,
            'height'    => 117,
            'image'     => array(
                'img3'  => new ImageConfig(0, 0, 152, 117)
            )
        ),
        18  => array(
            'width'     => 152,
            'height'    => 117,
            'image'     => array(
                'img4'  => new ImageConfig(0, 0, 152, 117)
            )
        ),
        21  => array(
            'width'     => 152,
            'height'    => 117,
            'image'     => array(
                'img5'  => new ImageConfig(0, 0, 152, 117)
            )
        ),
        25  => array(
            'width'     => 152,
            'height'    => 102,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 152, 102)
            )
        ),
        27  => array(
            'width'     => 121,
            'height'    => 75,
            'text'      => array(
                'year'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(2, 30), 115, 25, Alignment::Center),
                'make'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 12, 0, new Position(2, 52), 115, 15, Alignment::Center),
                'model'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 12, 0, new Position(2, 70), 115, 13, Alignment::Center)
            )
        ),
        31  => array(
            'width'     => 100,
            'height'    => 158,
            'template'  => array(
                'vertical'  => new ImageConfig(0, 0, 106, 154, 0, 0, 0, 0, false, false, true)
        //($x, $y, $width, $height, $source_x = 0, $source_y = 0, $source_ix = 0, $source_iy = 0, $enable_zooming = false, $source_origin = false, $truecolor = false)
            )
        ),
        35  => array(
            'width'     => 152,
            'height'    => 78,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 152, 78)
            )
        ),
        37  => array(
            'width'     => 118,
            'height'    => 61,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(9, 47), 100, 32, Alignment::Center)
                //'biweekly'  => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 30, 0, new Position(2, 40), 110, 40, Alignment::Center),
                //'text'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 11, 0, new Position(5, 59), 110, 18, Alignment::Center)
            )
        ),
        40  => array(
            'width'     => 126,
            'height'    => 41,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(12, 33), 100, 32, Alignment::Center)
            )
        )
    ),
    #######################################     200x200     #############################################
    '200x200'   => array(
     
        2   => array(
            'width'     => 80,
            'height'    => 50,
            'template'  => array(
                'logo'  => new ImageConfig(0, 0, 80, 50, 0, 0, 0, 0, false, false, true)
            )
        ),
        5   => array(
            'width'     => 200,
            'height'    => 200,
            'border'    => array(
                'width' => 4,
                'color' => new Color(36, 135, 202)
            )
        ),
        9   => array(
            'width'     => 98,
            'height'    => 73,
            'image'     => array(
                'img1'  => new ImageConfig(0, 0, 98, 73)
            )
        ),
        12   => array(
            'width'     => 98,
            'height'    => 73,
            'image'     => array(
                'img2'  => new ImageConfig(0, 0, 98, 73)
            )
        ),
        15  => array(
            'width'     => 98,
            'height'    => 73,
            'image'     => array(
                'img3'  => new ImageConfig(0, 0, 98, 73)
            )
        ),
        18  => array(
            'width'     => 98,
            'height'    => 73,
            'image'     => array(
                'img4'  => new ImageConfig(0, 0, 98, 73)
            )
        ),
        21  => array(
            'width'     => 98,
            'height'    => 73,
            'image'     => array(
                'img5'  => new ImageConfig(0, 0, 98, 73)
            )
        ),
        25  => array(
            'width'     => 194,
            'height'    => 45,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 194, 45)
            )
        ),
        27  => array(
            'width'     => 175,
            'height'    => 25,
            'text'      => array(
                'year'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(2, 23), 50, 21, Alignment::Center),
                'make'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 10, 0, new Position(60, 10), 110, 9, Alignment::Center),
                'model'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 10, 0, new Position(60, 24), 110, 9, Alignment::Center)
            )
        ),
        30  => array(
            'width'     => 94,
            'height'    => 32,
            'template'  => array(
                'horizontal'    => new ImageConfig(0, 0, 94, 32, 0, 0, 0, 0, true, false, true)
            )
        ),
        35  => array(
            'width'     => 76,
            'height'    => 40,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 20, 0, new Position(1, 34), 74, 28, Alignment::Center)
                //'biweekly'  => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 25, 0, new Position(2, 28), 72, 26, Alignment::Center),
                //'text'      => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 9, 0, new Position(5, 39), 66, 9, Alignment::Center)
            )
        ),
        38  => array(
            'width'     => 115,
            'height'    => 32,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 20, 0, new Position(22, 30), 74, 28, Alignment::Center)
            )
        )
    ),
    #######################################     250x250     #############################################
    '250x250'   => array(
     
        2   => array(
            'width'     => 102,
            'height'    => 64,
            'template'  => array(
                'logo'  => new ImageConfig(0, 0, 102, 64, 0, 0, 0, 0, false, true, true)
            )
        ),
        5   => array(
            'width'     => 250,
            'height'    => 250,
            'border'    => array(
                'width' => 5,
                'color' => new Color(36, 135, 202)
            )
        ),
        9   => array(
            'width'     => 120,
            'height'    => 90,
            'image'     => array(
                'img1'  => new ImageConfig(0, 0, 120, 90)
            )
        ),
        12   => array(
            'width'     => 120,
            'height'    => 90,
            'image'     => array(
                'img2'  => new ImageConfig(0, 0, 120, 90)
            )
        ),
        15  => array(
            'width'     => 120,
            'height'    => 90,
            'image'     => array(
                'img3'  => new ImageConfig(0, 0, 120, 90)
            )
        ),
        18  => array(
            'width'     => 120,
            'height'    => 90,
            'image'     => array(
                'img4'  => new ImageConfig(0, 0, 120, 90)
            )
        ),
        21  => array(
            'width'     => 120,
            'height'    => 90,
            'image'     => array(
                'img5'  => new ImageConfig(0, 0, 120, 90)
            )
        ),
        25  => array(
            'width'     => 239,
            'height'    => 55,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 239, 55)
            )
        ),
        27  => array(
            'width'     => 215,
            'height'    => 30,
            'text'      => array(
                'year'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(2, 24), 60, 19, Alignment::Center),
                'make'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 10, 0, new Position(80, 14), 125, 13, Alignment::Center),
                'model'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 10, 0, new Position(80, 29), 125, 13, Alignment::Center)
            )
        ),
        30  => array(
            'width'     => 125,
            'height'    => 43,
            'template'  => array(
                'horizontal'    => new ImageConfig(0, 0, 125, 43, 0, 0, 0, 0, true, false, true)
            )
        ),
        35  => array(
            'width'     => 93,
            'height'    => 50,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 30, 0, new Position(8, 41), 85, 32, Alignment::Center)
                //'biweekly'  => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 25, 0, new Position(2, 35), 89, 32, Alignment::Center),
                //'text'      => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 9, 0, new Position(5, 48), 83, 10, Alignment::Center)
            )
        ),
        38  => array(
            'width'     => 115,
            'height'    => 38,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 30, 0, new Position(16, 35), 85, 32, Alignment::Center)
            )
        )
    ),
    #######################################     300x250     #############################################
    '300x250'   => array(
     
        2   => array(
            'width'     => 108,
            'height'    => 68,
            'template'  => array(
                'logo'  => new ImageConfig(0, 0, 108, 68, 0, 0, 0, 0, false, true, true)
            )
        ),
        5   => array(
            'width'     => 300,
            'height'    => 250,
            'border'    => array(
                'width' => 6,
                'color' => new Color(36, 135, 202)
            )
        ),
        9   => array(
            'width'     => 141,
            'height'    => 105,
            'image'     => array(
                'img1'  => new ImageConfig(0, 0, 141, 105)
            )
        ),
        12   => array(
            'width'     => 141,
            'height'    => 105,
            'image'     => array(
                'img2'  => new ImageConfig(0, 0, 141, 105)
            )
        ),
        15  => array(
            'width'     => 141,
            'height'    => 105,
            'image'     => array(
                'img3'  => new ImageConfig(0, 0, 141, 105)
            )
        ),
        18  => array(
            'width'     => 141,
            'height'    => 105,
            'image'     => array(
                'img4'  => new ImageConfig(0, 0, 141, 105)
            )
        ),
        21  => array(
            'width'     => 141,
            'height'    => 105,
            'image'     => array(
                'img5'  => new ImageConfig(0, 0, 141, 105)
            )
        ),
        25  => array(
            'width'     => 286,
            'height'    => 55,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 286, 55)
            )
        ),
        27  => array(
            'width'     => 250,
            'height'    => 38,
            'text'      => array(
                'year'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(10, 30), 90, 22, Alignment::Left),
                'make'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 10, 0, new Position(120, 17), 130, 15, Alignment::Center),
                'model'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 10, 0, new Position(120, 37), 130, 15, Alignment::Center)
            )
        ),
        30  => array(
            'width'     => 133,
            'height'    => 44,
            'template'  => array(
                'horizontal'    => new ImageConfig(0, 0, 133, 44, 0, 0, 0, 0, false, false, true)
            )
        ),
        35  => array(
            'width'     => 106,
            'height'    => 58,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 30, 0, new Position(4, 43), 85, 32, Alignment::Center)
                //'biweekly'  => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 25, 0, new Position(2, 35), 89, 32, Alignment::Center),
                //'text'      => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 9, 0, new Position(5, 48), 83, 10, Alignment::Center)
            )
        ),
        38  => array(
            'width'     => 128,
            'height'    => 41,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(0, 0, 0), 30, 0, new Position(12, 34), 85, 32, Alignment::Center)
            )
        )
    ),
    #######################################     728x90     #############################################
    '728x90'   => array(
     
        2   => array(
            'width'     => 134,
            'height'    => 55,
            'template'  => array(
                'logo'  => new ImageConfig(0, 0, 134, 55, 0, 0, 0, 0, false, true, true)
            )
        ),
        5   => array(
            'width'     => 728,
            'height'    => 90,
            'border'    => array(
                'width' => 4,
                'color' => new Color(36, 135, 202)
            )
        ),
        9   => array(
            'width'     => 111,
            'height'    => 82,
            'image'     => array(
                'img1'  => new ImageConfig(0, 0, 111, 82)
            )
        ),
        12   => array(
            'width'     => 111,
            'height'    => 82,
            'image'     => array(
                'img2'  => new ImageConfig(0, 0, 111, 82)
            )
        ),
        15  => array(
            'width'     => 111,
            'height'    => 82,
            'image'     => array(
                'img3'  => new ImageConfig(0, 0, 111, 82)
            )
        ),
        18  => array(
            'width'     => 111,
            'height'    => 82,
            'image'     => array(
                'img4'  => new ImageConfig(0, 0, 111, 82)
            )
        ),
        21  => array(
            'width'     => 111,
            'height'    => 82,
            'image'     => array(
                'img5'  => new ImageConfig(0, 0, 111, 82)
            )
        ),
        25  => array(
            'width'     => 122,
            'height'    => 82,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 122, 82)
            )
        ),
        27  => array(
            'width'     => 105,
            'height'    => 64,
            'text'      => array(
                'year'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(2, 24), 101, 22, Alignment::Center),
                'make'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 12, 0, new Position(2, 46), 101, 15, Alignment::Center),
                'model'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 12, 0, new Position(2, 63), 101, 13, Alignment::Center)
            )
        ),
        31  => array(
            'width'     => 189,
            'height'    => 58,
            'template'  => array(
                'horizontal'  => new ImageConfig(0, 0, 189, 58, 0, 0, 0, 0, false, false, true)
            )
        ),
        35  => array(
            'width'     => 136,
            'height'    => 82,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 136, 82)
            )
        ),
        37  => array(
            'width'     => 116,
            'height'    => 60,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(2, 44), 111, 34, Alignment::Center)
                //'biweekly'  => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 30, 0, new Position(2, 40), 111, 40, Alignment::Center),
                //'text'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 11, 0, new Position(5, 59), 106, 18, Alignment::Center)
            )
        ),
        40  => array(
            'width'     => 115,
            'height'    => 38,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(1, 35), 111, 34, Alignment::Center)
            )
        )
    ),
    #######################################     970x90     #############################################
    '970x90'   => array(
     
        2   => array(
            'width'     => 188,
            'height'    => 63,
            'template'  => array(
                'logo'  => new ImageConfig(0, 0, 188, 63, 0, 0, 0, 0, false, true, true)
            )
        ),
        5   => array(
            'width'     => 970,
            'height'    => 90,
            'border'    => array(
                'width' => 5,
                'color' => new Color(36, 135, 202)
            )
        ),
        9   => array(
            'width'     => 113,
            'height'    => 84,
            'image'     => array(
                'img1'  => new ImageConfig(0, 0, 113, 84)
            )
        ),
        12   => array(
            'width'     => 113,
            'height'    => 84,
            'image'     => array(
                'img2'  => new ImageConfig(0, 0, 113, 84)
            )
        ),
        15  => array(
            'width'     => 113,
            'height'    => 84,
            'image'     => array(
                'img3'  => new ImageConfig(0, 0, 113, 84)
            )
        ),
        18  => array(
            'width'     => 113,
            'height'    => 84,
            'image'     => array(
                'img4'  => new ImageConfig(0, 0, 113, 84)
            )
        ),
        21  => array(
            'width'     => 113,
            'height'    => 84,
            'image'     => array(
                'img5'  => new ImageConfig(0, 0, 113, 84)
            )
        ),
        25  => array(
            'width'     => 136,
            'height'    => 80,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 136, 80)
            )
        ),
        27  => array(
            'width'     => 105,
            'height'    => 64,
            'text'      => array(
                'year'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(2, 24), 101, 22, Alignment::Center),
                'make'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 12, 0, new Position(2, 46), 101, 15, Alignment::Center),
                'model'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 12, 0, new Position(2, 63), 101, 13, Alignment::Center)
            )
        ),
        31  => array(
            'width'     => 197,
            'height'    => 66,
            'template'  => array(
                'horizontal'  => new ImageConfig(0, 0, 197, 66, 0, 0, 0, 0, false, false, true)
            )
        ),
        35  => array(
            'width'     => 136,
            'height'    => 80,
            'template'  => array(
                'gradient'  => new ImageConfig(0, 0, 136, 80)
            )
        ),
        37  => array(
            'width'     => 116,
            'height'    => 60,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(2, 44), 111, 34, Alignment::Center)
                //'biweekly'  => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 30, 0, new Position(2, 40), 111, 40, Alignment::Center),
                //'text'      => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 11, 0, new Position(5, 59), 106, 18, Alignment::Center)
            )
        ),
        40  => array(
            'width'     => 115,
            'height'    => 38,
            'text'      => array(
                'price'     => new TextConfig('fonts/arialbd.ttf', new Color(255, 255, 255), 20, 0, new Position(1, 35), 111, 34, Alignment::Center)
            )
        )
    )
);
