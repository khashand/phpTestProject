<?php

class dbManagement
{
    private $connection="";
    public function __construct()
    {
        if ($this->connection =="")
        {
            try
            {
                @session_start();
                $host = "localhost";
                $username = "zahra-db";
                $password = "Zahra1373@";
                $name = "testphp";
                $dns = "mysql:host={$host};dbname={$name}";
                $this->connection = new PDO($dns, $username, $password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set attr for remote to db
                $this->connection->exec("set names utf8"); //use it when farsi char used in project
            } catch (PDOException $exception)
            {
                $exception->getMessage();
            }
        }
    }
    public function getConnection()
    {
        return $this->connection;
    }

}

