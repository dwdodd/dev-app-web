<?php

class ImgBridge
{
    public static function img_bridge( $imgPath )
    {
        $img = base64_encode(file_get_contents( $imgPath ));
        return 'data: ' . $img . ';base64,' . $img;
    }
}