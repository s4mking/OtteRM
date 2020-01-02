<?php

namespace OtteRM\config;

use Symfony\Component\Yaml\Yaml;

class LogWriter
{
    public static function writeLog($query)
    {
        $date = new \DateTime();
        $date = $date->format("y:m:d h:i:s");
        $params = Yaml::parseFile('Config/parameters.yml');
        $logfodler = $params['db']['logs'];
        $logfile = $logfodler . 'request.log';
        $current = $query['query'] . " " . $query['time'] . " ms";
        file_put_contents($logfile, PHP_EOL . $date . " " . $current, FILE_APPEND);
    }
    public static function writeLogError($error)
    {
        $date = new \DateTime();
        $date = $date->format("y:m:d h:i:s");
        $params = Yaml::parseFile('Config/parameters.yml');
        $logfodler = $params['db']['logs'];
        $logfile = $logfodler . 'error.log';
        file_put_contents($logfile, PHP_EOL . $date . " " . $error, FILE_APPEND);
    }
}
