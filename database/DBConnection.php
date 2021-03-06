<?php

namespace Database;

use PDO;

class DBConnection{

    private $dbname;
    private $host;
    private $username;
    private $password;
    private $pdo;

    public function __construct($dbname, $host, $username, $password){
        $this->dbname = $dbname;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    public function getPDO(){

        if($this->pdo === null){

            $this->pdo = new \PDO("mysql:dbname={$this->dbname};host={$this->host};charset=utf8mb4", $this->username, $this->password,
                [
                    //Thoose options transform it into object/
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    //UTF-8 characters
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ]
            );

        }

        return $this->pdo;

    }


}