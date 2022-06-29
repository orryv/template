<?php

namespace Core\Logger;

use Core\Time;
use Core\Logger\PLog;

class Log
{

	public static function log($string)
	{
		$day = Time::epochToDay(Time::getDayEpoch(time(), DB_TIMEZONE));
		$logFile = '';
		if(file_exists(LOG_PATH.$day.'.log')){
			$logFile = file_get_contents(LOG_PATH.$day.'.log');

			$pos = strrpos($logFile, '] ')+2;
			$test = substr($logFile, $pos);
			$test = strstr2($test, "\r\n", true);
			if($test === $string)
				return true;
		}

		$logFile.= '['.Time::epochToBelgianStyle(time()).'] '.$string."\r\n"
			.'PLog ID: '.PLog::getID()."\r\n"
            .'PLog Step: '.PLog::getStep()."\r\n";

        return file_put_contents(LOG_PATH.$day.'.log', $logFile);

	}

}