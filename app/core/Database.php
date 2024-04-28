<?php

namespace app\core;

use mysqli;
use mysqli_result;

class Database
{

    private mysqli|false $connection;

    public function __construct()
    {
        $databaseConfig = App::$config['db'];

        $host = $databaseConfig['host'];
        $user = $databaseConfig['user'];
        $password = $databaseConfig['password'];
        $dbname = $databaseConfig['dbname'];
        $port = $databaseConfig['port'];
        $charset = $databaseConfig['charset'];

        $this->connection = mysqli_connect($host, $user, $password, $dbname, $port);
        $this->setCharset($charset);
    }

    public function __destruct()
    {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }

    private function setCharset($charset): void
    {
        $this->query("SET NAMES " . $charset);
    }

    public function query($resource): mysqli_result|bool
    {
        return mysqli_query($this->connection, $resource);
    }

    public function unique($resource): false|array|null
    {
        return ($result = $this->query($resource)) ? $result->fetch_array(MYSQLI_ASSOC) : false;
    }

    public function count($resource)
    {
        return ($result = $this->query($resource)) ? $result->fetch_array(MYSQLI_NUM)[0] : false;
    }

    public function fetch($resource, $encode = []): array
    {
        $result = $this->query($resource);
        $Return = [];
        while ($Data = $result->fetch_array(MYSQLI_ASSOC)) {
            foreach ($encode as $key) {
                if (isset($Data[$key])) {
                    $Data[$key] = base64_encode($Data[$key]);
                }
            }
            $Return[] = $Data;
        }
        $result->close();
        return $Return;
    }

    public function fetchArray($result)
    {
        return $result->fetch_array(MYSQLI_ASSOC);
    }

    public function fetchNum($result)
    {
        return $result->fetch_array(MYSQLI_NUM);
    }

    public function numRows($query)
    {
        return $query->num_rows;
    }

    public function insertId(): int|string
    {
        return $this->connection->insert_id;
    }

    public function sqlEscape($string, $flag = false): string
    {
        $escapedString = mysqli_real_escape_string($this->connection, $string);
        return ($flag === false) ? $escapedString : addcslashes($escapedString, '%_');
    }

    public function freeResult($resource)
    {
        return $resource->close();
    }

    public function affectedRows(): int|string
    {
        return $this->connection->affected_rows;
    }

    public function fetchFields($tablename): array
    {
        return $this->query("SELECT * FROM $tablename LIMIT 1")->fetch_fields();
    }

}