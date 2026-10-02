<?php

namespace Supalta\Cannelle\utils;

use Exception;
use PDO;
use PDOStatement;
use Monolog\Logger;

class LoggedPDOStatement extends PDOStatement
{
    private PDOStatement $statement;
    private Logger $logger;
    private string $user;

    /**
     * @param PDOStatement $statement
     * @param Logger $logger
     * @param string $user
     */
    public function __construct(PDOStatement $statement, Logger $logger, string $user)
    {
        $this->statement = $statement;
        $this->user = $user;
        $this->logger = $logger;
    }

    /**
     * @return void
     */
    private function logStatement(): void
    {
        ob_start();
        $this->statement->debugDumpParams();
        $message = ob_get_clean();

        $loggedLine = "User : " . $this->user . " - Query : " . $this->statement->queryString . " - Params : " . $message;

        if ($this->statement->errorCode() !== PDO::ERR_NONE) {
            $errors = $this->statement->errorInfo();
            $this->logger->error($loggedLine . " - Errors : " . print_r($errors, true));
        } else {
            $this->logger->info($loggedLine);
        }
    }

    /**
     * @param $params
     * @return bool
     * @throws Exception
     */
    public function execute($params = null): bool
    {
        try {
            $result = $this->statement->execute($params);
        } catch (Exception $e) {
            $this->logStatement();
            throw $e;
        }
        $this->logStatement();
        return $result;
    }

    /**
     * @param int|string $param
     * @param mixed $value
     * @param int $type
     * @return bool
     */
    public function bindValue(int|string $param, mixed $value, int $type = PDO::PARAM_STR): bool
    {
        return $this->statement->bindValue($param, $value, $type);
    }

    /**
     * @param int $mode
     * @param ...$args
     * @return array
     */
    public function fetchAll(int $mode = PDO::FETCH_DEFAULT, ...$args): array
    {
        return $this->statement->fetchAll($mode, ...$args);
    }

    /**
     * @param int $mode
     * @param int $cursorOrientation
     * @param int $cursorOffset
     * @return mixed
     */
    public function fetch(int $mode = PDO::FETCH_DEFAULT, int $cursorOrientation = PDO::FETCH_ORI_NEXT, int $cursorOffset = 0): mixed
    {
        return $this->statement->fetch($mode, $cursorOrientation, $cursorOffset);
    }

    /**
     * @param string|null $class
     * @param array $constructorArgs
     * @return object|false
     */
    public function fetchObject(?string $class = "stdClass", array $constructorArgs = []): object|false
    {
        return $this->statement->fetchObject($class, $constructorArgs);
    }

    /**
     * @param $mode
     * @param ...$args
     * @return bool
     */
    public function setFetchMode($mode = PDO::FETCH_DEFAULT, ...$args): bool
    {
        return $this->statement->setFetchMode($mode, ...$args);
    }
}
