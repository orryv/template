<?php

namespace Core\Error;

use Core\DateTime\Time;
use Core\Logger\PLog;

class ExceptionHandler{

    protected $exception;


    public function __construct($exception) {
        $this->exception = $exception;
        
    }
   
    public function __toString()
    {
        $buffer = '';
        if (ob_get_length())
            $buffer = ob_end_clean();

        if(php_sapi_name() === 'cli') {
            $msg = '##############################'."\r\n";
            if(!empty($this->exception->getMessage()))
                $msg = 'Error: '.$this->exception->getMessage()."\r\n";
            if(!empty($this->exception->getFile()) && !empty($this->exception->getLine()))
                $msg.= 'File: '.$this->exception->getFile().':'.$this->exception->getLine()."\r\n";
            $msg.= 'PLog ID: '.PLog::getID()."\r\n";
            $msg.= 'PLog Step: '.PLog::getStep()."\r\n";
            $d = PLog::getDB();
            if(empty($d))
                $msg.= 'PLog DB: None';
            else {
                foreach($d as $key => $value){
                    $msg.= $value['ref']."\r\n";
                    $msg.= $value['query']."\r\n";
                    $msg.= print_r($value['params'], true)."\r\n";
                }
            }

            if(VERBOSE_LOGFILE_LOGGING){
                file_put_contents(LOG_PATH.$day.'.log', $msg);
            }

        }

        else if(DEV_MODE){

            if(API_REQUEST){
                $msg = '';
                if(!empty($this->exception->getMessage()))
                    $msg.= 'Error: '.$this->exception->getMessage()."\r\n";
                if(!empty($this->exception->getFile()) && !empty($this->exception->getLine()))
                    $msg.= 'File: '.$this->exception->getFile().':'.$this->exception->getLine()."\r\n";

                if(!empty($this->exception->getTrace())){
                    $msg.= 'Trace:'."\r\n";
                    foreach ($this->exception->getTrace() as $key => $value) {
                        $msg.= $value['file'].':'.$value['line']."\r\n";
                    }
                }

                $msg.= 'PLog ID: '.PLog::getID()."\r\n";
                $msg.= 'PLog Step: '.PLog::getStep()."\r\n";
                $d = PLog::getDB();
                if(empty($d))
                    $msg.= 'PLog DB: None';
                else {
                    foreach($d as $key => $value){
                        $msg.= $value['ref']."\r\n";
                        $msg.= $value['query']."\r\n";
                        $msg.= print_r($value['params'], true)."\r\n";
                    }
                }
            } else {
                $msg = '<div style="background-color:red;padding:5px">';
                if(!empty($this->exception->getMessage()))
                    $msg.= 'Error: <b>'.$this->exception->getMessage().'</b><br>';
                if(!empty($this->exception->getFile()) && !empty($this->exception->getLine()))
                $msg.= 'File: <b>'.$this->exception->getFile().':'.$this->exception->getLine().'</b><br>';

                if(!empty($this->exception->getTrace())){
                    $msg.= '<b>Trace:</b><br>';
                    foreach ($this->exception->getTrace() as $key => $value) {
                        $msg.= $value['file'].':'.$value['line'].'<br>';
                    }
                }
                $msg.= '<br>PLog Step: '.PLog::getStep();

                $d = PLog::getDB();
                if(empty($d))
                    $msg.= '<br>PLog DB: None';
                else {
                    foreach($d as $key => $value){
                        $msg.= '<br><b>'.$value['ref'].'</b>';
                        $msg.= '<br><b>'.$value['query'].'</b>';
                        $msg.= '<br><pre>'.print_r($value['params'], true).'</pre>';
                    }
                }
                $msg.= '</div>';
                if(php_sapi_name() !== 'cli'){
                    if(substr($_SERVER['REQUEST_URI'],0,6) === '/cron/')
                        $msg.= '<meta http-equiv="refresh" content="10">';
                }
                $msg.= $buffer;
            }



        } else {

            $day = Time::epochToDay(Time::getDayEpoch(time(), DB_TIMEZONE));

            $txt = 
                '['.Time::epochToTime(time()).']'."\r\n".
                ' Error: '.$this->exception->getMessage()."\r\n"
                .'File: '.$this->exception->getFile().':'.$this->exception->getLine()."\r\n"
                .'PLog ID: '.PLog::getID()."\r\n"
                .'PLog Step: '.PLog::getStep()."\r\n";

            $d = PLog::getDB();
            if(empty($d))
                $txt.= 'PLog DB: None'."\r\n";
            else {
                $txt.= 'PLog DB:'."\r\n";
                foreach($d as $key => $value){
                    $txt.= $value['ref']."\r\n";
                    $txt.= $value['query']."\r\n";
                    $txt.= print_r($value['params'], true)."\r\n"."\r\n";
                }
            }

            if(file_exists(LOG_PATH.$day.'.log')){
                $fp = fopen(LOG_PATH.$day.'.log', 'a');//opens file in append mode  
                fwrite($fp,$txt);   
                fclose($fp); 
            } else {

                file_put_contents(LOG_PATH.$day.'.log', $txt);

            }

            if(API_REQUEST){
                return json_encode(['status' => 503, 'message' => 'An error occured, please try again later. ref.: '.PLog::getID()]);
            } else {
                $code = 503;
                $reason = 'An error occured, please try again or come back later. ref.: '.PLog::getID();
                $msg = require BASE_DIR.'/views/html/min/error/error.php';
            }
        }


        return $msg;
    }
}


?>