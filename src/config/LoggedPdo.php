<?php

namespace OtteRM\config;

use OtteRM\config\LogWriter;
use Symfony\Component\Yaml\Yaml;


/**
 * Extends PDO and logs all queries that are executed and how long
 * they take, including queries issued via prepared statements
 */
class LoggedPDO extends \PDO
{
    public $logger;

    public function query($query)
    {
        $this->logger = new LogWriter();
        $start = microtime(true);

        try {
            $result = parent::query($query);
            $time = microtime(true) - $start;
            $log = array(
                'query' => $query,
                'time' => round($time * 1000, 3)
            );
        } catch (\PDOException $exception) {
            $this->logger->writeLogError($exception->getMessage());
        }
        $this->logger->writeLog($log);
        return $result;
    }

    /**
     * @return LoggedPDOStatement
     */
    public function prepare($query, $options = NULL)
    {
        return new LoggedPDOStatement(parent::prepare($query));
    }
}

/**
 * PDOStatement decorator that logs when a PDOStatement is
 * executed, and the time it took to run
 * @see LoggedPDO
 */
class LoggedPDOStatement
{
    /**
     * The PDOStatement we decorate
     */
    private $statement;
    public $logger;

    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
        $this->logger = new LogWriter();
    }

    /**
     * When execute is called record the time it takes and
     * then log the query
     * @return PDO result set
     */
    public function execute(array $input_parameters = [])
    {
        $start = microtime(true);

        try {
            $result = $this->statement->execute($input_parameters);
        } catch (\PDOException $exception) {
            $this->logger->writeLogError($exception->getMessage());
        }
        $time = microtime(true) - $start;
        $log = array(
            'query' => '[PS] ' . $this->statement->queryString,
            'time' => round($time * 1000, 3)
        );
        $this->logger->writeLog($log);
        return $result;
    }
    /**
     * Other than execute pass all other calls to the PDOStatement object
     * @param string $function_name
     * @param array $parameters arguments
     */
    public function __call($function_name, $parameters)
    {
        return call_user_func_array(array($this->statement, $function_name), $parameters);
    }
}
