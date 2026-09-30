<?php

namespace Supalta\Cannelle\utils;

use PDO;


class LoggedPDO extends PDO {

    /**
     * @param string $query
     * @param array $options
     * @return LoggedPDOStatement|false
     */
    public function prepare(string $query, array $options = []): LoggedPDOStatement|false {
        $statement = parent::prepare($query, $options);
        if (!$statement) {
            return false;
        }
        return new LoggedPDOStatement($statement, SingletonLogger::getInstance()->getSQLLogger(), 'toto' );
    }
}
