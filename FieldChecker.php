<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 08.12.2017
 * Time: 16:46
 */

namespace Valid;


class FieldChecker
{
    public static function datetime($dateStr, $format = 'd.m.Y')
    {
        date_default_timezone_set('Europe/Moscow');
        $date = \DateTime::createFromFormat($format, $dateStr);
        return $date && ($date->format($format) === $dateStr);
    }

    public static function mail($val)
    {
        return filter_var($val, FILTER_VALIDATE_EMAIL);
    }
}
