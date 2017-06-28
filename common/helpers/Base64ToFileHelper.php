<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 23.06.17
 * Time: 15:19
 */

namespace common\helpers;


class Base64ToFileHelper
{
    CONST mimeTypes = [
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',
        // Images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        // Archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',
        // Audio/video
        'mpg' => 'audio/mpeg',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'mp4' => 'audio/mp4',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'ogg' => 'audio/ogg',
        'oga' => 'audio/ogg',
        'wav' => 'audio/wav',
        'webm' => 'audio/webm',
        'aac' => 'audio/aac',
        // Adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        // MS Office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        // Open Office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    ];

    public static function SaveFile($base64String, $path)
    {

        $date = new \DateTime();
        $data = base64_decode($base64String);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
        $mime_typeArr = explode('/',$mime_type);
        $extension = $mime_typeArr[1];
       foreach (self::mimeTypes as $ext => $mimeType){

           if($mime_type == $mimeType){
               $extension = $ext;
           }
       }

        $src = '/uploads/'.rand().$date->getTimestamp().'.'.$extension;
        $file = $path.$src;

        if(file_put_contents($file, $data) !== false){
            return $src;
        }
        return false;

    }


}