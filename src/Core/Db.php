<?php
namespace App\Core;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use PDO;
use PDOException;

class Db extends PDO
{
    private static $instance;

    private const DB_HOST = 'localhost';
    private const DB_USER = 'root';
    private const DB_PASS = 'root';
    private const DB_NAME = 'blog_php';

    private function __construct()
    {
        $_dsn = 'mysql:dbname='. self::DB_NAME . ';host=' . self::DB_HOST;

        try{
            parent::__construct($_dsn, self::DB_USER, self::DB_PASS);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }


    public static function getInstance():self
    {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
}