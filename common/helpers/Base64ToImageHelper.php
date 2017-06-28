<?php

namespace common\helpers;


class Base64ToImageHelper
{
    public static function SaveImage($base64String, $path)
    {

        $date = new \DateTime();
        $data = str_replace('data:image/png;base64,', '', $base64String);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
        $mime_typeArr = explode('/',$mime_type);
        $extension = $mime_typeArr[1];

        $src = '/uploads/'.rand().$date->getTimestamp().'.'.$extension;
        $file = $path.$src;

        if(file_put_contents($file, $data) !== false){
            return $src;
        }
        return false;

    }



}