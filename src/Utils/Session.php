<?php
namespace App\Utils;

class Session{
    static $instance;

    static function getInstance(){
        if(!self::$instance){
            self::$instance = new Session(); //Singleton : regarder !!
        }
        return self::$instance;
    }

    private function __construct(){
        session_start();
    }

    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function forget($key){
        unset($_SESSION[$key]);
    }

    public static function get($key, $item = NULL){
        if (isset($_SESSION[$key])) {
            if(isset($item) && isset($_SESSION[$key][$item])) {
                return $_SESSION[$key][$item];
            }

            return $_SESSION[$key];
        }

        return NULL; //not found
    }
}

