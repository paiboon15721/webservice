<?php

class ConvertDateTime
{

    public static function dateForService($date)
    {
        $dateList = explode("/", $date);
        return $dateList[2] . $dateList[1] . $dateList[0];
    }

    public static function dateNowForService()
    {
        $dateList = explode("/", date("Y/m/d"));
        return $dateList[0] + 543 . $dateList[1] . $dateList[2];
    }

    public static function timeForService($time)
    {
        $timeList = explode(".", $time);
        $hour = substr($timeList[0], 0, 2);
        $min = substr($timeList[1], 0, 2);
        return $hour . $min;
    }

    public static function timeForClient($time)
    {
        $hour = substr($time, 0, 2);
        $min = substr($time, 2, 2);
        return $hour . '.' . $min;
    }

    public static function dateForClient($date)
    {
        $year = substr($date, 0, 4);
        $month = substr($date, 4, 2);
        $day = substr($date, 6, 2);
        return $day . '/' . $month . '/' . $year;
    }

    public static function dateForReport($date)
    {
        $strMonth = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $year = substr($date, 0, 4);
        $month = substr($date, 4, 2);
        $day = substr($date, 6, 2);
        return 'วันที่  '.$day . '  เดือน  ' . $strMonth[(ltrim($month, '0') - 1)] . '  พ.ศ.  ' . $year;
    }

    public static function dateCheck($date)
    {
        $date = explode('/', $date);
        if (count($date) != 3) {
            return false;
        } elseif (is_numeric($date[0]) and is_numeric($date[1]) and is_numeric($date[2])) {
            $date[2] = $date[2] - 543;
            if (checkdate($date[1], $date[0], $date[2])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
