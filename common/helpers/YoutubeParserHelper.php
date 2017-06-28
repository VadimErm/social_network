<?php


namespace common\helpers;


class YoutubeParserHelper
{
    public static function parse($url)
    {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $video_id = $match[1];

            return 'https://www.youtube.com/embed/'.$video_id;
        }
        return null;
    }
}