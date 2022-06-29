<?php

namespace Core\Logger;


class PLog
{

	private static ?PLog $instance = null;
	private ?array $plog_data = NULL;


    public function __construct()
    {

    }

    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new PLog();

            self::$instance->plog_data = [
                'id' => randstr(40, '0123456789abcdef', false),
                'step' => 'X',
                'db' => []
            ];
        }

        

        return self::$instance;
    }


    public static function step($step)
    {
        $inst = self::getInstance();
        $inst->plog_data['step'] = $step;
        return true;
    }

    public static function getStep()
    {
        $inst = self::getInstance();
        return (isset($inst->plog_data['step']) ? $inst->plog_data['step'] : '-');
    }

    public static function db($ref, $query, $params)
    {
        $inst = self::getInstance();
        $inst->plog_data['db'][] = ['ref' => $ref, 'query' => $query, 'params' => $params];
        return true;
    }

    public static function getDB()
    {
        $inst = self::getInstance();
        return $inst->plog_data['db'];
    }

    public static function getID()
    {
        $inst = self::getInstance();
        return $inst->plog_data['id'];
    }

}