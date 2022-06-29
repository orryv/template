<?php

namespace Core\Error;

use Core\DateTime\Time;
use Core\Logger\PLog;

class ErrorHandler
{

    protected $message = 'Unknown exception';   // exception message
    protected $code = 0;                        // user defined exception code
    protected $severity;                        
    protected $file;                            // source filename of exception
    protected $line;                            // source line of exception

    public function __construct($message, $code, $severity, $filename = NULL, $lineno = NULL)
    {
        $this->message = $message;
        $this->code = $code;
        $this->severity = $severity;
        $this->file = $filename;
        $this->line = $lineno;
    }
   
    public function __toString()
    {
        
        $buffer = '';
        if (ob_get_length())
            $buffer = ob_end_clean();
        
        
        if(php_sapi_name() === 'cli') {
            $msg = '##############################'."\r\n";
            $msg = 'Error: '.$this->message."\r\n";
            $msg.= 'File: '.$this->file.':'.$this->line."\r\n";
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
                $msg = 'Error: '.$this->message."\r\n";
                $msg.= 'File: '.$this->file.':'.$this->line."\r\n";
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
                $msg = '<div style="background-color:red;padding:5px">Error: <b>'.$this->message.'</b>';
                $msg.= '<br>File: '.$this->file.':'.$this->line;
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
        } 
        else {

            $day = Time::epochToDay(Time::getDayEpoch(time(), DB_TIMEZONE));

            $txt = 
                '['.Time::epochToTime(time()).']'."\r\n".
                ' Error: '.$this->message."\r\n"
                .'File: '.$this->file.':'.$this->line."\r\n"
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
                fwrite($fp, $txt);   
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