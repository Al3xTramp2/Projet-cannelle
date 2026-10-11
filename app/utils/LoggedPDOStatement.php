<?php

namespace Supalta\Cannelle\utils;

use Exception;
use PDO;
use PDOStatement;
use Monolog\Logger;

/**
 * Decorator of PDOStatement that logs each executed query
 */
class LoggedPDOStatement extends PDOStatement
{
    /** Statement decorated by this class */
    private PDOStatement $statement;
    /** Logger receiving the queries */
    private Logger $logger;
    /** User written in each log line */
    private string $user;

    /**
     * Constructor of the LoggedPDOStatement class
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
     * Write the query, its params and its errors in the SQL log
     * @return void
     */
    private function logStatement(): void
    {
        ob_start();
        $this->statement->debugDumpParams();
        $message = ob_get_clean();

        $loggedLine = "User : " . $this->user
            . " - Query : " . $this->statement->queryString
            . " - Params : " . $message;

        if ($this->statement->errorCode() !== PDO::ERR_NONE) {
            $errors = $this->statement->errorInfo();
            $this->logger->error($loggedLine . " - Errors : " . print_r($errors, true));
            return;
        }
        $this->logger->info($loggedLine);
    }

    /**
     * Execute the decorated statement then log it
     * @param array<int|string, mixed>|null $params
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
     * Bind a value to the decorated statement
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
     * Return all the rows of the decorated statement
     * @param int $mode
     * @param mixed ...$args
     * @return array<int, mixed>
     */
    public function fetchAll(int $mode = PDO::FETCH_DEFAULT, ...$args): array
    {
        return $this->statement->fetchAll($mode, ...$args);
    }

    /**
     * Return the next row of the decorated statement
     * @param int $mode
     * @param int $cursorOrientation
     * @param int $cursorOffset
     * @return mixed
     */
    public function fetch(
        int $mode = PDO::FETCH_DEFAULT,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): mixed {
        return $this->statement->fetch($mode, $cursorOrientation, $cursorOffset);
    }

    /**
     * Return the next row of the decorated statement as an object
     * @param string|null $class
     * @param array<int, mixed> $constructorArgs
     * @return object|false
     */
    public function fetchObject(?string $class = "stdClass", array $constructorArgs = []): object|false
    {
        return $this->statement->fetchObject($class, $constructorArgs);
    }

    /**
     * Return one column of the next row of the decorated statement
     * @param int $column
     * @return mixed
     */
    public function fetchColumn(int $column = 0): mixed
    {
        return $this->statement->fetchColumn($column);
    }

    /**
     * Set the fetch mode of the decorated statement
     * @param $mode
     * @param ...$args
     * @return bool
     */
    public function setFetchMode($mode = PDO::FETCH_DEFAULT, ...$args): bool
    {
        return $this->statement->setFetchMode($mode, ...$args);
    }
}
