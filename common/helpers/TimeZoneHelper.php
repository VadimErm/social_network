<?php


namespace common\helpers;


use Yii;
use yii\base\ErrorException;

class TimeZoneHelper
{
    public static function getTime($format, $time)
    {
        $userIp = Yii::$app->request->getUserIP();
        $Info = Yii::createObject([
            'class' => '\rmrevin\yii\geoip\HostInfo',
            'host' =>  '91.206.31.130', // some host or ip
        ]);

        try{
            $tz = $Info->getTimeZone();
        } catch (ErrorException $exception) {
            return '';
        }

        date_default_timezone_set($tz);
        return date($format, $time);
    }

}