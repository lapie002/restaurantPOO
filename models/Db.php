<?php

class Db{

    private static $instance = NULL;

    function __construct(){}

    function __clone(){}

    public static function getInstance()
    {

        if(!isset(self::$instance))
        {
            //$pdo_option[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO('mysql:host=localhost;dbname=tp_resto','root','root');
        }
        return self::$instance;
    }
}
