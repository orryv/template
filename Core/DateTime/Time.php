<?php

namespace Core\DateTime;

class Time
{

    public static function get_15_minutes_epoch()
    {

        $current_epoch = time();
        $all = floor($current_epoch / 900);
        return $all*900;

    }

    public static function get_current_minute()
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp(time())->setTimezone($timezone);
        return $time->format('i');
    }

    public static function get_hour($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('H');
    }

    public static function epochToHoursMinutes($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('H:i');
    }

    public static function epochToYearMonth($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('Y-m');
    }

    public static function epochToYearWeek($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('Y-W');
    }

    public static function epochToReadableMonth($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('M Y');
    }

    public static function epochToDay($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('Y-m-d');
    }

    public static function epochToDaySlash($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('Y/m/d');
    }

    public static function epochToTableReadString($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('M j, Y h:ia');
    }

    public static function epochToReadable($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('M j, Y H:i:s');
    }

    public static function epochToTime($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('H:i:s');
    }

    public static function epochToBelgianStyle($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('Y-m-d H:i:s');
    }


    public static function dbTimeToReadableHour($time)
    {
        $epoch = self::dbTimeToEpoch($time);
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('M j, Y h:ia');
    }

    public static function dbTimeToReadableDay($time)
    {
        $epoch = self::dbTimeToEpoch($time);
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('F j, Y');
    }

    public static function epochToAge($epoch)
    {
        $diff = time() - (int)$epoch;
        return floor($diff / 31536000);
    }

    public static function epochToDBTime($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        //return $time->format('M j, Y h:ia');
        return $time->format('Y-m-d H:i:s');
    }


    public static function dbTimeToEpoch($time)
    {
        $t = explode(' ', $time);
        $s = explode('-', $t[0]);
        $d = explode(':', $t[1]);
        return mktime($d[0], $d[1], $d[2], $s[1], $s[2], $s[0]);
    }

    public static function getTimeZoneString()
    {
        return DB_TIMEZONE;
    }

    public static function getMidnightEpoch($minus_seconds, $timezone)
    {
        $date_time = new \Datetime('midnight', new \Datetimezone($timezone));

        return $date_time->getTimestamp() - $minus_seconds;
    }


    public static function getYearEpoch($epoch, $timezone)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        $time->setTime(0,0,0);
        $offset = $time->format('z');
        $midnight_epoch = $time->getTimestamp();

        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($midnight_epoch)->setTimezone($timezone);
        $time->modify('-'.$offset.' days');
        return $time->getTimestamp();
    }




    public static function getMonthEpoch($epoch, $timezone)
    {
        /*
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        $time->setTime(0,0,0);
        $offset = $time->format('j');
        $midnight_epoch = $time->getTimestamp();
        $time = $midnight_epoch - (($offset-1) * 86400);
        return $time;
        */
       
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        $time->setTime(0,0,0);
        $offset = $time->format('j');
        $midnight_epoch = $time->getTimestamp();

        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($midnight_epoch)->setTimezone($timezone);
        $time->modify('-'.($offset-1).' days');
        return $time->getTimestamp();
    }

    public static function getWeekEpoch($epoch, $timezone)
    {
        /*
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        $time->setTime(0,0,0);
        $offset = $time->format('N');
        $midnight_epoch = $time->getTimestamp();
        $time = $midnight_epoch - (($offset -1) * 86400);
        return $time;
        */
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        $time->setTime(0,0,0);
        $offset = $time->format('N');
        $midnight_epoch = $time->getTimestamp();

        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($midnight_epoch)->setTimezone($timezone);
        $time->modify('-'.($offset-1).' days');
        return $time->getTimestamp();
    }

    public static function getDayEpoch($epoch, $timezone)
    {
        /*
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        $time->setTime(0,0,0);
        $offset = $time->format('N');
        $midnight_epoch = $time->getTimestamp();
        $time = $midnight_epoch - (($offset -1) * 86400);
        return $time;
        */
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        $time->setTime(0,0,0);
        return $time->getTimestamp();
        /*
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($midnight_epoch)->setTimezone($timezone);
        $time->modify('-'.($offset-1).' days');
        return $time->getTimestamp();
        */
    }

    public static function addDaysEpoch($epoch, $days)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        $time->setTime(0,0,0);
        $offset = $time->format('N');
        $time->modify('+'.$days.' days');
        return $time->getTimestamp();

    }

    public static function getWeek($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('Y').'-W'.$time->format('W');
    }

    public static function getMonth($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('Y').'-'.$time->format('m');
    }

    public static function getYear($epoch)
    {
        $time = new \DateTime();
        $timezone = new \DateTimeZone(DB_TIMEZONE);
        $time->setTimestamp($epoch)->setTimezone($timezone);
        return $time->format('Y');
    }

    public static function getWeekFromTo($epoch)
    {
        $epoch = self::getWeekEpoch($epoch, self::getTimeZoneString());
        $time = new \DateTime();
        $timezone = new \DateTimeZone(self::getTimeZoneString());
        $time->setTimestamp($epoch)->setTimezone($timezone);
        $from = $time->format('M').' '.$time->format('d').', '.$time->format('Y').' '.$time->format('H').':'.$time->format('i');

        $time->modify('+7 days');
        //$time->modify('-1 second');
        $to = $time->format('M').' '.$time->format('d').', '.$time->format('Y').' '.$time->format('H').':'.$time->format('i');

        return [
            'from' => $from,
            'to' => $to
        ];
    }

    public static function isValidWeek($week, $min = false, $max = false)
    {
        

        if(
            !is_numeric(substr($week, 0, 4))
            || substr($week, 4, 2) !== '-W'
            || !is_numeric(substr($week, 6))
            || strlen($week) !== 8
        )
            return false;

        $epoch = strtotime($week);

        if($min !== false && $epoch < $min)
            return false;

        if($max !== false && $epoch > $max)
             return false;

        return true;
    }

    public static function isValidMonth($month, $min = false, $max = false)
    {
        if(
            !is_numeric(substr($month, 0, 4))
            || substr($month, 4, 1) !== '-'
            || !is_numeric(substr($month, 5))
            || strlen($month) !== 7
        )
            return false;

        $epoch = strtotime($month);

        if($min !== false && $epoch < $min)
            return false;

        if($max !== false && $epoch > $max)
             return false;

        return true;
    }

    public static function isValidYear($year, $min = false, $max = false)
    {
        if(
            !is_numeric(substr($year, 0))
            || strlen($year) !== 4
        )
            return false;

        $epoch = self::yearToEpoch($year);

        if($min !== false && $epoch < $min)
            return false;

        if($max !== false && $epoch > $max)
             return false;

        return true;
    }


    public static function yearToEpoch($year)
    {
        return strtotime('01-01-'.$year);
    }
}

?>