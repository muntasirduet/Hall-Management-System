<?php

class Session {

    public static function init() {
        session_start();
    }

    public static function set($key, $val) {
        $_SESSION[$key] = $val;
    }

    public static function get($key) {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
        else 
            return false;
    }

    public static function checkLogin() {
        if (self::get("login") == true) {
            echo "<script>window.location.href='admin.php';</script>";
            
        }
    }

    public static function checkSession() {
        if (self::get("login") == false) {
            self::destroy();
            header("Location: index.php");
        }
    }

    public static function destroy() {
        session_destroy();
        session_unset();
        header("Location: ../index.php");
    }
}