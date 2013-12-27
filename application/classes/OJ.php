<?php defined('SYSPATH') or die('No direct script access.');

/**
 * static helper for html
 */
class OJ
{

    /**
     * @var  array  result code to human language readable long
     */
    public static $status
        = array(
            "4"  => "Accepted",
            "5"  => "Presentation Error",
            "6"  => "Wrong Answer",
            "7"  => "Time Limit Exceed",
            "8"  => "Memory Limit Exceed",
            "9"  => "Output Limit Exceed",
            "10" => "Runtime Error",
            "11" => "Compile Error",
            "0"  => "Pending",
            "1"  => "Pending Rejudging",
            "2"  => "Compiling",
            "3"  => "Running &amp; Judging"
        );

    /**
     * @var array result code to human language short
     */
    public static $result
        = array(
            "4"  => "AC",
            "5"  => "PE",
            "6"  => "WA",
            "7"  => "TLE",
            "8"  => "MLE",
            "9"  => "OLE",
            "10" => "RE",
            "11" => "CE",
        );

    /**
     * @var array language code to human language
     */
    public static $language
        = array(
            '0' => 'C',
            '1' => 'C++',
            '2' => 'Pascal',
            '3' => 'Java'
        );

    /**
     * @var array private value to human language
     */
    public static $private
        = array(
            '0' => 'public',
            '1' => 'private'
        );

    /**
     * @static
     *
     * @param $value
     *
     * @return string
     *
     * translate result code to human readable
     */
    public static function jresult($value)
    {
        return OJ::$status[$value];
    }

    /**
     * @static
     *
     * @param $value
     *
     * @return string
     *
     * translate language code to human readable
     */
    public static function lang($value)
    {
        if ($value > 3) {
            return 'Others';
        }
        return OJ::$language[$value];
    }

    /**
     * @static
     *
     * @param $value
     *
     * @return mixed
     *
     */
    public static function is_private($value)
    {
        if (intval($value) == 1) return true;
        return false;
    }

    /**
     * translate private code to human readable
     *
     * @param $value
     *
     * @return mixed
     */
    public static function private_value($value)
    {
        return OJ::$private[$value];
    }

    /**
     * @static
     *
     * @param $pid
     *
     * @return string
     *
     * translate contest pid to A, B....
     */
    public static function contest_pid($pid)
    {
        return chr(65 + $pid);
    }

    /**
     * @static
     *
     * @param $time
     *
     * @return string
     *
     * make contest time normalize
     */
    public static function contest_time($time)
    {
        $sec = $time % 60;
        $time = $time / 60;
        $minute = $time % 60;
        $hour = $time / 60;
        return sprintf("%02d:%02d:%02d", $hour, $minute, $sec);
    }

    /**
     * @static
     *
     * @param $mtime
     *
     * @return string
     *
     * make mongoDate human readable
     */
    public static function mtime($mtime)
    {
        if ($mtime) {
            return date('Y-m-d h:i:s', $mtime->sec);
        }
        return '';
    }

    /**
     * @static
     *
     * @param $mtime
     *
     * @return string
     *
     * generate read date
     */
    public static function getdate($mtime)
    {
        if ($mtime) {
            return date('Y年m月d', $mtime->sec);
        }
        return '';
    }

    /**
     * @static
     *
     * @param $timestamp mongdb datetime
     * @param int $granularity
     *
     * @return string
     *
     * from http://stackoverflow.com/questions/2952361/date-time-convert-to-time-since-php* from http://stackoverflow.com/questions/2952361/date-time-convert-to-time-since-php
     *
     * make timestamp to timesince
     *
     */
    public static function timesince($timestamp, $granularity = 2) {
        $timestamp = time() - $timestamp->sec;
        $units = array('1 year|%d years' => 31536000,
            '1 week|%d weeks' => 604800,
            '1 day|%d days' => 86400,
            '1 hour|%d hours' => 3600,
            '1 min|%d mins' => 60,
            '1 sec|%d secs' => 1
        );
        $output = '';
        foreach ($units as $key => $value) {
            $key = explode('|', $key);
            if ($timestamp >= $value) {
                $pluralized = floor($timestamp / $value) > 1 ?
                    sprintf($key[1], floor($timestamp / $value)) :
                    $key[0];
                $output .= ($output ? ' ' : '') . $pluralized;
                $timestamp %= $value;
                $granularity--;
            }
            if ($granularity == 0) {
                break;
            }
        }
        return $output ? $output : "Just now";
    }
}